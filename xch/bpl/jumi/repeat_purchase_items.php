<?php

namespace BPL\Jumi\Repeat_Purchase_Items;

require_once 'bpl/menu.php';
require_once 'bpl/mods/repeat_items.php';
require_once 'bpl/mods/category_items.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\delete;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Repeat_Items\items;

use function BPL\Mods\Category_Items\view_modal_cat;
use function BPL\Mods\Category_Items\process_add_category;
use function BPL\Mods\Category_Items\process_update_category;
use function BPL\Mods\Category_Items\process_delete_category;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate as page_validate_purchase_items;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;

use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');
	$usertype     = session_get('usertype');

	$cat_name      = input_get('cat_name', '', 'RAW');
	$cat_to_update = input_get('cat_to_update', '', 'RAW');
	$cat_to_delete = input_get('cat_to_delete', '', 'RAW');

	$pg  = input_get('pg', 0);
	$cat = input_get('cat', 0);

	$rows = 10;

	page_validate_purchase_items();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid = input_get('uid');

	if ($cat_name !== '' && $cat_to_update === '' && $cat_to_delete === '')
	{
		process_add_category($cat_name);
	}

	if ($cat_to_update !== '' && $cat_name !== '' && $cat_to_delete === '')
	{
		process_update_category($cat_name, $cat_to_update);
	}

	if ($cat_to_delete !== '' && $cat_name === '' && $cat_to_update === '')
	{
		process_delete_category($cat_to_delete);
	}

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ($uid === '')
		{
			$str .= view_items($pg, $cat, $rows);
		}
		else
			if (input_get('final') === '')
			{
				$str .= view_confirm_delete($uid);
			}
			else
			{
				process_delete($uid);
			}
	}

	echo $str;
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function process_delete($uid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		delete_items($uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(69),
		'Online Shop item deleted.', 'notice');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function delete_items($uid)
{
	delete(
		'network_items_repeat',
		['item_id = ' . db()->quote($uid)]
	);
}

/**
 * @param $uid
 *
 * @return string
 *
 * @since version
 */
function view_confirm_delete($uid): string
{
	$str = '<h1>Confirm Delete</h1>';
	$str .= '<strong>' . item_repeat($uid)->item_name . '</strong><br><br>';
	$str .= '<a href="' . sef(69) . qs() . 'uid=' . $uid .
		'&final=1" class="uk-button uk-button-primary">Confirm Delete</a>';

	return $str;
}

/**
 *
 * @param        $pg
 * @param        $cat_id
 * @param   int  $rows
 *
 * @return string
 *
 * @since version
 */
function view_items($pg, $cat_id, int $rows = 10): string
{
	$str = '<article class="uk-article">';
	$str .= '<h1>Online Shop Items';
	$str .= '<span style="float: right">';
	$str .= '<a href="javascript:void(0)" class="uk-button uk-button-primary" 
        data-uk-modal="{target:\'#modal-cat\'}">Manage Category</a>&nbsp;';
	$str .= '<a href="' . sef(70) . '" class="uk-button uk-button-primary">Add Items</a>';
	$str .= '</span>';
	$str .= '</h1>';

	$str .= items($cat_id, $pg, $rows, 1);

	$str .= '</article>';

	$str .= view_modal_cat();

	return $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $user_id
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $user_id, $username): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function item_repeat($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_repeat ' .
		'WHERE item_id = ' . $db->quote($uid)
	)->loadObject();
}