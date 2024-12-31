<?php

namespace BPL\Ajax\Ajaxer\Time_Remaining_To_Activate;

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function main($user_id): string
{
	/* top up trade profit processing time upon top up */
	$str = '<script>';
	$str .= '(function ($) {
            setInterval(
                function () {
                    $("#time_remaining_to_activate").load(
                        "bpl/ajax/action.php",
                        {
                            action: "time_remaining_to_activate",
                            user_id: ' . $user_id .
						'}
                    ).fadeIn("slow");
                },
                10000
            );
        })(jQuery);';
	$str .= '</script>';

	return $str;
}