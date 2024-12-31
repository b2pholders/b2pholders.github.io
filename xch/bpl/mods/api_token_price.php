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
		$url      = 'https://api.coingecko.com/api/v3/simple/price?ids=' . $token_id . '&vs_currencies=usd';

		try
		{
			$json = !in_array('curl', get_loaded_extensions()) || is_localhost() ?
				@file_get_contents($url) : file_get_contents_curl($url);

			$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

			// Adjust data structure to match expected format
			if (isset($data[$token_id]['usd']))
			{
				$data = [
					'symbol' => $token,
					'price'  => $data[$token_id]['usd']
				];
			}
			else
			{
				$data = [];
			}
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}

	return $data;
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
		'USDT'  => 'tether',
		'BTC'   => 'bitcoin',
		'ETH'   => 'ethereum',
		'BNB'   => 'binancecoin',
		'LTC'   => 'litecoin',
		'ADA'   => 'cardano',
		'USDC'  => 'usd-coin',
		'LINK'  => 'chainlink',
		'DOGE'  => 'dogecoin',
		'DAI'   => 'dai',
		'BUSD'  => 'binance-usd',
		'SHIB'  => 'shiba-inu',
		'UNI'   => 'uniswap',
		'MATIC' => 'polygon',
		'DOT'   => 'polkadot',
		'TRX'   => 'tron',
		'SOL'   => 'solana',
		'XRP'   => 'ripple',
		'TON'   => 'the-open-network',
		'BCH'   => 'bitcoin-cash'
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