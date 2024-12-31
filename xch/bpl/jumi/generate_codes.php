<?php

namespace BPL\Jumi\Generate_Codes;

require_once 'bpl/mods/code_generate.php';
require_once 'bpl/ajax/ajaxer/code_validate.php';
require_once 'bpl/mods/account_options.php';
require_once 'bpl/menu.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Codes_Generate\main as code_generate;

use function BPL\Ajax\Ajaxer\Code_Validate\main as code_validate;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Options_Account\main as account_options;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Url_SEF\sef;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$username      = session_get('username');
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
//	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');
	$amount        = input_get('amount', '0');
	$type          = input_get('type', 'none', 'RAW');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	if ($amount === '0' || $type === '')
	{
		$str .= view_form($account_type, $admintype, $user_id);
	}
	else
	{
		validate_user($user_id, $admintype, $type, $amount);

		code_generate($amount, $type, $user_id);

		$message = $amount . ' ' . $type . ' registration codes generated.';

		send_mail($message, 'Registration Codes Generated Successfully!');
	}

	echo $str;
}

function validate_user($user_id, $admintype, $type, $amount)
{
	$se = settings('entry');

	$user = user($user_id);

//	$usertype = $user->usertype;

	$efund = $user->payout_transfer;

	$price = $se->{$type . '_entry'};

	$total = $price * $amount;

	if ($admintype !== 'Super' && $efund < $total)
	{
		$error = 'Insufficient Funds!';

		application()->redirect(URI::root(true) . '/' . sef(34), $error, 'error');
	}
}

/**
 *
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

	switch ($usertype)
	{
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
 *
 * @return string
 *
 * @since version
 */
function row_select_count(): string
{
	$str = '<tr>
                <td style="width: 150px"><label for="amount">Number of Codes:</label></td>
                <td>';
	$str .= '<select name="amount" id="amount" style="float: left">';

	for ($ctr = 0; $ctr <= 100; $ctr++)
	{
		$str .= $ctr === 0 ? '<option value="' . $ctr . '">Select number</option>' :
			'<option value="' . $ctr . '">' . $ctr . '</option>';
	}

	$str .= '</select>';

	$str .= '<div><span id="error_number_codes" style="width:330px; height:21px; font-weight:bold; 
    				float:left; padding:7px 0 0 10px; color: red"></span></div>
                </td>
            </tr>';

	return $str;
}

/**
 * @param $account_type
 * @param $admintype
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($account_type, $admintype, $user_id): string
{
	$str = '<h1>Generate Codes</h1>
	    <form method="post">
	        <table class="category table table-striped table-bordered table-hover">';

	$str .= row_select_count();

	$str .= '<tr>
                <td><label for="type">Code Type:</label></td>
                <td>
                    <select name="type" id="type" style="float: left">
                        <option value="none" selected>Select type</option>';

	$str .= account_options($account_type, $admintype);

	if (settings('ancillaries')->cd_mode === 'cd')
	{
		$str .= account_options($account_type, $admintype, 'cd');
	}

	$str .= '</select>
	    <div>
	        <span id="error_code_type" style="width:330px; height:21px; font-weight:bold; 
	            float:left; padding:7px 0 0 10px; color: orangered"></span>
	    </div>
	    </td>
	    </tr>';

	$str .= '<tr>
	        <td colspan="2">
	            <div style="text-align: center">
	                <input type="submit" value="Generate Codes" name="submit" id="code_generate"
	                       class="uk-button uk-button-primary">
	            </div>
	        </td>
	    </tr>
	    </table>
	    </form>';

	$str .= code_validate($user_id);

	return $str;
}