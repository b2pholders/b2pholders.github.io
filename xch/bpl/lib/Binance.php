<?php

namespace BPL\Lib\Local\CryptoCurrency;

use Exception;

class Binance
{
	/**
	 * @var array
	 * @since version
	 */
	private static array $auth = [];

	/**
	 * @param $key
	 * @param $secret
	 *
	 *
	 * @since version
	 */
	public static function auth($key, $secret): void
	{
		self::$auth['key']    = $key;
		self::$auth['secret'] = $secret;
	}

	/**
	 * Will sign and call specified API method
	 *
	 * @param           $method
	 * @param   array   $params
	 * @param   string  $http_method
	 *
	 * @return array|mixed|string
	 *
	 * @since version
	 */
	public static function call($method, array $params = [], string $http_method = 'GET')
	{
		$host = 'api';

		if (strpos($method, '/dapi') === 0)
		{
			$host = 'dapi';
		}

		if (strpos($method, '/fapi') === 0)
		{
			$host = 'fapi';
		}

		$url = 'https://' . $host . '.binance.com' . $method;

		if (self::signed($method))
		{
			$params['timestamp'] = number_format(
				microtime(true) * 1000, 0, '.', ''
			);

			$query = http_build_query($params);
			$sign  = hash_hmac('sha256', $query, self::$auth['secret']);

			$url .= '?' . $query . '&signature=' . $sign;
		}
		else if ($params)
		{
			$query = http_build_query($params);

			$url .= '?' . $query;
		}

		$opts = [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT        => 5,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_HTTPHEADER     => ['X-MBX-APIKEY: ' . self::$auth['key']]
		];

		if ($http_method !== 'GET')
		{
			$opts[CURLOPT_CUSTOMREQUEST] = $http_method;
		}

		return self::call_http($url, $opts);
	}

	/**
	 * @param $method
	 *
	 * @return bool
	 *
	 * @since version
	 */
	private static function signed($method): bool
	{
		return !(
			(strpos($method, 'ticker/price') !== false) ||
			(strpos($method, '/exchangeInfo') !== false) ||
			(strpos($method, '/depth') !== false)
		);
	}

	/**
	 * @param          $url
	 * @param   array  $options
	 *
	 * @return array|mixed|string
	 *
	 * @since version
	 */
	private static function call_http($url, array $options = [])
	{
		$c = curl_init($url);

		curl_setopt_array($c, $options);

		if ($error = curl_error($c))
		{
			return $error;
		}

		$response = [];

		try
		{
			$response = json_decode(curl_exec($c), 1, 512, JSON_THROW_ON_ERROR);
		}
		catch (Exception $e)
		{

		}

		if (strpos($url, 'order') || strpos($url, 'depth'))
		{
			file_put_contents('/tmp/apiworker', print_r(curl_getinfo($c), 1));
		}

		return $response;
	}
}