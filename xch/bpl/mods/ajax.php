<?php

namespace BPL\Mods\Ajax;

/**
 *
 * @return string
 *
 * @since version
 */
function check_input(): string
{
    $str = '<script>';
    $str .= js_fade_up();
    $str .= js_check_input();
    $str .= '</script>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function check_input2(): string
{
    $str = '<script>';
    $str .= js_fade_up();
    $str .= js_check_input2();
    $str .= '</script>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function check_input3(): string
{
    $str = '<script>';
    $str .= js_fade_up();
    $str .= js_check_input3();
    $str .= '</script>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function check_input5(): string
{
    $str = '<script>';
    $str .= js_fade_up();
    $str .= js_check_input5();
    $str .= '</script>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
//function check_input6(): string
//{
//	$str = '<script>';
//	$str .= js_fade_up();
//	$str .= js_check_input6();
//	$str .= '</script>';
//
//	return $str;
//}

/**
 *
 * @return string
 *
 * @since version
 */
function check_position(): string
{
    $str = '<script>';
    $str .= js_fade_up();
    $str .= js_check_position();
    $str .= '</script>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function js_fade_up(): string
{
    return 'function fadeUp(obj) {
            if (typeof(obj) === "string") {
                obj = document.getElementById(obj);
            }
            
            let t, opacity_counter = 0;
           
            const doFade = function () {
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
}

/**
 *
 * @return string
 *
 * @since version
 */
function js_check_input(): string
{
    return 'function checkInput(inputID) {
            let ajaxRequest;
            const divID = inputID + "Div";

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
                    const ajaxDisplay = document.getElementById(divID);
                    
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    
                    fadeUp(divID);
                }
            };

            const ie = new Date().getTime();
            const uid = document.getElementById(inputID).value;
            const queryString = "?type=" + inputID + "&uid=" + uid + "&ie=" + ie;
            
            ajaxRequest.open("GET", "bpl/ajax/check_input.php" + queryString, true);
            ajaxRequest.send(null);
        }';
}

/**
 *
 * @return string
 *
 * @since version
 */
function js_check_input2(): string
{
    return 'function checkInput(inputID) {
            let ajaxRequest;
            
            const divID = inputID + "Div";

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
                    const ajaxDisplay = document.getElementById(divID);
                    
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    
                    fadeUp(divID);
                }
            };

            const ie = new Date().getTime();
            const uid = document.getElementById(inputID).value;
            const queryString = "?type=" + inputID + "&uid=" + uid + "&ie=" + ie;
            
            ajaxRequest.open("GET", "bpl/ajax/check_input2.php" + queryString, true);
            ajaxRequest.send(null);
        }';
}

/**
 *
 * @return string
 *
 * @since version
 */
function js_check_input3(): string
{
    return 'function checkInput(inputID) {
        let ajaxRequest;
        
        const divID = inputID + "Div";

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
                const ajaxDisplay = document.getElementById(divID);
                
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                
                fadeUp(divID);
            }
        };

        const ie = new Date().getTime();
        const uid = document.getElementById(inputID).value;
        const queryString = "?type=" + inputID + "&uid=" + uid + "&ie=" + ie;
        
        ajaxRequest.open("GET", "bpl/ajax/check_input3.php" + queryString, true);
        ajaxRequest.send(null);
    }';
}

/**
 *
 * @return string
 *
 * @since version
 */
function js_check_input5(): string
{
    return 'function checkInput(inputID) {
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
            ajaxRequest.open("GET", "bpl/ajax/check_input5.php" + queryString, true);
            ajaxRequest.send(null);
        }';
}

/**
 *
 * @return string
 *
 * @since version
 */
//function js_check_input6(): string
//{
//	return 'function checkInput(inputUserId, inputID) {
//            let ajaxRequest;
//
//            const divID = inputID + "Div";
//
//            try {
//                ajaxRequest = new XMLHttpRequest();
//            } catch (e) {
//                // Internet Explorer Browsers
//                try {
//                    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
//                } catch (e) {
//                    try {
//                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
//                    } catch (e) {
//                        // Something went wrong
//                        alert("Your browser broke!");
//
//                        return false;
//                    }
//                }
//            }
//
//            ajaxRequest.onreadystatechange = function () {
//                if (ajaxRequest.readyState === 4) {
//                    const ajaxDisplay = document.getElementById(divID);
//
//                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
//
//                    fadeUp(divID);
//                }
//            };
//
//            const ie = new Date().getTime();
//            const uid = document.getElementById(inputID).value;
//            const user_id = document.getElementById(inputUserId).value;
//            const queryString = "?type=" + inputID + "&user_id=" + user_id + "&uid=" + uid + "&ie=" + ie;
//
//            ajaxRequest.open("GET", "bpl/ajax/check_input6.php" + queryString, true);
//            ajaxRequest.send(null);
//        }';
//}

/**
 *
 * @return string
 *
 * @since version
 */
function js_check_position(): string
{
    return 'function checkPosition(inputUpline, inputID) {
            let ajaxRequest;
            
            const divID = inputID + "Div";

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
                    const ajaxDisplay = document.getElementById(divID);
                    
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    
                    fadeUp(divID);
                }
            };

            const ie = new Date().getTime();
            const uid = document.getElementById(inputUpline).value;
            const tmp = document.getElementById(inputID);
            const position = tmp.options[tmp.selectedIndex].value;

            const queryString = "?position=" + position + "&uid=" + uid + "&ie=" + ie;
            
            ajaxRequest.open("GET", "bpl/ajax/check_position.php" + queryString, true);
            ajaxRequest.send(null);
        }';
}