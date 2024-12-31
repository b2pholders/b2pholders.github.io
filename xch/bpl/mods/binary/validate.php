<?php

namespace BPL\Mods\Binary\Validate;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

//use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

//use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\time;

//use function BPL\Mods\Helpers\user;

function main(
	$user_id,
	$username,
	$sponsor,
	$upline,
	$position,
	string $account_type_new = 'starter',
	string $prov = 'code'
)
{
	$set_binary = (settings('plans')->binary_pair /*&& empty(user_plan($user_id, 'binary'))*/);

//	$register = (($account_type_new !== 'starter' && $prov === 'code'));
//	$upgrade  = ($set_binary && $account_type_new === 'starter' && ($prov === 'activate' || $prov === 'upgrade'));

//	$sef = $register ? 65 : 10;
//
//	$app = application();

//	$app->redirect(Uri::root(true) . '/' . sef($sef), 'test', 'error');

	if ($set_binary /*&&*/ /*($register || $upgrade)*/)
	{
		$user_upline = username_upline($upline);

		$upline_id = $user_upline->u_id;

//		$err = '';
//
//		if ($upline === '')
//		{
//			$err = 'Please specify your Upline.<br>';
//			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
//		}
//
//		$user_upline = username_upline($upline);
//
//		if (empty($user_upline))
//		{
//			$err = 'Invalid Upline!<br>';
//			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
//		}
//
//		if (count(binary_downlines($upline_id)) >= 2)
//		{
//			$err = 'Invalid Upline Username!<br>';
//			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
//		}
//
//		$username_paid = user_username_paid($upline);
//
//		if (empty($username_paid))
//		{
//			$err = 'Invalid Upline!<br>';
//			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
//		}
//
//		if (has_position($upline_id, $position) ||
//			(!empty($username_paid) && !empty(user_binary_active($username_paid->id, $position))))
//		{
//			$err = 'Invalid Position!<br>';
//			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
//		}

		$user_binary = user_binary($user_id);

		/*if ($err === '')
		{*/
		if (empty($user_binary))
		{
			// insert binary entry
			$binary_insert = binary_insert($user_id, $upline_id, $position, $account_type_new);

			if ($binary_insert)
			{
				$update_binary = update_binary($user_id, $upline_id, $position);

				if ($update_binary)
				{
//					$username = $user_binary->username;
//					$sponsor  = user_binary($user_binary->sponsor_id)->username;

					logs_binary($user_id, $account_type_new, $username, $sponsor, time(), $prov);
				}
			}
		}
		else
		{
			if ($prov === 'upgrade' &&
				$user_binary->status === 'inactive' &&
				settings('binary')->{$account_type_new . '_pairs'} > 0)
			{
				$db = db();

				update('network_binary',
					['status = ' . $db->quote('active')],
					['user_id = ' . $db->quote($user_id)]);
			}
		}
		/*}*/
	}
}

/**
 * @param $username
 *
 * @return mixed|null
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

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 *
 * @since version
 */
function logs_binary($insert_id, $code_type, $username, $sponsor, $date, $prov)
{
	$sp = settings('plans');

	$db = db();

	$user_sponsor = user_username($sponsor);

	$sponsor_id = $user_sponsor ? $user_sponsor->id : '';

	$source = ' Sign Up';

	if ($prov === 'activate')
	{
		$source = ' Activation';
	}
	elseif ($prov === 'upgrade')
	{
		$source = ' Upgrade';
	}

	$binary_name  = ucwords($sp->binary_pair_name);
	$root_query   = sef(44) . qs();
	$package_name = ucfirst(settings('entry')->{$code_type . '_package_name'});
	$user_link    = "<a href=\"{$root_query}uid=$insert_id\">$username</a>";

	$activity = "<b>$binary_name Entry:</b> $user_link has entered into $binary_name upon $package_name $source.";

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $insert_id
 * @param $upline_id
 * @param $position
 *
 * @return false|mixed
 *
 * @since version
 */
function update_binary($insert_id, $upline_id, $position)
{
	$db = db();

	return update('network_binary',
		[($position === 'Left' ? 'downline_left_id = ' : 'downline_right_id = ') . $db->quote($insert_id)],
		['user_id = ' . $db->quote($upline_id)]);
}

/**
 * @param $insert_id
 * @param $upline_id
 * @param $position
 * @param $account_type
 *
 * @return false|mixed
 *
 * @since version
 */
function binary_insert($insert_id, $upline_id, $position, $account_type)
{
	$db = db();

	$sb = settings('binary');
	$sp = settings('plans');

	$status       = ($sb->{$account_type . '_pairs'} > 0 || $sp->redundant_binary) ? 'active' : 'inactive';
	$status_cycle = ($sb->{$account_type . '_pairs'} > 0 || $sp->redundant_binary) ? '1' : '0';

	return insert(
		'network_binary',
		[
			'user_id',
			'upline_id',
			'status',
			'position',
			'status_cycle',
			'date_last_flushout'
		],
		[
			$db->quote($insert_id),
			$db->quote($upline_id),
			$db->quote($status),
			$db->quote($position),
			$db->quote($status_cycle),
			$db->quote(time())
		]
	);
}


/**
 * @param $upline_id
 * @param $position
 *
 *
 * @return mixed|null
 * @since version
 */
function user_binary_active($upline_id, $position)
{
	$db = db();

	return $db->setQuery(
		'SELECT u.id ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE b.upline_id = ' . $db->quote($upline_id) .
		'AND b.position = ' . $db->quote($position) .
		'AND u.block = ' . $db->quote(0)
	)->loadObject();
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
 *
 * @return mixed|null
 * @since version
 */
function user_username_paid($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username) .
		'AND account_type <> ' . $db->quote('starter')
	)->loadObject();
}

/**
 * @param $upline_id
 * @param $position
 *
 * @return array|mixed
 *
 * @since version
 */
function has_position($upline_id, $position)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary b ' .
		'INNER JOIN network_users u ' .
		'ON b.user_id = u.id ' .
		'WHERE b.upline_id = ' . $db->quote($upline_id) .
		' AND b.position = ' . $db->quote($position) .
		' AND u.block = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $upline_id
 *
 * @return array|mixed
 *
 * @since version
 */
function binary_downlines($upline_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON b.user_id = u.id ' .
		'WHERE b.upline_id = ' . $db->quote($upline_id) .
		' AND u.block = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $username
 *
 * @return mixed|null
 *
 * @since version
 */
function username_upline($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT u.id as u_id, ' .
		'downline_left_id, ' .
		'downline_right_id ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE u.username = ' . $db->quote($username) .
		' AND u.account_type <> ' . $db->quote('starter')
	)->loadObject();
}

/**
 * @param $user_id
 * @param $plan
 *
 * @return mixed|null
 *
 * @since version
 */
function user_plan($user_id, $plan)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_' . $plan .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}