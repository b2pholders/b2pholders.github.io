<?php

namespace BPL\Mods\Local\Commission_Deduct\Filter;

require_once 'query_local.php';
require_once 'helpers_local.php';

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;

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
		if (($bonus - $user_cd->balance) > 0)
		{
			delete_cd($user_id);

			return ($bonus - $user_cd->balance);
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
	crud(
		'DELETE ' .
		'FROM network_commission_deduct ' .
		'WHERE id = :id',
		['id' => $user_id]
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
	crud(
		'UPDATE network_commission_deduct ' .
		'SET balance = balance - :balance ' .
		'WHERE id = :id',
		[
			'balance' => $bonus,
			'id'      => $user_id
		]
	);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_cd($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_commission_deduct ' .
		'WHERE id = :id',
		['id' => $user_id]
	);
}