<?php

namespace BPL\Jumi\Request_Share_Fund;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/btc_currency.php';
require_once 'bpl/mods/api_token_price.php';
require_once 'bpl/mods/api_coinbrain_token_price.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\delete;
use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Mailer\main as send_mail;

//use function BPL\Mods\BTC_Currency\main as btc_currency;
use function BPL\Mods\API_Token_Price\main as token_price;
use function BPL\Mods\API\Coinbrain\TokenPrice\main as coinbrain_price_token;

use function BPL\Mods\Url_SEF\sef;
use function bpl\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\time;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$username     = session_get('username');
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$amount       = input_get('amount');
	$method       = input_get('method');
	$cid          = input_get('cid');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$app = application();

	$user = user($user_id);

	$arr_payment_method = arr_payment_method($user);

	$sa = settings('ancillaries');

	$currency = $sa->currency;

//	$currency_upper = settings('ancillaries')->currency;
//	$currency_lower = strtolower(settings('ancillaries')->currency);

	if (empty($arr_payment_method))
	{
		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Fill Up Your Payment Method.', 'error');
	}

	if ($currency === 'PHP')
	{
		if (!array_key_exists('gcash', $arr_payment_method) && !array_key_exists('bank', $arr_payment_method))
		{
			$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
				'Please Fill Up Your G-Cash or Bank Details.', 'error');
		}
	}

	if ($currency === 'USD' && !array_key_exists('bank', $arr_payment_method))
	{
		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Fill Up Your Bank Details.', 'error');
	}

	if (!in_array($currency, ['PHP', 'USD']))
	{
		if (!array_key_exists(strtolower($currency), $arr_payment_method))
		{
			$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
				'Please Fill Up Your ' . $currency . ' Payment Method.', 'error');
		}
	}

//	if (empty($arr_payment_method) || !array_key_exists($currency_lower, $arr_payment_method))
//	{
//		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
//			'Required to fill up your ' . $currency_upper . ' Token', 'error');
//	}

	if ($user->account_type !== 'starter')
	{
		$max_request = settings('ancillaries')->{$user->account_type . '_max_request_usd'};

		if ($max_request > 0 && ((double) $user->requested_today + (double) $amount) > $max_request)
		{
			$app->redirect(Uri::root(true) . '/' . sef(135) . qs() . 'uid=' . $user_id,
				'Exceeded Maximum Request for today!', 'error');
		}
	}

	if ($cid !== '')
	{
		process_delete_request($cid);
	}

	if ($amount !== '')
	{
		process_request($user_id, $amount, $method);
	}

	$str .= view_form($user_id);
	$str .= view_pending_requests();

	echo $str;
}

function process_delete_request($cid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		delete(
			'network_share_fund_request',
			['request_id = ' . db()->quote($cid)]
		);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(135),
		'Request Cancelled!', 'notice');
}

/**
 *
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $user_id): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
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
	$app = application();

	$sa = settings('ancillaries');

	$user = user($user_id);

	$account_type = $user->account_type;

	$minimum_request = $sa->{$account_type . '_min_request_usd'};

	$arr_payment_method = arr_payment_method($user);

	if (empty($arr_payment_method) || empty($arr_payment_method[$method]))
	{
		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Your Wallet Address for ' . strtoupper($method) . ' is Required.', 'error');
	}

	if ($method === 'none')
	{
		application()->redirect(Uri::root(true) . '/' . sef(135),
			'Please Select Payment Method!', 'error');
	}

	if ($amount <= 0)
	{
		application()->redirect(Uri::root(true) . '/' . sef(135),
			'Please enter valid amount!', 'error');
	}

	if ($amount < $minimum_request)
	{
		application()->redirect(Uri::root(true) . '/' . sef(135),
			'Minimum Amount is ' . $minimum_request . '.', 'error');
	}
}

/**
 * @param $user_id
 * @param $amount
 * @param $price
 * @param $method
 *
 * @return false|mixed
 * @since version
 */
function insert_request($user_id, $amount, $price, $method)
{
	$db = db();

	return insert(
		'network_share_fund_request',
		[
			'user_id',
			'amount',
			'price',
			'method',
			'date_requested'
		],
		[
			$db->quote($user_id),
			$db->quote($amount),
			$db->quote($price),
			$db->quote($method),
			$db->quote(time())
		]
	);
}

///**
// * @param $user
// *
// * @return array
// *
// * @since version
// */
//function payout_method($user): array
//{
//	return explode('|', $user->bank);
//}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function php_price_usd()
{
	$url = 'https://quote.coins.ph/v1/markets/USD-PHP';

	$data = [];

	try
	{
		$json = /*!in_array('curl', get_loaded_extensions()) || is_localhost() ?
			*/
			@file_get_contents($url)/* : file_get_contents_curl($url)*/
		;

		$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
	}
	catch (Exception $e)
	{

	}

	return $data;
}

