<?php

namespace BPL\Jumi\P2P_Sell_Item;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/api_token_price.php';
require_once 'bpl/mods/api_coinbrain_token_price.php';
require_once 'bpl/mods/repeat_items.php';
require_once 'bpl/mods/category_items.php';
require_once 'bpl/mods/upload_image.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\API_Token_Price\main as token_price;
use function BPL\Mods\API\Coinbrain\TokenPrice\main as coinbrain_btc3;

use function BPL\Mods\Repeat_Items\items;
use function BPL\Mods\Repeat_Items\items_repeat;

use function BPL\Mods\Category_Items\cat_single;
use function BPL\Mods\Category_Items\view_modal_cat;
use function BPL\Mods\Category_Items\view_option_cat;
use function BPL\Mods\Category_Items\process_add_category;
use function BPL\Mods\Category_Items\process_update_category;
use function BPL\Mods\Category_Items\process_delete_category;

use function BPL\Mods\Upload_Image\main as upload_image;

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

//use function BPL\Mods\Helpers\page_reload;
use function bpl\Mods\Helpers\paginate;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\time;
use function BPL\Mods\Helpers\alert;

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

    $cat_name = input_get('cat_name', '', 'RAW');
    $cat_to_update = input_get('cat_to_update', '', 'RAW');
    $cat_to_delete = input_get('cat_to_delete', '', 'RAW');

    $item_name = input_get('item_name', '', 'RAW');
    $item_description = input_get('item_description', '', 'RAW');
    $item_details = input_get('item_details', '', 'RAW');
    $item_category = input_get('item_category', '', 'RAW');
    $amount_minimum = input_get('amount_minimum');
    $amount_maximum = input_get('amount_maximum');
    $item_price = input_get('item_price');
    $payment_method = input_get('payment_method');
    $item_picture = application()->input->files->get('item_picture');

    $pg = input_get('pg', 0);
    $cat = input_get('cat', 0);

    $stock_url = input_get('stock', 0);

    $rows = 10;

    /* *
    $request_id = input_get('request_id');
    $amount = input_get('amount');
    $amount_min = input_get('amount_min');
    $value_sell = input_get('value_sell');
    $type = input_get('type');
    $method = input_get('method');
    $price = input_get('price');

    $cid = input_get('cid');
    $gp = input_get('gp');
    $dp = input_get('dp');

    $aid = input_get('aid');
    $did = input_get('did');

    $rows = 5;

    $grace_period = 33000; // seconds

    $p_post = input_get('pst', 0);
    $p_request = input_get('rq', 0);
    /* */

    page_validate();

    $str = menu($usertype, $admintype, $account_type, $username, $user_id);

    validate_seller($user_id);

    /* */
    if ($amount_maximum !== '') {
        process_add_post(
            $user_id,
            $item_name,
            $item_category,
            $item_description,
            $item_details,
            $amount_maximum,
            $amount_minimum,
            $payment_method,
            $item_price,
            $item_picture
        );
    }

    /* *
    if ($value_sell !== '') {
        process_sell_request($user_id, $value_sell, $request_id);
    }

    if ($cid !== '') {
        process_delete_post($cid, $gp, $dp);
    }

    if ($aid !== '') {
        process_approve_request($aid);
    }

    if ($did !== '') {
        process_deny_request($did);
    }

    /* */

//    $str .= page_reload();

    if ($cat_name !== '' && $cat_to_update === '') {
        process_add_category($cat_name, 126);
    }

    if ($cat_to_update !== '' && $cat_name !== '') {
        process_update_category($cat_name, $cat_to_update, 126);
    }

    if ($cat_to_delete !== '' && $cat_name === '' && $cat_to_update === '') {
        process_delete_category($cat_to_delete, 126);
    }

    $str .= view_form_sell_post($user_id, $pg, $cat, $rows, $stock_url);

    /* *
    $str .= view_sell_postings($user_id, $p_post, $grace_period, $rows);
    $str .= view_requests($user_id, $p_request, $rows);
    /* */

    echo $str;
}

//function process_add_category($cat_add)
//{
//    $db = db();
//
//    try {
//        $db->transactionStart();
//
//        insert_category($cat_add);
//
//        $db->transactionCommit();
//    } catch (Exception $e) {
//        $db->transactionRollback();
//
//        ExceptionHandler::render($e);
//    }
//
//    application()->redirect(Uri::root(true) . '/' . sef(126),
//        'Product Category Added Successfully!', 'success');
//}
//
//function process_update_category($category, $cat_id)
//{
//    $db = db();
//
//    $app = application();
//
//    if ($cat_id === 'none') {
//        $app->redirect(Uri::root(true) . '/' . sef(126),
//            'Please select Category to update!', 'error');
//    }
//
//    try {
//        $db->transactionStart();
//
//        update_category($category, $cat_id);
//
//        $db->transactionCommit();
//    } catch (Exception $e) {
//        $db->transactionRollback();
//
//        ExceptionHandler::render($e);
//    }
//
//    $app->redirect(Uri::root(true) . '/' . sef(126),
//        'Product Category Updated Successfully!', 'success');
//}

function validate_input_sell_request($user_id, $value, $request_id)
{
    $buyer = request_single($request_id);

    $amount_pending = $buyer->amount_pending;
    $amount_minimum = $buyer->amount_minimum;
    $type_buy = $buyer->type_buy;

    $user_seller = user($user_id);
    $bank_seller = payment_method($user_seller);

    $app = application();

    if (empty($bank_seller[$buyer->type_buy])) {
        $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
            'Please fill Up ' . strtoupper($buyer->type_buy) . ' Wallet Address.', 'error');
    }

    if (empty($bank_seller[$buyer->method_buy])) {
        $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
            'Please fill Up ' . strtoupper($buyer->method_buy) . ' Payment Method.', 'error');
    }

    if ($value > $amount_pending) {
        $app->redirect(Uri::root(true) . '/' . sef(126),
            'Please enter valid amount!', 'error');
    }

    if ($value < $amount_minimum) {
        $app->redirect(Uri::root(true) . '/' . sef(126),
            'Minimum amount is ' . $amount_minimum . ' ' . strtoupper($type_buy), 'error');
    }
}

