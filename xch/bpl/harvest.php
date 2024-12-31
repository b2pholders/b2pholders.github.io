<?php

namespace BPL\Harvest;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user as get_user;
use function BPL\Mods\Helpers\users as get_users;
use function BPL\Mods\Helpers\settings;

/**
 *
 *
 * @since version
 */
function main()
{
	initialize();

	foreach (get_users() as $user)
	{
		$user = get_user($user->id);

		$executive_harvest_type = harvest_type_user($user->id, 'executive');
		$regular_harvest_type   = harvest_type_user($user->id, 'regular');
		$associate_harvest_type = harvest_type_user($user->id, 'associate');
		$basic_harvest_type     = harvest_type_user($user->id);

		if (!empty($executive_harvest_type))
		{
			bonus($executive_harvest_type->id, 'executive');
		}

		if (!empty($regular_harvest_type))
		{
			bonus($regular_harvest_type->id, 'regular');
		}

		if (!empty($associate_harvest_type))
		{
			bonus($associate_harvest_type->id, 'associate');
		}

		if (!empty($basic_harvest_type))
		{
			bonus($basic_harvest_type->id);
		}
	}
}

/**
 *
 *
 * @since version
 */
function initialize()
{
	foreach (get_users() as $user)
	{
		$account_type = get_user($user->id)->account_type;

		if (count(get_directs($user->id)) >= settings('harvest')->{$account_type . '_harvest_sponsored'})
		{
			if (empty(has_harvest($user)))
			{
				insert_harvest($user);
			}

			if (empty(harvest_type_user($user->id, $account_type)))
			{
				harvest_entry($user->id, $account_type);
			}
		}
	}
}

/**
 * @param $user
 *
 *
 * @since version
 */
function insert_harvest($user)
{
	$db = db();

	insert('network_harvest',
		['user_id'],
		[$db->quote($user->id)]);
}

/**
 * @param $user
 *
 * @return array|mixed
 *
 * @since version
 */
function has_harvest($user)
{
	$db = db();

	return $db->setQuery(
		'SELECT id ' .
		'FROM network_harvest' .
		' WHERE user_id = ' . $db->quote($user->id)
	)->loadObjectList();
}

/**
 * @param           $user_id
 * @param   string  $harvest_type
 *
 *
 * @since version
 */
function harvest_entry($user_id, string $harvest_type = 'basic')
{
	$db = db();

	insert(
		'network_harvest_' . $harvest_type,
		[
			'user_id',
			'has_mature',
			'is_active'
		],
		[
			$db->quote($user_id),
			$db->quote(0),
			$db->quote(1)
		]
	);

	position($harvest_type);
}

/**
 * @param $harvest_type
 *
 *
 * @since version
 */
function position($harvest_type)
{
	$users = user_harvest_type($harvest_type);

	if (!empty($users))
	{
		foreach ($users as $user)
		{
			update_harvest_upline_id($user, $harvest_type);
		}
	}
}

/**
 * @param $user
 * @param $harvest_type
 *
 *
 * @since version
 */
function update_harvest_upline_id($user, $harvest_type)
{
	$db = db();

	$width = settings('harvest')->{$harvest_type . '_harvest_width'};

	$position  = position_count_id($user, $harvest_type)->position + $width - 1;
	$remainder = $position % $width;
	$count     = ($position - $remainder) / $width;

	update('network_harvest_' . $harvest_type,
		['harvest_upline_id = ' . $db->quote($count)],
		['id = ' . $db->quote($user->id)]);
}

/**
 * @param $user
 * @param $harvest_type
 *
 * @return mixed|null
 *
 * @since version
 */
function position_count_id($user, $harvest_type)
{
	$db = db();

	return $db->setQuery(
		'SELECT COUNT(id) - 1 AS position ' .
		'FROM network_harvest_' . $harvest_type .
		' WHERE id <= ' . $user->id)->loadObject();
}

/**
 * @param           $id
 * @param   string  $harvest_type
 *
 *
 * @since version
 */
