<?php

namespace BPL\Mods\Local\Leadership_Passive;

require_once 'helpers_local.php';

use function BPL\Mods\Local\Database\Query\crud;
use function BPL\Mods\Local\Database\Query\fetch_all;

/**
 *
 * @return array|false
 *
 * @since version
 */
function leadership_passive_users()
{
	return fetch_all(
		'SELECT account_type, ' .
		'user_id, ' .
		'p.bonus_leadership_passive as p_bonus_leadership_passive, ' .
		'bonus_leadership_passive_now, ' .
		'u.bonus_leadership_passive as u_bonus_leadership_passive, ' .
		'bonus_leadership_passive_balance, ' .
		'u.id as u_id, ' .
		'bonus_leadership_passive_last ' .
		'FROM network_users u ' .
		'INNER JOIN network_leadership_passive p ' .
		'ON u.id = p.user_id ' .
		'WHERE u.account_type <> :account_type',
		['account_type' => 'starter']
	);
}

/**
 * @param $sponsor_id
 *
 * @return array|false
 *
 * @since version
 */
function user_directs($sponsor_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type ' .
		'AND sponsor_id = :sponsor_id',
		[
			'account_type' => 'starter',
			'sponsor_id'   => $sponsor_id
		]
	);
}

/**
 * @param $user
 * @param $bonus
 * @param $leadership_passive
 *
 *
 * @since version
 */
function update_leadership_passive($user, $bonus, $leadership_passive)
{
	$bonus_leadership_passive      = $user->p_bonus_leadership_passive;
	$bonus_leadership_passive_now  = $user->bonus_leadership_passive_now;

	crud(
		'UPDATE network_leadership_passive ' .
		'SET bonus_leadership_passive = :passive, ' .
		'bonus_leadership_passive_now = :passive_now, ' .
		'bonus_leadership_passive_last = :passive_last ' .
		'WHERE user_id = :id',
		[
			'passive'      => $bonus_leadership_passive + $bonus,
			'passive_now'  => $bonus_leadership_passive_now + $bonus,
			'passive_last' => $leadership_passive,
			'id'           => $user->user_id
		]
	);
}

/**
 * @param $user
 * @param $bonus
 *
 *
 * @since version
 */
function update_user($user, $bonus)
{
	crud(
		'UPDATE network_users ' .
		'SET bonus_leadership_passive = :passive, ' .
		'bonus_leadership_passive_balance = :balance ' .
		'WHERE id = :id',
		[
			'passive' => $user->u_bonus_leadership_passive + $bonus,
			'balance' => $user->bonus_leadership_passive_balance + $bonus,
			'id'      => $user->u_id
		]
	);
}