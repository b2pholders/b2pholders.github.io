<?php

namespace BPL\Ajax\Ajaxer\Time_Remaining_To_Top_Up;

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
                    $(".time_remaining_to_top_up").load(
                        "bpl/ajax/action.php",
                        {
                            action: "time_remaining_to_top_up",
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