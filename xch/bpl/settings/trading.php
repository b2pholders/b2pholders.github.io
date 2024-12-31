<?php

namespace BPL\Settings\Trading;

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
		'chairman_fmc' => input_get('chairman_fmc'),
		'executive_fmc' => input_get('executive_fmc'),
		'regular_fmc'   => input_get('regular_fmc'),
		'associate_fmc' => input_get('associate_fmc'),
		'basic_fmc'     => input_get('basic_fmc'),
		'starter_fmc'   => input_get('starter_fmc'),

		'fmc_to_usd'    => input_get('fmc_to_usd'),
		'fmc_to_btc3'   => input_get('fmc_to_btc3'),
		'token_name'    => input_get('token_name'),
		'donation_name' => input_get('donation_name'),

		'vlt_min_stock'   => input_get('vlt_min_stock'),
		'vlt_buy_charge'  => input_get('vlt_buy_charge'),
		'vlt_sell_charge' => input_get('vlt_sell_charge'),
		'merchant_share'  => input_get('merchant_share'),

		'trade_buy_charge'  => input_get('trade_buy_charge'),
		'trade_sell_charge' => input_get('trade_sell_charge'),

		'chairman_minimum_bal_fmc' => input_get('chairman_minimum_bal_fmc'),
		'executive_minimum_bal_fmc' => input_get('executive_minimum_bal_fmc'),
		'regular_minimum_bal_fmc'   => input_get('regular_minimum_bal_fmc'),
		'associate_minimum_bal_fmc' => input_get('associate_minimum_bal_fmc'),
		'basic_minimum_bal_fmc'     => input_get('basic_minimum_bal_fmc'),
		'starter_minimum_bal_fmc'   => input_get('starter_minimum_bal_fmc'),

		'chairman_minimum_buy' => input_get('chairman_minimum_buy'),
		'executive_minimum_buy' => input_get('executive_minimum_buy'),
		'regular_minimum_buy'   => input_get('regular_minimum_buy'),
		'associate_minimum_buy' => input_get('associate_minimum_buy'),
		'basic_minimum_buy'     => input_get('basic_minimum_buy'),
		'starter_minimum_buy'   => input_get('starter_minimum_buy'),

		'chairman_maximum_buy' => input_get('chairman_maximum_buy'),
		'executive_maximum_buy' => input_get('executive_maximum_buy'),
		'regular_maximum_buy'   => input_get('regular_maximum_buy'),
		'associate_maximum_buy' => input_get('associate_maximum_buy'),
		'basic_maximum_buy'     => input_get('basic_maximum_buy'),
		'starter_maximum_buy'   => input_get('starter_maximum_buy'),

		'chairman_minimum_sell' => input_get('chairman_minimum_sell'),
		'executive_minimum_sell' => input_get('executive_minimum_sell'),
		'regular_minimum_sell'   => input_get('regular_minimum_sell'),
		'associate_minimum_sell' => input_get('associate_minimum_sell'),
		'basic_minimum_sell'     => input_get('basic_minimum_sell'),
		'starter_minimum_sell'   => input_get('starter_minimum_sell'),

		'chairman_minimum_transfer' => input_get('chairman_minimum_transfer'),
		'executive_minimum_transfer' => input_get('executive_minimum_transfer'),
		'regular_minimum_transfer'   => input_get('regular_minimum_transfer'),
		'associate_minimum_transfer' => input_get('associate_minimum_transfer'),
		'basic_minimum_transfer'     => input_get('basic_minimum_transfer'),
		'starter_minimum_transfer'   => input_get('starter_minimum_transfer'),

		'chairman_transfer_fee' => input_get('chairman_transfer_fee'),
		'executive_transfer_fee' => input_get('executive_transfer_fee'),
		'regular_transfer_fee'   => input_get('regular_transfer_fee'),
		'associate_transfer_fee' => input_get('associate_transfer_fee'),
		'basic_transfer_fee'     => input_get('basic_transfer_fee'),
		'starter_transfer_fee'   => input_get('starter_transfer_fee')
	];
}

/**
 *
 *
 * @since version
 */
