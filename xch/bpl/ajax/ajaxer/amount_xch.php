<?php

namespace BPL\Ajax\Ajaxer\Token\Vault\Exchange\Amount;

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
                $("#xch").attr("disabled", true);
                $("#amount_xch").bindWithDelay("keyup", function () {
                    if ($(this).val().length !== 0) {
                        var data = {
                            "action": "amount_sell",
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
                                var subtotal_xch = data["subtotal"] === undefined ? "0.00000" : data["subtotal"];
                                var charge_xch = data["charge"] === undefined ? "0.00000" : data["charge"];
                                var total_xch = data["total"] === undefined ? "0.00000" : data["total"];
                                var error_xch = data["error"] === undefined ? "" : data["error"];

                                $("#subtotal_xch").html($.number(subtotal_xch, 5));
                                $("#charge_xch").html($.number(charge_xch, 5));
                                $("#total_xch").html($.number(total_xch, 5));

                                if (error_xch !== "") {
                                    $("#error_xch").html(error_xch).fadeIn().delay(5000).fadeOut();
                                    $("#xch").attr("disabled", true);
                                } else {
                                    $("#xch").attr("disabled", false);
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