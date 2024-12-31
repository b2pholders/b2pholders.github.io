<?php

namespace BPL\Cron\Endowment;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use Exception;

use DateTime;
use DateTimeZone;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$dbh = DB::connect();

	$endowments = endowments();

	if ($endowments)
	{
		try
		{
			$dbh->beginTransaction();

			foreach ($endowments as $endowment)
			{
				if (!$endowment->time_mature)
				{
					$daily = 100;

					update_endowment($endowment, $daily);
					update_user($endowment, $daily);
				}
			}

			bonus();

			mature();

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

/**
 *
 * @return array|false
 *
 * @since version
 */
function endowments()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_endowment'
	);
}

/**
 * @param $endowment
 * @param $daily
 *
 *
 * @since version
 */
function update_endowment($endowment, $daily)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	crud(
		'UPDATE network_endowment ' .
		'SET day = :day, ' .
		'value_last = :value_last, ' .
		'pocket = :pocket, ' .
		'time_last = :time_last ' .
		'WHERE endowment_id = :endowment_id',
		[
			'day'          => ($endowment->day + 1),
			'value_last'   => ($endowment->value_last + $daily),
			'pocket'       => ($endowment->pocket + $daily),
			'time_last'    => $now,
			'endowment_id' => $endowment->endowment_id
		]
	);
}

/**
 * @param $endowment
 * @param $daily
 *
 *
 * @since version
 */
function update_user($endowment, $daily)
{
	$user = user($endowment->user_id);

	crud(
		'UPDATE network_users ' .
		'SET endowment_bonus = :endowment_bonus ' .
		'WHERE id = :id',
		[
			'endowment_bonus' => ($user->endowment_bonus + $daily),
			'id'              => $user->user_id
		]
	);
}

/**
 * @param $endowment
 * @param $pocket
 *
 * @since version
 */
function update_endowment_pocket($endowment, $pocket)
{
	crud(
		'UPDATE network_endowment ' .
		'SET pocket = :pocket ' .
		'WHERE endowment_id = :endowment_id',
		[
			'pocket'       => $pocket,
			'endowment_id' => $endowment->endowment_id
		]
	);
}

/**
 * @param $endowment
 * @param $harvest
 *
 *
 * @since version
 */
function update_user_balance($endowment, $harvest)
{
	$user = user($endowment->user_id);

	crud(
		'UPDATE network_users ' .
		'SET balance = :balance ' .
		'WHERE id = :id',
		[
			'balance' => ($user->balance + $harvest),
			'id'      => $user->id
		]
	);
}

/**
 *
 *
 * @since version
 */
function bonus()
{
	$endowments = endowments();

	if ($endowments)
	{
		foreach ($endowments as $endowment)
		{
			$period  = 2; // days
			$harvest = 150; // good as cash

			if (!$endowment->time_mature &&
				$endowment->day &&
				$endowment->day % $period === 0)
			{
				update_endowment_pocket($endowment, ($endowment->pocket - $harvest));
				update_user_balance($endowment, $harvest);
			}
			elseif ($endowment->time_mature && $endowment->pocket)
			{
				update_endowment_pocket($endowment, 0);
				update_user_balance($endowment, $endowment->pocket);
			}
		}
	}
}

/**
 *
 *
 * @since version
 */
function mature()
{
	$endowments = endowments();

	if (!empty($endowments))
	{
		foreach ($endowments as $endowment)
		{
			// check for month equal maturity with 0 time_mature
			if ($endowment->day === $endowment->maturity && !$endowment->time_mature)
			{
				update_endowment_time_mature($endowment);
			}
		}
	}
}

/**
 * @param $endowment
 *
 *
 * @since version
 */
function update_endowment_time_mature($endowment)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	crud(
		'UPDATE network_endowment ' .
		'SET time_mature = :time_mature ' .
		'WHERE endowment_id = :endowment_id',
		[
			'time_mature'  => $now,
			'endowment_id' => $endowment->endowment_id
		]
	);
}