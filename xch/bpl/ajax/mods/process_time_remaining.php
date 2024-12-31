<?php

namespace BPL\Ajax\Mods\Process_Time_Remaining;

use Exception;

use function BPL\Mods\Seconds_To_Time\main as seconds_to_time;
use function BPL\Mods\Local\Database\Query\fetch;
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
	$user_compound = user_compound($user_id);

	$remaining = user($user_id)->date_registered + $user_compound['processing'] * 86400 - time();

	if ($remaining > 0)
	{
		try
		{
			echo seconds_to_time($remaining) . ' to Processing!';
		}
		catch (Exception $e)
		{

		}
	}
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