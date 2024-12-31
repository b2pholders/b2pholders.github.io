<?php

namespace BPL\Ajax\Ajaxer\API_Gold;

require_once 'bpl/ajax/ajaxer/jquery_number.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;

/**
 * @param $fmc_to_usd
 *
 * @return string
 *
 * @since version
 */
function main($fmc_to_usd): string
{
	$str = '<script>';
	$str .= '(function ($) {
            setInterval(
                function () {
                    $.ajax({
                        url: "https://www.quandl.com/api/v3/datasets/WGC/GOLD_DAILY_USD.json?api_key=scee1Y9UsoziEcoJsXHW",
                        success: function (json) {
                            var fmc = json.dataset.data[0][1] * ' . $fmc_to_usd . ';
                            $.ajax({
                                url: "https://www.quandl.com/api/v3/datasets/CURRFX/USDPHP.json?api_key=scee1Y9UsoziEcoJsXHW",
                                success: function (json2) {
                                    var usd_php = json2.dataset.data[0][1];
                                    var usd_au = usd_php * fmc;
                                    $("#fmc_mkt_price_online").html($.number(usd_au, 5));
                                },
                                error: function () {
                                    $("#fmc_mkt_price_online").html("1321.50000");
                                }
                            });
                        },
                        error: function () {
                            $("#fmc_mkt_price_online").html("1321.50000");
                        }
                    });
                },
                33000
            );
        })(jQuery);';
	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}