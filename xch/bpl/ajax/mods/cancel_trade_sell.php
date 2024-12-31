<?php

namespace BPL\Ajax\Mods\Token\Trade\Cancel\Sell;

use Exception;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\crud;

$trade_id = filter_input(INPUT_POST, 'trade_id', FILTER_VALIDATE_INT);
$user_id  = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($trade_id, $user_id);

/**
 * @param $trade_id
 * @param $user_id
 *
 *
 * @since version
 */
function main($trade_id, $user_id)
{
	$dbh = DB::connect();

	try
	{
		$dbh->beginTransaction();

		crud(
			'DELETE ' .
			'FROM network_fmc_trade ' .
			'WHERE id = :id ' .
			'AND user_id = :user_id ' .
			'AND order_type = :order_type',
			[
				'id'         => $trade_id,
				'user_id'    => $user_id,
				'order_type' => 'sell'
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