<?php

namespace BPL\Jumi\Echelon_Bonus;

require_once 'bpl/echelon_bonus.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Echelon_Bonus\view as view_echelon_bonus;

use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\page_reload;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');

	page_validate();

	$str = menu();

	$uid = input_get('uid');

	if ($uid) {
		$user_id = $uid;
	}

	$str .= page_reload();
	$str .= view_echelon_bonus($user_id);

	echo $str;
}