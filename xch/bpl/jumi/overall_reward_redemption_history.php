<?php

namespace BPL\Jumi\Overall_Reward_Redemption_History;

require_once 'bpl/menu.php';
require_once 'bpl/mods/url_sef.php';

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
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
	$usertype = session_get('usertype');

	page_validate();

	$str = menu();

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$str .= page_reload();
		$str .= view_table();
	}

	echo $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function incentives()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_incentive ' .
		'ORDER BY incentive_id DESC'
	)->loadObjectList();
}

/**
 * @param $item_id
 *
 *
 * @return mixed|null
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

/**
 *
 * @return string
 *
 * @since version
 */
function view_table(): string
{
	$rewards = incentives();

	$str = '<h1>Overall Token Redeem List</h1>';

	if (!empty($rewards))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Item</th>
                <th>Price (usd)</th>
                <th>Quantity</th>
                <th>Total (usd)</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($rewards as $reward)
		{
			$item = items_incentive($reward->item_id);

			$user = user($reward->user_id);

			$str .= '<tr>
				<td>' . date('M j, Y g:i A', $reward->date) . '</td>
				<td><a href="' . sef(44) . qs() . 'uid=' .
				$user->id . '">' . $user->username . '</a></td>
				<td><a href="' . sef(64) . qs() . 'uid=' .
				$item->item_id . '" target="_blank">' .
				$item->item_name . '</a></td>
				<td>' . $reward->price . '</td>
				<td>' . $reward->quantity . '</td>
				<td>' . number_format($reward->total_purchases) . '</td>
				<td>' . ($reward->status === 'Awaiting Delivery' ? 'Processing' : 'Completed') . '</td>
			</tr>';
		}

		$str .= '</tbody>
        	</table>';
	}
	else
	{
		$str .= '<hr><p>No redemption yet.</p>';
	}

	return $str;
}