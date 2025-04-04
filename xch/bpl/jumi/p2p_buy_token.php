<?php

namespace BPL\Jumi\P2P_Buy_Token;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/api_token_price.php';
require_once 'bpl/mods/api_coinbrain_token_price.php';
require_once 'bpl/mods/helpers.php';
require_once 'bpl/plugins/phpqrcode/qrlib.php';

use Exception;
use QRcode;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use RuntimeException;
use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\API_Token_Price\main as token_price;
use function BPL\Mods\API\Coinbrain\TokenPrice\main as coinbrain_price_token;

use function BPL\Mods\Database\Query\delete;
use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function bpl\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;
use function bpl\Mods\Helpers\paginate;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\time;
use const QR_ECLEVEL_L;

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

	$sell_id = input_get('sell_id');
	$amount_buy_post = input_get('amount_buy_post');
	$amount_buy_post_min = input_get('amount_buy_post_min');
	$value = input_get('value');
	//	$price_buy_post      = input_get('price_buy_post');
	$type_buy_post = input_get('type_buy_post');
	$method_buy_post = input_get('method_buy_post');

	$aid = input_get('aid');
	$did = input_get('did');
	$cid = input_get('cid');

	$gp = input_get('gp');
	$dr = input_get('dr');

	$rows = 5;

	$grace_period = 33000; // seconds

	$p_pst = input_get('pst', 0);
	$p_rq = input_get('rq', 0);

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	validate_buyer($user_id);

	if ($amount_buy_post !== '') {
		process_add_buy_post(
			$user_id,
			$amount_buy_post,
			$amount_buy_post_min,
			$type_buy_post,
			$method_buy_post
		);
	}

	if ($value !== '') {
		process_add_request($user_id, $value, $sell_id, $type_buy_post);
	}

	if ($cid !== '') {
		process_delete_request($cid, $gp, $dr);
	}

	if ($aid !== '') {
		process_approve_sell_request($aid);
	}

	if ($did !== '') {
		process_deny_sell_request($did);
	}

	$str .= page_reload();

	$str .= view_form_buy_post($user_id);

	$str .= view_sell_postings($user_id, $p_pst, $rows);
	$str .= view_requests($user_id, $p_rq, $grace_period, $rows);

	echo $str;
}

