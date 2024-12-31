<?php

namespace Cron\Fast_Track_Deposit_Reset;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';

use function Cron\Database\Query\crud;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	crud(
		'UPDATE network_users ' .
		'SET fast_track_deposit_today = 0'
	);
}