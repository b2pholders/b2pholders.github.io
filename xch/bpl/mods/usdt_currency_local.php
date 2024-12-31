<?php

namespace BPL\Mods\Local\USDT_Currency;

require_once 'api_usdt_price_local.php';
require_once 'helpers_local.php';

use function BPL\Mods\Local\API_USDT_Price\main as api_usdt_price_local;

use function BPL\Mods\Local\Helpers\settings as settings_local;

/**
 *
 * @return float
 *
 * @since version
 */
function main()
{
	$currency   = settings_local('ancillaries')->currency;
	$fmc_to_usd = settings_local('trading')->fmc_to_usd;

	$price = $currency === 'PHP' ? 0.012 : 0.00024;

	$data = api_usdt_price_local();

	if (!empty($data))
	{
		$price = ($currency !== 'PHP' ? $data['lastPrice'] :
				(price_ask() + price_bid()) / 2) * $fmc_to_usd;
	}

	return $price;
}

/**
 *
 * @return float|int
 *
 * @since version
 */
function price_ask()
{
	$currency = settings_local('ancillaries')->currency;

	$price = $currency === 'PHP' ? 0.012 : 0.00024;

	$data = api_usdt_price_local();

	if (!empty($data))
	{
		$price = ($currency !== 'PHP' ? $data['askPrice'] :
				$data['ask']) * settings_local('trading')->fmc_to_usd;
	}

	return $price;
}

/**
 *
 * @return float|int
 *
 * @since version
 */
function price_bid()
{
	$currency = settings_local('ancillaries')->currency;

	$price = $currency === 'PHP' ? 0.012 : 0.00024;

	$data = api_usdt_price_local();

	if (!empty($data))
	{
		$price = ($currency !== 'PHP' ? $data['bidPrice'] :
				$data['bid']) * settings_local('trading')->fmc_to_usd;
	}

	return $price;
}