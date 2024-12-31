<?php

namespace BPL\Ajax\Ajaxer\Process_Time_Remaining;

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function main($user_id): string
{
	/* trade profit processing time upon registration */
	$str = '<script>';
	$str .= '(function ($) {
            setInterval(
                function () {
                    $(".process_time_remaining").load(
                        "bpl/ajax/action.php",
                        {
                            action: "process_time_remaining",
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