<?php

namespace BPL\Jumi\Profile_Update;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\HTML\HTMLHelper;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\time;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$username = session_get('username');
	$usertype = session_get('usertype');
	$admintype = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id = session_get('user_id');
	$uid = input_get('uid');
	$final = input_get('final');

	session_set('edit', false);

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	if ($uid !== '') {
		$user_id = $uid;
	}

	if ($final === '') {
		$str .= view_form($user_id, $admintype, $usertype);
	} else {
		process_form($user_id, $usertype, $admintype);
	}

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $user_id): string
{
	$str = '';

	switch ($usertype) {
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 * @param $user_id
 * @param $admintype
 * @param $usertype
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id, $admintype, $usertype): string
{
	$str = ajax_check_input();

	$str .= '<h1>Update Member Account</h1>';
	$str .= '<form name="regForm" method="post"
	      enctype="multipart/form-data"' . ' ' . '>';

	$str .= view_form_input_hidden($user_id);

	$str .= '<table class="category table table-striped table-bordered table-hover">';

	$str .= view_form_super_access($admintype, $usertype, $user_id);
	$str .= view_form_admin_access($user_id, $usertype);
	$str .= view_form_account_info($user_id);
	$str .= view_form_payment_method($user_id);
	//	$str .= view_form_beneficiary($user_id);
	$str .= view_form_change_password();

	$str .= '<td colspan="2"><div style="text-align: center">
	        <input type="submit" value="Submit" name="submit" class="uk-button uk-button-primary"></div>
	    </td>
	</tr>';

	$str .= '</table>' . HTMLHelper::_('form.token') . '</form>';

	$str .= script_payment_method();
	$str .= script_contact_info();
	$str .= script_beneficiary_info();

	$str .= formCss();

	return $str;
}

function formCss(): string
{
	return <<<CSS
		<style>
			/* Make the page transparent */
			body {
				background-color: transparent;
			}

			/* Card-like styling for the registration form */
			.registration-form {
				background-color: white; /* White background */
				padding: 10px; /* Add padding */
				border-radius: 8px; /* Rounded corners */
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
			}

			/* Custom styling for the input group */
			.input-group {
				width: 100%;
			}

			.input-group .form-control {
				border-radius: 4px 0 0 4px;
				height: 38px; /* Ensure input height matches button height */
			}

			.input-group-btn .btn {
				border-radius: 0 4px 4px 0;
				border-left: 0;
				height: 38px; /* Ensure button height matches input height */
			}

			.input-group-btn .btn-default {
				background-color: #f8f9fa;
				border-color: #ccc;
			}

			.input-group-btn .btn-default:hover {
				background-color: #e9ecef;
			}
		</style>
	CSS;
}

/**
 *
 * @return string
 *
 * @since version
 */
function ajax_check_input(): string
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
            }
            
            var ie = new Date().getTime();
            var uid = document.getElementById(inputID).value;
            var queryString = "?type=" + inputID + "&uid=" + uid + "&ie=" + ie;
            ajaxRequest.open("GET", "bpl/ajax/check_input.php" + queryString, true);
            ajaxRequest.send(null);
       }';

	$str .= '</script>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form_input_hidden($user_id): string
{
	$user = user($user_id);

	$str = '<input type="hidden" name="user_id" value="' . $user->id . '">';
	$str .= '<input type="hidden" name="username" value="' . $user->username . '">';
	$str .= '<input type="hidden" name="final" value="1">';

	return $str;
}

