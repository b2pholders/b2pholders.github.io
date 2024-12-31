<?php

namespace BPL\Ajax\Mods\Token\P2P_Trade\Table\Requests_Pending;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Helpers\settings;

$user_id    = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$limit_from = filter_input(INPUT_POST, 'limit_from', FILTER_VALIDATE_INT);
$limit_to   = filter_input(INPUT_POST, 'limit_to', FILTER_VALIDATE_INT);

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
	$wall = 7;
	$fix  = 14;

	$limit_from = $wall * $start_row;
	$limit_to   = $wall;

	$currency = settings('ancillaries')->currency;

	$results = token_trade_buy_complete_limit($limit_from, $limit_to);

	$str = '';

	if (!empty($results))
	{
		$str .= '<div class="uk-panel uk-panel-box uk-text-center">';
		$str .= (count(token_trade_buy_complete()) > ($limit_from + $wall)) ?
			('<input type="button" value="Prev" onclick="paginate_buy(' . ($start_row + 1) . ')" ' .
				'class="uk-panel-badge uk-badge uk-badge-warning" style="margin-right: 17%">') : '';
		$str .= ($start_row > 0) ?
			('<input type="button" value="Next" onclick="paginate_buy(' . ($start_row - 1) . ')" ' .
				'class="uk-panel-badge uk-badge uk-badge-success">') : '';
		$str .= '<h3 class="uk-panel-title" style="padding: 7px 0 0 7px">Buy</h3>
		        <table class="category table table-striped table-bordered table-hover">
		            <thead>
		                <tr>';
//		$str .= '<th>Price (' . $currency . ')</th>';
		$str .= '<th>Price</th>';
		$str .= '<th>Qty (' . settings('trading')->token_name . ')</th>';
//		$str .= '<th>Value (' . $currency . ')</th>';
		$str .= '<th>Value</th>';
		$str .= '</tr>
		            </thead>
		            <tbody>';

		foreach ($results as $result)
		{
			$color = '';

			if (time() - $result->time_post <= $fix)
			{
				$color = ' style="color: red"';
			}

			$str .= '
            <tr';
			$str .= (($result->user_id === $user_id) && (time() - $result->time_post) > $fix) ?
				' style="color: #2b95ee"' : $color;
			$str .= '>
                <td>' . number_format($result->price, 2) . '</td>
                <td>' . number_format($result->amount, 8) . '</td>
                <td>' . number_format($result->amount * $result->price, 2) .
				((($result->user_id === $user_id) && (time() - $result->time_post <= $fix)) ?
					' <input type="button" value="x" onclick="delete_buy(' . $result->id . ')"' .
					' class="uk-badge uk-badge-danger uk-badge-notification" style="float: right">' : '') . '</td>           
            </tr>';
		}

		$str .= '</tbody>
	        </table>
	    </div>';

	}

	echo $str;
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function token_trade_buy_complete()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE time_complete = :time_complete ' .
		'AND order_type = :order_type',
		[
			'time_complete' => 0,
			'order_type'    => 'buy'
		]
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
function token_trade_buy_complete_limit($limit_from, $limit_to)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE time_complete = :time_complete ' .
		'AND order_type = :order_type ' .
		'ORDER BY time_post DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to,
		[
			'time_complete' => 0,
			'order_type'    => 'buy'
		]
	);
}