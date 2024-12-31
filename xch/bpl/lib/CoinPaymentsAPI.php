<?php

namespace BPL\Lib\Local\CryptoCurrency\API;

/*
	CoinPayments.net API Class - v1.1
	Copyright 2014-2018 CoinPayments.net. All rights reserved.	
	License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

use Exception;

class CoinPaymentsAPI
{
	private string $private_key = '';
	private string $public_key = '';
	private $ch;

	public function Setup($private_key, $public_key): void
	{
		$this->private_key = $private_key;
		$this->public_key  = $public_key;
		$this->ch          = null;
	}

	/**
	 * Gets the current CoinPayments.net exchange rate. Output includes both crypto and fiat currencies.
	 *
	 * @param   bool  $short  If short == TRUE (the default), the output won't include
	 *                        the currency names and confirms needed to save bandwidth.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function GetRates(bool $short = true)
	{
		return $this->api_call('rates', ['short' => $short]);
	}

	/**
	 * Gets your current coin balances (only includes coins with a balance unless all = TRUE).<br />
	 *
	 * @param   false  $all  If all = TRUE then it will return all coins, even those with a 0 balance.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function GetBalances(bool $all = false)
	{
		return $this->api_call('balances', ['all' => $all ? 1 : 0]);
	}

	/**
	 * Creates a basic transaction with minimal parameters.<br />
	 * See CreateTransaction for more advanced features.
	 *
	 * @param   ?double  $amount       The amount of the transaction (floating point to 8 decimals).
	 * @param   ?string  $currency1    The source currency (i.e. USD),
	 *                                 this is used to calculate the exchange rate for you.
	 * @param   ?string  $currency2    The cryptocurrency of the transaction. currency1 and currency2 can
	 *                                 be the same if you don't want any exchange rate conversion.
	 * @param   ?string  $buyer_email  Set the buyer's email, so they can automatically claim
	 *                                 refunds if there is an issue with their payment.
	 * @param   string   $address      Optionally set the payout address of the transaction. If address is empty
	 *                                 then it will follow your payout settings for that coin.
	 * @param   string   $ipn_url      Optionally set an IPN handler to receive notices about this transaction.
	 *                                 If ipn_url is empty then it will use the default IPN URL in your account.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function CreateTransactionSimple(?float  $amount, ?string $currency1, ?string $currency2,
	                                        ?string $buyer_email, string $address = '', string $ipn_url = '')
	{
		$req = [
			'amount'      => $amount,
			'currency1'   => $currency1,
			'currency2'   => $currency2,
			'buyer_email' => $buyer_email,
			'address'     => $address,
			'ipn_url'     => $ipn_url,
		];

		return $this->api_call('create_transaction', $req);
	}

	/**
	 * See https://www.coinpayments.net/apidoc-create-transaction for parameters
	 *
	 * @param $req
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function CreateTransaction($req)
	{
		return $this->api_call('create_transaction', $req);
	}

	/**
	 * Creates an address for receiving payments into your CoinPayments Wallet.<br />
	 *
	 * @param   ?string  $currency  The cryptocurrency to create a receiving address for.
	 * @param   string   $ipn_url   Optionally set an IPN handler to receive notices about this transaction.
	 *                              If ipn_url is empty then it will use the default IPN URL in your account.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function GetCallbackAddress(?string $currency, string $ipn_url = '')
	{
		$req = [
			'currency' => $currency,
			'ipn_url'  => $ipn_url,
		];

		return $this->api_call('get_callback_address', $req);
	}

	/**
	 * Creates a withdrawal from your account to a specified address.<br />
	 *
	 * @param   ?double  $amount        The amount of the transaction (floating point to 8 decimals).
	 * @param   ?string  $currency      The cryptocurrency to withdraw.
	 * @param   ?string  $address       The address to send the coins to.
	 * @param   bool     $auto_confirm  If auto_confirm is TRUE, then the withdrawal will
	 *                                  be performed without an email confirmation.
	 * @param   string   $ipn_url       Optionally set an IPN handler to receive notices about this transaction.
	 *                                  If ipn_url is empty then it will use the default IPN URL in your account.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function CreateWithdrawal(
		?float $amount, ?string $currency, ?string $address, bool $auto_confirm = false, string $ipn_url = '')
	{
		$req = [
			'amount'       => $amount,
			'currency'     => $currency,
			'address'      => $address,
			'auto_confirm' => $auto_confirm ? 1 : 0,
			'ipn_url'      => $ipn_url,
		];

		return $this->api_call('create_withdrawal', $req);
	}

	/**
	 * Creates a transfer from your account to a specified merchant.<br />
	 *
	 * @param   ?double  $amount        The amount of the transaction (floating point to 8 decimals).
	 * @param   ?string  $currency      The cryptocurrency to withdraw.
	 * @param   ?string  $merchant      The merchant ID to send the coins to.
	 * @param   bool     $auto_confirm  If auto_confirm is TRUE, then the transfer will
	 *                                  be performed without an email confirmation.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function CreateTransfer(?float $amount, ?string $currency, ?string $merchant, bool $auto_confirm = false)
	{
		$req = [
			'amount'       => $amount,
			'currency'     => $currency,
			'merchant'     => $merchant,
			'auto_confirm' => $auto_confirm ? 1 : 0,
		];

		return $this->api_call('create_transfer', $req);
	}

	/**
	 * @param   ?double  $amount        The amount of the transaction (floating point to 8 decimals).
	 * @param   ?string  $currency      The cryptocurrency to withdraw.
	 * @param   ?string  $pbntag        The $PayByName tag to send funds to.
	 * @param   bool     $auto_confirm  If auto_confirm is TRUE, then the transfer
	 *                                  will be performed without an email confirmation.
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	public function SendToPayByName(?float $amount, ?string $currency, ?string $pbntag, bool $auto_confirm = false)
	{
		$req = [
			'amount'       => $amount,
			'currency'     => $currency,
			'pbntag'       => $pbntag,
			'auto_confirm' => $auto_confirm ? 1 : 0,
		];

		return $this->api_call('create_transfer', $req);
	}

	/**
	 *
	 * @return bool
	 *
	 * @since version 1.1
	 */
	private function is_setup(): bool
	{
		return (!empty($this->private_key) && !empty($this->public_key));
	}

	/**
	 * @param   bool  $state
	 *
	 * @return bool
	 *
	 * @since version 1.1
	 */
	public function is_local(bool $state = true): bool
	{
		return $state;
	}

	/**
	 * @param          $cmd
	 * @param   array  $req
	 *
	 * @return mixed|string[]
	 *
	 * @since version 1.1
	 */
	private function api_call($cmd, array $req = [])
	{
		if (!$this->is_setup())
		{
			return ['error' => 'You have not called the Setup function with your private and public keys!'];
		}

		// Set the API command and required fields
		$req['version'] = 1;
		$req['cmd']     = $cmd;
		$req['key']     = $this->public_key;
		$req['format']  = 'json'; //supported values are json and xml

		// Generate the query string
		$post_data = http_build_query($req, '', '&');

		// Calculate the HMAC signature on the POST data
		$hmac = hash_hmac('sha512', $post_data, $this->private_key);

		// Create cURL handle and initialize (if needed)
		if ($this->ch === null)
		{
			$this->ch = curl_init('https://www.coinpayments.net/api.php');

			curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, !$this->is_local());
		}

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);

		$data = curl_exec($this->ch);

		if ($data !== false)
		{
			$dec = [];

			if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0)
			{
				try
				{
					// We are on 32-bit PHP, so use the bigint as string option.
					// If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
					$dec = json_decode(
						$data, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
				}
				catch (Exception $e)
				{
				}
			}
			else
			{
				try
				{
					$dec = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
				}
				catch (Exception $e)
				{
				}
			}
			if ($dec !== null && count($dec))
			{
				return $dec;
			}

			// If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
			return ['error' => 'Unable to parse JSON result (' . json_last_error() . ')'];
		}

		return ['error' => 'cURL error: ' . curl_error($this->ch)];
	}
}
