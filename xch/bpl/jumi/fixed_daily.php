<?php

namespace BPL\Jumi\Fixed_Daily;

require_once 'bpl/ajax/ajaxer/table_fixed_daily.php';
require_once 'bpl/mods/time_remaining.php';
require_once 'bpl/mods/table_daily_interest.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Ajax\Ajaxer\Table_Fixed_Daily\main as ajax_table_fixed_daily;
use function BPL\Mods\Table_Daily_Interest\main as table_daily;
use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	page_validate();

	$str = menu();

	try {
		$str .= fixed_daily(session_get('user_id'));
	} catch (Exception $e) {
	}

	echo $str;
}

/**
 * @throws Exception
 *
 * @since version
 */
function fixed_daily($user_id): string
{
	$settings_plans = settings('plans');
	$settings_entry = settings('entry');

	$user = user($user_id);

	$str = css_tbl_fixed_daily();

	$account_type = $user->account_type;

	$header = $settings_plans->fixed_daily_name . ' (' . $settings_entry->{$account_type . '_package_name'} . ' Plan)';
	$wallet_link = sef(18);
	$header .= '<span style="float: right; font-size: x-large; font-weight: bold"><span style="float: right">';
	$header .= '<a href="' . $wallet_link . '" class="uk-button uk-button-primary">Wallet</a></span></span>';

	$settings_investment = settings('investment');

	$user = user($user_id);

	$principal = $settings_investment->{$account_type . '_fixed_daily_principal'};
	$interval = $settings_investment->{$account_type . '_fixed_daily_interval'};
	$maturity = $settings_investment->{$account_type . '_fixed_daily_maturity'};

	$user_fixed_daily = user_fixed_daily($user_id);

	$starting_value = number_format($principal, 8);
	$current_value = number_format($user_fixed_daily->value_last, 8);
	$maturity_date = date('F d, Y', ($user->date_activated + $maturity * 86400));
	$status = time_remaining($user_fixed_daily->day, $user_fixed_daily->processing, $interval, $maturity);

	$efund_name = settings('ancillaries')->efund_name;

	$remaining = ($user_fixed_daily->processing + $maturity - $user_fixed_daily->day) * $interval;
	$remain_maturity = ($maturity - $user_fixed_daily->day) * $interval;

	$type_day = '';

	if ($remaining > $maturity && $user_fixed_daily->processing) {
		$type_day = 'Days for Processing: ';
	} elseif ($remain_maturity > 0) {
		$type_day = 'Days Remaining: ';
	}

	$str .= <<<HTML
		<h2>$header</h2>
		<div class="card-container" id="table_fixed_daily">
			<div class="card">
				<div class="card-header">Initial</div>
				<div class="card-content">$starting_value $efund_name</div>
			</div>
			<div class="card">
				<div class="card-header">Accumulated</div>
				<div class="card-content">$current_value $efund_name</div>
			</div>
			<div class="card">
				<div class="card-header">Running Days</div>
				<div class="card-content">$user_fixed_daily->day</div>
			</div>
			<div class="card">
				<div class="card-header">Maturity Date ($maturity days)</div>
				<div class="card-content">$maturity_date</div>
			</div>
			<div class="card">
				<div class="card-header">Status</div>
				<div class="card-content" style="color: green;">{$type_day}$status</div>
			</div>
		</div>
	HTML;

	$str .= ajax_table_fixed_daily($user_id);

	return $str;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_fixed_daily($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fixed_daily ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @throws Exception
 *
 * @since version
 */
function table_fixed_daily($user_id): string
{
	$settings_investment = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;

	//	$entry    = settings('entry')->{$account_type . '_entry'};
	$principal = $settings_investment->{$account_type . '_fixed_daily_principal'};
	$interval = $settings_investment->{$account_type . '_fixed_daily_interval'};
	$maturity = $settings_investment->{$account_type . '_fixed_daily_maturity'};

	$user_fixed_daily = user_fixed_daily($user_id);

	return table_daily(
		$principal,
		$user->date_activated,
		$user_fixed_daily->value_last,
		$user_fixed_daily->day,
		$user_fixed_daily->processing,
		$maturity,
		$interval
	);
}

function css_tbl_fixed_daily()
{
	$str = <<<CSS
		<style>
			.card-container {
				display: flex;
				flex-wrap: wrap;
				gap: 10px;
				padding: 10px;
			}

			.card {
				flex: 1 1 calc(50% - 20px); /* Two cards per row on mobile */
				box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
				border-radius: 8px;
				overflow: hidden;
				background-color: #fff;
				transition: transform 0.2s;
			}

			.card:hover {
				transform: translateY(-5px);
			}

			.card-header {
				padding: 10px;
				background-color: #f8f9fa;
				font-weight: bold;
				border-bottom: 1px solid #ddd;
			}

			.card-content {
				padding: 10px;
				font-size: 14px;
			}

			/* Responsive adjustments */
			@media (min-width: 768px) {
				.card {
					flex: 1 1 calc(33.333% - 20px); /* Three cards per row on tablets */
				}
			}

			@media (min-width: 1024px) {
				.card {
					flex: 1 1 calc(20% - 20px); /* Five cards per row on desktops */
				}
			}
		</style>
	CSS;

	return $str;
}