<?php

namespace BPL\Jumi\Convert_Token;

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
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Mailer\main as send_mail;

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
	$username = session_get('username');
	$usertype = session_get('usertype');
	$admintype = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id = session_get('user_id');

	$amount = input_get('amount');
	$method = input_get('method');

	$cid = input_get('cid');
	$fpt = session_get('fpt');
	$fdp = session_get('fdp');
	$fdtp = session_get('fdtp');
	$ftk = session_get('ftk');
	$lpd = session_get('lpd');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$app = application();

	$user = user($user_id);

	$arr_payment_method = arr_payment_method($user);

	$sa = settings('ancillaries');

	$currency = $sa->currency;

	if (empty($arr_payment_method)) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Fill Up Your Payment Method.',
			'error'
		);
	}

	if (
		($currency === 'PHP') && !array_key_exists('gcash', $arr_payment_method)
		&& !array_key_exists('bank', $arr_payment_method)
	) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Fill Up Your G-Cash or Bank Details.',
			'error'
		);
	}

	if ($currency === 'USD' && !array_key_exists('bank', $arr_payment_method)) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Fill Up Your Bank Details.',
			'error'
		);
	}

	if (!in_array($currency, ['PHP', 'USD'])) {
		if (!array_key_exists(strtolower($currency), $arr_payment_method)) {
			$app->redirect(
				Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
				'Please Fill Up Your ' . $currency . ' Payment Method.',
				'error'
			);
		}
	}

	if (((double) $user->converted_today + (double) $amount) > $sa->{$user->account_type . '_max_convert_usd'}) {
		$app->redirect(
			Uri::root(true) . '/' . sef(98) . qs() . 'uid=' . $user_id,
			'Exceeded Maximum Withdrawal Amount!',
			'error'
		);
	}

	if ($cid !== '') {
		process_cancel_conversion($cid);
	}

	if ($fdp !== '') {
		$mode = 'fdp';
		$value = $fdp;
	} elseif ($fpt !== '') {
		$mode = 'fpt';
		$value = $fpt;
	} elseif ($fdtp !== '') {
		$mode = 'fdtp';
		$value = $fdtp;
	} elseif ($ftk !== '') {
		$mode = 'ftk';
		$value = $ftk;
	} elseif ($lpd !== '') {
		$mode = 'lpd';
		$value = $lpd;
	} else {
		$mode = 'sop';
		$value = '';
	}

	if ($amount !== '') {
		process_conversion($user_id, $amount, $method, $mode);
	}

	$str .= view_form($user_id, $value, $mode);
	$str .= view_pending_conversions();

	echo $str;
}

