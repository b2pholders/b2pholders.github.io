<?php

namespace BPL\Mods\Commission_Deduct\Filter;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Database\Query\delete;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 * @param $user_id
 * @param $bonus
 *
 * @return int|mixed
 *
 * @since version
 */
function main($user_id, $bonus)
{
	if (settings('ancillaries')->cd_mode !== 'no_cd')
	{
		return filter($user_id, $bonus);
	}

	return $bonus;
}

/**
 * @param $user_id
 * @param $bonus
 *
 * @return int|mixed
 *
 * @since version
 */
function filter($user_id, $bonus)
{
	$user_cd = user_cd($user_id);

	if (!empty($user_cd))
	{
		$diff = $bonus - $user_cd->balance;

		if ($diff >= 0)
		{
			delete_cd($user_id);

			return $diff;
		}

		update_cd($user_id, $bonus);

		return 0;
	}

	return $bonus;
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function delete_cd($user_id)
{
	$db = db();

	delete(
		'network_commission_deduct',
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $bonus
 *
 *
 * @since version
 */
function update_cd($user_id, $bonus)
{
	$db = db();

	update(
		'network_commission_deduct',
		['balance = balance - ' . $bonus],
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_cd($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_commission_deduct ' .
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
}