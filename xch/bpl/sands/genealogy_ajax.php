<?php

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;

$parent_id = 1;

echo '<pre>';
echo main($parent_id);
echo '</pre>';

function main($parent_id)
{
	$family = [];

	$parent = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $parent_id]
	);

	$family['parent_id']    = $parent->id;
	$family['username']     = $parent->username;
	$family['account_type'] = $parent->account_type;

	populate($parent_id, $family);

	//return json_encode($family, JSON_PRETTY_PRINT);
	return print_r($family, true);
}

function populate($parent, &$array)
{
	if (count(get_child($parent)))
	{
		foreach (get_child($parent) as $child)
		{
			$array['children'][] = [
				'parent_id'    => $child->id,
				'username'     => $child->username,
				'account_type' => $child->account_type
			];

			populate($child->id, $array['children']);
		}
	}
}

// module test


function get_child($id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users as u ' .
		'INNER JOIN network_binary as b ' .
		'ON u.id = b.id ' .
		'WHERE u.block = :block ' .
		'AND b.upline_id = :upline_id',
		[
			'upline_id' => $id,
			'block'     => 0
		]
	);
}