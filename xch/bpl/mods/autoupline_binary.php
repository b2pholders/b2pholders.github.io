<?php

namespace BPL\Mods\AutoUpline_Binary;

require_once 'bpl/mods/binary/validate.php';
require_once 'bpl/mods/binary/downlines.php';

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Binary\Validate\username_upline;
use function BPL\Mods\Binary\Validate\binary_downlines;
use function BPL\Mods\Binary\Validate\user_username_paid;
use function BPL\Mods\Binary\Validate\user_binary_active;
use function BPL\Mods\Binary\Validate\has_position;

use function BPL\Mods\Binary\Downlines\tail_tip;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function get_upline($user_id): string
{
	$upline_id = user($user_id)->sponsor_id;
	$upline    = user($upline_id)->username;

	if (!empty(user_username_paid($upline)) &&
		!empty(user_binary($upline_id)) &&
		!empty(username_upline($upline)))
	{
		if (count(binary_downlines($upline_id)) < 2)
		{
			return $upline;
		}

		return tail_tip($upline_id);
	}

	return tail_tip(1); // admin
}

/**
 * @param $upline
 *
 * @return string
 *
 * @since version
 */
function get_position($upline): string
{
	$user = user_username($upline);

	$username_paid = user_username_paid($upline);

	$has_left = (has_position($user->id, 'Left') ||
		(!empty($username_paid) && !empty(user_binary_active($username_paid->id, 'Left'))));

	return $has_left ? 'Right' : 'Left';
}

/**
 * @param $upline
 *
 * @return string
 *
 * @since version
 */
function option_position($upline): string
{
	$position = get_position($upline);

	return '<option value="Left" ' . position_select($position, 'Left') . '>Left</option>
        <option value="Right" ' . position_select($position, 'Right') . '>Right</option>';
}

/**
 * @param $value
 * @param $position
 *
 * @return string
 *
 * @since version
 */
function position_select($value, $position): string
{
	return $value === $position ? 'selected' : '';
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
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $username
 *
 * @return array|mixed
 *
 * @since version
 */
function user_username($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username)
	)->loadObject();
}