function process_approve_sell_request($aid)
{
	$db = db();

	try {
		$db->transactionStart();

		update_seller_p2p_wallet_approve($aid);
		update_seller_posting_approve($aid);
		update_seller_request_approve($aid);

		log_p2p_sell_transaction($aid);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(
		Uri::root(true) . '/' . sef(55),
		'Seller Request approved successfully!',
		'success'
	);
}

function log_p2p_sell_transaction($sell_id)
{
	$pc = posting_single($sell_id);
	$rc = request_single($pc->purchase_id);

	insert_sell_transaction(
		$pc->seller_id,
		$rc->buyer_id,
		$pc->amount_sold,
		$rc->type_buy,
		$rc->method_buy,
		$rc->price_buy,
		$pc->total_sell,
		$pc->date_posted
	);
}

function insert_sell_transaction(
	$seller_id,
	$buyer_id,
	$amount,
	$type,
	$method,
	$price,
	$final,
	$date_open
) {
	$db = db();

	return insert(
		'network_p2p_transactions',
		[
			'seller_id',
			'buyer_id',
			'amount',
			'type',
			'method',
			'price',
			'final',
			'date_open',
			'date_close'
		],
		[
			$db->quote($seller_id),
			$db->quote($buyer_id),
			$db->quote($amount),
			$db->quote($type),
			$db->quote($method),
			$db->quote($price),
			$db->quote($final),
			$db->quote($date_open),
			$db->quote(time())
		]
	);
}

function process_deny_sell_request($did)
{
	$db = db();

	try {
		$db->transactionStart();

		update_seller_request_deny($did);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(
		Uri::root(true) . '/' . sef(55),
		'Seller Request has been denied!',
		'notice'
	);
}

function update_seller_request_deny($sell_id)
{
	$db = db();

	update(
		'network_p2p_sell_tokens',
		[
			'date_updated = ' . $db->quote('-1')
		],
		['sell_id = ' . $db->quote($sell_id)]
	);
}

function update_seller_p2p_wallet_approve($sell_id)
{
	$db = db();

	$posting = posting_single($sell_id);

	$amount_sold = $posting->amount_sold;

	$user = user($posting->seller_id);
	$json_p2p_wallet = $user->p2p_wallet;
	$arr_p2p_wallet = json_decode($json_p2p_wallet, true);

	if (!empty($arr_p2p_wallet) && array_key_exists($posting->type, $arr_p2p_wallet)) {
		$value_type = (double) $arr_p2p_wallet[$posting->type];
		$value_type_new = $value_type - $amount_sold;

		$arr_p2p_wallet[$posting->type] = $value_type_new;
	} else {
		$arr_p2p_wallet[$posting->type] = 0;
	}

	update(
		'network_users',
		[
			'p2p_wallet = ' . $db->quote(json_encode($arr_p2p_wallet))
		],
		['id = ' . $db->quote($posting->seller_id)]
	);
}

function update_seller_posting_approve($sell_id)
{
	$db = db();

	//	$posting = posting_single($sell_id);

	update(
		'network_p2p_sell_tokens',
		[
			//			'amount_remaining = amount_remaining - ' . $amount_sold,
//			'amount_sold = amount_sold + ' . $amount_sold,
			'date_confirmed = ' . $db->quote(time())
		],
		['sell_id = ' . $db->quote($sell_id)]
	);
}

function update_seller_request_approve($sell_id)
{
	$db = db();

	$posting = posting_single($sell_id);

	$amount_sold = $posting->amount_sold;

	$request = request_single($posting->purchase_id);

	$amount_pending_new = $request->amount_pending - $amount_sold;

	$field = [
		'sale_id = ' . $db->quote($sell_id),
		'amount_pending = amount_pending - ' . $amount_sold,
		'amount = amount + ' . $amount_sold,
		'date_updated = ' . $db->quote(time())
	];

	if ($amount_pending_new <= 0) {
		$field[] = 'date_confirmed = ' . $db->quote(time());
	}

	update(
		'network_p2p_token_sale',
		$field,
		['request_id = ' . $db->quote($posting->purchase_id)]
	);
}

function request_single($request_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_token_sale ' .
		'WHERE request_id = ' . $db->quote($request_id)
	)->loadObject();
}

function view_form_buy_post($user_id): string
{
	$sp = settings('plans');

	$str = '<h1>' . $sp->p2p_trading_name . '</h1>';

	$str .= '<p style="margin-bottom: -3px; color: green;">When buying tokens using P2P, always contact the other party first for payment confirmation before sending any payment.</p>';
	$str .= '<p style="color: green;">After successfully completing the payment transaction, kindly take a screenshot of the proof of payment and share it with the other party as confirmation.</p>';

	$user = user($user_id);
	$account_type = $user->account_type;

	if ($account_type !== 'starter') {
		$str .= '<form method="post" onsubmit="submit.disabled=true; return true;">';
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<tr>';
		$str .= '<td>';

		$str .= '<div class="uk-grid"><div class="uk-width-1-1" data-uk-margin="">';
		$str .= '<button class="uk-button" style = "float:left"><strong>Buy:</strong></button>';
		$str .= '<input type="text" name="amount_buy_post_min" placeholder="Set Minimum Asset" id="amount_buy_post" style = "float:left">';
		$str .= '<input type="text" name="amount_buy_post" placeholder="Set Maximum Asset" id="amount_buy_post" style = "float:left">';
		$str .= view_type_buy_post_select($user_id);
		$str .= '</div></div>';

		$str .= '<div class="uk-grid"><div class="uk-width-1-1" data-uk-margin="">';
		//	$str .= '<input type="text" name="price_buy_post" placeholder="Preferred Price (' .
//		settings('ancillaries')->currency . ')" id="price_buy_post" style = "float:left">';
		$str .= view_method_buy_post_select($user_id);
		$str .= '<input type="submit" name="submit" value="Submit" class="uk-button uk-button-primary">';
		$str .= '</div></div>';

		$str .= '</td>';
		$str .= '</tr>';
		$str .= '</table>';
		$str .= '</form>';
	}

	$str .= script_type_method();

	return $str;
}

function view_type_buy_post_select($user_id): string
{
	$user = user($user_id);

	$pmu = arr_payment_method($user);

	$str = '<select name="type_buy_post" id="type_buy_post" style="float:left">';
	$str .= '<option value="none" selected>Select Currency</option>';

	if (!empty($pmu)) {
		foreach ($pmu as $k => $v) {
			if (!in_array($k, ['bank', 'gcash', 'maya'])) {
				$str .= '<option value="' . $k . '">' . strtoupper($k) . '</option>';
			}
		}
	}

	$str .= '</select>';

	return $str;
}

function view_method_buy_post_select($user_id): string
{
	$user = user($user_id);

	$pmu = arr_payment_method($user);

	$str = '<select name="method_buy_post" id="method_buy_post" style="float:left">';
	$str .= '<option value="none" selected>Currency Payment Method</option>';

	if (!empty($pmu)) {
		foreach ($pmu as $k => $v) {
			if (!is_array($v)) {
				$str .= '<option value="' . $k . '"' .
					/*($k === 'btc3' ? ' selected' : '') .*/
					'>' . strtoupper($k) . '</option>';
			} elseif (!empty($v)) {
				foreach ($v as $x => $y) {
					if (!empty($x)) {
						$str .= '<option value="' . $k . '">' . strtoupper($k) . '</option>';
					}

					break;
				}
			}
		}
	}

	$str .= '</select>';

	return $str;
}

function script_type_method(): string
{
	return '<script>
	    (function ($) {
	        toggleTypeMethod($);
	
	        $("#type_buy_post").change(function () {
	            toggleTypeMethod($);
	        });
	    })(jQuery);
	
	    function toggleTypeMethod($) {
	        const type = $("#type_buy_post");
            const method = $("#method_buy_post");
            
            const val = type.val();
            
            method.children("option").show();
            
            if (val !== "none") {
                method.children("option[value=" + val + "]").hide();
            }
            
	        return false;
	    }
	</script>';
}

/**
 * @param $cid
 *
 * @param $gp
 * @param $dr
 *
 * @since version
 */
function process_delete_request($cid, $gp, $dr)
{
	$db = db();

	if ((time() - $dr) > $gp) {
		application()->redirect(
			Uri::root(true) . '/' . sef(55),
			'Request is now permanent and cannot be cancelled!',
			'warning'
		);
	}

	try {
		$db->transactionStart();

		delete_request($cid);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(
		Uri::root(true) . '/' . sef(55),
		'Request deleted successfully!',
		'notice'
	);
}

/**
 * @param $cid
 *
 *
 * @since version
 */
function delete_request($cid)
{
	delete(
		'network_p2p_token_sale',
		['request_id = ' . db()->quote($cid)]
	);
}

/**
 * @param $user_id
 *
 * @since version
 */
function validate_buyer($user_id)
{
	$buyer = user($user_id);

	$app = application();

	//payment method
	validate_payment_method($buyer);

	$arr_contact = arr_contact_info($buyer);

	// contact
	if (empty($arr_contact)) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $buyer->id,
			'Your Contact Information is Required for Verification.',
			'error'
		);
	}

	// fullname
	if (empty($buyer->fullname)) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $buyer->id,
			'Your Full Name is Required for Verification.',
			'error'
		);
	}
}

function validate_payment_method($user)
{
	$app = application();

	$payment_method = arr_payment_method($user);

	if (empty($payment_method)) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user->id,
			'Buyer Wallet Address is Required as your Payment Method.',
			'error'
		);
	} else {
		$no_address = true;

		foreach ($payment_method as $v) {
			if (!empty($v)) {
				$no_address = false;
			}

			break;
		}

		if ($no_address) {
			$app->redirect(
				Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user->id,
				'Buyer Wallet Address is Required as your Payment Method.',
				'error'
			);
		}
	}
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
 * @param           $user_id
 * @param           $value
 * @param           $sell_id
 *
 * @since version
 */
function validate_input($user_id, $value, $sell_id)
{
	$seller = posting_single($sell_id);

	$amount_remaining = $seller->amount_remaining;
	$amount_minimum = $seller->amount_minimum;
	$type = $seller->type;

	$user_buyer = user($user_id);
	$bank_buyer = arr_payment_method($user_buyer);

	$app = application();

	if (empty($bank_buyer[$seller->type])) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please fill Up ' . strtoupper($seller->type) . ' Wallet Address.',
			'error'
		);
	}

	if (empty($bank_buyer[$seller->method])) {
		$app->redirect(
			Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please fill Up ' . strtoupper($seller->method) . ' Payment Method.',
			'error'
		);
	}

	if ($value > $amount_remaining) {
		$app->redirect(
			Uri::root(true) . '/' . sef(55),
			'Asset remaining for Sale is ' . $amount_remaining . ' ' . strtoupper($type),
			'error'
		);
	}

	if ($value < $amount_minimum) {
		$app->redirect(
			Uri::root(true) . '/' . sef(55),
			'Minimum amount is ' . $amount_minimum . ' ' . strtoupper($type),
			'error'
		);
	}
}

