<?php

namespace BPL\Ajax\Mods\Token\Trade\Sell;

use BPL\Lib\Local\Database\Db_Connect as DB;

use Exception;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;

$amount  = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$price   = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($amount, $price, $user_id);

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function user_token_trade($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE user_id = :user_id ' .
		'AND order_type = :order_type',
		[
			'user_id'    => $user_id,
			'order_type' => 'sell'
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 * @param $price
 *
 *
 * @since version
 */
function insert_token_trade($user_id, $amount, $price)
{
	crud(
		'INSERT ' .
		'INTO network_fmc_trade (' .
		'user_id, ' .
		'order_type, ' .
		'price, ' .
		'amount, ' .
		'time_post' .
		') VALUES (' .
		':user_id, ' .
		':order_type, ' .
		':price, ' .
		':amount, ' .
		':time_post' .
		')',
		[
			'user_id'    => $user_id,
			'order_type' => 'sell',
			'price'      => $price,
			'amount'     => $amount,
			'time_post'  => time()
		]
	);
}

/**
 * @param $id
 * @param $amount
 *
 * @since version
 */
function update_deduct_token($id, $amount)
{
	crud(
		'UPDATE network_users ' .
		'SET balance_fmc = :balance_fmc ' .
		'WHERE id = :id',
		[
			'balance_fmc' => (user($id)->balance_fmc - $amount),
			'id'          => $id
		]
	);
}

/**
 * @param $id
 * @param $amount
 *
 * @since version
 */
function update_add_token($id, $amount)
{
	crud(
		'UPDATE network_users ' .
		'SET balance_fmc = :balance_fmc ' .
		'WHERE id = :id',
		[
			'balance_fmc' => (user($id)->balance_fmc + $amount),
			'id'          => $id
		]
	);
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_token_trade_last($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE user_id = :user_id ' .
		'ORDER BY time_post ' .
		'DESC LIMIT 1',
		['user_id' => $user_id]
	);
}

/**
 * @param $user_id
 * @param $price
 *
 * @return array|false
 *
 * @since version
 */
function token_trade_buy_valid($user_id, $price)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE order_type = :order_type ' .
		'AND price >= :price ' .
		'AND time_complete = :time_complete ' .
		'AND user_id <> :user_id',
		[
			'order_type'    => 'buy',
			'price'         => $price,
			'time_complete' => 0,
			'user_id'       => $user_id
		]
	);
}

/**
 * @param $trade_id
 * @param $amount
 *
 *
 * @since version
 */
