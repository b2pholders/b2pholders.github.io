<?php

namespace Cron\Fixed_Daily;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';
require_once 'cron_leadership_passive.php';
require_once 'cron_fixed_daily_leadership.php';
//require_once 'cron_income_local.php';

use Exception;

use DateTime;
use DateTimeZone;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

use function Cron\Database\Query\fetch_all;
use function Cron\Database\Query\fetch;
use function Cron\Database\Query\crud;

//use function Cron\Income\main as income_global;

use function Cron\Leadership\Fixed_Daily\main as leadership_fixed_daily;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$dbh = DB_Cron::connect();

	$si = settings('investment');

	$fdu = fixed_daily_users();

	if (!empty($fdu)) {
		try {
			$dbh->beginTransaction();

			foreach ($fdu as $fd) {
				$account_type = $fd->account_type;

				//                $interval = $si->{$account_type . '_fixed_daily_interval'};
				$maturity = $si->{$account_type . '_fixed_daily_maturity'};
				$required_directs = $si->{$account_type . '_fixed_daily_required_directs'};
				$actual_directs = directs_valid($fd->user_id);

				//                $interval = $si->{$fd->account_type . '_fixed_daily_interval'};

				$principal = $si->{$fd->account_type . '_fixed_daily_principal'};
				//                $principal_cut = $si->{$fd->account_type . '_fixed_daily_principal_cut'} / 100;

				//                $principal_cut = $principal_cut > 0 ?: 1;

				$interest = $si->{$fd->account_type . '_fixed_daily_interest'} / 100;
				$rate_donation = $si->{$fd->account_type . '_fixed_daily_donation'} / 100;

				//                $diff = time() - $fd->date_last_cron;

				if (
					(($required_directs && $actual_directs >= $required_directs) || !$required_directs)
					&& !$fd->processing
					&& $principal > 0
					&& $fd->day < $maturity
					/*&& $diff >= $interval*/
				) {
					//                    $fd->day++;

					$daily_raw = $interest * $principal;
					$value_now = $daily_raw * (1 - $rate_donation);
					$donation_new = $daily_raw * $rate_donation;

					//                    $principal_new = $principal * /*$principal_cut **/ (1 + $interest * $maturity);
//                    $value_now = ($principal_new / $maturity) * (1 - $rate_donation);

					//                    $donation_new = ($principal_new / $maturity) * $rate_donation;

					//                    try {
//                        $dbh->beginTransaction();

					update_fixed_daily($fd, $value_now, $donation_new);
					//					update_user($fd, $value_now, $donation_new);

					//					logs($user, $value_now);

					//                        $dbh->commit();
//                    } catch (Exception $e) {
//                        try {
//                            $dbh->rollback();
//                        } catch (Exception $e2) {
//                        }
//                    }
				}
			}

			mature();
			// leadership_fixed_daily();

			$dbh->commit();
		} catch (Exception $e) {
			try {
				$dbh->rollback();
			} catch (Exception $e2) {
				echo $e2->getMessage();
			}
		}
	}
}

/**
 * @param $type
 *
 * @return mixed
 *
 * @since version
 */
function settings($type)
{
	return fetch(
		'SELECT * ' .
		'FROM network_settings_' . $type
	);
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function fixed_daily_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fixed_daily d ' .
		'INNER JOIN network_users u ' .
		'ON d.user_id = u.id'
	);
}

/**
 * @param $user
 * @param $value_now
 *
 * @param $donation_new
 *
 * @since version
 */
