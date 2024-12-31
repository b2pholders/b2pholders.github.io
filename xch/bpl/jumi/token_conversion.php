<?php

namespace BPL\Jumi\Token_Conversion;

require_once 'bpl/mods/account_summary.php';
require_once 'bpl/mods/btc_currency.php';
require_once 'bpl/mods/api_token_price.php';
require_once 'bpl/mods/api_coinbrain_token_price.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\API\Coinbrain\TokenPrice\main as coinbrain_price_token;
use function BPL\Mods\BTC_Currency\main as btc_currency;

use function BPL\Mods\API_Token_Price\main as token_price;
//use function BPL\Mods\API\Coinbrain\TokenPrice\main as coinbrain_btc3;

use function BPL\Mods\Account_Summary\ticker_coin_price;
use function BPL\Mods\Account_Summary\script_coin_price;

use function BPL\Mods\Database\Query\delete;
use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype     = session_get('usertype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$amount       = input_get('amount');
	$method       = input_get('method');
	$cid          = input_get('cid');

	page_validate($usertype, $account_type);

	$str = menu();

	if ($usertype === 'Member' || $usertype === 'Admin')
	{
		$str .= script_trading();
		$str .= header();
//		$str .= '<h1>' . strtoupper(settings('trading')->token_name) . ' Conversion</h1>';

		if ($cid !== '')
		{
			process_delete_request($cid);
		}

		if ($amount !== '')
		{
			process_conversion($user_id, $amount, $method);
		}

		$str .= view_form($user_id);
		$str .= view_pending($user_id);
	}

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function script_trading(): string
{
	$str = '';

	$jquery_number = 'bpl/plugins/jquery.number.js';

	if (settings('plans')->trading)
	{
		$str .= '<script>';

		$str .= script_coin_price();

		$str .= '</script>';
		$str .= '<script src="' . $jquery_number . '"></script>';
	}

	return $str;
}

function header(): string
{
	$str = '<h2>';
	$str .= strtoupper(settings('trading')->token_name) . ' Conversion';
	$str .= ticker_coin_price();
	$str .= '</h2>';

	return $str;
}

/**
 * @param $cid
 *
 *
 * @since version
 */
function process_delete_request($cid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		delete(
			'network_token_convert',
			['convert_id = ' . db()->quote($cid)]
		);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(98),
		'Request deleted successfully!', 'notice');
}

/**
 * @param $user_id
 * @param $amount
 * @param $method
 *
 * @since version
 */
