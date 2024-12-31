<?php

namespace BPL\Jumi\Token_Conversion_Completed;

require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\menu;
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
	$usertype     = session_get('usertype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');

	page_validate($usertype, $account_type);

	$str = menu();

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$str .= page_reload();

		$str .= view_table_admin();
	}
	else
	{
		$str .= view_table_user($user_id);
	}

	echo $str;
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
	if ($usertype === '' || $account_type === 'starter')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function admin_token_convert()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_token_convert t ' .
		'WHERE u.id = t.user_id ' .
		'AND t.date_completed <> ' . $db->quote(0) .
		' ORDER BY t.convert_id DESC'
	)->loadObjectList();
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

/**
 * @return string
 *
 * @since version
 */
function view_table_admin(): string
{
	$token_name = settings('trading')->token_name;

	$str = '<h1>Completed ' . strtoupper($token_name) . ' Conversion</h1>';

	$result = admin_token_convert();

	if (!empty($result))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date Converted</th>
                <th>Username</th>' . /*'
                <th>Account</th>
                <th>Balance (' . strtoupper($token_name) . ')</th>' .*/ '
                <th>Amount</th>
                <th>Charges</th>
                <th>Method</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($result as $user)
		{
//			$method         = explode('|', $user->method);
//			$method_name    = $method[0] ? strtoupper($method[0]) : '';
//			$method_address = $method[1] ?? '';

			$arr_payment_method = arr_payment_method($user);
			$method_address = $arr_payment_method[$user->method];

			$str .= '
            <tr>
                <td>' . date('M j, Y - g:i A', $user->date_converted) . '</td>
                <td><a href="' . sef(44) . 'uid=' . $user->id . '">' . $user->username . /*'</a></td>
                <td>' . settings('entry')->{$user->account_type . '_package_name'} . '</td>
                <td>' . number_format($user->balance_fmc, 8) .*/ '</td>
                <td>' . number_format($user->amount, 8) . ' ' . strtoupper($token_name) . '</td>
                <td>' . number_format($user->deduction_total, 2) . ' ' . strtoupper($user->method) . '</td>
                <td>' . strtoupper($user->method) . ': ' . $method_address . '</td>
            </tr>';
		}

		$str .= '</tbody>
        </table>';
	}
	else
	{
		$str .= '<hr><p>No conversions yet.</p>';
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
function user_token_convert($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_token_convert t ' .
		'WHERE u.id = t.user_id ' .
		'AND t.date_completed <> ' . $db->quote(0) .
		' AND t.user_id = ' . $db->quote($user_id) .
		' ORDER BY t.convert_id DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_table_user($user_id): string
{
	$str = '<h1>Completed Conversions</h1>';

	$results = user_token_convert($user_id);

	if (!empty($results))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date Converted</th>
                <th>Amount</th>
                <th>Charges</th>
                <th>Method</th>
            </tr>
            </thead>
            <tbody>';

		foreach ($results as $result)
		{
			$user = user($result->user_id);

//			$method         = explode('|', $user->method);
//			$method_name    = $method[0] ? strtoupper($method[0]) : '';
//			$method_address = $method[1] ?? '';

			$arr_payment_method = arr_payment_method($user);
			$method_address = $arr_payment_method[$result->method];

			$str .= '<tr>
                <td>' . date('M j, Y - g:i A', $result->date_converted) . '</td>
                <td>' . number_format($result->amount, 8) . ' ' .
				strtoupper(settings('trading')->token_name) . '</td>
                <td>' . number_format($result->deduction_total, 2) . ' ' . strtoupper($result->method) . '</td>
                <td>' . strtoupper($result->method) . ': ' . $method_address . '</td>
            </tr>';
		}

		$str .= '</tbody>
        </table>';
	}
	else
	{
		$str .= '<hr><p>No conversions yet.</p>';
	}

	return $str;
}