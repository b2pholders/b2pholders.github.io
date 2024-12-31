<?php

namespace BPL\Mods\Rewards_Items;

/**
 * @param $item
 * @param $ctr
 *
 * @return string
 *
 * @since version
 */
function main($item, $ctr): string
{
	$str = '<div style="text-align: center">';
	$str .= '<a data-lightbox="on" data-spotlight="on" href="#modal-' . $ctr;
	$str .= '" data-uk-modal="{center: true}" class="uk-thumbnail uk-overlay-hover">';
	$str .= '<div class="uk-overlay">';
	$str .= '<img src="images/';

	if ($item->picture !== '')
	{
		$str .= 'incentive/tmb_' . $item->picture;
	}
	else
	{
		$str .= 'no-image.png';
	}

	$str .= '" height="150" alt="' . $item->item_name . '">';
	$str .= '<div class="uk-overlay-panel uk-overlay-icon uk-overlay-background uk-overlay-fade"></div>';
	$str .= '</div></a></div>';

	return $str;
}