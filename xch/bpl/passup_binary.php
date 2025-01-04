<?php

namespace BPL\Passup_Binary;

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

/**
 *
 *
 * @since version
 */
function main()
{
	$spb = settings('passup_binary');

	$users = users();

	foreach ($users as $user) {
		$account_type = $user->account_type;
		$user_id = $user->id;
		$passup_binary_bonus = $user->passup_binary_bonus;

		$income_limit_cycle = $spb->{$account_type . '_max_daily_income'};
		$income_max = $spb->{$account_type . '_maximum_income'};

		$user_pb = user_passup_binary($user_id);

		$income_today = $user_pb->income_today;

		if (
			(($income_limit_cycle > 0 && $income_today < $income_limit_cycle) || !$income_limit_cycle)
			&& ($income_max > 0 && $passup_binary_bonus < $income_max || !$income_max)
		) {
			// whole value
			$income_total = total($user_id)['bonus'];
			$income_add = $income_total - $user_pb->bonus_passup_binary_last;

			if ($income_add > 0) {
				if ($income_limit_cycle > 0 && ($income_today + $income_add) >= $income_limit_cycle) {
					$income_add = non_zero($income_limit_cycle - $income_today);
				}

				if ($income_max > 0 && ($passup_binary_bonus + $income_add) >= $income_max) {
					$income_add = non_zero($income_max - $passup_binary_bonus);
				}

				update_user_passup_binary($income_total, $income_add, $user);
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
function insert_passup_binary($insert_id, $code_type, $username, $sponsor, $date, $prov)
{
	if (empty(user_passup_binary($insert_id))) {
		insert(
			'network_passup_binary',
			['user_id'],
			[db()->quote($insert_id)]
		);

		logs_pb($insert_id, $code_type, $username, $sponsor, $date, $prov);
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
function logs_pb($insert_id, $code_type, $username, $sponsor, $date, $prov)
{
	$db = db();

	$settings_plans = settings('plans');

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor)) {
		$sponsor_id = $user_sponsor[0]->id;
	}

	$activity = '<b>' . ucwords($settings_plans->passup_binary_name) . ' Entry: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
		ucwords($settings_plans->passup_binary_name) . ' upon ' . ucfirst(settings('entry')->{$code_type .
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
function update_user_passup_binary($total, $add, $user)
{
	$db = db();

	$user_id = $user->id;
	$username = $user->username;
	$sponsor_id = $user->sponsor_id;

	$se = settings('entry');
	$sf = settings('freeze');

	$account_type = $user->account_type;

	$income_cycle_global = $user->income_cycle_global;

	$entry = $se->{$account_type . '_entry'};
	$factor = $sf->{$account_type . '_percentage'} / 100;

	$freeze_limit = $entry * $factor;

	$status = $user->status_global;

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

		update_network_pb($total, 0, $user_id);
	} else {
		$diff = $freeze_limit - $income_cycle_global;

		if ($diff < $add) {
			$flushout_global = $add - $diff;

			if ($user->status_global === 'active') {
				$field_user = ['passup_binary_bonus = passup_binary_bonus + ' . $diff];

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

			update_network_pb($total, $diff, $user_id);
			log_activity($diff, $user_id, $sponsor_id, $username);
		} else {
			$field_user = ['passup_binary_bonus = passup_binary_bonus + ' . $add];

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

			update_network_pb($total, $add, $user_id);
			log_activity($add, $user_id, $sponsor_id, $username);
		}
	}
}

function update_network_pb($total, $add, $user_id)
{
	$db = db();

	update(
		'network_passup_binary',
		[
			'bonus_passup_binary = bonus_passup_binary + ' . $add,
			'bonus_passup_binary_now = bonus_passup_binary_now + ' . $add,
			'bonus_passup_binary_last = ' . $db->quote($total),
			'income_today = income_today + ' . $add
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $passup_binary
 * @param $user_id
 * @param $sponsor_id
 * @param $username
 *
 *
 * @since version
 */
function log_activity($passup_binary, $user_id, $sponsor_id, $username)
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
			$db->quote('<b>' . settings('plans')->passup_binary_name . ' Bonus: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $username .
				'</a> has earned ' . number_format($passup_binary, 2) . ' ' .
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
function user_passup_binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_passup_binary ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

function is_cd($account_type): bool
{
	$code_type_arr = explode('_', $account_type);

	return in_array('cd', $code_type_arr, true);
}

/**
 * @param $user_id
 * @param $compound
 *
 * @return array
 *
 * @since version
 */
function total($user_id, $compound = false): array
{
	$cumulative_percentage = 1;

	$total_income = 0;
	$c_users = [];

	$user = user_binary($user_id);

	$d_id = $user->downline_right_id;

	if ($d_id) {
		$d_user = user_binary($d_id);

		$c_id = $d_user->downline_left_id;

		while ($c_id) {
			$c_user = user_binary($c_id);

			$c_account_type = $c_user->account_type;
			$c_username = $c_user->username;

			$c_compensation = getCompensation($c_account_type);
			$c_percentage = getPercentage($c_account_type);

			if ($compound) {
				$cumulative_percentage *= $c_percentage;
			} else {
				$cumulative_percentage = $c_percentage;
			}

			$c_income = $c_compensation * $cumulative_percentage;

			$c_users[$c_username] = $c_income;

			$total_income += $c_income;

			$c_id = $c_user->downline_left_id;
		}
	}

	return [
		'bonus' => $total_income,
		'members' => $c_users
	];
}

function getCompensation($account_type)
{
	$spb = settings('passup_binary');

	return $spb->{$account_type . '_bonus'} ?? 0;
}

function getPercentage($account_type)
{
	$spb = settings('passup_binary');

	$percent = doubleval($spb->{$account_type . '_percent'}) / 100;

	return $percent ?? 0;
}

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
	$spb = settings('passup_binary');

	$user = user($user_id);

	$head_account_type = $user->account_type;

	$currency = $sa->currency;

	$str = '';

	if ($head_account_type !== 'starter') {
		$str .= '<h3>' . $sp->passup_binary_name . '</h3>';
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Member</h4></div>';
		$str .= '</th>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Profit (' . $currency . ')</h4></div>';
		$str .= '</th>';

		$str .= '<th>';
		$str .= '<div style="text-align: center"><h4>Allocation (%)</h4></div>';
		$str .= '</th>';

		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		$total = total($user_id);

		$members = $total['members'];

		if (count($members) > 0) {
			foreach ($members as $member => $income) {

				$str .= '<tr>';

				$str .= '<td>';
				$str .= '<div style="text-align: center">' . $member . '</div>';
				$str .= '</td>';

				$str .= '<td>';
				$str .= '<div style="text-align: center">' . number_format($income, 8) . '</div>';
				$str .= '</td>';

				$entry = $se->{$head_account_type . '_entry'};

				$percent = $entry > 0 ? ($income / $entry) * 100 : 0;

				$str .= '<td>';
				$str .= '<div style="text-align: center">' . number_format($percent, 2) . '</div>';
				$str .= '</td>';

				$str .= '</tr>';
			}
		} else {
			$str .= '<tr>';
			$str .= '<td colspan="3">';
			$str .= '<div style="text-align: center">No members yet.</div>';
			$str .= '</td>';
			$str .= '</tr>';
		}

		$str .= '<tr>';
		$str .= '<td>';
		$str .= '<div style="text-align: center"><strong>Total</strong></div>';
		$str .= '</td>';
		$str .= '<td>';
		$str .= '<div style="text-align: center">' . (count($members)) . '</div>';
		$str .= '</td>';
		$str .= '<td>';
		$str .= '<div style="text-align: center">' . number_format($total['bonus'], 8) . '</div>';
		$str .= '</td>';
		$str .= '</tr>';

		$str .= '</tbody>';
		$str .= '</table>';
	}

	return $str;
}