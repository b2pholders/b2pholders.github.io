<?php

namespace BPL\Jumi\Point_Transfer;

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
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\user;
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

	page_validate();

	session_set('edit', false);

	$str = menu();

	if ((int) $final !== 1)
	{
		$str .= check_input2();
		$str .= view_form($user_id);
	}
	else
	{
		$amount   = input_get('amount');
		$username = input_get('username');
		$edit     = session_get('edit', false);

		$date = input_get_date($edit);

		process_form($user_id, $amount, $username, $date);
	}

	$str .= view_transfer_history($user_id);

	echo $str;
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

//	$efund_name = $settings_ancillaries->efund_name;
//
//	$currency = $settings_ancillaries->currency;

	$processing_fee = $settings_ancillaries->processing_fee;

	$transfer_from = user($user_id);

	$str = '<h1>' . /*$efund_name*/
		'Token' . ' Transfer</h1>';
	$str .= $processing_fee ? '<p>Transfers are subject to ' . number_format($processing_fee, 5) .
		/*$currency */
		' tkn.' . ' processing fee to be deducted from the remaining balance</p>' : '';
	$str .= '<form method="post" onsubmit="submit.disabled = true; return true;">
        <input type="hidden" name="final" value="1">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="2"><strong>' . /*$efund_name*/'Token' . ': </strong>' .
		number_format(/*$transfer_from->payout_transfer*/$transfer_from->points, 5) . '</td>
            </tr>
            <tr>
                <td><label for="username">Recipient Username:</label></a></td>
                <td><input type="text"
                           name="username"
                           id="username"
                           required="required"
                           size="40"
                           style="float:left; padding-right: 12px">
                    <a href="javascript:void(0)" onClick="checkInput(\'username\')"
                       class="uk-button uk-button-primary"
                       style="float:left">Check Username</a>
                    <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
                         id="usernameDiv"></div>
                </td>
            </tr>
            <tr>
                <td><strong><label for="amount">Amount:</label></strong></td>
                <td>
                    <input type="text" name="amount" id="amount" style="float:left">
                    <input type="submit" name="submit" value="Transfer" class="uk-button uk-button-primary">                   
                </td>
            </tr>
        </table>
    </form>
    <hr>';

	return $str;
}

/**
 *
 *
 * @since version
 */
