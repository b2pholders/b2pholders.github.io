<?php

namespace BPL\Ajax\Ajaxer\Token\Trade\Buy\Price;

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
	// token price buy trade validation
	$str = '<script>';
	$str .= '(function ($) {
            $.fn.bindWithDelay = function (type, data, fn, timeout, throttle) {
                if ($.isFunction(data)) {
                    throttle = timeout;
                    timeout = fn;
                    fn = data;
                    data = undefined;
                }

                // Allow delayed function to be removed with fn in unbind function
                fn.guid = fn.guid || ($.guid && $.guid++);

                // Bind each separately so that each element has its own delay
                return this.each(function () {
                    var wait = null;

                    function cb() {
                        var e = $.extend(true, {}, arguments[0]);
                        var ctx = this;
                        var throttler = function () {
                            wait = null;
                            fn.apply(ctx, [e]);
                        };

                        if (!throttle) {
                            clearTimeout(wait);
                            wait = null;
                        }

                        if (!wait) {
                            wait = setTimeout(throttler, timeout);
                        }
                    }

                    cb.guid = fn.guid;
                    $(this).bind(type, data, cb);
                });
            };

            $(document).ready(function () {
                $("#buy_trade").attr("disabled", true);
                $("#price_buy_trade").bindWithDelay("keyup", function () {
                    var data = {
                        "action": "price_buy_trade",
                        "amount": $("#amount_buy_trade").val(),
                        "price": $(this).val(),
                        "user_id": ' . $user_id .
					'};
                    //data = $(this).serialize() + "&" + $.param(data);
                    if ($(this).val().length !== 0) {
                        $.ajax({
                            type: "post",
                            dataType: "json",
                            url: "bpl/ajax/action.php",
                            data: data,
                            cache: false,
                            success: function (data) {
                                var subtotal_buy_trade = data["subtotal_buy_trade"] === undefined ?
                                    "0.00" : data["subtotal_buy_trade"];
                                var total_buy_trade = data["total_buy_trade"] === undefined ?
                                    "0.00" : data["total_buy_trade"];
                                var charge_buy_trade = data["charge_buy_trade"] === undefined ?
                                    "0.00" : data["charge_buy_trade"];
                                var error_buy_trade = data["error_buy_trade"] === undefined ?
                                    "" : data["error_buy_trade"];
                                var error_amount_buy_trade = data["error_amount_buy_trade"] === undefined ?
                                    "" : data["error_amount_buy_trade"];
                                var error_price_buy_trade = data["error_price_buy_trade"] === undefined ?
                                    "" : data["error_price_buy_trade"];
                                var debug = data["debug"] === undefined ? "" : data["debug"];

                                $("#subtotal_buy_trade").html($.number(subtotal_buy_trade, 2));
                                $("#total_buy_trade").html($.number(total_buy_trade, 2));
                                $("#charge_buy_trade").html($.number(charge_buy_trade, 2));

                                if (error_buy_trade !== ""
                                    ||
                                    error_amount_buy_trade !== ""
                                    ||
                                    error_price_buy_trade !== "") {
                                    $("#buy_trade").attr("disabled", true);
                                    
                                    if (error_buy_trade !== "") {
                                        $("#error_buy_trade").html(error_buy_trade).fadeIn().delay(5000).fadeOut();
                                    }

                                    if (error_amount_buy_trade !== "") {
                                        $("#error_amount_buy_trade").html(error_amount_buy_trade).fadeIn().delay(5000).fadeOut();
                                    }

                                    if (error_price_buy_trade !== "") {
                                        $("#error_price_buy_trade").html(error_price_buy_trade).fadeIn().delay(5000).fadeOut();
                                    }
                                } else {
                                    $("#buy_trade").attr("disabled", false);
                                }
                            }
                        });

                        return false;
                    }
                }, 700);
            });
        })(jQuery);';
	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}