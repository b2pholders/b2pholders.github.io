<?php

// elite group

namespace Onewayhi\Sand\Elite_Group;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use Exception;

use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;
use function \Onewayhi\Database\Local\Query\crud;

// zero the insert_id to take price
// zero the price to take user_id
function main($insert_id, $price)
{
	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account',
		['account_type' => 'starter']
	);

	if ($insert_id > 0 && $price == 0)
	{
		// get entry account_type
		$entry_user = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $insert_id]
		);

		foreach ($users as $user)
		{
			entry_elite_bonus($entry_user->account_type, $user->id);
		}
	}
	elseif ($insert_id == 0 && $price > 0)
	{
		foreach ($users as $user)
		{
			repeat_purchase_elite_bonus($price, $user->id);
		}
	}
}

// user_id for all users
// account_type for user just registered
function entry_elite_bonus($account_type, $user_id)
{
	if (on_elite_maintain($user_id))
	{
		$user = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $user_id]
		);

		$elite_maintain = fetch(
			'SELECT * ' .
			'FROM network_elite_maintain ' .
			'WHERE user_id = :user_id',
			['user_id' => $user->id]
		);

		$sales_now = group_sales($user->id) - $elite_maintain->maintain_elite_last;

		$period_elite_maintain = $elite_maintain->period_elite_maintain + $sales_now;

		enlist_to_elite($user->id);

		if ($period_elite_maintain >= 500000)
		{
			switch ($account_type)
			{
				case 'regular':
					$pool = 2000;
					break;
				case 'associate':
					$pool = 350;
					break;
				case 'basic':
					$pool = 50;
					break;
				default:
					$pool = 0;
					break;
			}

			add_elite_bonus(($pool / 20), $user_id);
		}
	}
}

// price based on franchise
function repeat_purchase_elite_bonus($price, $user_id)
{
	if (on_elite_maintain($user_id))
	{
		$user = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $user_id]
		);

		$elite_maintain = fetch(
			'SELECT * ' .
			'FROM network_elite_maintain ' .
			'WHERE user_id = :user_id',
			['user_id' => $user->id]
		);

		$sales_now = group_sales($user->id) - $elite_maintain->maintain_elite_last;

		$period_elite_maintain = $elite_maintain->period_elite_maintain + $sales_now;

		enlist_to_elite($user->id);

		if ($period_elite_maintain >= 100000)
		{
			add_elite_bonus(($price * 10 / 100 / 20), $user->id);
		}

		update_elite_maintain($sales_now, $user->id);
	}
}

function add_elite_bonus($amount, $user_id)
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
			'SET elite_reward = :elite_reward ' .
			'WHERE user_id = :user_id',
			[
				'elite_reward' => ($user->elite_reward + $amount),
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

function update_elite_maintain($amount, $user_id)
{
	$dbh = DB::connect();

	$elite_maintain = fetch(
		'SELECT * ' .
		'FROM network_elite_maintain ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);

	$maintain_elite        = $elite_maintain->maintain_elite + $amount;
	$maintain_elite_now    = $elite_maintain->maintain_elite_now + $amount;
	$period_elite_maintain = $elite_maintain->period_elite_maintain + $amount;

	try
	{
		$dbh->beginTransaction();

		crud(
			'UPDATE network_elite_maintain ' .
			'SET maintain_elite = :maintain_elite, ' .
			'maintain_elite_now = :maintain_elite_now, ' .
			'maintain_elite_last = :maintain_elite_last, ' .
			'period_elite_maintain = :period_elite_maintain ' .
			'WHERE user_id = :user_id',
			[
				'maintain_elite'        => $maintain_elite,
				'maintain_elite_now'    => $maintain_elite_now,
				'maintain_elite_last'   => $amount,
				'period_elite_maintain' => $period_elite_maintain,
				'user_id'               => $user_id
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

function on_elite_maintain($user_id)
{
	// check if user is on elite maintain
	$result = fetch(
		'SELECT * ' .
		'FROM network_elite_maintain ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);

	if ($result)
	{
		return true;
	}

	return false;
}

function all_elite()
{
	$result = [];

	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account',
		['account_type' => 'starter']
	);

	foreach ($users as $user)
	{
		if ($user->elite == 1)
		{
			array_push($result, $user->id);
		}
	}

	return $result;
}

function enlist_to_elite($user_id)
{
	$dbh = DB::connect();

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);

	if (
		count(all_elite()) < 20
		&&
		$user->elite == 0
		&&
		direct_member($user->id) >= 10
	)
	{
		try
		{
			$dbh->beginTransaction();

			crud(
				'UPDATE network_users ' .
				'SET elite = :elite ' .
				'WHERE user_id = :user_id',
				[
					'elite'   => 1,
					'user_id' => $user_id
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
}

function group_sales($user_id)
{
	$sales = 0;

	$indirects = indirect_member($user_id);

	if ($indirects)
	{
		foreach ($indirects as $result)
		{
			$indirect = fetch(
				'SELECT * ' .
				'FROM network_users ' .
				'WHERE id = :id',
				['id' => $result->id]
			);

			switch ($indirect->account_type)
			{
				case 'basic':
					$sales += 3998;
					break;
				case 'wholesale':
					$sales += 15998;
					break;
				case 'mobile':
					$sales += 300000;
					break;
			}
		}
	}

	return $sales;
}

function direct_member($user_id)
{
	$directs = [];

	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE sponsor_id = :id ' .
		'AND account_type <> :account_type',
		[
			'id'           => $user_id,
			'account_type' => 'starter'
		]
	);

	foreach ($users as $user)
	{
		array_push($directs, $user->id);
	}

	return $directs;
}

function indirect_member($user_id)
{
	$indirects = [];

	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id <> :id ' .
		'AND account_type <> :account_type',
		[
			'id'           => $user_id,
			'account_type' => 'starter'
		]
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