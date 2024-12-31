<?php

// royalty bonus

namespace Onewayhi\Sand\Royalty_Bonus;

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
			entry_royalty_bonus($entry_user->account_type, $user->id);
		}
	}
	elseif ($insert_id == 0 && $price > 0)
	{
		foreach ($users as $user)
		{
			repeat_purchase_royalty_bonus($price, $user->id);
		}
	}
}

// user_id for all users
// account_type for user just registered
function entry_royalty_bonus($account_type, $user_id)
{
	if (on_rank_maintain($user_id))
	{
		$user = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $user_id]
		);

		$ranking_maintain = fetch(
			'SELECT * ' .
			'FROM network_ranking_maintain ' .
			'WHERE user_id = :user_id',
			['user_id' => $user->d]
		);

		$sales_now = group_sales($user->id) - $ranking_maintain->maintain_ranking_last;

		$period_ranking_maintain = $ranking_maintain->period_ranking_maintain + $sales_now;

		promote_rank($user->id);

		switch ($user->rank)
		{
			case 'supervisor':
				if ($period_ranking_maintain >= 100000)
				{
					$royalty = account_rank_royalty_bonus($account_type, 'supervisor');
					add_bonus($royalty, $user_id);
				}

				break;
			case 'manager':
				if ($period_ranking_maintain >= 200000)
				{
					$royalty = account_rank_royalty_bonus($account_type, 'manager');
					add_bonus($royalty, $user_id);
				}

				break;
			case 'director':
				if ($period_ranking_maintain >= 500000)
				{
					$royalty = account_rank_royalty_bonus($account_type, 'director');
					add_bonus($royalty, $user_id);
				}

				break;
		}
	}
}

// price based on franchise
function repeat_purchase_royalty_bonus($price, $user_id)
{
	if (on_rank_maintain($user_id))
	{
		$user = fetch(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = :id',
			['id' => $user_id]
		);

		$ranking_maintain = fetch(
			'SELECT * ' .
			'FROM network_ranking_maintain ' .
			'WHERE user_id = :user_id',
			['user_id' => $user->d]
		);

		$sales_now = group_sales($user->id) - $ranking_maintain->maintain_ranking_last;

		$period_ranking_maintain = $ranking_maintain->period_ranking_maintain + $sales_now;

		promote_rank($user->id);

		switch ($user->rank)
		{
			case 'supervisor':
				if ($period_ranking_maintain >= 100000)
				{
					$royalty = $price * 3 / 100 / count(all_rank('supervisor'));
					add_bonus($royalty, $user_id);
				}

				break;
			case 'manager':
				if ($period_ranking_maintain >= 200000)
				{
					$royalty = $price * 5 / 100 / count(all_rank('manager'));
					add_bonus($royalty, $user_id);
				}

				break;
			case 'director':
				if ($period_ranking_maintain >= 500000)
				{
					$royalty = $price * 10 / 100 / count(all_rank('director'));
					add_bonus($royalty, $user_id);
				}

				break;
		}
	}
}

function account_rank_royalty_bonus($account_type, $rank_type)
{
	switch ($rank_type)
	{
		case 'director':
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

			$royalty = $pool / count(all_rank('director'));
			break;
		case 'manager':
			switch ($account_type)
			{
				case 'regular':
					$pool = 1000;
					break;
				case 'associate':
					$pool = 200;
					break;
				case 'basic':
					$pool = 30;
					break;
				default:
					$pool = 0;
					break;
			}

			$royalty = $pool / count(all_rank('manager'));
			break;
		case 'supervisor':
			switch ($account_type)
			{
				case 'regular':
					$pool = 500;
					break;
				case 'associate':
					$pool = 100;
					break;
				case 'basic':
					$pool = 20;
					break;
				default:
					$pool = 0;
					break;
			}

			$royalty = $pool / count(all_rank('supervisor'));
			break;
		default:
			$royalty = 0;
			break;
	}

	return $royalty;
}

function all_rank($rank_type)
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
		if ($user->rank == $rank_type)
		{
			array_push($result, $user->id);
		}
	}

	return $result;
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
			'SET rank_reward = :rank_reward ' .
			'WHERE user_id = :user_id',
			[
				'rank_reward' => ($user->rank_reward + $amount),
				'user_id'     => $user_id
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

function on_rank_maintain($user_id)
{
	// check if user is on rank maintain
	$result = fetch(
		'SELECT * ' .
		'FROM network_ranking_maintain ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);

	if ($result)
	{
		return true;
	}

	return false;
}

function rank_promote_to($rank_type, $user_id)
{
	$dbh = DB::connect();

	try
	{
		$dbh->beginTransaction();

		// update user rank
		crud(
			'UPDATE network_users ' .
			'SET rank = :rank ' .
			'WHERE user_id = :user_id',
			[
				'rank'    => $rank_type,
				'user_id' => $user_id
			]
		);

		if (!on_rank_maintain($user_id))
		{
			// insert user to ranking maintain
			crud(
				'INSERT ' .
				'INTO network_ranking_maintain (' .
				'user_id' .
				') VALUES (' .
				':user_id' .
				')',
				['user_id' => $user_id]
			);
		}

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

function promote_rank($user_id)
{
	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);

	switch ($user->rank)
	{
		case 'none':
			if (leader_member($user->id) >= 20)
			{
				rank_promote_to('supervisor', $user->id);
			}

			break;
		case 'supervisor':
			if (rank_member('supervisor', $user->id) >= 10)
			{
				rank_promote_to('manager', $user->id);
			}

			break;
		case 'manager':
			if (rank_member('manager', $user_id) >= 5)
			{
				rank_promote_to('director', $user->id);
			}

			break;
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

function leader_member($user_id)
{
	$leaders = [];

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

			if (count(direct_member($result)) >= 3 && $indirect->rank == 'none')
			{
				array_push($leaders, $result);
			}
		}
	}

	return $leaders;
}

function rank_member($rank_type, $user_id)
{
	$rank_member = [];

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

			if ($indirect->rank == $rank_type)
			{
				array_push($rank_member, $indirect->id);
			}
		}
	}

	return $rank_member;
}