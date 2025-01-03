<?php

namespace BPL\Settings\Passup_Binary;

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
 * Retrieves input data from the request.
 *
 * @return array
 */
function get_input(): array
{
	return [
		'throttle' => input_get('throttle'),

		'chairman_bonus' => input_get('chairman_bonus'),
		'executive_bonus' => input_get('executive_bonus'),
		'regular_bonus' => input_get('regular_bonus'),
		'associate_bonus' => input_get('associate_bonus'),
		'basic_bonus' => input_get('basic_bonus'),

		'chairman_percent' => input_get('chairman_percent'),
		'executive_percent' => input_get('executive_percent'),
		'regular_percent' => input_get('regular_percent'),
		'associate_percent' => input_get('associate_percent'),
		'basic_percent' => input_get('basic_percent'),

		'chairman_sponsored' => input_get('chairman_sponsored'),
		'executive_sponsored' => input_get('executive_sponsored'),
		'regular_sponsored' => input_get('regular_sponsored'),
		'associate_sponsored' => input_get('associate_sponsored'),
		'basic_sponsored' => input_get('basic_sponsored'),

		'chairman_max_daily_income' => input_get('chairman_max_daily_income'),
		'executive_max_daily_income' => input_get('executive_max_daily_income'),
		'regular_max_daily_income' => input_get('regular_max_daily_income'),
		'associate_max_daily_income' => input_get('associate_max_daily_income'),
		'basic_max_daily_income' => input_get('basic_max_daily_income'),

		'chairman_maximum_income' => input_get('chairman_maximum_income'),
		'executive_maximum_income' => input_get('executive_maximum_income'),
		'regular_maximum_income' => input_get('regular_maximum_income'),
		'associate_maximum_income' => input_get('associate_maximum_income'),
		'basic_maximum_income' => input_get('basic_maximum_income')
	];
}

/**
 * Updates the settings based on the input data.
 */
