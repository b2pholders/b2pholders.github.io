<?php

namespace Onewayhi\Sands\Binary\Pairing;

use \PDO;
use \Exception;

$ctr_add   = 25;
$upline_id = 3;
$position  = 'Left';

test($ctr_add, $upline_id, $position);

/**
 * @param $ctr_add
 * @param $upline_id
 * @param $position
 *
 *
 * @since version
 */
function test($ctr_add, $upline_id, $position)
{
	echo '<!DOCTYPE html>
<html lang="en">
<head><title>Binary Pairing Prototype</title>
<style>
body {
	background-color: black;
}
pre {
	color: green;
}
</style>
</head>';
	echo '<body><pre>';

	main($ctr_add, $upline_id, $position);

	echo '</pre></body></html>';
}

///**
// * @param $ctr_add
// * @param $upline_id
// * @param $position
// *
// *
// * @since version
// */
//function main($ctr_add, $upline_id, $position)
//{
//	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
//	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//	if ($upline_id)
//	{
//		try
//		{
//			$db->beginTransaction();
//
//			$tmp_upline_id = $upline_id;
//
//			$st = $db->prepare(
//				'SELECT * ' .
//				'FROM `binary` ' .
//				'WHERE `user_id` = :upline_id'
//			);
//			$st->execute(['upline_id' => $tmp_upline_id]);
//
//			$upline = $st->fetch(PDO::FETCH_OBJ);
//
//			$tmp_ctr_left  = $upline->ctr_left;
//			$tmp_ctr_right = $upline->ctr_right;
//
//			while ($tmp_upline_id)
//			{
//				if (
//					(($position === 'Left') && ($tmp_ctr_right > $tmp_ctr_left))
//					||
//					(($position === 'Right') && ($tmp_ctr_left > $tmp_ctr_right))
//				)
//				{
//					$differential = abs($tmp_ctr_left - $tmp_ctr_right);
//					$pairing      = $ctr_add < $differential ? $ctr_add : $differential;
//
//					$st = $db->prepare(
//						'UPDATE `binary` ' .
//						'SET `pairs` = `pairs` + ' . $pairing . ', ' .
//						($position === 'Left' ? '`ctr_left` = `ctr_left`' :
//							'`ctr_right` = `ctr_right`') . ' + ' . $ctr_add .
//						' WHERE `user_id` = :user_id'
//					);
//
//					$binary_update = $st->execute(['user_id' => $tmp_upline_id]);
//
//					$binary_insert = false;
//
//					if ($binary_update)
//					{
//						$st = $db->prepare(
//							'INSERT ' .
//							'INTO `binary_entry` (' .
//							'`user_id`, ' .
//							'`amount`, ' .
//							'`date`' .
//							') VALUES (' .
//							':user_id, ' .
//							':amount, ' .
//							':date' .
//							')'
//						);
//
//						$binary_insert = $st->execute(
//							[
//								'user_id' => $tmp_upline_id,
//								'amount'  => $pairing,
//								'date'    => time()
//							]
//						);
//					}
//
//					if ($binary_insert)
//					{
//						points_update($pairing, $tmp_upline_id);
//					}
//				}
//				else // no pairing
//				{
//					$st = $db->prepare(
//						'UPDATE `binary` ' .
//						'SET ' . ($position === 'Left' ? '`ctr_left` = `ctr_left`' :
//							'`ctr_right` = `ctr_right`') . ' + ' . $ctr_add .
//						' WHERE `user_id` = :user_id'
//					);
//
//					$st->execute(['user_id' => $tmp_upline_id]);
//				}
//
//				$tmp_upline_id = $upline->upline_id;
//
//				if (!$tmp_upline_id)
//				{
//					break;
//				}
//
//				$st = $db->prepare(
//					'SELECT * ' .
//					'FROM `binary` ' .
//					'WHERE `user_id` = :upline_id'
//				);
//				$st->execute(['upline_id' => $tmp_upline_id]);
//
//				$upline = $st->fetch(PDO::FETCH_OBJ);
//
//				$tmp_ctr_left  = $upline->ctr_left;
//				$tmp_ctr_right = $upline->ctr_right;
//			}
//
//			$db->commit();
//		}
//		catch (Exception $e)
//		{
//			try
//			{
//				$db->rollback();
//			}
//			catch (Exception $e2)
//			{
//				trigger_error($e2->getMessage());
//			}
//
//			trigger_error($e->getMessage());
//		}
//	}
//}
//
///**
// * @param $pairing
// * @param $user_id
// *
// *
// * @since version
// */
//function points_update($pairing, $user_id)
//{
//	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
//	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//	$st = $db->prepare(
//		'UPDATE `points` ' .
//		'SET `points` = `points` + ' . $pairing .
//		' WHERE `user_id` = :user_id'
//	);
//
//	$st->execute(['user_id' => $user_id]);
//
//	// get latest points
//	$st = $db->prepare(
//		'SELECT * ' .
//		'FROM `points` ' .
//		'WHERE `user_id` = :user_id'
//	);
//	$st->execute(['user_id' => $user_id]);
//
//	$points = $st->fetch(PDO::FETCH_OBJ);
//
//	$points_latest  = $points->points;
//	$points_spent   = $points->points_spent;
//	$points_waiting = $points->points_waiting;
//
//	$ceiling = 100; // based on fast track binary pairing requirements
//
//	if ($points_latest >= $ceiling)
//	{
//		if ($points_spent)
//		{
//			if ($points_latest > $points_spent)
//			{
//				$differential = $points_latest - $points_spent;
//
//				if (($differential + $points_waiting) >= $ceiling)
//				{
//					fast_track_points(($differential + $points_waiting - $ceiling), $user_id);
//				}
//			}
//		}
//		else
//		{
//			fast_track_points(($points_latest - $ceiling), $user_id);
//		}
//	}
//}
//
///**
// * @param $points_waiting_new
// * @param $user_id
// *
// *
// * @since version
// */
//function fast_track_points($points_waiting_new, $user_id)
//{
//	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
//	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//	if ($points_waiting_new)
//	{
//		$st = $db->prepare(
//			'UPDATE `points` ' .
//			'SET `points_waiting` = ' . $points_waiting_new .
//			' WHERE `user_id` = :user_id'
//		);
//
//		$st->execute(['user_id' => $user_id]);
//	}
//
//	$ceiling = 100; // based on fast track binary pairing requirements
//
//	$st = $db->prepare(
//		'UPDATE `points` ' .
//		'SET `points_spent` = `points_spent` + ' . $ceiling .
//		' WHERE `user_id` = :user_id'
//	);
//
//	$points_spent_update = $st->execute(['user_id' => $user_id]);
//
//	// add fast track if successful
//	if ($points_spent_update)
//	{
//		$st = $db->prepare(
//			'INSERT ' .
//			'INTO `fast_track` (' .
//			'`user_id`, ' .
//			'`time_last`, ' .
//			'`value_last`, ' .
//			'`day`, ' .
//			'`principal`, ' .
//			'`date_entry`, ' .
//			'`processing`, ' .
//			'`maturity`' .
//			') VALUES (' .
//			':user_id, ' .
//			':time_last, ' .
//			':value_last, ' .
//			':day, ' .
//			':principal, ' .
//			':date_entry, ' .
//			':processing, ' .
//			':maturity' .
//			')'
//		);
//
//		$st->execute(
//			[
//				'user_id'    => $user_id,
//				'time_last'  => 0,
//				'value_last' => 0,
//				'day'        => 0,
//				'principal'  => 1000, // based on binary settings
//				'date_entry' => time(),
//				'processing' => 0, // based on fast track settings
//				'maturity'   => 30 // based on fast track settings
//			]
//		);
//	}
//}