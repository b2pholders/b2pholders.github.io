<?php

namespace BPL\Ajax\Mods\Code_User_Update_Balance;

use Exception;

use BPL\Lib\Local\Database\Db_Connect as DB;

use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

$account_type = array(
	'executive',
	'regular',
	'associate',
	'basic',
	'starter'
);

$type  = in_array($_POST['type'], $account_type, true) ? $_POST['type'] : 'none';
$count = (!empty($_POST['count']) && ($_POST['count'] < 100)) ? $_POST['count'] : 0;

main($user_id, $type, $count);

/**
 * @param $user_id
 * @param $type
 * @param $count
 *
 *
 * @since version
 */
function main($user_id, $type, $count)
{
	$dbh = DB::connect();

	$return            = $_POST;
	$return['user_id'] = $user_id;

	if (!(!empty($_POST['count']) && ($_POST['count'] < 100)))
	{
		$return['error_validate_code'] = 'Please specify count!';

		echo_json($return);
	}

	if ($type === 'none')
	{
		$return['error_validate_code'] = 'Please specify type!';

		echo_json($return);
	}

	$settings_ancillaries = settings('ancillaries');

	$entry = settings('entry')->{$type . '_entry'};

	$user = user($user_id);

	$balance = $user->payout_transfer;

	$return['balance'] = $balance;

	$residue = bcsub($balance, bcmul($entry, $count), 2);

	$return['residue'] = $residue;

	$minimum_bal_usd = $settings_ancillaries->{$user->account_type . '_min_bal_usd'};

	if (!($residue >= $minimum_bal_usd))
	{
		$return['error_validate_code'] = 'Maintain at least ' .
			bcadd(bcmul($entry, $count), $minimum_bal_usd, 2) .
			' ' . $settings_ancillaries->currency . '!';

		echo_json($return);
	}

	try
	{
		$dbh->beginTransaction();

		update_user($user_id, $residue);

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

	try
	{
		$return['debug'] = json_encode($return, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
	}
	catch (Exception $e)
	{
	}

	echo_json($return);
}

/**
 * @param $user_id
 * @param $balance
 *
 *
 * @since version
 */
function update_user($user_id, $balance)
{
	crud(
		'UPDATE network_users ' .
		'SET balance = :balance ' .
		'WHERE id = :id',
		[
			'balance' => $balance,
			'id'      => $user_id
		]
	);
}