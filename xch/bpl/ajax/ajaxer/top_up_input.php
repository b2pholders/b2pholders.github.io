<?php

namespace BPL\Ajax\Ajaxer\Top_Up_Input;

function main($user_id): string
{
	// input ajax validation for top up
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
                $("#top_up").attr("disabled", true);
                $("#top_up_input").bindWithDelay("keyup", function () {        
                    var value = $.trim($(this).val());
                    if (value.length !== 0) {
                        var data = {
                            "action": "top_up_input",
                            "input": value,
                            "user_id": ' . $user_id .
						'}
                        //data = $(this).serialize() + "&" + $.param(data);
                        $.ajax({
                            type: "post",
                            url: "bpl/ajax/action.php",
                            dataType: "json",
                            data: data,
                            success: function (response) {
                                //alert(response["input"]);
                                var error_top_up = response["error_top_up"] === undefined ? "" : response["error_top_up"];
                                var error_top_up_cl = $(".error_top_up");

                                if (error_top_up !== "") {
                                    $("#top_up").attr("disabled", true);
                                    $(error_top_up_cl[0]).html(error_top_up).fadeIn().delay(5000).fadeOut();
                                } else {
                                    $("#top_up").attr("disabled", false);
                                }
                            }
                        });

                        return false;
                    }
                }, 1000);
            });
        })(jQuery);';
        $str .= '</script>';

	return $str;
}