<?php

namespace BPL\Jumi\Withdrawal_Request;

require_once 'bpl/mods/usdt_currency.php';
require_once 'bpl/mods/payout_method.php';
require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Payout_Method\main as payout_method;

use function BPL\Mods\USDT_Currency\main as usdt_currency;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\page_validate;
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
	$username      = session_get('username');
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$merchant_type = session_get('merchant_type');
	$amount        = input_get('amount');
	$user_id       = session_get('user_id');

	page_validate();

	session_set('edit', false);

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= '<h1>Payout Request</h1>';

	if ($usertype === 'Member' || $usertype === 'Admin')
	{
		if ($amount !== '')
		{
			$amount_final     = input_get('amount_final');
			$deductions_total = input_get('total_deductions');

			process_payout($amount, $amount_final, $deductions_total, $user_id);
		}

		$str .= js();

		$str .= header($user_id);

		$str .= view_form($user_id);

		$str .= view_pending($user_id);
	}

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $merchant_type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_payout_pending($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_withdrawals ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' AND date_completed = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $amount
 * @param $user_id
 * @param $edit
 *
 *
 * @since version
 */
function validate_input($amount, $user_id, $edit)
{
	$settings_ancillaries = settings('ancillaries');

	$currency       = $settings_ancillaries->currency;
	$cybercharge    = $settings_ancillaries->cybercharge;
	$processing_fee = $settings_ancillaries->processing_fee;

	$user = user($user_id);

	$minimum_withdraw = $settings_ancillaries->{$user->account_type . '_min_withdraw'}; // php
	$minimum_bal_usd  = $settings_ancillaries->{$user->account_type . '_min_bal_usd'}; // php

	$pending = user_payout_pending($user_id);

	$pending_requests = 0;

	if ($pending)
	{
		foreach ($pending as $requested)
		{
			$pending_requests += $requested->amount;
		}
	}

	$gcash = explode('|', $user->bank);

	$app = application();

	if (empty($gcash[0]) || empty($gcash[1]))
	{
		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Completely Fill Up G-Cash Name and G-Cash Number for Payout Method.', 'error');
	}

	if (empty($amount))
	{
		$app->redirect(Uri::root(true) . '/' . sef(113),
			'Enter any amount!', 'error');
	}

	if ($amount < $minimum_withdraw)
	{
		$app->redirect(Uri::root(true) . '/' . sef(113),
			'Minimum withdraw is ' . number_format($minimum_withdraw, 2), 'error');
	}

	if (($user->balance - $pending_requests) < (
			$amount * (1 + $cybercharge / 100) + $processing_fee + $minimum_bal_usd))
	{
		$err = 'Maintain at least ' . number_format(($amount * (
					1 + $cybercharge / 100) + $processing_fee + $minimum_bal_usd), 2) .
			(!$pending_requests ? (' ' . $currency . '!') : (' ' . $currency .
					' due to your pending requests amounting to ' .
					number_format($pending_requests, 2)) . ' ' . $currency . '!');

		$app->redirect(Uri::root(true) . '/' . sef(113), $err, 'error');
	}

	if ($edit)
	{
		$date = input_get('date', '', 'RAW');
	}

	if ($edit && $date === '')
	{
		$app->redirect(Uri::root(true) . '/' . sef(113), 'Please specify Date!', 'error');
	}
}

/**
 * @param $amount
 * @param $amount_final
 * @param $deductions_total
 * @param $user_id
 * @param $edit
 *
 *
 * @since version
 */
function insert_payout($amount, $amount_final, $deductions_total, $user_id, $edit)
{
	$db = db();

	insert(
		'network_withdrawals',
		[
			'user_id',
			'amount',
			'amount_final',
			'deductions_total',
			'date_requested'
		],
		[
			$db->quote($user_id),
			$db->quote($amount),
			$db->quote($amount_final),
			$db->quote($deductions_total),
			$db->quote(date_get($edit))
		]
	);
}

/**
 * @param $edit
 *
 * @return int|string
 *
 * @since version
 */
function date_get($edit)
{
	$date = input_get('date', '', 'RAW');

	return $edit && isset($date) ? $date : time();
}

/**
 * @param $amount
 * @param $amount_final
 * @param $deductions_total
 * @param $user_id
 *
 *
 * @since version
 */
function process_payout($amount, $amount_final, $deductions_total, $user_id)
{
	$db = db();

	$edit = session_get('edit', false);

	validate_input($amount, $user_id, $edit);

	$settings_ancillaries = settings('ancillaries');

	$currency = $settings_ancillaries->currency;

	$user = user($user_id);

// mail admin and user
	$message = 'Username: ' . $user->username . '<br>
			Full Name: ' . $user->fullname . '<br>
			Email: ' . $user->email . '<br>
			Contact Number: ' . $user->contact . '<br><br>
			
			e-Wallet Balance: ' . $user->balance . ' ' . $currency . '<br>
			Amount Requested: ' . $amount . ' ' .
		$currency . '<br>
			Method: ' . $user->bank;

	try
	{
		$db->transactionStart();

		insert_payout($amount, $amount_final, $deductions_total, $user_id, $edit);

		update_payout_user($db->insertid());

		send_mail($message, 'Payout Request', [$user->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(113),
		'Payout processing time: Within 48 hours', 'success');

//	send_mail($amount, $user_id);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function update_payout_user($uid)
{
	$db = db();

	$payout = user_payouts($uid);

	update(
		'network_users',
		[
			'balance = balance - ' . ($payout->amount + $payout->deductions_total),
			'payout_total = payout_total + ' . $payout->amount
		],
		['id = ' . $db->quote($payout->user_id)]
	);
}

/**
 *
 * @return string
 *
 * @since version
 */
function js(): string
{
	$settings_ancillaries = settings('ancillaries');

	$str = '<script>';
	$str .= '(function ($) {
		$(document).ready(function () {
			$("#amount").keyup(function () {
				const amount = parseFloat($("#amount").val()),
	            cybercharge = parseFloat(' . ($settings_ancillaries->cybercharge / 100) . '),
	            processing_fee = parseFloat(' . $settings_ancillaries->processing_fee . '),
	            tax = amount * cybercharge,
	            deductions = amount * cybercharge + processing_fee,
				final_btc = amount / ' . (usdt_currency() / settings('trading')->fmc_to_usd) . ';' .
		'$("#amount_final").val($.number((final_btc > 0 ? final_btc : 0), 8));' .
		'$("#tax").val($.number(tax, 2));
				$("#total_deductions").val($.number(deductions, 2));
			});
		});
	})(jQuery);';
	$str .= '</script>';

	$jquery_number = 'bpl/plugins/jquery.number.js';

	$str .= '<script src="' . $jquery_number . '"></script>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function header($user_id): string
{
	$settings_ancillaries = settings('ancillaries');

	$currency       = $settings_ancillaries->currency;
	$cybercharge    = $settings_ancillaries->cybercharge;
	$processing_fee = $settings_ancillaries->processing_fee;

	$minimum_withdraw = $settings_ancillaries->{user($user_id)->account_type . '_min_withdraw'}; // php

	$str = $cybercharge || $processing_fee ? '<p>Payouts are subject to ' : '';
	$str .= $cybercharge ? $cybercharge . '% cybercharge ' : '';
	$str .= $cybercharge && $processing_fee ? '+ ' : '';
	$str .= $processing_fee ? number_format($processing_fee, 2) .
		' ' . $currency . ' ' . 'processing fee ' : '';
	$str .= $cybercharge || $processing_fee ? 'per withdrawal transaction, and is non-refundable' : '';
	$str .= $minimum_withdraw ? '<br>Minimum request is ' . number_format($minimum_withdraw, 2) .
		' ' . $currency . '.' : '.';
	$str .= '</p>';

	return $str;
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
	$settings_ancillaries = settings('ancillaries');

	$currency       = $settings_ancillaries->currency;
	$cybercharge    = $settings_ancillaries->cybercharge;
	$processing_fee = $settings_ancillaries->processing_fee;

	$user = user($user_id);

	$pending = user_payout_pending($user_id);

	$pending_requests = 0;

	if ($pending)
	{
		foreach ($pending as $requested)
		{
			$pending_requests += $requested->amount;
		}
	}

	$str = '<form method="post" onsubmit="submit.disabled = true; return true;">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td style="width: 150px">
                    <div style="text-align: right"><strong>Balance</strong>:</div>
                </td>';

	$max_withdraw = (($user->balance - $pending_requests) * (1 - $cybercharge / 100) -
		$processing_fee - $settings_ancillaries->{$user->account_type . '_min_bal_usd'});

	$str .= '<td>' . number_format($user->balance, 2) . ' ' . $currency . '<span
                style="float:right;">Max. Withdraw: ' . number_format(
			($max_withdraw > 0 ? $max_withdraw : 0), 2) . ' ' . $currency . '</span>
    </td>
    </tr>
    <tr>
        <td>
            <div style="text-align: right"><strong><label for="amount">Amount Requested:</label></strong></div>
        </td>
        <td><input style="text-align: center" type="text" name="amount" id="amount"> ' . $currency . '</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Service Charge</strong></td>
    </tr>
    <tr>
        <td>
            <div style="text-align: right"><label for="tax">Cybercharge:</label></div>
        </td>
        <td><input type="text" name="tax" style="text-align: center" id="tax" value="0.00"
                   readonly> ' . $currency .
		'</td>
    </tr>
    <tr>
        <td>
            <div style="text-align: right"><label for="fee">Processing Fee:</label></div>
        </td>
        <td><input type="text" id="fee" style="text-align: center"
                   value="' . number_format($processing_fee, 2) . '" readonly> ' . $currency .
		'</td>
    </tr>
    <tr>
        <td>
            <div style="text-align: right"><label for="total_deductions">Total Deductions:</label></div>
        </td>
        <td>
            <input type="text" style="text-align: center" readonly="readonly" name="total_deductions" id="total_deductions"> ' .
		$currency . '</td>
    </tr>';

	$str .= (settings('plans')->trading ? '<tr>
        <td><strong><label for="amount_final">Final amount:</strong></label></td>
        <td>
            <input type="text" readonly="readonly" name="amount_final" id="amount_final" style="text-align: center"> BTC
        </td>
    </tr>' : '<input type="hidden" readonly="readonly" name="amount_final" id="amount_final">');
	$str .= '<tr>
        <td colspan="2">
            <div style="text-align: center"><input type="submit" name="submit" value="Submit Request"
                                       class="uk-button uk-button-primary"></div>
        </td>
    </tr>
    </table>
    </form>';

	return $str;
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function user_payouts($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_withdrawals w ' .
		'WHERE u.id = w.user_id ' .
		'AND w.withdrawal_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 * @param $uid
 * @param $user_id
 *
 *
 * @since version
 */
function request_cancel($uid, $user_id)
{
	$app = application();

	$result = user_payouts($uid);

	if ($result->user_id !== $user_id)
	{
		$app->redirect(Uri::root(true) . '/' . sef(113), 'Transaction Invalid!', 'error');
	}

	$db = db();

	try
	{
		$db->transactionStart();

		payout_cancel($uid);

		update_user_payout_cancel($result->amount, $result->user_id);

		logs_cancel($uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	$app->redirect(Uri::root(true) . '/' . sef(113), 'Payout Request Cancelled!', 'notice');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function payout_cancel($uid)
{
	delete(
		'network_withdrawals',
		['withdrawal_id = ' . db()->quote($uid)]
	);
}

/**
 * @param $amount
 * @param $user_id
 *
 * @since version
 */
function update_user_payout_cancel($amount, $user_id)
{
	$db = db();

	update(
		'network_users',
		[
			'balance = balance + ' . $amount,
			'payout_total = payout_total - ' . $amount
		],
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_cancel($uid)
{
	$result = user_payouts($uid);

	$db = db();

	$activity = '<b>Payout Request of ' . number_format($result->amount, 2) .
		settings('ancillaries')->currency . ' was cancelled by </b><a href="' . sef(44) . qs() . 'uid=' .
		$result->id . '">' . $result->username . '</a>' . '.';

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
			$db->quote($result->id),
			$db->quote($result->id),
			$db->quote(1),
			$db->quote($activity),
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
function view_pending($user_id): string
{
	$settings_plans = settings('plans');

	$pending = user_payout_pending($user_id);

	$str = '<h2>Pending Requests</h2>';

	if (empty($pending))
	{
		$str .= '<hr><p>No pending requests yet.</p>';
	}
	else
	{
		$uid    = input_get('uid');
		$cancel = input_get('cancel', 0);

		if ($cancel && $uid)
		{
			request_cancel($uid, $user_id);
		}

		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Date Requested</th>';
		$str .= '<th>Amount (' . settings('ancillaries')->currency . ')</th>';
		$str .= '<th>Deductions (' . settings('ancillaries')->currency . ')</th>';
		$str .= ($settings_plans->trading ? '<th>Final Amount (BTC)</th>' : '');
		$str .= '<th>Method</th>';
		$str .= '<th>Action</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($pending as $tmp)
		{
			$payout_method = payout_method(user($user_id));

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $tmp->date_requested) . '</td>';
			$str .= '<td>' . number_format($tmp->amount, 2) . '</td>';
			$str .= '<td>' . number_format($tmp->deductions_total, 2) . '</td>';
			$str .= ($settings_plans->trading ? '<td>' . number_format($tmp->amount_final, 8) . '</td>' : '');
			$str .= '<td>' . $payout_method . '</td>';
			$str .= '<td><a href="' . sef(113) . qs() . 'uid=' . $tmp->withdrawal_id . '&cancel=1">Cancel</a></td>';
			$str .= '</tr>';
		}

		$str .= '</tbody>
        </table>';
	}

	return $str;
}