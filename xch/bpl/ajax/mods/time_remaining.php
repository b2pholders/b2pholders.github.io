<?php

namespace BPL\Ajax\Mods\Time_Remaining;

use DateTime;
use Exception;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($user_id);

/**
 * @param $user_id
 *
 *
 * @since version
 */
function main($user_id)
{
	$settings_investment = settings('investment');

	$account_type = user($user_id)->account_type;

	$interval = $settings_investment->{$account_type . '_interval'};
	$maturity = $settings_investment->{$account_type . '_maturity'};

	$user_compound = user_compound($user_id);

	$time_last = $user_compound->time_last;
	$day       = $user_compound->day;

	$remaining = $interval - (time() - $time_last);

	if ($remaining > 0)
	{
		try
		{
			echo seconds_to_time($remaining) . '<br>' . $day . '/' . $maturity . ' To Maturity';
		}
		catch (Exception $e)
		{
		}
	}
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
	$dt_f = new DateTime('@0');
	$dt_t = new DateTime('@' . $seconds);

	if ($seconds >= (48 * 3600))
	{
		$time_str = '%a days %h hours %i minutes %s seconds';
	}
	elseif ($seconds >= (2 * 3600))
	{
		$time_str = '%h hours %i minutes %s seconds';
	}
	else
	{
		$time_str = '%h hour %i minutes %s seconds';
	}

	return $dt_f->diff($dt_t)->format($time_str);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_compound($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_compound ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}