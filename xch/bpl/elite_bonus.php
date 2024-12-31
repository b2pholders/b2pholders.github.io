<?php

namespace BPL\Elite_Bonus;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\users;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;

/**
 * @param $insert_id  // zero the insert_id to take price
 * @param $price      // zero the price to take user_id
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
			entry_elite_bonus($entry_user->account_type, $user->id);
		}
	}
	elseif ((int) $insert_id === 0 && $price > 0)
	{
		foreach ($users as $user)
		{
			repeat_purchase_elite_bonus($price, $user->id);
		}
	}
}

/**
 * @param $user_id
 *
 *
 * @return mixed|null
 * @since version
 */
function user_elite_maintain($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_elite_maintain ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}


/**
 * @param $account_type  // account_type for user just registered
 * @param $user_id       // user_id for all users
 *
 *
 * @since version
 */
function entry_elite_bonus($account_type, $user_id)
{
	if (!empty(user_elite_maintain($user_id)))
	{
		$settings_elite = settings('elite_reward');

		$user = user($user_id);

		enlist_to_elite($user->id);

		$pool = $settings_elite->{$account_type . '_reward'};

		$bonus = $pool / $settings_elite->group_limit;

		core($user_id, $bonus);
	}
}

/**
 * @param $user_id
 * @param $bonus
 *
 *
 * @since version
 */
function core($user_id, $bonus)
{
//	$settings_plans = settings('plans');
//	$settings_elite = settings('elite_reward');

	$user = user($user_id);

	$elite_maintain = user_elite_maintain($user->id);

	$sales_now = group_sales($user->id) - $elite_maintain->maintain_elite_last;

	$period_elite_maintain = $elite_maintain->period_elite_maintain + $sales_now;

	enlist_to_elite($user->id);

	if ($period_elite_maintain >= settings('elite_reward')->sales)
	{
//		$bonus = $settings_plans->upline_support ?
//			upline_support($bonus, $user->id) : cd_filter($user->id, $bonus);

		add_bonus(deduct($bonus, $user->id), $user->id);
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
 * @param $price  // price based on franchise
 * @param $user_id
 *
 *
 * @since version
 */
function repeat_purchase_elite_bonus($price, $user_id)
{
	if (!empty(user_elite_maintain($user_id)))
	{
		$settings_elite = settings('elite_reward');

		$user = user($user_id);

		$elite_maintain = user_elite_maintain($user->id);

		$sales_now = group_sales($user->id) - $elite_maintain->maintain_elite_last;

		enlist_to_elite($user->id);

		$cut = $price * $settings_elite->repeat_purchase_reward / 100;

		$bonus = $cut / $settings_elite->group_limit;

		core($user_id, $bonus);

		update_elite_maintain($sales_now, $user->id);
	}
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

//	$settings_ancillaries = settings('ancillaries');

	$user = user($user_id);

	$field_user = ['elite_reward = ' . $db->quote($user->elite_reward + $amount)];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = ' . $db->quote($user->balance + $amount);
	}
	else
	{
		$field_user[] = 'payout_transfer = ' . $db->quote($user->payout_transfer + $amount);
	}

	update('network_users',
		$field_user,
		['id = ' . $db->quote($user->id)]);
}

/**
 * @param $amount
 * @param $user_id
 *
 *
 * @since version
 */
function update_elite_maintain($amount, $user_id)
{
	$db = db();

	$elite_maintain = user_elite_maintain($user_id);

	$maintain_elite        = $elite_maintain->maintain_elite + $amount;
	$maintain_elite_now    = $elite_maintain->maintain_elite_now + $amount;
	$period_elite_maintain = $elite_maintain->period_elite_maintain + $amount;

	update('network_elite_maintain',
		[
			'maintain_elite = ' . $db->quote($maintain_elite),
			'maintain_elite_now = ' . $db->quote($maintain_elite_now),
			'maintain_elite_last = ' . $db->quote($amount),
			'period_elite_maintain = ' . $db->quote($period_elite_maintain)
		],
		['user_id = ' . $db->quote($user_id)]);
}

/**
 *
 * @return array
 *
 * @since version
 */
function all_elite(): array
{
	$result = [];

	$users = users();

	foreach ($users as $user)
	{
		if ((int) $user->elite === 1)
		{
			$result[] = $user->id;
		}
	}

	return $result;
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function enlist_to_elite($user_id)
{
	$db = db();

	$settings_elite = settings('elite_reward');

	$user = user($user_id);

	if ((int) $user->elite === 0 &&
		direct_member($user->id) >= $settings_elite->directs &&
		count(all_elite()) < $settings_elite->group_limit)
	{
		update('network_users',
			['elite = ' . $db->quote(1)],
			['id = ' . $db->quote($user_id)]);
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
		$settings_entry = settings('entry');

		foreach ($indirects as $indirect)
		{
			$sales += (double) $settings_entry->{user($indirect->id)->account_type . '_entry'};
		}
	}

	return $sales;
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
	$db = db();

	$directs = [];

	$users = $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE sponsor_id = ' . $db->quote($user_id) .
		' AND account_type <> ' . $db->quote('starter')
	)->loadObjectList();

	foreach ($users as $user)
	{
		$directs[] = $user->id;
	}

	return $directs;
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
	$db = db();

	$indirects = [];

	$users = $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id <> ' . $db->quote($user_id) .
		' AND account_type <> ' . $db->quote('starter')
	)->loadObjectList();

	foreach ($users as $user)
	{
		$direct = user($user->id);

		while ($direct->sponsor_id)
		{
			if ((int) $direct->sponsor_id === (int) $user_id &&
				!in_array($user->id, $indirects, true))
			{
				$indirects[] = $user->id;
			}

			$direct = user($direct->sponsor_id);
		}
	}

	return $indirects;
}