<?php

namespace BPL\Mods\Binary\Core;

//require_once 'bpl/mods/income.php';
require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/binary/capping.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

//use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

//use function BPL\Mods\Income\main as income_global;

use function BPL\Mods\Binary\Capping\main as capping_limit;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\time;

/**
 * @param           $insert_id
 * @param   string  $prov  code || activate || upgrade
 * @param   bool    $is_insert_cd
 * @param   string  $account_type_old
 * @param   string  $account_type_new
 *
 * @since version
 */
function main(
	$insert_id,
	string $prov = 'code',
	$is_insert_cd = false,
	string $account_type_old = '',
	string $account_type_new = ''
) {
	$downline = user_binary($insert_id);
	$upline_id = $downline->upline_id;

	while ($upline_id > 0) {
		if (
			!$is_insert_cd
			//			&& empty(user_cd($downline->user_id))
			&& has_binary($insert_id, $upline_id, $prov, $account_type_old, $account_type_new)
		) {
			if (has_pairing($downline, $upline_id)) {
				$pairing = pairing($insert_id, $upline_id, $downline, $prov, $account_type_old, $account_type_new);

				if ($pairing) {
					set_binary_status($insert_id, $upline_id, $prov, $account_type_old, $account_type_new);
				}
			} else {
				no_pairing($insert_id, $upline_id, $downline, $prov, $account_type_old, $account_type_new);
			}
		}

		$downline = user_binary($upline_id);
		$upline_id = $downline->upline_id;

		if (!$upline_id) {
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

/**
 * @param $insert_id
 * @param $upline_id
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @return bool
 *
 * @since version
 */
function has_binary($insert_id, $upline_id, $prov, $account_type_old, $account_type_new): bool
{
	$sf = settings('freeze');
	$sb = settings('binary');

	$flushout = $sb->hedge === 'flushout';

	$upline_binary = user_binary($upline_id);

	$reactivate_count = $upline_binary->reactivate_count;

	$account_type = $upline_binary->account_type;
	$income_cycle_global = $upline_binary->income_cycle_global;

	$upline_max_income = $sb->{$account_type . '_maximum_income'};
	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	$status = get_binary_status($upline_id);

	$se = settings('entry');

	$factor = $sf->{$account_type . '_percentage'} / 100;
	$entry = $se->{$upline_binary->account_type . '_entry'};

	$freeze_limit = $entry * $factor;

	$pairs_value = pairs_value(user($insert_id), $upline_id);

	$cycle_new = $upline_binary->income_cycle + $pairs_value;

	return (
			//		empty(user_cd($upline_id))
			/*&&*/ (($upline_max_income && $cycle_new <= $upline_max_income) || !$upline_max_income)
		&& ((!$flushout && ($status === 'active'/* || $status === 'reactivated'*/)) || $flushout)
		&& $reactivate_count <= $capping_cycle_max
		&& /*$income_global*/ $income_cycle_global < $freeze_limit
	);
}

/**
 * @param $username
 *
 * @return array|mixed
 *
 * @since version
 */
function user_username($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username)
	)->loadObject();
}

/**
 * @param           $insert_id
 * @param           $upline_id
 * @param           $downline
 * @param           $prov
 * @param           $account_type_old
 * @param           $account_type_new
 *
 * @return false|mixed
 * @since version
 */
function pairing($insert_id, $upline_id, $downline, $prov, $account_type_old, $account_type_new)
{
	$insert_user = user($insert_id);

	$nth_pair = upline_pairs_safety($upline_id) ?
		nth_pair($insert_user, $upline_id, $prov, $account_type_old, $account_type_new) : 0;

	$pairs_add_actual = pairs_add_actual($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);
	$pairs_add_limit = pairs_add_limit($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	$flushout = flush_out(
		$pairs_add_limit,
		$pairs_add_actual,
		$nth_pair,
		$upline_id
	);

	$pairing = pairing_update_binary(
		$insert_user,
		$upline_id,
		$downline,
		$pairs_add_actual,
		$pairs_add_limit,
		$nth_pair,
		$flushout,
		$prov,
		$account_type_old,
		$account_type_new
	);

	if ($pairing) {
		//		$update_user = pairing_update_user($upline_id, $pairs_add_limit, $nth_pair);

		//		if ($update_user)
//		{
		return logs_pairing(
			$insert_user,
			$upline_id,
			$downline,
			$flushout,
			$nth_pair,
			$prov,
			$account_type_old,
			$account_type_new
		);
		//		}
	}

	return false;
}

/**
 * @param $value
 * @param $user_id
 *
 * @return int|mixed
 *
 * @since version
 */
//function deduct($value, $user_id)
//{
//	return cd_filter($user_id, upline_support($value, $user_id));
//}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $downline
 * @param $pairs_add_actual
 * @param $pairs_add_limit
 * @param $nth_pair
 * @param $flushout
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @return false|mixed
 * @since version
 */
function pairing_update_binary(
	$insert_user,
	$upline_id,
	$downline,
	$pairs_add_actual,
	$pairs_add_limit,
	$nth_pair,
	$flushout,
	$prov,
	$account_type_old,
	$account_type_new
) {
	$db = db();

	//	$sp = settings('plans');
//	$sf = settings('freeze');
//	$se = settings('entry');

	//	$saf = $sp->account_freeze;

	$user_binary = user_binary($upline_id);

	//	$account_type        = $user_binary->account_type;
//	$income_cycle_global = $user_binary->income_cycle_global;

	//	$entry  = $se->{$account_type . '_entry'};
//	$factor = $sf->{$account_type . '_percentage'} / 100;

	//	$freeze_limit = $entry * $factor;

	$pairs_value = pairs_value($insert_user, $upline_id);

	//	if ($income_cycle_global >= $freeze_limit)
//	{
//		$freeze = update(
//			'network_binary',
//			[
//				'freeze_flushout = freeze_flushout + ' . $pairs_add_limit,
//				'income_flushout = income_flushout + ' . $flushout,
//				'pairs_today = pairs_today + ' . $pairs_add_actual,
//				'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
//				($downline->position === 'Left' ? 'ctr_left = ctr_left' :
//					'ctr_right = ctr_right') . ' + ' . $pairs_value
//			],
//			['user_id = ' . $db->quote($upline_id)]
//		);
//
//		if ($user_binary->status_global === 'active' && $freeze)
//		{
//			update(
//				'network_users',
//				[
//					'status_global = ' . $db->quote('inactive'),
//					'income_flushout = income_flushout + ' . $pairs_add_limit
//				],
//				['id = ' . $db->quote($upline_id)]
//			);
//		}
//	}
//	else
//	{
//		$diff = $freeze_limit - $income_cycle_global;
//
//		if ($diff < $pairs_add_limit)
//		{
//			$flushout_global = $pairs_add_limit - $diff;
//
//			$freeze = update(
//				'network_binary',
//				[
//					'freeze_flushout = freeze_flushout + ' . $flushout,
//					'income_cycle = income_cycle + ' . $diff,
//					'pairs_5th = pairs_5th + ' . $nth_pair,
//					'income_giftcheck = income_giftcheck + ' . $nth_pair,
//					'pairs = pairs + ' . $diff,
//					'income_flushout = income_flushout + ' . $flushout,
//					'pairs_today = pairs_today + ' . $pairs_add_actual,
//					'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
//					'capping_cycle = capping_cycle + ' . $diff,
//					($downline->position === 'Left' ? 'ctr_left = ctr_left' :
//						'ctr_right = ctr_right') . ' + ' . $pairs_value
//				],
//				['user_id = ' . $db->quote($upline_id)]
//			);
//
//			if ($user_binary->status_global === 'active' && $freeze)
//			{
//				update(
//					'network_users',
//					[
//						'income_cycle_global = income_cycle_global + ' . /*cd_filter($upline_id, */$diff/*)*/,
//						'income_flushout = income_flushout + ' . $flushout_global,
//						'status_global = ' . $db->quote('inactive')
//					],
//					['id = ' . $db->quote($upline_id)]
//				);
//
//				if ($diff > 0)
//				{
//					return pairing_update_user($upline_id, $diff, $nth_pair);
//				}
//			}
//		}
//		else
//		{
	if ($pairs_value > 0) {
		$update = update(
			'network_binary',
			[
				'income_cycle = income_cycle + ' . $pairs_add_limit,
				'pairs_5th = pairs_5th + ' . $nth_pair,
				'income_giftcheck = income_giftcheck + ' . $nth_pair,
				'pairs = pairs + ' . $pairs_add_limit,
				'income_flushout = income_flushout + ' . $flushout,
				'pairs_today = pairs_today + ' . $pairs_add_actual,
				'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
				'capping_cycle = capping_cycle + ' . $pairs_add_limit,
				($downline->position === 'Left' ? 'ctr_left = ctr_left' :
					'ctr_right = ctr_right') . ' + ' . $pairs_value
			],
			[
				'user_id = ' . $db->quote($upline_id)
			]
		);

		//				if ($user_binary->status_global === 'active' && $update)
//				{
//					$update = update(
//						'network_users',
//						['income_cycle_global = income_cycle_global + ' . /*cd_filter($upline_id, */$pairs_add_limit/*)*/],
//						['id = ' . $db->quote($upline_id)]
//					);

		if ($update) {
			return pairing_update_user($upline_id, $pairs_add_limit, $nth_pair);
		}
		//				}
	}
	//		}
//	}

	return false;
}

/**
 * @param $upline_id
 * @param $bonus
 * @param $nth_pair
 *
 * @return false|mixed
 *
 * @since version
 */
function pairing_update_user($upline_id, $bonus, $nth_pair)
{
	$db = db();

	$field_user = ['points = points + ' . $nth_pair];

	$bonus = cd_filter($upline_id, $bonus);

	if (settings('ancillaries')->withdrawal_mode === 'standard') {
		$field_user[] = 'balance = balance + ' . $bonus;
	} else {
		$field_user[] = 'payout_transfer = payout_transfer + ' . $bonus;
	}

	return update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($upline_id)]
	);
}

