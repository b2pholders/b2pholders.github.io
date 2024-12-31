<?php

namespace BPL\Jumi\Profit_Share_Deposit;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\menu;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
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
	$user_id  = session_get('user_id');

	page_validate();

	$str = menu();

	$amount = input_get('amount');

	$db = db();

	$settings_plans = settings('plans');

	$str .= '<h1>' . $settings_plans->table_matrix_name . ' Deposit</h1>';

	if ($amount !== '')
	{
		$app = application();

		validate_amount($user_id, $amount);

		try
		{
			$db->transactionStart();

			update_user($user_id, $amount);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		$app->redirect(Uri::root(true) . '/' . sef(61),
			$settings_plans->table_matrix_name . ' Deposit Completed Successfully!', 'success');
	}

	$str .= view_form($user_id);

	echo $str;
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
	$sa = settings('ancillaries');

	$currency = $sa->currency;

	$user = user($user_id);

	return '<form method="post">
    <table class="category table table-striped table-bordered table-hover">
        <tr>
            <td><strong>' . settings('plans')->table_matrix_name . '
                    Balance: ' . number_format($user->bonus_share, 2) . ' ' . $currency . '</strong>
                <strong style="float: right">
                   ' . $sa->efund_name . ' Balance: ' . number_format($user->payout_transfer, 2) . ' ' . $currency . '</strong>
            </td>
        </tr>
        <tr>
            <td>
                <div class="uk-form-row">
                    <input type="text"
                           placeholder="amount"
                           name="amount"
                           class="uk-form-medium uk-form-width-medium"
                           required>
                    <input class="uk-button uk-button-medium"
                           name="submit"
                           value="Deposit" style="margin-bottom: 10px"
                           type="submit">
                </div>
            </td>
        </tr>
    </table>
</form>';
}

/**
 * @param $user_id
 * @param $amount
 *
 *
 * @since version
 */
function validate_amount($user_id, $amount)
{
	if ($amount > user($user_id)->bonus_share)
	{
		application()->redirect(Uri::root(true) . '/' . sef(61),
			'Maintain at least ' . $amount .
			' ' . settings('ancillaries')->currenc . '!', 'error');
	}
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

	$field_user = ['bonus_share = bonus_share - ' . $amount];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . $amount;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $amount;
	}

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote(user($user_id)->id)]
	);
}