<?php

namespace BPL\Jumi\Convert_Efund_Log;

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
	$username     = session_get('username');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$usertype     = session_get('usertype');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$str .= view_logs($user_id, $usertype, $admintype);

	echo $str;
}

/**
 *
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $user_id): string
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
function efund_convert_transactions()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_efund_conversions c ' .
		'INNER JOIN network_transactions t ' .
		'ON c.transaction_id = t.transaction_id ' .
		'ORDER BY c.conversion_id DESC'
	)->loadObjectList();
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_admin_efund_convert_logs(): string
{
	$results = efund_convert_transactions();

	$efund_name = settings('ancillaries')->efund_name;

	$str = '';

	if (!empty($results))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Date</th>';
		$str .= '<th>User</th>';
		$str .= '<th>Details</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>Total Requests</th>';
		$str .= '<th>Final</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($results as $log)
		{
			$user = user($log->user_id);

			$currency = in_array($log->method, ['bank', 'gcash']) ? 'PHP' : $log->method;

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $log->conversion_date) . '</td>';
			$str .= '<td><a href="' . sef(44) . qs() .
				'uid=' . $user->id . '">' . $user->username . '</a></td>';
			$str .= '<td style="table-layout: fixed; width: 300px">' . $log->details . '</td>';
			$str .= '<td>' . number_format($log->amount, 8) . ' ' . $efund_name . '</td>';
			$str .= '<td>' . number_format($log->conversion_total, 8) . ' ' . $efund_name . '</td>';
			$str .= '<td>' . number_format($log->price, $currency === 'PHP' ? 2 : 8) . ' ' .
				strtoupper($currency) .
				'</td>';
			$str .= '</tr>';
		}

		$str .= '</tbody>
        	</table>';
	}
	else
	{
		$str .= '<hr><p>No ' . settings('ancillaries')->efund_name . ' withdrawals yet.</p>';
	}

	return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function user_efund_convert_transactions($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_efund_conversions c ' .
		'INNER JOIN network_transactions t ' .
		'ON c.transaction_id = t.transaction_id ' .
		'AND t.user_id = ' . $db->quote($user_id) .
		' ORDER BY c.conversion_id DESC'
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
function view_user_efund_convert_logs($user_id): string
{
	$sa = settings('ancillaries');

	$efund_name = $sa->efund_name;

	$currency = $sa->currency;

	$results = user_efund_convert_transactions($user_id);

	$str = '';

	if ($results)
	{
		$str .= '<h1>' . $efund_name . ' Withdrawal Logs</h1>
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

		foreach ($results as $log)
		{
			$str .= '<tr>
                    <td>' . date('M j, Y - g:i A', $log->conversion_date) . '</td>
                    <td>' . $log->details . '</td>
                    <td>' . number_format($log->amount, 8) . ' ' . $efund_name . '</td>
                </tr>';

			$total += $log->amount;
		}

		$str .= '</tbody>
        </table>
        <p><strong>Total ' . $efund_name . ' Withdrawn: </strong>' .
			number_format($total, 8) . ' ' . $efund_name;
	}
	else
	{
		$str .= '<hr><p>No ' . $efund_name . ' withdrawals yet.</p>';
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

	$str .= '<h1>' . settings('ancillaries')->efund_name . ' Withdrawal Logs</h1>';

	if ($usertype === 'Admin' && $admintype === 'Super')
	{
		$str .= view_admin_efund_convert_logs();
	}
	else
	{
		$str .= view_user_efund_convert_logs($user_id);
	}

	return $str;
}