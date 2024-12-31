<?php

namespace BPL\Ajax\Ajaxer\Token\Vault\Exchange_Buy\Amount;

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
	// token convert ajax amount validation
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
                $("#xch_buy").attr("disabled", true);
                $("#amount_xch_buy").bindWithDelay("keyup", function () {
                    if ($(this).val().length !== 0) {
                        var data = {
                            "action": "amount_buy",
                            "amount": $(this).val(),
                            "price": $("#rate_sell").html(),
                            "user_id": ' . $user_id .
						'};
                        
                        $.ajax({
                            type: "post",
                            dataType: "json",
                            url: "bpl/ajax/action.php",
                            data: data,
                            cache: false,
                            success: function (data) {
                                var subtotal_xch_buy = data["subtotal"] === undefined ? "0.00000" : data["subtotal"];
                                var charge_xch_buy = data["charge"] === undefined ? "0.00000" : data["charge"];
                                var total_xch_buy = data["total"] === undefined ? "0.00000" : data["total"];
                                var error_xch_buy = data["error"] === undefined ? "" : data["error"];

                                $("#subtotal_xch_buy").html($.number(subtotal_xch_buy, 5));
                                $("#charge_xch_buy").html($.number(charge_xch_buy, 5));
                                $("#total_xch_buy").html($.number(total_xch_buy, 5));

                                if (error_xch_buy !== "") {
                                    $("#error_xch_buy").html(error_xch_buy).fadeIn().delay(5000).fadeOut();
                                    $("#xch_buy").attr("disabled", true);
                                } else {
                                    $("#xch_buy").attr("disabled", false);
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