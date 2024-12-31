<?php

namespace BPL\Mods\Url_SEF;

require_once 'bpl/mods/helpers.php';

use JConfig;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;

use function BPL\Mods\Helpers\db;

/**
 *
 * @return JConfig|Registry|object
 *
 * @since version
 */
function config_get()
{
	$conf = Factory::getConfig();

	return !is_null($conf) ? $conf : (object) [];
}

/**
 * @param $id
 *
 * @return string
 *
 * @since version
 */
function sef($id): string
{
	$default = '?option=com_jumi&view=application&fileid=' . $id;

	$conf = config_get();

	if ($conf->get('sef') && $conf->get('sef_rewrite'))
	{
		$db = db();

		$path = $db->setQuery(
			'SELECT path ' .
			'FROM #__menu ' .
			'WHERE link LIKE ' . $db->quote('%=' . $id)
		)->loadObject();

		return $path->path ?? $default;
	}

	return $default;
}

/**
 *
 * @return string
 *
 * @since version
 */
function qs(): string
{
	$conf = config_get();

	return ($conf->get('sef') && $conf->get('sef_rewrite')) ? '?' : '&';
}