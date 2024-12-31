<?php

namespace BPL\Jumi\Indirect_Bonus;

require_once 'bpl/indirect_referral.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Indirect_Referral\view as view_indirect_bonus;

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

	if ($uid)
	{
		$user_id = $uid;
	}

	$str .= page_reload();
	$str .= view_indirect_bonus($user_id);

	echo $str;
}