/**
 * @param $admintype
 * @param $usertype
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form_super_access($admintype, $usertype, $user_id): string
{
	$str = '';

	if ($admintype === 'Super' && $usertype === 'Admin') {
		$user = user($user_id);

		$settings_royalty = settings('royalty');

		$str .= '<tr>
            <td colspan="2"><h3 style="margin:0;">Membership Status</h3></td>
        </tr>';

		$str .= '<tr>
            <td><label for="usertype">Access Level:</label></td>
            <td>';
		$str .= '<select name="usertype" id="usertype">';
		$str .= '<option value="Member" ' . ($user->usertype === 'Member' ? 'selected' : '') . '>Member</option>';
		$str .= '<option value="manager" ' . ($user->usertype === 'manager' ? 'selected' : '') . '>manager</option>';
		$str .= '<option value="Admin" ' . ($user->usertype === 'Admin' ? 'selected' : '') . '>Admin</option>';
		$str .= '</select>';
		$str .= '</td>
        </tr>';

		$str .= '<tr>
            <td><label for="rank">' . settings('plans')->royalty_name . ':</label></td>
            <td>
                <input type="hidden" name="rank_old" value="' . $user->rank . '">
                <select name="rank" id="rank">';
		$str .= '<option value="affiliate" ' .
			($user->rank === 'affiliate' ? 'selected' : '') .
			'>' . $settings_royalty->affiliate_rank_name . '</option>';
		$str .= '<option value="supervisor" ' .
			($user->rank === 'supervisor' ? 'selected' : '') .
			'>' . $settings_royalty->supervisor_rank_name . '</option>';
		$str .= '<option value="manager" ' .
			($user->rank === 'manager' ? 'selected' : '') .
			'>' . $settings_royalty->manager_rank_name . '</option>';
		$str .= '<option value="director" ' .
			($user->rank === 'director' ? 'selected' : '') .
			'>' . $settings_royalty->director_rank_name . '</option>';
		$str .= '</select>
            </td>
        </tr>';
	}

	return $str;
}

/**
 * @param $usertype
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form_admin_access($user_id, $usertype): string
{
	$user = user($user_id);

	$str = '';

	if ($usertype === 'Admin') {
		$settings_entry = settings('entry');

		$str .= '<tr>
            <td><label for="account_type">Account Type: (' .
			$settings_entry->{$user->account_type . '_package_name'} . ')</label></td>
            <td>
                <input type="hidden" name="account_type_old" value="' . $user->account_type . '">
                <select name="account_type" id="account_type">';

		$str .= '<option value="basic" ' .
			($user->account_type === 'basic' ? 'selected' : '') . '>' .
			$settings_entry->basic_package_name . '</option>';
		$str .= '<option value="associate" ' .
			($user->account_type === 'associate' ? 'selected' : '') . '>' .
			$settings_entry->associate_package_name . '</option>';
		$str .= '<option value="regular" ' .
			($user->account_type === 'regular' ? 'selected' : '') . '>' .
			$settings_entry->regular_package_name . '</option>';
		$str .= '<option value="executive" ' .
			($user->account_type === 'executive' ? 'selected' : '') . '>' .
			$settings_entry->executive_package_name . '</option>';

		$str .= '</select>
	        	</td>
	        </tr>';
	} else {
		$str .= '<input type="hidden" name="rank" value="' . $user->rank . '">
        <input type="hidden" name="usertype" value="' . $user->usertype . '">
        <input type="hidden" name="account_type" value="' . $user->account_type . '">';
	}

	return $str;
}

/**
 * @param   array  $address
 *
 * @return string
 *
 * @since version
 */
function option_country_selected(array $address): string
{
	$db = db();

	return ((array_key_exists(4, $address) && $address[4] !== '') ? (

		$db->setQuery(
			'SELECT countryName ' .
			'FROM countries ' .
			'WHERE idCountry = ' . $db->quote($address[4])
		)->loadObject()->countryName

	) : 'Select a country');
}

/**
 *
 * @return string
 *
 * @since version
 */
