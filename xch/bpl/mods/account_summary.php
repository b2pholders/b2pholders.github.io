<?php

namespace BPL\Mods\Account_Summary;

require_once 'bpl/mods/root_url_upline.php';
require_once 'bpl/mods/usdt_currency.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Root_Url_Upline\main as root_url;
use function BPL\Mods\USDT_Currency\main as usdt_currency;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 *
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_referral_link($user): string
{
	$settings_plans = settings('plans');

	$str = '';

	if ($settings_plans->direct_referral) {
		$http = 'http';

		$link = $http . '://' . $_SERVER['SERVER_NAME'] . root_url() . '/' . $user->username;

		$str .= '<tr>
            <td style="width: 33%">' . $settings_plans->direct_referral_name . ' Link:</td>
            <td><a href="' . $link . '">' . $link . '</a></td>
        </tr>';
	}

	return $str;
}

/**
 *
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_username($user): string
{
	return '<tr>
        <td style="width: 300px">Username:</td>
        <td>' . $user->username . '</td>
    </tr>';
}

/**
 *
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_account_type($user): string
{
	return '<tr>
	        <td>Account Type:</td>
	        <td>' . settings('entry')->{$user->account_type . '_package_name'} . '</td>
	    </tr>';
}

/**
 *
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_balance($user): string
{
	$settings_ancillaries = settings('ancillaries');

	$field_balance = $settings_ancillaries->withdrawal_mode === 'standard' ?
		'balance' : 'payout_transfer';

	return '<tr>
        <td>Balance:</td>
        <td><span class="usd_bal_now_user">' .
		number_format($user->{$field_balance}, 8) .
		' ' . $settings_ancillaries->currency .
		'</span></td>
    </tr>';
}

/**
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_efund($user): string
{
	$sa = settings('ancillaries');

	return '<tr>
        <td>' . $sa->efund_name . ':</td>
        <td><span class="usd_bal_now_user">' .
		number_format($user->payout_transfer, 8) . ' ' . $sa->currency . '</span></td>
    </tr>';
}

/**
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_points($user): string
{
	$settings_plans = settings('plans');

	$str = '';

	if ($settings_plans->unilevel || $settings_plans->redundant_binary) {
		$str .= '<tr>
        <td>Points:</td>
        <td>' . number_format($user->points, 2) . ' pts.</td>
        </tr>';
	}

	return $str;
}

/**
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_daily_incentive($user): string
{
	$settings_plans = settings('plans');

	// $currency = settings('ancillaries')->currency;

	$str = '';

	if (
		($settings_plans->etrade && !empty(user_compound($user->id))) ||
		($settings_plans->top_up && !empty(user_top_up($user->id))) ||
		($settings_plans->fast_track && !empty(user_fast_track($user->id))) ||
		($settings_plans->fixed_daily && !empty(user_fixed_daily($user->id)))
	) {
		$passive_income = $user->fixed_daily_interest + $user->top_up_interest + $user->fast_track_interest;

		$str .= '<tr>
            <td>B2P Holdings:</td>
            <td>' . number_format($passive_income, 8) . ' ' . /* $currency */ 'B2P' . '</td>
        </tr>';

		$str .= settings('investment')->{$user->account_type . '_fast_track_donation'} ? '<tr>
            <td>Cybercharge:</td>
            <td>' . number_format($user->donation, 8) . ' ' . /* $currency */ 'B2P' . '</td>
        </tr>' : '';
	}

	return $str;
}

/**
 * @param $user_id
 *
 *
 * @return array|mixed
 * @since version
 */
