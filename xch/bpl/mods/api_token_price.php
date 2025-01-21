<?php

namespace BPL\Mods\API_Token_Price;

require_once 'bpl/mods/file_get_contents_curl.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;

/**
 * @param   string  $token
 *
 * @return array
 *
 * @since version
 */
function main(string $token): array
{
	$data = [];

	// Retrieve the list of supported tokens
	$tokens = list_token();

	if (array_key_exists($token, $tokens)) // Check if the token is in the list
	{
		// Get the CoinGecko ID for the token
		$token_id = $tokens[$token];

		// Check if cached data is available and still valid
		$cachedData = get_cached_price($token);
		if ($cachedData !== null) {
			return $cachedData;
		}

		// If no valid cache, fetch from API
		$url = 'https://api.coingecko.com/api/v3/simple/price?ids=' . $token_id . '&vs_currencies=usd';

		try {
			$json = !in_array('curl', get_loaded_extensions()) || is_localhost() ?
				@file_get_contents($url) : file_get_contents_curl($url);

			$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

			// Adjust data structure to match expected format
			if (isset($data[$token_id]['usd'])) {
				$data = [
					'symbol' => $token,
					'price' => $data[$token_id]['usd']
				];

				// Cache the fetched price
				cache_price($token, $data);
			} else {
				$data = [];
			}
		} catch (Exception $e) {
			// If API fails, try to return cached data
			$cachedData = get_cached_price($token);
			if ($cachedData !== null) {
				return $cachedData;
			}

			// Log the error if no cached data is available
			error_log($e->getMessage());
		}
	}

	return $data;
}

/**
 * Cache the fetched price in a file
 *
 * @param   string  $token
 * @param   array   $data
 *
 * @since version
 */
function cache_price(string $token, array $data): void
{
	$cacheDir = __DIR__ . '/cache';
	if (!is_dir($cacheDir)) {
		mkdir($cacheDir, 0755, true);
	}

	$cacheFile = $cacheDir . '/' . $token . '.json';
	$cacheData = [
		'timestamp' => time(),
		'data' => $data
	];

	file_put_contents($cacheFile, json_encode($cacheData));
}

/**
 * Get cached price if it exists and is still valid
 *
 * @param   string  $token
 *
 * @return array|null
 *
 * @since version
 */
function get_cached_price(string $token): ?array
{
	$cacheFile = __DIR__ . '/cache/' . $token . '.json';

	if (file_exists($cacheFile)) {
		$cacheData = json_decode(file_get_contents($cacheFile), true);

		// Check if the cache is still valid (e.g., within 5 minutes)
		if (isset($cacheData['timestamp']) && (time() - $cacheData['timestamp']) < 300) {
			return $cacheData['data'];
		}
	}

	return null;
}

/**
 *
 * @return string[]
 *
 * @since version
 */
function list_token(): array
{
	// symbol => token_id
	return [
		'USDT' => 'tether',
		'BTC' => 'bitcoin',
		'ETH' => 'ethereum',
		'BNB' => 'binancecoin',
		'LTC' => 'litecoin',
		'ADA' => 'cardano',
		'USDC' => 'usd-coin',
		'LINK' => 'chainlink',
		'DOGE' => 'dogecoin',
		'DAI' => 'dai',
		'BUSD' => 'binance-usd',
		'SHIB' => 'shiba-inu',
		'UNI' => 'uniswap',
		'MATIC' => 'matic-network',
		'DOT' => 'polkadot',
		'TRX' => 'tron',
		'BCH' => 'bitcoin-cash'
	];
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