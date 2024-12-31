<?php

namespace BPL\Ajax\Mods\Top_Up;

use BPL\Lib\Local\Database\Db_Connect as DB;

use DateTime;
use DateTimeZone;
use Exception;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_top_up;

$input   = filter_input(INPUT_POST, 'input', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($input, $user_id);

/**
 * @param $input
 * @param $user_id
 *
 *
 * @since version
 */
function main($input, $user_id)
{
	header('Content-Type: application/json');

	$dbh = DB::connect();

	$return = $_POST;

	validate_top_up($user_id, $input, user($user_id)->top_up_principal, $return);

	try
	{
		$dbh->beginTransaction();

		insert_top_up($user_id, $input);
		update_user($user_id, $input);

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
		}
	}

	$user_latest = user($user_id);

	$return['principal'] = $user_latest->top_up_principal;
	$return['balance']   = $user_latest->payout_transfer;

	$value_last = 0;

	foreach (user_top_up($user_id) as $top_up)
	{
		$value_last += $top_up->value_last;
	}

	$return['interest'] = $value_last + $user_latest->top_up_interest;
	$return['input']    = $input;

	$return['success_top_up'] = settings('plans')->top_up_name . ' successful!';

	try
	{
		$return['top_up_json'] = json_encode($return, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
	}
	catch (Exception $e)
	{

	}

	echo_json($return);
}

/**
 * @param $user_id
 * @param $input
 *
 *
 * @since version
 */
function insert_top_up($user_id, $input)
{
	$time = new DateTime('now');
	$time->setTimezone(new DateTimeZone('Asia/Manila'));
	$now = $time->format('U'); // seconds since unix epoch

	$account_type = user($user_id)->account_type;

	$settings_investment = settings('investment');

	$top_up_maturity   = $settings_investment->{$account_type . '_top_up_maturity'};
	$top_up_processing = $settings_investment->{$account_type . '_top_up_processing'};

	crud(
		'INSERT ' .
		'INTO network_top_up (' .
		'user_id, ' .
		'time_last, ' .
		'value_last, ' .
		'day, ' .
		'principal, ' .
		'date_entry, ' .
		'processing, ' .
		'maturity' .
		') VALUES (' .
		':user_id, ' .
		':time_last, ' .
		':value_last, ' .
		':day, ' .
		':principal, ' .
		':date_entry, ' .
		':processing, ' .
		':maturity' .
		')',
		[
			'user_id'    => $user_id,
			'time_last'  => 0,
			'value_last' => 0,
			'day'        => 0,
			'principal'  => $input,
			'date_entry' => $now,
			'processing' => $top_up_processing,
			'maturity'   => $top_up_maturity
		]
	);
}

/**
 * @param $user_id
 * @param $input
 *
 *
 * @since version
 */
function update_user($user_id, $input)
{
	$user = user($user_id);

	$balance          = $user->payout_transfer;
	$top_up_principal = $user->top_up_principal;

	crud(
		'UPDATE network_users ' .
		'SET top_up_principal = :principal, ' .
		'payout_transfer = :payout_transfer ' .
		'WHERE id = :id',
		[
			'principal'       => ($top_up_principal + $input),
			'payout_transfer' => ($balance - $input),
			'id'              => $user_id
		]
	);
}

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function user_top_up($user_id)
{
	return fetch_all(
		'SELECT * ' .
		'FROM network_top_up ' .
		'WHERE user_id = :user_id ' .
		'ORDER BY id DESC',
		['user_id' => $user_id]
	);
}