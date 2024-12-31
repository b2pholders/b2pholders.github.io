<?php

namespace BPL\Ajax\Ajaxer\Table_Top_Up;

require_once 'bpl/ajax/ajaxer/jquery_number.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;

function main($user_id): string
{
	$str = '<script>';
	// displays top up entry
	$str .= 'var table_top_up = setInterval(
            function () {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_top_up",
                        user_id: ' . $user_id . ',
                        page: 0/*,
                        top_up_row_count_total: jQuery("#top_up_row_count_total").val(),
                        top_up_user_last_day: jQuery("#top_up_user_last_day").val()*/
                    },
                    ifModified: true,
                    success: function (data) {
                        /*if (data !== undefined)
                        {*/
                            jQuery("#table_top_up").html(data);
                        /*}*/                        
                    }
                });
            },
            5000
        );';

	// pagination for top up
	$str .= 'function paginate_top_up(page) {
            if (page > 0) {
                clearInterval(table_top_up);
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_top_up",
                        user_id: ' . $user_id . ',
                        page: page/*,
                        top_up_row_count_total: jQuery("#top_up_row_count_total").val(),
                        top_up_user_last_day: jQuery("#top_up_user_last_day").val()*/
                    },
                    success: function (data) {
                        /*if (data !== undefined)
                        {*/
                            jQuery("#table_top_up").html(data);
                        /*}*/
                    }
                });
            } else {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_top_up",
                        user_id: ' . $user_id . ',
                        page: page/*,
                        top_up_row_count_total: jQuery("#top_up_row_count_total").val(),
                        top_up_user_last_day: jQuery("#top_up_user_last_day").val()*/
                    },
                    success: function (data) {
                        jQuery("#table_top_up").html(data);
                        table_top_up;                      
                    }
                });
            }
        };';

	// displays top up profit
	$str .= 'setInterval(
            function () {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "profit_top_up",
                        user_id: ' . $user_id .
					'},
                    success: function (data) {
                        var top_up_value_last_cl = jQuery(".top_up_value_last");
                        jQuery(top_up_value_last_cl[0]).html(jQuery.number(data, 2));                      
                    }
                });
            },
            5000
        );';
	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}