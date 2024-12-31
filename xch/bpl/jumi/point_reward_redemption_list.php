<?php

namespace BPL\Jumi\Point_Reward_Redemption_list;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;
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
	$user_id       = session_get('user_id');
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$merchant_type = session_get('merchant_type');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= view_rewards_history(session_get('user_id'));

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
function rewards_user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_incentive ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' AND status = "Awaiting Delivery"' .
		' ORDER BY incentive_id DESC'
	)->loadObjectList();
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function items_incentive($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
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
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_rewards_history($user_id): string
{
	$rewards = rewards_user($user_id);

	$str = page_reload();

	$str .= '<h1>Token Redeem List</h1>';

	if (!empty($rewards))
	{
		$str .= '<div class="table-responsive">';
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Asset</th>
                <th>Price (usd)</th>
                <th>Qty</th>
                <th>Total (usd)</th>
                <th>Wallet Address</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($rewards as $reward)
		{
			$item = items_incentive($reward->item_id);

			$user = user($reward->user_id);

			$wallet_addr = has_wallet_addr($item->item_name, $user)
				? arr_payment_method($user)[strtolower($item->item_name)] : 'n/a';

			$str .= '<tr>
				<td>' . date('M j, Y g:i A', $reward->date) . '</td>
				<td><a href="' . sef(64) . qs() .
				'uid=' . $item->item_id . '" target="_blank">' .
				$item->item_name . '</a></td>
				<td>' . $reward->price . '</td>
				<td>' . $reward->quantity . '</td>
				<td>' . $reward->total_purchases . '</td>
				<td>' . $wallet_addr . '</td>
				<td>' . ($wallet_addr === 'n/a' ? $reward->status : (
					$reward->status === 'Awaiting Delivery' ? 'Processing' : 'Completed')) . '</td>
			</tr>';
		}

		$str .= '</tbody>
        	</table>';
		$str .= '</div>';
	}
	else
	{
		$str .= '<hr><p>No redemption yet.</p>';
	}

	return $str;
}
