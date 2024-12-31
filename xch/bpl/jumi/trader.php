<?php

namespace BPL\Jumi\Trader;

//require_once 'bpl/mods/btc_currency.php';
require_once 'bpl/mods/usdt_currency.php';

require_once 'bpl/ajax/ajaxer/api_coin.php';
require_once 'bpl/ajax/ajaxer/amount_buy_trade.php';
require_once 'bpl/ajax/ajaxer/price_buy_trade.php';
require_once 'bpl/ajax/ajaxer/buy_trade.php';
require_once 'bpl/ajax/ajaxer/amount_sell_trade.php';
require_once 'bpl/ajax/ajaxer/price_sell_trade.php';
require_once 'bpl/ajax/ajaxer/sell_trade.php';
require_once 'bpl/ajax/ajaxer/table_trade.php';

require_once 'bpl/mods/helpers.php';

//use function BPL\Mods\BTC_Currency\price_ask as btc_price_ask;
//use function BPL\Mods\BTC_Currency\price_bid as btc_price_bid;

//use function BPL\Mods\USDT_Currency\main as usdt_price;
use function BPL\Mods\USDT_Currency\price_ask;
use function BPL\Mods\USDT_Currency\price_bid;

use function BPL\Ajax\Ajaxer\API_Coin\main as api_coin;
use function BPL\Ajax\Ajaxer\Token\Trade\Buy\Amount\main as amount_buy_trade;
use function BPL\Ajax\Ajaxer\Token\Trade\Buy\Price\main as price_buy_trade;
use function BPL\Ajax\Ajaxer\Token\Trade\Buy\main as buy_trade;
use function BPL\Ajax\Ajaxer\Token\Trade\Sell\Amount\main as amount_sell_trade;
use function BPL\Ajax\Ajaxer\Token\Trade\Sell\Price\main as price_sell_trade;
use function BPL\Ajax\Ajaxer\Token\Trade\Sell\main as sell_trade;
use function BPL\Ajax\Ajaxer\Token\Trade\Table\main as table_trade;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id  = session_get('user_id');

	page_validate();

	$str = menu();

	$str .= view_trader($user_id);

	echo $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_trader($user_id): string
{
	$user = user($user_id);

	$settings_trading = settings('trading');

//	$currency = settings('ancillaries')->currency;

	$token_name = $settings_trading->token_name;

	$str = '';

//	if ($user->account_type !== 'starter')
//	{
		$price_bid = number_format(price_bid(), 5);
		$price_ask = number_format(price_ask(), 5);

		$str .= '<h2>' . /*$token_name .*/ 'Buy<span style="float: right; font-size: large; font-weight: bold">
            <span style="color: green">' . $token_name . ' Price: </span><span id="rate_buy">' . $price_bid/*usdt_price()*/ .
			'</span> ' . /*$currency .*/ /*' / ' . $token_name .*/ '</span></h2>';
		$str .= '<table class="category table table-striped table-bordered">
			<tr>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">Amount: <span id="total_buy_trade">0.00</span>' . /*$currency .*/ '</strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<div>
						<span id="debug_buy_trade"></span>
						<span style="color: red" id="error_buy_trade"></span>
						<span style="color: green" id="success_buy_trade"></span>
						<span style="color: red" id="error_amount_buy_trade"></span>
					</div>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<div>
						<span style="color: red" id="error_price_buy_trade"></span>
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: center; vertical-align: middle">
					<strong><label><input type="button"
					                      value="Buy"
					                      class="uk-button uk-button-primary"
					                      id="buy_trade"
					                      style="font-size: large;
                                       text-align: center;
                                       vertical-align: middle"></label></strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong><label for="amount_buy_trade"><input type="text"
					                                             id="amount_buy_trade"
					                                             style="font-size: large;
                                                                        text-align: center;
                                                                        vertical-align: middle"></label></strong>
					<div style="font-size: large; text-align: center"><strong>Quantity</strong></div>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong><label for="price_buy_trade"><input type="text"
					                                            id="price_buy_trade"
					                                            style="font-size: large;
                                                                        text-align: center;
                                                                        vertical-align: middle"></label></strong>
					<div style="font-size: large; text-align: center"><strong>Price</strong></div>
				</td>
			</tr>
			<tr>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">Charge: <span
							id="charge_buy_trade">0.00</span> ' . /*$currency .*/ '</strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">Subtotal: <span
							id="subtotal_buy_trade">0.00</span> ' . /*$currency .*/ '</strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">' . settings('ancillaries')->efund_name . ' Balance: <span
							class="usd_bal_now_user">' . number_format($user->payout_transfer, 2) .
			' ' . /*$currency .*/ '</span></strong>
				</td>
			</tr>
		</table>
		<br>
		<hr><br>';
		$str .= '<h2>' . /*$token_name .*/ 'Sell<span style="float: right; font-size: large; font-weight: bold">
            <span style="color: green">' . $token_name . ' Price: </span><span id="rate_sell">' . $price_ask/*usdt_price()*/ .
			'</span> ' ./* $currency .*/ /*' / ' . $token_name .*/ '</span></h2>';
		$str .= '<table class="category table table-striped table-bordered">
			<tr>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">Amount: <span id="total_sell_trade">0.00</span> ' . /*$currency .*/ '</strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<div>
						<span style="color: red" id="error_sell_trade"></span>
						<span style="color: green" id="success_sell_trade"></span>
						<span style="color: red" id="error_amount_sell_trade"></span>
						<span id="debug_sell_trade"></span>
					</div>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<div>
						<span style="color: red" id="error_price_sell_trade"></span>
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: center; vertical-align: middle">
					<strong><label><input type="button"
					                      value="Sell"
					                      class="uk-button uk-button-primary"
					                      id="sell_trade"
					                      style="font-size: large;
                                       text-align: center;
                                       vertical-align: middle"></label></strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong><label for="amount_sell_trade"><input type="text"
					                                              id="amount_sell_trade"
					                                              style="font-size: large;
                                                                        text-align: center;
                                                                        vertical-align: middle"></label></strong>
					<div style="font-size: large; text-align: center"><strong>Quantity</strong></div>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong><label for="price_sell_trade"><input type="text"
					                                             id="price_sell_trade"
					                                             style="font-size: large;
                                                                        text-align: center;
                                                                        vertical-align: middle"></label></strong>
					<div style="font-size: large; text-align: center"><strong>Price</strong></div>
				</td>
			</tr>
			<tr>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">Charge: <span
							id="charge_sell_trade">0.00</span> ' . /*$currency .*/ '</strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">Subtotal: <span
							id="subtotal_sell_trade">0.00</span> ' . /*$currency .*/ '</strong>
				</td>
				<td style="text-align: center; vertical-align: middle">
					<strong style="font-size: large">' . /*$token_name .*/ ' Tokens: <span
							class="fmc_bal_now_user">' . number_format($user->balance_fmc, 8) .
			'</span> ' . $token_name . '</strong>
				</td>
			</tr>
		</table>
		<div class="uk-container uk-container-center" style="padding: 0 0 0 0;">
			<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin>
				<div id="table_trade_buy" class="uk-width-1-1 uk-width-medium-1-3"></div>
				<div id="table_trade_sell" class="uk-width-1-1 uk-width-medium-1-3"></div>
				<div id="table_trade_complete" class="uk-width-1-1 uk-width-medium-1-3"></div>
			</section>
		</div>';

		$str .= api_coin(/*$currency, $settings_trading->fmc_to_usd*/);
		$str .= amount_buy_trade($user_id);
		$str .= price_buy_trade($user_id);
		$str .= buy_trade($user_id);
		$str .= amount_sell_trade($user_id);
		$str .= price_sell_trade($user_id);
		$str .= sell_trade($user_id);
		$str .= table_trade($user_id);
//	}

	return $str;
}