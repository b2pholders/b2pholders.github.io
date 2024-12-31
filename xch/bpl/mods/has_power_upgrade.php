<?php

namespace BPL\Mods\Has_Power_Upgrade;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 * @param $type
 *
 * @return bool
 *
 * @since version
 */
function main($type): bool
{
	return count(has_column_power($type)) > 0 &&
		settings('power')->{$type . '_upgrade'} > 0;
}

/**
 * @param $type
 *
 * @return array|mixed
 *
 * @since version
 */
function has_column_power($type)
{
	$db = db();

	return $db->setQuery(
		'SHOW COLUMNS ' .
		'FROM network_settings_power ' .
		'LIKE ' . $db->quote($type . '_upgrade')
	)->loadObjectList();
}