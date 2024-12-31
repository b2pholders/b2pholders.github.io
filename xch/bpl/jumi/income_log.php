<?php

namespace BPL\Jumi\Income_Log;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Menu\admin as menu_admin;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\input_get;
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
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate($usertype);

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	$page = substr(input_get('page', 0), 0, 3);

	$str .= page_reload();

	$str .= view_logs($page);

	echo $str;
}

/**
 * @param        $page
 * @param   int  $limit_to
 *
 * @return string
 *
 * @since version
 */
function view_logs($page, int $limit_to = 10): string
{
	$limit_from = $limit_to * $page;

	$currency = settings('ancillaries')->currency;

	$logs = user_logs();

	$total = count($logs);

	$last_page = ($total - $total % $limit_to) / $limit_to;

	$str = '<div style="float:right; margin-top:30px;">';

	if ($total > ($limit_from + $limit_to))
	{
		if ((int) $page !== (int) $last_page)
		{
			$str .= '<a href="' . sef(35) . qs() . 'page=' . ($last_page) .
				'" class="uk-button uk-button-primary">Oldest</a>';
		}

		$str .= '<a href="' . sef(35) . qs() . 'page=' . ($page + 1) .
			'" class="uk-button uk-button-danger">Previous</a>';
	}

	if ($page > 0 && $page)
	{
		$str .= '<a href="' . sef(35) . qs() . 'page=' . ($page - 1) .
			'" class="uk-button uk-button-primary">Next</a>';

		if ((int) $page !== 1)
		{
			$str .= '<a href="' . sef(35) . qs() . 'page=' . (1) .
				'" class="uk-button uk-button-danger">Latest</a>';
		}
	}

	$str .= '</div>';
	$str .= '<h1>System Income | ';
	$str .= ((int) $page === 0) ? ('Latest ' . $total) :
		('Past ' . $limit_from . ' - ' . ($limit_from + $limit_to));
	$str .= '</h1>';

	if (!empty($logs))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>Date</th>
        <th>User</th>
        <th>Transaction</th>
        <th>Details</th>
        <th>Value (' . $currency . ')</th>
        <th>Total (' . $currency . ')</th>
    </tr>
    </thead>
    <tbody>';

		$logs_lim = user_logs_lim($limit_from, $limit_to);

		foreach ($logs_lim as $log)
		{
			$user = user($log->user_id);

			$str .= '<tr>
            <td>' . date('M j, Y - g:i A', $log->income_date) . '</td>
            <td><a href="' . sef(44) . qs() . 'uid=' .
				$user->id . '">' . $user->username . '</a>' . '</td>
            <td>' . $log->transaction . '</td>
            <td>' . $log->details . '</td>
            <td>' . number_format($log->amount, 8) . '</td>
            <td>' . number_format($log->income_total, 8) . '</td>
        </tr>';
		}

		$str .= '</tbody></table>';
	}
	else
	{
		$str .= '<hr><p>No income records yet.</p>';
	}

	return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function user_logs()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income i, network_transactions t ' .
		'WHERE i.transaction_id = t.transaction_id ' .
		'ORDER BY i.income_id DESC'
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
function user_logs_lim($limit_from, $limit_to)
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income i, network_transactions t ' .
		'WHERE i.transaction_id = t.transaction_id ' .
		'ORDER BY i.income_id DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();
}

/**
 * @param $usertype
 *
 *
 * @since version
 */
function page_validate($usertype)
{
	if ($usertype !== 'Admin')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}