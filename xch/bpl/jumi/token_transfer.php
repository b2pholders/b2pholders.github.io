<?php

namespace BPL\Jumi\Token_Transfer;

require_once 'bpl/mods/usdt_currency.php';
require_once 'bpl/mods/transfer_history.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\USDT_Currency\main as usdt_currency;

use function BPL\Mods\Transfer_History\view_row_transfers;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\session_set;
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
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$amount       = input_get('amount');
	$username     = input_get('username');
	$final        = input_get('final');

	session_set('edit', false);

	page_validate($usertype, $account_type);

	$str = menu();

	if ((int) $final !== 1)
	{
		$str .= ajax_check_input6();
		$str .= view_form($user_id);
	}
	else
	{
		$edit = session_get('edit', false);

		$date = time();

		if ($edit)
		{
			$date = input_get('date', '', 'RAW');
		}

		validate_input($user_id, $amount, $username, $edit);

		process_transfer($user_id, $amount, $username, $date);
	}

	$str .= view_transfer_history($user_id);

	echo $str;
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
	if ($usertype === '' || $account_type === 'starter')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

/**
 *
 * @return string
 *
 * @since version
 */
function ajax_check_input6(): string
{
	return '<script>
		function fadeUp(obj) {
            if (typeof(obj) === "string") {
                obj = document.getElementById(obj);
            }
            
            let t;
            let opacity_counter = 0;
            
            const doFade = function () {
                obj.style.opacity = (opacity_counter / 100);

                /* for IE */
                obj.style.filter = "alpha(opacity=" + opacity_counter + ")";
                opacity_counter = opacity_counter + 10;
                
                if (opacity_counter >= 100) {
                    clearTimeout(t);
                    
                    obj.style.opacity = "1";
                    obj.style.filter = "alpha(opacity=100)";
                } else {
                    t = setTimeout(doFade, 50);
                }
            };
            
            doFade();
        }
        
        function checkInput(inputUserId, inputID) {
            let ajaxRequest;
            
            const divID = inputID + "Div";

            try {
                ajaxRequest = new XMLHttpRequest();
            } catch (e) {
                // Internet Explorer Browsers
                try {
                    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {
                        // Something went wrong
                        alert("Your browser broke!");
                        
                        return false;
                    }
                }
            }

            ajaxRequest.onreadystatechange = function () {
                if (ajaxRequest.readyState === 4) {
                    const ajaxDisplay = document.getElementById(divID);
                    
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    
                    fadeUp(divID);
                }
            };

            const ie = new Date().getTime();
            const uid = document.getElementById(inputID).value;
            const user_id = document.getElementById(inputUserId).value;
            const queryString = "?type=" + inputID + "&user_id=" + user_id + "&uid=" + uid + "&ie=" + ie;
            
            ajaxRequest.open("GET", "bpl/ajax/check_input6.php" + queryString, true);
            ajaxRequest.send(null);
        }
    </script>';
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

//	$currency = $settings_ancillaries->currency;

	$transfer_from = user($user_id);

	return '<h1>' . $settings_trading->token_name . ' Transfer</h1>
    <p>Transfers are subject to ' . $settings_ancillaries->cybercharge .
		' % cybercharge to be deducted from the remaining e-fund</p>
    <form method="post" onsubmit="submit.disabled = true; return true;">
    	<input type="hidden" name="user_id" id="user_id" value="' . $user_id . '">
        <input type="hidden" name="final" value="1">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="2"><strong>' . /*$settings_trading->token_name .*/ ' Balance: </strong>' .
		number_format($transfer_from->balance_fmc, 2) . ' ' . $settings_trading->token_name .
		'<span style="float: right"><strong>E-fund Balance: </strong>' .
		number_format($transfer_from->payout_transfer, 2) . ' ' . /*$currency .*/
		'</span></td>
            </tr>
            <tr>
                <td><label for="username">Recipient Username:</label></a></td>
                <td><input type="text"
                           name="username"
                           id="username"
                           required="required"
                           size="40"
                           style="float:left; padding-right: 12px">
                    <a onClick="checkInput(\'user_id\', \'username\')"
                       class="uk-button uk-button-primary"
                       style="float:left">Check Username</a>
                    <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
                         id="usernameDiv"></div>
                </td>
            </tr>
            <tr>
                <td><strong><label for="amount">Amount to Transfer (' . $settings_trading->token_name . '):</label></strong></td>
                <td>
                    <input type="text" name="amount" id="amount" style="float:left">
                    <input type="submit" name="submit" value="Transfer" class="uk-button uk-button-primary">                    
                </td>
            </tr>
        </table>
    </form>';
}

