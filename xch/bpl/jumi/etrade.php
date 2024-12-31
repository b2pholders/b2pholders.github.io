<?php

namespace BPL\Jumi\Etrade;

require_once 'bpl/ajax/ajaxer/table_etrade.php';
require_once 'bpl/mods/table_daily_interest.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Ajax\Ajaxer\Table_Etrade\main as ajax_table_etrade;
use function BPL\Mods\Table_Daily_Interest\main as table_daily;

use function BPL\Mods\Url_SEF\sef;

use function  BPL\Mods\Helpers\session_get;
use function  BPL\Mods\Helpers\page_validate;
use function  BPL\Mods\Helpers\menu;
use function  BPL\Mods\Helpers\db;
use function  BPL\Mods\Helpers\settings;
use function  BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	page_validate();

	$str = menu();

	try
	{
		$str .= etrade(session_get('user_id'));
	}
	catch (Exception $e)
	{
	}

	echo $str;
}

/**
 * @throws Exception
 *
 * @since version
 */
function view_etrade($user_id): string
{
	$str = '<h2>' . settings('entry')->{user($user_id)->account_type . '_package_name'} .
		' ' . settings('plans')->etrade_name .
		'<span style="float: right; font-size: x-large; font-weight: bold"><span style="float: right">
        <a href="' . sef(115) . '" class="uk-button">Deposit</a></span></span></h2>
		<div class="table-responsive">
			<table class="category table table-bordered table-hover">
				<tr>
					<td rowspan="3" style="text-align: center; width: 33%; vertical-align: middle">
						<div class="table-responsive" id="table_etrade">' . table_etrade($user_id) . '</div>
					</td>
				</tr>
			</table>
		</div>';

	$str .= ajax_table_etrade($user_id);

	return $str;
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @throws Exception
 * @since version
 */
function etrade($user_id): string
{
	$str = '';

	if (user($user_id)->account_type !== 'starter')
	{
		$str .= view_etrade($user_id);
	}

	return $str;
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_compound($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_compound ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @throws Exception
 *
 * @since version
 */
function table_etrade($user_id): string
{
	$settings_investment = settings('investment');

	$user = user($user_id);

	$account_type = $user->account_type;

	$entry = settings('entry')->{$account_type . '_entry'};

	$interval = $settings_investment->{$account_type . '_interval'};
	$maturity = $settings_investment->{$account_type . '_maturity'};

	return table_daily(user_compound($user_id), $entry, $user->date_activated, $maturity, $interval);
}