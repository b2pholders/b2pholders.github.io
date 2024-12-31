<?php

namespace BPL\Jumi\Buy_Package;

require_once 'bpl/direct_referral.php';
require_once 'bpl/indirect_referral.php';
require_once 'bpl/passup.php';
require_once 'bpl/mods/binary/core.php';
require_once 'bpl/mods/binary/validate.php';
//require_once 'bpl/binary_activate_bonus.php';
//require_once 'bpl/mods/autoupline_binary.php';

// test disbale
require_once 'bpl/leadership_binary.php';
require_once 'bpl/leadership_passive.php';

// test disbale
require_once 'bpl/unilevel.php';
//require_once 'bpl/harvest.php';
//require_once 'bpl/royalty_bonus.php';
//require_once 'bpl/passup_bonus.php';
//require_once 'bpl/elite_bonus.php';

require_once 'bpl/mods/usdt_currency.php';

require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;

use function BPL\Direct_Referral\main as direct_referral;
use function BPL\Indirect_Referral\main as indirect_referral;
use function BPL\Passup_Bonus\main as passup;
use function BPL\Leadership_Passive\insert_leadership_passive;

use function BPL\Mods\Binary\Core\main as binary_package;
use function BPL\Mods\Binary\Validate\main as binary_validated;

//use function BPL\Binary_Package\main as binary_package;

// test disable
use function BPL\Leadership_Binary\main as leadership_binary;

//use function BPL\Harvest\main as harvest;
use function BPL\Unilevel\insert_unilevel;

//use function BPL\Mods\Binary\Core\user_binary;
//use function BPL\Royalty_Bonus\main as royalty_bonus;
//use function BPL\Passup_Bonus\main as passup_bonus;
//use function BPL\Elite_Bonus\main as elite_bonus;

use function BPL\Mods\USDT_Currency\main as usdt_currency;

//use function BPL\Mods\AutoUpline_Binary\get_upline;
//use function BPL\Mods\AutoUpline_Binary\option_position;
//use function BPL\Mods\AutoUpline_Binary\get_position;

use function BPL\Mods\Ajax\check_input;
use function BPL\Mods\Ajax\check_position;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\time;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');
	$admintype = session_get('admintype');
	$usertype = session_get('usertype');
	$account_type = session_get('account_type');

	$type = input_get('type', '', 'RAW');
	$method = input_get('method', '', 'RAW');

	//	$upline   = input_get('upline', get_upline($user_id));
