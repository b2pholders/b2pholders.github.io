<?php

namespace BPL\Jumi\Registration;

require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/direct_referral.php';
require_once 'bpl/indirect_referral.php';
require_once 'bpl/passup.php';
require_once 'bpl/mods/binary/core.php';
require_once 'bpl/mods/binary/validate.php';
//require_once 'bpl/mods/autoupline_binary.php';
require_once 'bpl/leadership_binary.php';
require_once 'bpl/leadership_passive.php';
require_once 'bpl/unilevel.php';
require_once 'bpl/harvest.php';

require_once 'bpl/royalty_bonus.php';
require_once 'bpl/elite_bonus.php';

require_once 'bpl/mods/mailer.php';

require_once 'bpl/mods/helpers.php';

require_once 'bpl/mods/terms.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Ajax\check_input;
use function BPL\Mods\Ajax\check_position;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Direct_Referral\main as direct_referral;

use function BPL\Indirect_Referral\main as indirect_referral;

use function BPL\Passup_Bonus\main as passup;

use function BPL\Harvest\main as harvest;

use function BPL\Mods\Binary\Core\main as binary_package;

use function BPL\Leadership_Binary\main as leadership_binary;
use function BPL\Leadership_Passive\insert_leadership_passive;

use function BPL\Royalty_Bonus\main as royalty_bonus;
use function BPL\Elite_Bonus\main as elite_bonus;

use function BPL\Mods\Binary\Validate\main as binary_validated;

//use function BPL\Mods\AutoUpline_Binary\get_upline;
//use function BPL\Mods\AutoUpline_Binary\option_position;

use function BPL\Mods\Mailer\main as send_mail;

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
	$admintype = session_get('admintype');
	$user_id   = session_get('user_id');

	$str = menu();

	session_set('edit', false);

	if (input_get('username') === '')
	{
		$usertype = session_get('usertype');

		$sid = input_get('s');

		$s_username = session_get('s_username');
		$s_email    = session_get('s_email');
		$s_password = session_get('s_password');
		$s_sponsor  = session_get('s_sponsor');

		try
		{
			$str .= view_form($user_id, $usertype, $admintype, $sid, $s_username, $s_password, $s_sponsor, $s_email);
		}
		catch (Exception $e)
		{
		}
	}
	else
	{
		echo display_loader();

		$username = input_get('username');

		$password1 = input_get('password1');
		$password2 = input_get('password2');

		$code = input_get('code');

		$sponsor = input_get('sponsor');

		$upline   = input_get('upline');
		$position = input_get('position');

		$email = input_get('email', '', 'RAW');

		process_form(
			$user_id,
			$username,
			$password1,
			$password2,
			$code,
			$sponsor,
			$upline,
			$position,
			$email,
			$admintype
		);
	}

	echo $str;
}

