<?php

namespace BPL\Settings\Ancillaries;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\update as query_update;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 *
 * @return array
 *
 * @since version
 */
function get_input(): array
{
	return [
		'payment_mode'   => input_get('payment_mode'),
		'currency'       => input_get('currency'),
		'email_official' => input_get('email_official', '', 'RAW'),
		'company_name'   => input_get('company_name', '', 'RAW'),
		'cybercharge'    => input_get('cybercharge'),
		'processing_fee' => input_get('processing_fee'),
		'grace_period'   => input_get('grace_period'),

		'chairman_min_withdraw'  => input_get('chairman_min_withdraw'),
		'executive_min_withdraw' => input_get('executive_min_withdraw'),
		'regular_min_withdraw'   => input_get('regular_min_withdraw'),
		'associate_min_withdraw' => input_get('associate_min_withdraw'),
		'basic_min_withdraw'     => input_get('basic_min_withdraw'),

		'chairman_min_bal_usd'  => input_get('chairman_min_bal_usd'),
		'executive_min_bal_usd' => input_get('executive_min_bal_usd'),
		'regular_min_bal_usd'   => input_get('regular_min_bal_usd'),
		'associate_min_bal_usd' => input_get('associate_min_bal_usd'),
		'basic_min_bal_usd'     => input_get('basic_min_bal_usd'),

		'chairman_min_bal_fmc'  => input_get('chairman_min_bal_fmc'),
		'executive_min_bal_fmc' => input_get('executive_min_bal_fmc'),
		'regular_min_bal_fmc'   => input_get('regular_min_bal_fmc'),
		'associate_min_bal_fmc' => input_get('associate_min_bal_fmc'),
		'basic_min_bal_fmc'     => input_get('basic_min_bal_fmc'),

		'chairman_max_request_usd'  => input_get('chairman_max_request_usd'),
		'executive_max_request_usd' => input_get('executive_max_request_usd'),
		'regular_max_request_usd'   => input_get('regular_max_request_usd'),
		'associate_max_request_usd' => input_get('associate_max_request_usd'),
		'basic_max_request_usd'     => input_get('basic_max_request_usd'),

		'chairman_min_request_usd'  => input_get('chairman_min_request_usd'),
		'executive_min_request_usd' => input_get('executive_min_request_usd'),
		'regular_min_request_usd'   => input_get('regular_min_request_usd'),
		'associate_min_request_usd' => input_get('associate_min_request_usd'),
		'basic_min_request_usd'     => input_get('basic_min_request_usd'),

		'chairman_min_convert_usd'  => input_get('chairman_min_convert_usd'),
		'executive_min_convert_usd' => input_get('executive_min_convert_usd'),
		'regular_min_convert_usd'   => input_get('regular_min_convert_usd'),
		'associate_min_convert_usd' => input_get('associate_min_convert_usd'),
		'basic_min_convert_usd'     => input_get('basic_min_convert_usd'),

		'chairman_max_convert_usd'  => input_get('chairman_max_convert_usd'),
		'executive_max_convert_usd' => input_get('executive_max_convert_usd'),
		'regular_max_convert_usd'   => input_get('regular_max_convert_usd'),
		'associate_max_convert_usd' => input_get('associate_max_convert_usd'),
		'basic_max_convert_usd'     => input_get('basic_max_convert_usd'),

		'chairman_min_convert_fmc'  => input_get('chairman_min_convert_fmc'),
		'executive_min_convert_fmc' => input_get('executive_min_convert_fmc'),
		'regular_min_convert_fmc'   => input_get('regular_min_convert_fmc'),
		'associate_min_convert_fmc' => input_get('associate_min_convert_fmc'),
		'basic_min_convert_fmc'     => input_get('basic_min_convert_fmc'),

		'chairman_convert_points_cut'  => input_get('chairman_convert_points_cut'),
		'executive_convert_points_cut' => input_get('executive_convert_points_cut'),
		'regular_convert_points_cut'   => input_get('regular_convert_points_cut'),
		'associate_convert_points_cut' => input_get('associate_convert_points_cut'),
		'basic_convert_points_cut'     => input_get('basic_convert_points_cut'),

		'chairman_convert_points_usd'  => input_get('chairman_convert_points_usd'),
		'executive_convert_points_usd' => input_get('executive_convert_points_usd'),
		'regular_convert_points_usd'   => input_get('regular_convert_points_usd'),
		'associate_convert_points_usd' => input_get('associate_convert_points_usd'),
		'basic_convert_points_usd'     => input_get('basic_convert_points_usd'),

		'chairman_savings_target'  => input_get('chairman_savings_target'),
		'executive_savings_target' => input_get('executive_savings_target'),
		'regular_savings_target'   => input_get('regular_savings_target'),
		'associate_savings_target' => input_get('associate_savings_target'),
		'basic_savings_target'     => input_get('basic_savings_target'),

		'chairman_savings_min_bal'  => input_get('chairman_savings_min_bal'),
		'executive_savings_min_bal' => input_get('executive_savings_min_bal'),
		'regular_savings_min_bal'   => input_get('regular_savings_min_bal'),
		'associate_savings_min_bal' => input_get('associate_savings_min_bal'),
		'basic_savings_min_bal'     => input_get('basic_savings_min_bal'),

		'referral_mode'   => input_get('referral_mode'),
		'withdrawal_mode' => input_get('withdrawal_mode'),
		'cd_mode'         => input_get('cd_mode'),

		'efund_name'       => input_get('efund_name'),
		'share_fund_name'  => input_get('share_fund_name'),
		'loan_fund_name'   => input_get('loan_fund_name'),
		'p2p_price_buffer' => input_get('p2p_price_buffer')/*,
		'freezer' => input_get('freezer')*/
	];
}

