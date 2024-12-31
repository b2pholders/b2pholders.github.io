<?php

namespace BPL\Mods\Genealogy_Harvest;

require_once 'bpl/ajax/ajaxer/genealogy.php';
require_once 'bpl/harvest.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\Genealogy\main as genealogy;

use function BPL\Harvest\view as view_list;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main($type = 'basic')
{
	$user_id = session_get('user_id');

	$uid = input_get('uid');
	$lid = input_get('lid');

	page_validate();

	$str = menu();

	if ($lid !== '')
	{
		$user_id = $lid;

		$uid = '';
	}

	if ($uid !== '')
	{
		$user_id = $uid;

		$lid = '';
	}

	if ($lid !== '')
	{
		$str .= view_list(user($user_id), $type);
	}
	elseif (user_harvest($user_id, $type))
	{
		$str .= '<h3>' . type_alias($type) . ' Harvest<span style="float: right"><a href="' .
			sef(22) . qs() . 'lid=' . $user_id . '" style="font-size: medium">View List</a></span></h3>';

		$str .= genealogy('harvest_' . $type, $user_id, 'harvest');
	}

	echo $str;
}

/**
 * @param   string  $type
 *
 * @return string
 *
 * @since version
 */
function type_alias(string $type = 'basic'): string
{
	$alias = 'Bronze';

	if ($type === 'associate')
	{
		$alias = 'Silver';
	}

	return $alias;
}

/**
 * @param $user_id
 * @param $type
 *
 * @return array|mixed
 *
 * @since version
 */
function user_harvest($user_id, $type)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_harvest_' . $type .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObjectList();
}