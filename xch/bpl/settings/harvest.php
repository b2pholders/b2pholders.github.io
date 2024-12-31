<?php

namespace BPL\Settings\Harvest;

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
 * @throws Exception
 * @since 2021
 */
function get_input(): array
{
	$inputs = [];

	for ($i_i = 1; $i_i <= 10; $i_i++)
	{
		$inputs['basic_harvest_' . $i_i]['bonus']     = input_get('basic_harvest_' . $i_i . '_bonus');
		$inputs['associate_harvest_' . $i_i]['bonus'] = input_get('associate_harvest_' . $i_i . '_bonus');
		$inputs['regular_harvest_' . $i_i]['bonus']   = input_get('regular_harvest_' . $i_i . '_bonus');
		$inputs['executive_harvest_' . $i_i]['bonus'] = input_get('executive_harvest_' . $i_i . '_bonus');
	}

	$inputs['basic_harvest']['level']     = input_get('basic_harvest_level');
	$inputs['associate_harvest']['level'] = input_get('associate_harvest_level');
	$inputs['regular_harvest']['level']   = input_get('regular_harvest_level');
	$inputs['executive_harvest']['level'] = input_get('executive_harvest_level');

	$inputs['basic_harvest']['width']     = input_get('basic_harvest_width');
	$inputs['associate_harvest']['width'] = input_get('associate_harvest_width');
	$inputs['regular_harvest']['width']   = input_get('regular_harvest_width');
	$inputs['executive_harvest']['width'] = input_get('executive_harvest_width');

	$inputs['basic_harvest']['sponsored']     = input_get('basic_harvest_sponsored');
	$inputs['associate_harvest']['sponsored'] = input_get('associate_harvest_sponsored');
	$inputs['regular_harvest']['sponsored']   = input_get('regular_harvest_sponsored');
	$inputs['executive_harvest']['sponsored'] = input_get('executive_harvest_sponsored');

	return $inputs;
}

/**
 *
 *
 * @throws Exception
 * @since version
 */
function update()
{
	$db = db();

	$inputs = get_input();

	$test = [
		$inputs['executive_harvest']['level'],
		$inputs['regular_harvest']['level'],
		$inputs['associate_harvest']['level'],
		$inputs['basic_harvest']['level'],

		$inputs['executive_harvest']['width'],
		$inputs['regular_harvest']['width'],
		$inputs['associate_harvest']['width'],
		$inputs['basic_harvest']['width']
	];

	if (!in_array('', $test, true))
	{
		$fields = [];

		foreach ($inputs as $k => $v)
		{
			foreach ($v as $u => $y)
			{
				$fields[] = $k . '_' . $u . ' = ' . $db->quote($y);
			}
		}

		try
		{
			$db->transactionStart();

			query_update('network_settings_harvest', $fields);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(121),
			settings('plans')->harvest_name . ' Settings Updated Successfully!', 'success');
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
		<table class="category table table-striped table-bordered table-hover">';
	$str .= '<tr>
				<td colspan="5"><h3 class="center_align">' .
		settings('plans')->harvest_name . ' (' . settings('ancillaries')->currency . ')' . '</h3></td>
			</tr>
			<tr>
				<td></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
			</tr>';

	$str .= view_row_bonus();
	$str .= view_row_level();
	$str .= view_row_width();
	$str .= view_row_required_directs();

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
function view_row_bonus(): string
{
	$settings_harvest = settings('harvest');

	return '<tr>
				<td>
                    <div class="center_align"><strong>Bonus (' .
		settings('ancillaries')->currency . ')</strong></div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_bonus('executive', $settings_harvest->executive_harvest_level) . '</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_bonus('regular', $settings_harvest->regular_harvest_level) . '</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_bonus('associate', $settings_harvest->associate_harvest_level) . '</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_bonus('basic', $settings_harvest->basic_harvest_level) . '</ul>
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
					<div class="center_align"><label><select name="executive_harvest_level" style="width:150px">' .
		view_level('executive') . '</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="regular_harvest_level" style="width:150px">' .
		view_level('regular') . '</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="associate_harvest_level" style="width:150px">' .
		view_level('associate') . '</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="basic_harvest_level" style="width:150px">' .
		view_level('basic') . '</select></label></div>
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
	$settings_harvest = settings('harvest');

	return '<tr>
				<td>
					<div class="center_align"><strong>Width</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_harvest_width" class="net_align" value="' .
		number_format($settings_harvest->executive_harvest_width) . '" required></label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_harvest_width" class="net_align" value="' .
		number_format($settings_harvest->regular_harvest_width) . '" required></label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_harvest_width" class="net_align" value="' .
		number_format($settings_harvest->associate_harvest_width) . '" required></label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_harvest_width" class="net_align" value="' .
		number_format($settings_harvest->basic_harvest_width) . '" required></label>
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
function view_row_required_directs(): string
{
	$settings_harvest = settings('harvest');

	return '<tr>
				<td>
                    <div class="center_align"><strong>Required Directs</strong></div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_harvest_sponsored" class="net_align" value="' .
		number_format($settings_harvest->executive_harvest_sponsored) . '" required></label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_harvest_sponsored" class="net_align" value="' .
		number_format($settings_harvest->regular_harvest_sponsored) . '" required></label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_harvest_sponsored" class="net_align" value="' .
		number_format($settings_harvest->associate_harvest_sponsored) . '" required></label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_harvest_sponsored" class="net_align" value="' .
		number_format($settings_harvest->basic_harvest_sponsored) . '" required></label>
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
function view_bonus($account, int $level = 10, int $decimal = 2): string
{
	$str = '';

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$str .= '<li><label><input name="' . $account . '_harvest_' . $i_i . '_bonus" style="width:150px"
				       class="net_align" value="' . number_format(settings('harvest')->{$account .
			'_harvest_' . $i_i . '_bonus'}, $decimal) . '"> ' . $i_i . '</label></li>';
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
	return settings('harvest')->{$account_type . '_harvest_level'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function level_harvest($account_type, $value): string
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
		$str .= '<option value="' . $i_i . '" ' . level_harvest($account_type, $i_i) . '> ' . $i_i . '</option>';
	}

	return $str;
}