/**
 *
 *
 * @since version
 */
function update()
{
	$app = application();

	$db = db();

	$input = get_input();

	$test = [
		$input['cybercharge'],
		$input['email_official'],
		$input['company_name'],
		$input['processing_fee'],

		$input['chairman_min_withdraw'],
		$input['executive_min_withdraw'],
		$input['regular_min_withdraw'],
		$input['associate_min_withdraw'],
		$input['basic_min_withdraw'],

		$input['chairman_min_bal_usd'],
		$input['executive_min_bal_usd'],
		$input['regular_min_bal_usd'],
		$input['associate_min_bal_usd'],
		$input['basic_min_bal_usd']
	];

	if (!in_array('', $test, true))
	{
		$sa = settings('ancillaries');

		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_ancillaries',
				[
					'payment_mode = ' . $db->quote($input['payment_mode'] ?: $sa->payment_mode),
					'currency = ' . $db->quote($input['currency'] ?: $sa->currency),
					'email_official = ' . $db->quote($input['email_official'] ?: $sa->email_official),
					'company_name = ' . $db->quote($input['company_name'] ?: $sa->company_name),
					'cybercharge = ' . $db->quote($input['cybercharge'] ?: $sa->cybercharge),
					'processing_fee = ' . $db->quote($input['processing_fee'] ?: $sa->processing_fee),
					'grace_period = ' . $db->quote($input['grace_period'] ?: $sa->grace_period),

					'chairman_min_withdraw = ' . $db->quote($input['chairman_min_withdraw'] ?: $sa->chairman_min_withdraw),
					'executive_min_withdraw = ' . $db->quote($input['executive_min_withdraw'] ?: $sa->executive_min_withdraw),
					'regular_min_withdraw = ' . $db->quote($input['regular_min_withdraw'] ?: $sa->regular_min_withdraw),
					'associate_min_withdraw = ' . $db->quote($input['associate_min_withdraw'] ?: $sa->associate_min_withdraw),
					'basic_min_withdraw = ' . $db->quote($input['basic_min_withdraw'] ?: $sa->basic_min_withdraw),

					'chairman_min_bal_usd = ' . $db->quote($input['chairman_min_bal_usd'] ?: $sa->chairman_min_bal_usd),
					'executive_min_bal_usd = ' . $db->quote($input['executive_min_bal_usd'] ?: $sa->executive_min_bal_usd),
					'regular_min_bal_usd = ' . $db->quote($input['regular_min_bal_usd'] ?: $sa->regular_min_bal_usd),
					'associate_min_bal_usd = ' . $db->quote($input['associate_min_bal_usd'] ?: $sa->associate_min_bal_usd),
					'basic_min_bal_usd = ' . $db->quote($input['basic_min_bal_usd'] ?: $sa->basic_min_bal_usd),

					'chairman_min_bal_fmc = ' . $db->quote($input['chairman_min_bal_fmc'] ?: $sa->chairman_min_bal_fmc),
					'executive_min_bal_fmc = ' . $db->quote($input['executive_min_bal_fmc'] ?: $sa->executive_min_bal_fmc),
					'regular_min_bal_fmc = ' . $db->quote($input['regular_min_bal_fmc'] ?: $sa->regular_min_bal_fmc),
					'associate_min_bal_fmc = ' . $db->quote($input['associate_min_bal_fmc'] ?: $sa->associate_min_bal_fmc),
					'basic_min_bal_fmc = ' . $db->quote($input['basic_min_bal_fmc'] ?: $sa->basic_min_bal_fmc),

					'chairman_max_request_usd = ' . $db->quote($input['chairman_max_request_usd'] ?: $sa->chairman_max_request_usd),
					'executive_max_request_usd = ' . $db->quote($input['executive_max_request_usd'] ?: $sa->executive_max_request_usd),
					'regular_max_request_usd = ' . $db->quote($input['regular_max_request_usd'] ?: $sa->regular_max_request_usd),
					'associate_max_request_usd = ' . $db->quote($input['associate_max_request_usd'] ?: $sa->associate_max_request_usd),
					'basic_max_request_usd = ' . $db->quote($input['basic_max_request_usd'] ?: $sa->basic_max_request_usd),

					'chairman_min_request_usd = ' . $db->quote($input['chairman_min_request_usd'] ?: $sa->chairman_min_request_usd),
					'executive_min_request_usd = ' . $db->quote($input['executive_min_request_usd'] ?: $sa->executive_min_request_usd),
					'regular_min_request_usd = ' . $db->quote($input['regular_min_request_usd'] ?: $sa->regular_min_request_usd),
					'associate_min_request_usd = ' . $db->quote($input['associate_min_request_usd'] ?: $sa->associate_min_request_usd),
					'basic_min_request_usd = ' . $db->quote($input['basic_min_request_usd'] ?: $sa->basic_min_request_usd),

					'chairman_min_convert_usd = ' . $db->quote($input['chairman_min_convert_usd'] ?: $sa->chairman_min_convert_usd),
					'executive_min_convert_usd = ' . $db->quote($input['executive_min_convert_usd'] ?: $sa->executive_min_convert_usd),
					'regular_min_convert_usd = ' . $db->quote($input['regular_min_convert_usd'] ?: $sa->regular_min_convert_usd),
					'associate_min_convert_usd = ' . $db->quote($input['associate_min_convert_usd'] ?: $sa->associate_min_convert_usd),
					'basic_min_convert_usd = ' . $db->quote($input['basic_min_convert_usd'] ?: $sa->basic_min_convert_usd),

					'chairman_max_convert_usd = ' . $db->quote($input['chairman_max_convert_usd'] ?: $sa->chairman_max_convert_usd),
					'executive_max_convert_usd = ' . $db->quote($input['executive_max_convert_usd'] ?: $sa->executive_max_convert_usd),
					'regular_max_convert_usd = ' . $db->quote($input['regular_max_convert_usd'] ?: $sa->regular_max_convert_usd),
					'associate_max_convert_usd = ' . $db->quote($input['associate_max_convert_usd'] ?: $sa->associate_max_convert_usd),
					'basic_max_convert_usd = ' . $db->quote($input['basic_max_convert_usd'] ?: $sa->basic_max_convert_usd),

					'chairman_min_convert_fmc = ' . $db->quote($input['chairman_min_convert_fmc'] ?: $sa->chairman_min_convert_fmc),
					'executive_min_convert_fmc = ' . $db->quote($input['executive_min_convert_fmc'] ?: $sa->executive_min_convert_fmc),
					'regular_min_convert_fmc = ' . $db->quote($input['regular_min_convert_fmc'] ?: $sa->regular_min_convert_fmc),
					'associate_min_convert_fmc = ' . $db->quote($input['associate_min_convert_fmc'] ?: $sa->associate_min_convert_fmc),
					'basic_min_convert_fmc = ' . $db->quote($input['basic_min_convert_fmc'] ?: $sa->basic_min_convert_fmc),

					'chairman_convert_points_cut = ' . $db->quote($input['chairman_convert_points_cut'] ?: $sa->chairman_convert_points_cut),
					'executive_convert_points_cut = ' . $db->quote($input['executive_convert_points_cut'] ?: $sa->executive_convert_points_cut),
					'regular_convert_points_cut = ' . $db->quote($input['regular_convert_points_cut'] ?: $sa->regular_convert_points_cut),
					'associate_convert_points_cut = ' . $db->quote($input['associate_convert_points_cut'] ?: $sa->associate_convert_points_cut),
					'basic_convert_points_cut = ' . $db->quote($input['basic_convert_points_cut'] ?: $sa->basic_convert_points_cut),

					'chairman_convert_points_usd = ' . $db->quote($input['chairman_convert_points_usd'] ?: $sa->chairman_convert_points_usd),
					'executive_convert_points_usd = ' . $db->quote($input['executive_convert_points_usd'] ?: $sa->executive_convert_points_usd),
					'regular_convert_points_usd = ' . $db->quote($input['regular_convert_points_usd'] ?: $sa->regular_convert_points_usd),
					'associate_convert_points_usd = ' . $db->quote($input['associate_convert_points_usd'] ?: $sa->associate_convert_points_usd),
					'basic_convert_points_usd = ' . $db->quote($input['basic_convert_points_usd'] ?: $sa->basic_convert_points_usd),

					'chairman_savings_target = ' . $db->quote($input['chairman_savings_target'] ?: $sa->chairman_savings_target),
					'executive_savings_target = ' . $db->quote($input['executive_savings_target'] ?: $sa->executive_savings_target),
					'regular_savings_target = ' . $db->quote($input['regular_savings_target'] ?: $sa->regular_savings_target),
					'associate_savings_target = ' . $db->quote($input['associate_savings_target'] ?: $sa->associate_savings_target),
					'basic_savings_target = ' . $db->quote($input['basic_savings_target'] ?: $sa->basic_savings_target),

					'chairman_savings_min_bal = ' . $db->quote($input['chairman_savings_min_bal'] ?: $sa->chairman_savings_min_bal),
					'executive_savings_min_bal = ' . $db->quote($input['executive_savings_min_bal'] ?: $sa->executive_savings_min_bal),
					'regular_savings_min_bal = ' . $db->quote($input['regular_savings_min_bal'] ?: $sa->regular_savings_min_bal),
					'associate_savings_min_bal = ' . $db->quote($input['associate_savings_min_bal'] ?: $sa->associate_savings_min_bal),
					'basic_savings_min_bal = ' . $db->quote($input['basic_savings_min_bal'] ?: $sa->basic_savings_min_bal),

					'referral_mode = ' . $db->quote($input['referral_mode'] ?: $sa->referral_mode),
					'withdrawal_mode = ' . $db->quote($input['withdrawal_mode'] ?: $sa->withdrawal_mode),
					'cd_mode = ' . $db->quote($input['cd_mode'] ?: $sa->cd_mode),

					'efund_name = ' . $db->quote($input['efund_name'] ?: $sa->efund_name),
					'share_fund_name = ' . $db->quote($input['share_fund_name'] ?: $sa->share_fund_name),
					'loan_fund_name = ' . $db->quote($input['loan_fund_name'] ?: $sa->loan_fund_name),
					'p2p_price_buffer = ' . $db->quote($input['p2p_price_buffer'] ?: $sa->p2p_price_buffer)/*,
					'freezer = ' . $db->quote($input['freezer'] ?: $sa->freezer)*/
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		$app->redirect(Uri::root(true) . '/' . sef(94),
			'Ancillary Settings Updated Successfully!', 'success');
	}
}

/**
 *
 * @return mixed
 *
 * @since version
 */
function get_currency()
{
	return db()->setQuery(
		'SELECT currency ' .
		'FROM network_settings_ancillaries'
	)->loadObject()->currency;
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function currency($value): string
{
	return get_currency() === $value ? 'selected' : '';
}

/**
 *
 * @return mixed
 *
 * @since version
 */
function get_payment_mode()
{
	return db()->setQuery(
		'SELECT payment_mode ' .
		'FROM network_settings_ancillaries'
	)->loadObject()->payment_mode;
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function payment_mode($value): string
{
	return get_payment_mode() === $value ? 'selected' : '';
}

/**
 *
 * @return mixed
 *
 * @since version
 */
function get_referral_mode()
{
	return db()->setQuery(
		'SELECT referral_mode ' .
		'FROM network_settings_ancillaries'
	)->loadObject()->referral_mode;
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function referral_mode($value): string
{
	return get_referral_mode() === $value ? 'selected' : '';
}

/**
 *
 * @return mixed
 *
 * @since version
 */
function get_withdrawal_mode()
{
	return db()->setQuery(
		'SELECT withdrawal_mode ' .
		'FROM network_settings_ancillaries'
	)->loadObject()->withdrawal_mode;
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function withdrawal_mode($value): string
{
	return get_withdrawal_mode() === $value ? 'selected' : '';
}

/**
 *
 * @return mixed
 *
 * @since version
 */
function get_cd_mode()
{
	return db()->setQuery(
		'SELECT cd_mode ' .
		'FROM network_settings_ancillaries'
	)->loadObject()->cd_mode;
}

/**
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function cd_mode($value): string
{
	return get_cd_mode() === $value ? 'selected' : '';
}

/**
 *
 * @return string
 *
 * @since version
 */
function style(): string
{
	return '<style>
		.table th, .table td {
			vertical-align: middle;
			text-align: center;
		}
		
        .net_align {
            width: auto;
            text-align: center;
        }
        
        .center_align {
        	text-align: center;
        	display: block;    
        	margin: 0;
        }   
        
        label {
        	margin-bottom: 0;
        }       

        select {
            text-align-last: center;
            direction: ltr;
        }
    </style>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view(): string
{
	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
    <form method="post">';

	$str .= view_min_withdraw();
	$str .= view_min_request_efund();
	$str .= view_max_request_efund();
	$str .= view_min_convert_efund();
	$str .= view_max_convert_efund();
	$str .= view_min_convert_token();
	$str .= view_min_convert_token();
	$str .= view_convert_points_cut();
	$str .= view_convert_points_usd();
	$str .= view_savings_target();
	$str .= view_savings_min_bal();
	$str .= view_min_bal_token();
	$str .= view_table_min_bal();
	$str .= view_table_fees();
	$str .= view_table_profile_admin();

	$str .= '<div class="center_align">
            <input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
        </div>
    </form>
    </div></div></section>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_min_withdraw(): string
{
	$settings_entry       = settings('entry');
	$settings_ancillaries = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Minimum Withdraw (' . $settings_ancillaries->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_min_withdraw"
                                      value="' . number_format($settings_ancillaries->chairman_min_withdraw, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_min_withdraw"
                                      value="' . number_format($settings_ancillaries->executive_min_withdraw, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_min_withdraw"
                                      value="' . number_format($settings_ancillaries->regular_min_withdraw, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_min_withdraw"
                                      value="' . number_format($settings_ancillaries->associate_min_withdraw, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_min_withdraw"
                                      value="' . number_format($settings_ancillaries->basic_min_withdraw, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_min_request_efund(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Minimum Request (' . $sa->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_min_request_usd"
                                      value="' . number_format($sa->chairman_min_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_min_request_usd"
                                      value="' . number_format($sa->executive_min_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_min_request_usd"
                                      value="' . number_format($sa->regular_min_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_min_request_usd"
                                      value="' . number_format($sa->associate_min_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_min_request_usd"
                                      value="' . number_format($sa->basic_min_request_usd, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_max_request_efund(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Maximum Request (' . $sa->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_max_request_usd"
                                      value="' . number_format($sa->chairman_max_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_max_request_usd"
                                      value="' . number_format($sa->executive_max_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_max_request_usd"
                                      value="' . number_format($sa->regular_max_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_max_request_usd"
                                      value="' . number_format($sa->associate_max_request_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_max_request_usd"
                                      value="' . number_format($sa->basic_max_request_usd, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_min_convert_efund(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Minimum Convert (' . $sa->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_min_convert_usd"
                                      value="' . number_format($sa->chairman_min_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_min_convert_usd"
                                      value="' . number_format($sa->executive_min_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_min_convert_usd"
                                      value="' . number_format($sa->regular_min_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_min_convert_usd"
                                      value="' . number_format($sa->associate_min_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_min_convert_usd"
                                      value="' . number_format($sa->basic_min_convert_usd, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

function view_max_convert_efund(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Maximum Convert / Cycle (' . $sa->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_max_convert_usd"
                                      value="' . number_format($sa->chairman_max_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_max_convert_usd"
                                      value="' . number_format($sa->executive_max_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_max_convert_usd"
                                      value="' . number_format($sa->regular_max_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_max_convert_usd"
                                      value="' . number_format($sa->associate_max_convert_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_max_convert_usd"
                                      value="' . number_format($sa->basic_max_convert_usd, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

function view_convert_points_cut(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Conversion Cut (%)</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_convert_points_cut"
                                      value="' .
		number_format($sa->chairman_convert_points_cut, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_convert_points_cut"
                                      value="' .
		number_format($sa->executive_convert_points_cut, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_convert_points_cut"
                                      value="' .
		number_format($sa->regular_convert_points_cut, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_convert_points_cut"
                                      value="' .
		number_format($sa->associate_convert_points_cut, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_convert_points_cut"
                                      value="' .
		number_format($sa->basic_convert_points_cut, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

function view_convert_points_usd(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Conversion Cut Rate (' . $sa->efund_name . '/pts.)</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_convert_points_usd"
                                      value="' .
		number_format($sa->chairman_convert_points_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_convert_points_usd"
                                      value="' .
		number_format($sa->executive_convert_points_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_convert_points_usd"
                                      value="' .
		number_format($sa->regular_convert_points_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_convert_points_usd"
                                      value="' .
		number_format($sa->associate_convert_points_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_convert_points_usd"
                                      value="' .
		number_format($sa->basic_convert_points_usd, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

function view_savings_target(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Savings Target (' . $sa->efund_name . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_savings_target"
                                      value="' .
		number_format($sa->chairman_savings_target, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_savings_target"
                                      value="' .
		number_format($sa->executive_savings_target, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_savings_target"
                                      value="' .
		number_format($sa->regular_savings_target, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_savings_target"
                                      value="' .
		number_format($sa->associate_savings_target, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_savings_target"
                                      value="' .
		number_format($sa->basic_savings_target, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

function view_savings_min_bal(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Savings Minimum Balance (' . $sa->efund_name . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_savings_min_bal"
                                      value="' .
		number_format($sa->chairman_savings_min_bal, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_savings_min_bal"
                                      value="' .
		number_format($sa->executive_savings_min_bal, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_savings_min_bal"
                                      value="' .
		number_format($sa->regular_savings_min_bal, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_savings_min_bal"
                                      value="' .
		number_format($sa->associate_savings_min_bal, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_savings_min_bal"
                                      value="' .
		number_format($sa->basic_savings_min_bal, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_min_convert_token(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');
	$sp = settings('plans');
	$st = settings('trading');

	return !$sp->trading ? '' :
		'<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Minimum Convert (' . $st->token_name . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_min_convert_fmc"
                                      value="' .
		number_format($sa->chairman_min_convert_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_min_convert_fmc"
                                      value="' .
		number_format($sa->executive_min_convert_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_min_convert_fmc"
                                      value="' .
		number_format($sa->regular_min_convert_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_min_convert_fmc"
                                      value="' .
		number_format($sa->associate_min_convert_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_min_convert_fmc"
                                      value="' .
		number_format($sa->basic_min_convert_fmc, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_min_bal_token(): string
{
	$se = settings('entry');
	$sa = settings('ancillaries');
	$sp = settings('plans');
	$st = settings('trading');

	return !$sp->trading ? '' :
		'<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Minimum Balance (' . $st->token_name . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_min_bal_fmc"
                                      value="' .
		number_format($sa->chairman_min_bal_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_min_bal_fmc"
                                      value="' .
		number_format($sa->executive_min_bal_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_min_bal_fmc"
                                      value="' .
		number_format($sa->regular_min_bal_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_min_bal_fmc"
                                      value="' .
		number_format($sa->associate_min_bal_fmc, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_min_bal_fmc"
                                      value="' .
		number_format($sa->basic_min_bal_fmc, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_min_bal(): string
{
	$settings_entry       = settings('entry');
	$settings_ancillaries = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Minimum Balance (' . $settings_ancillaries->currency . ')</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>
            <tr>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="chairman_min_bal_usd"
                                      value="' . number_format($settings_ancillaries->chairman_min_bal_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="executive_min_bal_usd"
                                      value="' . number_format($settings_ancillaries->executive_min_bal_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="regular_min_bal_usd"
                                      value="' . number_format($settings_ancillaries->regular_min_bal_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="associate_min_bal_usd"
                                      value="' . number_format($settings_ancillaries->associate_min_bal_usd, 8) . '"></label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="basic_min_bal_usd"
                                      value="' . number_format($settings_ancillaries->basic_min_bal_usd, 8) . '"></label>
                    </div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_fees(): string
{
	$settings_ancillaries = settings('ancillaries');

	return '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="2"><h3 class="center_align">Registration</h3></td>
                <td colspan="3"><h3 class="center_align">Withdrawal</h3></td>
            </tr>
            <tr>
                <td><h4 class="center_align">Payment Mode</h4></td>
                <td><h4 class="center_align">Grace Period (days)</h4></td>  
                <td><h4 class="center_align">Mode</h4></td>              
                <td><h4 class="center_align">Cybercharge (%)</h4></td>
                <td><h4 class="center_align">Processing Fee (' . $settings_ancillaries->currency . ')</h4></td>               
            </tr>
            <tr>
                <td>
                    <div class="center_align"><label><select name="payment_mode" style="width:150px">
                                <option value="CODE" ' . payment_mode('CODE') . '>CODE</option>
                                <option value="ECASH" ' . payment_mode('ECASH') . '>ECASH</option>
                            </select></label></div>
                </td>
                 <td>
                    <div class="center_align">
                        <label><input class="net_align" name="grace_period"
                                      value="' . $settings_ancillaries->grace_period . '"></label></div>
                </td> 
                <td>
                    <div class="center_align"><label><select name="withdrawal_mode" style="width:150px">
                                <option value="standard" ' . withdrawal_mode('standard') . '>Standard</option>
                                <option value="coin" ' . withdrawal_mode('coin') . '>Coin</option>
                            </select></label></div>
                </td>               
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="cybercharge"
                                      value="' .
		number_format($settings_ancillaries->cybercharge, 5) . '"></label></div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input class="net_align" name="processing_fee"
                                      value="' .
		number_format($settings_ancillaries->processing_fee, 8) . '"></label></div>
                </td>
            </tr>
        </table>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_profile_admin(): string
{
	$settings_ancillaries = settings('ancillaries');

	$str = '<table class="category table table-striped table-bordered table-hover">
            <tr>
                <td colspan="5"><h3 class="center_align">Company Profile</h3></td>                
            </tr>';

	$str .= '<tr>                               
                <td><h4 class="center_align">Official Email</h4></td>
                <td colspan="2"><h4 class="center_align">Company Name</h4></td>
             	<td><h4 class="center_align">Commission Deduct</h4></td>
             	<td><h4 class="center_align">Referral Mode</h4></td>                          	
            </tr>
            <tr>                             
                <td>
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="email_official"
                                      value="' . $settings_ancillaries->email_official . '"></label></div>
                </td>
                <td colspan="2">
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="company_name"
                                      value="' . $settings_ancillaries->company_name . '"></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="cd_mode" style="width:150px">
                                <option value="cd" ' . cd_mode('cd') . '>CD</option>
                                <option value="no_cd" ' . cd_mode('no_cd') . '>No CD</option>
                            </select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="referral_mode" style="width:150px">
                                <option value="standard" ' . referral_mode('standard') . '>Standard</option>
                                <option value="outright" ' . referral_mode('outright') . '>Outright</option>
                            </select></label></div>
                </td>                        
            </tr>';

	$str .= '<tr> 
				<td><h4 class="center_align">Currency</h4></td>                             
             	<td><h4 class="center_align">E-Fund Name</h4></td>
             	<td><h4 class="center_align">Share-Fund Name</h4></td>
             	<td colspan="2"><h4 class="center_align">Loan-Fund Name</h4></td>
             	<!--<td><h4 class="center_align">P2P Buffer (%)</h4></td>-->
             	<!--<td><h4 class="center_align">Freezer (%)</h4></td>-->
            </tr>
            <tr>    
            	<td>
                    <div class="center_align"><label><select name="currency" style="width:150px">
                                <option value="BNB" ' . currency('BNB') . '>BNB</option>
                                <option value="SHIB" ' . currency('SHIB') . '>SHIB</option>
                                <option value="TRX" ' . currency('TRX') . '>TRX</option>
                                <option value="BUSD" ' . currency('BUSD') . '>BUSD</option>' . /*'
                                <option value="GOLD" ' . currency('GOLD') . '>GOLD</option>' .*/ /*'
                                <option value="P2P" ' . currency('P2P') . '>P2P</option>' .*/ '
                                <option value="BCH" ' . currency('BCH') . '>BCH</option>' . /*'
                                <option value="BTCW" ' . currency('BTCW') . '>BTCW</option>' .*/ /*'
                                <option value="PAC" ' . currency('PAC') . '>PAC</option>' .*/ '
                                <option value="PESO" ' . currency('PESO') . '>PESO</option>' . '
								<option value="USDT" ' . currency('USDT') . '>USDT</option>
								<option value="B2P" ' . currency('B2P') . '>B2P</option>
								<option value="AET" ' . currency('AET') . '>AET</option>
								<option value="AET" ' . currency('TPAY') . '>TPAY</option>
                                ' . /* */
		'
                                <option value="USD" ' . currency('USD') . '>USD</option>
                                <option value="PHP" ' . currency('PHP') . '>PHP</option>
                                ' . /* */
		'
                            </select></label></div>
                </td>                        
                <td>
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="efund_name"
                                      value="' . $settings_ancillaries->efund_name . '"></label></div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="share_fund_name"
                                      value="' . $settings_ancillaries->share_fund_name . '"></label></div>
                </td>
                <td colspan="2">
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="loan_fund_name"
                                      value="' . $settings_ancillaries->loan_fund_name . '"></label></div>
                </td>' /*. '
                <td>
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="p2p_price_buffer"
                                      value="' . $settings_ancillaries->p2p_price_buffer . '"></label></div>
                </td>'*/ . /*'
                <td>
                    <div class="center_align">
                        <label><input type="text" class="net_align" name="freezer"
                                      value="' . $settings_ancillaries->freezer . '"></label></div>
                </td>' . */
		'
            </tr>';

	$str .= '</table>';

	return $str;
}