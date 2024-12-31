<?php

namespace BPL\Mods\Local\Helpers;

require_once 'query_local.php';

use Exception;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

/**
 * @param $type
 *
 * @return mixed
 *
 * @since version
 */
function settings($type)
{
	return fetch(
		'SELECT * ' .
		'FROM network_settings_' . $type
	);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = :id',
		['id' => $user_id]
	);
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function users()
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users'
	);
}

/**
 * @param $arr
 *
 *
 * @since version
 */
function echo_json($arr)
{
	try
	{
		echo json_encode($arr, JSON_THROW_ON_ERROR);
	}
	catch (Exception $e)
	{
		// handle exception
	}

	exit;
}

/**
 *
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

/**
 *
 * @return string
 *
 * @since version
 */
function page_reload(): string
{
	return '<script>
        setInterval(function () {
            window.location.reload();
        }, 30000);
    </script>';
}

/**
 * @param          $user_id
 * @param          $amount
 * @param          $price
 * @param   array  $return
 *
 *
 * @since version
 */
function validate_token_request($user_id, $amount, $price, array $return)
{
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$account_type = $user->account_type;

	$subtotal_buy = $amount * $price;
	$charge_buy   = $subtotal_buy * $settings_trading->vlt_buy_charge / 100;
	$total_buy    = $subtotal_buy + $charge_buy;

	$minimum_buy     = $settings_trading->{$account_type . '_minimum_buy'};
	$maximum_buy     = $settings_trading->{$account_type . '_maximum_buy'};
	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	if (!is_numeric($amount))
	{
		$return['error'] = 'Enter valid quantity!';

		echo_json($return);
	}

	if ($amount > $maximum_buy)
	{
		$return['error'] = 'Buy not more than ' . number_format($maximum_buy, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if ($amount < $minimum_buy)
	{
		$return['error'] = 'Buy at least ' . number_format($minimum_buy, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if ((token()->balance - $amount) < $settings_trading->vlt_min_stock)
	{
		$return['error'] = 'No Available ' . $token_name . ' Yet!';

		echo_json($return);
	}

	validate_funds($total_buy, $user, $minimum_bal_usd, $settings_ancillaries, $return);
}

/**
 * @param          $total_buy
 * @param          $user
 * @param          $minimum_bal_usd
 * @param          $settings_ancillaries
 * @param   array  $return
 *
 *
 * @since version
 */
function validate_funds($total_buy, $user, $minimum_bal_usd, $settings_ancillaries, array $return): void
{
	if ($total_buy > 0)
	{
		if (($user->payout_transfer - $total_buy) < $minimum_bal_usd)
		{
			$return['error'] = 'Maintain at least ' .
				number_format($minimum_bal_usd + $total_buy, 2) .
				' ' . $settings_ancillaries->currency . '!';

			echo_json($return);
		}
	}
	else
	{
		$return['error'] = 'Transaction could not proceed!';

		echo_json($return);
	}
}

/**
 * @param          $user_id
 * @param          $amount
 * @param          $price
 *
 * @param   array  $return
 *
 * @since version
 */
function validate_token_trade_buy($user_id, $amount, $price, array $return)
{
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$account_type = $user->account_type;

	$minimum_buy     = $settings_trading->{$account_type . '_minimum_buy'};
	$maximum_buy     = $settings_trading->{$account_type . '_maximum_buy'};
	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	if (!is_numeric($amount))
	{
		$return['error_amount_buy_trade'] = 'Enter valid amount!';

		echo_json($return);
	}

	if ($amount < $minimum_buy)
	{
		$return['error_amount_buy_trade'] = 'Buy at least ' .
			number_format($minimum_buy, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if ($amount > $maximum_buy)
	{
		$return['error_amount_buy_trade'] = 'Buy not more than ' .
			number_format($maximum_buy, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (!is_numeric($price) || !$price)
	{
		$return['error_price_buy_trade'] = 'Enter valid price!';

		echo_json($return);
	}

	$subtotal_buy_trade = $amount * $price;
	$charge_buy_trade   = $subtotal_buy_trade * $settings_trading->trade_buy_charge / 100;
	$total_buy_trade    = $subtotal_buy_trade + $charge_buy_trade;

	if ($total_buy_trade > 0)
	{
		if (($user->payout_transfer - $total_buy_trade) < $minimum_bal_usd)
		{
			$return['error_buy_trade'] = 'Maintain at least ' .
				number_format($minimum_bal_usd + $total_buy_trade, 2) .
				' ' . $settings_ancillaries->currency . '!';

			echo_json($return);
		}
	}
	else
	{
		$return['error_buy_trade'] = 'Transaction could not proceed!';

		echo_json($return);
	}
}

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function directs_valid($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> :account_type ' .
		' AND sponsor_id = :sponsor_id',
		[
			'account_type' => 'starter',
			'sponsor_id'   => $user_id
		]
	);
}

/**
 * @param          $input
 * @param          $user_id
 *
 * @param   array  $return
 *
 * @since version
 */
function validate_fast_track($input, $user_id, array $return)
{
	$si = settings('investment');
	$sa = settings('ancillaries');

	$currency = $sa->currency;

	$user = user($user_id);

	$account_type = $user->account_type;

	$min_bal_usd = $sa->{$account_type . '_min_bal_usd'};

	$min_input        = $si->{$account_type . '_fast_track_minimum'};
	$max_input        = $si->{$account_type . '_fast_track_maximum'};
	$max_principal    = $si->{$account_type . '_fast_track_principal_maximum'};
	$required_directs = $si->{$account_type . '_fast_track_required_directs'};

	$actual_directs = directs_valid($user_id);

	if ($required_directs && $actual_directs < $required_directs)
	{
		$return['error_fast_track'] = 'Sponsor at least ' . $required_directs .
			($required_directs > 1 ? ' directs!' : ' direct!');

		echo_json($return);
	}

	if (!is_numeric($input))
	{
		$return['error_fast_track'] = 'Enter valid amount!';

		echo_json($return);
	}

	if ($input < $min_input)
	{
		$return['error_fast_track'] = 'Enter at least ' .
			number_format($min_input, 2) . ' ' . $currency . '!';

		echo_json($return);
	}

	if ($input > $max_input)
	{
		$return['error_fast_track'] = 'Enter not more than ' .
			number_format($max_input, 2) . ' ' . $currency . '!';

		echo_json($return);
	}

	if ($user->fast_track_principal > $max_principal)
	{
		$return['error_fast_track'] = 'Maximum ' . settings('plans')->fast_track_name . ' Deposit is ' .
			number_format($max_principal, 2) . ' ' . $currency . '!';

		echo_json($return);
	}

	if (($user->payout_transfer /*$user->points*/ - $input) < $min_bal_usd)
	{
		$return['error_fast_track'] = 'Maintain at least ' .
			bcadd($min_bal_usd, $input, 2) . ' ' . $currency . '!';

		echo_json($return);
	}
}

/**
 * @param          $user_id
 * @param          $input
 * @param          $principal
 *
 * @param   array  $return
 *
 * @since version
 */
function validate_top_up($user_id, $input, $principal, array $return)
{
	$settings_investment  = settings('investment');
	$settings_ancillaries = settings('ancillaries');

	$currency = $settings_ancillaries->currency;

	$user = user($user_id);

	$account_type = $user->account_type;

	$top_up_minimum           = $settings_investment->{$account_type . '_top_up_minimum'};
	$top_up_maximum           = $settings_investment->{$account_type . '_top_up_maximum'};
	$top_up_principal_maximum = $settings_investment->{$account_type . '_top_up_principal_maximum'};
	$minimum_bal_usd          = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	if (!is_numeric($input))
	{
		$return['error_top_up'] = 'Enter valid amount!';

		echo_json($return);
	}

	if ($input < $top_up_minimum)
	{
		$return['error_top_up'] = 'Enter at least ' .
			number_format($top_up_minimum, 2) . ' ' . $currency . '!';

		echo_json($return);
	}

	if ($input > $top_up_maximum)
	{
		$return['error_top_up'] = 'Enter not more than ' .
			number_format($top_up_maximum, 2) . ' ' . $currency . '!';

		echo_json($return);
	}

	if ($principal > $top_up_principal_maximum)
	{
		$return['error_top_up'] = 'Maximum ' . settings('plans')->top_up_name . ' Deposit is ' .
			number_format($top_up_principal_maximum, 2) . ' ' . $currency . '!';

		echo_json($return);
	}

	if (($user->payout_transfer - $input) < $minimum_bal_usd)
	{
		$return['error_top_up'] = 'Maintain at least ' .
			bcadd($minimum_bal_usd, $input, 2) . ' ' . $currency . '!';

		echo_json($return);
	}
}

/**
 * @param $user_id
 * @param $amount
 * @param $total
 *
 *
 * @since version
 */
function token_trade_sell($user_id, $amount, $total)
{
	$dbh = DB::connect();

	try
	{
		$dbh->beginTransaction();

		update_user_token_trade_sell($user_id, $total, $amount);
		update_token_trade_sell($amount, $total);

		$dbh->commit();
	}
	catch (Exception $e)
	{
		try
		{
			$dbh->rollback();
		}
		catch (Exception $e2)
		{
		}
	}
}

function token_trade_buy($user_id, $amount, $total)
{
	$dbh = DB::connect();

	try
	{
		$dbh->beginTransaction();

		update_user_token_trade_buy($user_id, $total, $amount);
		update_token_trade_buy($amount, $total);

		$dbh->commit();
	}
	catch (Exception $e)
	{
		try
		{
			$dbh->rollback();
		}
		catch (Exception $e2)
		{
		}
	}
}

/**
 * @param $user_id
 * @param $fund
 * @param $token
 *
 *
 * @since version
 */
function update_user_token_trade_sell($user_id, $fund, $token)
{
	$user = user($user_id);

	crud(
		'UPDATE network_users ' .
		'SET payout_transfer = :balance, ' .
		'balance_fmc = :balance_fmc ' .
		'WHERE id = :id',
		[
			'balance'     => ($user->payout_transfer + $fund),
			'balance_fmc' => ($user->balance_fmc - $token),
			'id'          => $user_id
		]
	);
}

function update_user_token_trade_buy($user_id, $fund, $token)
{
	$user = user($user_id);

	crud(
		'UPDATE network_users ' .
		'SET payout_transfer = :balance, ' .
		'balance_fmc = :balance_fmc ' .
		'WHERE id = :id',
		[
			'balance'     => ($user->payout_transfer - $fund),
			'balance_fmc' => ($user->balance_fmc + $token),
			'id'          => $user_id
		]
	);
}

/**
 * @param $balance_token
 * @param $purchase_token
 *
 *
 * @since version
 */
function update_token_trade_sell($balance_token, $purchase_token)
{
	$token = token();

	crud(
		'UPDATE network_fmc ' .
		'SET balance = :balance, ' .
		'purchase_fmc = :purchase_fmc',
		[
			'balance'      => ($token->balance + $balance_token),
			'purchase_fmc' => ($token->purchase_fmc + $purchase_token)
		]
	);
}

function update_token_trade_buy($balance_token, $purchase_token)
{
	$token = token();

	crud(
		'UPDATE network_fmc ' .
		'SET balance = :balance, ' .
		'purchase_fmc = :purchase_fmc',
		[
			'balance'      => ($token->balance - $balance_token),
			'purchase_fmc' => ($token->purchase_fmc - $purchase_token)
		]
	);
}