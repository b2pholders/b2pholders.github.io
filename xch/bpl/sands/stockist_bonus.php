<?php

// mobile stockist

namespace Onewayhi\Sand\Mobile_Stockist;

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
		'WHERE account_type <> :account_type',
		['account_type' => 'starter']
	);

	foreach ($users as $user)
	{
		// regular matches mobile stockist
		if ($user->account_type == 'regular')
		{
			add_bonus(($price * 3 / 100 / count(all_mobile_stockist())), $user->id);
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
			'stockist_bonus = :stockist_bonus ' .
			'WHERE id = :id',
			[
				'balance'        => ($user->balance + $amount),
				'stockist_bonus' => ($user->stockist_bonus + $amount),
				'id'             => $user_id
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

function all_mobile_stockist()
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
		if ($user->account_type == 'regular')
		{
			array_push($result, $user->id);
		}
	}

	return $result;
}