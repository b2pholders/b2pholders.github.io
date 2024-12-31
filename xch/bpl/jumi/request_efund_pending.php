<?php

namespace BPL\Jumi\Request_Efund_Pending;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Menu\settings_adjust;
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

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate($usertype);

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid   = input_get('uid');
	$mode  = input_get('mode');
	$final = input_get('final');

	$str .= '<h1>Pending ' . settings('ancillaries')->efund_name . ' Requests</h1>';

	if ($uid !== '')
	{
		$str .= ((int) $mode === 1 ? '<h3>Approve Request</h3>' : '<h3>Deny Request</h3>');

		if ((int) $final !== 1)
		{
			$str .= view_form_requests($uid, $mode);
		}
		else
		{
			// approve
			if ((int) $mode === 1)
			{
				process_approve($uid);
			}

			// delete
			if ((int) $mode === 2)
			{
				process_deny($uid);
			}
		}

		$str .= '<hr>';
	}

	$str .= view_requests_pending();

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
function view_form_requests($uid, $mode): string
{
	$user_request = user_request($uid);

//	$currency = settings('ancillaries')->currency;

	$efund_name = settings('ancillaries')->efund_name;

	$currency = in_array($user_request->method, ['bank', 'gcash']) ? 'PHP' : $user_request->method;

	$str = '<form method="post">
            <input type="hidden" name="final" value="1">
            <input type="hidden" name="uid" value="' . $uid . '">
            <input type="hidden" name="mode" value="' . $mode . '">
            <table class="category table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date Requested</th>
                    <th>Username</th>
                    <th>Balance</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Method</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';
	$str .= '<tr>
			<td>' . date('M j, Y - g:i A', $user_request->date_requested) . '</td>
			<td><a href="' . sef(44) . qs() . 'uid=' . $user_request->id . '">' .
		$user_request->username . '</a>' . '</td>
			<td>' . number_format($user_request->payout_transfer, 8) . ' ' . $efund_name . '</td>
			<td>' . number_format($user_request->amount, 8) . ' ' . $efund_name . '</td>
			<td>' . number_format($user_request->price, 8) . ' ' . strtoupper($currency) . '</td>
			<td>' . strtoupper($user_request->method) . '</td>
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

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function qr_code_generate($address): string
{
	$cht  = "qr";
	$chs  = "300x300";
	$chl  = $address;
	$choe = "UTF-8";

	return 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_requests_pending(): string
{
	$sa = settings('ancillaries');

	$efund_name = $sa->efund_name;

	$pending_request = requests_pending();

	$str = '';

	if ($pending_request)
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date Requested</th>
            <th>Username</th>
            <th>Balance</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Method</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>';

		foreach ($pending_request as $request)
		{
			$user = user($request->id);

			$currency = in_array($request->method, ['bank', 'gcash']) ? 'PHP' : $request->method;

			$str .= '<tr>';
			$str .= '<td>' . date('M j, Y - g:i A', $request->date_requested) . '</td>';
			$str .= '<td><a href="' . sef(44) . qs() . 'uid=' . $request->id .
				'">' . $request->username . '</a>' . '</td>';
			$str .= '<td>' . number_format($request->payout_transfer, 8) . ' ' . $efund_name . '</td>';

//			$str .= '<td>' . number_format($request->amount, 2) . '</td>';

			$str .= '<td><input type="button" class="uk-button uk-button-primary" value="' .
				number_format($request->amount, 8) . ' ' . $efund_name . '" data-uk-modal="{target:\'#modal-' .
				$request->request_id . '\'}"></td>';

			$str .= '<td>' . number_format($request->price, 8) . ' ' . strtoupper($currency) . '</td>';
			$str .= '<td>' . strtoupper($request->method) . '</td>';

			$str .= '<div id="modal-' . $request->request_id .
				'" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll; margin-top: 150px">';
			$str .= '<div class="uk-modal-dialog" style="text-align: center">';
			$str .= '<button type="button" class="uk-modal-close uk-close"></button>';

			$contact_info = arr_contact_info($user);

			$messenger = '';

			if (!empty($contact_info))
			{
				$messenger = $contact_info['messenger'] ?? '';
			}

			$contact = $messenger ? '<p><b>User Messenger URL:</b> ' . $messenger . '</p>' : '';
			$contact .= $user->email ? '<p><b>User Email Address:</b> ' . $user->email . '</p>' : '';

			$str .= $contact;
			$str .= '<p>Upon Payment confirmation, Admin can now transfer <b>' .
				number_format($request->amount, 8) . '</b> ' .
				$efund_name . ' to <b>' . $user->username . '</b></p>';

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
			$str .= '<a href="' . sef(76) . qs() . 'uid=' . $request->request_id . '&mode=1">Approve</a>';
			$str .= '</li>';
			$str .= '<li>';
			$str .= '<a href="' . sef(76) . qs() . 'uid=' . $request->request_id . '&mode=2">Deny</a>';
			$str .= '</li>';
			$str .= '</ul>';
			$str .= '</div>';
			$str .= '</div>';
			$str .= '</div>';
			$str .= '</td>';
			$str .= '</tr>';
		}

		$str .= '</tbody>
    </table>';
	}
	else
	{
		$str .= '<hr><p>No pending ' . $efund_name . ' requests.</p>';
	}

	return $str;
}

/**
 * @param $amount
 * @param $user_id
 *
 *
 * @since version
 */
function update_user_efund($amount, $user_id)
{
	$db = db();

	update(
		'network_users',
		['payout_transfer = payout_transfer + ' . $amount],
		['id = ' . $db->quote($user_id)]
	);

	// update pogi_wallet
//	update(
//		'network_users',
//		['payout_transfer = payout_transfer + ' . ($amount * 0.25)],
//		['id = ' . $db->quote(2)]
//	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function update_efund_request($uid)
{
	$db = db();

	update(
		'network_efund_request',
		['date_confirmed = ' . $db->quote(time())],
		['request_id = ' . $db->quote($uid)]
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

	$user_request = user_request($uid);

	$settings_ancillaries = settings('ancillaries');

	$efund_name = $settings_ancillaries->efund_name;

	// mail admin
	$message = 'Username: ' . $user_request->username . '<br>
			Full Name: ' . $user_request->fullname . '<br>
			Email: ' . $user_request->email . '<br>
			Contact: ' . $user_request->contact . '<br>
			Amount (' . strtoupper($settings_ancillaries->currency) . '): ' .
		number_format($user_request->amount, 2);

	try
	{
		$db->transactionStart();

		update_user_efund($user_request->amount, $user_request->id);
		update_efund_request($uid);

		logs_approve($uid);

		send_mail($message, $efund_name . ' Request Confirmed', [$user_request->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

//	send_mail($uid);

	application()->redirect(Uri::root(true) . '/' . sef(76),
		$efund_name . ' request confirmed!', 'success');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_activity_approve($uid)
{
	$user_request = user_request($uid);

	$db = db();

	$activity = '<b>' . settings('ancillaries')->efund_name . ' Request Confirmed: ' . '</b><a href="' .
		sef(44) . qs() . 'uid=' . $user_request->id . '">' . $user_request->username . '</a> has requested ' .
		number_format($user_request->amount, 8) . ' ' . strtoupper(settings('ancillaries')->efund_name);

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
			$db->quote($user_request->id),
			$db->quote($user_request->id),
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

	$user_request = user_request($uid);

	$details = '<b>' . $sa->efund_name . ' Request Confirmed: ' . '</b><a href="' . sef(44) . qs() .
		'uid=' . $user_request->id . '">' . $user_request->username . '</a> has requested ' .
		number_format($user_request->amount, 8) . ' ' . strtoupper(settings('ancillaries')->efund_name);

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
			$db->quote($user_request->id),
			$db->quote($efund_name . ' Request Confirmed'),
			$db->quote($details),
			$db->quote($user_request->amount),
			$db->quote(transactions_user($uid)->payout_transfer + $user_request->amount),
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
function logs_efund_requests_approve($uid, $transaction_id)
{
	$user_request = user_request($uid);

	$fund_request = efund_requests();

	$db = db();

	insert(
		'network_efund_requests',
		[
			'transaction_id',
			'amount',
			'price',
			'method',
			'request_date',
			'request_total'
		],
		[
			$db->quote($transaction_id),
			$db->quote($user_request->amount),
			$db->quote($user_request->price),
			$db->quote($user_request->method),
			$db->quote(time()),
			$db->quote($fund_request->request_total + $user_request->amount)
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
	logs_efund_requests_approve($uid, db()->insertid());
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

	try
	{
		$db->transactionStart();

		delete_request($uid);

		logs_deny($uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' .
		sef(76), settings('ancillaries')->efund_name . ' Request denied!', 'error');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_deny($uid)
{
	$user_request = user_request($uid);

	$db = db();

	$activity = '<b>' . settings('ancillaries')->efund_name . ' Request Denied: ' . '</b><a href="' .
		sef(44) . qs() . 'uid=' . $user_request->id . '">' . $user_request->username . '</a>, ' .
		number_format($user_request->amount, 2) . ' ' . strtoupper(settings('ancillaries')->currency);

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
			$db->quote($user_request->id),
			$db->quote($user_request->id),
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
function delete_request($uid)
{
	delete(
		'network_efund_request',
		['request_id = ' . db()->quote($uid)]
	);
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function user_request($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_efund_request r ' .
		'ON u.id = r.user_id ' .
		'AND r.request_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function requests_pending()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_efund_request r ' .
		'WHERE u.id = r.user_id ' .
		'AND r.date_confirmed = ' . $db->quote(0) .
		' ORDER BY r.request_id ASC'
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
		'WHERE user_id = ' . $db->quote(user_request($uid)->id) .
		' ORDER BY transaction_id DESC'
	)->loadObject();
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function efund_requests()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_efund_requests ' .
		'ORDER BY request_id DESC'
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

	switch ($usertype)
	{
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
	if ($usertype !== 'Admin' && $usertype !== 'manager')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}