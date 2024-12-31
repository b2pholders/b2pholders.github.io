<?php

namespace BPL\Jumi\Leadership_Bonus;

require_once 'bpl/menu.php';
require_once 'bpl/leadership_binary.php';
require_once 'bpl/mods/url_sef.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Leadership_Binary\view;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\page_reload;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id  = session_get('user_id');

	page_validate();

	$str = menu();

	$uid = input_get('uid');

	if ($uid)
	{
		$user_id = $uid;
	}

	$str .= page_reload();

	$str .= view(user($user_id));

	echo $str;
}