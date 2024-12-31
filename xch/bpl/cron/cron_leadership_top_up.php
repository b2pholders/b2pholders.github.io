<?php

namespace BPL\Cron\Leadership\Top_Up;

require_once '../upline_support_local.php';
require_once '../mods/leadership_passive.php';
require_once '../mods/cd_filter_local.php';
require_once '../mods/helpers_local.php';

use function BPL\Upline_Support_Local\main as upline_support;
use function BPL\Mods\Local\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Local\Leadership_Passive\leadership_passive_users;
use function BPL\Mods\Local\Leadership_Passive\user_directs;
use function BPL\Mods\Local\Leadership_Passive\update_leadership_passive;
use function BPL\Mods\Local\Leadership_Passive\update_user;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

/**
 *
 *
 * @since version
 */
function main()
{
	$settings = settings('leadership_passive');

	$users = leadership_passive_users();

	if (!empty($users))
	{
		foreach ($users as $user)
		{
			$count_directs = count(user_directs($user->user_id));

			$account_type = $user->account_type;

			$type_level       = $settings->{$account_type . '_leadership_passive_level'};
			$directs_required = $settings->{$account_type . '_leadership_passive_sponsored'};

			if ($type_level && $count_directs >= $directs_required)
			{
				$bonus = bonus_total_leadership_top_up($user->user_id)['bonus'];

				$leadership_passive = $bonus - $user->bonus_leadership_passive_last;
				$leadership_passive = deduct($leadership_passive, $user->user_id);

				update_leadership_passive($user, $leadership_passive, $bonus);
				update_user($user, $leadership_passive);
			}
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
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_cd($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_commission_deduct ' .
		'WHERE id = :id',
		['id' => $user_id]
	);
}

/**
 * @param   array  $head
 *
 * @return array[]
 *
 * @since version
 */
function level_leadership_top_up(array $head = []): array
{
	$group   = [];
	$passive = [];

	foreach ($head as $sponsor)
	{
		$directs = user_directs($sponsor);

		if (!empty($directs))
		{
			foreach ($directs as $direct)
			{
				$group[] = $direct->id;

				if (empty(user_cd($direct->id)))
				{
					$passive[] = $direct->top_up_interest;
				}
			}
		}
	}

	return [$group, $passive];
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
		$result[] = level_leadership_top_up(array_reverse($result)[0][0]);
	}

	return array_reverse($result)[0];
}

/**
 * @param $indirect
 * @param $share
 * @param $share_cut
 *
 * @return float|int
 *
 * @since version
 */
function get_leadership_top_up($indirect, $share, $share_cut)
{
	$leadership = 0;

	if ($indirect)
	{
		foreach ($indirect as $top_up)
		{
			$leadership += $top_up * $share * $share_cut / 100 / 100;
		}
	}

	return $leadership;
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function bonus_total_leadership_top_up($user_id): array
{
	$level_1 = level_leadership_top_up([$user_id]);

	$account_type = user($user_id)->account_type;

	$settings_leadership_passive = settings('leadership_passive');

	$member = count($level_1[0]);
	$bonus  = get_leadership_top_up(
		$level_1[1],
		$settings_leadership_passive->{$account_type . '_leadership_passive_share_1'},
		$settings_leadership_passive->{$account_type . '_leadership_passive_share_cut_1'}
	);

	$type_level = $settings_leadership_passive->{$account_type . '_leadership_passive_level'};

	for ($i_i = 2; $i_i <= $type_level; $i_i++)
	{
		$member += count(nested($i_i, $level_1)[0]);

		$bonus += get_leadership_top_up(
			nested($i_i, $level_1)[1],
			$settings_leadership_passive->{$account_type . '_leadership_passive_share_' . $i_i},
			$settings_leadership_passive->{$account_type . '_leadership_passive_share_cut_' . $i_i}
		);
	}

	return [
		'member' => $member,
		'bonus'  => $bonus
	];
}