function display_loader(): string
{
	return '<div class="wave">
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
      height: 100vh;
      background-color: #fff;
    }

    .ball {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      margin: 0 10px;
      background-color: #6c5ce7;
      animation: wave 1s ease-in-out infinite;
    }

    @keyframes wave {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-15px);
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
</style>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_logo(): string
{
	$img = 'images/logo_responsive.png';

	$logo1 = '<svg data-jdenticon-value="' . time() . '" width="80" height="80"></svg>';
	$logo2 = '<a href="../"><img src="' . $img . '" class="img-responsive" alt=""></a>';

	$str = '<div style="background-color: white; text-align: center; padding: 5px">' .
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
 * @param $user_id
 * @param $usertype
 * @param $admintype
 * @param $sid
 * @param $s_username
 * @param $s_password
 * @param $s_sponsor
 * @param $s_email
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id, $usertype, $admintype, $sid, $s_username, $s_password, $s_sponsor, $s_email): string
{
	$edit = session_get('edit');

	$sponsor = sponsor();

	$str = '<div' . ($usertype === '' ? ' style="margin-top: -100px;"' : '') . '>';

	$str .= $usertype === '' ? view_logo() : '';
	$str .= '<h1 style="text-align:center;">Sign Up</h1>
    <p style="text-align:center;">All fields marked * are required.';
	$str .= (!$usertype ? '<span style="float: right; font-size: x-large; font-weight: bold"><a href="' . sef(43) . '">Sign In</a></span>' : '');
	$str .= '</p>';
	$str .= '<form name="regForm" method="post" enctype="multipart/form-data" 
         onsubmit="submit.disabled = true; return true;" 
         onsubmit="return validateForm()" style="max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 10px;">
        <table class="category table table-striped table-bordered table-hover" style="width: 100%;">
            <tr>
                <td><label for="username">Username: *</label></td>
                <td><input type="text"
                           name="username"
                           id="username"
                           value="' . $s_username . '" size="40"
                           required="required"
                           style="width:calc(100% - 80px);"><a href="javascript:void(0)" onClick="checkInput(\'username\')" 
                           class="uk-button uk-button-primary" style="margin-left: 10px;">Verify</a>
                    <div style="font-weight:bold; padding-top: 5px;" id="usernameDiv"></div>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" value="' . $s_email . '" id="email" size="40" style="width:100%;"></td>
            </tr>
            <tr>
                <td><label for="password1">Password: *</label></td>
                <td><input type="password"
                           name="password1"
                           value="' . $s_password . '"
                           id="password1"
                           size="40"
                           required style="width:100%;"></td>
            </tr>
            <tr>
                <td><label for="password2">Confirm Password: *</label></td>
                <td><input type="password"
                           name="password2"
                           value="' . $s_password . '"
                           id="password2"
                           size="40"
                           required style="width:100%;"></td>
            </tr>';

	if (settings('ancillaries')->payment_mode === 'CODE') {
		$str .= '<tr>
                <td><label for="code">Registration Code: *</label></td>
                <td><input type="text" name="code" id="code" size="40" style="width:calc(100% - 80px);">
                    <a href="javascript:void(0)" onClick="checkInput(\'code\')" 
                    class="uk-button uk-button-primary" style="margin-left: 10px;">Verify</a>
                    <div style="font-weight:bold; padding-top: 5px;" id="codeDiv"></div>
                </td>
            </tr>';
	}

	$str .= '<tr>
            <td><label for="sponsor">Sponsor Username: *</label></td>
            <td><input type="text"
                       name="sponsor"
                       id="sponsor"
                       size="40"
                       value="' . ($s_sponsor && !isset($sponsor) ? $s_sponsor : $sponsor) . '" 
                       required="required" style="width:calc(100% - 80px);"' .
		($sid !== '' ? ' readonly' : '') . '>
                <a href="javascript:void(0)" onClick="checkInput(\'sponsor\')" class="uk-button uk-button-primary" 
                style="margin-left: 10px;">Verify</a>
                <div style="font-weight:bold; padding-top: 5px;" id="sponsorDiv"></div>
            </td>
        </tr>';

	$sp = settings('plans');

	if (($sp->binary_pair || $sp->redundant_binary) &&
		settings('ancillaries')->payment_mode === 'CODE') {
		$str .= '<tr>
                <td><label for="upline">Upline Username: *</label></td>
                <td><input type="text"
                           name="upline"
                           id="upline"
                           size="40"
                           value="' . /*get_upline($user_id) .*/ '" 
                           required="required"
                           style="width:calc(100% - 80px);">
                    <a href="javascript:void(0)" onClick="checkInput(\'upline\')" class="uk-button uk-button-primary" 
                    style="margin-left: 10px;">Verify</a>
                    <div style="font-weight:bold; padding-top: 5px;" id="uplineDiv"></div>
                </td>
            </tr>
            <tr>
                <td><label for="position">Position:</label></td>
                <td>
                    <select name="position" id="position" style="width:calc(100% - 80px);">' .
			/*option_position(get_upline($user_id)) .*/ '
                        <option value="Left">Left</option>
                        <option value="Right">Right</option>
                    </select>
                    <a href="javascript:void(0)" onClick="checkPosition(\'upline\', \'position\')" class="uk-button uk-button-primary" 
                    style="margin-left: 10px;">Verify</a>
                    <div style="font-weight:bold; padding-top: 5px;" id="positionDiv"></div>
                </td>
            </tr>';
	}

	$str .= (($edit && $admintype === 'Super') ? '<tr>
            <td><label for="date">Date Registered:</label></td>
            <td><input type="text" name="date" value="' . /*. date('Y - m - d G:i', $s_date == '' ? 0 : $s_date) .*/ '" 
                       id="date" size="40" style="width:100%;"></td></tr>' : '');

$str .= '<tr>
            <td colspan="2">
                <div style="float: left">
                    <label><input id="terms" type="checkbox" style="margin-top: -3px"> 
                    <a href="javascript:void(0)" data-uk-modal="{target:\'#modal-1\'}">
                        I Agree to the Terms &amp; Conditions 
                    </a>
                    </label>
                </div>
                <div style="text-align: center; margin-top: 10px;">
                    <input id="register" onClick="disableMenu()" type="submit" value="Sign Up" name="submit"
                           class="uk-button uk-button-primary" style="padding: 10px 20px;">
                </div>
            </td>
        </tr>
        </table>
    ' . HTMLHelper::_('form.token') . '
    </form>';

$str .= '<div>';


	$str .= terms();
	$str .= check_input();
	$str .= check_position();
	$str .= js();

	return $str;
}

/**
 * // *
 * @param $username
 * @param $password1
 * @param $password2
 * @param $code
 * @param $sponsor
 * @param $upline
 * @param $position
 * @param $account_type_new
 * @param $prov
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
	$upline,
	$position,
	$account_type_new,
	$prov,
	$admintype,
	$edit
)
{
//	$settings_plans = settings('plans');
//	$settings_ancillaries = settings('ancillaries');

	$payment_mode = settings('ancillaries')->payment_mode;

	if ($edit && $admintype === 'Super')
	{
		$date = input_get('date', '', 'RAW');
	}

	$app = application();

	$user_sponsor = user_username($sponsor);

//	$upline_id         = 0;
//	$downline_left_id  = 0;
//	$downline_right_id = 0;
//
//	if ($settings_ancillaries->payment_mode === 'CODE' &&
//		$settings_plans->binary_pair &&
//		!empty(user_plan($user_id, 'binary')))
//	{
//		$user_upline = username_upline($upline);
//
//		if (!empty($user_upline))
//		{
//			$upline_id         = $user_upline->u_id;
//			$downline_left_id  = $user_upline->downline_left_id;
//			$downline_right_id = $user_upline->downline_right_id;
//		}
//	}

	if ($username === '')
	{
		$err = 'Please specify your Username.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($password1 === '')
	{
		$err = 'Please specify your Password.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($password2 === '')
	{
		$err = 'Please specify your Password confirmation.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($sponsor === '')
	{
		$err = 'Please specify your Sponsor Username.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($edit && !isset($date))
	{
		$err = 'Please specify your Registration Date.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if (count(user_username_unblock($username)))
	{
		$err = 'Username already taken.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($payment_mode === 'CODE' && $code === '')
	{
		$err = 'Please specify your Registration Code.<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($payment_mode === 'CODE')
	{
		if ($code === '')
		{
			$err = 'Please specify your Registration Code.<br>';
			$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
		}

		if (empty(has_code($code)))
		{
			$err = 'Code Invalid.<br>';
			$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
		}

		if (count(has_code_used($code)))
		{
			$err = 'Code Invalid.<br>';
			$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
		}
	}

	if (empty($user_sponsor) || (empty(user_username_active($sponsor))))
	{
		$err = 'Invalid Sponsor Username!<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	if ($password1 !== $password2)
	{
		$err = 'Your Passwords do not match!<br>';
		$app->redirect(Uri::root(true) . '/' . sef(65), $err, 'error');
	}

	validate_binary($upline, $position, $account_type_new, $prov);

//	if ($settings_plans->binary_pair)
//	{
//		binary_validate($user_id, $upline, $position);
//	}
}

/**
 * @param   false  $local
 *
 * @return bool
 *
 * @since version
 */
//function has_internet(bool $local = true): bool
//{
//	$host_name = 'tokenshibs.org';
//	$port_no   = '80';
//
//	$st = (bool) @fsockopen($host_name, $port_no, $err_no, $err_str, 10);
//
//	if ((!$local && $st) || $local)
//	{
//		return true;
//	}
//
//	return false;
//}

/**
 * @param $user_id
 * @param $username
 * @param $password1
 * @param $password2
 * @param $code
 * @param $sponsor
 * @param $upline
 * @param $position
 * @param $email
 * @param $admintype
 *
 * @since version
 */
function process_form(
	$user_id,
	$username,
	$password1,
	$password2,
	$code,
	$sponsor,
	$upline,
	$position,
	$email,
	$admintype
)
{
	$db = db();

	$app = application();

//	has_internet(/*false*/) or $app->redirect(Uri::root(true) .
//		'/' . sef(65), 'Abnormal Network Connection!', 'error');

	Session::checkToken() or $app->redirect(Uri::root(true) .
		'/' . sef(65), 'Invalid Transaction!', 'error');

	$email = substr($email, 0, 60);

	$edit = session_get('edit');

	session_set_date($admintype, $edit);

	session_set('s_username', $username);
	session_set('s_email', $email);
	session_set('s_password', $password1);
	session_set('s_sponsor', $sponsor);
	session_set('s_upline', $upline);

	$code_type = code_type($code);

	$code_type_arr = explode('_', $code_type);
	$is_cd         = in_array('cd', $code_type_arr, true);

	$code_type = $code_type_arr[0];

	validate_input(
		$username,
		$password1,
		$password2,
		$code,
		$sponsor,
		$upline,
		$position,
		$code_type,
		'code',
		$admintype,
		$edit
	);

//	validate_input(
//		$username,
//		$password1,
//		$password2,
//		$code,
//		$sponsor,
//		$upline,
//		$position,
//		$account_type_new,
//		$prov,
//		$admintype,
//		$edit
//	)

	$success = false;

	try
	{
		$db->transactionStart();

		if (insert_user($username, $password1, $sponsor, $email, $admintype, $edit))
		{
			$insert_id = $db->insertid();

			insert_points($insert_id);

			// if codes
			/* */
			if (settings('ancillaries')->payment_mode === 'CODE')
			{
				$sp = settings('plans');

				update_codes($insert_id, $code);

				$has_binary = $sp->binary_pair || $sp->redundant_binary;

//			$app->redirect(Uri::root(true) . '/' . sef(65), 'Test hehehe', 'error');

				if ($has_binary)
				{
					binary_validated($insert_id, $username, $sponsor, $upline, $position, $code_type);
				}

				$settings_entry = settings('entry');

//				if ($code_type !== null)
//				{
				$code_type_mod = $settings_entry->{$code_type . '_package_name'};

				// mail admin
				$body = 'Username: ' . $username;
				$body .= '<br>';
				$body .= 'Email: ' . $email;
				$body .= '<br>';
				$body .= 'Sponsor Username: ' . $sponsor;
				$body .= '<br>';

				if ($has_binary)
				{
					$body .= ('Upline: ' . $upline);
					$body .= '<br>';
					$body .= ('Position: ' . $position);
					$body .= '<br>';
				}

				if ($code_type !== null)
				{
					$body .= isset($code_type_mod) ? ('Account Type: ' . ucfirst($code_type_mod)) : '';
				}

				$message_admin = 'A new member has Signed Up Successfully!<br><hr>' . $body;
				$message_user  = 'Congratulations, you have been signed up successfully!.<br><hr>' . $body;

				update_user_account_type($insert_id, $code_type);

				$entry = settings('entry')->{$code_type . '_entry'};
//				$points = settings('entry')->{$code_type . '_points'};

//				update_user_points($insert_id, $points);

				// commission deduction
				if ($is_cd)
				{
					insert_cd($insert_id, $entry);
				}

				$date = input_get_date($admintype, $edit);

				logs_registration($user_id, $insert_id, $code_type, $username, $sponsor, $upline, $position);

				process_plans($insert_id, $code_type, $is_cd, $username, $sponsor, $date);

				send_mail($message_admin, 'A New Member has Signed Up Successfully!');

				if ($email !== '')
				{
					send_mail($message_user, 'Sign up Confirmation', [$email]);
				}

				$success = true;

				$db->transactionCommit();
			}

		}
		/* */
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	if ($success)
	{
		$app->redirect(Uri::root(true) . '/' . sef(65), $username .
			' has been registered successfully!', 'success');
	}
	else
	{
		$app->redirect(Uri::root(true) . '/' . sef(65), 'Something went wrong!', 'error');
	}
}

function validate_binary($upline, $position, string $account_type_new = 'starter', string $prov = 'code')
{
	if (settings('plans')->binary_pair)
	{
		$app = application();

		$user_upline = username_upline($upline);

		$upline_id = $user_upline->u_id;

		$register = (($account_type_new !== 'starter' && $prov === 'code'));

		$sef = $register ? 65 : 10;

		if ($upline === '')
		{
			$err = 'Please specify your Upline.<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		$user_upline = username_upline($upline);

		if (empty($user_upline))
		{
			$err = 'Invalid Upline!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		if (count(binary_downlines($upline_id)) >= 2)
		{
			$err = 'Invalid Upline Username!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		$username_paid = user_username_paid($upline);

		if (empty($username_paid))
		{
			$err = 'Invalid Upline!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		if (has_position($upline_id, $position) ||
			(!empty($username_paid) && !empty(user_binary_active($username_paid->id, $position))))
		{
			$err = 'Invalid Position!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}
	}
}

/**
 * @param $upline_id
 * @param $position
 *
 *
 * @return mixed|null
 * @since version
 */
function user_binary_active($upline_id, $position)
{
	$db = db();

	return $db->setQuery(
		'SELECT u.id ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE b.upline_id = ' . $db->quote($upline_id) .
		'AND b.position = ' . $db->quote($position) .
		'AND u.block = ' . $db->quote(0)
	)->loadObject();
}

/**
 * @param $upline_id
 * @param $position
 *
 * @return array|mixed
 *
 * @since version
 */
function has_position($upline_id, $position)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary b ' .
		'INNER JOIN network_users u ' .
		'ON b.user_id = u.id ' .
		'WHERE b.upline_id = ' . $db->quote($upline_id) .
		' AND b.position = ' . $db->quote($position) .
		' AND u.block = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $username
 *
 *
 * @return mixed|null
 * @since version
 */
function user_username_paid($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username) .
		'AND account_type <> ' . $db->quote('starter')
	)->loadObject();
}

/**
 * @param $upline_id
 *
 * @return array|mixed
 *
 * @since version
 */
function binary_downlines($upline_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON b.user_id = u.id ' .
		'WHERE b.upline_id = ' . $db->quote($upline_id) .
		' AND u.block = ' . $db->quote(0)
	)->loadObjectList();
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
	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id = $user_sponsor[0]->id;
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

	if ($payment_mode === 'CODE')
	{
		$date_activated = $date_registered;
	}
	else
	{
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

	if ($payment_mode === 'ECASH')
	{
		$columns_user_insert[] = 'account_type';
		$values_user_insert[]  = $db->quote('starter');
	}

	return insert(
		'network_users',
		$columns_user_insert,
		$values_user_insert
	);
}

/**
 * @param $insert_id
 *
 *
 * @since version
 */
function insert_points($insert_id)
{
	insert('network_points', ['user_id'], [db()->quote($insert_id)]);
}

/**
 * @param $insert_id
 * @param $code
 *
 *
 * @since version
 */
function update_codes($insert_id, $code)
{
	$db = db();

	update(
		'network_codes',
		['user_id = ' . $db->quote($insert_id)],
		['code = ' . $db->quote($code)]
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

	if ($code_user)
	{
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
 *
 *
 * @since version
 */
function update_user_account_type($insert_id, $code_type)
{
	$db = db();

	update(
		'network_users',
		['account_type = ' . $db->quote($code_type)],
		['id = ' . $db->quote($insert_id)]
	);
}

/**
 * @param $insert_id
 * @param $points
 *
 *
 * @since version
 */
function update_user_points($insert_id, $points)
{
	if ($points > 0)
	{
		$db = db();

		update(
			'network_users',
			['points = ' . $db->quote($points)],
			['id = ' . $db->quote($insert_id)]
		);
	}
}

/**
 * @param $insert_id
 * @param $entry
 *
 *
 * @since version
 */
function insert_cd($insert_id, $entry)
{
	$db = db();

	insert(
		'network_commission_deduct',
		[
			'id',
			'balance'
		],
		[
			$db->quote($insert_id),
			$db->quote($entry)
		]
	);
}

/**
 * @param $user_id
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $upline
 * @param $position
 *
 *
 * @since version
 */
function log_registration_activity($user_id, $insert_id, $code_type, $username, $sponsor, $upline, $position)
{
	$db = db();

	$settings_plans = settings('plans');

	// sponsor
	$sponsor_id   = '';
	$sponsor_name = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id   = $user_sponsor[0]->id;
		$sponsor_name = $user_sponsor[0]->username;
	}

	$upline_id = 0;

	if ($settings_plans->binary_pair)
	{
		$user_upline = username_upline($upline);

		if (!empty($user_upline))
		{
			$upline_id = $user_upline->u_id;
		}
	}

	$not_free = settings('plans')->binary_pair/* && !empty(user_plan($user_id, 'binary')) &&
		settings('ancillaries')->payment_mode === 'CODE'*/
	;

	$code_type_mod = settings('entry')->{$code_type . '_package_name'};

	$activity = '<b>Sign up: </b><a href="' . sef(44) . qs() . 'uid=' . $insert_id . '">' .
		$username . ' (' . ucfirst($code_type_mod) . ')' . '</a>, sponsored by <a href="' .
		sef(44) . qs() . 'uid=' . $sponsor_id . '">' . $sponsor_name . '</a>.' .
		($not_free ? (' Upline: ' . $position . ' of <a href="' . sef(44) . qs() .
			'uid=' . $upline_id . '">' . $upline . '</a>.') : '');

	$field = [
		'user_id',
		'sponsor_id',
//		'upline_id',
		'activity',
		'activity_date'
	];

	if ($not_free)
	{
		$field[] = 'upline_id';
	}

	$value = [
		$db->quote($insert_id),
		$db->quote($sponsor_id),
		$db->quote($activity),
		$db->quote(time())
	];

	if ($not_free)
	{
		$value[] = $db->quote($upline_id);
	}

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
	$sponsor_id   = '';
	$sponsor_name = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id   = $user_sponsor[0]->id;
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
 * @param $insert_id
 * @param $code_type
 *
 *
 * @since version
 */
function log_income_admin($insert_id, $code_type)
{
	$settings_entry = settings('entry');

	$db = db();

	$income = (income_admin()->income_total ?? 0) + $settings_entry->{$code_type . '_entry'};

	// insert company income
	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($settings_entry->{$code_type . '_entry'}),
			$db->quote($income),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $upline
 * @param $position
 *
 *
 * @since version
 */
function logs_registration($user_id, $insert_id, $code_type, $username, $sponsor, $upline, $position)
{
	log_registration_activity($user_id, $insert_id, $code_type, $username, $sponsor, $upline, $position);

//	$not_free = settings('plans')->binary_pair && !empty(user_plan($user_id, 'binary')) &&
//		settings('ancillaries')->payment_mode === 'CODE';

//	if ($not_free)
//	{
	log_registration_transactions($insert_id, $code_type, $username, $sponsor);
	log_income_admin($insert_id, $code_type);
//	}
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function income_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 * @param $user_id
 * @param $plan
 *
 * @return mixed|null
 *
 * @since version
 */
function user_plan($user_id, $plan)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_' . $plan .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $is_cd
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_plans($insert_id, $code_type, $is_cd, $username, $sponsor, $date)
{
	process_direct_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date);
	process_indirect_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date);
//	process_passup($insert_id, $code_type, $username, $sponsor);
	process_binary($insert_id, $is_cd);
	process_leadership_binary($insert_id, $code_type, $is_cd, $sponsor, $date);
	process_unilevel($insert_id, $code_type, $is_cd, $username, $sponsor, $date);
//	process_harvest();
//	process_royalty($insert_id);
//	process_elite($insert_id);

	process_compound_daily($insert_id, $code_type, $username, $sponsor, $date);
	process_fixed_daily($insert_id, $code_type, $username, $sponsor, $date);
	process_leadership_passive($insert_id, $code_type, $username, $sponsor, $date);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $is_cd
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_direct_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date)
{
	$sponsor_account_type = 'starter';

	$Settings_plans = settings('plans');

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_account_type = $user_sponsor[0]->account_type;
	}

	if ($sponsor_account_type !== 'starter' &&
		(settings('plans')->direct_referral || $Settings_plans->binary_pair) &&
		settings('ancillaries')->referral_mode === 'standard')
	{
		direct_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $is_cd
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_indirect_referral($insert_id, $code_type, $is_cd, $username, $sponsor, $date)
{
	if (
		settings('indirect_referral')->{$code_type . '_indirect_referral_level'}
		&& settings('plans')->indirect_referral
//		&& !$is_cd
	)
	{
		insert_indirect($insert_id);

		logs_indirect_referral($insert_id, $code_type, $username, $sponsor, $date);

		indirect_referral();
	}
}

/**
 * @param $insert_id
 *
 *
 * @since version
 */
function insert_indirect($insert_id)
{
	insert(
		'network_indirect',
		['id', 'user_id'],
		[db()->quote($insert_id), db()->quote($insert_id)]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function logs_indirect_referral($insert_id, $code_type, $username, $sponsor, $date)
{
	$settings_plans = settings('plans');

	$db = db();

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id = $user_sponsor[0]->id;
	}

	$activity = '<b>' . ucwords($settings_plans->indirect_referral_name) . ' Entry: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
		ucwords($settings_plans->indirect_referral_name) . ' upon ' .
		ucfirst(settings('entry')->{$code_type . '_package_name'}) . ' Sign Up.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $insert_id
 * @param $is_cd
 *
 * @since version
 */
function process_binary($insert_id, $is_cd)
{
	if (settings('plans')->binary_pair)
	{
//		$flushout = settings('binary')->hedge === 'flushout';

		binary_package($insert_id, 'code', $is_cd);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $is_cd
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_leadership_binary($insert_id, $code_type, $is_cd, $sponsor, $date)
{
	if (
		settings('leadership')->{$code_type . '_leadership_level'}
		&& settings('plans')->leadership_binary
//		&& !$is_cd
	)
	{
		insert_leadership_binary($insert_id);

		logs_leadership_binary($insert_id, $code_type, $sponsor, $date);

		leadership_binary();
	}
}

/**
 * @param $insert_id
 *
 *
 * @since version
 */
function insert_leadership_binary($insert_id)
{
	insert('network_leadership',
		['user_id'],
		[db()->quote($insert_id)]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function logs_leadership_binary($insert_id, $code_type, $sponsor, $date)
{
	$db = db();

	$settings_plans = settings('plans');

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id = $user_sponsor[0]->id;
	}

	$activity = '<b>' . ucwords($settings_plans->leadership_binary_name) . ' Entry: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . input_get('username') . '</a> has entered into ' .
		ucwords($settings_plans->leadership_binary_name) . ' upon ' .
		ucfirst(settings('entry')->{$code_type . '_package_name'}) . ' Sign Up.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 *
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_compound_daily($insert_id, $code_type, $username, $sponsor, $date)
{
	if (settings('investment')->{$code_type . '_principal'} &&
		settings('plans')->etrade)
	{
		insert_compound($insert_id, $code_type);

		logs_compound_daily($insert_id, $code_type, $username, $sponsor, $date);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 *
 *
 * @since version
 */
function insert_compound($insert_id, $code_type)
{
	$db = db();

	$settings_investment = settings('investment');

	insert(
		'network_compound',
		[
			'user_id',
			'time_last',
			'value_last',
			'day',
			'processing',
			'maturity'
		],
		[
			$db->quote($insert_id),
			0,
			0,
			0,
			$db->quote($settings_investment->{$code_type . '_processing'}),
			$db->quote($settings_investment->{$code_type . '_maturity'})
		]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function logs_compound_daily($insert_id, $code_type, $username, $sponsor, $date)
{
	$db = db();

	$settings_plans = settings('plans');

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id = $user_sponsor[0]->id;
	}

	$activity = '<b>' . ucwords($settings_plans->etrade_name) . ' Entry: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
		ucwords($settings_plans->etrade_name) . ' upon ' .
		ucfirst(settings('entry')->{$code_type . '_package_name'}) . ' Sign Up.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 *
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_fixed_daily($insert_id, $code_type, $username, $sponsor, $date)
{
	if (settings('investment')->{$code_type . '_fixed_daily_principal'} &&
		settings('plans')->fixed_daily)
	{
		insert_fixed_daily($insert_id, $code_type);

		logs_fixed_daily($insert_id, $code_type, $username, $sponsor, $date);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 *
 *
 * @since version
 */
function insert_fixed_daily($insert_id, $code_type)
{
	$settings_investment = settings('investment');

	$db = db();

	insert(
		'network_fixed_daily',
		[
			'user_id',
			'time_last',
			'value_last',
			'day',
			'processing'
		],
		[
			$db->quote($insert_id),
			0,
			0,
			0,
			$db->quote($settings_investment->{$code_type . '_fixed_daily_processing'})
		]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function logs_fixed_daily($insert_id, $code_type, $username, $sponsor, $date)
{
	$settings_plans = settings('plans');

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id = $user_sponsor[0]->id;
	}

	$db = db();

	$activity = '<b>' . ucwords($settings_plans->fixed_daily_name) . ' Entry: </b> <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
		ucwords($settings_plans->fixed_daily_name) . ' upon ' .
		ucfirst(settings('entry')->{$code_type . '_package_name'}) . ' Sign Up.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 *
 * @param $username
 * @param $sponsor_id
 * @param $date
 *
 * @since version
 */
function process_leadership_passive($insert_id, $code_type, $username, $sponsor_id, $date)
{
	if (settings('plans')->leadership_passive &&
		settings('leadership_passive')->{$code_type . '_leadership_passive_level'})
	{
		insert_leadership_passive($insert_id, $code_type, $username, $sponsor_id, $date);

//		logs_leadership_passive($insert_id, $code_type, $username, $sponsor, $date);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $is_cd
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function process_unilevel($insert_id, $code_type, $is_cd, $username, $sponsor, $date)
{
	if (
		settings('plans')->unilevel
		&& settings('unilevel')->{$code_type . '_unilevel_level'}
//		&& !$is_cd
	)
	{
		insert_unilevel($insert_id);

		logs_unilevel($insert_id, $code_type, $username, $sponsor, $date);
	}
}

/**
 * @param $insert_id
 *
 *
 * @since version
 */
function insert_unilevel($insert_id)
{
	insert(
		'network_unilevel',
		['user_id'],
		[db()->quote($insert_id)]
	);
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $username
 * @param $sponsor
 * @param $date
 *
 * @since version
 */
function logs_unilevel($insert_id, $code_type, $username, $sponsor, $date)
{
	$db = db();

	$settings_plans = settings('plans');

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor))
	{
		$sponsor_id = $user_sponsor[0]->id;
	}

	$activity = '<b>' . ucwords($settings_plans->unilevel_name) . ' Entry via Signup: </b> <a href="' . sef(44) . qs() .
		'uid=' . $insert_id . '">' . $username . '</a> has entered into ' . ucwords($settings_plans->unilevel_name) .
		' upon ' . ucfirst(settings('entry')->{$code_type . '_package_name'}) . ' Sign Up.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($sponsor_id),
			$db->quote($activity),
			$db->quote($date)
		]
	);
}

/**
 *
 * @return void|null
 *
 * @since version
 */
function process_harvest()
{
	$settings_plans = settings('plans');

	if ($settings_plans->harvest)
	{
		harvest();

		return null;
	}
}

/**
 * @param $insert_id
 *
 *
 * @since version
 */
function process_royalty($insert_id)
{
	$settings_plans = settings('plans');

	if ($settings_plans->royalty)
	{
		royalty_bonus($insert_id, 0);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 * @param $entry_name
 * @param $sponsor
 *
 *
 * @since version
 */
function process_passup($insert_id, $code_type, $entry_name, $sponsor)
{
	if (settings('plans')->passup)
	{
		passup($insert_id, $code_type, $entry_name, user_username($sponsor)->id);
	}
}

/**
 * @param $insert_id
 *
 *
 * @since version
 */
function process_elite($insert_id)
{
	$settings_plans = settings('plans');

	if ($settings_plans->elite_reward)
	{
		elite_bonus($insert_id, 0);
	}
}

/**
 *
 * @return string
 *
 * @since version
 */
function js(): string
{
	$str = '<script>';
	$str .= 'function validateForm() {
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
        }';

	$str .= 'function disableMenu() {
				document.getElementById("menu").disabled = true;
			}';

	$str .= '(function ($) {
            $("#register").attr("disabled", true);

            $("#terms").change(function () {
                if (this.checked) {
                    $("#register").attr("disabled", false);
                } else {
                    $("#register").attr("disabled", true);
                }
                
                return false;
            });
        })(jQuery);';
	$str .= '</script>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function sponsor(): string
{
	$sid     = input_get('s');
	$user_id = session_get('user_id');

	$sponsor = '';

	if ($sid !== '')
	{
		$sponsor = $sid;
	}
	elseif ($user_id !== '')
	{
		$sponsor = user($user_id)->username ?? '';
	}

	return $sponsor;
}

/**
 *
 * @return string
 *
 * @since version
 */
//function upline(): string
//{
//	$uid     = input_get('uid');
//	$user_id = session_get('user_id');
//
//	$settings_plans = settings('plans');
//
//	$upline = '';
//
//	if ($settings_plans->binary_pair)
//	{
//		if ($uid !== '')
//		{
//			$upline = user($uid)->username ?? '';
//		}
//		elseif ($user_id !== '')
//		{
//			$upline = user($user_id)->username ?? '';
//		}
//	}
//
//	return $upline;
//}

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
 * @param $code
 *
 * @return array|mixed
 *
 * @since version
 */
function has_code($code)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE code = ' . $db->quote($code)
	)->loadObjectList();
}

/**
 * @param $code
 *
 * @return array|mixed
 *
 * @since version
 */
function has_code_used($code)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE code = ' . $db->quote($code) .
		' AND user_id <> 0'
	)->loadObjectList();
}

/**
 * @param $username
 *
 * @return mixed|null
 *
 * @since version
 */
function username_upline($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT u.id as u_id, ' .
		'downline_left_id, ' .
		'downline_right_id ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE u.username = ' . $db->quote($username) .
		' AND u.account_type <> ' . $db->quote('starter')
	)->loadObject();
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

	if ($edit && $admintype === 'Super')
	{
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

	if ($edit && $admintype === 'Super' && (int) $date !== 0)
	{
		session_set('s_date', $date);
	}
}