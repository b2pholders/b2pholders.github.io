<?php

namespace BPL\Jumi\System_Reset;

require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype  = session_get('usertype');
	$admintype = session_get('admintype');

	page_validate($usertype, $admintype);

	echo '<h1>Database Reset</h1>
		<p>Warning: This action is non-reversible.</p>
		<table>
		    <tr>
		        <td><a href="' . sef(77) . '" class="uk-button uk-button-primary">Reset Database</a>
		        </td>
		        <td><a href="' . sef(43) . '" class="uk-button uk-button-primary">Back to Admin</a></td>
		    </tr>
		</table>';
}

/**
 * @param $usertype
 * @param $admintype
 *
 *
 * @since version
 */
function page_validate($usertype, $admintype)
{
	if ($usertype !== 'Admin' && $admintype !== 'Super')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}
