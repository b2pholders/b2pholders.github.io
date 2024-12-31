<?php

namespace BPL\Jumi\Converter_Token;

require_once 'bpl/ajax/ajaxer/api_coin.php';
require_once 'bpl/ajax/ajaxer/amount_xch.php';
require_once 'bpl/ajax/ajaxer/amount_xch_buy.php';
require_once 'bpl/ajax/ajaxer/xch.php';
require_once 'bpl/ajax/ajaxer/xch_buy.php';
//require_once 'bpl/mods/btc_currency.php';
require_once 'bpl/mods/usdt_currency.php';

require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\API_Coin\main as api_coin;
use function BPL\Ajax\Ajaxer\Token\Vault\Exchange\Amount\main as amount_xch;
use function BPL\Ajax\Ajaxer\Token\Vault\Exchange_Buy\Amount\main as amount_xch_buy;
use function BPL\Ajax\Ajaxer\Token\Exchange\main as xch;
use function BPL\Ajax\Ajaxer\Token\Exchange_Buy\main as xch_buy;

//use function BPL\Mods\BTC_Currency\main as btc_currency;

use function BPL\Mods\USDT_Currency\main as usdt_currency;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	page_validate();

	$str = menu();

	$str .= converter(session_get('user_id'));

	echo $str;
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function token_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_fmc'
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function header($user_id): string
{
	$sa = settings('ancillaries');

	$str = '<h2>Portal</h2>';

	$str .= '<h3>';

	$str .= '<span style="font-size: large; font-weight: bold">
            <span style="color: green">Market Price: </span><span id="rate_sell">' .
		number_format(usdt_currency(), 5) . '</span>';

	$str .= '<span style="float: right; font-size: large; font-weight: bold">
            <span style="color: green">Cash Balance: </span><span class="usd_bal_now_user">' .
		number_format(user($user_id)->payout_transfer, 5) . '</span>';

	$str .= '</h3>';

	return $str;
}

function footer($user_id): string
{
	$str = '<h2>';

	$str .= '<span style="font-size: large; font-weight: bold">
            <span style="color: green">' . settings('trading')->token_name .
		': </span><span class="fmc_bal_now_user">' .
		number_format(user($user_id)->balance_fmc, 8) . '</span>';

	$str .= '<span style="float: right; font-size: large; font-weight: bold">
            <span style="color: green">Available Stock:' . ' </span><span class="fmc_bal_now_vlt">' .
		number_format(token_admin()->balance, 8) . '</span>';

    $str .= '</h2>';

	return $str;
}

function converter($user_id): string
{
	$str = header($user_id);

	$str .= sell();
	$str .= buy();

	$str .= footer($user_id);

	$str .= api_coin();
	$str .= amount_xch($user_id);
	$str .= amount_xch_buy($user_id);
	$str .= xch($user_id);
	$str .= xch_buy($user_id);

	return $str;
}

function sell(): string
{
	$str = '<div class="table-responsive">';
	$str .= '<table class="category table table-striped table-bordered table-hover">';
	$str .= '<tr>';
	$str .= '<td style="text-align: center; width: 25%; vertical-align: middle">';
	$str .= '<strong style="font-size: large">Total: <span id="total_xch">0.00000</span></strong>';
	$str .= '</td>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<div>';
	$str .= '<span style="color: red" id="error_xch"></span>';
	$str .= '<span style="color: green" id="success_xch"></span>';
	$str .= '</div>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '<tr>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<strong>';
	$str .= '<label>';
	$str .= '<input type="button" value="Sell" class="uk-button uk-button-primary" id="xch"
                style="font-size: large; text-align: center; vertical-align: middle">';
	$str .= '</label>';
	$str .= '</strong>';
	$str .= '</td>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<br>';
	$str .= '<strong><label for="amount_xch"><input
                                    type="text"
                                    id="amount_xch"
                                    style="font-size: large;
                                    text-align: center;
                                    vertical-align: middle"></label></strong>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '<tr>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<strong style="font-size: large">Charge: <span id="charge_xch">0.00000</span></strong>';
	$str .= '</td>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<strong style="font-size: large">Subtotal: <span id="subtotal_xch">0.00000</span></strong>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '</table>';
	$str .= '</div>';

	return $str;
}

function buy(): string
{
	$str = '<div class="table-responsive">';
	$str .= '<table class="category table table-striped table-bordered table-hover">';
	$str .= '<tr>';
	$str .= '<td style="text-align: center; width: 25%; vertical-align: middle">';
	$str .= '<strong style="font-size: large">Total: <span id="total_xch_buy">0.00000</span></strong>';
	$str .= '</td>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<div>';
	$str .= '<span style="color: red" id="error_xch_buy"></span>';
	$str .= '<span style="color: green" id="success_xch_buy"></span>';
	$str .= '</div>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '<tr>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<strong>';
	$str .= '<label>';
	$str .= '<input type="button" value="Buy" class="uk-button uk-button-primary" id="xch_buy"
                style="font-size: large; text-align: center; vertical-align: middle">';
	$str .= '</label>';
	$str .= '</strong>';
	$str .= '</td>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<br>';
	$str .= '<strong><label for="amount_xch_buy"><input
                                    type="text"
                                    id="amount_xch_buy"
                                    style="font-size: large;
                                    text-align: center;
                                    vertical-align: middle"></label></strong>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '<tr>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<strong style="font-size: large">Charge: <span id="charge_xch_buy">0.00000</span></strong>';
	$str .= '</td>';
	$str .= '<td style="text-align: center; vertical-align: middle">';
	$str .= '<strong style="font-size: large">Subtotal: <span id="subtotal_xch_buy">0.00000</span></strong>';
	$str .= '</td>';
	$str .= '</tr>';
	$str .= '</table>';
	$str .= '</div>';

	return $str;
}