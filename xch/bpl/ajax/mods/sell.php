<?php

namespace BPL\Ajax\Mods\Token\Vault\Sell;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\token_trade_sell;

$amount  = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$price   = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($amount, $price, $user_id);

/**
 *
 * @return mixed
 *
 * @since version
 */
function token()
{
	return fetch(
		'SELECT * ' .
		'FROM network_fmc'
	);
}

function main($amount, $price, $user_id)
{
	$return = $_POST;

	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$balance_usd  = $user->payout_transfer;
	$balance_fmc  = $user->balance_fmc;
	$account_type = $user->account_type;

	$minimum_bal_fmc = $settings_trading->{$account_type . '_minimum_bal_fmc'};
	$minimum_sell    = $settings_trading->{$account_type . '_minimum_sell'};
	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	$return['usd_bal_now_user'] = $balance_usd;
	$return['fmc_bal_now_user'] = $balance_fmc;
	$return['fmc_bal_now_vlt']  = token()->balance;

	$try_subtotal = $amount * $price;
	$try_charge   = $try_subtotal * $settings_trading->vlt_sell_charge / 100;
	$try_total    = $try_subtotal - $try_charge;

	if (!is_numeric($amount))
	{
		$return['error_sell'] = 'Enter valid amount!';

		echo_json($return);
	}

	if ($amount < $minimum_sell)
	{
		$return['error_sell'] = 'Sell at least ' . number_format($minimum_sell, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (($balance_fmc - $amount) < $minimum_bal_fmc)
	{
		$return['error_sell'] = 'Maintain at least ' .
			number_format($minimum_bal_fmc + $amount, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (($balance_usd - $try_charge) < $minimum_bal_usd)
	{
		$return['error_sell'] = 'Maintain at least ' .
			number_format($minimum_bal_usd + $try_charge, 2) .
			' ' . $settings_ancillaries->currency . '!';

		echo_json($return);
	}

	token_trade_sell($user_id, $amount, $try_total);

	$user_latest = user($user_id);

	$return['usd_bal_now_user'] = $user_latest->payout_transfer;
	$return['fmc_bal_now_user'] = $user_latest->balance_fmc;

	$fmc_bal_now_vlt = token()->balance;

	$return['fmc_bal_now_vlt'] = $fmc_bal_now_vlt;

	$return['success_sell'] = 'You\'ve successfully sold ' .
		number_format($amount, 8) . ' ' . $token_name . '!';

	echo_json($return);
}