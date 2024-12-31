<?php
//
//namespace BPL\Cron\Fixed_Daily_Processing;
//
//require_once '../lib/Db_Connect.php';
//require_once '../mods/helpers_local.php';
//
//use Exception;
//
//use BPL\Lib\Local\Database\Db_Connect as DB;
//
//use function BPL\Mods\Local\Database\Query\fetch_all;
//use function BPL\Mods\Local\Database\Query\crud;
//
//main();
//
///**
// *
// *
// * @since version
// */
//function main()
//{
//	$results = fixed_daily();
//
//	if (!empty($results))
//	{
//		foreach ($results as $result)
//		{
//			update_fixed_daily_processing($result);
//		}
//	}
//}
//
///**
// *
// * @return array|false
// *
// * @since version
// */
//function fixed_daily()
//{
//	return fetch_all(
//		'SELECT * ' .
//		'FROM network_fixed_daily'
//	);
//}
//
///**
// * @param $result
// *
// *
// * @since version
// */
//function update_fixed_daily_processing($result)
//{
//	$dbh = DB::connect();
//
//	$processing = $result->processing;
//
//	if ($processing > 0)
//	{
//		try
//		{
//			$dbh->beginTransaction();
//
//			crud(
//				'UPDATE network_fixed_daily ' .
//				'SET processing = :processing ' .
//				'WHERE id = :id',
//				[
//					'processing' => (($processing - 1) >= 0 ? $processing - 1 : 0),
//					'id'         => $result->id
//				]
//			);
//
//			$dbh->commit();
//		}
//		catch (Exception $e)
//		{
//			try
//			{
//				$dbh->rollback();
//			}
//			catch (Exception $e2)
//			{
//			}
//		}
//	}
//}