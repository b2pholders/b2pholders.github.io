<?php

namespace BPL\Ajax\Ajaxer\Token\Vault\Buy;

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
	// token buy execution
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $("#buy_vlt").click(function () {
                    var data = {
                        "action": "buy",
                        "amount": $("#amount_buy_vlt").val(),
                        "price": $("#rate_buy").html(),
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
                            $("#amount_buy_vlt").val("");
                            $("#subtotal_buy_vlt").html("0.00");
                            $("#charge_buy_vlt").html("0.00");
                            $("#total_buy_vlt").html("0.00");

                            $("#buy_vlt").attr("disabled", true);
                            
                            var usd_bal_now_user = data["usd_bal_now_user"] === undefined ?
                                "0.00" : data["usd_bal_now_user"];
                            var fmc_bal_now_user = data["fmc_bal_now_user"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_user"];
                            var fmc_bal_now_vlt = data["fmc_bal_now_vlt"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_vlt"];
                            var success_buy = data["success_buy"] === undefined ?
                                "" : data["success_buy"];
                            var error_buy = data["error_buy"] === undefined ?
                                "" : data["error_buy"];

                            var usd_bal_now_user_cl = $(".usd_bal_now_user");
                            var fmc_bal_now_user_cl = $(".fmc_bal_now_user");
                            var fmc_bal_now_vlt_cl = $(".fmc_bal_now_vlt");

                            $(usd_bal_now_user_cl[0]).html($.number(usd_bal_now_user, 2));
                            $(fmc_bal_now_user_cl[0]).html($.number(fmc_bal_now_user, 8));
                            $(fmc_bal_now_vlt_cl[0]).html($.number(fmc_bal_now_vlt, 8));

                            if (success_buy !== "") {
                                $("#success_buy_vlt").html(success_buy).fadeIn().delay(5000).fadeOut();
                            }

                            if (error_buy !== "") {
                                $("#error_buy_vlt").html(error_buy).fadeIn().delay(5000).fadeOut();
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