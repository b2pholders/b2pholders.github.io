<?php

namespace BPL\Ajax\Ajaxer\Etrade;

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function main($user_id): string
{
	$str = '<script>';
	$str .= '(function ($) {
            $(document).ready(function () {
                $(".etrade").click(function () {
                    var data = {
                        "action": "etrade",
                        "user_id": ' . $user_id .
		'};
                    data = $(this).serialize() + "&" + $.param(data);
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "bpl/ajax/action.php",
                        data: data,
                        success: function (data) {
                            var value_last = data["value_last"] === undefined ? "" : data["value_last"];
                            var error = data["error"] === undefined ? "" : data["error"];

                            $(".etrade_value_last").html(value_last);
                            
                            if (error !== "") {
                                $(".etrade_error").html(error);
                            }                           
                        }
                    });
                    
                    return false;
                });
            });
        })(jQuery);';
	$str .= '</script>';

	return $str;
}