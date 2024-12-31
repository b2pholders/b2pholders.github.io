<?php

namespace BPL\Settings\Referral;

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
		'chairman_referral'  => input_get('chairman_referral'),
		'executive_referral' => input_get('executive_referral'),
		'regular_referral'   => input_get('regular_referral'),
		'associate_referral' => input_get('associate_referral'),
		'basic_referral'     => input_get('basic_referral')
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
		$input['chairman_referral'],
		$input['executive_referral'],
		$input['regular_referral'],
		$input['associate_referral'],
		$input['basic_referral']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_referral',
				[
					'chairman_referral = ' . $db->quote($input['chairman_referral']),
					'executive_referral = ' . $db->quote($input['executive_referral']),
					'regular_referral = ' . $db->quote($input['regular_referral']),
					'associate_referral = ' . $db->quote($input['associate_referral']),
					'basic_referral = ' . $db->quote($input['basic_referral'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(91),
			settings('plans')->direct_referral_name . ' Settings Updated Successfully!', 'success');
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
	$settings_entry    = settings('entry');
	$settings_referral = settings('referral');

	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
	<form method="post">
        <table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">' . settings('plans')->direct_referral_name .
		' (' . settings('ancillaries')->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input name="chairman_referral" class="net_align"
                                      value="' . number_format($settings_referral->chairman_referral, 8) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_referral" class="net_align"
                                      value="' . number_format($settings_referral->executive_referral, 8) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_referral" class="net_align"
                                      value="' . number_format($settings_referral->regular_referral, 8) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_referral" class="net_align"
                                      value="' . number_format($settings_referral->associate_referral, 8) . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_referral" class="net_align"
                                      value="' . number_format($settings_referral->basic_referral, 8) . '" required>
                        </label>
                    </div>
                </td>
            </tr>
        </table>
		<div class="center_align">
			<input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
		</div>
	</form>
    </div></div></section>';

	return $str;
}