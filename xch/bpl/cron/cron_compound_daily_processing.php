<?php

namespace BPL\Cron\Compound_Daily_Processing;

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
	$users = compound_get();

	if (!empty($users))
	{
		foreach ($users as $user)
		{
			update_compound_daily_processing($user);
		}
	}
}

/**
 * @param $user
 *
 *
 * @since version
 */
function update_compound_daily_processing($user)
{
	$dbh = DB::connect();

	$processing = $user->processing;

	if ($user->processing > 0)
	{
		try
		{
			$dbh->beginTransaction();

			crud(
				'UPDATE network_compound ' .
				'SET processing = :processing ' .
				'WHERE id = :id',
				[
					'processing' => (($processing - 1) >= 0 ? $processing - 1 : 0),
					'id'         => $user->id
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
function compound_get()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_compound'
	);
}