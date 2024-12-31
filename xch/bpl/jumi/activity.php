<?php

namespace BPL\Jumi\Activity;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;

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
	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');
	$page          = substr(input_get('page', 0), 0, 3);

	$limit = 20;
	$start = $limit * $page;

	page_validate();

	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			$str .= admin($page, $start);
			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
			$str .= member($user_id, $page, $start);
			break;
		case 'manager':
			$str .= menu_manager();
			$str .= admin($page, $start);
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
function activity_all()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_activity ' .
		'ORDER BY activity_date DESC'
	)->loadObjectList();
}

/**
 * @param $limit_from
 * @param $limit_to
 *
 *
 * @return array|mixed
 * @since version
 */
function activities_lim($limit_from, $limit_to)
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_activity ' .
		'ORDER BY activity_date DESC ' .
		'LIMIT ' . $limit_from . ', ' . $limit_to
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_activity($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_activity ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' OR sponsor_id = ' . $db->quote($user_id) .
		' OR upline_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $limit_from
 * @param $limit_to
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_activities_lim($limit_from, $limit_to, $user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_activity ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' OR sponsor_id = ' . $db->quote($user_id) .
		' OR upline_id = ' . $db->quote($user_id) .
		' ORDER BY activity_date DESC ' .
		'LIMIT ' . $limit_from . ',' . $limit_to
	)->loadObjectList();
}

/**
 * @param $page
 * @param $start
 * @param $limit
 *
 * @return string
 *
 * @since version
 */
function paginate($page, $start, $limit): string
{
	$activities = activity_all();

	$total = count($activities);

	$last_page = ($total - $total % $limit) / $limit;

	$str = '<div style="float:right; margin-top:30px;">';

	if ($total > ($start + $limit))
	{
		if ((int) $page !== (int) $last_page)
		{
			$str .= '<a href="' . sef(3) . qs() . 'page=' . ($last_page) .
				'" class="uk-button uk-button-primary">Oldest</a>';
		}

		$str .= '<a href="' . sef(3) . qs() . 'page=' . ($page + 1) .
			'" class="uk-button uk-button-success">Previous</a>';
	}

	if ($page > 0 && $page)
	{
		$str .= '<a href="' . sef(3) . qs() . 'page=' . ($page - 1) .
			'" class="uk-button uk-button-primary">Next</a>';

		if ((int) $page !== 1)
		{
			$str .= '<a href="' . sef(3) . qs() . 'page=' . (1) .
				'" class="uk-button uk-button-success">Latest</a>';
		}
	}

	$str .= '</div>';

	return $str;
}

/**
 * @param $start
 * @param $page
 * @param $limit
 *
 * @return string
 *
 * @since version
 */
function header_admin($start, $page, $limit): string
{
	$str = '<h1>Account Activity | ';
	$str .= ((int) $page === 0) ? ('Latest ' . count(activity_all())) :
		('Past ' . $start . ' - ' . ($start + $limit));
	$str .= '</h1>';

	return $str;
}

/**
 * @param $user_id
 * @param $start
 * @param $page
 * @param $limit
 *
 * @return string
 *
 * @since version
 */
function header_user($user_id, $start, $page, $limit): string
{
	$str = '<h1>Account Activity | ';
	$str .= ((int) $page === 0) ?
		('Latest ' . count(user_activity($user_id))) :
		('Past ' . $start . ' - ' . ($start + $limit));
	$str .= '</h1>';

	return $str;
}

/**
 *
 * @param        $page
 * @param        $start
 * @param   int  $limit
 *
 * @return string
 *
 * @since version
 */
function admin($page, $start, int $limit = 10): string
{
	$activities = activity_all();

	$str = page_reload();
	$str .= paginate($page, $start, $limit);
	$str .= header_admin($start, $page, $limit);

	if (!empty($activities))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date</th>
            <th>Users Notified</th>
            <th>Activity</th>
        </tr>
        </thead>
        <tbody>';

		$activities_limit = activities_lim($start, $limit);

		foreach ($activities_limit as $activity)
		{
			$str .= '<tr>
                <td>' . date('M j, Y - G:i', $activity->activity_date) . '</td>
                <td>';

			if ($activity->user_id !== '0')
			{
				$tmp = user($activity->user_id);

				$str .= '<a href="' . sef(44) . qs() . 'uid=' .
					$activity->user_id . '">' . $tmp->username . '</a><br>';
			}

			if ($activity->sponsor_id !== '0' &&
				$activity->sponsor_id !== $activity->user_id)
			{
				$tmp = user($activity->sponsor_id);

				$str .= '<a href="' . sef(44) . qs() . 'uid=' .
					$activity->sponsor_id . '">' . $tmp->username . '</a><br>';
			}

			if ($activity->upline_id !== '0' &&
				$activity->upline_id !== $activity->sponsor_id &&
				$activity->upline_id !== $activity->user_id)
			{
				$tmp = user($activity->upline_id);

				$str .= '<a href="' . sef(44) . qs() . 'uid=' .
					$activity->upline_id . '">' . $tmp->username . '</a><br>';
			}

			$str .= '</td>
                <td>' . $activity->activity . '</td>
            </tr>';
		}

		$str .= '</tbody></table>';
	}
	else
	{
		$str .= '<hr><p>No activities yet.</p>';
	}

	return $str;
}

/**
 * @param        $user_id
 * @param        $page
 * @param        $start
 * @param   int  $limit
 *
 * @return string
 *
 * @since version
 */
function member($user_id, $page, $start, int $limit = 10): string
{
	$activities = user_activity($user_id);

	$str = page_reload();
	$str .= paginate($page, $start, $limit);
	$str .= header_user($user_id, $start, $page, $limit);

	if (!empty($activities))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
	        <thead>
	        <tr>
	            <th>Date</th>
	            <th>Users Notified</th>
	            <th>Activity</th>
	        </tr>
	        </thead>
	        <tbody>';

		$activities_limit = user_activities_lim($start, $limit, $user_id);

		foreach ($activities_limit as $activity)
		{
			$str .= '<tr><td>' . date('M j, Y - G:i', $activity->activity_date) . '</td><td>';

			if ((int) $activity->user_id !== 0)
			{
				$tmp = user($activity->user_id);

				$str .= '<a href="' . sef(44) . qs() . 'uid=' .
					$activity->user_id . '">' . $tmp->username . '</a><br>';
			}

			if ((int) $activity->sponsor_id !== 0)
			{
				$tmp = user($activity->sponsor_id);

				$str .= '<a href="' . sef(44) . qs() . 'uid=' .
					$activity->sponsor_id . '">' . $tmp->username . '</a><br>';
			}

			if ((int) $activity->upline_id !== 0 &&
				$activity->upline_id !== $activity->sponsor_id &&
				$activity->upline_id !== $activity->user_id)
			{
				$tmp = user($activity->upline_id);

				$str .= '<a href="' . sef(44) . qs() . 'uid=' .
					$activity->upline_id . '">' . $tmp->username . '</a><br>';
			}

			$str .= '</td>
	                <td>' . $activity->activity . '</td>
	            </tr>';
		}

		$str .= '<tbody></table>';
	}
	else
	{
		$str .= '<hr><p>No activities yet.</p>';
	}

	return $str;
}