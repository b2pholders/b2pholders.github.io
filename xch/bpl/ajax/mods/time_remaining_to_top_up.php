<?php

namespace BPL\Ajax\Mods\Time_Remaining_To_Top_Up;

use Exception;

use function BPL\Mods\Seconds_To_Time\main as seconds_to_time;

use function BPL\Mods\Local\Database\Query\fetch;

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
	$remaining = user_top_up($user_id)->processing - time();

	if ($remaining > 0)
	{
		try
		{
			echo 'Processing in ' . seconds_to_time($remaining);
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
function user_top_up($user_id)
{
	return fetch(
		'SELECT processing ' .
		'FROM network_top_up ' .
		'WHERE user_id = :user_id ' .
		'AND processing > :processing ' .
		'ORDER BY id',
		[
			'user_id'    => $user_id,
			'processing' => 0
		]
	);
}