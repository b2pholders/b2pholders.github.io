<?php

namespace BPL\Jumi\Unilevel_Bonus;

require_once 'bpl/unilevel.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Unilevel\view as view_unilevel;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
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
	$uid      = input_get('uid');

	page_validate();

	$str = menu();

	if ($uid)
	{
		$user_id = $uid;
	}

	$str .= page_reload();

	$str .= view_unilevel($user_id);

	echo $str;
}