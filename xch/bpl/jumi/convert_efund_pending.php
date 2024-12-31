<?php

namespace BPL\Jumi\Convert_Efund_Pending;

require_once 'bpl/echelon_bonus.php';
require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';
require_once 'bpl/plugins/phpqrcode/qrlib.php';

use Exception;
use QRcode;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use RuntimeException;

use function BPL\Echelon_Bonus\main as echelon_bonus;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use const QR_ECLEVEL_L;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype = session_get('usertype');
	$admintype = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id = session_get('user_id');
	$username = session_get('username');

	page_validate($usertype);

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid = input_get('uid');
	$mode = input_get('mode');
	$final = input_get('final');

	$str .= '<h1>Pending ' . settings('ancillaries')->efund_name . ' Withdrawals</h1>';

	if ($uid !== '') {
		$str .= ((int) $mode === 1 ? '<h3>Approve Transaction</h3>' : '<h3>Deny Transaction</h3>');

		if ((int) $final !== 1) {
			$str .= view_form_conversions($uid, $mode);
		} else {
			// approve
			if ((int) $mode === 1) {
				process_approve($uid);
			}

			// delete
			if ((int) $mode === 2) {
				process_deny($uid);
			}
		}

		$str .= '<hr>';
	}

	$str .= view_table_conversions();

	echo $str;
}

/**
 * @param $uid
 * @param $mode
 *
 * @return string
 *
 * @since version
 */
