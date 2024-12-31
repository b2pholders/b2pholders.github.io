<?php

namespace BPL\Mods\Repeat_Items;

require_once 'bpl/mods/category_items.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Category_Items\cat_list;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\db;
use function bpl\Mods\Helpers\settings;
use function bpl\Mods\Helpers\paginate;

/**
 * @param         $cat_id
 * @param         $pg
 * @param         $rows
 * @param   int   $user_id
 * @param   int   $sef_edit
 * @param   int   $sef_delete
 * @param   int   $sef_buy
 * @param   bool  $p2p
 * @param   int   $stock_url
 *
 * @return string
 *
 * @since version
 */
function items(
	$cat_id,
	$pg,
	$rows,
	int $user_id = 0,
	int $sef_edit = 71,
	int $sef_delete = 69,
	int $sef_buy = 9,
	bool $p2p = false,
	int $stock_url = 0
): string
{
	$str = cat_list($user_id, $p2p);

	$lim_to   = $rows;
	$lim_from = $lim_to * $pg;

//	echo '<pre>';
//	print_r(user_unilevel($user_id), 1);
//	exit;

//	echo '<pre>';
//	var_dump($p2p);
//	exit;

	$items = items_lim_desc($user_id, $lim_from, $lim_to, $cat_id, $p2p);

	if (!empty($items))
	{
		$str .= '<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-5" data-uk-grid-margin="">';

		$list = 0;

		foreach ($items as $item)
		{
			if (!empty(user_unilevel($user_id)) && $item->cat_id == 22) {
				continue;
			}

//			if (($p2p && isset($item->user_id) && (int) $item->user_id !== $user_id && $stock_url === 0)
//				|| (!$p2p/* && $user_id === 1*/))
//			{
//				$str .= repeat_items($item, $p2p);
//
//				$list++;
//			}
//			elseif ($p2p && isset($item->user_id) && (int) $item->user_id === $user_id && $stock_url > 0)
//			{
//				$str .= repeat_items($item, $p2p);
//
//				$list++;
//			}
			$str .= repeat_items($item, $p2p);

			$list++;
		}

		$str .= '</ul>';

		$str .= show_modals($items, $user_id, $sef_edit, $sef_delete, $sef_buy, $p2p);

		$str .= script_readmore();

		if (empty($list))
		{
			$str .= '<hr><p>No items yet.</p>';
		}
	}
	else
	{
		$str .= '<hr><p>No items yet.</p>';
	}

	$str .= paginate($pg, items_repeat($cat_id), 69, $rows);

	return $str;
}

/**
 * @param $item
 * @param $p2p
 *
 * @return string
 *
 * @since version
 */
function repeat_items($item, $p2p): string
{
	$str = '<li class="uk-row-first">';
	$str .= '<a class="uk-thumbnail uk-overlay-hover" href="#modal-' .
		$item->item_id . '" data-uk-modal="{center:true}">';
	$str .= '<div class="uk-overlay">';

	$src = 'images/no-image.png';

	if (!empty($item->picture))
	{
		$src = 'images/' . ($p2p ? 'p2p' : 'repeat') . '/tmb_' . $item->picture;
	}

	$str .= '<img src="' . $src . '" height="150" alt="' . $item->item_name . '">';
	$str .= '<div class="uk-overlay-panel uk-overlay-icon uk-overlay-background uk-overlay-fade"></div>';
	$str .= '</div>';
	$str .= '<div class="uk-thumbnail-caption"><b>' . $item->item_name . '</b></div>';
	$str .= '</a>';
	$str .= '</li>';

	return $str;
}

/**
 * @param $item
 * @param $p2p
 *
 * @return string
 *
 * @since version
 */
function modal_item($item, $p2p): string
{
	$str = '<div id="modal-' . $item->item_id . '" class="uk-modal" style="z-index: 1030;">';
	$str .= '<div class="uk-modal-dialog uk-modal-dialog-lightbox">';
	$str .= '<div class="uk-width-1-1 uk-row-first">';
	$str .= '<div class="uk-panel uk-panel-box">';
	$str .= '<button type="button" class="uk-modal-close uk-close" style="float: right"></button>';
	$str .= '<div class="uk-grid" data-uk-grid-margin="">';

	$str .= '<div class="uk-width-medium-1-3 uk-width-large-1-3 uk-text-center uk-row-first">';

	return $str;
}

/**
 * @param           $item
 * @param   string  $p2p
 *
 * @return string
 *
 * @since version
 */
function modal_detail($item, string $p2p): string
{
	$sp = settings('plans');

	$str = '</div>';

	$str .= '<div class="uk-width-medium-2-3 uk-width-large-2-3 uk-text-center-small">';
	$str .= '<h3 class="uk-panel-title" style="margin-bottom: 0">' . $item->item_name . '</h3>';
	$str .= '<p style="padding-top: 0; margin-top: 0">' . $item->description . '</p>';
	$str .= '<p class="more">' . $item->details . '</p>';
	$str .= '<input type="button" class="uk-button" value="Price: ' .
		number_format($item->price, 8) . ' ' . settings('ancillaries')->currency . '">&nbsp;';
	$str .= '<input type="button" class="uk-button" value="' . $item->quantity . ' available items.">&nbsp;';

	$str .= $p2p ? '' : (($sp->binary_pair || $sp->redundant_binary) ?
		'<input type="button" class="uk-button" value="BP: ' . $item->binary_points . ' pts.">&nbsp;' : '');
	$str .= $p2p ? '' : ($sp->unilevel ?
		'<input type="button" class="uk-button" value="UP: ' . $item->unilevel_points . ' pts.">&nbsp;' : '');
	$str .= $p2p ? '' : '<input type="button" class="uk-button" value="PR: ' . $item->reward_points . ' tkn.">&nbsp;';
	$str .= '</div>';

	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	return $str;
}

