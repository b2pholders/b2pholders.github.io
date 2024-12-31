<?php

namespace BPL\Binary_Product;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/binary/capping.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Binary\Capping\main as capping_limit;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\time;

/**
 * @param         $user_id
 * @param         $p_id
 * @param         $p_name
 * @param         $p_points
 * @param         $p_position
 *
 *
 * @since version
 */
function main($user_id, $p_id, $p_name, $p_points, $p_position)
{
	$user = user_binary($user_id);

	while ($user->user_id > 0)
	{
		if (has_binary($user, $p_points))
		{
			if (has_pairing($user, $p_position))
			{
				$pairing = pairing($user, $p_id, $p_name, $p_points, $p_position);

				if ($pairing)
				{
					set_binary_status($user_id, $p_points);
				}
			}
			else
			{
				no_pairing($user, $p_id, $p_name, $p_points, $p_position);
			}
		}

		$p_position = $user->position;
		$user       = user_binary($user->upline_id);

		if (!$user)
		{
			break;
		}
	}
}

function user_cd($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_commission_deduct ' .
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
}

function set_binary_status(/*$user, */ $user_id, $p_points)
{
	$user = user_binary($user_id);

	$settings_binary = settings('binary');

	$flushout = $settings_binary->hedge === 'flushout';

	$status = $user->status;

	$account_type = $user->account_type;

	$capping_pairs  = $settings_binary->{$account_type . '_max_pairs'};
	$maximum_income = $settings_binary->{$account_type . '_maximum_income'};

	if (($status === 'active' &&
			((!$flushout && ($user->capping_cycle /*+ $p_points*/) >= $capping_pairs)/* ||
			($flushout && ($user_binary->ctr_left >= $capping_pairs &&
					$user_binary->ctr_right >= $capping_pairs))*/))
		|| (/*$status === 'reactivated' &&*/ $maximum_income && ($user->income_cycle /*+ $p_points*/) >= $maximum_income))
	{
		$status = /*($status === 'reactivated'
			&& $maximum_income
			&& $user->income_cycle >= $maximum_income) ? 'graduate' :*/
			'inactive';

		update_status_binary($user, $status);
		logs_status_binary($user, $p_points, $status);
	}
}

function update_status_binary($user, $status)
{
	$db = db();

	update('network_binary',
		['status = ' . $db->quote($status),
			'direct_cycle = ' . $db->quote(0),
			'status_cycle = ' . $db->quote(0)/*,
            'ctr_left = ' . $db->quote(0),
            'ctr_right = ' . $db->quote(0)*/],
		['user_id = ' . $db->quote($user->user_id)]);
}

function logs_status_binary($user, $p_points, $status)
{
	$pairs_add_actual = pairs_add_actual($user, $p_points);

	$activity = '<b>Binary Deactivated: </b>Binary Status set to ' . $status . ' for <a href="' . sef(44) .
		qs() . 'uid=' . $user->user_id . '">' . $user->username . '</a>. Pairing: ' .
		number_format($pairs_add_actual, 2) . ' ' . settings('ancillaries')->currency . '<br>';

	$db = db();

	insert('network_activity',
		['user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'],
		[$db->quote($user->user_id),
			$db->quote($user->sponsor_id),
			$db->quote($user->user_id),
			$db->quote($activity),
			$db->quote(time())]
	);
}

function has_binary($user, $p_points): bool
{
	$sb = settings('binary');

	$flushout = $sb->hedge === 'flushout';

	$reactivate_count = $user->reactivate_count;

	$account_type = $user->account_type;

	$upline_max_income = $sb->{$account_type . '_maximum_income'};
	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	$status = $user->status;

	$pairs_value = pairs_value($user, $p_points);

	return (
		empty(user_cd($user->user_id))
		&& (($upline_max_income &&
				($user->income_cycle + $pairs_value) <= $upline_max_income)
			|| !$upline_max_income)
		&& (!$flushout && ($status === 'active'/* || $status === 'reactivated'*/)) || $flushout
		&& $reactivate_count <= $capping_cycle_max
	);
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user
 *
 * @return array|mixed
 *
 * @since version
 */
function directs($user)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($user->user_id)
	)->loadObjectList();
}

/**
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function left_pairs($user)
{
	return user_binary($user->user_id)->ctr_left;
}

/**
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function right_pairs($user)
{
	return user_binary($user->user_id)->ctr_right;
}

/**
 * @param $user
 * @param $position
 *
 * @return bool
 *
 * @since version
 */
