<?php

namespace BPL\Binary_Redundant;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/binary/capping.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

//use function BPL\Upline_Support\main as upline_support;
//use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Binary\Capping\main as capping_limit;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\time;

/**
 * @param         $user_id
 *
 * @param         $process_type
 *
 * @since version
 */
function main($user_id, $process_type)
{
	$user = user_binary($user_id);

	while ($user->upline_id > 0)
	{
		$upline = user_binary($user->upline_id);

		if (has_binary($upline))
		{
			$position = $user->position;

			if (has_pairing($upline, $position))
			{
				if (pairing($user, $process_type))
				{
					set_binary_status($upline, $process_type);
				}
			}
			else
			{
				no_pairing($user, $process_type);
			}
		}

		$user = user_binary($user->upline_id);

		if (!$user)
		{
			break;
		}
	}
}

function set_binary_status($upline, $process_type)
{
	$settings_binary = settings('binary');

	$flushout = $settings_binary->hedge === 'flushout';

	$status = $upline->status;

	$account_type = $upline->account_type;

	$capping_pairs  = $settings_binary->{$account_type . '_max_pairs'};
	$maximum_income = $settings_binary->{$account_type . '_maximum_income'};

	if (($status === 'active' &&
			((!$flushout && $upline->capping_cycle >= $capping_pairs)/* ||
			($flushout && ($user_binary->ctr_left >= $capping_pairs &&
					$user_binary->ctr_right >= $capping_pairs))*/))
		|| (/*$status === 'reactivated' &&*/ $maximum_income && $upline->income_cycle >= $maximum_income))
	{
		$status = /*($status === 'reactivated'
			&& $maximum_income
			&& $user->income_cycle >= $maximum_income) ? 'graduate' :*/
			'inactive';

		update_status_binary($upline, $status);
		logs_status_binary($upline, $status, $process_type);
	}
}

function update_status_binary($upline, $status)
{
	$db = db();

	update('network_binary',
		['status = ' . $db->quote($status),
			'direct_cycle = ' . $db->quote(0),
			'status_cycle = ' . $db->quote(0)/*,
            'ctr_left = ' . $db->quote(0),
            'ctr_right = ' . $db->quote(0)*/],
		['user_id = ' . $db->quote($upline->user_id)]);
}

function logs_status_binary($user, $status, $process_type = 'reactivate')
{
	$upline_id = $user->upline_id;
	$upline    = user_binary($upline_id);

	$pairs_add_actual = pairs_add_actual($user);

	$root_query = sef(44) . qs();

	$upline_link = "<a href=\"{$root_query}uid=$upline_id\" target=\"_blank\">$upline->username</a>";
	$user_link   = "<a href=\"{$root_query}uid=$user->user_id\" target=\"_blank\">$upline->username</a>";

	$process_type = $process_type === 'reactivate' ? 'reactivation' : 'upgrade';

	$pairs_add_actual = number_format($pairs_add_actual, 2);

	$currency = settings('ancillaries')->currency;

	$activity = "<b>Binary Deactivated:</b> Binary Status for $upline_link is set to $status 
		due to $user_link's $process_type. Pairing: $pairs_add_actual $currency<br>";

	$db = db();

	insert('network_activity',
		['user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'],
		[$db->quote($upline_id),
			$db->quote($upline->sponsor_id),
			$db->quote($upline->upline_id),
			$db->quote($activity),
			$db->quote(time())]
	);
}

/**
 * @param $upline
 *
 * @return bool
 *
 * @since version
 */
