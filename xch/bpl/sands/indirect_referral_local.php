<?php

namespace Onewayhi\Sand\Indirect_Referral;

date_default_timezone_set('Asia/Manila');

require_once '../bpl/lib/db_connect.php';
require_once '../bpl/mods/query_local.php';
require_once '../bpl/mods/url_sef_local.php';

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;
use function \Onewayhi\Database\Local\Query\crud;
use function \Onewayhi\Url\SEF\sef;

function main()
{
	$settings_plans = fetch(
		'SELECT * ' .
		'FROM network_settings_plans'
	);

	$settings_ancillaries = fetch(
		'SELECT * ' .
		'FROM network_settings_ancillaries'
	);

	$users = fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type',
		['account_type' => 'starter']
	);

	if ($users)
	{
		foreach ($users as $user)
		{
			$sponsored = count(fetch_all(
				'SELECT * ' .
				'FROM network_users ' .
				'WHERE account_type <> :account_type ' .
				'AND sponsor_id = :sponsor_id',
				[
					'account_type' => 'starter',
					'sponsor_id'   => $user->id
				]
			));

			$settings_indirect_referral = fetch(
				'SELECT * ' .
				'FROM network_settings_indirect_referral'
			);

			if (
				$settings_indirect_referral->{$user->account_type . '_indirect_referral_level'}
				&&
				$sponsored >= $settings_indirect_referral->{$user->account_type . '_indirect_referral_sponsored'}
			)
			{
				$indirect_referral = total($user->id)['bonus'];

				$user_indirect = fetch(
					'SELECT * ' .
					'FROM network_indirect ' .
					'WHERE id = :id',
					['id' => $user->id]
				);

				$bonus_indirect_new = $indirect_referral - $user_indirect->bonus_indirect_last;

				crud(
					'UPDATE network_indirect ' .
					'SET bonus_indirect = bonus_indirect + :bonus_indirect, ' .
					'bonus_indirect_now = bonus_indirect_now + :bonus_indirect_now, ' .
					'bonus_indirect_last = :bonus_indirect_last ' .
					'WHERE id = :id',
					[
						'bonus_indirect'      => $bonus_indirect_new,
						'bonus_indirect_now'  => $bonus_indirect_new,
						'bonus_indirect_last' => $indirect_referral,
						'id'                  => $user->id
					]
				);

				crud(
					'UPDATE network_users ' .
					'SET bonus_indirect_referral = bonus_indirect_referral + :bonus_indirect_referral, ' .
					'balance = balance + :balance, ' .
					'WHERE id = :id',
					[
						'bonus_indirect_referral' => $bonus_indirect_new,
						'balance'                 => $bonus_indirect_new,
						'id'                      => $user->id
					]
				);

				crud(
					'INSERT ' .
					'INTO network_activity (' .
					'user_id, ' .
					'sponsor_id, ' .
					'activity, ' .
					'activity_date' .
					') VALUES (' .
					':user_id, ' .
					':sponsor_id, ' .
					':activity, ' .
					':activity_date' .
					')',
					[
						'user_id'       => $user->id,
						'sponsor_id'    => $user->sponsor_id,
						'activity'      => ('<b>' . $settings_plans->indirect_referral_name .
							' Bonus: </b> <a href="' . sef(44) . '&uid=' .
							$user->id . '">' . $user->username . '</a> has earned ' .
							number_format($indirect_referral, 2) . ' ' . $settings_ancillaries->currency),
						'activity_date' => time()
					]
				);
			}
		}
	}
}

function level($lvl_1 = [])
{
	$lvl_2 = [];
	$type  = [];

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
					array_push($type, $sponsor2->account_type);
				}
			}
		}
	}

	return [$lvl_2, $type];
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

function get($indirect, $share, $share_cut)
{
	$indirect_referral = 0;

	$settings_entry = fetch(
		'SELECT * ' .
		'FROM network_settings_entry'
	);

	if (count($indirect) > 0)
	{
		foreach ($indirect as $type)
		{
			$indirect_referral += $settings_entry->{$type . '_entry'} * $share * $share_cut / 100 / 100;
		}
	}

	return $indirect_referral;
}

function bonus($level, $user_id)
{
	$level_1 = level([$user_id]);

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);

	$account_type = $user->account_type;

	$settings_indirect_referral = fetch(
		'SELECT * ' .
		'FROM network_settings_indirect_referral'
	);

	return extracted($level, $level_1, $account_type, $settings_indirect_referral);
}

function total($user_id)
{
	$level_1 = level([$user_id]);

	$user = fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);

	$account_type = $user->account_type;

	$settings_indirect_referral = fetch(
		'SELECT * ' .
		'FROM network_settings_indirect_referral'
	);

	return extracted($level_1, $account_type, $settings_indirect_referral);
}