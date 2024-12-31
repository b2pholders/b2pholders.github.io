<?php

namespace BPL\Jumi\Repeat_Purchase_Merchants_Edit;

require_once 'bpl/menu.php';
require_once 'bpl/mods/upload_image.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;
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
use function BPL\Mods\Helpers\application;

try {
    main();
} catch (Exception $e) {
}

/**
 *
 *
 * @throws Exception
 * @since version
 */
function main()
{
    $usertype = session_get('usertype');
    $admintype = session_get('admintype');
    $account_type = session_get('account_type');
    $user_id = session_get('user_id');
    $username = session_get('username');

    page_validate();

    $str = menu($usertype, $admintype, $account_type, $user_id, $username);

    if ($usertype === 'Admin' || $usertype === 'manager') {
        $uid = input_get('uid');

        if ((int)input_get('final') !== 1) {
            $str .= view_form($uid);
        } else {
            $merchant_name = substr(input_get('merchant_name_edit', '', 'RAW'), 0, 150);
            $description = substr(input_get('description_edit', '', 'RAW'), 0, 1000);
            $details = substr(input_get('details_edit', '', 'RAW'), 0, 1000);
            $avatar = application()->input->files->get('picture_edit');

            process_merchant_edit($avatar, $uid, $merchant_name, $description, $details);
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

    switch ($usertype) {
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
    $merchant = items_merchant_all($uid);

    $str = '<div style="float:right; margin-top:15px"><a href="' .
        sef(123) . '" class="uk-button uk-button-primary">Back</a></div>';
    $str .= '<h1>Edit Online Shop Merchant</h1>	        
	        <form method="post" enctype="multipart/form-data">
	            <input type="hidden" name="final" value="1">
	            <table class="category table table-striped table-bordered table-hover">
	            	<tr><td colspan="2"><p>All fields marked * are required.</p></td></tr>
	                <tr>
	                    <td><label for="merchant_name_edit">Name: *</label></td>
	                    <td><input name="merchant_name_edit" id="merchant_name_edit" value="' .
        $merchant->merchant_name . '" size="40" required></td>
	                </tr>
	                <tr>
	                    <td><label for="description_edit">Description:</label></td>
	                    <td><textarea name="description_edit" id="description_edit"
	                                  style="width:70%; height:100px;">' .
        $merchant->description . '</textarea></td>
	                </tr>
	                <tr>
	                    <td><label for="details_edit">Details:</label></td>
	                    <td><textarea name="details_edit" id="details_edit"
	                                  style="width:70%; height:100px;">' .
        $merchant->details . '</textarea></td>
	                </tr>	               
                    <tr>
                        <td>Picture:</td>
                        <td>';

    if ($merchant->picture !== '') {
        $str .= 'Current Picture:<br/>
                            <img src="images/merchant/tmb_' . $merchant->picture . '" alt=""><br>
                            *Changing picture might require a browser refresh (F5) to reload image.<br>';
    }

    $str .= '<input type="file" name="picture_edit" id="picture_edit" size="40"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" value="Save Changes" name="submit"
                                           class="uk-button uk-button-primary"></td>
                </tr>
            </table>' . HTMLHelper::_('form.token') . '
        </form>';

    return $str;
}

/**
 * @param $avatar
 * @param $uid
 * @param $merchant_name
 * @param $description
 * @param $details
 *
 *
 * @since version
 */
function process_merchant_edit($avatar, $uid, $merchant_name, $description, $details)
{
//    $db = db();

    Session::checkToken() or die(Text::_('Invalid Token'));

    validate_input($uid, $merchant_name);

//    try {
//        $db->transactionStart();

        update_merchant($uid, $merchant_name, $description, $details);

        upload_image($uid, $avatar, 'merchant');

//        $db->transactionCommit();
//    } catch (Exception $e) {
//        $db->transactionRollback();
//
//        ExceptionHandler::render($e);
//    }

    application()->redirect(Uri::root(true) . '/' . sef(125) . qs() .
        'uid=' . $uid, 'Online Shop Merchant Updated.', 'notice');
}

/**
 * @param $uid
 * @param $merchant_name
 * @param $description
 * @param $details
 *
 *
 * @since version
 */
function update_merchant($uid, $merchant_name, $description, $details)
{
    $db = db();

    update(
        'network_items_merchant',
        [
            'merchant_name = ' . $db->quote($merchant_name),
            'description = ' . $db->quote($description),
            'details = ' . $db->quote($details)
        ],
        ['merchant_id = ' . $db->quote($uid)]
    );
}

/**
 * @param $uid
 * @param $merchant_name
 *
 *
 * @since version
 */
function validate_input($uid, $merchant_name)
{
    $app = application();

    if ($uid === '') {
        $err = 'No merchant selected.';

        $app->redirect(Uri::root(true) . '/' . sef(125) . qs() . 'uid=' . $uid, $err, 'error');
    }

    if ($merchant_name === '') {
        $err = 'Please specify Merchant Name';

        $app->redirect(Uri::root(true) . '/' . sef(125) . qs() . 'uid=' . $uid, $err, 'error');
    }
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function items_merchant_all($uid)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_items_merchant ' .
        'WHERE merchant_id = ' . $db->quote($uid)
    )->loadObject();
}