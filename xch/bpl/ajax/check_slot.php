<?php

namespace BPL\Ajax\Mods\Check_Slot;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;

$uid  = substr($_GET['uid'], 0, 40);
$code = substr($_GET['code'], 0, 10);

main($uid, $code);

/**
 * @param $uid
 * @param $code
 *
 *
 * @since version
 */
function main($uid, $code)
{
	if ($uid === '')
	{
		echo '<span style="color:#FF0000">Please specify upline.</span>';
		die();
	}

	$result = user_username($uid);

	if (!empty($result))
	{
		echo user_binary($result->id, $code) ?
			'<span style="color:#FF0000">Position not available.</span>' : 'Position available.';
	}
	else
	{
		echo '<span style="color:#FF0000">Invalid upline.</span>';
	}
}

/**
 * @param $username
 *
 * @return mixed
 *
 * @since version
 */
function user_username($username)
{
	return fetch(
		'SELECT id ' .
		'FROM network_users ' .
		'WHERE username = :username',
		['username' => $username]
	);
}

/**
 * @param $upline_id
 * @param $position
 *
 * @return mixed
 *
 * @since version
 */
function user_binary($upline_id, $position)
{
	return fetch(
		'SELECT u.id ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.id ' .
		'WHERE b.upline_id = :upline_id ' .
		'AND b.position = :position',
		[
			'upline_id' => $upline_id,
			'position'  => $position
		]
	);
}