<?php

namespace BPL\Mods\USDT_Currency;

require_once 'bpl/mods/api_usdt_price.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\API_USDT_Price\main as api_usdt_price;

use function BPL\Mods\Helpers\settings;

/**
 *
 * @return float
 *
 * @since version
 */
function main()
{
	$currency   = settings('ancillaries')->currency;
	$fmc_to_usd = settings('trading')->fmc_to_usd;

	$price = $currency === 'PHP' ? 0.01200 : 0.00024;

	$data = api_usdt_price();

	if (!empty($data))
	{
		$price = ($currency !== 'PHP' ? $data :
				(price_ask() + price_bid()) / 2) * $fmc_to_usd;
	}

	return $price;
}

/**
 * Get the ask price for the currency.
 *
 * @return float|int
 *
 * @since version
 */
function price_ask()
{
	$currency   = settings('ancillaries')->currency;
	$fmc_to_usd = settings('trading')->fmc_to_usd;

	$price = ($currency === 'PHP') ? 0.012 : 0.00024;

	$data = api_usdt_price();

	if ($data)
	{
		$price = $data * $fmc_to_usd;
	}

	return $price;
}

/**
 * Get the bid price for the currency.
 *
 * @return float|int
 *
 * @since version
 */
function price_bid()
{
	$currency   = settings('ancillaries')->currency;
	$fmc_to_usd = settings('trading')->fmc_to_usd;

	$price = ($currency === 'PHP') ? 0.012 : 0.00024;

	$data = api_usdt_price();

	if ($data)
	{
		$price = $data * $fmc_to_usd;
	}

	return $price;
}