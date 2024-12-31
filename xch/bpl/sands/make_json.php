<?php

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;

$id_user = 1;

$head = fetch(
	'SELECT * ' .
	'FROM network_users ' .
	'WHERE id = :id',
	['id' => $id_user]
);

echo '<pre>';

echo '{';
echo '"name":"' . $head->username . '",';
echo '"account":"' . $head->account_type . '"';

if (count(get_child($id_user)))
{
	echo ',"children":[';
	make_json($id_user);
	echo ']';
}

echo '}';

echo '</pre>';

function make_json($parent)
{
	$children = get_child($parent);

	if (count($children))
	{
		foreach ($children as $child)
		{
			echo array_search($child, $children) > 0 ? ',{' : '{';
			echo '"name":"' . $child->username . '",';
			echo '"account":"' . $child->account_type . '"';

			if (count(get_child($child->id)))
			{
				echo ',"children":[';
				make_json($child->id);
				echo ']';
			}

			echo '}';
		}
	}
}

function get_child($id)
{
	$sth = fetch_all(
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

	return $sth;
}