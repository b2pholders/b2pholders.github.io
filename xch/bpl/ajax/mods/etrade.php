<?php

namespace BPL\Ajax\Mods\Etrade;

use BPL\Lib\Local\Database\Db_Connect as DB;

use Exception;

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($user_id);

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

/**
 * @param $user_id
 * @param $value_last
 * @param $day
 *
 *
 * @since version
 */
function update_user_compound($user_id, $value_last, $day)
{
	crud(
		'UPDATE network_compound ' .
		'SET day = :day, ' .
		'value_last = :value_last, ' .
		'time_last = :time_last ' .
		'WHERE user_id = :user_id',
		[
			'day'        => $day,
			'value_last' => $value_last,
			'time_last'  => time(),
			'user_id'    => $user_id
		]
	);
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function main($user_id)
{
	$dbh = DB::connect();

	$return = $_POST;

	$account_type = user($user_id)->account_type;

	$settings_investment = settings('investment');

	$principal = $settings_investment->{$account_type . '_principal'};
	$interest  = $settings_investment->{$account_type . '_interest'} / 100;
	$interval  = $settings_investment->{$account_type . '_interval'};
	$maturity  = $settings_investment->{$account_type . '_maturity'};

	$user_compound = user_compound($user_id);

	$time_last  = $user_compound->time_last;
	$value_last = $user_compound->value_last;
	$day        = $user_compound->day;

	$diff = time() - $time_last;

	if (!((($diff > $interval) || ((int) $day === 0)) && ($day <= $maturity)))
	{
		$return['value_last'] = $value_last;

		echo_json($return);
	}

	$day++;

	$principal_new = bcmul((string) $principal,
		bcpow((string) (1 + $interest), (string) $day, 7), 7);
	$value_last    = bcsub($principal_new, (string) $principal, 2);

	try
	{
		$dbh->beginTransaction();

		update_user_compound($user_id, $value_last, $day);

		$dbh->commit();
	}
	catch (Exception $e)
	{
		try
		{
			$dbh->rollback();
		}
		catch (Exception $e2)
		{
			$return['error']      = 'Error Updating';
			$return['value_last'] = $value_last;

			echo_json($return);
		}
	}

	$return['value_last'] = user_compound($user_id)->value_last;

	echo_json($return);
}