function update()
{
	$app = application();
	$db = db();
	$input = get_input();

	$test = array_values($input);

	if (!in_array('', $test, true)) {
		try {
			$db->transactionStart();

			query_update(
				'network_settings_passup_binary',
				array_map(function ($key, $value) use ($db) {
					return "$key = " . $db->quote($value);
				}, array_keys($input), $input)
			);

			$db->transactionCommit();
		} catch (Exception $e) {
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		$app->enqueueMessage(settings('plans')->passup_binary_name . ' Settings Updated Successfully!', 'success');
		$app->redirect(Uri::root(true) . '/' . sef(148));
	}
}

/**
 * Generates the CSS styles for the view.
 *
 * @return string
 */
function style(): string
{
	return <<<CSS
		<style>
			/* Base styles */
			.table th, .table td {
				vertical-align: middle;
				text-align: center;
			}
			.net_align {
				width: 100%;
				max-width: 120px;
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
				width: 100%;
				max-width: 150px;
			}
			.uk-button {
				width: 100%;
				max-width: 200px;
				margin: 10px auto;
			}

			/* Responsive styles */
			@media (max-width: 768px) {
				.table th, .table td {
					display: block;
					width: 100%;
					text-align: left;
				}
				.table tr {
					display: flex;
					flex-direction: column;
					margin-bottom: 10px;
					border: 1px solid #ddd;
					padding: 10px;
				}
				.table td {
					border: none;
				}
				.net_align {
					max-width: 100%;
				}
				select {
					max-width: 100%;
				}
				.uk-button {
					max-width: 100%;
				}
			}
		</style>
	CSS;
}

/**
 * Generates the HTML view for the settings form.
 *
 * @return string
 */
function view(): string
{
	$se = settings('entry');
	$sp = settings('plans');

	$style = style();
	$throttleOptions = throttle_options();
	$bonusRow = view_row_bonus();
	$percentRow = view_row_percent();
	$sponsoredRow = view_row_sponsored();
	$maxDailyRow = view_row_max_daily();
	$maxRow = view_row_max();

	return <<<HTML
		{$style}
		<section class="tm-top-b uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first">
				<div class="uk-panel uk-text-center">
					<form method="post">
						<table class="category table table-striped table-bordered table-hover">
							<tr>
								<th colspan="7"><h3 class="center_align">{$sp->passup_binary_name}</h3></th>
							</tr>
							<tr>
								<th>
									<div class="center_align">
										<label>
											<select name="throttle">
												$throttleOptions
											</select>
										</label>
									</div>
								</th>
								<th><h4 class="center_align">{$se->chairman_package_name}</h4></th>
								<th><h4 class="center_align">{$se->executive_package_name}</h4></th>
								<th><h4 class="center_align">{$se->regular_package_name}</h4></th>
								<th><h4 class="center_align">{$se->associate_package_name}</h4></th>
								<th><h4 class="center_align">{$se->basic_package_name}</h4></th>
							</tr>
							{$bonusRow}
							{$percentRow}
							{$sponsoredRow}
							{$maxDailyRow}
							{$maxRow}
						</table>
						<div class="center_align">
							<input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
						</div>
					</form>
				</div>
			</div>
		</section>
	HTML;
}

/**
 * Generates the throttle options for the select input.
 *
 * @return string
 */
function throttle_options(): string
{
	$default = throttle(0);
	$selected = throttle(1);

	return <<<OPTIONS
		<option value="0" {$default}>Default</option>
		<option value="1" {$selected}>Throttled</option>
	OPTIONS;
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function throttle($value): string
{
	return (int) settings('passup_binary')->throttle === (int) $value ? 'selected' : '';
}

/**
 * Generates the HTML for the bonus row.
 *
 * @return string
 */
function view_row_bonus(): string
{
	$spb = settings('passup_binary');
	$currency = settings('ancillaries')->currency;

	return <<<HTML
		<tr>
			<td><div class="center_align">Amount ($currency):</div></td>
			<td><div class="center_align"><label><input type="text" name="chairman_bonus" class="net_align" value="{$spb->chairman_bonus}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="executive_bonus" class="net_align" value="{$spb->executive_bonus}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="regular_bonus" class="net_align" value="{$spb->regular_bonus}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="associate_bonus" class="net_align" value="{$spb->associate_bonus}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="basic_bonus" class="net_align" value="{$spb->basic_bonus}" required></label></div></td>
		</tr>
	HTML;
}

/**
 * Generates the HTML for the percent row.
 *
 * @return string
 */
function view_row_percent(): string
{
	$spb = settings('passup_binary');

	return <<<HTML
		<tr>
			<td><div class="center_align">Percent (%):</div></td>
			<td><div class="center_align"><label><input type="text" name="chairman_percent" class="net_align" value="{$spb->chairman_percent}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="executive_percent" class="net_align" value="{$spb->executive_percent}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="regular_percent" class="net_align" value="{$spb->regular_percent}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="associate_percent" class="net_align" value="{$spb->associate_percent}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="basic_percent" class="net_align" value="{$spb->basic_percent}" required></label></div></td>
		</tr>
	HTML;
}

function view_row_sponsored()
{
	$spb = settings('passup_binary');

	return <<<HTML
		<tr>
			<td><div class="center_align">Sponsored:</div></td>
			<td><div class="center_align"><label><input type="text" name="chairman_sponsored" class="net_align" value="{$spb->chairman_sponsored}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="executive_sponsored" class="net_align" value="{$spb->executive_sponsored}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="regular_sponsored" class="net_align" value="{$spb->regular_sponsored}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="associate_sponsored" class="net_align" value="{$spb->associate_sponsored}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="basic_sponsored" class="net_align" value="{$spb->basic_sponsored}" required></label></div></td>
		</tr>
	HTML;
}

function view_row_max_daily()
{
	$spb = settings('passup_binary');
	$currency = settings('ancillaries')->currency;

	return <<<HTML
		<tr>
			<td><div class="center_align">Max. Daily Income ($currency):</div></td>
			<td><div class="center_align"><label><input type="text" name="chairman_max_daily_income" class="net_align" value="{$spb->chairman_max_daily_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="executive_max_daily_income" class="net_align" value="{$spb->executive_max_daily_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="regular_max_daily_income" class="net_align" value="{$spb->regular_max_daily_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="associate_max_daily_income" class="net_align" value="{$spb->associate_max_daily_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="basic_max_daily_income" class="net_align" value="{$spb->basic_max_daily_income}" required></label></div></td>
		</tr>
	HTML;
}

function view_row_max()
{
	$spb = settings('passup_binary');
	$currency = settings('ancillaries')->currency;

	return <<<HTML
		<tr>
			<td><div class="center_align">Maximum Income ($currency):</div></td>
			<td><div class="center_align"><label><input type="text" name="chairman_maximum_income" class="net_align" value="{$spb->chairman_maximum_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="executive_maximum_income" class="net_align" value="{$spb->executive_maximum_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="regular_maximum_income" class="net_align" value="{$spb->regular_maximum_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="associate_maximum_income" class="net_align" value="{$spb->associate_maximum_income}" required></label></div></td>
			<td><div class="center_align"><label><input type="text" name="basic_maximum_income" class="net_align" value="{$spb->basic_maximum_income}" required></label></div></td>
		</tr>
	HTML;
}