function has_pairing($user, $position): bool
{
	$left_pairs  = left_pairs($user);
	$right_pairs = right_pairs($user);

	return ((($position === 'Left') && ($right_pairs > $left_pairs)) ||
		(($position === 'Right') && ($left_pairs > $right_pairs)));
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function max_pairs_add($user)
{
	return abs($user->ctr_left - $user->ctr_right);
}

function pairs_value($user, $p_points)
{
	$settings_binary = settings('binary');

	$upline_income_cycle = $user->income_cycle;

	$upline_max_income = $settings_binary->{$user->account_type . '_maximum_income'};

	if (($upline_income_cycle + $p_points) >= $upline_max_income)
	{
		return non_zero($upline_max_income - $upline_income_cycle);
	}

	return $p_points;
}

/**
 * @param $user
 * @param $p_points
 *
 * @return float|int|mixed
 *
 * @since version
 */
function pairs_add_actual($user, $p_points)
{
	$pairs_value   = pairs_value($user, $p_points);
	$max_pairs_add = max_pairs_add($user);

	$val = $pairs_value > $max_pairs_add ? $max_pairs_add : $pairs_value;

	return capping_limit($user->user_id, $val);
}

/**
 * @param $user
 * @param $p_points
 *
 * @return float|int|mixed
 *
 * @since version
 */
function pairs_add_limit($user, $p_points)
{
	$pairs_value   = pairs_value($user, $p_points);
	$max_pairs_add = max_pairs_add($user);

	$val = $pairs_value > $max_pairs_add ? $max_pairs_add : $pairs_value;

	return capping_limit($user->user_id, $val);
}

/**
 * @param $user
 * @param $p_id
 * @param $p_name
 * @param $p_points
 * @param $p_position
 *
 *
 * @return false|mixed
 * @since version
 */
function pairing($user, $p_id, $p_name, $p_points, $p_position)
{
	$pairs_add_actual = pairs_add_actual($user, $p_points);
//	$pairs_add_actual = deduct($pairs_add_actual, $user->user_id);

	$pairs_add_limit = pairs_add_limit($user, $p_points);

	$nth_pair = upline_pairs_safety($user) ? nth_pair($user, $pairs_add_actual) : 0;

	$flushout = flush_out(
		$pairs_add_limit,
		$pairs_add_actual,
		$nth_pair,
		$user
	);

	$pairing = pairing_update_binary(
		$user,
		$p_position,
		$p_points,
		$pairs_add_actual,
		$pairs_add_limit,
		$nth_pair,
		$flushout
	);

	if ($pairing)
	{
		$update_user = pairing_update_user($user, $pairs_add_limit, $nth_pair);

		if ($update_user)
		{
			return logs_pairing($user, $p_id, $p_name, $p_points, $p_position, $pairs_add_actual);
		}
	}

	return false;
}

/**
 * @param $user
 * @param $pairs_add_limit
 * @param $nth_pair
 *
 *
 * @return false|mixed
 * @since version
 */
function pairing_update_user($user, $pairs_add_limit, $nth_pair)
{
	$db = db();

	$field_user = ['points = points + ' . $nth_pair];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . cd_filter($user->user_id, $pairs_add_limit);
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . cd_filter($user->user_id, $pairs_add_limit);
	}

	return update('network_users',
		$field_user,
		['id = ' . $db->quote($user->user_id)]);
}

function pairing_update_binary(
	$user,
	$p_position,
	$p_points,
	$pairs_add_actual,
	$pairs_add_limit,
	$nth_pair,
	$flushout
)
{
	$db = db();

//	$pairs_value = pairs_value($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	if ($p_points > 0)
	{
		return update('network_binary',
			['income_cycle = income_cycle + ' . $pairs_add_limit,
				'pairs_5th = pairs_5th + ' . $nth_pair,
				'income_giftcheck = income_giftcheck + ' . $nth_pair,
				'pairs = pairs + ' . $pairs_add_limit,
				'income_flushout = income_flushout + ' . $flushout,
				'pairs_today = pairs_today + ' . $pairs_add_actual,
				'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
				'capping_cycle = capping_cycle + ' . $pairs_add_limit,
				($p_position === 'Left' ? 'ctr_left = ctr_left' :
					'ctr_right = ctr_right') . ' + ' . $p_points],
			['user_id = ' . $db->quote($user->user_id)]);
	}

	return false;
}

function upline_pairs_safety($user)
{
	return settings('binary')->{$user->account_type . '_pairs_safety'};
}

function upline_max_cycle($user)
{
	return settings('binary')->{$user->account_type . '_max_cycle'};
}

function upline_pairs($user)
{
	return $user->pairs;
}

