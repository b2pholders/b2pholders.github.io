<?php

namespace BPL\Mods\Time_Remaining;

use DateTime;
use Exception;

/**
 * @param $day
 * @param $processing
 * @param $interval
 * @param $maturity
 *
 * @return string
 *
 * @throws Exception
 * @since version
 */
function main($day, $processing, $interval, $maturity): string
{
	$remaining = ($processing + $maturity - $day) * $interval;
	$remain_processing = $processing * $interval;
	$remain_maturity = ($maturity - $day) * $interval;

	if ($remaining > $maturity && $processing) {
		$time = '<span style="color: orangered">' . seconds_to_time($remain_processing) . /* ' to Processing' . */ '</span>';
	} elseif ($remain_maturity > 0) {
		$time = '<span style="color: green">' . seconds_to_time($remain_maturity) . /* ' to Maturity' . */ '</span>';
	} else {
		$time = 'Mature';
	}

	return $time;
}

/**
 * @param $seconds
 *
 * @return string
 *
 * @throws Exception
 * @since version
 */
function seconds_to_time($seconds): string
{
	$first = new DateTime('@0');
	$second = new DateTime('@' . $seconds);

	$diff = $second->diff($first);

	// if ($diff->format('%a') > 1) {
	// 	$time_str = '%a days';
	// } else {
	// 	$time_str = '%a day';
	// }

	$time_str = '%a';

	return $diff->format($time_str);
}

