<?php

namespace BPL\Echelon_Bonus;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

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
	$settings_echelon = settings('echelon');

	$users = users();

	foreach ($users as $user) {
		$account_type = $user->account_type;
		$user_id = $user->id;
		$user_bonus_echelon = $user->bonus_echelon;

		//		$sponsored = user_direct($user_id);

		$level = $settings_echelon->{$account_type . '_echelon_level'};
		$income_limit_cycle = $settings_echelon->{$account_type . '_echelon_max_daily_income'};
		$income_max = $settings_echelon->{$account_type . '_echelon_maximum'};

		$user_echelon = user_echelon($user_id);

		$income_today = $user_echelon->income_today;

		if (
			$level
			//	        && empty(user_cd($user_id))
			&& (($income_limit_cycle > 0 && $income_today < $income_limit_cycle) || !$income_limit_cycle)
			&& ($income_max > 0 && $user_bonus_echelon < $income_max || !$income_max)
		) {
			// whole value
			$echelon_total = total($user_id)['bonus'];
			$echelon_add = $echelon_total - $user_echelon->bonus_echelon_last;

			if ($echelon_add > 0) {
				if ($income_limit_cycle > 0 && ($income_today + $echelon_add) >= $income_limit_cycle) {
					$echelon_add = non_zero($income_limit_cycle - $income_today);
				}

				if ($income_max > 0 && ($user_bonus_echelon + $echelon_add) >= $income_max) {
					$echelon_add = non_zero($income_max - $user_bonus_echelon);
				}

				// difference between last whole value and whole value now
//				$bonus_ir_new = upline_support(cd_filter($user_id, $ir_add), $user_id);

				/*if (*/
				update_bonus_echelon($echelon_total, $echelon_add, $user);/*)*/
				//				{
//					update_user($bonus_ir_new, $ir_add, $user_id);
//					log_activity($ir_add, $user_id, $sponsor_id, $username);
//				}
			}
		}
	}
}

/**
 * @param $insert_id
 *
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 * @return void
 * @since version
 */
function insert_echelon($insert_id, $code_type, $username, $sponsor, $date, $prov)
{
	if (empty(user_echelon($insert_id))) {
		insert(
			'network_echelon',
			['user_id'],
			[db()->quote($insert_id)]
		);

		logs_echelon($insert_id, $code_type, $username, $sponsor, $date, $prov);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 * @since version
 */
function logs_echelon($insert_id, $code_type, $username, $sponsor, $date, $prov)
{
	$db = db();

	$settings_plans = settings('plans');

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor)) {
		$sponsor_id = $user_sponsor[0]->id;
	}

	$activity = '<b>' . ucwords($settings_plans->echelon_name) . ' Entry: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
		ucwords($settings_plans->echelon_name) . ' upon ' . ucfirst(settings('entry')->{$code_type .
			'_package_name'}) . source($prov) . '.';

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

	if ($prov === 'activate') {
		$source = ' Activation';
	} elseif ($prov === 'upgrade') {
		$source = ' Upgrade';
	}

	return $source;
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
	)->loadObjectList();
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
 * @param $total
 * @param $add
 * @param $user
 *
 * @return void
 *
 * @since version
 */
function update_bonus_echelon($total, $add, $user)
{
	$db = db();

	$user_id = $user->id;
	$username = $user->username;
	$sponsor_id = $user->sponsor_id;

	$se = settings('entry');
	$sf = settings('freeze');

	$account_type = $user->account_type;

	$user_income_cycle_global = $user->income_cycle_global;

	$entry = $se->{$account_type . '_entry'};
	$factor = $sf->{$account_type . '_percentage'} / 100;

	$freeze_limit = $entry * $factor;

	$status = $user->status_global;

	// $income_cycle_global = session_set(
	// 	'income_cycle_global',
	// 	$user_income_cycle_global + $add
	// );

	$income_cycle_global = $user_income_cycle_global + $add;

	if ($income_cycle_global >= $freeze_limit) {
		if ($status === 'active') {
			update(
				'network_users',
				[
					'status_global = ' . $db->quote('inactive'),
					'income_flushout = income_flushout + ' . $add
				],
				['id = ' . $db->quote($user_id)]
			);
		}

		update_network_echelon($total, 0, $user_id);
	} else {
		$diff = $freeze_limit - $income_cycle_global;

		if ($diff < $add) {
			$flushout_global = $add - $diff;

			if ($user->status_global === 'active') {
				$field_user = ['bonus_echelon = bonus_echelon + ' . $diff];

				$field_user[] = 'status_global = ' . $db->quote('inactive');
				$field_user[] = 'income_cycle_global = income_cycle_global + ' . cd_filter($user_id, $diff);
				$field_user[] = 'income_flushout = income_flushout + ' . $flushout_global;

				if (settings('ancillaries')->withdrawal_mode === 'standard') {
					$field_user[] = 'balance = balance + ' . cd_filter($user_id, $diff);
				} else {
					$field_user[] = 'payout_transfer = payout_transfer + ' . cd_filter($user_id, $diff);
				}

				update(
					'network_users',
					$field_user,
					['id = ' . $db->quote($user_id)]
				);
			}

			update_network_echelon($total, $diff, $user_id);
			log_activity($diff, $user_id, $sponsor_id, $username);
		} else {
			$field_user = ['bonus_echelon = bonus_echelon + ' . $add];

			$field_user[] = 'income_cycle_global = income_cycle_global + ' . cd_filter($user_id, $add);

			if (settings('ancillaries')->withdrawal_mode === 'standard') {
				$field_user[] = 'balance = balance + ' . cd_filter($user_id, $add);
			} else {
				$field_user[] = 'payout_transfer = payout_transfer + ' . cd_filter($user_id, $add);
			}

			update(
				'network_users',
				$field_user,
				['id = ' . $db->quote($user_id)]
			);

			update_network_echelon($total, $add, $user_id);
			log_activity($add, $user_id, $sponsor_id, $username);
		}
	}
}

