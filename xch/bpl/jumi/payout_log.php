<?php

namespace BPL\Jumi\Payout_Log;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;
use function BPL\Menu\member as menu_member;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\page_reload;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

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
	$user_id       = session_get('user_id');
	$account_type  = session_get('account_type');
	$merchant_type = session_get('merchant_type');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= page_reload();

	$str .= view_payouts(session_get('user_id'), $usertype, session_get('admintype'));

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
 *
 * @return array|mixed
 *
 * @since version
 */
function payouts_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_payouts p ' .
		'INNER JOIN network_transactions t ' .
		'WHERE p.transaction_id = t.transaction_id ' .
		'ORDER BY p.payout_id DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function payouts_user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_payouts p ' .
		'INNER JOIN network_transactions t ' .
		'WHERE p.transaction_id = t.transaction_id ' .
		'AND t.user_id = ' . $db->quote($user_id) .
		' ORDER BY p.payout_id DESC'
	)->loadObjectList();
}

/**
 * @param           $user
 *
 * @return string
 *
 * @since version
 */
function payout_method($user): string
{
	$payout_member = explode('|', $user->bank);

	switch ($payout_member[0])
	{
		case 'bank':
			[, $bank_type, $bank_name, $bank_account] = $payout_member;

			$payout_method = 'Bank: [' . $bank_type . '][' . $bank_name . '][' . $bank_account . ']';
			break;
		case 'other':
			$other_method = $payout_member[1];

			$payout_method = '[' . $other_method . ']';
			break;
		default:
			[, $gcash_name, $gcash_number,] = $payout_member;

			$payout_method = 'G-Cash: [' . $gcash_name . '][' . $gcash_number . ']';
			break;
	}

	return $payout_method;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_payouts_admin(): string
{
	$currency = settings('ancillaries')->currency;

	$payouts = payouts_admin();

	$str = '';

	if (!empty($payouts))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Method</th>
                <th>Amount (' . $currency . ')</th>
                <th>Charge (' . $currency . ')</th>
                <th>Total Payouts (' . $currency . ')</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($payouts as $payout)
		{
			$user = user($payout->user_id);

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $payout->payout_date) . '</td>';
			$str .= '<td><a href="' . sef(44) . qs() . 'uid=' .
				$user->id . '">' . $user->username . '</a></td>';
			$str .= '<td>' . payout_method($user) . '</td>';
			$str .= '<td>' . number_format($payout->amount, 2) . '</td>';
			$str .= '<td>' . number_format($payout->total_tax, 2) . '</td>';
			$str .= '<td>' . number_format($payout->payout_total, 2) . '</td>';
			$str .= '</tr>';
		}

		$str .= '</tbody>
        </table>';
	}
	else
	{
		$str .= '<hr><p>No payouts yet.</p>';
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_payouts_user($user_id): string
{
	$setting_ancillaries = settings('ancillaries');

	$cybercharge    = $setting_ancillaries->cybercharge / 100;
	$processing_fee = $setting_ancillaries->processing_fee;
	$currency       = $setting_ancillaries->currency;

	$payouts = payouts_user($user_id);

	$str = '';

	if (!empty($payouts))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Method</th>
                <th>Paid (' . $currency . ')</th>
            </tr>
            </thead>
            <tbody>';

		$total = 0;

		foreach ($payouts as $payout)
		{
			$user = user($payout->user_id);

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $payout->payout_date) . '</td>';

			$str .= payout_method($user);
			$str .= '<td>' . number_format($payout->amount - (
						($payout->amount * $cybercharge) + $processing_fee), 2) . '</td>';
			$str .= '</tr>';

			$total += ($payout->amount - (($payout->amount * $cybercharge) + $processing_fee));
		}

		$str .= '</tbody>
	        </table>
	        <p><strong>Total Paid: </strong>' . number_format($total, 2) . ' ' . $currency;
	}
	else
	{
		$str .= '<hr><p>No payouts yet.</p>';
	}

	return $str;
}

/**
 * @param $user_id
 * @param $usertype
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function view_payouts($user_id, $usertype, $admintype): string
{
	$str = '<h1>Payout Logs</h1>';

	if ($usertype === 'Admin' && $admintype === 'Super')
	{
		$str .= view_payouts_admin();
	}
	else
	{
		$str .= view_payouts_user($user_id);
	}

	return $str;
}