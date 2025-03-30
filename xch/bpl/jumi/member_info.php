<?php

namespace BPL\Jumi\Member_Info;

require_once 'bpl/mods/root_url_upline.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Root_Url_Upline\main as root_url;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');
	$usertype = session_get('usertype');

	$uid = input_get('uid');

	page_validate();

	$str = menu();

	if ($uid !== '') {
		$user_id = $uid;
	}

	$str .= view_table($user_id, $usertype);
	$str .= scripts();

	echo $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function directs($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE sponsor_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

function user_binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE b.user_id = ' . $db->quote($user_id)
	)->loadObject();
}

function sponsor_url($sponsor_id)
{
	$user_id = session_get('user_id');
	$uid = input_get('uid');

	$user = user($user_id);

	$usertype = $user->usertype;

	$str = 'javascript:void(0)';

	if (!empty($user_id) && (empty($uid) || $uid === $user_id || $usertype === 'Admin')) {
		$str = sef(44) . qs() . 'uid=' . $sponsor_id;
	}

	return $str;
}

function view_table($user_id, $usertype): string
{
	$settings_plans = settings('plans');
	$user = user($user_id);
	$currency = settings('ancillaries')->currency;

	$str = '<div class="container table-responsive">';
	$str .= '<h1 class="text-center">' . /*htmlspecialchars($user->username)*/ 'Profile' . '</h1>';

	$str .= '<div class="card mb-3">';
	$str .= '<div class="card-header"><strong>Account Information</strong></div>';
	$str .= '<div class="card-body">';

	// Improved Table Styling
	$str .= '<style>
        .custom-table {
            background-color: #ffffff; /* White background for the table */
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .custom-table th {
            background-color: #f5f5f5; /* Light grey background for headers */
            color: #333; /* Dark text color for contrast */
            padding: 12px;
            text-align: left;
        }
        .custom-table td {
            background-color: #ffffff; /* White background for table cells */
            color: #333; /* Dark text color for contrast */
            padding: 12px;
            border-bottom: 1px solid #ddd; /* Light grey border for rows */
        }
        .custom-table tr:hover {
            background-color: #f9f9f9; /* Light grey background on row hover */
        }
    </style>';

	$str .= '<table class="custom-table">';
	$str .= '<tr><th>Detail</th><th>Information</th></tr>';
	$str .= '<tr><td>Username:</td><td>' . (!empty($user->username) ? htmlspecialchars($user->username) : '-') . '</td></tr>';
	$str .= '<tr><td>Full Name:</td><td>' . (!empty($user->fullname) ? htmlspecialchars($user->fullname) : '-') . '</td></tr>';
	//	$str .= '<tr><td>Account Type:</td><td><span class="badge badge-info">' . htmlspecialchars(settings('entry')->{$user->account_type . '_package_name'}) . '</span></td></tr>';
//	$str .= '<tr><td>Joined:</td><td>' . date('M j, Y - g:i A', $user->date_registered) . '</td></tr>';
	$str .= '<tr><td>USDT Wallet:</td><td><span class="badge badge-success">' . number_format($user->payout_transfer, 8) . ' ' . htmlspecialchars($currency) . '</span></td></tr>';
	$str .= '</table>';

	$str .= '</div></div>';

	if ($settings_plans->direct_referral) {
		$str .= '<div class="card mb-3">';
		$str .= '<div class="card-header d-flex justify-content-between align-items-center">';
		$str .= '<strong>Referral Information</strong>';
		$str .= '</div>'; // End of card-header
		$str .= '<div class="card-body">';

		// Create referral link input with a button to copy it
		$link = 'http://' . $_SERVER['SERVER_NAME'] . root_url() . '/' . htmlspecialchars($user->username);
		$str .= '<div class="uk-width-1-1 uk-form">
            <fieldset>                                                  
                <div class="uk-form-row">
                    <input type="text" value="' . $link . '" id="myLink" readonly
                    	class="uk-form-width-medium custom-input-width">
                    <button class="btn btn-primary" onClick="copyLink()" type="reset">Copy</button>
                </div>                            
            </fieldset>
        </div>';

		$str .= '<style>
			.custom-input-width {
			    width: 480px; /* Adjust as needed */
			}
		</style>';

		// Add table with referral details
		$str .= '<div class="table-responsive">'; // Add a wrapper for responsiveness
		$str .= '<table class="custom-table">';
		$str .= '<tr><td>Sponsored Members:</td><td>' . count(directs($user_id)) . '</td></tr>';

		$sponsor_url = sponsor_url($user->sponsor_id);

		$tmp = user($user->sponsor_id);
		$sponsor_link = (!empty($tmp) && $tmp->username !== '') ? '<a href="' . $sponsor_url . '">' . htmlspecialchars($tmp->username) . '</a>' : '-';
		$str .= '<tr><td>Sponsor:</td><td>' . $sponsor_link . '</td></tr>';
		$str .= '</table>';
		$str .= '</div>'; // Close table-responsive wrapper

		$str .= '</div>'; // End of card-body
		$str .= '</div>'; // End of card

		$str .= '<style>
			/* Flexbox setup for card-header */
			.card-header {
			    display: flex;
			    justify-content: space-between;
			    align-items: center;
			    background-color: #f5f5f5; /* Light grey background */
			    border-bottom: 1px solid #ddd; /* Light border */
			    padding: 10px 15px;
			}
			
			/* Ensure card-body and content align well */
			.card-body {
			    padding: 15px;
			}
			
			.input-group {
			    width: 100%; /* Full width for the input group */
			}
			
			.input-group .form-control {
			    flex: 1; /* Ensure the input field takes up available space */
			}
			
			.table-responsive {
			    margin-top: 15px; /* Add some space above the table */
			}
			
			/* Custom table styling */
			.custom-table {
			    width: 100%;
			    border-collapse: collapse;
			}
			
			.custom-table th, .custom-table td {
			    padding: 8px 12px;
			    border: 1px solid #ddd;
			    text-align: left;
			}
			
			.custom-table tr:nth-child(even) {
			    background-color: #f9f9f9; /* Alternating row colors */
			}
			
			.custom-table tr:hover {
			    background-color: #f1f1f1; /* Hover effect */
			}
		</style>';
	}

	if ($settings_plans->binary_pair) {
		$user_binary = user_binary($user_id);

		$upline_username = 'n/a';

		if ($user_binary) {
			$user_binary = user($user_binary->upline_id);

			if ($user_binary) {
				$upline_username = htmlspecialchars($user_binary->username);
			}
		}

		$str .= '<div class="card mb-3">';
		$str .= '<div class="card-header"><strong>Binary Information</strong></div>';
		$str .= '<div class="card-body">';
		$str .= '<table class="custom-table">';
		$str .= '<tr><td>Upline:</td><td>' . $upline_username . '</td></tr>';
		$str .= '</table>';
		$str .= '</div></div>';
	}

	$str .= '<div class="card mb-3">';
	$str .= '<div class="card-header"><strong>Contact Information</strong></div>';
	$str .= '<div class="card-body">';
	$str .= '<table class="custom-table">';
	$str .= '<tr><td>Address:</td><td>' . get_formatted_address($user->address) . '</td></tr>';
	$str .= '<tr><td>Email:</td><td>' . (!empty($user->email) ? htmlspecialchars($user->email) : '-') . '</td></tr>';
	$str .= '<tr><td>Contact Info:</td><td>' . contact_info($user->contact) . '</td></tr>';
	$str .= '</table>';
	$str .= '</div></div>';

	$str .= '<div class="card mb-3">';
	$str .= '<div class="card-header"><strong>Payment Information</strong></div>';
	$str .= '<div class="card-body">';
	$str .= '<table class="custom-table">';
	$str .= '<tr><td>Payment Method:</td><td>' . payment_info($user->payment_method) . '</td></tr>';
	//	$str .= '<tr><td>Beneficiary:</td><td>' . contact_info($user->beneficiary) . '</td></tr>';
	$str .= '</table>';
	$str .= '</div></div>';

	$str .= '<div class="text-center">';

	// if ($user_id !== '' && (input_get('uid') === '' || (input_get('uid') !== '' && input_get('uid') === session_get('user_id')))) {
	// 	$str .= '<a href="' . sef(60) . qs() . 'uid=' . $user->id . '" class="btn btn-secondary">Update Profile</a> ';
	// }

	if (!empty($user_id) && (empty(input_get('uid')) || input_get('uid') === session_get('user_id'))) {
		$url = sef(60) . qs() . 'uid=' . $user->id;
		$str .= '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" class="btn btn-secondary">Update Profile</a> ';
	}

	if ($usertype === 'Admin') {
		$str .= '<a href="' . sef(106) . qs() . 'uid=' . $user->id . '" class="btn btn-secondary">View Transactions</a>';
	}
	$str .= '</div>';

	$str .= '</div>'; // Close container

	return $str;
}

function get_formatted_address($address): string
{
	$tmp = explode('|', $address);
	$country = (isset($tmp[4]) && $tmp[4] !== '') ? (get_country_name($tmp[4])) : '';

	return (!empty($address) ? $tmp[0] . ' ' . $tmp[1] . '<br>' . $tmp[2] . ', ' . $tmp[3] . '<br>' . $country : '-');
}

function payment_info($payment_method): string
{
	$pmu = json_decode($payment_method, true);

	$str = '';

	if (!empty($pmu)) {
		foreach ($pmu as $k => $v) {
			$str .= '<p class="category table table-bordered">';
			$str .= '<a class="uk-button uk-button-success uk-button-small" href="javascript:void(0)">';
			$str .= strtoupper($k);
			$str .= '</a>';

			if (!is_array($v)) {
				$str .= '<small style="padding-left: 7px"><b>' . $v . '</b></small>';
			} else {
				foreach ($v as $x => $y) {
					$str .= '<small style="padding-left: 7px"><b>' . strtoupper($x) . ': ' . $y . '</b></small>';
				}
			}

			$str .= '</p>';
		}
	}

	return $str;
}

function contact_info($contact): string
{
	$ciu = json_decode($contact, true);

	$str = '';

	if (!empty($ciu)) {
		foreach ($ciu as $k => $v) {
			$str .= '<p class="category table table-bordered">';
			$str .= '<a class="uk-button uk-button-small" href="javascript:void(0)">';
			$str .= strtoupper($k);
			$str .= '</a>';

			if (!is_array($v)) {
				$str .= '<small style="padding-left: 7px"><b>' . $v . '</b></small>';
			}

			$str .= '</p>';
		}
	}

	return $str;
}

/**
 * @param $country_id
 *
 * @return mixed
 *
 * @since version
 */
function get_country_name($country_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT countryName ' .
		'FROM countries ' .
		'WHERE idCountry = ' . $db->quote($country_id)
	)->loadObject()->countryName;
}

/**
 *
 * @return string
 *
 * @since version
 */
function scripts(): string
{
	$str = '<script>';
	$str .= 'function copyLink() {
        /* Get the text field */
        var copyText = document.getElementById("myLink");

        /* Select the text field */
        copyText.select();

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        //alert("Copied the text: " + copyText.value);
    };
    
    (function ($) {
        $.fn.textWidth = function (text, font) {

            if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $("<span>").hide().appendTo(document.body);

            $.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr("placeholder")).css("font", font || this.css("font"));

            return $.fn.textWidth.fakeEl.width();
        };

        var cl_width_dynamic = $(".width-dynamic");

        cl_width_dynamic.on("input", function () {
            var inputWidth = $(this).textWidth();
            $(this).css({
                width: inputWidth
            })
        }).trigger("input");


        function inputWidth(elem) {
            elem = $(this);
            console.log(elem)
        }

        //var targetElem = cl_width_dynamic;

        inputWidth(cl_width_dynamic);
    })(jQuery);';
	$str .= '</script>';

	return $str;
}