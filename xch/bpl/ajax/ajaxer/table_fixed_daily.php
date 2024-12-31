<?php

namespace BPL\Ajax\Ajaxer\Table_Fixed_Daily;

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
            setInterval(
                function () {
                    $.ajax({
                        type: "post",
                        url: "bpl/ajax/action.php",
                        data: {
                            action: "table_fixed_daily",
                            user_id: ' . $user_id .
						'},
                        success: function (data) {
                            $("#table_fixed_daily").html(data);
                        }
                    });
                },
                5000
            );
        })(jQuery);';
	$str .= '</script>';

	return $str;
}