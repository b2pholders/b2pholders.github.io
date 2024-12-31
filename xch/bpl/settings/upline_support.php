<?php

namespace BPL\Settings\Upline_Support;

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
		'executive_upline_support_share_1' => input_get('executive_upline_support_share_1'),
		'regular_upline_support_share_1'   => input_get('regular_upline_support_share_1'),
		'associate_upline_support_share_1' => input_get('associate_upline_support_share_1'),
		'basic_upline_support_share_1'     => input_get('basic_upline_support_share_1'),

		'executive_upline_support_share_2' => input_get('executive_upline_support_share_2'),
		'regular_upline_support_share_2'   => input_get('regular_upline_support_share_2'),
		'associate_upline_support_share_2' => input_get('associate_upline_support_share_2'),
		'basic_upline_support_share_2'     => input_get('basic_upline_support_share_2'),

		'executive_upline_support_share_3' => input_get('executive_upline_support_share_3'),
		'regular_upline_support_share_3'   => input_get('regular_upline_support_share_3'),
		'associate_upline_support_share_3' => input_get('associate_upline_support_share_3'),
		'basic_upline_support_share_3'     => input_get('basic_upline_support_share_3'),

		'executive_upline_support_share_4' => input_get('executive_upline_support_share_4'),
		'regular_upline_support_share_4'   => input_get('regular_upline_support_share_4'),
		'associate_upline_support_share_4' => input_get('associate_upline_support_share_4'),
		'basic_upline_support_share_4'     => input_get('basic_upline_support_share_4'),

		'executive_upline_support_share_5' => input_get('executive_upline_support_share_5'),
		'regular_upline_support_share_5'   => input_get('regular_upline_support_share_5'),
		'associate_upline_support_share_5' => input_get('associate_upline_support_share_5'),
		'basic_upline_support_share_5'     => input_get('basic_upline_support_share_5'),

		'executive_upline_support_share_6' => input_get('executive_upline_support_share_6'),
		'regular_upline_support_share_6'   => input_get('regular_upline_support_share_6'),
		'associate_upline_support_share_6' => input_get('associate_upline_support_share_6'),
		'basic_upline_support_share_6'     => input_get('basic_upline_support_share_6'),

		'executive_upline_support_share_7' => input_get('executive_upline_support_share_7'),
		'regular_upline_support_share_7'   => input_get('regular_upline_support_share_7'),
		'associate_upline_support_share_7' => input_get('associate_upline_support_share_7'),
		'basic_upline_support_share_7'     => input_get('basic_upline_support_share_7'),

		'executive_upline_support_share_8' => input_get('executive_upline_support_share_8'),
		'regular_upline_support_share_8'   => input_get('regular_upline_support_share_8'),
		'associate_upline_support_share_8' => input_get('associate_upline_support_share_8'),
		'basic_upline_support_share_8'     => input_get('basic_upline_support_share_8'),

		'executive_upline_support_share_9' => input_get('executive_upline_support_share_9'),
		'regular_upline_support_share_9'   => input_get('regular_upline_support_share_9'),
		'associate_upline_support_share_9' => input_get('associate_upline_support_share_9'),
		'basic_upline_support_share_9'     => input_get('basic_upline_support_share_9'),

		'executive_upline_support_share_10' => input_get('executive_upline_support_share_10'),
		'regular_upline_support_share_10'   => input_get('regular_upline_support_share_10'),
		'associate_upline_support_share_10' => input_get('associate_upline_support_share_10'),
		'basic_upline_support_share_10'     => input_get('basic_upline_support_share_10'),

		/*-------------------------------------------------------------------------------------------------*/

		'executive_upline_support_share_cut_1' => input_get('executive_upline_support_share_cut_1'),
		'regular_upline_support_share_cut_1'   => input_get('regular_upline_support_share_cut_1'),
		'associate_upline_support_share_cut_1' => input_get('associate_upline_support_share_cut_1'),
		'basic_upline_support_share_cut_1'     => input_get('basic_upline_support_share_cut_1'),

		'executive_upline_support_share_cut_2' => input_get('executive_upline_support_share_cut_2'),
		'regular_upline_support_share_cut_2'   => input_get('regular_upline_support_share_cut_2'),
		'associate_upline_support_share_cut_2' => input_get('associate_upline_support_share_cut_2'),
		'basic_upline_support_share_cut_2'     => input_get('basic_upline_support_share_cut_2'),

		'executive_upline_support_share_cut_3' => input_get('executive_upline_support_share_cut_3'),
		'regular_upline_support_share_cut_3'   => input_get('regular_upline_support_share_cut_3'),
		'associate_upline_support_share_cut_3' => input_get('associate_upline_support_share_cut_3'),
		'basic_upline_support_share_cut_3'     => input_get('basic_upline_support_share_cut_3'),

		'executive_upline_support_share_cut_4' => input_get('executive_upline_support_share_cut_4'),
		'regular_upline_support_share_cut_4'   => input_get('regular_upline_support_share_cut_4'),
		'associate_upline_support_share_cut_4' => input_get('associate_upline_support_share_cut_4'),
		'basic_upline_support_share_cut_4'     => input_get('basic_upline_support_share_cut_4'),

		'executive_upline_support_share_cut_5' => input_get('executive_upline_support_share_cut_5'),
		'regular_upline_support_share_cut_5'   => input_get('regular_upline_support_share_cut_5'),
		'associate_upline_support_share_cut_5' => input_get('associate_upline_support_share_cut_5'),
		'basic_upline_support_share_cut_5'     => input_get('basic_upline_support_share_cut_5'),

		'executive_upline_support_share_cut_6' => input_get('executive_upline_support_share_cut_6'),
		'regular_upline_support_share_cut_6'   => input_get('regular_upline_support_share_cut_6'),
		'associate_upline_support_share_cut_6' => input_get('associate_upline_support_share_cut_6'),
		'basic_upline_support_share_cut_6'     => input_get('basic_upline_support_share_cut_6'),

		'executive_upline_support_share_cut_7' => input_get('executive_upline_support_share_cut_7'),
		'regular_upline_support_share_cut_7'   => input_get('regular_upline_support_share_cut_7'),
		'associate_upline_support_share_cut_7' => input_get('associate_upline_support_share_cut_7'),
		'basic_upline_support_share_cut_7'     => input_get('basic_upline_support_share_cut_7'),

		'executive_upline_support_share_cut_8' => input_get('executive_upline_support_share_cut_8'),
		'regular_upline_support_share_cut_8'   => input_get('regular_upline_support_share_cut_8'),
		'associate_upline_support_share_cut_8' => input_get('associate_upline_support_share_cut_8'),
		'basic_upline_support_share_cut_8'     => input_get('basic_upline_support_share_cut_8'),

		'executive_upline_support_share_cut_9' => input_get('executive_upline_support_share_cut_9'),
		'regular_upline_support_share_cut_9'   => input_get('regular_upline_support_share_cut_9'),
		'associate_upline_support_share_cut_9' => input_get('associate_upline_support_share_cut_9'),
		'basic_upline_support_share_cut_9'     => input_get('basic_upline_support_share_cut_9'),

		'executive_upline_support_share_cut_10' => input_get('executive_upline_support_share_cut_10'),
		'regular_upline_support_share_cut_10'   => input_get('regular_upline_support_share_cut_10'),
		'associate_upline_support_share_cut_10' => input_get('associate_upline_support_share_cut_10'),
		'basic_upline_support_share_cut_10'     => input_get('basic_upline_support_share_cut_10'),

		'executive_upline_support_level' => input_get('executive_upline_support_level'),
		'regular_upline_support_level'   => input_get('regular_upline_support_level'),
		'associate_upline_support_level' => input_get('associate_upline_support_level'),
		'basic_upline_support_level'     => input_get('basic_upline_support_level'),

		'executive_upline_support_sponsored' => input_get('executive_upline_support_sponsored'),
		'regular_upline_support_sponsored'   => input_get('regular_upline_support_sponsored'),
		'associate_upline_support_sponsored' => input_get('associate_upline_support_sponsored'),
		'basic_upline_support_sponsored'     => input_get('basic_upline_support_sponsored')

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
		$input['executive_upline_support_level'],
		$input['regular_upline_support_level'],
		$input['associate_upline_support_level'],
		$input['basic_upline_support_level']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_upline_support',
				[
					'executive_upline_support_share_1 = ' . $db->quote($input['executive_upline_support_share_1']),
					'regular_upline_support_share_1 = ' . $db->quote($input['regular_upline_support_share_1']),
					'associate_upline_support_share_1 = ' . $db->quote($input['associate_upline_support_share_1']),
					'basic_upline_support_share_1 = ' . $db->quote($input['basic_upline_support_share_1']),

					'executive_upline_support_share_2 = ' . $db->quote($input['executive_upline_support_share_2']),
					'regular_upline_support_share_2 = ' . $db->quote($input['regular_upline_support_share_2']),
					'associate_upline_support_share_2 = ' . $db->quote($input['associate_upline_support_share_2']),
					'basic_upline_support_share_2 = ' . $db->quote($input['basic_upline_support_share_2']),

					'executive_upline_support_share_3 = ' . $db->quote($input['executive_upline_support_share_3']),
					'regular_upline_support_share_3 = ' . $db->quote($input['regular_upline_support_share_3']),
					'associate_upline_support_share_3 = ' . $db->quote($input['associate_upline_support_share_3']),
					'basic_upline_support_share_3 = ' . $db->quote($input['basic_upline_support_share_3']),

					'executive_upline_support_share_4 = ' . $db->quote($input['executive_upline_support_share_4']),
					'regular_upline_support_share_4 = ' . $db->quote($input['regular_upline_support_share_4']),
					'associate_upline_support_share_4 = ' . $db->quote($input['associate_upline_support_share_4']),
					'basic_upline_support_share_4 = ' . $db->quote($input['basic_upline_support_share_4']),

					'executive_upline_support_share_5 = ' . $db->quote($input['executive_upline_support_share_5']),
					'regular_upline_support_share_5 = ' . $db->quote($input['regular_upline_support_share_5']),
					'associate_upline_support_share_5 = ' . $db->quote($input['associate_upline_support_share_5']),
					'basic_upline_support_share_5 = ' . $db->quote($input['basic_upline_support_share_5']),

					'executive_upline_support_share_6 = ' . $db->quote($input['executive_upline_support_share_6']),
					'regular_upline_support_share_6 = ' . $db->quote($input['regular_upline_support_share_6']),
					'associate_upline_support_share_6 = ' . $db->quote($input['associate_upline_support_share_6']),
					'basic_upline_support_share_6 = ' . $db->quote($input['basic_upline_support_share_6']),

					'executive_upline_support_share_7 = ' . $db->quote($input['executive_upline_support_share_7']),
					'regular_upline_support_share_7 = ' . $db->quote($input['regular_upline_support_share_7']),
					'associate_upline_support_share_7 = ' . $db->quote($input['associate_upline_support_share_7']),
					'basic_upline_support_share_7 = ' . $db->quote($input['basic_upline_support_share_7']),

					'executive_upline_support_share_8 = ' . $db->quote($input['executive_upline_support_share_8']),
					'regular_upline_support_share_8 = ' . $db->quote($input['regular_upline_support_share_8']),
					'associate_upline_support_share_8 = ' . $db->quote($input['associate_upline_support_share_8']),
					'basic_upline_support_share_8 = ' . $db->quote($input['basic_upline_support_share_8']),

					'executive_upline_support_share_9 = ' . $db->quote($input['executive_upline_support_share_9']),
					'regular_upline_support_share_9 = ' . $db->quote($input['regular_upline_support_share_9']),
					'associate_upline_support_share_9 = ' . $db->quote($input['associate_upline_support_share_9']),
					'basic_upline_support_share_9 = ' . $db->quote($input['basic_upline_support_share_9']),

					'executive_upline_support_share_10 = ' . $db->quote($input['executive_upline_support_share_10']),
					'regular_upline_support_share_10 = ' . $db->quote($input['regular_upline_support_share_10']),
					'associate_upline_support_share_10 = ' . $db->quote($input['associate_upline_support_share_10']),
					'basic_upline_support_share_10 = ' . $db->quote($input['basic_upline_support_share_10']),

					'executive_upline_support_share_cut_1 = ' . $db->quote($input['executive_upline_support_share_cut_1']),
					'regular_upline_support_share_cut_1 = ' . $db->quote($input['regular_upline_support_share_cut_1']),
					'associate_upline_support_share_cut_1 = ' . $db->quote($input['associate_upline_support_share_cut_1']),
					'basic_upline_support_share_cut_1 = ' . $db->quote($input['basic_upline_support_share_cut_1']),

					'executive_upline_support_share_cut_2 = ' . $db->quote($input['executive_upline_support_share_cut_2']),
					'regular_upline_support_share_cut_2 = ' . $db->quote($input['regular_upline_support_share_cut_2']),
					'associate_upline_support_share_cut_2 = ' . $db->quote($input['associate_upline_support_share_cut_2']),
					'basic_upline_support_share_cut_2 = ' . $db->quote($input['basic_upline_support_share_cut_2']),

					'executive_upline_support_share_cut_3 = ' . $db->quote($input['executive_upline_support_share_cut_3']),
					'regular_upline_support_share_cut_3 = ' . $db->quote($input['regular_upline_support_share_cut_3']),
					'associate_upline_support_share_cut_3 = ' . $db->quote($input['associate_upline_support_share_cut_3']),
					'basic_upline_support_share_cut_3 = ' . $db->quote($input['basic_upline_support_share_cut_3']),

					'executive_upline_support_share_cut_4 = ' . $db->quote($input['executive_upline_support_share_cut_4']),
					'regular_upline_support_share_cut_4 = ' . $db->quote($input['regular_upline_support_share_cut_4']),
					'associate_upline_support_share_cut_4 = ' . $db->quote($input['associate_upline_support_share_cut_4']),
					'basic_upline_support_share_cut_4 = ' . $db->quote($input['basic_upline_support_share_cut_4']),

					'executive_upline_support_share_cut_5 = ' . $db->quote($input['executive_upline_support_share_cut_5']),
					'regular_upline_support_share_cut_5 = ' . $db->quote($input['regular_upline_support_share_cut_5']),
					'associate_upline_support_share_cut_5 = ' . $db->quote($input['associate_upline_support_share_cut_5']),
					'basic_upline_support_share_cut_5 = ' . $db->quote($input['basic_upline_support_share_cut_5']),

					'executive_upline_support_share_cut_6 = ' . $db->quote($input['executive_upline_support_share_cut_6']),
					'regular_upline_support_share_cut_6 = ' . $db->quote($input['regular_upline_support_share_cut_6']),
					'associate_upline_support_share_cut_6 = ' . $db->quote($input['associate_upline_support_share_cut_6']),
					'basic_upline_support_share_cut_6 = ' . $db->quote($input['basic_upline_support_share_cut_6']),

					'executive_upline_support_share_cut_7 = ' . $db->quote($input['executive_upline_support_share_cut_7']),
					'regular_upline_support_share_cut_7 = ' . $db->quote($input['regular_upline_support_share_cut_7']),
					'associate_upline_support_share_cut_7 = ' . $db->quote($input['associate_upline_support_share_cut_7']),
					'basic_upline_support_share_cut_7 = ' . $db->quote($input['basic_upline_support_share_cut_7']),

					'executive_upline_support_share_cut_8 = ' . $db->quote($input['executive_upline_support_share_cut_8']),
					'regular_upline_support_share_cut_8 = ' . $db->quote($input['regular_upline_support_share_cut_8']),
					'associate_upline_support_share_cut_8 = ' . $db->quote($input['associate_upline_support_share_cut_8']),
					'basic_upline_support_share_cut_8 = ' . $db->quote($input['basic_upline_support_share_cut_8']),

					'executive_upline_support_share_cut_9 = ' . $db->quote($input['executive_upline_support_share_cut_9']),
					'regular_upline_support_share_cut_9 = ' . $db->quote($input['regular_upline_support_share_cut_9']),
					'associate_upline_support_share_cut_9 = ' . $db->quote($input['associate_upline_support_share_cut_9']),
					'basic_upline_support_share_cut_9 = ' . $db->quote($input['basic_upline_support_share_cut_9']),

					'executive_upline_support_share_cut_10 = ' . $db->quote($input['executive_upline_support_share_cut_10']),
					'regular_upline_support_share_cut_10 = ' . $db->quote($input['regular_upline_support_share_cut_10']),
					'associate_upline_support_share_cut_10 = ' . $db->quote($input['associate_upline_support_share_cut_10']),
					'basic_upline_support_share_cut_10 = ' . $db->quote($input['basic_upline_support_share_cut_10']),

					'executive_upline_support_level = ' . $db->quote($input['executive_upline_support_level']),
					'regular_upline_support_level = ' . $db->quote($input['regular_upline_support_level']),
					'associate_upline_support_level = ' . $db->quote($input['associate_upline_support_level']),
					'basic_upline_support_level = ' . $db->quote($input['basic_upline_support_level']),

					'executive_upline_support_sponsored = ' . $db->quote($input['executive_upline_support_sponsored']),
					'regular_upline_support_sponsored = ' . $db->quote($input['regular_upline_support_sponsored']),
					'associate_upline_support_sponsored = ' . $db->quote($input['associate_upline_support_sponsored']),
					'basic_upline_support_sponsored = ' . $db->quote($input['basic_upline_support_sponsored'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(117),
			settings('plans')->upline_support_name . ' Settings Updated Successfully!', 'success');
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
                <td colspan="5"><h3
                            class="center_align">' .
		settings('plans')->upline_support_name . ' (' . settings('ancillaries')->currency . ')' . '</h3>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>';

	$str .= view_row_share();
	$str .= view_row_share_cut();
	$str .= view_row_level();
	$str .= view_row_sponsored_members();

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
	$settings_upline_support = settings('upline_support');

	return '<tr>
                <td>
                    <div class="center_align">Share (%):</div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('executive', $settings_upline_support->executive_upline_support_level, 5) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('regular', $settings_upline_support->regular_upline_support_level, 5) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('associate', $settings_upline_support->associate_upline_support_level, 5) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('basic', $settings_upline_support->basic_upline_support_level, 5) .
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
	$settings_upline_support = settings('upline_support');

	return '<tr>
                <td>
                    <div class="center_align">Share Cut (%):</div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('executive', $settings_upline_support->executive_upline_support_level, 5) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('regular', $settings_upline_support->regular_upline_support_level, 5) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('associate', $settings_upline_support->associate_upline_support_level, 5) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share_cut('basic', $settings_upline_support->basic_upline_support_level, 5) .
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
                    <div class="center_align"><label><select name="executive_upline_support_level" style="width:150px">' .
		view_level('executive') .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="regular_upline_support_level" style="width:150px">' .
		view_level('regular') .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="associate_upline_support_level" style="width:150px">' .
		view_level('associate') .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="basic_upline_support_level" style="width:150px">' .
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
function view_row_sponsored_members(): string
{
	$settings_upline_support = settings('upline_support');

	return '<tr>
                <td>
                    <div class="center_align">Sponsored Members:</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_upline_support_sponsored" class="net_align"
                                      value="' .
		number_format($settings_upline_support->executive_upline_support_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_upline_support_sponsored" class="net_align"
                                      value="' .
		number_format($settings_upline_support->regular_upline_support_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_upline_support_sponsored" class="net_align"
                                      value="' .
		number_format($settings_upline_support->associate_upline_support_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_upline_support_sponsored" class="net_align"
                                      value="' .
		number_format($settings_upline_support->basic_upline_support_sponsored) . '"
                                      required>
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
                <input name="' . $account . '_upline_support_share_' . $i_i . '" style="width:150px"
                       class="net_align"
                       value="' . number_format(settings('upline_support')->{$account .
			'_upline_support_share_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
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
                <input name="' . $account . '_upline_support_share_cut_' . $i_i . '" style="width:150px"
                       class="net_align"
                       value="' . number_format(settings('upline_support')->{$account .
			'_upline_support_share_cut_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
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
	return settings('upline_support')->{$account_type . '_upline_support_level'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function level($account_type, $value): string
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
		$str .= '<option value="' . $i_i . '" ' . level($account_type, $i_i) . '> ' . $i_i . '</option>';
	}

	return $str;
}