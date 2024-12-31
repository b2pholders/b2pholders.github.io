<?php

namespace BPL\Jumi\Convert_Efund_Confirmed;

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
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$str .= view_efund_convert_confirmed($usertype, $user_id);

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
function efund_convert_confirmed()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users, ' .
		'network_efund_convert ' .
		'WHERE id = user_id ' .
		'AND date_approved <> 0 ' .
		'ORDER BY convert_id DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_efund_convert_confirmed($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users, ' .
		'network_efund_convert ' .
		'WHERE id = user_id ' .
		'AND date_approved <> 0 ' .
		'AND user_id = ' . $db->quote($user_id) .
		' ORDER BY convert_id DESC'
	)->loadObjectList();
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_admin_efund_convert_confirmed(): string
{
	$sa = settings('ancillaries');

	$efund_name = $sa->efund_name;

	$results = efund_convert_confirmed();

	$str = '';

	if (!empty($results))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Username</th>                
                <th>Amount</th>
                <th>Final</th>                
            </tr>
            </thead>
            <tbody>';

		foreach ($results as $result)
		{
			$currency = in_array($result->method, ['bank', 'gcash']) ? 'PHP' : $result->method;

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $result->date_posted) . '</td>';
			$str .= '<td><a href="' . sef(44) . qs() . 'uid=' . $result->id . '">' .
				$result->username . '</a>' . '</td>';
			$str .= '<td>' . number_format($result->amount, 8) .
				' ' . settings('ancillaries')->efund_name . '</td>';
			$str .= '<td>' . number_format($result->price, $currency === 'PHP' ? 2 : 8) . ' ' .
				strtoupper($currency) .
				'</td>';
			$str .= '</tr>';
		}

		$str .= '</tbody>';
		$str .= '</table>';
	}
	else
	{
		$str .= '<hr><p>No ' . $efund_name . ' withdrawals yet.</p>';
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
function view_user_efund_convert_confirmed($user_id): string
{
	$results = user_efund_convert_confirmed($user_id);

	$str = '';

	if ($results)
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($results as $result)
		{
			$str .= '<tr>
                <td>' . date('M j, Y - g:i A', $result->date_approved) . '</td>
                <td>' . number_format($result->amount, 2) . '</td>
            </tr>';
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
 * @param $usertype
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_efund_convert_confirmed($usertype, $user_id): string
{
	$str = page_reload();

	$str .= '<h1>' . settings('ancillaries')->efund_name . ' Withdrawal History</h1>';

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$str .= view_admin_efund_convert_confirmed();
	}
	else
	{
		$str .= view_user_efund_convert_confirmed($user_id);
	}

	return $str;
}