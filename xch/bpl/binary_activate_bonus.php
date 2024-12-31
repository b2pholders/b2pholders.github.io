<?php

namespace BPL\Binary_Package;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';
//require_once 'bpl/mods/cd_filter.php';
//require_once 'bpl/upline_support.php';
//require_once 'bpl/mods/url_sef.php';

use function BPL\Mods\Database\Query\update;

//use function \Onewayhi\Commission_Deduct\Filter\main as cd_filter;
//use function \Onewayhi\Upline_Support\main as upline_support;
//use function \Onewayhi\Url\SEF\sef;
//use function \Onewayhi\Url\SEF\qs;

use function BPL\Mods\Helpers\db;

//use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;

/**
 * @param           $user_id
 * @param   string  $start  takes either upline or user
 *
 *
 * @since version
 */
function main($user_id, string $start = 'upline')
{
	$settings_binary = settings('binary');

	$user = user_upline($user_id);

	$ctr_add = $settings_binary->{$user->account_type . '_pairs'};

	$tmp_upline_id = $start === 'upline' ? $user->upline_id : $user_id;
	$tmp_position  = $user->position;

	$upline = user_upline($tmp_upline_id);

	$tmp_account_type = $upline->account_type;

	$tmp_max_cycle    = $settings_binary->{$tmp_account_type . '_max_cycle'};
	$tmp_pairs_safety = $settings_binary->{$tmp_account_type . '_pairs_safety'};
	$tmp_max_pairs    = $settings_binary->{$tmp_account_type . '_max_pairs'};

	$tmp_ctr_left          = $upline->ctr_left;
	$tmp_ctr_right         = $upline->ctr_right;
	$tmp_pairs             = $upline->pairs;
	$tmp_income_cycle      = $upline->income_cycle;
	$tmp_pairs_today       = $upline->pairs_today;
	$tmp_pairs_today_total = $upline->pairs_today_total;

	while ($tmp_upline_id > 0)
	{
		if (($tmp_position === 'Left' && $tmp_ctr_right > $tmp_ctr_left) ||
			($tmp_position === 'Right' && $tmp_ctr_left > $tmp_ctr_right))
		{
			// max pair-able
			$max_pairs_add = abs($tmp_ctr_left - $tmp_ctr_right);

			// max countable pairs
			$open_pairs        = $tmp_max_cycle ? $tmp_max_cycle - $tmp_pairs_today : 0;
			$open_pairs        = $open_pairs > 0 ? $open_pairs : 0;
			$max_pairs_limited = $max_pairs_add > $open_pairs ? $open_pairs : $max_pairs_add;

			// limited pairs add
			$pairs_add_limited = $ctr_add > $max_pairs_limited ? $max_pairs_limited : $ctr_add;

			// actual pairs
			$pairs_add_actual = $ctr_add > $max_pairs_add ? $max_pairs_add : $ctr_add;

			// nth pair
			$nth_pair = nth_pair(
				$tmp_pairs_safety,
				$tmp_pairs,
				$pairs_add_actual,
				$tmp_max_cycle,
				$tmp_pairs_today_total
			);

			// flushout
			$flushout = 0;

			if ($tmp_max_cycle > 0 && (($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle))
			{
				$tmp_add_limited = abs($pairs_add_limited - $nth_pair);
			}
			else
			{
				$tmp_add_limited = 0;
				$flushout        = $pairs_add_limited;
			}

			$reach = $tmp_income_cycle + $pairs_add_actual;

			// max limit || graduation from binary
			if ($reach >= $tmp_max_pairs)
			{
				$tmp_add_limited = $tmp_income_cycle >= $tmp_max_pairs ? 0 : abs($tmp_max_pairs - $reach);
			}

			update_pairing(
				$tmp_add_limited,
				$nth_pair,
				$pairs_add_actual,
				$flushout,
				$tmp_position,
				$ctr_add,
				$tmp_upline_id
			);
		}
		else
		{
			update_no_pairing($tmp_position, $ctr_add, $tmp_upline_id);
		}

		$tmp_position  = $upline->position;
		$tmp_upline_id = $upline->upline_id;

		if ((int) $tmp_upline_id === 0)
		{
			break;
		}

		$upline = user_upline($tmp_upline_id);

		$tmp_account_type = $upline->account_type;

		$tmp_max_cycle    = $settings_binary->{$tmp_account_type . '_max_cycle'};
		$tmp_pairs_safety = $settings_binary->{$tmp_account_type . '_pairs_safety'};

		$tmp_ctr_left          = $upline->ctr_left;
		$tmp_ctr_right         = $upline->ctr_right;
		$tmp_pairs             = $upline->pairs;
		$tmp_pairs_today       = $upline->pairs_today;
		$tmp_pairs_today_total = $upline->pairs_today_total;
	}
}

/**
 * @param $tmp_add_limited
 * @param $nth_pair
 * @param $pairs_add_actual
 * @param $flushout
 * @param $tmp_position
 * @param $ctr_add
 * @param $tmp_upline_id
 *
 * @since version
 */
function update_pairing(
	$tmp_add_limited,
	$nth_pair,
	$pairs_add_actual,
	$flushout,
	$tmp_position,
	$ctr_add,
	$tmp_upline_id
)
{
	$db = db();

	update(
		'network_binary',
		['income_cycle = income_cycle + ' . $tmp_add_limited,
			'pairs_5th = pairs_5th + ' . $nth_pair,
			'income_giftcheck = income_giftcheck + ' . $nth_pair,
			'pairs = pairs + ' . $pairs_add_actual,
			'income_flushout = income_flushout + ' . $flushout,
			'pairs_today = pairs_today + ' . $tmp_add_limited,
			'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,
			($tmp_position === 'Left' ? 'ctr_left = ctr_left' : 'ctr_right = ctr_right') . ' + ' . $ctr_add],
		['id = ' . $db->quote($tmp_upline_id)]
	);

	update(
		'network_users',
		['payout_transfer = payout_transfer + ' . $tmp_add_limited],
		['id = ' . $db->quote($tmp_upline_id)]
	);
}

/**
 * @param $tmp_position
 * @param $ctr_add
 * @param $tmp_upline_id
 *
 *
 * @since version
 */
function update_no_pairing($tmp_position, $ctr_add, $tmp_upline_id)
{
	update(
		'network_binary',
		[
			($tmp_position === 'Left' ? 'ctr_left = ctr_left' : 'ctr_right = ctr_right') . ' + ' . $ctr_add
		],
		['id = ' . db()->quote($tmp_upline_id)]
	);
}

/**
 * @param $upline_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_upline($upline_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE b.user_id = ' . $db->quote($upline_id)
	)->loadObject();
}

/**
 * @param $tmp_pairs_safety
 * @param $tmp_pairs
 * @param $pairs_add_actual
 * @param $tmp_max_cycle
 * @param $tmp_pairs_today_total
 *
 * @return float|int
 *
 * @since version
 */
function nth_pair($tmp_pairs_safety, $tmp_pairs, $pairs_add_actual, $tmp_max_cycle, $tmp_pairs_today_total)
{
	if ($tmp_pairs_safety > 0)
	{
		$old = $tmp_pairs - $tmp_pairs % $tmp_pairs_safety;

		$new = $tmp_pairs + $pairs_add_actual - (($tmp_pairs + $pairs_add_actual) % $tmp_pairs_safety);

		return (+($tmp_max_cycle &&
				($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle &&
				$new > $old) * ($new - $old) / $tmp_pairs_safety);
	}

	return 0;
}