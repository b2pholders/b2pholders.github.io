<?php

namespace BPL\Ajax\Mods\Token\Vault\Exchange_Buy;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\token_trade_buy;

$amount  = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$total   = filter_input(INPUT_POST, 'total', FILTER_VALIDATE_FLOAT);
$charge  = filter_input(INPUT_POST, 'charge', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($amount, $total, $charge, $user_id);

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

function main($amount, $total, $charge, $user_id)
{
	$return = $_POST;

	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$balance_usd  = $user->payout_transfer;
	$account_type = $user->account_type;

	$minimum_bal_fmc = $settings_trading->{$account_type . '_minimum_bal_fmc'};
	$minimum_buy     = $settings_trading->{$account_type . '_minimum_buy'};
	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	if (empty($total))
	{
		$return['error_xch_buy'] = 'Transaction Could Not Proceed!';

		echo_json($return);
	}

	if (!is_numeric($amount))
	{
		$return['error_xch_buy'] = 'Enter valid amount!';

		echo_json($return);
	}

	if ($amount < $minimum_buy)
	{
		$return['error_xch_buy'] = 'Enter at least ' .
			number_format($minimum_buy, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (($user->balance_fmc - $amount) < $minimum_bal_fmc)
	{
		$return['error_xch_buy'] = 'Maintain at least ' .
			number_format($minimum_bal_fmc, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	$balance_usd += $total;

	if (($balance_usd - $charge) < $minimum_bal_usd)
	{
		$return['error_xch_buy'] = 'Maintain at least ' . number_format($minimum_bal_usd, 2) .
			' ' . $settings_ancillaries->currency . '!';

		echo_json($return);
	}

	token_trade_buy($user_id, $amount, $total);

	$user_latest = user($user_id);

	$return['usd_bal_now_user'] = $user_latest->payout_transfer;
	$return['fmc_bal_now_user'] = $user_latest->balance_fmc;

	$token_latest = token();

	$return['fmc_bal_now_vlt'] = $token_latest->balance;

	$return['success_xch'] = 'You\'ve Successfully Converted ' .
		number_format($amount, 8) . ' ' . $token_name . '!';

	echo_json($return);
}