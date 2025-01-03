<?php

namespace BPL\Mods\Helpers;

require_once 'bpl/menu.php';
require_once 'bpl/mods/url_sef.php';

use DateTime;
use DateTimeZone;
use Exception;
use JDatabaseDriver;

use JInput;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

/**
 *
 * @return string
 *
 * @since version
 */
function menu(): string
{
	$username = session_get('username');
	$usertype = session_get('usertype');
	$admintype = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id = session_get('user_id');

	$str = '';

	switch ($usertype) {
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);

			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);

			break;
	}

	return $str;
}

/**
 * @param           $p
 * @param           $src
 * @param           $sef
 * @param           $rows
 * @param   string  $q
 *
 * @return string
 *
 * @since version
 */
function paginate($p, $src, $sef, $rows, string $q = 'pg'): string
{
	$p = (int) $p;

	$lim_to = $rows;
	$lim_from = $lim_to * ($p);

	$total = count($src);

	$last = ($total - $total % $lim_to) / $lim_to;

	$str = '<div style="float:right; margin-top:30px;">';

	if ($total > $rows) {
		if ((int) $p > 0) {
			$str .= '<a href="' . sef($sef) . qs() . $q . '=' . (0) . '" class="uk-button uk-button-danger">';
			$str .= '<i class="uk-icon-arrow-left" data-uk-tooltip title="First"></i>';
			$str .= '</a>';

			$str .= '<a href="' . sef($sef) . qs() . $q . '=' . ($p - 1) . '" class="uk-button uk-button-primary">';
			$str .= '<i class="uk-icon-chevron-left" data-uk-tooltip title="Prev"></i>';
			$str .= '</a>';
		}

		if ($total > ($lim_from + $lim_to)) {
			$str .= '<a href="' . sef($sef) . qs() . $q . '=' . ($p + 1) . '" class="uk-button uk-button-danger">';
			$str .= '<i class="uk-icon-chevron-right" data-uk-tooltip title="Next"></i>';
			$str .= '</a>';

			$str .= '<a href="' . sef($sef) . qs() . $q . '=' . ($last) . '" class="uk-button uk-button-primary">';
			$str .= '<i class="uk-icon-arrow-right" data-uk-tooltip title="Last"></i>';
			$str .= '</a>';
		}
	}

	$str .= '</div>';

	return $str;
}

/**
 *
 *
 * @since version
 */
function page_validate()
{
	if (session_get('usertype') === '') {
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

function restrict_page()
{
	application()->redirect(Uri::root(true) . '/' . sef(43));
}

/**
 * @param $usertype
 * @param $admintype
 *
 *
 * @since version
 */
function page_validate_admin($usertype, $admintype)
{
	if ($usertype === '' || $admintype !== 'Super') {
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

/**
 * @param $username
 *
 * @return mixed|null
 *
 * @since version
 */
function user_username($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username)
	)->loadObject();
}

/**
 *
 * @param   int  $s
 *
 * @return string
 *
 * @since version
 */
function page_reload(int $s = 30000): string
{
	$str = '<script>';
	$str .= 'setInterval(() => {
			window.location.reload();
		}, ' . $s . ');';
	$str .= '</script>';

	return $str;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function users()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' .
		$db->quote('starter')
	)->loadObjectList();
}

/**
 * @param $type
 *
 * @return mixed|null
 *
 * @since version
 */
function settings($type)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_' . $type
	)->loadObject();
}

// /**
//  *
//  * @return CMSApplication|object
//  *
//  * @since version
//  */
// function application()
// {
// 	$app = null;

// 	try
// 	{
// 		$app = Factory::getApplication();
// 	}
// 	catch (Exception $e)
// 	{
// 	}

// 	return !is_null($app) ? $app : (object) [];
// }

/**
 * Get the Joomla application instance.
 *
 * @return CMSApplication|object The Joomla application instance.
 * @throws Exception If the application instance cannot be retrieved.
 */
function application()
{
	static $app = null;

	// If the application instance is already cached, return it
	if ($app instanceof CMSApplication) {
		return $app;
	}

	// Try to get the Joomla application instance
	try {
		$app = Factory::getApplication();
	} catch (Exception $e) {
		throw new Exception('Unable to retrieve Joomla application instance.');
	}

	// Ensure the application instance is valid
	if (!($app instanceof CMSApplication)) {
		throw new Exception('Invalid Joomla application instance.');
	}

	return $app;
}

/**
 * @param $name
 * @param $value
 *
 * @return mixed
 *
 * @since version
 */
function session_set($name, $value)
{
	$session = Factory::getSession();

	$session = !is_null($session) ? $session : (object) [];

	return $session->set($name, $value);
}

/**
 * @param           $name
 * @param   string  $default
 *
 * @return mixed|null
 *
 * @since version
 */
function session_get($name, string $default = '')
{
	$session = Factory::getSession();

	$session = !is_null($session) ? $session : (object) [];

	return $session->get($name, $default);
}

/**
 * @param           $name
 * @param   string  $default
 * @param   null    $filter
 *
 * @return string
 *
 * @since version
 */
function input_get($name, string $default = '', $filter = null): string
{
	$input = application()->input;

	$input = !is_null($input) ? $input : (object) [];

	return $filter === null ?
		$input->get($name, $default) :
		$input->get($name, $default, $filter);
}

/**
 *
 * @return JInput|object
 *
 * @throws Exception
 * @since version
 */
function input()
{
	$input = application()->input;

	return !is_null($input) ? $input : (object) [];
}

/**
 *
 * @return JDatabaseDriver|object
 *
 * @since version
 */
function db()
{
	$db = Factory::getDbo();

	return !is_null($db) ? $db : (object) [];
}

/**
 *
 * @return string
 *
 * @since version
 */
function time(): string
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));

	return $time->format('U');
}

/**
 * @param           $sef
 * @param           $message
 * @param   string  $type
 *
 *
 * @since version
 */
function alert($sef, $message, string $type = 'error')
{
	application()->redirect(Uri::root(true) . '/' . sef($sef), $message, $type);
}