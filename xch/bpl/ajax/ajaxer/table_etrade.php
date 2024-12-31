<?php

namespace BPL\Ajax\Ajaxer\Table_Etrade;

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
	$str = '<script>';
	$str .= '(function ($) {
            setInterval(
                function () {
                    $.ajax({
                        type: "post",
                        url: "bpl/ajax/action.php",
                        data: {
                            action: "table_etrade",
                            user_id: ' . $user_id .
		'},
                        success: function (data) {
                            $("#table_etrade").html(data);
                        }
                    });
                },
                5000
            );
        })(jQuery);';
	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}