function update()
{
	$db = db();

	$input = get_input();

	$test = [
		$input['chairman_fmc'],
		$input['executive_fmc'],
		$input['regular_fmc'],
		$input['associate_fmc'],
		$input['basic_fmc'],
		$input['starter_fmc'],

		$input['fmc_to_usd'],
		$input['fmc_to_btc3'],

		$input['vlt_min_stock'],
		$input['vlt_buy_charge'],
		$input['vlt_sell_charge'],

		$input['trade_buy_charge'],
		$input['trade_sell_charge'],

		$input['chairman_minimum_bal_fmc'],
		$input['executive_minimum_bal_fmc'],
		$input['regular_minimum_bal_fmc'],
		$input['associate_minimum_bal_fmc'],
		$input['basic_minimum_bal_fmc'],
		$input['starter_minimum_bal_fmc'],

		$input['chairman_minimum_buy'],
		$input['executive_minimum_buy'],
		$input['regular_minimum_buy'],
		$input['associate_minimum_buy'],
		$input['basic_minimum_buy'],
		$input['starter_minimum_buy'],

		$input['chairman_maximum_buy'],
		$input['executive_maximum_buy'],
		$input['regular_maximum_buy'],
		$input['associate_maximum_buy'],
		$input['basic_maximum_buy'],
		$input['starter_maximum_buy'],

		$input['chairman_minimum_sell'],
		$input['executive_minimum_sell'],
		$input['regular_minimum_sell'],
		$input['associate_minimum_sell'],
		$input['basic_minimum_sell'],
		$input['starter_minimum_sell']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_trading',
				[
					'chairman_fmc = ' . $db->quote($input['chairman_fmc']),
					'executive_fmc = ' . $db->quote($input['executive_fmc']),
					'regular_fmc = ' . $db->quote($input['regular_fmc']),
					'associate_fmc = ' . $db->quote($input['associate_fmc']),
					'basic_fmc = ' . $db->quote($input['basic_fmc']),
					'starter_fmc = ' . $db->quote($input['starter_fmc']),

					'fmc_to_usd = ' . $db->quote($input['fmc_to_usd']),
					'fmc_to_btc3 = ' . $db->quote($input['fmc_to_btc3']),
					'token_name = ' . $db->quote($input['token_name']),
					'donation_name = ' . $db->quote($input['donation_name']),

					'vlt_min_stock = ' . $db->quote($input['vlt_min_stock']),
					'vlt_buy_charge = ' . $db->quote($input['vlt_buy_charge']),
					'vlt_sell_charge = ' . $db->quote($input['vlt_sell_charge']),
					'merchant_share = ' . $db->quote($input['merchant_share']),

					'trade_buy_charge = ' . $db->quote($input['trade_buy_charge']),
					'trade_sell_charge = ' . $db->quote($input['trade_sell_charge']),

					'chairman_minimum_bal_fmc = ' . $db->quote($input['chairman_minimum_bal_fmc']),
					'executive_minimum_bal_fmc = ' . $db->quote($input['executive_minimum_bal_fmc']),
					'regular_minimum_bal_fmc = ' . $db->quote($input['regular_minimum_bal_fmc']),
					'associate_minimum_bal_fmc = ' . $db->quote($input['associate_minimum_bal_fmc']),
					'basic_minimum_bal_fmc = ' . $db->quote($input['basic_minimum_bal_fmc']),
					'starter_minimum_bal_fmc = ' . $db->quote($input['starter_minimum_bal_fmc']),

					'chairman_minimum_buy = ' . $db->quote($input['chairman_minimum_buy']),
					'executive_minimum_buy = ' . $db->quote($input['executive_minimum_buy']),
					'regular_minimum_buy = ' . $db->quote($input['regular_minimum_buy']),
					'associate_minimum_buy = ' . $db->quote($input['associate_minimum_buy']),
					'basic_minimum_buy = ' . $db->quote($input['basic_minimum_buy']),
					'starter_minimum_buy = ' . $db->quote($input['starter_minimum_buy']),

					'chairman_maximum_buy = ' . $db->quote($input['chairman_maximum_buy']),
					'executive_maximum_buy = ' . $db->quote($input['executive_maximum_buy']),
					'regular_maximum_buy = ' . $db->quote($input['regular_maximum_buy']),
					'associate_maximum_buy = ' . $db->quote($input['associate_maximum_buy']),
					'basic_maximum_buy = ' . $db->quote($input['basic_maximum_buy']),
					'starter_maximum_buy = ' . $db->quote($input['starter_maximum_buy']),

					'chairman_minimum_sell = ' . $db->quote($input['chairman_minimum_sell']),
					'executive_minimum_sell = ' . $db->quote($input['executive_minimum_sell']),
					'regular_minimum_sell = ' . $db->quote($input['regular_minimum_sell']),
					'associate_minimum_sell = ' . $db->quote($input['associate_minimum_sell']),
					'basic_minimum_sell = ' . $db->quote($input['basic_minimum_sell']),
					'starter_minimum_sell = ' . $db->quote($input['starter_minimum_sell']),

					'chairman_minimum_transfer = ' . $db->quote($input['chairman_minimum_transfer']),
					'executive_minimum_transfer = ' . $db->quote($input['executive_minimum_transfer']),
					'regular_minimum_transfer = ' . $db->quote($input['regular_minimum_transfer']),
					'associate_minimum_transfer = ' . $db->quote($input['associate_minimum_transfer']),
					'basic_minimum_transfer = ' . $db->quote($input['basic_minimum_transfer']),
					'starter_minimum_transfer = ' . $db->quote($input['starter_minimum_transfer']),

					'chairman_transfer_fee = ' . $db->quote($input['chairman_transfer_fee']),
					'executive_transfer_fee = ' . $db->quote($input['executive_transfer_fee']),
					'regular_transfer_fee = ' . $db->quote($input['regular_transfer_fee']),
					'associate_transfer_fee = ' . $db->quote($input['associate_transfer_fee']),
					'basic_transfer_fee = ' . $db->quote($input['basic_transfer_fee']),
					'starter_transfer_fee = ' . $db->quote($input['starter_transfer_fee'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(92),
			settings('plans')->trading_name . ' Settings Updated Successfully!', 'success');
	}
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
            width: 120px;
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

	$str .= view_table_merchant();
	$str .= view_table_trader_conversion();
	$str .= view_table_trading();

	$str .= '		
		<div class="center_align">
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
function view_table_trading(): string
{
	$settings_entry = settings('entry');

	$str = '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="7"><h3 class="center_align">Trading</h3></td>
			</tr>
			<tr>
				<td></td>
				<td><h4 class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
				<td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
				<td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
				<td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
				<td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
				<td><h4 class="center_align">' . $settings_entry->starter_package_name . '</h4></td>
			</tr>';

	$str .= view_row_entry();
	$str .= view_row_min_bal();
	$str .= view_row_min_buy();
	$str .= view_row_max_buy();
	$str .= view_row_min_sell();
	$str .= view_row_min_transfer();
	$str .= view_row_transfer_fee();

	$str .= '</table>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_entry(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">Entry (' . $settings_trading->token_name . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->executive_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->regular_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->associate_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->basic_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->starter_fmc, 8) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_min_bal(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">Minimum Balance (' . $settings_trading->token_name . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_minimum_bal_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_minimum_bal_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_minimum_bal_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->executive_minimum_bal_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_minimum_bal_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->regular_minimum_bal_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_minimum_bal_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->associate_minimum_bal_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_minimum_bal_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->basic_minimum_bal_fmc, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_minimum_bal_fmc" class="net_align"
							       value="' .
		number_format($settings_trading->starter_minimum_bal_fmc, 8) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_min_buy(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">Minimum Buy (' . $settings_trading->token_name . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_minimum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_minimum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_minimum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->executive_minimum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_minimum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->regular_minimum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_minimum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->associate_minimum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_minimum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->basic_minimum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_minimum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->starter_minimum_buy, 8) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_max_buy(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">Maximum Buy (' . $settings_trading->token_name . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_maximum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_maximum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_maximum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->executive_maximum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_maximum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->regular_maximum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_maximum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->associate_maximum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_maximum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->basic_maximum_buy, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_maximum_buy" class="net_align"
							       value="' .
		number_format($settings_trading->starter_maximum_buy, 8) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_min_sell(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">Minimum Sell (' . $settings_trading->token_name . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_minimum_sell" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_minimum_sell, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_minimum_sell" class="net_align"
							       value="' .
		number_format($settings_trading->executive_minimum_sell, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_minimum_sell" class="net_align"
							       value="' .
		number_format($settings_trading->regular_minimum_sell, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_minimum_sell" class="net_align"
							       value="' .
		number_format($settings_trading->associate_minimum_sell, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_minimum_sell" class="net_align"
							       value="' .
		number_format($settings_trading->basic_minimum_sell, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_minimum_sell" class="net_align"
							       value="' .
		number_format($settings_trading->starter_minimum_sell, 8) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_min_transfer(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">Minimum Transfer (' . $settings_trading->token_name . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_minimum_transfer" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_minimum_transfer, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_minimum_transfer" class="net_align"
							       value="' .
		number_format($settings_trading->executive_minimum_transfer, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_minimum_transfer" class="net_align"
							       value="' .
		number_format($settings_trading->regular_minimum_transfer, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_minimum_transfer" class="net_align"
							       value="' .
		number_format($settings_trading->associate_minimum_transfer, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_minimum_transfer" class="net_align"
							       value="' .
		number_format($settings_trading->basic_minimum_transfer, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_minimum_transfer" class="net_align"
							       value="' .
		number_format($settings_trading->starter_minimum_transfer, 8) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_transfer_fee(): string
{
	$settings_trading = settings('trading');

	return '<tr>
				<td>
					<div class="center_align">' . $settings_trading->token_name .
		' Transfer Fee (' . settings('ancillaries')->currency . ')</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="chairman_transfer_fee" class="net_align"
							       value="' .
		number_format($settings_trading->chairman_transfer_fee, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="executive_transfer_fee" class="net_align"
							       value="' .
		number_format($settings_trading->executive_transfer_fee, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="regular_transfer_fee" class="net_align"
							       value="' .
		number_format($settings_trading->regular_transfer_fee, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="associate_transfer_fee" class="net_align"
							       value="' .
		number_format($settings_trading->associate_transfer_fee, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="basic_transfer_fee" class="net_align"
							       value="' .
		number_format($settings_trading->basic_transfer_fee, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="starter_transfer_fee" class="net_align"
							       value="' .
		number_format($settings_trading->starter_transfer_fee, 2) . '"></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_table_trader_conversion(): string
{
	$settings_trading = settings('trading');

	return '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="2"><h3 class="center_align">Trader</h3></td>
				<td colspan="5"><h3 class="center_align">Conversion</h3></td>
			</tr>
			<tr>
				<td><h4 class="center_align">Buy Charges (%)</h4></td>
				<td><h4 class="center_align">Sell Charges (%)</h4></td>
				<td><h4 class="center_align">' . $settings_trading->token_name . '</h4></td>
				<td><h4 class="center_align">BTC</h4></td>
				<td><h4 class="center_align">BTC3</h4></td>
				<td><h4 class="center_align">Token Name</h4></td>
				<td><h4 class="center_align">Donation Name</h4></td>
			</tr>
			<tr>
				<td>
					<div class="center_align"><label>
							<input name="trade_buy_charge" class="net_align"
							       value="' .
		number_format($settings_trading->trade_buy_charge, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="trade_sell_charge" class="net_align"
							       value="' .
		number_format($settings_trading->trade_sell_charge, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align">1</div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="fmc_to_usd" class="net_align"
							       value="' .
		number_format($settings_trading->fmc_to_usd, 12) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="fmc_to_btc3" class="net_align"
							       value="' .
		number_format($settings_trading->fmc_to_btc3, 12) . '"></label></div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" class="net_align" name="token_name"
						              value="' . $settings_trading->token_name . '"></label></div>
				</td>
				<td>
					<div class="center_align">
						<label><input type="text" class="net_align" name="donation_name"
						              value="' . $settings_trading->donation_name . '"></label></div>
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
function view_table_merchant(): string
{
	$settings_trading = settings('trading');

	return '<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="4"><h3 class="center_align">Merchant</h3></td>
			</tr>
			<tr>
				<td><h4 class="center_align">Min. Stock</h4></td>
				<td><h4 class="center_align">Buy Charges (%)</h4></td>
				<td><h4 class="center_align">Sell Charges (%)</h4></td>
				<td><h4 class="center_align">Global Share (%)</h4></td>
			</tr>
			<tr>
				<td>
					<div class="center_align"><label>
							<input name="vlt_min_stock" class="net_align"
							       value="' .
		number_format($settings_trading->vlt_min_stock, 8) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="vlt_buy_charge" class="net_align"
							       value="' .
		number_format($settings_trading->vlt_buy_charge, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="vlt_sell_charge" class="net_align"
							       value="' .
		number_format($settings_trading->vlt_sell_charge, 2) . '"></label></div>
				</td>
				<td>
					<div class="center_align"><label>
							<input name="merchant_share" class="net_align"
							       value="' .
		number_format($settings_trading->merchant_share, 2) . '"></label></div>
				</td>
			</tr>
		</table>';
}