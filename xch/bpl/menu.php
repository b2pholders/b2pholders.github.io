<?php

namespace BPL\Menu;

require_once 'bpl/mods/url_sef.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\session_get;

/**
 * @param $user_id
 * @param $type
 *
 * @return array|mixed
 *
 * @since version
 */
function user_harvest($user_id, $type)
{
	$db = db();

	return $db->setQuery(
		'SELECT id ' .
		'FROM network_harvest_' . $type .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary ' .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $type
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_share($type, $user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_share_' . $type .
		' WHERE user_id = ' . $db->quote($user_id) .
		' AND is_active = ' . $db->quote(1) .
		' AND has_mature = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $account_type
 * @param $user_id
 *
 * @return bool
 *
 * @since version
 */
function has_user_share($account_type, $user_id): bool
{
	return count(user_share($account_type, $user_id)) === 1;
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function home_admin($admintype): string
{
	// home: start
	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
                <a href="' . sef(43) . '" class="uk-button" style="width: 80%;">Home</a>
                <div class="" data-uk-dropdown="{mode:\'click\'}">
                    <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                    <div style="" class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="' . sef(79) . '">Sales Overview</a></li>
                            <li><a href="' . sef(1) . '">Account Summary</a></li>
                            <li><a href="' . sef(2) . '">Active Income</a></li>';
	$str .= $admintype === 'Super' ? '<li><a href="' . sef(97) . '">System Reset</a></li>' : '';
	$str .= '</ul>
                    </div>
                </div>
            </div>';

	// home: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function home_member(): string
{
	return '<div class="uk-button-group"  style="display: block; width: 100%; margin-bottom: 10px;"><a href="' .
		sef(43) . '" class="uk-button" style="width: 93%;">Home</a></div>';
}

function signup_member($account_type): string
{
	// home: start
	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
                    <a href="javascript:" class="uk-button" style="width: 80%;">Account</a>
                    <div class="" data-uk-dropdown="{mode:\'click\'}">
                        <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                        <div style="" class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(settings('ancillaries')->payment_mode === 'CODE' ? 65
		: 144) . '">Add Account</a></li>';
	//	$str .= ($account_type !== 'starter' && 0 ? '<li><a href="' . sef(1) . '">Account Summary</a></li>' : '');
//	$str .= ($account_type !== 'starter' ? '<li><a href="' . sef(2) . '">Dashboard</a></li>' : '');
//	$str .= '<li><a href="' . sef(2) . '">Profit Chart</a></li>';
	$str .= (($account_type !== 'executive'
		&& $account_type !== 'starter') ? '<li><a href="' . sef(110) . '">Upgrade</a></li>' : '');
	$str .= '</ul>
                        </div>
                    </div>
                </div>';

	// home: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function home_manager(): string
{
	// home: start
	return '<div class="uk-button-group" style="background-color: padding: 5px">
                <a href="' . sef(43) . '" class="uk-button uk-button-primary">Home</a>
                <div class="" data-uk-dropdown="{mode:\'click\'}">
                    <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
                    <div style="" class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="' . sef(41) . '">Log out</a></li>
                        </ul>
                    </div>
                </div>
            </div>';
	// home: end
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function members_admin($admintype): string
{
	// members: start
	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">Members</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">
                    <li><a href="' . sef(40) . '">List Members</a></li>
                    <li><a href="' . sef(settings('ancillaries')->payment_mode === 'CODE' ? 65
		: 144) . '">Registration</a></li>
                    <li><a href="' . sef(44) . '">Member Info</a></li>';
	$str .= '<li><a href="' . sef(60) . '">Profile Update</a></li>';
	$str .= ($admintype === 'Super' ? '<li><a href="' . sef(6) . '">Admin Account Update</a></li>' : '');
	$str .= '</ul>
            </div>
        </div>
    </div>';

	// members: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function members_manager(): string
{
	// members: start
	return '<div class="uk-button-group" style="background-color: padding: 5px">
                <button class="uk-button uk-button-primary">Members</button>
                <div class="" data-uk-dropdown="{mode:\'click\'}">
                    <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
                    <div style="" class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="' . sef(40) . '">List Members</a></li>
                            <li><a href="' . sef(settings('ancillaries')->payment_mode === 'CODE' ? 65
		: 144) . '">Registration</a></li>
                        </ul>
                    </div>
                </div>
            </div>';
	// members: end
}

/**
 *
 * @return string
 *
 * @since version
 */
function codes(): string
{
	$admintype = session_get('admintype');

	$str = '';

	// codes: start
	if (settings('ancillaries')->payment_mode === 'CODE'/* && $admintype === 'Super'*/) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">Codes</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">
                    <li><a href="' . sef(66) . '">Available</a></li>
                    <li><a href="' . sef(68) . '">Used</a></li>
                    <li><a href="' . sef(67) . '">Inventory</a></li>';
		$str .= (($admintype === 'Super') ? '<li><a href="' . sef(7) . '">Inventory Admin</a></li>' : '');
		//		$str .= '<li><a href="' . sef(7) . '">Inventory Admin</a></li>';
		$str .= '<li><a href="' . sef(42) . '">Lookup</a></li>
	                    <li><a href="' . sef(34) . '">Generate</a></li>
	                </ul>
	            </div>
	        </div>
	    </div>';
	}

	// codes: end

	return $str;
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function buy_package($account_type): string
{
	// buy pack: start
	return ($account_type === 'starter' &&
		settings('ancillaries')->payment_mode === 'ECASH' ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <a href="' . sef(10) . '" class="uk-button" style="width: 93%;">Buy Account</a></div>' : '');
	// buy pack: end
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function logs_admin($admintype): string
{
	// logs: start
	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">Logs</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
	$str .= (($admintype === 'Super') ? '<li><a href="' . sef(3) . '">Activity</a></li>' : '');
	$str .= '<li><a href="' . sef(106) . '">Transactions</a></li>';
	$str .= (($admintype === 'Super') ? '<li><a href="' . sef(35) . '">Income Log</a></li>' : '');
	$str .= '</ul>
            </div>
        </div>
    </div>';

	// logs: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function logs_manager(): string
{
	// logs: start
	return '<div class="uk-button-group" style="background-color: padding: 5px">
                <button class="uk-button uk-button-primary">Logs</button>
                <div class="" data-uk-dropdown="{mode:\'click\'}">
                    <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
                    <div style="" class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="' . sef(3) . '">Activity</a></li>
                            <li><a href="' . sef(111) . '">Withdrawal Completed</a></li>
                        </ul>
                    </div>
                </div>
            </div>';
	// logs: end
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function efund_admin($admintype): string
{
	$sa = settings('ancillaries');
	$efund_name = $sa->efund_name;

	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">';
	$str .= '<button class="uk-button" style="width: 80%;">' . /*$efund_name*/
		'Finance' . '</button>';
	$str .= '<div class="" data-uk-dropdown="{mode:\'click\'}">';
	$str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
	$str .= '<div style="" class="uk-dropdown uk-dropdown-small">';
	$str .= '<ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(73) . '">Buy ' . $efund_name . '</a></li>';
	$str .= '<li><a href="' . sef(74) . '">Buy ' . $efund_name . ' Confirmed</a></li>';
	$str .= $admintype === 'Super' || 1 ? '<li><a href="' . sef(76) . '">Buy ' .
		$efund_name . ' Pending</a></li>' : '';
	$str .= $admintype === 'Super' || 1 ? '<li><a href="' . sef(4) . '">Add ' . $efund_name . '</a></li>' : '';
	$str .= '<li><a href="' . sef(16) . '">' . $efund_name . ' Transfer</a></li>';
	$str .= '<li><a href="' . sef(75) . '">Buy ' . $efund_name . ' Logs</a></li>';
	$str .= '<li><a href="' . sef(57) . '">Withdraw ' . $efund_name . '</a></li>';
	$str .= $admintype === 'Super' || 1 ? '<li><a href="' . sef(58) . '">Pending ' .
		$efund_name . ' Withdrawals</a></li>' : '';
	$str .= '<li><a href="' . sef(59) . '">Approved ' . $efund_name . ' Withdrawals</a></li>';
	$str .= '<li><a href="' . sef(122) . '">' . $efund_name . ' Withdrawal Logs</a></li>';
	$str .= '</ul>
            </div>	
        </div>
    </div>';

	return $str;
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function share_fund_admin($admintype): string
{
	$sa = settings('ancillaries');
	$share_fund_name = $sa->share_fund_name;

	$str = '<div class="uk-button-group" style="padding-right: 5px">';
	$str .= '<button class="uk-button">' . $share_fund_name . '</button>';
	$str .= '<div class="" data-uk-dropdown="{mode:\'click\'}">';
	$str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
	$str .= '<div style="" class="uk-dropdown uk-dropdown-small">';
	$str .= '<ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(135) . '">Request ' . $share_fund_name . '</a></li>';
	$str .= '<li><a href="' . sef(136) . '">Request ' . $share_fund_name . ' Confirmed</a></li>';
	$str .= $admintype === 'Super' || 1 ? '<li><a href="' . sef(138) . '">Request ' .
		$share_fund_name . ' Pending</a></li>' : '';
	$str .= '<li><a href="' . sef(134) . '">' . $share_fund_name . ' Transfer</a></li>';
	$str .= '<li><a href="' . sef(137) . '">Request ' . $share_fund_name . ' Logs</a></li>';
	$str .= '</ul>
            </div>	
        </div>
    </div>';

	return $str;
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function loan_admin($admintype): string
{
	$sa = settings('ancillaries');
	$loan_fund_name = $sa->loan_fund_name;

	$str = '<div class="uk-button-group" style="padding-right: 5px">';
	$str .= '<button class="uk-button">' . $loan_fund_name . '</button>';
	$str .= '<div class="" data-uk-dropdown="{mode:\'click\'}">';
	$str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
	$str .= '<div style="" class="uk-dropdown uk-dropdown-small">';
	$str .= '<ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(140) . '">Request ' . $loan_fund_name . '</a></li>';
	$str .= '<li><a href="' . sef(141) . '">Request ' . $loan_fund_name . ' Confirmed</a></li>';
	$str .= $admintype === 'Super' || 1 ? '<li><a href="' . sef(143) . '">Request ' .
		$loan_fund_name . ' Pending</a></li>' : '';
	$str .= '<li><a href="' . sef(139) . '">' . $loan_fund_name . ' Transfer</a></li>';
	$str .= '<li><a href="' . sef(142) . '">Request ' . $loan_fund_name . ' Logs</a></li>';
	$str .= '</ul>
            </div>	
        </div>
    </div>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function efund_member($user_id): string
{
	$sa = settings('ancillaries');
	//	$efund_name = $sa->efund_name;

	$account_type = user($user_id)->account_type;

	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">' . /*$efund_name*/
		'B2P Wallet' . '</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(16) . '">' . /*$efund_name .*/
		' Transfer B2P</a></li>';
	$str .= '<li><a href="' . sef(73) . '">Load B2P ' . /*$efund_name .*/
		'</a></li>';
	$str .= '<li><a href="' . sef(74) . '">' . /*$efund_name .*/
		'B2P Request History</a></li>';
	$str .= '<li><a href="' . sef(75) . '">Load ' . /*$efund_name .*/
		' Logs</a></li>';

	if ($account_type !== 'starter') {
		$str .= '<li><a href="' . sef(57) . '">Withdraw B2P ' . /*$efund_name .*/
			'</a></li>';
		$str .= '<li><a href="' . sef(59) . '">' . /*$efund_name .*/
			' Withdrawal History</a></li>';
		$str .= '<li><a href="' . sef(122) . '">' . /*$efund_name .*/
			' Withdrawal Logs</a></li>';
	}

	$str .= '</ul>
            </div>
        </div>
    </div>';

	// efund request: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function share_fund_member(): string
{
	$sa = settings('ancillaries');
	$share_fund_name = $sa->share_fund_name;

	$str = '<div class="uk-button-group" style="padding-right: 5px">
        <button class="uk-button">' . $share_fund_name . '</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(134) . '">' . $share_fund_name . ' Transfer</a></li>';
	$str .= '<li><a href="' . sef(135) . '">Request ' . $share_fund_name . '</a></li>';
	$str .= '<li><a href="' . sef(136) . '">' . $share_fund_name . ' Transactions</a></li>';
	$str .= '</ul>
            </div>
        </div>
    </div>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function loan_member(): string
{
	$sa = settings('ancillaries');
	$loan_fund_name = $sa->loan_fund_name;

	$str = '<div class="uk-button-group" style="padding-right: 5px">
        <button class="uk-button">' . $loan_fund_name . '</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
	$str .= '<li><a href="' . sef(139) . '">' . $loan_fund_name . ' Transfer</a></li>';
	$str .= '<li><a href="' . sef(140) . '">Request ' . $loan_fund_name . '</a></li>';
	$str .= '<li><a href="' . sef(141) . '">' . $loan_fund_name . ' Transactions</a></li>';
	$str .= '</ul>
            </div>
        </div>
    </div>';

	return $str;
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function wallet_admin($admintype): string
{
	$str = '';

	// my wallet: start
	if (settings('ancillaries')->withdrawal_mode === 'standard') {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">My Wallet</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
		$str .= $admintype === 'Super' ?
			'<li><a href="' . sef(116) . '">Add eCash</a></li>' : '';
		$str .= '<li><a href="' . sef(15) . '">Convert to Efund</a></li>';
		$str .= '<li><a href="' . sef(113) . '">Withdrawal Request</a></li>';
		$str .= '<li><a href="' . sef(112) . '">Withdrawal Confirm</a></li>';
		$str .= '<li><a href="' . sef(111) . '">Withdrawal Completed</a></li>';
		$str .= '<li><a href="' . sef(49) . '">Payout Log</a></li>';
		$str .= '</ul>
	            </div>
	        </div>
	    </div>';
	}

	// my wallet: end

	return $str;
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function wallet_member($account_type): string
{
	// my wallet: start
	return ($account_type !== 'starter' &&
		settings('ancillaries')->withdrawal_mode === 'standard' ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">My Wallet</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                    	<li><a href="' . sef(15) . '">Convert to Efund</a></li>                    
                    	<li><a href="' . sef(49) . '">Payout Log</a></li>
                        <li><a href="' . sef(113) . '">Withdrawal Request</a></li>
                        <li><a href="' . sef(111) . '">Withdrawal Completed</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
	// my wallet: end
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function fixed_daily_token_admin($admintype): string
{
	$settings_plans = settings('plans');

	// $token_name = settings('trading')->token_name;

	$str = '';

	// token operations: start
	if ($settings_plans->fixed_daily_token) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">' . $settings_plans->fixed_daily_token_name . '</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
		$str .= ('<li><a href="' . sef(151) . '">' . $settings_plans->fixed_daily_token_name . '</a></li>');
		// $str .= (($admintype === 'Super') ?
		// 	'<li><a href="' . sef(5) . '">Add ' . $token_name . '</a></li>' : '');
		// $str .= ('<li><a href="' . sef(102) . '">' . strtoupper($token_name) . ' Transfer</a></li>');
		$str .= ('<li><a href="' . sef(98) . '">Withdraw B2P</a></li>');
		$str .= ('<li><a href="' . sef(99) . '">Completed B2P Withdrawals</a></li>');
		$str .= ('<li><a href="' . sef(100) . '">Pending B2P Withdrawals</a></li>');
		// $str .= ('<li><a href="' . sef(101) . '">B2P Withdrawal Logs</a></li>');
		$str .= '</ul>
            </div>
        </div>
    </div>';
	}

	// token operations: end

	return $str;
}

function fixed_daily_token_member($admintype): string
{
	$settings_plans = settings('plans');

	// $token_name = settings('trading')->token_name;

	$str = '';

	// token operations: start
	if ($settings_plans->fixed_daily_token) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
        <button class="uk-button" style="width: 80%;">' . /* $settings_plans->fixed_daily_token_name */ 'B2P Holdings' . '</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">';
		$str .= ('<li><a href="' . sef(151) . '">' . $settings_plans->fixed_daily_token_name . '</a></li>');
		// $str .= (($admintype === 'Super') ?
		// '<li><a href="' . sef(5) . '">Add ' . $token_name . '</a></li>' : '');
		// $str .= ('<li><a href="' . sef(102) . '">' . strtoupper($token_name) . ' Transfer</a></li>');
		// $str .= ('<li><a href="' . sef(98) . '">B2P Wallet</a></li>');
		$str .= ('<li><a href="' . sef(99) . '">Completed B2P Withdrawals</a></li>');
		// $str .= ('<li><a href="' . sef(100) . '">Pending B2P Withdrawals</a></li>');
		// $str .= ('<li><a href="' . sef(101) . '">B2P Withdrawal Logs</a></li>');
		$str .= '</ul>
            </div>
        </div>
    </div>';
	}

	// token operations: end

	return $str;
}

// /**
//  *
//  * @param $account_type
//  *
//  * @return string
//  *
//  * @since version
//  */
// function token_member($account_type): string
// {
// 	$settings_plans = settings('plans');

// 	$token_name = settings('trading')->token_name;

// 	// coin: start
// 	return ($settings_plans->trading && $account_type !== 'starter' ?
// 		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
//             <button class="uk-button" style="width: 80%;">' . strtoupper($token_name) . '</button>
//             <div class="" data-uk-dropdown="{mode:\'click\'}">
//                 <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
//                 <div style="" class="uk-dropdown uk-dropdown-small">
//                     <ul class="uk-nav uk-nav-dropdown">
//                         <li><a href="' . sef(102) . '">' . /*strtoupper($token_name) .*/ 'Transfer</a></li>
//                         <li><a href="' . sef(98) . '">' . /*strtoupper($token_name) .*/ 'Convert</a></li>
//                         <li><a href="' . sef(99) . '">' . /*strtoupper($token_name) .*/ 'Completed</a></li>
//                         <li><a href="' . sef(101) . '">' . /*strtoupper($token_name) .*/ 'Logs</a></li>
//                     </ul>
//                 </div>
//             </div>
//         </div>' : '');
// 	// coin: end
// }

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function shop_admin($account_type): string
{
	$settings_plans = settings('plans');
	$settings_unilevel = settings('unilevel');

	// online shop: start
	return ((($settings_plans->unilevel &&
		$settings_unilevel->{$account_type . '_unilevel_level'}) ||
		$settings_plans->redundant_binary) ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">ShoppeClub</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(9) . '">Buy Items</a></li>
                        <li><a href="' . sef(64) . '">Redeem Tokens</a></li>
                        <li><a href="' . sef(133) . '">Transfer Tokens</a></li>
                        <li><a href="' . sef(132) . '">Add Tokens</a></li>
                        <li><a href="' . sef(145) . '">Convert Tokens</a></li>
                        <li><a href="' . sef(146) . '">Pending Convert Tokens</a></li>
                        <li><a href="' . sef(147) . '">Confirmed Convert Tokens</a></li>
                        <li><a href="' . sef(148) . '">Logs Convert Tokens</a></li>
                        <li><a href="' . sef(69) . '">Shoppe Items</a></li>
                        <li><a href="' . sef(50) . '">Token Items</a></li>
                        <li><a href="' . sef(123) . '">Merchants</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
	// online shop: end
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function shop_member($account_type): string
{
	$sp = settings('plans');
	$su = settings('unilevel');

	$str = '';

	if (
		$account_type !== 'starter'
		&& (($sp->unilevel
			&& $su->{$account_type . '_unilevel_level'} > 0)
			|| $sp->redundant_binary)
	) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">';
		$str .= '<button class="uk-button" style="width: 80%;">TKN</button>';
		$str .= '<div class="" data-uk-dropdown="{mode:\'click\'}">';
		$str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
		$str .= '<div style="" class="uk-dropdown uk-dropdown-small">';
		$str .= '<ul class="uk-nav uk-nav-dropdown">';
		//		$str .= '<li><a href="' . sef(9) . '">Buy Items</a></li>';
		$str .= '<li><a href="' . sef(64) . '">Swap Tokens</a></li>';
		$str .= '<li><a href="' . sef(133) . '">Transfer Tokens</a></li>';
		$str .= '<li><a href="' . sef(145) . '">Convert Tokens</a></li>';
		$str .= '<li><a href="' . sef(147) . '">Convert Tokens History</a></li>';
		$str .= '<li><a href="' . sef(148) . '">Convert Tokens Log</a></li>';
		//		$str .= '<li><a href="' . sef(72) . '">Purchased History</a></li>';
		$str .= '<li><a href="' . sef(53) . '">Token Swap List</a></li>';
		//		$str .= '<li><a href="' . sef(123) . '">Merchants</a></li>';
		$str .= '</li>';
		$str .= '</ul>';
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';
	}

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function shop_manager(): string
{
	// online shop: start
	return '<div class="uk-button-group" style="background-color: padding: 5px">
            <button class="uk-button uk-button-primary">ShoppeClub</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(9) . '">Buy Items</a></li>
                        <li><a href="' . sef(64) . '">Redeem Tokens</a></li>
                        <li><a href="' . sef(69) . '">Shoppe Items</a></li>
                        <li><a href="' . sef(71) . '">Shoppe Items Edit</a></li>
                    </ul>
                </div>
            </div>
        </div>';
	// online shop: end
}

/**
 *
 *
 * @return string
 *
 * @since version
 */
function account_member(): string
{
	// account: start
	$str = '<div class="uk-button-group" style="padding-right: 5px">
        <button class="uk-button">Account</button>
        <div class="" data-uk-dropdown="{mode:\'click\'}">
            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
            <div style="" class="uk-dropdown uk-dropdown-small">
                <ul class="uk-nav uk-nav-dropdown">'/* . '
<li><a href="' . sef(13) . '">Direct Referrals</a></li>'*/
	;

	$str .= '<li><a href="' . sef(settings('ancillaries')->payment_mode === 'CODE' ? 65
		: 144) . '">Sign Up</a></li>';
	$str .= '<li><a href="' . sef(44) . '">Details</a></li>';
	$str .= '<li><a href="' . sef(60) . '">Edit Details</a></li>';
	$str .= '</ul>
            </div>
        </div>
    </div>';

	// account: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function account_manager(): string
{
	$sa = settings('ancillaries');
	$settings_plans = settings('plans');

	// account: start
	$str = '<div class="uk-button-group" style="background-color: padding: 5px">
                    <button class="uk-button uk-button-primary">Account</button>
                    <div class="" data-uk-dropdown="{mode:\'click\'}">
                        <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
                        <div style="" class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav uk-nav-dropdown">
                                <li><a href="' . sef(16) . '">' . $sa->efund_name . ' Transfer</a></li>';
	$str .= (($settings_plans->unilevel ||
		$settings_plans->redundant_binary) ?
		'<li><a href="' . sef(72) . '">Purchased History</a></li>
        <li><a href="' . sef(53) . '">Token Redemption List</a></li>' : '');
	$str .= '<li><a href="' . sef(60) . '">Profile Update</a></li>';
	$str .= '</ul>
                </div>
            </div>
        </div>';

	// account: end

	return $str;
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function purchases_admin($account_type): string
{
	$settings_plans = settings('plans');
	$settings_unilevel = settings('unilevel');

	// purchases: start
	return ((($settings_plans->unilevel &&
		$settings_unilevel->{$account_type . '_unilevel_level'} > 0) ||
		$settings_plans->redundant_binary) ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">Purchases</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(47) . '">Overall Purchase History</a></li>
                        <li><a href="' . sef(62) . '">Purchase-Items Confirm</a></li>
                        <li><a href="' . sef(48) . '">Overall Token Request Redeem</a></li>
                        <li><a href="' . sef(78) . '">Token Redemption Confirm</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
	// purchases: end
}

/**
 *
 * @return string
 *
 * @since version
 */
function purchases_manager(): string
{
	// purchases: start
	return '<div class="uk-button-group" style="background-color: padding: 5px">
                <button class="uk-button uk-button-primary">Member Purchases</button>
                <div class="" data-uk-dropdown="{mode:\'click\'}">
                    <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
                    <div style="" class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="' . sef(47) . '">Overall Purchase History</a></li>
                            <li><a href="' . sef(48) . '">Overall Token Request Redeem</a></li>
                        </ul>
                    </div>
                </div>
            </div>';
	// purchases: end
}

/**
 *
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function settings_adjust($admintype): string
{
	$settings_plans = settings('plans');

	$str = '';

	// settings: start
	if ($admintype === 'Super') {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <a href="javascript:void(0)" class="uk-button" style="width: 80%;">Settings</a>

            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(88) . '">Plans</a></li>
                        <li><a href="' . sef(81) . '">Entry</a></li>';
		$str .= (($settings_plans->direct_referral) ? '<li><a href="' . sef(91) . '">' .
			$settings_plans->direct_referral_name . '</a></li>' : '');
		$str .= (($settings_plans->indirect_referral) ? '<li><a href="' . sef(82) . '">' .
			$settings_plans->indirect_referral_name . '</a></li>' : '');
		$str .= (($settings_plans->echelon) ? '<li><a href="' . sef(146) . '">' .
			$settings_plans->echelon_name . '</a></li>' : '');
		$str .= (($settings_plans->unilevel) ? '<li><a href="' . sef(93) . '">' .
			$settings_plans->unilevel_name . '</a></li>' : '');
		$str .= (($settings_plans->royalty) ? '<li><a href="' . sef(90) . '">' .
			$settings_plans->royalty_name . '</a></li>' : '');
		$str .= (($settings_plans->binary_pair) ? '<li><a href="' . sef(80) . '">' .
			$settings_plans->binary_pair_name . '</a></li>' : '');
		$str .= (($settings_plans->leadership_binary &&
			$settings_plans->binary_pair) ?
			'<li><a href="' . sef(84) . '">' .
			$settings_plans->leadership_binary_name . '</a></li>' : '');
		$str .= (($settings_plans->leadership_passive &&
			($settings_plans->etrade ||
				$settings_plans->top_up ||
				$settings_plans->fast_track ||
				$settings_plans->fixed_daily)) ?
			'<li><a href="' . sef(85) . '">' .
			$settings_plans->leadership_passive_name . '</a></li>' : '');

		$str .= (($settings_plans->harvest) ? '<li><a href="' . sef(121) . '">' .
			$settings_plans->harvest_name . '</a></li>' : '');
		$str .= (($settings_plans->matrix) ? '<li><a href="' . sef(86) . '">' .
			$settings_plans->matrix_name . '</a></li>' : '');

		// $str .= (($settings_plans->power) ? '<li><a href="' . sef(89) . '">' .
		// 	$settings_plans->power_name . '</a></li>' : '');

		$str .= (($settings_plans->upline_support) ? '<li><a href="' . sef(117) . '">' .
			$settings_plans->upline_support_name . '</a></li>' : '');

		// $str .= (($settings_plans->passup) ? '<li><a href="' . sef(118) . '">' .
		// 	$settings_plans->passup_name . '</a></li>' : '');

		$str .= (($settings_plans->passup_binary) ? '<li><a href="' . sef(148) . '">' .
			$settings_plans->passup_binary_name . '</a></li>' : '');

		$str .= (($settings_plans->elite_reward) ? '<li><a href="' . sef(119) . '">' .
			$settings_plans->elite_reward_name . '</a></li>' : '');

		$str .= (($settings_plans->etrade ||
			$settings_plans->top_up ||
			$settings_plans->fast_track ||
			$settings_plans->fixed_daily) ?
			'<li><a href="' . sef(83) . '">Investment</a></li>' : '');
		$str .= (($settings_plans->trading) ? '<li><a href="' . sef(92) . '">' .
			$settings_plans->trading_name . '</a></li>' : '');
		$str .= ((($settings_plans->unilevel ||
			$settings_plans->redundant_binary) &&
			$settings_plans->merchant) ?
			'<li><a href="' . sef(87) . '">' . $settings_plans->merchant_name . '</a></li>' : '');
		$str .= '<li><a href="' . sef(94) . '">Ancillaries</a></li>';
		$str .= '<li><a href="' . sef(129) . '">Freeze</a></li>';
		$str .= '</ul>
                </div>
            </div>
        </div>';
	}

	// settings: end

	return $str;
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function binary($account_type): string
{
	$sp = settings('plans');

	// binary: start
	return (($account_type !== 'starter'
		&& ($sp->binary_pair || $sp->redundant_binary)) ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $sp->binary_pair_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">' .
		'<li><a href="' . sef(21) . '">Graphical</a></li>' .
		'<li><a href="' . sef(14) . '">Binary</a></li>' .
		'</ul>
                </div>
            </div>
        </div>' : '');
	// binary: end
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function leadership_binary($account_type): string
{
	$settings_plans = settings('plans');
	$settings_leadership = settings('leadership');

	// leadership binary: start
	return (($account_type !== 'starter' &&
		$settings_plans->binary_pair &&
		$settings_plans->leadership_binary &&
		$settings_leadership->{$account_type . '_leadership_level'} > 0) ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $settings_plans->leadership_binary_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">' .
		'<li><a href="' . sef(25) . '">Structure</a></li>' .
		'<li><a href="' . sef(37) . '">Profit Summary</a></li>' .
		'</ul>
                </div>
            </div>
        </div>' : '');
	// leadership binary: end
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function leadership_passive($account_type): string
{
	$settings_plans = settings('plans');
	$settings_leadership = settings('leadership_passive');

	// leadership passive: start
	return (($account_type !== 'starter' &&
		($settings_plans->leadership_passive &&
			$settings_leadership->{$account_type . '_leadership_passive_level'} > 0 &&
			($settings_plans->etrade ||
				$settings_plans->top_up ||
				$settings_plans->fast_track ||
				$settings_plans->fixed_daily))) ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $settings_plans->leadership_passive_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">                        
                        <li><a href="' . sef(38) . '">Profit Summary</a></li>
                        <li><a href="' . sef(39) . '">Wallet</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
	// leadership passive: end

	//<li><a href="' . sef(26) . '">Genealogy</a></li>
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function harvest($user_id): string
{
	$settings_plans = settings('plans');

	$user_harvest_associate = user_harvest($user_id, 'associate');
	$user_harvest_basic = user_harvest($user_id, 'basic');

	$str = '';

	// harvest: start
	if (($user_harvest_associate || $user_harvest_basic) && $settings_plans->harvest) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">Harvest</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">';
		//		$str .= ($user_harvest_associate ? '<li><a href="' . sef(22) . '">Silver</a></li>' : '');
		$str .= ($user_harvest_basic ? '<li><a href="' . sef(23) . '">Bronze</a></li>' : '');
		$str .= '</ul>
                </div>
            </div>
        </div>';
	}

	// harvest: end

	return $str;
}

/**
 *
 * @param $account_type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function table_matrix($account_type, $user_id): string
{
	$settings_plans = settings('plans');
	$settings_entry = settings('entry');

	$str = '';

	// table matrix: start
	if (
		$settings_plans->table_matrix &&
		!$settings_entry->executive_entry &&
		!$settings_entry->regular_entry &&
		!$settings_entry->associate_entry &&
		$account_type !== 'starter'
	) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
	        <button class="uk-button" style="width: 80%;">' . $settings_plans->table_matrix_name . '</button>
	        <div class="" data-uk-dropdown="{mode:\'click\'}">
	            <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
	            <div style="" class="uk-dropdown uk-dropdown-small">
	                <ul class="uk-nav uk-nav-dropdown">';
		$str .= (has_user_share('basic', $user_id) ? '<li><a href="' .
			sef(28) . '">Genealogy Profit Share Basic</a></li>' : '');
		$str .= (has_user_share('associate', $user_id) ? '<li><a href="' .
			sef(27) . '">Genealogy Profit Share Associate</a>' : '');
		$str .= (has_user_share('regular', $user_id) ? '<li><a href="' .
			sef(32) . '">Genealogy Profit Share Regular</a></li>' : '');
		$str .= (has_user_share('executive', $user_id) ? '<li><a href="' .
			sef(31) . '">Genealogy Profit Share Executive</a></li>' : '');
		$str .= (has_user_share('director', $user_id) ? '<li><a href="' .
			sef(30) . '">Genealogy Profit Share Director</a></li>' : '');
		$str .= (has_user_share('chairman', $user_id) ? '<li><a href="' .
			sef(29) . '">Genealogy Profit Share Chairman</a></li>' : '');
		$str .= '<li><a href="' . sef(61) . '">Profit Share Deposit</a></li>';
		$str .= '</ul>
	            </div>
	        </div>
	    </div>';
	}

	// table matrix: end

	return $str;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_indirect($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_indirect ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_passup_binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_passup_binary ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}


/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function indirect_referral($user_id): string
{
	$settings_plans = settings('plans');
	//	$settings_indirect = settings('indirect_referral');
//
//	$level = 0;
//
//	if (property_exists($settings_indirect, $account_type . '_indirect_referral_level'))
//	{
//		$level = $settings_indirect->{$account_type . '_indirect_referral_level'};
//	}

	// indirect referral: start
	return (user_indirect($user_id) && $settings_plans->indirect_referral ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $settings_plans->indirect_referral_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">' .
		'<li><a href="' . sef(24) . '">Group Line</a></li>' .
		'<li><a href="' . sef(36) . '">' . $settings_plans->indirect_referral_name . '</a></li>' .
		'</ul>
                </div>
            </div>
        </div>' : '');
	// indirect referral: end
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function unilevel($user_id): string
{
	$sp = settings('plans');
	$sul = settings('unilevel');

	$user = user($user_id);

	$account_type = $user->account_type;

	$str = '';

	if ($account_type !== 'starter') {
		// unilevel: start
		$str .= (($sp->unilevel
			&& $sul->{$account_type . '_unilevel_level'} > 0
			&& !empty(user_unilevel($user_id))
		) ? '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $sp->unilevel_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">' .
			'<li><a href="' . sef(33) . '">Genealogy Unilevel</a></li>' .
			'<li><a href="' . sef(109) . '">Unilevel Bonus</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
		// unilevel: end
	}

	return $str;
}

function echelon($user_id): string
{
	$settings_plans = settings('plans');
	$settings_echelon = settings('echelon');

	$user = user($user_id);

	$account_type = $user->account_type;

	$str = '';

	if ($account_type !== 'starter') {
		// unilevel: start
		$str .= (($settings_plans->echelon
			&& $settings_echelon->{$account_type . '_echelon_level'} > 0
			&& !empty(user_echelon($user_id))
		) ? '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $settings_plans->echelon_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">' .
			// '<li><a href="' . sef(33) . '">Genealogy Echelon</a></li>' .
			'<li><a href="' . sef(145) . '">Table Summary</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
		// unilevel: end
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_unilevel($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_unilevel ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

function user_echelon($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_echelon ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function investment($account_type): string
{
	$settings_plans = settings('plans');

	$str = '';

	// shares: start
	if (
		!$settings_plans->table_matrix &&
		!$settings_plans->matrix &&
		($settings_plans->etrade ||
			$settings_plans->top_up ||
			$settings_plans->fixed_daily ||
			$settings_plans->fast_track) &&
		$account_type !== 'starter'
	) {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $settings_plans->fixed_daily_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">';
		$str .= ($settings_plans->etrade ? '<li><a href="' .
			sef(114) . '">' . $settings_plans->etrade_name . '</a></li>' : '');
		$str .= ($settings_plans->fixed_daily ? '<li><a href="' .
			sef(17) . '">' . $settings_plans->fixed_daily_name . '</a></li>' : '');
		$str .= ($settings_plans->top_up ? '<li><a href="' .
			sef(103) . '">' . $settings_plans->top_up_name . '</a></li>' : '');
		$str .= ($settings_plans->fast_track ? '<li><a href="' .
			sef(19) . '">' . $settings_plans->fast_track_name . '</a></li>' : '');

		//		$str .= ($settings_plans->fast_track ? '<li><a href="' .
//			sef(20) . '">' . /*$settings_plans->fast_track_name .*/
//			' Wallet</a></li>' : '');

		$str .= '</ul>
                </div>
            </div>
        </div>';
	}

	// shares: end

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function trader_admin(): string
{
	$settings_plans = settings('plans');

	// trading: start
	return ($settings_plans->trading ? '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $settings_plans->trading_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(12) . '">Converter</a></li>
                        <li><a href="' . sef(45) . '">Merchant</a></li>
                        <li><a href="' . sef(105) . '">Trader</a></li>
                    </ul>
                </div>
            </div>
        </div>' : '');
	// trading: end
}

function p2p_trading(): string
{
	$settings_plans = settings('plans');

	// trading: start
	return (/*$settings_plans->trading &&*/ $settings_plans->p2p_trading ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . /*$settings_plans->p2p_trading_name*/ 'P2P / Swap' . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(54) . '">Sell</a></li>
                        <li><a href="' . sef(55) . '">Buy</a></li>
                        <li><a href="' . sef(56) . '">Trade History</a></li>                       
                    </ul>
                </div>
            </div>
        </div>' : '');
	// trading: end
}

function p2p_commerce(): string
{
	$sp = settings('plans');

	// trading: start
	return ($sp->p2p_commerce ?
		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
            <button class="uk-button" style="width: 80%;">' . $sp->p2p_commerce_name . '</button>
            <div class="" data-uk-dropdown="{mode:\'click\'}">
                <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                <div style="" class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="' . sef(126) . '">Seller</a></li>
                        <li><a href="' . sef(127) . '">Buyer</a></li>
                        <li><a href="' . sef(128) . '">Logs</a></li>                       
                    </ul>
                </div>
            </div>
        </div>' : '');
	// trading: end
}

/**
 *
 * @param $account_type
 *
 * @return string
 *
 * @since version
 */
function trader_member($account_type): string
{
	$settings_plans = settings('plans');

	$str = '';

	// trading: start
	if ($settings_plans->trading && $account_type !== 'starter') {
		$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
                <button class="uk-button" style="width: 80%;">' . $settings_plans->trading_name . '</button>
                <div class="" data-uk-dropdown="{mode:\'click\'}">
                    <button class="uk-button"><i class="uk-icon-caret-down"></i></button>
                    <div style="" class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav uk-nav-dropdown">';
		$str .= '<li><a href="' . sef(12) . '">Portal</a></li>';
		//		$str .= '<li><a href="' . sef(45) . '">Portal</a></li>';
//		$str .= '<li><a href="' . sef(105) . '">Exchanger</a></li>';
		$str .= '</ul>
                    </div>
                </div>
            </div>';
	}

	// trading: end

	return $str;
}

/**
 *
 * @param $admintype
 * @param $account_type
 * @param $user_id
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function admin($admintype, $account_type, $user_id, $username): string
{
	$logo = 'images/logo_responsive.png'/*'https://picsum.photos/300/100'*/
	;

	$logo1 = '<svg data-jdenticon-value="' . ($username . \BPL\Mods\Helpers\time()) . '" width="80" height="80"></svg>';

	$logo2 = '<a href="../">
                <img src="' . $logo . '" class="img-responsive" style="padding: 5px; margin-left: 33px" alt="">
            </a>';

	$str = (($admintype === 'Super') ? '<h3>Welcome SuperAdmin!</h3>' : '');
	//	$str .= '<div class="navbar-fixed-top" id="menu" style="background: transparent">'; // navbar-fixed-top: start
//	$str .= '<div style="text-align: center;">
//        <a href="../">
//            <img src="' . $logo . '" class="img-responsive" style="padding: 5px; margin-left: 33px" alt="">
//        </a>
//    </div>'; // logo
//    $str .= '<div class="sidebar" id="menu" style="background: transparent">';
	$str .= '<div class="sidebar" id="menu">';

	$str .= '<div style="text-align: center; padding: 10px;">' . (1 ? '<img src="' . $logo .
		'" style="max-width: 100%; height: auto;" alt="">' : $logo1) . '</div>'; // Change 1 to 0 to switch logos
//	$str .= '<div style="text-align: center;">' . (!1 ? $logo1 : $logo2) . '</div>';
	$str .= '<div class="uk-grid center" style="padding: 5px">'; // uk-grid center: start
	$str .= '<div class="uk-width-1-1" data-uk-margin>';

	$str .= home_admin($admintype);
	$str .= members_admin($admintype);
	$str .= codes();
	$str .= buy_package($account_type);
	$str .= logs_admin($admintype);
	$str .= efund_admin($admintype);
	//	$str .= share_fund_admin($admintype);
//	$str .= loan_admin($admintype);
	$str .= wallet_admin($admintype);
	$str .= fixed_daily_token_admin($admintype);
	$str .= shop_admin($account_type);
	$str .= purchases_admin($account_type);
	$str .= settings_adjust($admintype);

	//	$str .= core($account_type, $user_id);

	$str .= affiliates($account_type, $user_id);

	$str .= trader_admin();
	$str .= p2p_trading();
	$str .= p2p_commerce();

	$str .= $admintype === 'Super' ? cron_menu() : '';

	$str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;"><a href="' . sef(44) .
		'" class="uk-button" style="width: 93%;">' . /*($admintype === 'Super' ? 'Super' : $username)*/
		'Details' . '</a></div>';
	// $str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
	// 			<a href="site.html" class="uk-button" style="width: 93%;">Homepage</a></div>';
	$str .= logout();

	$str .= '</div>';
	$str .= '</div>'; // uk-grid center: end
	$str .= '</div>'; // navbar-fixed-top: end

	$str .= identicon_js();

	$str .= hamburger();

	$str .= menu_styles();

	$str .= menu_scripts();

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function hamburger(): string
{
	return '<button class="hamburger-button" id="hamburgerButton">
            &#9776; Menu
         </button>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function menu_styles(): string
{
	return <<<CSS
		<link rel="stylesheet" href="bpl/plugins/bootstrap3/bootstrap.min.css">
		<style>
			/* Make the entire page transparent */
			body {
					background: transparent !important;
					margin: 0;
					padding: 0;
			}

			/* Ensure the table and pagination are visible */
			.container {
				background: white; /* Add a white background to the table and pagination */
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for better visibility */
			}

			/* Existing styles for the hamburger button */
			.hamburger-button {
				position: fixed;
				top: 15px;
				right: 15px;
				background-color: #2f7997;
				border: none;
				font-size: 20px;
				color: white;
				cursor: pointer;
				padding: 8px 10px;
				border-radius: 5px;
				box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
				transition: background-color 0.3s ease, transform 0.3s ease;
			}
		
			/* Hover effect */
			.hamburger-button:hover {
				background-color: #26669e;
			}
		
			/* Mobile mode styling */
			@media (max-width: 768px) {
				.hamburger-button {
					top: 15px;
					left: 15px; /* Move to top-left corner in mobile mode */
					right: auto; /* Override the right position */
				}
			
				.hamburger-button.active {
					transform: translateX(250px); /* Move the button horizontally by the width of the sidebar */
				}
			}
		
			.sidebar {
				font-sizes: 14px; /* Adjust the font size as needed */
				width: 250px;
				background: #26669e;
				position: fixed;
				top: 0;
				left: 0;
				height: 100%;
				overflow-y: auto;
				transition: transform 0.3s ease;
				box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
				padding-top: 20px;
				z-index: 999;
				transform: translateX(-100%); /* Initially hide the sidebar */
			}
		
			.sidebar.active {
				transform: translateX(0); /* Show the sidebar when active */
			}

			.uk-button {			
				font-size: 1.5rem;			
			}

			.uk-dropdown {
				font-size: 1.5rem;
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
function menu_scripts(): string
{
	return <<<JS
		<script src="bpl/plugins/bootstrap3/jquery.min.js"></script>
		<script src="bpl/plugins/bootstrap3/bootstrap.min.js"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				const sidebar = document.getElementById("menu");
				const hamburger = document.getElementById("hamburgerButton");
			
				// Toggle sidebar and move hamburger button on click
				hamburger.addEventListener("click", function(e) {
					sidebar.classList.toggle("active");
					hamburger.classList.toggle("active"); // Add or remove the active class on the hamburger button
					e.stopPropagation(); // Prevent click from propagating to the document
				});
			
				// Close sidebar and reset hamburger button position when clicking outside
				document.addEventListener("click", function(e) {
					if (!sidebar.contains(e.target) && sidebar.classList.contains("active")) {
						sidebar.classList.remove("active");
						hamburger.classList.remove("active"); // Reset hamburger button position
					}
				});
			
				// Prevent sidebar from closing when clicking inside it
				sidebar.addEventListener("click", function(e) {
					e.stopPropagation();
				});
			});
		</script>
	JS;
}

/**
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function cron_menu(): string
{
	$sa = settings('ancillaries');
	$sp = settings('plans');

	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">';
	$str .= '<button class="uk-button" style="width: 80%;">CRON</button>';
	$str .= '<div data-uk-dropdown="{mode:\'click\'}" aria-haspopup="true" aria-expanded="true">';
	$str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
	$str .= '<div class="uk-dropdown uk-dropdown-small" aria-hidden="true">';
	$str .= '<div class="uk-grid uk-dropdown-grid">';

	$str .= '<div class="uk-width">';
	$str .= '<ul class="uk-nav uk-nav-dropdown">';

	$str .= '<li class="uk-nav-header">' . $sa->efund_name . '</li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_efund_convert_reset.php' . '">Convert Reset</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_efund_request_reset.php' . '">Buy Reset</a></li>';

	$str .= '<li class="uk-nav-divider"></li>';
	$str .= '<li class="uk-nav-header">' . $sp->unilevel_name . '</li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_unilevel_maintain.php' . '">' . $sp->unilevel_name . ' Maintain</a></li>';
	$str .= '<li class="uk-nav-divider"></li>';
	$str .= '<li class="uk-nav-header">Grace Period</li>';
	$str .= '<li><a href="' . Uri::root(true) . '/crons/cron_grace_period.php' . '">Grace Period</a></li>';

	$str .= '<li class="uk-nav-divider"></li>';
	$str .= '<li class="uk-nav-header">' . $sp->fast_track_name . '</li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_fast_track.php' . '">' . $sp->fast_track_name . '</a></li>';
	//	$str .= '<li><a href="' . Uri::root(true) . '/crons/cron_fast_track_deposit_reset.php' . '">Deposit Reset</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_fast_track_processing.php' . '">Processing</a></li>';

	$str .= '<li class="uk-nav-divider"></li>';
	$str .= '<li class="uk-nav-header">' . $sp->fixed_daily_name . '</li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_fixed_daily.php' . '">' . $sp->fixed_daily_name . '</a></li>';
	//	$str .= '<li><a href="' . Uri::root(true) . '/crons/cron_fixed_daily_deposit_reset.php' . '">Deposit Reset</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_fixed_daily_processing.php' . '">Processing</a></li>';

	$str .= '<li class="uk-nav-divider"></li>';
	$str .= '<li class="uk-nav-header">' . $sp->fixed_daily_token_name . '</li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_fixed_daily_token.php' . '">' . $sp->fixed_daily_token_name . '</a></li>';
	//	$str .= '<li><a href="' . Uri::root(true) . '/crons/cron_fixed_daily_token_deposit_reset.php' . '">Deposit Reset</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_fixed_daily_token_processing.php' . '">Processing</a></li>';

	$str .= '<li class="uk-nav-divider"></li>';
	$str .= '<li class="uk-nav-header">Flushout</li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_binary_flushout.php' . '">' . $sp->binary_pair_name . '</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_indirect_flushout.php' . '">' . $sp->indirect_referral_name . '</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_leadership_binary_flushout.php' . '">' . $sp->leadership_binary_name . '</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_leadership_passive_flushout.php' . '">' . $sp->leadership_passive_name . '</a></li>';
	$str .= '<li><a href="' . Uri::root(true) .
		'/crons/cron_unilevel_flushout.php' . '">' . $sp->unilevel_name . '</a></li>';

	$str .= '</ul>';
	$str .= '</div>';

	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	return $str;
}

/**
 * @param $account_type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function core($account_type, $user_id): string
{
	$str = $account_type === 'starter' || empty(user_binary($user_id)) ? '' : binary($account_type);
	$str .= $account_type === 'starter' ? '' : leadership_binary($account_type);
	$str .= $account_type === 'starter' ? '' : leadership_passive($account_type);
	$str .= $account_type === 'starter' ? '' : harvest($user_id);
	$str .= $account_type === 'starter' ? '' : table_matrix($account_type, $user_id);
	$str .= $account_type === 'starter' ? '' : indirect_referral($user_id);
	$str .= $account_type === 'starter' ? '' : unilevel($user_id);
	$str .= $account_type === 'starter' ? '' : echelon($user_id);
	$str .= $account_type === 'starter' ? '' : investment($account_type);

	return $str;
}

/**
 *
 * @param $account_type
 * @param $username
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function member($account_type, $username, $user_id): string
{
	$sa = settings('ancillaries');
	$efund_name = $sa->efund_name;

	$logo = 'images/logo_responsive.png'/*'https://picsum.photos/300/100'*/
	;

	$logo1 = '<svg data-jdenticon-value="' . ($username . \BPL\Mods\Helpers\time()) . '" width="80" height="80"></svg>';

	$logo2 = '<a href="../">
                <img src="' . $logo . '" class="img-responsive" style="padding: 5px; margin-left: 33px" alt="">
            </a>';

	$str = '<div class="sidebar" id="menu">';

	$str .= '<div style="text-align: center; padding: 10px;">' . (1 ? '<img src="' . $logo .
		'" style="max-width: 100%; height: auto;" alt="">' : $logo1) . '</div>'; // Change 1 to 0 to switch logos

	$str .= '<div class="uk-grid center" style="padding: 5px">';
	$str .= '<div class="uk-width-1-1" data-uk-margin>';

	//	$str .= home_member();
	$str .= '<div class="uk-button-group"  style="display: block; width: 100%; margin-bottom: 10px;"><a href="' .
		sef(44) . '" class="uk-button" style="width: 93%;">' . /*$username*/
		'Account Info' . '</a></div>';
	$str .= $account_type === 'starter' ? ''
		: '<div class="uk-button-group"  style="display: block; width: 100%; margin-bottom: 10px;"><a href="' .
		sef(2) . '" class="uk-button" style="width: 93%;">' . /*$username*/
		'Dashboard' . '</a></div>';
	$str .= '<div class="uk-button-group"  style="display: block; width: 100%; margin-bottom: 10px;"><a href="' .
		sef(settings('ancillaries')->payment_mode === 'CODE' ? 65
			: 144) . '" class="uk-button" style="width: 93%;">' . /*$username*/
		'Add Account' . '</a></div>';
	//	$str .= signup_member($account_type);
//	$str .= codes();
	$str .= buy_package($account_type);
	$str .= $account_type === 'starter' ? '' : wallet_member($account_type);
	$str .= $account_type === 'starter' ? '' : fixed_daily_token_member($account_type);
	$str .= shop_member($account_type);
	//	$str .= account_member();

	//	$str .= core($account_type, $user_id);

	$str .= trader_member($account_type);
	$str .= p2p_trading();
	$str .= p2p_commerce();

	$str .= /*$account_type !== 'starter' ?*/
		efund_member($user_id) /*: ''*/
	;

	//	$str .= $account_type !== 'starter' ? '' :
//		'<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;"><a href="' . sef(73) .
//		'" class="uk-button" style="width: 93%;">Request eCash ' . /*$efund_name .*/ '</a></div>';

	//	$str .= $account_type !== 'starter' ? share_fund_member() : '';
//	$str .= $account_type !== 'starter' ? loan_member() : '';

	//	$str .= $account_type !== 'starter' ? '' : '<div class="uk-button-group" style="padding-right: 5px">
//		<a href="https://coinbrain.com/converter/bnb-0x4a0bfc65feb6f477e3944906fb09652d2d8b5f0d/usd"
//		class="uk-button">Buy GOLD</a></div>';

	$str .= /*$account_type === 'starter' ? '' : */ affiliates($account_type, $user_id);

	// $str .= '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">
	// 			<a href="site.html" class="uk-button" style="width: 93%;">Homepage</a></div>';

	$str .= logout();
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	$str .= identicon_js();

	$str .= hamburger();

	$str .= menu_styles();

	$str .= menu_scripts();

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function logout(): string
{
	return '<div class="uk-button-group"  style="display: block; width: 100%; margin-bottom: 10px;"><a href="' .
		sef(41) . '" class="uk-button uk-button-primary" style="width: 93%;">' . 'Logout' . '</a></div>';
}

/**
 * @param $account_type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function affiliates($account_type, $user_id): string
{
	$se = settings('entry');
	$sp = settings('plans');
	$slb = settings('leadership');
	$slp = settings('leadership_passive');
	$sul = settings('unilevel');
	$spb = settings('passup_binary');

	$user_harvest_associate = user_harvest($user_id, 'associate');
	$user_harvest_basic = user_harvest($user_id, 'basic');

	$str = '<div class="uk-button-group" style="display: block; width: 100%; margin-bottom: 10px;">';
	$str .= '<button class="uk-button" style="width: 80%;">Agent Portal</button>';
	$str .= '<div data-uk-dropdown="{mode:\'click\'}" aria-haspopup="true" aria-expanded="true">';
	$str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
	$str .= '<div class="uk-dropdown uk-dropdown-small" aria-hidden="true">';
	$str .= '<div class="uk-grid uk-dropdown-grid">';

	$str .= '<div class="uk-width">';
	$str .= '<ul class="uk-nav uk-nav-dropdown">';

	$first = 0;

	// indirect referral
	if ($sp->indirect_referral && user_indirect($user_id)) {
		$first = 1;

		$str .= '<li class="uk-nav-header">' . $sp->indirect_referral_name . '</li>';

		$str .= '<li><a href="' . sef(24) . '">Indirect Line</a></li>';
		$str .= '<li><a href="' . sef(36) . '">Income Chart</a></li>';
	}

	if ($sp->echelon && user_echelon($user_id)) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->echelon_name . '</li>';

		$str .= '<li><a href="' . sef(147) . '">Team Line</a></li>';
		$str .= '<li><a href="' . sef(145) . '">Profit Board</a></li>';
	}

	// unilevel
	if (
			/*$account_type !== 'starter'
																																																																																																																																																																																																																																							   &&*/ (
			$sp->unilevel
			&& $sul->{$account_type . '_unilevel_level'} > 0
			&& !empty(user_unilevel($user_id))
		)
	) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->unilevel_name . '</li>';

		$str .= '<li><a href="' . sef(33) . '">Genealogy</a></li>';
		$str .= '<li><a href="' . sef(109) . '">Profit Board</a></li>';
	}

	//binary
	// if (
	// 		/*$account_type !== 'starter'
	// 																																																																				   &&*/ ($sp->binary_pair || $sp->redundant_binary)
	// ) {
	$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
	$first = !$first ? 1 : $first;

	$str .= '<li class="uk-nav-header">' . $sp->binary_pair_name . '</li>';

	$str .= '<li><a href="' . sef(21) . '">Graphical</a></li>';
	$str .= '<li><a href="' . sef(14) . '">Listing</a></li>';
	// }

	// leadership binary
	if (
		$account_type !== 'starter'
		&& $sp->binary_pair
		&& $sp->leadership_binary
		&& $slb->{$account_type . '_leadership_level'} > 0
	) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->leadership_binary_name . '</li>';

		$str .= '<li><a href="' . sef(25) . '">Direct Line</a></li>';
		$str .= '<li><a href="' . sef(37) . '">Leadership Chart</a></li>';
	}

	// passsup binary
	if ($sp->passup_binary && user_passup_binary($user_id)) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->passup_binary_name . '</li>';

		$str .= '<li><a href="' . sef(150) . '">Infinity Line</a></li>';
		$str .= '<li><a href="' . sef(149) . '">Infinity Bonus Board</a></li>';
	}

	// leadership passive
	if (
		$account_type !== 'starter'
		&& (
			$sp->leadership_passive
			&& $slp->{$account_type . '_leadership_passive_level'} > 0
			&& (
				$sp->etrade
				|| $sp->top_up
				|| $sp->fast_track
				|| $sp->fixed_daily
			)
		)
	) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->leadership_passive_name . '</li>';

		$str .= '<li><a href="' . sef(38) . '">Bounty Line</a></li>';
		$str .= '<li><a href="' . sef(39) . '">Bounty Chart</a></li>';
	}

	// harvest
	if (
		($user_harvest_associate || $user_harvest_basic)
		&& $sp->harvest
	) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->harvest_name . '</li>';

		//		$str .= ($user_harvest_associate ? '<li><a href="' . sef(22) . '">Silver</a></li>' : '');
		$str .= ($user_harvest_basic ? '<li><a href="' . sef(23) . '">Bronze</a></li>' : '');
	}

	// table matrix
	if (
		$sp->table_matrix
		&& !$se->executive_entry
		&& !$se->regular_entry
		&& !$se->associate_entry
		//		&& $account_type !== 'starter'
	) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';
		$first = !$first ? 1 : $first;

		$str .= '<li class="uk-nav-header">' . $sp->table_matrix_name . '</li>';

		$str .= (has_user_share('basic', $user_id) ? '<li><a href="' .
			sef(28) . '">Genealogy Basic</a></li>' : '');
		$str .= (has_user_share('associate', $user_id) ? '<li><a href="' .
			sef(27) . '">Genealogy Associate</a>' : '');
		$str .= (has_user_share('regular', $user_id) ? '<li><a href="' .
			sef(32) . '">Genealogy Regular</a></li>' : '');
		$str .= (has_user_share('executive', $user_id) ? '<li><a href="' .
			sef(31) . '">Genealogy Executive</a></li>' : '');
		$str .= (has_user_share('director', $user_id) ? '<li><a href="' .
			sef(30) . '">Genealogy Director</a></li>' : '');
		$str .= (has_user_share('chairman', $user_id) ? '<li><a href="' .
			sef(29) . '">Genealogy Chairman</a></li>' : '');
		$str .= '<li><a href="' . sef(61) . '">Profit Share Deposit</a></li>';
	}

	// investment
	if (
		!$sp->table_matrix
		&& !$sp->matrix
		&& (
			$sp->etrade
			|| $sp->top_up
			|| $sp->fixed_daily
			|| $sp->fast_track
		) /*&& $account_type !== 'starter'*/
	) {
		$str .= $first ? '<li class="uk-nav-divider"></li>' : '';

		$str .= '<li class="uk-nav-header">' . $sp->fixed_daily_name . '</li>';

		$str .= $sp->etrade ? '<li><a href="' . sef(114) . '">' . $sp->etrade_name . '</a></li>' : '';
		$str .= $sp->fixed_daily ? '<li><a href="' . sef(17) . '">' . $sp->fixed_daily_name . '</a></li>' : '';
		$str .= $sp->top_up ? '<li><a href="' . sef(103) . '">' . $sp->top_up_name . '</a></li>' : '';
		$str .= $sp->fast_track ? '<li><a href="' . sef(19) . '">' . $sp->fast_track_name . '</a></li>' : '';
	}

	$str .= '</ul>';
	$str .= '</div>';

	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	$str .= '<style>
		/* Reduce space between li tags */
		.uk-nav-dropdown li {
		    margin: 0; /* Adjust margin as needed */
		    padding: 0; /* Adjust padding as needed */
		}
		
		/* Set the width of the dropdown to match the sidebar */
		.uk-dropdown {
		    width: 100%; /* Set to 100% to match the container */
		    box-sizing: border-box; /* Ensures padding is included in the element\'s total width */
		}
	</style>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function manager(): string
{
	$img = 'images/logo_responsive.png'/*'https://picsum.photos/300/100'*/
	;

	$str = '<div class="navbar-fixed-top" style="background: white">';
	$str .= '<div style="text-align: center;">
            <a href="../">
                <img src="' . $img . '" class="img-responsive" style="padding: 5px; margin-left: 33px" alt="">
            </a>
        </div>';
	$str .= '<div class="uk-grid center">';
	$str .= '<div class="uk-width-1-1" data-uk-margin>';

	$str .= home_manager();
	$str .= members_manager();
	$str .= logs_manager();
	$str .= account_manager();
	$str .= shop_manager();
	$str .= purchases_manager();

	$str .= '</div>
        </div>
    </div>';

	return $str;
}

function identicon_js(): string
{
	return '<script src="https://cdn.jsdelivr.net/npm/jdenticon@3.1.1/dist/jdenticon.min.js" async
            integrity="sha384-l0/0sn63N3mskDgRYJZA6Mogihu0VY3CusdLMiwpJ9LFPklOARUcOiWEIGGmFELx" crossorigin="anonymous">
    </script>';
}