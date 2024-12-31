<?php

namespace BPL\Jumi\Registration_Codes_Used;

require_once 'bpl/menu.php';
require_once 'bpl/mods/url_sef.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
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
	$username      = session_get('username');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$user_id       = session_get('user_id');
	$merchant_type = session_get('merchant_type');
	$usertype      = session_get('usertype');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$page = substr(input_get('page', 0), 0, 3);

	$limit_to = 20;

	$codes = user_codes($user_id);

	$str .= page_reload();

	$str .= paginate($user_id);

	$str .= '<h1>' . count($codes) . ' Codes Used</h1>';

	if ($codes)
	{
		$str .= view_codes($user_id, $page, $limit_to);
	}
	else
	{
		$str .= '<hr><p>No codes to display.</p>';
	}

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $merchant_type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id): string
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
 * @param $user_id
 * @param $page
 * @param $limit_to
 *
 * @return string
 *
 * @since version
 */
function view_codes($user_id, $page, $limit_to): string
{
	$settings_entry = settings('entry');

	$str = '<div class="table-responsive">
        <table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Used By</th>
            </tr>
            </thead>
            <tbody>';

	$codes_limit = user_codes_limit($user_id, $page, $limit_to);

	if (!empty($codes_limit))
	{
		foreach ($codes_limit as $code)
		{
			$type_arr = explode('_', $code->type);
			$cd_type  = in_array('cd', $type_arr, true);

			$str .= '<tr>' .
				'<td>' . $code->code . '</td>' .
				'<td>' . (!$cd_type ? $settings_entry->{$code->type . '_package_name'} :
					$settings_entry->{$type_arr[0] . '_package_name'} . ' CD') . '</td>' .
				'<td>' . $code->username . '</td>' .
				'</tr>';
		}
	}

	$str .= '</tbody>
        </table>
    </div>';

	return $str;
}

/**
 * @param $user_id
 * @param $page
 * @param $limit_to
 *
 * @return array|mixed
 *
 * @since version
 */
function user_codes_limit($user_id, $page, $limit_to)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes as c ' .
		'INNER JOIN network_users as u ' .
		'ON c.user_id = u.id ' .
		'WHERE c.user_id <> ' . $db->quote(0) .
		' AND c.owner_id = ' . $db->quote($user_id) .
		' ORDER BY c.user_id DESC ' .
		'LIMIT ' . ($limit_to * $page) . ', ' . $limit_to
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_codes($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes as c ' .
		'INNER JOIN network_users as u ' .
		'ON c.user_id = u.id ' .
		'WHERE c.user_id <> ' . $db->quote(0) .
		' AND c.owner_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function paginate($user_id): string
{
	$page = substr(input_get('page', 0), 0, 3);

	$limit_to   = 20;
	$limit_from = $limit_to * $page;

	$codes = user_codes($user_id);

	$total = count($codes);

	$last_page = ($total - $total % $limit_to) / $limit_to;

	$str = '<div style="float:right; margin-top:30px;">';

	if ($total > ($limit_from + $limit_to))
	{
		if ((int) $page !== (int) $last_page)
		{
			$str .= '<a href="' . sef(68) . qs() . 'page=' .
				($last_page) . '" class="uk-button uk-button-primary">Oldest</a>';
		}

		$str .= '<a href="' . sef(68) . qs() . 'page=' .
			($page + 1) . '" class="uk-button uk-button-danger">Previous</a>';
	}

	if ($page > 0 && $page)
	{
		$str .= '<a href="' . sef(68) . qs() . 'page=' .
			($page - 1) . '" class="uk-button uk-button-primary">Next</a>';

		if ((int) $page !== 1)
		{
			$str .= '<a href="' . sef(68) . qs() . 'page=' .
				(1) . '" class="uk-button uk-button-danger">Latest</a>';
		}
	}

	$str .= '</div>';

	return $str;
}