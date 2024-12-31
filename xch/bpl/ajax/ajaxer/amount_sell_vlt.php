<?php

namespace BPL\Ajax\Ajaxer\Token\Vault\Sell\Amount;

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
	// token sell validation
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
                $("#sell_vlt").attr("disabled", true);
                $("#amount_sell_vlt").bindWithDelay("keyup", function () {
                    if ($(this).val().length !== 0) {
                        var data = {
                            "action": "amount_sell",
                            "amount": $(this).val(),
                            "price": $("#rate_sell").html(),
                            "user_id": ' . $user_id .
						'};
                        data = $(this).serialize() + "&" + $.param(data);
                        if ($(this).val().length !== 0) {
                            $.ajax({
                                type: "post",
                                dataType: "json",
                                url: "bpl/ajax/action.php",
                                data: data,
                                cache: false,
                                success: function (data) {
                                    var subtotal_sell = data["subtotal"] === undefined ?
                                        "0.00" : data["subtotal"];
                                    var charge_sell = data["charge"] === undefined ?
                                        "0.00" : data["charge"];
                                    var total_sell = data["total"] === undefined ?
                                        "0.00" : data["total"];
                                    var error_sell = data["error"] === undefined ?
                                        "" : data["error"];

                                    $("#subtotal_sell_vlt").html($.number(subtotal_sell, 2));
                                    $("#charge_sell_vlt").html($.number(charge_sell, 2));
                                    $("#total_sell_vlt").html($.number(total_sell, 2));

                                    if (error_sell !== "") {
                                        $("#sell_vlt").prop("disabled", true);
                                        $("#error_sell_vlt").html(error_sell).fadeIn().delay(5000).fadeOut();
                                    } else {
                                        $("#sell_vlt").prop("disabled", false);
                                    }
                                }
                            });

                            return false;
                        }
                    }
                }, 700);
            });
        })(jQuery);';
	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}