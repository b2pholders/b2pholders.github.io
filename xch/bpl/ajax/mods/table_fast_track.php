<?php

namespace BPL\Ajax\Mods\Table_Fast_Track;

use DateTime;
use DateInterval;

use function BPL\Mods\Local\Database\Query\fetch_all;

use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\pgn8Ajax;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);

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
		'WHERE user_id = :user_id ' .
		'ORDER BY fast_track_id DESC',
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
	$user_fast_tracks = user_fast_track_local($user_id);

	$si = settings('investment');

	$account_type = user($user_id)->account_type;

	$interval = $si->{$account_type . '_fast_track_interval'};
	$maturity = $si->{$account_type . '_fast_track_maturity'};

	$pagination = pgn8Ajax($user_fast_tracks, $page);

	$offset = $pagination['offset'];
	$limit = $pagination['limit'];
	$nav_pg = $pagination['html'];

	$paginated_fast_tracks = array_slice($user_fast_tracks, $offset, $limit, true);

	$str = '';

	if (!empty($paginated_fast_tracks)) {
		$str .= <<<HTML
        <div class="card-container">
            <div class="table-responsive" style="background: white">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th style="text-align: center;"><h4>Initial</h4></th>
                            <th style="text-align: center;"><h4>Accumulated</h4></th>
                            <th style="text-align: center;"><h4>Running Days</h4></th>
                            <th style="text-align: center;"><h4>Maturity Date ($maturity days)</h4></th>
                            <th style="text-align: center;"><h4>Status</h4></th>
                        </tr>
                    </thead>
                    <tbody>
        HTML;

		foreach ($paginated_fast_tracks as $fs) {
			$start = new DateTime('@' . $fs->date_entry);
			$end = new DateInterval('P' . $maturity . 'D');

			$start->add($end);

			$starting_value = number_format($fs->principal, 2);
			$current_value = number_format($fs->value_last, 2);
			$maturity_date = $start->format('F d, Y');
			$status = time_remaining($fs->day, $fs->processing, $interval, $maturity);

			$remaining = ($fs->processing + $maturity - $fs->day) * $interval;
			$remain_maturity = ($maturity - $fs->day) * $interval;

			$type_day = '';

			if ($remaining > $maturity && $fs->processing) {
				$type_day = 'Days for Processing: ';
			} elseif ($remain_maturity > 0) {
				$type_day = 'Days Remaining: ';
			}

			$str .= <<<HTML
                <tr>
                    <td style="text-align: center;">{$starting_value}</td>
                    <td style="text-align: center;">{$current_value}</td>
                    <td style="text-align: center;">{$fs->day}</td>
                    <td style="text-align: center;">{$maturity_date}</td>
                    <td style="text-align: center;">{$type_day}{$status}</td>
                </tr>
            HTML;
		}

		$str .= <<<HTML
            <tr style="visibility: hidden;">
                <td colspan="5"></td>
            </tr>
        HTML;

		$str .= <<<HTML
            </tbody>
        </table>
        </div>
        HTML;

		$str .= $nav_pg;

		$str .= <<<HTML
            </div>
        HTML;
	}

	echo $str;
}