function validate_input($user_id, $amount, $username)
{
	$sa = settings('ancillaries');

	$processing_fee = $sa->processing_fee;

	$transfer_from = user($user_id);

	$app = application();

	if ($amount === '' ||
		!is_numeric($amount) ||
		$username === '' ||
		$username === $transfer_from->username)
	{
		$app->redirect(Uri::root(true) .
			'/' . sef(133), 'Invalid Amount or Username!', 'error');
	}

	if ($transfer_from->payout_transfer < ($amount + $processing_fee))
	{
		$app->redirect(Uri::root(true) .
			'/' . sef(133), 'Please maintain at least ' .
			number_format($amount + $processing_fee, 5) .
			' ' . $sa->currency, 'error');
	}

	$transfer_to = user_username($username);

	if (!$transfer_to->id)
	{
		$app->redirect(Uri::root(true) .
			'/' . sef(133), 'Invalid user!', 'error');
	}

	$edit = session_get('edit', false);

	if ($edit)
	{
		$date = input_get('date', '', 'RAW');

		if ($date === '')
		{
			$app->redirect(Uri::root(true) . '/' . sef(133),
				'Please specify the Current Date!', 'error');
		}
	}
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_user_transfer_from($user_id, $amount)
{
	update(
		'network_users',
		[
			/*'payout_transfer = payout_transfer - '*/'points = points - ' . ((double) $amount),
			'payout_transfer = payout_transfer - ' . ((double) settings('ancillaries')->processing_fee)
		],
		['id = ' . db()->quote(user($user_id)->id)]
	);
}

/**
 * @param $username
 * @param $amount
 *
 *
 * @since version
 */
function update_user_transfer_to($username, $amount)
{
	update(
		'network_users',
		[/*'payout_transfer = payout_transfer + '*/'points = points + ' . $amount],
		['id = ' . db()->quote(user_username($username)->id)]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function log_activity($user_id, $username, $amount, $date)
{
	$db = db();

//	$sa = settings('ancillaries');

	$transfer_from = user($user_id);
	$transfer_to   = user_username($username);

	$activity = '<b>' . /*$sa->efund_name*/'Points' . ' Transfer: </b> <a href="' . sef(44) . qs() . 'uid=' .
		$user_id . '">' . $transfer_from->username . '</a> transferred ' . number_format($amount, 5) . ' ' .
		/*settings('ancillaries')->currency*/'Points' . ' to <a href="' . sef(44) . qs() . 'uid=' .
		$transfer_to->id . '">' . $transfer_to->username . '</a>.';

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
			$db->quote($transfer_from->sponsor_id),
			$db->quote(1),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function log_transactions($user_id, $username, $amount, $date)
{
	$db = db();

	$sa = settings('ancillaries');

//	$efund_name = $sa->efund_name;

	$transfer_from = user($user_id);
	$transfer_to   = user_username($username);

	$details = '<b>' . /*$efund_name*/'Points' . ' Transfer: </b> <a href="' . sef(44) . qs() . 'uid=' . $user_id .
		'">' . $transfer_from->username . '</a> transferred ' . number_format($amount, 5) . ' ' .
		/*$settings_ancillaries->currency*/'Points' . ' to <a href="' . sef(44) . qs() . 'uid=' .
		$transfer_to->id . '">' . $transfer_to->username . '</a>.';

	$balance = $transfer_from->payout_transfer - (/*(double) $amount + */(double) $sa->processing_fee);

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
			$db->quote(/*$efund_name*/'Points' . ' Transfer'),
			$db->quote($details),
			$db->quote($amount),
			$db->quote($balance),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function log_transfer($user_id, $username, $amount, $date)
{
	$db = db();

	insert(
		'network_transfer_points',
		[
			'transfer_from',
			'transfer_to',
			'date',
			'amount'
		],
		[
			$db->quote($user_id),
			$db->quote(user_username($username)->id),
			$db->quote($date),
			$db->quote($amount)
		]
	);
}

/**
 *
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
 * @param $date
 *
 *
 * @since version
 */
function log_income_admin($date)
{
	$db = db();

	$processing_fee = settings('ancillaries')->processing_fee;

	$income_total = income_admin();

	$income = $income_total ? ($income_total->income_total + $processing_fee) : 0;

	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($db->insertid()),
			$db->quote($processing_fee),
			$db->quote($income),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function logs($user_id, $username, $amount, $date)
{
	log_activity($user_id, $username, $amount, $date);
	log_transactions($user_id, $username, $amount, $date);
	log_transfer($user_id, $username, $amount, $date);
	log_income_admin($date);
}

/**
 * @param $user_id
 * @param $amount
 * @param $username
 *
 * @param $date
 *
 * @since version
 */
function process_form($user_id, $amount, $username, $date)
{
	$db = db();

//	$sa = settings('ancillaries');

	validate_input($user_id, $amount, $username);

	$transfer_from = user($user_id);
	$transfer_to   = user_username($username);

	// mail admin and user
	$message = '<strong>Sender</strong>
			Username: ' . $transfer_from->username . '<br>
			Full Name: ' . $transfer_from->fullname . '<br>
			Email: ' . $transfer_from->email . '<br>
			Contact Number: ' . $transfer_from->contact . '<br><br>

			<strong>Recipient</strong>
			Username: ' . $transfer_to->username . '<br>
			Full Name: ' . $transfer_to->fullname . '<br>
			Email: ' . $transfer_to->email . '<br>
			Contact Number: ' . $transfer_to->contact . '<br><br>

			<strong>Amount Transferred</strong><br>
			' . $amount . ' tkn.<br>';

	try
	{
		$db->transactionStart();

		update_user_transfer_from($user_id, $amount);
		update_user_transfer_to($username, $amount);

		logs($user_id, $username, $amount, $date);

		send_mail($message, /*$sa->efund_name*/'Points' .
			' Transferred Successfully!', [$transfer_from->email, $transfer_to->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(133), number_format($amount, 5) .
		' ' . /*settings('ancillaries')->currency*/'tkn.' . ' transferred to ' . $username . '.', 'success');
}

/**
 * @param $edit
 *
 *
 * @return string
 * @since version
 */
function input_get_date($edit): string
{
	$date = time();

	if ($edit)
	{
		$date = input_get('date', '0', 'RAW');
	}

	return $date;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_transfers($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transfer_points ' .
		'WHERE (transfer_from = ' . $db->quote($user_id) .
		' OR transfer_to = ' . $db->quote($user_id) .
		') AND type = ' . $db->quote('transfer') .
		' ORDER BY date DESC'
	)->loadObjectList();
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_transfer_history($user_id): string
{
	$transfers = user_transfers($user_id);

	$str = '<h2>Transfer History</h2>';

	if (empty($transfers))
	{
		$str .= '<hr><p>No transfers yet.</p>';
	}
	else
	{
		$str .= '<div class="table-responsive">';
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date Transferred</th>
            <th>Transfer From</th>
            <th>Transfer To</th>
            <th>Amount (tkn.)</th>
        </tr>
        </thead>
        <tbody>';

		$str .= view_row_transfers($transfers);

		$str .= '</tbody>
    	</table>';
		$str .= '</div>';
	}

	return $str;
}