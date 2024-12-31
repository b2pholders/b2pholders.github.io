<?php

namespace BPL\Mods\API_Coin_Price;

require_once 'bpl/mods/file_get_contents_curl.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;

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

	$url = ($currency === 'PHP' ? 'https://quote.coins.ph/v1/markets/BTC-' .
		$currency : 'https://blockchain.info/ticker');

	$data = [];

	try
	{
		$json = !in_array('curl', get_loaded_extensions()) || is_localhost() ?
			@file_get_contents($url) : file_get_contents_curl($url);

		$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
	}
	catch (Exception $e)
	{

	}

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