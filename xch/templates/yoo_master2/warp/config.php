<?php
/**
 * @package   Warp Theme Framework
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use Joomla\CMS\Factory;

$conf = Factory::getConfig();

$panel = !0 ? '' : '<div class="uk-panel">
		<ul class="uk-subnav uk-subnav-line uk-flex-center">
			<li><a href="https://web.facebook.com/Bitcoin-30-107227648696434">Facebook</a></li>
			<li><a href="https://twitter.com/Bitcoin3T">Twitter</a></li>		
		</ul>
	</div>';

function session_get_cfg($name, string $default = '')
{
	$session = Factory::getSession();

	$session = !is_null($session) ? $session : (object) [];

	return $session->get($name, $default);
}

$user_id = session_get_cfg('user_id');

$panel .= $user_id ? '' : '<div class="uk-panel">
	Copyright &copy; ' . date('Y') .
	' <a href="javascript:void(0)">' . $conf->get('sitename') . '</a>
	</div>';

return array(

	'helper' => array(
		'asset'       => 'Warp\Helper\AssetHelper',
		'assetfilter' => 'Warp\Helper\AssetfilterHelper',
		'check'       => 'Warp\Helper\CheckHelper',
		'checksum'    => 'Warp\Helper\ChecksumHelper',
		'dom'         => 'Warp\Helper\DomHelper',
		'event'       => 'Warp\Helper\EventHelper',
		'field'       => 'Warp\Helper\FieldHelper',
		'http'        => 'Warp\Helper\HttpHelper',
		'menu'        => 'Warp\Helper\MenuHelper',
		'path'        => 'Warp\Helper\PathHelper',
		'template'    => 'Warp\Helper\TemplateHelper',
		'useragent'   => 'Warp\Helper\UseragentHelper'
	),

	'path' => array(
		'warp'    => array(__DIR__),
		'config'  => array(__DIR__ . '/config'),
		'js'      => array(__DIR__ . '/js', __DIR__ . '/vendor/uikit/js'),
		'layouts' => array(__DIR__ . '/layouts')
	),

	'menu'     => array(
		'pre'    => 'Warp\Menu\Menu',
		'post'   => 'Warp\Menu\Post',
		'nav'    => 'Warp\Menu\Nav',
		'navbar' => 'Warp\Menu\Navbar',
		'subnav' => 'Warp\Menu\Subnav'
	),

	/*'branding' => 'Powered by <a href="http://www.yootheme.com">Warp Theme Framework</a>'*/
	/*'branding' => 'Copyright &copy; ' . date('Y') .
		' <a href="javascript:void(0)">' . $conf->get('sitename') . '</a>'*/

	'branding' => $panel
);