/**
 * @param $username
 *
 * @return mixed|null
 *
 * @since version
 */
function user_username($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username)
	)->loadObject();
}

/**
 * @param $user_id
 * @param $amount
 * @param $username
 * @param $edit
 *
 *
 * @since version
 */
function validate_input($user_id, $amount, $username, $edit)
{
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

	$cybercharge = $settings_ancillaries->cybercharge / 100;

	$app = application();

	$btc_currency = usdt_currency();

	$transfer_from = user($user_id);

	if ($amount === '' ||
		!is_numeric($amount) ||
		$username === '' ||
		$username === $transfer_from->username)
	{
		$app->redirect(Uri::root(true) . '/' . sef(102), 'Invalid Transaction!', 'error');
	}

	if ($transfer_from->payout_transfer < ($settings_ancillaries->{$transfer_from->account_type .
			'_min_bal_usd'} + $amount * $btc_currency * $settings_trading->fmc_to_usd * $cybercharge))
	{
		$err = 'Please maintain at least ' . number_format(($settings_ancillaries->{$transfer_from->account_type .
				'_min_bal_usd'} + $amount * $btc_currency * $settings_trading->fmc_to_usd * $cybercharge),
				2) . ' E-Fund'/* . $settings_ancillaries->currency*/
		;

		$app->redirect(Uri::root(true) . '/' . sef(102), $err, 'error');
	}

	if ($transfer_from->balance_fmc < ($amount +
			$settings_ancillaries->{$transfer_from->account_type . '_min_bal_fmc'}))
	{
		$err = 'Please maintain at least ' . number_format(($amount +
				$settings_ancillaries->{$transfer_from->account_type .
				'_min_bal_fmc'}), 8) . ' ' . $settings_trading->token_name;

		$app->redirect(Uri::root(true) . '/' . sef(102), $err, 'error');
	}

	$transfer_to = user_username($username);

	if ($transfer_to->id === '')
	{
		$err = 'Invalid user!';

		$app->redirect(Uri::root(true) . '/' . sef(102), $err, 'error');
	}

	if ($edit)
	{
		$date = input_get('date', '', 'RAW');

		if ($date === '')
		{
			$err = 'Please specify the Current Date!';

			$app->redirect(Uri::root(true) . '/' . sef(102), $err, 'error');
		}
	}
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_user_transfer_from($user_id, $amount)
{
	$user = user($user_id);

	$settings_trading = settings('trading');
	$cybercharge      = settings('ancillaries')->cybercharge / 100;

	$charge = $amount * usdt_currency() * $settings_trading->fmc_to_usd * $cybercharge;
	$fee    = $settings_trading->{$user->account_type . '_transfer_fee'};

	$deductions = $charge + $fee;

	update(
		'network_users',
		[
			'payout_transfer = payout_transfer - ' . $deductions,
			'balance_fmc = balance_fmc - ' . $amount,
			'coin_transfer = coin_transfer + ' . $amount
		],
		['id = ' . db()->quote($user_id)]
	);
}

/**
 * @param $username
 * @param $amount
 *
 *
 * @since version
 */
function update_user_transfer_to($username, $amount)
{
	update(
		'network_users',
		['balance_fmc = balance_fmc + ' . $amount],
		['id = ' . db()->quote(user_username($username)->id)]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function insert_token_transfer($user_id, $username, $amount, $date)
{
	$db = db();

	insert(
		'network_transfer_fmc',
		[
			'transfer_from',
			'transfer_to',
			'date',
			'amount'
		],
		[
			$db->quote($user_id),
			$db->quote(user_username($username)->id),
			$db->quote($date),
			$db->quote($amount)
		]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function log_activity($user_id, $username, $amount, $date)
{
	$db = db();

	$token_name = settings('trading')->token_name;

	$transfer_from = user($user_id);
	$transfer_to   = user_username($username);

	$activity = '<b>' . $token_name . ' Transfer: </b> <a href="' . sef(44) . qs() . 'uid=' . $user_id . '">' .
		$transfer_from->username . '</a> transferred ' . number_format($amount, 8) . ' ' . $token_name .
		' to <a href="' . sef(44) . qs() . 'uid=' . $transfer_to->id . '">' . $transfer_to->username . '</a>.';

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
			$db->quote($transfer_from->id),
			$db->quote($transfer_from->sponsor_id),
			$db->quote(1),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function log_transactions($user_id, $username, $amount, $date)
{
	$db = db();

	$settings_trading = settings('trading');

	$transfer_from = user($user_id);
	$transfer_to   = user_username($username);

	$details = '<b>' . $settings_trading->token_name . ' Transfer: </b> <a href="' . sef(44) .
		qs() . 'uid=' . $user_id . '">' . $transfer_from->username . '</a> transferred ' .
		number_format($amount, 8) . ' ' . $settings_trading->token_name . ' to <a href="' .
		sef(44) . qs() . 'uid=' . $transfer_to->id . '">' . $transfer_to->username . '</a>.';

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
			$db->quote($transfer_from->id),
			$db->quote($settings_trading->token_name . ' Transfer'),
			$db->quote($details),
			$amount,
			($transfer_from->payout_transfer - $amount * usdt_currency() * $settings_trading
					->fmc_to_usd * settings('ancillaries')->cybercharge / 100),
			$db->quote($date)
		]
	);
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function income_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 * @param $insert_id
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function log_income_admin($insert_id, $amount, $date)
{
	$db = db();

	$settings_trading = settings('trading');

	$cybercharge = settings('ancillaries')->cybercharge / 100;

	$btc_currency = usdt_currency();

	$income_total = income_admin();

	$income = $income_total ? ($income_total->income_total +
		$amount * $btc_currency * $settings_trading->fmc_to_usd * $cybercharge) : 0;

	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($amount * $btc_currency * $settings_trading->fmc_to_usd * $cybercharge),
			$db->quote($income),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $username
 * @param $amount
 * @param $date
 *
 *
 * @since version
 */
function logs($user_id, $username, $amount, $date)
{
	log_activity($user_id, $username, $amount, $date);
	log_transactions($user_id, $username, $amount, $date);
	log_income_admin(db()->insertid(), $amount, $date);
}

/**
 * @param $user_id
 * @param $amount
 * @param $username
 * @param $date
 *
 *
 * @since version
 */
function process_transfer($user_id, $amount, $username, $date)
{
	$db = db();

	$settings_trading = settings('trading');

	$transfer_from = user($user_id);

	$transfer_to = user_username($username);

	// mail admin and user
	$message = '<strong>Sender</strong>
			Username: ' . $transfer_from->username . '<br>
			Full Name: ' . $transfer_from->fullname . '<br>
			Email: ' . $transfer_from->email . '<br>
			Contact Number: ' . $transfer_from->contact . '<br><br>

			<strong>Recipient</strong>
			Username: ' . $transfer_to->username . '<br>
			Full Name: ' . $transfer_to->fullname . '<br>
			Email: ' . $transfer_to->email . '<br>
			Contact Number: ' . $transfer_to->contact . '<br><br>

			<strong>Amount Transferred</strong><br>
			' . $amount . ' ' . $settings_trading->token_name . '<br>';

	try
	{
		$db->transactionStart();

		update_user_transfer_from($user_id, $amount);
		update_user_transfer_to($username, $amount);

		insert_token_transfer($user_id, $username, $amount, $date);

		logs($user_id, $username, $amount, $date);

		send_mail($message, $settings_trading->token_name .
			' Transfer', [$transfer_from->email, $transfer_to->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

//	send_mail($user_id, $username, $amount);

	application()->redirect(Uri::root(true) . '/' . sef(102), number_format($amount, 2) .
		' ' . settings('trading')->token_name . ' transferred to ' . $username . '.', 'notice');
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function token_transfers($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transfer_fmc ' .
		'WHERE (transfer_from = ' . $db->quote($user_id) .
		' OR transfer_to = ' . $db->quote($user_id) .
		') AND type = ' . $db->quote('transfer') .
		' ORDER BY date DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_transfer_history($user_id): string
{
	$settings_trading = settings('trading');

	$transfers = token_transfers($user_id);

	$str = '';

	if (empty($transfers))
	{
		$str .= '<hr><p>No transfers yet.</p>';
	}
	else
	{
		$str .= '<h2>' . $settings_trading->token_name . ' Transfer History</h2>
		    <table class="category table table-striped table-bordered table-hover">
		        <thead>
		        <tr>
		            <th>Date Transferred</th>
		            <th>Transfer From</th>
		            <th>Transfer To</th>
		            <th>Amount (' . $settings_trading->token_name . ')</th>
		        </tr>
		        </thead>
		        <tbody>';

		$str .= view_row_transfers($transfers);

		$str .= '</tbody>
    		</table>';
	}

	return $str;
}