function php_price_usd()
{
    $url = 'https://quote.coins.ph/v1/markets/USD-PHP';

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

function price_btc3()
{
    $data = [
        56 => ['0xac642e017764c4759efeb1c9ea0782cf5d1a81d1']
    ];

    $price = settings('ancillaries')->currency === 'PHP' ? 0.00012 : 0.0000024;

    $results = json_decode(coinbrain_btc3('https://api.coinbrain.com/public/coin-info', $data));

    if (!empty($results)) {
        $results = (array)$results[0];
        $price = $results['priceUsd'];
    }

    return $price;
}

function process_sell_request($user_id, $value_sell, $request_id)
{
    $db = db();

    $app = application();

    validate_input_sell_request($user_id, $value_sell, $request_id);

    $user_buyer = user($user_id);

    $request = request_single($request_id);

    $method_buyer = $request->method_buy;
    $amount_pending = $request->amount_pending;
    $price_buy = $request->price_buy;

    $total = $value_sell * $price_buy;

    if (in_array($method_buyer, ['bank', 'gcash'])) {
        $currency = 'PHP';

        $php_price_usd = php_price_usd();

        $price_php = 0;

        if ($php_price_usd) {
            $ask = $php_price_usd['market']['ask'];
            $bid = $php_price_usd['market']['bid'];

            $price_php = ($ask + $bid) / 2;
        }

        $price_total = $total * $price_php; // PHP
    } else {
        $currency = strtoupper($method_buyer);

        if (strtoupper($method_buyer) === 'BTC3') {
            $price_total = $total / price_btc3();
        } else {
            $price_method = token_price(strtoupper($method_buyer))['price'];
            $price_base = token_price('USDT')['price'];

            $price_total = ($price_base / $price_method) * $total;
        }
    }

    $contact_info = arr_contact_info($user_buyer);

    $messenger = '';
    $mobile = '';
    $landline = '';

    if (!empty($contact_info)) {
        $messenger = $contact_info['messenger'] ?? '';
        $mobile = $contact_info['mobile'] ?? '';
        $landline = $contact_info['landline'] ?? '';
    }

    $contact = '<p>Buyer Messenger URL: ' . $messenger . '</p>';
    $contact .= '<p>Buyer Mobile Number: ' . $mobile . '</p>';
    $contact .= '<p>Buyer Landline Number: ' . $landline . '</p>';

    // mail admin and user
    $message = '
			Buyer Username: ' . $user_buyer->username . '<br>
			Buyer Full Name: ' . $user_buyer->fullname . '<br>
			Buyer Email: ' . $user_buyer->email . '<br>';

    $message .= $contact;

    $message .= 'Payment Method: ' . strtoupper($request->method_buy) . '<br>
			Date Posted: ' . time() . '<hr>
			Buyer Amount: ' . $amount_pending . ' ' . strtoupper($request->type_buy) . '<br>
			Buyer Price: ' . $price_buy . ' ' . $currency . '<hr>
			Seller Amount: ' . $value_sell . ' ' . strtoupper($request->type_buy) . '<br>
			Total: ' . $price_total . ' ' . $currency;

    try {
        $db->transactionStart();

        insert_sell_request($user_id, $value_sell, $price_buy, $price_total, $method_buyer, $request->type_buy, $request_id);

        send_mail($message, 'P2P Token Buyer Request', [$user_buyer->email]);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();
        ExceptionHandler::render($e);
    }

    $app->redirect(Uri::root(true) . '/' . sef(126),
        'P2P Token Buyer Request Successful', 'success');
}

function insert_sell_request($user_id, $value_sell, $price_buy, $price_total, $method_buyer, $type_buy, $request_id)
{
    $db = db();

    return insert(
        'network_p2p_sell_tokens',
        [
            'purchase_id',
            'seller_id',
            'amount_sold',
            'price',
            'method',
            'type',
            'total_sell',
            'date_posted'
        ],
        [
            $db->quote($request_id),
            $db->quote($user_id),
            $db->quote($value_sell),
            $db->quote($price_buy),
            $db->quote($method_buyer),
            $db->quote($type_buy),
            $db->quote($price_total),
            $db->quote(time())
        ]
    );
}

/**
 * @param        $user_id
 * @param        $p_request
 * @param int $rows
 *
 * @return string
 *
 * @since version
 */
function view_requests($user_id, $p_request, int $rows = 5): string
{
    $str = '<div class="uk-panel uk-text-left">';
    $str .= '<table class="category table table-bordered table-hover">';
    $str .= '<tr>';
    $str .= '<td>';
    $str .= '<section id="tm-top-b" class="tm-top-b uk-grid" 
        data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">';
    $str .= '<div class="uk-width-1-1">';
    $str .= '<div class="uk-panel uk-panel-box uk-text-left">';

    $str .= '<h2>Requests</h2>';

    $limit_to = $rows;
    $limit_from = $limit_to * $p_request;

    $requests = requests_seller_desc_lim($user_id, $limit_from, $limit_to);

    $str .= paginate($p_request, requests_seller_all($user_id), 126, $rows, 'rq');

    if (empty($requests)) {
        $str .= '<hr><p>No pending requests yet.</p>';
    } else {
        $str .= '<table class="category table table-striped table-bordered table-hover">';
        $str .= '<thead>';
        $str .= '<tr>';
        $str .= '<th>Date Requested</th>';
        $str .= '<th>Amount</th>';
        $str .= '<th>Price</th>';
        $str .= '<th>Total</th>';
        $str .= '<th>Method</th>';
        $str .= '<th>Status</th>';
        $str .= '<th>Action</th>';
        $str .= '</tr>';
        $str .= '</thead>';
        $str .= '<tbody id="p2p_buyer_requests_pending">';

        $str .= view_requests_all($requests);

        $str .= '</tbody>';
        $str .= '</table>';

        $str .= view_modals($requests);
    }

    $str .= '</div>';
    $str .= '</div>';
    $str .= '</section>';
    $str .= '</td>';
    $str .= '</tr>';
    $str .= '</table>';
    $str .= '</div>';
    $str .= '<br>';

    return $str;
}

/**
 * @param $requests
 *
 * @return string
 *
 * @since version
 */
function view_requests_all($requests): string
{
    $str = '';

    foreach ($requests as $request) {
        $str .= view_request_single($request);
    }

    return $str;
}

/**
 * @param $requests
 *
 * @return string
 *
 * @since version
 */
function view_modals($requests): string
{
    $str = '';

    foreach ($requests as $request) {
        $request_id = $request->request_id;
        $sale_id = $request->sale_id;
        $buyer_id = $request->buyer_id;
        $amount = $request->amount;
        $amount_pending = $request->amount_pending;
        $total_buy = $request->total;
        $type_buy = $request->type_buy;
        $price_buy = $request->price_buy;
        $method_buy = $request->method_buy;
        $date_requested = $request->date_requested;

        $posting = posting_single($sale_id);

        $method_seller = $posting->method ?? '';
        $total_sell = $posting->total_sell ?? 0;
        $price_sell = $posting->price ?? 0;
        $type_sell = $posting->type ?? '';

        $type = !$amount_pending ? $type_sell : $type_buy;

        $price = !$amount_pending ? $price_sell : $price_buy;
        $total = !$amount_pending ? $total_buy : $total_sell;

        $user_buyer = user($buyer_id);

        $method = !$amount_pending ? $method_seller : $method_buy;

        $bank_buyer = payment_method($user_buyer);

        $wallet_buyer = $bank_buyer[$type] ?? '';

        $amount_rep = $amount_pending ?: $amount;

        // modal buy confirm
        $str .= view_modal_buy_confirm(
            $request_id,
            $buyer_id,
            $date_requested,
            $amount_rep,
            $type,
            $total,
            $method,
            $wallet_buyer
        );

        // modal sell
        $str .= view_modal_sell_request($request_id, $date_requested, $amount_rep, $type, $price, $method);
    }

    return $str;
}

/**
 * @param $request
 *
 * @return string
 *
 * @since version
 */
function view_request_single($request): string
{
    $request_id = $request->request_id;
    $sale_id = $request->sale_id;
    $buyer_id = $request->buyer_id;
    $amount = $request->amount;
    $amount_pending = $request->amount_pending;
    $total_buy = $request->total;
    $type_buy = $request->type_buy;
    $price_buy = $request->price_buy;
    $method_buy = $request->method_buy;
    $date_requested = $request->date_requested;
    $date_confirmed = $request->date_confirmed;

    $posting = posting_single($sale_id);

    $method_seller = $posting->method ?? '';
    $total_sell = $posting->total_sell ?? 0;
    $price_sell = $posting->price ?? 0;
    $type_sell = $posting->type ?? '';
//	$purchase_id   = $posting->purchase_id ?? '';

    $type = !$amount_pending ? $type_sell : $type_buy;

    $price = !$amount_pending ? $price_sell : $price_buy;
    $total = !$amount_pending ? $total_buy : $total_sell;

    $user_buyer = user($buyer_id);

    $method = !$amount_pending ? $method_seller : $method_buy;

    $bank_buyer = payment_method($user_buyer);

    $wallet_buyer = $bank_buyer[$type] ?? '';

    $currency = $method;

    if (in_array($currency, ['bank', 'gcash'])) {
        $currency = 'PHP';
    }

    $total_rep = !$amount_pending ? number_format($total, 8) . ' ' .
        strtoupper(!empty($posting) ? $currency : settings('ancillaries')->currency) : '-----';

    $amount_rep = $amount_pending ?: $amount;

    $str = '<tr>';
    $str .= '<td> ' . date('M j, Y - g:i A', $date_requested) . ' </td>';

    if ($amount_pending) {
        $str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' .
            number_format($amount_rep, 8) . ' ' . strtoupper($type) .
            '" data-uk-modal="{target:\'#modal-type-' . $request_id . '\'}"' . '></td>';
    } else {
        $str .= '<td> ' . number_format($amount_rep, 8) . ' ' . strtoupper($type) . '</td>';
    }

    $str .= '<td> ' . number_format($price, 8) . ' ' .
        strtoupper(!empty($posting) ? $currency : settings('ancillaries')->currency) . '</td>';
    $str .= '<td> ' . $total_rep . '</td>';

    if ($amount_pending) {
        $str .= '<td> ' . strtoupper($method) . '</td>';
    } else {
        $str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' .
            strtoupper($method) . '" data-uk-modal="{target:\'#modal-method-' . $request_id . '\'}"' . '></td>';
    }

    if ($amount_pending) {
        $str .= '<div id="modal-type-' . $request_id .
            '" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">
            <div class="uk-modal-dialog" style="text-align: center">
                <button type="button" class="uk-modal-close uk-close"></button>';

//	if (!in_array($method, ['bank', 'gcash']) || $amount_pending <= 0)
//	{
//		$str .= '<img src="images/trust-wallet.svg" alt=""><br>';
//	}

        $str .= '<p>Buyer Username: <b>' . $user_buyer->username . '</b></p>';
        $str .= '<p>Buyer Full Name: <b>' . $user_buyer->fullname . '</b></p>';

        $contact_info = arr_contact_info($user_buyer);

        $messenger = '';
        $mobile = '';
        $landline = '';

        if (!empty($contact_info)) {
            $messenger = $contact_info['messenger'] ?? '';
            $mobile = $contact_info['mobile'] ?? '';
            $landline = $contact_info['landline'] ?? '';
        }

        $str .= $messenger ? '<p>Buyer Messenger URL: ' . $messenger . '</p>' : '';
        $str .= $mobile ? '<p>Buyer Mobile Number: ' . $mobile . '</p>' : '';
        $str .= $landline ? '<p>Buyer Landline Number: ' . $landline . '</p>' : '';

//	$str .= '<p>Buyer Contact Info: <b>' . $user_buyer->contact . '</b></p>';

        if (!$amount_pending) {
            $str .= '<p>Upon payment confirmation, you can now transfer <b>' . number_format($amount, 8) .
                '</b> ' . strtoupper($type) . ' to the following Wallet Address:</p>';
            $str .= '<p><b>' . $bank_buyer[$type] . '</b></p>';
            $str .= '<img src="' . qr_code_generate($bank_buyer[$type]) .
                '" alt="QR Code Trust Wallet" style="width:250px;">';
        } else {
            $str .= '<p><b>Buyer ' . strtoupper($type) . ' Wallet Address: ' . $wallet_buyer . '</b></p>';
//		if (!in_array($method, ['bank', 'gcash']))
//		{
//			$str .= '<p><b>Buyer Wallet Address: ' . $wallet_buyer . '</b></p>';
//			$str .= '<img src="' . qr_code_generate($wallet_buyer) .
//				'" alt="QR Code Trust Wallet" style="width:250px;">';
//		}
//		elseif ($method === 'bank')
//		{
//			$bank_name    = '';
//			$bank_account = '';
//
//			foreach ($bank_buyer[$method] as $k => $v)
//			{
//				$bank_name    = strtoupper($k);
//				$bank_account = $v;
//			}
//
//			$str .= '<p><b>Buyer ' . $bank_name . ' Account: ' . $bank_account . '</b></p>';
//		}
//		elseif ($method === 'gcash')
//		{
//			$str .= '<p><b>Buyer G-Cash Number: ' . $wallet_buyer . '</b></p>';
//		}
        }

        $str .= '</div>';
        $str .= '</div>';
    } else {
        $str .= '<div id="modal-method-' . $request_id .
            '" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">
            <div class="uk-modal-dialog" style="text-align: center">
                <button type="button" class="uk-modal-close uk-close"></button>';

        if (!in_array($method, ['bank', 'gcash']) || $amount_pending <= 0) {
            $str .= '<img src="images/trust-wallet.svg" alt=""><br>';
        }

        $str .= '<p>Buyer Username: <b>' . $user_buyer->username . '</b></p>';
        $str .= '<p>Buyer Full Name: <b>' . $user_buyer->fullname . '</b></p>';

        $contact_info = arr_contact_info($user_buyer);

        $messenger = '';
        $mobile = '';
        $landline = '';

        if (!empty($contact_info)) {
            $messenger = $contact_info['messenger'] ?? '';
            $mobile = $contact_info['mobile'] ?? '';
            $landline = $contact_info['landline'] ?? '';
        }

        $str .= $messenger ? '<p>Buyer Messenger URL: ' . $messenger . '</p>' : '';
        $str .= $mobile ? '<p>Buyer Mobile Number: ' . $mobile . '</p>' : '';
        $str .= $landline ? '<p>Buyer Landline Number: ' . $landline . '</p>' : '';

//	$str .= '<p>Buyer Contact Info: <b>' . $user_buyer->contact . '</b></p>';

        if (!$amount_pending) {
            $str .= '<p>Upon payment confirmation, you can now transfer <b>' . number_format($amount, 8) .
                '</b> ' . strtoupper($type) . ' to the following Wallet Address:</p>';
            $str .= '<p><b>' . $bank_buyer[$type] . '</b></p>';
            $str .= '<img src="' . qr_code_generate($bank_buyer[$type]) .
                '" alt="QR Code Trust Wallet" style="width:250px;">';
        } else {
//			$str .= '<p><b>Buyer ' . strtoupper($type) . ' Wallet Address: ' . $wallet_buyer . '</b></p>';

            if (!in_array($method, ['bank', 'gcash'])) {
                $str .= '<p><b>Buyer Wallet Address: ' . $wallet_buyer . '</b></p>';
                $str .= '<img src="' . qr_code_generate($wallet_buyer) .
                    '" alt="QR Code Trust Wallet" style="width:250px;">';
            } elseif ($method === 'bank') {
                $bank_name = '';
                $bank_account = '';

                foreach ($bank_buyer[$method] as $k => $v) {
                    $bank_name = strtoupper($k);
                    $bank_account = $v;
                }

                $str .= '<p><b>Buyer ' . $bank_name . ' Account: ' . $bank_account . '</b></p>';
            } elseif ($method === 'gcash') {
                $str .= '<p><b>Buyer G-Cash Number: ' . $wallet_buyer . '</b></p>';
            }
        }

        $str .= '</div>';
        $str .= '</div>';
    }

//	$status = $date_confirmed > 0 ? '<span class="uk-badge uk-badge-success uk-badge-notification">Approved</span>' :
//		'<span class="uk-badge uk-badge-warning uk-badge-notification">Pending</span>';

//	$str .= '<td> ' . $status . '</td>';

//	$disabled = (time() - $date_requested) > $grace_period ? ' disabled' : '';
    if (!empty($posting)) {
        if ((int)$date_confirmed > 0) {
            $status = '<span class="uk-badge uk-badge-success uk-badge-notification">Approved</span>';
        } else {
            if ((int)$date_confirmed === 0) {
                if ($amount_pending > 0) {
                    $status = '<span class="uk-badge uk-badge-success uk-badge-notification">Active</span>';
                } else {
                    $status = '<span class="uk-badge uk-badge-warning uk-badge-notification">Pending</span>';
                }
            } else {
                $status = '<span class="uk-badge uk-badge-danger uk-badge-notification">Denied</span>';
            }
        }
    } else {
        $status = '<span class="uk-badge uk-badge-success uk-badge-notification">Active</span>';
    }

    $str .= '<td>' . $status . '</td>';

    $str .= !$amount_pending ? '<td><input type="button" class="uk-button uk-button-primary" value="Confirm" 
				data-uk-modal="{target:\'#modal-confirm-' . $request_id . '\'}"></td>' :
        '<td><input type="button" class="uk-button uk-button-primary" value="Sell" 
				data-uk-modal="{target:\'#modal-sell-' . $request_id . '\'}"></td>';

    $str .= '</tr>';

    return $str;
}

function view_modal_buy_confirm(
    $request_id,
    $buyer_id,
    $date_requested,
    $amount,
    $type,
    $total,
    $method_buyer,
    $wallet_buyer): string
{
    $user_buyer = user($buyer_id);

    $contact_info = arr_contact_info($user_buyer);

    $messenger = '';
    $mobile = '';
    $landline = '';

    if (!empty($contact_info)) {
        $messenger = $contact_info['messenger'] ?? '';
        $mobile = $contact_info['mobile'] ?? '';
        $landline = $contact_info['landline'] ?? '';
    }

    $currency = $method_buyer;

    if (in_array($currency, ['bank', 'gcash'])) {
        $currency = 'PHP';
    }

    $str = '<div id="modal-confirm-' . $request_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 150px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
    $str .= '<p><strong>Please verify and check the following details, from the Buyer, upon confirmation:</strong></p>';
    $str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <p>Date Requested: <b>' . date('M j, Y - g:i A', $date_requested) . '</b></p>
                        <p>Amount: <b>' . number_format($amount, 8) . ' ' . strtoupper($type) . '</b></p>
                        <p>Total: <b>' . number_format($total, 8) . ' ' . strtoupper($currency) . '</b></p>
                        <p>Buyer Full Name: <b>' . $user_buyer->fullname . '</b></p>';

//	$contact_info = arr_contact_info($user_buyer);

    $str .= $messenger ? '<p>Buyer Messenger URL: ' . $messenger . '</p>' : '';
    $str .= $mobile ? '<p>Buyer Mobile Number: ' . $mobile . '</p>' : '';
    $str .= $landline ? '<p>Buyer Landline Number: ' . $landline . '</p>' : '';

//	$str .= '<p>Buyer Contact Info: <b>' . $user_buyer->contact . '</b></p>';

    if (!in_array($method_buyer, ['bank', 'gcash'])) {
        $str .= '<p>Buyer Wallet Address: <b>' . $wallet_buyer . '</b></p>';
    }

    $str .= '</div>';
    $str .= '<div class="uk-modal-footer" style="text-align: right">								
				<a href="' . sef(126) . qs() . 'did=' . $request_id . '" type="button" class="uk-button uk-button-primary">Deny</a>						
				<a href="' . sef(126) . qs() . 'aid=' . $request_id . '" type="button" class="uk-button uk-button-primary">Approve</a>
			</div>';
    $str .= '</div>
		        </div>';

    return $str;
}

function view_modal_sell_request(
    $request_id,
    $date_requested,
    $amount,
    $type_buy,
    $price_buy,
    $method_buy): string
{
//	$str = '<div id="modal-sell-' . $request_id . '" class="uk-modal" aria-hidden="true"
//		style="display: none; overflow-y: scroll; margin-top: 120px">';
    $str = '<div id="modal-sell-' . $request_id . '" class="uk-modal" style="z-index: 1030;">';
    $str .= '<div class="uk-modal-dialog" style="text-align: center">';
    $str .= '<button type="button" class="uk-modal-close uk-close"></button>';

    $str .= '<h3><strong>Details</strong></h3>';

    $str .= '<div class="uk-panel uk-panel-box" style="text-align: left">';
    $str .= '<h4 class="uk-panel-title"><strong>Date Posted:</strong> ' .
        date('M j, Y - g:i A', $date_requested) . '</h4>';
    $str .= '<h4 class="uk-panel-title"><strong>Amount to Buy:</strong> ' .
        number_format($amount, 8) . ' ' . strtoupper($type_buy) . '</h4>';
    $str .= '<h4 class="uk-panel-title"><strong>Price: </strong> ' .
        number_format($price_buy, 8) . ' ' . settings('ancillaries')->currency . '</h4>';
    $str .= '<h4 class="uk-panel-title"><strong>Payment Method:</strong> ' . strtoupper($method_buy) . '</h4>';
    $str .= '</div>';

    $str .= view_form_sell_request($request_id);

    $str .= '</div>';
    $str .= '</div>';

    return $str;
}

function view_form_sell_request($request_id): string
{
    return '
		<div class="uk-form uk-grid-margin uk-row-first">
			<form method="post" onsubmit="submit.disabled=true; return true;">
				<input type="hidden" name="request_id" value="' . $request_id . '">' .
        /*'<input type="hidden" name="amount_buy" value="' . $amount . '">
        <input type="hidden" name="price_buy" value="' . $price_buy . '">' .*/
        '<fieldset>
                    <legend>Fill Up Desired Amount to Sell</legend>
                    <div class="uk-form-row">
                        <input type="text" placeholder="Amount" name="value_sell" class="uk-width-1-1">
                    </div>
                    
                    <div class="uk-form-row">
                        <input type="submit" name="submit" value="Submit" class="uk-button uk-button-success">
                    </div>
                </fieldset>
            </form>
        </div>';
}

function arr_contact_info($user)
{
    $contact_info = empty($user->contact) ? '{}' : $user->contact;

    return json_decode($contact_info, true);
}

function qr_code_generate($address): string
{
    $cht = "qr";
    $chs = "300x300";
    $chl = $address;
    $choe = "UTF-8";

    return 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
}

function requests_seller_desc_lim($user_id, $limit_from, $limit_to, $order = 'request_id'): array
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_p2p_token_sale ' .
        'WHERE date_confirmed <= 0 ' .
        'AND ((buyer_id <> ' . $user_id .
        ' AND sale_id = ' . $user_id .
        ' AND amount_minimum = 0) ' .
        'OR (buyer_id <> ' . $user_id .
        ' AND amount_minimum > 0)) ' .
        'ORDER BY ' . $order . ' DESC ' .
        'LIMIT ' . $limit_from . ', ' . $limit_to
    )->loadObjectList();
}

