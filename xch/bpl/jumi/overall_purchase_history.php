<?php

namespace BPL\Jumi\Overall_Purchase_History;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
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
 * @return string
 *
 * @since version
 */
function view_table(): string
{
	$currency = settings('ancillaries')->currency;

	$repeat_purchases = repeat_purchases();

	$str = '<h1>Overall Item Purchase History</h1>';

	if (!empty($repeat_purchases))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Item</th>
                <th>Price (' . $currency . ')</th>
                <th>Quantity</th>
                <th>Reward Points</th>
                <th>Unilevel Points</th>
                <th>Binary Points</th>
                <th>Total (' . $currency . ')</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($repeat_purchases as $purchase)
		{
			$item = items_repeat($purchase->item_id);

			$user = user($purchase->user_id);

			$str .= '<tr>
					<td>' . date('M j, Y g:i A', $purchase->date) . '</td>
					<td><a href="' . sef(44) . qs() . 'uid=' . $user->id . '">' . $user->username . '</a></td>
					<td><a href="' . sef(9) . qs() . 'uid=' . $item->item_id . '" target="_blank">' .
				$item->item_name . '</a></td>
					<td>' . number_format($purchase->price, 8) . '</td>
					<td>' . $purchase->quantity . '</td>
					<td>' . $purchase->reward_points . '</td>
					<td>' . $purchase->unilevel_points . '</td>
					<td>' . $purchase->binary_points . '</td>
					<td>' . number_format($purchase->total_purchases, 8) . '</td>
					<td>' . $purchase->status . '</td>
					<td><a href="' . sef(63) . qs() . 'uid=' . $purchase->repeat_id .
				'" class="uk-button uk-button-primary">Invoice</a>' .
				'</td>
				</tr>';
		}

		$str .= '</tbody>
        	</table>';
	}
	else
	{
		$str .= '<hr><p>No repeat purchases yet.</p>';
	}

	return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function repeat_purchases()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_repeat ' .
		'ORDER BY repeat_id DESC'
	)->loadObjectList();
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