<?php

namespace BPL\Cron\Top_Up_Processing;

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
	$results = top_ups();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
			update_top_up_processing($result);
		}
	}
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function top_ups()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_top_up'
	);
}

/**
 * @param $result
 *
 *
 * @since version
 */
function update_top_up_processing($result)
{
	$dbh = DB::connect();

	$processing = $result->processing;

	if ($processing > 0)
	{
		try
		{
			$dbh->beginTransaction();

			crud(
				'UPDATE network_top_up ' .
				'SET processing = :processing ' .
				'WHERE id = :id',
				[
					'processing' => (($processing - 1) >= 0 ? $processing - 1 : 0),
					'id'         => $result->id
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