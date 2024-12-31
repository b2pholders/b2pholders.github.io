<?php

namespace BPL\Jumi\Registration_Codes_Inventory;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
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
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$user_id       = session_get('user_id');
	$merchant_type = session_get('merchant_type');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$uid = input_get('uid');

	if ($uid !== '')
	{
		$user_id = $uid;
	}

	$str .= style();
	$str .= page_reload();
	$str .= header_inventory($admintype, user($user_id)->username);
	$str .= view_inventory($user_id);

	echo $str;
}

/**
 *
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
 * @param $type
 *
 * @return array|mixed
 *
 * @since version
 */
function codes_generated($user_id, $type)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE type = ' . $db->quote($type) .
		' AND owner_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 * @param $type
 *
 * @return array|mixed
 *
 * @since version
 */
function codes_used($user_id, $type)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_codes ' .
		'WHERE type = ' . $db->quote($type) .
		' AND user_id <> ' . $db->quote(0) .
		' AND owner_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 * @param $type
 *
 * @return array
 *
 * @since version
 */
function data($user_id, $type): array
{
	$type_arr = explode('_', $type);

	$type = $type_arr[0];

	$price = settings('entry')->{$type . '_entry'};

	$generated = count(codes_generated($user_id, $type));
	$used      = count(codes_used($user_id, $type));

	return [
		'generated' => $generated,
		'used'      => $used,
		'price'     => $price,
		'balance'   => ($generated * $price),
		'sales'     => $used * $price
	];
}

/**
 * @param $user_id
 * @param $type
 *
 * @return string
 *
 * @since version
 */
function row($user_id, $type): string
{
	$settings_entry = settings('entry');

	$type_arr = explode('_', $type);
	$cd_type  = in_array('cd', $type_arr, true);

	return '<tr>
        <td class="type_code"><strong>' . (!$cd_type ? $settings_entry->{$type . '_package_name'} :
			$settings_entry->{$type_arr[0] . '_package_name'} . ' CD') . '</strong></td>
        <td>' . data($user_id, $type)['generated'] . '</td>
        <td>' . data($user_id, $type)['used'] . '</td>
        <td>' . data($user_id, $type)['price'] . '</td>
        <td>' . number_format(data($user_id, $type)['balance'], 2) . '</td>
        <td>' . number_format(data($user_id, $type)['sales'], 2) . '</td>
    </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function style(): string
{
	return '<style>
    .table th {
        text-align: center;
        color: #006600;
    }

    .table td {
        text-align: center;
    }

    .type_code {
        color: #ff6600;
    }

    .total {
        color: #006600;
    }
</style>';
}

/**
 * @param $admintype
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function header_inventory($admintype, $username): string
{
	$str = '<h1>Codes Inventory';
	$str .= ($admintype === 'Super' ? '<span style="float: right">' . $username . '</span>' : '');
	$str .= '</h1>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function thead(): string
{
	$currency = settings('ancillaries')->currency;

	return '<thead>
        <tr>
            <th>Package</th>
            <th colspan="2">Quantity</th>
            <th>Price (' . $currency . ')</th>
            <th colspan="2">Subtotal (' . $currency . ')</th>
        </tr>
        <tr>
            <th></th>
            <th>Generated</th>
            <th>Used</th>
            <th></th>
            <th>Generated (' . $currency . ')</th>
            <th>Used (' . $currency . ')</th>
        </tr>
        </thead>';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function generated_total($user_id): string
{
	$settings_entry = settings('entry');

	return number_format(
		data($user_id, 'chairman')['generated'] * (bool) $settings_entry->chairman_entry +
		data($user_id, 'executive')['generated'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular')['generated'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate')['generated'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic')['generated'] * (bool) $settings_entry->basic_entry +
		data($user_id, 'executive_cd')['generated'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular_cd')['generated'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate_cd')['generated'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic_cd')['generated'] * (bool) $settings_entry->basic_entry
	);
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function used_total($user_id): string
{
	$settings_entry = settings('entry');

	return number_format(
		data($user_id, 'chairman')['used'] * (bool) $settings_entry->chairman_entry +
		data($user_id, 'executive')['used'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular')['used'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate')['used'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic')['used'] * (bool) $settings_entry->basic_entry +
		data($user_id, 'executive_cd')['used'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular_cd')['used'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate_cd')['used'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic_cd')['used'] * (bool) $settings_entry->basic_entry
	);
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function balance_total($user_id): string
{
	$settings_entry = settings('entry');

	return (
		data($user_id, 'chairman')['balance'] * (bool) $settings_entry->chairman_entry +
		data($user_id, 'executive')['balance'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular')['balance'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate')['balance'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic')['balance'] * (bool) $settings_entry->basic_entry +
		data($user_id, 'executive_cd')['balance'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular_cd')['balance'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate_cd')['balance'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic_cd')['balance'] * (bool) $settings_entry->basic_entry
	);
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function sales_total($user_id): string
{
	$settings_entry = settings('entry');

	return (
		data($user_id, 'chairman')['sales'] * (bool) $settings_entry->chairman_entry +
		data($user_id, 'executive')['sales'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular')['sales'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate')['sales'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic')['sales'] * (bool) $settings_entry->basic_entry +
		data($user_id, 'executive_cd')['sales'] * (bool) $settings_entry->executive_entry +
		data($user_id, 'regular_cd')['sales'] * (bool) $settings_entry->regular_entry +
		data($user_id, 'associate_cd')['sales'] * (bool) $settings_entry->associate_entry +
		data($user_id, 'basic_cd')['sales'] * (bool) $settings_entry->basic_entry
	);
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function tbody($user_id): string
{
	$settings_ancillaries = settings('ancillaries');
	$settings_entry       = settings('entry');

	$currency = $settings_ancillaries->currency;

	$str = '<tbody>';

	$str .= $settings_entry->chairman_entry ? row($user_id, 'chairman') : '';
	$str .= $settings_entry->executive_entry ? row($user_id, 'executive') : '';
	$str .= $settings_entry->regular_entry ? row($user_id, 'regular') : '';
	$str .= $settings_entry->associate_entry ? row($user_id, 'associate') : '';
	$str .= $settings_entry->basic_entry ? row($user_id, 'basic') : '';

	if ($settings_ancillaries->cd_mode === 'cd')
	{
		$str .= $settings_entry->chairman_entry ? row($user_id, 'chairman_cd') : '';
		$str .= $settings_entry->executive_entry ? row($user_id, 'executive_cd') : '';
		$str .= $settings_entry->regular_entry ? row($user_id, 'regular_cd') : '';
		$str .= $settings_entry->associate_entry ? row($user_id, 'associate_cd') : '';
		$str .= $settings_entry->basic_entry ? row($user_id, 'basic_cd') : '';
	}

	$str .= row($user_id, 'starter');

	$str .= '<tr class="total">
		    <td><strong>Total</strong></td>
		    <td><strong>' . generated_total($user_id) . '</strong></td>
		    <td><strong>' . used_total($user_id) . '</strong></td>
		    <td><strong>n/a</strong></td>
		    <td><strong>' . number_format(balance_total($user_id), 8) . ' ' . $currency . '</strong></td>
		    <td><strong>' . number_format(sales_total($user_id), 8) . ' ' . $currency . '</strong></td>
		</tr>
		</tbody>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_inventory($user_id): string
{
	$str = '<div class="table-responsive">
    	<table class="category table table-striped table-bordered table-hover">';
	$str .= thead();
	$str .= tbody($user_id);

	$str .= '</table>
		</div>';

	return $str;
}