<?php

namespace BPL\Ajax\Ajaxer\Token\Trade\Sell\Price;

require_once 'bpl/ajax/ajaxer/jquery_number.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;

function main($user_id): string
{
	// token price sell trade ajax validation
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
                $("#sell_trade").attr("disabled", true);
                $("#price_sell_trade").bindWithDelay("keyup", function () {
                    var data = {
                        "action": "amount_sell_trade",
                        "amount": $("#amount_sell_trade").val(),
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
                                var subtotal_sell_trade = data["subtotal_sell_trade"] === undefined ?
                                    "0.00" : data["subtotal_sell_trade"];
                                var total_sell_trade = data["total_sell_trade"] === undefined ?
                                    "0.00" : data["total_sell_trade"];
                                var charge_sell_trade = data["charge_sell_trade"] === undefined ?
                                    "0.00" : data["charge_sell_trade"];
                                var error_sell_trade = data["error_sell_trade"] === undefined ?
                                    "" : data["error_sell_trade"];
                                var error_amount_sell_trade = data["error_amount_sell_trade"] === undefined ?
                                    "" : data["error_amount_sell_trade"];
                                var error_price_sell_trade = data["error_price_sell_trade"] === undefined ?
                                    "" : data["error_price_sell_trade"];
                                var debug = data["debug"] === undefined ? "" : data["debug"];

                                $("#subtotal_sell_trade").html($.number(subtotal_sell_trade, 2));
                                $("#total_sell_trade").html($.number(total_sell_trade, 2));
                                $("#charge_sell_trade").html($.number(charge_sell_trade, 2));

                                if (error_sell_trade !== ""
                                    ||
                                    error_amount_sell_trade !== ""
                                    ||
                                    error_price_sell_trade !== "") {
                                    $("#sell_trade").attr("disabled", true);

                                    if (error_sell_trade !== "") {
                                        $("#error_sell_trade").html(error_sell_trade).fadeIn().delay(5000).fadeOut();
                                    }

                                    if (error_amount_sell_trade !== "") {
                                        $("#error_amount_sell_trade").html(error_amount_sell_trade).fadeIn().delay(5000).fadeOut();
                                    }

                                    if (error_price_sell_trade !== "") {
                                        $("#error_price_sell_trade").html(error_price_sell_trade).fadeIn().delay(5000).fadeOut();
                                    }
                                } else {
                                    $("#sell_trade").attr("disabled", false);
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