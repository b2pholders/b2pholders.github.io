<?php

namespace BPL\Jumi\Downlines;

require_once 'bpl/mods/binary/downlines.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Binary\Downlines\main as downlines;
//use function BPL\Mods\Binary\Downlines\tail_tip;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	page_validate();

	$uid = input_get('uid');

	$user_id = $uid !== '' ? $uid : session_get('user_id');

	echo menu();

//	$user = user($user_id);

//	$binary_sponsored = settings('binary')->{$user->account_type . '_binary_sponsored'};

//	if (!($user->account_type !== 'starter' &&
//		count(directs_paid($user_id)) >= $binary_sponsored))
//	{
//		echo '<h4 style="alignment: center">Sponsor At Least ' . $binary_sponsored .
//			' Paid Accounts To Enable Your ' . settings('plans')->binary_pair_name . ' Booster.</h4>';
//	}

	echo page_reload();

	view_table($user_id);

//	echo '<pre>target a:';
//	echo print_r(tail_tip(1), true); // test2 username
//	echo '</pre>';
}

/**
 * @param $user_id
 *
 * @since version
 */
function view_table($user_id)
{
	$user_binary = user_binary($user_id);

	echo '<h1>' . settings('plans')->binary_pair_name . ' Summary</h1>';
    echo '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th style="text-align: center">A</th>
            <th style="text-align: center">B</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <ol class="uk-list uk-list-line" style="text-align: center">';
	downlines($user_binary->downline_left_id);
	echo '</ol>
            </td>
            <td>
                <ol class="uk-list uk-list-line" style="text-align: center">';
	downlines($user_binary->downline_right_id);
	echo '</ol>
            </td>
        </tr>
        </tbody>
    </table>';
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
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary ' .
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function directs_paid($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($user_id)
	)->loadObjectList();
}