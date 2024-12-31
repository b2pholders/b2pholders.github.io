<?php

namespace BPL\Jumi\Slogin;

require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\session_set;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$admintype = session_get('admintype');
	$spassword = input_get('spassword');
	$susername = input_get('susername');

	$str = '';

	if ($susername === '')
	{
		$str .= view($admintype);
	}
	else
	{
		slogin($susername, $spassword);
	}

	echo $str;
}

/**
 * @param $admintype
 *
 * @return string
 *
 * @since version
 */
function view($admintype): string
{
	$str = '';

	if ($admintype === 'Super')
	{
		$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
				<div class="uk-form-row" style="width: 200px; padding-top: 21px; margin-left: auto; margin-right: auto">
					<a href="' . sef(96) . '" class="uk-button">Superlogout</a>
				</div>
			</div></div></section>';
	}
	else
	{
		$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
				<h1>Superlogin</h1>
				<form class="uk-form" name="sform" method="post" style="width: 200px; padding-top: 21px; margin-left: auto; margin-right: auto">
					<div class="uk-form-row">
						<input class="uk-width-1-1" name="susername" size="18" placeholder="Username" type="text">
					</div>
	
					<div class="uk-form-row">
						<input class="uk-width-1-1" name="spassword" size="18" placeholder="Password" type="password">
					</div>
	
					<div class="uk-form-row">
						<button class="uk-button uk-button-primary" value="Log in" name="slogin" type="submit">
							Login
						</button>
					</div>
				</form>
			</div></div></section>';
	}

	return $str;
}

/**
 * @param $susername
 * @param $spassword
 *
 * @return array|mixed
 *
 * @since version
 */
function admin_get($susername, $spassword)
{
	$db = db();

	return $db->setQuery(
		'SELECT admintype ' .
		'FROM network_admin ' .
		'WHERE username = ' . $db->quote($susername) .
		' AND password = ' . $db->quote(md5($spassword))
	)->loadObjectList();
}

/**
 * @param $susername
 * @param $spassword
 *
 *
 * @since version
 */
function slogin($susername, $spassword)
{
	$app = application();

	$result = admin_get($susername, $spassword);

	if (!empty($result))
	{
		session_set('admintype', $result[0]->admintype);

		$app->redirect(Uri::root(true) . '/' . sef(43));
	}
	else
	{
		$app->redirect(Uri::root(true) . '/' . sef(43), 'Super Login Failed!', 'error');
	}
}