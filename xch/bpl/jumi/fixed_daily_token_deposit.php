<?php

namespace BPL\Jumi\Fixed_Daily_Token_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

// use Exception;

use Joomla\CMS\Uri\Uri;
// use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\application;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id = session_get('user_id');
	$amount = input_get('amount_fdtp');

	session_set('fdtp', $amount);

	page_validate();

	$str = menu();

	$str .= '<h1>' . settings('plans')->fixed_daily_token_name . ' Wallet</h1>';

	if ($amount !== '') {
		process_form($user_id, $amount);
	}

	$str .= view_form($user_id);
	$str .= view_pending_conversions();

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_pending_conversions(): string
{
	$user_id = session_get('user_id');

	$pending = user_token_convert($user_id);

	$token_name = /* settings('ancillaries')->efund_name */ 'B2P';

	$str = '<h2>Pending ' . $token_name . ' Withdrawals</h2>';

	if (empty($pending)) {
		$str .= '<hr><p>No pending ' . $token_name . ' withdrawals yet.</p>';
	} else {
		$str .= '<div class="table-responsive">';
		$str .= '<table class="category table table-striped table-bordered table-hover">';
		$str .= '<thead>';
		$str .= '<tr>';
		$str .= '<th>Date</th>';
		$str .= '<th>Amount</th>';
		$str .= '<th>System Charge</th>';
		$str .= '<th>Rate</th>';
		$str .= '<th>Method</th>';
		$str .= '<th>Mode</th>';
		$str .= '<th>On Processing</th>';
		$str .= '</tr>';
		$str .= '</thead>';
		$str .= '<tbody>';

		foreach ($pending as $tmp) {
			$currency = in_array($tmp->method, ['bank', 'gcash']) ? 'PHP' : $tmp->method;

			// $sa = settings('ancillaries');

			switch ($tmp->mode) {
				case 'fdp':
					$mode = settings('plans')->fixed_daily_name;
					break;
				case 'fdtp':
					$mode = settings('plans')->fixed_daily_token_name;
					break;
				case 'ftk':
					$mode = settings('plans')->fast_track_name;
					break;
				case 'lpd':
					$mode = settings('plans')->leadership_passive_name;
					break;
				default:
					$mode = 'Standard';
					break;
			}

			$str .= '<tr>';
			$str .= '<td> ' . date('M j, Y - g:i A', $tmp->date_posted) . ' </td>';
			$str .= '<td> ' . number_format($tmp->amount, 8) . ' ' . /* $sa->efund_name */ $token_name . '</td>';
			$str .= '<td> ' . number_format($tmp->cut, 8) . ' ' . /* $sa->efund_name */ $token_name . '</td>';
			$str .= '<td> ' . number_format($tmp->price, 8) . ' ' . strtoupper($currency) . '</td>';
			$str .= '<td>' . strtoupper($tmp->method) . '</td>';
			$str .= '<td>' . $mode . '</td>';

			$str .= '<td> ' . '<input type="button" class="uk-button uk-button-primary" value="Cancel" 
				data-uk-modal="{target:\'#modal-cancel-' . $tmp->convert_id . '\'}"></td>';

			$str .= '<div id="modal-cancel-' . $tmp->convert_id . '" class="uk-modal" aria-hidden="true" 
						style="display: none; overflow-y: scroll; margin-top: 120px">
		            <div class="uk-modal-dialog" style="text-align: center">
		                <button type="button" class="uk-modal-close uk-close"></button>';
			$str .= '<p><strong>Are you sure, you want to cancel this transaction?</strong></p>';
			$str .= '<div class="uk-panel uk-panel-box" style="text-align: left">
                        <h3 class="uk-panel-title"><strong>Date of Transaction:</strong> ' .
				date('M j, Y - g:i A', $tmp->date_posted) . '</h3>
                        <h3 class="uk-panel-title"><strong>Amount:</strong> ' .
				number_format($tmp->amount, 2) . ' ' . '</h3>
                        <h3 class="uk-panel-title"><strong>Final: </strong> ' .
				number_format($tmp->price, 2) . ' ' . strtoupper($currency) . '</h3>                        
                    </div>';
			$str .= '<div class="uk-modal-footer" style="text-align: right">
						<input type="button" class="uk-modal-close uk-button uk-button-primary" value="Close">
						<a href="' . sef(98) . qs() . 'cid=' . $tmp->convert_id . '" 
							type="button" class="uk-button uk-button-primary">Confirm</a>
					</div>';
			$str .= '</div>
		        </div>';
			$str .= '</tr>';
		}

		$str .= '</tbody>
        </table> ';
		$str .= '</div>';
	}

	return $str;
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function validate_input($user_id, $amount)
{
	$sef = sef(152);

	$app = application();

	$token = 'B2P';

	$si = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;

	// $fixed_daily_token_principal = $si->{$account_type . '_fixed_daily_token_principal'};
	$fixed_daily_token_principal_cut = $si->{$account_type . '_fixed_daily_token_principal_cut'} / 100;
	//	$fixed_daily_interest      = $settings_investment->{$account_type . '_fixed_daily_interest'} / 100;
//	$fixed_daily_harvest       = $settings_investment->{$account_type . '_fixed_daily_harvest'};
	$fixed_daily_token_maturity = $si->{$account_type . '_fixed_daily_token_maturity'};
	//	$fixed_daily_donation      = $settings_investment->{$account_type . '_fixed_daily_donation'} / 100;

	$fixed_daily_token_principal_cut = $fixed_daily_token_principal_cut ?: 1;

	// $principal = $fixed_daily_token_principal * $fixed_daily_token_principal_cut;
	//	$maturity_principal = $principal * ($fixed_daily_maturity * $fixed_daily_interest + 1);

	//	$minimum_deposit    = ($maturity_principal / $fixed_daily_maturity) *
//		$fixed_daily_harvest * (1 - $fixed_daily_donation);

	$fixed_daily_token_minimum_deposit = $si->{$account_type . '_fixed_daily_token_minimum_deposit'};

	if ($amount > $user->fixed_daily_token_balance) {
		$app->redirect(
			Uri::root(true) . '/' . $sef,
			'Exceeds ' . settings('plans')->fixed_daily_token_name .
			' Balance!',
			'error'
		);
	}

	if (user_fixed_daily_token($user_id)->day < $fixed_daily_token_maturity && $amount < $fixed_daily_token_minimum_deposit) {
		$app->redirect(
			Uri::root(true) . '/' . $sef,
			'Enter at least ' . number_format($fixed_daily_token_minimum_deposit, 8) .
			' ' . /* settings('ancillaries')->currency */ $token . '!',
			'error'
		);
	}

	if (
		((double) $user->fixed_daily_token_deposit_today + (double) $amount) > $si->{
			$user->account_type . '_fixed_daily_token_maximum_deposit'}
	) {
		$app->redirect(
			Uri::root(true) . '/' . $sef . qs() . 'uid=' . $user_id,
			'Exceeded Maximum Withdrawal!',
			'error'
		);
	}

	$mode = 'fdtp';

	if ($mode === 'fdtp') {
		$fdtp_converts = user_token_convert($user_id, 'fdtp');

		$fdtp_total = 0;

		if (!empty($fdtp_converts)) {
			foreach ($fdtp_converts as $fdtp) {
				$fdtp_total += $fdtp->amount;
			}
		}

		if ($user->fixed_daily_token_balance < ($fdtp_total + $amount)) {
			session_set('fdtp', '');

			$app->redirect(
				Uri::root(true) . '/' . $sef,
				settings('plans')->fixed_daily_token_name . ' Balance exceeded!',
				'error'
			);
		}
	}
}

/**
 * @param           $user_id
 * @param   string  $mode
 *
 * @return array|mixed
 *
 * @since version
 */
function user_token_convert($user_id, string $mode = 'fdtp')
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_token_convert ' .
		'WHERE user_id = ' . $db->quote($user_id) .
		($mode !== 'fdtp' ? ' AND mode = ' . $db->quote($mode) : '') .
		' AND date_approved = ' . $db->quote(0)
	)->loadObjectList();
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function process_form($user_id, $amount)
{
	//	$db = db();

	validate_input($user_id, $amount);

	//	try
//	{
//		$db->transactionStart();
//
//		update_user($user_id, $amount);
//
//		logs($user_id, $amount);
//
//		$db->transactionCommit();
//	}
//	catch (Exception $e)
//	{
//		$db->transactionRollback();
//		ExceptionHandler::render($e);
//	}

	//	application()->redirect(Uri::root(true) . '/' . sef(18),
//		settings('plans')->fixed_daily_name . ' Deposit Completed Successfully!', 'success');

	application()->redirect(
		Uri::root(true) . '/' . sef(98) . qs() . 'fdtp=' . $amount/*,
'We\'ll Process your conversion within 24 hours.<br>Thank You.', 'success'*/
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function update_user($user_id, $amount)
{
	$db = db();

	$field_user = ['fixed_daily_balance = fixed_daily_balance - ' . $amount];
	//	$field_user[] = (settings('ancillaries')->withdrawal_mode === 'standard' ?
//			'balance = balance + ' : 'payout_transfer = payout_transfer + ') . $amount;

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function logs($user_id, $amount)
{
	transaction_deposit_to($user_id, $amount);

	transaction_deposit_from($user_id, $amount);

	activity($user_id, $amount);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function transaction_deposit_to($user_id, $amount)
{
	$db = db();

	$currency = settings('ancillaries')->currency;

	$user = user($user_id);

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
			$db->quote(settings('plans')->fixed_daily_name . ' Convert'),
			$db->quote(number_format($amount, 2) . ' ' . $currency .
				' converted to ' . $currency . ' of <a href="' . sef(44) . qs() .
				'uid=' . $user_id . '">' . $user->username . '</a>.'),
			$db->quote($amount),
			$db->quote((double) $user->payout_transfer + (double) $amount),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function transaction_deposit_from($user_id, $amount)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

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
			$db->quote($settings_plans->fixed_daily_name . ' Deposit'),
			$db->quote(number_format($amount, 2) . ' ' . settings('ancillaries')->currency .
				' converted from ' . $settings_plans->fixed_daily_name .
				' Wallet of <a href="' . sef(44) . qs() . 'uid=' .
				$user_id . '">' . $user->username . '</a>.'),
			$db->quote($amount),
			$db->quote($user->fixed_daily_balance - $amount),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function activity($user_id, $amount)
{
	$db = db();

	$user = user($user_id);

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
			$db->quote($user->sponsor_id),
			$db->quote($user_id),
			$db->quote('<b>' . settings('plans')->fixed_daily_name . ' Convert: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> converted ' .
				number_format($amount, 2) . ' ' . settings('ancillaries')->currency . ' to e-Wallet.'),
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
function user_fixed_daily_token($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_fixed_daily_token ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	// $currency = settings('ancillaries')->currency;

	// $sa = settings('ancillaries');

	// $currency = $sa->currency;

	$user = user($user_id);

	$str = '<form method="post">
	    <table class="category table table-striped table-bordered table-hover">
	        <tr>
	            <td><strong>' . settings('plans')->fixed_daily_token_name . ' Balance: ' .
		number_format($user->fixed_daily_token_balance, 8) . ' ' . /* $currency */ 'B2P' . ' </strong>';
	// $str .= '<strong style="float: right">
	//                     ' . $sa->efund_name . ' Balance: ' .
	// 	number_format($user->payout_transfer, 8) . ' ' . /* $currency */ 'B2P' . '</strong>';
	$str .= '</td>
	        </tr>
	        <tr>
	            <td>
	                <div class="uk-form-row">
	                    <input type="text"
	                           placeholder="Input Amount"
	                           name="amount_fdtp"
	                           class="uk-form-medium uk-form-width-medium"
	                           required>
	                    <input class="uk-button uk-button-medium"
	                           name="submit"
	                           value="Withdraw" style="margin-bottom: 10px"
	                           type="submit">
	                </div>
	            </td>
	        </tr>
	    </table>
	</form>';

	return $str;
}