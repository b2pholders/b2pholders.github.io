<?php

namespace BPL\Mods\Genealogy_Matrix_Table;

require_once 'bpl/ajax/ajaxer/genealogy.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\Genealogy\main as genealogy;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 *
 *
 * @since version
 */
function main($type = 'basic')
{
	$user_id  = session_get('user_id');

	page_validate();

	$str = menu();

	$uid = input_get('uid');

	if ($uid !== '')
	{
		$user_id = $uid;
	}

	if (!empty(user_matrix_table($user_id, $type)))
	{
		$str .= '<h1>' . settings('plans')->table_matrix_name . ' 2</h1>';
		$str .= genealogy('matrix_table_' . $type, $user_id, 'matrix_table');
	}

	echo $str;
}

/**
 * @param $user_id
 * @param $type
 *
 * @return array|mixed
 *
 * @since version
 */
function user_matrix_table($user_id, $type)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_share_' . $type .
		' WHERE user_id = ' . $db->quote($user_id) .
		' AND has_mature = ' . $db->quote(0) .
		' AND is_active = ' . $db->quote(1)
	)->loadObjectList();
}