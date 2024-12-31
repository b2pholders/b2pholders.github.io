<?php

// upline support

namespace Onewayhi\Sand\Upline_Support;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use Exception;

use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;
use function \Onewayhi\Database\Local\Query\crud;

// amount: user income
// user_id: user id
function main($amount, $level, $user_id)
{
	$cut = [
		1 => 5,
		2 => 3,
		3 => 2
	];

	$level1 = level([$user_id])[0];

	foreach ($level1 as $direct)
	{
		add_bonus($amount * $cut[1] / 100 / count($level1), $direct);
	}

	for ($i_i = 2; $i_i <= $level; $i_i++)
	{
		foreach (nested($i_i, $level1)[0] as $user)
		{
			add_bonus($amount * $cut[$i_i] / 100 / count(nested($i_i, $level1)[0]), $user);
		}
	}

	$percent_sum = 0;

	foreach ($cut as $key => $value)
	{
		$percent_sum += $value;
	}

	return $amount * (1 - $percent_sum / 100);
}

function level($lvl_1 = [])
{
	$lvl_2 = [];

	if (!empty($lvl_1))
	{
		foreach ($lvl_1 as $sponsor1)
		{
			$result = fetch_all(
				'SELECT * ' .
				'FROM network_users ' .
				'WHERE account_type <> :account_type ' .
				'AND sponsor_id = :sponsor_id',
				[
					'account_type' => 'starter',
					'sponsor_id'   => $sponsor1
				]
			);

			if ($result)
			{
				foreach ($result as $sponsor2)
				{
					array_push($lvl_2, $sponsor2->id);
				}
			}
		}
	}

	return [$lvl_2];
}

function nested($n, $level_1)
{
	$result = [$level_1];

	for ($i_i = 2; $i_i <= $n; $i_i++)
	{
		$result[] = level(array_reverse($result)[0][0]);
	}

	return array_reverse($result)[0];
}

function add_bonus($amount, $id)
{
	$dbh = DB::connect();

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $id]
	);

	try
	{
		$dbh->beginTransaction();

		crud(
			'UPDATE network_users ' .
			'SET upline_support = :upline_support, ' .
			'balance = :balance ' .
			'WHERE user_id = :user_id',
			[
				'upline_support' => ($user->upline_support + $amount),
				'balance'        => ($user->balance + $amount),
				'user_id'        => $id
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