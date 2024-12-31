<?php

namespace BPL\Mods\Binary\Downlines;

require_once 'bpl/mods/helpers.php';

use Exception;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;

/**
 * @param          $user_id
 *
 * @since version
 */
function main($user_id)
{
	$user_binary = user_binary($user_id);

	if ($user_binary)
	{
		// show main
		show_list($user_binary);

		// left
		if ((int) $user_binary->downline_left_id !== 0)
		{
			main($user_binary->downline_left_id);
		}

		// right
		if ((int) $user_binary->downline_right_id !== 0)
		{
			main($user_binary->downline_right_id);
		}
	}
}

/**
 * @param          $user_id
 * @param   array  $grp
 *
 *
 * @since version
 */
function populate($user_id, array &$grp = [])
{
	$user_binary = user_binary($user_id);

	if ($user_binary)
	{
		try
		{
			$grp[$user_binary->user_id] = $user_binary->username;

			if ((int) $user_binary->downline_left_id !== 0)
			{
				populate($user_binary->downline_left_id, $grp);
			}

			if ((int) $user_binary->downline_right_id !== 0)
			{
				populate($user_binary->downline_right_id, $grp);
			}
		}
		catch(Exception $e)
		{

		}
	}
}

/**
 * @param           $user_id
 * @param   string  $default
 *
 * @return string
 *
 * @since version
 */
function tail_tip($user_id, string $default = 'admin'): string
{
	$a = [];
	$b = [];

	$user_binary = user_binary($user_id);

	populate($user_binary->downline_left_id, $a);
	populate($user_binary->downline_right_id, $b);

	if (!empty($a) && !empty($b))
	{
		return array_values(target(count($a) >= count($b) ? $b : $a))[0];
	}

	return $default;
}

/**
 * @param   array  $c
 *
 * @return array
 *
 * @since version
 */
function target(array $c): array
{
	$c1 = [];

	$result = [];

	spot($c, $c1, $result);

	return $result;
}

/**
 * @param   array  $a
 * @param   array  $a1
 * @param   array  $result
 *
 * @return array
 *
 * @since version
 */
function spot(array $a, array $a1, array &$result): array
{
	if (!empty($a))
	{
		foreach ($a as $k => $v)
		{
			$a1[] = $k;
		}

		arsort($a1);

		$a2 = array_values($a1);

		$result[$a2[0]] = $a[$a2[0]];
	}

	return $result;
}

/**
 * @param $user_binary
 *
 *
 * @since version
 */
function show_list($user_binary)
{
	echo '<li><a href="' . sef(44) . qs() . 'uid=' .
		$user_binary->user_id . '">' . $user_binary->username . '</a></li>';
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
		'WHERE u.id = ' . $db->quote($user_id) .
		' AND u.account_type <> ' . $db->quote('starter')
	)->loadObject();
}