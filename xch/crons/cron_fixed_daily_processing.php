<?php

namespace Cron\Fixed_Dail\Processing;

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
	$results = fixed_daily();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
			update_fixed_daily_processing($result);
		}
	}
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function fixed_daily()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fixed_daily'
	);
}

/**
 * @param $fixed_daily
 *
 *
 * @since version
 */
function update_fixed_daily_processing($fixed_daily)
{
	$dbh = DB_Cron::connect();

	$processing = $fixed_daily->processing;

	if ($processing > 0)
	{
		try
		{
			$dbh->beginTransaction();

			crud(
				'UPDATE network_fixed_daily ' .
				'SET processing = :processing ' .
				'WHERE fixed_daily_id = :fixed_daily_id',
				[
					'processing'     => (($processing - 1) >= 0 ? $processing - 1 : 0),
					'fixed_daily_id' => $fixed_daily->fixed_daily_id
				]
			);

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