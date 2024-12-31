<?php

namespace BPL\Cron\Fast_Track_Processing;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use Exception;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$fast_tracks = fast_tracks();

	if (!empty($fast_tracks))
	{
		foreach ($fast_tracks as $fast_track)
		{
			update_fast_track_processing($fast_track);
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
	$dbh = DB::connect();

	$processing = $fast_track->processing;

	if ($processing > 0)
	{
		try
		{
			$dbh->beginTransaction();

			crud(
				'UPDATE network_fast_track ' .
				'SET processing = :processing ' .
				'WHERE id = :id',
				[
					'processing' => (($processing - 1) >= 0 ? $processing - 1 : 0),
					'id'         => $fast_track->id
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
