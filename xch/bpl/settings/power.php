<?php

namespace BPL\Settings\Power;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\update as query_update;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 *
 * @return array
 *
 * @since version
 */
function get_input(): array
{
	return [
		'executive_power_share_1' => input_get('executive_power_share_1'),
		'regular_power_share_1'   => input_get('regular_power_share_1'),
		'associate_power_share_1' => input_get('associate_power_share_1'),
		'basic_power_share_1'     => input_get('basic_power_share_1'),

		'executive_power_share_2' => input_get('executive_power_share_2'),
		'regular_power_share_2'   => input_get('regular_power_share_2'),
		'associate_power_share_2' => input_get('associate_power_share_2'),
		'basic_power_share_2'     => input_get('basic_power_share_2'),

		'executive_power_share_3' => input_get('executive_power_share_3'),
		'regular_power_share_3'   => input_get('regular_power_share_3'),
		'associate_power_share_3' => input_get('associate_power_share_3'),
		'basic_power_share_3'     => input_get('basic_power_share_3'),

		'executive_power_share_4' => input_get('executive_power_share_4'),
		'regular_power_share_4'   => input_get('regular_power_share_4'),
		'associate_power_share_4' => input_get('associate_power_share_4'),
		'basic_power_share_4'     => input_get('basic_power_share_4'),

		'executive_power_share_5' => input_get('executive_power_share_5'),
		'regular_power_share_5'   => input_get('regular_power_share_5'),
		'associate_power_share_5' => input_get('associate_power_share_5'),
		'basic_power_share_5'     => input_get('basic_power_share_5'),

		'executive_power_share_6' => input_get('executive_power_share_6'),
		'regular_power_share_6'   => input_get('regular_power_share_6'),
		'associate_power_share_6' => input_get('associate_power_share_6'),
		'basic_power_share_6'     => input_get('basic_power_share_6'),

		'executive_power_share_7' => input_get('executive_power_share_7'),
		'regular_power_share_7'   => input_get('regular_power_share_7'),
		'associate_power_share_7' => input_get('associate_power_share_7'),
		'basic_power_share_7'     => input_get('basic_power_share_7'),

		'executive_power_share_8' => input_get('executive_power_share_8'),
		'regular_power_share_8'   => input_get('regular_power_share_8'),
		'associate_power_share_8' => input_get('associate_power_share_8'),
		'basic_power_share_8'     => input_get('basic_power_share_8'),

		'executive_power_share_9' => input_get('executive_power_share_9'),
		'regular_power_share_9'   => input_get('regular_power_share_9'),
		'associate_power_share_9' => input_get('associate_power_share_9'),
		'basic_power_share_9'     => input_get('basic_power_share_9'),

		'executive_power_share_10' => input_get('executive_power_share_10'),
		'regular_power_share_10'   => input_get('regular_power_share_10'),
		'associate_power_share_10' => input_get('associate_power_share_10'),
		'basic_power_share_10'     => input_get('basic_power_share_10'),

		/*-------------------------------------------------------------------------------------------------*/

		'executive_power_share_cut_1' => input_get('executive_power_share_cut_1'),
		'regular_power_share_cut_1'   => input_get('regular_power_share_cut_1'),
		'associate_power_share_cut_1' => input_get('associate_power_share_cut_1'),
		'basic_power_share_cut_1'     => input_get('basic_power_share_cut_1'),

		'executive_power_share_cut_2' => input_get('executive_power_share_cut_2'),
		'regular_power_share_cut_2'   => input_get('regular_power_share_cut_2'),
		'associate_power_share_cut_2' => input_get('associate_power_share_cut_2'),
		'basic_power_share_cut_2'     => input_get('basic_power_share_cut_2'),

		'executive_power_share_cut_3' => input_get('executive_power_share_cut_3'),
		'regular_power_share_cut_3'   => input_get('regular_power_share_cut_3'),
		'associate_power_share_cut_3' => input_get('associate_power_share_cut_3'),
		'basic_power_share_cut_3'     => input_get('basic_power_share_cut_3'),

		'executive_power_share_cut_4' => input_get('executive_power_share_cut_4'),
		'regular_power_share_cut_4'   => input_get('regular_power_share_cut_4'),
		'associate_power_share_cut_4' => input_get('associate_power_share_cut_4'),
		'basic_power_share_cut_4'     => input_get('basic_power_share_cut_4'),

		'executive_power_share_cut_5' => input_get('executive_power_share_cut_5'),
		'regular_power_share_cut_5'   => input_get('regular_power_share_cut_5'),
		'associate_power_share_cut_5' => input_get('associate_power_share_cut_5'),
		'basic_power_share_cut_5'     => input_get('basic_power_share_cut_5'),

		'executive_power_share_cut_6' => input_get('executive_power_share_cut_6'),
		'regular_power_share_cut_6'   => input_get('regular_power_share_cut_6'),
		'associate_power_share_cut_6' => input_get('associate_power_share_cut_6'),
		'basic_power_share_cut_6'     => input_get('basic_power_share_cut_6'),

		'executive_power_share_cut_7' => input_get('executive_power_share_cut_7'),
		'regular_power_share_cut_7'   => input_get('regular_power_share_cut_7'),
		'associate_power_share_cut_7' => input_get('associate_power_share_cut_7'),
		'basic_power_share_cut_7'     => input_get('basic_power_share_cut_7'),

		'executive_power_share_cut_8' => input_get('executive_power_share_cut_8'),
		'regular_power_share_cut_8'   => input_get('regular_power_share_cut_8'),
		'associate_power_share_cut_8' => input_get('associate_power_share_cut_8'),
		'basic_power_share_cut_8'     => input_get('basic_power_share_cut_8'),

		'executive_power_share_cut_9' => input_get('executive_power_share_cut_9'),
		'regular_power_share_cut_9'   => input_get('regular_power_share_cut_9'),
		'associate_power_share_cut_9' => input_get('associate_power_share_cut_9'),
		'basic_power_share_cut_9'     => input_get('basic_power_share_cut_9'),

		'executive_power_share_cut_10' => input_get('executive_power_share_cut_10'),
		'regular_power_share_cut_10'   => input_get('regular_power_share_cut_10'),
		'associate_power_share_cut_10' => input_get('associate_power_share_cut_10'),
		'basic_power_share_cut_10'     => input_get('basic_power_share_cut_10'),

		'executive_power_level' => input_get('executive_power_level'),
		'regular_power_level'   => input_get('regular_power_level'),
		'associate_power_level' => input_get('associate_power_level'),
		'basic_power_level'     => input_get('basic_power_level'),

		'executive_power_width' => input_get('executive_power_width'),
		'regular_power_width'   => input_get('regular_power_width'),
		'associate_power_width' => input_get('associate_power_width'),
		'basic_power_width'     => input_get('basic_power_width'),

		'executive_entry' => input_get('executive_entry'),
		'regular_entry'   => input_get('regular_entry'),
		'associate_entry' => input_get('associate_entry'),
		'basic_entry'     => input_get('basic_entry'),

		'executive_reentry' => input_get('executive_reentry'),
		'regular_reentry'   => input_get('regular_reentry'),
		'associate_reentry' => input_get('associate_reentry'),
		'basic_reentry'     => input_get('basic_reentry'),

		'executive_upgrade' => input_get('executive_upgrade'),
		'regular_upgrade'   => input_get('regular_upgrade'),
		'associate_upgrade' => input_get('associate_upgrade'),
		'basic_upgrade'     => input_get('basic_upgrade'),

		'executive_sponsored' => input_get('executive_sponsored'),
		'regular_sponsored'   => input_get('regular_sponsored'),
		'associate_sponsored' => input_get('associate_sponsored'),
		'basic_sponsored'     => input_get('basic_sponsored')
	];
}

