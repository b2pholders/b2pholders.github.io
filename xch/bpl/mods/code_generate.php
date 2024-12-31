<?php

namespace BPL\Mods\Codes_Generate;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\time;

/**
 * @param $amount
 * @param $type
 * @param $user_id
 *
 *
 * @since version
 */
function main($amount, $type, $user_id)
{
	$db = db();

	try
	{
		$db->transactionStart();

		foreach (code_array($amount) as $code)
		{
			if (insert_codes($user_id, $code, $type))
			{
				update_user($user_id, $type, $amount);
			}
		}

		logs($user_id, $amount, $type);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(URI::root(true) . '/' . sef(66));
}

/**
 * @param $user_id
 * @param $code
 * @param $type
 *
 *
 * @return false|mixed
 * @since version
 */
function insert_codes($user_id, $code, $type)
{
	$db = db();

	return insert(
		'network_codes',
		[
			'code',
			'type',
			'owner_id'
		],
		[
			$db->quote($code),
			$db->quote($type),
			$db->quote($user_id)
		]
	);
}

function update_user($user_id, $type, $amount)
{
	$se = settings('entry');

	$user = user($user_id);

	$usertype = $user->usertype;

	$price = $se->{$type . '_entry'};

	$total = $price * $amount;

	if ($usertype === 'Member')
	{
		update(
			'network_users',
			[
				'payout_transfer = payout_transfer - ' . $total
			],
			[
				'id = ' . db()->quote($user_id)
			]
		);
	}
}

/**
 * @param $user_id
 * @param $amount
 * @param $type
 *
 *
 * @since version
 */
function logs($user_id, $amount, $type)
{
	$db = db();

	$details = '<b>Generated: </b>' . $amount . ' ' . $type . ' registration codes.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($user_id),
			$db->quote($user_id),
			$db->quote($details),
			$db->quote(time())
		]
	);
}

/**
 *
 * @return string
 *
 * @since version
 */
function generate(): string
{
	$chars = 'abcdefghijkmnpqrstuvwxyz23456789';

	$pass = '';

	for ($i = 0; $i <= 9; $i++)
	{
		$num  = mt_rand() % 33;
		$tmp  = $chars[$num];
		$pass .= $tmp;
	}

	if (get_code($pass))
	{
		generate(); // generate again, if duplicate
	}

	return $pass;
}

/**
 * @param $code
 *
 * @return array|mixed
 *
 * @since version
 */
function get_code($code)
{
	$db = db();

	return $db->setQuery(
		'SELECT code ' .
		'FROM network_codes ' .
		'WHERE code = ' . $db->quote($code)
	)->loadObjectList();
}

/**
 * @param $amount
 *
 * @return array
 *
 * @since version
 */
function code_array($amount): array
{
	$arr = [];

	for ($ctr = 0; $ctr < $amount; $ctr++)
	{
		$arr[] = generate();
	}

	return $arr;
}