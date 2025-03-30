<?php

namespace BPL\Mods\API_Token_Price;

require_once 'bpl/mods/file_get_contents_curl.php';
require_once 'bpl/mods/api_coinbrain_token_price.php';

use Exception;
use RuntimeException;

use function BPL\Mods\File_Get_Contents_Curl\main as file_get_contents_curl;
use function BPL\Mods\API\Coinbrain\TokenPrice\main as coinbrain_price_token;

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
	private const COINBRAIN_API_URL = 'https://api.coinbrain.com/public/coin-info';
	private const FALLBACK_DURATION = 3600; // 1 hour for fallback cached prices

	private string $cacheDir;
	private array $tokens;
	private array $coinbrainTokens;

	public function __construct()
	{
		$this->cacheDir = __DIR__ . '/cache';
		$this->ensureCacheDirectory();
		$this->tokens = $this->getTokenList();
		$this->coinbrainTokens = $this->getCoinbrainTokenList();
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
		// First check if it's a Coinbrain token
		if (array_key_exists($token, $this->coinbrainTokens)) {
			try {
				// Try cache first
				$cachedData = $this->getCachedPrice($token, false, 'coinbrain');
				if ($cachedData !== null) {
					return $cachedData;
				}

				return $this->fetchFreshCoinbrainPrice($token);
			} catch (Exception $e) {
				error_log("Error fetching Coinbrain price for $token: " . $e->getMessage());

				// Fall back to cached data even if expired
				$cachedData = $this->getCachedPrice($token, true, 'coinbrain');
				if ($cachedData !== null) {
					return $cachedData;
				}

				return [];
			}
		}

		// Otherwise use CoinGecko
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
	 * Fetch fresh price data from CoinGecko API with retry mechanism
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
	 * Fetch fresh price data from Coinbrain API with retry mechanism
	 */
	private function fetchFreshCoinbrainPrice(string $token): array
	{
		$contract = $this->coinbrainTokens[$token];

		$data = [
			56 => [$contract]
		];

		$attempts = 0;
		$lastError = null;

		while ($attempts < self::MAX_RETRIES) {
			try {
				$response = coinbrain_price_token(self::COINBRAIN_API_URL, $data);

				if (empty($response)) {
					throw new RuntimeException("Empty Coinbrain response received");
				}

				$results = json_decode($response, true);

				$results = (array) $results[0];
				$price = $results['priceUsd'];

				if (empty($results) || !isset($price)) {
					throw new RuntimeException("Invalid Coinbrain response format");
				}

				$priceData = [
					'symbol' => $token,
					'price' => $price
				];

				$this->cachePrice($token, $priceData, 'coinbrain');
				return $priceData;

			} catch (Exception $e) {
				$lastError = $e;
				$attempts++;
				if ($attempts < self::MAX_RETRIES) {
					sleep(1); // Wait before retry
				}
			}
		}

		// Log the last error
		if ($lastError !== null) {
			error_log("Failed to fetch Coinbrain price for {$token} after {$attempts} attempts: " . $lastError->getMessage());
		}

		// Get last cached price regardless of expiration
		$lastCachedData = $this->getLastCachedPrice($token, 'coinbrain');

		if ($lastCachedData !== null) {
			// Re-cache the last known price with extended duration to prevent frequent retries
			$this->cachePrice($token, $lastCachedData, 'coinbrain', self::FALLBACK_DURATION);
			return $lastCachedData;
		}

		// If we don't have any cached data at all, create a minimal response
		$priceData = [
			'symbol' => $token,
			'price' => 0
		];

		$this->cachePrice($token, $priceData, 'coinbrain', 60); // Short cache for complete fallback
		return $priceData;
	}

	/**
	 * Get the last cached price regardless of expiration
	 * Will search for any cache file for this token
	 */
	private function getLastCachedPrice(string $token, string $source = 'coingecko'): ?array
	{
		$cacheFile = $this->cacheDir . '/' . $source . '_' . $token . '.json';

		if (!file_exists($cacheFile)) {
			return null;
		}

		try {
			$cacheData = json_decode(file_get_contents($cacheFile), true, 512, JSON_THROW_ON_ERROR);

			if (!isset($cacheData['data']) || !is_array($cacheData['data'])) {
				return null;
			}

			return $cacheData['data'];
		} catch (Exception $e) {
			error_log("Error reading last cached price for $token: " . $e->getMessage());
			return null;
		}
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
	private function getCachedPrice(string $token, bool $acceptExpired = false, string $source = 'coingecko'): ?array
	{
		$cacheFile = $this->cacheDir . '/' . $source . '_' . $token . '.json';

		if (!file_exists($cacheFile)) {
			return null;
		}

		try {
			$cacheData = json_decode(file_get_contents($cacheFile), true, 512, JSON_THROW_ON_ERROR);

			if (!isset($cacheData['timestamp'], $cacheData['data'])) {
				return null;
			}

			$age = time() - $cacheData['timestamp'];
			$duration = $cacheData['duration'] ?? self::CACHE_DURATION;

			if ($acceptExpired || $age < $duration) {
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
	private function cachePrice(string $token, array $data, string $source = 'coingecko', ?int $duration = null): void
	{
		$cacheFile = $this->cacheDir . '/' . $source . '_' . $token . '.json';
		$cacheData = [
			'timestamp' => time(),
			'duration' => $duration ?? self::CACHE_DURATION,
			'data' => $data
		];

		if (file_put_contents($cacheFile, json_encode($cacheData)) === false) {
			throw new RuntimeException("Failed to write cache file");
		}
	}

	/**
	 * Get list of supported tokens for CoinGecko API
	 */
	private function getTokenList(): array
	{
		return [
			'USDT' => 'tether',
			'USDT_TRC20' => 'tether', // Added USDT (TRC20)
			'USDT_BEP20' => 'tether', // Added USDT (BEP20)
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
			'TWT' => 'trust-wallet-token',
			'TON' => 'the-open-network',
			'XRP' => 'ripple'
		];
	}

	/**
	 * Get list of supported tokens for Coinbrain API
	 */
	private function getCoinbrainTokenList(): array
	{
		return [
			'B2P' => '0xF8AB9fF465C612D5bE6A56716AdF95c52f8Bc72d',
			'BTCB' => '0x7130d2A12B9BCbFAe4f2634d864A1Ee1Ce3Ead9c',
			'BTCW' => '0xfc4f8cDC508077e7a60942e812A9C9f1f05020c5',
			'GOLD' => '0x4A0bfC65fEb6F477E3944906Fb09652d2d8b5f0d',
			'PAC' => '0x565C9e3A95E9d3Df4afa4023204F758C27E38E6a',
			'P2P' => '0x07A9e44534BabeBBd25d2825C9465b0a82f26813',
			'PESO' => '0xBdFfE2Cd5B9B4D93B3ec462e3FE95BE63efa8BC0',
			'AET' => '0xbc26fCCe32AeE5b0D470Ca993fb54aB7Ab173a1E',
			'TPAY' => '0xd405200D9c8F8Be88732e8c821341B3AeD6724b7'
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