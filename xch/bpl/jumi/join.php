<?php

namespace BPL\Jumi\Join;

require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';
require_once 'bpl/mods/terms.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;
use Joomla\CMS\HTML\HTMLHelper;

use function BPL\Mods\Ajax\check_input;
use function BPL\Mods\Ajax\check_position;

use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\time;

use function BPL\Mods\Terms\main as terms;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$str = menu();

	session_set('edit', false);

	if (input_get('username') === '') {
		try {
			$str .= view_form();
		} catch (Exception $e) {
		}
	} else {
		process_form();
	}

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function display_loader(): string
{
	return <<<HTML
		<div class="wave">
			<div class="ball"></div>
			<div class="ball"></div>
			<div class="ball"></div>
			<div class="ball"></div>
			<div class="ball"></div>
		</div>
		<style>
			.wave {
				display: flex;
				justify-content: center;
				align-items: center;
				position: fixed;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
			}

			.ball {
				width: 10px; /* Further reduce width */
				height: 10px; /* Further reduce height */
				border-radius: 50%;
				margin: 0 3px; /* Reduce margin for closer spacing */
				background-color: #6c5ce7;
				animation: wave 1s ease-in-out infinite;
			}

			@keyframes wave {
				0% {
					transform: translateY(0);
				}
				50% {
					transform: translateY(-5px); /* Further reduce bounce height */
				}
				100% {
					transform: translateY(0);
				}
			}

			.ball:nth-child(2) {
				animation-delay: -0.2s;
			}

			.ball:nth-child(3) {
				animation-delay: -0.4s;
			}

			.ball:nth-child(4) {
				animation-delay: -0.6s;
			}

			.ball:nth-child(5) {
				animation-delay: -0.8s;
			}
		</style>
	HTML;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_logo(): string
{
	$img = 'images/Logo_Yellow_P.gif';

	$logo1 = '<svg data-jdenticon-value="' . time() . '" width="80" height="80"></svg>';
	$logo2 = '<a href="../"><img src="' . $img . '" class="img-responsive" alt=""></a>';

	$str = '<div style="background-color: transparent; text-align: center; padding: 5px">' .
		(!1 ? $logo1 : $logo2) . /*('<a href="../">
<img src="' . $img . '" class="img-responsive" style="padding: 5px; margin-left: 33px" alt="">
</a>') .*/
		'</div>';

	$str .= identicon_js();

	return $str;
}

function identicon_js(): string
{
	return '<script src="https://cdn.jsdelivr.net/npm/jdenticon@3.1.1/dist/jdenticon.min.js" async
        integrity="sha384-l0/0sn63N3mskDgRYJZA6Mogihu0VY3CusdLMiwpJ9LFPklOARUcOiWEIGGmFELx" crossorigin="anonymous">
</script>';
}

/**
 * @return string
 *
 * @since version
 */
function view_form(): string
{
	$settings_plans = settings('plans');
	$usertype = session_get('usertype');
	$admintype = session_get('admintype');
	$sid = input_get('s');
	$s_username = session_get('s_username');
	$s_email = session_get('s_email');
	$s_password = session_get('s_password');
	$s_sponsor = session_get('s_sponsor');
	$edit = session_get('edit');
	$sponsor = sponsor();

	$form = '';

	$margin_style = '';
	$logo = '';

	if ($usertype === '') {
		$form .= <<<CSS
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		CSS;

		$margin_style = ' style="margin-top: -10px;"';

		$logo = view_logo();
	}

	$sponsor_field = '';
	if ($settings_plans->direct_referral || $settings_plans->echelon) {
		$sponsor_value = $s_sponsor && !isset($sponsor) ? $s_sponsor : $sponsor;
		$readonly = $sid !== '' ? ' readonly' : '';
		$sponsor_field = <<<HTML
            <div class="form-group">
                <label for="sponsor">Sponsor Username: *</label>
                <div class="input-group">
                    <input type="text" name="sponsor" id="sponsor" class="form-control" value="$sponsor_value" placeholder="Enter Sponsor Username Here.." required$readonly>
                    <span class="input-group-btn">
                        <button type="button" onClick="checkInput('sponsor')" class="btn btn-default" style="height: 38px;">Check Validity</button>
                    </span>
                </div>
                <div id="sponsorDiv" class="help-block validation-message"></div>
            </div>
        HTML;
	}

	$date_field = '';
	if ($edit && $admintype === 'Super') {
		$date_field = <<<HTML
            <div class="form-group">
                <label for="date">Date Registered:</label>
                <input type="text" name="date" id="date" class="form-control" size="40">
            </div>
        HTML;
	}

	$login_link = !$usertype ? '<a href="' . sef(43) . '" class="login-link">Log In</a>' : '';

	$formToken = HTMLHelper::_('form.token');

	// Include the form CSS and JS
	$form .= formCss();

	// Form HTML with updated style
	$form .= <<<HTML
        <div class="registration-form"$margin_style>
            $logo
            <h1>Register</h1>
            <p>Please fill up all fields marked *</p>
            <form name="regForm" method="post" enctype="multipart/form-data" onsubmit="submit.disabled = true; return validateForm()">
                <!-- Username Field -->
                <div class="form-group">
                    <label for="username">Username: *</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" class="form-control" value="$s_username" placeholder="Enter Username Here.." required>
                        <span class="input-group-btn">
                            <button type="button" onClick="checkInput('username')" class="btn btn-default" style="height: 38px;">Check Availability</button>
                        </span>
                    </div>
                    <div id="usernameDiv" class="help-block validation-message"></div>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email: *</label>
                    <input type="email" name="email" id="email" class="form-control" value="$s_email" placeholder="Enter Email Here.." required>
                </div>

                <!-- Password Fields -->
				<div class="form-group">
					<label for="password1">Password: *</label>
					<div class="input-group">
						<input type="password" name="password1" id="password1" class="form-control" value="$s_password" placeholder="Enter Password Here.." required>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default toggle-password" data-target="password1" style="height: 38px;">
								<i class="bi bi-eye"></i>
							</button>
						</span>
					</div>
				</div>

				<div class="form-group">
					<label for="password2">Confirm Password: *</label>
					<div class="input-group">
						<input type="password" name="password2" id="password2" class="form-control" value="$s_password" placeholder="Confirm Password Here.." required>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default toggle-password" data-target="password2" style="height: 38px;">
								<i class="bi bi-eye"></i>
							</button>
						</span>
					</div>
				</div>

				<!-- Bootstrap Icons CDN (add to head if not present) -->
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

				<!-- JavaScript (place before closing </body> tag) -->
				<script>
					document.querySelectorAll('.toggle-password').forEach(button => {
						button.addEventListener('click', function() {
							const targetId = this.getAttribute('data-target');
							const input = document.getElementById(targetId);
							const icon = this.querySelector('i');
							
							if (input.type === 'password') {
								input.type = 'text';
								icon.classList.remove('bi-eye');
								icon.classList.add('bi-eye-slash');
							} else {
								input.type = 'password';
								icon.classList.remove('bi-eye-slash');
								icon.classList.add('bi-eye');
							}
						});
					});
				</script>

                <!-- Sponsor Field -->
                $sponsor_field

                <!-- Date Field (for admin) -->
                $date_field

                <!-- Terms and Conditions -->
                <div class="form-group terms">
                    <label style="display: flex; align-items: center;">
                        <input type="checkbox" id="terms" required>&nbsp;
                        I Agree to the <a href="javascript:void(0)" data-uk-modal="{target:'#modal-1'}">Terms & Conditions</a>
                    </label>
                </div>

                <!-- Submit Button and Login Link -->
                <div class="form-group actions">
                    <button type="submit" id="register" class="btn btn-primary">Register</button>
                    <div style="text-align: center; margin-top: 10px;">
                        $login_link
                    </div>
                </div>
                $formToken
            </form>
        </div>
HTML;

	// Append additional functions
	$form .= terms();
	$form .= check_input();
	$form .= check_position();
	$form .= js();

	return $form;
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
                max-width: 600px; /* Reduced width */
                margin: 50px auto; /* Center the form with some top margin */
                padding: 20px; /* Add padding */
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

            /* Custom styling for the validation messages */
            .help-block.validation-message {
                color: #a94442; /* Red color for error messages */
                font-size: 12px;
            }

            /* Center the form heading */
            .registration-form h1 {
                text-align: center;
                margin-bottom: 20px;
            }

            /* Style the terms and conditions link */
            .registration-form .terms a {
                color: #007bff; /* Bootstrap primary color */
                text-decoration: none;
            }

            .registration-form .terms a:hover {
                text-decoration: underline;
            }

            /* Style the submit button */
            .registration-form .actions .btn-primary {
                width: 100%;
                margin-top: 10px;
            }

            /* Center the login link */
            .registration-form .actions {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .registration-form .actions .login-link {
                margin-top: 10px; /* Add spacing between the button and the link */
                text-align: center;
                color: #007bff; /* Bootstrap primary color */
                text-decoration: none;
            }

            .registration-form .actions .login-link:hover {
                text-decoration: underline;
            }
        </style>
    CSS;
}

/**
 * // *
 * @param $username
 * @param $password1
 * @param $password2
 * @param $code
 * @param $sponsor
 * @param $admintype
 * @param $edit
 *
 * @since version
 */
function validate_input(
	$username,
	$password1,
	$password2,
	$code,
	$sponsor,
	$admintype,
	$edit
) {
	$settings_plans = settings('plans');
	$settings_ancillaries = settings('ancillaries');

	$payment_mode = $settings_ancillaries->payment_mode;

	if ($edit && $admintype === 'Super') {
		$date = input_get('date', '', 'RAW');
	}

	$app = application();

	if ($username === '') {
		$err = 'Please specify your Username.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if ($password1 === '') {
		$err = 'Please specify your Password.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if ($password2 === '') {
		$err = 'Please specify your Password confirmation.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if ($edit && !isset($date)) {
		$err = 'Please specify your Registration Date.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if (count(user_username_unblock($username))) {
		$err = 'Username already taken.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if ($payment_mode === 'CODE' && $code === '') {
		$err = 'Please specify your Registration Code.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if ($password1 !== $password2) {
		$err = 'Your Passwords do not match!<br>';
		$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
	}

	if ($settings_plans->direct_referral) {
		$user_sponsor = user_username($sponsor);

		if ($sponsor === '') {
			$err = 'Please specify your Sponsor Username.<br>';
			$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
		}

		if (empty($user_sponsor) || (empty(user_username_active($sponsor)))) {
			$err = 'Invalid Sponsor Username!<br>';
			$app->redirect(Uri::root(true) . '/' . sef(144), $err, 'error');
		}
	}
}

/**
 * @since version
 */
function process_form()
{
	echo display_loader();

	$admintype = session_get('admintype');
	$edit = session_get('edit');

	$username = input_get('username');
	$password1 = input_get('password1');
	$password2 = input_get('password2');
	$code = input_get('code');
	$sponsor = input_get('sponsor');
	$email = input_get('email', '', 'RAW');

	$app = application();

	Session::checkToken() or $app->redirect(Uri::root(true) .
		'/' . sef(144), 'Invalid Transaction!', 'error');

	$email = substr($email, 0, 60);

	session_set_date($admintype, $edit);

	session_set('s_username', $username);
	session_set('s_email', $email);
	session_set('s_password', $password1);
	//	session_set('s_sponsor', $sponsor);

	validate_input(
		$username,
		$password1,
		$password2,
		$code,
		$sponsor,
		$admintype,
		$edit
	);

	if (insert_user($username, $password1, $sponsor, $email, $admintype, $edit)) {
		$app->redirect(Uri::root(true) . '/' . sef(144), $username .
			' has joined successfully!', 'success');
	} else {
		$app->redirect(Uri::root(true) . '/' . sef(144), 'Something went wrong!', 'error');
	}
}

/**
 * @param $username
 * @param $password
 * @param $sponsor
 * @param $email
 * @param $admintype
 * @param $edit
 *
 * @return false|mixed
 *
 * @since version
 */
function insert_user($username, $password, $sponsor, $email, $admintype, $edit)
{
	$db = db();

	$payment_mode = settings('ancillaries')->payment_mode;

	$email = substr($email, 0, 60);

	$date = input_get_date($admintype, $edit);

	// sponsor
	$sponsor_id = '1';

	if (settings('plans')->direct_referral || settings('plans')->echelon) {
		$user_sponsor = user_username($sponsor);

		if (!empty($user_sponsor)) {
			$sponsor_id = $user_sponsor[0]->id;
		}
	}

	$columns_user_insert = [
		'username',
		'password',
		'sponsor_id',
		'date_registered',
		'date_activated',
		'email'
	];

	$date_registered = ($edit && isset($date) ? $db->quote($date) : $db->quote(time()));

	if ($payment_mode === 'CODE') {
		$date_activated = $date_registered;
	} else {
		$date_activated = ($edit && (int) $date !== 0 ? $db->quote($date) : $db->quote(0));
	}

	$values_user_insert = [
		$db->quote($username),
		$db->quote(md5($password)),
		$db->quote($sponsor_id),
		$date_registered,
		$date_activated,
		$db->quote($email)
	];

	if ($payment_mode === 'ECASH') {
		$columns_user_insert[] = 'account_type';
		$values_user_insert[] = $db->quote('starter');
	}

	return insert(
		'network_users',
		$columns_user_insert,
		$values_user_insert
	);
}

/**
 * @param $code
 *
 * @return string
 *
 * @since version
 */
function code_type($code): string
{
	$code_type = 'starter';

	$code_user = code_user($code);

	if ($code_user) {
		$code_type = $code_user[0]->type;
	}

	return $code_type;
}

/**
 * @param $code
 *
 * @return array|mixed
 *
 * @since version
 */
function code_user($code)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE code = ' . $db->quote($code)/* .
' AND user_id = ' . $db->quote($insert_id)*/
	)->loadObjectList();
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 *
 *
 * @since version
 */
function log_registration_activity($insert_id, $code_type, $username, $sponsor)
{
	$db = db();

	// sponsor
	$sponsor_id = '';
	$sponsor_name = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor)) {
		$sponsor_id = $user_sponsor[0]->id;
		$sponsor_name = $user_sponsor[0]->username;
	}

	$code_type_mod = settings('entry')->{$code_type . '_package_name'};

	$activity = '<b>Sign up: </b><a href="' . sef(44) . qs() . 'uid=' . $insert_id . '">' .
		$username . ' (' . ucfirst($code_type_mod) . ')' . '</a>, sponsored by <a href="' .
		sef(44) . qs() . 'uid=' . $sponsor_id . '">' . $sponsor_name . '</a>.';

	$field = [
		'user_id',
		'sponsor_id',
		'activity',
		'activity_date'
	];

	$value = [
		$db->quote($insert_id),
		$db->quote($sponsor_id),
		$db->quote($activity),
		$db->quote(time())
	];

	// activity
	insert('network_activity', $field, $value);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 *
 *
 * @since version
 */
