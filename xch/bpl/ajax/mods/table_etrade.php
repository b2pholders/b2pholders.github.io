<?php

namespace BPL\Ajax\Mods\Table_Etrade;

use Exception;

use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Local\Database\Query\fetch;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

try
{
	main($user_id);
}
catch (Exception $e)
{
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

	$settings_investment = settings('investment');

	$currency = settings('ancillaries')->currency;

	$user = user($user_id);

	$account_type = $user->account_type;

	$maturity = $settings_investment->{$account_type . '_maturity'};

	$user_compound = user_compound($user_id);

	$day = $user_compound->day;

	$output .= '<div class="uk-panel uk-panel-box tm-panel-line">';
	$output .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Starting Value (' . $currency . ')</th>
                    <th>Current Value (' . $currency . ')</th>
                    <th>Running Days</th>
                    <th>Maturity Date (' . $maturity . ' Days)</th>
                    <th>Status</th>     
                </tr>
            </thead>
            <tbody>';
	$output .= '<tr>';
	$output .= '<td>' . number_format(settings('entry')->{$account_type . '_entry'}, 2) . '</td>
                <td>' . number_format($user_compound->value_last, 2) . '</td>
                <td>' . $day . '</td>
                <td>' . date('F d, Y', ($user->date_activated + $maturity * 86400)) . '</td>
                <td>' .
		time_remaining($day, $user_compound->processing, $settings_investment
			->{$account_type . '_interval'}, $maturity) .
		'</td>
            </tr>';
	$output .= '</tbody>
        </table>
    </div>';

	echo $output;
}

/**
 * @param $user_id
 *
 * @return mixed
 *
 * @since version
 */
function user_compound($user_id)
{
	return fetch(
		'SELECT * ' .
		'FROM network_compound ' .
		'WHERE user_id = :user_id',
		['user_id' => $user_id]
	);
}