function user_fast_track($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fast_track ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 *
 * @return array|mixed
 * @since version
 */
function user_fixed_daily($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fixed_daily ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 *
 * @return array|mixed
 * @since version
 */
function user_compound($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_compound ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 *
 * @return array|mixed
 * @since version
 */
function user_top_up($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function row_merchant($user): string
{
	$settings_trading = settings('trading');

	$currency = settings('ancillaries')->currency;

	$token_name = $settings_trading->token_name;
	//	$fmc_to_usd = $settings_trading->fmc_to_usd;

	$token = token();

	$str = '';

	if (settings('plans')->trading) {
		if ($user->merchant_type !== 'starter') {
			$str .= '<tr>
	            <td>Merchant Bonus:</td>
	            <td>' . number_format($user->bonus_merchant, 8) . ' ' . $currency . '<span
	                        style="float: right">Global Sales (' . $token_name . '): ' .
				number_format($token->sales_fmc, 8) . ' ' . $currency . '</span>
	            </td>
	        </tr>';
		}

		//		$data = api_coin_price();

		//		$btc_currency = btc_currency();

		//		$coin_usd = usdt_currency() * $user->balance_fmc;

		$str .= '<tr>
            <td>' . $token_name . ' Tokens:</td>
            <td>
                <input id="coin_balance" type="hidden" value="' . $user->balance_fmc . '">
                <span id="fmc_bal_now_user">' . number_format($user->balance_fmc, 8) .
			'</span><span style="padding-left: 5px">' . $token_name . '</span><span style="float:right;
                        padding-left:5px">' . /*$currency .
'</span><span id="fmc_bal_now_user_usd" style="float:right">' .
(isset($coin_usd) ? number_format($coin_usd, 5) : '') .*/ '</span>
            </td>
        </tr>
        <tr id="active-income">
            <td>' . $token_name . ' Available Supply:</td>
            <td>
                <span id="fmc_bal_now_vlt">' .
			number_format($token->balance, 8) . '</span> ' . $token_name .
			'</td>
        </tr>';
	}

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function script_coin_price_php(): string
{
	return '(function ($) {
            setInterval(
                function () {
                    $.ajax({
                        url: "https://quote.coins.ph/v1/markets/BTC-' . settings('ancillaries')->currency . '",
                        success: function (data) {
                            var coin_balance = parseFloat($("#coin_balance").val());
                            var fmc_ask = parseFloat(data.market.ask);
                            var fmc_bid = parseFloat(data.market.bid);
                            var fmc = (fmc_ask + fmc_bid) * ' . settings('trading')->fmc_to_usd . ' / 2;
                            var coin_usd = fmc * coin_balance;
                            $("#coin_price").html($.number(fmc, 5));
                            $("#fmc_bal_now_user_usd").html($.number(coin_usd, 2));
                            $("#fmc_bal_now_user").html($.number(coin_balance, 12));
                        },
                        error: function () {
                            var coin_balance = parseFloat($("#coin_balance").val());
                            //var fmc_bal_now_user = parseFloat($("#fmc_bal_now_user").html());
                            var temp = coin_balance * 0.000000024;
                            $("#coin_price").html(0.000000024);
                            $("#fmc_bal_now_user_usd").html($.number(temp, 2));
                            $("#fmc_bal_now_user").html($.number(coin_balance, 12));
                        }
                    });
                },
                33000
            );
        })(jQuery);';
}

/**
 *
 * @return string
 *
 * @since version
 */
function script_coin_price(): string
{
	$currency = settings('ancillaries')->currency;

	$str = '';

	if ($currency === 'PHP') {
		$str .= script_coin_price_php();
	} else {
		$currency = settings('ancillaries')->currency;

		$symbol = $currency === 'USD' ? 'TUSDUSDT' : 'EURUSDT';

		$url = 'https://api.binance.com/api/v3/ticker/price?symbol=' . $symbol;

		$str .= '(function ($) {
            setInterval(
                function () {
                    $.ajax({
                        url: "' . $url . '",
                        success: function (data) {
                            var coin_balance = parseFloat($("#coin_balance").val());
                            var fmc = data.price * ' . settings('trading')->fmc_to_usd . ';
                            var coin_usd = fmc * coin_balance;
                            $("#coin_price").html($.number(fmc, 12));
                            $("#fmc_bal_now_user_usd").html($.number(coin_usd, 2));
                            $("#fmc_bal_now_user").html($.number(coin_balance, 12));
                        },
                        error: function () {
                            var coin_balance = parseFloat($("#coin_balance").val());
                            var temp = coin_balance * 0.000000001200;
                            $("#coin_price").html(0.000000001200);
                            $("#fmc_bal_now_user_usd").html($.number(temp, 2));
                            $("#fmc_bal_now_user").html($.number(coin_balance, 12));
                        }
                    });
                },
                33000
            );
        })(jQuery);';
	}

	return $str;
}

/**
 * @return string
 *
 * @since version
 */
function ticker_coin_price(): string
{
	$token_name = settings('trading')->token_name;

	$str = '';

	if (settings('plans')->trading) {
		$btc_currency = usdt_currency();

		$str .= '<span style="float: right; font-size: large; font-weight: bold">
            <span style="color: #26A69A">' . $token_name .
			' Price: </span><span id="coin_price" style="color: #EF5350">' .
			number_format($btc_currency, 12) . '</span> ' .
			settings('ancillaries')->currency . '</span>';
	}

	return $str;
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function token()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fmc'
	)->loadObject();
}