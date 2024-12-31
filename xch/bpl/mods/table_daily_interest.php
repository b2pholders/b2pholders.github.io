<?php

namespace BPL\Mods\Table_Daily_Interest;

require_once 'bpl/mods/time_remaining.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Helpers\settings;

/**
 * @param $value_last
 * @param $day
 * @param $processing
 * @param $entry
 * @param $date_activated
 * @param $maturity
 * @param $interval
 *
 * @return string
 *
 * @throws Exception
 * @since version
 */
function main($entry, $date_activated, $value_last, $day, $processing, $maturity, $interval): string
{
	$starting_value = number_format($entry, 8);
	$current_value  = number_format($value_last, 8);
	$maturity_date  = date('F d, Y', ($date_activated + $maturity * 86400));
	$status         = time_remaining($day, $processing, $interval, $maturity);

	$str = '<div class="uk-panel uk-panel-box tm-panel-line">';

	$str .= table($starting_value, $current_value, $day, $maturity, $maturity_date, $status);

	return $str;
}

/**
 * @param           $starting_value
 * @param           $current_value
 * @param           $day
 * @param           $maturity
 * @param           $maturity_date
 * @param           $status
 *
 * @return string
 *
 * @since version
 */
function table($starting_value, $current_value, $day, $maturity, $maturity_date, $status): string
{
//	$currency = settings('ancillaries')->currency;

	$efund_name = settings('ancillaries')->efund_name;

	$str = '<table class="category table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>IMO</th>
                    <th>CTO</th>
                    <th>Running Days</th>
                    <th>Maturity (' . $maturity . ' Days)</th>
                    <th>Status</th>     
                </tr>
            </thead>
            <tbody>';

	$str .= '<tr>';
	$str .= '<td>' . $starting_value . ' ' . $efund_name . '</td>
                <td>' . $current_value . ' ' . $efund_name . '</td>
                <td>' . $day . '</td>
                <td>' . $maturity_date . '</td>
                <td>' . $status . '</td>
            </tr>';

	$str .= '</tbody>
        </table>
    </div>';

	return $str;
}

/**
 * @param $starting_value
 * @param $current_value
 * @param $day
 * @param $maturity_date
 * @param $status
 *
 * @return string
 *
 * @since version
 */
function tbody($starting_value, $current_value, $day, $maturity_date, $status): string
{
//	$efund_name = settings('ancillaries')->efund_name;

	$str = '<tr>';
	$str .= '<td>' . $starting_value . ' ' . /*$efund_name .*/ '</td>
                <td>' . $current_value . ' ' . /*$efund_name .*/ '</td>
                <td>' . $day . '</td>
                <td>' . $maturity_date . '</td>
                <td>' . $status . '</td>
            </tr>';

	return $str;
}