function log_registration_transactions($insert_id, $code_type, $username, $sponsor)
{
	$db = db();

	$entry = settings('entry')->{$code_type . '_entry'};

	// sponsor
	$sponsor_id = '';
	$sponsor_name = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor)) {
		$sponsor_id = $user_sponsor[0]->id;
		$sponsor_name = $user_sponsor[0]->username;
	}

	$details = '<b>Sign up: ' . number_format($entry, 2) . settings('ancillaries')->currency .
		' paid by </b><a href="' . sef(44) . qs() . 'uid=' . $insert_id . '">' . $username .
		' (' . ucfirst(settings('entry')->{$code_type . '_package_name'}) . ')' .
		'</a>, sponsored by <a href="' . sef(44) . qs() . 'uid=' . $sponsor_id . '">' . $sponsor_name . '</a>.';

	// transactions
	insert(
		'network_transactions',
		[
			'user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'
		],
		[
			$db->quote($insert_id),
			$db->quote('Sign Up'),
			$db->quote($details),
			$db->quote($entry),
			$db->quote(0),
			$db->quote(time())
		]
	);
}

/**
 *
 * @return string
 *
 * @since version
 */
function js(): string
{
	return <<<JS
		<script>
			function validateForm() {
				if (document.forms["regForm"]["username"].value === ""
					|| document.forms["regForm"]["password1"].value === ""
					|| document.forms["regForm"]["password2"].value === ""
					|| document.forms["regForm"]["code"].value === ""
					|| document.forms["regForm"]["sponsor"].value === ""
					|| document.forms["regForm"]["upline"].value === "") {
					alert("Please specify all required info.");
					
					return false;
				} else {
					return true;
				}
			}

			function disableMenu() {
				document.getElementById("menu").disabled = true;
			}

			(function ($) {
				$("#register").attr("disabled", true);

				$("#terms").change(function () {
					if (this.checked) {
						$("#register").attr("disabled", false);
					} else {
						$("#register").attr("disabled", true);
					}
					
					return false;
				});
			})(jQuery);
		</script>
	JS;
}

