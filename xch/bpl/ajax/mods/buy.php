<?php

namespace BPL\Ajax\Mods\Token\Vault\Buy;

use Exception;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\users;
use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\token;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_token_request;

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
	$dbh = DB::connect();

	$return = $_POST;

	$settings_trading = settings('trading');

	$user = user($user_id);

	$return['usd_bal_now_user'] = $user->payout_transfer;
	$return['fmc_bal_now_user'] = $user->balance_fmc;
	$return['fmc_bal_now_vlt']  = token()->balance;

	$subtotal_buy = $amount * $price;
	$charge_buy   = $subtotal_buy * $settings_trading->vlt_buy_charge / 100;
	$total_buy    = $subtotal_buy + $charge_buy;

	validate_token_request($user_id, $amount, $price, $return);

	try
	{
		$dbh->beginTransaction();

		update_users($user_id, $amount, $price);
		update_token($amount, $price);

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

	if (merchant($total_buy))
	{
		$user = user($user_id);

		$return['usd_bal_now_user'] = $user->payout_transfer;
		$return['fmc_bal_now_user'] = $user->balance_fmc;
		$return['fmc_bal_now_vlt'] = token()->balance;

		$return['success_buy'] = 'You\'ve successfully bought ' .
			number_format($amount, 8) . ' ' . $settings_trading->token_name . '!';

		echo_json($return);
	}
}

/**
 * @param $user_id
 * @param $amount
 * @param $price
 *
 *
 * @since version
 */
function update_users($user_id, $amount, $price)
{
	$user = user($user_id);

	$balance_usd = $user->payout_transfer;
	$balance_fmc = $user->balance_fmc;

	$subtotal_buy = $amount * $price;
	$charge_buy   = $subtotal_buy * settings('trading')->vlt_buy_charge / 100;
	$total_buy    = $subtotal_buy + $charge_buy;

	$balance_usd -= $total_buy;
	$balance_fmc += $amount;

	crud(
		'UPDATE network_users ' .
		'SET payout_transfer = :balance, ' .
		'balance_fmc = :balance_fmc ' .
		'WHERE id = :id',
		[
			'balance'     => $balance_usd,
			'balance_fmc' => $balance_fmc,
			'id'          => $user_id
		]
	);
}

/**
 * @param $amount
 * @param $price
 *
 *
 * @since version
 */
function update_token($amount, $price)
{
	$subtotal_buy = $amount * $price;
	$charge_buy   = $subtotal_buy * settings('trading')->vlt_buy_charge / 100;
	$total_buy    = $subtotal_buy + $charge_buy;

	$fmc = token();

	$balance_fmc_vlt = $fmc->balance;

	$sales_fmc       = $fmc->sales_fmc + $total_buy;
	$balance_fmc_vlt -= $amount;

	crud(
		'UPDATE network_fmc ' .
		'SET balance = :balance, ' .
		'sales_fmc = :sales_fmc',
		[
			'balance'   => $balance_fmc_vlt,
			'sales_fmc' => $sales_fmc
		]
	);
}

/**
 * @param $total
 *
 * @return bool
 *
 * @since version
 */
function merchant($total): bool
{
	if (settings('plans')->merchant)
	{
		$dbh = DB::connect();

		$users = users();

		$merchant_count = [
			'executive' => 0,
			'regular'   => 0,
			'associate' => 0,
			'basic'     => 0,
			'starter'   => 0
		];

		foreach ($users as $user)
		{
			if (array_key_exists($user->merchant_type, $merchant_count))
			{
				++$merchant_count[$user->merchant_type];
			}
		}

		foreach ($users as $user)
		{
			if ($user->merchant_type === 'starter')
			{
				return false;
			}

			$merchant_cut = settings('merchant ')->{$user->merchant_type . '_merchant_cut'} / 100;

			if (!($merchant_count[$user->merchant_type] > 0 && $merchant_cut > 0))
			{
				return false;
			}

			$bonus_merchant = $total * (settings('trading')
						->merchant_share / 100) * $merchant_cut / $merchant_count[$user->merchant_type];

			$update = false;

			try
			{
				$dbh->beginTransaction();

				$update = crud(
					'UPDATE network_users ' .
					'SET bonus_merchant = :bonus_merchant, ' .
					'balance = :balance ' .
					'WHERE id = :id',
					[
						'bonus_merchant' => ($user->bonus_merchant + $bonus_merchant),
						'balance'        => ($user->payout_transfer + $bonus_merchant),
						'id'             => $user->id
					]
				);

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

			if (!$update)
			{
				return false;
			}
		}
	}

	return true;
}