function requests_seller_all($user_id): array
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_p2p_token_sale ' .
        'WHERE date_confirmed <= 0 ' .
        'AND ((buyer_id <> ' . $user_id .
        ' AND sale_id = ' . $user_id .
        ' AND (type_buy = "" OR method_buy = "")) ' .
        'OR (buyer_id <> ' . $user_id .
        ' AND (type_buy <> "" OR method_buy <> "")))'
    )->loadObjectList();
}

/**
 * @param $cid
 *
 * @param $gp
 * @param $dp
 *
 * @since version
 */
function process_delete_post($cid, $gp, $dp)
{
    $db = db();

    if ((time() - $dp) > $gp) {
        application()->redirect(Uri::root(true) . '/' . sef(126),
            'Post is now permanent and cannot be cancelled!', 'warning');
    }

    $posting = posting_single($cid);

    try {
        $db->transactionStart();

        update_user_token_cancel($posting->seller_id, $posting->amount_remaining, $posting->type);
        delete_post($cid);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();

        ExceptionHandler::render($e);
    }

    application()->redirect(Uri::root(true) . '/' . sef(126),
        'Post deleted successfully!', 'notice');
}

/**
 * @param $cid
 *
 *
 * @since version
 */
function delete_post($cid)
{
    delete(
        'network_p2p_sell_tokens',
        ['sell_id = ' . db()->quote($cid)]
    );
}

