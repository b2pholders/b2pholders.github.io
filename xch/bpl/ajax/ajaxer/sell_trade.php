<?php

namespace BPL\Ajax\Ajaxer\Token\Trade\Sell;

require_once 'bpl/ajax/ajaxer/jquery_number.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;

function main($user_id): string
{
	// token sell trade execution
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $("#sell_trade").click(function () {
                    var charge_sell_trade_id = $("#charge_sell_trade");
                    var total_sell_trade_id = $("#total_sell_trade");
                    var amount_sell_trade_id = $("#amount_sell_trade");
                    var price_sell_trade_id = $("#price_sell_trade");
                    var data = {
                        "action": "sell_trade",
                        "amount": amount_sell_trade_id.val(),
                        "price": price_sell_trade_id.val(),
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
                            amount_sell_trade_id.val("");
                            price_sell_trade_id.val("");
                            charge_sell_trade_id.html("0.00");
                            total_sell_trade_id.html("0.00");
                            
                            $("#subtotal_sell_trade").html("0.00");
                            $("#sell_trade").attr("disabled", true);
                            
                            var usd_bal_now_user = data["usd_bal_now_user"] === undefined ?
                                "0.00" : data["usd_bal_now_user"];
                            var fmc_bal_now_user = data["fmc_bal_now_user"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_user"];
                            var success_sell_trade = data["success_sell_trade"] === undefined ?
                                "" : data["success_sell_trade"];
                            var error_sell_trade = data["error_sell_trade"] === undefined ?
                                "" : data["error_sell_trade"];
                            var debug = data["debug"] === undefined ? "" : data["debug"];

                            var usd_bal_now_user_cl = $(".usd_bal_now_user");
                            var fmc_bal_now_user_cl = $(".fmc_bal_now_user");

                            $(usd_bal_now_user_cl[0]).html($.number(usd_bal_now_user, 2));
                            $(fmc_bal_now_user_cl[0]).html($.number(fmc_bal_now_user, 8));
                            
                            if (success_sell_trade == "") {alert("no reply");}                          

                            if (success_sell_trade !== "") {
                                $("#success_sell_trade").html(success_sell_trade).fadeIn().delay(5000).fadeOut();
                            }

                            if (error_sell_trade !== "") {
                                $("#error_sell_trade").html(error_sell_trade).fadeIn().delay(5000).fadeOut();
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