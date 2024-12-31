<?php

namespace BPL\Jumi\Transactions;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\input_get;
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
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
//	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');
	$page          = substr(input_get('page', 0), 0, 3);
	$uid           = input_get('uid');
	$username      = session_get('username');

	page_validate();

	if ($uid !== '')
	{
		$user_id = $uid;
	}

	$limit_to = 20;

	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			$str .= view_admin($user_id, $admintype, $page, $limit_to);
			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
			$str .= member($user_id, $page, $limit_to);
			break;
		case 'Manager':
			$str .= menu_manager();
			$str .= view_admin($user_id, $admintype, $page, $limit_to);
			break;
	}

	echo $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function transactions_get()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transactions ' .
		'ORDER BY transaction_id DESC'
	)->loadObjectList();
}

function view_paginate($page, $limit_to): string
{
	$limit_from = $limit_to * $page;
	$total = count(transactions_get());
	$last_page = ($total - $total % $limit_to) / $limit_to;

	$str = '<div class="pagination-container" style="text-align:right; margin-top:30px;">';

	if ($total > ($limit_from + $limit_to))
	{
		if ($page !== $last_page)
		{
			$str .= '<a href="' . sef(106) . qs() . 'page=' . ($last_page) .
				'" class="btn btn-primary">Oldest</a>';
		}

		$str .= '<a href="' . sef(106) . qs() . 'page=' . ($page + 1) .
			'" class="btn btn-danger">Previous</a>';
	}

	if ($page > 0 && $page)
	{
		$str .= '<a href="' . sef(106) . qs() . 'page=' . ($page - 1) .
			'" class="btn btn-primary">Next</a>';

		if ((int) $page !== 1)
		{
			$str .= '<a href="' . sef(106) . qs() . 'page=' . (1) .
				'" class="btn btn-danger">Latest</a>';
		}
	}

	$str .= '</div>';

	$str .= '<style>
		.pagination-container {
		    display: flex;
		    flex-wrap: wrap;
		    gap: 10px; /* Adds spacing between buttons */
		}
		
		.pagination-container a {
		    flex: 1; /* Makes buttons flexible to occupy available space */
		    min-width: 100px; /* Ensures a minimum width for buttons */
		    text-align: center;
		    margin-bottom: 10px; /* Adds margin at the bottom for small screens */
		}
		
		@media (max-width: 600px) {
		    .pagination-container {
		        flex-direction: column; /* Stacks buttons vertically on small screens */
		    }
		}
	</style>';

	return $str;
}

/**
 * @param $page
 * @param $limit_to
 *
 * @return array|mixed
 *
 * @since version
 */
function transactions_limit_get($page, $limit_to)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transactions ' .
		'ORDER BY transaction_id DESC ' .
		'LIMIT ' . ($limit_to * $page) . ', ' . $limit_to
	)->loadObjectList();
}

function view_transactions_admin($page, $limit_to): string
{
	$transactions = transactions_get();

	$total = count($transactions);

	$limit_from = $limit_to * $page;

	$str = '<h1>Account Transaction | ';
	$str .= ((int) $page === 0) ? ('Latest ' . $total) :
		('Past ' . $limit_from . ' - ' . ($limit_from + $limit_to));
	$str .= '</h1>';

	// Wrap the pagination in a div with custom styles to position it
	$str .= '<div class="pagination-container" style="text-align: right; margin-bottom: 10px;">';
	$str .= view_paginate($page, $limit_to);
	$str .= '</div>';

	if (!empty($transactions))
	{
		$currency = settings('ancillaries')->currency;

		$str .= '<table class="category table table-striped table-bordered table-hover">
	            <thead>
	            <tr>
	                <th>Date</th>
	                <th>Transaction</th>
	                <th>Details</th>
	                <th>Spent Value / Gained Value (' . $currency . ')</th>
	                <th>Total Credit Balance (' . $currency . ')</th>
	            </tr>
	            </thead>
	            <tbody>';

		$transactions_limit = transactions_limit_get($page, $limit_to);

		foreach ($transactions_limit as $transaction)
		{
			$str .= '<tr>
	                    <td>' . date('M j, Y - g:i A', $transaction->transaction_date) . '</td>
	                    <td>' . $transaction->transaction . '</td>
	                    <td>' . $transaction->details . '</td>
	                    <td>' . number_format($transaction->value, 8) . '</td>
	                    <td>' . number_format($transaction->balance, 8) . '</td>
	                </tr>';
		}

		$str .= '</tbody></table>';
	}
	else
	{
		$str .= '<hr><p>No transactions yet.</p>';
	}

	return $str;
}

