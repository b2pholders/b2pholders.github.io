<?php

namespace BPL\Jumi\Genealogy_Echelon;

require_once 'bpl/ajax/ajaxer/genealogy.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\Genealogy\main as genealogy;

use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\session_get;
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
	$user_id = input_get('uid') ?: session_get('user_id');

	page_validate();

	$str = menu();

	$str .= '<h1>' . settings('plans')->echelon_name . ' Structure</h1>';
	$str .= genealogy('indirect', $user_id, 'echelon');

	echo $str;
}