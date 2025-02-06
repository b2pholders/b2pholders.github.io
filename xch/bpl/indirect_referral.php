<?php

namespace BPL\Indirect_Referral;

//require_once 'bpl/mods/income.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/upline_support.php';
require_once 'bpl/mods/helpers.php';

//use function BPL\Mods\Income\main as income_global;

use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

//use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\session_set;

/**
 *
 *
 * @since version
 */
function main()
{
	$settings_ir = settings('indirect_referral');

	$users = users();

	foreach ($users as $user) {
		$account_type = $user->account_type;
		$user_id = $user->id;
		//		$username      = $user->username;
//		$sponsor_id    = $user->sponsor_id;
		$user_bonus_ir = $user->bonus_indirect_referral;

		$sponsored = user_direct($user_id);

		$type_level = $settings_ir->{$account_type . '_indirect_referral_level'};
		$type_directs = $settings_ir->{$account_type . '_indirect_referral_sponsored'};
		$income_limit_cycle = $settings_ir->{$account_type . '_indirect_referral_max_daily_income'};
		$income_max = $settings_ir->{$account_type . '_indirect_referral_maximum'};

		$user_ir = user_indirect($user_id);

		$income_today = $user_ir->income_today;

		if (
			$type_level
			//	        && empty(user_cd($user_id))
			&& count($sponsored) >= $type_directs
			/*&& (($income_limit_cycle > 0 && $income_today < $income_limit_cycle) || !$income_limit_cycle)
																																																											 && ($income_max > 0 && $user_bonus_ir < $income_max || !$income_max)*/
		) {
			// whole value
			$ir_total = total($user_id)['bonus'];
			$ir_add = $ir_total - $user_ir->bonus_indirect_last;

			if ($ir_add > 0) {
				if ($income_limit_cycle > 0 && ($income_today + $ir_add) >= $income_limit_cycle) {
					$ir_add = non_zero($income_limit_cycle - $income_today);
				}

				if ($income_max > 0 && ($user_bonus_ir + $ir_add) >= $income_max) {
					$ir_add = non_zero($income_max - $user_bonus_ir);
				}

				// difference between last whole value and whole value now
//				$bonus_ir_new = upline_support(cd_filter($user_id, $ir_add), $user_id);

				/*if (*/
				update_bonus_ir($ir_total, $ir_add, $user);/*)*/
				//				{
//					update_user($bonus_ir_new, $ir_add, $user_id);
//					log_activity($ir_add, $user_id, $sponsor_id, $username);
//				}
			}
		}
	}
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
	return $value < 0 ? 0 : $value;
}

/**
 * @param $ir
 * @param $ir_add
 * @param $user
 *
 * @return void
 *
 * @since version
 */