//function fixed_daily($user_id)
//{
//	$db = db();
//
//	return $db->setQuery(
//		'SELECT * ' .
//		'FROM network_fixed_daily ' .
//		'WHERE user_id = ' . $db->quote($user_id)
//	)->loadObject();
//}

function update_network_echelon($total, $add, $user_id)
{
	$db = db();

	update(
		'network_echelon',
		[
			'bonus_echelon = bonus_echelon + ' . $add,
			'bonus_echelon_now = bonus_echelon_now + ' . $add,
			'bonus_echelon_last = ' . $db->quote($total),
			'income_today = income_today + ' . $add
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

// /**
//  * @param $bonus_ir_new
//  * @param $ir_add
//  * @param $user_id
//  *
//  *
//  * @since version
//  */
// function update_user($bonus_ir_new, $ir_add, $user_id)
// {
// 	$field_user = ['bonus_indirect_referral = bonus_indirect_referral + ' . $ir_add];

// 	if (settings('ancillaries')->withdrawal_mode === 'standard') {
// 		$field_user[] = 'balance = balance + ' . $bonus_ir_new;
// 	} else {
// 		$field_user[] = 'payout_transfer = payout_transfer + ' . $bonus_ir_new;
// 	}

// 	update(
// 		'network_users',
// 		$field_user,
// 		['id = ' . db()->quote($user_id)]
// 	);
// }

/**
 * @param $echelon
 * @param $user_id
 * @param $sponsor_id
 * @param $username
 *
 *
 * @since version
 */
function log_activity($echelon, $user_id, $sponsor_id, $username)
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
			$db->quote('<b>' . settings('plans')->echelon_name . ' Bonus: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $username .
				'</a> has earned ' . number_format($echelon, 2) . ' ' .
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
		' AND sponsor_id = ' . $db->quote($sponsor_id)
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
function user_echelon($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_echelon ' .
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

	$withdrawals = [];

	if (!empty($lvl_1)) {
		foreach ($lvl_1 as $sponsor1) {
			$directs = user_direct($sponsor1);

			if (!empty($directs)) {
				foreach ($directs as $direct) {
					// $amount_total = 0;

					// $user_withdrawals = user_repeat_head($head_id, $direct->id);
					// $user_withdrawals = user_efund_convert_confirmed($direct->id);

					// foreach ($user_withdrawals as $withdrawal) {
					// 	$amount_total += $withdrawal->amount; // points per user
					// }

					//					$user_cd = user_cd($sponsor2->id);

					$lvl_2[] = $direct->id; // array
//						$points += $item_points; // double
					$withdrawals[] = [$direct->account_type => direct_withdrawals($direct->id)];

					//					$lvl_2[$sponsor2->id] = $item_points;
				}
			}
		}
	}

	return [$lvl_2, $withdrawals];
}

function direct_withdrawals($user_id)
{
	$user_withdrawals = user_efund_convert_confirmed($user_id);

	$amount_total = 0;

	foreach ($user_withdrawals as $withdrawal) {
		$amount_total += $withdrawal->amount; // points per user
	}

	return $amount_total;
}

// /**
//  * @param $user_id
//  * @param $head_id
//  *
//  * @return array|mixed
//  *
//  * @since version
//  */
// function user_repeat_head($head_id, $user_id)
// {
// 	$db = db();

// 	$head_user = user($head_id);

// 	$date_activated_head = $head_user->date_activated;

// 	$head_repeat = user_repeat($head_id);

// 	if (!empty($head_repeat)) {
// 		foreach ($head_repeat as $repeat) {
// 			if ($repeat->item_id == 24) {
// 				$date_activated_head = $repeat->date;
// 			}

// 			break;
// 		}
// 	}

// 	return $db->setQuery(
// 		'SELECT * ' .
// 		'FROM network_repeat ' .
// 		'WHERE user_id = ' . $db->quote($user_id) .
// 		' AND date >= ' . $date_activated_head
// 	)->loadObjectlist();
// }

function user_efund_convert_confirmed($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users, ' .
		'network_efund_convert ' .
		'WHERE id = user_id ' .
		'AND date_approved > 0 ' .
		'AND user_id = ' . $db->quote($user_id) .
		' ORDER BY convert_id DESC'
	)->loadObjectList();
}

// function user_repeat($user_id)
// {
// 	$db = db();

// 	return $db->setQuery(
// 		'SELECT * ' .
// 		'FROM network_repeat ' .
// 		'WHERE user_id = ' . $db->quote($user_id)
// 	)->loadObjectlist();
// }

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
 * @param $level
 *
 * @return float|int
 *
 * @since version
 */
function get($indirects, $level)
{
	$echelon = 0;

	// Fetch echelon settings
	$settings_echelon = settings('echelon');

	// Check if $indirects is not empty
	if (count($indirects) > 0) {
		foreach ($indirects as $indirect) {
			// Extract the account type and withdrawal amount
			$account_type = key($indirect); // e.g., 'executive'
			$withdrawals = $indirect[$account_type]; // e.g., 1000

			// Calculate member share and cut based on settings
			$member_share = $settings_echelon->{$account_type . '_echelon_share_' . $level};
			$member_share_cut = $settings_echelon->{$account_type . '_echelon_share_cut_' . $level};

			// Calculate the member cut
			$member_cut = $member_share * $member_share_cut / 100 / 100;

			// Apply the cut (skip if is_cd is true for the account type)
			$cut = is_cd($account_type) ? 0 : $member_cut;

			// Add to the total echelon bonus
			$echelon += $cut * $withdrawals;
		}
	}

	return $echelon;
}

// function get($indirects, $level)
// {
// 	$echelon = 0;

// 	$settings_echelon = settings('echelon');

// 	if (count($indirects) > 0) {
// 		foreach ($indirects as $account_type => $withdrawals) {
// 			$member_share = $settings_echelon->{$account_type . '_echelon_share_' . $level};
// 			$member_share_cut = $settings_echelon->{$account_type . '_echelon_share_cut_' . $level};

// 			$member_cut = $member_share * $member_share_cut / 100 / 100;

// 			$cut = is_cd($account_type) ? 0 : $member_cut;

// 			$echelon += $cut * $withdrawals;
// 		}
// 	}

// 	return $echelon;
// }

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
		'bonus' => get($indirects[1], $ctr)
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
	$settings_echelon = settings('echelon');

	$head_account_type = user($user_id)->account_type;

	$type_level = $settings_echelon->{$head_account_type . '_echelon_level'};

	$member = 0;
	$bonus = 0;

	$ctr = 1;

	$results = nested($type_level, $user_id);

	foreach ($results as $result) {
		$member += count($result[0]);
		$bonus += get($result[1], $ctr);

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
	$settings_ancillaries = settings('ancillaries');
	$settings_plans = settings('plans');
	$settings_entry = settings('entry');
	$settings_echelon = settings('echelon');

	$user = user($user_id);

	$head_account_type = $user->account_type;

	$currency = $settings_ancillaries->currency;

	$str = '';

	$type_level = $settings_echelon->{$head_account_type . '_echelon_level'};

	if ($type_level && $head_account_type !== 'starter') {
		$str .= '<h3>' . /* $settings_plans->echelon_name */ 'Income Summary' . '</h3>';
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
		$str .= '<div style="text-align: center"><h4>Fixed Rate (%)</h4></div>';
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

			//			$share     = $sul->{$head_account_type . '_echelon_share_' . $ctr};
//			$share_cut = $sul->{$head_account_type . '_echelon_share_cut_' . $ctr};
//
//			$cut = $share * $share_cut / 100;

			$entry = $settings_entry->{$head_account_type . '_entry'};

			$percent = $entry > 0 ? ($bonus / $entry) * 100 : 0;

			$str .= '<td>';
			$str .= '<div style="text-align: center" ' .
				($ctr === 1 ? 'style="color: red"' : '') . '>' .
				($ctr === 1 ? ('(' . number_format($percent, 2) . ')') :
					number_format($percent, 2)) . '</div>';
			$str .= '</td>';

			$str .= '</tr>';

			$ctr++;
		}

		//		$user_echelon = user_echelon($user_id);

		//		$flushout_global = $user_echelon->flushout_global;
//		$flushout_local  = $user_echelon->flushout_local;

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
				($user->bonus_echelon/* - $flushout_global - $flushout_local*/),
				8
			) . '</div>';
		$str .= '</td>';
		$str .= '<td>';
		$str .= '<div style="text-align: center">N/A</div>';
		$str .= '</td>';
		$str .= '</tr>';
		$str .= '</tbody>';
		$str .= '</table>';
	}
	//	else
//	{
//		$str .= '<h3 style="alignment: center">Sponsor At Least ' .
//			$sul->{$head_account_type . '_indirect_referral_sponsored'} .
//			' Paid Accounts To Enable Your ' . settings('plans')->indirect_referral_name . '!</h3>';
//	}

	return $str;
}