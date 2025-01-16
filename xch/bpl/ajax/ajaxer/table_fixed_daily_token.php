<?php

namespace BPL\Ajax\Ajaxer\Table_Fixed_Daily_Token;

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
                            action: "table_fixed_daily_token",
                            user_id: ' . $user_id .
        '},
                        success: function (data) {
                            $("#table_fixed_daily_token").html(data);
                        }
                    });
                },
                5000
            );
        })(jQuery);';
    $str .= '</script>';

    return $str;
}