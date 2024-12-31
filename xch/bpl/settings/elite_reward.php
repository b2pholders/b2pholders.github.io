<?php

namespace BPL\Settings\Elite_Reward;

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
		'directs'                => input_get('directs'),
		'sales'                  => input_get('sales'),
		'group_limit'            => input_get('group_limit'),
		'repeat_purchase_reward' => input_get('repeat_purchase_reward'),
		'basic_reward'           => input_get('basic_reward'),
		'associate_reward'       => input_get('associate_reward'),
		'regular_reward'         => input_get('regular_reward')
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
		$input['directs'],
		$input['sales']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_elite_reward',
				[
					'repeat_purchase_reward = ' . $db->quote($input['repeat_purchase_reward']),
					'basic_reward = ' . $db->quote($input['basic_reward']),
					'associate_reward = ' . $db->quote($input['associate_reward']),
					'regular_reward = ' . $db->quote($input['regular_reward']),
					'directs = ' . $db->quote($input['directs']),
					'sales = ' . $db->quote($input['sales']),
					'group_limit = ' . $db->quote($input['group_limit'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(119),
			$settings_plans->elite_reward_name . ' Settings Updated Successfully!', 'success');
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
	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
	<form method="post">';

	// rewards
	$str .= view_table_rewards();

	// requirements
	$str .= view_table_requirements();

	$str .= '<div class="center_align">
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
function view_table_rewards(): string
{
	$settings_entry        = settings('entry');
	$settings_elite_reward = settings('elite_reward');

	$currency = settings('ancillaries')->currency;

	return '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="4"><h3 class="center_align">' . settings('plans')->elite_reward_name . '</h3></td>
			</tr>
			<tr>			
				<td><h4 class="center_align" data-uk-tooltip title="Reward per repeat purchase">Repeat Purchase (%)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Reward per ' .
		$settings_entry->basic_package_name .
		' entry">' . $settings_entry->basic_package_name . ' (' . $currency . ')</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Reward per ' .
		$settings_entry->associate_package_name .
		' entry">' . $settings_entry->associate_package_name . ' (' . $currency . ')</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Reward per ' .
		$settings_entry->regular_package_name .
		' entry">' . $settings_entry->regular_package_name . ' (' . $currency . ')</h4></td>
			</tr>
			<tr>				
				<td>
					<div class="center_align"><label>
							<input name="repeat_purchase_reward" class="net_align"
							       value="' .
		number_format($settings_elite_reward->repeat_purchase_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_reward" class="net_align"
							       value="' .
		number_format($settings_elite_reward->basic_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_reward" class="net_align"
							       value="' .
		number_format($settings_elite_reward->associate_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_reward" class="net_align"
							       value="' .
		number_format($settings_elite_reward->regular_reward, 2) . '"></label></div>
				</td>
			</tr>			
		</table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_requirements(): string
{
	$settings_elite_reward = settings('elite_reward');

	return '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="3"><h3 class="center_align">Requirements</h3></td>
			</tr>		
			<tr>
				<td><h4 class="center_align" data-uk-tooltip title="Number of sponsored members">Directs (#)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Group sales quota">Sales (' .
		settings('ancillaries')->currency . ')</h4></td>	
				<td><h4 class="center_align" data-uk-tooltip title="Group number limit">Limit (#)</h4></td>			
			</tr>
			<tr>
				<td>
					<div class="center_align"><label>
							<input name="directs" class="net_align"
							       value="' . number_format($settings_elite_reward->directs) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="sales" class="net_align"
							       value="' . number_format($settings_elite_reward->sales, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="group_limit" class="net_align"
							       value="' . number_format($settings_elite_reward->group_limit) . '"></label></div>
				</td>			
			</tr>
		</table>';
}