/**
 *
 * @return string
 *
 * @since version
 */
function sponsor(): string
{
	$sid = input_get('s');
	$user_id = session_get('user_id');

	$sponsor = '';

	if ($sid !== '') {
		$sponsor = $sid;
	} elseif ($user_id !== '') {
		$sponsor = user($user_id)->username ?? '';
	}

	return $sponsor;
}

/**
 * @param $username
 *
 * @return array|mixed
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
	)->loadObjectList();
}

/**
 * @param $username
 *
 * @return array|mixed
 *
 * @since version
 */
function user_username_active($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username) .
		' AND account_type <> ' . $db->quote('starter')
	)->loadObjectList();
}

/**
 * @param $username
 *
 * @return array|mixed
 *
 * @since version
 */
function user_username_unblock($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username) .
		' AND block = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 *
 * @param $admintype
 * @param $edit
 *
 * @return string
 *
 * @since version
 */
function input_get_date($admintype, $edit): string
{
	$date = time();

	if ($edit && $admintype === 'Super') {
		$date = input_get('date', 0, 'RAW');
	}

	return $date;
}

/**
 * @param $admintype
 * @param $edit
 *
 *
 * @since version
 */
function session_set_date($admintype, $edit)
{
	$date = input_get_date($admintype, $edit);

	if ($edit && $admintype === 'Super' && (int) $date !== 0) {
		session_set('s_date', $date);
	}
}