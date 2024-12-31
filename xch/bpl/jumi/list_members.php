<?php

namespace BPL\Jumi\List_Members;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_reload;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	page_validate();

	$str = menu();

	$str .= page_reload();
	$str .= paginate();
	$str .= header();

	if (count(users_desc()) > 0) {
		$str .= view_members(5);
	} else {
		$str .= '<hr><p>No members yet.</p>';
	}

	echo $str;
}

/**
 *
 * @param $limit
 *
 * @return string
 *
 * @since version
 */
function view_members($limit): string
{
	$usertype = session_get('usertype');
	$username = input_get('username');
	$page = substr(input_get('page', 0), 0, 3);

	$settings_ancillaries = settings('ancillaries');
	$settings_plans = settings('plans');

	$currency = $settings_ancillaries->currency;

	$limit_to = $limit;
	$limit_from = $limit_to * $page;

	$str = '<table class="category table table-striped table-bordered table-hover">';
	$str .= '<thead>';

	$str .= search_member();

	$str .= '<tr>';
	$str .= '<th>Date Registered</th>';
	$str .= '<th>Username</th>';
	$str .= '<th>Account</th>';

	if ($settings_plans->royalty) {
		$str .= '<th>' . $settings_plans->royalty_name . '</th>';
	}

	$str .= '<th>Balance (' . $currency . ')</th>';

	if (
		$settings_plans->binary_pair &&
		binary_all()
	) {
		$str .= '<th>Left</th>';
		$str .= '<th>Right</th>';
	}

	if ($usertype === 'Admin') {
		$str .= '<th>Actions</th>';
	}

	$str .= '</tr>';
	$str .= '</thead>';
	$str .= '<tbody>';

	if ($username === '') {
		$members_limit = users_desc_lim($limit_from, $limit_to);

		foreach ($members_limit as $member) {
			$str .= view_member($member);
		}
	} else {
		$str .= search_result($username);
	}

	$str .= '</tbody>';
	$str .= '</table>';

	return $str;
}

/**
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function search_result($username): string
{
	$users = username_users($username);

	$str = '';

	if ($users) {
		foreach ($users as $user) {
			$str .= view_member($user);
		}
	}

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function search_member(): string
{
	return '<tr><td colspan="5"><form method="post">
		<input type="text" name="username" style="float:left" placeholder="Search member">
		<input type="submit" class="uk-button uk-button-primary">
		</form></td></tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function paginate(): string
{
	$page = substr(input_get('page', 0), 0, 3);

	$limit_to = 5;
	$limit_from = $limit_to * $page;

	$members = users_desc();

	$total = count($members);

	$last_page = ($total - $total % $limit_to) / $limit_to;

	$str = '<div style="float:right; margin-top:30px;">';

	if ($total > ($limit_from + $limit_to)) {
		if ((int) $page !== (int) $last_page) {
			$str .= '<a href="' . sef(40) . qs() . 'page=' . ($last_page) .
				'" class="uk-button uk-button-primary">Oldest</a>';
		}

		$str .= '<a href="' . sef(40) . qs() . 'page=' . ($page + 1) .
			'" class="uk-button uk-button-danger">Previous</a>';
	}

	if ($page > 0 && $page) {
		$str .= '<a href="' . sef(40) . qs() . 'page=' . ($page - 1) .
			'" class="uk-button uk-button-primary">Next</a>';

		if ((int) $page !== 1) {
			$str .= '<a href="' . sef(40) . qs() . 'page=' . (1) .
				'" class="uk-button uk-button-danger">Latest</a>';
		}
	}

	$str .= '</div>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function header(): string
{
	$page = substr(input_get('page', 0), 0, 3);

	$limit_to = 5;
	$limit_from = $limit_to * $page;

	$members = users_desc();

	$total = count($members);

	$str = '<h1>Members | ';
	$str .= ((int) $page === 0) ? ('Latest ' . $total) :
		('Past ' . $limit_from . ' - ' . ($limit_from + $limit_to));
	$str .= '</h1>';

	return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function users_desc()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'ORDER BY id DESC'
	)->loadObjectList();
}

/**
 * @param $limit_from
 * @param $limit_to
 *
 * @return array|mixed
 *
 * @since version
 */
