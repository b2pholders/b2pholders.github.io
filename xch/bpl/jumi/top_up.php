<?php

namespace BPL\Jumi\Top_Up;

require_once 'bpl/ajax/ajaxer/top_up_input.php';
require_once 'bpl/ajax/ajaxer/top_up.php';
require_once 'bpl/ajax/ajaxer/table_top_up.php';
require_once 'bpl/mods/time_remaining.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use DateInterval;
use DateTime;

use function BPL\Ajax\Ajaxer\Top_Up_Input\main as top_up_input;
use function BPL\Ajax\Ajaxer\Top_Up\main as ajax_top_up;
use function BPL\Ajax\Ajaxer\Table_Top_Up\main as ajax_table_top_up;

use function BPL\Mods\Time_Remaining\main as time_remaining;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\input_get;
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

	page_validate();

	$str = menu();

	$page = substr(input_get('page'), 0, 3);

	$str .= view_top_up($user_id, $page);

	echo $str;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function user_top_up($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = ' . $db->quote($user_id)
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
function view_top_up($user_id, $page): string
{
	$top_up_name = settings('plans')->top_up_name;

	$top_ups = user_top_up($user_id);

	$value_last = 0;

	if (!empty($top_ups))
	{
		foreach ($top_ups as $top_up)
		{
			$value_last += $top_up->value_last;
		}
	}

	$user = user($user_id);

	$sa = settings('ancillaries');

	$currency = $sa->currency;

	$str = '';

	if ($user->account_type !== 'starter')
	{
		$str .= '<h2>' . settings('entry')->{$user->account_type . '_package_name'} . ' ' .
			$top_up_name . '<span style="float: right; font-size: x-large; font-weight: bold">
            <span style="color: green">' . $sa->efund_name . ' Balance: </span><span
                        class="usd_bal_now_user">' .
			number_format($user->payout_transfer, 2) . ' ' . $currency .
			'</span></h2>
        <div class="table-responsive">
            <table class="category table table-bordered table-hover">
                <tr>
                    <td rowspan="3" style="text-align: center; width: 33%; vertical-align: middle">
                        <strong style="font-size: x-large"><span style="color: #006600">Shares:</span> <span
                                    class="top_up_value_last">' . number_format(
				$value_last, 2) . '</span>' . ' ' . $currency .
			'</strong>
                    </td>
                    <td colspan="2" style="text-align: center; vertical-align: middle" height="21px">
                        <div style="text-align: center">
                        	<span style="font-size: medium;
                        color: #006600;
                        text-align: center;
                        vertical-align: middle;"
                              class="success_top_up"></span>
                            <span style="font-size: medium;
                        color: red;
                        text-align: center;
                        vertical-align: middle;"
                                  class="error_top_up"></span>
                            <span style="font-size: medium;
                        color: orangered;
                        text-align: center;
                        vertical-align: middle;"
                                  class="debug_top_up"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; vertical-align: middle">
                        <div>
                            <strong><label>
                                    <input type="text"
                                           id="top_up_input"
                                           style="font-size: x-large;
                                              text-align: center;
                                              vertical-align: middle;">
                                </label></strong>
                            <br>
                            <strong><label>
                                    <input type="button"
                                           value="' . $top_up_name . '"
                                           class="uk-button uk-button-primary"
                                           id="top_up"
                                           style="font-size: large;
                                       text-align: center;
                                       vertical-align: middle;
                                       <?php /* * ?>float: right<?php /* */ ?>">
                                </label></strong>
                        </div>
                    </td>
                    <td style="text-align: center; vertical-align: middle" id="digital-trading">
                        <strong style="font-size: xx-large; color: #006600"><strong style="font-size: x-large">
                                Value: <span style="color: #444444"
                                             class="top_up_principal">' .
			number_format($user->top_up_principal, 2) . ' ' . $currency . '</span></strong>
                        </strong>
                    </td>
                </tr>
            </table>
        </div>';

		$str .= '<div class="table-responsive" id="table_top_up">' . view_table_top_up($user_id, $page) . '</div>';

		$str .= top_up_input($user_id);
		$str .= ajax_top_up($user_id);
		$str .= ajax_table_top_up($user_id);
	}

	return $str;
}

/**
 * @param $user_id
 * @param $page
 * @param $limit_to
 *
 *
 * @return array|mixed
 * @since version
 */
function user_top_up_limit($user_id, $page, $limit_to)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		' ORDER BY id DESC ' .
		'LIMIT ' . ($limit_to * $page) . ', ' . $limit_to
	)->loadObjectList();
}

/**
 * @param        $user_id
 * @param        $page
 * @param   int  $limit_to
 *
 * @return string
 *
 * @since version
 */
function view_table_top_up($user_id, $page, int $limit_to = 3): string
{
	$page = ($page !== '') ? $page : 0;

	$total = count(user_top_up($user_id));

	$last_page = ($total - $total % $limit_to) / $limit_to;

	$currency = settings('ancillaries')->currency;

	$settings_investment = settings('investment');

	$account_type = user($user_id)->account_type;

	$maturity = $settings_investment->{$account_type . '_top_up_maturity'};

	$results = user_top_up_limit($user_id, $page, $limit_to);

	$str = '';

	if (!empty($results))
	{
		$str .= '<div class="uk-panel uk-panel-box tm-panel-line">';

		if ($total > ($limit_to * $page + $limit_to))
		{
			if ($page !== $last_page)
			{
				$str .= '<span style="float: right"><a href="' . sef(103) . qs() . 'page=' . ($last_page) .
					'" class="uk-button uk-button-primary">Oldest</a></span>';
			}

			$str .= '<span style="float: right"><a href="' . sef(103) . qs() . 'page=' . ($page + 1) .
				'" class="uk-button uk-button-success">Previous</a></span>';
		}

		if ($page > 0 && $page)
		{
			$str .= '<span style="float: right"><a href="' . sef(103) . qs() . 'page=' . ($page - 1) .
				'" class="uk-button uk-button-primary">Next</a></span>';

			if ((int) $page !== 1)
			{
				$str .= '<span style="float: right"><a href="' . sef(103) . qs() . 'page=' . (1) .
					'" class="uk-button uk-button-success">Latest</a></span>';
			}
		}

		$str .= '<span style="float: left"><a href="' . sef(104) . '" class="uk-button uk-button-success">Deposit</a></span>';

		$str .= '<table class="category table table-striped table-bordered table-hover">' .
			'<thead>
                <tr>
                    <th>Starting Value (' . $currency . ')</th>
                    <th>Current Value (' . $currency . ')</th>
                    <th>Running Days</th>
                    <th>Maturity Date (' . $maturity . ' Days)</th>
                    <th>Status</th>     
                </tr>
            </thead>
            <tbody>';

		foreach ($results as $result)
		{
			try
			{
				$start = new DateTime('@' . $result->date_entry);
				$end   = new DateInterval('P' . $maturity . 'D');
				$start->add($end);

				$str .= '<tr>';
				$str .= '<td>' . number_format($result->principal, 2) . '</td>
                <td>' . number_format($result->value_last, 2) . '</td>
                <td>' . $result->day . '</td>
                <td>' . $start->format('F d, Y') . '</td>
                <td>' . time_remaining(
						$result->day,
						$result->processing,
						$settings_investment->{$account_type . '_top_up_interval'},
						$maturity
					) . '</td></tr>';
			}
			catch (Exception $e)
			{

			}
		}

		$str .= '</tbody>
        </table>
    </div>';
	}

	return $str;
}