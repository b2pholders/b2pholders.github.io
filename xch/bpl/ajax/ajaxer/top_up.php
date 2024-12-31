<?php

namespace BPL\Ajax\Ajaxer\Top_Up;

require_once 'bpl/ajax/ajaxer/jquery_number.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;

function main($user_id): string
{
	// top up execution
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $("#top_up").click(function () {
                    var data = {
                        "action": "top_up",
                        "input": $("#top_up_input").val(),
                        "user_id": ' . $user_id .
					'}
                    data = $(this).serialize() + "&" + $.param(data);
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "bpl/ajax/action.php",
                        data: data,
                        success: function (data) {
                            $("#top_up_input").val("");
                            $("#top_up").attr("disabled", true);

                            var balance = data["balance"] === undefined ? "" : data["balance"];
                            var principal = data["principal"] === undefined ? "" : data["principal"];
                            var interest = data["interest"] === undefined ? "" : data["interest"];
                            var success_top_up = data["success_top_up"] === undefined ? "" : data["success_top_up"];
                            var error_top_up = data["error_top_up"] === undefined ? "" : data["error_top_up"];

                            var usd_bal_now_user_cl = $(".usd_bal_now_user");
                            var top_up_principal_cl = $(".top_up_principal");
                            var top_up_value_last_cl = $(".top_up_value_last");
                            var success_top_up_cl = $(".success_top_up");
                            var error_top_up_cl = $(".error_top_up");

                            if (balance !== "") {
                                $(usd_bal_now_user_cl[0]).html($.number(balance, 2));
                            }
                            
                            if (principal !== "") {
                                $(top_up_principal_cl[0]).html($.number(principal, 2));
                            }
                            
                            if (interest !== "") {
                                $(top_up_value_last_cl[0]).html($.number(interest, 2));
                            }
                            
                            if (success_top_up !== "") {
                                $(success_top_up_cl[0]).html(success_top_up).fadeIn().delay(3000).fadeOut();
                            }
                                                       
                            if (error_top_up !== "") {
                                $(error_top_up_cl[0]).html(error_top_up).fadeIn().delay(3000).fadeOut();
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