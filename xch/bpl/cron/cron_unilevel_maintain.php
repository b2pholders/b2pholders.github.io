<?php

namespace BPL\Cron\Unilevel_Maintain;

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

	$results = unilevels();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
			try
			{
				$dbh->beginTransaction();

				update_unilevel_period($result);

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
 * @param $result
 *
 *
 * @since version
 */
function update_unilevel_period($result)
{
	crud(
		'UPDATE network_unilevel ' .
		'SET period_unilevel = 0 ' .
		'WHERE user_id = :id',
		['id' => $result->user_id]
	);
}