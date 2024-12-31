<?php

namespace BPL\Ajax\Mods\Token\Trade\Buy;

use BPL\Lib\Local\Database\Db_Connect as DB;

use Exception;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_token_trade_buy;

$amount  = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$price   = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($amount, $price, $user_id);

/**
 * @param $user_id
 *
 *
 * @return mixed
 * @since version
 */
function user_token_trade($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE user_id = :user_id ' .
		'ORDER BY time_post DESC LIMIT 1',
		['user_id' => $user_id]
	);
}

/**
 * @param $user_id
 * @param $price
 * @param $amount
 *
 *
 * @since version
 */
function insert_token_trade($user_id, $price, $amount)
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
			'order_type' => 'buy',
			'price'      => $price,
			'amount'     => $amount,
			'time_post'  => time()
		]
	);
}

/**
 * @param $user_id
 * @param $amount
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
 * @param $user_id
 * @param $amount
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
 * @param $price
 *
 * @return array|false
 *
 * @since version
 */
function user_sell_valid($user_id, $price)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE order_type = :order_type ' .
		'AND price <= :price ' .
		'AND time_complete = :time_complete ' .
		'AND user_id <> :user_id',
		[
			'order_type'    => 'sell',
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
function update_add_token($user_id, $amount)
{
	crud(
		'UPDATE network_users ' .
		'SET balance_fmc = :balance_fmc ' .
		'WHERE id = :id',
		[
			'balance_fmc' => (user($user_id)->balance_fmc + $amount),
			'id'          => $user_id
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
 * @param $trade_id_try
 * @param $trade_id
 *
 *
 * @since version
 */
function update_token_trade_time($trade_id_try, $trade_id)
{
	crud(
		'UPDATE network_fmc_trade ' .
		'SET time_complete = :time_complete, ' .
		'complete_by = :complete_by ' .
		'WHERE id = :id',
		[
			'time_complete' => time(),
			'complete_by'   => $trade_id,
			'id'            => $trade_id_try
		]
	);
}

/**
 * @param $trade_id_try
 *
 * @return mixed
 *
 * @since version
 */
function token_trade($trade_id_try)
{
	return fetch(
		'SELECT * ' .
		'FROM network_fmc_trade ' .
		'WHERE id = :id',
		['id' => $trade_id_try]
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

	$subtotal_buy_trade = $amount * $price;
	$charge_buy_trade   = $subtotal_buy_trade * settings('trading')->trade_buy_charge / 100;
	$total_buy_trade    = $subtotal_buy_trade + $charge_buy_trade;

	validate_token_trade_buy($user_id, $amount, $price, $return);

	try
	{
		$dbh->beginTransaction();

		insert_token_trade($user_id, $price, $amount);

		// set aside the fund
		update_deduct_fund($user_id, $total_buy_trade);

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

	$trade_id = user_token_trade($user_id)->id;

	core($amount, $price, $user_id, $trade_id);

	$user_latest = user($user_id);

	$return['usd_bal_now_user'] = $user_latest->payout_transfer;
	$return['fmc_bal_now_user'] = $user_latest->balance_fmc;

	$return['success_buy_trade'] = 'Transaction Successful!';

	echo_json($return);
}

/**
 * @param $amount
 * @param $price
 * @param $user_id
 * @param $trade_id
 *
 *
 * @since version
 */
function core($amount, $price, $user_id, $trade_id)
{
	$dbh = DB::connect();

	$settings_trading = settings('trading');

	$user = user($user_id);

	// current credit balance
	$balance_usd_buy = $user->payout_transfer;

	$minimum_bal_usd = settings('ancillaries')->{$user->account_type . '_min_bal_usd'};

	$valid_sells = user_sell_valid($user_id, $price);

	if (!empty($valid_sells))
	{
		foreach ($valid_sells as $valid_sell)
		{
			$trade_id_try = $valid_sell->id;
			$amount_try   = $valid_sell->amount;

			if ($amount <= 0)
			{
				break;
			}

			// compare amount
			if ($amount_try < $amount)
			{
				// buyer amount updated ---------------

				$subtotal_trade = $amount_try * $price;

				// buyer
				$charge_buy_trade = $subtotal_trade * settings('trading')->trade_buy_charge / 100;
				$total_buy_trade  = $subtotal_trade + $charge_buy_trade;

				//seller
				$charge_sell_trade = $subtotal_trade * $settings_trading->trade_sell_charge / 100;
				$total_sell_trade  = $subtotal_trade - $charge_sell_trade;

				if (($balance_usd_buy - $total_buy_trade) < $minimum_bal_usd)
				{
					break;
				}

				try
				{
					$dbh->beginTransaction();

					$amount -= $amount_try;

					update_token_pool($trade_id, $amount);

					$user_trade_try = token_trade($trade_id_try);

					$user_id_try = $user_trade_try->user_id;

//					update_deduct_fund($user_id, $total_buy_trade); //buyer
					update_add_fund($user_id_try, $total_sell_trade); //seller

					update_token_trade_time($trade_id_try, $trade_id);

					update_add_token($user_id, $amount_try);

//					update_deduct_fund(1, $charge_buy_trade);
					update_add_fund(1, $charge_sell_trade);

					core($amount, $price, $user_id, $trade_id);

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
			elseif ($amount_try > $amount)
			{
				$subtotal_trade = $amount * $price;

				// buyer
				$charge_buy_trade = $subtotal_trade * settings('trading')->trade_buy_charge / 100;
				$total_buy_trade  = $subtotal_trade + $charge_buy_trade;

				//seller
				$charge_sell_trade = $subtotal_trade * $settings_trading->trade_sell_charge / 100;
				$total_sell_trade  = $subtotal_trade - $charge_sell_trade;

				if (($balance_usd_buy - $total_buy_trade) < $minimum_bal_usd)
				{
					break;
				}

				try
				{
					$dbh->beginTransaction();

					// seller account updated --------------

					$amount_try -= $amount;

					update_token_pool($trade_id_try, $amount_try);

					$user_trade_try = token_trade($trade_id_try);

					$user_id_try = $user_trade_try->user_id;

//					update_deduct_fund($user_id, $total_buy_trade); // buyer
					update_add_fund($user_id_try, $total_sell_trade); //seller

					update_token_trade_time($trade_id, $trade_id_try);

					update_add_token($user_id, $amount);

//					update_deduct_fund(1, $charge_buy_trade);
					update_add_fund(1, $charge_sell_trade);

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

				break;
			}
			elseif ($amount_try === $amount)
			{
				$subtotal_trade = $amount * $price;

				// buyer
				$charge_buy_trade = $subtotal_trade * settings('trading')->trade_buy_charge / 100;
				$total_buy_trade  = $subtotal_trade + $charge_buy_trade;

				//seller
				$charge_sell_trade = $subtotal_trade * $settings_trading->trade_sell_charge / 100;
				$total_sell_trade  = $subtotal_trade - $charge_sell_trade;

				if (($balance_usd_buy - $total_buy_trade) < $minimum_bal_usd)
				{
					break;
				}

				try
				{
					$dbh->beginTransaction();

					$user_trade_try = token_trade($trade_id_try);

					$user_id_try = $user_trade_try->user_id;

//					update_deduct_fund($user_id, $total_buy_trade); //buyer
					update_add_fund($user_id_try, $total_sell_trade); //seller

					update_token_trade_time($trade_id, $trade_id_try);
					update_token_trade_time($trade_id_try, $trade_id);

					update_add_token($user_id, $amount);

//					update_deduct_fund(1, $charge_buy_trade);
					update_add_fund(1, $charge_sell_trade);

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

				break;
			}
		}
	}
}