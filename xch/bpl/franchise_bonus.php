<?php

namespace BPL\Franchise_Bonus;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\users;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;

/**
 * @param $price
 *
 *
 * @since version
 */
function main($price)
{
	$users = users();

	foreach ($users as $user)
	{
		// regular matches mobile stockist
		if ($user->account_type === 'executive')
		{
			$bonus = $price * settings('entry')->executive_global / 100 / count(all_franchise());

//			$bonus = settings('plans')->upline_support ?
//				upline_support($bonus, $user->id) : cd_filter($user->id, $bonus);

			add_bonus(deduct($bonus, $user->id), $user->id);
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

	$field_user = ['franchise_bonus = ' . $db->quote($user->franchise_bonus + $amount)];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = ' . $db->quote($user->balance + $amount);
	}
	else
	{
		$field_user[] = 'payout_transfer = ' . $db->quote($user->payout_transfer + $amount);
	}

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user_id)]
	);
}

/**
 *
 * @return array
 *
 * @since version
 */
function all_franchise(): array
{
	$result = [];

	$users = users();

	foreach ($users as $user)
	{
		if ($user->account_type === 'executive')
		{
			$result[] = $user->id;
		}
	}

	return $result;
}