function update_bonus_ir($ir, $ir_add, $user)
{
	$db = db();

	$user_id = $user->id;
	$username = $user->username;
	$sponsor_id = $user->sponsor_id;

	$se = settings('entry');
	$sf = settings('freeze');
	$sa = settings('ancillaries');

	$account_type = $user->account_type;

	$user_income_cycle_global = $user->income_cycle_global;

	$entry = $se->{$account_type . '_entry'};
	$factor = $sf->{$account_type . '_percentage'} / 100;

	$freeze_limit = $entry * $factor;

	$status = $user->status_global;

	$income_cycle_global = $user_income_cycle_global;

	if ($income_cycle_global + $ir_add >= $freeze_limit) {
		$flushout = $income_cycle_global + $ir_add - $freeze_limit;
		$bonus_diff = $ir_add - $flushout;

		if ($status === 'active') {
			// update(
			// 	'network_users',
			// 	[
			// 		'status_global = ' . $db->quote('inactive'),
			// 		'income_flushout = income_flushout + ' . $flushout,
			// 		'bonus_indirect_referral = bonus_indirect_referral + ' . $bonus_diff
			// 	],
			// 	['id = ' . $db->quote($user_id)]
			// );

			$field_user = ['bonus_indirect_referral = bonus_indirect_referral + ' . $bonus_diff];

			$field_user[] = 'status_global = ' . $db->quote('inactive');
			$field_user[] = 'income_cycle_global = income_cycle_global + ' .
				cd_filter($user_id, $bonus_diff);
			$field_user[] = 'income_flushout = income_flushout + ' . $flushout;

			if ($sa->withdrawal_mode === 'standard') {
				$field_user[] = 'balance = balance + ' .
					cd_filter($user_id, $bonus_diff);
			} else {
				$field_user[] = 'payout_transfer = payout_transfer + ' .
					cd_filter($user_id, $bonus_diff);
			}

			update(
				'network_users',
				$field_user,
				['id = ' . $db->quote($user_id)]
			);
		}

		update_network_ir($ir, 0, $user_id);
	} else {
		$diff = $freeze_limit - $income_cycle_global - $ir_add;

		if ($diff < $ir_add) {
			$flushout_global = $ir_add - $diff;

			if ($user->status_global === 'active') {
				$field_user = ['bonus_indirect_referral = bonus_indirect_referral + ' . $diff];

				$field_user[] = 'status_global = ' . $db->quote('inactive');
				$field_user[] = 'income_cycle_global = income_cycle_global + ' .
					cd_filter($user_id, $diff);
				$field_user[] = 'income_flushout = income_flushout + ' . $flushout_global;

				if ($sa->withdrawal_mode === 'standard') {
					$field_user[] = 'balance = balance + ' .
						cd_filter($user_id, $diff);
				} else {
					$field_user[] = 'payout_transfer = payout_transfer + ' .
						cd_filter($user_id, $diff);
				}

				update(
					'network_users',
					$field_user,
					['id = ' . $db->quote($user_id)]
				);
			}

			update_network_ir($ir, $diff, $user_id);
			log_activity($diff, $user_id, $sponsor_id, $username);
		} else {
			$field_user = ['bonus_indirect_referral = bonus_indirect_referral + ' . $ir_add];

			$field_user[] = 'income_cycle_global = income_cycle_global + ' .
				cd_filter($user_id, $ir_add);

			if (settings('ancillaries')->withdrawal_mode === 'standard') {
				$field_user[] = 'balance = balance + ' .
					cd_filter($user_id, $ir_add);
			} else {
				$field_user[] = 'payout_transfer = payout_transfer + ' .
					cd_filter($user_id, $ir_add);
			}

			update(
				'network_users',
				$field_user,
				['id = ' . $db->quote($user_id)]
			);

			update_network_ir($ir, $ir_add, $user_id);
			log_activity($ir_add, $user_id, $sponsor_id, $username);
		}
	}
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

function update_network_ir($ir, $ir_add, $user_id)
{
	$db = db();

	update(
		'network_indirect',
		[
			'bonus_indirect = bonus_indirect + ' . $ir_add,
			'bonus_indirect_now = bonus_indirect_now + ' . $ir_add,
			'bonus_indirect_last = ' . $db->quote($ir),
			'income_today = income_today + ' . $ir_add
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $bonus_ir_new
 * @param $ir_add
 * @param $user_id
 *
 *
 * @since version
 */
function update_user($bonus_ir_new, $ir_add, $user_id)
{
	$field_user = ['bonus_indirect_referral = bonus_indirect_referral + ' . $ir_add];

	if (settings('ancillaries')->withdrawal_mode === 'standard') {
		$field_user[] = 'balance = balance + ' . $bonus_ir_new;
	} else {
		$field_user[] = 'payout_transfer = payout_transfer + ' . $bonus_ir_new;
	}

	update(
		'network_users',
		$field_user,
		['id = ' . db()->quote($user_id)]
	);
}

/**
 * @param $ir
 * @param $user_id
 * @param $sponsor_id
 * @param $username
 *
 *
 * @since version
 */
function log_activity($ir, $user_id, $sponsor_id, $username)
{
	$db = db();

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($sponsor_id),
			$db->quote('<b>' . settings('plans')->indirect_referral_name . ' Bonus: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $username .
				'</a> has earned ' . number_format($ir, 2) . ' ' .
				settings('ancillaries')->currency),
			($db->quote(time()))
		]
	);
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function users()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter')
	)->loadObjectList();
}

/**
 * @param $sponsor_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_direct($sponsor_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		'AND sponsor_id = ' . $db->quote($sponsor_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
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
 * @param $user_id
 *
 *
 * @return mixed|null
 * @since version
 */
function user_indirect($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_indirect ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
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
	$type = [];

	if (!empty($lvl_1)) {
		foreach ($lvl_1 as $head) {
			$user_direct = user_direct($head);

			if ($user_direct) {
				foreach ($user_direct as $body) {
					$lvl_2[] = $body->id;
					$type[] = $body->account_type . (!empty(user_cd($body->id)) ? '_cd' : '');
				}
			}
		}
	}

	return [$lvl_2, $type];
}

function is_cd($account_type): bool
{
	$code_type_arr = explode('_', $account_type);

	return in_array('cd', $code_type_arr, true);
}

/**
 * @param          $level
 * @param          $user_id
 *
 * @return array
 *
 * @since version
 */
function nested($level, $user_id): array
{
	$result[] = level([$user_id]);

	for ($i_i = 2; $i_i <= $level; $i_i++) {
		$last = array_reverse($result)[0];

		$result[] = level($last[0]);
	}

	return $result;
}

/**
 * @param $indirects
 * @param $head_account_type
 * @param $level
 *
 * @return float|int
 *
 * @since version
 */
function get($indirects, $head_account_type, $level)
{
	$indirect_referral = 0;

	$sir = settings('indirect_referral');

	// $head_share = $sir->{$head_account_type . '_indirect_referral_share_' . $level};

	if (count($indirects) > 0) {
		foreach ($indirects as $account_type) {
			$indirect_share = $sir->{$account_type . '_indirect_referral_share_' . $level};

			$share = is_cd($account_type) ? 0 : $indirect_share;
			// ($indirect_share < $head_share ? $indirect_share : $head_share);

			$indirect_referral += $share;
		}
	}

	return $indirect_referral;
}

/**
 * @param $head_account_type
 * @param $indirects
 * @param $ctr
 *
 * @return array
 *
 * @since version
 */
function bonus($head_account_type, $indirects, $ctr): array
{
	return [
		'member' => count($indirects[0]),
		'bonus' => get($indirects[1], $head_account_type, $ctr)
	];
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function total($user_id): array
{
	$sir = settings('indirect_referral');

	$head_account_type = user($user_id)->account_type;

	$type_level = $sir->{$head_account_type . '_indirect_referral_level'};

	$member = 0;
	$bonus = 0;

	$ctr = 1;

	$results = nested($type_level, $user_id);

	foreach ($results as $result) {
		$member += count($result[0]);
		$bonus += get($result[1], $head_account_type, $ctr);

		$ctr++;
	}

	return [
		'member' => $member,
		'bonus' => $bonus
	];
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view($user_id): string
{
	$sa = settings('ancillaries');
	$sp = settings('plans');
	$se = settings('entry');
	$sir = settings('indirect_referral');

	$user = user($user_id);

	$head_account_type = $user->account_type;

	$currency = $sa->currency;

	$str = '';

	$type_level = $sir->{$head_account_type . '_indirect_referral_level'};

	if ($type_level && $head_account_type !== 'starter') {
		$str .= '<h3>' . $sp->indirect_referral_name . '</h3>';
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Level</h4></div>';
		$str .= '</th>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Accounts</h4></div>';
		$str .= '</th>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Profit</h4></div>';
		$str .= '</th>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Allocation (%)</h4></div>';
		$str .= '</th>';

		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		$results = nested($type_level, $user_id);

		$ctr = 1;

		foreach ($results as $result) {
			$member = bonus($head_account_type, $result, $ctr)['member'];
			$bonus = bonus($head_account_type, $result, $ctr)['bonus'];

			$str .= '<tr>';

			$str .= '<td>';
			$str .= '<div style="text-align: center" ' . /* ($ctr === 1 ? 'style="color: red"' : '') . */ '>
                            <strong>' . /* ($ctr !== 1 ? $ctr : '') .
($ctr === 1 ? ' (Direct)' : '') */ $ctr . '</strong>
                        </div>';
			$str .= '</td>';

			$str .= '<td>';
			$str .= '<div style="text-align: center" ' .
				($ctr === 1 ? 'style="color: red"' : '') . '>' .
				($ctr === 1 ? ('(' . $member . ')') : $member) . '</div>';
			$str .= '</td>';

			$str .= '<td>';
			$str .= '<div style="text-align: center" ' .
				($ctr === 1 ? 'style="color: red"' : '') . '>' .
				($ctr === 1 ? ('(' . number_format($bonus, 8) . ')') :
					number_format($bonus, 8)) . '</div>';
			$str .= '</td>';

			$share = $sir->{$head_account_type . '_indirect_referral_share_' . $ctr};
			$entry = $se->{$head_account_type . '_entry'};

			$percent = $entry > 0 ? ($share / $entry) * 100 : 0;

			$str .= '<td>';
			$str .= '<div style="text-align: center" ' .
				($ctr === 1 ? 'style="color: red"' : '') . '>' .
				($ctr === 1 ? ('(' . number_format($percent, 2) . ')') :
					number_format($percent, 2)) . '</div>';
			$str .= '</td>';

			$str .= '</tr>';

			$ctr++;
		}

		$user_indirect = user_indirect($user_id);

		$flushout_global = $user_indirect->flushout_global;
		$flushout_local = $user_indirect->flushout_local;

		$str .= '<tr>';
		$str .= '<td>';
		$str .= '<div style="text-align: center"><strong>Total</strong></div>';
		$str .= '</td>';
		$str .= '<td>';
		$str .= '<div style="text-align: center">' . (total($user_id)['member']) . '</div>';
		$str .= '</td>';
		$str .= '<td>';
		$str .= '<div style="text-align: center">' .
			number_format(/*total($user_id)['bonus']*/
				($user->bonus_indirect_referral - $flushout_global - $flushout_local),
				8
			) . '</div>';
		$str .= '</td>';
		$str .= '<td>';
		$str .= '<div style="text-align: center">N/A</div>';
		$str .= '</td>';
		$str .= '</tr>';
		$str .= '</tbody>';
		$str .= '</table>';
	} else {
		$str .= '<h3 style="alignment: center">Sponsor At Least ' .
			$sir->{$head_account_type . '_indirect_referral_sponsored'} .
			' Paid Accounts To Enable Your ' . settings('plans')->indirect_referral_name . '!</h3>';
	}

	return $str;
}