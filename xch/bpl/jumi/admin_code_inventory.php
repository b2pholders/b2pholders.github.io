<?php

namespace BPL\Jumi\Admin_Code_Inventory;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;

use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\session_get;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate();

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	$str .= ajax_check_input4();

	$str .= view_form();

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_form(): string
{
	return '<h1>Check Member Code Inventory</h1>
		<p>Enter Member\'s Username.</p>
		    <table class="category table table-striped table-bordered table-hover">
		        <tr>
		            <td><label for="username">Username: *</label></td>
		            <td><input type="text"
		                       name="username"
		                       id="username"
		                       size="40"
		                       required="required"
		                       style="float:left">
		                <a onClick="checkInput(\'username\')"
		                   class="uk-button uk-button-primary"
		                   style="float:left">Verify Username</a>
		                <div style="width:200px;
		                    height:20px;
		                    font-weight:bold;
		                    float:left;
		                    padding:7px 0 0 10px;" id="usernameDiv"></div>
		            </td>
		        </tr>
		    </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function ajax_check_input4(): string
{
	$str = '<script>';
	$str .= 'function fadeUp(obj) {
        if (typeof(obj) === "string") {
            obj = document.getElementById(obj);
        }
        var t;
        var opacity_counter = 0;
        var doFade = function () {
            obj.style.opacity = (opacity_counter / 100);

            /* for IE */
            obj.style.filter = "alpha(opacity=" + opacity_counter + ")";
            opacity_counter = opacity_counter + 10;
            if (opacity_counter >= 100) {
                clearTimeout(t);
                obj.style.opacity = "1";
                obj.style.filter = "alpha(opacity=100)";
            } else {
                t = setTimeout(doFade, 50);
            }
        };
        doFade();
    }';
	$str .= 'function checkInput(inputID) {
        var ajaxRequest;
        var divID = inputID + "Div";

        try {
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {

            // Internet Explorer Browsers
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {

                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }

        ajaxRequest.onreadystatechange = function () {
            if (ajaxRequest.readyState === 4) {
                var ajaxDisplay = document.getElementById(divID);
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                fadeUp(divID);
            }
        };

        var ie = new Date().getTime();
        var uid = document.getElementById(inputID).value;
        var queryString = "?type=" + inputID + "&uid=" + uid + "&ie=" + ie;
        ajaxRequest.open("GET", "bpl/ajax/check_input4.php" + queryString, true);
        ajaxRequest.send(null);
    }';

	$str .= '</script>';

	return $str;
}