function update_token_pool($trade_id, $amount)
{
	crud(
		'UPDATE network_fmc_trade ' .
		'SET amount = :amount ' .
		'WHERE id = :id',
		[
			'amount' => $amount,
			'id'     => $trade_id
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_add_fund($user_id, $amount)
{
	crud(
		'UPDATE network_users ' .
		'SET payout_transfer = :balance ' .
		'WHERE id = :id',
		[
			'balance' => (user($user_id)->payout_transfer + $amount),
			'id'      => $user_id
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_deduct_fund($user_id, $amount)
{
	crud(
		'UPDATE network_users ' .
		'SET payout_transfer = :balance ' .
		'WHERE id = :id',
		[
			'balance' => (user($user_id)->payout_transfer - $amount),
			'id'      => $user_id
		]
	);
}

/**
 * @param $id
 * @param $id_complete_by
 *
 *
 * @since version
 */
function update_token_trade_time($id, $id_complete_by)
{
	crud(
		'UPDATE network_fmc_trade ' .
		'SET time_complete = :time_complete, ' .
		'complete_by = :complete_by ' .
		'WHERE id = :id',
		[
			'time_complete' => time(),
			'complete_by'   => $id_complete_by,
			'id'            => $id
		]
	);
}

/**
 * @param $id
 *
 * @return mixed
 *
 * @since version
 */
function token_trade($id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE id = :id',
		['id' => $id]
	);
}

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
	$dbh = DB::connect();

	$return = $_POST;

	validate_token_sell($amount, $price, $user_id);

	try
	{
		$dbh->beginTransaction();

		insert_token_trade($user_id, $amount, $price);

		update_deduct_token($user_id, $amount); // set aside the token for sale

		core($user_id, $price, $amount, user_token_trade_last($user_id)->id);

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

	$user_latest = user($user_id);

	$return['usd_bal_now_user'] = $user_latest->payout_transfer;
	$return['fmc_bal_now_user'] = $user_latest->balance_fmc;

	$return['success_sell_trade'] = 'Transaction Successful!';

	echo_json($return);
}

/**
 * @param $amount
 * @param $price
 * @param $user_id
 *
 *
 * @since version
 */
function validate_token_sell($amount, $price, $user_id)
{
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$user = user($user_id);

	$account_type = $user->account_type;
	$balance_fmc  = $user->balance_fmc;

	$minimum_bal_fmc = $settings_trading->{$account_type . '_minimum_bal_fmc'};
	$minimum_sell    = $settings_trading->{$account_type . '_minimum_sell'};
	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};

	if (!is_numeric($amount))
	{
		$return['error_amount_sell_trade'] = 'Enter valid amount!';

		echo_json($return);
	}

	if ($amount < $minimum_sell)
	{
		$return['error_amount_sell_trade'] = 'Sell at least ' .
			number_format($minimum_sell, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	if (($balance_fmc - $amount) < $minimum_bal_fmc)
	{
		$return['error_amount_sell_trade'] = 'Maintain at least ' .
			number_format($minimum_bal_fmc + $amount, 8) . ' ' . $token_name . '!';

		echo_json($return);
	}

	$charge_sell_trade = $amount * $price * $settings_trading->trade_sell_charge / 100;

	if ($user->payout_transfer && ($user->payout_transfer - $charge_sell_trade) < $minimum_bal_usd)
	{
		$return['error_sell_trade'] = 'Maintain at least ' .
			number_format($minimum_bal_usd + $charge_sell_trade, 2) .
			' ' . $settings_ancillaries->currency . '!';

		echo_json($return);
	}

	$user_sell_trades = user_token_trade($user_id);

	$amount_sell_total = 0;

	if ($user_sell_trades)
	{
		foreach ($user_sell_trades as $user_sell_trade)
		{
			$amount_sell_total += $user_sell_trade->amount;
		}
	}

	if (($balance_fmc - $amount_sell_total - $amount) < $minimum_bal_fmc)
	{
		$return['error_sell_trade'] = 'Maintain at least ' .
			number_format($minimum_bal_fmc + $amount_sell_total + $amount, 8) .
			' ' . $token_name . '!';

		echo_json($return);
	}
}

/**
 * @param         $user_id
 * @param         $price
 * @param         $amount
 * @param         $trade_id
 *
 * @since version
 */
function core($user_id, $price, $amount, $trade_id): void
{
//	$dbh = DB::connect();

	$settings_trading = settings('trading');

	$user = user($user_id);

	$balance_fmc_sell = $user->balance_fmc;

	$minimum_bal_fmc = $settings_trading->{$user->account_type . '_minimum_bal_fmc'};

	$valid_buys = token_trade_buy_valid($user_id, $price);

	if (!empty($valid_buys))
	{
		foreach ($valid_buys as $valid_buy)
		{
			$trade_id_try = $valid_buy->id; // id of buyer
			$amount_try   = $valid_buy->amount; // amount the buyer is willing to buy

			if ($amount <= 0)
			{
				break;
			}

			if ($amount_try < $amount) // the buyer is willing to buy only a part
			{
				if (($balance_fmc_sell - $amount) < $minimum_bal_fmc)
				{
					break;
				}

				/*try
				{
					$dbh->beginTransaction();*/

					$amount -= $amount_try;

					$subtotal_trade = $amount_try * $price;

					//seller
					$charge_sell_trade = $subtotal_trade * $settings_trading->trade_sell_charge / 100;
					$total_sell_trade  = $subtotal_trade - $charge_sell_trade;

					//buyer
					$charge_buy_trade = $subtotal_trade * $settings_trading->trade_buy_charge / 100;
					$total_buy_trade  = $subtotal_trade + $charge_buy_trade;

					update_token_pool($trade_id, $amount);

					update_add_fund($user_id, $total_sell_trade); // seller
					update_deduct_fund($trade_id_try, $total_buy_trade); // buyer

					update_token_trade_time($trade_id_try, $trade_id); // trx timestamp

					$user_trade_try = token_trade($trade_id_try);

					$user_id_try = $user_trade_try->user_id;

					update_add_token($user_id_try, $amount_try); // add token to buyer

					update_add_fund(1, $charge_sell_trade); // take sell charge
					update_add_fund(1, $charge_buy_trade); // take buy charge

					core($amount, $price, $user_id, $trade_id);

//					$dbh->commit();
//				}
//				catch (Exception $e)
//				{
//					try
//					{
//						$dbh->rollback();
//					}
//					catch (Exception $e2)
//					{
//					}
//				}
			}
			elseif ($amount_try > $amount)
			{
				if (($balance_fmc_sell - $amount) < $minimum_bal_fmc)
				{
					break;
				}

				/*try
				{
					$dbh->beginTransaction();*/

					$amount_try -= $amount;

					$subtotal_trade = $amount * $price;

					// seller
					$charge_sell_trade = $subtotal_trade * $settings_trading->trade_sell_charge / 100;
					$total_sell_trade  = $subtotal_trade - $charge_sell_trade;

					// buyer
					$charge_buy_trade = $subtotal_trade * $settings_trading->trade_buy_charge / 100;
					$total_buy_trade  = $subtotal_trade + $charge_buy_trade;

					update_token_pool($trade_id_try, $amount_try);

					update_add_fund($user_id, $total_sell_trade); // seller
					update_deduct_fund($trade_id_try, $total_buy_trade); // buyer

					update_token_trade_time($trade_id, $trade_id_try);

					$user_trade_try = token_trade($trade_id_try);

					$user_id_try = $user_trade_try->user_id;

					update_add_token($user_id_try, $amount); //buyer

					update_add_fund(1, $charge_sell_trade); // take sell charge
					update_add_fund(1, $charge_buy_trade); // take buy charge

					/*$dbh->commit();
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
				}*/

				break;
			}
			elseif ($amount_try === $amount)
			{
				if (($balance_fmc_sell - $amount) < $minimum_bal_fmc)
				{
					break;
				}

				/*try
				{
					$dbh->beginTransaction();*/

					$subtotal_trade = $amount * $price;

					// seller
					$charge_sell_trade = $subtotal_trade * $settings_trading->trade_sell_charge / 100;
					$total_sell_trade  = $subtotal_trade - $charge_sell_trade;

					// buyer
					$charge_buy_trade = $subtotal_trade * $settings_trading->trade_buy_charge / 100;
					$total_buy_trade  = $subtotal_trade + $charge_buy_trade;

					update_add_fund($user_id, $total_sell_trade);
					update_deduct_fund($user_id, $total_buy_trade);

					update_token_trade_time($trade_id, $trade_id_try);
					update_token_trade_time($trade_id_try, $trade_id);

					$user_trade_try = token_trade($trade_id_try);

					$user_id_try = $user_trade_try->user_id;

					update_add_token($user_id_try, $amount_try); // add token to buyer

					update_add_fund(1, $charge_sell_trade); // take sell charge
					update_add_fund(1, $charge_buy_trade); // take buy charge

					/*$dbh->commit();
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
				}*/

				break;
			}
		}
	}
}