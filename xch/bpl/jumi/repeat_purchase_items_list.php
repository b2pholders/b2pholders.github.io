<?php

namespace BPL\Jumi\Repeat_Purchase_Items_List;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

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
	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');
	$username      = session_get('username');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	if ($usertype !== '')
	{
		$results = user_repeat(session_get('user_id'));

		$str .= '<h1>Purchased History</h1>';

		if (!empty($results))
		{
			$str .= view_items_list($results);
		}
		else
		{
			$str .= '<hr><p>No items purchased yet.</p>';
		}
	}

	echo $str;
}

/**
 * @param $results
 *
 * @return string
 *
 * @since version
 */
function view_items_list($results): string
{
	$sp = settings('plans');

	$currency = settings('ancillaries')->currency;

	$str = '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Item</th>';
	$str .= !$sp->unilevel ? '' : '<th>UP (pts)</th>';
	$str .= '<th>RP (pts)</th>
                <th>Price (' . $currency . ')</th>
                <th>Quantity</th>
                <th>Total (' . $currency . ')</th>';
	$str .= ($sp->redundant_binary ? '<th>Group</th>' : '');
	$str .= '<th>Status</th>
            </tr>
            </thead>
            <tbody>';

	foreach ($results as $log)
	{
		$item = items_repeat($log->item_id);

		$str .= '<tr>
			<td>' . date('M j, Y g:i A', $log->date) . '</td>
			<td>' . $item->item_name . '</a></td>';
		$str .=!$sp->unilevel ? '' : '<td>' . $log->unilevel_points . '</td>';
		$str .= '<td>' . $log->reward_points . '</td>
			<td>' . number_format($log->price, 8) . '</td>
			<td>' . $log->quantity . '</td>
			<td>' . number_format($log->total_purchases, 8) . ((int) $sp->redundant_binary ? ('</td>
			<td>' . $log->position) : '') .
			'</td>
			<td>' . $log->status . '</td>
		</tr>';
	}

	$str .= '</tbody>
        </table>';

	return $str;
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function items_repeat($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_repeat ' .
		'WHERE item_id = ' . $db->quote($item_id)
	)->loadObject();
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
function user_repeat($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_repeat ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' ORDER BY repeat_id DESC'
	)->loadObjectList();
}