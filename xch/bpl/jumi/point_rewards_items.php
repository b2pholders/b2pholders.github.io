<?php

namespace BPL\Jumi\Points_Rewards_Items;

require_once 'bpl/menu.php';
//require_once 'bpl/mods/rewards_items.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

//use function BPL\Mods\Rewards_Items\main as rewards_items;

use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function bpl\Mods\Helpers\paginate;
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
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');

	$pg = input_get('pg', 0);

	$rows = 5;

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		$uid = input_get('uid');

		if ($uid === '')
		{
			$str .= view_items($pg, $rows);
		}
		else
			if (input_get('final') === '')
			{
				$str .= view_delete_confirm($uid);
			}
			else
			{
				process_delete($uid);
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
 * @return array|mixed
 *
 * @since version
 */
function items_incentive_lim_desc($lim_from, $lim_to)
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
		'ORDER BY item_id DESC ' .
		'LIMIT ' . $lim_from . ', ' . $lim_to
	)->loadObjectList();
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function incentive_items($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
		'WHERE item_id = ' . $db->quote($item_id)
	)->loadObject();
}

/**
 *
 * @param        $pg
 * @param   int  $rows
 *
 * @return string
 *
 * @since version
 */
function view_items($pg, int $rows = 10): string
{
	$str = '<article class="uk-article">';
	$str .= '<h1 class="uk-article-title">Token Items</h1>';
	$str .= '<a href="' . sef(51) . '" class="uk-button uk-button-primary" style="float: right">Add Items</a>';

	$lim_to   = $rows;
	$lim_from = $lim_to * $pg;

	$items = items_incentive_lim_desc($lim_from, $lim_to);

	if (!empty($items))
	{
		$str .= '<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-5" data-uk-grid-margin="">';

		foreach ($items as $item)
		{
			$str .= '<li class="uk-row-first">';
			$str .= '<a class="uk-thumbnail uk-overlay-hover" href="#modal-' .
				$item->item_id . '" data-uk-modal="{center:true}">';
			$str .= '<div class="uk-overlay">';

			$src = 'images/no-image.png';

			if (!empty($item->picture))
			{
				$src = 'images/incentive/tmb_' . $item->picture;
			}

			$str .= '<img src="' . $src . '" height="150" alt="' . $item->item_name . '">';
			$str .= '<div class="uk-overlay-panel uk-overlay-icon uk-overlay-background uk-overlay-fade"></div>';
			$str .= '</div>';
			$str .= '<div class="uk-thumbnail-caption"><b>' . $item->item_name . '</b></div>';
			$str .= '</a>';
			$str .= '</li>';
		}

		$str .= '</ul>';

		$str .= show_modals($items);

		$str .= script_readmore();
	}
	else
	{
		$str .= '<hr><p>No items yet.</p>';
	}

	$str .= paginate($pg, items_incentive(), 50, $rows);

	$str .= '</article>';

	return $str;
}

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

/**
 * @param $items
 *
 * @return string
 *
 * @since version
 */
function show_modals($items): string
{
	$str = '';

	foreach ($items as $item)
	{
		$str .= modal_reward($item);
	}

	return $str;
}

/**
 * @param $item
 *
 * @return string
 *
 * @since version
 */
function modal_reward($item): string
{
	$str = '<div id="modal-' . $item->item_id . '" class="uk-modal" style="z-index: 1030;">';
	$str .= '<div class="uk-modal-dialog uk-modal-dialog-lightbox">';
	$str .= '<div class="uk-width-1-1 uk-row-first">';
	$str .= '<div class="uk-panel uk-panel-box">';
	$str .= '<button type="button" class="uk-modal-close uk-close" style="float: right"></button>';
	$str .= '<div class="uk-grid" data-uk-grid-margin="">';

	$str .= '<div class="uk-width-medium-1-3 uk-width-large-1-3 uk-text-center uk-row-first">';
	$str .= '<img src="images/incentive/' . $item->picture . '" alt="' . $item->item_name . '">';

	$str .= '<p>';
	$str .= '<a href="' . sef(52) . qs() . 'uid=' . $item->item_id .
		'" class="uk-button uk-button-primary">Edit</a>&nbsp;';
	$str .= '<a href="' . sef(50) . qs() . 'uid=' . $item->item_id .
		'" class="uk-button uk-button-primary">Delete</a>';
	$str .= '</p>';

	$str .= '</div>';

	$str .= '<div class="uk-width-medium-2-3 uk-width-large-2-3 uk-text-center-small">';
	$str .= '<h3 class="uk-panel-title">' . $item->item_name . '</h3>';
	$str .= '<p class="more">' . $item->description . '</p>';
	$str .= '<input type="button" class="uk-button" value="' . $item->price . ' tkn.">&nbsp;';
	$str .= '<input type="button" class="uk-button" value="' . $item->quantity . ' pcs.">';

	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	return $str;
}

function items_incentive()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive'
	)->loadObjectList();
}

/**
 * @param $uid
 *
 * @return string
 *
 * @since version
 */
function view_delete_confirm($uid): string
{
	$str = '<h1>Confirm Item Delete</h1>';
	$str .= '<strong>' . incentive_items($uid)->item_name . '</strong><br><br>';
	$str .= '<a href="' . sef(50) . qs() . 'uid=' . $uid .
		'&final=1" class="uk-button uk-button-primary">Confirm Delete</a>';

	return $str;
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

		delete(
			'network_items_incentive',
			['item_id = ' . $db->quote($uid)]
		);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(50),
		'Incentive item deleted.', 'notice');
}