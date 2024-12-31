<?php

namespace BPL\Mods\Block_Unblock;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\application;

/**
 *
 *
 * @since version
 */
function main($type = 'block')
{
	$user_id = input_get('uid');

	page_validate();

	if (session_get('usertype') !== 'Admin')
	{
		die("Access denied: Admins only.");
	}

	if ($user_id === '')
	{
		die();
	}

	$str = '';

	if (input_get('final') === '')
	{
		$str .= view_form($user_id, $type);
	}
	else
	{
		process_form($user_id, $type);
	}

	echo $str;
}

/**
 * @param $user_id
 * @param $type
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id, $type): string
{
	$user = user($user_id);

	return '<h1>Confirm ' . ucfirst($type) . '</h1>
	    Username: ' . $user->username . '<br>
	    Full Name: ' . $user->fullname . '<br>
	    <form method="post">
	        <input type="hidden" name="final" value="1">
	        <input type="hidden" name="uid" value="' . $user_id . '">
	        <input type="submit" value="' . ucfirst($type) .
		' User" class="uk-button uk-button-primary">
	    </form>';
}

/**
 * @param           $user_id
 *
 * @param   string  $type
 *
 * @since version
 */
function process_form($user_id, string $type = 'block')
{
	update_users($user_id, $type);

	application()->redirect(Uri::root(true) . '/' . sef(40),
		user($user_id)->username . ' has been ' . $type . 'ed', 'notice');
}

/**
 * @param $user_id
 * @param $type
 *
 *
 * @since version
 */
function update_users($user_id, $type)
{
	$db = db();

	update(
		'network_users',
		['block = ' . $db->quote($type === 'unblock' ? 0 : 1)],
		['id = ' . $db->quote($user_id)]
	);
}