<?php

namespace Cron\Fixed_Daily_Deposit_Reset;

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
		'SET fixed_daily_deposit_today = 0'
	);
}