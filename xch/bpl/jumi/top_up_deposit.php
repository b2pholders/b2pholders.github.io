<?php

namespace BPL\Jumi\Top_Up_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\time;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');

	page_validate();

	$amount = input_get('amount');

	$str = menu();

	if ($amount !== '')
	{
		validate_input($user_id, $amount);

		process_deposit($user_id, $amount);
	}

	$str .= view_form($user_id);

	echo $str;
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function validate_input($user_id, $amount)
{
	$user = user($user_id);

	$si = settings('investment');

	$minimum_deposit = $si->{$user->account_type . '_top_up_minimum_deposit'};

	$app = application();

	if ($amount > $user->top_up_balance)
	{
		$err = 'Deposit exceeds ' . settings('plans')->top_up_name . ' balance!';

		$app->redirect(Uri::root(true) . '/' . sef(104), $err, 'error');
	}

	if ($amount < $minimum_deposit)
	{
		$err = 'Deposit at least ' . number_format($minimum_deposit, 2) .
			' ' . settings('ancillaries')->currency . '!';

		$app->redirect(Uri::root(true) . '/' . sef(104), $err, 'error');
	}

	if (((double) $user->top_up_deposit_today + (double) $amount) > $si->{$user->account_type . '_top_up_maximum_deposit'})
	{
		$app->redirect(Uri::root(true) . '/' . sef(104) . qs() . 'uid=' . $user_id,
			'Exceeded Maximum Deposit!', 'error');
	}
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_user($user_id, $amount)
{
	$db = db();

	update(
		'network_users',
		[
			'top_up_balance = top_up_balance - ' . $amount,
			'payout_transfer = payout_transfer + ' . $amount
		],
		['id = ' . $db->quote(user($user_id)->id)]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function log_activity($user_id, $amount)
{
	$db = db();

	$user = user($user_id);

	$activity = '<b>' . settings('plans')->top_up_name . ' Deposit: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> deposited ' .
		number_format($amount, 2) . ' ' . settings('ancillaries')->currency . ' to e-wallet.';

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
			$db->quote($user->sponsor_id),
			$db->quote($user_id),
			$db->quote($activity),
			$db->quote(time())
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
function log_transactions($user_id, $amount)
{
	$db = db();

	$user = user($user_id);

	$details = number_format($amount, 2) . ' ' . settings('ancillaries')->currency .
		' deposited to e-wallet of <a href="' . sef(44) . qs() . 'uid=' . $user_id . '">' .
		$user->username . '</a>.';

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
			$db->quote(settings('plans')->top_up_name . ' Deposit'),
			$db->quote($details),
			$db->quote($amount),
			$db->quote($user->payout_transfer + $amount),
			$db->quote(time())
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
function logs($user_id, $amount)
{
	log_activity($user_id, $amount);
	log_transactions($user_id, $amount);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function process_deposit($user_id, $amount)
{
	$db = db();

	try
	{
		$db->transactionStart();

		update_user($user_id, $amount);

		logs($user_id, $amount);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(104),
		settings('plans')->top_up_name . ' deposit completed successfully!', 'success');
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$sa = settings('ancillaries');

	$currency = $sa->currency;

	$user = user($user_id);

	$str = '<h1>' . settings('plans')->top_up_name . ' Wallet</h1>';

	$str .= '<form method="post">
	    <table class="category table table-striped table-bordered table-hover">
	        <tr>
	            <td><strong>' . settings('plans')->top_up_name . ' Balance: ' .
		number_format($user->top_up_balance, 2) . ' ' . $currency .
		'</strong>
	                <strong style="float: right">
	                    ' . $sa->efund_name . ' Balance: ' . number_format($user->payout_transfer, 2) . ' ' . $currency .
		'</strong>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <div class="uk-form-row">
	                    <input type="text"
	                           placeholder="amount"
	                           name="amount"
	                           class="uk-form-medium uk-form-width-medium"
	                           required>
	                    <input class="uk-button uk-button-primary"
	                           name="submit"
	                           value="Deposit" style="margin-bottom: 10px"
	                           type="submit">
	                </div>
	            </td>
	        </tr>
	    </table>
	</form>';

	return $str;
}