/**
 * @param $user_id
 * @param $lim_from
 * @param $lim_to
 * @param $cat_id
 * @param $p2p
 *
 * @return array|mixed
 *
 * @since version
 */
function items_lim_desc($user_id, $lim_from, $lim_to, $cat_id, $p2p)
{
	if ($p2p)
	{
		if ((int) $cat_id !== 0)
		{
			if (!empty(user_unilevel($user_id)) && (int) $cat_id === 22)
			{
				return [];
			}

			return db()->setQuery(
				'SELECT * ' .
				'FROM network_p2p_items ' .
				'WHERE cat_id = ' . db()->quote($cat_id) .
				' ORDER BY item_id DESC ' .
				'LIMIT ' . $lim_from . ', ' . $lim_to
			)->loadObjectList();
		}
		else
		{
			if (!empty(user_unilevel($user_id)) && (int) $cat_id === 22)
			{
				return db()->setQuery(
					'SELECT * ' .
					'FROM network_p2p_items ' .
					' WHERE cat_id <> ' . db()->quote($cat_id) .
					' ORDER BY item_id DESC ' .
					'LIMIT ' . $lim_from . ', ' . $lim_to
				)->loadObjectList();
			}

			return db()->setQuery(
				'SELECT * ' .
				'FROM network_p2p_items ' .
				' ORDER BY item_id DESC ' .
				'LIMIT ' . $lim_from . ', ' . $lim_to
			)->loadObjectList();
		}
	}
	else
	{
		if ((int) $cat_id !== 0)
		{
			if (!empty(user_unilevel($user_id)) && $cat_id == 22)
			{
				return [];
			}

			return db()->setQuery(
				'SELECT * ' .
				'FROM network_items_repeat ' .
				'WHERE cat_id = ' . db()->quote($cat_id) .
				' ORDER BY item_id DESC ' .
				'LIMIT ' . $lim_from . ', ' . $lim_to
			)->loadObjectList();
		}
		else
		{
//			if (!empty(user_unilevel($user_id)) /*&& (int) $cat_id === 22*/)
//			{
//				return db()->setQuery(
//					'SELECT * ' .
//					'FROM network_items_repeat ' .
//					' WHERE cat_id <> ' . $cat_id .
//					' ORDER BY item_id DESC ' .
//					'LIMIT ' . $lim_from . ', ' . $lim_to
//				)->loadObjectList();
//			}

			return db()->setQuery(
				'SELECT * ' .
				'FROM network_items_repeat ' .
				' ORDER BY item_id DESC ' .
				'LIMIT ' . $lim_from . ', ' . $lim_to
			)->loadObjectList();
		}
	}
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
 * @param $items
 * @param $user_id
 * @param $sef_edit
 * @param $sef_delete
 * @param $sef_buy
 * @param $p2p
 *
 * @return string
 *
 * @since version
 */
function show_modals($items, $user_id, $sef_edit, $sef_delete, $sef_buy, $p2p): string
{
	$str = '';

	if (!empty($items))
	{
		foreach ($items as $item)
		{
			$admin = ($p2p && isset($item->user_id) && (int) $item->user_id === (int) $user_id)
				|| (!$p2p && $user_id === 1);
			$str   .= modal_buy($item, $admin, $sef_edit, $sef_delete, $sef_buy, $p2p);
		}
	}

	return $str;
}

/**
 * @param $item
 * @param $admin
 * @param $sef_edit
 * @param $sef_delete
 * @param $sef_buy
 * @param $p2p
 *
 * @return string
 *
 * @since version
 */
function modal_buy($item, $admin, $sef_edit, $sef_delete, $sef_buy, $p2p): string
{
	$str = modal_item($item, $p2p);

	$str .= '<img src="images/' . ($p2p ? 'p2p' : 'repeat') . '/' . $item->picture . '" alt="' . $item->item_name . '">';

	$str .= '<p>';

	if ($admin)
	{
		$str .= '<a href="' . sef($sef_edit) . qs() . 'uid=' . $item->item_id .
			'" class="uk-button uk-button-primary">Edit</a>&nbsp;';
		$str .= '<a href="' . sef($sef_delete) . qs() . 'uid=' . $item->item_id .
			'" class="uk-button uk-button-primary">Delete</a>&nbsp;';
		$str .= '<a href="' . sef($sef_buy) . qs() . 'uid=' . $item->item_id .
			'" class="uk-button uk-button-primary" style="margin-top: 5px">Buy</a>';
	}
	else
	{
		$str .= '<a href="' . sef($sef_buy) . qs() . 'uid=' . $item->item_id .
			'" class="uk-button uk-button-primary">Buy</a>';
	}

	$str .= '</p>';

	$str .= modal_detail($item, $p2p);

	return $str;
}

/**
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

/**
 * @param $cat_id
 *
 * @return array|mixed
 *
 * @since version
 */
function items_repeat($cat_id)
{
	if ((int) $cat_id !== 0)
	{
		return db()->setQuery(
			'SELECT * ' .
			'FROM network_items_repeat ' .
			'WHERE cat_id = ' . db()->quote($cat_id)
		)->loadObjectList();
	}
	else
	{
		return db()->setQuery(
			'SELECT * ' .
			'FROM network_items_repeat'
		)->loadObjectList();
	}
}