function process_cancel_conversion($cid)
{
	$db = db();

	$etc = entry_token_convert($cid);

	try {
		$db->transactionStart();

		$update = update(
			'network_users',
			[
				'converted_token_today = converted_token_today - ' . $etc->amount/* ,
'savings = savings - ' . $etc->cut,
'points = points - ' . $etc->cut */
			],
			['id = ' . db()->quote($etc->user_id)]
		);

		if ($update) {
			delete(
				'network_token_convert',
				['convert_id = ' . db()->quote($cid)]
			);
		}

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(
		Uri::root(true) . '/' . sef(98),
		'Transaction canceled!',
		'notice'
	);
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

	switch ($usertype) {
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
 * @param $mode
 *
 * @since version
 */
function validate_input($user_id, $amount, $method, $mode)
{
	$app = application();

	// $sa = settings('ancillaries');
	$si = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;

	$min_token_convert = $si->{$account_type . '_fixed_daily_token_minimum_deposit'};

	// $efund_balance = $user->payout_transfer;

	$arr_payment_method = arr_payment_method($user);

	// if ($mode === 'fdp') {
	// 	$fdp_converts = user_token_convert($user_id, 'fdp');

	// 	$fdp_total = 0;

	// 	if (!empty($fdp_converts)) {
	// 		foreach ($fdp_converts as $fdp) {
	// 			$fdp_total += $fdp->amount;
	// 		}
	// 	}

	// 	if ($user->fixed_daily_balance < ($fdp_total + $amount)) {
	// 		session_set('fdp', '');

	// 		$app->redirect(
	// 			Uri::root(true) . '/' . sef(98),
	// 			settings('plans')->fixed_daily_name . ' Balance exceeded!',
	// 			'error'
	// 		);
	// 	}
	// }

	if ($mode === 'fdtp') {
		$fdtp_converts = user_token_convert($user_id, 'fdtp');

		$fdtp_total = 0;

		if (!empty($fdtp_converts)) {
			foreach ($fdtp_converts as $fdtp) {
				$fdtp_total += $fdtp->amount;
			}
		}

		if ($user->fixed_daily_token_balance < ($fdtp_total + $amount)) {
			session_set('fdtp', '');

			$app->redirect(
				Uri::root(true) . '/' . sef(98),
				settings('plans')->fixed_daily_token_name . ' Balance exceeded!',
				'error'
			);
		}
	}

	// if ($mode === 'ftk') {
	// 	$ftk_converts = user_token_convert($user_id, 'ftk');

	// 	$ftk_total = 0;

	// 	if (!empty($ftk_converts)) {
	// 		foreach ($ftk_converts as $ftk) {
	// 			$ftk_total += $ftk->amount;
	// 		}
	// 	}

	// 	if ($user->fast_track_balance < ($ftk_total + $amount)) {
	// 		session_set('ftk', '');

	// 		$app->redirect(
	// 			Uri::root(true) . '/' . sef(98),
	// 			settings('plans')->fast_track_name . ' Balance exceeded!',
	// 			'error'
	// 		);
	// 	}
	// }

	if (empty($method) || $method === 'none') {
		$app->redirect(
			Uri::root(true) . '/' . sef(98),
			'Please Select Method!',
			'error'
		);
	}

	if (empty($arr_payment_method) || empty($arr_payment_method[$method])) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Your Wallet Address for ' . strtoupper($method) . ' is Required.',
			'error'
		);
	}

	if ($amount <= 0) {
		$app->redirect(
			Uri::root(true) . '/' . sef(98),
			'Please enter valid amount!',
			'error'
		);
	}

	// if (((double) $amount + (double) $sa->processing_fee) > $efund_balance) {
	// 	$app->redirect(
	// 		Uri::root(true) . '/' . sef(98),
	// 		'Not enough ' . $sa->currency . ' to cover your gas fee!',
	// 		'error'
	// 	);
	// }

	if ($amount < $min_token_convert) {
		$app->redirect(
			Uri::root(true) . '/' . sef(98),
			'Minimum withdrawal amount is ' . $min_token_convert . '.',
			'error'
		);
	}
}

/**
 * @param           $user_id
 * @param           $amount
 * @param           $cut
 * @param           $price
 * @param           $method
 * @param   string  $mode
 *
 * @return false|mixed
 * @since version
 */
function insert_convert($user_id, $amount, $cut, $price, $method, string $mode = 'sop')
{
	$db = db();

	return insert(
		'network_token_convert',
		[
			'user_id',
			'amount',
			'cut',
			'price',
			'mode',
			'method',
			'date_posted'
		],
		[
			$db->quote($user_id),
			$db->quote($amount),
			$db->quote($cut),
			$db->quote($price),
			$db->quote($mode),
			$db->quote($method),
			$db->quote(time())
		]
	);
}

function update_user($value, $user_id/*, $mode = 'sop'*/ , $cut)
{
	//	if ($mode === 'fdp')
//	{
//		update(
//			'network_users',
//			[
//				'converted_today = converted_today + ' . $value,
////				'fixed_daily_balance = fixed_daily_balance - ' . $value,
//				'payout_transfer = payout_transfer - ' . settings('ancillaries')->processing_fee
//			],
//			[
//				'id = ' . db()->quote($user_id)
//			]
//		);
//	}
//	else
//	{
	$update = update(
		'network_users',
		[
			'converted_token_today = converted_token_today + ' . $value/* ,
'payout_transfer = payout_transfer - ' . settings('ancillaries')->processing_fee,
'savings = savings + ' . $cut,
'points = points + ' . $cut */
		],
		[
			'id = ' . db()->quote($user_id)
		]
	);
	//	}

	// if ($update) {
	// 	$sa = settings('ancillaries');

	// 	$user = user($user_id);
	// 	$account_type = $user->account_type;
	// 	$savings = $user->savings;

	// 	$target = $sa->{$account_type . '_savings_target'};

	// 	if ($savings >= $target) {
	// 		update(
	// 			'network_users',
	// 			['savings = ' . db()->quote(0)],
	// 			['id = ' . db()->quote($user_id)]
	// 		);
	// 	}
	// }
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function php_price_usd()
{
	$url = 'https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=php';

	$data = [];

	try {
		$json = /*!in_array('curl', get_loaded_extensions()) || is_localhost() ?
		   */
			@file_get_contents($url)/* : file_get_contents_curl($url)*/
		;

		$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
	} catch (Exception $e) {

	}

	return $data;
}

function price_token_method($value, $method)
{
	if (in_array($method, ['bank', 'gcash', 'maya'])) {
		$php_price_usd = php_price_usd();

		$price_php = 0;

		if ($php_price_usd && isset($php_price_usd['tether']['php'])) {
			//            $ask = $php_price_usd['market']['ask'];
//            $bid = $php_price_usd['market']['bid'];
//
//            $price_php = ($ask + $bid) / 2;

			$price_php = $php_price_usd['tether']['php'];
		}

		$price_res = $price_php; // PHP
	} else {
		$currency = strtoupper($method);

		if (in_array($currency, ['B2P', 'AET', 'TPAY', /*'BTC3', 'BTCB', 'BTCW', 'GOLD', 'PAC', 'P2P',*/ 'PESO'])) {
			$price_res = 1 / price_coinbrain($currency);
		} else {
			$price_method = token_price($currency)['price'];
			$price_base = token_price('USDT')['price'];

			$price_res = $price_base / $price_method;
		}
	}

	return $price_res * $value;
}

/**
 * Array of contact infos
 *
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

/**
 * @param $user_id
 * @param $amount
 *
 * @param $method
 * @param $mode
 *
 * @since version
 */
function process_conversion($user_id, $amount, $method, $mode)
{
	$db = db();

	$app = application();

	validate_input($user_id, $amount, $method, $mode);

	$user = user($user_id);

	$si = settings('investment');

	// $sa = settings('ancillaries');

	$account_type = $user->account_type;

	$withdrawal_fee = $si->{$account_type . '_fixed_daily_token_withdrawal_fee'}; // percent

	// $convert_points_cut = $sa->{$account_type . '_convert_points_cut'}; // percent
//	$convert_points_usd = $sa->{$account_type . '_convert_points_usd'}; // efund / points

	$amount_cut = $amount * $withdrawal_fee / 100;

	$amount_final = $amount - $amount_cut;
	//	$points_cut   = $amount_cut / $convert_points_usd; // set aside for reward points

	$price_total = /* price_token_method($amount_final, $method) */ $amount_final;

	$currency = /* in_array($method, ['bank', 'gcash']) ? 'PHP' : $method */ 'B2P';

	$contacts = arr_contact_info($user);

	$str_contact = '';

	if (!empty($contacts)) {
		foreach ($contacts as $k => $v) {
			$str_contact .= ucwords($k) . ': ' . $v . '<br>';
		}
	}

	// mail admin and user
	$message = 'Username: ' . $user->username . '<br>
			Full Name: ' . $user->fullname . '<br>
			Email: ' . $user->email . '<br>' .
		$str_contact . '
			Amount: ' . $amount_final . ' ' .
		'<br>
			Price: ' . $price_total . ' ' . strtoupper($currency) .
		'<br>
			Payment Method: ' . strtoupper($method) . '<br>';

	try {
		$db->transactionStart();

		//		$mode = $fdp === '' ? 'sop' : 'fdp';

		if (insert_convert($user_id, $amount, $amount_cut, $price_total, $method, $mode)) {
			update_user($amount, $user_id, /*$points_cut*/ $amount_cut);

			if ($mode === 'fdp') {
				session_set('fdp', '');
			}

			if ($mode === 'fpt') {
				session_set('fpt', '');
			}

			if ($mode === 'fdtp') {
				session_set('fdtp', '');
			}

			if ($mode === 'ftk') {
				session_set('ftk', '');
			}

			if ($mode === 'lpd') {
				session_set('lpd', '');
			}
		}

		send_mail($message, 'B2P Withdrawal', [$user->email]);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	$app->redirect(
		Uri::root(true) . '/' . sef(98),
		'Withdrawals are processed within 24 Hours. Please check your e-wallet after the said processing time. FYI.',
		'success'
	);
}

function view_form($user_id, string $value = '', $mode = 'fdtp'): string
{
	$user = user($user_id);
	// $sa = settings('ancillaries');

	$token_name = /* $sa->efund_name */ 'B2P';

	// Start building the HTML structure
	$str = '<div class="form-container">';
	$str .= '<h1>' . $token_name . ' Withdrawal<span class="create-wallet-link">';

	// Optionally include a link for creating a wallet
	$str .= '<!--<a class="uk-button uk-button-primary" href="https://study.bitkeep.com/en/?ht_kb=create-your-first-wallet">Create Your Smart Wallet</a>-->';
	$str .= '</span></h1>';

	$str .= '<p>The transaction will be processed within 24 hours, and you will see the B2P in your token wallet.</p>';

	// $str .= '<p>Input the amount to be withdrawn in the box provided below, then select your preferred payment method. You can withdraw from ' .
	// 	$sa->{$user->account_type . '_min_convert_usd'} . ' ' . $token_name .
	// 	' up to ' . $sa->{$user->account_type . '_max_convert_usd'} . ' ' . $token_name . '.</p>';

	// Start form
	$str .= '<form method="post" onsubmit="submit.disabled=true; return true;" class="withdrawal-form">';
	$str .= '<div class="form-group">';

	// Input field for amount
	$str .= '<label for="amount" class="form-label">' . $token_name . ' Amount:</label>';
	$str .= '<input type="text" name="amount" placeholder="Input Amount (' . $token_name . ')" value="' . $value . '" id="amount" class="form-input" readonly' .
		/* ($value == '' ? '' : 'readonly') . */ '>';

	// Payment method select
	$str .= view_method_select($user_id, $mode);

	// Submit button
	$str .= '<input type="submit" name="submit" value="Submit" class="uk-button uk-button-primary submit-button">';

	// Display balance
	// $str .= '<b class="balance-info">' . $token_name . ' Balance: ' . number_format($user->payout_transfer, 8) . '</b>';
	$str .= '</div>';
	$str .= '</form>';

	$str .= '</div>'; // Close form-container

	$str .= '<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h1 {
        font-size: 1.5em;
        margin-bottom: 20px;
        color: #333;
    }

    .form-container .create-wallet-link {
        float: right;
    }

    .form-container p {
        margin-bottom: 15px;
        font-size: 1em;
        line-height: 1.5;
        color: #666;
    }

    .form-container .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-input {
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1em;
    }

    .withdrawal-form select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
    }

    .submit-button {
        width: 100%;
        padding: 12px;
        font-size: 1.2em;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .submit-button:hover {
        background-color: #0056b3;
    }

    .balance-info {
        display: block;
        margin-top: 10px;
        font-weight: bold;
        text-align: right;
        color: #333;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 15px;
        }

        .form-container h1 {
            font-size: 1.2em;
        }

        .submit-button {
            font-size: 1em;
            padding: 10px;
        }
    }
</style>
';

	return $str;
}

function view_method_select($user_id, $mode): string
{
	// $user = user($user_id);
	// $pmu = arr_payment_method($user);

	// $isReadonly = in_array($mode, ['fdtp', 'fpt']); // Determine if the select should be readonly (disabled)
	// $str = '<select name="method" id="method" style="float:left" ' . ($isReadonly ? 'disabled' : '') . '>';

	// // Default option
	// $str .= '<option value="none" ' . (!$isReadonly ? 'selected' : '') . '>Select Method</option>';

	// if (!empty($pmu)) {
	// 	foreach ($pmu as $k => $v) {
	// 		$selected = ($isReadonly && $k === 'b2p') ? 'selected' : '';
	// 		$str .= '<option value="' . $k . '" ' . $selected . '>' . strtoupper($k) . '</option>';
	// 	}
	// }

	// $str .= '</select>';

	// // Add a hidden input to preserve the value of the method when disabled
	// if ($isReadonly) {
	// 	$str .= '<input type="hidden" name="method" value="b2p">';
	// }

	$str = '<input type="hidden" name="method" value="b2p">';

	return $str;
}

/**
 * @param $address
 *
 * @return string
 *
 * @since version
 */
//function qr_code_generate($address): string
//{
//	$cht  = "qr";
//	$chs  = "300x300";
//	$chl  = $address;
//	$choe = "UTF-8";
//
//	return 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
//}

/**
 *
 * @return string
 *
 * @since version
 */
function view_pending_conversions(): string
{
	$user_id = session_get('user_id');

	$pending = user_token_convert($user_id);

	$token_name = /* settings('ancillaries')->efund_name */ 'B2P';

	$str = '<h2>Pending ' . $token_name . ' Withdrawals</h2>';

	if (empty($pending)) {
		$str .= '<hr><p>No pending ' . $token_name . ' withdrawals yet.</p>';
	} else {
		$str .= '<div class="table-responsive">';
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Date</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>System Charge</th>';
		$str .= '<th>Rate</th>';
		$str .= '<th>Method</th>';
		$str .= '<th>Mode</th>';
		$str .= '<th>On Processing</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($pending as $tmp) {
			$currency = in_array($tmp->method, ['bank', 'gcash']) ? 'PHP' : $tmp->method;

			// $sa = settings('ancillaries');

			switch ($tmp->mode) {
				case 'fdp':
					$mode = settings('plans')->fixed_daily_name;
					break;
				case 'fdtp':
					$mode = settings('plans')->fixed_daily_token_name;
					break;
				case 'ftk':
					$mode = settings('plans')->fast_track_name;
					break;
				case 'lpd':
					$mode = settings('plans')->leadership_passive_name;
					break;
				default:
					$mode = 'Standard';
					break;
			}

			$str .= '<tr>';
			$str .= '<td> ' . date('M j, Y - g:i A', $tmp->date_posted) . ' </td>';
			$str .= '<td> ' . number_format($tmp->amount, 8) . ' ' . /* $sa->efund_name */ $token_name . '</td>';
			$str .= '<td> ' . number_format($tmp->cut, 8) . ' ' . /* $sa->efund_name */ $token_name . '</td>';
			$str .= '<td> ' . number_format($tmp->price, 8) . ' ' . strtoupper($currency) . '</td>';
			$str .= '<td>' . strtoupper($tmp->method) . '</td>';
			$str .= '<td>' . $mode . '</td>';

			$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="Cancel" 
				data-uk-modal="{target:\'#modal-cancel-' . $tmp->convert_id . '\'}"></td>';

			$str .= '<div id="modal-cancel-' . $tmp->convert_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
			$str .= '<p><strong>Are you sure, you want to cancel this transaction?</strong></p>';
			$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <h3 class="uk-panel-title"><strong>Date of Transaction:</strong> ' .
				date('M j, Y - g:i A', $tmp->date_posted) . '</h3>
                        <h3 class="uk-panel-title"><strong>Amount:</strong> ' .
				number_format($tmp->amount, 2) . ' ' . '</h3>
                        <h3 class="uk-panel-title"><strong>Final: </strong> ' .
				number_format($tmp->price, 2) . ' ' . strtoupper($currency) . '</h3>                        
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

		$str .= '</tbody>
        </table> ';
		$str .= '</div>';
	}

	return $str;
}

/**
 * @param           $user_id
 * @param   string  $mode
 *
 * @return array|mixed
 *
 * @since version
 */
function user_token_convert($user_id, string $mode = 'fdtp')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_token_convert ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		($mode !== 'fdtp' ? ' AND mode = ' . $db->quote($mode) : '') .
		' AND date_approved = ' . $db->quote(0)
	)->loadObjectList();
}

function entry_token_convert($cid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_token_convert ' .
		'WHERE convert_id = ' . $db->quote($cid)
	)->loadObject();
}

function price_coinbrain($token = 'BTC3')
{
	switch ($token) {
		case 'B2P':
			$contract = '0xF8AB9fF465C612D5bE6A56716AdF95c52f8Bc72d';
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
		case 'AET':
			$contract = '0xbc26fCCe32AeE5b0D470Ca993fb54aB7Ab173a1E';
			break;
		case 'TPAY':
			$contract = '0xd405200D9c8F8Be88732e8c821341B3AeD6724b7';
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

	if (!empty($results)) {
		$results = (array) $results[0];
		$price = $results['priceUsd'];
	}

	return $price;
}