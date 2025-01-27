<?php

namespace BPL\Jumi\Account_Reactivate;

require_once 'bpl/mods/income.php';
require_once 'bpl/mods/binary/core.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Income\main as income_global;

//use function BPL\Mods\Binary\Core\main as binary;
use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Helpers\user;
use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\settings;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype = session_get('usertype');
	$user_id = session_get('user_id');
	$final = input_get('final');

	page_validate($usertype, $user_id);

	$str = menu();

	if ($final === '') {
		$str .= view_form($user_id);
	} else {
		process_reactivation($user_id);
	}

	echo $str;
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$sa = settings('ancillaries');

	$user = user($user_id);

	return '<h1>Reactivate Account</h1>
		<b>' . $sa->efund_name . ':</b> ' .
		number_format($user->payout_transfer, 8) . ' ' . $sa->currency . '<br>
		<b>Username:</b> ' . $user->username . '<br>
	    <b>Full Name:</b> ' . $user->fullname . '<hr>
	    <form method="post">
	        <input type="hidden" name="final" value="1">
	        <input type="hidden" name="uid" value="' . $user->id . '">
	        <input type="submit" value="Reactivate Account" class="uk-button uk-button-primary">
	    </form>';
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function validate($user_id)
{
	$app = application();

	$sa = settings('ancillaries');
	//	$sb = settings('binary');
	$sf = settings('freeze');

	//	$binary_user = binary_user($user_id);

	$user = user($user_id);

	$account_type = $user->account_type;

	//	$reactivate_count = $binary_user->reactivate_count;

	//	$cost_reactivate = $sb->{$account_type . '_pairs_reactivate'};
//	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	$cost_reactivate = $sf->{$account_type . '_reactivation'};

	//	if ($reactivate_count >= $capping_cycle_max)
//	{
//		$app->redirect(Uri::root(true) . '/' . sef(120),
//			'Maximum reactivation reached!', 'error');
//	}

	// check stock fund balance
	if ($user->payout_transfer < $cost_reactivate) {
		$app->redirect(
			Uri::root(true) . '/' . sef(130),
			'Maintain at least an ' . $sa->efund_name . ' amount of ' .
			number_format($cost_reactivate, 8) . ' ' . settings('ancillaries')->currency,
			'error'
		);
	}
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function binary_user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 *
 *
 * @since version
 */
function process_reactivation($user_id)
{
	$db = db();

	validate($user_id);

	try {
		$db->transactionStart();

		update_users($user_id);

		//		if (update_binary($user_id))
//		{
//			process_binary($user_id);
//		}

		logs($user_id);

		$db->transactionCommit();
	} catch (Exception $e) {
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' .
		sef(43), user($user_id)->username .
		'\'s Account has been reactivated successfully', 'success');
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
//function process_binary($user_id)
//{
//	if (settings('plans')->binary_pair)
//	{
//		binary($user_id/*, 'reactivate'*/);
//	}
//}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function update_users($user_id)
{
	$db = db();

	//	$sa = settings('ancillaries');
//	$sb = settings('binary');
	$sf = settings('freeze');

	//	$binary_user = binary_user($user_id);

	$user = user($user_id);

	$account_type = $user->account_type;
	//	$income_cycle_global = $user->income_cycle_global;

	//	$reactivate_count = $binary_user->reactivate_count;

	//	$cost_reactivate = $sb->{$account_type . '_pairs_reactivate'};
//	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	$cost_reactivate = $sf->{$account_type . '_reactivation'};

	update(
		'network_users',
		[
			'payout_transfer = payout_transfer - ' . $cost_reactivate,
			//			'income_flushout = ' . /*income_global($user_id)*/ $income_cycle_global,
			'income_cycle_global = ' . '0',
			'status_global = ' . $db->quote('active')
		],
		['id = ' . $db->quote($user_id)]
	);

	update_fixed_daily($user_id);
	update_fast_track($user_id);
}

function update_fixed_daily($user_id)
{
	$db = db();

	update(
		'network_fixed_daily',
		[
			'time_last = 0',
			'value_last = 0',
			'day = 0',
			'processing = 0',
			'time_mature = 0',
			'date_last_cron = 0',
			'flushout_global = 0'
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

function update_fast_track($user_id)
{
	$db = db();

	delete(
		'network_fast_track',
		['user_id = ' . $db->quote($user_id)],
	);
}

/**
 *
 *
 * @since version
 */
//function update_binary($user_id)
//{
//	$db = db();
//
//	$binary_user = binary_user($user_id);
//
//	$reactivate_count = $binary_user->reactivate_count;
//
//	return update('network_binary',
//		[
//			'status = ' . $db->quote(/*'reactivated'*/'active')
//			, 'capping_cycle = ' . $db->quote(0)
//			, 'status_cycle = ' . $db->quote(1)
//			, 'ctr_left = ' . $db->quote(0)
//			, 'ctr_right = ' . $db->quote(0)
//			, 'pairs_today = ' . $db->quote(0)
//			, 'reactivate_count = ' . $db->quote($reactivate_count + 1)
//		],
//		[
//			'user_id = ' . $db->quote($user_id)
//		]
//
//	);
//}

/**
 *
 *
 * @since version
 */
function logs($user_id)
{
	$db = db();

	$user = user($user_id);

	//	$binary_user = binary_user($user_id);

	$currency = settings('ancillaries')->currency;

	$cost_reactivate = settings('freeze')->{$user->account_type . '_reactivation'};

	insert(
		'network_transactions',
		[
			'user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'
		],
		[
			$db->quote($user_id),
			$db->quote('Account Reactivation'),
			$db->quote(number_format($cost_reactivate, 8) . ' ' . $currency .
				' deducted to <a href="' . sef(44) . qs() . 'uid=' . $user_id . '">' .
				$user->username . '</a> for Account Reactivation.'),
			$db->quote($cost_reactivate),
			($user->payout_transfer - $cost_reactivate),
			$db->quote(time())
		]
	);

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
			$db->quote($user_id),
			$db->quote($user_id),
			1,
			$db->quote('<b>Account Reactivation: ' .
				number_format($cost_reactivate, 8) . $currency .
				' deducted to <a href="' . sef(44) . qs() . 'uid=' .
				$user_id . '">' . $user->username .
				'</a> for Account Reactivation.'),
			$db->quote(time())
		]
	);
}

/**
 * @param $usertype
 * @param $user_id
 *
 *
 * @since version
 */
function page_validate($usertype, $user_id)
{
	$binary_user = binary_user($user_id);

	if ($usertype === '' || $binary_user->status_global === 'active') {
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}