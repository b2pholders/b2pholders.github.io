<?php

namespace BPL\Jumi\Repeat_Purchase_Merchants_Add;

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

use function BPL\Mods\Database\Query\insert;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Upload_Image\main as upload_image;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
//use function BPL\Mods\Helpers\settings;
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
        if ((int)input_get('final') !== 1) {
            $str .= view_form();
        } else {
            $merchant = substr(input_get('merchant_name_add', '', 'RAW'), 0, 150);
            $description = substr(input_get('description_add', '', 'RAW'), 0, 1000);
            $details = substr(input_get('details_add', '', 'RAW'), 0, 1000);
            $avatar = application()->input->files->get('picture_add');

            process_merchant_add($avatar, $merchant, $description, $details);
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
 * @return string
 *
 * @since version
 */
function view_form(): string
{
    $str = '<div style="float:right; margin-top:15px"><a href="' .
        sef(123) . '" class="uk-button uk-button-primary">Back</a></div>';
    $str .= '<h1>Add Online Shop Merchants</h1>       
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="final" value="1">
            <table class="category table table-striped table-bordered table-hover">
            	<tr><td colspan="2"><p>All fields marked * are required.</p></td></tr>
                <tr>
                    <td style="width: 200px"><label for="merchant_name_add">Name: *</label></td>
                    <td><input name="merchant_name_add" id="merchant_name_add" size="40" required></td>
                </tr>
                <tr>
                    <td><label for="description_add">Description:</label></td>
                    <td><textarea name="description_add" id="description_add" style="width:70%; height:100px;"></textarea></td>
                </tr>
                <tr>
                    <td><label for="details_add">Details:</label></td>
                    <td><textarea name="details_add" id="details_add" style="width:70%; height:100px;"></textarea></td>
                </tr>';
    $str .= '<tr>
                    <td><label for="picture_add">Picture:</label></td>
                    <td><input type="file" name="picture_add" id="picture_add" size="40"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" value="Add Merchant" name="submit"
                                           class="uk-button uk-button-primary"></td>
                </tr>
            </table>' . HTMLHelper::_('form.token') . '
        </form>';

    return $str;
}

/**
 * @param $avatar
 * @param $merchant_name
 * @param $description
 * @param $details
 *
 *
 * @since version
 */
function process_merchant_add($avatar, $merchant_name, $description, $details)
{
    $db = db();

    Session::checkToken() or die(Text::_('Invalid Token'));

    validate_input($merchant_name);

//    try {
//        $db->transactionStart();

        insert_merchant($merchant_name, $description, $details);

        upload_image($db->insertid(), $avatar, 'merchant');

//        $db->transactionCommit();
//    } catch (Exception $e) {
//        $db->transactionRollback();
//        ExceptionHandler::render($e);
//    }

    application()->redirect(Uri::root(true) . '/' .
        sef(123), 'Online Shop Merchant Added Successfully!', 'success');
}

/**
 * @param $merchant_name
 * @param $description
 * @param $details
 *
 *
 * @since version
 */
function insert_merchant($merchant_name, $description, $details)
{
    $db = db();

    insert(
        'network_items_merchant',
        [
            'merchant_name',
            'description',
            'details'
        ],
        [
            $db->quote($merchant_name),
            $db->quote($description),
            $db->quote($details)
        ]
    );
}

/**
 * @param $merchant_name
 * @since version
 */
function validate_input($merchant_name)
{
    $app = application();

    if ($merchant_name === '') {
        $err = 'Please specify Merchant Name';

        $app->redirect(Uri::root(true) . '/' . sef(124), $err, 'error');
    }
}