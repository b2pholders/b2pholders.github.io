<?php

namespace BPL\Ajax\Mods\Token\Vault\Sell\Amount;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_funds;

$amount  = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$price   = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($amount, $price, $user_id);

/**
 * @param $amount
 * @param $price
 * @param $user_id
 *
 *
 * @since version
 */
function main($amount, $price, $user_id)
{
	$return = $_POST;

	$settings_ancillaries = settings('ancillaries');
	$settings_trading     = settings('trading');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$account_type = $user->account_type;

	$minimum_bal_fmc = $settings_trading->{$account_type . '_minimum_bal_fmc'};
	$minimum_sell    = $settings_trading->{$account_type . '_minimum_sell'};
	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	$subtotal = $amount * $price;
	$charge   = $subtotal * $settings_trading->vlt_sell_charge / 100;

	if (!is_numeric($amount))
	{
		$return['error'] = 'Enter valid quantity!';

		echo_json($return);
	}

	if ($amount < $minimum_sell)
	{
		$return['error'] = 'Enter at least ' .
			number_format($minimum_sell, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (($user->balance_fmc - $amount) < $minimum_bal_fmc)
	{
		$return['error'] = 'Maintain at least ' .
			number_format($minimum_bal_fmc + $amount, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	validate_funds($charge, $user, $minimum_bal_usd, $settings_ancillaries, $return);

	$return['subtotal'] = $subtotal;
	$return['charge']   = $charge;
	$return['total']    = $subtotal - $charge;

	echo_json($return);
}