//	$position = input_get('position', get_position($upline));

	$upline = input_get('upline');
	$position = input_get('position');

	page_validate($usertype, $account_type);

	$str = menu();

	session_set('edit', false);

	if ($type === '' || ($method === '' && settings('plans')->trading)) {
		$str .= view_package($user_id);
	} else {
		$final = input_get('final');
		$edit = session_get('edit', false);

		$str .= buy_package($user_id, $admintype, $type, $method, $final, $upline, $position, $edit);
	}

	echo $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_package($user_id): string
{
	//	$sa = settings('ancillaries');

	$str = '<h1>Subscribe</h1>
    <form method="post" onsubmit="submit.disabled = true; return true;">
        <table class="category table table-striped table-bordered table-hover">';
	$str .= row_balance_remaining($user_id);
	$str .= '<tr>
                <td><label for="type" style="text-align: right; font-weight: bold">Accounts:</label></td>
                <td>';
	$str .= account_select();
	$str .= payment_select();
	$str .= '<input type="submit" name="submit" value="Subscribe" class="uk-button uk-button-primary">';
	//	$str .= '<span style="float: right;"><span style="color: green; font-weight: bold">
//		<a href="' . sef(73) . '">Buy ' . $sa->efund_name . '</a></span>';
	$str .= '</td>
            </tr>
        </table>';
	$str .= HTMLHelper::_('form.token');
	$str .= '</form>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function row_balance_remaining($user_id): string
{
	$sa = settings('ancillaries');

	$user = user($user_id);

	$str = '<tr><td colspan="2">';
	$str .= settings('plans')->trading ? ('<strong>Token Balance: </strong>' .
		number_format($user->balance_fmc, 2) . ' ' .
		settings('trading')->token_name . '<span style="float: right">') : '';
	$str .= '<strong>' . $sa->efund_name . ' Balance: </strong>' .
		number_format($user->payout_transfer, 2) . '</span></td></tr>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function account_select(): string
{
	$str = '<select name="type" id="type" style="float: left">
            	<option value="none" selected>Select Account</option>';
	$str .= account_options();
	$str .= '</select>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function account_options(): string
{
	$settings_entry = settings('entry');

	$str = $settings_entry->chairman_entry > 0 ? '<option value="chairman">' .
		$settings_entry->chairman_package_name . '</option>' : '';
	$str .= $settings_entry->executive_entry > 0 ? '<option value="executive">' .
		$settings_entry->executive_package_name . '</option>' : '';
	$str .= $settings_entry->regular_entry > 0 ? '<option value="regular">' .
		$settings_entry->regular_package_name . '</option>' : '';
	$str .= $settings_entry->associate_entry > 0 ? '<option value="associate">' .
		$settings_entry->associate_package_name . '</option>' : '';
	$str .= $settings_entry->basic_entry > 0 ? '<option value="basic">' .
		$settings_entry->basic_package_name . '</option>' : '';

	return $str;

	//	return $settings_entry->basic_entry > 0 ? '<option value="basic">' .
//		$settings_entry->basic_package_name . '</option>' : '';
}

/**
 *
 * @return string
 *
 * @since version
 */
function payment_select(): string
{
	// $sa = settings('ancillaries');

	$str = '<input name="method" value="efund" type="hidden">';

	// if (settings('plans')->trading) {
	// 	$str .= '<select name="method" id="method" style="float: left">';
	// 	$str .= '<option value="efund" selected>Payment method</option>';
	// 	$str .= '<option value="efund">' . $sa->efund_name . '</option>';
	// 	$str .= '</select>';
	// }

	return $str;
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
	)->loadObject();
}

/**
 * @param $user_id
 * @param $admintype
 * @param $type
 * @param $method
 *
 * @since version
 */
function validate_input($user_id, $admintype, $type, $method)
{
	$sa = settings('ancillaries');

	$settings_plans = settings('plans');
	$settings_entry = settings('entry');
	$settings_trading = settings('trading');

	$app = application();

	$user = user($user_id);

	$entry = $settings_entry->{$type . '_entry'};

	if ((double) $user->payout_transfer <= 0 && (double) $user->balance_fmc <= 0) {
		$err = 'Empty balance!';
		$app->redirect(Uri::root(true) . '/' . sef(10), $err, 'error');
	}

	// start: check if user has enough efund to buy the package
	if ($user->payout_transfer < $entry && (!$settings_plans->trading && $method === 'efund')) {
		$err = 'Not enough ' . $sa->efund_name . '!';
		$app->redirect(Uri::root(true) . '/' . sef(10), $err, 'error');
	}
	// end: check if user has enough efund to buy the package

	if (
		$admintype === 'Super' &&
		session_get('edit', false) === true &&
		input_get('date', '', 'RAW') === ''
	) {
		$err = 'Please specify your Activation Date!';
		$app->redirect(Uri::root(true) . '/' . sef(10), $err, 'error');
	}

	if ($type === 'none') {
		$err = 'Select any package!';
		$app->redirect(Uri::root(true) . '/' . sef(10), $err, 'error');
	}

	if ($method === 'none' && $settings_plans->trading) {
		$err = 'Select any method!';
		$app->redirect(Uri::root(true) . '/' . sef(10), $err, 'error');
	}

	if (
		$method === 'token' && $settings_plans->trading &&
		$user->balance_fmc < ($entry * usdt_currency() * $settings_trading->fmc_to_usd)
	) {
		$err = 'Not enough ' . $settings_trading->token_name . '!';
		$app->redirect(Uri::root(true) . '/' . sef(10), $err, 'error');
	}
}

/**
 * @param $user_id
 * @param $admintype
 * @param $type
 * @param $method
 * @param $final
 * @param $upline
 * @param $position
 * @param $edit
 *
 * @return string
 *
 * @since version
 */
function buy_package($user_id, $admintype, $type, $method, $final, $upline, $position, $edit): string
{
	validate_input($user_id, $admintype, $type, $method);

	$str = '';

	if ((int) $final !== 1) {
		$str .= view_form_confirm($user_id, $type, $method);
	} else {
		process_buy($user_id, $admintype, $type, $method, $upline, $position, $edit);
	}

	return $str;
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
 * @param $admintype
 * @param $type
 * @param $method
 * @param $upline
 * @param $position
 * @param $edit
 *
 * @since version
 */
function process_buy($user_id, $admintype, $type, $method, $upline, $position, $edit)
{
	$app = application();

	//	has_internet(/*false*/) or $app->redirect(Uri::root(true) .
//		'/' . sef(10), 'Abnormal Network Connection!', 'error');

	Session::checkToken() or $app->redirect(Uri::root(true) .
		'/' . sef(10), 'Invalid Transaction!', 'error');

	$db = db();

	$user = user($user_id);
	$sponsor = user($user->sponsor_id)->username;

	validate_binary($upline, $position, $type, 'activate');
	binary_validated($user_id, $user->username, $sponsor, $upline, $position, $type, 'activate');

	$sa = settings('ancillaries');
	$se = settings('entry');

	$code_type_mod = $se->{$type . '_package_name'};

	$user = user($user_id);

	$username = $user->username;
	$email = $user->email;
	$sponsor_id = $user->sponsor_id;

	$sponsor = user($sponsor_id);

	$sponsor_name = $sponsor->username;

	$body = 'Username: ' . $username . ($email !== '' ? ('<br>
	Email: ' . $email) : '') . '<br>
	Sponsor Username: ' . $sponsor_name . '<br>' . '
	Account Type: ' . ucfirst($code_type_mod);

	$message_admin = 'A new ' . $code_type_mod . ' member has been ' .
		($sa->payment_mode === 'CODE' ? 'registered' : 'activated') . '.<br>
	<hr>' . $body;

	$message_user = 'Congratulations on your successful ' . $code_type_mod . ' ' .
		($sa->payment_mode === 'CODE' ? 'registration' : 'activation') . '!<br><hr>' . $body;

	try {
		$db->transactionStart();

		if (update_users($user_id, $admintype, $type, $method, $edit)) {
			logs($user_id, $type, $admintype, $edit);
		}

		$date = input_get_date();

		$sponsor = user($user->sponsor_id)->username;

		process_plans($user_id, $type, $username, $sponsor, $date, 'activate');

		send_mail($message_admin, 'A New Member has been ' .
			($sa->payment_mode === 'CODE' ? 'Registered' : 'Activated') . '!');

		if ($email !== '') {
			send_mail($message_user, 'Activation Successful!', [$email]);
		}

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	//	send_mail($user_id, $type);

	$app->redirect(Uri::root(true) . '/' . sef(41), $username .
		'\'s ' . ucfirst(settings('entry')->{$type . '_package_name'}) . ' ' .
		(settings('ancillaries')->payment_mode === 'CODE' ? 'Registration' : 'Activation') .
		' Successful!', 'success');
}

function validate_binary($upline, $position, string $account_type_new = 'starter', string $prov = 'code')
{
	if (settings('plans')->binary_pair) {
		$app = application();

		$user_upline = username_upline($upline);

		$upline_id = $user_upline->u_id;

		$register = (($account_type_new !== 'starter' && $prov === 'code'));

		$sef = $register ? 65 : 10;

		if ($upline === '') {
			$err = 'Please specify your Upline.<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		$user_upline = username_upline($upline);

		if (empty($user_upline)) {
			$err = 'Invalid Upline!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		if (count(binary_downlines($upline_id)) >= 2) {
			$err = 'Invalid Upline Username!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		$username_paid = user_username_paid($upline);

		if (empty($username_paid)) {
			$err = 'Invalid Upline!<br>';
			$app->redirect(Uri::root(true) . '/' . sef($sef), $err, 'error');
		}

		if (
			has_position($upline_id, $position) ||
			(!empty($username_paid) && !empty(user_binary_active($username_paid->id, $position)))
		) {
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
 * @param $user_id
 * @param $admintype
 * @param $type
 * @param $method
 * @param $edit
 *
 * @return false|mixed
 * @since version
 */
function update_users($user_id, $admintype, $type, $method, $edit)
{
	$db = db();

	$entry = settings('entry')->{$type . '_entry'};

	if ($edit === true && $admintype === 'Super') {
		$date = input_get('date', time(), 'RAW');
	}

	$fields = [
		($method !== 'token' ? ('payout_transfer = payout_transfer - ' .
			$entry) : ('balance_fmc = balance_fmc - ' .
			($entry * usdt_currency() * settings('trading')->fmc_to_usd))),
		'account_type = ' . $db->quote($type),
		'date_activated = ' . ($edit && isset($date) ? $db->quote($date) : $db->quote(time()))
	];

	$type_token = settings('trading')->{$type . '_fmc'};

	if ($type_token > 0 && settings('plans')->trading) {
		$fields[] = 'balance_fmc = balance_fmc + ' . $type_token;

		update(
			'network_fmc',
			['balance = balance - ' . $type_token]
		);
	}

	return update(
		'network_users',
		$fields,
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $usertype
 * @param $account_type
 *
 *
 * @since version
 */
function page_validate($usertype, $account_type)
{
	if (
		$usertype === '' ||
		$account_type !== 'starter' ||
		settings('ancillaries')->payment_mode !== 'ECASH'
	) {
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $method
 *
 * @return string
 *
 * @since version
 */
function view_form_confirm($user_id, $type, $method): string
{
	$sa = settings('ancillaries');

	$settings_plans = settings('plans');
	$settings_trading = settings('trading');

	$currency = settings('ancillaries')->currency;
	$entry = settings('entry')->{$type . '_entry'};

	$user = user($user_id);

	$str = '<form method="post" onsubmit="submit.disabled = true; return true;">
            <input type="hidden" name="final" value="1">
            <input type="hidden" name="type" value="' . $type . '">
            <input type="hidden" name="method" value="' . ($settings_plans->trading ? $method : 'efund') . '">         
            <p><strong style="font-size: large">Confirm Activation</strong></p>
            <table class="category table table-striped table-bordered table-hover">';

	if ($method === 'token') {
		$str .= '<tr>
                <td>Token:</td>
                <td>' . number_format($user->balance_fmc, 8) . ' ' . $settings_trading->token_name . '</td>
            </tr>';
	} else {
		$str .= '<tr>
                <td>' . $sa->efund_name . ':</td>
                <td>' . number_format($user->payout_transfer, 8) . ' ' . $currency . '</td>
            </tr>';
	}

	$str .= '<tr>
            <td style="width: 200px">Package Selected:</td>
            <td>' . $type . '</td>
        </tr>
        <tr>
            <td>Package Price:</td>
            <td>' . number_format($entry, 8) . ' ' . $currency . '</td>
        </tr>';

	if ($settings_plans->trading) {
		$str .= '<tr>
                    <td>Method:</td>
                    <td>' . $method . '</td>
                </tr>';
	}

	if (/*settings('binary')->{$type . '_pairs'} > 0 &&*/
		settings('plans')->binary_pair/* &&
empty(user_plan($user_id, 'binary'))*/
	) {
		$str .= '<tr>
            <td><label for="upline">Upline Username: *</label></td>
            <td><input type="text"
                       name="upline"
                       id="upline"
                       value="' . /*get_upline($user_id) .*/
			'"
                       size="40"                       
                       required="required"
                       style="float:left">
                <a href="javascript:void(0)" onClick="checkInput(\'upline\')" class="uk-button uk-button-primary" 
                style="float:left">Verify</a>
                <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
                     id="uplineDiv"></div>
            </td>
        </tr>
        <tr>
            <td><label for="position">Position:</label></td>
            <td>
                <select name="position" id="position" style="float:left">' .
			/*option_position(get_upline($user_id)) .*/
			'
                    <option value="Left">Left</option>
                    <option value="Right">Right</option>
                </select>
                <a href="javascript:void(0)" onClick="checkPosition(\'upline\', \'position\')" class="uk-button uk-button-primary" 
                style="float:left">Verify</a>
        <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
             id="positionDiv"></div>
        </td>
        </tr>';
	}

	$str .= '</table>' . HTMLHelper::_('form.token') .
		'<input type="submit" value="Confirm" name="submit" class="uk-button uk-button-primary">
            <a href="' . sef(10) . '" class="uk-button uk-button-primary">Cancel</a>
        </form>';

	$str .= check_input();
	$str .= check_position();

	return $str;
}

/**
 * @param $user_id
 * @param $type
 * @param $admintype
 *
 * @param $edit
 *
 * @since version
 */
function logs($user_id, $type, $admintype, $edit)
{
	$db = db();

	$date = time();

	if ($edit === true && $admintype === 'Super') {
		$date = input_get('date');
	}

	$settings_entry = settings('entry');

	$code_type_mod = $settings_entry->{$type . '_package_name'};

	$user = user($user_id);

	$username = $user->username;
	$sponsor_id = $user->sponsor_id;

	$sponsor_name = user($sponsor_id)->username;

	// activity
	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($sponsor_id),
			$db->quote('<b>' . ($code_type_mod) . ' Activation: </b><a href="' . sef(44) . qs() .
				'uid=' . $user_id . '">' . $username . '</a>, sponsored by <a href="' .
				sef(44) . qs() . 'uid=' . $sponsor_id . '">' . $sponsor_name . '</a>.'),
			($edit ? $db->quote($date) : $db->quote(time()))
		]
	);

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
			$db->quote($user_id),
			$db->quote('Account Activation'),
			$db->quote('<b>' . ($code_type_mod) . ' Activation: </b><a href="' . sef(44) . qs() .
				'uid=' . $user_id . '">' . $username . '</a>, sponsored by <a href="' .
				sef(44) . qs() . 'uid=' . $sponsor_id . '">' . $sponsor_name . '</a>.'),
			$db->quote($settings_entry->{$type . '_entry'}),
			$db->quote(0),
			($edit ? $db->quote($date) : $db->quote(time()))
		]
	);
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
 * @param $user_id
 * @param $code_type
 *
 * @since version
 */
function process_direct_referral($user_id, $code_type)
{
	$Settings_plans = settings('plans');
	$settings_referral = settings('referral');

	$bonus = $settings_referral->{$code_type . '_referral'};

	$sponsor_id = user($user_id)->sponsor_id;

	$db = db();

	if ($Settings_plans->direct_referral || $Settings_plans->binary_pair) {
		// direct_referral($user_id, $code_type, $username, $sponsor, $date, $prov);
		update(
			'network_users',
			[
				'payout_transfer = payout_transfer + ' . $bonus,
				//'income_cycle_global = income_cycle_global + ' . $sponsor_referral_add,
				'income_referral = income_referral + ' . $bonus
			],
			['id = ' . $db->quote($sponsor_id)]
		);
	}
}

/**
 * @param $insert_id
 * @param $code_type
 *
 * @since version
 */
function process_indirect_referral($insert_id, $code_type)
{
	$username = input_get('username');
	$sponsor = input_get('sponsor');

	$edit = session_get('edit');

	$settings_plans = settings('plans');
	$settings_indirect = settings('indirect_referral');
	$settings_entry = settings('entry');

	$indirect_referral_level = $settings_indirect->{$code_type . '_indirect_referral_level'};

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor)) {
		$sponsor_id = $user_sponsor[0]->id;
	}

	$date = input_get_date();

	$db = db();

	if (
		$indirect_referral_level &&
		$settings_plans->indirect_referral
	) {
		insert(
			'network_indirect',
			['id', 'user_id'],
			[$db->quote($insert_id), $db->quote($insert_id)]
		);

		$activity = '<b>' . ucwords($settings_plans->indirect_referral_name) . ' Entry: </b> <a href="' .
			sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
			ucwords($settings_plans->indirect_referral_name) . ' upon ' .
			ucfirst($settings_entry->{$code_type . '_package_name'}) . ' Sign Up.';

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
				($edit === true && (int) $date !== 0 ? $db->quote($date) : $db->quote(time()))
			]
		);

		indirect_referral();
	}
}

/**
 * @param $insert_id
 * @param $code_type
 *
 * @since version
 */
function process_echelon_bonus($insert_id, $code_type)
{
	$username = input_get('username');
	$sponsor = input_get('sponsor');

	$edit = session_get('edit');

	$settings_plans = settings('plans');
	$settings_echelon = settings('echelon');
	$settings_entry = settings('entry');

	$echelon_level = $settings_echelon->{$code_type . '_echelon_level'};

	$sponsor_id = '';

	$user_sponsor = user_username($sponsor);

	if (!empty($user_sponsor)) {
		$sponsor_id = $user_sponsor[0]->id;
	}

	$date = input_get_date();

	$db = db();

	if (
		$echelon_level &&
		$settings_plans->echelon
	) {
		insert(
			'network_echelon',
			['id', 'user_id'],
			[$db->quote($insert_id), $db->quote($insert_id)]
		);

		$activity = '<b>' . ucwords($settings_plans->echelon_name) . ' Entry: </b> <a href="' .
			sef(44) . qs() . 'uid=' . $insert_id . '">' . $username . '</a> has entered into ' .
			ucwords($settings_plans->echelon_name) . ' upon ' .
			ucfirst($settings_entry->{$code_type . '_package_name'}) . ' Activation.';

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
				($edit === true && (int) $date !== 0 ? $db->quote($date) : $db->quote(time()))
			]
		);

		// indirect_referral();
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
	if (settings('plans')->passup) {
		passup($insert_id, $code_type, $entry_name, user_username($sponsor)->id);
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $date
 *
 * @return void
 *
 * @since version
 */
//function logs_indirect_referral($user_id, $type, $date)
//{
//	$db = db();
//
//	$settings_plans = settings('plans');
//
//	$user = user($user_id);
//
//	insert(
//		'network_activity',
//		[
//			'user_id',
//			'sponsor_id',
//			'activity',
//			'activity_date'
//		],
//		[
//			$db->quote($user_id),
//			$db->quote($user->sponsor_id),
//			$db->quote('<b>' . $settings_plans->indirect_referral_name . ' Entry: </b> <a href="' .
//				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> has entered into ' .
//				$settings_plans->indirect_referral_name . ' upon ' .
//				ucfirst(settings('entry')->{$type . '_package_name'}) . ' activation.'),
//			$db->quote($date)
//		]
//	);
//}

/**
 * @param $user_id
 * @param $type
 *
 * @since version
 */
function process_compound_daily($user_id, $type)
{
	$db = db();

	$settings_investment = settings('investment');

	// compound interest daily
	if (
		$settings_investment->{$type . '_principal'} > 0 &&
		empty(user_plan($user_id, 'compound'))
	) {
		$compound_daily_insert = insert(
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
				$db->quote($user_id),
				0,
				0,
				0,
				$db->quote($settings_investment->{$type . '_processing'}),
				$db->quote($settings_investment->{$type . '_maturity'})
			]
		);

		if ($compound_daily_insert) {
			logs_compound_daily($user_id, $type);
		}
	}
}

/**
 * @param $user_id
 * @param $type
 *
 * @since version
 */
function logs_compound_daily($user_id, $type)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($user->sponsor_id),
			$db->quote(
				'<b>' . $settings_plans->etrade_name . ' Entry: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username .
				'</a> has entered into ' . $settings_plans->etrade_name . ' upon ' .
				ucfirst(settings('entry')->{$type . '_package_name'}) . ' activation.'
			),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $type
 *
 * @since version
 */
function process_fixed_daily($user_id, $type)
{
	$db = db();

	$settings_investment = settings('investment');

	// fixed interest daily
	if (
		$settings_investment->{$type . '_fixed_daily_principal'} > 0 &&
		empty(user_plan($user_id, 'fixed_daily'))
	) {
		$fixed_daily_insert = insert(
			'network_fixed_daily',
			[
				'user_id',
				'time_last',
				'value_last',
				'day',
				'processing'
			],
			[
				$db->quote($user_id),
				0,
				0,
				0,
				$db->quote($settings_investment->{$type . '_fixed_daily_processing'})
			]
		);

		if ($fixed_daily_insert) {
			logs_fixed_daily($user_id, $type);
		}
	}
}

/**
 * @param $user_id
 * @param $type
 *
 * @since version
 */
function logs_fixed_daily($user_id, $type)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($user->sponsor_id),
			$db->quote('<b>' . $settings_plans->fixed_daily_name . ' Entry: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username .
				'</a> has entered into ' . $settings_plans->fixed_daily_name . ' upon ' .
				ucfirst(settings('entry')->{$type . '_package_name'}) . ' activation.'),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $type
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 * @since version
 */
function process_leadership_passive($user_id, $type, $username, $sponsor, $date, $prov)
{
	if (
		settings('plans')->leadership_passive &&
		settings('leadership_passive')->{$type . '_leadership_passive_level'} &&
		empty(user_plan($user_id, 'leadership_passive'))
	) {
		insert_leadership_passive($user_id, $type, $username, $sponsor, $date, $prov);
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $date
 * @param $prov
 *
 * @since version
 */
function process_unilevel($user_id, $type, $date, $prov)
{
	if (
		settings('plans')->unilevel &&
		settings('unilevel')->{$type . '_unilevel_level'}
	) {
		$user = user($user_id);

		$username = $user->username;
		$sponsor = user($user->sponsor_id)->username;

		insert_unilevel($user_id, $type, $username, $sponsor, $date, $prov);

		//        logs_unilevel($user_id, $type, $date);
	}
}

/**
 * @param $prov
 *
 * @return string
 *
 * @since version
 */
function source($prov): string
{
	$source = ' Sign Up';

	if ($prov === 'activate') {
		$source = ' Activation';
	} elseif ($prov === 'upgrade') {
		$source = ' Upgrade';
	}

	return $source;
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function process_binary($user_id)
{
	if (settings('plans')->binary_pair) {
		binary_package($user_id, 'activate');
	}
}

//function username_upline($username)
//{
//    $db = db();
//
//    return $db->setQuery(
//        'SELECT u.id as u_id, ' .
//        'downline_left_id, ' .
//        'downline_right_id ' .
//        'FROM network_users u ' .
//        'INNER JOIN network_binary b ' .
//        'ON u.id = b.user_id ' .
//        'WHERE u.username = ' . $db->quote($username) .
//        ' AND u.account_type <> ' . $db->quote('starter')
//    )->loadObject();
//}

/**
 * @param $user_id
 *
 * @param $type
 *
 * @since version
 */
function process_leadership_binary($user_id, $type)
{
	$settings_leadership = settings('leadership');
	$settings_plans = settings('plans');

	$type_level = $settings_leadership->{$type . '_leadership_level'};

	if ($type_level > 0 && $settings_plans->leadership_binary) {
		if (empty(user_plan($user_id, 'leadership'))) {
			insert(
				'network_leadership',
				['user_id'],
				[db()->quote($user_id)]
			);

			//			logs_indirect_referral($user_id, $type, $date);
		}

		leadership_binary(/*$user_id, 'upgrade'*/);
	}
}

/**
 *
 *
 * @since version
 */
//function process_harvest()
//{
//	if (settings('plans')->harvest)
//	{
//		harvest();
//	}
//}

/**
 * @param $user_id
 *
 *
 * @since version
 */
//function process_royalty($user_id)
//{
//	// royalty bonus
//	if (settings('plans')->royalty)
//	{
//		royalty_bonus($user_id, 0);
//	}
//}

/**
 * @param $user_id
 *
 *
 * @since version
 */
//function process_passup($user_id)
//{
//	// passup bonus
//	if (settings('plans')->passup)
//	{
//		passup_bonus($user_id);
//	}
//}

/**
 * @param $user_id
 *
 *
 * @since version
 */
//function process_elite_reward($user_id)
//{
//	// elite reward
//	if (settings('plans')->elite_reward)
//	{
//		elite_bonus($user_id, 0);
//	}
//}

/**
 * @param $user_id
 * @param $type
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 * @since version
 */
function process_plans($user_id, $type, $username, $sponsor, $date, $prov)
{
	process_direct_referral($user_id, $type);
	process_indirect_referral($user_id, $type);
	process_passup($user_id, $type, $username, $sponsor);
	process_binary($user_id);

	// test disable
	process_leadership_binary($user_id, $type);
	process_unilevel($user_id, $type, $date, $prov);
	//
//	process_harvest();
//	process_royalty($user_id);
//	process_passup($user_id);
//	process_elite_reward($user_id);

	process_echelon_bonus($user_id, $type);

	process_compound_daily($user_id, $type);
	process_fixed_daily($user_id, $type);
	process_leadership_passive($user_id, $type, $username, $sponsor, $date, $prov);
}

/**
 *
 * @return int|string
 *
 * @since version
 */
function input_get_date()
{
	$edit = session_get('edit', false);
	$admintype = session_get('admintype', false);

	$date = 0;

	if ($edit && $admintype === 'Super') {
		$date = input_get('date', '', 'RAW');
	}

	return $date;
}