/**
 * @param $user_id
 *
 *
 * @return array|mixed
 * @since version
 */
function transactions_user_get($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transactions ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' ORDER BY transaction_id DESC'
	)->loadObjectList();
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
function transactions_user_limit_get($user_id, $page, $limit_to)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transactions ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' ORDER BY transaction_id DESC ' .
		'LIMIT ' . ($limit_to * $page) . ', ' . $limit_to
	)->loadObjectList();
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
function view_transactions_user($user_id, $page, $limit_to): string
{
	$transactions = transactions_user_get($user_id);

	$limit_from = $limit_to * $page;

	$str = view_paginate($page, $limit_to);

	$str .= '<h1>Account Transaction | ';
	$str .= ((int) $page === 0) ? ('Latest ' . count($transactions)) :
		('Past ' . $limit_from . ' - ' . ($limit_from + $limit_to));
	$str .= '</h1>';

	if (!empty($transactions))
	{
		$currency = settings('ancillaries')->currency;

		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Transaction</th>
                <th>Details</th>
                <th>Value (' . $currency . ')</th>
                <th>Balance (' . $currency . ')</th>
            </tr>
            </thead>
            <tbody>';

		$transactions_limit = transactions_user_limit_get($user_id, $page, $limit_to);

		foreach ($transactions_limit as $transaction)
		{
			$str .= '<tr>
                    <td>' . date('M j, Y - g:i A', $transaction->transaction_date) . '</td>
                    <td>' . $transaction->transaction . '</td>
                    <td>' . $transaction->details . '</td>
                    <td>' . number_format($transaction->value, 8) . '</td>
                    <td>' . number_format($transaction->balance, 8) . '</td>
                </tr>';
		}

		$str .= '</tbody></table>';
	}
	else
	{
		$str .= '<hr><p>No transactions yet.</p>';
	}

	return $str;
}

/**
 * @param        $user_id
 * @param        $admintype
 * @param        $page
 * @param        $limit_to
 *
 * @return string
 *
 * @since version
 */
function view_admin($user_id, $admintype, $page, $limit_to): string
{
	$str = page_reload();

	if ($admintype === 'Super')
	{
		$str .= view_transactions_admin($page, $limit_to);
	}
	else
	{
		$str .= view_transactions_user($user_id, $page, $limit_to);
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
function member($user_id, $page, $limit_to): string
{
	$limit_from = $limit_to * $page;

	$str = page_reload();

	$transactions = transactions_user_get($user_id);

	$str .= view_paginate($page, $limit_to);

	$str .= '<h1>Account Transaction | ';
	$str .= ((int) $page === 0) ? ('Latest ' . count($transactions)) :
		('Past ' . $limit_from . ' - ' . ($limit_from + $limit_to));
	$str .= '</h1>';

	if (!empty($transactions))
	{
		$currency = settings('ancillaries')->currency;

		$str .= '<table class="category table table-striped table-bordered table-hover">
	        <thead>
	        <tr>
	            <th>Date</th>
	            <th>Transaction</th>
	            <th>Details</th>
	            <th>Value (' . $currency . ')</th>
	            <th>Balance (' . $currency . ')</th>
	        </tr>
	        </thead>
	        <tbody>';

		$transactions_limit = transactions_user_limit_get($user_id, $page, $limit_to);

		foreach ($transactions_limit as $transaction)
		{
			$str .= '<tr>
	            <td>' . date('M j, Y - g:i A', $transaction->transaction_date) . '</td>
	            <td>' . $transaction->transaction . '</td>
	            <td>' . $transaction->details . '</td>
	            <td>' . number_format($transaction->value, 8) . '</td>
	            <td>' . number_format($transaction->balance, 8) . '</td>
        	</tr>';
		}

		$str .= '</tbody></table>';
	}
	else
	{
		$str .= '<hr><p>No transactions yet.</p>';
	}

	return $str;
}