function nth_pair($user, $pairs_add_actual)
{
	$upline_pairs_safety = upline_pairs_safety($user);

	$remainder = $pairs_add_actual % $upline_pairs_safety;
	$divisible = $pairs_add_actual - $remainder;

	$nth_pair_partial = $upline_pairs_safety ? $divisible / $upline_pairs_safety : 0;

	return $user->status === 'active' ? $nth_pair_partial : 0;
}

function flush_out(&$pairs_add_limited, $pairs_add_actual, $nth_pair, $user): string
{
	$max_cycle   = settings('binary')->{$user->account_type . '_max_cycle'};
	$pairs_today = $user->pairs_today;

	$flushout = 0;

	if ($max_cycle > 0)
	{
		if ($pairs_today < $max_cycle)
		{
			if (($pairs_today + $pairs_add_actual) <= $max_cycle)
			{
				$pairs_add_limited = abs($pairs_add_limited - $nth_pair);
			}
			else
			{
				if ($pairs_add_actual > $max_cycle)
				{
					$pairs_add_limited = $max_cycle;
					$flushout          = non_zero($max_cycle - $pairs_add_actual);
				}
				else
				{
					$pairs_add_limited = non_zero($max_cycle - $pairs_today);
				}
			}
		}
		else
		{
			$pairs_add_limited = 0;
			$flushout          = $pairs_add_actual;
		}
	}

	return $flushout;
}

function non_zero($value)
{
	return $value < 0 ? 0 : $value;
}

function logs_pairing($user, $p_id, $p_name, $p_points, $p_position, $pairs_add_actual)
{
	$settings_ancillaries = settings('ancillaries');
	$settings_plans       = settings('plans');

	$currency = $settings_ancillaries->currency;

	if ($pairs_add_actual)
	{
		$activity = '<b>' . $settings_plans->binary_pair_name . ': </b> <a href="' .
			sef(44) . qs() . 'uid=' . $user->user_id . '">' . $user->username . '</a> gained ' .
			number_format($pairs_add_actual, 2) . ' pts. for purchasing <a href="' .
			sef(9) . qs() . 'uid=' . $p_id . '" target="_blank">' . $p_name .
			'</a>. <br>Balance added: ' . number_format($pairs_add_actual, 2) . ' ' . $currency;
	}
	else
	{
		$activity = '<b>Points added </b> to <a href="' . sef(44) . qs() . 'uid=' . $user->user_id . '">' .
			$user->username . '</a> for purchasing <a href="' . sef(9) . qs() . 'uid=' . $p_id .
			'" target="_blank">' . $p_name . '</a>. <br>';

		$activity .= (($p_position === 'Left') ?
			('Group A: + ' . number_format($p_points, 2) . ' pts.') :
			('Group B: + ' . number_format($p_points, 2) . ' pts.'));
	}

	return activity_dump($user, $activity);
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
 * @param $user
 * @param $p_id
 * @param $p_name
 * @param $p_points
 * @param $p_position
 *
 *
 * @since version
 */
function no_pairing($user, $p_id, $p_name, $p_points, $p_position)
{
	no_pairing_update_binary($user, $p_points, $p_position);

	logs_no_pairing($user, $p_id, $p_name, $p_points, $p_position);
}

function no_pairing_update_binary($user, $p_points, $p_position)
{
//	$pairs_value = pairs_value($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	if ($p_points > 0)
	{
		update('network_binary',
			[($p_position === 'Left' ? 'ctr_left = ctr_left' : 'ctr_right = ctr_right') . ' + ' . $p_points],
			['user_id = ' . db()->quote($user->user_id)]);
	}
}

function logs_no_pairing($user, $p_id, $p_name, $p_points, $p_position)
{
	$activity = '<b>Points added </b> to <a href="' . sef(9) . qs() . 'uid=' . $user->user_id . '">' .
		$user->username . '</a> for the purchase of <a href="' . sef(9) . qs() . 'uid=' . $p_id .
		'" target="_blank">' . $p_name . '</a>.';

	$activity .= (($p_position === 'Left') ? ('<br>Group A: + ' .
		number_format($p_points, 2) . ' pts.') :
		('<br>Group B: + ' . number_format($p_points, 2) . ' pts.'));

	activity_dump($user, $activity);
}

/**
 * @param $user
 * @param $activity
 *
 *
 * @return false|mixed
 * @since version
 */
function activity_dump($user, $activity)
{
	$db = db();

	return insert('network_activity',
		['user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'],
		[$db->quote($user->user_id),
			$db->quote($user->sponsor_id),
			$db->quote($user->user_id),
			$db->quote($activity),
			$db->quote(time())]);
}