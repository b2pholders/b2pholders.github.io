<?php

namespace BPL\Ajax\Ajaxer\Code_Validate;

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

	$str .= '(function ($) {
        $("#code_generate").attr("disabled", true);

        $("#amount").change(function () {
            let type_select = "";
            let count = "";

            $("#type").find("option:selected").each(function () {
                type_select += $(this).val();
            });

            $("#amount").find("option:selected").each(function () {
                count += $(this).val();
            });

            const data = {
                "action": "code_validate",
                "user_id": ' . $user_id . ',
                "type": type_select,
                "count": count
            };

            $.ajax({
                type: "post",
                dataType: "json",
                url: "bpl/ajax/action.php",
                data: data,
                cache: false,
                success: function (data) {
                    const debug = data["debug"] === undefined ? "" : data["debug"];
                    const error_number_codes = data["error_number_codes"] === undefined ?
                        "" : data["error_number_codes"];
                    const error_code_type = data["error_code_type"] === undefined ?
                        "" : data["error_code_type"];
                    const none = data["none"] === undefined ? "" : data["none"];

                    //alert(error_validate_code.length);

                    if (error_number_codes === "" && error_code_type === "") {
                        //$("#note_type_package").text("Hey you, boy!");
                        $("#code_generate").attr("disabled", false);
                    } else {
                        if (error_number_codes !== "") {
                            $("#error_number_codes").html(error_number_codes).fadeIn().delay(5000).fadeOut();                       
                        }
                        
                        if (error_code_type !== "") {
                            $("#error_code_type").html(error_code_type).fadeIn().delay(5000).fadeOut();                       
                        }
                        
                        $("#code_generate").attr("disabled", true);
                    }

                    //alert(debug);
                    //$("#debug_type_package").html(debug);
                }
            });

            return false;
        });

        $("#type").change(function () {
            let type_select = "";
            let count = "";

            $("#type").find("option:selected").each(function () {
                type_select += $(this).val();
            });

            $("#amount").find("option:selected").each(function () {
                count += $(this).val();
            });
            
            const data = {
                "action": "code_validate",
                "user_id": ' . $user_id . ',
                "type": type_select,
                "count": count
            };
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: "bpl/ajax/action.php",
                data: data,
                cache: false,
                success: function (data) {
                    const debug = data["debug"] === undefined ? "" : data["debug"];
                    const error_number_codes = data["error_number_codes"] === undefined ?
                        "" : data["error_number_codes"];
                    const error_code_type = data["error_code_type"] === undefined ?
                        "" : data["error_code_type"];
                    const none = data["none"] === undefined ? "" : data["none"];

                    //alert(error_validate_code.length);

                    if (error_number_codes === "" && error_code_type === "") {
                        //$("#note_type_package").text("Hey you, boy!");
                        $("#code_generate").attr("disabled", false);
                    } else {
                        if (error_number_codes !== "") {
                            $("#error_number_codes").html(error_number_codes).fadeIn().delay(5000).fadeOut();                       
                        }
                        
                        if (error_code_type !== "") {
                            $("#error_code_type").html(error_code_type).fadeIn().delay(5000).fadeOut();                       
                        }
                        
                        $("#code_generate").attr("disabled", true);
                    }

                    //alert(debug);
                    //$("#debug_type_package").html(debug);
                }
            });
            
            return false;
        });
    })(jQuery);';

	$str .= '</script>';

	return $str;
}