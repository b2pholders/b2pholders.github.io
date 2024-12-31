<?php

namespace BPL\Jumi\Add_Points;

require_once 'bpl/menu.php';
require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;

use function BPL\Mods\Ajax\check_input2;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\page_validate_admin;
use function BPL\Mods\Helpers\user_username;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
//use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\time;

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
	$final        = input_get('final');

	session_set('edit', false);

	page_validate_admin($usertype, $admintype);

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	if ((int) $final !== 1)
	{
		$str .= check_input2();
		$str .= view_form();
	}
	else
	{
		$username = input_get('username');
		$amount   = input_get('amount');
		$edit     = session_get('edit', false);

		process_add_points($username, $amount, $edit);
	}

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_form(): string
{
//	$sa = settings('ancillaries');
//
//	$efund_name = $sa->efund_name;

	return '<h1>Add ' . /*$efund_name*/'Tokens' . '</h1>
	    <p>Enter member\'s Username and the amount to add.</p>
	    <form method="post" onsubmit="submit.disabled = true; return true;">
	        <input type="hidden" name="final" value="1">
	        <table class="category table table-striped table-bordered table-hover">
	            <tr>
	                <td><label for="username">Username: *</label></td>
	                <td><input type="text" name="username" id="username" 
	                		size="40" required="required" style="float:left">
                       	<a href="javascript:void(0)" onClick="checkInput(\'username\')"
                             class="uk-button uk-button-primary" style="float:left">Check</a>
	                    <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
	                         id="usernameDiv"></div>
	                </td>
	            </tr>
	            <tr>
	                <td><label for="amount">Amount (' . /*settings('ancillaries')->currency*/'tkn.' . '): *</label></td>
	                <td>
	                    <input type="text" name="amount" id="amount" style="float:left">
	                    <input type="submit" name="submit" value="Add ' . /*$efund_name*/'Tokens' .
		'" class="uk-button uk-button-primary">	                 
	                </td>
	            </tr>
	        </table>
	    </form>';
}

/**
 * @param $username
 * @param $amount
 *
 * @param $edit
 *
 * @since version
 */
function process_add_points($username, $amount, $edit)
{
//	$sa = settings('ancillaries');
//
//	$efund_name = $sa->efund_name;

	$db = db();

	validate_input($username, $amount, $edit);

	$transfer_to = user_username(input_get('username'));

	$message = '<strong>Recipient</strong>' .
		'Username: ' . $transfer_to->username . '<br>' .
		'Full Name: ' . $transfer_to->fullname . '<br>' .
		'Email: ' . $transfer_to->email . '<br>' .
		'Contact Number: ' . $transfer_to->contact . '<br><br>' .
		'<strong>' . /*$efund_name*/'Tokens' . ' Added</strong><br>' . input_get('amount') . '<br>';

	try
	{
		$db->transactionStart();

		update_users($username, $amount);

		insert_point_add($username, $amount, $edit);

		logs($username, $amount, $edit);

		send_mail($message, /*$efund_name*/'Tokens' . ' Added Successfully!', [$transfer_to->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(132), number_format($amount, 2) .
		' ' . /*settings('ancillaries')->currency*/'Tokens' . ' added to ' . $username . '.', 'success');
}

/**
 * @param $username
 * @param $amount
 *
 * @param $edit
 *
 * @since version
 */
function validate_input($username, $amount, $edit)
{
	$app = application();

	if ($amount === '' || !is_numeric($amount) || $username === '')
	{
		$app->redirect(Uri::root(true) . '/' .
			sef(132), 'Invalid Amount or Username!', 'error');
	}

	if ($amount < 0)
	{
		$app->redirect(Uri::root(true) . '/' .
			sef(132), 'Invalid Amount!', 'error');
	}

	$transfer_to = user_username($username);

	if ($transfer_to->id === '')
	{
		$app->redirect(Uri::root(true) . '/' . sef(132),
			'User to transfer to does not exist.', 'error');
	}

	if ($edit)
	{
		$date = input_get('date', '0', 'RAW');

		if ($date === '0')
		{
			$app->redirect(Uri::root(true) . '/' . sef(132),
				'Please specify the Current Date!', 'error');
		}
	}
}

/**
 * @param $username
 *
 * @param $amount
 *
 * @since version
 */
function update_users($username, $amount)
{
	update(
		'network_users',
		[/*'payout_transfer = payout_transfer + '*/'points = points + ' . $amount],
		['id = ' . db()->quote(user_username($username)->id)]
	);
}

/**
 * @param $username
 * @param $amount
 * @param $edit
 *
 *
 * @since version
 */
function insert_point_add($username, $amount, $edit)
{
	$db = db();

	insert(
		'network_point_add',
		[
			'user_id',
			'date',
			'amount'
		],
		[
			$db->quote(user_username($username)->id),
			$db->quote(date_get($edit)),
			$db->quote($amount)
		]
	);
}

/**
 * @param $username
 * @param $amount
 * @param $edit
 *
 *
 * @since version
 */
function logs($username, $amount, $edit)
{
	logs_transactions($username, $amount, $edit);
	logs_activity($username, $amount, $edit);
}

/**
 * @param $username
 * @param $amount
 * @param $edit
 *
 *
 * @since version
 */
function logs_transactions($username, $amount, $edit)
{
//	$sa = settings('ancillaries');

	$db = db();

	$transfer_to = user_username($username);

	$date = time();

	if ($edit)
	{
		$date = input_get('date', '0', 'RAW');
	}

	$details = number_format($amount, 2) . ' ' . /*settings('ancillaries')->currency*/'Tokens' .
		' added to <a href="' . sef(44) . qs() . 'uid=' . $transfer_to->id . '">' . $username . '</a>.';

	$balance = (double) /*$transfer_to->payout_transfer*/$transfer_to->points + (double) $amount;

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
			$db->quote($transfer_to->id),
			$db->quote('Admin Added ' . /*$sa->efund_name*/'Tokens'),
			$db->quote($details),
			$db->quote($amount),
			$db->quote($balance),
			$db->quote($date)
		]
	);
}

/**
 * @param $username
 * @param $amount
 * @param $edit
 *
 *
 * @since version
 */
function logs_activity($username, $amount, $edit)
{
//	$sa = settings('ancillaries');

	$db = db();

	$transfer_to = user_username($username);

	$activity = '<b>' . /*$sa->efund_name*/'Tokens' . ' Added: </b> Admin added ' . number_format($amount, 2) .
		' ' . /*settings('ancillaries')->currency*/'tkn.' . ' to <a href="' . sef(44) . qs() . 'uid=' .
		$transfer_to->id . '">' . $transfer_to->username . '</a>.';

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
			$db->quote($transfer_to->id),
			$db->quote($transfer_to->sponsor_id),
			1,
			$db->quote($activity),
			$db->quote(date_get($edit))
		]
	);
}

/**
 * @param $edit
 *
 * @return string
 *
 * @since version
 */
function date_get($edit): string
{
	$date = time();

	if ($edit)
	{
		$date = input_get('date', '0', 'RAW');
	}

	return $date;
}