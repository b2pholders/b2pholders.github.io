<?php

namespace BPL\Settings\Binary;

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
		'hedge' => input_get('hedge'),

		'chairman_pairs'  => input_get('chairman_pairs'),
		'executive_pairs' => input_get('executive_pairs'),
		'regular_pairs'   => input_get('regular_pairs'),
		'associate_pairs' => input_get('associate_pairs'),
		'basic_pairs'     => input_get('basic_pairs'),

		'chairman_max_cycle'  => input_get('chairman_max_cycle'),
		'executive_max_cycle' => input_get('executive_max_cycle'),
		'regular_max_cycle'   => input_get('regular_max_cycle'),
		'associate_max_cycle' => input_get('associate_max_cycle'),
		'basic_max_cycle'     => input_get('basic_max_cycle'),

		'chairman_max_daily'  => input_get('chairman_max_cycle'),
		'executive_max_daily' => input_get('executive_max_cycle'),
		'regular_max_daily'   => input_get('regular_max_cycle'),
		'associate_max_daily' => input_get('associate_max_cycle'),
		'basic_max_daily'     => input_get('basic_max_cycle'),

		'chairman_leg_retention'  => input_get('chairman_leg_retention'),
		'executive_leg_retention' => input_get('executive_leg_retention'),
		'regular_leg_retention'   => input_get('regular_leg_retention'),
		'associate_leg_retention' => input_get('associate_leg_retention'),
		'basic_leg_retention'     => input_get('basic_leg_retention'),

		'chairman_pairs_safety'  => input_get('chairman_pairs_safety'),
		'executive_pairs_safety' => input_get('executive_pairs_safety'),
		'regular_pairs_safety'   => input_get('regular_pairs_safety'),
		'associate_pairs_safety' => input_get('associate_pairs_safety'),
		'basic_pairs_safety'     => input_get('basic_pairs_safety'),

		'chairman_max_pairs'  => input_get('chairman_max_pairs'),
		'executive_max_pairs' => input_get('executive_max_pairs'),
		'regular_max_pairs'   => input_get('regular_max_pairs'),
		'associate_max_pairs' => input_get('associate_max_pairs'),
		'basic_max_pairs'     => input_get('basic_max_pairs'),

		'chairman_binary_sponsored'  => input_get('chairman_binary_sponsored'),
		'executive_binary_sponsored' => input_get('executive_binary_sponsored'),
		'regular_binary_sponsored'   => input_get('regular_binary_sponsored'),
		'associate_binary_sponsored' => input_get('associate_binary_sponsored'),
		'basic_binary_sponsored'     => input_get('basic_binary_sponsored'),

		'chairman_required_pairs'  => input_get('chairman_required_pairs'),
		'executive_required_pairs' => input_get('executive_required_pairs'),
		'regular_required_pairs'   => input_get('regular_required_pairs'),
		'associate_required_pairs' => input_get('associate_required_pairs'),
		'basic_required_pairs'     => input_get('basic_required_pairs'),

		'chairman_pairs_proper'  => input_get('chairman_pairs_proper'),
		'executive_pairs_proper' => input_get('executive_pairs_proper'),
		'regular_pairs_proper'   => input_get('regular_pairs_proper'),
		'associate_pairs_proper' => input_get('associate_pairs_proper'),
		'basic_pairs_proper'     => input_get('basic_pairs_proper'),

		'chairman_pairs_capped'  => input_get('chairman_pairs_capped'),
		'executive_pairs_capped' => input_get('executive_pairs_capped'),
		'regular_pairs_capped'   => input_get('regular_pairs_capped'),
		'associate_pairs_capped' => input_get('associate_pairs_capped'),
		'basic_pairs_capped'     => input_get('basic_pairs_capped'),

		'chairman_pairs_reactivate'  => input_get('chairman_pairs_reactivate'),
		'executive_pairs_reactivate' => input_get('executive_pairs_reactivate'),
		'regular_pairs_reactivate'   => input_get('regular_pairs_reactivate'),
		'associate_pairs_reactivate' => input_get('associate_pairs_reactivate'),
		'basic_pairs_reactivate'     => input_get('basic_pairs_reactivate'),

		'chairman_capping_cycle_max'  => input_get('chairman_capping_cycle_max'),
		'executive_capping_cycle_max' => input_get('executive_capping_cycle_max'),
		'regular_capping_cycle_max'   => input_get('regular_capping_cycle_max'),
		'associate_capping_cycle_max' => input_get('associate_capping_cycle_max'),
		'basic_capping_cycle_max'     => input_get('basic_capping_cycle_max'),

		'chairman_maximum_income'  => input_get('chairman_maximum_income'),
		'executive_maximum_income' => input_get('executive_maximum_income'),
		'regular_maximum_income'   => input_get('regular_maximum_income'),
		'associate_maximum_income' => input_get('associate_maximum_income'),
		'basic_maximum_income'     => input_get('basic_maximum_income')
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

	$settings_plans = settings('plans');

	$input = get_input();

	$test = [
		$input['chairman_pairs'],
		$input['executive_pairs'],
		$input['regular_pairs'],
		$input['associate_pairs'],
		$input['basic_pairs'],

		$input['chairman_max_cycle'],
		$input['executive_max_cycle'],
		$input['regular_max_cycle'],
		$input['associate_max_cycle'],
		$input['basic_max_cycle'],

		$input['chairman_max_pairs'],
		$input['executive_max_pairs'],
		$input['regular_max_pairs'],
		$input['associate_max_pairs'],
		$input['basic_max_pairs']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_binary',
				[
					'hedge = ' . $db->quote($input['hedge']),

					'chairman_pairs = ' . $db->quote($input['chairman_pairs']),
					'executive_pairs = ' . $db->quote($input['executive_pairs']),
					'regular_pairs = ' . $db->quote($input['regular_pairs']),
					'associate_pairs = ' . $db->quote($input['associate_pairs']),
					'basic_pairs = ' . $db->quote($input['basic_pairs']),

					'chairman_max_cycle = ' . $db->quote($input['chairman_max_cycle']),
					'executive_max_cycle = ' . $db->quote($input['executive_max_cycle']),
					'regular_max_cycle = ' . $db->quote($input['regular_max_cycle']),
					'associate_max_cycle = ' . $db->quote($input['associate_max_cycle']),
					'basic_max_cycle = ' . $db->quote($input['basic_max_cycle']),

					'chairman_max_daily = ' . $db->quote($input['chairman_max_daily']),
					'executive_max_daily = ' . $db->quote($input['executive_max_daily']),
					'regular_max_daily = ' . $db->quote($input['regular_max_daily']),
					'associate_max_daily = ' . $db->quote($input['associate_max_daily']),
					'basic_max_daily = ' . $db->quote($input['basic_max_daily']),

					'chairman_leg_retention = ' . $db->quote($input['chairman_leg_retention']),
					'executive_leg_retention = ' . $db->quote($input['executive_leg_retention']),
					'regular_leg_retention = ' . $db->quote($input['regular_leg_retention']),
					'associate_leg_retention = ' . $db->quote($input['associate_leg_retention']),
					'basic_leg_retention = ' . $db->quote($input['basic_leg_retention']),

					'chairman_pairs_safety = ' . $db->quote($input['chairman_pairs_safety']),
					'executive_pairs_safety = ' . $db->quote($input['executive_pairs_safety']),
					'regular_pairs_safety = ' . $db->quote($input['regular_pairs_safety']),
					'associate_pairs_safety = ' . $db->quote($input['associate_pairs_safety']),
					'basic_pairs_safety = ' . $db->quote($input['basic_pairs_safety']),

					'chairman_max_pairs = ' . $db->quote($input['chairman_max_pairs']),
					'executive_max_pairs = ' . $db->quote($input['executive_max_pairs']),
					'regular_max_pairs = ' . $db->quote($input['regular_max_pairs']),
					'associate_max_pairs = ' . $db->quote($input['associate_max_pairs']),
					'basic_max_pairs = ' . $db->quote($input['basic_max_pairs']),

					'chairman_binary_sponsored = ' . $db->quote($input['chairman_binary_sponsored']),
					'executive_binary_sponsored = ' . $db->quote($input['executive_binary_sponsored']),
					'regular_binary_sponsored = ' . $db->quote($input['regular_binary_sponsored']),
					'associate_binary_sponsored = ' . $db->quote($input['associate_binary_sponsored']),
					'basic_binary_sponsored = ' . $db->quote($input['basic_binary_sponsored']),

					'chairman_required_pairs = ' . $db->quote($input['chairman_required_pairs']),
					'executive_required_pairs = ' . $db->quote($input['executive_required_pairs']),
					'regular_required_pairs = ' . $db->quote($input['regular_required_pairs']),
					'associate_required_pairs = ' . $db->quote($input['associate_required_pairs']),
					'basic_required_pairs = ' . $db->quote($input['basic_required_pairs']),

					'chairman_pairs_proper = ' . $db->quote($input['chairman_pairs_proper']),
					'executive_pairs_proper = ' . $db->quote($input['executive_pairs_proper']),
					'regular_pairs_proper = ' . $db->quote($input['regular_pairs_proper']),
					'associate_pairs_proper = ' . $db->quote($input['associate_pairs_proper']),
					'basic_pairs_proper = ' . $db->quote($input['basic_pairs_proper']),

					'chairman_pairs_capped = ' . $db->quote($input['chairman_pairs_capped']),
					'executive_pairs_capped = ' . $db->quote($input['executive_pairs_capped']),
					'regular_pairs_capped = ' . $db->quote($input['regular_pairs_capped']),
					'associate_pairs_capped = ' . $db->quote($input['associate_pairs_capped']),
					'basic_pairs_capped = ' . $db->quote($input['basic_pairs_capped']),

					'chairman_pairs_reactivate = ' . $db->quote($input['chairman_pairs_reactivate']),
					'executive_pairs_reactivate = ' . $db->quote($input['executive_pairs_reactivate']),
					'regular_pairs_reactivate = ' . $db->quote($input['regular_pairs_reactivate']),
					'associate_pairs_reactivate = ' . $db->quote($input['associate_pairs_reactivate']),
					'basic_pairs_reactivate = ' . $db->quote($input['basic_pairs_reactivate']),

					'chairman_capping_cycle_max = ' . $db->quote($input['chairman_capping_cycle_max']),
					'executive_capping_cycle_max = ' . $db->quote($input['executive_capping_cycle_max']),
					'regular_capping_cycle_max = ' . $db->quote($input['regular_capping_cycle_max']),
					'associate_capping_cycle_max = ' . $db->quote($input['associate_capping_cycle_max']),
					'basic_capping_cycle_max = ' . $db->quote($input['basic_capping_cycle_max']),

					'chairman_maximum_income = ' . $db->quote($input['chairman_maximum_income']),
					'executive_maximum_income = ' . $db->quote($input['executive_maximum_income']),
					'regular_maximum_income = ' . $db->quote($input['regular_maximum_income']),
					'associate_maximum_income = ' . $db->quote($input['associate_maximum_income']),
					'basic_maximum_income = ' . $db->quote($input['basic_maximum_income'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(80),
			$settings_plans->binary_pair_name . ' Settings Updated Successfully!', 'success');
	}
}

/**
 * @param $account_type
 *
 * @return mixed
 *
 * @since version
 */
function get_pairs_safety($account_type)
{
	return settings('binary')->{$account_type . '_pairs_safety'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function pairs_safety($account_type, $value): string
{
	return (int) get_pairs_safety($account_type) === (int) $value ? 'selected' : '';
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function hedge($value): string
{
	return settings('binary')->hedge === $value ? 'selected' : '';
}

/**
 * @param   string  $account_type
 * @param   int     $limit
 *
 * @return string
 *
 * @since version
 */
function display_pairs_safety(string $account_type = 'basic', int $limit = 10): string
{
	$str = '';

	for ($i_i = 0; $i_i <= $limit; $i_i++)
	{
		$str .= '<option value="' . $i_i . '" ' . pairs_safety($account_type, $i_i) . '>' . $i_i . '</option>';
	}

	return $str;
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
                <td colspan="6"><h3 class="center_align">' .
		settings('plans')->binary_pair_name . ' (' . settings('ancillaries')->currency . ')' . '</h3></td>
            </tr>
            <tr>
                <td><div class="center_align"><label><select name="hedge" style="width:150px">
                    <option value="flushout" ' . hedge('flushout') . '>Flushout</option>
                    <option value="capping"  ' . hedge('capping') . '>Capping</option>
                </select></label></div></td>
                <td><h4 class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>';

	$str .= view_row_pairing_bonus();
	$str .= view_row_max_cycle();
	$str .= view_row_leg_retention();
	$str .= view_row_nth_pair();
	$str .= view_row_capping_pairs();
	$str .= view_row_required_directs();
	$str .= view_row_required_pairs();
	$str .= view_row_pairing_bonus_proper();
	$str .= view_row_pairing_bonus_capped();
	$str .= view_row_reactivate_cost();
	$str .= view_row_capping_cycle_max();
	$str .= view_row_maximum_income();

	$str .= '</table>
        <input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
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
function view_row_pairing_bonus(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Pairing Bonus (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_pairs" class="net_align"
                                      value="' . number_format($settings_binary->chairman_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_pairs" class="net_align"
                                      value="' . number_format($settings_binary->executive_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_pairs" class="net_align"
                                      value="' . number_format($settings_binary->regular_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_pairs" class="net_align"
                                      value="' . number_format($settings_binary->associate_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_pairs" class="net_align"
                                      value="' . number_format($settings_binary->basic_pairs, 8) . '" 
                                      required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_max_cycle(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Max. Pairs / Cycle (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_max_cycle" class="net_align"
                                      value="' . number_format($settings_binary->chairman_max_cycle, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_max_cycle" class="net_align"
                                      value="' . number_format($settings_binary->executive_max_cycle, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_max_cycle" class="net_align"
                                      value="' . number_format($settings_binary->regular_max_cycle, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_max_cycle" class="net_align"
                                      value="' . number_format($settings_binary->associate_max_cycle, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_max_cycle" class="net_align"
                                      value="' . number_format($settings_binary->basic_max_cycle, 8) . '" 
                                      required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_leg_retention(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Leg Retention (%):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_leg_retention" class="net_align"
                                      value="' . number_format($settings_binary
											->chairman_leg_retention, 2) . '" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_leg_retention" class="net_align"
                                      value="' . number_format($settings_binary
											->executive_leg_retention, 2) . '" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_leg_retention" class="net_align"
                                      value="' . number_format($settings_binary
											->regular_leg_retention, 2) . '" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_leg_retention" class="net_align"
                                      value="' . number_format($settings_binary
											->associate_leg_retention, 2) . '" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_leg_retention" class="net_align"
                                      value="' . number_format($settings_binary
											->basic_leg_retention, 2) . '" required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_nth_pair(): string
{
	return '<tr>
                <td><div class="center_align">Nth Pair:</div></td>
                <td>
                    <div class="center_align"><label><select name="chairman_pairs_safety" style="width:150px">' .
		display_pairs_safety('chairman') . '</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="executive_pairs_safety" style="width:150px">' .
		display_pairs_safety('executive') . '</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="regular_pairs_safety" style="width:150px">' .
		display_pairs_safety('regular') . '</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="associate_pairs_safety" style="width:150px">' .
		display_pairs_safety('associate') . '</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="basic_pairs_safety" style="width:150px">' .
		display_pairs_safety() . '</select></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_capping_pairs(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Capping Pairs (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_max_pairs" class="net_align"
                                      value="' . number_format($settings_binary->chairman_max_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_max_pairs" class="net_align"
                                      value="' . number_format($settings_binary->executive_max_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_max_pairs" class="net_align"
                                      value="' . number_format($settings_binary->regular_max_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_max_pairs" class="net_align"
                                      value="' . number_format($settings_binary->associate_max_pairs, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_max_pairs" class="net_align"
                                      value="' . number_format($settings_binary->basic_max_pairs, 8) . '" 
                                      required></label></div>
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
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Required Directs:</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_binary_sponsored" class="net_align"
                                      value="' . number_format($settings_binary->chairman_binary_sponsored) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_binary_sponsored" class="net_align"
                                      value="' . number_format($settings_binary->executive_binary_sponsored) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_binary_sponsored" class="net_align"
                                      value="' . number_format($settings_binary->regular_binary_sponsored) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_binary_sponsored" class="net_align"
                                      value="' . number_format($settings_binary->associate_binary_sponsored) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_binary_sponsored" class="net_align"
                                      value="' . number_format($settings_binary->basic_binary_sponsored) . '" 
                                      required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_required_pairs(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Required Pairs (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_required_pairs" class="net_align"
                                      value="' . number_format($settings_binary->chairman_required_pairs, 8) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_required_pairs" class="net_align"
                                      value="' . number_format($settings_binary->executive_required_pairs, 8) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_required_pairs" class="net_align"
                                      value="' . number_format($settings_binary->regular_required_pairs, 8) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_required_pairs" class="net_align"
                                      value="' . number_format($settings_binary->associate_required_pairs, 8) . '"
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_required_pairs" class="net_align"
                                      value="' . number_format($settings_binary->basic_required_pairs) . '" 
                                      required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_pairing_bonus_proper(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Pairing Bonus Proper (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_pairs_proper" class="net_align"
                                      value="' . number_format($settings_binary->chairman_pairs_proper, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_pairs_proper" class="net_align"
                                      value="' . number_format($settings_binary->executive_pairs_proper, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_pairs_proper" class="net_align"
                                      value="' . number_format($settings_binary->regular_pairs_proper, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_pairs_proper" class="net_align"
                                      value="' . number_format($settings_binary->associate_pairs_proper, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_pairs_proper" class="net_align"
                                      value="' . number_format($settings_binary->basic_pairs_proper, 8) . '" 
                                      required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_pairing_bonus_capped(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Pairing Bonus Capped (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_pairs_capped" class="net_align"
                                      value="' . number_format($settings_binary->chairman_pairs_capped, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_pairs_capped" class="net_align"
                                      value="' . number_format($settings_binary->executive_pairs_capped, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_pairs_capped" class="net_align"
                                      value="' . number_format($settings_binary->regular_pairs_capped, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_pairs_capped" class="net_align"
                                      value="' . number_format($settings_binary->associate_pairs_capped, 8) . '" 
                                      required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_pairs_capped" class="net_align"
                                      value="' . number_format($settings_binary->basic_pairs_capped, 8) . '" 
                                      required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_reactivate_cost(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Reactivate Cost (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_pairs_reactivate" class="net_align"
                                      value="' .
		number_format($settings_binary->chairman_pairs_reactivate, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_pairs_reactivate" class="net_align"
                                      value="' .
		number_format($settings_binary->executive_pairs_reactivate, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_pairs_reactivate" class="net_align"
                                      value="' .
		number_format($settings_binary->regular_pairs_reactivate, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_pairs_reactivate" class="net_align"
                                      value="' .
		number_format($settings_binary->associate_pairs_reactivate, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_pairs_reactivate" class="net_align"
                                      value="' .
		number_format($settings_binary->basic_pairs_reactivate, 8) .
		'" required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_capping_cycle_max(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Max. Capping Cycle:</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_capping_cycle_max" class="net_align"
                                      value="' .
		number_format($settings_binary->chairman_capping_cycle_max) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_capping_cycle_max" class="net_align"
                                      value="' .
		number_format($settings_binary->executive_capping_cycle_max) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_capping_cycle_max" class="net_align"
                                      value="' .
		number_format($settings_binary->regular_capping_cycle_max) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_capping_cycle_max" class="net_align"
                                      value="' .
		number_format($settings_binary->associate_capping_cycle_max) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_capping_cycle_max" class="net_align"
                                      value="' .
		number_format($settings_binary->basic_capping_cycle_max) .
		'" required></label></div>
                </td>
            </tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_maximum_income(): string
{
	$settings_binary = settings('binary');

	return '<tr>
                <td><div class="center_align">Maximum Income (' .
		settings('ancillaries')->currency . '):</div></td>
                <td>
                    <div class="center_align"><label><input name="chairman_maximum_income" class="net_align"
                                      value="' .
		number_format($settings_binary->chairman_maximum_income, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="executive_maximum_income" class="net_align"
                                      value="' .
		number_format($settings_binary->executive_maximum_income, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="regular_maximum_income" class="net_align"
                                      value="' .
		number_format($settings_binary->regular_maximum_income, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="associate_maximum_income" class="net_align"
                                      value="' .
		number_format($settings_binary->associate_maximum_income, 8) .
		'" required></label></div>
                </td>
                <td>
                    <div class="center_align"><label><input name="basic_maximum_income" class="net_align"
                                      value="' .
		number_format($settings_binary->basic_maximum_income, 8) .
		'" required></label></div>
                </td>
            </tr>';
}