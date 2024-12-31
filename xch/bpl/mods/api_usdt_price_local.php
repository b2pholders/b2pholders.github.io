<?php

namespace BPL\Mods\Local\API_USDT_Price;

require_once 'file_get_contents_curl.php';
require_once 'api_usdt_price_core.php';
require_once 'helpers_local.php';

//use Exception;

//use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;
use function BPL\Mods\API_USDT_Price\Core\main as core;
use function BPL\Mods\Local\Helpers\settings as settings_local;

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function main()
{
	$currency = settings_local('ancillaries')->currency;

	return core($currency);
}

///**
// * @param $currency
// *
// * @return array|mixed
// *
// * @since version
// */
//function extracted($currency)
//{
//	$symbol = $currency === 'USD' ? 'TUSDUSDT' : 'EURUSDT';
//
//	$url = $currency === 'PHP' ? 'https://quote.coins.ph/v2/markets/USDT-' .
//		$currency : 'https://api.binance.com/api/v3/ticker/24hr?symbol=' . $symbol;
//
//	$data = [];
//
//	try
//	{
//		$json = !in_array('curl', get_loaded_extensions()) || is_localhost() ?
//			@file_get_contents($url) : file_get_contents_curl($url);
//
//		$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
//	}
//	catch (Exception $e)
//	{
////		echo $e->getMessage();
//	}
//
//	return $data;
//}

///**
// * @param   string[]  $whitelist
// *
// * @return bool
// *
// * @since version
// */
//function is_localhost(array $whitelist = ['127.0.0.1', '::1']): bool
//{
//	return in_array($_SERVER['REMOTE_ADDR'], $whitelist, true);
//}