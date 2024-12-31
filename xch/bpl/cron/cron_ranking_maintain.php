<?php

namespace BPL\Cron\Ranking_Maintain;

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
	$dbh = DB::connect();

	$results = ranking_maintain();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
			try
			{
				$dbh->beginTransaction();

				update_ranking_maintain($result);

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
function ranking_maintain()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_ranking_maintain'
	);
}

/**
 * @param $result
 *
 *
 * @since version
 */
function update_ranking_maintain($result)
{
	crud(
		'UPDATE network_ranking_maintain ' .
		'SET period_ranking_maintain = 0 ' .
		'WHERE user_id = :id',
		['id' => $result->user_id]
	);
}