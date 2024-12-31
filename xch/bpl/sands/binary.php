<?php

namespace Onewayhi\Sands\Binary\Package;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/mods/url_sef.php';

use \Joomla\CMS\Factory;
//use \Joomla\CMS\Uri\Uri;

use function \Onewayhi\Database\Query\insert;
use function \Onewayhi\Database\Query\update;
use function \Onewayhi\Commission_Deduct\Filter\main as cd_filter;

use function \Onewayhi\Url\SEF\sef;
use function \Onewayhi\Url\SEF\qs;

function main($upline, $position, $code_type, $insert_id, $username)
{
	//$redirect = Factory::getApplication();
	$db       = Factory::getDbo();

	$settings_plans = $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_plans'
	)->loadObject();

	$settings_ancillaries = $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_ancillaries'
	)->loadObject();

	$currency = $settings_ancillaries->currency;

	$settings_entry = $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_entry'
	)->loadObject();

	$code_type_mod = $settings_entry->{$code_type . '_package_name'};

	$settings_binary = $db->setQuery(
		'SELECT * ' .
		'FROM network_settings_binary'
	)->loadObject();

	$ctr_add = $settings_binary->{$code_type . '_pairs'};

	$upline = $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($upline)
	)->loadObject();

	$tmp_upline_id         = $upline->id;
	$tmp_pairs             = $upline->pairs;
	$tmp_income_cycle      = $upline->income_cycle;
	$tmp_username          = $upline->username;
	$tmp_account_type      = $upline->account_type;
	$tmp_ctr_right         = $upline->ctr_right;
	$tmp_ctr_left          = $upline->ctr_left;
	$tmp_pairs_today       = $upline->pairs_today;
	$tmp_pairs_today_total = $upline->pairs_today_total;
	$tmp_sponsor_id        = $upline->sponsor_id;
	$tmp_max_cycle         = $settings_binary->{$tmp_account_type . '_max_cycle'};
	$tmp_pairs_safety      = $settings_binary->{$tmp_account_type . '_pairs_safety'};
	$tmp_max_pairs         = $settings_binary->{$tmp_account_type . '_max_pairs'};
	$tmp_binary_sponsored  = $settings_binary->{$tmp_account_type . '_binary_sponsored'};

	$tmp_sponsored = count(
		$db->setQuery(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE account_type <> ' . $db->quote('starter') .
			' AND sponsor_id = ' . $db->quote($upline->upline_id)
		)->loadObjectList()
	);

	while ($tmp_upline_id > 0)
	{
		// add pair point(s)
		if (abs($tmp_ctr_left - $tmp_ctr_right))
		{
			// max pairable
			$max_pairs_add = abs($tmp_ctr_left - $tmp_ctr_right);

			// max countable pairs
			$open_pairs        = $tmp_max_cycle - $tmp_pairs_today;
			$open_pairs        = $open_pairs < 0 ? 0 : $open_pairs;
			$max_pairs_limited = $max_pairs_add < $open_pairs ? $max_pairs_add : $open_pairs;

			// limited pairs add
			$pairs_add_limited = $ctr_add < $max_pairs_limited ? $ctr_add : $max_pairs_limited;

			// actual pairs
			$pairs_add_actual = $ctr_add < $max_pairs_add ? $max_pairs_add : $ctr_add;

			// nth pair
			$old = $tmp_pairs - $tmp_pairs % $tmp_pairs_safety;
			$new = $tmp_pairs + $pairs_add_limited - ($tmp_pairs + $pairs_add_limited) % $tmp_pairs_safety;

			$nth_pair = ((+(($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle && $tmp_pairs_safety > 0)
				) * ($new - $old) / $tmp_pairs_safety);

			// flushout
			$flushout  = 0;
			$tmp_maxed = '';

			if (($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle)
			{
				$tmp_add_limited = abs($pairs_add_limited - $nth_pair);
			}
			else
			{
				$tmp_add_limited = 0;
				$flushout        = $pairs_add_limited;
				$tmp_maxed       = '1';
			}

			$tmp_add_limited = cd_filter($tmp_upline_id, $tmp_add_limited);

			// add pair point(s), counters, update downline

			$fields = [
				'income_cycle = income_cycle + ' . $tmp_add_limited,
				'income_day = income_day + ' . $tmp_add_limited,
				'payout_transfer = payout_transfer + ' .
				((($tmp_income_cycle + $tmp_add_limited) >= $tmp_max_pairs)
				&& ($tmp_sponsored >= $tmp_binary_sponsored) ? $tmp_add_limited : 0),
				'income_week = income_week + ' . $tmp_add_limited,

				'pairs_5th = pairs_5th + ' . $nth_pair,
				'income_giftcheck = income_giftcheck + ' . $nth_pair,
				'points = points + ' . $nth_pair,
				'pairs = pairs + ' . $pairs_add_limited,

				'income_flushout = income_flushout + ' . $flushout,
				'pairs_today = pairs_today + ' . $pairs_add_limited,
				'pairs_today_total = pairs_today_total + ' . $pairs_add_actual,

				($position == 'Left' ? 'ctr_left = ctr_left' : 'ctr_right = ctr_right') . ' + ' . $ctr_add
			];

			$binary = update(
				'network_users',
				$fields,
				['id = ' . $db->quote($tmp_upline_id)]
			);

			if ($binary)
			{
				// add activity
				if ($pairs_add_actual > 0 || $nth_pair > 0)
				{
					$activity = '<b>' . $settings_plans->binary_pair_name . ': </b> <a href="' . sef(44) . qs() .
						'uid=' . $upline->id . '">' . $upline->username . '</a> gained ' . $pairs_add_actual .
						' pts. from the ' . ($settings_ancillaries->payment_mode == 'CODE' ? 'registration' : 'activation') .
						' of	<a href="' . sef(44) . qs() . 'uid=' . $insert_id . '">' . $username .
						'</a> (' . $code_type_mod . ') . <br>Points added: ' . ' ' . number_format($tmp_add_limited) .
						'.<br>Current account type: ' . $settings_entry->{$upline->account_type . '_package_name'} . '.';

					$activity .= $nth_pair > 0 ? '<br>point rewards added from 5th pairs: ' .
						number_format($nth_pair) : '';
				}
				else
				{
					$activity = '<b>Points added </b> to <a href="' . sef(44) . qs() . 'uid=' . $tmp_upline_id . '">' .
						$tmp_username . '</a> from the ' . ($settings_ancillaries->payment_mode == 'CODE' ? 'registration' :
							'activation') . ' of <a href="' . sef(44) . qs() . 'uid=' . $insert_id . '">' .
						$username . '</a> (' . $code_type_mod . '). <br>';

					$activity .= 'Group ' . ($position == 'Left' ? 'A' : 'B') . ': + ' . $currency . ' ' . $ctr_add;
				}

				$activity .= $tmp_maxed == '1' ? '<br>Reached max pairs per day.' : '';
				$activity .= $pairs_add_actual > $pairs_add_limited ? '<br>Flush out: ' .
					($pairs_add_actual - $pairs_add_limited) . ' pts.' : '';

				insert(
					'network_activity',
					[
						'user_id',
						'sponsor_id',
						'upline_id',
						'activity',
						'activity_date'
					],
					[
						$db->quote($tmp_upline_id),
						$db->quote($tmp_sponsor_id),
						$db->quote($tmp_upline_id),
						$db->quote($activity),
						$db->quote(time())
					]
				);
			}
			else
			{
				//$redirect->redirect(Uri::root(true) . '/' . sef(10), 'Binary process terminated!', 'error');

				return false;
				break;
			}
		}
		else
		{
			// no pairing/matching, just add to ctr_
			// add pair point(s), counters, update downline

			$no_pair = update(
				'network_users',
				[($position == 'Left' ? 'ctr_left = ctr_left' : 'ctr_right = ctr_right') . ' + ' . $ctr_add],
				['id = ' . $db->quote($tmp_upline_id)]
			);

			if ($no_pair)
			{
				$activity = '<b>Points added </b> to <a href="' . sef(44) . qs() . 'uid=' . $tmp_upline_id . '">' .
					$tmp_username . '</a> for the ' . ($settings_ancillaries->payment_mode == 'CODE' ? 'registration' :
						'activation') . ' of <a href="' . sef(44) . qs() . 'uid=' . $insert_id .
					'">' . $username . '</a> (' . $code_type_mod . ').';
				$activity .= '<br>Group ' . ($position == 'Left' ? 'A' : 'B') . ': + ' . $currency . ' ' . $ctr_add;

				insert(
					'network_activity',
					[
						'user_id',
						'sponsor_id',
						'upline_id',
						'activity',
						'activity_date'
					],
					[
						$db->quote($tmp_upline_id),
						$db->quote($tmp_sponsor_id),
						$db->quote($tmp_upline_id),
						$db->quote($activity),
						$db->quote(time())
					]
				);
			}
			else
			{
				//$redirect->redirect(Uri::root(true) . '/' . sef(10), 'Binary process terminated!', 'error');

				return false;
				break;
			}
		}

		$position      = $upline->position;
		$tmp_upline_id = $upline->upline_id;

		$upline = $db->setQuery(
			'SELECT * ' .
			'FROM network_users ' .
			'WHERE id = ' . $db->quote($tmp_upline_id)
		)->loadObject();

		$tmp_pairs             = $upline->pairs;
		$tmp_username          = $upline->username;
		$tmp_account_type      = $upline->account_type;
		$tmp_ctr_right         = $upline->ctr_right;
		$tmp_ctr_left          = $upline->ctr_left;
		$tmp_pairs_today       = $upline->pairs_today;
		$tmp_pairs_today_total = $upline->pairs_today_total;
		$tmp_sponsor_id        = $upline->sponsor_id;
		$tmp_max_cycle         = $settings_binary->{$tmp_account_type . '_max_cycle'};
		$tmp_pairs_safety      = $settings_binary->{$tmp_account_type . '_pairs_safety'};
		$tmp_max_pairs         = $settings_binary->{$tmp_account_type . '_max_pairs'};
		$tmp_binary_sponsored  = $settings_binary->{$tmp_account_type . '_binary_sponsored'};

		$tmp_sponsored = count(
			$db->setQuery(
				'SELECT * ' .
				'FROM network_users ' .
				'WHERE account_type <> ' . $db->quote('starter') .
				' AND sponsor_id = ' . $db->quote($tmp_upline_id)
			)->loadObjectList()
		);
	}

	//$redirect->redirect(Uri::root(true) . '/' . sef(10), 'Binary process ended!', 'error');

	return true;
}