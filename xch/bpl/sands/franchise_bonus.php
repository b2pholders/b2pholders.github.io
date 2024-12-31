<?php

// franchise

namespace Onewayhi\Sand\Franchise_Bonus;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use Exception;

use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;
use function \Onewayhi\Database\Local\Query\crud;

function main($price)
{
	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account',
		['account_type' => 'starter']
	);

	foreach ($users as $user)
	{
		// regular matches mobile stockist
		if ($user->account_type == 'executive')
		{
			add_bonus(($price * 5 / 100 / count(all_franchise())), $user->id);
		}
	}
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
			'SET balance = :balance, ' .
			'franchise_bonus = :franchise_bonus ' .
			'WHERE user_id = :user_id',
			[
				'balance'         => ($user->balance + $amount),
				'franchise_bonus' => ($user->stockist_bonus + $amount),
				'user_id'         => $user_id
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

function all_franchise()
{
	$result = [];

	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type',
		['account_type' => 'starter']
	);

	foreach ($users as $user)
	{
		if ($user->account_type == 'executive')
		{
			array_push($result, $user->id);
		}
	}

	return $result;
}