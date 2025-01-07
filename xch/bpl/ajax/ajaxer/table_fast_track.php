<?php

namespace BPL\Ajax\Ajaxer\Table_Fast_Track;

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
    $str = <<<JS
    <script>
        const table_fast_track = setInterval(
            function () {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_fast_track",
                        user_id: $user_id
                    },
                    ifModified: true,
                    success: function (data) {
                        jQuery("#table_fast_track").html(data);
                    }
                });
            },
            5000
        );

        function loadPage(page) {
            if (page > 0) {
                clearInterval(table_fast_track);
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_fast_track",
                        user_id: $user_id,
                        page: page
                    },
                    success: function (data) {
                        jQuery("#table_fast_track").html(data);
                    }
                });
            } else {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_fast_track",
                        user_id: $user_id,
                        page: page
                    },
                    success: function (data) {
                        jQuery("#table_fast_track").html(data);
                        table_fast_track;                      
                    }
                });
            }
        };

        setInterval(
            function () {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "profit_fast_track",
                        user_id: $user_id
                    },
                    success: function (data) {
                        const fast_track_value_last_cl = jQuery(".fast_track_value_last");
                        jQuery(fast_track_value_last_cl[0]).html(jQuery.number(data, 2));                      
                    }
                });
            },
            5000
        );
    </script>
    JS;

    $str .= jquery_number();

    return $str;
}