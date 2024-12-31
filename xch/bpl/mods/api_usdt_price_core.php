<?php

namespace BPL\Mods\API_USDT_Price\Core;

//require_once 'file_get_contents_curl.php';

use Exception;
use RuntimeException;

//use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;

/**
 * @param $currency
 *
 * @return array|mixed
 *
 * @since version
 */
function main($currency)
{
	try
	{
		if ($currency === 'PHP')
		{
			// Use CoinGecko API for PHP currency (USDT to PHP conversion)
			$url  = 'https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=php';
			$json = is_localhost() ? @file_get_contents($url) : file_get_contents_curl($url);
			$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
		}
		elseif (in_array($currency, ['B2P', 'AET', 'TPAY', 'PESO']))
		{
			// Use CoinBrain API for specific tokens
			$contracts = [
				'B2P'  => '0xF8AB9fF465C612D5bE6A56716AdF95c52f8Bc72d',
				'AET'  => '0xbc26fCCe32AeE5b0D470Ca993fb54aB7Ab173a1E',
				'TPAY' => '0xd405200D9c8F8Be88732e8c821341B3AeD6724b7',
				'PESO' => '0xBdFfE2Cd5B9B4D93B3ec462e3FE95BE63efa8BC0'
			];

			$contract = $contracts[$currency] ?? null;

			if ($contract)
			{
				$url         = 'https://api.coinbrain.com/public/coin-info';
				$requestData = [56 => [$contract]];  // Chain ID 56 corresponds to BSC (Binance Smart Chain)

				$json = is_localhost() ? @file_get_contents($url) : file_get_contents_curl($url, json_encode($requestData));
				$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
			}
			else
			{
				throw new RuntimeException('Invalid contract address.');
			}
		}
		else
		{
			// Use CoinGecko API for other tokens
			$tokens = [
				'USD' => 'tether',  // Assume 'USD' maps to 'tether'
				'EUR' => 'euro'
				// Add other currency mappings if necessary
			];

			$tokenId = $tokens[$currency] ?? null;

			if ($tokenId)
			{
				$url  = "https://api.coingecko.com/api/v3/simple/price?ids={$tokenId}&vs_currencies=usd";
				$json = is_localhost() ? @file_get_contents($url) : file_get_contents_curl($url);
				$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
			}
			else
			{
				throw new RuntimeException('Unsupported currency.');
			}
		}
	}
	catch (Exception $e)
	{
		// Handle exception and maybe log it
		error_log($e->getMessage());
		$data = []; // Return empty array in case of failure
	}

	return $data;
}

function file_get_contents_curl($url, $postFields = null)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	if ($postFields !== null)
	{
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json'
		]);
	}

	$data = curl_exec($ch);

	if (curl_errno($ch))
	{
		throw new RuntimeException(curl_error($ch));
	}

	curl_close($ch);

	return $data;
}

/**
 * @param   string[]  $whitelist
 *
 * @return bool
 *
 * @since version
 */
function is_localhost(array $whitelist = ['127.0.0.1', '::1']): bool
{
	return in_array($_SERVER['REMOTE_ADDR'], $whitelist, true);
}