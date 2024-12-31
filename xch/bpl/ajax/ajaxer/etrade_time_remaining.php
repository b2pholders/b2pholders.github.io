<?php

namespace BPL\Ajax\Ajaxer\Etrade\Time_Remaining;

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
                    $(".etrade_time_remaining").load(
                        "bpl/ajax/action.php",
                        {
                            action: "time_remaining",
                            user_id: ' . $user_id .
		'}
                    ).fadeIn("slow");
                },
                3000
            );
        })(jQuery);';
	$str .= '</script>';

	return $str;
}