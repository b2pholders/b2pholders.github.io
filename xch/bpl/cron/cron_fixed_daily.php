<?php
//
//namespace BPL\Cron\Fixed_Daily;
//
//require_once '../lib/Db_Connect.php';
//require_once '../mods/url_sef_local.php';
//require_once '../mods/helpers_local.php';
//
//require_once 'cron_leadership_fixed_daily.php';
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
//use function BPL\Cron\Leadership\Fixed_Daily\main as leadership_fixed_daily;
//
//use function BPL\Mods\Local\Url_SEF\qs;
//use function BPL\Mods\Local\Url_SEF\sef;
//
//use function BPL\Mods\Local\Helpers\settings;
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
//	$users = fixed_daily_users();
//
//	if (!empty($users))
//	{
//		foreach ($users as $user)
//		{
//			$principal     = $settings_investment->{$user->account_type . '_fixed_daily_principal'};
//			$principal_cut = $settings_investment->{$user->account_type . '_fixed_daily_principal_cut'} / 100;
//			$interest      = $settings_investment->{$user->account_type . '_fixed_daily_interest'} / 100;
//			$rate_donation = $settings_investment->{$user->account_type . '_fixed_daily_donation'} / 100;
//
//			if (empty($user->processing) &&
//				$principal > 0 &&
//				$user->day < $user->maturity)
//			{
//				$user->day++;
//
//				$principal_new = $user->principal * $principal_cut * (1 + $interest * $user->maturity);
//				$value_now     = ($principal_new / $user->maturity) * (1 - $rate_donation);
//				$donation_new  = ($principal_new / $user->maturity) * $rate_donation;
//
//				try
//				{
//					$dbh->beginTransaction();
//
//					update_fixed_daily($user, $value_now);
//					update_user($user, $value_now, $donation_new);
//
//					logs($user, $value_now);
//
//					leadership_fixed_daily();
//
//					$dbh->commit();
//				}
//				catch (Exception $e)
//				{
//					try
//					{
//						$dbh->rollback();
//					}
//					catch (Exception $e2)
//					{
//					}
//				}
//			}
//		}
//	}
//
//	mature();
//}
//
///**
// *
// * @return array|false
// *
// * @since version
// */
//function fixed_daily_users()
//{
//	return fetch_all(
//		'SELECT * ' .
//		'FROM network_fixed_daily d ' .
//		'INNER JOIN network_users u ' .
//		'ON d.user_id = u.id'
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
//function update_fixed_daily($user, $value_now)
//{
//	$time = new DateTime('now');
//	$time->setTimezone(new DateTimeZone('Asia/Manila'));
//	$now = $time->format('U');
//
//	crud(
//		'UPDATE network_fixed_daily ' .
//		'SET day = :day, ' .
//		'value_last = :value_last, ' .
//		'time_last = :time_last ' .
//		'WHERE id = :id',
//		[
//			'day'        => $user->day,
//			'value_last' => ($user->value_last + $value_now),
//			'time_last'  => $now,
//			'id'         => $user->id
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
//		'fixed_daily_interest = :fixed_daily_interest, ' .
//		'fixed_daily_balance = :fixed_daily_balance ' .
//		'WHERE id = :id',
//		[
//			'donation'             => ($user->donation + $donation_new),
//			'fixed_daily_interest' => ($user->fixed_daily_interest + $value_now),
//			'fixed_daily_balance'  => ($user->fixed_daily_balance + $value_now),
//			'id'                   => $user->id
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
//
///**
// *
// * @return array|false
// *
// * @since version
// */
//function fixed_daily()
//{
//	return fetch_all(
//		'SELECT * ' .
//		'FROM network_fixed_daily'
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
//	$dbh = DB::connect();
//
//	$results = fixed_daily();
//
//	if (!empty($results))
//	{
//		foreach ($results as $result)
//		{
//			if ($result->day === $result->maturity && (int) $result->time_mature === 0)
//			{
//				try
//				{
//					$dbh->beginTransaction();
//
//					update_fixed_daily_time_mature($result);
//
//					$dbh->commit();
//				}
//				catch (Exception $e)
//				{
//					try
//					{
//						$dbh->rollback();
//					}
//					catch (Exception $e2)
//					{
//					}
//				}
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
//function update_fixed_daily_time_mature($result)
//{
//	$time = new DateTime('now');
//	$time->setTimezone(new DateTimeZone('Asia/Manila'));
//	$now = $time->format('U');
//
//	crud(
//		'UPDATE network_fixed_daily ' .
//		'SET time_mature = :time_mature ' .
//		'WHERE id = :id',
//		[
//			'time_mature' => $now,
//			'id'          => $result->id
//		]
//	);
//}