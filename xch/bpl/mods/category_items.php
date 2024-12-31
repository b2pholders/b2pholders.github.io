<?php

namespace BPL\Mods\Category_Items;

require_once 'bpl/mods/repeat_items.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Repeat_Items\items_repeat;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\application;

/**
 * @param $cat_id
 *
 * @return mixed|null
 *
 * @since version
 */
function cat_single($cat_id)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_settings_product_category ' .
        'WHERE cat_id = ' . $db->quote($cat_id)
    )->loadObject();
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function items($p2p)
{
    if ($p2p) {
        return db()->setQuery(
            'SELECT * ' .
            'FROM network_p2p_items'
        )->loadObjectList();
    }

    return db()->setQuery(
        'SELECT * ' .
        'FROM network_items_repeat'
    )->loadObjectList();
}

/**
 *
 * @param $user_id
 * @param $p2p
 * @return array
 *
 * @since version
 */
function cat_items($user_id, $p2p): array
{
    $items = items($p2p);

    $cats = [];

    if (!empty($items)) {
        foreach ($items as $item) {
	        if (!empty(user_unilevel($user_id)) && $item->cat_id == 22) {
		        continue;
	        }

            if (!in_array($item->cat_id, $cats)
                && (($p2p && isset($item->user_id) && $item->user_id != $user_id)
                || (!$p2p/* && $user_id === 0*/))) {
                $cats[$item->cat_id] = cat_single($item->cat_id)->category;
            }
        }
    }

    return $cats;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_unilevel($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_unilevel ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 *
 * @param $user_id
 * @param $p2p
 * @return array
 *
 * @since version
 */
function cat_arr($user_id, $p2p): array
{
    $cat_items = cat_items($user_id, $p2p);

    $cat_arr = [];

    if (!empty($cat_items)) {
        foreach ($cat_items as $k => $v) {
            $cat_arr[] = ['cat_id' => $k, 'category' => $v];
        }
    }

    return $cat_arr;
}

/**
 * @param $cat
 *
 * @return string
 *
 * @since version
 */
function li_cat($cat): string
{
    return '<li><a href="' . sef(9) . qs() .
        'cat=' . $cat['cat_id'] . '">' . $cat['category'] . '</a></li>';
}

/**
 * @param $ctr
 *
 * @return string
 *
 * @since version
 */
function col_cat_list($ctr): string
{
    $col = 1;

    if ($ctr > 10 && $ctr <= 20) {
        $col = 2;
    } elseif ($ctr > 20 && $ctr <= 30) {
        $col = 3;
    } elseif ($ctr > 30 && $ctr <= 40) {
        $col = 4;
    } elseif ($ctr > 40 && $ctr <= 50) {
        $col = 5;
    }

    return '<div class="uk-dropdown uk-dropdown-width-' . $col . ' uk-dropdown-bottom" 
                aria-hidden="true" tabindex="" style="top: 30px; left: 0;">';
}

/**
 * @param $cat
 * @param $n
 *
 * @return string
 *
 * @since version
 */
function ul_cat($cat, $n): string
{
    $str = isset($cat[$n]) ? '<ul class="uk-nav uk-nav-dropdown uk-panel">' : '';
    $str .= isset($cat[$n]) ? li_cat($cat[$n]) : '';
    $str .= isset($cat[$n + 1]) ? li_cat($cat[$n + 1]) : '';
    $str .= isset($cat[$n + 2]) ? li_cat($cat[$n + 2]) : '';
    $str .= isset($cat[$n + 3]) ? li_cat($cat[$n + 3]) : '';
    $str .= isset($cat[$n + 4]) ? li_cat($cat[$n + 4]) : '';
    $str .= isset($cat[$n + 5]) ? '<li class="uk-nav-divider"></li>' : '';
    $str .= isset($cat[$n + 5]) ? li_cat($cat[$n + 5]) : '';
    $str .= isset($cat[$n + 6]) ? li_cat($cat[$n + 6]) : '';
    $str .= isset($cat[$n + 7]) ? li_cat($cat[$n + 7]) : '';
    $str .= isset($cat[$n + 8]) ? li_cat($cat[$n + 8]) : '';
    $str .= isset($cat[$n + 9]) ? li_cat($cat[$n + 9]) : '';
    $str .= isset($cat[$n + 9]) ? '</ul>' : '';

    return $str;
}

/**
 * @param int $user_id
 * @param bool $p2p
 * @return string
 *
 * @since version
 */
function cat_list(int $user_id = 0, bool $p2p = false): string
{
    $cats = cat_arr($user_id, $p2p);

    $ctr = count($cats);

    if (empty($ctr)) {
        return '';
    }

    $str = '<div class="uk-grid">';
    $str .= '<div class="uk-width-1-1" data-uk-margin="">';
    $str .= '<div class="uk-button-group">';
    $str .= '<a href="' . sef(9) . '" class="uk-button">Categories</a>';
    $str .= '<div data-uk-dropdown="{mode:\'click\'}" aria-haspopup="true" aria-expanded="false" class="">';
    $str .= '<button class="uk-button"><i class="uk-icon-caret-down"></i></button>';
    $str .= col_cat_list($ctr);

    $str .= $ctr > 0 ? '<div class="uk-grid uk-dropdown-grid">' : '';

    if ($ctr > 0 && $ctr <= 10) {
        $str .= '<div class="uk-width-1-1">';
        $str .= ul_cat($cats, 0);
        $str .= '</div>';
    } elseif ($ctr > 10 && $ctr <= 20) {
        $str .= '<div class="uk-width-1-2">';
        $str .= ul_cat($cats, 0);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-2">';
        $str .= ul_cat($cats, 10);
        $str .= '</div>';
    } elseif ($ctr > 20 && $ctr <= 30) {
        $str .= '<div class="uk-width-1-3">';
        $str .= ul_cat($cats, 0);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-3">';
        $str .= ul_cat($cats, 10);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-3">';
        $str .= ul_cat($cats, 20);
        $str .= '</div>';
    } elseif ($ctr > 30 && $ctr <= 40) {
        $str .= '<div class="uk-width-1-4">';
        $str .= ul_cat($cats, 0);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-4">';
        $str .= ul_cat($cats, 10);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-4">';
        $str .= ul_cat($cats, 20);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-4">';
        $str .= ul_cat($cats, 30);
        $str .= '</div>';
    } elseif ($ctr > 40 && $ctr <= 50) {
        $str .= '<div class="uk-width-1-5">';
        $str .= ul_cat($cats, 0);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-5">';
        $str .= ul_cat($cats, 10);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-5">';
        $str .= ul_cat($cats, 20);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-5">';
        $str .= ul_cat($cats, 30);
        $str .= '</div>';

        $str .= '<div class="uk-width-1-5">';
        $str .= ul_cat($cats, 40);
        $str .= '</div>';
    }

    $str .= $ctr > 0 ? '</div>' : '';

    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_option_cat(): string
{
    $cat_list = cat_all();

    $str = '';

    if (!empty($cat_list)) {
        foreach ($cat_list as $cat) {
            $value = $cat->category;
            $option = ucwords($value);

            $str .= '<option value="' . $cat->cat_id . '">' . $option . '</option>' . "\n";
        }
    }

    return $str;
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function cat_all()
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_settings_product_category'
    )->loadObjectList();
}

function view_modal_cat(): string
{
    $str = '<div id="modal-cat" class="uk-modal" style="z-index: 1030;">';
    $str .= '<div class="uk-modal-dialog">';
    $str .= '<button type="button" class="uk-modal-close uk-close"></button>';

    $str .= view_form_cat();

    $str .= '</div>';
    $str .= '</div>';

    $str .= script_cat_action();

    return $str;
}

function view_form_cat(): string
{
    $str = '<div class="page-header"><h1>Category</h1></div>';
    $str .= '<form method="post" class="form-horizontal well">';

    $str .= '<div class="uk-form-row">';
    $str .= '<select name="cat_action" id="cat_action">
            <option value="add" selected="">Add</option>
            <option value="update">Update</option>
            <option value="delete">Delete</option>
        </select>';
    $str .= '<button type="submit" class="uk-button" disabled>Action</button>';
    $str .= '</div>';

    $str .= '<div class="uk-form-row" id="cat_to_update">';
    $str .= '<select name="cat_to_update">';
    $str .= '<option value="none" selected="" disabled>Select Category to Update</option>';
    $str .= view_option_cat();
    $str .= '</select>';
    $str .= '<button class="uk-button cat_label" disabled>Categories</button>';
    $str .= '</div>';

    $str .= '<div class="uk-form-row" id="cat_to_delete">';
    $str .= '<select name="cat_to_delete">';
    $str .= '<option value="none" selected="" disabled>Select Category to Delete</option>';
    $str .= view_option_cat();
    $str .= '</select>';
    $str .= '<button class="uk-button cat_label" disabled>Categories</button>';
    $str .= '</div>';

    $str .= '<div class="uk-form-row">';
    $str .= '<input type="text" id="cat_name" name="cat_name" placeholder="Category Name">&nbsp;';
    $str .= '<input type="submit" id="cat_add_btn" class="uk-button uk-button-primary" value="Add">&nbsp;';
    $str .= '<input type="submit" id="cat_update_btn" class="uk-button uk-button-primary" value="Update">';
    $str .= '<input type="submit" id="cat_delete_btn" class="uk-button uk-button-primary" value="Delete">';
    $str .= '</div>';

    $str .= '</form>';

    return $str;
}

function script_cat_action(): string
{
    return '<script>
	    (function ($) {
	        toggleCatAction($);
	
	        $("#cat_action").change(function () {
	            toggleCatAction($);
	        });
	    })(jQuery);
	
	    function toggleCatAction($) {
	        const action = $("#cat_action");
	
	        const cat_name = $("#cat_name");
            const cat_to_update = $("#cat_to_update");
            const cat_to_delete = $("#cat_to_delete");
            const cat_add_btn = $("#cat_add_btn");
            const cat_update_btn = $("#cat_update_btn");
            const cat_delete_btn = $("#cat_delete_btn");
           
	        cat_name.hide();
            cat_to_update.hide();
            cat_to_delete.hide();
            cat_add_btn.hide();
            cat_update_btn.hide();
            cat_delete_btn.hide();
            
            switch (action.val()) {
                case "add":
                    cat_to_update.hide();                   
                    cat_update_btn.hide();
                    cat_name.show();
                    cat_add_btn.show();
                    cat_to_delete.hide();
                    cat_delete_btn.hide();
                	break;
                case "update":
                    cat_to_update.show();	
                    cat_update_btn.show();
                    cat_name.show();
                    cat_add_btn.hide();   
                    cat_to_delete.hide();
                    cat_delete_btn.hide();
                	break;
                case "delete":
                    cat_to_update.hide();	
                    cat_update_btn.hide();
                    cat_name.hide();
                    cat_add_btn.hide();
                    cat_to_delete.show();
                    cat_delete_btn.show();                    
                	break;               
            }
            
	        return false;
	    }
	</script>';
}

/**
 * @param $cat_add
 *
 * @param int $sef
 * @since version
 */
function process_add_category($cat_add, int $sef = 69)
{
    $db = db();

    validate_add_cat($cat_add);

    try {
        $db->transactionStart();

        insert_category($cat_add);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();

        ExceptionHandler::render($e);
    }

    application()->redirect(Uri::root(true) . '/' . sef($sef),
        'Product Category Added Successfully!', 'success');
}

/**
 * @param $category
 * @param $cat_id
 *
 * @param int $sef
 * @since version
 */
function process_update_category($category, $cat_id, int $sef = 69)
{
    $db = db();

    $app = application();

    if ($cat_id === 'none') {
        $app->redirect(Uri::root(true) . '/' . sef($sef),
            'Please select Category to update!', 'error');
    }

    try {
        $db->transactionStart();

        update_category($category, $cat_id);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();

        ExceptionHandler::render($e);
    }

    $app->redirect(Uri::root(true) . '/' . sef($sef),
        'Product Category Updated Successfully!', 'success');
}

/**
 * @param $cat_id
 *
 * @param int $sef
 * @since version
 */
function process_delete_category($cat_id, int $sef = 69)
{
    $db = db();

    $app = application();

    validate_delete_cat($cat_id);

    try {
        $db->transactionStart();

        delete_category($cat_id);

        $db->transactionCommit();
    } catch (Exception $e) {
        $db->transactionRollback();

        ExceptionHandler::render($e);
    }

    $app->redirect(Uri::root(true) . '/' . sef($sef),
        'Product Category Deleted Successfully!', 'success');
}

/**
 * @param $cat
 *
 * @param int $sef
 * @since version
 */
function validate_add_cat($cat, int $sef = 69)
{
    $app = application();

    if (count(cat_all()) >= 50) {
        $app->redirect(Uri::root(true) . '/' . sef($sef),
            'Category Limit Exceeded!', 'error');
    }

    if (count(cat_entry($cat)) > 0) {
        $app->redirect(Uri::root(true) . '/' . sef($sef),
            'Category has a duplicate entry!', 'error');
    }
}

/**
 * @param $cat_id
 *
 * @param int $sef
 * @since version
 */
function validate_delete_cat($cat_id, int $sef = 69)
{
    $app = application();

    $items_repeat = items_repeat($cat_id);

    if (!empty($items_repeat)) {
        foreach ($items_repeat as $item) {
            if ((int)$cat_id === (int)$item->cat_id) {
                $app->redirect(Uri::root(true) . '/' . sef($sef),
                    'Category cannot be deleted!', 'error');
            }
        }
    }

    if ($cat_id === 'none') {
        $app->redirect(Uri::root(true) . '/' . sef($sef),
            'Please select Category to delete!', 'error');
    }
}

/**
 * @param $entry
 *
 * @return array|mixed
 *
 * @since version
 */
function cat_entry($entry)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_settings_product_category ' .
        'WHERE category LIKE ' . $db->quote('%' . $entry . '%')
    )->loadObjectList();
}

/**
 * @param $category
 * @since version
 */
function insert_category($category)
{
    $db = db();

    insert(
        'network_settings_product_category',
        ['category'],
        [$db->quote($category)]
    );
}

/**
 * @param $category
 * @param $cat_id
 *
 *
 * @since version
 */
function update_category($category, $cat_id)
{
    $db = db();

    update(
        'network_settings_product_category',
        ['category = ' . $db->quote($category)],
        ['cat_id = ' . $db->quote($cat_id)]
    );
}

/**
 * @param $cat_id
 *
 *
 * @since version
 */
function delete_category($cat_id)
{
    $db = db();

    delete(
        'network_settings_product_category',
        ['cat_id = ' . $db->quote($cat_id)]
    );
}