<?php

namespace BPL\Ajax\Mods\Code_Validate;

use function BPL\Mods\Local\Helpers\echo_json;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

$code_type = [
	'chairman',
	'executive',
	'regular',
	'associate',
	'basic',
	'starter',
	'chairman_cd',
	'executive_cd',
	'regular_cd',
	'associate_cd',
	'basic_cd',
	'starter_cd'
];

$type  = in_array($_POST['type'], $code_type, true) ? $_POST['type'] : 'none';
$count = (!empty($_POST['count']) && ($_POST['count'] <= 100)) ? $_POST['count'] : 0;

main($user_id, $type, $count);

/**
 * @param $user_id
 * @param $type
 * @param $count
 *
 *
 * @since version
 */
function main($user_id, $type, $count)
{
	$return            = $_POST;
	$return['user_id'] = $user_id;

	if (empty($count))
	{
		$return['error_number_codes'] = 'Please select number!';

		echo_json($return);
	}

	if ($type === 'none')
	{
		$return['error_code_type'] = 'Please select type!';

		echo_json($return);
	}

	echo_json($return);
}