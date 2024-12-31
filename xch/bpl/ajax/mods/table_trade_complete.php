<?php

namespace BPL\Ajax\Mods\Token\Trade\Table\Complete;

require_once 'components_table_trade.php';

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Ajax\Mods\Token\Trade\Table\Components\paginate as pg_frame;
use function BPL\Mods\Local\Helpers\settings;

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
	$grace_period = 33000;

	$limit_from = $rows * $start_row;

	$list_tot     = trade_complete();
	$list_tot_lim = trade_complete_limit($limit_from, $rows);

	$str = '';

	if (!empty($list_tot_lim))
	{
		$str .= '<div class="uk-panel uk-panel-box uk-text-left">';
		$str .= '<h3 class="uk-panel-title" style="padding: 7px 0 0 7px">Completed</h3>';
		$str .= paginate_complete($list_tot, $rows, $start_row);
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Price</th>';
		$str .= '<th>Qty (' . settings('trading')->token_name . ')</th>';
		$str .= '<th>Trx</th>';
		$str .= '<th>Time</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($list_tot_lim as $result)
		{
			$color = ' style="color: #2b95ee"';

			if ((int) $result->user_id === (int) $user_id && (time() - $result->time_post) <= $grace_period)
			{
				$color = ' style="color: red"';
			}

			$str .= '<tr' . $color . '>';
			$str .= '<td>' . $result->price . '</td>';
			$str .= '<td>' . $result->amount . '</td>';
			$str .= '<td>' . $result->order_type . '</td>';
			$str .= '<td>' . date('Y-m-d H:i:s', $result->time_complete) . '</td>';
			$str .= '</tr>';
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
function paginate_complete($total, $rows, $start_row): string
{
	$count_total = count($total);

	$oldest_page = ($count_total - $count_total % $rows) / $rows;

	$pg_oldest = ' onclick="paginate_complete(' . $oldest_page . ')"';
	$pg_prev   = ' onclick="paginate_complete(' . ($start_row + 1) . ')"';
	$pg_next   = ' onclick="paginate_complete(' . ($start_row - 1) . ')"';
	$pg_latest = ' onclick="paginate_complete(0)"';

	return pg_frame($pg_latest, $pg_next, $pg_prev, $pg_oldest, $total, $rows, $start_row);
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function trade_complete()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE time_complete > :time_complete',
		['time_complete' => 0]
	);
}

/**
 * @param $limit_from
 * @param $limit_to
 *
 * @return array|false
 *
 * @since version
 */
function trade_complete_limit($limit_from, $limit_to)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE time_complete > :time_complete ' .
		'ORDER BY time_post DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to,
		['time_complete' => 0]
	);
}