function users_desc_lim($limit_from, $limit_to)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'ORDER BY id DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_cd($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_commission_deduct ' .
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
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
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function binary_all()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary'
	)->loadObject();
}

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
		'SELECT * ' .
		'FROM network_harvest_' . $type .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $username
 *
 * @return mixed|null
 *
 * @since version
 */
function username_users($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username LIKE ' . $db->quote('%' . $username . '%')
	)->loadObjectList();
}

function harvest_append($member): string
{
	$user_cd = user_cd($member->id);

	$account_rd = settings('entry')->{$member->account_type .
		'_package_name'} . ($user_cd ? ' CD' : '');

	if (
		!empty(user_harvest($member->id, 'basic')) ||
		!empty(user_harvest($member->id, 'associate'))
	) {
		if (!empty(user_harvest($member->id, 'basic'))) {
			$account_rd .= ' + <a href="' . sef(23) . qs() .
				'uid=' . $member->id . '">(Bronze Harvest)</a>';
		}

		if (!empty(user_harvest($member->id, 'associate'))) {
			$account_rd .= ' + <a href="' . sef(22) . qs() .
				'uid=' . $member->id . '">(Silver Harvest)</a>';
		}
	}

	return $account_rd;
}

/**
 * @param $member
 *
 * @return string
 *
 * @since version
 */
function view_member($member): string
{
	$usertype = session_get('usertype');

	$settings_ancillaries = settings('ancillaries');
	$settings_plans = settings('plans');

	$account_type = $member->account_type;

	$payment_mode = $settings_ancillaries->payment_mode;

	$user_cd = user_cd($member->id);

	$user_binary = user_binary($member->id);

	$account_rd = settings('entry')->{$account_type . '_package_name'} . ($user_cd ? ' CD' : '');

	$account_rd .= !0 ? '' : harvest_append($member);

	$psv = $account_type !== 'starter' ? settings('binary')->{$account_type . '_pairs'} : 0; // pair set value

	$str = '<tr>';
	$str .= '<td>' . date('M j, Y - G:i', $member->date_registered) . '</td>';
	$str .= '<td><a href="' . sef(44) . qs() .
		'uid=' . $member->id . '">' . $member->username . '</a></td>';
	$str .= '<td>' . $account_rd . '</td>';
	$str .= ($settings_plans->royalty ? ('<td>' .
		settings('royalty')->{$member->rank . '_rank_name'} . '</td>') : "\n");
	$str .= '<td>' . number_format($member->payout_transfer, 8) . '</td>';
	if (
		$settings_plans->binary_pair &&
		binary_all()
	) {
		$str .= '<td>' . ($user_binary->ctr_left ?? 'n/a') . '</td>';
		$str .= '<td>' . ($user_binary->ctr_right ?? 'n/a') . '</td>';
	}

	// $str .= ($settings_plans->binary_pair && $user_binary && $psv ?
	// 	('<td>' . $user_binary->ctr_left . '</td>' . '<td>' .
	// 		$user_binary->ctr_right . '</td>') : ('<td>N/A</td>' . '<td>N/A</td>'));

	if ($usertype === 'Admin') {
		$str .= '<td>';
		$str .= '<div class="uk-button-group">';
		$str .= '<button class="uk-button uk-button-primary">Select</button>';
		$str .= '<div class="" data-uk-dropdown="{mode:\'click\'}">';
		$str .= '<button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>';
		$str .= '<div style="" class="uk-dropdown uk-dropdown-small">';
		$str .= '<ul class="uk-nav uk-nav-dropdown">';
		$str .= '<li>';
		$str .= (!$member->block ?
			'<a href="' . sef(8) . qs() . 'uid=' . $member->id . '">Block</a>' :
			'<a href="' . sef(107) . qs() . 'uid=' . $member->id . '">Unblock</a>');
		$str .= '</li>';
		$str .= $payment_mode === 'CODE' && $settings_ancillaries->cd_mode === 'cd' ?
			('<li>' . (!$user_cd ? '<a href="' . sef(11) . qs() . 'uid=' . $member->id . '">CD</a>' :
				'<a href="' . sef(108) . qs() . 'uid=' . $member->id . '">UnCD</a>') . '</li>') : '';
		$str .= '</ul>';
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</td>';
	}

	$str .= '</tr>';

	return $str;
}