function process_conversion($user_id, $amount, $method)
{
	$db = db();

	validate_input($user_id, $amount, $method);

	$token_name = settings('trading')->token_name;

	$user = user($user_id);

	$btc_price_token = btc_currency(); // usd price of our token
	$total           = $amount * $btc_price_token; // usd price

	$price_method_total = price_token_method($total, $method);
	$cybercharge        = settings('ancillaries')->cybercharge / 100; // percentage
	$processing_fee     = settings('ancillaries')->processing_fee; // usd
	$fee_method_price   = price_token_method($processing_fee, $method)/*$processing_fee*/
	;
	$tax                = $price_method_total * $cybercharge;
	$deductions         = $tax + $fee_method_price; // quoted by method

	$arr_payment_method = arr_payment_method($user);

	$payment_method = '';
	$payout_address = '';

	if (!is_array($arr_payment_method[$method]))
	{
		$payment_method = strtoupper($method);
		$payout_address = $arr_payment_method[$method] ?? '';
	}
	else
	{
		foreach ($arr_payment_method[$method] as $k => $v)
		{
			$payment_method = strtoupper($k);
			$payout_address = $v;

			break;
		}
	}

	$currency = in_array($method, ['bank', 'gcash']) ? 'PHP' : strtoupper($method);

	// mail admin and user
	$message = 'Username: ' . $user->username . '<br>
			Full Name: ' . $user->fullname . '<br>
			Email: ' . $user->email . '<br>
			Contact Number: ' . $user->contact . '<br><br>' .
		strtoupper($token_name) . ' Balance: ' . $user->balance_fmc . ' ' . strtoupper($token_name) . '<br>' .
		'Amount: ' . $amount . ' ' .
		'Final Value: ' .
		$price_method_total . ' ' . $currency . '<br>
			Method: ' . strtoupper($payment_method) . ': ' . $payout_address;

	try
	{
		$db->transactionStart();

		insert_token_convert($user_id, $amount, $method, $price_method_total, $deductions);

		send_mail($message, strtoupper($token_name) . ' Conversion', [$user->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(98),
		'Conversion successful!<br>Conversion processing time: 48 hours.', 'success');

//	send_mail($user_id, $amount_final_btc);
}

/**
 * @param $usertype
 * @param $account_type
 *
 *
 * @since version
 */
function page_validate($usertype, $account_type)
{
	if ($account_type === 'starter' || $usertype === '' || !settings('plans')->trading)
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_token_convert($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_token_convert ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' AND date_completed = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $user_id
 * @param $amount
 *
 * @param $method
 *
 * @since version
 */
function validate_input($user_id, $amount, $method)
{
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;
	$fmc_to_usd = $settings_trading->fmc_to_usd; // btc value per token

	$cybercharge    = $settings_ancillaries->cybercharge / 100;
	$processing_fee = $settings_ancillaries->processing_fee;

	$user = user($user_id);

	$account_type = $user->account_type;

	$minimum_bal_usd = $settings_ancillaries->{$account_type . '_min_bal_usd'};
	$minimum_bal_fmc = $settings_ancillaries->{$account_type . '_min_bal_fmc'};

	$btc_currency = btc_currency();

	// token unit
	$token_min_withdraw = $settings_ancillaries->{$account_type . '_min_convert_fmc'};

	$app = application();

	if ($method === 'none')
	{
		$err = 'Select any method!';

		$app->redirect(Uri::root(true) . '/' . sef(98), $err, 'error');
	}

	if ($amount === '')
	{
		$err = 'Enter any amount!';

		$app->redirect(Uri::root(true) . '/' . sef(98), $err, 'error');
	}

	if ($amount < $token_min_withdraw)
	{
		$err = 'Minimum conversion allowed is ' . number_format($token_min_withdraw, 8) . ' ' .
			strtoupper($token_name) . '.';

		$app->redirect(Uri::root(true) . '/' . sef(98), $err, 'error');
	}

	if ($user->payout_transfer < ($minimum_bal_usd +
			$amount * $btc_currency * $fmc_to_usd * $cybercharge + $processing_fee))
	{
		$err = 'Maintain at least ' . number_format(($amount * $btc_currency * $fmc_to_usd * $cybercharge +
					$processing_fee + $minimum_bal_usd) . ' ' . $settings_ancillaries->currency, 2) . '!';

		$app->redirect(Uri::root(true) . '/' . sef(98), $err, 'error');
	}

	if ($user->balance_fmc < ($minimum_bal_fmc + $amount))
	{
		$err = 'Maintain at least ' . number_format(($amount + $minimum_bal_fmc) . ' ' .
				strtoupper($token_name), 8) . '!';

		$app->redirect(Uri::root(true) . '/' . sef(98), $err, 'error');
	}

	// check if total pending exceeds balance
	$total_request = 0;

	$result = user_token_convert($user_id);

	foreach ($result as $tmp)
	{
		$total_request += $tmp->amount;
	}

	if (($total_request + $amount) > $user->balance_fmc)
	{
		$err = 'Conversion denied!<br> Total conversion amount exceeds' .
			$settings_trading->token_name . ' balance.';

		$app->redirect(Uri::root(true) . '/' . sef(98), $err, 'error');
	}
}

/**
 * @param $user_id
 * @param $amount
 * @param $method
 * @param $amount_final_btc
 * @param $total_deductions
 *
 *
 * @since version
 */
function insert_token_convert($user_id, $amount, $method, $amount_final_btc, $total_deductions)
{
	$db = db();

	insert(
		'network_token_convert',
		[
			'user_id',
			'amount',
			'amount_final',
			'deduction_total',
			'method',
			'date_converted'
		],
		[
			$db->quote($user_id),
			$db->quote($amount),
			$db->quote($amount_final_btc),
			$db->quote($total_deductions),
			$db->quote($method),
			$db->quote(time())
		]
	);
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function price_token_method($value, $method)
{
	if (in_array($method, ['bank', 'gcash']))
	{
		$php_price_usd = php_price_usd();

		$price_php = 0;

		if ($php_price_usd)
		{
			$ask = $php_price_usd['market']['ask'];
			$bid = $php_price_usd['market']['bid'];

			$price_php = ($ask + $bid) / 2;
		}

		$price_total = $value * $price_php; // PHP
	}
	else
    {
        $currency = strtoupper($method);

        if (in_array($currency, ['BTC', 'BTC3', 'BTCB', 'BTCW', 'GOLD', 'PAC', 'P2P']))
        {
            $price_total = $value / price_coinbrain($currency);
        }
        else
        {
            $price_method = token_price($currency)['price'];
            $price_base   = token_price('USDT')['price'];

            $price_total = ($price_base / $price_method) * $value;
        }
    }

	return $price_total;
}

function price_coinbrain($token = 'BTC3')
{
    switch ($token)
    {
        case 'BTC':
            $contract = '0xac642e017764c4759efeb1c9ea0782cf5d1a81d1';
            break;
        case 'BTC3':
            $contract = '0xbea17f143f2535f424c9d7acd5fbff75a9c8ab62';
            break;
        case 'BTCB':
            $contract = '0x7130d2A12B9BCbFAe4f2634d864A1Ee1Ce3Ead9c';
            break;
        case 'BTCW':
            $contract = '0xfc4f8cDC508077e7a60942e812A9C9f1f05020c5';
            break;
        case 'GOLD':
            $contract = '0x4A0bfC65fEb6F477E3944906Fb09652d2d8b5f0d';
            break;
        case 'PAC':
            $contract = '0x565C9e3A95E9d3Df4afa4023204F758C27E38E6a';
            break;
        case 'P2P':
            $contract = '0x07A9e44534BabeBBd25d2825C9465b0a82f26813';
            break;
        default:
            $contract = '0xac642e017764c4759efeb1c9ea0782cf5d1a81d1';
    }

    $data = [
        56 => [$contract]
    ];

    $price = settings('ancillaries')->currency === 'PHP' ? 0.00012 : 0.0000024;

    $results = json_decode(
        coinbrain_price_token('https://api.coinbrain.com/public/coin-info', $data)
    );

    if (!empty($results))
    {
        $results = (array) $results[0];
        $price   = $results['priceUsd'];
    }

    return $price;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function php_price_usd()
{
	$url = 'https://quote.coins.ph/v1/markets/USD-PHP';

	$data = [];

	try
	{
		$json = @file_get_contents($url);

		$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
	}
	catch (Exception $e)
	{

	}

	return $data;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_method_select($user_id): string
{
	$user = user($user_id);

	$pmu = arr_payment_method($user);

	$str = '<select name="method" id="method" style="float:left">';
	$str .= '<option value="none" selected>Select Payout Method</option>';

	if (!empty($pmu))
	{
		foreach ($pmu as $k => $v)
		{
			$str .= '<option value="' . $k . '">' . strtoupper($k) . '</option>';
		}
	}

	$str .= '</select>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$token_name = $settings_trading->token_name;

	$processing_fee = $settings_ancillaries->processing_fee;

	$user = user($user_id);

	// token unit
	$token_min_withdraw = $settings_ancillaries->{$user->account_type . '_min_convert_fmc'};

	$str = $settings_ancillaries->cybercharge && $processing_fee ? '<p>Conversions are subject to ' : '';
	$str .= $settings_ancillaries->cybercharge ? $settings_ancillaries->cybercharge . '% cybercharge + ' : '';
	$str .= $processing_fee ? number_format($processing_fee, 2) . ' ' . 'processing fee per transaction. ' : '';
	$str .= $token_min_withdraw ? 'Minimum conversion is ' .
		number_format($token_min_withdraw, 8) . ' ' . strtoupper($token_name) . '.</p>' : '';

	$str .= '<form method="post" onsubmit="submit.disabled = true; return true;">';
	$str .= '<table class="category table table-striped table-bordered table-hover">';

	$str .= '<tr>';
	$str .= '<td colspan="2">';
	$str .= '<span style="float: left"><strong>Balance: </strong>' . number_format($user->balance_fmc, 8) .
		' ' . strtoupper($token_name) . '</span>';
	$str .= '<span style="float: right"><strong>' . $settings_ancillaries->efund_name . ' Balance:</strong> ' .
		number_format($user->payout_transfer, 2) . '</span>';
	$str .= '</td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td colspan="2">';
	$str .= '<div class="uk-grid"><div class="uk-width-1-1" data-uk-margin="">';
	$str .= '<button class="uk-button" style = "float:left"><strong>Convert ' .
		strtoupper($token_name) . ':</strong></button>';
	$str .= '<input type="text" name="amount" placeholder="Amount" id="amount" style = "float:left">';
	$str .= view_method_select($user_id);
	$str .= '<input type="submit" name="submit" value="Submit" class="uk-button uk-button-primary">';
	$str .= '</div>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '</table>
    </form>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function token_convert_pending($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_token_convert ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' AND date_completed = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_pending($user_id): string
{
	$token_name = settings('trading')->token_name;

	$str = '<hr>';
	$str .= '<h2>Pending ' . strtoupper($token_name) . ' Conversions</h2>';

	$pending = token_convert_pending($user_id);

	if (empty($pending))
	{
		$str .= '<hr><p>No pending ' . strtoupper($token_name) . ' conversions yet.</p>';
	}
	else
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Date Requested</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>Charges</th>';
		$str .= '<th>Final</th>';
		$str .= '<th>Method</th>';
		$str .= '<th>Action</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody style="font-size: small">';

		foreach ($pending as $tmp)
		{
			$user = user($tmp->user_id);

			$arr_payment_method = arr_payment_method($user);
			$payout_address     = $arr_payment_method[$tmp->method] ?? '';

			$payment_method = strtoupper($tmp->method);

			if (is_array($arr_payment_method[$tmp->method]))
			{
				foreach ($arr_payment_method[$tmp->method] as $k => $v)
				{
					$payment_method = strtoupper($k);
					$payout_address = $v;

					break;
				}
			}

			$currency = in_array($tmp->method, ['bank', 'gcash']) ? 'PHP' : strtoupper($tmp->method);

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $tmp->date_converted) . '</td>';
			$str .= '<td>' . number_format($tmp->amount, 8) . ' ' . strtoupper($token_name) . '</td>';
			$str .= '<td>' . number_format($tmp->deduction_total, 8) . ' ' . $currency . '</td>';
			$str .= '<td>' . number_format($tmp->amount_final, 8) . ' ' . $currency . '</td>';
			$str .= '<td>' . strtoupper($payment_method) . ': ' . $payout_address . '</td>';

			$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="Cancel" 
				data-uk-modal="{target:\'#modal-cancel-' . $tmp->convert_id . '\'}"></td>';

			$str .= '<div id="modal-cancel-' . $tmp->convert_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
			$str .= '<p><strong>Are you sure, you want to cancel this conversion?</strong></p>';
			$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <h3 class="uk-panel-title"><strong>Date Requested:</strong> ' .
				date('M j, Y - g:i A', $tmp->date_converted) . '</h3>
                        <h3 class="uk-panel-title"><strong>Amount:</strong> ' .
				number_format($tmp->amount, 2) . ' ' . strtoupper($token_name) . '</h3>
                        <h3 class="uk-panel-title"><strong>Final: </strong> ' .
				number_format($tmp->amount_final, 2) . ' ' . $currency . '</h3>                        
                    </div>';
			$str .= '<div class="uk-modal-footer" style="text-align: right">
						<input type="button" class="uk-modal-close uk-button uk-button-primary" value="Close">
						<a href="' . sef(98) . qs() . 'cid=' . $tmp->convert_id . '" 
							type="button" class="uk-button uk-button-primary">Confirm</a>
					</div>';
			$str .= '</div>
		        </div>';

			$str .= '</tr>';
		}

		$str .= '</tbody>';
		$str .= '</table>';
	}

	return $str;
}

///**
// *
// * @return mixed
// *
// * @since version
// */
//function price_btc3()
//{
//	$url = 'https://api.coinbrain.com/public/coin-info';
//
//	$data = [
//		56 => ['0xac642e017764c4759efeb1c9ea0782cf5d1a81d1']
//	];
//
//	$results = json_decode(coinbrain_btc3($url, $data));
//	$results = (array) $results[0];
//
//	return $results['priceUsd'];
//}