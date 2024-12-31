<?php

namespace BPL\Ajax\Ajaxer\Token\Trade\Table;

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

	$str .= 'let table_trade_complete = ' . table_trade_complete($user_id);
	$str .= 'let table_trade_buy = ' . table_trade_buy($user_id);
	$str .= 'let table_trade_sell = ' . table_trade_sell($user_id);

	$str .= paginate_trade_complete($user_id);
	$str .= paginate_trade_buy($user_id);
	$str .= paginate_trade_sell($user_id);

	$str .= delete_buy_trade($user_id);
	$str .= delete_sell_trade($user_id);

	$str .= '</script>';

	return $str;
}

/**
 * @param $action
 * @param $user_id
 * @param $start_row
 * @param $target
 *
 * @return string
 *
 * @since version
 */
function ajax($action, $user_id, $start_row, $target): string
{
	return 'jQuery.ajax({
	        type: "post",
	        url: "bpl/ajax/action.php",
	        data: {
	            action: "' . $action . '",	 
	            user_id: "' . $user_id . '",           
	            start_row: ' . $start_row . '
	        },
	        success: function (data) {
	            jQuery("' . $target . '").html(data);
	        }
	    });';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function table_trade_complete($user_id): string
{
	return 'setInterval(
            function () {' .
		ajax('table_trade_complete', $user_id, 0, '#table_trade_complete') . '},
            5000
        );';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function table_trade_buy($user_id): string
{
	return 'setInterval(
            function () {' .
		ajax('table_trade_buy', $user_id, 0, '#table_trade_buy') . '},
            5000
        );';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function table_trade_sell($user_id): string
{
	return 'setInterval(
            function () {' .
		ajax('table_trade_sell', $user_id, 0, '#table_trade_sell') . '},
            5000
        );';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function paginate_trade_complete($user_id): string
{
	$ajax = ajax('table_trade_complete', $user_id, 'start_row', '#table_trade_complete');

	return 'function paginate_complete(start_row) {
            if (start_row > 0) {
                clearInterval(table_trade_complete);' . $ajax . '                
            } else {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_trade_complete",
                        user_id: ' . $user_id . ',
                        start_row: start_row
                    },
                    success: function (data) {
                        jQuery("#table_trade_complete").html(data);
                        table_trade_complete = setInterval(function () {' . $ajax . '}, 5000);
                    }
                });
            }
        }';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function paginate_trade_buy($user_id): string
{
	$ajax = ajax('table_trade_buy', $user_id, 'start_row', '#table_trade_buy');

	return 'function paginate_buy(start_row) {
            if (start_row > 0) {
                clearInterval(table_trade_buy);' . $ajax . '                
            } else {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_trade_buy",
                        user_id: ' . $user_id . ',
                        start_row: start_row
                    },
                    success: function (data) {
                        jQuery("#table_trade_buy").html(data);
                        table_trade_buy = setInterval(function () {' . $ajax . '}, 5000);
                    }
                });
            }
        }';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function paginate_trade_sell($user_id): string
{
	$ajax = ajax('table_trade_sell', $user_id, 'start_row', '#table_trade_sell');

	return 'function paginate_sell(start_row) {
            if (start_row > 0) {
                clearInterval(table_trade_sell);' . $ajax . '                
            } else {
                jQuery.ajax({
                    type: "post",
                    url: "bpl/ajax/action.php",
                    data: {
                        action: "table_trade_sell",
                        user_id: ' . $user_id . ',
                        start_row: start_row
                    },
                    success: function (data) {
                        jQuery("#table_trade_sell").html(data);
                        table_trade_sell = setInterval(function () {' . $ajax . '}, 5000);
                    }
                });
            }
        }';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function delete_buy_trade($user_id): string
{
	return 'function delete_buy(trade_id) {
        let data_cancel_trade_buy = {
            "action": "cancel_trade_buy",
            "trade_id": trade_id,
            "user_id": ' . $user_id .
		'};
				
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: "bpl/ajax/action.php",
            data: data_cancel_trade_buy
        });
    }';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function delete_sell_trade($user_id): string
{
	return 'function delete_sell(trade_id) {
        let data_cancel_trade_sell = {
            "action": "cancel_trade_sell",
            "trade_id": trade_id,
            "user_id": ' . $user_id .
		'};
					
		jQuery.ajax({
            type: "post",
            dataType: "json",
            url: "bpl/ajax/action.php",
            data: data_cancel_trade_sell
        });
    }';
}