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

	//	$currency = settings('ancillaries')->currency;

	$efund_name = settings('ancillaries')->efund_name;

	// $settings_entry = settings('entry');

	$settings_investment = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;
	// $date_activated = $user->date_activated;

	//	$entry    = $settings_entry->{$account_type . '_entry'};
	$principal = $settings_investment->{$account_type . '_fixed_daily_principal'};
	$interval = $settings_investment->{$account_type . '_fixed_daily_interval'};
	$maturity = $settings_investment->{$account_type . '_fixed_daily_maturity'};

	$user_fixed_daily = user_fixed_daily($user_id);

	// $value_last = $user_fixed_daily->value_last;
	// $day        = $user_fixed_daily->day;
	// $processing = $user_fixed_daily->processing;

	// $output .= '<div class="uk-panel uk-panel-box tm-panel-line">';
	// $output .= '<table class="category table table-striped table-bordered table-hover">
	//         <thead>
	//             <tr>
	//                 <th>IMO</th>
	//                 <th>CTO</th>
	//                 <th>Running Days</th>
	//                 <th>Maturity (' . $maturity . ' Days)</th>
	//                 <th>Status</th>     
	//             </tr>
	//         </thead>
	//         <tbody>';
	// $output .= '<tr>';
	// $output .= '<td>' . number_format($principal, 8) . ' ' . $efund_name . '</td>
	//             <td>' . number_format($value_last, 8) . ' ' . $efund_name . '</td>
	//             <td>' . $day . '</td>
	//             <td>' . date('F d, Y', ($date_activated + $maturity * 86400)) . '</td>
	//             <td>' . time_remaining($day, $processing, $interval, $maturity) . '</td>
	//         </tr>';
	// $output .= '</tbody>
	//     </table>
	// </div>';

	$starting_value = number_format($principal, 8);
	$current_value = number_format($user_fixed_daily->value_last, 8);
	$maturity_date = date('F d, Y', ($user->date_activated + $maturity * 86400));
	$status = time_remaining($user_fixed_daily->day, $user_fixed_daily->processing, $interval, $maturity);

	$remaining = ($user_fixed_daily->processing + $maturity - $user_fixed_daily->day) * $interval;
	$remain_maturity = ($maturity - $user_fixed_daily->day) * $interval;

	$type_day = '';

	if ($remaining > $maturity && $user_fixed_daily->processing) {
		$type_day = 'Processing Days:';
	} elseif ($remain_maturity > 0) {
		$type_day = 'Remaining Days:';
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
			<div class="card-header">Maturity Days (300)</div>
			<div class="card-content">Date: $maturity_date</div>
		</div>
		<div class="card">
			<div class="card-header">Status</div>
			<div class="card-content" style="color: green;">$type_day $status</div>
		</div>
	HTML;

	echo $output;
}