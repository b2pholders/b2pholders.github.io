<?php

namespace Cron\Fast_Track;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';
require_once 'cron_fast_track_leadership.php';

//require_once 'cron_income_local.php';

use Exception;

use DateTime;
use DateTimeZone;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

use function Cron\Database\Query\fetch_all;
use function Cron\Database\Query\fetch;
use function Cron\Database\Query\crud;

//use function Cron\Income\main as income_global;

use function Cron\Leadership\Fast_Track\main as leadership_fast_track;

//use function BPL\Mods\Local\Url_SEF\qs;
//use function BPL\Mods\Local\Url_SEF\sef;

//use function BPL\Mods\Local\Helpers\settings;

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

	$ftu = fast_track_users();

	if (!empty($ftu))
	{
		try
		{
			$dbh->beginTransaction();

			foreach ($ftu as $ft)
			{
				$account_type = $ft->account_type;

//                $interval = $si->{$account_type . '_fast_track_interval'};
				$maturity         = $si->{$account_type . '_fast_track_maturity'};
				$required_directs = $si->{$account_type . '_fast_track_required_directs'};
				$actual_directs   = directs_valid($ft->user_id);

				$interest      = $si->{$account_type . '_fast_track_interest'} / 100;
				$rate_donation = $si->{$account_type . '_fast_track_donation'} / 100;

//                $diff = time() - $ft->date_last_cron;

				if ((($required_directs && $actual_directs >= $required_directs) || !$required_directs)
					&& !$ft->processing
					&& $ft->principal
					&& $ft->day < $maturity
//                    && $diff >= $interval
				)
				{
					$daily_raw    = $interest * $ft->principal;
					$value_now    = $daily_raw * (1 - $rate_donation);
					$donation_new = $daily_raw * $rate_donation;

					update_fast_track($ft, $value_now, $donation_new);
					/*update_user($ft, $value_now, $donation_new);*/

//					logs($ft, $value_now);
				}
			}

			mature();
			leadership_fast_track();
			reap_fast_track();

			$dbh->commit();
		}
		catch (Exception $e)
		{
			try
			{
				$dbh->rollback();
			}
			catch (Exception $e2)
			{
				echo $e2->getMessage();
			}
		}
	}

//	echo 'test';
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
 * @param $user_id
 *
 * @return mixed
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
 *
 * @return array|false
 *
 * @since version
 */
function fast_track_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fast_track f ' .
		'INNER JOIN network_users u ' .
		'ON f.user_id = u.id'
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
function update_fast_track($user, $value_now, $donation_new)
{
//	$sp = settings('plans');
//	$sa = settings('ancillaries');
//	$se = settings('entry');
//	$sf = settings('freeze');

//	$saf = $sp->account_freeze;

//	$user_id      = $user->user_id;
//	$account_type = $user->account_type;

//	$income_cycle_global = $user->income_cycle_global;
//
//	$entry  = $se->{$account_type . '_entry'};
//	$factor = $sf->{$account_type . '_percentage'} / 100;

//	$freeze_limit = $entry * $factor;

//	$status = $user->status_global;

	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

//	if ($income_cycle_global >= $freeze_limit)
//	{
////		if ($saf)
////		{
////		$flushout_global = $value_now;
//
//		if ($user->status_global === 'active')
//		{
//			crud(
//				'UPDATE network_fast_track ' .
//				' SET flushout_global = :flushout_global ' .
//				'WHERE fast_track_id = :fast_track_id',
//				[
//					'flushout_global' => ($user->flushout_global + $value_now),
//					'fast_track_id'   => $user->fast_track_id
//				]
//			);
//
//			crud(
//				'UPDATE network_users ' .
//				'SET status_global = :status_global, ' .
//				'income_flushout = :income_flushout ' .
//				'WHERE id = :id',
//				[
//					'status_global'   => 'inactive',
//					'income_flushout' => ($user->income_flushout + $value_now),
//					'id'              => $user->user_id
//				]
//			);
//		}
////		}
//	}
//	else
//	{
//		$diff = $freeze_limit - $income_cycle_global;
//
//		if ($diff < $value_now)
//		{
////			if ($saf)
////			{
//			$flushout_global = $value_now - $diff;
//
//			if ($user->status_global === 'active')
//			{
//				crud(
//					'UPDATE network_fast_track ' .
//					'SET day = :day, ' .
//					'value_last = :value_last, ' .
//					'flushout_global = :flushout_global, ' .
//					'time_last = :time_last, ' .
//					'date_last_cron = :date_last_cron ' .
//					'WHERE fast_track_id = :fast_track_id',
//					[
//						'day'             => ($user->day + 1),
//						'value_last'      => ($user->value_last + $diff),
//						'flushout_global' => ($user->flushout_global + $flushout_global),
//						'time_last'       => $now,
//						'fast_track_id'   => $user->fast_track_id,
//						'date_last_cron'  => time()
//					]
//				);
//
//				crud(
//					'UPDATE network_users ' .
//					'SET status_global = :status_global, ' .
//					'income_flushout = :income_flushout, ' .
//					'income_cycle_global = :income_cycle_global ' .
//					'WHERE id = :id',
//					[
//						'status_global'       => 'inactive',
//						'income_cycle_global' => ($user->income_cycle_global + $diff),
//						'income_flushout'     => ($user->income_flushout + $flushout_global),
//						'id'                  => $user->user_id
//					]
//				);
//
//				update_user($user, $diff, $donation_new);
//			}
////			}
//		}
//		else
//		{
			crud(
				'UPDATE network_fast_track ' .
				'SET day = :day, ' .
				'value_last = :value_last, ' .
				'time_last = :time_last, ' .
				'date_last_cron = :date_last_cron ' .
				'WHERE fast_track_id = :fast_track_id',
				[
					'day'            => ($user->day + 1),
					'value_last'     => ($user->value_last + $value_now),
					'time_last'      => $now,
					'fast_track_id'  => $user->fast_track_id,
					'date_last_cron' => time()
				]
			);

//			crud(
//				'UPDATE network_users ' .
//				'SET income_cycle_global = :income_cycle_global ' .
//				'WHERE id = :id',
//				[
//					'income_cycle_global' => ($user->income_cycle_global + $value_now),
//					'id'                  => $user->user_id
//				]
//			);

			update_user($user, $value_now, $donation_new);
//		}
//	}
}

