<?php

namespace BPL\Jumi\Binary_Reactivate;

require_once 'bpl/mods/binary/core.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\Uri\Uri;

use function BPL\Mods\Binary\Core\main as binary;
use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

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
	$user_id  = session_get('user_id');
	$final    = input_get('final');

	page_validate($usertype, $user_id);

	$str = menu();

	if ($final === '')
	{
		$str .= view_form($user_id);
	}
	else
	{
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

	$binary_user = binary_user($user_id);

	$payout_transfer = $binary_user->payout_transfer;

	return '<h1>Reactivate Binary</h1>
		<b>' . $sa->efund_name . ':</b> ' . number_format($payout_transfer, 2) . ' ' . $sa->currency . '<br>
		<b>Username:</b> ' . $binary_user->username . '<br>
	    <b>Full Name:</b> ' . $binary_user->fullname . '<hr>
	    <form method="post">
	        <input type="hidden" name="final" value="1">
	        <input type="hidden" name="uid" value="' . $binary_user->user_id . '">
	        <input type="submit" value="Reactivate Binary" class="uk-button uk-button-primary">
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
	$sb = settings('binary');

	$binary_user = binary_user($user_id);

	$account_type = $binary_user->account_type;

	$reactivate_count = $binary_user->reactivate_count;

	$cost_reactivate = $sb->{$account_type . '_pairs_reactivate'};
	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	if ($reactivate_count >= $capping_cycle_max)
	{
		$app->redirect(Uri::root(true) . '/' . sef(120),
			'Maximum reactivation reached!', 'error');
	}

	// check stock fund balance
	if ($binary_user->payout_transfer < $cost_reactivate)
	{
		$app->redirect(Uri::root(true) . '/' . sef(120),
			'Maintain at least an ' . $sa->efund_name . ' amount of ' .
			number_format($cost_reactivate, 2) . ' ' . settings('ancillaries')->currency, 'error');
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

	try
	{
		$db->transactionStart();

		update_users($user_id);

		if (update_binary($user_id))
		{
			process_binary($user_id);
		}

		logs($user_id);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' .
		sef(43), binary_user($user_id)->username .
		'\'s Binary has been reactivated successfully', 'success');
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function process_binary($user_id)
{
	if (settings('plans')->binary_pair)
	{
		binary($user_id/*, 'reactivate'*/);
	}
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function update_users($user_id)
{
	$binary_user = binary_user($user_id);

	$cost_reactivate = settings('binary')->{$binary_user->account_type . '_pairs_reactivate'};

	update('network_users',
		['payout_transfer = payout_transfer - ' . $cost_reactivate],
		['id = ' . db()->quote($user_id)]);
}

/**
 *
 *
 * @since version
 */
function update_binary($user_id)
{
	$db = db();

	$binary_user = binary_user($user_id);

	$reactivate_count = $binary_user->reactivate_count;

	return update('network_binary',
		[
			'status = ' . $db->quote(/*'reactivated'*/'active')
			, 'capping_cycle = ' . $db->quote(0)
			, 'status_cycle = ' . $db->quote(1)
			, 'ctr_left = ' . $db->quote(0)
			, 'ctr_right = ' . $db->quote(0)
			, 'pairs_today = ' . $db->quote(0)
			, 'reactivate_count = ' . $db->quote($reactivate_count + 1)
		],
		[
			'user_id = ' . $db->quote($user_id)
		]

	);
}

/**
 *
 *
 * @since version
 */
function logs($user_id)
{
	$db = db();

	$binary_user = binary_user($user_id);

	$currency = settings('ancillaries')->currency;

	$cost_reactivate = settings('binary')->{$binary_user->account_type . '_pairs_reactivate'};

	insert('network_transactions',
		['user_id',
			'transaction',
			'details',
			'value',
			'balance',
			'transaction_date'],
		[$db->quote($binary_user->user_id),
			$db->quote('Binary Reactivation'),
			$db->quote(number_format($cost_reactivate, 2) . ' ' . $currency .
				' deducted to <a href="' . sef(44) . qs() . 'uid=' . $binary_user->user_id . '">' .
				$binary_user->username . '</a> for Binary Reactivation.'),
			$db->quote($cost_reactivate),
			($binary_user->payout_transfer - $cost_reactivate),
			$db->quote(time())
		]
	);

	insert('network_activity',
		['user_id',
			'sponsor_id',
			'upline_id',
			'activity',
			'activity_date'],
		[$db->quote($binary_user->user_id),
			$db->quote($binary_user->user_id),
			1,
			$db->quote('<b>Binary Reactivation: ' .
				number_format($cost_reactivate, 2) . $currency .
				' deducted to <a href="' . sef(44) . qs() . 'uid=' .
				$binary_user->user_id . '">' . $binary_user->username .
				'</a> for Binary Reactivation.'),
			$db->quote(time())]
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

	if ($usertype === '' || $binary_user->status === 'active')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}