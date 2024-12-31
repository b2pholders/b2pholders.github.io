<?php

namespace BPL\Ajax\Ajaxer\Token\Exchange;

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
	// convert execution
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $("#xch").click(function () {
                    var data = {
                        "action": "xch",
                        "amount": $("#amount_xch").val(),
                        "total": $("#total_xch").html(),
                        "charge": $("#charge_xch").html(),
                        "user_id": ' . $user_id .
					'};                   
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "bpl/ajax/action.php",
                        data: data,
                        cache: false,
                        success: function (data) {
                            $("#amount_xch").val("");
                            $("#subtotal_xch").html("0.00000");
                            $("#charge_xch").html("0.00000");
                            $("#total_xch").html("0.00000");

                            $("#xch").attr("disabled", true);
                            
                            var usd_bal_now_user = data["usd_bal_now_user"] === undefined ?
                                "0.00000" : data["usd_bal_now_user"];
                            var fmc_bal_now_user = data["fmc_bal_now_user"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_user"];
                            var fmc_bal_now_vlt = data["fmc_bal_now_vlt"] === undefined ?
                                "0.00000000" : data["fmc_bal_now_vlt"];
                            var success_xch = data["success_xch"] === undefined ?
                                "" : data["success_xch"];
                            var error_xch = data["error_xch"] === undefined ?
                                "" : data["error_xch"];

                            var usd_bal_now_user_cl = $(".usd_bal_now_user");
                            var fmc_bal_now_user_cl = $(".fmc_bal_now_user");
                            var fmc_bal_now_vlt_cl = $(".fmc_bal_now_vlt");

                            $(usd_bal_now_user_cl[0]).html($.number(usd_bal_now_user, 5));
                            $(fmc_bal_now_user_cl[0]).html($.number(fmc_bal_now_user, 8));
                            $(fmc_bal_now_vlt_cl[0]).html($.number(fmc_bal_now_vlt, 8));

                            if (success_xch !== "")
                            {
                                $("#success_xch").html(success_xch).fadeIn().delay(5000).fadeOut();
                            }

                            if (error_xch !== "")
                            {
                                $("#error_xch").html(error_xch).fadeIn().delay(5000).fadeOut();
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