/**
 * @param $user_id
 * @param $value
 * @param $price_total
 * @param $sell_id
 *
 * @return false|mixed
 * @since version
 */
function insert_request($user_id, $value, $price_total, $sell_id)
{
	$db = db();

	return insert(
		'network_p2p_token_sale',
		[
			'sale_id',
			'buyer_id',
			'amount',
			'total',
			'date_requested'
		],
		[
			$db->quote($sell_id),
			$db->quote($user_id),
			$db->quote($value),
			$db->quote($price_total),
			$db->quote(time())
		]
	);
}

/**
 * @param $user
 *
 * @return array
 *
 * @since version
 */
function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

function price_usd($method)
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

		// if (in_array($currency, ['B2P', 'AET', 'TPAY', 'BTCB', /*'BTC3', 'BTCW', 'GOLD', 'PAC', 'P2P',*/ 'PESO'])) {
		// 	$price_res = 1 / price_coinbrain($currency);
		// } else {
		// 	$price_method = token_price($currency)['price'];
		// 	$price_base = token_price('USDT')['price'];

		// 	$price_res = $price_base / $price_method;
		// }

		$results = token_price(strtoupper($currency));
		$price_res = $results['price']; // USD / method
	}

	return $price_res;
}

function process_add_buy_post(
	$user_id,
	$amount_buy_post,
	$amount_buy_post_min,
	$type_buy_post,
	$method_buy_post
) {
	$db = db();

	validate_input_buy_post(
		$user_id,
		$amount_buy_post,
		$amount_buy_post_min,
		$type_buy_post,
		$method_buy_post
	);

	$user = user($user_id);
	$account_type = $user->account_type;
	$se = settings('entry');
	$buffer = $se->{$account_type . '_p2p_share'};

	$price_buy_post = price_usd($type_buy_post) * (1 - $buffer / 100);

	$contacts = arr_contact_info($user);

	$str_contact = '';

	if (!empty($contacts)) {
		foreach ($contacts as $k => $v) {
			$str_contact .= ucwords($k) . ': ' . $v . '<br>';
		}
	}

	$message = '
			Username: ' . $user->username . '<br>
			Full Name: ' . $user->fullname . '<br>
			Email: ' . $user->email . '<br>' .
		$str_contact .
		'Date Posted: ' . time() . '<br>
			Amount: ' . $amount_buy_post . '<br>
			Type: ' . strtoupper($type_buy_post) . '<br>
			Price: ' . $price_buy_post;

	$price_total = (double) $amount_buy_post * (double) $price_buy_post;

	try {
		$db->transactionStart();

		if ($price_total > 0) {
			insert_buy_posting(
				$user_id,
				$amount_buy_post,
				$amount_buy_post_min,
				$type_buy_post,
				$method_buy_post,
				$price_buy_post
			);

			send_mail($message, 'P2P Token Buyer Posting', [$user->email]);
		}

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(
		Uri::root(true) . '/' . sef(55),
		'P2P Token Buyer Posting Successful',
		'success'
	);
}

function insert_buy_posting($user_id, $amount, $amount_min, $type, $method, $price)
{
	$db = db();

	return insert(
		'network_p2p_token_sale',
		[
			'buyer_id',
			'amount_pending',
			'amount_minimum',
			'type_buy',
			'method_buy',
			'price_buy',
			'total',
			'date_requested'
		],
		[
			$db->quote($user_id),
			$db->quote($amount),
			$db->quote($amount_min),
			$db->quote($type),
			$db->quote($method),
			$db->quote($price),
			$db->quote($amount * $price),
			$db->quote(time())
		]
	);
}

function validate_input_buy_post($user_id, $amount, $amount_min, $type, $method)
{
	$app = application();

	if ($type === $method) {
		$app->redirect(
			Uri::root(true) . '/' . sef(55) . qs() . 'uid=' . $user_id,
			'Your Payment Method Must be Different from the Type.',
			'error'
		);
	}

	if ($amount <= 0) {
		$app->redirect(
			Uri::root(true) . '/' . sef(55),
			'Maximum Value is Required!',
			'error'
		);
	}

	if ($amount_min <= 0) {
		$app->redirect(
			Uri::root(true) . '/' . sef(55),
			'Minimum Value is Required!',
			'error'
		);
	}

	//	if ($price <= 0)
//	{
//		$app->redirect(Uri::root(true) . '/' . sef(55),
//			'Please enter valid price!', 'error');
//	}
}

/**
 * @param $user_id
 * @param $value
 * @param $sell_id
 * @param $type
 *
 * @since version
 */
function process_add_request($user_id, $value, $sell_id, $type)
{
	$db = db();

	$app = application();

	validate_input($user_id, $value, $sell_id);

	$user_buyer = user($user_id);

	$posting = posting_single($sell_id);

	$amount_remaining = $posting->amount_remaining;
	$price = $posting->price;

	//	$price = (1 / price_usd($type)) * (1 - settings('ancillaries')->p2p_price_buffer / 100);

	$user_seller = user($posting->seller_id);

	$method_seller = $posting->method;

	$total = (double) $value * (double) $price;

	if (in_array($method_seller, ['bank', 'gcash', 'maya'])) {
		$currency = 'PHP';

		$php_price_usd = php_price_usd();

		$price_php = 0;

		if ($php_price_usd && isset($php_price_usd['tether']['php'])) {
			//			$ask = $php_price_usd['market']['ask'];
//			$bid = $php_price_usd['market']['bid'];
//
//			$price_php = ($ask + $bid) / 2;

			$price_php = $php_price_usd['tether']['php'];
		}

		$price_total = $total * $price_php; // PHP
	} else {
		$currency = strtoupper($method_seller);

		// if (in_array($currency, ['B2P', 'AET', 'TPAY', /*'BTC3', 'BTCB', 'BTCW', 'GOLD', 'PAC', 'P2P',*/ 'PESO'])) {
		// 	$price_total = $total / price_coinbrain($currency);
		// } else {
		// 	$price_method = token_price($currency)['price'];
		// 	$price_base = token_price('USDT')['price'];

		// 	$price_total = ($price_base / $price_method) * $total;
		// }

		$results = token_price(strtoupper($currency));
		$price = $results['price']; // USD / method

		return $total / $price; // (USD) / (USD / method) => method
	}

	$contact_info_seller = arr_contact_info($user_seller);

	$messenger_seller = '';
	$mobile_seller = '';
	$landline_seller = '';

	if (!empty($contact_info_seller)) {
		$messenger_seller = $contact_info_seller['messenger'] ?? '';
		$mobile_seller = $contact_info_seller['mobile'] ?? '';
		$landline_seller = $contact_info_seller['landline'] ?? '';
	}

	$contact_seller = $messenger_seller ? '<p>Seller Messenger URL: ' . $messenger_seller . '</p>' : '';
	$contact_seller .= $mobile_seller ? '<p>Seller Mobile Number: ' . $mobile_seller . '</p>' : '';
	$contact_seller .= $landline_seller ? '<p>Seller Landline Number: ' . $landline_seller . '</p>' : '';

	// mail buyer
	$message_buyer = '
			Seller Username: ' . $user_seller->username . '<br>
			Seller Full Name: ' . $user_seller->fullname . '<br>
			Seller Email: ' . $user_seller->email . '<br>';

	$message_buyer .= $contact_seller;

	$message_buyer .= 'Payment Method: ' . strtoupper($posting->method) . '<br>
			Date Requested: ' . time() . '<hr>
			Seller Amount: ' . $amount_remaining . ' ' . strtoupper($posting->type) . '<br>
			Seller Price: ' . $price . ' ' . $currency . '<hr>
			Buyer Amount: ' . $value . ' ' . strtoupper($posting->type) . '<br>
			Total: ' . $price_total . ' ' . $currency;

	$contact_info_buyer = arr_contact_info($user_buyer);

	$messenger_buyer = '';
	$mobile_buyer = '';
	$landline_buyer = '';

	if (!empty($contact_info_buyer)) {
		$messenger_buyer = $contact_info_buyer['messenger'] ?? '';
		$mobile_buyer = $contact_info_buyer['mobile'] ?? '';
		$landline_buyer = $contact_info_buyer['landline'] ?? '';
	}

	$contact_buyer = $messenger_buyer ? '<p>Buyer Messenger URL: ' . $messenger_buyer . '</p>' : '';
	$contact_buyer .= $mobile_buyer ? '<p>Buyer Mobile Number: ' . $mobile_buyer . '</p>' : '';
	$contact_buyer .= $landline_buyer ? '<p>Buyer Landline Number: ' . $landline_buyer . '</p>' : '';

	// mail buyer
	$message_seller = '
			Buyer Username: ' . $user_buyer->username . '<br>
			Buyer Full Name: ' . $user_buyer->fullname . '<br>
			Buyer Email: ' . $user_buyer->email . '<br>';

	$message_seller .= $contact_buyer;

	$message_seller .= 'Payment Method: ' . strtoupper($posting->method) . '<br>
			Date Requested: ' . time() . '<hr>
			Seller Amount: ' . $amount_remaining . ' ' . strtoupper($posting->type) . '<br>
			Seller Price: ' . $price . ' ' . $currency . '<hr>
			Buyer Amount: ' . $value . ' ' . strtoupper($posting->type) . '<br>
			Total: ' . $price_total . ' ' . $currency;

	try {
		$db->transactionStart();

		insert_request($user_id, $value, $price_total, $sell_id);

		send_mail($message_buyer, 'P2P Token Buyer Request', [$user_buyer->email]);
		send_mail($message_seller, 'P2P Token Buyer Request', [$user_seller->email]);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	$app->redirect(
		Uri::root(true) . '/' . sef(55),
		'P2P Token Buyer Request Successful',
		'success'
	);
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

//function is_localhost(array $whitelist = ['127.0.0.1', '::1']): bool
//{
//	return in_array($_SERVER['REMOTE_ADDR'], $whitelist, true);
//}

/**
 *
 * @param $sell_id
 *
 * @return string
 *
 * @since version
 */
function view_form($sell_id): string
{
	return '
		<div class="uk-form uk-grid-margin uk-row-first">
			<form method="post" onsubmit="submit.disabled=true; return true;">
				<input type="hidden" name="sell_id" value="' . $sell_id . '">' .
		/*'<input type="hidden" name="amount" value="' . $amount . '">
																					  <input type="hidden" name="price" value="' . $price . '">' .*/
		'<fieldset>
                    <legend>Fill Up Desired Amount to Buy</legend>
                    <div class="uk-form-row">
                        <input type="text" placeholder="Amount" name="value" class="uk-width-1-1">
                    </div>
                    
                    <div class="uk-form-row">
                        <input type="submit" name="submit" value="Submit" class="uk-button uk-button-success">
                    </div>
                </fieldset>
            </form>
        </div>';
}

/**
 *
 * @param        $user_id
 * @param        $p_pst
 * @param   int  $rows
 *
 * @return string
 *
 * @since version
 */
function view_sell_postings($user_id, $p_pst, int $rows = 5): string
{
	$str = '<div class="uk-panel uk-text-left">
        <table class="category table table-bordered table-hover">
            <tr>
                <td>
                    <section id="tm-top-b" class="tm-top-b uk-grid" 
                        data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
                        <div class="uk-width-1-1">
                            <div class="uk-panel uk-panel-box uk-text-left">';

	$str .= '<h2>Token Available Sell</h2>';

	$limit_to = $rows;
	$limit_from = $limit_to * $p_pst;

	$postings = postings_desc_lim($user_id, $limit_from, $limit_to);

	$str .= paginate($p_pst, postings_all($user_id), 55, $rows, 'pst');

	if (empty($postings)) {
		$str .= '<hr><p>No postings yet.</p>';
	} else {
		$str .= '
			<table class="category table table-striped table-bordered table-hover">
	            <thead>
		            <tr>
		                <th>Date Posted</th>
		                <th>Amount</th>		               
		                <th>Rate</th>
		                <th>Final</th>
		                <th>Method</th>
		                <th>Status</th>
		                <th>Option</th>
		            </tr>
	            </thead>
            <tbody id="p2p_sell_postings_all">';

		foreach ($postings as $posting) {
			$str .= view_posting_single($posting, $user_id);
		}

		$str .= '</tbody>
        </table> ';
	}

	$str .= '</div>
                        </div>
                    </section>
                </td>
            </tr>
        </table>
    </div>
    <br>';

	return $str;
}

function view_requests($user_id, $p_rq, $grace_period, int $rows = 5): string
{
	$limit_to = $rows;
	$limit_from = $limit_to * $p_rq;

	$requests = requests_desc_lim($user_id, $limit_from, $limit_to);

	$str = '<div class="uk-panel uk-text-left">
        <table class="category table table-bordered table-hover">
            <tr>
                <td>
                    <section id="tm-top-b" class="tm-top-b uk-grid" 
                        data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
                        <div class="uk-width-1-1">
                            <div class="uk-panel uk-panel-box uk-text-left">';

	$str .= ' <h2>Order History</h2> ';

	$str .= paginate($p_rq, requests_all($user_id), 55, $rows, 'rq');

	if (empty($requests)) {
		$str .= '<hr><p>No requests yet.</p>';
	} else {
		$str .= '
			<table class="category table table-striped table-bordered table-hover">
	            <thead>
		            <tr>
		                <th>Date Requested</th>
		                <th>Amount</th>	
		                <th>Rate</th>	               
		                <th>Total</th>
		                <th>Method</th>
		                <th>Status</th>
		                <th>Option</th>
		            </tr>
	            </thead>
            <tbody id="p2p_buyer_requests">';

		foreach ($requests as $request) {
			$str .= view_request_single($request, $grace_period);
		}

		$str .= '</tbody>
        	</table> ';
	}

	$str .= '</div>
                        </div>
                    </section>
                </td>
            </tr>
        </table>
    </div>
    <br>';

	return $str;
}

/**
 * @param $posting
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_posting_single($posting, $user_id): string
{
	$sell_id = $posting->sell_id;
	$purchase_id = $posting->purchase_id;
	$seller_id = $posting->seller_id;
	$date_posted = $posting->date_posted;
	$date_updated = $posting->date_updated;
	$amount_remaining = $posting->amount_remaining;
	$amount_sold = $posting->amount_sold;
	$total_sell = $posting->total_sell;
	$type = $posting->type;
	$method = $posting->method;

	$user_seller = user($seller_id);

	$currency = $method;

	if (in_array($currency, ['bank', 'gcash', 'maya'])) {
		$currency = 'PHP';
	}

	$request = request_single($purchase_id);

	//	$buyer_id = $request->buyer_id;

	$amount = $purchase_id ? $amount_sold : $amount_remaining;

	$final_rep = $purchase_id ? number_format($total_sell, 18) . ' ' . strtoupper($currency) : '-----';

	$str = '<tr>';
	$str .= '<td> ' . date('M j, Y - g:i A', $date_posted) . ' </td>';
	$str .= '<td> ' . number_format($amount, 8) . ' ' . strtoupper($type) . '</td>';
	$str .= '<td> ' . number_format($posting->price, 18) . ' ' .
		/*settings('ancillaries')->currency*/
		'USD' . '</td>';
	$str .= '<td> ' . $final_rep . '</td>';
	$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' .
		strtoupper($method) . '" data-uk-modal="{target:\'#modal-method-buy-' . $sell_id . '\'}"' . '></td>';

	$str .= '<div id="modal-method-buy-' . $sell_id .
		'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 120px">
	            <div class="uk-modal-dialog" style="text-align: center">
	                <button type="button" class="uk-modal-close uk-close"></button>';

	if (!in_array($method, ['bank', 'gcash', 'maya'])) {
		$str .= '<img src="images/trust-wallet.svg" alt=""><br>';
	}

	$str .= $user_seller->username ? ('<p>Seller Username: <b>' . $user_seller->username . '</b></p>') : '';
	$str .= $user_seller->fullname ? ('<p>Seller Full Name: <b>' . $user_seller->fullname . '</b></p>') : '';
	$str .= $user_seller->email ? ('<p>Seller E-mail: <b>' . $user_seller->email . '</b></p>') : '';

	$contact_info = arr_contact_info($user_seller);

	$messenger = '';
	$mobile = '';
	$landline = '';

	if (!empty($contact_info)) {
		$messenger = $contact_info['messenger'] ?? '';
		$mobile = $contact_info['mobile'] ?? '';
		$landline = $contact_info['landline'] ?? '';
	}

	$str .= $messenger ? '<p>Seller Messenger URL: <b>' . $messenger . '</b></p>' : '';
	$str .= $mobile ? '<p>Seller Mobile Number: <b>' . $mobile . '</b></p>' : '';
	$str .= $landline ? '<p>Seller Landline Number: <b>' . $landline . '</b></p>' : '';

	$seller_payment_method = arr_payment_method($user_seller);

	$wallet_seller = $seller_payment_method[$method];

	if ($purchase_id) {
		if (!in_array($method, ['bank', 'gcash', 'maya'])) {
			$str .= '<p>Upon transfer confirmation, you can now pay<br><br> <b>' . number_format($total_sell, 18) .
				'</b> ' . strtoupper($currency) . '<br><br> to the following Wallet Address:</p>';
			$str .= '<p><b>' . $wallet_seller . '</b></p>';

			$str .= '<img src="' . qr_code_generate($wallet_seller) .
				'" alt="QR Code Trust Wallet" style="width:250px;">';
		} elseif ($method === 'bank') {
			$bank_name = '';
			$bank_account = '';

			foreach ($wallet_seller as $k => $v) {
				$bank_name = strtoupper($k);
				$bank_account = $v;

				break;
			}

			$str .= '<p>Upon transfer confirmation, you can now pay <b>' . number_format($total_sell, 18) .
				'</b> ' . strtoupper($currency) . ' to the following ' . $bank_name . ' Account:</p>';
			$str .= '<p><b>' . $bank_account . '</b></p>';
		} elseif ($method === 'gcash') {
			$str .= '<p>Upon transfer confirmation, you can now pay <b>' . number_format($total_sell, 18) .
				'</b> ' . strtoupper($currency) . ' to the following G-Cash Number:</p>';
			$str .= '<p><b>' . $wallet_seller . '</b></p>';
		}
	} else {
		if (!in_array($method, ['bank', 'gcash', 'maya'])) {
			$str .= '<p>Seller Wallet Address:</p> <p><b>' . $wallet_seller . '</b></p>';
			$str .= '<img src="' . qr_code_generate($wallet_seller) .
				'" alt="QR Code Trust Wallet" style="width:250px;">';
		} elseif ($method === 'bank') {
			$bank_name = '';
			$bank_account = '';

			foreach ($wallet_seller as $k => $v) {
				$bank_name = strtoupper($k);
				$bank_account = $v;

				break;
			}

			$str .= '<p>Seller <b>' . $bank_name . ' Account: ' . $bank_account . '</b></p>';
		} elseif ($method === 'gcash') {
			$str .= '<p>Seller G-Cash Number: <b>' . $wallet_seller . '</b></p>';
		}
	}

	$str .= '</div>';
	$str .= '</div>';

	//status
	if ($purchase_id) {
		if ((int) $date_updated > 0) {
			$status = '<span class="uk-badge uk-badge-warning uk-badge-notification">Pending</span>';
		} else {
			if ((int) $date_updated === 0) {
				$status = '<span class="uk-badge uk-badge-success uk-badge-notification">Active</span>';
			} else {
				$status = '<span class="uk-badge uk-badge-warning uk-badge-notification">Denied</span>';
			}
		}
	} else {
		$status = '<span class="uk-badge uk-badge-success uk-badge-notification">Active</span>';
	}

	$str .= '<td> ' . $status . '</td>';

	if ($purchase_id) {
		if ($request->buyer_id === $user_id) {
			$str .= '<td><input type="button" class="uk-button uk-button-primary" value="Confirm" 
				data-uk-modal="{target:\'#modal-confirm-' . $sell_id . '\'}"></td>';

			$str .= view_modal_sell_confirm($sell_id, $seller_id, $date_posted, $amount, $type, $total_sell, $method);
		} else {
			$str .= '<td>N/A</td>';
		}
	} else {
		$str .= '<td><input type="button" class="uk-button uk-button-primary" value="Buy" 
				data-uk-modal="{target:\'#modal-buy-' . $sell_id . '\'}"' . '></td>';

		// modal start
		$str .= '<div id="modal-buy-' . $sell_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
		$str .= '<h3><strong>Details</strong></h3>';
		$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">';

		$str .= '<h4 class="uk-panel-title"><strong>Date Posted:</strong> ' .
			date('M j, Y - g:i A', $date_posted) . '</h4>';

		$str .= '<h4 class="uk-panel-title"><strong>Amount for Sale:</strong> ' .
			number_format($posting->amount_remaining, 8) . ' ' . strtoupper($type) . '</h4>';

		$str .= '<h4 class="uk-panel-title"><strong>Price: </strong> ' .
			number_format($posting->price, 18) . ' ' . /*settings('ancillaries')->currency*/
			'USD' . '</h4>';

		$str .= '<h4 class="uk-panel-title"><strong>Payment Method:</strong> ' . strtoupper($method) . '</h4>';

		$str .= '</div>';

		$str .= view_form($sell_id);

		$str .= '</div>
		        </div>';
		// modal end
	}

	$str .= '</tr> ';

	return $str;
}

function view_modal_sell_confirm($sell_id, $seller_id, $date_posted, $amount, $type, $total_sell, $method): string
{
	$type = strtoupper($type);

	$user_seller = user($seller_id);

	$payment_method_seller = arr_payment_method($user_seller);

	$contact_info = arr_contact_info($user_seller);

	$messenger = '';
	$mobile = '';
	$landline = '';

	if (!empty($contact_info)) {
		$messenger = $contact_info['messenger'] ?? '';
		$mobile = $contact_info['mobile'] ?? '';
		$landline = $contact_info['landline'] ?? '';
	}

	$currency = $method;

	if (in_array($currency, ['bank', 'gcash', 'maya'])) {
		$currency = 'PHP';
	}

	$str = '<div id="modal-confirm-' . $sell_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 150px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
	$str .= '<p><strong>Please verify and check the following details, from the Seller, upon confirmation:</strong></p>';
	$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">';
	$str .= '<p>Date Posted: <b>' . date('M j, Y - g:i A', $date_posted) . '</b></p>';
	$str .= '<p>Asset Sold: <b>' . number_format($amount, 8) . ' ' . $type . '</b></p>';
	$str .= '<p>Total Sell: <b>' . number_format($total_sell, 18) . ' ' .
		strtoupper($currency) . '</b></p>';
	$str .= $user_seller->username ? ('<p>Seller Username: <b>' . $user_seller->username . '</b></p>') : '';
	$str .= $user_seller->fullname ? ('<p>Seller Full Name: <b>' . $user_seller->fullname . '</b></p>') : '';
	$str .= $user_seller->email ? ('<p>Seller E-mail: <b>' . $user_seller->email . '</b></p>') : '';

	//	$contact_info = arr_contact_info($user_buyer);

	$str .= $messenger ? '<p>Seller Messenger URL: <b>' . $messenger . '</b></p>' : '';
	$str .= $mobile ? '<p>Seller Mobile Number: <b>' . $mobile . '</b></p>' : '';
	$str .= $landline ? '<p>Seller Landline Number: <b>' . $landline . '</b></p>' : '';

	//	$str .= '<p>Buyer Contact Info: <b>' . $user_buyer->contact . '</b></p>';

	if (!in_array($method, ['bank', 'gcash', 'maya'])) {
		$str .= '<p>Seller Wallet Address: <b>' . $payment_method_seller[$method] . '</b></p>';
	} elseif ($method === 'bank') {
		$bank_name = '';
		$bank_account = '';

		foreach ($payment_method_seller[$method] as $k => $v) {
			$bank_name = strtoupper($k);
			$bank_account = $v;

			break;
		}

		$str .= '<p>Seller ' . $bank_name . ' Account: <b>' . $bank_account . '</b></p>';
	} elseif ($method === 'gcash') {
		$str .= '<p>Seller G-Cash Number: <b>' . $payment_method_seller[$method] . '</b></p>';
	}

	$str .= '</div>';
	$str .= '<div class="uk-modal-footer" style="text-align: right">								
				<a href="' . sef(55) . qs() . 'did=' . $sell_id . '" type="button" class="uk-button uk-button-primary">Deny</a>						
				<a href="' . sef(55) . qs() . 'aid=' . $sell_id . '" type="button" class="uk-button uk-button-primary">Approve</a>
			</div>';
	$str .= '</div>
		        </div>';

	return $str;
}

/**
 * @param $request
 * @param $grace_period
 *
 * @return string
 *
 * @since version
 */
function view_request_single($request, $grace_period): string
{
	$request_id = $request->request_id;
	$sale_id = $request->sale_id;
	$buyer_id = $request->buyer_id;
	$date_requested = $request->date_requested;
	$date_confirmed = $request->date_confirmed;
	$amount = $request->amount;
	$amount_pending = $request->amount_pending;
	$method_buyer = $request->method_buy;
	$price_buyer = $request->price_buy;
	$type_buyer = $request->type_buy;
	$total = $request->total;

	$posting = posting_single($sale_id);

	$seller_id = $posting->seller_id ?? 0;
	//	$purchase_id   = $posting->purchase_id ?? 0;
	$method_seller = $posting->method ?? '';
	$type_seller = $posting->type ?? '';
	$price_seller = $posting->price ?? 0;

	$price = $amount_pending > 0 ? $price_buyer : $price_seller;

	$type = $type_seller ?: $type_buyer;

	$user = user($seller_id) ?: user($buyer_id);
	$bank = arr_payment_method($user);

	$method = $method_seller ?: $method_buyer;

	$wallet = $bank[$method] ?? '';

	$currency = $method;

	if (in_array($currency, ['bank', 'gcash', 'maya'])) {
		$currency = 'PHP';
	}

	$amount_rep = $amount_pending ?: $amount;

	$total_rep = !($amount_pending > 0) ? number_format($total, 18) . ' ' .
		strtoupper(!empty($posting) ? $currency : /*settings('ancillaries')->currency*/ 'USD') : '-----';

	$str = '<tr>';
	$str .= '<td> ' . date('M j, Y - g:i A', $date_requested) . ' </td>';
	$str .= '<td> ' . number_format($amount_rep, 8) . ' ' . strtoupper($type) . '</td>';
	$str .= '<td> ' . number_format($price, 18) . ' ' . 'USD' . '</td>';
	$str .= '<td> ' . $total_rep . '</td>';

	$disable_method = $amount_pending > 0 || $date_confirmed > 0 ? ' disabled' : '';

	$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' .
		strtoupper($method) . '" data-uk-modal="{target:\'#modal-method-' . $request_id . '\'}"' .
		$disable_method . '></td>';

	$str .= '<div id="modal-method-' . $request_id .
		'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 120px">
	            <div class="uk-modal-dialog" style="text-align: center">
	                <button type="button" class="uk-modal-close uk-close"></button>';

	if (!in_array($method, ['bank', 'gcash', 'maya'])) {
		$str .= '<img src="images/trust-wallet.svg" alt=""><br>';
		$str .= '<img src="' . qr_code_generate($wallet) . '" alt="QR Code Trust Wallet" style="width:250px;">';
	}

	$contact_info = arr_contact_info($user);

	$messenger = '';
	$mobile = '';
	$landline = '';

	if (!empty($contact_info)) {
		$messenger = $contact_info['messenger'] ?? '';
		$mobile = $contact_info['mobile'] ?? '';
		$landline = $contact_info['landline'] ?? '';
	}

	if (!empty($posting)) {
		$str .= $user->username ? ('<p>Seller Username: <b>' . $user->username . '</b></p>') : '';
		$str .= $user->fullname ? ('<p>Seller Full Name: <b>' . $user->fullname . '</b></p>') : '';
		$str .= $user->email ? ('<p>Seller Email: <b>' . $user->email . '</b></p>') : '';
		$str .= $messenger ? '<p>Seller Messenger URL: <b>' . $messenger . '</b></p>' : '';
		$str .= $mobile ? '<p>Seller Mobile Number: <b>' . $mobile . '</b></p>' : '';
		$str .= $landline ? '<p>Seller Landline Number: <b>' . $landline . '</b></p>' : '';
	} else {
		$str .= $user->username ? ('<p>Buyer Username: <b>' . $user->username . '</b></p>') : '';
		$str .= $user->fullname ? ('<p>Buyer Full Name: <b>' . $user->fullname . '</b></p>') : '';
		$str .= $user->email ? ('<p>Buyer Email: <b>' . $user->email . '</b></p>') : '';
		$str .= $messenger ? '<p>Buyer Messenger URL: <b>' . $messenger . '</b></p>' : '';
		$str .= $mobile ? '<p>Buyer Mobile Number: <b>' . $mobile . '</b></p>' : '';
		$str .= $landline ? '<p>Buyer Landline Number: <b>' . $landline . '</b></p>' : '';
	}

	if (!empty($posting)) {
		if (!in_array($method, ['bank', 'gcash', 'maya'])) {
			$str .= '<p>Please pay <b>' . number_format($total, 18) . '</b> ' . strtoupper($currency) .
				'</p> <p>to the following address:</p>
	                <p><b>' . $wallet . '</b></p>';
		} else {
			if ($method === 'bank') {
				$bank_name = '';
				$account_number = '';

				foreach ($wallet as $k => $v) {
					$bank_name = strtoupper($k);
					$account_number = $v;
				}

				$str .= '<p>Please pay <b>' . number_format($total, 18) . '</b> ' . strtoupper($currency) .
					' to the following Bank Account:</p>';
				$str .= '<p>Bank Name: <b>' . $bank_name . '</b></p>';
				$str .= '<p>Account Number: <b>' . $account_number . '</b></p>';
			} elseif ($method_seller === 'gcash') {
				$str .= '<p>Please pay <b>' . number_format($total, 18) . '</b> ' . strtoupper($currency) .
					' to the following G-Cash Number:</p>
	                <p><b>' . $wallet . '</b></p>';
			} elseif ($method_seller === 'maya') {
				$str .= '<p>Please pay <b>' . number_format($total, 18) . '</b> ' . strtoupper($currency) .
					' to the following Maya Number:</p>
	                <p><b>' . $wallet . '</b></p>';
			}
		}
	}

	$str .= '</div>
	        </div>';

	if ((int) $date_confirmed > 0) {
		$status = '<span class="uk-badge uk-badge-success uk-badge-notification">Confirmed</span>';
	} else {
		if ((int) $date_confirmed === 0) {
			$status = !($amount_pending > 0) ? '<span class="uk-badge uk-badge-warning uk-badge-notification">Pending</span>' :
				'<span class="uk-badge uk-badge-success uk-badge-notification">Active</span>';
		} elseif ((int) $date_confirmed === -1) {
			$status = '<span class="uk-badge uk-badge-danger uk-badge-notification">Denied</span>';
		} else {
			$status = '<span class="uk-badge uk-badge-danger uk-badge-notification">Expired</span>';
		}
	}

	$str .= '<td> ' . $status . '</td>';

	//	$disable_cancel = (time() - $date_requested) > $grace_period || $date_confirmed > 0 ? ' disabled' : '';

	$str .= '<td><input type="button" class="uk-button uk-button-primary" value="Cancel" 
				data-uk-modal="{target:\'#modal-cancel-' . $request_id . '\'}"' . /*$disable_cancel .*/
		'></td>';

	$str .= '<div id="modal-cancel-' . $request_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
	$str .= '<p><strong>Are you sure, you want to cancel this request?</strong></p>';
	$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <h3 class="uk-panel-title"><strong>Date Requested:</strong> ' .
		date('M j, Y - g:i A', $date_requested) . '</h3>
                        <h3 class="uk-panel-title"><strong>Amount:</strong> ' .
		number_format($amount_rep, 8) . ' ' . strtoupper($type) . '</h3>
                        <h3 class="uk-panel-title"><strong>Total: </strong> ' .
		number_format($total, 18) . ' ' . /*strtoupper($currency)*/
		'USD' . '</h3>                        
                    </div>';
	$str .= '<div class="uk-modal-footer" style="text-align: right">
						<input type="button" class="uk-modal-close uk-button uk-button-primary" value="Close">
						<a href="' . sef(55) . qs() . 'cid=' . $request_id .
		'&gp=' . $grace_period . '&dr=' . $date_requested . '" 
							type="button" class="uk-button uk-button-primary">Confirm</a>
					</div>';
	$str .= '</div>
		        </div>';

	$str .= '</tr> ';

	return $str;
}

//function qr_code_generate($address): string
//{
////	$cht  = "qr";
////	$chs  = "300x300";
////	$chl  = $address;
////	$choe = "UTF-8";
////
////	return 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
//
//    $size = '300x300';
//    return "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($address) . "&size={$size}";
//
////    return 'https://qrcode.tec-it.com/API/QRCode?data=' . $address . '&backcolor=%23ffffff&istransparent=true';
//}

function qr_code_generate($address): string
{
	// Get the system's temporary directory
	$tempDir = sys_get_temp_dir();

	// Ensure the temporary directory is writable
	if (!is_writable($tempDir)) {
		throw new RuntimeException("Temporary directory is not writable.");
	}

	// Create a temporary image path
	$tempFile = tempnam($tempDir, 'qr');

	if ($tempFile === false) {
		throw new RuntimeException("Unable to create temporary file.");
	}

	// Generate the QR code and output it as an image
	QRcode::png($address, $tempFile, QR_ECLEVEL_L, 10);

	// Read the image file and encode it in base64
	$imageData = file_get_contents($tempFile);
	if ($imageData === false) {
		throw new RuntimeException("Unable to read temporary file.");
	}
	$imageData = base64_encode($imageData);

	// Remove the temporary file
	unlink($tempFile);

	// Return the image data as a base64-encoded string
	return 'data:image/png;base64,' . $imageData;
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
		case 'LTC':
			$contract = '0xaCB10B1bdb44960d886A867E75692Db0Db4A43b4';
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
		$results = $results[0];
		$price = $results->priceUsd;
	}

	return $price;
}

function postings_desc_lim($user_id, $limit_from, $limit_to, $order = 'sell_id'): array
{
	$db = db();

	//	return $db->setQuery(
//		'SELECT * ' .
//		'FROM network_p2p_sell_tokens ' .
//		'WHERE seller_id <> ' . $db->quote($user_id) .
//		' AND date_confirmed <= 0 ' .
//		'ORDER BY ' . $order . ' DESC ' .
//		'LIMIT ' . $limit_from . ', ' . $limit_to
//	)->loadObjectList();

	$return = [];

	$results = $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_sell_tokens ' .
		'WHERE date_confirmed <= 0 ' .
		'AND ((seller_id <> ' . $user_id .
		' AND purchase_id > 0 ' . /*$user_id .*/
		' AND amount_minimum = 0) ' .
		'OR (seller_id <> ' . $user_id .
		' AND amount_minimum > 0)) ' .
		'ORDER BY ' . $order . ' DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();

	foreach ($results as $result) {
		if ($result->purchase_id) {
			$request = request_single($result->purchase_id);

			if ($request->buyer_id === $user_id) {
				$return[] = $result;
			}
		} else {
			$return[] = $result;
		}
	}

	return $return;
}

function requests_desc_lim($user_id, $limit_from, $limit_to, $order = 'request_id')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_token_sale ' .
		'WHERE buyer_id = ' . $db->quote($user_id) .
		' AND date_confirmed <= 0 ' .
		'ORDER BY ' . $order . ' DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function postings_all($user_id): array
{
	$db = db();

	//	return $db->setQuery(
//		'SELECT * ' .
//		'FROM network_p2p_sell_tokens ' .
//		'WHERE seller_id <> ' . $db->quote($user_id) .
//		' AND date_confirmed <= 0'
//	)->loadObjectList();

	//	return $db->setQuery(
//		'SELECT * ' .
//		'FROM network_p2p_sell_tokens ' .
//		'WHERE date_confirmed <= 0 ' .
//		'AND ((seller_id <> ' . $user_id .
//		' AND purchase_id > 0 ' . /*$user_id .*/
//		' AND amount_minimum = 0) ' .
//		'OR (seller_id <> ' . $user_id .
//		' AND amount_minimum > 0))'
//	)->loadObjectList();

	$return = [];

	$results = $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_sell_tokens ' .
		'WHERE date_confirmed <= 0 ' .
		'AND ((seller_id <> ' . $user_id .
		' AND purchase_id > 0 ' . /*$user_id .*/
		' AND amount_minimum = 0) ' .
		'OR (seller_id <> ' . $user_id .
		' AND amount_minimum > 0))'
	)->loadObjectList();

	foreach ($results as $result) {
		if ($result->purchase_id) {
			$request = request_single($result->purchase_id);

			if ($request->buyer_id === $user_id) {
				$return[] = $result;
			}
		} else {
			$return[] = $result;
		}
	}

	return $return;
}

function requests_all($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_token_sale ' .
		'WHERE buyer_id = ' . $db->quote($user_id) .
		' AND date_confirmed <= 0'
	)->loadObjectList();
}

function posting_single($sell_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_sell_tokens ' .
		'WHERE sell_id = ' . $db->quote($sell_id)
	)->loadObject();
}

