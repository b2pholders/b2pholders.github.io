<?php

// inidirect referral infinite

namespace Onewayhi\Sand\Indirect_Count;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;

print_r(main(4));

function main($insert_id)
{
	$settings = [
		'basic'     => 10,
		'associate' => 20
	];

	$result = [];

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $insert_id]
	);

	$bonus = $settings[$user->account_type];

	$sponsor_id = $user ? $user->sponsor_id : 0;

	$sponsored = sponsored($sponsor_id);

	$sponsor = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $sponsor_id]
	);

	while ($sponsor_id)
	{
		// test for minimum requirements
		if ($sponsored && count($sponsored) >= 2)
		{
			$result[$sponsor->username] = $bonus;
		}

		$user = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $sponsor_id]
		);

		$sponsor_id = $user ? $user->sponsor_id : 0;

		$sponsored = sponsored($sponsor_id);

		$sponsor = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $sponsor_id]
		);
	}

	return $result;
}

function sponsored($id)
{
	// get all the sponsor directs
	$directs = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type ' .
		'AND sponsor_id = :sponsor_id',
		[
			'account_type' => 'starter',
			'sponsor_id'   => $id
		]
	);

	// repository for first step directs
	$sponsored = [];

	foreach ($directs as $direct)
	{
		// collect all direct id
		array_push($sponsored, $direct->id);
	}

	return $sponsored;
}