<?php

namespace BPL\Mods\API_USDT_Price;

require_once 'bpl/mods/file_get_contents_curl.php';
require_once 'bpl/mods/api_usdt_price_core.php';
require_once 'bpl/mods/helpers.php';

//use Exception;

//use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;
use function BPL\Mods\API_USDT_Price\Core\main as core;
use function BPL\Mods\Helpers\settings;

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function main()
{
	$currency = settings('ancillaries')->currency;

	$data = core($currency);

	if (!empty($data))
	{
		if ($currency === 'PHP')
		{
			return $data['tether']['php'] ?? 0;
		}

		if (in_array($currency, ['B2P', 'AET', 'TPAY', 'PESO']))
		{
			// Assuming CoinBrain API returns prices under a key like 'priceUsd'
			return $data[0]['priceUsd'] ?? 0;
		}

		// Handle other tokens using CoinGecko
		return $data['tether']['usd'] ?? 0;
	}

	return 0;
}

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