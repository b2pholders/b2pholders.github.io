<?php

namespace Onewayhi\Mods\Check_Id_Local;

require_once 'bpl/mods/query_local.php';

use function Onewayhi\Database\Local\Query\fetch;

/**
 * @param $id
 *
 * @return mixed
 *
 * @since version
 */
function main($id)
{
	return user($id);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);
}