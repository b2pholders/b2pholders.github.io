<?php

namespace BPL\Jumi\Purchase_Items_Confirm;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;

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

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid = input_get('uid');

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ($uid === '')
		{
			$str .= view_purchases();
		}
		else
		{
			process_confirm($user_id, $uid);
		}
	}

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function header(): string
{
	return '<h1>Pending Item Purchases</h1>
        <p>Confirm delivery of purchases here.</p>';
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $user_id
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $user_id, $username): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function process_confirm($user_id, $uid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		repeat_purchase($uid);

		logs($user_id, $uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	$err = 'Item delivery confirmed.';

	application()->redirect(Uri::root(true) . '/' . sef(62), $err, 'notice');
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function logs($user_id, $uid)
{
	$db = db();

	$purchases = user_repeat_purchase($uid);

	$item = item($purchases->item_id);

	$activity = '<b>Item Delivery Confirmation: </b>' . $item->item_name . ' by <a href="' .
		sef(44) . qs() . 'uid=' . $purchases->user_id . '">' . $purchases->username . '</a>.';

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
			$db->quote(1),
			$db->quote(1),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function user_repeat_purchase($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_repeat r ' .
		'WHERE u.id = r.user_id ' .
		'AND r.repeat_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function repeat_purchase($uid)
{
	$db = db();

	update(
		'network_repeat',
		['status = ' . $db->quote('Delivered')],
		['repeat_id = ' . $db->quote($uid)]
	);
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function purchase_pending()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_repeat ' .
		'WHERE status = ' . $db->quote('Awaiting Delivery') .
		' ORDER BY repeat_id DESC'
	)->loadObjectList();
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function item($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_repeat ' .
		'WHERE item_id = ' . $db->quote($item_id)
	)->loadObject();
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function has_wallet_addr($item_name, $user): bool
{
	$arr = arr_payment_method($user);

	if ($arr)
	{
		foreach ($arr as $k => $v)
		{
			if (strtolower($item_name) === $k)
			{
				return true;
			}
		}
	}

	return false;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_purchases(): string
{
	$purchases = purchase_pending();

	$str = header();

	if (!empty($purchases))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Price (' . settings('ancillaries')->currency . ')</th>
                    <th>Reward Points</th>
                    <th>Unilevel Points</th>
                    <th>Binary Points</th>
                    <th>Wallet Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';

		foreach ($purchases as $purchase)
		{
			$item = item($purchase->item_id);

			$user = user($purchase->user_id);

			$wallet_addr = has_wallet_addr($item->item_name, $user)
				? arr_payment_method($user)[strtolower($item->item_name)] : 'n/a';

			$str .= '<tr>
					<td>' . date('M j, Y g:i A', $purchase->date) . '</td>
					<td><a href="' . sef(44) . qs() . 'uid=' . $item->item_id . '" target="_blank">' .
				$item->item_name . '</a></td>
					<td>' . number_format($purchase->price, 8) . '</td>
					<td>' . $purchase->reward_points . '</td>
					<td>' . $purchase->unilevel_points . '</td>
					<td>' . $purchase->binary_points . '</td>
					<td>' . $wallet_addr . '</td>
					<td>' . $purchase->status . '</td>
					<td><a href="' . sef(62) . qs() . 'uid=' . $purchase->repeat_id .
				'" class="uk-button uk-button-primary">Confirm</a></td>
				</tr>';
		}

		$str .= '</tbody>
            </table>';
	}
	else
	{
		$str .= '<hr><p>No pending item purchases.</p>';
	}

	return $str;
}