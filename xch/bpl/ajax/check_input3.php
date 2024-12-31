<?php

namespace BPL\Ajax\Mods\Check_Input3;

require_once '../lib/Db_Connect.php';
require_once '../mods/url_sef_local.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Url_SEF\qs;
use function BPL\Mods\Local\Url_SEF\sef;

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

	$result = user_username($uid);

	echo $result ? ('<a style="margin-top:-7px;" href="' . sef(60) . qs() . 'uid=' .
		$result->id . '" class="uk-button uk-button-primary">Update Account</a>') :
		'<span style="color:#FF0000">Invalid Username!</span>';
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