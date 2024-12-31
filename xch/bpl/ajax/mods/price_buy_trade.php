<?php

namespace BPL\Ajax\Mods\Token\Trade\Buy\Price;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_token_trade_buy;

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

	validate_token_trade_buy($user_id, $amount, $price, $return);

	$subtotal_buy_trade = $amount * $price;
	$charge_buy_trade   = $subtotal_buy_trade * settings('trading')->trade_buy_charge / 100;

	$return['charge_buy_trade']   = $charge_buy_trade;
	$return['subtotal_buy_trade'] = $subtotal_buy_trade;
	$return['total_buy_trade']    = $subtotal_buy_trade + $charge_buy_trade;

	echo_json($return);
}