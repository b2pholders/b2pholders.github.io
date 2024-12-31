<?php

namespace BPL\Ajax\Mods\Profit_Top_Up;

use function BPL\Mods\Local\Database\Query\fetch_all;

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
	$result = user_top_up($user_id);

	$profit = 0;

	foreach ($result as $top_up)
	{
		$profit += $top_up->value_last;
	}

	echo $profit;
}

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