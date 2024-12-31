<?php

namespace BPL\Jumi\fast_track;

require_once 'bpl/ajax/ajaxer/fast_track_input.php';
require_once 'bpl/ajax/ajaxer/fast_track.php';
require_once 'bpl/mods/time_remaining.php';
require_once 'bpl/ajax/ajaxer/table_fast_track.php';
require_once 'bpl/mods/time_remaining.php';
require_once 'bpl/mods/table_daily_interest.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use DateTime;
use DateInterval;

use function BPL\Ajax\Ajaxer\Fast_Track_Input\main as fast_track_input;
use function BPL\Ajax\Ajaxer\Fast_Track\main as ajax_fast_track;
use function BPL\Ajax\Ajaxer\Table_Fast_Track\main as ajax_table_fast_track;
use function BPL\Mods\Time_Remaining\main as time_remaining;
use function BPL\Mods\Table_Daily_Interest\tbody;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
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
    $user_id = session_get('user_id');
    $page = substr(input_get('page'), 0, 3);

    page_validate();

    $str = menu();

    $str .= fast_track($user_id, $page);

    echo $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_fast_track($user_id)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_fast_track ' .
        'WHERE user_id = ' . $db->quote($user_id)
    )->loadObjectList();
}

/**
 * @param $user_id
 * @param $limit_from
 * @param $limit_to
 *
 * @return array|mixed
 *
 * @since version
 */
function user_fast_track_limit($user_id, $limit_from, $limit_to)
{
    $db = db();

    return $db->setQuery(
        'SELECT * ' .
        'FROM network_fast_track ' .
        'WHERE user_id = ' . $db->quote($user_id) .
        ' ORDER BY fast_track_id DESC ' .
        'LIMIT ' . $limit_from . ', ' . $limit_to
    )->loadObjectList();
}

/**
 * @param $user_id
 * @param $page
 *
 * @return string
 *
 * @since version
 */
function fast_track($user_id, $page): string
{
    $sa = settings('ancillaries');
    $se = settings('entry');
    $sp = settings('plans');

    $user_fast_track = user_fast_track($user_id);

    $value_last = 0;

    foreach ($user_fast_track as $fast_track) {
        $value_last += $fast_track->value_last;
    }

    $user = user($user_id);

	$currency = settings('ancillaries')->currency;

    $str = '';

    if ($user->account_type !== 'starter') {
        $package_name = $se->{$user->account_type . '_package_name'};

        // header and points balance
        $str .= '<h2>' . $package_name . ' ' . $sp->fast_track_name .
            '<span style="float: right; font-size: x-large; font-weight: bold">
            <span style="color: green">' . $sa->efund_name . ' Balance: '
            /*'Points: '*/ . '</span><span class="usd_bal_now_user">' .
            number_format($user->payout_transfer /*$user->points*/, 2) . ' ' . $currency .
            '</span></h2>';

        // wallet button
        $str .= !0 ? '' : '<span style="float: right; font-size: x-large; font-weight: bold"><span style="float: right">
	        <a href="' . sef(20) . '" class="uk-button uk-button-primary">Wallet</a></span></span>';

        $str .= '<div class="table-responsive">';
        $str .= '<table class="category table table-bordered table-hover">';

        // shares and notifications
        $str .= '<tr>
                    <td rowspan="3" style="text-align: center; width: 33%; vertical-align: middle">
                        <strong style="font-size: x-large"><span style="color: #006600">Shares:</span> <span
                                    class="fast_track_value_last">' . number_format(
                $value_last, 2) . '</span>' . ' ' . /*$currency .*/
            '</strong>
                    </td>
                    <td colspan="2" style="text-align: center; vertical-align: middle" height="21px">
                        <div style="text-align: center">
                        	<span style="font-size: medium;
                        color: #006600;
                        text-align: center;
                        vertical-align: middle;"
                              class="success_fast_track"></span>
                            <span style="font-size: medium;
                        color: red;
                        text-align: center;
                        vertical-align: middle;"
                                  class="error_fast_track"></span>
                            <span style="font-size: medium;
                        color: orangered;
                        text-align: center;
                        vertical-align: middle;"
                                  class="debug_fast_track"></span>
                        </div>
                    </td>
                </tr>';

        // input and current values
        $str .= '<tr>
                    <td style="text-align: center; vertical-align: middle">
                        <div>
                            <strong><label>
                                    <input type="text"
                                           id="fast_track_input"
                                           style="font-size: x-large;
                                              text-align: center;
                                              vertical-align: middle;">
                                </label></strong>
                            <br>
                            <strong><label>
                                    <input type="button"
                                           value="' . $sp->fast_track_name . '"
                                           class="uk-button uk-button-primary"
                                           id="fast_track"
                                           style="font-size: large;
                                       text-align: center;
                                       vertical-align: middle;">
                                </label></strong>
                        </div>
                    </td>
                    <td style="text-align: center; vertical-align: middle" id="digital-trading">
                        <strong style="font-size: xx-large; color: #006600"><strong style="font-size: x-large">
                                Value: <span style="color: #444444"
                                             class="fast_track_principal">' . number_format(
                $user->fast_track_principal, 2) . ' ' . /*$currency .*/
            '</span></strong>
                        </strong>
                    </td>
                </tr>';

        $str .= '</table>';
        $str .= '</div>';

        // tracker
        $str .= '<div class="table-responsive" id="table_fast_track">' . table_fast_track($user_id, $page) . '</div>';

        $str .= fast_track_input($user_id);
        $str .= ajax_fast_track($user_id);
        $str .= ajax_table_fast_track($user_id);
    }

    return $str;
}

