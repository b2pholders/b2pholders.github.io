<?php

namespace BPL\Ajax\Ajaxer\Token\Vault\Sell;

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
	// token sell execution
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $("#sell_vlt").click(function () {
                    var data = {
                        "action": "sell",
                        "amount": $("#amount_sell_vlt").val(),
                        "price": $("#rate_sell").html(),
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
                            $("#amount_sell_vlt").val("");
                            $("#subtotal_sell_vlt").html("0.00");
                            $("#charge_sell_vlt").html("0.00");
                            $("#total_sell_vlt").html("0.00");

                            $("#sell_vlt").attr("disabled", true);
                            
                            var usd_bal_now_user = data["usd_bal_now_user"] === undefined ?
                                "0.00" : data["usd_bal_now_user"];
                            var fmc_bal_now_user = data["fmc_bal_now_user"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_user"];
                            var fmc_bal_now_vlt = data["fmc_bal_now_vlt"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_vlt"];
                            var success_sell = data["success_sell"] === undefined ?
                                "" : data["success_sell"];
                            var error_sell = data["error_sell"] === undefined ?
                                "" : data["error_sell"];

                            var usd_bal_now_user_cl = $(".usd_bal_now_user");
                            var fmc_bal_now_user_cl = $(".fmc_bal_now_user");
                            var fmc_bal_now_vlt_cl = $(".fmc_bal_now_vlt");

                            $(usd_bal_now_user_cl[0]).html($.number(usd_bal_now_user, 2));
                            $(usd_bal_now_user_cl[1]).html($.number(usd_bal_now_user, 2));
                            $(fmc_bal_now_user_cl[0]).html($.number(fmc_bal_now_user, 8));
                            $(fmc_bal_now_vlt_cl[0]).html($.number(fmc_bal_now_vlt, 8));

                            if (success_sell !== "") {
                                $("#success_sell_vlt").html(success_sell).fadeIn().delay(5000).fadeOut();
                            }

                            if (error_sell !== "") {
                                $("#error_sell_vlt").html(error_sell).fadeIn().delay(5000).fadeOut();
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