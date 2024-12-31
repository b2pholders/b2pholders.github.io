<?php

namespace BPL\Mods\Seconds_To_Time;

use DateTime;
use Exception;

/**
 * @param $seconds
 *
 * @return string
 *
 * @throws Exception
 * @since version
 */
function main($seconds): string
{
	$dt_f = new DateTime('@0');
	$dt_t = new DateTime('@' . $seconds);

	if ($seconds >= (48 * 3600))
	{
		$time_str = '%a days %h hrs %i mins %s secs';
	}
	elseif ($seconds >= (24 * 3600) && $seconds < (48 * 3600))
	{
		$time_str = '%a day %h hr %i mins %s secs';
	}
	elseif ($seconds >= (2 * 3600))
	{
		$time_str = '%h hrs %i mins %s secs';
	}
	else
	{
		$time_str = '%h hr %i min %s sec';
	}

	return $dt_f->diff($dt_t)->format($time_str);
}