/**
 * @param           $insert_id
 * @param           $upline_id
 * @param           $downline
 * @param           $prov
 * @param           $account_type_old
 * @param           $account_type_new
 *
 * @since version
 */
function no_pairing($insert_id, $upline_id, $downline, $prov, $account_type_old, $account_type_new)
{
	$insert_user = user($insert_id);

	no_pairing_update_binary($insert_user, $upline_id, $downline, $prov, $account_type_old, $account_type_new);
	logs_no_pairing($insert_user, $upline_id, $downline, $prov, $account_type_old, $account_type_new);
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $downline
 *
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @since version
 */
function no_pairing_update_binary($insert_user, $upline_id, $downline, $prov, $account_type_old, $account_type_new)
{
	$pairs_value = pairs_value($insert_user, $upline_id);

	if ($pairs_value > 0) {
		update(
			'network_binary',
			[
				($downline->position === 'Left' ? 'ctr_left = ctr_left' :
					'ctr_right = ctr_right') . ' + ' . $pairs_value
			],
			['user_id = ' . db()->quote($upline_id)]
		);
	}
}

/**
 * @param $insert_id
 * @param $upline_id
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @since version
 */
function set_binary_status($insert_id, $upline_id, $prov, $account_type_old, $account_type_new)
{
	$insert_user = user($insert_id);

	$settings_binary = settings('binary');

	$flushout = $settings_binary->hedge === 'flushout';

	$user_binary = user_binary($upline_id);

	$status = $user_binary->status;

	$account_type = $user_binary->account_type;

	$capping_pairs = $settings_binary->{$account_type . '_max_pairs'};
	$maximum_income = $settings_binary->{$account_type . '_maximum_income'};

	//	$pairs_add_actual = pairs_add_actual($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	if (
		($status === 'active' &&
			((!$flushout && ($user_binary->capping_cycle /*+ $pairs_add_actual*/) >= $capping_pairs)/* ||
($flushout && ($user_binary->ctr_left >= $capping_pairs &&
$user_binary->ctr_right >= $capping_pairs))*/))
		|| (/*$status === 'reactivated' &&*/ $maximum_income && ($user_binary->income_cycle /*+ $pairs_add_actual*/) >= $maximum_income)
	) {
		$status = /*($status === 'reactivated'
		  && $maximum_income
		  && $user_binary->income_cycle >= $maximum_income) ? 'graduate' :*/
			'inactive';

		update_status_binary($upline_id, $status);
		logs_status_binary($insert_user, $upline_id, $status, $prov, $account_type_old, $account_type_new);
	}
}

