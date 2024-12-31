<?php

namespace BPL\Ajax\Mods\Token\Trade\Table\Buy;

require_once 'components_table_trade.php';

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Ajax\Mods\Token\Trade\Table\Components\paginate as pg_frame;
use function BPL\Ajax\Mods\Token\Trade\Table\Components\table_head_mkt as head_frame;
use function BPL\Ajax\Mods\Token\Trade\Table\Components\table_row_mkt as row_frame;

$start_row = filter_input(INPUT_POST, 'start_row', FILTER_VALIDATE_INT);
$user_id   = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($user_id, $start_row);

/**
 * @param $user_id
 * @param $start_row
 *
 *
 * @since version
 */
function main($user_id, $start_row)
{
	$rows         = 5;
	$grace_period = 33; // seconds

	$limit_from = $rows * $start_row;

	$list_tot     = trade_buy($user_id);
	$list_tot_lim = trade_buy_limit($limit_from, $rows, $user_id);

	$str = '';

	if (!empty($list_tot_lim))
	{
		$str .= '<div class="uk-panel uk-panel-box uk-text-left">';
		$str .= '<h3 class="uk-panel-title" style="padding: 7px 0 0 7px">Buy</h3>';
		$str .= paginate_buy($list_tot, $rows, $start_row);
		$str = head_frame($str);

		foreach ($list_tot_lim as $result)
		{
			$color  = ' style="color: #2b95ee"';
			$button = '';

			if ((int) $result->user_id === (int) $user_id && (time() - $result->time_post) <= $grace_period)
			{
				$delete = ' onclick="delete_buy(' . $result->id . ')"';

				$color  = ' style="color: red"';
				$button = ' <input type="button" value="x"' . $delete .
					' class="uk-badge uk-badge-danger uk-badge-notification" style="float: right; font-size: smaller">';
			}

			$str = row_frame($result, $color, $str, $button);
		}

		$str .= '</tbody>';
		$str .= '</table>';
		$str .= '</div>';
	}

	echo $str;
}

/**
 * @param $total
 * @param $rows
 * @param $start_row
 *
 * @return string
 *
 * @since version
 */
function paginate_buy($total, $rows, $start_row): string
{
	$count_total = count($total);

	$oldest_page = ($count_total - $count_total % $rows) / $rows;

	$pg_oldest = ' onclick="paginate_buy(' . $oldest_page . ')"';
	$pg_prev   = ' onclick="paginate_buy(' . ($start_row + 1) . ')"';
	$pg_next   = ' onclick="paginate_buy(' . ($start_row - 1) . ')"';
	$pg_latest = ' onclick="paginate_buy(0)"';

	return pg_frame($pg_latest, $pg_next, $pg_prev, $pg_oldest, $total, $rows, $start_row);
}

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function trade_buy($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE time_complete = :time_complete ' .
		'AND user_id <> :user_id ' .
		'AND order_type = :order_type',
		[
			'time_complete' => 0,
			'order_type'    => 'buy',
			'user_id'       => $user_id
		]
	);
}

/**
 * @param $limit_from
 * @param $limit_to
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function trade_buy_limit($limit_from, $limit_to, $user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE time_complete = :time_complete ' .
		'AND user_id <> :user_id ' .
		'AND order_type = :order_type ' .
		'ORDER BY time_post DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to,
		[
			'time_complete' => 0,
			'order_type'    => 'buy',
			'user_id'       => $user_id
		]
	);
}