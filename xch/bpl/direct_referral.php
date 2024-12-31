<?php

namespace BPL\Direct_Referral;

require_once 'bpl/mods/income.php';
require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

//use function BPL\Mods\Income\main as income_global;

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

//use function BPL\Mods\Helpers\input_get;
//use function BPL\Mods\Helpers\time;

/**
 * @param           $insert_id
 * @param           $code_type
 * @param           $is_cd
 * @param           $username
 * @param           $sponsor
 * @param           $date
 * @param   string  $prov
 *
 * @since version
 */
function main($insert_id, $code_type, $is_cd, $username, $sponsor, $date, string $prov = 'code')
{
	$Settings_plans = settings('plans');

	if ($Settings_plans->direct_referral)
	{
		update_user_referral($code_type, $is_cd, $sponsor);
		logs_direct_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date, $prov);
	}

	if ($Settings_plans->binary_pair)
	{
		update_binary($sponsor);
	}
}

/**
 * @param $sponsor
 *
 *
 * @since version
 */
function update_binary($sponsor)
{
	update(
		'network_binary',
		['direct_cycle = direct_cycle + 1'],
		['id = ' . db()->quote(user_username($sponsor)->id)]
	);
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
 * @param $code_type
 * @param $is_cd
 * @param $sponsor
 *
 *
 * @since version
 */
function update_user_referral($code_type, $is_cd, $sponsor)
{
	$db = db();

//	$sp = settings('plans');
//	$sa = settings('ancillaries');
	$se = settings('entry');
	$sf = settings('freeze');

//	$saf = $sp->account_freeze;

	$user = user_username($sponsor);

	$user_id = $user->id;

//	if (empty(user_cd($user_id)))
//	{
	$account_type        = $user->account_type;
	$income_cycle_global = $user->income_cycle_global;

	$entry  = $se->{$account_type . '_entry'};
	$factor = $sf->{$account_type . '_percentage'} / 100;

	$freeze_limit = $entry * $factor;

	$sponsor_referral_add = sponsor_referral_add($code_type, $is_cd, $sponsor);

//	$sponsor_referral_add_final = 0;

	$status = $user->status_global;

	if ($income_cycle_global >= $freeze_limit
		/*(fixed_daily($user_id)->time_mature > 0 && $status === 'active') || $status !== 'active'*/)
	{
//		if ($saf)
//		{
		if ($status === 'active')
		{
			update(
				'network_users',
				[
					'income_referral_flushout = income_referral_flushout + ' . $sponsor_referral_add,
					'status_global = ' . $db->quote('inactive'),
					'income_flushout = income_flushout + ' . $sponsor_referral_add,
				],
				['id = ' . $db->quote($user_id)]
			);
		}
//		}
	}
	else
	{
		$diff = $freeze_limit - $income_cycle_global;

		if ($diff < $sponsor_referral_add)
		{
			$flushout_global = $sponsor_referral_add - $diff;

//			if ($saf)
//			{
//			$sponsor_referral_add_final = $sponsor_referral_add - $diff;

			if ($status === 'active')
			{
				$diff = cd_filter($user_id, $diff);

				update(
					'network_users',
					[
						'income_referral_flushout = income_referral_flushout + ' . $flushout_global,
						'status_global = ' . $db->quote('inactive'),
						'payout_transfer = payout_transfer + ' . $diff,
						'income_cycle_global = income_cycle_global + ' . $diff,
						'income_flushout = income_flushout + ' . $flushout_global
					],
					['id = ' . $db->quote($user_id)]
				);
			}
//			}
		}
		else
		{
			if ($status === 'active')
			{
				$sponsor_referral_add = cd_filter($user_id, $sponsor_referral_add);

				update(
					'network_users',
					[
						'payout_transfer = payout_transfer + ' . $sponsor_referral_add,
						'income_cycle_global = income_cycle_global + ' . $sponsor_referral_add,
						'income_referral = income_referral + ' . $sponsor_referral_add
					],
					['id = ' . $db->quote($user_id)]
				);
			}
//		}
		}
	}
//	}
}

/**
 * @param $code_type
 * @param $is_cd
 * @param $sponsor
 *
 * @return float|int
 *
 * @since version
 */
function sponsor_referral_add($code_type, $is_cd, $sponsor)
{
	$user_sponsor = user_username($sponsor);

	$settings_referral = settings('referral');

	$val_user = $settings_referral->{$code_type . '_referral'};

// 	$val_sponsor = $settings_referral->{$user_sponsor->account_type . '_referral'};

	$value = /*$val_user > $val_sponsor ? $val_sponsor :*/ $val_user;

	return /*deduct($value, $user_sponsor->id)*/ $is_cd ? 0 : $value;
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
		'WHERE username = ' . $db->quote($username) .
		' AND account_type <> ' . $db->quote('starter')
	)->loadObject();
}

function fixed_daily($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fixed_daily ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $is_cd
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 * @since version
 */
function logs_direct_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date, $prov)
{
	$user_sponsor = user_username($sponsor);

	$sponsor_id = $user_sponsor->id;

	$db = db();

	$settings_plans = settings('plans');

	$activity = '<b>' . ucfirst($settings_plans->direct_referral_name) . ' Bonus: </b> ' .
		'<a href="' . sef(44) . qs() . 'uid=' . $sponsor_id . '">' . $user_sponsor->username . '</a> gained ' .
		number_format(sponsor_referral_add($code_type, $is_cd, $sponsor), 2) . ' ' .
		settings('ancillaries')->currency . ' ' . ucfirst($settings_plans->direct_referral_name) .
		' Bonus for sponsoring <a href="' . sef(44) . qs() . 'uid=' . $insert_id . '">' . $username .
		'</a> upon ' . ucfirst(settings('entry')->{$code_type . '_package_name'}) . source($prov) . '.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $prov
 *
 * @return string
 *
 * @since version
 */
function source($prov): string
{
	$source = ' Sign Up';

	if ($prov === 'activate')
	{
		$source = ' Activation';
	}
	elseif ($prov === 'upgrade')
	{
		$source = ' Upgrade';
	}

	return $source;
}
