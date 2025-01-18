<?php

namespace BPL\Jumi\Fifth_Pair_Token_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

// use Exception;

use Joomla\CMS\Uri\Uri;
// use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
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
	$amount = input_get('amount_fpt');

	session_set('fpt', $amount);

	page_validate();

	$str = menu();

	$str .= '<h1>Loyalty Token Wallet</h1>';

	if ($amount !== '') {
		process_form($user_id, $amount);
	}

	$str .= view_form($user_id);

	echo $str;
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
	$sef = sef(153);

	$app = application();

	$user = user($user_id);

	if ($amount > $user->fifth_pair_token_balance) {
		$app->redirect(
			Uri::root(true) . '/' . $sef,
			'Exceeds Loyalty Token Balance!',
			'error'
		);
	}
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

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function process_form($user_id, $amount)
{
	validate_input($user_id, $amount);

	application()->redirect(Uri::root(true) . '/' . sef(98));
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_user($user_id, $amount)
{
	$db = db();

	$field_user = ['fixed_daily_balance = fixed_daily_balance - ' . $amount];

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user_id)]
	);
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
	transaction_deposit_to($user_id, $amount);

	transaction_deposit_from($user_id, $amount);

	activity($user_id, $amount);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function transaction_deposit_to($user_id, $amount)
{
	$db = db();

	$currency = settings('ancillaries')->currency;

	$user = user($user_id);

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
			$db->quote(settings('plans')->fixed_daily_name . ' Convert'),
			$db->quote(number_format($amount, 2) . ' ' . $currency .
				' converted to ' . $currency . ' of <a href="' . sef(44) . qs() .
				'uid=' . $user_id . '">' . $user->username . '</a>.'),
			$db->quote($amount),
			$db->quote((double) $user->payout_transfer + (double) $amount),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function transaction_deposit_from($user_id, $amount)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

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
			$db->quote($settings_plans->fixed_daily_name . ' Deposit'),
			$db->quote(number_format($amount, 2) . ' ' . settings('ancillaries')->currency .
				' converted from ' . $settings_plans->fixed_daily_name .
				' Wallet of <a href="' . sef(44) . qs() . 'uid=' .
				$user_id . '">' . $user->username . '</a>.'),
			$db->quote($amount),
			$db->quote($user->fixed_daily_balance - $amount),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function activity($user_id, $amount)
{
	$db = db();

	$user = user($user_id);

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
			$db->quote('<b>' . settings('plans')->fixed_daily_name . ' Convert: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> converted ' .
				number_format($amount, 2) . ' ' . settings('ancillaries')->currency . ' to e-Wallet.'),
			$db->quote(time())
		]
	);
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
	$user = user($user_id);

	$str = '<form method="post">
	    <table class="category table table-striped table-bordered table-hover">
	        <tr>
	            <td><strong>Loyalty Token Balance: ' .
		number_format($user->fifth_pair_token_balance, 8) . ' B2P</strong>';
	$str .= '</td>
	        </tr>
	        <tr>
	            <td>
	                <div class="uk-form-row">
	                    <input type="text"
	                           placeholder="Input Amount"
	                           name="amount_fpt"
	                           class="uk-form-medium uk-form-width-medium"
	                           required>
	                    <input class="uk-button uk-button-medium"
	                           name="submit"
	                           value="Withdraw" style="margin-bottom: 10px"
	                           type="submit">
	                </div>
	            </td>
	        </tr>
	    </table>
	</form>';

	return $str;
}