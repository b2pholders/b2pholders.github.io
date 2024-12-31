<?php

namespace BPL\Jumi\Settings_Harvest;

require_once 'bpl/menu.php';
require_once 'bpl/settings/harvest.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;

use function BPL\Menu\admin as menu_admin;

use function BPL\Settings\Harvest\update as update_settings_harvest;
use function BPL\Settings\Harvest\view as view_settings_harvest;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$admintype    = session_get('admintype');
	$usertype     = session_get('usertype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate($usertype, $admintype);

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	try
	{
		update_settings_harvest();
	}
	catch (Exception $e)
	{
	}

	$str .= view_settings_harvest();

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 *
 *
 * @since version
 */
function page_validate($usertype, $admintype)
{
	if ($usertype !== 'Admin' && $admintype !== 'Super')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}