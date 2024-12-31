<?php

namespace Cron\Leadership_Passive_Flushout;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';

use Exception;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

use function Cron\Database\Query\fetch;
use function Cron\Database\Query\fetch_all;
use function Cron\Database\Query\crud;

main();

/**
 *
 *
 * @since version
 */
function main()
{
//    $interval = 12 * 60 * 60; // 12-hour cycle

	$dbh = DB_Cron::connect();

	$users = lp_users();

	if (!empty($users))
	{
		foreach ($users as $user)
		{
			$flushed = flushed($user->account_type, $user->income_today);

//            $diff = time() - $user->date_last_flushout;

			if ($flushed/* && ($diff >= $interval)*/)
			{
				try
				{
					$dbh->beginTransaction();

					update_lp($user);

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
function lp_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_leadership_passive lp ' .
		'INNER JOIN network_users u ' .
		'ON lp.user_id = u.id'
	);
}

/**
 * @param $user
 *
 * @since version
 */
function update_lp($user)
{
	crud('UPDATE network_leadership_passive ' .
		'SET income_today = :income_today, ' .
//		'flushout_local = :flushout_local,' .
		'date_last_flushout = :date_last_flushout' .
		' WHERE user_id = :user_id',
		[
			'user_id'            => $user->user_id,
			'income_today'       => 0,
//			'flushout_local'     => ($user->flushout_local + $user->income_today),
			'date_last_flushout' => time()
		]
	);
}

/**
 * @param $account_type
 * @param $income_today
 *
 * @return bool
 *
 * @since version
 */
function flushed($account_type, $income_today): bool
{
	$max_daily_income = settings('leadership_passive')->{$account_type . '_leadership_passive_max_daily_income'};

	return ($income_today >= $max_daily_income);
}