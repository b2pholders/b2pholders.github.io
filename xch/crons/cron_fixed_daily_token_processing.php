<?php

namespace Cron\Fixed_Dail_Token\Processing;

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
	$results = fixed_daily_token();

	if (!empty($results)) {
		foreach ($results as $result) {
			update_fixed_daily_token_processing($result);
		}
	}
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function fixed_daily_token()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fixed_daily_token'
	);
}

/**
 * @param $fixed_daily_token
 *
 *
 * @since version
 */
function update_fixed_daily_token_processing($fixed_daily_token)
{
	$dbh = DB_Cron::connect();

	$processing = $fixed_daily_token->processing;

	if ($processing > 0) {
		try {
			$dbh->beginTransaction();

			crud(
				'UPDATE network_fixed_daily_token ' .
				'SET processing = :processing ' .
				'WHERE fixed_daily_token_id = :fixed_daily_token_id',
				[
					'processing' => (($processing - 1) >= 0 ? $processing - 1 : 0),
					'fixed_daily_token_id' => $fixed_daily_token->fixed_daily_token_id
				]
			);

			$dbh->commit();
		} catch (Exception $e) {
			try {
				$dbh->rollback();
			} catch (Exception $e2) {
			}
		}
	}
}