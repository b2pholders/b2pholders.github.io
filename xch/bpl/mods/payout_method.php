<?php

namespace BPL\Mods\Payout_Method;

/**
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function main($user): string
{
	$payout_member = explode('|', $user->bank);

	$payout_method = '';

	if ($payout_member[0] === 'gcash')
	{
		[, $gcash_name, $gcash_number,] = $payout_member;

		$payout_method = 'G-Cash: [' . $gcash_name . '][' . $gcash_number . ']';
	}

	if ($payout_member[0] === 'bank')
	{
		[, $bank_type, $bank_name, $bank_account] = $payout_member;

		$payout_method = 'Bank: [' . $bank_type . '][' . $bank_name . '][' . $bank_account . ']';
	}

	if ($payout_member[0] === 'other')
	{
		[, $other_method, ,] = $payout_member;

		$payout_method = '[' . $other_method . ']';
	}

	return $payout_method;
}