<?php

namespace BPL\Ajax\Ajaxer\Token\P2P_Trade\Table;

function p2p_requests_pending($user_id, $limit_from, $limit_to): string
{
	$str = '<script>';
	$str .= 'setInterval(
            function () {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_trade_p2p_requests_pending",
                        user_id: ' . $user_id . ',
                        limit_from: ' . $limit_from . ',
                        limit_to: ' . $limit_to . '
                    },
                    success: function (data) {
                        jQuery("#p2p_buyer_requests_pending").html(data);
                    }
                });
            },
            33000
        );';
	$str .= '</script>';

	return $str;
}