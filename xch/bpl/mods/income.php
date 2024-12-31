<?php

namespace BPL\Mods\Income;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\db;

function main($user_id)
{
	return income_marketing($user_id) + income_daily($user_id);
}

function income_marketing($user_id)
{
	$sp = settings('plans');

	$user = user($user_id);

	$binary = 0;

	$user_binary = binary($user_id);

	if ($sp->binary_pair && $user_binary)
	{
		$binary = $user_binary->income_cycle;
	}

	return (
		+$sp->direct_referral * $user->income_referral +
		+$sp->indirect_referral * $user->bonus_indirect_referral +
		+$sp->binary_pair * $binary +
		+$sp->leadership_binary * $user->bonus_leadership +
		+$sp->leadership_passive * $user->bonus_leadership_passive +
		+($sp->unilevel && !empty(user_unilevel($user_id))) * $user->unilevel +
		+$sp->matrix * $user->bonus_matrix +
		+$sp->power * $user->bonus_power +
		+$sp->harvest * $user->bonus_harvest +
		+$sp->royalty * $user->rank_reward +
		+$sp->upline_support * $user->upline_support +
		+$sp->passup * $user->passup_bonus +
		+$sp->elite_reward * $user->elite_reward +
		+$sp->stockist * $user->stockist_bonus +
		+$sp->franchise * $user->franchise_bonus
	);
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_unilevel($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_unilevel ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

function income_daily($user_id)
{
	$sp = settings('plans');

	$user = user($user_id);

	return (
		+$sp->etrade * $user->compound_daily_interest +
		+$sp->top_up * $user->top_up_interest +
		+$sp->fast_track * $user->fast_track_interest +
		+$sp->fixed_daily * $user->fixed_daily_interest
	);
}

function binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary ' .
		'WHERE user_id = ' .
		$db->quote($user_id)
	)->loadObject();
}