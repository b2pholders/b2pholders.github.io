<?php

namespace BPL\Jumi\Repeat_Purchase_Items_Merchant;

require_once 'bpl/menu.php';
//require_once 'bpl/mods/repeat_items.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\delete;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

//use function BPL\Mods\Repeat_Items\main as repeat_items;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function bpl\Mods\Helpers\paginate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;

//use function BPL\Mods\Helpers\settings;
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

	$pg = input_get('pg', 0);

	$rows = 5;

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid = input_get('uid');

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ($uid === '')
		{
			$str .= view_merchants($pg, $usertype, $rows);
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
	else
	{
		$str .= view_merchants($pg, $usertype, $rows);
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

		delete_merchant($uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();

		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(123),
		'Online Shop Merchant Deleted.', 'notice');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function delete_merchant($uid)
{
	delete(
		'network_items_merchant',
		['merchant_id = ' . db()->quote($uid)]
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
	$str = '<h1>Confirm Delete Merchant</h1>';
	$str .= '<strong>' . items_merchant_single($uid)->merchant_name . '</strong><br><br>';
	$str .= '<a href="' . sef(123) . qs() . 'uid=' . $uid .
		'&final=1" class="uk-button uk-button-primary">Confirm</a>';

	return $str;
}

/**
 *
 * @param        $pg
 * @param        $usertype
 * @param   int  $rows
 *
 * @return string
 *
 * @since version
 */
function view_merchants($pg, $usertype = 'Member', int $rows = 10): string
{
	$str = '<article class="uk-article">';
	$str .= '<h1 class="uk-article-title">Online Shop Merchants</h1>';
	$str .= $usertype === 'Member' ? '' : '<a href="' . sef(124) .
		'" class="uk-button uk-button-primary" style="float: right">Add Merchants</a>';

	$lim_to   = $rows;
	$lim_from = $lim_to * $pg;

	$merchants = items_merchant_lim_desc($lim_from, $lim_to);

	if (!empty($merchants))
	{
		$str .= '<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-5" data-uk-grid-margin="">';

		foreach ($merchants as $merchant)
		{
			$str .= '<li class="uk-row-first">';
			$str .= $usertype === 'Member' ? '' : '<a class="uk-thumbnail uk-overlay-hover" href="#modal-' .
				$merchant->merchant_id . '" data-uk-modal="{center:true}">';
			$str .= '<div class="uk-overlay">';

			$src = 'images/no-image.png';

			if (!empty($merchant->picture))
			{
				$src = 'images/merchant/tmb_' . $merchant->picture;
			}

			$str .= '<img src="' . $src . '" height="150" alt="' . $merchant->merchant_name . '">';
			$str .= $usertype === 'Member' ? '' : '<div class="uk-overlay-panel uk-overlay-icon uk-overlay-background uk-overlay-fade"></div>';
			$str .= '</div>';
			$str .= '<div class="uk-thumbnail-caption"><b>' . $merchant->merchant_name . '</b></div>';
			$str .= $usertype === 'Member' ? '' : '</a>';
			$str .= '</li>';
		}

		$str .= '</ul>';

		$str .= show_modals_merchant($merchants);

		$str .= script_readmore();
	}
	else
	{
		$str .= '<hr><p>No merchants yet.</p>';
	}

	$str .= paginate($pg, items_merchant(), 69, $rows);

	$str .= '</article>';

	return $str;
}

/**
 * @param $items
 *
 * @return string
 *
 * @since version
 */
function show_modals_merchant($items): string
{
	$str = '';

	foreach ($items as $item)
	{
		$str .= modal_merchant($item);
	}

	return $str;
}

/**
 * @param $merchant
 *
 * @return string
 *
 * @since version
 */
function modal_merchant($merchant): string
{
	$str = '<div id="modal-' . $merchant->merchant_id . '" class="uk-modal" style="z-index: 1030;">';
	$str .= '<div class="uk-modal-dialog uk-modal-dialog-lightbox">';
	$str .= '<div class="uk-width-1-1 uk-row-first">';
	$str .= '<div class="uk-panel uk-panel-box">';
	$str .= '<button type="button" class="uk-modal-close uk-close" style="float: right"></button>';
	$str .= '<div class="uk-grid" data-uk-grid-margin="">';

	$str .= '<div class="uk-width-medium-1-3 uk-width-large-1-3 uk-text-center uk-row-first">';
	$str .= '<img src="images/merchant/' . $merchant->picture . '" alt="' . $merchant->merchant_name . '">';

	$str .= '<p>';
	$str .= '<a href="' . sef(125) . qs() . 'uid=' . $merchant->merchant_id .
		'" class="uk-button uk-button-primary">Edit</a>&nbsp;';
	$str .= '<a href="' . sef(123) . qs() . 'uid=' . $merchant->merchant_id .
		'" class="uk-button uk-button-primary">Delete</a>';
	$str .= '</p>';

	$str .= '</div>';

	$str .= '<div class="uk-width-medium-2-3 uk-width-large-2-3 uk-text-center-small">';
	$str .= '<h3 class="uk-panel-title" style="margin-bottom: 0">' . $merchant->merchant_name . '</h3>';
	$str .= '<p style="padding-top: 0; margin-top: 0">' . $merchant->description . '</p>';
	$str .= '<p class="more">' . $merchant->details . '</p>';
//	$str .= '<input type="button" class="uk-button" value="' .
//		number_format($merchant->price, 2) . ' ' . settings('ancillaries')->currency . '">&nbsp;';
//	$str .= '<input type="button" class="uk-button" value="' . $merchant->binary_points . ' pts.">&nbsp;';
//	$str .= '<input type="button" class="uk-button" value="' . $merchant->quantity . ' pcs.">';

	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	return $str;
}

/**
 * Jquery script for read more/ read less functionality
 *
 * @return string
 *
 * @since version
 */
function script_readmore(): string
{
	$str = '<style>
		.more_content span {
		  	display: none;
		}
		
		.more_link {
		  	display: block;
		}
	</style>';

	$str .= '<script>
		(function ($) {			    
            const max_len = 10; 
            const ellipsis = "...";
            const mrk_more = "<small>Show more</small>";
            const mrk_less = "<small>Show less</small>";

  			$(".more").each(function() {
    			const my_str = $(this).text();

    			if ($.trim(my_str).length > max_len) {                      
                    let reduced_str = my_str.split(" ").splice(0, max_len).join(" ");
                    let removed_str = my_str.split(" ").splice(max_len, $.trim(my_str).length).join(" ");

      				let html = reduced_str + \'<span>\' + ellipsis + 
      					\'</span><span class="more_content"><span>&nbsp;\' + removed_str + 
      					\'</span>&nbsp;&nbsp;<a href="" class="more_link">\' + mrk_more + \'</a></span\';

      				$(this).html(html);
    			}
    		});

  			$(".more_link").click(function() {
    			if ($(this).hasClass("less")) {
      				$(this).removeClass("less");                  
      				$(this).html(mrk_more);
    			} else {
      				$(this).addClass("less");
      				$(this).html(mrk_less);
                }
                
    			$(this).parent().prev().toggle();
    			$(this).prev().toggle();
                
    			return false;
  			});
		})(jQuery);
	</script>';

	return $str;
}

function items_merchant()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_items_merchant'
	)->loadObjectList();
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
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
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
function items_merchant_single($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_merchant ' .
		'WHERE merchant_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function items_merchant_lim_desc($lim_from, $lim_to)
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_items_merchant ' .
		'ORDER BY merchant_id DESC ' .
		'LIMIT ' . $lim_from . ', ' . $lim_to
	)->loadObjectList();
}