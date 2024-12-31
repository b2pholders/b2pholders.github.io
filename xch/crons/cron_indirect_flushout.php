<?php

namespace Cron\Indirect_Flushout;

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

	$users = indirect_users();

	if (!empty($users))
	{
		foreach ($users as $user)
		{
//            $diff = time() - $user->date_last_flushout;

			if (flushed($user)/* && ($diff >= $interval)*/)
			{
				try
				{
					$dbh->beginTransaction();

					update_indirect($user);

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
function indirect_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_indirect i ' .
		'INNER JOIN network_users u ' .
		'ON i.user_id = u.id'
	);
}

/**
 * @param $user
 *
 * @since version
 */
function update_indirect($user)
{
	crud('UPDATE network_indirect ' .
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
 * @param $user
 *
 * @return bool
 *
 * @since version
 */
function flushed($user): bool
{
	$max_daily_income = settings('indirect_referral')->{$user->account_type . '_indirect_referral_max_daily_income'};

	return $user->income_today >= $max_daily_income;
}