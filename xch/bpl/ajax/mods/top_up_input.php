<?php

namespace BPL\Ajax\Mods\Top_Up_Input;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_top_up;

$input   = trim(filter_input(INPUT_POST, 'input', FILTER_VALIDATE_FLOAT));
$user_id = trim(filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT));

main($input, $user_id);

/**
 * @param $input
 * @param $user_id
 *
 *
 * @since version
 */
function main($input, $user_id)
{
	header('Content-Type: application/json');

	$return = $_POST;

	$principal = user_top_up($user_id)->principal ?? 0;

	validate_top_up($user_id, $input, $principal, $return);

	echo_json($return);
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
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}