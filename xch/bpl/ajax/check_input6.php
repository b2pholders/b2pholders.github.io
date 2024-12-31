<?php

namespace BPL\Ajax\Mods\Check_Input6;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;

$user_id = substr($_GET['user_id'], 0, 40);
$uid     = substr($_GET['uid'], 0, 40);

main($user_id, $uid);

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function main($user_id, $uid)
{
	if ($uid === '')
	{
		echo '<span style="color:#FF0000">Blank input not allowed.</span>';

		die();
	}

	if ($uid === user_user_id($user_id)->username)
	{
		echo '<span style="color:#FF0000">Invalid Username.</span>';

		die();
	}

	echo(user_username($uid) ? 'Valid Username!' :
		'<span style="color:#FF0000">Invalid Username!</span>');
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_user_id($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :user_id',
		['user_id' => $user_id]
	);
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
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = :username',
		['username' => $username]
	);
}