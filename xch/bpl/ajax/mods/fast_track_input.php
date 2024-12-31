<?php

namespace BPL\Ajax\Mods\Fast_Track_Input;

use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_fast_track;

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

	validate_fast_track($input, $user_id, $return);

	echo_json($return);
}