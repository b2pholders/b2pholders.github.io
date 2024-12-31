<?php

namespace BPL\Jumi\Repeat_Purchase_Items_Edit;

require_once 'bpl/menu.php';
require_once 'bpl/mods/upload_image.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

//use Exception;

use Joomla\CMS\Uri\Uri;

//use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Upload_Image\main as upload_image;

use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;

//try {
main();
/*} catch (Exception $e) {
}*/

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	$uid = input_get('uid');

	if ($uid === '')
	{
		application()->redirect(Uri::root(true) . '/' . sef(69),
			'Please select an item to edit.', 'error');
	}

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ((int) input_get('final') !== 1)
		{
			$str .= view_form($uid);
		}
		else
		{
			$item         = substr(input_get('item_name_edit', '', 'RAW'), 0, 150);
			$category     = input_get('item_cat_add', 'none', 'RAW');
			$description  = substr(input_get('description_edit', '', 'RAW'), 0, 1000);
			$details      = substr(input_get('details_edit', '', 'RAW'), 0, 1000);
			$price        = input_get('price_edit');
			$price_retail = input_get('price_retail_edit');
			$qty          = input_get('quantity_edit');
			$binary_pts   = input_get('binary_points_edit');
			$unilevel_pts = input_get('unilevel_points_edit');
			$reward_pts   = input_get('reward_points_edit');
			$avatar       = application()->input->files->get('picture_edit');

			process_items_edit(
				$avatar,
				$uid,
				$item,
				$category,
				$description,
				$details,
				$price,
				$price_retail,
				$qty,
				$binary_pts,
				$unilevel_pts,
				$reward_pts
			);
		}
	}

	echo $str;
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
 *
 * @param $uid
 *
 * @return string
 *
 * @since version
 */
function view_form($uid): string
{
	$currency = settings('ancillaries')->currency;

	$item = items_repeat($uid);

	$str = '<div style="float:right; margin-top:15px"><a href="' .
		sef(69) . '" class="uk-button uk-button-primary">Back</a></div>';
	$str .= '<h1>Edit Online Shop Item</h1>';

	$str .= '<form name="regForm" method="post" enctype="multipart/form-data">';
	$str .= '<input type="hidden" name="final" value="1">';
	$str .= '<table class="category table table-striped table-bordered table-hover">';
	$str .= '<tr><td colspan="2"><p>All fields marked * are required.</p></td></tr>';

	$str .= '<tr>';
	$str .= '<td><label for="item_name_edit">Name: *</label></td>';
	$str .= '<td><input name="item_name_edit" id="item_name_edit" value="' . $item->item_name .
		'" size="40" required></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="item_cat_add">Category: *</label></td>';
	$str .= '<td>';
	$str .= '<select name="item_cat_add" id="item_cat_add">';
	$str .= view_option_cat(cat_single($item->cat_id));
	$str .= '</select>';
	$str .= '</td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="description_edit">Description:</label></td>';
	$str .= '<td><textarea name="description_edit" id="description_edit" style="width:70%; height:100px;">' .
		$item->description . '</textarea></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="details_edit">Details:</label></td>';
	$str .= '<td><textarea name="details_edit" id="details_edit" style="width:70%; height:100px;">' .
		$item->details . '</textarea></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="price_edit">Price (' . $currency . '): *</label></td>';
	$str .= '<td><input name="price_edit" id="price_edit" size="40" value="' . $item->price . '" required></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="price_retail_edit">Price Retail (' . $currency . '): *</label></td>';
	$str .= '<td><input name="price_retail_edit" id="price_retail_edit" size="40" value="' .
		$item->price_retail . '" required></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="binary_points_edit">Binary Points: *</label></td>';
	$str .= '<td><input name="binary_points_edit" id="binary_points_edit" size="40" value="' .
		$item->binary_points . '" required></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="unilevel_points_edit">Unilevel Points: *</label></td>';
	$str .= '<td><input name="unilevel_points_edit" id="unilevel_points_edit" size="40" value="' .
		$item->unilevel_points . '" required></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="reward_points_edit">Rewards Points: *</label></td>';
	$str .= '<td><input name="reward_points_edit" id="reward_points_edit" size="40" value="' .
		$item->reward_points . '" required></td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td><label for="quantity_edit">Add Quantity (' . ($item->quantity) . ' items remaining): *</label></td>';
	$str .= '<td>';
	$str .= '<select name="quantity_edit" id="quantity_edit">';

	for ($ctr = 0; $ctr <= 100; $ctr++)
	{
		$str .= '<option value="' . $ctr . '">' . $ctr . '</option>';
	}

	$str .= '</select>';
	$str .= '</td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td>Picture:</td>';
	$str .= '<td>';

	if ($item->picture !== '')
	{
		$str .= 'Current Picture:<br>';
		$str .= '<img src="images/repeat/tmb_' . $item->picture . '" alt=""><br>';
		$str .= '*Changing picture might require a browser refresh (F5) to reload image.<br>';
	}

	$str .= '<input type="file" name="picture_edit" id="picture_edit" size="40">';
	$str .= '</td>';
	$str .= '</tr>';

	$str .= '<tr>';
	$str .= '<td colspan="2" style="text-align: center">';
	$str .= '<input type="submit" value="Save Changes" name="submit" class="uk-button uk-button-primary">';
	$str .= '</td>';
	$str .= '</tr>';

	$str .= '</table>';
	$str .= HTMLHelper::_('form.token');
	$str .= '</form>';

	return $str;
}

