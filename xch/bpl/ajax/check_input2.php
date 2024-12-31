<?php

namespace BPL\Ajax\Mods\Check_Input2;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;

$uid = substr($_GET['uid'], 0, 40);

main($uid);

/**
 * @param $uid
 *
 *
 * @since version
 */
function main($uid)
{
	if ($uid === '')
	{
		echo '<span style="color:#FF0000">Blank input not allowed.</span>';
		die();
	}

	echo(user_username($uid) ? 'Valid Username!' :
		'<span style="color:#FF0000">Invalid Username!</span>');
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