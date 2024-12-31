<?php

namespace BPL\Jumi\Reset;

require_once 'bpl/lib/Db_Import.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use BPL\Lib\Local\Database\Db_Import;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$app = application();

	if (Db_Import::devImportSQL('bpl/sql/reset/reset.sql', db()))
	{
		$app->redirect(Uri::root(true) . '/' . sef(41), Db_Import::$message, 'success');
	}
	else
	{
		$app->redirect(Uri::root(true) . '/' . sef(41), Db_Import::$message, 'error');
	}
}