/**
 * @param $upline_id
 * @param $status
 *
 *
 * @since version
 */
function update_status_binary($upline_id, $status)
{
	$db = db();

	update(
		'network_binary',
		[
			'status = ' . $db->quote($status),
			'direct_cycle = ' . $db->quote(0),
			'status_cycle = ' . $db->quote(0)/*,
'ctr_left = ' . $db->quote(0),
'ctr_right = ' . $db->quote(0)*/
		],
		['user_id = ' . $db->quote($upline_id)]
	);
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $downline
 * @param $flushout
 * @param $nth_pair
 * @param $prov
 *
 * @param $account_type_old
 * @param $account_type_new
 *
 * @return false|mixed
 * @since version
 */
function logs_pairing(
	$insert_user,
	$upline_id,
	$downline,
	$flushout,
	$nth_pair,
	$prov,
	$account_type_old,
	$account_type_new
) {
	$settings_plans = settings('plans');

	$db = db();

	$source = 'Sign Up';

	if ($prov === 'activate') {
		$source = 'Activation';
	} elseif ($prov === 'upgrade') {
		$source = 'Upgrade';
	}
	//	elseif ($prov === 'reactivate')
//	{
//		$source = 'Reactivation';
//	}

	//	$nth_pair = nth_pair($account_type, $upline_id, $downline);

	$upline = user_binary($upline_id);

	$pairs_add_actual = pairs_add_actual($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);
	$pairs_add_limit = pairs_add_limit($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	$pairing = abs($pairs_add_actual - $nth_pair);

	if ($pairs_add_actual > 0 || $nth_pair > 0) {
		$activity = '<b>' . $settings_plans->binary_pair_name . ': </b> <a href="' . sef(44) . qs() . 'uid=' .
			$upline->id . '">' . $upline->username . '</a> gained ' . number_format($pairs_add_actual, 2) .
			' pts. from ' . $source . ' of <a href="' . sef(9) . qs() . 'uid=' . $insert_user->id .
			'" target="_blank">' . $insert_user->username . '</a>. <br>Balance added: ' .
			number_format($pairing, 2) . ' ' . settings('ancillaries')->currency;

		$activity .= ($nth_pair > 0) ?
			('<br>Reward Points: ' . number_format($nth_pair, 2) . ' pts.') : '';
	} else {
		$activity = '<b>Points added </b> to <a href="' . sef(44) . qs() . 'uid=' . $upline->id . '">' .
			$upline->username . '</a> from Entry of <a href="' . sef(9) . qs() . 'uid=' . $insert_user->id .
			'" target="_blank">' . $insert_user->username . '</a>. <br>';

		$activity .= (($downline->position === 'Left') ?
			('Group A: + ' . number_format($pairs_add_limit, 2) . ' pts.') :
			('Group B: + ' . number_format($pairs_add_limit, 2) . ' pts.'));
	}

	$activity .= ($pairs_add_actual > $pairing && $flushout) ? ('<br>Flush out: ' .
		number_format($pairs_add_actual - $pairing, 2) . ' pts.') : '';

	return insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_user->id),
			$db->quote($insert_user->sponsor_id),
			$db->quote($upline->id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $downline
 * @param $prov
 *
 * @param $account_type_old
 * @param $account_type_new
 *
 * @since version
 */
function logs_no_pairing($insert_user, $upline_id, $downline, $prov, $account_type_old, $account_type_new)
{
	$source = 'Sign Up';

	if ($prov === 'activate') {
		$source = 'Activation';
	} elseif ($prov === 'upgrade') {
		$source = 'Upgrade';
	}
	//	elseif ($prov === 'reactivate')
//	{
//		$source = 'Reactivation';
//	}

	$upline = user($upline_id);

	$pairs_value = pairs_value($insert_user, $upline->id);

	if ($pairs_value > 0) {
		$activity = '<b>Points added </b> to <a href="' . sef(44) . qs() . 'uid=' . $upline->id . '">' .
			$upline->username . '\'s</a> Group ' . ($downline->position === 'Left' ? 'A' : 'B') . ': 
		from ' . $source . ' of <a href="' . sef(9) . qs() . 'uid=' . $insert_user->id .
			'" target="_blank">' . $insert_user->username . '</a>. <br>';

		$activity .= (($downline->position === 'Left') ?
			('Group A: + ' . number_format($pairs_value, 2) . ' pts.') :
			('Group B: + ' . number_format($pairs_value, 2) . ' pts.'));

		$db = db();

		insert(
			'network_activity',
			[
				'user_id',
				'sponsor_id',
				'upline_id',
				'activity',
				'activity_date'
			],
			[
				$db->quote($insert_user->id),
				$db->quote($insert_user->sponsor_id),
				$db->quote($upline->id),
				$db->quote($activity),
				$db->quote(time())
			]
		);
	}
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $status
 *
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @since version
 */
function logs_status_binary($insert_user, $upline_id, $status, $prov, $account_type_old, $account_type_new)
{
	$user_binary = user_binary($upline_id);

	$upline = user($upline_id);

	$pairs_add_actual = pairs_add_actual($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	$activity = '<b>Binary Deactivated: </b>Binary Status set to ' . $status . ' for <a href="' . sef(44) .
		qs() . 'uid=' . $user_binary->id . '">' . $user_binary->username . '</a>. Pairing: ' .
		number_format($pairs_add_actual, 2) . ' ' . settings('ancillaries')->currency . '<br>';

	$db = db();

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_user->id),
			$db->quote($insert_user->sponsor_id),
			$db->quote($upline->id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $insert_user
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function pairs_value($insert_user, $upline_id)
{
	$sb = settings('binary');

	$account_type = $insert_user->account_type;
	$insert_user_id = $insert_user->id;

	$upline_binary = user_binary($upline_id);

	$status = $upline_binary->status;

	//	if ($prov === 'upgrade')
//	{
//		$insert_pairs_old = $settings_binary->{$account_type_old . '_pairs'};
//		$insert_pairs_new = $settings_binary->{$account_type_new . '_pairs'};
//
//		$insert_pairs = non_zero($insert_pairs_new - $insert_pairs_old);
//	}
//	else
//	{
//		$insert_pairs = $settings_binary->{$account_type . '_pairs'};
//	}

	$insert_pairs = empty(user_cd($insert_user_id)) ? $sb->{$account_type . '_pairs'} : 0;

	// $upline_pairs = $sb->{$upline_binary->account_type . '_pairs'};

	$pairs_lim = /*$insert_pairs > $upline_pairs ? $upline_pairs :*/ $insert_pairs;

	$upline_income_cycle = $upline_binary->income_cycle;

	$upline_max_income = $sb->{$upline_binary->account_type . '_maximum_income'};

	if (($upline_income_cycle + $pairs_lim) >= $upline_max_income) {
		$pairs_lim = non_zero($upline_max_income - $upline_income_cycle);
	}

	if (pair_upgradable($upline_id) && $status === 'active') {
		$pairs_proper = $sb->{$account_type . '_pairs_proper'};
		$pairs_lim = $pairs_lim > $pairs_proper ? $pairs_proper : $pairs_lim;
	}

	//	if ($status === 'reactivated')
//	{
//		$pairs_capped = $settings_binary->{$account_type . '_pairs_capped'};
//		$pairs_lim    = $pairs_lim > $pairs_capped ? $pairs_capped : $pairs_lim;
//	}

	return $pairs_lim;
}

/**
 * @param $downline
 * @param $upline_id
 *
 * @return bool
 *
 * @since version
 */
function has_pairing($downline, $upline_id): bool
{
	$left_pairs = left_pairs($upline_id);
	$right_pairs = right_pairs($upline_id);

	return (/*$downline->status === 'active' &&*/
		(($downline->position === 'Left' && $right_pairs > $left_pairs) ||
		($downline->position === 'Right' && $left_pairs > $right_pairs)));
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
		'WHERE b.user_id = ' . $db->quote($user_id)
	)->loadObject();
}

///**
// * @param $upline_id
// *
// * @return mixed
// *
// * @since version
// */
//function upline_max_cycle($upline_id)
//{
//	return settings('binary')->{user_binary($upline_id)->account_type . '_max_cycle'};
//}

/**
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function upline_pairs_safety($upline_id)
{
	return settings('binary')->{user_binary($upline_id)->account_type . '_pairs_safety'};
}

///**
// * @param $upline_id
// *
// * @return mixed
// *
// * @since version
// */
//function upline_pairs($upline_id)
//{
//	return user_binary($upline_id)->pairs;
//}

/**
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function left_pairs($upline_id)
{
	return user_binary($upline_id)->ctr_left;
}

/**
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function right_pairs($upline_id)
{
	return user_binary($upline_id)->ctr_right;
}

/**
 * @param $upline_id
 *
 * @return float|int
 *
 * @since version
 */
function max_pairs_add($upline_id) // waiting
{
	return abs(left_pairs($upline_id) - right_pairs($upline_id));
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @return float|int|mixed
 *
 * @since version
 */
function pairs_add_actual($insert_user, $upline_id, $prov, $account_type_old, $account_type_new)
{
	$pairs_value = pairs_value($insert_user, $upline_id);
	$max_pairs_add = max_pairs_add($upline_id);

	$pairs_add_actual = $pairs_value > $max_pairs_add ? $max_pairs_add : $pairs_value;

	return capping_limit($upline_id, $pairs_add_actual);
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @return float|int
 *
 * @since version
 */
function nth_pair($insert_user, $upline_id, $prov, $account_type_old, $account_type_new)
{
	$upline_pairs_safety = upline_pairs_safety($upline_id);

	$pairs_add_actual = pairs_add_actual($insert_user, $upline_id, $prov, $account_type_old, $account_type_new);

	$remainder = $pairs_add_actual % $upline_pairs_safety;
	$divisible = $pairs_add_actual - $remainder;

	$nth_pair_partial = $upline_pairs_safety ? $divisible / $upline_pairs_safety : 0;

	return user_binary($upline_id)->status === 'active' ? $nth_pair_partial : 0;
}

/**
 * @param $pairs_add_limited
 * @param $pairs_add_actual
 * @param $nth_pair
 * @param $upline_id
 *
 * @return string
 *
 * @since version
 */
function flush_out(&$pairs_add_limited, $pairs_add_actual, $nth_pair, $upline_id): string
{
	$ub = user_binary($upline_id);
	$sb = settings('binary');

	$max_cycle = $sb->{$ub->account_type . '_max_cycle'};
	$pairs_today = $ub->pairs_today;

	$flushout = 0;

	if ($max_cycle > 0) {
		if ($pairs_today < $max_cycle) {
			if (($pairs_today + $pairs_add_actual) <= $max_cycle) {
				$pairs_add_limited = abs($pairs_add_limited - $nth_pair);
			} else {
				if ($pairs_add_actual > $max_cycle) {
					$pairs_add_limited = $max_cycle;
					$flushout = non_zero($max_cycle - $pairs_add_actual);
				} else {
					$pairs_add_limited = non_zero($max_cycle - $pairs_today);
				}
			}
		} else {
			$pairs_add_limited = 0;
			$flushout = $pairs_add_actual;
		}
	}

	return $flushout;
}

/**
 * @param $value
 *
 * @return int|mixed
 *
 * @since version
 */
function non_zero($value)
{
	return $value > 0 ? $value : 0;
}

/**
 * @param $insert_user
 * @param $upline_id
 * @param $prov
 * @param $account_type_old
 * @param $account_type_new
 *
 * @return mixed
 *
 * @since version
 */
function pairs_add_limit($insert_user, $upline_id, $prov, $account_type_old, $account_type_new)
{
	$pairs_value = pairs_value($insert_user, $upline_id);
	$max_pairs_add = max_pairs_add($upline_id);

	$pairs_add_limit = $pairs_value > $max_pairs_add ? $max_pairs_add : $pairs_value;

	return capping_limit($upline_id, $pairs_add_limit);
}

/**
 * @param $upline_id
 *
 * @return mixed
 *
 * @since version
 */
function get_binary_status($upline_id)
{
	return user_binary($upline_id)->status;
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

	if (!empty($directs)) {
		foreach ($directs as $direct) {
			$user_binary = user_binary($direct->id);
			$max_pairs = settings('binary')->{$user_binary->account_type . '_max_pairs'};

			if (
				(int) $user_binary->status_cycle === 1 &&
				$user_binary->capping_cycle >= $max_pairs
			) {
				$status_cycle_directs[] = $direct->id;
			}
		}
	}

	return $status_cycle_directs;
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
 * @param $upline_id
 *
 * @return bool
 *
 * @since version
 */
function pair_upgradable($upline_id): bool
{
	$flushout = settings('binary')->hedge === 'flushout';

	$required_pairs = required_pairs($upline_id);
	$required_directs = binary_directs($upline_id);

	return (!$flushout &&
		($required_pairs && user_binary($upline_id)->pairs >= $required_pairs) &&
		($required_directs && count(directs_valid($upline_id)) >= $required_directs) &&
		cycle_direct_status($upline_id));
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