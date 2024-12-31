<?php

namespace BPL\Cron\Compound_Daily;

require_once '../lib/Db_Connect.php';
require_once '../mods/url_sef_local.php';
require_once '../mods/helpers_local.php';

require_once 'cron_leadership_compound_daily.php';

use Exception;

use DateTime;
use DateTimeZone;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Cron\Leadership\Compound_Daily\main as leadership_compound_daily;

use function BPL\Mods\Local\Url_SEF\qs;
use function BPL\Mods\Local\Url_SEF\sef;

use function BPL\Mods\Local\Helpers\settings;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$users = compound_users();

	if ($users)
	{
		$dbh = DB::connect();

		$settings_investment = settings('investment');

		foreach ($users as $user)
		{
			$principal     = $settings_investment->{$user->account_type . '_principal'};
			$principal_cut = $settings_investment->{$user->account_type . '_principal_cut'} / 100;
			$interest      = $settings_investment->{$user->account_type . '_interest'} / 100;
			$rate_donation = $settings_investment->{$user->account_type . '_donation'} / 100;

			if (empty($user->processing) &&
				$principal > 0 &&
				$user->day < $user->maturity)
			{
				$user->day++;

				$principal_new = $principal * $principal_cut * bcpow((string) (1 + $interest), $user->day, 7);
				$value_now     = ($principal_new - $user->value_last) * (1 - $rate_donation);
				$donation_new  = ($principal_new - $user->value_last) * $rate_donation;

				try
				{
					$dbh->beginTransaction();

					update_compound_daily($user, $value_now);
					update_user_interest($user, $value_now, $donation_new);

					logs($user, $value_now);

					leadership_compound_daily();

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
					}
				}
			}
		}
	}

	reap_compound_daily();
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function compound_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_compound c ' .
		'INNER JOIN network_users u ' .
		'ON c.user_id = u.id'
	);
}

/**
 * @param $user
 * @param $value_now
 *
 *
 * @since version
 */
function update_compound_daily($user, $value_now)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	crud(
		'UPDATE network_compound ' .
		'SET day = :day, ' .
		'value_last = :value_last, ' .
		'time_last = :time_last ' .
		'WHERE id = :id',
		[
			'day'        => $user->day,
			'value_last' => ($user->value_last + $value_now),
			'time_last'  => $now,
			'id'         => $user->id
		]
	);
}

/**
 * @param $user
 * @param $value_now
 * @param $donation_new
 *
 *
 * @since version
 */
function update_user_interest($user, $value_now, $donation_new)
{
	crud(
		'UPDATE network_users ' .
		'SET donation = :donation, ' .
		'compound_daily_interest = :interest ' .
		'WHERE id = :id',
		[
			'donation' => ($user->donation + $donation_new),
			'interest' => ($user->compound_daily_interest + $value_now),
			'id'       => $user->user_id
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
function logs($user, $value_now)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	$code_type_mod = settings('entry')->{$user->account_type . '_package_name'};

	$activity = '<b>' . ucfirst($code_type_mod) . ' ' . settings('plans')->etrade_name .
		' of ' . number_format($value_now, 2) . settings('ancillaries')->currency .
		' was added to </b><a href="' . sef(44) . qs() . 'uid=' .
		$user->user_id . '">' . $user->username . '</a>.';

	crud(
		'INSERT ' .
		'INTO network_activity (' .
		'user_id, ' .
		'sponsor_id, ' .
		'activity, ' .
		'activity_date' .
		') VALUES (' .
		':user_id, ' .
		':sponsor_id, ' .
		':activity, ' .
		':activity_date' .
		')',
		[
			'user_id'       => $user->id,
			'sponsor_id'    => $user->sponsor_id,
			'activity'      => $activity,
			'activity_date' => $now
		]
	);
}

/**
 *
 *
 * @since version
 */
function reap_compound_daily()
{
	$dbh = DB::connect();

	$users = compound_users();

	if ($users)
	{
		foreach ($users as $user)
		{
			if ($user->day === $user->maturity && (int) $user->time_mature === 0)
			{
				try
				{
					$dbh->beginTransaction();

					update_user_daily($user);
					update_time_mature($user);

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
					}
				}
			}
		}
	}
}

/**
 * @param $user
 *
 *
 * @since version
 */
function update_user_daily($user)
{
	crud(
		'UPDATE network_users ' .
		'SET compound_daily_balance = :balance ' .
		'WHERE id = :id',
		[
			'balance' => ($user->compound_daily_balance + $user->value_last),
			'id'      => $user->user_id
		]
	);
}

/**
 * @param $user
 *
 *
 * @since version
 */
function update_time_mature($user)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	crud(
		'UPDATE network_compound ' .
		'SET time_mature = :time_mature ' .
		'WHERE id = :id',
		[
			'time_mature' => $now,
			'id'          => $user->id
		]
	);
}