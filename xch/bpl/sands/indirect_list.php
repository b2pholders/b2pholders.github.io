<?php

// indirect count

namespace Onewayhi\Sand\Indirect_Count;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;

print_r(main(1));

function main($user_id)
{
	$indirects = [];

	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id <> :id',
		['id' => $user_id]
	);

	foreach ($users as $user)
	{
		$direct = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $user->id]
		);

		while ($direct->sponsor_id)
		{
			if ($direct->sponsor_id == $user_id && !in_array($user->id, $indirects))
			{
				array_push($indirects, $user->id);
			}

			$direct = fetch(
				'SELECT * ' .
				'FROM network_users ' .
				'WHERE id = :id',
				['id' => $direct->sponsor_id]
			);
		}
	}

	return $indirects;
}