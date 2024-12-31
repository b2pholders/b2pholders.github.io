<?php

namespace Cron\Leadership\Fixed_Daily;

require_once 'cron_leadership_passive.php';
require_once 'cron_query_local.php';

use function Cron\Leadership_Passive\leadership_passive_users;
use function Cron\Leadership_Passive\user_directs;
use function Cron\Leadership_Passive\update_leadership_passive;
use function Cron\Leadership_Passive\update_user;

use function Cron\Database\Query\fetch;
use function Cron\Database\Query\crud;

/**
 * Main function to process leadership fixed daily bonuses for all users.
 * This function iterates through all users and processes their leadership fixed daily bonuses.
 *
 * @since version
 */
function main()
{
	// Fetch leadership passive settings
	$slp = settings('leadership_passive');

	// Fetch all users eligible for leadership passive bonuses
	$users = leadership_passive_users();

	if (!empty($users)) {
		foreach ($users as $user) {
			process_user_leadership_fixed_daily($user, $slp);
		}
	}
}

/**
 * Process leadership fixed daily bonus for a single user.
 * This function calculates and updates the leadership fixed daily bonus for a given user.
 *
 * @param object $user The user object.
 * @param object $slp  Leadership passive settings.
 *
 * @since version
 */
function process_user_leadership_fixed_daily($user, $slp)
{
	$user_id = $user->user_id;
	$account_type = $user->account_type;

	// Fetch entry and freeze settings
	$se = settings('entry');
	$sf = settings('freeze');

	$income_cycle_global = $user->income_cycle_global;

	// Calculate freeze limit based on entry and freeze percentage
	$entry = $se->{$account_type . '_entry'};
	$factor = $sf->{$account_type . '_percentage'} / 100;
	$freeze_limit = $entry * $factor;

	$status = $user->status_global;

	// Count the number of direct referrals
	$count_directs = count(user_directs($user_id));

	// Fetch leadership passive settings for the user's account type
	$type_level = $slp->{$account_type . '_leadership_passive_level'};
	$required_directs = $slp->{$account_type . '_leadership_passive_sponsored'};
	$max_daily_income = $slp->{$account_type . '_leadership_passive_max_daily_income'};
	$income_max = $slp->{$account_type . '_leadership_passive_maximum'};

	$user_bonus_lp = $user->u_bonus_leadership_passive;
	$income_today = $user->income_today;

	// Check if the user qualifies for leadership fixed daily bonus
	if ($type_level > 0 && $count_directs >= $required_directs && $status === 'active') {
		// Calculate total leadership fixed daily bonus
		$lp_total = bonus_total_leadership_fixed_daily($user_id)['bonus'];
		$lp_add = $lp_total - $user->bonus_leadership_passive_last;

		if ($lp_add > 0) {
			// Apply daily and maximum income limits
			if ($max_daily_income > 0 && ($income_today + $lp_add) >= $max_daily_income) {
				$lp_add = non_zero($max_daily_income - $income_today);
			}

			if ($income_max > 0 && ($user_bonus_lp + $lp_add) >= $income_max) {
				$lp_add = non_zero($income_max - $user_bonus_lp);
			}

			// Handle freeze limit logic
			if ($income_cycle_global >= $freeze_limit) {
				// Update flushout global and mark the user as inactive
				crud(
					'UPDATE network_leadership_passive ' .
					' SET flushout_global = :flushout_global ' .
					' WHERE user_id = :user_id',
					[
						'flushout_global' => ($user->flushout_global + $lp_add),
						'user_id' => $user_id
					]
				);

				crud(
					'UPDATE network_users ' .
					'SET status_global = :status_global, ' .
					'income_flushout = :income_flushout ' .
					'WHERE id = :id',
					[
						'status_global' => 'inactive',
						'income_flushout' => ($user->income_flushout + $lp_add),
						'id' => $user_id
					]
				);

				// Update leadership passive and user records
				update_leadership_passive($user, 0, $lp_total);
				update_user($user, 0);
			} else {
				$diff = $freeze_limit - $income_cycle_global;

				if ($diff < $lp_add) {
					$flushout_global = $lp_add - $diff;

					// Update flushout global and mark the user as inactive
					crud(
						'UPDATE network_leadership_passive ' .
						' SET flushout_global = :flushout_global ' .
						' WHERE user_id = :user_id',
						[
							'flushout_global' => ($user->flushout_global + $flushout_global),
							'user_id' => $user_id
						]
					);

					crud(
						'UPDATE network_users ' .
						'SET status_global = :status_global, ' .
						'income_flushout = :income_flushout, ' .
						'income_cycle_global = :income_cycle_global ' .
						'WHERE id = :id',
						[
							'status_global' => 'inactive',
							'income_flushout' => ($user->income_flushout + $lp_add),
							'income_cycle_global' => ($user->income_cycle_global + $diff),
							'id' => $user_id
						]
					);

					// Update leadership passive and user records
					update_leadership_passive($user, $diff, $lp_total);
					update_user($user, $diff);
				} else {
					// Update income cycle global
					crud(
						'UPDATE network_users ' .
						'SET income_cycle_global = :income_cycle_global ' .
						'WHERE id = :id',
						[
							'income_cycle_global' => ($user->income_cycle_global + $lp_add),
							'id' => $user_id
						]
					);

					// Update leadership passive and user records
					update_leadership_passive($user, $lp_add, $lp_total);
					update_user($user, $lp_add);
				}
			}
		}
	}
}

