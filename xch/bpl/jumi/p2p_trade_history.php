<?php

namespace BPL\Jumi\P2P_Trade_History;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\sef;
use function bpl\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;

use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;
use function bpl\Mods\Helpers\paginate;
use function BPL\Mods\Helpers\user;

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

	$rows = 5;

	$p_pst = input_get('pst', 0);
	$p_rq  = input_get('rq', 0);

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$str .= page_reload();

	$str .= view_sold_postings($user_id, $p_pst, $rows);
	$str .= view_bought_requests($user_id, $p_rq, $rows);

	echo $str;
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
function view_sold_postings($user_id, $p_pst, int $rows = 5): string
{
	$str = '<div class="uk-panel uk-text-left">
        <table class="category table table-bordered table-hover">
            <tr>
                <td>
                    <section id="tm-top-b" class="tm-top-b uk-grid" 
                        data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
                        <div class="uk-width-1-1">
                            <div class="uk-panel uk-panel-box uk-text-left">';

	$str .= ' <h2>Trades Sold</h2> ';

	$limit_to   = $rows;
	$limit_from = $limit_to * $p_pst;

	$sales = sold_postings_lim_desc($user_id, $limit_from, $limit_to);

//	$src = sold_postings_all($user_id);

//	$str .= paginate_sold_postings($p_pst, $rows, $src);

	$str .= paginate($p_pst, sold_postings_all($user_id), 56, $rows, 'pst');

	if (empty($sales))
	{
		$str .= '<hr><p>No trades sold yet.</p>';
	}
	else
	{
		$str .= '
			<table class="category table table-striped table-bordered table-hover">
	            <thead>
		            <tr>
		                <th>Date Posted</th>
		                <th>Amount</th>		               
		                <th>Rate (USD)</th>	
		                <th>Total Value</th>	                
		                <th>Date Sold</th>
		                <th>Buyer</th>
		            </tr>
	            </thead>
            <tbody id="p2p_history_sell">';

		foreach ($sales as $sale)
		{
			$str .= view_posting_sold_single($sale);
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

function view_bought_requests($user_id, $p_rq, int $rows = 5): string
{
	$str = '<div class="uk-panel uk-text-left">
        <table class="category table table-bordered table-hover">
            <tr>
                <td>
                    <section id="tm-top-b" class="tm-top-b uk-grid" 
                        data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
                        <div class="uk-width-1-1">
                            <div class="uk-panel uk-panel-box uk-text-left">';

	$str .= ' <h2>Trades Bought</h2> ';

	$limit_to   = $rows;
	$limit_from = $limit_to * $p_rq;

	$purchases = requests_lim_desc($user_id, $limit_from, $limit_to);

//	$src = requests_all($user_id);
//
//	$str .= paginate_bought_requests($p_rq, $rows, $src);

	$str .= paginate($p_rq, requests_all($user_id), 56, $rows, 'rq');

	if (empty($purchases))
	{
		$str .= '<hr><p>No confirmed requests yet.</p>';
	}
	else
	{
		$str .= '
			<table class="category table table-striped table-bordered table-hover">
	            <thead>
		            <tr>
		                <th>Date Requested</th>
		                <th>Amount</th>		
		                <th>Rate (USD)</th>               
		                <th>Total Value</th>
		                <th>Date Bought</th>
		                <th>Seller</th>
		            </tr>
	            </thead>
            <tbody id="p2p_history_buy">';

		foreach ($purchases as $purchase)
		{
			$str .= view_bought_request_single($purchase);
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
 * @param $sale
 *
 * @return string
 *
 * @since version
 */
function view_posting_sold_single($sale): string
{
	$transaction_id = $sale->transaction_id;
	$buyer_id       = $sale->buyer_id;
	$date_close     = $sale->date_close;
	$amount         = $sale->amount;
	$final          = $sale->final;
	$date_open      = $sale->date_open;
	$price          = $sale->price;
	$type           = $sale->type;
	$method         = $sale->method;

	$user_buyer = user($buyer_id);

	$bank_buyer = payment_method($user_buyer);

	$wallet_buyer = $bank_buyer[$method];

	$currency = $method;

	if (in_array($method, ['bank', 'gcash']))
	{
		$currency = 'PHP';
	}

	$str = '<tr>';
	$str .= '<td> ' . date('M j, Y - g:i:s A', $date_open) . ' </td>';
	$str .= '<td> ' . number_format($amount, 8) . ' ' . strtoupper($type) . '</td>';
	$str .= '<td> ' . number_format($price, 18) . ' ' . /*settings('ancillaries')->currency*/'USD' . '</td>';
	$str .= '<td> ' . number_format($final, 18) . ' ' . strtoupper($currency) . '</td>';
	$str .= '<td> ' . date('M j, Y - g:i:s A', $date_close) . '</td>';
	$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' . $user_buyer->username . '" 
		data-uk-modal="{target:\'#modal-buyer-' . $transaction_id . '\'}"' . '></td>';

	$str .= '<div id="modal-buyer-' . $transaction_id .
		'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 120px">
	            <div class="uk-modal-dialog" style="text-align: center">
	                <button type="button" class="uk-modal-close uk-close"></button>
	                <h4><b>Buyer Details</b></h4>              
	                <p>Username: <b>' . $user_buyer->username . '</b></p>
	                <p>Full Name: <b>' . $user_buyer->fullname . '</b></p>';

	$contact_info = arr_contact_info($user_buyer);

	$messenger = '';
	$mobile    = '';
	$landline  = '';

	if (!empty($contact_info))
	{
		$messenger = $contact_info['messenger'] ?? '';
		$mobile    = $contact_info['mobile'] ?? '';
		$landline  = $contact_info['landline'] ?? '';
	}

	$str .= $messenger ? '<p>Messenger URL: ' . $messenger . '</p>' : '';
	$str .= $mobile ? '<p>Mobile Number: ' . $mobile . '</p>' : '';
	$str .= $landline ? '<p>Landline Number: ' . $landline . '</p>' : '';

	if (!in_array($method, ['bank', 'gcash']))
	{
		$str .= '<p>Wallet Address: <b> ' . $wallet_buyer . '</b></p>';
		$str .= '<img src = "' . qr_code_generate($wallet_buyer) .
			'" alt="QR Code Trust Wallet" style="width:250px;">';
	}
	else
	{
		if ($method === 'bank')
		{
			$bank_name      = '';
			$account_number = '';

			foreach ($wallet_buyer as $k => $v)
			{
				$bank_name      = strtoupper($k);
				$account_number = $v;
			}

			$str .= '<p><b> ' . $bank_name . ' Account: ' . $account_number . '</b></p>';
		}
		elseif ($method === 'gcash')
		{
			$str .= '<p><b>G-Cash Number: ' . $wallet_buyer . '</b></p>';
		}
	}

	$str .= '</div>
	        </div> ';

	$str .= '</div>
		        </div> ';
	// modal end

	$str .= '</tr> ';

	return $str;
}

function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

/**
 * @param $purchase
 *
 * @return string
 *
 * @since version
 */
function view_bought_request_single($purchase): string
{
	$transaction_id = $purchase->transaction_id;
	$seller_id      = $purchase->seller_id;
	$amount         = $purchase->amount;
	$final          = $purchase->final;
	$date_open      = $purchase->date_open;
	$date_close     = $purchase->date_close;
	$price          = $purchase->price;
	$type           = $purchase->type;
	$method         = $purchase->method;

	$user_seller = user($seller_id);

	$bank_seller = payment_method($user_seller);

	$wallet_seller = $bank_seller[$method];

	$currency = $method;

	if (in_array($method, ['bank', 'gcash']))
	{
		$currency = 'PHP';
	}

	$str = ' <tr>';
	$str .= ' <td> ' . date('M j, Y - g:i:s A', $date_open) . '</td>';
	$str .= '<td> ' . number_format($amount, 8) . ' ' . strtoupper($type) . '</td>';
	$str .= '<td> ' . number_format($price, 18) . ' ' . /*settings('ancillaries')->currency*/'USD' . '</td>';
	$str .= '<td> ' . number_format($final, 18) . ' ' . strtoupper($currency) . '</td>';
	$str .= '<td> ' . date('M j, Y - g:i:s A', $date_close) . '</td>';

	$str .= '<td>' . '<input type="button" class="uk-button uk-button-primary" value="' .
		$user_seller->username . '" data-uk-modal= "{target:\'#modal-seller-' . $transaction_id . '\'}"></td>';

	$str .= '<div id = "modal-seller-' . $transaction_id .
		'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 120px">
	            <div class="uk-modal-dialog" style = "text-align: center">
	                <button type="button" class="uk-modal-close uk-close"></button>
	                <h4>Profile</h4>	               
	                <p>Seller Username: ' . $user_seller->username . '</p>
	                <p>Seller Full Name: ' . $user_seller->fullname . '</p>';

	$contact_info = arr_contact_info($user_seller);

	if (!empty($contact_info))
	{
		$messenger = $contact_info['messenger'] ?? '';
		$mobile    = $contact_info['mobile'] ?? '';
		$landline  = $contact_info['landline'] ?? '';

		$str .= $messenger ? '<p>Seller Messenger URL: ' . $messenger . '</p>' : '';
		$str .= $mobile ? '<p>Seller Mobile Number: ' . $mobile . '</p>' : '';
		$str .= $landline ? '<p>Seller Landline Number: ' . $landline . '</p>' : '';
	}

	if (!in_array($method, ['bank', 'gcash']))
	{
		$str .= '<p>Seller Wallet Address: ' . $wallet_seller . '</p>';
		$str .= '<img src="' . qr_code_generate($wallet_seller) . '" alt="QR Code Trust Wallet" style="width:250px;">';

	}
	else
	{
		if ($method === 'bank')
		{
			$bank_name      = '';
			$account_number = '';

			foreach ($wallet_seller as $k => $v)
			{
				$bank_name      = strtoupper($k);
				$account_number = $v;
			}

			$str .= '<p><b>Seller ' . $bank_name . ' Account: ' . $account_number . '</b></p>';
		}
		elseif ($method === 'gcash')
		{
			$str .= '<p><b>G-Cash Number: ' . $wallet_seller . '</b></p>';
		}
	}

	$str .= '</div>
	        </div>';

	$str .= '</tr>';

	return $str;
}

function qr_code_generate($address): string
{
	$cht  = "qr";
	$chs  = "300x300";
	$chl  = $address;
	$choe = "UTF-8";

	return 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
}

function sold_postings_lim_desc($user_id, $limit_from, $limit_to, $order = 'transaction_id')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_transactions ' .
		'WHERE seller_id = ' . $db->quote($user_id) .
		'ORDER BY ' . $order . ' DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();
}

//function sold_postings_lim_desc($user_id, $limit_from, $limit_to, $order = 'request_id')
//{
//	$db = db();
//
//	return $db->setQuery(
//		'SELECT ' .
//		'amount_sold, ' .
//		'price, ' .
//		'total_sell, ' .
//		'request_id, ' .
//		'date_posted, ' .
//		'buyer_id, ' .
//		'p2pst.date_confirmed p_date_confirmed, ' .
//		'method, ' .
//		'type ' .
//		'FROM network_p2p_token_sale tsp2p ' .
//		'INNER JOIN network_p2p_sell_tokens p2pst ' .
//		'ON sale_id = sell_id ' .
//		'WHERE seller_id = ' . $db->quote($user_id) .
//		' AND p2pst.date_confirmed > 0 ' .
//		'ORDER BY ' . $order . ' DESC ' .
//		'LIMIT ' . $limit_from . ', ' . $limit_to
//	)->loadObjectList();
//}

//function requests_lim_desc($user_id, $limit_from, $limit_to, $order = 'request_id')
//{
//	$db = db();
//
//	return $db->setQuery(
//		'SELECT ' .
//		'amount_sold, ' .
//		'price, ' .
//		'total_sell, ' .
//		'request_id, ' .
//		'date_requested, ' .
//		'seller_id, ' .
//		'p2pst.date_confirmed p_date_confirmed, ' .
//		'method, ' .
//		'type ' .
//		'FROM network_p2p_token_sale tsp2p ' .
//		'INNER JOIN network_p2p_sell_tokens p2pst ' .
//		'ON purchase_id = request_id ' .
//		'WHERE buyer_id = ' . $db->quote($user_id) .
//		' AND p2pst.date_confirmed > 0 ' .
//		'ORDER BY ' . $order . ' DESC ' .
//		'LIMIT ' . $limit_from . ', ' . $limit_to
//	)->loadObjectList();
//}

function requests_lim_desc($user_id, $limit_from, $limit_to, $order = 'transaction_id')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_transactions ' .
		'WHERE buyer_id = ' . $db->quote($user_id) .
		'ORDER BY ' . $order . ' DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();
}

///**
// * @param $user_id
// *
// * @return array|mixed
// *
// * @since version
// */
//function sold_postings_all($user_id)
//{
//	$db = db();
//
//	return $db->setQuery(
//		'SELECT ' .
//		'amount_sold, ' .
//		'price, ' .
//		'total_sell, ' .
//		'request_id, ' .
//		'date_posted, ' .
//		'buyer_id, ' .
//		'p2pst.date_confirmed p_date_confirmed, ' .
//		'method, ' .
//		'type ' .
//		'FROM network_p2p_token_sale tsp2p ' .
//		'INNER JOIN network_p2p_sell_tokens p2pst ' .
//		'ON sale_id = sell_id ' .
//		'WHERE seller_id = ' . $db->quote($user_id) .
//		' AND p2pst.date_confirmed > 0'
//	)->loadObjectList();
//}

function sold_postings_all($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_transactions ' .
		'WHERE seller_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

//function requests_all($user_id)
//{
//	$db = db();
//
//	return $db->setQuery(
//		'SELECT ' .
//		'amount_sold, ' .
//		'price, ' .
//		'total_sell, ' .
//		'request_id, ' .
//		'date_requested, ' .
//		'sale_id, ' .
//		'p2pst.date_confirmed p_date_confirmed, ' .
//		'method, ' .
//		'type ' .
//		'FROM network_p2p_token_sale tsp2p ' .
//		'INNER JOIN network_p2p_sell_tokens p2pst ' .
//		'ON purchase_id = request_id ' .
//		'WHERE buyer_id = ' . $db->quote($user_id) .
//		' AND p2pst.date_confirmed > 0'
//	)->loadObjectList();
//}

function requests_all($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_p2p_transactions ' .
		'WHERE buyer_id = ' . $db->quote($user_id)
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

///**
// * @param $p_pst
// * @param $rows
// * @param $src
// *
// * @return string
// *
// * @since version
// */
//function paginate_sold_postings($p_pst, $rows, $src): string
//{
//	$limit_to   = $rows;
//	$limit_from = $limit_to * $p_pst;
//
//	$total = count($src);
//
//	$last_page = ($total - $total % $limit_to) / $limit_to;
//
//	$str = '<div style="float:right; margin-top:30px;">';
//
//	if ($total > ($limit_from + $limit_to))
//	{
//		$str .= '<a href="' . sef(56) . qs() . 'pst=' . ($last_page) .
//			'" class="uk-button uk-button-primary">Oldest</a>';
//
//		$str .= '<a href="' . sef(56) . qs() . 'pst=' . ($p_pst + 1) .
//			'" class="uk-button uk-button-danger">Previous</a>';
//	}
//
//	if ($p_pst > 0 /*&& $p_pst*/)
//	{
//		$str .= '<a href="' . sef(56) . qs() . 'pst=' . ($p_pst - 1) .
//			'" class="uk-button uk-button-primary">Next</a>';
//
//		$str .= '<a href="' . sef(56) . qs() . 'pst=' . (0) .
//			'" class="uk-button uk-button-danger">Latest</a>';
//	}
//
//	$str .= '</div>';
//
//	return $str;
//}

///**
// * @param $p_rq
// * @param $rows
// * @param $src
// *
// * @return string
// *
// * @since version
// */
//function paginate_bought_requests($p_rq, $rows, $src): string
//{
//	$limit_to   = $rows;
//	$limit_from = $limit_to * $p_rq;
//
//	$total = count($src);
//
//	$last_page = ($total - $total % $limit_to) / $limit_to;
//
//	$str = '<div style="float:right; margin-top:30px;">';
//
//	if ($total > ($limit_from + $limit_to))
//	{
//		$str .= '<a href="' . sef(56) . qs() . 'rq=' . ($last_page) .
//			'" class="uk-button uk-button-primary">Oldest</a>';
//
//		$str .= '<a href="' . sef(56) . qs() . 'rq=' . ($p_rq + 1) .
//			'" class="uk-button uk-button-danger">Previous</a>';
//	}
//
//	if ($p_rq > 0 && $p_rq)
//	{
//		$str .= '<a href="' . sef(56) . qs() . 'rq=' . ($p_rq - 1) .
//			'" class="uk-button uk-button-primary">Next</a>';
//
//		$str .= '<a href="' . sef(56) . qs() . 'rq=' . (0) .
//			'" class="uk-button uk-button-danger">Latest</a>';
//	}
//
//	$str .= '</div>';
//
//	return $str;
//}

