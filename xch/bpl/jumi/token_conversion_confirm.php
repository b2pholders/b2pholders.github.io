<?php

namespace BPL\Jumi\Token_Conversion_Confirm;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\delete;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\time;
use function BPL\Mods\Helpers\input_get;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype = session_get('usertype');
	$mode     = input_get('mode');
	$final    = input_get('final');
	$uid      = input_get('uid');

	page_validate($usertype);

	$str = menu();

	if ($uid !== '')
	{
		if ((int) $final !== 1)
		{
			$str .= view_form($uid, $mode);
		}
		else
		{
			if ((int) $mode === 1)
			{
				approve_conversion($uid);
			}

			if ((int) $mode === 2)
			{
				deny_conversion($uid);
			}
		}

		$str .= '<hr>';
	}

	$str .= view_pending();

	echo $str;
}

/**
 * @param $usertype
 *
 *
 * @since version
 */
function page_validate($usertype)
{
	if ($usertype !== 'Admin' && $usertype !== 'manager')
	{
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function user_token_convert($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_token_convert t ' .
		'WHERE u.id = t.user_id ' .
		'AND t.convert_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 * @param $uid
 * @param $mode
 *
 * @return string
 *
 * @since version
 */
function view_form($uid, $mode): string
{
	$token_name = settings('trading')->token_name;

//	$currency = settings('ancillaries')->currency;

	$result = user_token_convert($uid);

	$method         = explode('|', $result->method);
	$method_name    = $method[0] ? strtoupper($method[0]) : '';
	$method_address = $method[1] ?? '';

	$str = ((int) $mode === 1 ? '<h3>Approve Conversion</h3>' : '<h3>Deny Conversion</h3>');

	$str .= '<form method="post">
            <input type="hidden" name="final" value="1">
            <input type="hidden" name="uid" value="' . $uid . '">
            <input type="hidden" name="mode" value="' . $mode . '">
            <table class="category table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date Converted</th>
                    <th>Username</th>' . /*'
                    <th>Account</th>
                    <th>Balance (' . strtoupper($token_name) . ')</th>' .*/ '
                    <th>Amount</th>
                    <th>Charges</th>
                    <th>Final</th>
                    <th>Method</th>
                    <th>Action</th>
                </tr>
                </thead>';

	$str .= '<tr>
			<td>' . date('M j, Y - g:i A', $result->date_converted) . '</td>
			<td><a href="' . sef(44) . qs() . 'uid=' . $result->id . '">' . $result->username . /*'</a></td>
			<td>' . settings('entry')->{$result->account_type . '_package_name'} . '</td>
			<td>' . number_format($result->balance_fmc, 8) .*/ '</td>
			<td>' . number_format($result->amount, 8) . ' ' . strtoupper($token_name) .
		'</td>
			<td>' . number_format($result->deduction_total, 2) . ' ' . $method_name .
		'</td>
			<td>' . number_format($result->amount_final, 8) . ' ' . $method_name .
		'</td>
			<td>' . $method_name . ': ' . $method_address . '</td>
			<td><input type="submit" value="Confirm" name="submit" class="uk-button uk-button-primary"></td>
		</tr>';

	$str .= '</table>
        </form>';

	return $str;
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function update_user($uid)
{
	$db = db();

	$result = user_token_convert($uid);

	update(
		'network_users',
		[
			'balance_fmc = balance_fmc - ' . $result->amount,
			'payout_transfer = payout_transfer - ' . $result->deduction_total
		],
		['id = ' . $db->quote($result->id)]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function update_token_convert($uid)
{
	$db = db();

	update(
		'network_token_convert',
		['date_completed = ' . $db->quote(time())],
		['convert_id = ' . $db->quote($uid)]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function log_activity($uid)
{
	$db = db();

	$result = user_token_convert($uid);

	$token_name = settings('trading')->token_name;

	$currency = settings('ancillaries')->currency;

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
			$db->quote($result->id),
			$db->quote($result->id),
			$db->quote(1),
			$db->quote('<b>' . $token_name . ' Conversion Confirmed: ' . '</b><a href="' .
				sef(44) . qs() . 'uid=' . $result->id . '">' . $result->username .
				'</a> has converted ' . number_format($result->amount, 8) . ' ' .
				strtoupper($token_name) . '.<br>Total Charges (' . $currency . '): ' .
				number_format($result->deduction_total, 2) . '<br>Final Amount (' .
				$currency . '): ' . number_format($result->amount_final, 2) . '.'),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 *
 *
 * @return mixed|null
 * @since version
 */
function user_transactions($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_transactions ' .
		'WHERE user_id = ' . $user_id .
		' ORDER BY transaction_id DESC'
	)->loadObject();
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function log_transactions($uid)
{
	$db = db();

	$result = user_token_convert($uid);

	$currency = settings('ancillaries')->currency;

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
			$db->quote($result->id),
			$db->quote(strtoupper(settings('trading')->token_name) . ' Conversion'),
			$db->quote('Amount (' . $currency . '): ' . number_format($result->amount, 2) .
				'.<br>Total Charges (' . $currency . '): ' . number_format($result->deduction_total, 2) .
				'<br>Final Amount (' . $currency . '): ' . number_format($result->amount_final, 2) . '.'),
			$db->quote('-' . $result->amount),
			$db->quote(user_transactions($result->id)->balance - $result->amount),
			$db->quote(time())
		]
	);
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function token_conversions()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_token_conversions ' .
		'ORDER BY conversion_id DESC'
	)->loadObject();
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function log_token_conversions($uid)
{
	$db = db();

	$result = user_token_convert($uid);

	$user_convert = token_conversions();

	insert(
		'network_token_conversions',
		[
			'transaction_id',
			'amount',
			'conversion_date',
			'conversion_total',
			'amount_tax',
			'total_tax'
		],
		[
			$db->quote($db->insertid()),
			$db->quote($result->amount),
			$db->quote(time()),
			$db->quote($user_convert->conversion_total + $result->amount),
			$db->quote($result->deduction_total),
			$db->quote($user_convert->total_tax + $result->deduction_total)
		]
	);
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function income_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 * @param $uid
 *
 * @param $insert_id
 *
 * @since version
 */
function log_income_admin($uid, $insert_id)
{
	$db = db();

	$result = user_token_convert($uid);

	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($insert_id),
			$db->quote($result->deduction_total),
			$db->quote(income_admin()->income_total + $result->deduction_total),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_approve($uid)
{
	log_activity($uid);
	log_transactions($uid);
	log_token_conversions($uid);

	log_income_admin($uid, db()->insertid());
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function approve_conversion($uid)
{
	$db = db();

	$settings_ancillaries = settings('ancillaries');

	$token_name = settings('trading')->token_name;

	$result = user_token_convert($uid);

	// mail admin
	$message = 'Username: ' . $result->username . '<br>
			Full Name: ' . $result->fullname . '<br>
			Email: ' . $result->email . '<br>
			Contact Number: ' . $result->contact . '<br>
			Amount (' . strtoupper($token_name) . '): ' . number_format($result->amount, 8) . '<br>
			Final Amount (' . $settings_ancillaries->currency . '): ' . number_format($result->amount, 2);

	try
	{
		$db->transactionStart();

		update_user($uid);
		update_token_convert($uid);

		logs_approve($uid);

		send_mail($message, strtoupper($token_name) . ' Conversion Confirmed', [$result->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

//	send_mail($uid);

	application()->redirect(Uri::root(true) . '/' . sef(100),
		strtoupper(settings('trading')->token_name) . ' conversion confirmed!', 'success');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function logs_deny($uid)
{
	$db = db();

	$result = user_token_convert($uid);

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
			$db->quote($result->id),
			$db->quote($result->id),
			$db->quote(1),
			$db->quote('<b>Conversion Denied: ' . '</b><a href="' . sef(44) . qs() .
				'uid=' . $result->id . '">' . $result->username . '</a>, ' .
				number_format($result->amount, 8) . ' ' . strtoupper(settings('trading')->token_name) .
				'. Contact for more info.'),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function delete_token_convert($uid)
{
	$db = db();

	delete(
		'network_token_convert',
		['convert_id = ' . $db->quote($uid)]
	);
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function deny_conversion($uid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		delete_token_convert($uid);

		logs_deny($uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(100),
		strtoupper(settings('trading')->token_name) . ' conversion denied!', 'error');
}

/**
 *
 * @return array|mixed
 *
 * @since version
 */
function user_token_convert_pending()
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_token_convert t ' .
		'WHERE u.id = t.user_id ' .
		'AND t.date_completed = ' . $db->quote(0) .
		' ORDER BY t.convert_id ASC'
	)->loadObjectList();
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_pending(): string
{
	$token_name = settings('trading')->token_name;
//	$currency   = settings('ancillaries')->currency;

	$str = '<h1>Pending ' . strtoupper($token_name) . ' Conversions</h1>';

	$result = user_token_convert_pending();

	if (!empty($result))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Date Converted</th>
            <th>Username</th>' . /*'
            <th>Account</th>
            <th>Balance (' . strtoupper($token_name) . ')</th>' .*/ '
            <th>Amount (' . strtoupper($token_name) . ')</th>
            <th>Charges</th>
            <th>Final</th>
            <th>Method</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>';

		foreach ($result as $member)
		{
//			$account_type_mod_2 = settings('entry')->{$member->account_type . '_package_name'};

			$user = user($member->user_id);

			$arr_payment_method = arr_payment_method($user);
//			$method_address = $arr_payment_method[$member->method];

			$bank_name      = '';
			$bank_account   = '';
			$payout_address = '';

			if (!is_array($arr_payment_method[$member->method]))
			{
				$payout_address = $arr_payment_method[$member->method] ?? '';
			}
			else
			{
				foreach ($arr_payment_method[$member->method] as $k => $v)
				{
					if ($member->method === 'bank')
					{
						$bank_name    = strtoupper($k);
						$bank_account = $v;
					}
				}
			}

			$currency = in_array($member->method, ['bank', 'gcash']) ? 'PHP' : $member->method;

			$str .= '<tr>
			<td>' . date('M j, Y - g:i A', $member->date_converted) . '</td>
			<td><a href="' . sef(44) . qs() . 'uid=' . $member->id . '">' . $member->username . '</a></td>
			<td>' . /*$account_type_mod_2 . '</td>
			<td>' . number_format($member->balance_fmc, 8) . '</td>
			<td>' .*/ number_format($member->amount, 8) .
				'</td>
			<td>' . number_format($member->deduction_total, 8) . ' ' . strtoupper($currency) .
				'</td>
			<td>' . number_format($member->amount_final, 8) . ' ' . strtoupper($currency) .
				'</td>
			<td>' . strtoupper($member->method === 'bank' ? $bank_name : $member->method) .
				': ' . ($member->method === 'bank' ? $bank_account : $payout_address) . '</td>
			<td>';
			$str .= '<div class="uk-button-group">
	            <button class="uk-button uk-button-primary">Select</button>
	            <div class="" data-uk-dropdown="{mode:\'click\'}">
	                <button class="uk-button uk-button-primary"><i class="uk-icon-caret-down"></i></button>
	                <div style="" class="uk-dropdown uk-dropdown-small">
	                    <ul class="uk-nav uk-nav-dropdown">
	                        <li>
	                            <a href="' . sef(100) . qs() . 'uid=' . $member->convert_id . '&mode=1">Confirm</a>
	                        </li>
	                        <li>
	                            <a href="' . sef(100) . qs() . 'uid=' . $member->convert_id . '&mode=2">Delete</a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </div>';
			$str .= '
				</td>
			</tr>';
		}

		$str .= '</tbody>
    	</table>';
	}
	else
	{
		$str .= '<hr><p>No pending ' . strtoupper($token_name) . ' conversions.</p>';
	}

	return $str;
}