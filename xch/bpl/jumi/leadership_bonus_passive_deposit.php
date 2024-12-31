<?php

namespace BPL\Jumi\Leadership_Bonus_Passive_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
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

	$str = menu();

	$amount = input_get('amount');
	session_set('lpd', $amount);

	$str .= '<h1>' . settings('plans')->leadership_passive_name . ' Wallet</h1>';

	if ($amount !== '')
	{
		process_form($user_id, $amount);
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
	$app = application();

	$user = user($user_id);

	$count_directs = count(directs($user_id));

	$minimum_deposit = settings('leadership_passive')
		->{$user->account_type . '_leadership_passive_minimum_deposit'};

	if ($amount > $user->bonus_leadership_passive_balance)
	{
		$app->redirect(Uri::root(true) . '/' . sef(39),
			'Amount exceeds available balance!', 'error');
	}

	if (round($amount, 2) !== round($minimum_deposit * $count_directs, 2))
	{
		$app->redirect(Uri::root(true) . '/' . sef(39), 'Deposit only ' .
			number_format($minimum_deposit * $count_directs, 2) .
			' ' . settings('ancillaries')->currency . '!', 'error');
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

	$field_user = ['bonus_leadership_passive_balance = bonus_leadership_passive_balance - ' . $amount];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . $amount;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $amount;
	}

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function process_form($user_id, $amount)
{
//	$db = db();

	validate_input($user_id, $amount);

//	try
//	{
//		$db->transactionStart();
//
//		update_user($user_id, $amount);
//
//		logs($user_id, $amount);
//
//		$db->transactionCommit();
//	}
//	catch (Exception $e)
//	{
//		$db->transactionRollback();
//		ExceptionHandler::render($e);
//	}
//
//	application()->redirect(Uri::root(true) . '/' . sef(39),
//		settings('plans')->leadership_passive_name .
//		' Deposit Completed Successfully!', 'success');

	application()->redirect(Uri::root(true) . '/' . sef(57));
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
	activity($user_id, $amount);

	transactions($user_id, $amount);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function activity($user_id, $amount)
{
	$db = db();

	$user = user($user_id);

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
			$db->quote('<b>' . settings('plans')->leadership_passive_name . ' Deposit: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> deposited ' .
				number_format($amount, 2) . ' ' . settings('ancillaries')->currency . ' to credit.'),
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
function transactions($user_id, $amount)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

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
			$db->quote($settings_plans->leadership_passive_name . ' Deposit'),
			$db->quote('<b>' . $settings_plans->leadership_passive_name . ' Deposit: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> deposited ' .
				number_format($amount, 2) . ' ' . settings('ancillaries')->currency . ' to credit.'),
			$amount,
			((double) $user->payout_transfer + (double) $amount),
			$db->quote(time())
		]
	);
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
	$currency = settings('ancillaries')->currency;

	$user = user($user_id);

	return '<form method="post">
	    <table class="category table table-striped table-bordered table-hover">
	        <tr>
	            <td><strong>' . settings('plans')->leadership_passive_name .
		' Balance: ' . number_format($user->bonus_leadership_passive_balance, 8) . ' ' . $currency . '</strong>
	                <strong style="float: right">
	                    e-Wallet Balance: ' .
		number_format($user->payout_transfer, 2) . ' ' . $currency . '</strong>
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
	                    <input class="uk-button uk-button-medium"
	                           name="submit"
	                           value="Claim" style="margin-bottom: 10px"
	                           type="submit">
	                </div>
	            </td>
	        </tr>
	    </table>
	</form>';
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function directs($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($user_id)
	)->loadObjectList();
}