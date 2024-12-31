<?php

namespace BPL\Settings\Passup;

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
        'executive_passup_bonus' => input_get('executive_passup_bonus'),
        'regular_passup_bonus'   => input_get('regular_passup_bonus'),
        'associate_passup_bonus' => input_get('associate_passup_bonus'),
        'basic_passup_bonus'     => input_get('basic_passup_bonus'),

        'executive_passup_width' => input_get('executive_passup_width'),
        'regular_passup_width'   => input_get('regular_passup_width'),
        'associate_passup_width' => input_get('associate_passup_width'),
        'basic_passup_width'     => input_get('basic_passup_width'),

        'executive_passup_interval' => input_get('executive_passup_interval'),
        'regular_passup_interval'   => input_get('regular_passup_interval'),
        'associate_passup_interval' => input_get('associate_passup_interval'),
        'basic_passup_interval'     => input_get('basic_passup_interval')
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
        $input['executive_passup_width'],
        $input['regular_passup_width'],
        $input['associate_passup_width'],
        $input['basic_passup_width'],

        $input['executive_passup_interval'],
        $input['regular_passup_interval'],
        $input['associate_passup_interval'],
        $input['basic_passup_interval']
    ];

    if (!in_array('', $test, true))
    {
        try
        {
            $db->transactionStart();

            query_update(
                'network_settings_passup',
                [
                    'executive_passup_bonus = ' . $db->quote($input['executive_passup_bonus']),
                    'regular_passup_bonus = ' . $db->quote($input['regular_passup_bonus']),
                    'associate_passup_bonus = ' . $db->quote($input['associate_passup_bonus']),
                    'basic_passup_bonus = ' . $db->quote($input['basic_passup_bonus']),

                    'executive_passup_width = ' . $db->quote($input['executive_passup_width']),
                    'regular_passup_width = ' . $db->quote($input['regular_passup_width']),
                    'associate_passup_width = ' . $db->quote($input['associate_passup_width']),
                    'basic_passup_width = ' . $db->quote($input['basic_passup_width']),

                    'executive_passup_interval = ' . $db->quote($input['executive_passup_interval']),
                    'regular_passup_interval = ' . $db->quote($input['regular_passup_interval']),
                    'associate_passup_interval = ' . $db->quote($input['associate_passup_interval']),
                    'basic_passup_interval = ' . $db->quote($input['basic_passup_interval'])
                ]
            );

            $db->transactionCommit();
        }
        catch (Exception $e)
        {
            $db->transactionRollback();
            ExceptionHandler::render($e);
        }

        application()->redirect(Uri::root(true) . '/' . sef(118),
            settings('plans')->passup_name . ' Settings Updated Successfully!', 'success');
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
				<td colspan="5"><h3 class="center_align">' . settings('plans')->passup_name . '</h3></td>
			</tr>
			<tr>
				<td></td>
				<td><h4 class="center_align" data-uk-tooltip title="' . $settings_entry->executive_package_name .
        ' user account">' . $settings_entry->executive_package_name . '</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="' . $settings_entry->regular_package_name .
        ' user account">' . $settings_entry->regular_package_name . '</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="' . $settings_entry->associate_package_name .
        ' user account">' . $settings_entry->associate_package_name . '</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="' . $settings_entry->basic_package_name .
        ' user account">' . $settings_entry->basic_package_name . '</h4></td>
			</tr>';

    $str .= view_row_bonus();
    $str .= view_row_width();
    $str .= view_row_interval();

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
    $settings_passup = settings('passup');

    return '<tr>
				<td>
					<div class="center_align" data-uk-tooltip title="Entry Passup Bonus">Bonus' .
        ' (' . settings('ancillaries')->currency . ')</div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="executive_passup_bonus" class="net_align"
						              value="' .
        number_format($settings_passup->executive_passup_bonus, 2) . '" required>
						</label>
					</div>
				</td>			
				<td>
					<div class="center_align">
						<label><input type="text" name="regular_passup_bonus" class="net_align"
						              value="' .
        number_format($settings_passup->regular_passup_bonus, 2) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="associate_passup_bonus" class="net_align"
						              value="' .
        number_format($settings_passup->associate_passup_bonus, 2) . '" required>
						</label>
					</div>
				</td>				
				<td>
					<div class="center_align">
						<label><input type="text" name="basic_passup_bonus" class="net_align"
						              value="' .
        number_format($settings_passup->basic_passup_bonus, 2) . '" required>
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
function view_row_width(): string
{
    $settings_passup = settings('passup');

    return '<tr>
				<td>
					<div class="center_align" data-uk-tooltip title="Max Downline Directs">Width (#)</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="executive_passup_width" class="net_align"
						              value="' . number_format($settings_passup->executive_passup_width) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="regular_passup_width" class="net_align"
						              value="' . number_format($settings_passup->regular_passup_width) . '" required>
						</label>
					</div>
				</td>				
				<td>
					<div class="center_align">
						<label><input type="text" name="associate_passup_width" class="net_align"
						              value="' . number_format($settings_passup->associate_passup_width) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="basic_passup_width" class="net_align"
						              value="' . number_format($settings_passup->basic_passup_width) . '" required>
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
function view_row_interval(): string
{
    $settings_passup = settings('passup');

    return '<tr>
				<td>
					<div class="center_align" data-uk-tooltip title="Downline Interval of Directs">Interval (#)</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="executive_passup_interval" class="net_align"
						              value="' . number_format($settings_passup->executive_passup_interval) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="regular_passup_interval" class="net_align"
						              value="' . number_format($settings_passup->regular_passup_interval) . '" required>
						</label>
					</div>
				</td>				
				<td>
					<div class="center_align">
						<label><input type="text" name="associate_passup_interval" class="net_align"
						              value="' . number_format($settings_passup->associate_passup_interval) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" name="basic_passup_interval" class="net_align"
						              value="' . number_format($settings_passup->basic_passup_interval) . '" required>
						</label>
					</div>
				</td>	
			</tr>';
}