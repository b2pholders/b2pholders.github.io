<?php

namespace Onewayhi\Sands\Binary\Positioning;

use \PDO;

$insert_id      = 7;
$sponsor_id     = 1;
$position_entry = 'Left';

test($insert_id, $sponsor_id, $position_entry);

/**
 * @param $insert_id
 * @param $sponsor_id
 * @param $position_entry
 *
 *
 * @since version
 */
function test($insert_id, $sponsor_id, $position_entry)
{
	echo '<!DOCTYPE html>
<html lang="en">
<head><title>Binary Position Prototype</title>
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
	echo print_r(main($insert_id, $sponsor_id, $position_entry), true);
	echo '</pre></body></html>';
}

/**
 * @param $insert_id
 * @param $sponsor_id
 * @param $position_entry
 *
 * @return mixed
 *
 * @since version
 */
function main($insert_id, $sponsor_id, $position_entry)
{
	if (
		(!get_binary('downline_left_id', $sponsor_id) && $position_entry === 'Left')
		||
		(!get_binary('downline_right_id', $sponsor_id) && $position_entry === 'Right')
	)
	{
		return test_encode($sponsor_id, $insert_id, $position_entry);
	}

	return test_encode(upline_available($position_entry, $sponsor_id), $insert_id, $position_entry);
}

/**
 * @param $upline_id
 * @param $insert_id
 * @param $position_entry
 *
 * @return mixed
 *
 * @since version
 */
function test_encode($upline_id, $insert_id, $position_entry)
{
	$downline_position = 'downline_' . ($position_entry === 'Left' ? 'left' : 'right') . '_id';

	$result['binary_update']['user_id']          = $upline_id;
	$result['binary_update'][$downline_position] = $insert_id;

	$result['binary_insert']['user_id']   = $insert_id;
	$result['binary_insert']['upline_id'] = $upline_id;
	$result['binary_insert']['position']  = $position_entry;

	return $result;
}

/**
 * @param $position
 * @param $sponsor_id
 *
 * @return mixed
 *
 * @since version
 */
function upline_available($position, $sponsor_id)
{
	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare(
		'SELECT u.`id` ' .
		'FROM `users` u ' .
		'INNER JOIN `binary` b ' .
		'ON u.`id` = b.`user_id` ' .
		'WHERE b.`upline_id` = :sponsor_id ' .
		'AND b.`downline_' . (strtolower($position)) . '_id` = 0 ' .
		'ORDER BY b.`user_id` DESC'
	);
	$st->execute(['sponsor_id' => $sponsor_id]);

	return $st->fetch(PDO::FETCH_COLUMN);
}

/**
 * @param $column
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function get_binary($column, $user_id)
{
	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare(
		'SELECT ' . $column .
		' FROM `binary` ' .
		'WHERE `user_id` = :user_id'
	);
	$st->execute(['user_id' => $user_id]);

	return $st->fetch(PDO::FETCH_COLUMN);
}