function bonus($id, string $harvest_type = 'basic')
{
	$user_harvest = user_harvest($id, $harvest_type);

	if (empty($user_harvest))
	{
		return;
	}

	$user_id = $user_harvest->user_id;

	$bonus_total = bonus_total($id, $harvest_type);

	if ($bonus_total > 0)
	{
		// execute income computation
		$bonus_harvest_new = $bonus_total - user_harvest_last(get_user($user_id)->id, $harvest_type)
				->{'bonus_harvest_' . $harvest_type . '_last'};

		$bonus_harvest_new = deduct($bonus_harvest_new, $user_id);

//		$bonus_harvest_new = settings('plans')->upline_support ?
//			upline_support($bonus_harvest_new, $user_id) :
//			cd_filter($user_id, $bonus_harvest_new);

		update_harvest($user_id, $harvest_type, $bonus_total, $bonus_harvest_new);
		update_user_bonus($user_id, $bonus_harvest_new);

		// graduate
		if (member_total($id, $harvest_type) >= member_max($harvest_type))
		{
			update_harvest_type_bonus($id, $harvest_type);

			logs_bonus($id, $harvest_type, $bonus_harvest_new);
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
 * @param $id
 * @param $harvest_type
 * @param $bonus_harvest_new
 *
 *
 * @since version
 */
function logs_activity($id, $harvest_type, $bonus_harvest_new)
{
	$db = db();

	$user_id = user_harvest($id, $harvest_type)->user_id;

	$user = get_user($user_id);

	$activity = '<b>Matured ' . ucfirst($harvest_type) . ' Harvest:</b> <a href="' .
		sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> has matured ' .
		ucfirst($harvest_type) . ' Harvest.<br>Harvest Bonus is now ' .
		number_format($user->bonus_harvest + $bonus_harvest_new, 2) .
		' ' . settings('ancillaries')->currency;

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$user_id,
			$user->sponsor_id,
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $id
 * @param $harvest_type
 * @param $bonus_harvest_new
 *
 *
 * @since version
 */
function logs_transactions($id, $harvest_type, $bonus_harvest_new)
{
	$db = db();

	$user_id = user_harvest($id, $harvest_type)->user_id;

	$user = get_user($user_id);

	$bonus_harvest = $user->bonus_harvest;

	$details = '<b>Matured ' . ucfirst($harvest_type) . ' Harvest:</b> <a href="' .
		sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> has matured ' .
		ucfirst($harvest_type) . ' Harvest.<br>Harvest Bonus is now ' .
		number_format($bonus_harvest + $bonus_harvest_new, 2) .
		' ' . settings('ancillaries')->currency;

	insert(
		'network_transactions',
		[
			'user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'
		],
		[
			$user->sponsor_id,
			$db->quote('Matured ' . ucfirst($harvest_type) . ' Harvest'),
			$db->quote($details),
			$db->quote($bonus_harvest + $bonus_harvest_new),
			$db->quote($user->balance),
			$db->quote(time())
		]
	);
}

/**
 * @param $id
 * @param $harvest_type
 * @param $bonus_harvest_new
 *
 *
 * @since version
 */
function logs_bonus($id, $harvest_type, $bonus_harvest_new)
{
	logs_activity($id, $harvest_type, $bonus_harvest_new);
	logs_transactions($id, $harvest_type, $bonus_harvest_new);
}

/**
 * @param $id
 * @param $harvest_type
 *
 *
 * @since version
 */
function update_harvest_type_bonus($id, $harvest_type)
{
	$db = db();

	update(
		'network_harvest_' . $harvest_type,
		[
			'has_mature = ' . $db->quote(1),
			'is_active = ' . $db->quote(0)
		],
		['id = ' . $db->quote($id)]
	);
}

/**
 * @param $user_id
 * @param $bonus_harvest_new
 *
 *
 * @since version
 */
function update_user_bonus($user_id, $bonus_harvest_new)
{
	$db = db();

	$field_user = ['bonus_harvest = bonus_harvest + ' . $bonus_harvest_new];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . $bonus_harvest_new;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $bonus_harvest_new;
	}

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $harvest_type
 * @param $bonus_total
 * @param $bonus_harvest_new
 *
 *
 * @since version
 */
function update_harvest($user_id, $harvest_type, $bonus_total, $bonus_harvest_new)
{
	$db = db();

	update(
		'network_harvest',
		[
			'bonus_harvest_' . $harvest_type . ' = bonus_harvest_' .
			$harvest_type . ' + ' . $bonus_harvest_new,
			'bonus_harvest_' . $harvest_type . '_now = bonus_harvest_' .
			$harvest_type . '_now + ' . $bonus_harvest_new,
			'bonus_harvest_' . $harvest_type . '_last = ' . $bonus_total
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

/**
 * @param   array   $lvl_1
 * @param   string  $harvest_type
 *
 * @return array[]
 *
 * @since version
 */
function level(array $lvl_1 = [], string $harvest_type = 'basic'): array
{
	$lvl_2 = [];

	if (!empty($lvl_1))
	{
		foreach ($lvl_1 as $harvest1)
		{
			$result = downlines($harvest1, $harvest_type);

			if (!empty($result))
			{
				foreach ($result as $harvest2)
				{
					$lvl_2[] = $harvest2->id;
				}
			}
		}
	}

	return [$lvl_2];
}

/**
 * @param $depth
 * @param $id
 * @param $harvest_type
 *
 * @return mixed
 *
 * @since version
 */
function nested($depth, $id, $harvest_type)
{
	$result = [level([$id], $harvest_type)];

	for ($i_i = 2; $i_i <= $depth; $i_i++)
	{
		$result[] = level(array_reverse($result)[0][0], $harvest_type);
	}

	return array_reverse($result)[0];
}

/**
 * @param $id
 * @param $harvest_type
 *
 * @return int
 *
 * @since version
 */
function member_total($id, $harvest_type): int
{
	$level_1 = level([$id], $harvest_type);

	$level = settings('harvest')->{$harvest_type . '_harvest_level'};

	$member = count($level_1[0]);

	for ($i_i = 2; $i_i <= $level; $i_i++)
	{
		$member += count(nested($i_i, $id, $harvest_type)[0]);
	}

	return $member;
}

/**
 * @param $harvest_type
 *
 * @return int
 *
 * @since version
 */
function member_max($harvest_type): int
{
	$settings = settings('harvest');

	$width = $settings->{$harvest_type . '_harvest_width'};
	$level = $settings->{$harvest_type . '_harvest_level'};

	$max = 0;

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$max += $width ** $i_i;
	}

	return $max;
}

/**
 * @param $level_last_fill
 * @param $harvest_type
 *
 * @return int
 *
 * @since version
 */
function member_max_fill($level_last_fill, $harvest_type): int
{
	$width = settings('harvest')->{$harvest_type . '_harvest_width'};

	$member_max_fill = 0;

	for ($i_i = 1; $i_i <= $level_last_fill; $i_i++)
	{
		$member_max_fill += $width ** $i_i;
	}

	return $member_max_fill;
}

/**
 * @param $id
 * @param $level
 * @param $harvest_type
 *
 * @return int
 *
 * @since version
 */
function member_level($id, $level, $harvest_type): int
{
	$level_1 = level([$id], $harvest_type);

	return count($level > 1 ? nested($level, $id, $harvest_type)[0] : $level_1[0]);
}

/**
 * @param $level
 * @param $harvest_type
 *
 * @return int
 *
 * @since version
 */
function member_max_level($level, $harvest_type): int
{
	return settings('harvest')->{$harvest_type . '_harvest_width'} ** $level;
}

/**
 * @param           $id
 * @param   string  $harvest_type
 *
 * @return float|int
 *
 * @since version
 */
function bonus_total($id, string $harvest_type = 'basic')
{
	$settings_harvest = settings('harvest');

	$bonus_total      = 0;
	$member_total_now = 0;

	$level_last_fill = 0;

	for ($i_i = 1; $i_i <= $settings_harvest->{$harvest_type . '_harvest_level'}; $i_i++)
	{
		$member_level = member_level($id, $i_i, $harvest_type);

		$member_total_now += $member_level;

		$level_last_fill += $member_level > 0 ? 1 : 0; // breakthrough: centerpiece!!!

		$bonus_total += $member_level >= member_max_level($i_i, $harvest_type) ?
			$settings_harvest->{$harvest_type . '_harvest_' . $i_i . '_bonus'} : 0;
	}

	// max member for last level, with slot
	$member_max_fill = member_max_fill($level_last_fill, $harvest_type);

	$user_harvest = user_harvest($id, $harvest_type);

	$user = get_user($user_harvest->user_id);

	$user_harvest_last = user_harvest_last($user->id, $harvest_type);

	$bonus_harvest_last = $user_harvest_last->{'bonus_harvest_' . $harvest_type . '_last'};

	return (($bonus_total > $bonus_harvest_last &&
		$member_total_now === $member_max_fill) ? $bonus_total : 0);
}

/**
 * @param $user
 * @param $harvest_type
 *
 * @return string
 *
 * @since version
 */
function view($user, $harvest_type): string
{
	$settings_plans   = settings('plans');
	$settings_harvest = settings('harvest');

	$str = '';

	$alias_type = 'Bronze';
	$sef        = sef(23);

	if ($harvest_type === 'associate')
	{
		$alias_type = 'Silver';
		$sef        = sef(22);
	}

	if ($settings_harvest->{$harvest_type . '_harvest_level'} &&
		$user->account_type !== 'starter' &&
		(count(get_directs($user->id)) >= $settings_harvest->{$harvest_type . '_harvest_sponsored'} ||
			$user->usertype === 'Admin'))
	{
		$str .= '<h3>' . ucwords($alias_type . ' ' . $settings_plans->harvest_name) .
			'<span style="float: right"><a href="' . $sef . qs() .
			'uid=' . $user->id . '" style="font-size: medium">View Genealogy</a></span></h3>
        <table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>
                    <div style="text-align: center"><h4>Level</h4></div>
                </th>
                <th>
                    <div style="text-align: center"><h4>Member</h4></div>
                </th>' .
			'<th>
                    <div style="text-align: center"><h4>Bonus (' . settings('ancillaries')->currency . ')</h4></div>
                </th>' .
			'</tr>
            </thead>
            <tbody>';

		$type_level = $settings_harvest->{$harvest_type . '_harvest_level'};

		$bonus_total = 0;

		for ($i_i = 1; $i_i <= $type_level; $i_i++)
		{
			$member_level     = member_level($user->id, $i_i, $harvest_type);
			$member_max_level = member_max_level($i_i, $harvest_type);

			$settings_level_bonus = $settings_harvest->{$harvest_type . '_harvest_' . $i_i . '_bonus'};

			$level_bonus = $member_level >= $member_max_level ? $settings_level_bonus : 0;

			$bonus_total += $level_bonus;

			$str .= '<tr>
                    <td>
                        <div style="text-align: center"><strong>' . $i_i . '</strong></div>
                    </td>
                    <td>
                        <div style="text-align: center">' . $member_level . '</div>
                    </td>' .
				'<td>
                        <div style="text-align: center">' . number_format($level_bonus, 2) . '</div>
                    </td>' .
				'</tr>';
		}

		$str .= '<tr>
                <td>
                    <div style="text-align: center"><strong>Total</strong></div>
                </td>
                <td>
                    <div style="text-align: center">' . member_total($user->id, $harvest_type) . '</div>
                </td>' .
			'<td>
                    <div style="text-align: center">' .
			number_format($bonus_total, 2) . '</div>
                </td>' .
			'</tr>
            </tbody>
        </table>';
	}
	else
	{
		$str .= '<h3 style="alignment: center">Sponsor At Least ' .
			$settings_harvest->{$alias_type . '_harvest_sponsored'} .
			' Paid Accounts To Enable Your ' . ucwords($settings_plans->harvest_name) . '!</h3>';
	}

	return $str;
}

/**
 * @param           $user_id
 * @param   string  $harvest_type
 *
 * @return mixed|null
 *
 * @since version
 */
function harvest_type_user($user_id, string $harvest_type = 'basic')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_harvest_' . $harvest_type .
		' WHERE user_id = ' . $db->quote($user_id) .
		' AND has_mature = ' . $db->quote(0) .
		' AND is_active = ' . $db->quote(1)
	)->loadObject();
}

/**
 * @param $sponsor_id
 *
 * @return array|mixed
 *
 * @since version
 */
function get_directs($sponsor_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT id ' .
		'FROM network_users ' .
		'WHERE id NOT IN ' .
		'(SELECT id ' .
		'FROM network_commission_deduct) ' .
		'AND account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($sponsor_id)
	)->loadObjectlist();
}

/**
 * @param $harvest_type
 *
 * @return array|mixed
 *
 * @since version
 */
function user_harvest_type($harvest_type)
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_harvest_' . $harvest_type
	)->loadObjectList();
}

/**
 * @param $harvest_id
 * @param $harvest_type
 *
 * @return mixed|null
 *
 * @since version
 */
function user_harvest($harvest_id, $harvest_type)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_harvest_' . $harvest_type .
		' WHERE id = ' . $db->quote($harvest_id) .
		' AND has_mature = ' . $db->quote(0) .
		' AND is_active = ' . $db->quote(1)
	)->loadObject();
}

/**
 * @param $user_id
 * @param $harvest_type
 *
 * @return mixed|null
 *
 * @since version
 */
function user_harvest_last($user_id, $harvest_type)
{
	$db = db();

	return $db->setQuery(
		'SELECT bonus_harvest_' . $harvest_type . '_last ' .
		'FROM network_harvest ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param           $upline_id
 * @param   string  $harvest_type
 *
 * @return array|mixed
 *
 * @since version
 */
function downlines($upline_id, string $harvest_type = 'basic')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_harvest_' . $harvest_type .
		' WHERE harvest_upline_id = ' . $db->quote($upline_id) .
		' AND has_mature = ' . $db->quote(0) .
		' AND is_active = ' . $db->quote(1)
	)->loadObjectlist();
}