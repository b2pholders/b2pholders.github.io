<?php

namespace BPL\Mods\BTC_Currency;

require_once 'bpl/mods/api_coin_price.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\API_Coin_Price\main as api_coin_price;

use function BPL\Mods\Helpers\settings;

/**
 *
 * @return float|int
 *
 * @since version
 */
function main()
{
	return price_avg();
}

/**
 * @return float|int
 *
 * @since version
 */
function price_avg()
{
	return (price_ask() + price_bid()) * settings('trading')->fmc_to_usd / 2;
}

/**
 * @return mixed
 *
 * @since version
 */
function price_ask()
{
	$currency = settings('ancillaries')->currency;

	$price = $currency === 'PHP' ? 0.0024 : 0.012;

	$data = api_coin_price();

	if (!empty($data))
	{
		$price = $currency === 'PHP' ? $data['market']['ask'] : $data[$currency]['buy'];
	}

	return $price;
}

/**
 * @return mixed
 *
 * @since version
 */
function price_bid()
{
	$currency = settings('ancillaries')->currency;

	$price = $currency === 'PHP' ? 0.0024 : 0.012;

	$data = api_coin_price();

	if (!empty($data))
	{
		$price = $currency === 'PHP' ? $data['market']['bid'] : $data[$currency]['sell'];
	}

	return $price;
}