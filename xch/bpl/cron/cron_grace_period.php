<?php

namespace BPL\Cron\Grace_Period;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use DateTime;
use DateTimeZone;
use Exception;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\users;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U');

	$dbh = DB::connect();

	$results = users();

	if (!empty($results))
	{
		foreach ($results as $result)
		{
			if ((int) $result->date_activated === 0 &&
				(int) $result->block === 0 &&
				($now - $result->date_registered) > (settings('ancillaries')->grace_period * 86400))
			{
				try
				{
					$dbh->beginTransaction();

					update_user($result);

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
 * @param $result
 *
 *
 * @since version
 */
function update_user($result)
{
	crud(
		'UPDATE network_users ' .
		'SET block = :block ' .
		'WHERE id = :id',
		[
			'block' => 1,
			'id'    => $result->id
		]
	);
}