function options_country(): string
{
	$countries = db()->setQuery(
		'SELECT * ' .
		'FROM countries ' .
		'ORDER BY countryName'
	)->loadObjectList();

	$str = '';

	foreach ($countries as $country) {
		$str .= '<option value="' . $country->idCountry . '">' . $country->countryName . '</option>';
	}

	return $str;
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form_account_info($user_id): string
{
	$user = user($user_id);

	$str = '<tr>
        <td colspan="2" style="font-color: #fff; background-color: #999; font-weight: bold"><h3 style="margin:0;">Account Info</h3></td>
    </tr>';

	$str .= '<tr>
        <td style="width: 200px">
            <a href="#"><label for="fullname">Full Name:</label></a>
        </td>
        <td>
            <input type="text" name="fullname" id="fullname"
                   value="' . (!empty($user->fullname) ? $user->fullname : '') . '" size="40"' . '>
        </td>
    </tr>';

	$str .= '<tr>
        <td><label for="username">Username:</label></td>
        <td><input type="text"
                   name="username"
                   id="username"
                   value="' . $user->username . '"
                   required="required"
                   size="40"
                   style="float:left"
                   readonly>';
	// $str .= '<a href="javascript:void(0)" onClick="checkInput(\'username\')"
	//                            class="uk-button uk-button-primary"
	//                            style="float:left">Check Availability</a>
	//         <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
	//              id="usernameDiv"></div>';
	$str .= '</td>
    </tr>';

	$str .= '<tr>
	    <td>Address:</td>
	    <td>';

	$address = explode('|', $user->address);

	// $str .= '<input type="text" name="address_1" size="40" placeholder="House No."
	//             value="' . (array_key_exists(0, $address) ? $address[0] : '') . '">';
	// $str .= '<input type="text" name="address_2" placeholder="Street / Road"
	//             value="' . (array_key_exists(1, $address) ? $address[1] : '') . '">';
	// $str .= '<input type="text" name="address_3" placeholder="City"
	//             value="' . (array_key_exists(2, $address) ? $address[2] : '') . '">';
	// $str .= '<input type="text" name="address_4"  placeholder="State / Region"
	//             value="' . (array_key_exists(3, $address) ? $address[3] : '') . '">';

	$str .= '<div style="display: flex; flex-direction: column; gap: 10px;">
            <input 
                type="text" 
                name="address_1" 
                size="40" 
                placeholder="No." 
                value="' . htmlspecialchars(array_key_exists(0, $address) ? $address[0] : '') . '" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
            >
            <input 
                type="text" 
                name="address_2" 
                placeholder="Street" 
                value="' . htmlspecialchars(array_key_exists(1, $address) ? $address[1] : '') . '" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
            >
            <input 
                type="text" 
                name="address_3" 
                placeholder="Municipality" 
                value="' . htmlspecialchars(array_key_exists(2, $address) ? $address[2] : '') . '" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
            >
            <input 
                type="text" 
                name="address_4" 
                placeholder="Province" 
                value="' . htmlspecialchars(array_key_exists(3, $address) ? $address[3] : '') . '" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
            >';
	$str .= '<label>
	            <select name="address_5" style="float: left">
	                <option value="' . (array_key_exists(4, $address) ? $address[4] : '') . '" ' .
		(array_key_exists(4, $address) && $address[4] !== '' ? 'selected' : 'disabled selected') . '>';
	$str .= option_country_selected($address);
	$str .= '</option>';
	$str .= options_country();
	$str .= '</select>
	</label></div>
	</td>
	<tr>';

	$str .= '<tr>
        <td><label for="email">Email Address:</label></td>
        <td><input type="text" name="email" id="email"
                   value="' . (!empty($user->email) ? $user->email : '') . '" size="40"></td>
    </tr>';

	//	$str .= '<tr>
//        <td><label for="contact">Contact Info:</label></td>
//        <td><input type="text" name="contact" id="contact" class="uk-width-1-1" size="40"
//                   value="' . (!empty($user->contact) ? $user->contact : '') . '">
//        </td>
//    </tr>';

	$str .= view_form_contact($user_id);

	return $str;
}

function view_form_contact($user_id): string
{
	$user = user($user_id);

	$contact = arr_contact_info($user);

	$str = '<tr>';
	$str .= '<td>Contact Info:</td>';
	$str .= '<td>';
	$str .= '<select name="contact" id="contact" style="float:left">';
	// $str .= '<option value="messenger">Messenger</option>';
	// $str .= '<option value="mobile">Mobile</option>';
	// $str .= '<option value="landline">Landline</option>';
	$str .= '<option value="whatsapp">Whatsapp</option>';
	$str .= '<option value="telegram">Telegram</option>';
	$str .= '</select>';

	// whatsapp
	$whatsappValue = htmlspecialchars($contact['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8');

	$str .= <<<HTML
		<div id="whatsapp_input">
			<label>
				<input type="text" class="uk-width-1-1" name="whatsapp_url" 
					placeholder="WhatsApp URL" value="$whatsappValue">
			</label>
		</div>
		HTML;

	// telegram
	$whatsappValue = htmlspecialchars($contact['telegram'] ?? '', ENT_QUOTES, 'UTF-8');

	$str .= <<<HTML
		<div id="telegram_input">
			<label>
				<input type="text" class="uk-width-1-1" name="telegram_url" 
					placeholder="Telegram URL" value="$whatsappValue">
			</label>
		</div>
		HTML;

	// messenger
	$str .= '<div id="messenger_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="messenger_url" placeholder="Messenger URL"
                value="' . ($contact['messenger'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	// mobile
	$str .= '<div id="mobile_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="mobile_number" placeholder="Mobile Number"
                value="' . ($contact['mobile'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	// landline
	$str .= '<div id="landline_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="landline_number" placeholder="Landline Number"
                value="' . ($contact['landline'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	$str .= '</td>';
	$str .= '<tr>';

	return $str;
}

function view_form_beneficiary($user_id): string
{
	$user = user($user_id);

	$beneficiary = arr_beneficiary_info($user);

	$str = '<tr>';
	$str .= '<td>Beneficiary:</td>';
	$str .= '<td>';
	$str .= '<select name="beneficiary" id="beneficiary" style="float:left">';
	//	$str .= '<option value="messenger">Messenger</option>';
	$str .= '<option value="beneficiary_name">Name</option>';
	$str .= '<option value="beneficiary_contact">Contact</option>';
	$str .= '</select>';

	// messenger
	$str .= '<div id="beneficiary_name_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="beneficiary_name_input" placeholder="Name"
                value="' . ($beneficiary['name'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	// mobile
	$str .= '<div id="beneficiary_contact_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="beneficiary_contact_input" placeholder="Contact Number"
                value="' . ($beneficiary['contact'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	$str .= '</td>';
	$str .= '<tr>';

	return $str;
}

function list_token(): array
{
	return [
		'USDT',
		'BTC',
		'ETH',
		'BNB',
		'LTC',
		'ADA',
		'USDC',
		'LINK',
		'DOGE',
		'DAI',
		'BUSD',
		'SHIB',
		'UNI',
		'MATIC',
		'DOT',
		'TRX',
		'SOL',
		'TWT',
		'XRP',
		'TON',
		//		'BTC3',
		//'BTCB',
		//		'BTCW',
//		'GOLD',
//		'PAC',
//		'P2P',
		'PESO',
		'B2P',
		'AET',
		'TPAY'
	];
}

function token_options(): string
{
	$tokens = list_token();

	$str = '';

	if ($tokens) {
		foreach ($tokens as $token) {
			$str .= '<option value="' . strtolower($token) . '"' .
				($token === 'B2P' ? ' selected' : '') .
				'>' . $token . '</option>';
			$str .= "\n\n";
		}
	}

	return $str;
}

function token_inputs($user): string
{
	$payment_method = arr_payment_method($user);

	$tokens = list_token();

	$str = '';

	if ($tokens) {
		foreach ($tokens as $token) {
			$str .= '<div id="' . strtolower($token) . '_input">';
			$str .= '<label>';
			$str .= '<input type="text" class="uk-width-1-1" name="' . strtolower($token) .
				'_address" placeholder="' . $token . ' Wallet Address"
                value="' . ($payment_method[strtolower($token)] ?? '') . '">';
			$str .= '</label>';
			$str .= '</div>';
			$str .= "\n\n";
		}
	}

	return $str;
}

function const_script_token(): string
{
	$tokens = list_token();

	$str = '';

	if ($tokens) {
		foreach ($tokens as $token) {
			$str .= 'const ' . strtolower($token) . ' = $("#' . strtolower($token) . '_input");';
			$str .= "\n\n";
		}
	}

	return $str;
}

function fill_payout_method($user)
{
	$payout_method = input_get('payout_method');

	$payout_method_user = arr_payment_method($user);

	$tokens = list_token();

	if ($payout_method === 'bank') {
		$bank_name = input_get('bank_name', '', 'RAW');
		$account_number = input_get('bank_account_number', '', 'RAW');

		if (!empty($bank_name) && !empty($account_number)) {
			$payout_method_user['bank'] = [$bank_name => $account_number];
		}
	} elseif ($payout_method === 'gcash') {
		$gcash_number = input_get('gcash_number', '', 'RAW');

		if (!empty($gcash_number)) {
			$payout_method_user['gcash'] = $gcash_number;
		}
	} elseif ($payout_method === 'maya') {
		$maya_number = input_get('maya_number', '', 'RAW');

		if (!empty($maya_number)) {
			$payout_method_user['maya'] = $maya_number;
		}
	} else if ($tokens) {
		foreach ($tokens as $token) {
			$strl_token = strtolower($token);

			if ($payout_method === $strl_token) {
				$payout_method_user[$strl_token] = input_get($strl_token . '_address', '', 'RAW');
			}
		}
	}

	return $payout_method_user;
}

function init_script_token_state($show = 'none'): string
{
	$tokens = list_token();

	$str = '';

	if ($tokens) {
		if ($show === 'none') {
			foreach ($tokens as $token) {
				$str .= strtolower($token) . '.hide();';
				$str .= "\n\n";
			}
		} else {
			if (in_array($show, $tokens)) {
				$str .= strtolower($show) . '.show();';
				$str .= "\n\n";

				unset($tokens[array_search($show, $tokens)]);

				foreach ($tokens as $token) {
					$str .= strtolower($token) . '.hide();';
					$str .= "\n\n";
				}
			}
		}
	}

	return $str;
}

function case_switch_script(): string
{
	$tokens = list_token();

	$str = '';

	if ($tokens) {
		foreach ($tokens as $token) {
			$str .= 'case "' . strtolower($token) . '":
                    bank.hide();
		            bank_name.hide();
		            gcash.hide();
                    
                    ' . init_script_token_state($token) . '
                    
                	break;';
			$str .= "\n\n";
		}
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form_payment_method($user_id): string
{
	$user = user($user_id);

	$payment_method = arr_payment_method($user); // array [method => address]

	$str = '<tr>
        <td>Payment Method:</td>
        <td>';

	$str .= '<select name="payout_method" id="payout_method" style="float:left">';
	//	$str .= '<option selected>Select Currency Method</option>';
	$str .= '<option value="bank">Bank</option>';
	$str .= '<option value="gcash">G-Cash</option>';
	$str .= '<option value="maya">MAYA</option>';
	$str .= token_options();
	$str .= '</select>';

	$bank_name = '';
	$account_num = '';

	if (!empty($payment_method['bank'])) {
		foreach ($payment_method['bank'] as $k => $v) {
			$bank_name = $k;
			$account_num = $v;
		}
	}

	$str .= '<input type="text" name="bank_name" placeholder="Bank Name" id="bank_name" value="' .
		$bank_name . '" style="float:left">';

	// bank
	$str .= '<div id="bank_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="bank_account_number" placeholder="Bank Account Number"
                value="' . $account_num . '">';
	$str .= '</label>';
	$str .= '</div>';

	// gcash
	$str .= '<div id="gcash_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="gcash_number" placeholder="G-Cash Number"
                value="' . ($payment_method['gcash'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	// gcash
	$str .= '<div id="maya_input">';
	$str .= '<label>';
	$str .= '<input type="text" class="uk-width-1-1" name="maya_number" placeholder="Maya Number"
                value="' . ($payment_method['maya'] ?? '') . '">';
	$str .= '</label>';
	$str .= '</div>';

	$str .= token_inputs($user);

	$str .= '</td>
    <tr>';

	return $str;
}

/**
 * Returns an associative array of payout methods with its corresponding wallet addresses
 *
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function arr_payment_method($user)
{
	$payout_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payout_method, true);
}

function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

function arr_beneficiary_info($user)
{
	$beneficiary_info = empty($user->beneficiary) ? '{}' : $user->beneficiary;

	return json_decode($beneficiary_info, true);
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_form_change_password(): string
{
	return '

	<!-- Bootstrap Icons CDN (add to head if not present) -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

	<tr>
	        <td colspan="2">Change your password here.</td>
	    </tr>
	    <tr>
		<tr>
	        <td><label for="password1">Password:</label></td>
	        <td>
				<div class="input-group">
					<input type="password" name="password1" id="password1" class="form-control" placeholder="Enter Password Here.." required>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default toggle-password" data-target="password1" style="height: 38px;">
							<i class="bi bi-eye"></i>
						</button>
					</span>
				</div>
			</td>
	    </tr>
	    <tr>
	        <td><label for="password2">Confirm Password:</label></td>
	        <td>
				<div class="input-group">
					<input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm Password Here.." required>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default toggle-password" data-target="password2" style="height: 38px;">
							<i class="bi bi-eye"></i>
						</button>
					</span>
				</div>
			</td>
	    </tr>
	<tr>

	<!-- JavaScript (place before closing </body> tag) -->
	<script>
		document.querySelectorAll(\'.toggle-password\').forEach(button => {
			button.addEventListener(\'click\', function() {
				const targetId = this.getAttribute(\'data-target\');
				const input = document.getElementById(targetId);
				const icon = this.querySelector(\'i\');
				
				if (input.type === \'password\') {
					input.type = \'text\';
					icon.classList.remove(\'bi-eye\');
					icon.classList.add(\'bi-eye-slash\');
				} else {
					input.type = \'password\';
					icon.classList.remove(\'bi-eye-slash\');
					icon.classList.add(\'bi-eye\');
				}
			});
		});
	</script>
	';
}

/**
 *
 * @return string
 *
 * @since version
 */
function script_payment_method(): string
{
	return '<script>
	    (function ($) {
	        togglePaymentMethod($);
	
	        $("#payout_method").change(function () {
	            togglePaymentMethod($);
	        });
	    })(jQuery);
	
	    function togglePaymentMethod($) {
	        const method = $("#payout_method");
	
	        const bank = $("#bank_input");
            const bank_name = $("#bank_name");           
            const gcash = $("#gcash_input");
            const maya = $("#maya_input");
            
            ' . const_script_token() . '
           
	        bank.hide();
            bank_name.hide();
            gcash.hide();
            maya.hide();
            
            ' . init_script_token_state() . '
            
            switch (method.val()) {
                case "bank":
                    bank.show();
		            bank_name.show();
		            gcash.hide();
		            maya.hide();
                    
                    ' . init_script_token_state() . '
                    
                	break;
                case "gcash":
                    bank.hide();
		            bank_name.hide();
		            gcash.show();
		            maya.hide();
                    
                    ' . init_script_token_state() . '
                    
                	break;
                case "maya":
                    bank.hide();
		            bank_name.hide();
		            gcash.hide();
		            maya.show();
                    
                    ' . init_script_token_state() . '
                    
                	break;
                	
                	' . case_switch_script() . '              
            }
            
	        return false;
	    }
	</script>';
}

function script_contact_info(): string
{
	return <<<HTML
		<script>
			(function ($) {
				toggleContactInfo($);
		
				$("#contact").change(function () {
					toggleContactInfo($);
				});
			})(jQuery);
		
			function toggleContactInfo($) {
				const contact = $("#contact");
		
				const whatsapp = $("#whatsapp_input");
				const telegram = $("#telegram_input");
				const messenger = $("#messenger_input");
				const mobile = $("#mobile_input");           
				const landline = $("#landline_input");           
			
				whatsapp.hide();
				telegram.hide();
				messenger.hide();
				mobile.hide();
				landline.hide();           
				
				switch (contact.val()) {
					case "whatsapp":
						whatsapp.show();
						telegram.hide();
						messenger.hide();
						mobile.hide();
						landline.hide();                    	
						
						break;
					case "telegram":
						whatsapp.hide();
						telegram.show();
						messenger.hide();
						mobile.hide();
						landline.hide();                    	
						
						break;
					case "messenger":
						whatsapp.hide();
						telegram.hide();
						messenger.show();
						mobile.hide();
						landline.hide();                    	
							
						break;
					case "mobile":
						whatsapp.hide();
						telegram.hide();
						messenger.hide();
						mobile.show();
						landline.hide();	
						
						break;
					case "landline":
						whatsapp.hide();
						telegram.hide();
						messenger.hide();
						mobile.hide();
						landline.show();	
						break;
				}
				
				return false;
			}
		</script>
	HTML;
}

function script_beneficiary_info(): string
{
	return '<script>
	    (function ($) {
	        toggleBeneficiaryInfo($);
	
	        $("#beneficiary").change(function () {
	            toggleBeneficiaryInfo($);
	        });
	    })(jQuery);
	
	    function toggleBeneficiaryInfo($) {
	        const beneficiary = $("#beneficiary");
	
	        const name = $("#beneficiary_name_input");
            const contact = $("#beneficiary_contact_input");         
           
	        name.hide();
            contact.hide();             
            
            switch (beneficiary.val()) {
                case "beneficiary_name":
                    name.show();
		            contact.hide();		                             	
                    
                	break;
                case "beneficiary_contact":
                    name.hide();
		            contact.show();		            	
                    
                	break;               
            }
            
	        return false;
	    }
	</script>';
}

/**
 * @param $username
 *
 * @return mixed|null
 *
 * @since version
 */
function user_username($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username)
	)->loadObject();
}

/**
 * @param $user_id
 * @param $usertype
 * @param $admintype
 *
 *
 * @since version
 */
function process_form($user_id, $usertype, $admintype)
{
	$user = user($user_id);

	$settings_entry = settings('entry');

	$db = db();

	$edit = session_get('edit', false);

	if ($admintype === 'Super') {
		$usertype_edit = input_get('usertype', '', 'RAW');
	} else {
		$usertype_edit = $user->usertype;
	}

	$account_type = substr(input_get('account_type', '', 'RAW'), 0, 60);

	$rank = input_get('rank', '', 'RAW');

	$rank_old = input_get('rank_old', '', 'RAW');

	$account_type_mod = $settings_entry->{$account_type . '_package_name'};

	$account_type_old = substr(input_get('account_type_old', '', 'RAW'), 0, 60);

	$account_type_old_mod = $settings_entry->{($account_type_old ?: $user->account_type) . '_package_name'};

	$fullname = substr(input_get('fullname', '', 'RAW'), 0, 60);
	$username = substr(input_get('username', '', 'RAW'), 0, 60);

	$address[0] = input_get('address_1', '', 'RAW');
	$address[1] = input_get('address_2', '', 'RAW');
	$address[2] = input_get('address_3', '', 'RAW');
	$address[3] = input_get('address_4', '', 'RAW');
	$address[4] = input_get('address_5', '', 'RAW');

	$address = implode('|', $address);

	$email = input_get('email', '', 'RAW');

	$contact_info_user = arr_contact_info($user);
	$contact = input_get('contact', '', 'RAW');

	$input_whatsapp = input_get('whatsapp_url', '', 'RAW');
	$input_telegram = input_get('telegram_url', '', 'RAW');
	$input_messenger = input_get('messenger_url', '', 'RAW');
	$input_mobile = input_get('mobile_number', '', 'RAW');
	$input_landline = input_get('landline_number', '', 'RAW');

	switch ($contact) {
		case 'whatsapp':
			if (!empty($input_whatsapp)) {
				$contact_info_user['whatsapp'] = $input_whatsapp;
			}

			break;
		case 'telegram':
			if (!empty($input_telegram)) {
				$contact_info_user['telegram'] = $input_telegram;
			}

			break;
		case 'messenger':
			if (!empty($input_messenger)) {
				$contact_info_user['messenger'] = $input_messenger;
			}

			break;
		case 'mobile':
			if (!empty($input_mobile)) {
				$contact_info_user['mobile'] = $input_mobile;
			}

			break;
		case 'landline':
			if (!empty($input_landline)) {
				$contact_info_user['landline'] = $input_landline;
			}

			break;
	}

	//	$beneficiary_info_user = arr_beneficiary_info($user);
//	$beneficiary           = input_get('beneficiary', '', 'RAW');
//
//	$beneficiary_name    = input_get('beneficiary_name_input', '', 'RAW');
//	$beneficiary_contact = input_get('beneficiary_contact_input', '', 'RAW');
//
//	switch ($beneficiary)
//	{
//		case 'beneficiary_name':
//			if (!empty($beneficiary_name))
//			{
//				$beneficiary_info_user['name'] = $beneficiary_name;
//			}
//
//			break;
//		case 'beneficiary_contact':
//			if (!empty($beneficiary_contact))
//			{
//				$beneficiary_info_user['contact'] = $beneficiary_contact;
//			}
//
//			break;
//	}

	$password1 = input_get('password1');
	$password2 = input_get('password2');

	$payout_method_user = fill_payout_method($user);

	$date = time();

	if ($edit && $admintype === 'Super') {
		$date = input_get('date', '', 'RAW');
	}

	$app = application();

	if ($password1 !== '' && $password2 !== '' && $password1 !== $password2) {
		$err = 'Your Passwords do not match.';

		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id, $err, 'error');
	}

	if ($user->username !== $username && user_username($username)->username !== '') {
		$err = 'Username already in use. Please use another username.';

		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id, $err, 'error');
	}

	try {
		$db->transactionStart();

		// update
		if (($admintype === 'Super' && $usertype === 'Admin') /*|| $usertype === 'manager'*/) {
			if ($password1 !== '' && ($password1 === $password2)) {
				$fields = [
					'`account_type` = ' . $db->quote($account_type),
					'`rank` = ' . $db->quote($rank),
					'`username` = ' . $db->quote($username),
					'`fullname` = ' . $db->quote($fullname),
					'`usertype` = ' . $db->quote($usertype_edit),
					'`email` = ' . $db->quote($email),
					'`date_registered` = ' . $db->quote($date),
					'`date_activated` = ' . $db->quote($date),
					'`password` = ' . $db->quote(md5($password1)),
					'`address` = ' . $db->quote($address)
				];

			} else {
				$fields = [
					'`account_type` = ' . $db->quote($account_type),
					'`rank` = ' . $db->quote($rank),
					'`username` = ' . $db->quote($username),
					'`fullname` = ' . $db->quote($fullname),
					'`usertype` = ' . $db->quote($usertype_edit),
					'`email` = ' . $db->quote($email),
					'`date_registered` = ' . $db->quote($date),
					'`date_activated` = ' . $db->quote($date),
					'`address` = ' . $db->quote($address)
				];
			}
		} else {
			if ($password1 !== '' && ($password1 === $password2)) {
				$fields = [
					'`username` = ' . $db->quote($username),
					'`fullname` = ' . $db->quote($fullname),
					'`usertype` = ' . $db->quote($usertype_edit),
					'`email` = ' . $db->quote($email),
					'`date_registered` = ' . $db->quote($date),
					'`date_activated` = ' . $db->quote($date),
					'`password` = ' . $db->quote(md5($password1)),
					'`address` = ' . $db->quote($address)
				];

			} else {
				$fields = [
					'`username` = ' . $db->quote($username),
					'`fullname` = ' . $db->quote($fullname),
					'`usertype` = ' . $db->quote($usertype_edit),
					'`email` = ' . $db->quote($email),
					'`date_registered` = ' . $db->quote($date),
					'`date_activated` = ' . $db->quote($date),
					'`address` = ' . $db->quote($address)
				];
			}
		}

		if ($contact_info_user) {
			$fields[] = '`contact` = ' . $db->quote(json_encode($contact_info_user));
		}

		if ($payout_method_user) {
			$fields[] = '`payment_method` = ' . $db->quote(json_encode($payout_method_user));
		}

		//		if ($beneficiary_info_user)
//		{
//			$fields[] = '`beneficiary` = ' . $db->quote(json_encode($beneficiary_info_user));
//		}

		/*print_r($fields);exit;*/

		update(
			'network_users',
			$fields,
			['id = ' . $db->quote($user_id)]
		);

		// activity
		if ($usertype === 'Admin' || $usertype === 'manager' || $admintype === 'Super') {
			$admin = user($user_id);

			$activity = '<b>Account Update: </b><a href="' . sef(44) . qs() . 'uid=' . $admin->id . '">' .
				$admin->username . '</a> updated member account: <a href="' . sef(44) . qs() . 'uid=' .
				$user->id . '">' . $user->username . '</a>.';

			if ($account_type !== '' && $account_type !== $account_type_old) {
				$activity .= '<br>Account Type changed from ' .
					$account_type_old_mod . ' to ' . $account_type_mod . '.';
			}

			if ($rank !== '' && $rank !== $rank_old/* && $admintype === 'Super'*/) {
				$activity .= '<br>Title changed from ' . $rank_old . ' to ' . $rank . '.';
			}
		} else {
			$activity = '<b>Account Update: </b> <a href="' . sef(44) . qs() .
				'uid=' . $user->id . '">' . $user->username . '</a> updated own account.';
		}

		insert(
			'network_activity',
			[
				'user_id',
				'sponsor_id',
				'upline_id',
				'activity',
				'activity_date'
			],
			[
				$db->quote($user_id),
				$db->quote($user_id),
				$db->quote($user_id),
				$db->quote($activity),
				$db->quote($date)
			]
		);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	$app->redirect(
		Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
		'Profile updated.',
		'notice'
	);
}