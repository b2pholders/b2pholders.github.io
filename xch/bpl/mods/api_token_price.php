<?php

namespace BPL\Mods\API_Token_Price;

require_once 'bpl/mods/file_get_contents_curl.php';
require_once 'bpl/mods/helpers.php';

use Exception;
use RuntimeException;

use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;

/**
 * Check if the current request is from localhost
 * 
 * @param string[] $whitelist Array of IP addresses considered as localhost
 * @return bool
 */
function is_localhost(array $whitelist = ['127.0.0.1', '::1']): bool
{
	return in_array($_SERVER['REMOTE_ADDR'] ?? '', $whitelist, true);
}

class TokenPriceAPI
{
	private const CACHE_DURATION = 300; // 5 minutes in seconds
	private const API_TIMEOUT = 10; // seconds
	private const MAX_RETRIES = 3;
	private string $cacheDir;
	private array $tokens;

	public function __construct()
	{
		$this->cacheDir = __DIR__ . '/cache';
		$this->ensureCacheDirectory();
		$this->tokens = $this->getTokenList();
	}

	/**
	 * Get token price with improved error handling and retries
	 * 
	 * @param string $token Token symbol
	 * @return array Price data or empty array on failure
	 * @throws RuntimeException When critical errors occur
	 */
	public function getTokenPrice(string $token): array
	{
		if (!array_key_exists($token, $this->tokens)) {
			return [];
		}

		try {
			// Try cache first
			$cachedData = $this->getCachedPrice($token);
			if ($cachedData !== null) {
				return $cachedData;
			}

			return $this->fetchFreshPrice($token);
		} catch (Exception $e) {
			error_log("Error fetching price for $token: " . $e->getMessage());

			// Fall back to cached data even if expired
			$cachedData = $this->getCachedPrice($token, true);
			if ($cachedData !== null) {
				return $cachedData;
			}

			return [];
		}
	}

	/**
	 * Fetch fresh price data from API with retry mechanism
	 */
	private function fetchFreshPrice(string $token): array
	{
		$tokenId = $this->tokens[$token];
		$url = "https://api.coingecko.com/api/v3/simple/price?ids={$tokenId}&vs_currencies=usd";

		$attempts = 0;
		$lastError = null;

		while ($attempts < self::MAX_RETRIES) {
			try {
				$response = $this->makeRequest($url);

				if (empty($response)) {
					throw new RuntimeException("Empty response received");
				}

				$data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

				if (!isset($data[$tokenId]['usd'])) {
					throw new RuntimeException("Invalid response format");
				}

				$priceData = [
					'symbol' => $token,
					'price' => $data[$tokenId]['usd']
				];

				$this->cachePrice($token, $priceData);
				return $priceData;

			} catch (Exception $e) {
				$lastError = $e;
				$attempts++;
				if ($attempts < self::MAX_RETRIES) {
					sleep(1); // Wait before retry
				}
			}
		}

		throw new RuntimeException(
			"Failed to fetch price after {$attempts} attempts: " . $lastError->getMessage()
		);
	}

	/**
	 * Make HTTP request with proper configuration
	 */
	private function makeRequest(string $url): string
	{
		$ctx = stream_context_create([
			'http' => [
				'timeout' => self::API_TIMEOUT,
				'ignore_errors' => true,
				'header' => [
					'User-Agent: PHP/TokenPriceAPI',
					'Accept: application/json'
				]
			],
			'ssl' => [
				'verify_peer' => true,
				'verify_peer_name' => true
			]
		]);

		if (!in_array('curl', get_loaded_extensions()) || is_localhost()) {
			$response = @file_get_contents($url, false, $ctx);
		} else {
			$response = file_get_contents_curl($url);
		}

		if ($response === false) {
			throw new RuntimeException("Failed to fetch URL: $url");
		}

		return $response;
	}

	/**
	 * Get cached price with optional expired cache acceptance
	 */
	private function getCachedPrice(string $token, bool $acceptExpired = false): ?array
	{
		$cacheFile = $this->cacheDir . '/' . $token . '.json';

		if (!file_exists($cacheFile)) {
			return null;
		}

		try {
			$cacheData = json_decode(file_get_contents($cacheFile), true, 512, JSON_THROW_ON_ERROR);

			if (!isset($cacheData['timestamp'], $cacheData['data'])) {
				return null;
			}

			$age = time() - $cacheData['timestamp'];

			if ($acceptExpired || $age < self::CACHE_DURATION) {
				return $cacheData['data'];
			}
		} catch (Exception $e) {
			error_log("Cache read error for $token: " . $e->getMessage());
		}

		return null;
	}

	/**
	 * Ensure cache directory exists and is writable
	 */
	private function ensureCacheDirectory(): void
	{
		if (!is_dir($this->cacheDir)) {
			if (!mkdir($this->cacheDir, 0755, true)) {
				throw new RuntimeException("Failed to create cache directory");
			}
		}

		if (!is_writable($this->cacheDir)) {
			throw new RuntimeException("Cache directory is not writable");
		}
	}

	/**
	 * Cache price data
	 */
	private function cachePrice(string $token, array $data): void
	{
		$cacheFile = $this->cacheDir . '/' . $token . '.json';
		$cacheData = [
			'timestamp' => time(),
			'data' => $data
		];

		if (file_put_contents($cacheFile, json_encode($cacheData)) === false) {
			throw new RuntimeException("Failed to write cache file");
		}
	}

	/**
	 * Get list of supported tokens
	 */
	private function getTokenList(): array
	{
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
			'BCH' => 'bitcoin-cash',
			'TWT' => 'trust-wallet-token', // Added TWT
			'TON' => 'the-open-network',   // Added TON
			'XRP' => 'ripple'              // Added XRP
		];
	}
}

// Example usage:
function main(string $token): array
{
	try {
		$api = new TokenPriceAPI();
		return $api->getTokenPrice($token);
	} catch (Exception $e) {
		error_log("Critical error in token price API: " . $e->getMessage());
		return [];
	}
}