function price_token_method($value, $method)
{
	$currency = settings('ancillaries')->currency;

	$token_price = token_price($currency)['price'];

	if (in_array($currency, ['GOLD', 'P2P', 'BTCW', 'PAC', 'PESO']))
	{
		$token_price = price_coinbrain($currency); // usd
	}
	elseif (in_array($currency, ['BNB', 'SHIB', 'TRX', 'BUSD', 'BCH', 'TWT', 'CAKE']))
	{
		$token_price = token_price($currency)['price']; // usd
	}
	elseif ($currency === 'PHP')
	{
		$php_price_usd = php_price_usd();

		$price_php = 0;

		if ($php_price_usd)
		{
			$ask = $php_price_usd['market']['ask'];
			$bid = $php_price_usd['market']['bid'];

			$price_php = ($ask + $bid) / 2;
		}

		$token_price = 1 / $price_php;
	}
	elseif ($currency === 'USD')
	{
		$token_price = 1;
	}

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

		if ($currency === 'PHP')
		{
			$price_total = $value;
		}
		else
		{
			$price_total = $value * $price_php * $token_price; // PHP
		}
	}
	else
	{
		$method = strtoupper($method);

		if (in_array($method, ['BTC', 'BTC3', 'BTCB', 'BTCW', 'GOLD', 'PAC', 'P2P', 'PESO']))
		{
			$price_total = $token_price * $value / price_coinbrain($method);
		}
		else
		{
			$price_total = ($token_price / token_price($method)['price']) * $value;
		}
	}

	return $price_total;
}

/**
 * @param $user_id
 * @param $amount
 *
 * @param $method
 *
 * @since version
 */
