<?php

namespace BPL\Jumi\Commission_Deduct;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = input_get('uid');

	page_validate();

	if (session_get('usertype') !== 'Admin')
	{
		die('Access denied: Admins only.');
	}

	if ($user_id === '')
	{
		die();
	}

	$str = '';

	if (input_get('final') === '')
	{
		$str .= view_form($user_id);
	}
	else
	{
		process_form($user_id);
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

	return '<h1>Confirm Commission Deduct</h1>
	    Username: ' . $user->username . '<br>
	    Full Name: ' . $user->fullname . '<br>
	    <form method="post">
	        <input type="hidden" name="final" value="1">
	        <input type="hidden" name="uid" value="' . $user->id . '">
	        <input type="submit" value="Commission Deduct" class="uk-button uk-button-primary">
	    </form>';
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function process_form($user_id)
{
	insert_cd($user_id);

	update_users($user_id);

	application()->redirect(Uri::root(true) . '/' . sef(40), user($user_id)->username .
		' has been added to commission deduction', 'notice');
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function insert_cd($user_id)
{
	$db = db();

	$user = user($user_id);

	insert(
		'network_commission_deduct',
		[
			'id',
			'balance'
		],
		[
			$db->quote($user->id),
			$db->quote(settings('entry')->{$user->account_type . '_entry'})
		]
	);
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function update_users($user_id)
{
	$field_user = [];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = 0';
	}
	else
	{
		$field_user[] = 'payout_transfer = 0';
	}

	update(
		'network_users',
		$field_user,
		['id = ' . db()->quote(user($user_id)->id)]
	);
}