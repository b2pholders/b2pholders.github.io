<?php

namespace BPL\Cron\Top_Up;

require_once '../lib/Db_Connect.php';
require_once '../mods/url_sef_local.php';
require_once '../mods/helpers_local.php';

require_once 'cron_leadership_top_up.php';

use Exception;

use DateTime;
use DateTimeZone;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Cron\Leadership\Top_Up\main as leadership_top_up;

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
	$dbh = DB::connect();

	$settings_investment = settings('investment');

	$users = top_up_users();

	if ($users)
	{
		foreach ($users as $user)
		{
			$principal_cut = $settings_investment->{$user->account_type . '_top_up_principal_cut'} / 100;
			$interest      = $settings_investment->{$user->account_type . '_top_up_interest'} / 100;
			$rate_donation = $settings_investment->{$user->account_type . '_top_up_donation'} / 100;

			if (empty($user->processing) &&
				$user->principal > 0 &&
				$user->day < $user->maturity)
			{
				$user->day++;

				$compounder = bcpow((string) (1 + $interest), $user->day, 7);

				$principal_new = $user->principal * $principal_cut * $compounder;
				$value_now     = ($principal_new - $user->value_last) * (1 - $rate_donation);
				$donation_new  = ($principal_new - $user->value_last) * $rate_donation;

				try
				{
					$dbh->beginTransaction();

					update_top_up($user, $value_now);
					update_user($user, $value_now, $donation_new);

					logs($user, $value_now);

					leadership_top_up();

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

	reap_top_up();
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function top_up_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_top_up t ' .
		'INNER JOIN network_users u ' .
		'ON t.user_id = u.id'
	);
}

/**
 * @param $user
 * @param $value_now
 *
 *
 * @since version
 */
function update_top_up($user, $value_now)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U'); // seconds since unix epoch

	crud(
		'UPDATE network_top_up ' .
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
function update_user($user, $value_now, $donation_new)
{
	crud(
		'UPDATE network_users ' .
		'SET donation = :donation, ' .
		'top_up_interest = :interest ' .
		'WHERE id = :id',
		[
			'donation' => ($user->donation + $donation_new),
			'interest' => ($user->top_up_interest + $value_now),
			'id'       => $user->id
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
	$now = $time->format('U'); // seconds since unix epoch

	$code_type_mod = settings('entry')->{$user->account_type . '_package_name'};

	$activity = '<b>' . ucfirst($code_type_mod) . ' ' . settings('plans')->top_up_name . ' of ' .
		number_format($value_now, 2) . settings('ancillaries')->currency .
		' was added to </b><a href="' . sef(44) . qs() . 'uid=' . $user->id . '">' . $user->username . '</a>.';

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
 * @param $result
 *
 *
 * @since version
 */
function update_user_fund($result)
{
	crud(
		'UPDATE network_users ' .
		'SET top_up_balance = :balance ' .
		'WHERE id = :id',
		[
			'balance' => ($result->top_up_balance + $result->value_last),
			'id'      => $result->id
		]
	);
}

/**
 * @param $result
 *
 *
 * @since version
 */
function update_top_time_mature($result)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U'); // seconds since unix epoch

	crud(
		'UPDATE network_top_up ' .
		'SET time_mature = :time_mature ' .
		'WHERE id = :id',
		[
			'time_mature' => $now,
			'id'          => $result->id
		]
	);
}

/**
 *
 *
 * @since version
 */
function reap_top_up()
{
	$dbh = DB::connect();

	$results = top_up_users();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
			// check for day equal maturity with 0 time_mature
			if ($result->day === $result->maturity && (int) $result->time_mature === 0)
			{
				try
				{
					$dbh->beginTransaction();

					update_user_fund($result);
					update_top_time_mature($result);

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