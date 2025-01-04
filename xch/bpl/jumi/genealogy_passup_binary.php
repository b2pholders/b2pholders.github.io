<?php

namespace BPL\Jumi\Genealogy_Passup_Binary;

require_once 'bpl/ajax/ajaxer/genealogy.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\Genealogy\main as genealogy;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\settings;

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

	if ($uid !== '') {
		$user_id = $uid;
	}

	$str .= '<h1>' . settings('plans')->passup_binary_name . ' Structure</h1>';
	$str .= genealogy('binary', $user_id, 'passup_binary');

	echo $str;
}