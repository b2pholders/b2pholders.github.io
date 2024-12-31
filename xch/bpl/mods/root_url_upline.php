<?php

namespace BPL\Mods\Root_Url_Upline;

/**
 *
 * @return string
 *
 * @since version
 */
function main(): string
{
	$scriptName = explode('/', $_SERVER['SCRIPT_NAME']);

	array_pop($scriptName);
	array_pop($scriptName);

	return implode('/', $scriptName);
}