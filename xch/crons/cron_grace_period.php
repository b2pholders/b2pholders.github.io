<?php

namespace Cron\Grace_Period;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';

use DateTime;
use DateTimeZone;
use Exception;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

use function Cron\Database\Query\fetch_all;
use function Cron\Database\Query\fetch;
use function Cron\Database\Query\crud;


main();

/**
 *
 *
 * @since version
 */
function main()
{
	$dbh = DB_Cron::connect();

	$users = users();

	if (!empty($users))
	{
		foreach ($users as $user)
		{
			if ((int) $user->date_activated === 0 &&
				(int) $user->block === 0 &&
				(now() - $user->date_registered) > (settings('ancillaries')->grace_period * 86400))
			{
				try
				{
					$dbh->beginTransaction();

					update_user($user->id);

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
 *
 * @return string
 *
 * @since version
 */
function now(): string
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));

	return $time->format('U');
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
function users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users'
	);
}

/**
 * @param $user_id
 *
 * @since version
 */
function update_user($user_id)
{
	crud(
		'UPDATE network_users ' .
		'SET block = :block ' .
		'WHERE id = :id',
		[
			'block' => 1,
			'id'    => $user_id
		]
	);
}