function process_request($user_id, $amount, $method)
{
	$db = db();

	$app = application();

	validate_input($user_id, $amount, $method);

	$user = user($user_id);

	$price_total = price_token_method($amount, $method);

	$currency = in_array($method, ['bank', 'gcash']) ? 'PHP' : $method;

	// mail admin and user
	$message = 'Username: ' . $user->username . '<br>
			Full Name: ' . $user->fullname . '<br>
			Email: ' . $user->email . '<br>
			Contact: ' . $user->contact . '<br>
			Amount Requested: ' . $amount . ' ' .
		'<br>
			Price: ' . $price_total . ' ' . strtoupper($currency) .
		'<br>
			Payment Method: ' . strtoupper($method) . '<br>';

	try
	{
		$db->transactionStart();

		insert_request($user_id, $amount, $price_total, $method);
		send_mail($message, settings('ancillaries')->share_fund_name . ' Request', [$user->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	$app->redirect(Uri::root(true) . '/' . sef(135),
		'Your transaction will appear below as a pending request. Please press \'Method\' at the bottom and pay your pending entry.', 'success');
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$user = user($user_id);

	$sa = settings('ancillaries');

	$share_fund_name = settings('ancillaries')->share_fund_name;

	$str = ' <h1>Request ' . $share_fund_name . /*'<span style="float: right">
 		
 		<div class="uk-width-1-1">
	        <div class="uk-button-group uk-margin-small-top">
	            <a class="uk-button uk-button-primary" style="float:right;" 
		href="https://bitkeep.com/en/swap/bnb/0x4A0bfC65fEb6F477E3944906Fb09652d2d8b5f0d">Buy GOLD Token</a>
	        </div>
	        <div class="uk-button-group uk-margin-small-top">
	            <a class="uk-button uk-button-primary" style="float:right;" 
		href="https://bitkeep.com/en/swap/eth/0x4fabb145d64652a948d72533023f6e7a623c7c53">Buy BUSD Token</a>
		</div>
	        </div></span>' .*/
		'</h1>';

	$min_request = $sa->{$user->account_type . '_min_request_usd'};
	$max_request = $sa->{$user->account_type . '_max_request_usd'};

	$str .= '<p>Enter requested amount in the box, then select your preferred currency payment method, ' .
		'(minimum request is ' . number_format($min_request, 2) . ' ' . $share_fund_name . ' up to ' .
		number_format($max_request, 2) . ' ' . $share_fund_name . ') then press the submit button. ' .
		'Press the "Method" button and follow the instructions provided.</p>';

	$str .= '	
 		<!--<input type="button" class="uk-button uk-button-primary" value="Buy Token Here" data-uk-modal="{target:\'#modal-buy-token\'}">--></span></h1>
	    <form method="post" onsubmit="submit.disabled=true; return true;">
	        <table class="category table table-striped table-bordered table-hover">
	            <tr>';

	$str .= '<td><input type="text" name="amount" placeholder="Amount (' .
		$share_fund_name . ')" id="amount" style = "float:left">';
	$str .= view_method_select($user_id);
	$str .= '<input type="submit" name="submit" value="Submit" class="uk-button uk-button-primary">';
//	$str .= '<a class="uk-button uk-button-primary" style="float:right"
//		href="https://study.bitkeep.com/en/?ht_kb=create-your-first-wallet">Create Your Smart Wallet</a>';
	$str .= '</td>';
	$str .= '</tr>
	        </table>
	    </form>';

	$str .= modal_buy_token('0xd8A4f0346bed070a19C0502d77Cff657963f3691');

	return $str;
}

function view_method_select($user_id): string
{
	$user = user($user_id);

	$pmu = arr_payment_method($user);

	$str = '<select name="method" id="method" style="float:left">';
	$str .= '<option value="none" selected>Currency Payment Method</option>';

	if (!empty($pmu))
	{
		$allowedCurrencies = ['busd', 'gold', 'usdt', 'bnb', 'btcb', 'btcw',
			'pac', 'shib', 'doge', 'trx', 'usdc', 'gcash', 'bank'];

		foreach ($pmu as $k => $v)
		{
			if (in_array($k, $allowedCurrencies))
			{
				$str .= '<option value="' . $k . '">' . strtoupper($k) . '</option>';
			}
		}
	}

	$str .= '</select>';

	return $str/*'<input type="hidden" name="method" value="busd">'*/ ;
}

/**
 * @param $address
 *
 * @return string
 *
 * @since version
 */
function qr_code_generate($address): string
{
	$cht  = "qr";
	$chs  = "300x300";
	$chl  = $address;
	$choe = "UTF-8";

	return 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
}

function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_pending_requests(): string
{
	$user_id = session_get('user_id');

	$pending = user_request($user_id);

	$share_fund_name = settings('ancillaries')->share_fund_name;

	$str = '<h2>Pending ' . $share_fund_name . ' Requests</h2>';

	if (empty($pending))
	{
		$str .= '<hr><p>No pending ' . $share_fund_name . ' requests yet.</p>';
	}
	else
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Date Requested</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>Price</th>';
		$str .= '<th>Method</th>';
		$str .= '<th>Action</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($pending as $tmp)
		{
			$user_admin = user(1);

			$admin_arr_payment     = arr_payment_method($user_admin);
			$admin_payment_address = $admin_arr_payment[$tmp->method];

			$payment_method = strtoupper($tmp->method);

			if (is_array($admin_arr_payment[$tmp->method]))
			{
				foreach ($admin_arr_payment[$tmp->method] as $k => $v)
				{
					$payment_method        = strtoupper($k);
					$admin_payment_address = $v;

					break;
				}
			}

			$currency = in_array($tmp->method, ['bank', 'gcash']) ? 'PHP' : $tmp->method;

			$str .= '<tr>';
			$str .= '<td> ' . date('M j, Y - g:i A', $tmp->date_requested) . ' </td>';
			$str .= '<td> ' . number_format($tmp->amount, 2) . ' ' . /*$efund_name .*/
				'</td>';
			$str .= '<td> ' . number_format($tmp->price, 2) . ' ' . strtoupper($currency) . '</td>';
			$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' .
				strtoupper($payment_method) . '" data-uk-modal="{target:\'#modal-' . $tmp->request_id . '\'}"></td>';

			$str .= '<div id="modal-' . $tmp->request_id .
				'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">';
			$str .= '<div class="uk-modal-dialog" style="text-align: center">';
			$str .= '<button type="button" class="uk-modal-close uk-close"></button>';

			$contact_info = arr_contact_info($user_admin);

			$messenger = '';

			if (!empty($contact_info))
			{
				$messenger = $contact_info['messenger'] ?? '';
			}

			$contact = $messenger ? '<p><b>Admin Messenger URL:</b> ' . $messenger . '</p>' : '';
			$contact .= $user_admin->email ? '<p><b>Admin Email Address:</b> ' . $user_admin->email . '</p>' : '';

			if (!in_array($tmp->method, ['bank', 'gcash']))
			{
				$str .= '<img src="images/trust-wallet.svg" alt="" width="150px">';

				$message = "After a successful transaction, please take a screenshot of the transaction ' . 
					'and send it to the email address provided below. Your transaction will be processed ' . 
					'within eight hours. Once processed, you will be able to view your $share_fund_name ' . 
					'in your dashboard wallet and select your desired entry to join the Rewards System. ' . 
					'If you have any concerns, feel free to email us at any time. ' . 
					'Congratulations on joining the team!<br><br>-- Support Team";

				$str .= '<p style="color: red; border: red">' . $message . '</p>';
				$str .= $contact;
				$str .= '<img src="' . qr_code_generate($admin_payment_address) .
					'" alt="QR Code Trust Wallet" style="width:250px;">';

				$str .= '<p>Please pay <b>' . number_format($tmp->price, 2) . '</b> ' .
					strtoupper($currency) . ' to the following Wallet Address:</p>
	                <p><b>' . $admin_payment_address . '</b></p>
	            </div>
	        </div>';
			}
			else
			{
				if ($tmp->method === 'gcash')
				{
					$str .= $contact;
					$str .= '<p>Please pay <b>' . number_format($tmp->price, 2) . '</b> ' .
						strtoupper($currency) . ' to the following G-Cash Number:</p>';
					$str .= '<p><b>' . $admin_payment_address . '</b></p>';
					$str .= '</div>';
					$str .= '</div>';
				}
				elseif ($tmp->method === 'bank')
				{
					$str .= $contact;
					$str .= '<p>Please pay <b>' . number_format($tmp->price, 2) . '</b> ' . strtoupper($currency) .
						' to the following ' . strtoupper($payment_method) . ' Bank Account:</p>';
					$str .= '<p><b>' . $admin_payment_address . '</b></p>';
					$str .= '</div>';
					$str .= '</div>';
				}
			}

			$str .= '<td><input type="button" class="uk-button uk-button-primary" value="Cancel" 
				data-uk-modal="{target:\'#modal-cancel-' . $tmp->request_id . '\'}"></td>';

			$str .= '<div id="modal-cancel-' . $tmp->request_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
			$str .= '<p><strong>Are you sure, you want to cancel this request?</strong></p>';
			$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <h3 class="uk-panel-title"><strong>Date Requested:</strong> ' .
				date('M j, Y - g:i A', $tmp->date_requested) . '</h3>
                        <h3 class="uk-panel-title"><strong>Amount:</strong> ' .
				number_format($tmp->amount, 2) . ' ' . '</h3>
                        <h3 class="uk-panel-title"><strong>Final: </strong> ' .
				number_format($tmp->price, 2) . ' ' . strtoupper($currency) . '</h3>                        
                    </div>';
			$str .= '<div class="uk-modal-footer" style="text-align: right">
						<input type="button" class="uk-modal-close uk-button uk-button-primary" value="Close">
						<a href="' . sef(135) . qs() . 'cid=' . $tmp->request_id . '" 
							type="button" class="uk-button uk-button-primary">Confirm</a>
					</div>';
			$str .= '</div>
		        </div>';
			$str .= '</tr>';
		}

		$str .= '</tbody>
        </table> ';
	}

	return $str;
}

function modal_buy_token($admin_payment_address): string
{
	$str = '<div id="modal-buy-token" class="uk-modal" aria-hidden="true" ' .
		'style="display: none; overflow-y: scroll; margin-top: 150px">';

	$str .= '<div class="uk-modal-dialog" style="text-align: center">
                <button type="button" class="uk-modal-close uk-close"></button>               
                <div class="uk-width-1-1 uk-form uk-grid-margin" style="text-align: center">                    
                    <legend>Buy Token in This Wallet Address</legend>
                    <p style="font-weight: bolder; font-size: large">' . $admin_payment_address . '</p>                   
                </div>';

	$str .= '<img src="' . qr_code_generate($admin_payment_address) .
		'" alt="QR Code Trust Wallet" style="width:250px;">';

	$str .= '</div>';

//	$str .= '<div class="uk-modal-dialog" style="text-align: center">';
//	$str .= '<button type="button" class="uk-modal-close uk-close"></button>';

//	$str .= '<div class="uk-form-row">
//                                <input type="text" value="' . $admin_payment_address . '" class="uk-form-large uk-form-width-small">
//                                <button class="uk-button uk-button-large" type="reset">Large</button>
//                            </div>';

	$str .= '</div>
	        </div>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_request($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_share_fund_request ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' AND date_confirmed = ' . $db->quote(0)
	)->loadObjectList();
}

function price_coinbrain($token = 'BTC3')
{
	switch ($token)
	{
//        case 'BUSD':
//            $contract = '0xe9e7cea3dedca5984780bafc599bd69add087d56';
//	        break;
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
		case 'PESO':
			$contract = '0xBdFfE2Cd5B9B4D93B3ec462e3FE95BE63efa8BC0';
			break;
		default:
			$contract = '0xe9e7cea3dedca5984780bafc599bd69add087d56';
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