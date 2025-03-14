<?php

namespace BPL\Jumi\Request_Efund_Confirmed;

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

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$user_id       = session_get('user_id');
	$merchant_type = session_get('merchant_type');
	$username      = session_get('username');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= view_efund_request_confirmed($usertype, $user_id);

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
function efund_request_confirmed()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, ' .
		'network_efund_request r ' .
		'WHERE u.id = r.user_id ' .
		'AND r.date_confirmed <> ' . $db->quote(0) .
		' ORDER BY r.request_id DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_efund_request_confirmed($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, ' .
		'network_efund_request r ' .
		'WHERE u.id = r.user_id ' .
		'AND r.date_confirmed <> ' . $db->quote(0) .
		' AND r.user_id = ' . $db->quote($user_id) .
		' ORDER BY r.request_id DESC'
	)->loadObjectList();
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_admin_efund_request_confirmed(): string
{
//	$currency = settings('ancillaries')->currency;

	$sa         = settings('ancillaries');
	$efund_name = $sa->efund_name;

	$result = efund_request_confirmed();

	$str = '';

	if (!empty($result))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date Requested</th>
                <th>Username</th>
                <th>Balance</th>
                <th>Amount</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($result as $member)
		{
			$str .= '<tr>
                <td>' . date('M j, Y - g:i A', $member->date_requested) . '</td>
                <td><a href="' . sef(44) . qs() . 'uid=' . $member->id . '">' .
				$member->username . '</a>' . '</td>
                <td>' . number_format($member->payout_transfer, 8) . ' ' . $efund_name . '</td>
                <td>' . number_format($member->amount, 8) . ' ' . $efund_name . '</td>
                <td>' . number_format($member->price, 8) . ' ' . strtoupper($member->method) . '</td>
            </tr>';
		}

		$str .= '</tbody>
        </table>';
	}
	else
	{
		$str .= '<hr><p>No ' . $efund_name . ' requests yet.</p>';
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
function view_user_efund_request_confirmed($user_id): string
{
	$result = user_efund_request_confirmed($user_id);

	$str = '';

	if ($result)
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date Requested</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($result as $member)
		{
			$str .= '<tr>
                <td>' . date('M j, Y - g:i A', $member->date_confirmed) . '</td>
                <td>' . number_format($member->amount, 2) . '</td>
                <td>Completed</td>
            </tr>';
		}

		$str .= '</tbody>
        	</table>';
	}
	else
	{
		$str .= '<hr><p>No ' . settings('ancillaries')->efund_name . ' requests yet.</p>';
	}

	return $str;
}

/**
 *
 * @param $usertype
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_efund_request_confirmed($usertype, $user_id): string
{
	$str = page_reload();

	$str .= '<h1> ' . settings('ancillaries')->efund_name . ' Transactions</h1>';

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$str .= view_admin_efund_request_confirmed();
	}
	else
	{
		$str .= view_user_efund_request_confirmed($user_id);
	}

	return $str;
}