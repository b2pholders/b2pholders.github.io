<?php

namespace BPL\Jumi\Direct_Referrals;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;
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

	$str = menu();
	$str .= page_reload();
	$str .= view_table($user_id);

	echo $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_table($user_id): string
{
	$directs = user_directs($user_id);

	$str = '<h1>Sponsored Accounts</h1>';

	if (!empty($directs)) {
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Accounts</th>
            <th>Package</th>
            <th>Title</th>
        </tr>
        </thead>
        <tbody>';

		$ctr = 0;

		foreach ($directs as $member) {
			$ctr++;

			$str .= '<tr>
                <td>' . $ctr . '</td>
                <td>
                    <a href="' . sef(44) . qs() . 'uid=' . $member->id . '">' . $member->username . '</a>
                </td>
                <td>' . settings('entry')->{$member->account_type . '_package_name'} . '</td>
                <td>' . settings('royalty')->{$member->rank . '_rank_name'} . '</td>
            </tr>';
		}

		$str .= '</tbody>
    </table>';
	} else {
		$str .= '<hr><p>No sponsored members yet.</p>';
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_directs($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE sponsor_id = ' . $db->quote($user_id)
	)->loadObjectList();
}