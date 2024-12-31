<?php

namespace BPL\Ajax\Action;

require_once '../lib/Db_Connect.php';
require_once '../mods/seconds_to_time.php';
require_once '../mods/time_remaining.php';
require_once '../mods/url_sef_local.php';
require_once '../mods/helpers_local.php';

main();

/**
 *
 *
 * @since version
 */
function main()
{
	if (isset($_POST['action']) && !empty($_POST['action']) && is_ajax())
	{
		$dir = 'mods/';
		$ext = '.php';

		require_once $dir . $_POST['action'] . $ext;
	}
}

/**
 *
 * @return bool
 *
 * @since version
 */
function is_ajax(): bool
{
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}

