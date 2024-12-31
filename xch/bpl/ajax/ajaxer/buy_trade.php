<?php

namespace BPL\Ajax\Ajaxer\Token\Trade\Buy;

require_once 'bpl/ajax/ajaxer/jquery_number.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function main($user_id): string
{
	// token buy trade execution
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $("#buy_trade").click(function () {
                    var charge_buy_trade_id = $("#charge_buy_trade");
                    var total_buy_trade_id = $("#total_buy_trade");
                    var amount_buy_trade_id = $("#amount_buy_trade");
                    var price_buy_trade_id = $("#price_buy_trade");
                    var data = {
                        "action": "buy_trade",
                        "amount": amount_buy_trade_id.val(),
                        "price": price_buy_trade_id.val(),
                        "user_id": ' . $user_id .
					'};
                    //data = $(this).serialize() + "&" + $.param(data);
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "bpl/ajax/action.php",
                        data: data,
                        cache: false,
                        success: function (data) {
                            amount_buy_trade_id.val("");
                            price_buy_trade_id.val("");
                            charge_buy_trade_id.html("0.00");
                            total_buy_trade_id.html("0.00");

                            $("#subtotal_buy_trade").html("0.00");
                            $("#buy_trade").attr("disabled", true);

                            var usd_bal_now_user = data["usd_bal_now_user"] === undefined ?
                                "0.00" : data["usd_bal_now_user"];
                            var fmc_bal_now_user = data["fmc_bal_now_user"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_user"];
                            var success_buy_trade = data["success_buy_trade"] === undefined ?
                                "" : data["success_buy_trade"];
                            var error_buy_trade = data["error_buy_trade"] === undefined ?
                                "" : data["error_buy_trade"];

                            var usd_bal_now_user_cl = $(".usd_bal_now_user");
                            var fmc_bal_now_user_cl = $(".fmc_bal_now_user");

                            $(usd_bal_now_user_cl[0]).html($.number(usd_bal_now_user, 2));
                            $(fmc_bal_now_user_cl[0]).html($.number(fmc_bal_now_user, 8));

                            if (success_buy_trade !== "") {
                                $("#success_buy_trade").html(success_buy_trade).fadeIn().delay(5000).fadeOut();
                            }

                            if (error_buy_trade !== "") {
                                $("#error_buy_trade").html(error_buy_trade).fadeIn().delay(5000).fadeOut();
                            }
                        }
                    });

                    return false;
                });
            });
        })(jQuery);';
	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}