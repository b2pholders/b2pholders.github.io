<?php

namespace BPL\Jumi\Fast_Track_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\session_set;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
//use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\restrict_page;
use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\page_reload;

main();

/**
 *
 *
 * @since version
 */
function main()
{
    $user_id = session_get('user_id');
    $amount = input_get('amount_ftk');
    session_set('ftk', $amount);

//    page_validate();
    restrict_page();

    $str = page_reload();

    $str .= menu();

    $str .= '<h1>' . /*settings('plans')->fast_track_name .*/
        ' Wallet</h1>';

    if ($amount !== '') {
        process_deposit($user_id, $amount);
    }

    $str .= view_form($user_id);

    echo $str;
}

/**
 * @param $user_id
 *
 * @param $amount
 *
 * @since version
 */
function process_deposit($user_id, $amount)
{
	$db = db();

    validate_input($user_id, $amount);

	try
	{
		$db->transactionStart();

		$field_user   = ['fast_track_balance = fast_track_balance - ' . $amount];
//		$field_user[] = (settings('ancillaries')->withdrawal_mode === 'standard' ?
//				'balance = balance + ' : 'payout_transfer = payout_transfer + ') . $amount;

        $field_user[] = 'points = points + ' . $amount;

		update(
			'network_users',
			$field_user,
			['id = ' . $db->quote($user_id)]
		);

		logs($user_id, $amount);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(20),
		settings('plans')->fast_track_name . ' Conversion Completed Successfully!', 'success');

//    application()->redirect(Uri::root(true) . '/' . sef(57)/* . qs() . 'fdp=' . $amount*//*,
//		'We\'ll Process your conversion within 24 hours.<br>Thank You.', 'success'*/);
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
    $user = user($user_id);

    $si = settings('investment');

    $minimum_deposit = $si->{$user->account_type . '_fast_track_minimum_deposit'};

    $app = application();

    if ($amount > $user->fast_track_balance) {
        $app->redirect(Uri::root(true) . '/' . sef(20),
            'Exceeds ' . settings('plans')->fast_track_name . '!', 'error');
    }

    if ($amount < $minimum_deposit) {
        $app->redirect(Uri::root(true) . '/' . sef(20), 'Convert at least ' .
            number_format($minimum_deposit, 2) . ' ' .
            settings('ancillaries')->currency . '!', 'error');
    }

    if (((double)$user->fast_track_deposit_today + (double)$amount) > $si->{$user->account_type . '_fast_track_maximum_deposit'}) {
        $app->redirect(Uri::root(true) . '/' . sef(20) . qs() . 'uid=' . $user_id,
            'Exceeded Maximum Conversion!', 'error');
    }
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
    $db = db();

    $sp = settings('plans');
//    $sa = settings('ancillaries');

//    $currency = $sa->currency;

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
            $db->quote('<b>' . $sp->fast_track_name . ' Conversion: </b> <a href="' .
                sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> converted ' .
                number_format($amount, 2) . ' ' . /*$currency*//*'pts.' .*/ /*' to credit.'*/' to points.'),
            $db->quote(time())
        ]
    );

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
            $db->quote($sp->fast_track_name . ' Conversion'),
            $db->quote('<b>' . $sp->fast_track_name . ' Conversion: </b> <a href="' .
                sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> converted ' .
                number_format($amount, 2) . ' ' . /*$currency . ' to credit.'*/'to points.'),
            $amount,
            ((double)$user->payout_transfer + (double)$amount),
            $db->quote(time())
        ]
    );
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
    $sp = settings('plans');
//    $sa = settings('ancillaries');

//    $currency = $sa->currency;

    $user = user($user_id);

    $str = '<form method="post">';
    $str .= '<table class="category table table-striped table-bordered table-hover">';

    $str .= '<tr>
            <td><strong>' . $sp->fast_track_name . ' Balance: ' .
        number_format($user->fast_track_balance, 2) . ' ' . /*$currency*/
        'pts.' . '</strong>
                <strong style="float: right">
                    ' . /*$sa->efund_name . ' Balance: '*/
        'Points: ' .
        number_format(/*$user->payout_transfer*/ $user->points, 2) . ' ' . /*$currency*/
        'pts.' . '</strong>
            </td>
        </tr>';

    $str .= '<tr>
            <td>
                <div class="uk-form-row">
                    <input type="text"
                           placeholder="Input Amount"
                           name="amount_ftk"
                           class="uk-form-medium uk-form-width-medium"
                           required>
                    <input class="uk-button uk-button-medium"
                           name="submit"
                           value="Convert" style="margin-bottom: 10px"
                           type="submit">
                </div>
            </td>
        </tr>';

    $str .= '</table>';
    $str .= '</form>';

    return $str;
}