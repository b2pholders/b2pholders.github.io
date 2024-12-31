<?php

namespace BPL\Ajax\Mods\Check_Position;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;

$uid      = substr($_GET['uid'], 0, 40);
$position = substr($_GET['position'], 0, 5);

main($uid, $position);

/**
 * @param $username
 *
 * @return mixed
 *
 * @since version
 */
function user_username_paid($username)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = :username ' .
		'AND account_type <> :account_type',
		[
			'username'     => $username,
			'account_type' => 'starter'
		]
	);
}

/**
 * @param $upline_id
 * @param $position
 *
 *
 * @return mixed
 * @since version
 */
function user_binary_active($upline_id, $position)
{
	return fetch(
		'SELECT u.id ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE b.upline_id = :upline_id ' .
		'AND b.position = :position ' .
		'AND u.block = :block',
		[
			'upline_id' => $upline_id,
			'position'  => $position,
			'block'     => 0
		]
	);
}

/**
 * @param $uid
 * @param $position
 *
 *
 * @since version
 */
function main($uid, $position)
{
	if ($uid === '')
	{
		echo '<span style="color:#FF0000">Please specify position</span>';

		die();
	}

	$username_paid = user_username_paid($uid);

	if (!empty($username_paid))
	{
		echo (!empty(user_binary_active($username_paid->id, $position)) ?
			'<span style="color:red">Invalid Position!</span>' :
			'<span style="color:green">Position Available!</span>');
	}
	else
	{
		echo '<span style="color:#FF0000">Invalid upline!</span>';
	}
}