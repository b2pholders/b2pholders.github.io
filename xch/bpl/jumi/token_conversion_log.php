<?php

namespace BPL\Jumi\Token_Conversion_Log;

require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\page_reload;
use function BPL\Mods\Helpers\user;

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
	$admintype    = session_get('admintype');
	$user_id      = session_get('user_id');

	page_validate($usertype, $account_type);

	$str = menu();

	$str .= page_reload();

	if ($usertype === 'Admin' && $admintype === 'Super')
	{
		$str .= view_logs_admin();
	}
	else
	{
		$str .= view_logs_user($user_id);
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
function conversion_logs_admin()
{
	return db()->setQuery(
		'SELECT * ' .
//		'FROM network_token_conversions c, network_transactions t ' .
		'FROM network_token_convert ' .
//		'WHERE c.transaction_id = t.transaction_id ' .
//		'ORDER BY c.conversion_id DESC'
		'ORDER BY convert_id DESC'
	)->loadObjectList();
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_logs_admin(): string
{
	$token_name = settings('trading')->token_name;
//	$currency   = settings('ancillaries')->currency;

	$logs = conversion_logs_admin();

	$str = '<h1>' . strtoupper(settings('trading')->token_name) . ' Conversion Logs</h1>';

	if (!empty($logs))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>Amount</th>
            <th>Amount Final</th>
            <th>Deductions</th>           
        </tr>
        </thead>
        <tbody>';

		foreach ($logs as $log)
		{
			$user = user($log->user_id);

			$currency = in_array($log->method, ['bank', 'gcash']) ? 'PHP' : $log->method;

			$str .= '<tr>
                <td>' . date('M j, Y - g:i A', $log->date_converted) . '</td>
                <td>' . '<a href="' . sef(44) . qs() . 'uid=' . $user->id . '">' .
				$user->username . '</a>' . '</td>
                <td>' . number_format($log->amount, 8) . ' ' . strtoupper($token_name) . '</td>
                <td>' . number_format($log->amount_final, 8) . ' ' . strtoupper($currency) . '</td>
                <td>' . number_format($log->deduction_total, 8) . ' ' . strtoupper($currency) . '</td>                
            </tr>';
		}

		$str .= '</tbody>
    		</table>';
	}
	else
	{
		$str .= '<hr><p>No ' . strtoupper($token_name) . ' conversions yet.</p>';
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
function conversion_logs_user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
//		'FROM network_token_conversions c, network_transactions t ' .
		'FROM network_token_convert ' .
//		'WHERE c.transaction_id = t.transaction_id ' .
		'WHERE user_id = ' . $db->quote($user_id) .
//		'AND t.user_id = ' . $db->quote($user_id) .
		' ORDER BY convert_id DESC'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_logs_user($user_id): string
{
	$token_name = settings('trading')->token_name;

	$logs = conversion_logs_user($user_id);

	$str = '<h1>' . strtoupper(settings('trading')->token_name) . ' Conversion Logs</h1>';

	if (!empty($logs))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Amount Final</th>
        </tr>
        </thead>
        <tbody>';

		$total = 0;

		foreach ($logs as $log)
		{
			$currency = in_array($log->method, ['bank', 'gcash']) ? 'PHP' : $log->method;

			$str .= '<tr>
                    <td>' . date('M j, Y - g:i A', $log->date_converted) . '</td>
                    <td>' . number_format($log->amount, 8) . ' ' . strtoupper($token_name) . '</td>
                    <td>' . number_format($log->amount_final, 8) . ' ' . strtoupper($currency) . '</td>
                </tr>';

			$total += $log->amount;
		}

		$str .= '</tbody>
		    </table>
		    <p><strong>Total ' . strtoupper($token_name) .
			'Converted: </strong>' . number_format($total, 2)/* . ' ' . settings('ancillaries')->currency*/;
	}
	else
	{
		$str .= '<hr><p>No ' . strtoupper($token_name) . ' conversions yet.</p>';
	}

	return $str;
}