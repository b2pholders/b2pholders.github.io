<?php

namespace BPL\Jumi\Settings_Entry;

require_once 'bpl/menu.php';
require_once 'bpl/settings/entry.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Menu\admin as menu_admin;

use function BPL\Settings\Entry\update as update_settings_entry;
use function BPL\Settings\Entry\view as view_settings_entry;

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
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	page_validate($usertype, $admintype);

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	update_settings_entry();

	$str .= view_settings_entry();

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