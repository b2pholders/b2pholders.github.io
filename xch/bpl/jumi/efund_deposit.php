<?php

namespace BPL\Jumi\Efund_Deposit;

require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/transfer_history.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Ajax\check_input2;

use function BPL\Mods\Transfer_History\view_row_transfers;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\time;
use function BPL\Mods\Helpers\user_username;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');
	$final   = input_get('final');

	session_set('edit', false);

	page_validate();

	$str = menu();

	if ((int) $final !== 1)
	{
		$str .= check_input2();
		$str .= view_form($user_id);
	}
	else
	{
		$amount      = input_get('amount');
		$username_to = input_get('username');
		$edit        = session_get('edit', false);

		process_efund_deposit($user_id, $amount, $username_to, $edit);
	}

	$str .= view_transfer_history($user_id);

	echo $str;
}

/**
 *
 *
 * @since version
 */
function validate_input($user_id, $amount, $username_to, $edit)
{
	$settings_ancillaries = settings('ancillaries');

	$currency       = $settings_ancillaries->currency;
	$processing_fee = $settings_ancillaries->processing_fee;

	$deposit_from = user($user_id);

	$app = application();

	if ($amount === '' ||
		!is_numeric($amount) ||
		$deposit_from->username === '')
	{
		$err = 'Invalid Transaction!';

		$app->redirect(Uri::root(true) . '/' . sef(15), $err, 'error');
	}

	if ($deposit_from->balance < ($amount + $processing_fee) &&
		$username_to !== $deposit_from->username)
	{
		$err = 'Please maintain balance of at least ' .
			number_format($amount + $processing_fee, 2) . ' ' . $currency;

		$app->redirect(Uri::root(true) . '/' . sef(15), $err, 'error');
	}
	elseif (($deposit_from->balance < $amount) &&
		$username_to === $deposit_from->username)
	{
		$err = 'Please maintain balance of at least ' . number_format($amount, 2) . ' ' . $currency;

		$app->redirect(Uri::root(true) . '/' . sef(15), $err, 'error');
	}

	$deposit_to = user_username($username_to);

	if ($deposit_to->id === '')
	{
		$err = 'Invalid user!';

		$app->redirect(Uri::root(true) . '/' . sef(15), $err, 'error');
	}

	if ($edit === true)
	{
		$date = input_get('date', '', 'RAW');

		if ($date === '')
		{
			$err = 'Please specify the Current Date!';

			application()->redirect(Uri::root(true) . '/' . sef(15), $err, 'error');
		}
	}
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function income_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 * @param $user_id
 * @param $amount
 * @param $username_to
 *
 * @param $date
 *
 * @since version
 */
function logs($user_id, $amount, $username_to, $date)
{
	$settings_ancillaries = settings('ancillaries');

	$efund_name = $settings_ancillaries->efund_name;

	$currency       = $settings_ancillaries->currency;
	$processing_fee = $settings_ancillaries->processing_fee;

	$deposit_from = user($user_id);
	$deposit_to   = user_username($username_to);

	$db = db();

	insert(
		'network_transactions',
		[
			'user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'
		],
		[
			$db->quote($user_id),
			$db->quote('Convert ' . $efund_name),
			$db->quote(number_format($amount, 2) . ' ' . $currency . ' converted to <a href="' .
				sef(44) . qs() . 'uid=' . $deposit_to->id . '">' . $username_to . '</a>.'),
			$amount,
			($deposit_from->username !== $username_to ?
				($deposit_from->balance - ((double) $amount + (double) $processing_fee)) :
				($deposit_from->balance - $amount)),
			$db->quote($date)
		]
	);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($deposit_from->sponsor_id),
			$db->quote(1),
			$db->quote('<b>Convert ' . $efund_name . ': </b> <a href="' . sef(44) . qs() . 'uid=' .
				$user_id . '">' . $deposit_from->username . '</a> converted ' . number_format($amount, 2) .
				' ' . $currency . ' to <a href="' . sef(44) . qs() . 'uid=' . $deposit_to->id . '">' .
				$deposit_to->username . '</a>.'),
			$db->quote($date)
		]
	);

	insert(
		'network_transfer',
		[
			'transfer_from',
			'transfer_to',
			'type',
			'date',
			'amount'
		],
		[
			$db->quote($deposit_from->id),
			$db->quote($deposit_to->id),
			$db->quote('deposit'),
			$db->quote($date),
			$db->quote($amount)
		]
	);

	if ($deposit_from->username !== $username_to)
	{
		$transaction_id = $db->insertid();

		$income_total = income_admin();
		$income_total = $income_total->income_total ?? 0;
		$income       = $income_total + $processing_fee;

		// insert company income
		insert(
			'network_income',
			[
				'transaction_id',
				'amount',
				'income_total',
				'income_date'
			],
			[
				$db->quote($transaction_id),
				$db->quote($processing_fee),
				$db->quote($income),
				$db->quote(time())
			]
		);
	}

	insert(
		'network_transactions',
		[
			'user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'
		],
		[
			$db->quote($deposit_to->id),
			$db->quote('Convert ' . $efund_name),
			$db->quote(number_format($amount, 2) . ' ' . $currency . ' converted from <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $deposit_from->username . '</a> to <a href="' .
				sef(44) . qs() . 'uid=' . $deposit_to->id . '">' . $deposit_to->username . '</a>'),
			$amount,
			$db->quote($deposit_from->balance),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_user_deposit_from($user_id, $amount)
{
	update(
		'network_users',
		['balance = balance - ' .
			((double) $amount + (double) settings('ancillaries')->processing_fee)],
		['id = ' . db()->quote($user_id)]
	);
}

/**
 * @param $username
 * @param $amount
 *
 *
 * @since version
 */
function update_user_deposit_to($username, $amount)
{
	update(
		'network_users',
		['payout_transfer = payout_transfer + ' . $amount],
		['id = ' . db()->quote(user_username($username)->id)]
	);
}

/**
 * @param $edit
 *
 * @return string
 *
 * @since version
 */
function date_get($edit): string
{
	$date = time();

	if ($edit)
	{
		$date = input_get('date', '', 'RAW');
	}

	return $date;
}

/**
 * @param $user_id
 * @param $amount
 * @param $username_to
 *
 * @param $edit
 *
 * @since version
 */
function process_efund_deposit($user_id, $amount, $username_to, $edit)
{
	$sa         = settings('ancillaries');
	$efund_name = $sa->efund_name;

	$db = db();

	validate_input($user_id, $amount, $username_to, $edit);

	$deposit_from = user($user_id);
	$deposit_to   = user_username($username_to);

	// mail admin and user
	$message = '<strong>Sender</strong>
			Username: ' . $deposit_from->username . '<br>
			Full Name: ' . $deposit_from->fullname . '<br>
			Email: ' . $deposit_from->email . '<br>
			Contact Number: ' . $deposit_from->contact . '<br><br>

			<strong>Recipient</strong>
			Username: ' . $deposit_to->username . '<br>
			Full Name: ' . $deposit_to->fullname . '<br>
			Email: ' . $deposit_to->email . '<br>
			Contact Number: ' . $deposit_to->contact . '<br><br>

			<strong>Amount Converted</strong><br>
			' . $amount . '<br>';

	try
	{
		$db->transactionStart();

		update_user_deposit_from($user_id, $amount);
		update_user_deposit_to($username_to, $amount);

		logs($user_id, $amount, $username_to, date_get($edit));

		send_mail($message, $efund_name .
			' Converted Successfully!', [$deposit_to->email, $deposit_from->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

//	send_mail($user_id, $amount, $username_to);

	application()->redirect(Uri::root(true) . '/' . sef(15), number_format($amount, 2) .
		' ' . settings('ancillaries')->currency . ' converted to ' . $username_to . '\'s ' . $efund_name, 'notice');
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_deposits($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transfer ' .
		'WHERE (transfer_from = ' . $db->quote($user_id) .
		' OR transfer_to = ' . $db->quote($user_id) .
		') AND type = ' . $db->quote('deposit') .
		' ORDER BY date DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_transfer_history($user_id): string
{
	$sa = settings('ancillaries');
	$efund_name = $sa->efund_name;

	$deposits = user_deposits($user_id);

	$str = '<h3>' . $efund_name . ' Conversion History</h3>';

	if (empty($deposits))
	{
		$str .= '<hr><p>No ' . $efund_name . ' converted yet.</p>';
	}
	else
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date Converted</th>
            <th>Convert From</th>
            <th>Convert To</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>';

		$str .= view_row_transfers($deposits);

		$str .= '</tbody>
    	</table>';
	}

	return $str;
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$settings_ancillaries = settings('ancillaries');

	$efund_name = $settings_ancillaries->efund_name;

	$currency       = $settings_ancillaries->currency;
	$processing_fee = $settings_ancillaries->processing_fee;

	$deposit_from = user($user_id);

	$str = '<h1>Convert ' . $efund_name . '</h1>';
	$str .= $processing_fee ? '<p>Efund Conversion is subject to ' . number_format($processing_fee, 2) .
		$currency . ' processing fee to be deducted from the remaining balance</p>' : '';
	$str .= '<form method="post" onsubmit="submit.disabled = true; return true;">
        <input type="hidden" name="final" value="1">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td><strong>Balance: </strong>' .
		number_format($deposit_from->balance, 2) . ' ' . $currency . '</td>
                <td><strong>' . $efund_name . ': </strong>' .
		number_format($deposit_from->payout_transfer, 2) . '</td>
            </tr>
            <tr>
                <td><label for="username">Recipient Username:</label></a></td>
                <td><input type="text"
                           name="username"
                           id="username"
                           required="required"
                           size="40"
                           style="float:left; padding-right: 12px">
                    <a onClick="checkInput(\'username\')"
                       class="uk-button uk-button-primary"
                       style="float:left">Check Username</a>
                    <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
                         id="usernameDiv"></div>
                </td>
            </tr>
            <tr>
                <td><strong><label for="amount">Amount to Convert (' . $currency . '):</label></strong></td>
                <td>
                    <input type="text" name="amount" id="amount" style="float:left">    
                    <input type="submit" name="submit" value="Convert" class="uk-button uk-button-primary">            
                </td>
            </tr>
        </table>
    </form>
    <hr>';

	return $str;
}