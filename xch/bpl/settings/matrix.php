<?php

namespace BPL\Settings\Matrix;

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
		'executive_matrix_share_1' => input_get('executive_matrix_share_1'),
		'regular_matrix_share_1'   => input_get('regular_matrix_share_1'),
		'associate_matrix_share_1' => input_get('associate_matrix_share_1'),
		'basic_matrix_share_1'     => input_get('basic_matrix_share_1'),

		'executive_matrix_share_2' => input_get('executive_matrix_share_2'),
		'regular_matrix_share_2'   => input_get('regular_matrix_share_2'),
		'associate_matrix_share_2' => input_get('associate_matrix_share_2'),
		'basic_matrix_share_2'     => input_get('basic_matrix_share_2'),

		'executive_matrix_share_3' => input_get('executive_matrix_share_3'),
		'regular_matrix_share_3'   => input_get('regular_matrix_share_3'),
		'associate_matrix_share_3' => input_get('associate_matrix_share_3'),
		'basic_matrix_share_3'     => input_get('basic_matrix_share_3'),

		'executive_matrix_share_4' => input_get('executive_matrix_share_4'),
		'regular_matrix_share_4'   => input_get('regular_matrix_share_4'),
		'associate_matrix_share_4' => input_get('associate_matrix_share_4'),
		'basic_matrix_share_4'     => input_get('basic_matrix_share_4'),

		'executive_matrix_share_5' => input_get('executive_matrix_share_5'),
		'regular_matrix_share_5'   => input_get('regular_matrix_share_5'),
		'associate_matrix_share_5' => input_get('associate_matrix_share_5'),
		'basic_matrix_share_5'     => input_get('basic_matrix_share_5'),

		'executive_matrix_share_6' => input_get('executive_matrix_share_6'),
		'regular_matrix_share_6'   => input_get('regular_matrix_share_6'),
		'associate_matrix_share_6' => input_get('associate_matrix_share_6'),
		'basic_matrix_share_6'     => input_get('basic_matrix_share_6'),

		'executive_matrix_share_7' => input_get('executive_matrix_share_7'),
		'regular_matrix_share_7'   => input_get('regular_matrix_share_7'),
		'associate_matrix_share_7' => input_get('associate_matrix_share_7'),
		'basic_matrix_share_7'     => input_get('basic_matrix_share_7'),

		'executive_matrix_share_8' => input_get('executive_matrix_share_8'),
		'regular_matrix_share_8'   => input_get('regular_matrix_share_8'),
		'associate_matrix_share_8' => input_get('associate_matrix_share_8'),
		'basic_matrix_share_8'     => input_get('basic_matrix_share_8'),

		'executive_matrix_share_9' => input_get('executive_matrix_share_9'),
		'regular_matrix_share_9'   => input_get('regular_matrix_share_9'),
		'associate_matrix_share_9' => input_get('associate_matrix_share_9'),
		'basic_matrix_share_9'     => input_get('basic_matrix_share_9'),

		'executive_matrix_share_10' => input_get('executive_matrix_share_10'),
		'regular_matrix_share_10'   => input_get('regular_matrix_share_10'),
		'associate_matrix_share_10' => input_get('associate_matrix_share_10'),
		'basic_matrix_share_10'     => input_get('basic_matrix_share_10'),

		/*-------------------------------------------------------------------------------------------------*/

		'executive_matrix_share_cut_1' => input_get('executive_matrix_share_cut_1'),
		'regular_matrix_share_cut_1'   => input_get('regular_matrix_share_cut_1'),
		'associate_matrix_share_cut_1' => input_get('associate_matrix_share_cut_1'),
		'basic_matrix_share_cut_1'     => input_get('basic_matrix_share_cut_1'),

		'executive_matrix_share_cut_2' => input_get('executive_matrix_share_cut_2'),
		'regular_matrix_share_cut_2'   => input_get('regular_matrix_share_cut_2'),
		'associate_matrix_share_cut_2' => input_get('associate_matrix_share_cut_2'),
		'basic_matrix_share_cut_2'     => input_get('basic_matrix_share_cut_2'),

		'executive_matrix_share_cut_3' => input_get('executive_matrix_share_cut_3'),
		'regular_matrix_share_cut_3'   => input_get('regular_matrix_share_cut_3'),
		'associate_matrix_share_cut_3' => input_get('associate_matrix_share_cut_3'),
		'basic_matrix_share_cut_3'     => input_get('basic_matrix_share_cut_3'),

		'executive_matrix_share_cut_4' => input_get('executive_matrix_share_cut_4'),
		'regular_matrix_share_cut_4'   => input_get('regular_matrix_share_cut_4'),
		'associate_matrix_share_cut_4' => input_get('associate_matrix_share_cut_4'),
		'basic_matrix_share_cut_4'     => input_get('basic_matrix_share_cut_4'),

		'executive_matrix_share_cut_5' => input_get('executive_matrix_share_cut_5'),
		'regular_matrix_share_cut_5'   => input_get('regular_matrix_share_cut_5'),
		'associate_matrix_share_cut_5' => input_get('associate_matrix_share_cut_5'),
		'basic_matrix_share_cut_5'     => input_get('basic_matrix_share_cut_5'),

		'executive_matrix_share_cut_6' => input_get('executive_matrix_share_cut_6'),
		'regular_matrix_share_cut_6'   => input_get('regular_matrix_share_cut_6'),
		'associate_matrix_share_cut_6' => input_get('associate_matrix_share_cut_6'),
		'basic_matrix_share_cut_6'     => input_get('basic_matrix_share_cut_6'),

		'executive_matrix_share_cut_7' => input_get('executive_matrix_share_cut_7'),
		'regular_matrix_share_cut_7'   => input_get('regular_matrix_share_cut_7'),
		'associate_matrix_share_cut_7' => input_get('associate_matrix_share_cut_7'),
		'basic_matrix_share_cut_7'     => input_get('basic_matrix_share_cut_7'),

		'executive_matrix_share_cut_8' => input_get('executive_matrix_share_cut_8'),
		'regular_matrix_share_cut_8'   => input_get('regular_matrix_share_cut_8'),
		'associate_matrix_share_cut_8' => input_get('associate_matrix_share_cut_8'),
		'basic_matrix_share_cut_8'     => input_get('basic_matrix_share_cut_8'),

		'executive_matrix_share_cut_9' => input_get('executive_matrix_share_cut_9'),
		'regular_matrix_share_cut_9'   => input_get('regular_matrix_share_cut_9'),
		'associate_matrix_share_cut_9' => input_get('associate_matrix_share_cut_9'),
		'basic_matrix_share_cut_9'     => input_get('basic_matrix_share_cut_9'),

		'executive_matrix_share_cut_10' => input_get('executive_matrix_share_cut_10'),
		'regular_matrix_share_cut_10'   => input_get('regular_matrix_share_cut_10'),
		'associate_matrix_share_cut_10' => input_get('associate_matrix_share_cut_10'),
		'basic_matrix_share_cut_10'     => input_get('basic_matrix_share_cut_10'),

		'executive_matrix_level' => input_get('executive_matrix_level'),
		'regular_matrix_level'   => input_get('regular_matrix_level'),
		'associate_matrix_level' => input_get('associate_matrix_level'),
		'basic_matrix_level'     => input_get('basic_matrix_level'),

		'executive_matrix_width' => input_get('executive_matrix_width'),
		'regular_matrix_width'   => input_get('regular_matrix_width'),
		'associate_matrix_width' => input_get('associate_matrix_width'),
		'basic_matrix_width'     => input_get('basic_matrix_width'),

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
		'basic_sponsored'     => input_get('basic_sponsored'),

		'executive_status' => input_get('executive_status', 0),
		'regular_status'   => input_get('regular_status', 0),
		'associate_status' => input_get('associate_status', 0),
		'basic_status'     => input_get('basic_status', 0)
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

	$status = [
		$input['executive_status'],
		$input['regular_status'],
		$input['associate_status'],
		$input['basic_status']
	];

	$test = [
		$input['executive_matrix_level'],
		$input['regular_matrix_level'],
		$input['associate_matrix_level'],
		$input['basic_matrix_level'],

		$input['executive_matrix_width'],
		$input['regular_matrix_width'],
		$input['associate_matrix_width'],
		$input['basic_matrix_width'],

		$input['executive_reentry'],
		$input['regular_reentry'],
		$input['associate_reentry'],
		$input['basic_reentry'],

		$input['executive_upgrade'],
		$input['regular_upgrade'],
		$input['associate_upgrade'],
		$input['basic_upgrade']
	];

	if ($status && !in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_matrix',
				[
					'executive_matrix_share_1 = ' . $db->quote($input['executive_matrix_share_1']),
					'regular_matrix_share_1 = ' . $db->quote($input['regular_matrix_share_1']),
					'associate_matrix_share_1 = ' . $db->quote($input['associate_matrix_share_1']),
					'basic_matrix_share_1 = ' . $db->quote($input['basic_matrix_share_1']),

					'executive_matrix_share_2 = ' . $db->quote($input['executive_matrix_share_2']),
					'regular_matrix_share_2 = ' . $db->quote($input['regular_matrix_share_2']),
					'associate_matrix_share_2 = ' . $db->quote($input['associate_matrix_share_2']),
					'basic_matrix_share_2 = ' . $db->quote($input['basic_matrix_share_2']),

					'executive_matrix_share_3 = ' . $db->quote($input['executive_matrix_share_3']),
					'regular_matrix_share_3 = ' . $db->quote($input['regular_matrix_share_3']),
					'associate_matrix_share_3 = ' . $db->quote($input['associate_matrix_share_3']),
					'basic_matrix_share_3 = ' . $db->quote($input['basic_matrix_share_3']),

					'executive_matrix_share_4 = ' . $db->quote($input['executive_matrix_share_4']),
					'regular_matrix_share_4 = ' . $db->quote($input['regular_matrix_share_4']),
					'associate_matrix_share_4 = ' . $db->quote($input['associate_matrix_share_4']),
					'basic_matrix_share_4 = ' . $db->quote($input['basic_matrix_share_4']),

					'executive_matrix_share_5 = ' . $db->quote($input['executive_matrix_share_5']),
					'regular_matrix_share_5 = ' . $db->quote($input['regular_matrix_share_5']),
					'associate_matrix_share_5 = ' . $db->quote($input['associate_matrix_share_5']),
					'basic_matrix_share_5 = ' . $db->quote($input['basic_matrix_share_5']),

					'executive_matrix_share_6 = ' . $db->quote($input['executive_matrix_share_6']),
					'regular_matrix_share_6 = ' . $db->quote($input['regular_matrix_share_6']),
					'associate_matrix_share_6 = ' . $db->quote($input['associate_matrix_share_6']),
					'basic_matrix_share_6 = ' . $db->quote($input['basic_matrix_share_6']),

					'executive_matrix_share_7 = ' . $db->quote($input['executive_matrix_share_7']),
					'regular_matrix_share_7 = ' . $db->quote($input['regular_matrix_share_7']),
					'associate_matrix_share_7 = ' . $db->quote($input['associate_matrix_share_7']),
					'basic_matrix_share_7 = ' . $db->quote($input['basic_matrix_share_7']),

					'executive_matrix_share_8 = ' . $db->quote($input['executive_matrix_share_8']),
					'regular_matrix_share_8 = ' . $db->quote($input['regular_matrix_share_8']),
					'associate_matrix_share_8 = ' . $db->quote($input['associate_matrix_share_8']),
					'basic_matrix_share_8 = ' . $db->quote($input['basic_matrix_share_8']),

					'executive_matrix_share_9 = ' . $db->quote($input['executive_matrix_share_9']),
					'regular_matrix_share_9 = ' . $db->quote($input['regular_matrix_share_9']),
					'associate_matrix_share_9 = ' . $db->quote($input['associate_matrix_share_9']),
					'basic_matrix_share_9 = ' . $db->quote($input['basic_matrix_share_9']),

					'executive_matrix_share_10 = ' . $db->quote($input['executive_matrix_share_10']),
					'regular_matrix_share_10 = ' . $db->quote($input['regular_matrix_share_10']),
					'associate_matrix_share_10 = ' . $db->quote($input['associate_matrix_share_10']),
					'basic_matrix_share_10 = ' . $db->quote($input['basic_matrix_share_10']),

					'executive_matrix_share_cut_1 = ' . $db->quote($input['executive_matrix_share_cut_1']),
					'regular_matrix_share_cut_1 = ' . $db->quote($input['regular_matrix_share_cut_1']),
					'associate_matrix_share_cut_1 = ' . $db->quote($input['associate_matrix_share_cut_1']),
					'basic_matrix_share_cut_1 = ' . $db->quote($input['basic_matrix_share_cut_1']),

					'executive_matrix_share_cut_2 = ' . $db->quote($input['executive_matrix_share_cut_2']),
					'regular_matrix_share_cut_2 = ' . $db->quote($input['regular_matrix_share_cut_2']),
					'associate_matrix_share_cut_2 = ' . $db->quote($input['associate_matrix_share_cut_2']),
					'basic_matrix_share_cut_2 = ' . $db->quote($input['basic_matrix_share_cut_2']),

					'executive_matrix_share_cut_3 = ' . $db->quote($input['executive_matrix_share_cut_3']),
					'regular_matrix_share_cut_3 = ' . $db->quote($input['regular_matrix_share_cut_3']),
					'associate_matrix_share_cut_3 = ' . $db->quote($input['associate_matrix_share_cut_3']),
					'basic_matrix_share_cut_3 = ' . $db->quote($input['basic_matrix_share_cut_3']),

					'executive_matrix_share_cut_4 = ' . $db->quote($input['executive_matrix_share_cut_4']),
					'regular_matrix_share_cut_4 = ' . $db->quote($input['regular_matrix_share_cut_4']),
					'associate_matrix_share_cut_4 = ' . $db->quote($input['associate_matrix_share_cut_4']),
					'basic_matrix_share_cut_4 = ' . $db->quote($input['basic_matrix_share_cut_4']),

					'executive_matrix_share_cut_5 = ' . $db->quote($input['executive_matrix_share_cut_5']),
					'regular_matrix_share_cut_5 = ' . $db->quote($input['regular_matrix_share_cut_5']),
					'associate_matrix_share_cut_5 = ' . $db->quote($input['associate_matrix_share_cut_5']),
					'basic_matrix_share_cut_5 = ' . $db->quote($input['basic_matrix_share_cut_5']),

					'executive_matrix_share_cut_6 = ' . $db->quote($input['executive_matrix_share_cut_6']),
					'regular_matrix_share_cut_6 = ' . $db->quote($input['regular_matrix_share_cut_6']),
					'associate_matrix_share_cut_6 = ' . $db->quote($input['associate_matrix_share_cut_6']),
					'basic_matrix_share_cut_6 = ' . $db->quote($input['basic_matrix_share_cut_6']),

					'executive_matrix_share_cut_7 = ' . $db->quote($input['executive_matrix_share_cut_7']),
					'regular_matrix_share_cut_7 = ' . $db->quote($input['regular_matrix_share_cut_7']),
					'associate_matrix_share_cut_7 = ' . $db->quote($input['associate_matrix_share_cut_7']),
					'basic_matrix_share_cut_7 = ' . $db->quote($input['basic_matrix_share_cut_7']),

					'executive_matrix_share_cut_8 = ' . $db->quote($input['executive_matrix_share_cut_8']),
					'regular_matrix_share_cut_8 = ' . $db->quote($input['regular_matrix_share_cut_8']),
					'associate_matrix_share_cut_8 = ' . $db->quote($input['associate_matrix_share_cut_8']),
					'basic_matrix_share_cut_8 = ' . $db->quote($input['basic_matrix_share_cut_8']),

					'executive_matrix_share_cut_9 = ' . $db->quote($input['executive_matrix_share_cut_9']),
					'regular_matrix_share_cut_9 = ' . $db->quote($input['regular_matrix_share_cut_9']),
					'associate_matrix_share_cut_9 = ' . $db->quote($input['associate_matrix_share_cut_9']),
					'basic_matrix_share_cut_9 = ' . $db->quote($input['basic_matrix_share_cut_9']),

					'executive_matrix_share_cut_10 = ' . $db->quote($input['executive_matrix_share_cut_10']),
					'regular_matrix_share_cut_10 = ' . $db->quote($input['regular_matrix_share_cut_10']),
					'associate_matrix_share_cut_10 = ' . $db->quote($input['associate_matrix_share_cut_10']),
					'basic_matrix_share_cut_10 = ' . $db->quote($input['basic_matrix_share_cut_10']),

					'executive_matrix_level = ' . $db->quote($input['executive_matrix_level']),
					'regular_matrix_level = ' . $db->quote($input['regular_matrix_level']),
					'associate_matrix_level = ' . $db->quote($input['associate_matrix_level']),
					'basic_matrix_level = ' . $db->quote($input['basic_matrix_level']),

					'executive_matrix_width = ' . $db->quote($input['executive_matrix_width']),
					'regular_matrix_width = ' . $db->quote($input['regular_matrix_width']),
					'associate_matrix_width = ' . $db->quote($input['associate_matrix_width']),
					'basic_matrix_width = ' . $db->quote($input['basic_matrix_width']),

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
					'basic_sponsored = ' . $db->quote($input['basic_sponsored']),

					'executive_status = ' . $db->quote($input['executive_status']),
					'regular_status = ' . $db->quote($input['regular_status']),
					'associate_status = ' . $db->quote($input['associate_status']),
					'basic_status = ' . $db->quote($input['basic_status'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(86),
			settings('plans')->matrix_name . ' Settings Updated Successfully!', 'success');
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
	$settings_entry  = settings('entry');

	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
			<form method="post">
				<table class="category table table-striped table-bordered table-hover">
					<tr>
						<td colspan="5"><h3 class="center_align">' .
		settings('plans')->matrix_name . ' (' . settings('ancillaries')->currency . ')' . '</h3></td>
					</tr>
					<tr>
						<td></td>
						<td><h4 style="margin:0" class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
						<td><h4 style="margin:0" class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
						<td><h4 style="margin:0" class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
						<td><h4 style="margin:0" class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
					</tr>';

	$str .= view_row_status();
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
function view_row_status(): string
{
	$settings_matrix = settings('matrix');

	return '<tr>
                <td>
                    <div class="center_align"><strong>Status</strong></div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input type="checkbox" name="executive_status"
                                      id="executive_status" class="net_align"
                                      value="1" ' . ($settings_matrix->executive_status ? 'checked' : '') . '></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input type="checkbox" name="regular_status"
                                      id="regular_status" class="net_align"
                                      value="1" ' . ($settings_matrix->regular_status ? 'checked' : '') . '></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input type="checkbox" name="associate_status"
                                      id="associate_status" class="net_align"
                                      value="1" ' . ($settings_matrix->associate_status ? 'checked' : '') . '></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input type="checkbox" name="basic_status"
                                      id="basic_status" class="net_align"
                                      value="1" ' . ($settings_matrix->basic_status ? 'checked' : '') . '></label>
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
function view_row_share(): string
{
	$settings_matrix = settings('matrix');

	return '<tr>
					<td>
	                    <div class="center_align"><strong>Share (%)</strong></div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share('executive', $settings_matrix->executive_matrix_level, 5) .
		'</ul>
						</div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share('regular', $settings_matrix->regular_matrix_level, 5) .
		'</ul>
						</div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share('associate', $settings_matrix->associate_matrix_level, 5) .
		'</ul>
						</div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share('basic', $settings_matrix->basic_matrix_level, 5) .
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
	$settings_matrix = settings('matrix');

	return '<tr>
					<td>
	                    <div class="center_align"><strong>Share Cut (%)</strong></div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share_cut('executive', $settings_matrix->executive_matrix_level, 5) .
		'</ul>
						</div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share_cut('regular', $settings_matrix->regular_matrix_level, 5) .
		'</ul>
						</div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share_cut('associate', $settings_matrix->associate_matrix_level, 5) .
		'</ul>
						</div>
					</td>
					<td>
						<div class="center_align">
							<ul class="uk-nav">' .
		view_share_cut('basic', $settings_matrix->basic_matrix_level, 5) .
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
						<div class="center_align"><strong>Level</strong></div>
					</td>
					<td>
						<div class="center_align"><label><select name="executive_matrix_level" style="width:150px">' .
		view_level('executive') .
		'</select></label></div>
					</td>
					<td>
						<div class="center_align"><label><select name="regular_matrix_level" style="width:150px">' .
		view_level('regular') .
		'</select></label></div>
					</td>
					<td>
						<div class="center_align"><label><select name="associate_matrix_level" style="width:150px">' .
		view_level('associate') .
		'</select></label></div>
					</td>
					<td>
						<div class="center_align"><label><select name="basic_matrix_level" style="width:150px">' .
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
	$settings_matrix = settings('matrix');

	return '<tr>
				<td>
					<div class="center_align"><strong>Width</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_matrix_width" class="net_align"
						              value="' . number_format($settings_matrix->executive_matrix_width) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_matrix_width" class="net_align"
						              value="' . number_format($settings_matrix->regular_matrix_width) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_matrix_width" class="net_align"
						              value="' . number_format($settings_matrix->associate_matrix_width) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_matrix_width" class="net_align"
						              value="' . number_format($settings_matrix->basic_matrix_width) . '" required>
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
	$settings_matrix = settings('matrix');

	return '<tr>
				<td>
                    <div class="center_align"><strong>Sponsored Members</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_sponsored" class="net_align"
						              value="' . number_format($settings_matrix->executive_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_sponsored" class="net_align"
						              value="' . number_format($settings_matrix->regular_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_sponsored" class="net_align"
						              value="' . number_format($settings_matrix->associate_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_sponsored" class="net_align"
						              value="' . number_format($settings_matrix->basic_sponsored) . '" required>
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
function view_row_entry_cost(): string
{
	$settings_matrix = settings('matrix');

	return '<tr>
				<td>
                    <div class="center_align"><strong>Entry Cost (' .
		settings('ancillaries')->currency . ')</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_entry" class="net_align"
						              value="' . number_format($settings_matrix->executive_entry) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_entry" class="net_align"
						              value="' . number_format($settings_matrix->regular_entry) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_entry" class="net_align"
						              value="' . number_format($settings_matrix->associate_entry) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_entry" class="net_align"
						              value="' . number_format($settings_matrix->basic_entry) . '" required>
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
	$settings_matrix = settings('matrix');

	return '<tr>
				<td>
                    <div class="center_align"><strong>Re-entry Cost (' .
		settings('ancillaries')->currency . ')</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_reentry" class="net_align"
						              value="' . number_format($settings_matrix->executive_reentry) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_reentry" class="net_align"
						              value="' . number_format($settings_matrix->regular_reentry) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_reentry" class="net_align"
						              value="' . number_format($settings_matrix->associate_reentry) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_reentry" class="net_align"
						              value="' . number_format($settings_matrix->basic_reentry) . '" required>
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
	$settings_matrix = settings('matrix');

	return '<tr>
				<td>
	                <div class="center_align"><strong>Upgrade Cost (' .
		settings('ancillaries')->currency . ')</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_upgrade" class="net_align"
						              value="' . number_format($settings_matrix->executive_upgrade) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_upgrade" class="net_align"
						              value="' . number_format($settings_matrix->regular_upgrade) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_upgrade" class="net_align"
						              value="' . number_format($settings_matrix->associate_upgrade) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_upgrade" class="net_align"
						              value="' . number_format($settings_matrix->basic_upgrade) . '" required>
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
				<input name="' . $account . '_matrix_share_' . $i_i . '" style="width:150px"
				       class="net_align" value="' . number_format(settings('matrix')->{$account .
			'_matrix_share_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
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
                <input name="' . $account . '_matrix_share_cut_' . $i_i . '" style="width:150px"
                       class="net_align" value="' . number_format(settings('matrix')->{$account .
			'_matrix_share_cut_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
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
	return settings('matrix')->{$account_type . '_matrix_level'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function level_matrix($account_type, $value): string
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
		$str .= '<option value="' . $i_i . '" ' . level_matrix($account_type, $i_i) . '> ' . $i_i . '</option>';
	}

	return $str;
}