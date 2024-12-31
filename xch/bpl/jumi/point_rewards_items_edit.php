<?php

namespace BPL\Jumi\Point_Rewards_Items_Edit;

require_once 'bpl/menu.php';
require_once 'bpl/mods/upload_image.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Upload_Image\main as upload_image;

use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\input_get;
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
	$final        = input_get('final');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$uid = input_get('uid');

		if ($uid === '')
		{
			application()->redirect(Uri::root(true) . '/' . sef(50), 'No item selected.', 'error');
		}

		if ((int) $final !== 1)
		{
			$str .= view_form($uid);
		}
		else
		{
			$item_name   = substr(input_get('item_name', '', 'RAW'), 0, 150);
			$description = substr(input_get('description', '', 'RAW'), 0, 1000);
			$price       = input_get('price');
			$quantity    = input_get('quantity');
			$avatar      = application()->input->files->get('picture');

			process_rewards_edit($avatar, $uid, $item_name, $description, $price, $quantity);
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
 * @param $uid
 *
 * @return string
 *
 * @since version
 */
function view_form($uid): string
{
	$item = items_incentive($uid);

	$str = '<h1>Edit Reward Item</h1>
        <p>All fields marked * are required.</p>
        <form name="regForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="final" value="1">
            <table class="category table table-striped table-bordered table-hover">
                <tr>
                    <td><label for="item_name">Name: *</label></td>
                    <td><input type="text" name="item_name" id="item_name" value="' . $item->item_name . '"
                               size="40" required="required"></td>
                </tr>
                <tr>
                    <td><label for="description">Description:</label></td>
                    <td><textarea name="description" id="description"
                                  style="width:70%; height:100px;">' . $item->description . '</textarea></td>
                </tr>
                <tr>
                    <td><label for="price">Price (tkn.): *</label></td>
                    <td><input type="text" name="price" id="price" size="40" value="' . $item->price . '"
                               required="required"></td>
                </tr>
                <tr>
                    <td><label for="quantity">Add Quantity (' . $item->quantity . ' items remaining): *</label>
                    </td>
                    <td>
                        <select name="quantity" id="quantity">';

	for ($ctr = 0; $ctr <= 100; $ctr++)
	{
		$str .= '<option value="' . $ctr . '">' . $ctr . '</option>';
	}

	$str .= '</select>
                    </td>
                </tr>
                <tr>
                    <td>Picture:</td>
                    <td>';

	if ($item->picture !== '')
	{
		$str .= 'Current Picture:<br>
                            <img src="images/incentive/tmb_' . $item->picture . '" alt=""><br>
                            *Changing picture might require a browser refresh (F5) to reload image.<br>';
	}

	$str .= '<input type="file" name="picture" id="picture" size="40"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" value="Save Changes" name="submit"
                                           class="uk-button uk-button-primary"></td>
                </tr>
            </table>';

	$str .= HTMLHelper::_('form.token');

	$str .= '</form>';

	return $str;
}

/**
 * @param $avatar
 * @param $uid
 *
 * @param $item_name
 * @param $description
 * @param $price
 * @param $quantity
 *
 * @since version
 */
function process_rewards_edit($avatar, $uid, $item_name, $description, $price, $quantity)
{
//	$db = db();

	Session::checkToken() or die(Text::_('Invalid Token'));

	validate_input($uid, $item_name, $price, $quantity);

//	try
//	{
//		$db->transactionStart();

		update_incentives($uid, $item_name, $description, $price, $quantity);

		upload_image($uid, $avatar, 'incentive');

//		$db->transactionCommit();
//	}
//	catch (Exception $e)
//	{
//		$db->transactionRollback();
//
//		ExceptionHandler::render($e);
//	}

	application()->redirect(Uri::root(true) . '/' . sef(52) . qs() . 'uid=' . $uid,
		'Incentive item updated.', 'notice');
}

/**
 * @param $uid
 *
 * @param $item_name
 * @param $description
 * @param $price
 * @param $quantity
 *
 * @since version
 */
function update_incentives($uid, $item_name, $description, $price, $quantity)
{
	$db = db();

	update(
		'network_items_incentive',
		[
			'item_name = ' . $db->quote($item_name),
			'description = ' . $db->quote($description),
			'price = ' . $db->quote($price),
			'quantity = quantity + ' . $db->quote($quantity)
		],
		['item_id = ' . $db->quote($uid)]
	);
}

/**
 * @param $uid
 * @param $item_name
 * @param $price
 * @param $quantity
 *
 *
 * @since version
 */
function validate_input($uid, $item_name, $price, $quantity)
{
	$app = application();

	if ($item_name === '')
	{
		$err = 'Please specify Item Name';

		$app->redirect(Uri::root(true) . '/' . sef(52) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($price === '')
	{
		$err = 'Please specify Price';

		$app->redirect(Uri::root(true) . '/' . sef(52) . qs() . 'uid=' . $uid, $err, 'error');
	}

	if ($quantity === '')
	{
		$err = 'Please specify quantity';

		$app->redirect(Uri::root(true) . '/' . sef(52) . qs() . 'uid=' . $uid, $err, 'error');
	}
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function items_incentive($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
		'WHERE item_id = ' . $db->quote($uid)
	)->loadObject();
}