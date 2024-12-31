<?php

namespace BPL\Ajax\Ajaxer\Local\API_Coin;

require_once 'account/bpl/ajax/ajaxer/jquery_number.php';
require_once 'account/bpl/mods/helpers_local.php';

//use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;
use function BPL\Mods\Local\Helpers\settings as settings_local;

/**
 * @return string
 *
 * @since version
 */
function main(/*$currency, $fmc_to_usd*/): string
{
	$currency   = settings_local('ancillaries')->currency;
	$fmc_to_usd = settings_local('trading')->fmc_to_usd;

	$str = '<script>';

	if ($currency === 'PHP')
	{
		$str .= '(function ($) {
            setInterval(
                function () {
                    $.ajax({
                        url: "https://quote.coins.ph/v2/markets/USDT-' . $currency . '",
                        success: function (data) {
                            var fmc_ask = parseFloat(data.ask) * ' . $fmc_to_usd . ', // sell
                            fmc_bid = parseFloat(data.bid) * ' . $fmc_to_usd . ', // buy
                            fmc = (fmc_ask + fmc_bid) / 2;
//                            $("#rate_sell").html($.number(fmc_ask, 5));
//                            $("#rate_buy").html($.number(fmc_bid, 5));
                            $("#fmc_mkt_price_online").html($.number(fmc, 5));
                        },
                        error: function () {
//                            $("#rate_sell").html($.number(0.012, 5));
//                            $("#rate_buy").html($.number(0.012, 5));
                            $("#fmc_mkt_price_online").html($.number(0.012, 5));
                        }
                    });
                },
                33000
            );
        })(jQuery);';
	}
	else
	{
		$symbol = $currency === 'USD' ? 'TUSDUSDT' : 'EURUSDT';
		$url    = 'https://api.binance.com/api/v3/ticker/24hr?symbol=' . $symbol;

		$str .= '(function ($) {
            setInterval(
                function () {
                    $.ajax({
                        url: "' . $url . '",
                        success: function (data) {
//                            var fmc_sell = data.askPrice * ' . $fmc_to_usd . ',
//                            fmc_buy = data.bidPrice * ' . $fmc_to_usd . ',
                            fmc = data.lastPrice * ' . $fmc_to_usd . ';
//                            $("#rate_sell").html($.number(fmc_sell, 5));
//                            $("#rate_buy").html($.number(fmc_buy, 5));
                            $("#fmc_mkt_price_online").html($.number(fmc, 5));                           
                        },
                        error: function () {                            
//                            $("#rate_sell").html($.number(0.00024, 5));
//                            $("#rate_buy").html($.number(0.00024, 5));
                            $("#fmc_mkt_price_online").html($.number(0.00024, 5));
                        }
                    });
                },
                33000
            );
        })(jQuery);';
	}

	$str .= '</script>';

	$str .= '<script src="account/bpl/plugins/jquery.number.js"></script>';

	return $str;
}