/**
 * @param $fast_track
 * @param $value_now
 * @param $donation_new
 *
 *
 * @since version
 */
function update_user($fast_track, $value_now, $donation_new)
{
	crud(
		'UPDATE network_users ' .
		'SET donation = :donation, ' .
		'fast_track_interest = :fast_track_interest, ' .
		'fast_track_balance = :fast_track_balance ' .
		'WHERE id = :id',
		[
			'donation'            => ($fast_track->donation + $donation_new),
			'fast_track_interest' => ($fast_track->fast_track_interest + $value_now),
			'fast_track_balance'  => ($fast_track->fast_track_balance + $value_now),
			'id'                  => $fast_track->user_id
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
//	$activity = '<b>' . ucfirst(settings('entry')->{$user->account_type . '_package_name'}) . ' ' .
//		settings('plans')->fast_track_name . ' of ' . number_format($value_now, 2) .
//		settings('ancillaries')->currency . ' was added to </b><a href="' . sef(44) . qs() . 'uid=' .
//		$user->id . '">' . $user->username . '</a>.';
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
//			'user_id'       => $user->user_id,
//			'sponsor_id'    => $user->sponsor_id,
//			'activity'      => $activity,
//			'activity_date' => $now
//		]
//	);
//}

/**
 *
 *
 * @since version
 */
function mature()
{
	$si = settings('investment');

	$ftu = fast_track_users();

	if (!empty($ftu))
	{
		foreach ($ftu as $ft)
		{
			$maturity = $si->{$ft->account_type . '_fast_track_maturity'};

			if ($ft->day === $maturity && !$ft->time_mature)
			{
				update_fast_track_time_mature($ft);
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
function update_fast_track_time_mature($result)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	crud(
		'UPDATE network_fast_track ' .
		'SET time_mature = :time_mature ' .
		'WHERE fast_track_id = :fast_track_id',
		[
			'time_mature'   => $now,
			'fast_track_id' => $result->fast_track_id
		]
	);
}

function reset_fast_track_value_last($fast_track)
{
	crud(
		'UPDATE network_fast_track ' .
		'SET value_last = :value_last ' .
		'WHERE fast_track_id = :fast_track_id',
		[
			'value_last'    => 0,
			'fast_track_id' => $fast_track->fast_track_id
		]
	);
}

/**
 * @param $ft_user
 *
 * @param $ft_principal
 *
 * @since version
 */
function update_user_fund($ft_user, $ft_principal)
{
//    $sa = settings('ancillaries');
//
//    $balance_new = $user->balance + $balance;
//	$payout_transfer_new = $ft_user->payout_transfer + $ft_principal;
	$points_new          = $ft_user->points + $ft_user->value_last;
//	$points_new = $user->points + $balance;

//	$field = /*$sa->withdrawal_mode === 'standard' ? 'balance' : 'payout_transfer'*/
//		/*'points'*/'payout_transfer';
//	$value = /*$sa->withdrawal_mode === 'standard' ? $balance_new : $payout_transfer_new*/
//		/*$points_new*/$payout_transfer_new;

	crud(
		'UPDATE network_users ' .
		'SET points = :points ' .
		'WHERE id = :id',
		[
//			'payout_transfer' => $payout_transfer_new,
			'points'          => $points_new,
			'id'              => $ft_user->user_id
		]
	);
}

/**
 * @param $user
 *
 * @param $value
 *
 * @since version
 */
function update_user_fast_track_balance($user, $value)
{
	crud(
		'UPDATE network_users ' .
		'SET fast_track_balance = :fast_track_balance ' .
		'WHERE id = :id',
		[
			'fast_track_balance' => ($user->fast_track_balance +  $value),
			'id'                 => $user->user_id
		]
	);
}

/**
 *
 *
 * @since version
 */
function reap_fast_track()
{
	$fts = fast_track_users();

	if (!empty($fts))
	{
		foreach ($fts as $ft)
		{
//			$minimum_deposit = settings('investment')->{$ft->account_type . '_fast_track_minimum_deposit'};

			if ($ft->time_mature && $ft->fast_track_balance && $ft->value_last > 0)
			{
				update_user_fund($ft, /*$ft->fast_track_balance*/ $ft->principal);
				update_user_fast_track_balance($ft, 0);
				reset_fast_track_value_last($ft);
			}
//			elseif (!$ft->time_mature && $ft->fast_track_balance >= $minimum_deposit)
//			{
//				update_user_fund($ft, $minimum_deposit);
//				update_user_fast_track_balance($ft, ($ft->fast_track_balance - $minimum_deposit));
//			}
			elseif (!$ft->time_mature && !$ft->fast_track_balance)
			{
				break;
			}
		}
	}
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
			'sponsor_id'   => $user_id
		]
	);
}