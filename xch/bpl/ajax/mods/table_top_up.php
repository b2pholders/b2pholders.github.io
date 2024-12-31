<?php

namespace BPL\Ajax\Mods\Table_Top_Up;

use Exception;
use DateTime;
use DateInterval;

use function BPL\Mods\Local\Database\Query\fetch_all;

use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Local\Url_SEF\sef;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$page    = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);

main($user_id, $page);

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function user_top_up($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}

/**'
 * @param $user_id
 * @param $limit_from
 * @param $limit_to
 *
 * @return array|false
 *
 * @since version
 */
function user_top_up_limit($user_id, $limit_from, $limit_to)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = :user_id ' .
		'ORDER BY id DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to,
		['user_id' => $user_id]
	);
}

/**
 * @param $user_id
 * @param $page
 *
 *
 * @since version
 */
function main($user_id, $page)
{
	$output = '';

	$limit_to   = 3;
	$limit_from = $limit_to * $page;

	$total = count(user_top_up($user_id));

	$last_page = ($total - $total % $limit_to) / $limit_to;

	$currency = settings('ancillaries')->currency;

	$settings_investment = settings('investment');

	$account_type = user($user_id)->account_type;

	$interval = $settings_investment->{$account_type . '_top_up_interval'};
	$maturity = $settings_investment->{$account_type . '_top_up_maturity'};

	$results = user_top_up_limit($user_id, $limit_from, $limit_to);

	if (!empty($results))
	{
		$output .= '
    		<div class="uk-panel uk-panel-box tm-panel-line">';

		if ($total > ($limit_from + $limit_to))
		{
			if ($page !== $last_page)
			{
				$output .= '<span style="float: right"><input type="button" value="Oldest" onclick="paginate_top_up(' .
					($last_page) . ')" ' . 'class="uk-button uk-button-primary"></span>';
			}

			$output .= '<span style="float: right"><input type="button" value="Previous" onclick="paginate_top_up(' .
				($page + 1) . ')" ' . 'class="uk-button uk-button-success"></span>';
		}

		if ($page > 0 && $page)
		{
			$output .= '<span style="float: right"><input type="button" value="Next" onclick="paginate_top_up(' .
				($page - 1) . ')" ' . 'class="uk-button uk-button-success"></span>';

			if ((int) $page !== 1)
			{
				$output .= '<span style="float: right"><input type="button" value="Latest" onclick="paginate_top_up(' .
					(1) . ')" ' . 'class="uk-button uk-button-primary"></span>';
			}
		}

		$output .= '<span style="float: left"><a href="' . sef(104) .
			'" class="uk-button uk-button-success">Deposit</a></span>';

		$output .= '
			<table class="category table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Timeshare Value (' . $currency . ')</th>
                    <th>Current Value (' . $currency . ')</th>
                    <th>Running Days</th>
                    <th>Maturity Date (' . $maturity . ' Days)</th>
                    <th>Status</th>     
                </tr>
            </thead>
            <tbody>';

		foreach ($results as $result)
		{
			try
			{
				$start = new DateTime('@' . $result->date_entry);
				$end   = new DateInterval('P' . $maturity . 'D');

				$start->add($end);

				$output .= '
            	<tr>';
				$output .= '
		                <td>' . number_format($result->principal, 2) . '</td>
		                <td>' . number_format($result->value_last, 2) . '</td>
		                <td>' . $result->day . '</td>
		                <td>' . $start->format('F d, Y') . '</td>
		                <td>' . time_remaining($result->day, $result->processing, $interval, $maturity) .
					'</td>
	            </tr>';
			}
			catch (Exception $e)
			{
			}
		}

		$output .= '</tbody>
	        </table>
	    </div>';
	}

	echo $output;
}