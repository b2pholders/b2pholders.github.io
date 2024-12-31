<?php

namespace BPL\Jumi\Request_Share_Fund_Log;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;
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
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');
	$usertype      = session_get('usertype');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= view_logs($user_id, $usertype, $admintype);

	echo $str;
}

/**
 *
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
function request_transactions()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_share_fund_requests r ' .
		'INNER JOIN network_transactions t ' .
		'ON r.transaction_id = t.transaction_id ' .
		'ORDER BY r.request_id DESC'
	)->loadObjectList();
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_admin_request_logs(): string
{
//	$currency = settings('ancillaries')->currency;

	$share_fund_name = settings('ancillaries')->share_fund_name;

	$result = request_transactions();

	$str = '';

	if (!empty($result))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Details</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>Total Requests</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($result as $log)
		{
			$user = user($log->user_id);

			$str .= '<tr>
                    <td>' . date('M j, Y - g:i A', $log->request_date) . '</td>
                    <td><a href="' . sef(44) . qs() .
				'uid=' . $user->id . '">' . $user->username . '</a></td>
                    <td style="table-layout: fixed; width: 300px">' . $log->details . '</td>
                    <td>' . number_format($log->amount, 2) . /*' ' . $efund_name .*/ '</td>
                    <td>' . number_format($log->request_total, 2) . /*' ' . $efund_name .*/ '</td>
                </tr>';
		}

		$str .= '</tbody>
        	</table>';
	}
	else
	{
		$str .= '<hr><p>No ' . $share_fund_name . ' requests yet.</p>';
	}

	return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function user_request_transactions($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_share_fund_requests r ' .
		'INNER JOIN network_transactions t ' .
		'ON r.transaction_id = t.transaction_id ' .
		'AND t.user_id = ' . $db->quote($user_id) .
		' ORDER BY r.request_id DESC'
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
function view_user_request_logs($user_id): string
{
	$sa = settings('ancillaries');

	$share_fund_name = $sa->share_fund_name;

	/*$currency = $sa->currency;*/

	$result = user_request_transactions($user_id);

	$str = '';

	if ($result)
	{
		$str .= '<h1>' . $share_fund_name . ' Activity</h1>
        <table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Details</th>';
		$str .= '<th>Amount</th>';
		$str .= '</tr>
            </thead>
            <tbody>';

		$total = 0;

		foreach ($result as $log)
		{
			$str .= '<tr>
                    <td>' . date('M j, Y - g:i A', $log->request_date) . '</td>
                    <td style="table-layout: fixed; width: 300px">' . $log->details . '</td>
                    <td>' . number_format($log->amount, 2) . /*'' . $efund_name .*/ '</td>
                </tr>';

			$total += $log->amount;
		}

		$str .= '</tbody>
        </table>
        <p><strong>Total ' . $share_fund_name . ' Request: </strong>' .
			number_format($total, 2)/* . ' ' . $efund_name*/;
	}
	else
	{
		$str .= '<hr><p>No ' . $share_fund_name . ' requests yet.</p>';
	}

	return $str;
}

/**
 *
 * @param $user_id
 * @param $usertype
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function view_logs($user_id, $usertype, $admintype): string
{
	$str = page_reload();

	$str .= '<h1>' . settings('ancillaries')->share_fund_name . ' Request Logs</h1>';

	if ($usertype === 'Admin' && $admintype === 'Super')
	{
		$str .= view_admin_request_logs();
	}
	else
	{
		$str .= view_user_request_logs($user_id);
	}

	return $str;
}