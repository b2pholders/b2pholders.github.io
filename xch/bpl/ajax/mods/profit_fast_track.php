<?php

namespace BPL\Ajax\Mods\Profit_Fast_Track;

use function BPL\Mods\Local\Database\Query\fetch_all;
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
//	$user = user($user_id);
//
//	$interest = $user->fast_track_interest;

	$result = user_fast_track($user_id);

	$profit = 0;

	foreach ($result as $fast_track)
	{
		$profit += $fast_track->value_last;
	}

	echo $profit/* + $interest*/;
}

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function user_fast_track($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fast_track ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}