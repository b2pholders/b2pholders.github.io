<?php

namespace BPL\Jumi\Merchant_Package_Buy;

require_once 'bpl/ajax/ajaxer/api_coin.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Ajax\Ajaxer\API_Coin\main as api_coin;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
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

	page_validate();

	$str = menu();

	$type = input_get('type');

	if (session_get('merchant_type') === 'starter')
	{
		if ($type === '')
		{
			$str .= view_form($user_id);

			$str .= api_coin(settings('ancillaries')->currency, settings('trading')->fmc_to_usd);
		}
		else
		{
			process_form($user_id, $type, input_get('fmc_mkt_price_online'));
		}
	}

	echo $str;
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
	$settings_merchant = settings('merchant');

	return '<h1>Buy Merchant Package</h1>
        <form method="post">
            <input type="hidden" name="fmc_mkt_price_online" id="fmc_mkt_price_online">
            <table class="category table table-striped table-bordered table-hover">
                <tr>
                    <td><label for="type">Merchant Packages:</label></td>
                    <td>
                        <select name="type" id="type" style="float: left">
                            <option value="none" selected>Select Package</option>
                            <option value="executive">' . $settings_merchant->executive_merchant_name . '</option>
                            <option value="regular">' . $settings_merchant->regular_merchant_name . '</option>
                            <option value="associate">' . $settings_merchant->associate_merchant_name . '</option>
                            <option value="basic">' . $settings_merchant->basic_merchant_name . '</option>
                        </select>
                        <span style="float: right; font-weight: bolder">' . settings('ancillaries')->efund_name .
		' Balance (' . settings('ancillaries')->currency .
		'): ' . number_format(user($user_id)->payout_transfe, 2) . '</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="alignment: center">
                            <input type="submit" value="Buy Merchant Package" name="submit" id="code_generate"
                                   class="uk-button uk-button-primary">
                        </div>
                    </td>
                </tr>
            </table>
        </form>';
}

/**
 * @param $user_id
 * @param $type
 *
 *
 * @since version
 */
function validate_merchant($user_id, $type)
{
	$app = application();

	$settings_ancillaries = settings('ancillaries');

	if ($type === 'none')
	{
		$err = 'Please select package!';

		$app->redirect(Uri::root(true) . '/' . sef(46), $err, 'error');
	}

	$min_bal_usd    = $settings_ancillaries->{$type . '_min_bal_usd'};
	$merchant_entry = settings('merchant')->{$type . '_merchant_entry'};

	if (user($user_id)->payout_transfer < ($merchant_entry + $min_bal_usd))
	{
		$err = 'Not enough ' . $settings_ancillaries->efund_name . ', please maintain at least ' .
			number_format($merchant_entry + $min_bal_usd, 2) . ' ' . $settings_ancillaries->currency;

		$app->redirect(Uri::root(true) . '/' . sef(46), $err, 'error');
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $fmc_mkt_price_online
 *
 *
 * @since version
 */
function process_form($user_id, $type, $fmc_mkt_price_online)
{
	$db = db();

	validate_merchant($user_id, $type);

	$merchant_name  = settings('merchant')->{$type . '_merchant_name'};

	$user = user($user_id);

	$email = $user->email;

	$body = 'Username: ' . $user->username . '<br>
		Email: ' . $email . '<br>
		Merchant Type: ' . $merchant_name;

	$message_admin = 'A new ' . $merchant_name . ' merchant has been registered.<br><hr>' . $body;
	$message_user  = 'Congratulations for your successful ' .
		$merchant_name . ' Merchant Registration!.<br><hr>' . $body;

	try
	{
		$db->transactionStart();

		update_user($user_id, $type, $fmc_mkt_price_online);

		logs($user_id, $type);

		send_mail($message_admin, 'Merchant Registration Successful!');

		if ($email !== '')
		{
			send_mail($message_user, 'Merchant Registration Confirmation', [$email]);
		}

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	// mail admin
//	send_mail($user_id, $type);

	application()->redirect(Uri::root(true) . '/' . sef(41),
		settings('merchant')->{$type . '_merchant_name'} . ' Registration Successful!', 'success');
}

/**
 * @param $user_id
 * @param $type
 * @param $fmc_mkt_price_online
 *
 *
 * @since version
 */
function update_user($user_id, $type, $fmc_mkt_price_online)
{
	$db = db();

	$merchant_entry = settings('merchant')->{$type . '_merchant_entry'};

	update(
		'network_users',
		[
			'payout_transfer = payout_transfer - ' . $merchant_entry,
			'balance_fmc = balance_fmc + ' .
			number_format($merchant_entry / $fmc_mkt_price_online, 8),
			'merchant_type = ' . $db->quote($db->quote($type))
		],
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $type
 *
 *
 * @since version
 */
function logs($user_id, $type)
{
	activity($user_id, $type);
	transactions($user_id, $type);
	income_admin($type);
}

/**
 * @param $user_id
 * @param $type
 *
 *
 * @since version
 */
function activity($user_id, $type)
{
	$db = db();

	$user = user($user_id);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($user->sponsor_id),
			$db->quote('<b>' . ucfirst(settings('merchant')->{$type . '_merchant_name'}) .
				' Merchant Package Purchase: </b><a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a>.'),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $type
 *
 *
 * @since version
 */
function transactions($user_id, $type)
{
	$db = db();

	$settings_merchant = settings('merchant');

	update(
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
			$db->quote('Merchant Package Purchase'),
			$db->quote(ucfirst($settings_merchant->{$type . '_merchant_name'}) .
				' Merchant Package, <a href="' . sef(44) . qs() .
				'uid=' . $user_id . '">' . user($user_id)->username . '</a>.'),
			$db->quote($settings_merchant->{$type . '_merchant_entry'}),
			$db->quote(0),
			$db->quote(time())
		]
	);
}

/**
 * @param $type
 *
 *
 * @since version
 */
function income_admin($type)
{
	$db = db();

	$merchant_entry = settings('merchant')->{$type . '_merchant_entry'};

	$income_total = $db->setQuery(
		'SELECT income_total ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();

	$income = $income_total ? ($income_total->income_total + $merchant_entry) : 0;

	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($db->insertid()),
			$db->quote($merchant_entry),
			$db->quote($income),
			$db->quote(time())
		]
	);
}