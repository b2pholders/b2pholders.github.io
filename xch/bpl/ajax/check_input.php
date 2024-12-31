<?php

namespace BPL\Ajax\Mods\Check_Input;

require_once '../lib/Db_Connect.php';
require_once '../mods/helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\fetch_all;

$uid  = substr($_GET['uid'] ?: '', 0, 40);
$type = substr($_GET['type'] ?: '', 0, 10);

main($uid, $type);

/**
 * @param $uid
 * @param $type
 *
 *
 * @since version
 */
function main($uid, $type)
{
	if ($uid === '')
	{
		echo '<span style="color:#FF0000">Blank input not allowed.</span>';

		die();
	}

	switch ($type)
	{
		case 'username':
			echo(!empty(user_username_valid($uid)) ?
				'<span style="color:#FF0000">Invalid Username!</span>' : 'Valid Username!');

			break;
		case 'code':
			echo(!empty(user_codes($uid)) ? 'Valid code!' :
				'<span style="color:#FF0000">Invalid code!</span>');

			break;
		case 'sponsor':
			echo(!empty(user_username_active($uid)) ? 'Valid Sponsor!' :
				'<span style="color:#FF0000">Invalid Sponsor!</span>');

			break;
		case 'upline':
			$result = user_username_active($uid);

			if (!$result)
			{
				echo '<span style="color:#FF0000">Invalid Upline!</span>';
			}
			else
			{
				$upline_id = $result->id;

				$user_binary      = user_binary($upline_id);
				$binary_downlines = binary_downlines($upline_id);

				if (!empty($result) && !empty($user_binary) && count($binary_downlines) < 2)
				{
					echo '<span style="color:green">Valid Upline!</span>';
				}
				else
				{
					echo '<span style="color:#FF0000">Invalid Upline!</span>';
				}
			}

			break;
	}
}

/**
 * @param $username
 *
 * @return mixed
 *
 * @since version
 */
function user_username_valid($username)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = :username ' .
		'AND block = :block',
		[
			'username' => $username,
			'block'    => 0
		]
	);
}

/**
 * @param $code
 *
 * @return mixed
 *
 * @since version
 */
function user_codes($code)
{
	return fetch(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE code = :code ' .
		'AND user_id = :user_id',
		[
			'code'    => $code,
			'user_id' => 0
		]
	);
}

/**
 * @param $username
 *
 * @return mixed
 *
 * @since version
 */
function user_username_active($username)
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
 *
 * @return array|false
 *
 * @since version
 */
function binary_downlines($upline_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE b.upline_id = :upline_id ' .
		'AND u.block = :block',
		[
			'upline_id' => $upline_id,
			'block'     => 0
		]
	);
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_binary($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}