/**
 * @param $user_id
 *
 * @since version
 */
function validate_seller($user_id)
{
    $seller = user($user_id);

    $app = application();

//    if ($type === 'none') {
//        $app->redirect(Uri::root(true) . '/' . sef(126),
//            'Select Type.', 'error');
//    }

//	if ($seller->balance_fmc < $amount)
//	{
//		$app->redirect(Uri::root(true) . '/' . sef(126),
//			'You don\'t have sufficient tokens to sell.', 'error');
//	}

    validate_payment_method($seller);

    // fullname
    if (empty($seller->fullname)) {
        $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $seller->id,
            'Your Full Name is Required for Verification.', 'error');
    }

    $arr_contact = arr_contact_info($seller);

    // contact
    if (empty($arr_contact)) {
        $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $seller->id,
            'Your Contact Information is Required for Verification.', 'error');
    }

    // email
    if (empty($seller->email)) {
        $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $seller->id,
            'Your Email is Required for Verification.', 'error');
    }

    $address_arr = explode('|', $seller->address);

    foreach ($address_arr as $addr) {
        if (empty($addr)) {
            $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $seller->id,
                'Your Complete Address Location is Required for Verification.', 'error');
        }
    }
}

function validate_payment_method($user)
{
    $app = application();

    $payment_method = payment_method($user);

    if (empty($payment_method)) {
        $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user->id,
            'Seller Wallet Address is Required as your Payment Method.', 'error');
    } else {
        $no_address = true;

        foreach ($payment_method as $v) {
            if (!empty($v)) {
                $no_address = false;
            }

            break;
        }

        if ($no_address) {
            $app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user->id,
                'Seller Wallet Address is Required as your Payment Method.', 'error');
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
 * @param $category
 * @since version
 */
//function insert_category($category)
//{
//    $db = db();
//
//    insert(
//        'network_settings_product_category',
//        ['category'],
//        [$db->quote($category)]
//    );
//}
//
//function update_category($category, $cat_id)
//{
//    $db = db();
//
//    update(
//        'network_settings_product_category',
//        ['category = ' . $db->quote($category)],
//        ['cat_id = ' . $db->quote($cat_id)]
//    );
//}

/**
 * @param $user
 *
 * @return array
 *
 * @since version
 */
function payment_method($user): array
{
    $payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

    return json_decode($payment_method, true);
}

function validate_input($item_name, $item_category, $description, $details, $quantity, $amount_min, $method, $price)
{
    if (empty($quantity) || $quantity <= 0) {
        alert(126, 'Maximum amount is required!');
    }

    if (empty($amount_min) || $amount_min <= 0) {
        alert(126, 'Minimum amount is required!');
    }

    if (empty($price) || $price <= 0) {
        alert(126, 'Please enter valid price!');
    }

    if (empty($item_name)) {
        alert(126, 'Please enter valid item name!');
    }

    if ($method === 'none') {
        alert(126, 'Please select payment method!');
    }

    if ($item_category === 'none') {
        alert(126, 'Please select category!');
    }

    if (empty($description)) {
        alert(126, 'Please enter item description!');
    }

    if (empty($details)) {
        alert(126, 'Please enter item details!');
    }
}


function process_add_post(
    $user_id,
    $item_name,
    $cat_id,
    $description,
    $details,
    $quantity,
    $amount_min,
    $method,
    $price,
    $picture
)
{
    validate_input($item_name, $cat_id, $description, $details, $quantity, $amount_min, $method, $price);

    $user = user($user_id);

    $price_total = (double)$quantity * (double)$price;

    // mail admin and user
    $message = '
			Username: ' . $user->username . '<br>
			Full Name: ' . $user->fullname . '<br>
			Email: ' . $user->email . '<br>
			Contact Info: ' . $user->contact . '<br>
			Date Posted: ' . time() . '<br>
			Item Name: ' . $item_name . '<br>
			Item Description: ' . $description . '<br>
			Item Details: ' . $details . '<br>
			Amount: ' . $quantity . '<br>
			Item Category: ' . strtoupper(cat_single($cat_id)) . '<br>
			Price: ' . number_format($price, 2) . ' ' . settings('ancillaries')->currency;

    if ($price_total > 0) {
        insert_posting(
            $user_id,
            $item_name,
            $cat_id,
            $description,
            $details,
            $quantity,
            $amount_min,
            $price,
            $price_total,
            $method,
            $picture
        );

        send_mail($message, 'P2P Token Seller Posting', [$user->email]);
    }

    application()->redirect(Uri::root(true) . '/' . sef(126),
        'P2P Token Seller Posting Successful', 'success');
}

function insert_posting(
    $user_id,
    $item_name,
    $cat_id,
    $description,
    $details,
    $quantity,
    $amount_min,
    $price,
    $total,
    $method,
    $picture
)
{
    $db = db();

    insert(
        'network_p2p_items',
        [
            'user_id',
            'item_name',
            'cat_id',
            'description',
            'details',
            'price',
            'quantity'/*,
            'picture'*/
        ],
        [
            $db->quote($user_id),
            $db->quote($item_name),
            $db->quote($cat_id),
            $db->quote($description),
            $db->quote($details),
            $db->quote($price),
            $db->quote($quantity)/*,
            $db->quote($picture)*/
        ]
    );

    $item_id = $db->insertid();

    if ($item_id) {
        insert(
            'network_p2p_sell_items',
            [
                'item_id',
                'amount_min',
                'total',
                'method',
                'date_posted'
            ],
            [
                $db->quote($item_id),
                $db->quote($amount_min),
                $db->quote($total),
                $db->quote($method),
                $db->quote(time())
            ]
        );

        upload_image($item_id, $picture, 'p2p');
    }
}

/**
 * Updates P2P Json Wallet
 *
 * @param $user_id
 * @param $amount
 * @param $type
 *
 *
 * @since version
 */
//function update_user_p2p_token_add($user_id, $amount, $type)
//{
//    $db = db();
//
//    $type = strtolower($type);
//
//    $arr_p2p_wallet = json_decode(user($user_id)->p2p_wallet, true);
//
//    if (!empty($arr_p2p_wallet) && array_key_exists($type, $arr_p2p_wallet)) {
//        $arr_p2p_wallet[$type] += $amount;
//    } else {
//        $arr_p2p_wallet[$type] = $amount;
//    }
//
//    update(
//        'network_users',
//        ['p2p_wallet = ' . $db->quote(json_encode($arr_p2p_wallet))],
//        ['id = ' . $db->quote($user_id)]
//    );
//}

function update_user_token_cancel($user_id, $amount, $type)
{
    $db = db();

    $type = strtolower($type);

    $user = user($user_id);
    $json_p2p_wallet = $user->p2p_wallet;
    $arr_p2p_wallet = json_decode($json_p2p_wallet, true);

    if (!empty($arr_p2p_wallet) && array_key_exists($type, $arr_p2p_wallet)) {
        $value_type = (double)$arr_p2p_wallet[$type];
        $value_type_new = $value_type - $amount;

        $arr_p2p_wallet[$type] = $value_type_new;
    } else {
        $arr_p2p_wallet[$type] = 0;
    }

    update(
        'network_users',
        ['p2p_wallet = ' . $db->quote(json_encode($arr_p2p_wallet))],
        ['id = ' . $db->quote($user_id)]
    );
}

/**
 * Update Seller P2P Wallet
 *
 * @param $request_id
 *
 *
 * @since version
 */
function update_seller_p2p_wallet_approve($request_id)
{
    $db = db();

    $request = request_single($request_id);

    $amount = $request->amount;

    $posting = posting_single($request->sale_id);
    $seller_id = $posting->seller_id;

    $type = strtolower($posting->type);

    $arr_p2p_wallet = json_decode(user($seller_id)->p2p_wallet, true);

    if (!empty($arr_p2p_wallet) && array_key_exists($type, $arr_p2p_wallet)) {
        $arr_p2p_wallet[$type] -= $amount;
    } else {
        $arr_p2p_wallet[$type] = 0;
    }

    update(
        'network_users',
        ['p2p_wallet = ' . $db->quote(json_encode($arr_p2p_wallet))],
        ['id = ' . $db->quote($seller_id)]
    );
}

/**
 * Update Seller Remaining Amount
 *
 * @param $request_id
 *
 *
 * @since version
 */
function update_seller_posting_approve($request_id)
{
    $db = db();

    $request = request_single($request_id);

    $amount = $request->amount;

    $posting = posting_single($request->sale_id);

    $amount_remaining_new = $posting->amount_remaining - $amount;

    $field = [
        'amount_remaining = amount_remaining - ' . $amount,
        'amount_sold = amount_sold + ' . $amount,
        'date_updated = ' . $db->quote(time())
    ];

    if ($amount_remaining_new <= 0) {
        $field[] = 'date_confirmed = ' . $db->quote(time());
    }

    update(
        'network_p2p_sell_tokens',
        $field,
        ['sell_id = ' . $db->quote($request->sale_id)]
    );
}

function update_buyer_request_approve($request_id)
{
    $db = db();

    update(
        'network_p2p_token_sale',
        ['date_confirmed = ' . $db->quote(time())],
        ['request_id = ' . $db->quote($request_id)]
    );
}

/**
 * @param $aid
 *
 *
 * @since version
 */
function process_approve_request($aid)
{
    $db = db();

    try {
        $db->transactionStart();

        update_seller_p2p_wallet_approve($aid);
        update_seller_posting_approve($aid);
        update_buyer_request_approve($aid);

        log_p2p_buy_transaction($aid);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();

        ExceptionHandler::render($e);
    }

    application()->redirect(Uri::root(true) . '/' . sef(126),
        'Request approved successfully!', 'success');
}

function log_p2p_buy_transaction($request_id)
{
    $rc = request_single($request_id);
    $pc = posting_single($rc->sale_id);

    insert_buy_transaction(
        $pc->seller_id,
        $rc->buyer_id,
        $rc->amount,
        $pc->type,
        $pc->method,
        $pc->price,
        $rc->total,
        $rc->date_requested);
}

function insert_buy_transaction(
    $seller_id,
    $buyer_id,
    $amount,
    $type,
    $method,
    $price,
    $final,
    $date_open)
{
    $db = db();

    insert(
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

function update_buyer_request_deny($request_id)
{
    $db = db();

    update(
        'network_p2p_token_sale',
        ['date_confirmed = ' . $db->quote('-1')],
        ['request_id = ' . $db->quote($request_id)]
    );
}

function process_deny_request($did)
{
    $db = db();

    try {
        $db->transactionStart();

        update_buyer_request_deny($did);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();

        ExceptionHandler::render($e);
    }

    application()->redirect(Uri::root(true) . '/' . sef(126),
        'Request has been denied!', 'notice');
}

/**
 *
 * @param $user_id
 * @param $pg
 * @param $cat
 * @param $rows
 * @param $stock_url
 * @return string
 *
 * @since version
 */
function view_form_sell_post($user_id, $pg, $cat, $rows, $stock_url): string
{
    $str = view_items($pg, $cat, $user_id, $rows, $stock_url);
    $str .= view_modal_sell_item($user_id);
    $str .= view_modal_cat();

    return $str;
}

function view_items($pg, $cat_id, $user_id, $rows, $stock_url): string
{
    $sp = settings('plans');

    $items_repeat = count(items_repeat($cat_id));

    $str = '<article class="uk-article">';
    $str .= '<h1>' . $sp->p2p_commerce_name . '</h1>';
    $str .= $stock_url ? '<p class="uk-article-lead">Manage Items on Stock</p>' :
        '<p class="uk-article-lead">Items for Sale</p>';
    $str .= '<a href="javascript:void(0)" class="uk-button uk-button-primary" 
        data-uk-modal="{target:\'#modal-sell-item\'}" style="float: right">Sell Items</a>';
    $str .= '<a href="javascript:void(0)" class="uk-button uk-button-primary" 
        data-uk-modal="{target:\'#modal-cat\'}" style="margin-right: 3px; float: right">Category</a>';

    if ($items_repeat > 0 && (int) $stock_url === 0) {
        $str .= '<a href="' . sef(126) . '?stock=' . $items_repeat . '" class="uk-button uk-button-primary" 
            style="margin-right: 3px; float: right">Stock</a>';
    } elseif ($items_repeat > 0 && (int) $stock_url > 0) {
        $str .= '<a href="' . sef(126) . '" class="uk-button uk-button-primary"  
            style="margin-right: 3px; float: right">Store</a>';
    } else {
        $str .= '';
    }

    $str .= items($cat_id, $pg, $rows, $user_id, 126, 126, 126, true, $stock_url);

    $str .= '</article>';

    return $str;
}

function view_modal_sell_item($user_id): string
{
    $str = '<div id="modal-sell-item" class="uk-modal" style="z-index: 1030;">';
    $str .= '<div class="uk-modal-dialog">';
    $str .= '<button type="button" class="uk-modal-close uk-close"></button>';

    $str .= view_form_sell_item($user_id);

    $str .= '</div>';
    $str .= '</div>';

    return $str;
}

function arr_payment_method($user)
{
    $payout_method = empty($user->payment_method) ? '{}' : $user->payment_method;

    return json_decode($payout_method, true);
}

function view_form_sell_item($user_id): string
{
    $str = '<div class="page-header"><h1>Sell Items</h1></div>';

    $str .= '<form method="post" class="form-horizontal well" enctype="multipart/form-data">';
    $str .= '<fieldset>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="item_name">Name<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<input type="text" name="item_name" id="item_name" placeholder="Item Name"
        required="required" aria-required="true" autofocus="" aria-invalid="true">';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="item_category">Category<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<select name="item_category" id="item_category">';
    $str .= '<option value="none" selected="" disabled>Select Category</option>';
    $str .= view_option_cat();
    $str .= '</select>';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="item_description">Description<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<input type="text" name="item_description" id="item_description" placeholder="Item Description"
        required="required" aria-required="true" autofocus="" aria-invalid="true">';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="item_details">Details<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<textarea name="item_details" id="item_details" placeholder="Item Details" style="height: 100px"
        required="required" aria-required="true" autofocus="" aria-invalid="true"></textarea>';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="amount_minimum">Amount Min.<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<input type="text" name="amount_minimum" id="amount_minimum" placeholder="Minimum Amount"
        required="required" aria-required="true" autofocus="" aria-invalid="true">';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="amount_maximum">Amount Max.<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<input type="text" name="amount_maximum" id="amount_maximum" placeholder="Maximum Amount"
        required="required" aria-required="true" autofocus="" aria-invalid="true">';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="item_price">Price<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<input type="text" name="item_price" id="item_price" placeholder="USD"
        required="required" aria-required="true" autofocus="" aria-invalid="true">';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="control-label">';
    $str .= '<label for="payment_method">Payment Method<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= view_method_select($user_id);
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="uk-margin">';
    $str .= '<div class="control-label">';
    $str .= '<label for="item_picture">Picture<span class="star">&nbsp;*</span></label>';
    $str .= '</div>';
    $str .= '<div class="controls">';
    $str .= '<input type="file" name="item_picture" id="item_picture">';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="control-group">';
    $str .= '<div class="controls">';
    $str .= '<button type="submit" class="btn btn-primary">Submit</button>';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '</fieldset>';
    $str .= HTMLHelper::_('form.token');
    $str .= '</form>';

    return $str;
}

//function view_type_select($user_id): string
//{
//	$user = user($user_id);
//
//	$pmu = payment_method($user);
//
//	$str = '<select name="type" id="type" style="float:left">';
//	$str .= '<option value="none" selected>Type</option>';
//
//	if (!empty($pmu))
//	{
//		foreach ($pmu as $k => $v)
//		{
//			if (!in_array($k, ['bank', 'gcash']))
//			{
//				$str .= '<option value="' . $k . '">' . strtoupper($k) . '</option>';
//			}
//		}
//	}
//
//	$str .= '</select>';
//
//	return $str;
//}

function view_method_select($user_id): string
{
    $user = user($user_id);

    $pmu = payment_method($user);

    $str = '<select name="payment_method" id="payment_method">';
    $str .= '<option value="none" selected>Select Payment Method</option>';

    if (!empty($pmu)) {
        foreach ($pmu as $k => $v) {
            if (!is_array($v)) {
                $str .= '<option value="' . $k . '">' . strtoupper($k) . '</option>';
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

/**
 *
 * @param        $user_id
 * @param        $p_post
 * @param        $grace_period
 * @param int $rows
 *
 * @return string
 *
 * @since version
 */
function view_sell_postings($user_id, $p_post, $grace_period, int $rows = 5): string
{
    $str = '<div class="uk-panel uk-text-left">
        <table class="category table table-bordered table-hover">
            <tr>
                <td>
                    <section id="tm-top-b" class="tm-top-b uk-grid" 
                        data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
                        <div class="uk-width-1-1">
                            <div class="uk-panel uk-panel-box uk-text-left">';

    $str .= ' <h2>Amount Remaining</h2> ';

    $limit_to = $rows;
    $limit_from = $limit_to * $p_post;

    $postings = postings_desc_lim($user_id, $limit_from, $limit_to);

    $str .= paginate($p_post, postings_user_all($user_id), 126, $rows, 'pst');

    if (empty($postings)) {
        $str .= '<hr><p>No postings yet.</p>';
    } else {
        $str .= '
			<table class="category table table-striped table-bordered table-hover">
	            <thead>
		            <tr>
		                <th>Date Posted</th>
		                <th>Amount Remaining</th>
		                <th>Amount Sold</th>
		                <th>Price</th>
		                <th>Method</th>
		                <th>Date Updated</th>
		                <th>Action</th>
		            </tr>
	            </thead>
            <tbody id="p2p_seller_postings">';

        foreach ($postings as $posting) {
            $str .= view_posting_single($posting, $grace_period);
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

function view_posting_single($posting, $grace_period): string
{
    $sell_id = $posting->sell_id;
    $purchase_id = $posting->purchase_id;
    $date_posted = $posting->date_posted;
    $date_updated = $posting->date_updated;
    $type = $posting->type;
    $method = $posting->method;

    $amount_remaining_rep = $purchase_id ? '-----' : number_format($posting->amount_remaining, 8) . ' ' . strtoupper($type);

    $str = '<tr>';
    $str .= '<td>' . date('M j, Y - g:i A', $date_posted) . '</td>';
    $str .= '<td>' . $amount_remaining_rep . '</td>';

    if ($purchase_id) {
        $request = request_single($purchase_id);

        $user_buyer = user($request->buyer_id);

        $bank_buyer = payment_method($user_buyer);

        $str .= '<td>' . '<input type="button" class="uk-button uk-button-primary" value="' .
            number_format($posting->amount_sold, 8) . ' ' . strtoupper($type) .
            '" data-uk-modal="{target:\'#modal-sold-' . $sell_id . '\'}"' . '></td>';

        $str .= '<div id="modal-sold-' . $sell_id .
            '" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">
            <div class="uk-modal-dialog" style="text-align: center">
                <button type="button" class="uk-modal-close uk-close"></button>';

        $str .= '<img src="images/trust-wallet.svg" alt=""><br>';

        $str .= '<p>Buyer Username: <b>' . $user_buyer->username . '</b></p>';
        $str .= '<p>Buyer Full Name: <b>' . $user_buyer->fullname . '</b></p>';

        $contact_info = arr_contact_info($user_buyer);

        $messenger = '';
        $mobile = '';
        $landline = '';

        if (!empty($contact_info)) {
            $messenger = $contact_info['messenger'] ?? '';
            $mobile = $contact_info['mobile'] ?? '';
            $landline = $contact_info['landline'] ?? '';
        }

        $str .= $messenger ? '<p>Buyer Messenger URL: ' . $messenger . '</p>' : '';
        $str .= $mobile ? '<p>Buyer Mobile Number: ' . $mobile . '</p>' : '';
        $str .= $landline ? '<p>Buyer Landline Number: ' . $landline . '</p>' : '';

        $str .= '<p>Upon Buyer Verification, you can now transfer <b>' .
            number_format($posting->amount_sold, 8) .
            '</b> ' . strtoupper($type) . ' to the following Wallet Address:</p>';
        $str .= '<p><b>' . $bank_buyer[$type] . '</b></p>';
        $str .= '<img src="' . qr_code_generate($bank_buyer[$type]) .
            '" alt="QR Code Trust Wallet" style="width:250px;">';

        $str .= '</div>';
        $str .= '</div>';
    } else {
        $str .= '<td>' . number_format($posting->amount_sold, 8) . ' ' . strtoupper($type) . '</td>';
    }

    $str .= '<td> ' . number_format($posting->price, 8) . ' ' . settings('ancillaries')->currency . '</td>';
    $str .= '<td> ' . strtoupper($method) . ' </td>';

    if ($purchase_id) {
        $str .= '<td>-----</td>';
    } else {
        if ($date_updated > 0) {
            $str .= '<td> ' . date('M j, Y - g:i A', $date_updated) . ' </td>';
        } else {
            $str .= '<td>No buyers yet.</td>';
        }
    }

    $disabled = (time() - $date_posted) > $grace_period ? ' disabled' : '';

    $str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="Cancel" 
				data-uk-modal="{target:\'#modal-cancel-' . $sell_id . '\'}"' . $disabled . '></td>';

    $str .= '<div id="modal-cancel-' . $sell_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
    $str .= '<p><strong>Are you sure, you want to cancel this post?</strong></p>';
    $str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <h3 class="uk-panel-title"><strong>Date Posted:</strong> ' .
        date('M j, Y - g:i A', $date_posted) . '</h3>
                        <h3 class="uk-panel-title"><strong>Amount:</strong> ' .
        number_format($posting->amount_remaining, 8) . '</h3>
                        <h3 class="uk-panel-title"><strong>Price (' . settings('ancillaries')->currency .
        '):</strong> ' . number_format($posting->price, 2) . '</h3>                        
                    </div>';
    $str .= '<div class="uk-modal-footer" style="text-align: right">
						<input type="button" class="uk-modal-close uk-button uk-button-primary" value="Close">
						<a href="' . sef(126) . qs() . 'cid=' . $sell_id .
        '&gp=' . $grace_period . '&dp=' . $date_posted . '" 
							type="button" class="uk-button uk-button-primary">Confirm</a>
					</div>';
    $str .= '</div>
		        </div>';

    $str .= '</tr> ';

    return $str;
}

function postings_desc_lim($user_id, $limit_from, $limit_to, $order = 'sell_id')
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_p2p_sell_tokens ' .
        'WHERE seller_id = ' . $db->quote($user_id) .
        ' AND date_confirmed <= 0 ' .
        'ORDER BY ' . $order . ' DESC ' .
        'LIMIT ' . $limit_from . ', ' . $limit_to
    )->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function postings_user_all($user_id)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_p2p_sell_tokens ' .
        'WHERE seller_id = ' . $db->quote($user_id) .
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

function request_single($request_id)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_p2p_token_sale ' .
        'WHERE request_id = ' . $db->quote($request_id)
    )->loadObject();
}

function view_btn_add_products($user_id): string
{
    return '<div style="float:right;">
            <input type="button" class="uk-button uk-button-primary" 
            	value="Add Products" data-uk-modal="{target:\'#modal-add\'}"' . '>
        </div>';
}