/**
 * Ensure the value is non-negative.
 *
 * @param mixed $value The value to check.
 * @return int|mixed The non-negative value.
 *
 * @since version
 */
function non_zero($value)
{
	return $value < 0 ? 0 : $value;
}

/**
 * Fetch settings for a specific type.
 *
 * @param string $type The type of settings to fetch.
 * @return mixed The settings object.
 *
 * @since version
 */
function settings($type)
{
	return fetch('SELECT * ' .
		'FROM network_settings_' . $type);
}

/**
 * Fetch user details by user ID.
 *
 * @param int $user_id The user ID.
 * @return mixed The user object.
 *
 * @since version
 */
function user($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);
}

/**
 * Fetch commission deduct details for a user.
 *
 * @param int $user_id The user ID.
 * @return mixed The commission deduct object.
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
 * Calculate leadership fixed daily income for a given level of users.
 *
 * @param array $head An array of sponsor user IDs.
 * @return array[] An array containing the group of users and their passive income.
 *
 * @since version
 */
function level_leadership_fixed_daily(array $head = []): array
{
	$group = [];
	$passive = [];

	foreach ($head as $sponsor) {
		$directs = user_directs($sponsor);

		if (!empty($directs)) {
			foreach ($directs as $direct) {
				$group[] = $direct->id;

				if (empty(user_cd($direct->id))) {
					$passive[] = $direct->fixed_daily_interest;
				}
			}
		}
	}

	return [$group, $passive];
}

/**
 * Calculate leadership fixed daily bonus for a given level of indirect users.
 *
 * @param array $indirect An array of indirect users.
 * @param float $share The share percentage.
 * @param float $share_cut The share cut percentage.
 * @return float|int The calculated leadership fixed daily bonus.
 *
 * @since version
 */
function get_leadership_fixed_daily($indirect, $share, $share_cut)
{
	$leadership = 0;

	if ($indirect) {
		foreach ($indirect as $fixed_daily) {
			$leadership += $fixed_daily * $share * $share_cut / 100 / 100;
		}
	}

	return $leadership;
}

/**
 * Calculate the total leadership fixed daily bonus for a user.
 *
 * @param int $user_id The user ID.
 * @return array An array containing the total members and bonus.
 *
 * @since version
 */
function bonus_total_leadership_fixed_daily($user_id): array
{
	$account_type = user($user_id)->account_type;
	$settings_leadership_passive = settings('leadership_passive');

	$total_members = 0;
	$total_bonus = 0;

	// Start with the user's direct referrals
	$current_level = [$user_id];

	for ($level = 1; $level <= $settings_leadership_passive->{$account_type . '_leadership_passive_level'}; $level++) {
		// Get users and their passive income for the current level
		[$current_level, $passive] = level_leadership_fixed_daily($current_level);

		// Add members and calculate bonus for the current level
		$total_members += count($current_level);
		$total_bonus += get_leadership_fixed_daily(
			$passive,
			$settings_leadership_passive->{$account_type . '_leadership_passive_share_' . $level},
			$settings_leadership_passive->{$account_type . '_leadership_passive_share_cut_' . $level}
		);
	}

	return [
		'member' => $total_members,
		'bonus' => $total_bonus
	];
}