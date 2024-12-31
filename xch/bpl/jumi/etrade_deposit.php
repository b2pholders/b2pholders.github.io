<?php

namespace BPL\Jumi\Etrade_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');
	$amount  = input_get('amount');

	page_validate();

	$str = menu();

	$str .= '<h1>' . settings('plans')->etrade_name . ' Wallet</h1>';

	if ($amount !== '')
	{
		validate_input($user_id, $amount);
		process_deposit($user_id, $amount);
	}

	$str .= view_form($user_id);

	echo $str;
}

/**
 * @param $amount
 * @param $user_id
 *
 *
 * @since version
 */
function update_user($amount, $user_id)
{
	update(
		'network_users',
		['compound_daily_balance = compound_daily_balance - ' . $amount,
			(settings('ancillaries')->withdrawal_mode === 'standard' ?
				'balance = balance + ' : 'payout_transfer = payout_transfer + ') . $amount],
		['id = ' . db()->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function process_deposit($user_id, $amount)
{
	$db = db();

	try
	{
		$db->transactionStart();

		update_user($amount, $user_id);

		logs($user_id, $amount);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(18),
		settings('plans')->etrade_name . ' Deposit Completed Successfully!', 'success');
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function validate_input($user_id, $amount)
{
	$si = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;

	$etrade_principal     = $si->{$account_type . '_principal'};
	$etrade_principal_cut = $si->{$account_type . '_principal_cut'} / 100;
	$etrade_interest      = $si->{$account_type . '_interest'} / 100;
	$etrade_maturity      = $si->{$account_type . '_maturity'};
	$etrade_donation      = $si->{$account_type . '_donation'} / 100;

	$maturity_principal = bcmul((string) ($etrade_principal * $etrade_principal_cut),
		bcpow((string) (1 + $etrade_interest), (string) $etrade_maturity, 7), 7);
	$minimum_deposit    = ($maturity_principal) * (1 - $etrade_donation);

	$app = application();

	if ($amount > $user->compound_daily_balance)
	{
		$app->redirect(Uri::root(true) . '/' . sef(115),
			'Deposit exceeds ' . settings('plans')->etrade_name . ' Balance!', 'error');
	}

	if (user_compound($user_id)->day < $etrade_maturity && $amount < $minimum_deposit)
	{
		$app->redirect(Uri::root(true) . '/' . sef(115),
			'Deposit only ' . number_format($minimum_deposit, 2) .
			' ' . settings('ancillaries')->currency . '!', 'error');
	}

	if (((double) $user->fast_track_deposit_today + (double) $amount) > $si->{$user->account_type . '_maximum_deposit'})
	{
		$app->redirect(Uri::root(true) . '/' . sef(115) . qs() . 'uid=' . $user_id,
			'Exceeded Maximum Deposit!', 'error');
	}
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
	$sa = settings('ancillaries');

	$currency = $sa->currency;

	$user = user($user_id);

	return '<form method="post">
	    <table class="category table table-striped table-bordered table-hover">
	        <tr>
	            <td><strong>' . settings('plans')->etrade_name . ' Balance: ' .
		number_format($user->compound_daily_balance, 2) . ' ' . $currency . ' </strong>
	                <strong style="float: right">
	                    ' . $sa->efund_name . ' Balance: ' .
		number_format($user->payout_transfer, 2) . ' ' . $currency . '</strong>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <div class="uk-form-row">
	                    <input type="text"
	                           placeholder="amount"
	                           name="amount"
	                           class="uk-form-medium uk-form-width-medium"
	                           required>
	                    <input class="uk-button uk-button-medium"
	                           name="submit"
	                           value="Deposit" style="margin-bottom: 10px"
	                           type="submit">
	                </div>
	            </td>
	        </tr>
	    </table>
	</form>';
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function logs($user_id, $amount)
{
	log_activity($amount, $user_id);
	log_transactions($amount, $user_id);
}

/**
 * @param $amount
 * @param $user_id
 *
 *
 * @since version
 */
function log_activity($amount, $user_id)
{
	$db = db();

	$user = user($user_id);

	$activity = '<b>' . settings('plans')->etrade_name . ' Deposit: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> deposited ' .
		number_format($amount, 2) . ' ' . settings('ancillaries')->currency . ' to e-Wallet.';

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
			$db->quote($user_id),
			$db->quote($user->sponsor_id),
			$db->quote($user_id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $amount
 * @param $user_id
 *
 *
 * @since version
 */
function log_transactions($amount, $user_id)
{
	$db = db();

	$sa = settings('ancillaries');

	$user = user($user_id);

	$details = number_format($amount, 2) . ' ' . settings('ancillaries')->currency .
		' deposited to ' . $sa->efund_name . ' ' . ' of <a href="' . sef(44) . qs() . 'uid=' . $user_id .
		'">' . $user->username . '</a>.';

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
			$db->quote($user_id),
			$db->quote(settings('plans')->etrade_name . ' Deposit'),
			$db->quote($details),
			$db->quote($amount),
			$db->quote((double) $user->payout_transfer + (double) $amount),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_compound($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_compound ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}