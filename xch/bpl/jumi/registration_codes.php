<?php

namespace BPL\Jumi\Registration_Codes;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
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
	$usertype     = session_get('usertype');
	$username     = session_get('username');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
//	$merchant_type = session_get('merchant_type');
	$user_id = session_get('user_id');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$count = count(user_codes($user_id));

	$settings_entry       = settings('entry');
	$settings_ancillaries = settings('ancillaries');

	$str .= page_reload();

	$str .= '<h1>' . $count . ' Available out of ' . count(codes_owner($user_id)) . ' Codes</h1>';

	if (
		user_codes_type('chairman', $user_id)
		|| user_codes_type('executive', $user_id)
		|| user_codes_type('regular', $user_id)
		|| user_codes_type('associate', $user_id)
		|| user_codes_type('basic', $user_id)
		|| user_codes_type('chairman_cd', $user_id)
		|| user_codes_type('executive_cd', $user_id)
		|| user_codes_type('regular_cd', $user_id)
		|| user_codes_type('associate_cd', $user_id)
		|| user_codes_type('basic_cd', $user_id)
	)
	{
		$str .= '<div class="table-responsive">
	        <table class="category table table-striped table-bordered table-hover">
	            <thead>
	            <tr>';
		$str .= $settings_entry->chairman_entry ? ('<th>' . $settings_entry->chairman_package_name . '</th>') : '';
		$str .= $settings_entry->executive_entry ? ('<th>' . $settings_entry->executive_package_name . '</th>') : '';
		$str .= $settings_entry->regular_entry ? ('<th>' . $settings_entry->regular_package_name . '</th>') : '';
		$str .= $settings_entry->associate_entry ? ('<th>' . $settings_entry->associate_package_name . '</th>') : '';
		$str .= $settings_entry->basic_entry ? ('<th>' . $settings_entry->basic_package_name . '</th>') : '';

		if ($settings_ancillaries->cd_mode === 'cd')
		{
			$str .= $settings_entry->chairman_entry ? ('<th>' . $settings_entry->chairman_package_name . ' CD</th>') : '';
			$str .= $settings_entry->executive_entry ? ('<th>' . $settings_entry->executive_package_name . ' CD</th>') : '';
			$str .= $settings_entry->regular_entry ? ('<th>' . $settings_entry->regular_package_name . ' CD</th>') : '';
			$str .= $settings_entry->associate_entry ? ('<th>' . $settings_entry->associate_package_name . ' CD</th>') : '';
			$str .= $settings_entry->basic_entry ? ('<th>' . $settings_entry->basic_package_name . ' CD</th>') : '';
		}

		$str .= '</tr>
            </thead>
            <tbody>
            <tr>';

		$str .= codes_available('chairman', $user_id);
		$str .= codes_available('executive', $user_id);
		$str .= codes_available('regular', $user_id);
		$str .= codes_available('associate', $user_id);
		$str .= codes_available('basic', $user_id);

		if ($settings_ancillaries->cd_mode === 'cd')
		{
			$str .= codes_available('chairman_cd', $user_id);
			$str .= codes_available('executive_cd', $user_id);
			$str .= codes_available('regular_cd', $user_id);
			$str .= codes_available('associate_cd', $user_id);
			$str .= codes_available('basic_cd', $user_id);
		}

		$str .= '</tr>
		    </tbody>
		    </table>
		    </div>';
	}
	else
	{
		$str .= '<hr><p>No available codes yet.</p>';
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
		'FROM network_codes ' .
		'WHERE user_id = ' . $db->quote(0) .
		' AND owner_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $type
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_codes_type($type, $user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE user_id = ' . $db->quote(0) .
		' AND owner_id = ' . $db->quote($user_id) .
		' AND type = ' . $db->quote($type)
	)->loadObjectList();
}

/**
 * @param $type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function codes_available($type, $user_id): string
{
	$codes = user_codes_type($type, $user_id);

	$str = '';

	$type_arr = explode('_', $type);

	if (settings('entry')->{$type_arr[0] . '_entry'})
	{
		$str .= '<td>
            <ol class="uk-list uk-list-line">';

		if ($codes)
		{
			foreach ($codes as $code)
			{
				$str .= '<li>' . $code->code . '</li>';
			}
		}
		else
		{
			$str .= 'None available.';
		}

		$str .= '</ol>
        	</td>';
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function codes_owner($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE owner_id = ' . $db->quote($user_id)
	)->loadObjectList();
}