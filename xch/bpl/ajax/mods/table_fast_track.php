<?php

namespace BPL\Ajax\Mods\Table_Fast_Track;

use Exception;

use DateTime;
use DateInterval;

use function BPL\Mods\Local\Database\Query\fetch_all;

use function BPL\Mods\Time_Remaining\main as time_remaining;

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
function user_fast_track_local($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fast_track ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}

/**
 * @param $user_id
 * @param $limit_from
 * @param $limit_to
 *
 * @return array|false
 *
 * @since version
 */
function user_fast_track_limit_local($user_id, $limit_from, $limit_to)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fast_track ' .
		'WHERE user_id = :user_id ' .
		'ORDER BY fast_track_id DESC ' .
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
	$limit_to   = 3;
	$limit_from = $limit_to * $page;

	$efund_name = settings('ancillaries')->efund_name;

	$total = count(user_fast_track_local($user_id));

	$last_page = ($total - $total % $limit_to) / $limit_to;

//	$currency = settings('ancillaries')->currency;

	$si = settings('investment');

	$account_type = user($user_id)->account_type;

	$maturity = $si->{$account_type . '_fast_track_maturity'};

	$results = user_fast_track_limit_local($user_id, $limit_from, $limit_to);

	$str = '';

	if (!empty($results))
	{
		$str .= '<div class="uk-panel uk-panel-box tm-panel-line">';

		if ($total > ($limit_from + $limit_to))
		{
			if ((int) $page !== (int) $last_page)
			{
				$str .= '<span style="float: right"><input type="button" value="Oldest" onclick="paginate_fast_track(' .
					($last_page) . ')" ' . 'class="uk-button uk-button-primary"></span>';
			}

			$str .= '<span style="float: right"><input type="button" value="Previous" onclick="paginate_fast_track(' .
				($page + 1) . ')" ' . 'class="uk-button uk-button-success"></span>';
		}

		if ($page > 0 && $page)
		{
			$str .= '<span style="float: right"><input type="button" value="Next" onclick="paginate_fast_track(' .
				($page - 1) . ')" ' . 'class="uk-button uk-button-success"></span>';

			if ((int) $page !== 1)
			{
				$str .= '<span style="float: right"><input type="button" value="Latest" onclick="paginate_fast_track(' .
					(1) . ')" ' . 'class="uk-button uk-button-primary"></span>';
			}
		}

		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Contract</th>
                    <th>Reward</th>
                    <th>Days</th>
                    <th>Maturity (' . $maturity . ' Days)</th>
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

				$str .= '
	            <tr>';
				$str .= '
	                <td>' . number_format($result->principal, 2) . ' ' . /*$efund_name .*/ '</td>
	                <td>' . number_format($result->value_last, 2) . ' ' . /*$efund_name .*/ '</td>
	                <td>' . $result->day . '</td>
	                <td>' . $start->format('F d, Y') . '</td>
	                <td>' . time_remaining(
						$result->day,
						$result->processing,
						$si->{$account_type . '_fast_track_interval'},
						$maturity
					) . '</td>
	            </tr>';
			}
			catch (Exception $e)
			{
			}
		}

		$str .= '</tbody>
	        </table>
	    </div>';
	}

	echo $str;
}