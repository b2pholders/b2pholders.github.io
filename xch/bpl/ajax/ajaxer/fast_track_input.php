<?php

namespace BPL\Ajax\Ajaxer\Fast_Track_Input;

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
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
                $("#fast_track").attr("disabled", true);
                $("#fast_track_input").bindWithDelay("keyup", function () {        
                    var value = $.trim($(this).val());
                    if (value.length !== 0) {
                        var data = {
                            "action": "fast_track_input",
                            "input": value,
                            "user_id": ' . $user_id . '}
                        //data = $(this).serialize() + "&" + $.param(data);
                        $.ajax({
                            type: "post",
                            url: "bpl/ajax/action.php",
                            dataType: "json",
                            data: data,
                            success: function (response) {
                                //alert(response["input"]);
                                var error_fast_track = response["error_fast_track"] === undefined ? "" : response["error_fast_track"];
                                var error_fast_track_cl = $(".error_fast_track");

                                if (error_fast_track !== "") {
                                    $("#fast_track").attr("disabled", true);
                                    $(error_fast_track_cl[0]).html(error_fast_track).fadeIn().delay(5000).fadeOut();
                                } else {
                                    $("#fast_track").attr("disabled", false);
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