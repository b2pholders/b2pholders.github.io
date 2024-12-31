<?php
//
//namespace BPL\Cron\Binary_Flushout;
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
//use function BPL\Mods\Local\Helpers\settings;
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
//	$dbh = DB::connect();
//
//	$ctr = 0;
//
//	foreach (binary_users() as $result)
//	{
//		$flushed = flushed(
//			$result->account_type,
//			$result->pairs_today,
//			$result->pairs_today_total,
//			$result->ctr_left,
//			$result->ctr_right);
//
//		if ($flushed)
//		{
//			try
//			{
//				$dbh->beginTransaction();
//
//				update_binary($result->user_id);
//
//				$dbh->commit();
//			}
//			catch (Exception $e)
//			{
//				try
//				{
//					$dbh->rollback();
//				}
//				catch (Exception $e2)
//				{
//				}
//			}
//		}
//
//		$ctr++;
//	}
//
//	echo $ctr;
//}
//
///**
// *
// * @return array|false
// *
// * @since version
// */
//function binary_users()
//{
//	return fetch_all(
//		'SELECT * ' .
//		'FROM network_binary b ' .
//		'INNER JOIN network_users u ' .
//		'ON b.user_id = u.id'
//	);
//}
//
///**
// * @param $id
// *
// *
// * @since version
// */
//function update_binary($id)
//{
//	crud('UPDATE network_binary ' .
//		'SET pairs_today = :pairs_today, ' .
//		'pairs_today_total = :pairs_today_total, ' .
//		'ctr_left = :ctr_left, ' .
//		'ctr_right = :ctr_right ' .
//		'WHERE user_id = :user_id',
//		['user_id'           => $id,
//		 'pairs_today'       => 0,
//		 'pairs_today_total' => 0,
//		 'ctr_left'          => 0,
//		 'ctr_right'         => 0]);
//}
//
///**
// * @param $account_type
// * @param $pairs_today
// * @param $pairs_today_total
// * @param $ctr_left
// * @param $ctr_right
// *
// * @return bool
// *
// * @since version
// */
//function flushed($account_type, $pairs_today, $pairs_today_total, $ctr_left, $ctr_right): bool
//{
//	$max_cycle = settings('binary')->{$account_type . '_max_cycle'};
//
//	return ($pairs_today >= $max_cycle || $pairs_today_total >= $max_cycle ||
//		($ctr_left >= $max_cycle && $ctr_right >= $max_cycle));
//}