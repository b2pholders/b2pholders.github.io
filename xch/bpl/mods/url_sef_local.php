<?php

namespace BPL\Mods\Local\Url_SEF;

require_once '../../configuration.php';
require_once 'query_local.php';

use JConfig;

use function BPL\Mods\Local\Database\Query\fetch;

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

	$config = new JConfig();

	if ($config->sef && $config->sef_rewrite)
	{
		$path = fetch(
			'SELECT path ' .
			'FROM joomla_menu ' .
			'WHERE link LIKE :link',
			['link' => ('%=' . $id)]
		);

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
	$config = new JConfig();

	return ($config->sef && $config->sef_rewrite) ? '?' : '&';
}