<?php

namespace BPL\Royalty_Bonus;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\users;
use function BPL\Mods\Helpers\settings;

/**
 * zero the insert_id to take price
 * zero the price to take user_id
 *
 * @param $insert_id
 * @param $price
 *
 *
 * @since version
 */
function main($insert_id, $price)
{
	$users = users();

	if ($insert_id > 0 && (int) $price === 0)
	{
		// get entry account_type
		$entry_user = user($insert_id);

		foreach ($users as $user)
		{
			entry_royalty_bonus($entry_user->account_type, $user->id);
		}
	}
	elseif ((int) $insert_id === 0 && $price > 0)
	{
		foreach ($users as $user)
		{
			repeat_purchase_royalty_bonus($price, $user->id);
		}
	}
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_ranking_maintain($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_ranking_maintain ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * user_id for all users
 * account_type for user just registered
 *
 * @param $account_type
 * @param $user_id
 *
 *
 * @since version
 */
function entry_royalty_bonus($account_type, $user_id)
{
	if (!empty(user_ranking_maintain($user_id)))
	{
//		$settings_plans   = settings('plans');
		$settings_royalty = settings('royalty');

		$user = user($user_id);

		$ranking_maintain = user_ranking_maintain($user->id);

		$sales_now = group_sales($user->id) - $ranking_maintain->maintain_ranking_last;

		$period_ranking_maintain = $ranking_maintain->period_ranking_maintain + $sales_now;

		promote_rank($user->id);

		switch ($user->rank)
		{
			case 'supervisor':
				if ($period_ranking_maintain >= $settings_royalty->supervisor_sales)
				{
					$royalty = account_rank_royalty_bonus($account_type, 'supervisor');

					$royalty = deduct($royalty, $user_id);

//					$royalty = $settings_plans->upline_support ?
//						upline_support($royalty, $user_id) : cd_filter($user_id, $royalty);

					add_bonus($royalty, $user_id);
				}

				break;
			case 'manager':
				if ($period_ranking_maintain >= $settings_royalty->manager_sales)
				{
					$royalty = account_rank_royalty_bonus($account_type, 'manager');

					$royalty = deduct($royalty, $user_id);

//					$royalty = $settings_plans->upline_support ?
//						upline_support($royalty, $user_id) : cd_filter($user_id, $royalty);

					add_bonus($royalty, $user_id);
				}

				break;
			case 'director':
				if ($period_ranking_maintain >= $settings_royalty->director_sales)
				{
					$royalty = account_rank_royalty_bonus($account_type, 'director');

					$royalty = deduct($royalty, $user_id);

//					$royalty = $settings_plans->upline_support ?
//						upline_support($royalty, $user_id) : cd_filter($user_id, $royalty);

					add_bonus($royalty, $user_id);
				}

				break;
		}
	}
}

/**
 * @param $value
 * @param $user_id
 *
 * @return int|mixed
 *
 * @since version
 */
function deduct($value, $user_id)
{
	return cd_filter($user_id, upline_support($value, $user_id));
}

/**
 * price based on franchise
 *
 * @param $price
 * @param $user_id
 *
 *
 * @since version
 */
function repeat_purchase_royalty_bonus($price, $user_id)
{
	if (!empty(user_ranking_maintain($user_id)))
	{
		$settings_royalty = settings('royalty');

		$user = user($user_id);

		$ranking_maintain = user_ranking_maintain($user->id);

		$sales_now = group_sales($user->id) - $ranking_maintain->maintain_ranking_last;

		$period_ranking_maintain = $ranking_maintain->period_ranking_maintain + $sales_now;

		promote_rank($user->id);

		if ($period_ranking_maintain >= $settings_royalty->{$user->rank . '_sales'})
		{
			$cut = (double) $settings_royalty->{$user->rank . '_repeat_purchase_reward'} / 100;

			$royalty = $price * $cut / count(all_rank($user->rank));

			$royalty = deduct($royalty, $user_id);

//			$royalty = settings('plans')->upline_support ?
//				upline_support($royalty, $user_id) : cd_filter($user_id, $royalty);

			add_bonus($royalty, $user_id);
		}
	}
}

/**
 * @param $account_type
 * @param $rank_type
 *
 * @return float|int
 *
 * @since version
 */
function account_rank_royalty_bonus($account_type, $rank_type)
{
	return settings('royalty')->{$rank_type . '_' . $account_type .
		'_reward'} / count(all_rank($rank_type));
}

/**
 * @param $rank_type
 *
 * @return array
 *
 * @since version
 */
function all_rank($rank_type): array
{
	$result = [];

	foreach (users() as $user)
	{
		if ($user->rank === $rank_type)
		{
			$result[] = $user->id;
		}
	}

	return $result;
}

/**
 * @param $amount
 * @param $user_id
 *
 *
 * @since version
 */
function add_bonus($amount, $user_id)
{
	$db = db();

	$user = user($user_id);

	$field_user = ['rank_reward = ' . $db->quote($user->rank_reward + $amount)];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . $amount;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $amount;
	}

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user->id)]
	);
}

