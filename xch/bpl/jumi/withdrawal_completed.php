<?php

namespace BPL\Jumi\Withdrawal_Completed;

require_once 'bpl/menu.php';
require_once 'bpl/mods/payout_method.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Payout_Method\main as payout_method;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_reload;

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
	$account_type  = session_get('account_type');
	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');
	$admintype     = session_get('admintype');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= page_reload();

	$str .= view_table($user_id, $usertype);

	echo $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function withdrawals_completed()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_withdrawals w ' .
		'WHERE u.id = w.user_id ' .
		'AND w.date_completed <> ' . $db->quote(0) .
		' ORDER BY w.withdrawal_id DESC'
	)->loadObjectList();
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
 *
 * @return array|mixed
 * @since version
 */
function user_withdrawals_completed($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_withdrawals w ' .
		'WHERE u.id = w.user_id ' .
		'AND w.date_completed <> ' . $db->quote(0) .
		' AND w.user_id = ' . $db->quote($user_id) .
		' ORDER BY w.withdrawal_id DESC;'
	)->loadObjectList();
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_admin(): string
{
	$settings_ancillaries = settings('ancillaries');

	$currency = $settings_ancillaries->currency;

	$results = withdrawals_completed();

	$str = '<h1>Completed Payouts</h1>';

	if (!empty($results))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
	            <thead>
	            <tr>
	                <th>Date Requested</th>
	                <th>Username</th>
	                <th>Balance (' . $currency . ')</th>
	                <th>Amount (' . $currency . ')</th>
	                <th>Deductions (' . $currency . ')</th>
	                <th>Method</th>
	            </tr>
	            </thead>
	            <tbody>';

		foreach ($results as $result)
		{
			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $result->date_requested) . '</td>';
			$str .= '<td><a href="' . sef(9) . qs() . 'uid=' . $result->id . '">' . $result->username . '</a></td>';
			$str .= '<td>' . number_format($result->balance, 2) . '</td>';
			$str .= '<td>' . number_format($result->amount, 2) . '</td>';
			$str .= '<td>' . number_format($result->deductions_total, 2) . '</td>';
			$str .= '<td>' . payout_method($result) . '</td>';
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
function view_table_user($user_id): string
{
	$settings_ancillaries = settings('ancillaries');

	$currency = $settings_ancillaries->currency;

	$results = user_withdrawals_completed($user_id);

	$str = '<h1>Completed Payouts</h1>';

	if (!empty($results))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
	            <thead>
	            <tr>
	                <th>Date Requested</th>
	                <th>Request (' . $currency . ')</th>
	                <th>Final Deducted (' . $currency . ')</th>
	                <th>Method</th>
	            </tr>
	            </thead>
	            <tbody>';

		foreach ($results as $result)
		{
			$str .= '<tr>
		                <td>' . date('M j, Y - g:i A', $result->date_requested) . '</td>
		                <td>' . number_format($result->amount, 2) . '</td>
		                <td>' . number_format($result->amount -
					(($result->amount * $settings_ancillaries->cybercharge / 100) +
						$settings_ancillaries->processing_fee), 2) . '</td>
		                <td>' . payout_method($result) . '</td>
		            </tr>';
		}

		$str .= '</tbody>
        		</table>';
	}
	else
	{
		$str .= '<hr>No payouts yet.';
	}

	return $str;
}

/**
 * @param $user_id
 * @param $usertype
 *
 * @return string
 *
 * @since version
 */
function view_table($user_id, $usertype): string
{
	$str = '';

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$str .= view_table_admin();
	}
	else
	{
		$str .= view_table_user($user_id);
	}

	return $str;
}