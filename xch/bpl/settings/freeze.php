<?php

namespace BPL\Settings\Freeze;

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
		'executive_reactivation' => input_get('executive_reactivation'),
		'regular_reactivation'   => input_get('regular_reactivation'),
		'associate_reactivation' => input_get('associate_reactivation'),
		'basic_reactivation'     => input_get('basic_reactivation'),

		'executive_percentage' => input_get('executive_percentage'),
		'regular_percentage'   => input_get('regular_percentage'),
		'associate_percentage' => input_get('associate_percentage'),
		'basic_percentage'     => input_get('basic_percentage')
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
		$input['executive_reactivation'],
		$input['regular_reactivation'],
		$input['associate_reactivation'],
		$input['basic_reactivation'],

		$input['executive_percentage'],
		$input['regular_percentage'],
		$input['associate_percentage'],
		$input['basic_percentage']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_freeze',
				[
					'executive_reactivation = ' . $db->quote($input['executive_reactivation']),
					'regular_reactivation = ' . $db->quote($input['regular_reactivation']),
					'associate_reactivation = ' . $db->quote($input['associate_reactivation']),
					'basic_reactivation = ' . $db->quote($input['basic_reactivation']),

					'executive_percentage = ' . $db->quote($input['executive_percentage']),
					'regular_percentage = ' . $db->quote($input['regular_percentage']),
					'associate_percentage = ' . $db->quote($input['associate_percentage']),
					'basic_percentage = ' . $db->quote($input['basic_percentage'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(129),
			settings('plans')->account_freeze_name . ' Settings Updated Successfully!', 'success');
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
                <td colspan="5">
                	<h3 class="center_align">' . settings('plans')->account_freeze_name . '</h3></td>
            </tr>
            <tr>
            	<td></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>';

	$str .= view_row_reactivation();
	$str .= view_row_percentage();

	$str .= '</table>
		<div class="center_align">
			<input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
		</div>
	</form>
    </div></div></section>';

	return $str;
}

function view_row_reactivation(): string
{
	$sf = settings('freeze');

	return '<tr>
				<td>
					<div class="center_align">Reactivation (' . settings('ancillaries')->currency . '):</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_reactivation" class="net_align"
						              value="' .
		number_format($sf->executive_reactivation, 8) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_reactivation" class="net_align"
						              value="' .
		number_format($sf->regular_reactivation, 8) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_reactivation" class="net_align"
						              value="' .
		number_format($sf->associate_reactivation, 8) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_reactivation" class="net_align"
						              value="' .
		number_format($sf->basic_reactivation, 8) . '" required>
						</label>
					</div>
				</td>				
			</tr>';
}

function view_row_percentage(): string
{
	$settings_entry = settings('freeze');

	return '<tr>
				<td>
					<div class="center_align">Percentage (%):</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_percentage" class="net_align"
						              value="' .
		number_format($settings_entry->executive_percentage, 8) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_percentage" class="net_align"
						              value="' .
		number_format($settings_entry->regular_percentage, 8) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_percentage" class="net_align"
						              value="' .
		number_format($settings_entry->associate_percentage, 8) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_percentage" class="net_align"
						              value="' .
		number_format($settings_entry->basic_percentage, 8) . '" required>
						</label>
					</div>
				</td>				
			</tr>';
}