function update_fixed_daily($user, $value_now, $donation_new)
{
	//	$sp = settings('plans');
//	$sa = settings('ancillaries');
	$se = settings('entry');
	$sf = settings('freeze');

	//	$saf = $sp->account_freeze;

	$user_id = $user->user_id;
	$account_type = $user->account_type;

	$income_cycle_global = $user->income_cycle_global;

	$entry = $se->{$account_type . '_entry'};
	$factor = $sf->{$account_type . '_percentage'} / 100;

	$freeze_limit = $entry * $factor;

	$status = $user->status_global;

	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	if ($income_cycle_global >= $freeze_limit) {
		//		if ($saf)
//		{
//			$flushout_global = $value_now;

		if ($status === 'active') {
			crud(
				'UPDATE network_fixed_daily ' .
				' SET flushout_global = :flushout_global ' .
				' WHERE fixed_daily_id = :fixed_daily_id',
				[
					'flushout_global' => ($user->flushout_global + $value_now),
					'fixed_daily_id' => $user->fixed_daily_id
				]
			);

			crud(
				'UPDATE network_users ' .
				'SET status_global = :status_global, ' .
				'income_flushout = :income_flushout ' .
				'WHERE id = :id',
				[
					'status_global' => 'inactive',
					'income_flushout' => ($user->income_flushout + $value_now),
					'id' => $user->user_id
				]
			);
		}
		//		}
	} else {
		$diff = $freeze_limit - $income_cycle_global;

		if ($diff < $value_now) {
			//			if ($saf)
//			{
			$flushout_global = $value_now - $diff;

			if ($status === 'active') {
				crud(
					'UPDATE network_fixed_daily ' .
					' SET day = :day ' .
					', value_last = :value_last ' .
					', flushout_global = :flushout_global ' .
					', time_last = :time_last ' .
					', date_last_cron = :date_last_cron ' .
					' WHERE fixed_daily_id = :fixed_daily_id',
					[
						'day' => ($user->day + 1)
						,
						'value_last' => ($user->value_last + $diff)
						,
						'flushout_global' => ($user->flushout_global + $flushout_global)
						,
						'time_last' => $now
						,
						'fixed_daily_id' => $user->fixed_daily_id
						,
						'date_last_cron' => time()
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
						'income_cycle_global' => ($user->income_cycle_global + $diff),
						'income_flushout' => ($user->income_flushout + $flushout_global),
						'id' => $user->user_id
					]
				);

				update_user($user, $diff, $donation_new);
			}
			//			}
		} else {
			crud(
				'UPDATE network_fixed_daily ' .
				' SET day = :day ' .
				', value_last = :value_last ' .
				', time_last = :time_last ' .
				', date_last_cron = :date_last_cron ' .
				' WHERE fixed_daily_id = :fixed_daily_id',
				[
					'day' => ($user->day + 1)
					,
					'value_last' => ($user->value_last + $value_now)
					,
					'time_last' => $now
					,
					'fixed_daily_id' => $user->fixed_daily_id
					,
					'date_last_cron' => time()
				]
			);

			crud(
				'UPDATE network_users ' .
				'SET income_cycle_global = :income_cycle_global ' .
				'WHERE id = :id',
				[
					'income_cycle_global' => ($user->income_cycle_global + $value_now),
					'id' => $user->user_id
				]
			);

			update_user($user, $value_now, $donation_new);
		}
	}
}

/**
 * @param $user
 * @param $value_now
 * @param $donation_new
 *
 *
 * @since version
 */
function update_user($user, $value_now, $donation_new)
{
	crud(
		'UPDATE network_users ' .
		'SET donation = :donation, ' .
		'fixed_daily_interest = :fixed_daily_interest, ' .
		'fixed_daily_balance = :fixed_daily_balance ' .
		'WHERE id = :id',
		[
			'donation' => ($user->donation + $donation_new),
			'fixed_daily_interest' => ($user->fixed_daily_interest + $value_now),
			'fixed_daily_balance' => ($user->fixed_daily_balance + $value_now),
			'id' => $user->user_id
		]
	);
}

/**
 * @param $user
 * @param $value_now
 *
 *
 * @since version
 */
//function logs($user, $value_now)
//{
//	$time = new DateTime('now');
//	$time->setTimezone(new DateTimeZone('Asia/Manila'));
//	$now = $time->format('U');
//
//	$code_type_mod = settings('entry')->{$user->account_type . '_package_name'};
//
//	$activity = '<b>' . ucfirst($code_type_mod) . ' ' . settings('plans')->fixed_daily_name . ' of ' .
//		number_format($value_now, 2) . settings('ancillaries')->currency .
//		' was added to </b><a href="' . sef(44) . qs() . 'uid=' . $user->id . '">' . $user->username . '</a>.';
//
//	crud(
//		'INSERT ' .
//		'INTO network_activity (' .
//		'user_id, ' .
//		'sponsor_id, ' .
//		'activity, ' .
//		'activity_date' .
//		') VALUES (' .
//		':user_id, ' .
//		':sponsor_id, ' .
//		':activity, ' .
//		':activity_date' .
//		')',
//		[
//			'user_id'       => $user->id,
//			'sponsor_id'    => $user->sponsor_id,
//			'activity'      => $activity,
//			'activity_date' => $now
//		]
//	);
//}

/**
 *
 * @return array|false
 *
 * @since version
 */
function fixed_daily()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fixed_daily'
	);
}

/**
 *
 *
 * @since version
 */
function mature()
{
	$dbh = DB_Cron::connect();

	$si = settings('investment');

	$results = fixed_daily_users();

	if (!empty($results)) {
		foreach ($results as $result) {
			$maturity = $si->{$result->account_type . '_fixed_daily_maturity'};

			if ($result->day === $maturity && (int) $result->time_mature === 0) {
				try {
					$dbh->beginTransaction();

					update_fixed_daily_time_mature($result);

					$dbh->commit();
				} catch (Exception $e) {
					try {
						$dbh->rollback();
					} catch (Exception $e2) {
					}
				}
			}
		}
	}
}

/**
 * @param $result
 *
 *
 * @since version
 */
function update_fixed_daily_time_mature($result)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	crud(
		'UPDATE network_fixed_daily ' .
		'SET time_mature = :time_mature ' .
		'WHERE fixed_daily_id = :fixed_daily_id',
		[
			'time_mature' => $now,
			'fixed_daily_id' => $result->fixed_daily_id
		]
	);
}

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function directs_valid($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type ' .
		' AND sponsor_id = :sponsor_id',
		[
			'account_type' => 'starter',
			'sponsor_id' => $user_id
		]
	);
}