<?php

namespace BPL\Jumi\Fixed_Daily_Token;

require_once 'bpl/ajax/ajaxer/table_fixed_daily_token.php';
require_once 'bpl/mods/time_remaining.php';
// require_once 'bpl/mods/table_daily_interest.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Ajax\Ajaxer\Table_Fixed_Daily_Token\main as ajax_table_fixed_daily_token;
// use function BPL\Mods\Table_Daily_Interest\main as table_daily;
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
		$str .= fixed_daily_token(session_get('user_id'));
	} catch (Exception $e) {
	}

	echo $str;
}

/**
 * @throws Exception
 *
 * @since version
 */
function fixed_daily_token($user_id): string
{
	$sp = settings('plans');
	$se = settings('entry');

	$user = user($user_id);

	$str = css_tbl_fixed_daily_token();

	$account_type = $user->account_type;

	// $header = $sp->fixed_daily_token_name . ' (' . $se->{$account_type . '_package_name'} . ' Plan)';
	// $wallet_link = sef(152);
	// $header .= '<span style="float: right; font-size: x-large; font-weight: bold"><span style="float: right">';
	// $header .= '<a href="' . $wallet_link . '" class="uk-button uk-button-primary">Wallet</a></span></span>';

	$header = $sp->fixed_daily_token_name . ' (' . $se->{$account_type . '_package_name'} . ' Plan)';
	$wallet_link = sef(152);
	$header .= '<div class="clearfix" style="padding-top: 5px">'; // Added clearfix container
	$header .= '<a href="' . $wallet_link . '" class="btn btn-primary pull-right">Wallet</a>';
	$header .= '</div>';

	$si = settings('investment');

	$user = user($user_id);

	$principal = $si->{$account_type . '_fixed_daily_token_principal'};
	$interval = $si->{$account_type . '_fixed_daily_token_interval'};
	$maturity = $si->{$account_type . '_fixed_daily_token_maturity'};

	$ufdt = user_fixed_daily_token($user_id);

	$starting_value = number_format($principal, 8);
	$current_value = number_format($ufdt->value_last, 8);
	$maturity_date = date('F d, Y', ($user->date_activated + $maturity * 86400));
	$status = time_remaining($ufdt->day, $ufdt->processing, $interval, $maturity);

	$efund_name = /* settings('ancillaries')->efund_name */ 'B2P';

	$remaining = ($ufdt->processing + $maturity - $ufdt->day) * $interval;
	$remain_maturity = ($maturity - $ufdt->day) * $interval;

	$type_day = '';

	if ($remaining > $maturity && $ufdt->processing) {
		$type_day = 'Days for Processing: ';
	} elseif ($remain_maturity > 0) {
		$type_day = 'Days Remaining: ';
	}

	$str .= <<<HTML
		<h2>$header</h2>
		<div class="card-container" id="table_fixed_daily_token">
			<div class="card">
				<div class="card-header">Initial Support Token</div>
				<div class="card-content">$starting_value $efund_name</div>
			</div>
			<div class="card">
				<div class="card-header">B2P Holdings</div>
				<div class="card-content">$current_value $efund_name</div>
			</div>
			<div class="card">
				<div class="card-header">Running Days</div>
				<div class="card-content">$ufdt->day</div>
			</div>
			<div class="card">
				<div class="card-header">Expiry Date ($maturity days)</div>
				<div class="card-content">$maturity_date</div>
			</div>
			<div class="card">
				<div class="card-header">Status</div>
				<div class="card-content" style="color: green;">{$type_day}$status</div>
			</div>			
		</div>

		<div class="card-container">
			<div class="card">
				<div class="card-header">Native Token</div>
				<div class="item-wrapper">
					<iframe width="100%" height="192" frameBorder="0" scrolling="no"
						src="https://coinbrain.com/embed/converter/bnb-0xF8AB9fF465C612D5bE6A56716AdF95c52f8Bc72d/usd?theme=light&padding=16&layout=vertical"></iframe>
				</div>
			</div>
			<div class="card">
				<div class="card-header">Primary Token</div>
				<div class="item-wrapper">
					<iframe width="100%" height="192" frameBorder="0" scrolling="no"
						src="https://coinbrain.com/coins/bnb-0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c/ticker?theme=light&padding=16&type=medium&currency=USD&blocks=price%2CmarketCap%2Cvolume24h"></iframe>
				</div>
			</div>
		</div>

		<div class="card-container">
			<div class="card">
				<iframe width="100%" height="640" frameBorder="0" scrolling="no" src="https://coinbrain.com/embed/bnb-0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c?theme=light&padding=16&chart=1&trades=1"></iframe>
			</div>
		</div>
	HTML;

	$str .= ajax_table_fixed_daily_token($user_id);

	return $str;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_fixed_daily_token($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fixed_daily_token ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

// /**
//  * @throws Exception
//  *
//  * @since version
//  */
// function table_fixed_daily($user_id): string
// {
// 	$settings_investment = settings('investment');

// 	$user = user($user_id);

// 	$account_type = $user->account_type;

// 	//	$entry    = settings('entry')->{$account_type . '_entry'};
// 	$principal = $settings_investment->{$account_type . '_fixed_daily_principal'};
// 	$interval = $settings_investment->{$account_type . '_fixed_daily_interval'};
// 	$maturity = $settings_investment->{$account_type . '_fixed_daily_maturity'};

// 	$user_fixed_daily = user_fixed_daily_token($user_id);

// 	return table_daily(
// 		$principal,
// 		$user->date_activated,
// 		$user_fixed_daily->value_last,
// 		$user_fixed_daily->day,
// 		$user_fixed_daily->processing,
// 		$maturity,
// 		$interval
// 	);
// }

function css_tbl_fixed_daily_token()
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