/**
 * @param        $user_id
 * @param        $page
 * @param int $limit_to
 *
 * @return string
 *
 * @since version
 */
function table_fast_track($user_id, $page, int $limit_to = 3): string
{
    $page = ($page !== '') ? $page : 0;

    $limit_from = $limit_to * $page;

    $total = count(user_fast_track($user_id));

    $last_page = ($total - $total % $limit_to) / $limit_to;

//	$currency = settings('ancillaries')->currency;

    $settings_investment = settings('investment');

    $account_type = user($user_id)->account_type;

    $interval = $settings_investment->{$account_type . '_fast_track_interval'};
    $maturity = $settings_investment->{$account_type . '_fast_track_maturity'};

    $results = user_fast_track_limit($user_id, $limit_from, $limit_to);

    $str = '';

    if (!empty($results)) {
        $str .= '<div class="uk-panel uk-panel-box tm-panel-line">';

        if ($total > ($limit_from + $limit_to)) {
            if ((int)$page !== (int)$last_page) {
                $str .= '<span style="float: right"><a href="' . sef(19) . qs() . 'page=' . ($last_page) .
                    '" class="uk-button uk-button-primary">Oldest</a></span>';
            }

            $str .= '<span style="float: right"><a href="' . sef(19) . qs() . 'page=' . ($page + 1) .
                '" class="uk-button uk-button-success">Previous</a></span>';
        }

        if ($page > 0 && $page) {
            $str .= '<span style="float: right"><a href="' . sef(19) . qs() . 'page=' . ($page - 1) .
                '" class="uk-button uk-button-primary">Next</a></span>';

            if ((int)$page !== 1) {
                $str .= '<span style="float: right"><a href="' . sef(19) . qs() . 'page=' . (1) .
                    '" class="uk-button uk-button-success">Latest</a></span>';
            }
        }

//		$str .= '<span style="float: left"><a href="' . sef(20) . '" class="uk-button uk-button-success">Deposit</a></span>';

        $str .= '<table class="category table table-striped table-bordered table-hover">' .
            '<thead>
                <tr>
                    <th>Contract</th>
                    <th>Reward</th>
                    <th>Days</th>
                    <th>Maturity (' . $maturity . ' Days)</th>
                    <th>Status</th>     
                </tr>
            </thead>
            <tbody>';

        foreach ($results as $result) {
            try {
                $start = new DateTime('@' . $result->date_entry);
                $end = new DateInterval('P' . $maturity . 'D');

                $start->add($end);

                $starting_value = number_format($result->principal, 2);
                $current_value = number_format($result->value_last, 2);
                $maturity_date = $start->format('F d, Y');
                $status = time_remaining($result->day, $result->processing, $interval, $maturity);

                $str .= tbody($starting_value, $current_value, $result->day, $maturity_date, $status);
            } catch (Exception $e) {
            }
        }

        $str .= '</tbody>
        </table>
    </div>';
    }

    return $str;
}