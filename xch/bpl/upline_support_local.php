<?php

namespace BPL\Upline_Support_Local;

require_once '../mods/share_cut_get.php';
//require_once '../mods/cd_filter_local.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Share_Cut_Get\main as share_cut_get;

//use function BPL\Mods\Local\Commission_Deduct\Filter\main as cd_filter_local;

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

/**
 * @param $amount
 * @param $user_id
 *
 * @return float|int
 *
 * @since version
 */
function main($amount, $user_id)
{
	if (settings_local('plans')->upline_support)
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
	$settings_local = settings_local('upline_support');

	$account_type = user_local($user_id)->account_type;

	$level = $settings_local->{$account_type . '_upline_support_level'};

	$cut = share_cut_get($account_type, $level, $settings_local);

	$level1 = level_local([$user_id])[0];

	foreach ($level1 as $direct)
	{
		user_bonus_local($amount * $cut[1] / count($level1), $direct);
	}

	for ($i_i = 2; $i_i <= $level; $i_i++)
	{
		foreach (nested_local($i_i, $level1)[0] as $direct)
		{
			user_bonus_local($amount * $cut[$i_i] / count(nested_local($i_i, $level1)[0]), $direct);
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
 * @return array|false
 *
 * @since version
 */
function user_directs($sponsor_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type ' .
		'AND sponsor_id = :sponsor_id',
		[
			'account_type' => 'starter',
			'sponsor_id'   => $sponsor_id
		]
	);
}

/**
 * @param   array  $lvl_1
 *
 * @return array[]
 *
 * @since version
 */
function level_local(array $lvl_1 = []): array
{
	$lvl_2 = [];

	if (!empty($lvl_1))
	{
		foreach ($lvl_1 as $sponsor1)
		{
			$directs = user_directs($sponsor1);

			if ($directs)
			{
				foreach ($directs as $sponsor2)
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
function nested_local($n, $level_1)
{
	$result = [$level_1];

	for ($i_i = 2; $i_i <= $n; $i_i++)
	{
		$result[] = level_local(array_reverse($result)[0][0]);
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
function user_bonus_local($amount, $user_id)
{
	$settings_ancillaries = settings_local('ancillaries');

	$user = user_local($user_id);

	$col_user = [
		'upline_support' => ($user->upline_support + $amount),
		'user_id'        => $user_id
	];

	if ($settings_ancillaries->withdrawal_mode === 'standard')
	{
		$col_user['balance'] = $user->balance + $amount;
	}
	else
	{
		$col_user['payout_transfer'] = $user->payout_transfer + $amount;
	}

	crud(
		'UPDATE network_users ' .
		'SET upline_support = :upline_support, ' .
		($settings_ancillaries->withdrawal_mode === 'standard' ?
			'balance = :balance ' : 'payout_transfer = :payout_transfer') .
		'WHERE id = :user_id',
		$col_user
	);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_local($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);
}

/**
 * @param $type
 *
 * @return mixed
 *
 * @since version
 */
function settings_local($type)
{
	return fetch(
		'SELECT * ' .
		'FROM network_settings_' . $type
	);
}