function view_form_conversions($uid, $mode): string
{
	$user_convert = user_convert($uid);

	$efund_name = settings('ancillaries')->efund_name;

	//	$currency = settings('ancillaries')->currency;

	$currency = in_array($user_convert->method, ['bank', 'gcash', 'maya']) ? 'PHP' : $user_convert->method;

	switch ($user_convert->mode) {
		case 'fdp':
			$pass = settings('plans')->fixed_daily_name;
			break;
		case 'ftk':
			$pass = settings('plans')->fast_track_name;
			break;
		case 'lpd':
			$pass = settings('plans')->leadership_passive_name;
			break;
		default:
			$pass = 'Standard';
			break;
	}

	$str = '<form method="post">
            <input type="hidden" name="final" value="1">
            <input type="hidden" name="uid" value="' . $uid . '">
            <input type="hidden" name="mode" value="' . $mode . '">
            <table class="category table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Username</th>
                    <th>Balance</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Mode</th>
                    <th>Method</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';
	$str .= '<tr>
			<td>' . date('M j, Y - g:i A', $user_convert->date_posted) . '</td>
			<td><a href="' . sef(44) . qs() . 'uid=' . $user_convert->id . '">' .
		$user_convert->username . '</a>' . '</td>
			<td>' . number_format($user_convert->payout_transfer, 8) . ' ' . $efund_name . '</td>
			<td>' . number_format($user_convert->amount, 8) . ' ' . $efund_name . '</td>
			<td>' . number_format($user_convert->price, 8) . ' ' . strtoupper($currency) . '</td>
			<td>' . $pass . '</td>
			<td>' . strtoupper($user_convert->method) . '</td>
			<td><input type="submit" value="' . ((int) $mode === 1 ? 'Approve' : 'Deny') .
		'" name="submit" class="uk-button uk-button-primary"></td>
		</tr>';
	$str .= '</tbody>
        </table>
        </form>';

	return $str;
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
function view_table_conversions(): string
{
	$sa = settings('ancillaries');

	$efund_name = $sa->efund_name;

	$pending_conversions = convert_pending();

	$str = '';

	if ($pending_conversions) {
		$str .= '<div class="table-responsive">';
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<th>Date</th>';
		$str .= '<th>Username</th>';
		$str .= '<th>Balance</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>Price</th>';
		$str .= '<th>Cut</th>';
		$str .= '<th>Mode</th>';
		$str .= '<th>Method</th>';
		$str .= '<th>Action</th>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($pending_conversions as $convert) {
			$user = user($convert->id);

			$user_arr_payment = arr_payment_method($convert);
			$user_payment_address = $user_arr_payment[$convert->method];

			$payment_method = strtoupper($convert->method);

			if (is_array($user_arr_payment[$convert->method])) {
				foreach ($user_arr_payment[$convert->method] as $k => $v) {
					$payment_method = strtoupper($k);
					$user_payment_address = $v;

					break;
				}
			}

			$currency = in_array($convert->method, ['bank', 'gcash', 'maya']) ? 'PHP' : $convert->method;

			switch ($convert->mode) {
				case 'fdp':
					$mode = settings('plans')->fixed_daily_name;
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
			$str .= '<td>' . date('M j, Y - g:i A', $convert->date_posted) . '</td>';
			$str .= '<td><a href="' . sef(44) . qs() . 'uid=' . $convert->id . '">' .
				$convert->username . '</a>' . '</td>';
			$str .= '<td>' . number_format($convert->payout_transfer, 8) . ' ' . $efund_name . '</td>';
			$str .= '<td>' . number_format($convert->amount, 8) . ' ' . $efund_name . '</td>';
			$str .= '<td>' . number_format($convert->price, $currency === 'PHP' ? 2 : 8) . ' ' .
				strtoupper($currency) .
				'</td>';
			$str .= '<td>' . number_format($convert->cut, 8) . ' ' . $efund_name . '</td>';
			$str .= '<td>' . $mode . '</td>';

			$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="' .
				strtoupper($payment_method) . '" data-uk-modal="{target:\'#modal-' . $convert->convert_id . '\'}"></td>';

			$str .= '<div id="modal-' . $convert->convert_id .
				'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">
	            <div class="uk-modal-dialog" style="text-align: center">
	                <button type="button" class="uk-modal-close uk-close"></button>';

			$contact_info = arr_contact_info($user);

			$messenger = '';

			if (!empty($contact_info)) {
				$messenger = $contact_info['messenger'] ?? '';
			}

			$contact = $messenger ? '<p><b>User Messenger URL:</b> ' . $messenger . '</p>' : '';
			$contact .= $user->email ? '<p><b>User Email Address:</b> ' . $user->email . '</p>' : '';


			if (!in_array($convert->method, ['bank', 'gcash', 'maya'])) {
				$str .= '<img src="images/trust-wallet.svg" alt="" width="150px"><br>';
				$str .= $contact;
				$str .= '<img src="' . qr_code_generate($user_payment_address) .
					'" alt="QR Code Trust Wallet" style="width:250px;">';

				$str .= '<p>Please transfer <b>' . number_format($convert->price, 8) . '</b> ' .
					strtoupper($currency) . ' to the following ' . strtoupper($convert->method) . ' Wallet Address:</p>
	                <p><b>' . $user_payment_address . '</b></p>
	            </div>
	        </div>';
			} else {
				if ($convert->method === 'gcash') {
					$str .= $contact;
					$str .= '<p>Please pay <b>' . number_format($convert->price, 8) . '</b> ' .
						strtoupper($currency) . ' to the following G-Cash Number:</p>
	                <p><b>' . $user_payment_address . '</b></p>';
				} elseif ($convert->method === 'bank') {
					$str .= $contact;
					$str .= '<p>Please pay <b>' . number_format($convert->price, 8) . '</b> ' .
						strtoupper($currency) . ' to the following ' . strtoupper($payment_method) .
						' Bank Account:</p>
	                <p><b>' . $user_payment_address . '</b></p>';
				} elseif ($convert->method === 'maya') {
					$str .= $contact;
					$str .= '<p>Please pay <b>' . number_format($convert->price, 8) . '</b> ' .
						strtoupper($currency) . ' to the following Maya Number:</p>
	                <p><b>' . $user_payment_address . '</b></p>';
				}
			}

			$str .= '</div>
	        </div>';

			$str .= '<td>';
			$str .= '<div class="uk-button-group">';
			$str .= '<button class="uk-button uk-button-primary">Select</button>';
			$str .= '<div class="" data-uk-dropdown="{mode:\'click\'}">';
			$str .= '<button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>';
			$str .= '<div style="" class="uk-dropdown uk-dropdown-small">';
			$str .= '<ul class="uk-nav uk-nav-dropdown">';
			$str .= '<li>';
			$str .= '<a href="' . sef(58) . qs() . 'uid=' . $convert->convert_id . '&mode=1">Approve</a>';
			$str .= '</li>';
			$str .= '<li>';
			$str .= '<a href="' . sef(58) . qs() . 'uid=' . $convert->convert_id . '&mode=2">Deny</a>';
			$str .= '</li>';
			$str .= '</ul>';
			$str .= '</div>';
			$str .= '</div>';
			$str .= '</div>';
			$str .= '</td>';
			$str .= '</tr>';
		}

		$str .= '</tbody>';
		$str .= '</table>';
		$str .= '</div>';


	} else {
		$str .= '<hr><p>No pending ' . $efund_name . ' withdrawals.</p>';
	}

	return $str;
}

function sand_table(): string
{
	$str = '<div class="category-list">
		<div>
			<div class="content-category">
				<h1>Blog</h1>	
				<form action="" method="post" name="adminForm" id="adminForm" class="form-inline">
					<fieldset class="filters btn-toolbar clearfix">
						<legend class="hide">Filters</legend>
						<div class="btn-group pull-right">
							<label for="limit" class="element-invisible">Display #</label>
							<select id="limit" name="limit" class="inputbox input-mini" size="1" onchange="this.form.submit()">
								<option value="5">5</option>
								<option value="10" selected="selected">10</option>
								<option value="15">15</option>
								<option value="20">20</option>
								<option value="25">25</option>
								<option value="30">30</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option value="0">All</option>
							</select>
						</div>
		
						<input type="hidden" name="filter_order" value="">
						<input type="hidden" name="filter_order_Dir" value="">
						<input type="hidden" name="limitstart" value="">
						<input type="hidden" name="task" value="">
					</fieldset>

					<div class="control-group hide pull-right">
						<div class="controls">
							<button type="submit" name="filter_submit" class="btn btn-primary">Filter</button>
						</div>
					</div>

					<table class="category table table-striped table-bordered table-hover">
						<caption class="hide">List of articles in category Blog</caption>
						<thead>
							<tr>
								<th scope="col" id="categorylist_header_title">
									<a href="#" onclick="Joomla.tableOrdering(\'a . title\',\'asc\',\'\', document.getElementById(\'adminForm\'));return false;" 
										class="hasPopover" title="" data-content="Select to sort by this column" 
										data-placement="top" data-original-title="Title">Title</a>				
								</th>
								<th scope="col" id="categorylist_header_author">
									<a href="#" onclick="Joomla.tableOrdering(\'author\',\'asc\',\'\');return false;" 
										class="hasPopover" title="" data-content="Select to sort by this column" 
										data-placement="top" data-original-title="Author">Author</a>					
								</th>
								<th scope="col" id="categorylist_header_hits">
									<a href="#" onclick="Joomla.tableOrdering(\'a . hits\',\'asc\',\'\');return false;" 
										class="hasPopover" title="" data-content="Select to sort by this column" 
										data-placement="top" data-original-title="Hits">Hits</a>					
								</th>
							</tr>
						</thead>
						<tbody>
							<tr class="cat-list-row0">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/8-joomla-templates">Joomla Templates</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row1">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/9-beautiful-icons">Beautiful Icons</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row0">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/10-warp-framework">Warp Framework</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row1">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/11-zoo-extension">ZOO Extension</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row0">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/23-widgetkit-extension">Widgetkit</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row1">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/24-uikit">UIkit</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row0">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/25-pagekit">Pagekit</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
							<tr class="cat-list-row1">
								<td headers="categorylist_header_title" class="list-title">
									<a href="/joomla/26-free-halloween-icons">Free Halloween Icons</a>
								</td>
								<td headers="categorylist_header_author" class="list-author">
									Written by Super User															
								</td>
								<td headers="categorylist_header_hits" class="list-hits">
									<span class="badge badge-info">Hits: 0</span>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>';

	return $str;
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
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

/**
 * @param $amount
 * @param $user_id
 *
 * @param $mode
 *
 * @since version
 */
function update_user_efund($amount, $user_id, $mode)
{
	$db = db();

	$sa = settings('ancillaries');
	$processing_fee = $sa->processing_fee;

	if ($mode === 'fdp') {
		update(
			'network_users',
			[
				'fixed_daily_balance = fixed_daily_balance - ' . $amount,
				'payout_transfer = payout_transfer - ' . $processing_fee
			],
			['id = ' . $db->quote($user_id)]
		);
	} elseif ($mode === 'ftk') {
		update(
			'network_users',
			[
				'fast_track_balance = fast_track_balance - ' . $amount,
				'payout_transfer = payout_transfer - ' . $processing_fee
			],
			['id = ' . $db->quote($user_id)]
		);
	} elseif ($mode === 'ldp') {
		update(
			'network_users',
			[
				'bonus_leadership_passive_balance = bonus_leadership_passive_balance - ' . $amount,
				'payout_transfer = payout_transfer - ' . $processing_fee
			],
			['id = ' . $db->quote($user_id)]
		);
	} else {
		update(
			'network_users',
			['payout_transfer = payout_transfer - ' . ($amount + $processing_fee)],
			['id = ' . $db->quote($user_id)]
		);
	}

	if (settings('plans')->direct_referral) {
		$sponsor_id = user($user_id)->sponsor_id;

		// add sponsor_income
		update(
			'network_users',
			['payout_transfer = payout_transfer + ' . ($amount * 0.1)],
			['id = ' . $db->quote($sponsor_id)]
		);
	}
}

/**
 * Summary of BPL\Jumi\Convert_Efund_Pending\update_efund_convert
 * @param mixed $uid
 * @return bool|mixed
 */
function update_efund_convert($uid)
{
	$db = db();

	return update(
		'network_efund_convert',
		['date_approved = ' . $db->quote(time())],
		['convert_id = ' . $db->quote($uid)]
	);
}

/**
 * @param $uid
 *
 * @since version
 */
function process_approve($uid)
{
	$db = db();

	//	$app = application();

	$user_convert = user_convert($uid);

	$settings_ancillaries = settings('ancillaries');

	$efund_name = $settings_ancillaries->efund_name;

	// mail admin
	$message = 'Username: ' . $user_convert->username . '<br>
			Full Name: ' . $user_convert->fullname . '<br>
			Email: ' . $user_convert->email . '<br>
			Contact: ' . $user_convert->contact . '<br>
			Amount (' . strtoupper($efund_name) . '): ' .
		number_format($user_convert->amount, 2);

	try {
		$db->transactionStart();

		update_user_efund($user_convert->amount, $user_convert->id, $user_convert->mode);

		if (update_efund_convert($uid)) {
			echelon_bonus();
		}

		logs_approve($uid);

		send_mail($message, $efund_name . ' Withdrawal Approved', [$user_convert->email]);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	//	if ($user_convert->mode === 'fdp')
//	{
//		$app->redirect(Uri::root(true) . '/' . sef(18),
//			settings('plans')->fixed_daily_name . ' wallet conversion approved!', 'success');
//	}elseif ($user_convert->mode === 'ftk') {
//		$app->redirect(Uri::root(true) . '/' . sef(20),
//			settings('plans')->fast_track_name . ' wallet conversion approved!', 'success');
//	} else {
	application()->redirect(
		Uri::root(true) . '/' . sef(58),
		$efund_name . ' withdrawal approved!',
		'success'
	);
	//	}
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_activity_approve($uid)
{
	$sa = settings('ancillaries');

	$user_convert = user_convert($uid);

	$db = db();

	$activity = '<b>' . $sa->efund_name . ' Withdrawal Approved: ' . '</b><a href="' . sef(44) . qs() .
		'uid=' . $user_convert->id . '">' . $user_convert->username . '</a> has withdrawn ' .
		number_format($user_convert->amount, 8) . ' ' . $sa->currency;

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_convert->id),
			$db->quote($user_convert->id),
			$db->quote(1),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_transactions_approve($uid)
{
	$db = db();

	$sa = settings('ancillaries');

	$efund_name = $sa->efund_name;

	$user_convert = user_convert($uid);

	$details = '<b>' . $sa->efund_name . ' Withdrawal Approved: ' . '</b><a href="' . sef(44) . qs() .
		'uid=' . $user_convert->id . '">' . $user_convert->username . '</a> has withdrawn ' .
		number_format($user_convert->amount, 8) . ' ' . $sa->currency;

	insert(
		'network_transactions',
		[
			'user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'
		],
		[
			$db->quote($user_convert->id),
			$db->quote($efund_name . ' Withdrawal Approved'),
			$db->quote($details),
			$db->quote($user_convert->amount),
			$db->quote(transactions_user($uid)->payout_transfer + $user_convert->amount),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 * @param $transaction_id
 *
 * @since version
 */
function logs_efund_conversions_approve($uid, $transaction_id)
{
	$user_convert = user_convert($uid);

	$efund_conversions = efund_conversions();

	$db = db();

	insert(
		'network_efund_conversions',
		[
			'transaction_id',
			'amount',
			'price',
			'method',
			'conversion_date',
			'conversion_total'
		],
		[
			$db->quote($transaction_id),
			$db->quote($user_convert->amount),
			$db->quote($user_convert->price),
			$db->quote($user_convert->method),
			$db->quote(time()),
			$db->quote($efund_conversions->conversion_total + $user_convert->amount)
		]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_approve($uid)
{
	logs_activity_approve($uid);
	logs_transactions_approve($uid);
	logs_efund_conversions_approve($uid, db()->insertid());
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function process_deny($uid)
{
	$db = db();

	try {
		$db->transactionStart();

		delete_convert($uid);

		logs_deny($uid);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' .
		sef(58), settings('ancillaries')->efund_name . ' Withdrawal denied!', 'notice');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_deny($uid)
{
	$sa = settings('ancillaries');

	$user_convert = user_convert($uid);

	$db = db();

	$activity = '<b>' . $sa->efund_name . ' Withdrawal Denied: ' . '</b><a href="' .
		sef(44) . qs() . 'uid=' . $user_convert->id . '">' . $user_convert->username . '</a>, ' .
		number_format($user_convert->amount, 2) . ' ' . strtoupper($sa->currency);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_convert->id),
			$db->quote($user_convert->id),
			$db->quote(1),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function delete_convert($uid)
{
	$eec = entry_efund_convert($uid);

	delete(
		'network_efund_convert',
		['convert_id = ' . db()->quote($uid)]
	);

	update(
		'network_users',
		[
			'converted_today = converted_today - ' . $eec->amount
		],
		[
			'id = ' . db()->quote($eec->user_id)
		]
	);
}

function entry_efund_convert($cid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_efund_convert ' .
		'WHERE convert_id = ' . $db->quote($cid)
	)->loadObject();
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function user_convert($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'INNER JOIN network_efund_convert ' .
		'ON id = user_id ' .
		'AND convert_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function convert_pending()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'INNER JOIN network_efund_convert ' .
		'WHERE id = user_id ' .
		'AND date_approved = 0 ' .
		'ORDER BY convert_id DESC'
	)->loadObjectList();
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function transactions_user($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transactions ' .
		'WHERE user_id = ' . $db->quote(user_convert($uid)->id) .
		' ORDER BY transaction_id DESC'
	)->loadObject();
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function efund_conversions()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_efund_conversions ' .
		'ORDER BY conversion_id DESC'
	)->loadObject();
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $user_id
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $user_id, $username): string
{
	$str = '';

	switch ($usertype) {
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 * @param $usertype
 *
 *
 * @since version
 */
function page_validate($usertype)
{
	if ($usertype !== 'Admin' && $usertype !== 'manager') {
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

// /**
//  * @param $user_id
//  * @param $code_type
//  * @param $amount
//  *
//  * @since version
//  */
// function process_echelon_bonus($code_type)
// {
// 	// $username = input_get('username');
// 	// $sponsor = input_get('sponsor');

// 	// $edit = session_get('edit');

// 	$settings_plans = settings('plans');
// 	$settings_echelon = settings('echelon');
// 	// $settings_entry = settings('entry');

// 	$echelon_level = $settings_echelon->{$code_type . '_echelon_level'};

// 	// $sponsor_id = user($user_id)->sponsor_id;

// 	// $user_sponsor = user_username($sponsor);

// 	// if (!empty($user_sponsor)) {
// 	// 	$sponsor_id = $user_sponsor[0]->id;
// 	// }

// 	// $date = input_get_date();

// 	$db = db();

// 	if (
// 		$echelon_level &&
// 		$settings_plans->echelon
// 	) {
// 		// insert(
// 		// 	'network_indirect',
// 		// 	['id', 'user_id'],
// 		// 	[$db->quote($user_id), $db->quote($user_id)]
// 		// );

// 		// $activity = '<b>' . ucwords($settings_plans->indirect_referral_name) . ' Entry: </b> <a href="' .
// 		// 	sef(44) . qs() . 'uid=' . $user_id . '">' . $username . '</a> has entered into ' .
// 		// 	ucwords($settings_plans->indirect_referral_name) . ' upon ' .
// 		// 	ucfirst($settings_entry->{$code_type . '_package_name'}) . ' Sign Up.';

// 		// insert(
// 		// 	'network_activity',
// 		// 	[
// 		// 		'user_id',
// 		// 		'sponsor_id',
// 		// 		'activity',
// 		// 		'activity_date'
// 		// 	],
// 		// 	[
// 		// 		$db->quote($user_id),
// 		// 		$db->quote($sponsor_id),
// 		// 		$db->quote($activity),
// 		// 		($edit === true && (int) $date !== 0 ? $db->quote($date) : $db->quote(time()))
// 		// 	]
// 		// );

// 		echelon_bonus();
// 	}
// }