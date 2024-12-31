<?php

// pass-up

namespace Onewayhi\Sand\Passup_Bonus;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

//require_once '../mods/url_sef_local.php';

use Exception;

use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;
use function \Onewayhi\Database\Local\Query\crud;

//use function \Onewayhi\Url\SEF\sef;

//print_r(main(3));

// insert id of the registered user
function main($insert_id)
{
	// first step up

	$result = [];

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $insert_id]
	);

	$sponsor_id = $user ? $user->sponsor_id : 0;

	$sponsored = sponsored($sponsor_id);

	$sponsor = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $sponsor_id]
	);

	if ($sponsored && count($sponsored) == 2)
	{
		// iterate up
		while ($sponsor_id)
		{
			if (count($sponsored) && count($sponsored) == 2)
			{
				// add bonus
				//$result[$sponsor->username] = 200;

				add_bonus(200, $sponsor->username);
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

function add_bonus($amount, $user_id)
{
	$dbh = DB::connect();

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);

	try
	{
		$dbh->beginTransaction();

		crud(
			'UPDATE network_users ' .
			'SET passup_bonus = :passup_bonus ' .
			'WHERE user_id = :user_id',
			[
				'passup_bonus' => ($user->passup_bonus + $amount),
				'user_id'      => $user_id
			]
		);

		$dbh->commit();
	}
	catch (Exception $e)
	{
		try
		{
			$dbh->rollback();
		}
		catch (Exception $e2)
		{
		}
	}
}