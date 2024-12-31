<?php

namespace BPL\Ajax\Ajaxer\Token\Trade\Sell\Amount;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;

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

	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$balance_usd  = $user->payout_transfer;
	$account_type = $user->account_type;

	$minimum_sell = $settings_trading->{$account_type . '_minimum_sell'};

	if (!is_numeric($amount))
	{
		$return['error_amount_sell_trade'] = 'Enter valid quantity!';

		echo_json($return);
	}

	if ($amount < $minimum_sell)
	{
		$return['error_amount_sell_trade'] = 'Sell at least ' .
			number_format($minimum_sell, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (!is_numeric($price) || !$price)
	{
		$return['error_price_sell_trade'] = 'Enter valid price!';

		echo_json($return);
	}

	if (($user->balance_fmc - $amount) < $settings_trading->{$account_type . '_minimum_bal_fmc'})
	{
		$return['error_sell_trade'] = 'Maintain at least ' .
			number_format($minimum_sell + $amount, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	$subtotal_sell_trade = $amount * $price;
	$charge_sell_trade   = $subtotal_sell_trade * $settings_trading->trade_sell_charge / 100;

	if ($charge_sell_trade > 0 && $balance_usd > 0)
	{
		if (($balance_usd - $charge_sell_trade) < $settings_ancillaries->{$account_type . '_min_bal_usd'})
		{
			$return['error_sell_trade'] = 'Maintain at least ' .
				number_format($balance_usd + $charge_sell_trade, 2) .
				' ' . $settings_ancillaries->currency . '!';

			echo_json($return);
		}
	}
	else
	{
		$return['error_sell_trade'] = 'Transaction could not proceed!';

		echo_json($return);
	}

	$return['charge_sell_trade']   = $charge_sell_trade;
	$return['subtotal_sell_trade'] = $subtotal_sell_trade;
	$return['total_sell_trade']    = $subtotal_sell_trade - $charge_sell_trade;

	echo_json($return);
}