/**
 *
 *
 * @since version
 */
function update()
{
	$db = db();

	$input = get_input();

	$test = [
		$input['executive_power_level'],
		$input['regular_power_level'],
		$input['associate_power_level'],
		$input['basic_power_level'],

		$input['executive_power_width'],
		$input['regular_power_width'],
		$input['associate_power_width'],
		$input['basic_power_width'],

		$input['executive_reentry'],
		$input['regular_reentry'],
		$input['associate_reentry'],
		$input['basic_reentry'],

		$input['executive_upgrade'],
		$input['regular_upgrade'],
		$input['associate_upgrade'],
		$input['basic_upgrade']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_power',
				[
					'executive_power_share_1 = ' . $db->quote($input['executive_power_share_1']),
					'regular_power_share_1 = ' . $db->quote($input['regular_power_share_1']),
					'associate_power_share_1 = ' . $db->quote($input['associate_power_share_1']),
					'basic_power_share_1 = ' . $db->quote($input['basic_power_share_1']),

					'executive_power_share_2 = ' . $db->quote($input['executive_power_share_2']),
					'regular_power_share_2 = ' . $db->quote($input['regular_power_share_2']),
					'associate_power_share_2 = ' . $db->quote($input['associate_power_share_2']),
					'basic_power_share_2 = ' . $db->quote($input['basic_power_share_2']),

					'executive_power_share_3 = ' . $db->quote($input['executive_power_share_3']),
					'regular_power_share_3 = ' . $db->quote($input['regular_power_share_3']),
					'associate_power_share_3 = ' . $db->quote($input['associate_power_share_3']),
					'basic_power_share_3 = ' . $db->quote($input['basic_power_share_3']),

					'executive_power_share_4 = ' . $db->quote($input['executive_power_share_4']),
					'regular_power_share_4 = ' . $db->quote($input['regular_power_share_4']),
					'associate_power_share_4 = ' . $db->quote($input['associate_power_share_4']),
					'basic_power_share_4 = ' . $db->quote($input['basic_power_share_4']),

					'executive_power_share_5 = ' . $db->quote($input['executive_power_share_5']),
					'regular_power_share_5 = ' . $db->quote($input['regular_power_share_5']),
					'associate_power_share_5 = ' . $db->quote($input['associate_power_share_5']),
					'basic_power_share_5 = ' . $db->quote($input['basic_power_share_5']),

					'executive_power_share_6 = ' . $db->quote($input['executive_power_share_6']),
					'regular_power_share_6 = ' . $db->quote($input['regular_power_share_6']),
					'associate_power_share_6 = ' . $db->quote($input['associate_power_share_6']),
					'basic_power_share_6 = ' . $db->quote($input['basic_power_share_6']),

					'executive_power_share_7 = ' . $db->quote($input['executive_power_share_7']),
					'regular_power_share_7 = ' . $db->quote($input['regular_power_share_7']),
					'associate_power_share_7 = ' . $db->quote($input['associate_power_share_7']),
					'basic_power_share_7 = ' . $db->quote($input['basic_power_share_7']),

					'executive_power_share_8 = ' . $db->quote($input['executive_power_share_8']),
					'regular_power_share_8 = ' . $db->quote($input['regular_power_share_8']),
					'associate_power_share_8 = ' . $db->quote($input['associate_power_share_8']),
					'basic_power_share_8 = ' . $db->quote($input['basic_power_share_8']),

					'executive_power_share_9 = ' . $db->quote($input['executive_power_share_9']),
					'regular_power_share_9 = ' . $db->quote($input['regular_power_share_9']),
					'associate_power_share_9 = ' . $db->quote($input['associate_power_share_9']),
					'basic_power_share_9 = ' . $db->quote($input['basic_power_share_9']),

					'executive_power_share_10 = ' . $db->quote($input['executive_power_share_10']),
					'regular_power_share_10 = ' . $db->quote($input['regular_power_share_10']),
					'associate_power_share_10 = ' . $db->quote($input['associate_power_share_10']),
					'basic_power_share_10 = ' . $db->quote($input['basic_power_share_10']),

					'executive_power_share_cut_1 = ' . $db->quote($input['executive_power_share_cut_1']),
					'regular_power_share_cut_1 = ' . $db->quote($input['regular_power_share_cut_1']),
					'associate_power_share_cut_1 = ' . $db->quote($input['associate_power_share_cut_1']),
					'basic_power_share_cut_1 = ' . $db->quote($input['basic_power_share_cut_1']),

					'executive_power_share_cut_2 = ' . $db->quote($input['executive_power_share_cut_2']),
					'regular_power_share_cut_2 = ' . $db->quote($input['regular_power_share_cut_2']),
					'associate_power_share_cut_2 = ' . $db->quote($input['associate_power_share_cut_2']),
					'basic_power_share_cut_2 = ' . $db->quote($input['basic_power_share_cut_2']),

					'executive_power_share_cut_3 = ' . $db->quote($input['executive_power_share_cut_3']),
					'regular_power_share_cut_3 = ' . $db->quote($input['regular_power_share_cut_3']),
					'associate_power_share_cut_3 = ' . $db->quote($input['associate_power_share_cut_3']),
					'basic_power_share_cut_3 = ' . $db->quote($input['basic_power_share_cut_3']),

					'executive_power_share_cut_4 = ' . $db->quote($input['executive_power_share_cut_4']),
					'regular_power_share_cut_4 = ' . $db->quote($input['regular_power_share_cut_4']),
					'associate_power_share_cut_4 = ' . $db->quote($input['associate_power_share_cut_4']),
					'basic_power_share_cut_4 = ' . $db->quote($input['basic_power_share_cut_4']),

					'executive_power_share_cut_5 = ' . $db->quote($input['executive_power_share_cut_5']),
					'regular_power_share_cut_5 = ' . $db->quote($input['regular_power_share_cut_5']),
					'associate_power_share_cut_5 = ' . $db->quote($input['associate_power_share_cut_5']),
					'basic_power_share_cut_5 = ' . $db->quote($input['basic_power_share_cut_5']),

					'executive_power_share_cut_6 = ' . $db->quote($input['executive_power_share_cut_6']),
					'regular_power_share_cut_6 = ' . $db->quote($input['regular_power_share_cut_6']),
					'associate_power_share_cut_6 = ' . $db->quote($input['associate_power_share_cut_6']),
					'basic_power_share_cut_6 = ' . $db->quote($input['basic_power_share_cut_6']),

					'executive_power_share_cut_7 = ' . $db->quote($input['executive_power_share_cut_7']),
					'regular_power_share_cut_7 = ' . $db->quote($input['regular_power_share_cut_7']),
					'associate_power_share_cut_7 = ' . $db->quote($input['associate_power_share_cut_7']),
					'basic_power_share_cut_7 = ' . $db->quote($input['basic_power_share_cut_7']),

					'executive_power_share_cut_8 = ' . $db->quote($input['executive_power_share_cut_8']),
					'regular_power_share_cut_8 = ' . $db->quote($input['regular_power_share_cut_8']),
					'associate_power_share_cut_8 = ' . $db->quote($input['associate_power_share_cut_8']),
					'basic_power_share_cut_8 = ' . $db->quote($input['basic_power_share_cut_8']),

					'executive_power_share_cut_9 = ' . $db->quote($input['executive_power_share_cut_9']),
					'regular_power_share_cut_9 = ' . $db->quote($input['regular_power_share_cut_9']),
					'associate_power_share_cut_9 = ' . $db->quote($input['associate_power_share_cut_9']),
					'basic_power_share_cut_9 = ' . $db->quote($input['basic_power_share_cut_9']),

					'executive_power_share_cut_10 = ' . $db->quote($input['executive_power_share_cut_10']),
					'regular_power_share_cut_10 = ' . $db->quote($input['regular_power_share_cut_10']),
					'associate_power_share_cut_10 = ' . $db->quote($input['associate_power_share_cut_10']),
					'basic_power_share_cut_10 = ' . $db->quote($input['basic_power_share_cut_10']),

					'executive_power_level = ' . $db->quote($input['executive_power_level']),
					'regular_power_level = ' . $db->quote($input['regular_power_level']),
					'associate_power_level = ' . $db->quote($input['associate_power_level']),
					'basic_power_level = ' . $db->quote($input['basic_power_level']),

					'executive_power_width = ' . $db->quote($input['executive_power_width']),
					'regular_power_width = ' . $db->quote($input['regular_power_width']),
					'associate_power_width = ' . $db->quote($input['associate_power_width']),
					'basic_power_width = ' . $db->quote($input['basic_power_width']),

					'executive_entry = ' . $db->quote($input['executive_entry']),
					'regular_entry = ' . $db->quote($input['regular_entry']),
					'associate_entry = ' . $db->quote($input['associate_entry']),
					'basic_entry = ' . $db->quote($input['basic_entry']),

					'executive_reentry = ' . $db->quote($input['executive_reentry']),
					'regular_reentry = ' . $db->quote($input['regular_reentry']),
					'associate_reentry = ' . $db->quote($input['associate_reentry']),
					'basic_reentry = ' . $db->quote($input['basic_reentry']),

					'executive_upgrade = ' . $db->quote($input['executive_upgrade']),
					'regular_upgrade = ' . $db->quote($input['regular_upgrade']),
					'associate_upgrade = ' . $db->quote($input['associate_upgrade']),
					'basic_upgrade = ' . $db->quote($input['basic_upgrade']),

					'executive_sponsored = ' . $db->quote($input['executive_sponsored']),
					'regular_sponsored = ' . $db->quote($input['regular_sponsored']),
					'associate_sponsored = ' . $db->quote($input['associate_sponsored']),
					'basic_sponsored = ' . $db->quote($input['basic_sponsored'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(89),
			settings('plans')->power_name . ' Settings Updated Successfully!', 'success');
	}
}

/**
 *
 * @return string
 *
 * @since version
 */
function style(): string
{
	return '<style>
		.table th, .table td {
			vertical-align: middle;
			text-align: center;
		}
        .net_align {
            width: 120px;
            text-align: center;
        }
        
        .center_align {
        	text-align: center;
        	display: block;    
        	margin: 0;
        }   
        
        label {
        	margin-bottom: 0;
        }       

        select {
            text-align-last: center;
            direction: ltr;
        }
    </style>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view(): string
{
	$settings_entry = settings('entry');

	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
    <form method="post">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">' . settings('plans')->power_name .
		' (' . settings('ancillaries')->currency . ')' . '</h3></td>
            </tr>
            <tr>
                <td></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>';

	$str .= view_row_share();
	$str .= view_row_share_cut();
	$str .= view_row_level();
	$str .= view_row_width();
	$str .= view_row_sponsored_members();
	$str .= view_row_entry_cost();
	$str .= view_row_reentry_cost();
	$str .= view_row_upgrade_cost();

        $str .= '</table>
        <div class="center_align">
            <input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
        </div>
    </form>
    </div></div></section>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_share(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Share (%):</div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('executive', $settings_power->executive_power_level) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('regular', $settings_power->regular_power_level) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('associate', $settings_power->associate_power_level) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('basic', $settings_power->basic_power_level) .
		'</ul>
                    </div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_share_cut(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Share Cut (%):</div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('executive', $settings_power->executive_power_level) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('regular', $settings_power->regular_power_level) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('associate', $settings_power->associate_power_level) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('basic', $settings_power->basic_power_level) .
		'</ul>
                    </div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_level(): string
{
	return '<tr>
                <td>
                    <div class="center_align">Level:</div>
                </td>
                <td>
                    <div class="center_align"><label><select name="executive_power_level" style="width:150px">' .
		view_level('executive') .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="regular_power_level" style="width:150px">' .
		view_level('regular') .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="associate_power_level" style="width:150px">' .
		view_level('associate') .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="basic_power_level" style="width:150px">' .
		view_level('basic') .
		'</select></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_width(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Width:</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_power_width" class="net_align"
                                      value="' . number_format($settings_power->executive_power_width) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_power_width" class="net_align"
                                      value="' . number_format($settings_power->regular_power_width) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_power_width" class="net_align"
                                      value="' . number_format($settings_power->associate_power_width) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_power_width" class="net_align"
                                      value="' . number_format($settings_power->basic_power_width) . '" required>
                        </label>
                    </div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_sponsored_members(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Sponsored Members:</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_sponsored" class="net_align"
                                      value="' . number_format($settings_power->executive_sponsored) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_sponsored" class="net_align"
                                      value="' . number_format($settings_power->regular_sponsored) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_sponsored" class="net_align"
                                      value="' . number_format($settings_power->associate_sponsored) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_sponsored" class="net_align"
                                      value="' . number_format($settings_power->basic_sponsored) . '" required>
                        </label>
                    </div>
                </td>
            </tr> ';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_entry_cost(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Entry Cost (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_entry" class="net_align"
                                      value="' . number_format($settings_power->executive_entry) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_entry" class="net_align"
                                      value="' . number_format($settings_power->regular_entry) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_entry" class="net_align"
                                      value="' . number_format($settings_power->associate_entry) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_entry" class="net_align"
                                      value="' . number_format($settings_power->basic_entry) . '" required>
                        </label>
                    </div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_reentry_cost(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Re-entry Cost (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_reentry" class="net_align"
                                      value="' . number_format($settings_power->executive_reentry) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_reentry" class="net_align"
                                      value="' . number_format($settings_power->regular_reentry) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_reentry" class="net_align"
                                      value="' . number_format($settings_power->associate_reentry) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_reentry" class="net_align"
                                      value="' . number_format($settings_power->basic_reentry) . '" required>
                        </label>
                    </div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_upgrade_cost(): string
{
	$settings_power = settings('power');

	return '<tr>
                <td>
                    <div class="center_align">Upgrade Cost (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_upgrade" class="net_align"
                                      value="' . number_format($settings_power->executive_upgrade) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_upgrade" class="net_align"
                                      value="' . number_format($settings_power->regular_upgrade) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_upgrade" class="net_align"
                                      value="' . number_format($settings_power->associate_upgrade) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_upgrade" class="net_align"
                                      value="' . number_format($settings_power->basic_upgrade) . '" required>
                        </label>
                    </div>
                </td>
            </tr>';
}

/**
 * @param        $account
 * @param   int  $level
 * @param   int  $decimal
 *
 * @return string
 *
 * @since version
 */
function view_share($account, int $level = 10, int $decimal = 2): string
{
	$str = '';

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$str .= '<li><label>
                <input name="' . $account . '_power_share_' . $i_i . '" style="width:150px"
                       class="net_align" value="' . number_format(settings('power')->{$account .
			'_power_share_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
	}

	return $str;
}

/**
 * @param        $account
 * @param   int  $level
 * @param   int  $decimal
 *
 * @return string
 *
 * @since version
 */
function view_share_cut($account, int $level = 10, int $decimal = 2): string
{
	$str = '';

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$str .= '<li>
            <label>
                <input name="' . $account . '_power_share_cut_' . $i_i . '" style="width:150px"
                       class="net_align" value="' . number_format(settings('power')->{$account .
			'_power_share_cut_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
	}

	return $str;
}

/**
 * @param $account_type
 *
 * @return mixed
 *
 * @since version
 */
function get_level($account_type)
{
	return settings('power')->{$account_type . '_power_level'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function level_power($account_type, $value): string
{
	return (int) get_level($account_type) === (int) $value ? 'selected' : '';
}

/**
 * @param        $account_type
 * @param   int  $level
 *
 * @return string
 *
 * @since version
 */
function view_level($account_type, int $level = 10): string
{
	$str = '';

	for ($i_i = 0; $i_i <= $level; $i_i++)
	{
		$str .= '<option value="' . $i_i . '" ' . level_power($account_type, $i_i) . '>' . $i_i . '</option>';
	}

	return $str;
}