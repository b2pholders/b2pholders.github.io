<?php

namespace BPL\Mods\Binary\Capping;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 * @param $user_id
 * @param $value
 *
 * @return int|mixed
 *
 * @since version
 */
function main($user_id, $value)
{
	$ub = user_binary($user_id);

	$limit = settings('binary')->{$ub->account_type . ('_max_pairs')};

//	if ($ub->status === 'reactivated')
//	{
//		return $value;
//	}

	$capping_cycle = $ub->capping_cycle;

	$capping_cycle_new = $capping_cycle + $value;

	if ($capping_cycle_new > $limit)
	{
		return non_zero($limit - $capping_cycle);
	}

	return $value;
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
		'WHERE b.user_id = ' . $db->quote($user_id)
	)->loadObject();
}

function non_zero($value)
{
	return $value > 0 ? $value : 0;
}