function has_binary($upline): bool
{
	$sb = settings('binary');

	$flushout = $sb->hedge === 'flushout';

	$reactivate_count = $upline->reactivate_count;

	$account_type = $upline->account_type;

	$upline_max_income = $sb->{$account_type . '_maximum_income'};
	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	$status = $upline->status;

	$pairs_value = pairs_value($upline);

	return ((($upline_max_income &&
				($upline->income_cycle + $pairs_value) <= $upline_max_income)
			|| !$upline_max_income)
		&& ((!$flushout && ($status === 'active'/* || $status === 'reactivated'*/)) || $flushout)
		&& ($reactivate_count <= $capping_cycle_max));
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
 * @param $upline
 * @param $position
 *
 * @return bool
 *
 * @since version
 */
function has_pairing($upline, $position): bool
{
	$left_pairs  = left_pairs($upline);
	$right_pairs = right_pairs($upline);

	return ($position === 'Left' && $right_pairs > $left_pairs) ||
		($position === 'Right' && $left_pairs > $right_pairs);
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

/**
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function pairs_value($user)
{
	$settings_binary = settings('binary');

	$upline_id     = $user->upline_id;
	$upline_binary = user_binary($upline_id);

	$user_account_type   = $user->account_type;
	$upline_account_type = $upline_binary->account_type;

	$status = $upline_binary->status;

	$insert_pairs = $settings_binary->{$user_account_type . '_pairs'};
	$upline_pairs = $settings_binary->{$upline_account_type . '_pairs'};

	$pairs_lim = $insert_pairs > $upline_pairs ? $upline_pairs : $insert_pairs;

	$upline_income_cycle = $upline_binary->income_cycle;

	$upline_max_income = $settings_binary->{$upline_account_type . '_maximum_income'};

	if (($upline_income_cycle + $pairs_lim) >= $upline_max_income)
	{
		$pairs_lim = non_zero($upline_max_income - $upline_income_cycle);
	}

	if (pair_upgradable($upline_id) && $status === 'active')
	{
		$pairs_proper = $settings_binary->{$user_account_type . '_pairs_proper'};
		$pairs_lim    = $pairs_lim > $pairs_proper ? $pairs_proper : $pairs_lim;
	}

	return $pairs_lim;
}

/**
 * @param $upline_id
 *
 * @return bool
 *
 * @since version
 */
function pair_upgradable($upline_id): bool
{
	$flushout = settings('binary')->hedge === 'flushout';

	$required_pairs   = required_pairs($upline_id);
	$required_directs = binary_directs($upline_id);

	return (!$flushout &&
		($required_pairs && user_binary($upline_id)->pairs >= $required_pairs) &&
		($required_directs && count(directs_valid($upline_id)) >= $required_directs) &&
		cycle_direct_status($upline_id));
}

/**
 * @param $upline_id
 *
 * @return bool
 *
 * @since version
 */
function cycle_direct_status($upline_id): bool
{
	$binary_directs = binary_directs($upline_id);

	return ((count(status_cycle_directs($upline_id)) >= $binary_directs) ||
		user_binary($upline_id)->direct_cycle >= $binary_directs);
}

/**
 * Array of directs with pairing that reaches capping value
 *
 * @param $upline_id
 *
 * @return array
 *
 * @since version
 */
function status_cycle_directs($upline_id): array
{
	$directs = directs_valid($upline_id);

	$status_cycle_directs = [];

	if (!empty($directs))
	{
		foreach ($directs as $direct)
		{
			$user_binary = user_binary($direct->id);
			$max_pairs   = settings('binary')->{$user_binary->account_type . '_max_pairs'};

			if ((int) $user_binary->status_cycle === 1 &&
				$user_binary->capping_cycle >= $max_pairs)
			{
				$status_cycle_directs[] = $direct->id;
			}
		}
	}

	return $status_cycle_directs;
}

/**
 * @param $upline_id
 *
 * @return array|mixed
 *
 * @since version
 */
function directs_valid($upline_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($upline_id)
	)->loadObjectList();
}

/**
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function required_pairs($upline_id)
{
	return settings('binary')->{user_binary($upline_id)->account_type . '_required_pairs'};
}

/**
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function binary_directs($upline_id)
{
	return settings('binary')->{user_binary($upline_id)->account_type . '_binary_sponsored'};
}

/**
 * @param $user
 *
 * @return float|int|mixed
 *
 * @since version
 */
function pairs_add_actual($user)
{
	$upline = user_binary($user->upline_id);

	$pairs_value   = pairs_value($user);
	$max_pairs_add = max_pairs_add($upline);

	$pairs_add_actual = $pairs_value > $max_pairs_add ? $max_pairs_add : $pairs_value;

	return capping_limit($upline->user_id, $pairs_add_actual);
}

/**
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function pairs_add_limit($user)
{
	$upline_id = $user->upline_id;
	$upline    = user_binary($upline_id);

	$pairs_value   = pairs_value($user);
	$max_pairs_add = max_pairs_add($upline);

	$pairs_add_limit = $pairs_value > $max_pairs_add ? $max_pairs_add : $pairs_value;

	return capping_limit($upline_id, $pairs_add_limit);
}

/**
 * @param $user
 * @param $process_type
 *
 * @return bool|mixed
 * @since version
 */
function pairing($user, $process_type)
{
	$upline = user_binary($user->upline_id);

	$pairs_add_actual = pairs_add_actual($user);
	$pairs_add_limit  = pairs_add_limit($user);

	$nth_pair = upline_pairs_safety($upline) ? nth_pair($upline, $pairs_add_actual) : 0;

	$flushout = flush_out($pairs_add_limit, $pairs_add_actual, $nth_pair, $upline);

	$pairing = pairing_update_binary($user, $pairs_add_actual, $pairs_add_limit, $nth_pair, $flushout);

	if ($pairing)
	{
		$update_user = pairing_update_user($upline, $pairs_add_limit, $nth_pair);

		if ($update_user)
		{
			return logs_pairing($upline, $pairs_add_limit, $user->position, $pairs_add_actual, $process_type);
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
		$field_user[] = 'balance = balance + ' . $pairs_add_limit;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $pairs_add_limit;
	}

	return update('network_users',
		$field_user,
		['id = ' . $db->quote($user->user_id)]);
}

/**
 * @param $user
 * @param $pairs_add_actual
 * @param $pairs_add_limit
 * @param $nth_pair
 * @param $flushout
 *
 * @return false|mixed
 * @since version
 */
function pairing_update_binary($user, $pairs_add_actual, $pairs_add_limit, $nth_pair, $flushout)
{
	$db = db();

	$upline_id = $user->upline_id;

	$sf = settings('freeze');
	$se = settings('entry');

	$upline_binary = user_binary($upline_id);

	$upline_account_type = $upline_binary->account_type;
	$income_cycle_global = $upline_binary->income_cycle_global;

	$entry  = $se->{$upline_account_type . '_entry'};
	$factor = $sf->{$upline_account_type . '_percentage'} / 100;

	$freeze_limit = $entry * $factor;

	$pairs_value = pairs_value($user);

	if ($income_cycle_global >= $freeze_limit)
	{
		$freeze = update(
			'network_binary',
			[
				'freeze_flushout = freeze_flushout + ' . $pairs_add_limit,
				'income_flushout = income_flushout + ' . $flushout,
				'pairs_today = pairs_today + ' . $pairs_add_actual,
				'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
				($user->position === 'Left' ? 'ctr_left = ctr_left' :
					'ctr_right = ctr_right') . ' + ' . $pairs_value
			],
			['user_id = ' . $db->quote($upline_id)]
		);

		if ($upline_binary->status_global === 'active' && $freeze)
		{
			update(
				'network_users',
				[
					'status_global = ' . $db->quote('inactive'),
					'income_flushout = income_flushout + ' . $pairs_add_limit
				],
				['id = ' . $db->quote($upline_id)]
			);
		}
	}
	else
	{
		$diff = $freeze_limit - $income_cycle_global;

		if ($diff < $pairs_add_limit)
		{
			$flushout_global = $pairs_add_limit - $diff;

			$freeze = update(
				'network_binary',
				[
					'freeze_flushout = freeze_flushout + ' . $flushout,
					'income_cycle = income_cycle + ' . $diff,
					'pairs_5th = pairs_5th + ' . $nth_pair,
					'income_giftcheck = income_giftcheck + ' . $nth_pair,
					'pairs = pairs + ' . $diff,
					'income_flushout = income_flushout + ' . $flushout,
					'pairs_today = pairs_today + ' . $pairs_add_actual,
					'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
					'capping_cycle = capping_cycle + ' . $diff,
					($user->position === 'Left' ? 'ctr_left = ctr_left' :
						'ctr_right = ctr_right') . ' + ' . $pairs_value
				],
				['user_id = ' . $db->quote($upline_id)]
			);

			if ($upline_binary->status_global === 'active' && $freeze)
			{
				update(
					'network_users',
					[
						'income_cycle_global = income_cycle_global + ' . $diff,
						'income_flushout = income_flushout + ' . $flushout_global,
						'status_global = ' . $db->quote('inactive')
					],
					['id = ' . $db->quote($upline_id)]
				);

				if ($diff > 0)
				{
					return pairing_update_user($upline_id, $diff, $nth_pair);
				}
			}
		}
		else
		{
			if ($pairs_value > 0)
			{
				$update = update('network_binary',
					[
						'income_cycle = income_cycle + ' . $pairs_add_limit,
						'pairs_5th = pairs_5th + ' . $nth_pair,
						'income_giftcheck = income_giftcheck + ' . $nth_pair,
						'pairs = pairs + ' . $pairs_add_limit,
						'income_flushout = income_flushout + ' . $flushout,
						'pairs_today = pairs_today + ' . $pairs_add_actual,
						'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
						'capping_cycle = capping_cycle + ' . $pairs_add_limit,
						($user->position === 'Left' ? 'ctr_left = ctr_left' :
							'ctr_right = ctr_right') . ' + ' . $pairs_value
					],
					[
						'user_id = ' . $db->quote($upline_id)
					]
				);

				if ($upline_binary->status_global === 'active' && $update)
				{
					$update = update(
						'network_users',
						['income_cycle_global = income_cycle_global + ' . $pairs_add_limit],
						['id = ' . $db->quote($upline_id)]
					);

					if ($update)
					{
						return pairing_update_user($upline_id, $pairs_add_limit, $nth_pair);
					}
				}
			}
		}
	}

	return false;
}

function upline_pairs_safety($user)
{
	return settings('binary')->{$user->account_type . '_pairs_safety'};
}

//function upline_max_cycle($user)
//{
//	return settings('binary')->{$user->account_type . '_max_cycle'};
//}

//function upline_pairs($user)
//{
//	return $user->pairs;
//}

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

function logs_pairing($user, $points, $position, $pairs_add_actual, $process_type = 'reactivate')
{
	$sa = settings('ancillaries');
	$sp = settings('plans');

	$currency = $sa->currency;

	$process_type = $process_type === 'reactivate' ? 'reactivation' : 'upgrade';

	$upline_id = $user->upline_id;
	$upline    = user($upline_id);

	$root_redirect = sef(44) . qs();
	$upline_link   = "<a href=\"{$root_redirect}uid=$upline->id\" target=\"_blank\">$upline->username</a>";
	$user_link     = "<a href=\"{$root_redirect}uid=$user->user_id\" target=\"_blank\">$user->username</a>";

	if ($pairs_add_actual)
	{
		$pairs_add_actual = number_format($pairs_add_actual, 2);

		$activity = "<b>$sp->binary_pair_name:</b> $upline_link gained $pairs_add_actual pts. from 
			$process_type of $user_link. <br>Balance Added: $pairs_add_actual $currency";
	}
	else
	{
		$points = number_format($points, 2);

		$activity = ">Points added to $upline_link from $process_type of $user_link.<br>";

		if ($position === 'Left')
		{
			$activity .= "Group A: + $points pts.";
		}
		else
		{
			$activity .= "Group B: + $points pts.";
		}
	}

	return activity_dump($upline, $activity);
}

///**
// * @param $value
// * @param $user_id
// *
// * @return int|mixed
// *
// * @since version
// */
//function deduct($value, $user_id)
//{
//	return cd_filter($user_id, upline_support($value, $user_id));
//}

/**
 * @param           $user
 * @param           $process_type
 *
 * @since version
 */
function no_pairing($user, $process_type)
{
	no_pairing_update_binary($user);
	logs_no_pairing($user, $process_type);
}

/**
 * @param $user
 *
 * @since version
 */
function no_pairing_update_binary($user)
{
	$upline_id = $user->upline_id;

	$pairs_value = pairs_value($user);

	if ($pairs_value > 0)
	{
		update('network_binary',
			[($user->position === 'Left' ? 'ctr_left = ctr_left' :
					'ctr_right = ctr_right') . ' + ' . $pairs_value],
			['user_id = ' . db()->quote($upline_id)]);
	}
}

/**
 * @param           $user
 * @param   string  $process_type
 *
 * @since version
 */
function logs_no_pairing($user, $process_type = 'reactivate')
{
	$upline_id = $user->upline_id;

	$upline = user_binary($upline_id);

	$pairs_value = pairs_value($user);

	if ($pairs_value > 0)
	{
		$root_query = sef(44) . qs();

		$upline_link = "<a href=\"{$root_query}uid=$upline_id\" target=\"_blank\">{$upline->username}</a>";
		$user_link   = "<a href=\"{$root_query}uid=$user->user_id\" target=\"_blank\">{$user->username}</a>";

		$group = $user->position === 'Left' ? 'A' : 'B';

		$process_type = $process_type === 'reactivate' ? 'reactivation' : 'upgrade';

		$activity = "<b>Points added</b> to $upline_link's Group $group from $user_link's $process_type<br>";

		$pairs_value = number_format($pairs_value, 2);

		if ($user->position === 'Left')
		{
			$activity .= "Group A: + $pairs_value pts.";
		}
		else
		{
			$activity .= "Group B: + $pairs_value pts.";
		}

		$db = db();

		insert('network_activity',
			[
				'user_id',
				'sponsor_id',
				'upline_id',
				'activity',
				'activity_date'
			],
			[
				$db->quote($upline_id),
				$db->quote($upline->sponsor_id),
				$db->quote($upline->upline_id),
				$db->quote($activity),
				$db->quote(time())
			]
		);
	}
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
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user->user_id),
			$db->quote($user->sponsor_id),
			$db->quote($user->user_id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}