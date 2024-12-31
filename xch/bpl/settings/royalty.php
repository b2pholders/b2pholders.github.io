<?php

namespace BPL\Settings\Royalty;

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
		'supervisor_members'        => input_get('supervisor_members'),
		'supervisor_member_directs' => input_get('supervisor_member_directs'),
		'supervisor_sales'          => input_get('supervisor_sales'),
		'manager_supervisors'       => input_get('manager_supervisors'),
		'manager_sales'             => input_get('manager_sales'),
		'director_managers'         => input_get('director_managers'),
		'director_sales'            => input_get('director_sales'),

		'supervisor_repeat_purchase_reward' => input_get('supervisor_repeat_purchase_reward'),
		'supervisor_basic_reward'           => input_get('supervisor_basic_reward'),
		'supervisor_associate_reward'       => input_get('supervisor_associate_reward'),
		'supervisor_regular_reward'         => input_get('supervisor_regular_reward'),
		'manager_repeat_purchase_reward'    => input_get('manager_repeat_purchase_reward'),
		'manager_basic_reward'              => input_get('manager_basic_reward'),
		'manager_associate_reward'          => input_get('manager_associate_reward'),
		'manager_regular_reward'            => input_get('manager_regular_reward'),
		'director_repeat_purchase_reward'   => input_get('director_repeat_purchase_reward'),
		'director_basic_reward'             => input_get('director_basic_reward'),
		'director_associate_reward'         => input_get('director_associate_reward'),
		'director_regular_reward'           => input_get('director_regular_reward'),

		'director_rank_name'   => input_get('director_rank_name'),
		'manager_rank_name'    => input_get('manager_rank_name'),
		'supervisor_rank_name' => input_get('supervisor_rank_name'),
		'affiliate_rank_name'  => input_get('affiliate_rank_name')
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
		$input['supervisor_members'],
		$input['supervisor_member_directs'],
		$input['supervisor_sales'],
		$input['manager_supervisors'],
		$input['manager_sales'],
		$input['director_managers'],
		$input['director_sales'],
		$input['affiliate_rank_name'],
		$input['supervisor_rank_name'],
		$input['manager_rank_name'],
		$input['director_rank_name']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_royalty',
				[
					'affiliate_rank_name = ' . $db->quote($input['affiliate_rank_name']),
					'supervisor_rank_name = ' . $db->quote($input['supervisor_rank_name']),
					'manager_rank_name = ' . $db->quote($input['manager_rank_name']),
					'director_rank_name = ' . $db->quote($input['director_rank_name']),

					'supervisor_repeat_purchase_reward = ' . $db->quote($input['supervisor_repeat_purchase_reward']),
					'supervisor_basic_reward = ' . $db->quote($input['supervisor_basic_reward']),
					'supervisor_associate_reward = ' . $db->quote($input['supervisor_associate_reward']),
					'supervisor_regular_reward = ' . $db->quote($input['supervisor_regular_reward']),
					'manager_repeat_purchase_reward = ' . $db->quote($input['manager_repeat_purchase_reward']),
					'manager_basic_reward = ' . $db->quote($input['manager_basic_reward']),
					'manager_associate_reward = ' . $db->quote($input['manager_associate_reward']),
					'manager_regular_reward = ' . $db->quote($input['manager_regular_reward']),
					'director_repeat_purchase_reward = ' . $db->quote($input['director_repeat_purchase_reward']),
					'director_basic_reward = ' . $db->quote($input['director_basic_reward']),
					'director_associate_reward = ' . $db->quote($input['director_associate_reward']),
					'director_regular_reward = ' . $db->quote($input['director_regular_reward']),

					'supervisor_members = ' . $db->quote($input['supervisor_members']),
					'supervisor_member_directs = ' . $db->quote($input['supervisor_member_directs']),
					'supervisor_sales = ' . $db->quote($input['supervisor_sales']),
					'manager_supervisors = ' . $db->quote($input['manager_supervisors']),
					'manager_sales = ' . $db->quote($input['manager_sales']),
					'director_managers = ' . $db->quote($input['director_managers']),
					'director_sales = ' . $db->quote($input['director_sales'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(90),
			settings('plans')->royalty_name . ' Settings Updated Successfully!', 'success');
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

	$str .= view_table_rank_name();
	$str .= view_table_rewards();
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
function view_table_rank_name(): string
{
	$settings_royalty = settings('royalty');

	// rank name
	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="4"><h3 class="center_align">' . settings('plans')->royalty_name . ' Name</h3></td>
            </tr>
            <tr>
                <td><h4 style="margin:0" class="center_align" data-uk-tooltip title="Default rank upon registration">' .
		$settings_royalty->affiliate_rank_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_royalty->supervisor_rank_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_royalty->manager_rank_name . '</h4></td>
                <td><h4 style="margin:0" class="center_align">' . $settings_royalty->director_rank_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input name="affiliate_rank_name" class="net_align"
                                      value="' . $settings_royalty->affiliate_rank_name . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="supervisor_rank_name" class="net_align"
                                      value="' . $settings_royalty->supervisor_rank_name . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="manager_rank_name" class="net_align"
                                      value="' . $settings_royalty->manager_rank_name . '" required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="director_rank_name" class="net_align"
                                      value="' . $settings_royalty->director_rank_name . '" required>
                        </label>
                    </div>
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
function view_table_rewards(): string
{
	$settings_entry = settings('entry');

	$currency = settings('ancillaries')->currency;

	// rewards
	$str = '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="5"><h3 class="center_align">Rewards</h3></td>
			</tr>
			<tr>
				<td></td>
				<td><h4 class="center_align" data-uk-tooltip title="Every repeat purchase">Repeat Purchase (%)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Every ' . $settings_entry->basic_package_name .
		' entry">' . $settings_entry->basic_package_name . ' (' . $currency . ')</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Every ' . $settings_entry->associate_package_name .
		' entry">' . $settings_entry->associate_package_name . ' (' . $currency . ')</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Every ' . $settings_entry->regular_package_name .
		' entry">' . $settings_entry->regular_package_name . ' (' . $currency . ')</h4></td>
			</tr>';

	$str .= view_row_rewards_supervisor();
	$str .= view_row_rewards_manager();
	$str .= view_row_rewards_director();

	$str .= '</table>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_rewards_supervisor(): string
{
	$settings_royalty = settings('royalty');

	return '<tr>
				<td>
					<h4 class="center_align" data-uk-tooltip title="' . $settings_royalty->supervisor_rank_name .
		' user rank">Supervisor</h4>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_repeat_purchase_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->supervisor_repeat_purchase_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_basic_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->supervisor_basic_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_associate_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->supervisor_associate_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_regular_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->supervisor_regular_reward, 2) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_rewards_manager(): string
{
	$settings_royalty = settings('royalty');

	return '<tr>
				<td>
					<h4 class="center_align" data-uk-tooltip title="' . $settings_royalty->manager_rank_name .
		' user rank">Manager</h4>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="manager_repeat_purchase_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->manager_repeat_purchase_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="manager_basic_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->manager_basic_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="manager_associate_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->manager_associate_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="manager_regular_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->manager_regular_reward, 2) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_rewards_director(): string
{
	$settings_royalty = settings('royalty');

	return '<tr>
				<td>
					<h4 class="center_align" data-uk-tooltip title="' . $settings_royalty->director_rank_name .
		' user rank">Director</h4>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="director_repeat_purchase_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->director_repeat_purchase_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="director_basic_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->director_basic_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="director_associate_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->director_associate_reward, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="director_regular_reward" class="net_align"
							       value="' .
		number_format($settings_royalty->director_regular_reward, 2) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_requirements(): string
{
	$settings_royalty = settings('royalty');

	$currency = settings('ancillaries')->currency;

	// requirements
	return '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="7"><h3 class="center_align">Requirements</h3></td>
			</tr>
			<tr>
				<td colspan="3"><h3 class="center_align">' . $settings_royalty->supervisor_rank_name . '</h3></td>
				<td colspan="2"><h3 class="center_align">' . $settings_royalty->manager_rank_name . '</h3></td>
				<td colspan="2"><h3 class="center_align">' . $settings_royalty->director_rank_name . '</h3></td>
			</tr>
			<tr>
				<td><h4 class="center_align" data-uk-tooltip title="Number of downlines">Members (#)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Number of directs per downline">Directs (#)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Monthly Group Sales">Sales (' . $currency . ')</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Number of Supervisors">' . $settings_royalty->supervisor_rank_name . ' (#)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Monthly Group Sales">Sales (' . $currency . ')</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Number of Managers">' . $settings_royalty->manager_rank_name . ' (#)</h4></td>
				<td><h4 class="center_align" data-uk-tooltip title="Monthly Group Sales">Sales (' . $currency . ')</h4></td>
			</tr>
			<tr>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_members" class="net_align"
							       value="' . number_format($settings_royalty->supervisor_members) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_member_directs" class="net_align"
							       value="' . number_format($settings_royalty->supervisor_member_directs) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="supervisor_sales" class="net_align"
							       value="' . number_format($settings_royalty->supervisor_sales, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="manager_supervisors" class="net_align"
							       value="' . number_format($settings_royalty->manager_supervisors) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="manager_sales" class="net_align"
							       value="' . number_format($settings_royalty->manager_sales, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="director_managers" class="net_align"
							       value="' . number_format($settings_royalty->director_managers) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="director_sales" class="net_align"
							       value="' . number_format($settings_royalty->director_sales, 2) . '"></label></div>
				</td>			
			</tr>
		</table>';
}
