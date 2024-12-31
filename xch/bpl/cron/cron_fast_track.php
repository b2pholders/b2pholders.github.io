<?php
//
//namespace BPL\Cron\Fast_Track;
//
//require_once '../lib/Db_Connect.php';
//require_once '../mods/url_sef_local.php';
//require_once '../mods/helpers_local.php';
//
//require_once 'cron_leadership_fast_track.php';
//
//use Exception;
//
//use DateTime;
//use DateTimeZone;
//
//use BPL\Lib\Local\Database\Db_Connect as DB;
//
//use function BPL\Mods\Local\Database\Query\fetch_all;
//use function BPL\Mods\Local\Database\Query\crud;
//
//use function BPL\Cron\Leadership\Fast_Track\main as leadership_fast_track;
//
//use function BPL\Mods\Local\Url_SEF\qs;
//use function BPL\Mods\Local\Url_SEF\sef;
//
//use function BPL\Mods\Local\Helpers\settings;
//
////use function BPL\Mods\Local\Helpers\users;
//
//main();
//
///**
// *
// *
// * @since version
// */
//function main()
//{
//	$dbh = DB::connect();
//
//	$settings_investment = settings('investment');
//
//	$fast_track_users = fast_track_users();
//
//	if (!empty($fast_track_users))
//	{
//		try
//		{
//			$dbh->beginTransaction();
//
////			$users = users();
//
//			foreach ($fast_track_users as $fast_track)
//			{
////				foreach ($users as $user)
////				{
//				$interest = $settings_investment->{$fast_track->account_type . '_fast_track_interest'};
//
//				$interest = bcdiv($interest, 100, 7);
//
//				$rate_donation = $settings_investment->{$fast_track->account_type . '_fast_track_donation'};
//
//				$rate_donation = bcdiv($rate_donation, 100, 7);
//
//				if (!$fast_track->processing &&
//					$fast_track->principal &&
//					$fast_track->day < $fast_track->maturity)
//				{
////						++$fast_track->day;
//
//					$daily_raw       = bcmul($interest, $fast_track->principal, 7);
//					$daily_reduction = bcsub(1, $rate_donation, 7);
//					$value_now       = round(bcmul($daily_raw, $daily_reduction, 7), 2);
//					$donation_new    = round(bcmul($daily_raw, $rate_donation, 7), 2);
//
//					update_fast_track($fast_track, $value_now);
//					update_user($fast_track, $value_now, $donation_new);
//
//					logs($fast_track, $value_now);
//				}
////				}
//			}
//
//			mature();
//			leadership_fast_track();
//			reap_fast_track();
//
//			$dbh->commit();
//		}
//		catch (Exception $e)
//		{
//			try
//			{
//				$dbh->rollback();
//			}
//			catch (Exception $e2)
//			{
//				echo $e2->getMessage();
//			}
//		}
//	}
//
//	echo 'test';
//}
//
///**
// *
// * @return array|false
// *
// * @since version
// */
//function fast_track_users()
//{
//	return fetch_all(
//		'SELECT * ' .
//		'FROM network_fast_track f ' .
//		'INNER JOIN network_users u ' .
//		'ON f.user_id = u.id'
//	);
//}
//
///**
// * @param $fast_track
// * @param $value_now
// *
// *
// * @since version
// */
//function update_fast_track($fast_track, $value_now)
//{
//	$time = new DateTime('now');
//	$time->setTimezone(new DateTimeZone('Asia/Manila'));
//	$now = $time->format('U');
//
//	crud(
//		'UPDATE network_fast_track ' .
//		'SET day = :day, ' .
//		'value_last = :value_last, ' .
//		'time_last = :time_last ' .
//		'WHERE fast_track_id = :fast_track_id',
//		[
//			'day'           => $fast_track->day + 1,
//			'value_last'    => $fast_track->value_last + $value_now,
//			'time_last'     => $now,
//			'fast_track_id' => $fast_track->fast_track_id
//		]
//	);
//}
//
///**
// * @param $user
// * @param $value_now
// * @param $donation_new
// *
// *
// * @since version
// */
//function update_user($user, $value_now, $donation_new)
//{
//	crud(
//		'UPDATE network_users ' .
//		'SET donation = :donation, ' .
//		'fast_track_interest = :fast_track_interest, ' .
//		'fast_track_balance = :fast_track_balance ' .
//		'WHERE id = :id',
//		[
//			'donation'            => $user->donation + $donation_new,
//			'fast_track_interest' => $user->fast_track_interest + $value_now,
//			'fast_track_balance'  => $user->fast_track_balance + $value_now,
//			'id'                  => $user->user_id
//		]
//	);
//}
//
///**
// * @param $user
// * @param $value_now
// *
// *
// * @since version
// */
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
//
///**
// *
// *
// * @since version
// */
//function mature()
//{
//	$results = fast_track_users();
//
//	if (!empty($results))
//	{
//		foreach ($results as $result)
//		{
//			if ($result->day === $result->maturity && !$result->time_mature)
//			{
//				update_fast_track_time_mature($result);
//			}
//		}
//	}
//}
//
///**
// * @param $result
// *
// *
// * @since version
// */
//function update_fast_track_time_mature($result)
//{
//	$time = new DateTime('now');
//	$time->setTimezone(new DateTimeZone('Asia/Manila'));
//	$now = $time->format('U');
//
//	crud(
//		'UPDATE network_fast_track ' .
//		'SET time_mature = :time_mature ' .
//		'WHERE fast_track_id = :fast_track_id',
//		[
//			'time_mature'   => $now,
//			'fast_track_id' => $result->fast_track_id
//		]
//	);
//}
//
///**
// * @param $user
// *
// * @param $balance
// *
// * @since version
// */
//function update_user_fund($user, $balance)
//{
//	$settings_ancillaries = settings('ancillaries');
//
//	$balance_new         = $user->balance + $balance;
//	$payout_transfer_new = $user->payout_transfer + $balance;
//
//	$field = $settings_ancillaries->withdrawal_mode === 'standard' ? 'balance' : 'payout_transfer';
//	$value = $settings_ancillaries->withdrawal_mode === 'standard' ? $balance_new : $payout_transfer_new;
//
//	crud(
//		'UPDATE network_users ' .
//		'SET ' . $field . ' = :amount ' .
//		'WHERE id = :id',
//		[
//			'amount' => $value,
//			'id'     => $user->user_id
//		]
//	);
//}
//
///**
// * @param $user
// *
// * @param $value
// *
// * @since version
// */
//function update_user_fast_track_balance($user, $value)
//{
//	crud(
//		'UPDATE network_users ' .
//		'SET fast_track_balance = :fast_track_balance ' .
//		'WHERE id = :id',
//		[
//			'fast_track_balance' => $user->fast_track_balance + $value,
//			'id'                 => $user->user_id
//		]
//	);
//}
//
///**
// *
// *
// * @since version
// */
//function reap_fast_track()
//{
//	$users = fast_track_users();
//
//	if (!empty($users))
//	{
////		foreach ($users as $fast_track)
////		{
////			$users = users();
//
//			foreach ($users as $user)
//			{
//				$minimum_deposit = settings('investment')->{$user->account_type . '_fast_track_minimum_deposit'};
//
//				if ($user->time_mature && $user->fast_track_balance)
//				{
//					update_user_fund($user, $user->fast_track_balance);
//					update_user_fast_track_balance($user, 0);
//				}
//				elseif (!$user->time_mature && $user->fast_track_balance >= $minimum_deposit)
//				{
//					update_user_fund($user, $minimum_deposit);
//					update_user_fast_track_balance($user, ($user->fast_track_balance - $minimum_deposit));
//				}
//				elseif (!$user->time_mature && !$user->fast_track_balance)
//				{
//					break;
//				}
//			}
////		}
//	}
//}