<?php

namespace BPL\Jumi\Repeat_Purchase_Items_Add;

require_once 'bpl/menu.php';
require_once 'bpl/mods/upload_image.php';
require_once 'bpl/mods/category_items.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

use function BPL\Mods\Database\Query\insert;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Upload_Image\main as upload_image;

use function BPL\Mods\Category_Items\view_option_cat;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;

//try {
main();
//} catch (Exception $e) {
//}

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

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ((int) input_get('final') !== 1)
		{
			$str .= view_form();
		}
		else
		{
			$item         = substr(input_get('item_name_add', '', 'RAW'), 0, 150);
			$category     = input_get('item_cat_add', 'none', 'RAW');
			$description  = substr(input_get('description_add', '', 'RAW'), 0, 1000);
			$details      = substr(input_get('details_add', '', 'RAW'), 0, 1000);
			$price        = input_get('price_add', 0);
			$price_retail = input_get('price_retail_add', 0);
			$qty          = input_get('quantity_add', 0);
			$binary_pts   = input_get('binary_points_add', 0);
			$reward_pts   = input_get('reward_points_add', 0);
			$avatar       = application()->input->files->get('picture_add');

			process_items_add(
				$avatar,
				$item,
				$category,
				$description,
				$details,
				$price,
				$price_retail,
				$qty,
				$binary_pts,
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
 * @return string
 *
 * @since version
 */
function view_form(): string
{
	$str = '<div style="float:right; margin-top:15px"><a href="' . sef(69) .
		'" class="uk-button uk-button-primary">Back</a></div>';
	$str .= '<h1>Add Online Shop Items</h1>';
	$str .= '<form name="regForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="final" value="1">
            <table class="category table table-striped table-bordered table-hover">
            	<tr><td colspan="2"><p>All fields marked * are required.</p></td></tr>';
	$str .= '<tr>
                    <td style="width: 200px"><label for="item_name_add">Name: *</label></td>
                    <td><input name="item_name_add" id="item_name_add" size="40" required></td>
                </tr>';

	$str .= '<tr>
                    <td><label for="item_cat_add">Category: *</label></td>
                    <td>';
	$str .= '<select name="item_cat_add" id="item_cat_add">';
	$str .= '<option value="none" selected="" disabled>Select Category</option>';
	$str .= view_option_cat();
	$str .= '</select>';
	$str .= '</td>
                </tr>';

	$str .= '<tr>
                    <td><label for="description_add">Description:</label></td>
                    <td><textarea name="description_add" id="description_add" style="width:70%; height:100px;"></textarea></td>
                </tr>';

	$str .= '<tr>
                    <td><label for="details_add">Details:</label></td>
                    <td><textarea name="details_add" id="details_add" style="width:70%; height:100px;"></textarea></td>
                </tr>';
	$str .= '<tr>
                    <td style="width: 200px"><label for="price_add">Price (' .
		settings('ancillaries')->currency . '): *</label></td>
                    <td><input name="price_add" id="price_add" size="40" required></td>
                </tr>';
	$str .= '<tr>
                    <td style="width: 200px"><label for="price_retail_add">Price Retail (' .
		settings('ancillaries')->currency . '): *</label></td>
                    <td><input name="price_retail_add" id="price_retail_add" size="40" required></td>
                </tr>';

	$str .= (!settings('plans')->binary_pair ? '' : '
                <tr>
                    <td><label for="binary_points_add">Binary Points: *</label></td>
                    <td><input name="binary_points_add" id="binary_points_add" size="40" required></td>
                </tr>');

	$str .= '<tr>
                    <td><label for="reward_points_add">Reward Points: *</label></td>
                    <td><input name="reward_points_add" id="reward_points_add" size="40" required></td>
                </tr>';

	/* *
	 * Quantity - fungible
	 * Declare initial value
	 * Allow only addition
	 */

	$str .= '<tr>
                    <td><label for="quantity_add">Quantity: *</label></td>
                    <td>';
	$str .= '<select name="quantity_add" id="quantity_add">';

	for ($ctr = 0; $ctr <= 1000; $ctr++)
	{
		$str .= '<option value="' . $ctr . '">' . $ctr . '</option>';
	}

	$str .= '</select>';
	$str .= '</td>
                </tr>';
	$str .= '<tr>
                    <td><label for="picture_add">Picture:</label></td>
                    <td><input type="file" name="picture_add" id="picture_add" size="40"></td>
                </tr>';
	$str .= '<tr>
                    <td colspan="2" style="text-align: center"><input type="submit" value="Add Item" name="submit"
                                           class="uk-button uk-button-primary"></td>
                </tr>';
	$str .= '</table>';
	$str .= HTMLHelper::_('form.token');
	$str .= '</form>';

	return $str;
}

//function view_option_cat(): string
//{
//    $cat_list = cat_all();
//
//    $str = '';
//
//    if (!empty($cat_list)) {
//        foreach ($cat_list as $cat) {
//            $value = $cat->category;
//            $option = ucwords($value);
//
//            $str .= '<option value="' . $cat->cat_id . '">' . $option . '</option>' . "\n";
//        }
//    }
//
//    return $str;
//}

//function cat_all()
//{
//    $db = db();
//
//    return $db->setQuery(
//        'SELECT * ' .
//        'FROM network_settings_product_category'
//    )->loadObjectList();
//}

/**
 * @param $avatar
 * @param $item_name
 * @param $category
 * @param $description
 * @param $details
 * @param $price
 * @param $price_retail
 * @param $quantity
 * @param $binary_points
 * @param $reward_points
 *
 *
 * @since version
 */
function process_items_add(
	$avatar,
	$item_name,
	$category,
	$description,
	$details,
	$price,
	$price_retail,
	$quantity,
	$binary_points,
	$reward_points
)
{
	$db = db();

	Session::checkToken() or die(Text::_('Invalid Token'));

	validate_input($item_name, $category, $price, $price_retail, $quantity, $binary_points, $reward_points);

	insert_items(
		$item_name,
		$category,
		$description,
		$details,
		$price,
		$price_retail,
		$quantity,
		$binary_points,
		$reward_points
	);

	upload_image($db->insertid(), $avatar);

	application()->redirect(Uri::root(true) . '/' .
		sef(69), 'Online Shop item added.', 'notice');
}

/**
 * @param $item_name
 * @param $category
 * @param $description
 * @param $details
 * @param $price
 * @param $price_retail
 * @param $quantity
 * @param $binary_points
 * @param $reward_points
 *
 *
 * @since version
 */
function insert_items(
	$item_name,
	$category,
	$description,
	$details,
	$price,
	$price_retail,
	$quantity,
	$binary_points,
	$reward_points)
{
	$db = db();

	insert(
		'network_items_repeat',
		[
			'item_name',
			'description',
			'cat_id',
			'details',
			'price',
			'price_retail',
			'quantity',
			'binary_points',
			'reward_points'],
		[
			$db->quote($item_name),
			$db->quote($description),
			$db->quote($category),
			$db->quote($details),
			$db->quote($price),
			$db->quote($price_retail),
			$db->quote($quantity),
			$db->quote($binary_points),
			$db->quote($reward_points)
		]
	);
}

/**
 * @param $item_name
 * @param $category
 * @param $price
 * @param $price_retail
 * @param $quantity
 * @param $binary_points
 * @param $reward_points
 *
 *
 * @since version
 */
function validate_input($item_name, $category, $price, $price_retail, $quantity, $binary_points, $reward_points)
{
	$app = application();

	if ($item_name === '')
	{
		$err = 'Please specify Item Name';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}

	if ($category === 'none')
	{
		$err = 'Please specify Category';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}

	if ($price === '')
	{
		$err = 'Please specify Price';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}

	if ($price_retail === '')
	{
		$err = 'Please specify Retail Price';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}

	if ((int) $quantity === 0)
	{
		$err = 'Please specify quantity';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}

	if ($binary_points === '')
	{
		$err = 'Please specify Binary Points';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}

	if ($reward_points === '')
	{
		$err = 'Please specify Reward Points';

		$app->redirect(Uri::root(true) . '/' . sef(70), $err, 'error');
	}
}