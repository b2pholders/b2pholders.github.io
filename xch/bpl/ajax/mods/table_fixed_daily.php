<?php

namespace BPL\Ajax\Mods\Table_Fixed_Daily;

use Exception;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

try {
	main($user_id);
} catch (Exception $e) {
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_fixed_daily($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_fixed_daily ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}

/**
 * @param $user_id
 *
 *
 * @throws Exception
 * @since version
 */
function main($user_id)
{
	$output = '';

	$efund_name = settings('ancillaries')->efund_name;

	$settings_investment = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;

	$principal = $settings_investment->{$account_type . '_fixed_daily_principal'};
	$interval = $settings_investment->{$account_type . '_fixed_daily_interval'};
	$maturity = $settings_investment->{$account_type . '_fixed_daily_maturity'};

	$user_fixed_daily = user_fixed_daily($user_id);

	$starting_value = number_format($principal, 8);
	$current_value = number_format($user_fixed_daily->value_last, 8);
	$maturity_date = date('F d, Y', ($user->date_activated + $maturity * 86400));
	$status = time_remaining($user_fixed_daily->day, $user_fixed_daily->processing, $interval, $maturity);

	$remaining = ($user_fixed_daily->processing + $maturity - $user_fixed_daily->day) * $interval;
	$remain_maturity = ($maturity - $user_fixed_daily->day) * $interval;

	$type_day = '';

	if ($remaining > $maturity && $user_fixed_daily->processing) {
		$type_day = 'Days for Processing: ';
	} elseif ($remain_maturity > 0) {
		$type_day = 'Days Remaining: ';
	}

	$output .= <<<HTML
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
	HTML;

	echo $output;
}