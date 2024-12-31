<?php

namespace BPL\Ajax\Mods\Token\Vault\Buy\Amount;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_token_request;

$amount  = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$price   = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($amount, $price, $user_id);

function main($amount, $price, $user_id)
{
	$return = $_POST;

	$vlt_buy_charge = settings('trading')->vlt_buy_charge / 100;

	$subtotal_buy = $amount * $price;
	$charge_buy   = $subtotal_buy * $vlt_buy_charge;
	$total_buy    = $subtotal_buy + $charge_buy;

	validate_token_request($user_id, $amount, $price, $return);

	$return['subtotal'] = $subtotal_buy;
	$return['charge']   = $charge_buy;
	$return['total']    = $total_buy;

	echo_json($return);
}