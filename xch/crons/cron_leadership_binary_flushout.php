<?php

namespace Cron\Leadership_Binary_Flushout;

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

	$users = lb_users();

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

					update_leadership($user->user_id);

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
function lb_users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_leadership l ' .
		'INNER JOIN network_users u ' .
		'ON l.user_id = u.id'
	);
}

/**
 * @param $id
 *
 *
 * @since version
 */
function update_leadership($id)
{
	crud('UPDATE network_leadership ' .
		'SET income_today = :income_today, ' .
		'date_last_flushout = :date_last_flushout' .
		' WHERE user_id = :user_id',
		[
			'user_id'            => $id,
			'income_today'        => 0,
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
	$max_daily_income = settings('leadership')->{$account_type . '_max_daily_income'};

	return ($income_today >= $max_daily_income);
}