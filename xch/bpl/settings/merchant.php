<?php

namespace BPL\Settings\Merchant;

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
		'executive_merchant_name' => input_get('executive_merchant_name'),
		'regular_merchant_name'   => input_get('regular_merchant_name'),
		'associate_merchant_name' => input_get('associate_merchant_name'),
		'basic_merchant_name'     => input_get('basic_merchant_name'),

		'executive_merchant_entry' => input_get('executive_merchant_entry'),
		'regular_merchant_entry'   => input_get('regular_merchant_entry'),
		'associate_merchant_entry' => input_get('associate_merchant_entry'),
		'basic_merchant_entry'     => input_get('basic_merchant_entry'),

		'executive_merchant_cut' => input_get('executive_merchant_cut'),
		'regular_merchant_cut'   => input_get('regular_merchant_cut'),
		'associate_merchant_cut' => input_get('associate_merchant_cut'),
		'basic_merchant_cut'     => input_get('basic_merchant_cut')
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
		$input['executive_merchant_name'],
		$input['regular_merchant_name'],
		$input['associate_merchant_name'],
		$input['basic_merchant_name']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_merchant',
				[
					'executive_merchant_name = ' . $db->quote($input['executive_merchant_name']),
					'regular_merchant_name = ' . $db->quote($input['regular_merchant_name']),
					'associate_merchant_name = ' . $db->quote($input['associate_merchant_name']),
					'basic_merchant_name = ' . $db->quote($input['basic_merchant_name']),

					'executive_merchant_entry = ' . $db->quote($input['executive_merchant_entry']),
					'regular_merchant_entry = ' . $db->quote($input['regular_merchant_entry']),
					'associate_merchant_entry = ' . $db->quote($input['associate_merchant_entry']),
					'basic_merchant_entry = ' . $db->quote($input['basic_merchant_entry']),

					'executive_merchant_cut = ' . $db->quote($input['executive_merchant_cut']),
					'regular_merchant_cut = ' . $db->quote($input['regular_merchant_cut']),
					'associate_merchant_cut = ' . $db->quote($input['associate_merchant_cut']),
					'basic_merchant_cut = ' . $db->quote($input['basic_merchant_cut'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(87),
			settings('plans')->merchant_name . ' Settings Updated Successfully!', 'success');
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
	$settings_merchant = settings('merchant');

	$str = style();

	$str .= '
    <section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
    <form method="post">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">' . settings('plans')->merchant_name . ' Bonus</h3></td>
            </tr>
            <tr>
                <td></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_merchant->executive_merchant_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_merchant->regular_merchant_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_merchant->associate_merchant_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_merchant->basic_merchant_name . '</h4></td>
            </tr>';

	$str .= view_row_name();
	$str .= view_row_entry();
	$str .= view_row_cut();

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
function view_row_name(): string
{
	$settings_merchant = settings('merchant');

	return '<tr>
                <td>
                    <div class="center_align">' . settings('plans')->merchant_name . ' Name:</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_merchant_name" class="net_align"
                                      value="' . $settings_merchant->executive_merchant_name . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_merchant_name" class="net_align"
                                      value="' . $settings_merchant->regular_merchant_name . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_merchant_name" class="net_align"
                                      value="' . $settings_merchant->associate_merchant_name . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_merchant_name" class="net_align"
                                      value="' . $settings_merchant->basic_merchant_name . '" required>
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
function view_row_entry(): string
{
	$settings_merchant = settings('merchant');

	return '<tr>
                <td>
                    <div class="center_align">Entry (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_merchant_entry" class="net_align"
                                      value="' . number_format($settings_merchant->executive_merchant_entry, 2) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_merchant_entry" class="net_align"
                                      value="' . number_format($settings_merchant->regular_merchant_entry, 2) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_merchant_entry" class="net_align"
                                      value="' . number_format($settings_merchant->associate_merchant_entry, 2) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_merchant_entry" class="net_align"
                                      value="' . number_format($settings_merchant->basic_merchant_entry, 2) . '"
                                      required>
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
function view_row_cut(): string
{
	$settings_merchant = settings('merchant');

	return '<tr>
                <td>
                    <div class="center_align">Cut (%):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_merchant_cut" class="net_align"
                                      value="' . number_format($settings_merchant->executive_merchant_cut) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_merchant_cut" class="net_align"
                                      value="' . number_format($settings_merchant->regular_merchant_cut) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_merchant_cut" class="net_align"
                                      value="' . number_format($settings_merchant->associate_merchant_cut) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_merchant_cut" class="net_align"
                                      value="' . number_format($settings_merchant->basic_merchant_cut) . '" required>
                        </label>
                    </div>
                </td>
            </tr>';
}