/**
 * @param $rank
 * @param $user_id
 *
 *
 * @since version
 */
function rank_promote_to($rank, $user_id)
{
	update_user_rank($user_id, $rank);

	if (empty(user_ranking_maintain($user_id)))
	{
		// insert user to ranking maintain
		insert_ranking_maintain($user_id);
	}
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function insert_ranking_maintain($user_id)
{
	$db = db();

	insert(
		'network_ranking_maintain',
		['user_id'],
		[$db->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $rank
 *
 *
 * @since version
 */
function update_user_rank($user_id, $rank)
{
	$db = db();

	update(
		'network_users',
		['rank = ' . $db->quote($rank)],
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function promote_rank($user_id)
{
	$settings_royalty = settings('royalty');

	$user = user($user_id);

	switch ($user->rank)
	{
		case 'none':
			if (leader_member($user->id) >= $settings_royalty->supervisor_members)
			{
				rank_promote_to('supervisor', $user->id);
			}

			break;
		case 'supervisor':
			if (rank_member('supervisor', $user->id) >= $settings_royalty->manager_supervisors)
			{
				rank_promote_to('manager', $user->id);
			}

			break;
		case 'manager':
			if (rank_member('manager', $user_id) >= $settings_royalty->director_managers)
			{
				rank_promote_to('director', $user->id);
			}

			break;
	}
}

/**
 * @param $user_id
 *
 * @return float|int
 *
 * @since version
 */
function group_sales($user_id)
{
	$sales = 0;

	$indirects = indirect_member($user_id);

	if (!empty($indirects))
	{
		foreach ($indirects as $indirect)
		{
			$sales += (double) settings('entry')->{user($indirect->id)->account_type . '_entry'};
		}
	}

	return $sales;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function get_directs($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE sponsor_id = ' . $db->quote($user_id) .
		' AND account_type <> ' . $db->quote('starter')
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function direct_member($user_id): array
{
	$list = [];

	foreach (get_directs($user_id) as $direct)
	{
		$list[] = $direct->id;
	}

	return $list;
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function indirect_member($user_id): array
{
	$list = [];

	foreach (user_paid($user_id) as $user)
	{
		while ($user->sponsor_id)
		{
			if ($user->sponsor_id === $user_id &&
				!in_array($user->id, $list, true))
			{
				$list[] = $user->id;
			}

			$user = user($user->sponsor_id);
		}
	}

	return $list;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_paid($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id <> ' . $db->quote($user_id) .
		' AND account_type <> ' . $db->quote('starter')
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function leader_member($user_id): array
{
	$list = [];

	$indirects = indirect_member($user_id);

	if (!empty($indirects))
	{
		foreach ($indirects as $indirect)
		{
			$user = user($indirect->id);

			if ($user->rank === 'none' &&
				count(direct_member($indirect)) >= settings('royalty')->supervisor_member_directs)
			{
				$list[] = $indirect;
			}
		}
	}

	return $list;
}

/**
 * @param $rank_type
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function rank_member($rank_type, $user_id): array
{
	$list = [];

	$indirects = indirect_member($user_id);

	if (!empty($indirects))
	{
		foreach ($indirects as $indirect)
		{
			$user = user($indirect->id);

			if ($user->rank === $rank_type)
			{
				$list[] = $user->id;
			}
		}
	}

	return $list;
}