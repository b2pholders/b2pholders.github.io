<?php

namespace BPL\Mods\Select_Account;

/**
 * @param $type
 *
 * @return int
 *
 * @since version
 */
function main($type): int
{
	$account = [
		'executive' => 4,
		'regular'   => 3,
		'associate' => 2,
		'basic'     => 1,
		'starter'   => 0
	];

	return array_key_exists($type, $account) ? $account[$type] : 0;
}