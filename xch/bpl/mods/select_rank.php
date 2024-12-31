<?php

namespace Onewayhi\Select_Rank;

/**
 * @param $type
 *
 * @return int
 *
 * @since version
 */
function main($type): int
{
	$rank = [
		'affiliate'     => 0,
		'bronze'        => 1,
		'silver'        => 2,
		'gold'          => 3,
		'platinum'      => 4,
		'diamond'       => 5,
		'crown_diamond' => 6
	];

	return array_key_exists($type, $rank) ? $rank[$type] : 0;
}