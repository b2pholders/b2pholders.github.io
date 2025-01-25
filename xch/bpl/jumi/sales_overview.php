<?php

namespace BPL\Jumi\Sales_Overview;

require_once 'bpl/menu.php';
require_once 'bpl/mods/helpers.php';

use Joomla\CMS\Uri\Uri;

use function BPL\Menu\admin;
use function BPL\Menu\admin as menu_admin;

use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\users;
use function BPL\Mods\Helpers\page_reload;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$usertype = session_get('usertype');
	$admintype = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id = session_get('user_id');
	$username = session_get('username');

	page_validate($usertype);

	$str = menu_admin($admintype, $account_type, $user_id, $username);

	$str .= page_reload();

	$str .= view_sales();

	echo $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_sales(): string
{
	$currency = settings('ancillaries')->currency;

	$total_sales = income_admin();

	$total_sales = $total_sales->income_total ?? 0;

	$cd_sales = cd_sales();

	$total_payouts = /* payouts() */ total_efund_convert();

	// $total_payouts = $total_payouts->payout_total ?? 0;

	$fmc_purchase = token()->purchase_fmc ?? 0;

	$net_sales = $total_sales - $cd_sales - $total_payouts - $fmc_purchase;

	$str = '<h2>Cash Flow</h2>
		<table class="category table table-striped table-bordered table-hover" style="width:900px;">
			<tr>
				<td style="width: 21%">Registrations:</td>
				<td style="width: 43%">' . count(users()) . '
					<a style="float:right" href="' . sef(40) . '">View All Accounts</a>
				</td>
			</tr>
			<tr>
				<td>Total Package Entries:</td>
				<td>' . number_format($total_sales, 5) . ' ' . $currency . '
					<a style="float:right" href="' . sef(35) . '">View Total Cash-in</a>
				</td>
			</tr>' . /* '
								<tr>
									<td>CD Sales:</td>
									<td>' . number_format($cd_sales, 5) . ' ' . $currency . '
									</td>
								</tr>' . */ '
			<tr>
				<td>Total Payouts:</td>
				<td>' . number_format($total_payouts, 5) . ' ' . $currency . '
					<a style="float:right" href="' . sef(59) . '">View All Completed Withdrawls</a>
				</td>
			</tr>';

	if (settings('plans')->trading) {
		$str .= '<tr>
					<td>' . settings('trading')->token_name . ' Profit:</td>
					<td>' . number_format($fmc_purchase, 5) . ' ' . $currency . '</td>
				</tr>';
	}

	$str .= '<tr>
				<td>Net Remaining Balance:</td>
				<td>' . number_format($net_sales, 5) . ' ' . $currency . '</td>
			</tr>
		</table>';

	return $str;
}

function total_efund_convert()
{
	return db()->setQuery(
		'SELECT conversion_total 
        FROM network_efund_conversions 
        ORDER BY conversion_date DESC'
	)->loadResult();
}

/**
 * @param $usertype
 *
 *
 * @since version
 */
function page_validate($usertype)
{
	if ($usertype !== 'Admin' && $usertype !== 'manager') {
		application()->redirect(Uri::root(true) . '/' . sef(43));
	}
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
		'SELECT income_total ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 *
 * @return float|int
 *
 * @since version
 */
function cd_sales()
{
	$se = settings('entry');

	$cd_codes = db()->setQuery(
		'SELECT * FROM network_codes WHERE type LIKE \'%cd%\' AND user_id <> 0;'
	)->loadObjectList();

	$chairman_cd = 0;
	$executive_cd = 0;
	$regular_cd = 0;
	$associate_cd = 0;
	$basic_cd = 0;

	if ($cd_codes) {
		foreach ($cd_codes as $code) {
			if (strpos($code->type, 'chairman') !== false) {
				$chairman_cd++;
			}

			if (strpos($code->type, 'executive') !== false) {
				$executive_cd++;
			}

			if (strpos($code->type, 'regular') !== false) {
				$regular_cd++;
			}

			if (strpos($code->type, 'associate') !== false) {
				$associate_cd++;
			}

			if (strpos($code->type, 'basic') !== false) {
				$basic_cd++;
			}
		}
	}

	$sales_chairman_cd = $chairman_cd * $se->chairman_entry;
	$sales_executive_cd = $executive_cd * $se->executive_entry;
	$sales_regular_cd = $regular_cd * $se->regular_entry;
	$sales_associate_cd = $associate_cd * $se->associate_entry;
	$sales_basic_cd = $basic_cd * $se->basic_entry;

	return $sales_chairman_cd + $sales_executive_cd + $sales_regular_cd + $sales_associate_cd + $sales_basic_cd;
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function payouts()
{
	return db()->setQuery(
		'SELECT payout_total ' .
		'FROM network_payouts ' .
		'ORDER BY payout_id DESC'
	)->loadObject();
}

/**
 *
 * @return mixed|null
 *
 * @since version
 */
function token()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_fmc'
	)->loadObject();
}
