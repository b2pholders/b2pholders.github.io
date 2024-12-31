<?php

namespace BPL\Jumi\Uncommission_Deduct;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Helpers\application;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype = session_get('usertype');

	$user_id = input_get('uid');
	$final   = input_get('final');

	page_validate();

	if ($usertype !== 'Admin')
	{
		die("Access denied: Admins only.");
	}

	if ($user_id === '')
	{
		die();
	}

	$str = '';

	if ($final === '')
	{
		$str .= view_form($user_id);
	}
	else
	{
		process_uncommission($user_id);
	}

	echo $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$user = user($user_id);

	return '<h1>Confirm Uncommission deduct</h1>
	    Username: ' . $user->username . '<br>
	    Full Name: ' . ($user->fullame ?? '') . '<br>
	    <form method="post">
	        <input type="hidden" name="final" value="1">
	        <input type="hidden" name="uid" value="' . $user_id . '">
	        <input type="submit" value="UnCD User" class="uk-button uk-button-primary">
	    </form>';
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function process_uncommission($user_id)
{
	delete(
		'network_commission_deduct',
		['id = ' . db()->quote($user_id)]
	);

	application()->redirect(Uri::root(true) . '/' . sef(40),
		user($user_id)->username . ' has been removed from CD', 'notice');
}