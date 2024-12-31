<?php

namespace BPL\Upline_Support;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

/**
 * to be used like cd_filter
 * userid: id of the target upline
 *
 * @param $amount
 * @param $user_id
 *
 * @return float|int
 *
 * @since version
 */
function main($amount, $user_id)
{
	if (settings('plans')->upline_support)
	{
		$amount -= value($amount, $user_id);
	}

	return $amount;
}

/**
 * @param $amount
 * @param $user_id
 *
 * @return float|int
 *
 * @since version
 */
function value($amount, $user_id)
{
	$settings_upline_support = settings('upline_support');

	// upline details
	$user = user($user_id);

	$level = $settings_upline_support->{$user->account_type . '_upline_support_level'};

	$cut = [];

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$share     = $settings_upline_support->{$user->account_type . '_upline_support_share_' . $i_i};
		$share_cut = $settings_upline_support->{$user->account_type . '_upline_support_share_cut_' . $i_i};

		$cut[$i_i] = $share * $share_cut / 100 / 100;
	}

//	$cut = [
//		1 => 5,
//		2 => 3,
//		3 => 2
//	];

	$level1 = level([$user_id])[0];

	foreach ($level1 as $direct)
	{
		add_bonus( $amount * $cut[1] / count($level1), $direct);
	}

	for ($i_i = 2; $i_i <= $level; $i_i++)
	{
		foreach (nested($i_i, $level1)[0] as $user)
		{
			add_bonus($amount * $cut[$i_i] / count(nested($i_i, $level1)[0]), $user);
		}
	}

	$percent_sum = 0;

	foreach ($cut as $value)
	{
		$percent_sum += $value;
	}

	// actual income received by the user
	return $amount * $percent_sum;
}

/**
 * @param $sponsor_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_directs($sponsor_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($sponsor_id)
	)->loadObjectList();
}

/**
 * @param   array  $lvl_1
 *
 * @return array[]
 *
 * @since version
 */
function level(array $lvl_1 = []): array
{
	$lvl_2 = [];

	if (!empty($lvl_1))
	{
		foreach ($lvl_1 as $sponsor1)
		{
			$result = user_directs($sponsor1);

			if ($result)
			{
				foreach ($result as $sponsor2)
				{
					$lvl_2[] = $sponsor2->id;
				}
			}
		}
	}

	return [$lvl_2];
}

/**
 * @param $n
 * @param $level_1
 *
 * @return mixed
 *
 * @since version
 */
function nested($n, $level_1)
{
	$result = [$level_1];

	for ($i_i = 2; $i_i <= $n; $i_i++)
	{
		$result[] = level(array_reverse($result)[0][0]);
	}

	return array_reverse($result)[0];
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

	$field_user = ['upline_support = ' . $db->quote($user->upline_support + $amount)];

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
		['id = ' . $db->quote($user_id)]
	);
}