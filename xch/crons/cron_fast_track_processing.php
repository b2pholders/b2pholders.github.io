<?php

namespace Cron\Fast_Track\Processing;

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
	$results = fast_tracks();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
//			print_r($fast_track) . "\n";
			update_fast_track_processing($result);
		}
	}
}

/**
 * @param $fast_track
 *
 *
 * @since version
 */
function update_fast_track_processing($fast_track)
{
	$dbh = DB_Cron::connect();

    $processing = $fast_track->processing;

	if ($processing > 0)
	{
		try
		{
			$dbh->beginTransaction();

			crud(
				'UPDATE network_fast_track ' .
				'SET processing = :processing ' .
				'WHERE fast_track_id = :fast_track_id',
				[
					'processing'    => (($processing - 1) >= 0 ? $processing - 1 : 0),
					'fast_track_id' => $fast_track->fast_track_id
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

/**
 *
 * @return array|false
 *
 * @since version
 */
function fast_tracks()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fast_track'
	);
}