function view_option_cat($category): string
{
	$cat_list = cat_all();

	$str = '';

	if (!empty($cat_list))
	{
		if ($category === 'none')
		{
			$str .= '<option value="none" selected="" disabled>Select Category</option>';
		}

		foreach ($cat_list as $cat)
		{
			$value  = $cat->category;
			$option = ucwords($value);

			$str .= '<option value="' . $cat->cat_id . '" ' .
				($value === $category ? ' selected' : '') . ' >' . $option . '</option>' . "\n";
		}
	}

	return $str;
}

function cat_all()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_product_category'
	)->loadObjectList();
}

function cat_single($cat_id): string
{
	$db = db();

	$result = $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_product_category ' .
		'WHERE cat_id = ' . $db->quote($cat_id)
	)->loadObject();

	return $result ? $result->category : 'none';
}

/**
 * @param $avatar
 * @param $uid
 * @param $item_name
 * @param $category
 * @param $description
 * @param $details
 * @param $price
 * @param $price_retail
 * @param $quantity
 * @param $binary_points
 * @param $unilevel_points
 * @param $reward_points
 *
 *
 * @since version
 */
function process_items_edit(
	$avatar,
	$uid,
	$item_name,
	$category,
	$description,
	$details,
	$price,
	$price_retail,
	$quantity,
	$binary_points,
	$unilevel_points,
	$reward_points
)
{
//	$db = db();

	Session::checkToken() or die(Text::_('Invalid Token'));

	validate_input(
		$uid,
		$item_name,
		$category,
		$price,
		$price_retail,
		$quantity,
		$binary_points,
		$unilevel_points,
		$reward_points
	);

//	try
//	{
//		$db->transactionStart();

	update_items(
		$uid,
		$item_name,
		$category,
		$description,
		$details,
		$price,
		$price_retail,
		$quantity,
		$binary_points,
		$unilevel_points,
		$reward_points
	);

	upload_image($uid, $avatar);

//		$db->transactionCommit();
//	}
//	catch (Exception $e)
//	{
//		$db->transactionRollback();
//
//		ExceptionHandler::render($e);
//	}

	application()->redirect(Uri::root(true) . '/' . sef(71) . qs() .
		'uid=' . $uid, 'Online Shop item inventory updated.', 'notice');
}

/**
 * @param $uid
 * @param $item_name
 * @param $category
 * @param $description
 * @param $details
 * @param $price
 * @param $price_retail
 * @param $quantity
 * @param $binary_points
 * @param $unilevel_points
 * @param $reward_points
 *
 *
 * @since version
 */
function update_items(
	$uid,
	$item_name,
	$category,
	$description,
	$details,
	$price,
	$price_retail,
	$quantity,
	$binary_points,
	$unilevel_points,
	$reward_points
)
{
	$db = db();

	update(
		'network_items_repeat',
		[
			'item_name = ' . $db->quote($item_name),
			'cat_id = ' . $db->quote($category),
			'description = ' . $db->quote($description),
			'details = ' . $db->quote($details),
			'price = ' . $db->quote($price),
			'price_retail = ' . $db->quote($price_retail),
			'quantity = quantity + ' . $quantity,
			'binary_points = ' . $db->quote($binary_points),
			'unilevel_points = ' . $db->quote($unilevel_points),
			'reward_points = ' . $db->quote($reward_points)
		],
		['item_id = ' . $db->quote($uid)]
	);
}

/**
 * @param $uid
 * @param $item_name
 * @param $category
 * @param $price
 * @param $price_retail
 * @param $quantity
 * @param $binary_points
 * @param $unilevel_points
 * @param $reward_points
 *
 *
 * @since version
 */
function validate_input(
	$uid,
	$item_name,
	$category,
	$price,
	$price_retail,
	$quantity,
	$binary_points,
	$unilevel_points,
	$reward_points
)
{
	$app = application();

//    if ($uid === '') {
//        $err = 'No item selected.';
//
//        $app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
//    }

	if ($item_name === '')
	{
		$err = 'Please specify Item Name';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($category === 'none')
	{
		$err = 'Please specify Item Category';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($price === '')
	{
		$err = 'Please specify Price';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($price_retail === '')
	{
		$err = 'Please specify Retail Price';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($quantity === '')
	{
		$err = 'Please specify quantity';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($binary_points === '')
	{
		$err = 'Please specify Binary points';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($unilevel_points === '')
	{
		$err = 'Please specify Unilevel points';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($reward_points === '')
	{
		$err = 'Please specify Reward points';

		$app->redirect(Uri::root(true) . '/' . sef(71) . qs() . 'uid=' . $uid, $err, 'error');
	}
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function items_repeat($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_repeat ' .
		'WHERE item_id = ' . $db->quote($uid)
	)->loadObject();
}