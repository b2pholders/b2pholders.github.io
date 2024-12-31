<?php

namespace Cron\Unilevel_Maintain;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';

use Exception;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

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
	$dbh = DB_Cron::connect();

	$unilevels = unilevels();

	if (!empty($unilevels))
	{
		foreach ($unilevels as $unilevel)
		{
			try
			{
				$dbh->beginTransaction();

				update_unilevel_period($unilevel->user_id);

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

/**
 *
 * @return array|false
 *
 * @since version
 */
function unilevels()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_unilevel'
	);
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function update_unilevel_period($user_id)
{
	crud(
		'UPDATE network_unilevel ' .
		'SET period_unilevel = 0 ' .
		'WHERE user_id = :id',
		['id' => $user_id]
	);
}