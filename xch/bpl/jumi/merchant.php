<?php

namespace BPL\Jumi\Merchant;

require_once 'bpl/ajax/ajaxer/api_coin.php';
require_once 'bpl/ajax/ajaxer/amount_buy_vlt.php';
require_once 'bpl/ajax/ajaxer/buy_vlt.php';
require_once 'bpl/ajax/ajaxer/amount_sell_vlt.php';
require_once 'bpl/ajax/ajaxer/sell_vlt.php';

require_once 'bpl/mods/usdt_currency.php';

require_once 'bpl/menu.php';

require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\API_Coin\main as api_coin;
use function BPL\Ajax\Ajaxer\Token\Vault\Buy\Amount\main as amount_buy_vlt;
use function BPL\Ajax\Ajaxer\Token\Vault\Buy\main as buy_vlt;
use function BPL\Ajax\Ajaxer\Token\Vault\Sell\Amount\main as amount_sell_vlt;
use function BPL\Ajax\Ajaxer\Token\Vault\Sell\main as sell_vlt;

//use function BPL\Mods\BTC_Currency\price_ask;
//use function BPL\Mods\BTC_Currency\price_bid;

//use function BPL\Mods\USDT_Currency\main as usdt_currency;
use function BPL\Mods\USDT_Currency\price_bid;
use function BPL\Mods\USDT_Currency\price_ask;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$username      = session_get('username');
	$usertype      = session_get('usertype');
	$admintype     = session_get('admintype');
	$account_type  = session_get('account_type');
	$merchant_type = session_get('merchant_type');
	$user_id       = session_get('user_id');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id);

	$str .= merchant(session_get('user_id'));

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $merchant_type
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $merchant_type, $user_id): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'Member':
			$str .= menu_member($account_type, $username, $user_id);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 *
 * @return mixed
 *
 * @since version
 */
function token_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_fmc'
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function merchant($user_id): string
{
	$user = user($user_id);

	$settings_trading = settings('trading');

//	$currency = settings('ancillaries')->currency;

	$token_name = $settings_trading->token_name;

	$str = '';

//	if ($user->account_type !== 'starter')
//	{
		$price_bid = number_format(price_bid(), 5);
		$price_ask = number_format(price_ask(), 5);

		$str .= '<div class="table-responsive">';
		$str .= '<h2>' ./* $token_name .*/ ' Portal<span style="float: right; font-size: large; font-weight: bold">
            <span style="color: green">' . settings('ancillaries')->efund_name . ' Balance: </span><span
                            class="usd_bal_now_user">' . number_format($user->payout_transfer, 2) .
			'</span>' . ' ' . /*$currency .*/ '</span>
            </h2>';
		$str .= '<table class="category table table-striped table-bordered">
                <tr>
                    <td style="text-align: center; vertical-align: middle">
                        <strong style="font-size: large">Total: <span
                                    id="total_buy_vlt">0.00</span> ' . /*$currency .*/ '</strong>
                    </td>
                    <td style="text-align: center; vertical-align: middle">
                        <div>
                            <div>
                                <span style="color: red" id="error_buy_vlt"></span>
                                <span style="color: green" id="success_buy_vlt"></span>
                            </div>
                        </div>
                    </td>
                    <td rowspan="2" style="text-align: center; vertical-align: middle">                    
                        <strong style="font-size: x-large"><span id="rate_buy">' . $price_bid
			/*usdt_currency()*/ .
			'</span> ' . /*$currency .*/ /*' / ' . $token_name .*/
			'<br>
                            <span style="color: #006600">Buying Price</span>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; vertical-align: middle">
                        <strong><label><input type="button"
                                              value="Buy"
                                              class="uk-button uk-button-primary"
                                              id="buy_vlt"
                                              style="font-size: large;
                                       text-align: center;
                                       vertical-align: middle"></label></strong>
                    </td>
                    <td style="text-align: center; vertical-align: middle"><br>
                        <strong><label for="amount_buy_vlt"><input type="text"
                                                                   id="amount_buy_vlt"
                                                                   style="font-size: large;
                                                                        text-align: center;
                                                                        vertical-align: middle"></label></strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; width: 33%; vertical-align: middle">
                        <strong style="font-size: large">Charge: <span
                                    id="charge_buy_vlt">0.00</span> ' . /*$currency .*/ '</strong>
                    </td>
                    <td style="text-align: center; width: 33%; vertical-align: middle">
                        <strong style="font-size: large">Subtotal: <span
                                    id="subtotal_buy_vlt">0.00</span> ' . /*$currency .*/ '</strong>
                    </td>
                    <td>
                        <div style="alignment: center">
                            <strong style="font-size: large">' . /*$token_name .*/
			'Supply: <span class="fmc_bal_now_vlt">' . number_format(token_admin()->balance, 8) .
			'</span> ' . $token_name .
			'</strong>
                        </div>
                    </td>
                </tr>
            </table>
            <br>
            <hr>
            <br>';

//		if ($user->merchant_type !== 'starter')
//		{
//			$str .= '<h2>' . $token_name . ' Portal Sell<span style="float: right; font-size: large; font-weight: bold">';
//			$str .= '<span style="color: green">e-Fund Balance: </span><span
//                            class="usd_bal_now_user">' . number_format($user->payout_transfer, 2) .
//				'</span>' . ' ' . /*$currency .*/ '</span>
//            </h2>';
			$str .= '<table class="category table table-striped table-bordered">
                    <tr>
                        <td style="text-align: center; vertical-align: middle">
                            <strong style="font-size: large">Total: <span
                                        id="total_sell_vlt">0.00</span> ' . /*$currency .*/ '</strong>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <div>
                                <span style="color: red" id="error_sell_vlt"></span>
                                <span style="color: green" id="success_sell_vlt"></span>
                            </div>
                        </td>
                        <td rowspan="2" style="text-align: center; width: 33%; vertical-align: middle">
                            <strong style="font-size: x-large"><span id="rate_sell">' . $price_ask
				/*usdt_currency()*/ .
				'</span> ' . /*$currency .*/ /*' / ' . $token_name .*/
				'<br>
                                <span style="color: #006600;">Selling Price</span>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle">
                            <strong><label><input type="button"
                                                  value="Sell"
                                                  class="uk-button uk-button-primary"
                                                  id="sell_vlt"
                                                  style="font-size: large;
                                       text-align: center;
                                       vertical-align: middle"></label></strong>
                        </td>
                        <td style="text-align: center; vertical-align: middle"><br>
                            <strong><label for="amount_sell_vlt"><input
                                            type="text"
                                            id="amount_sell_vlt"
                                            style="font-size: large;
                                    text-align: center;
                                    vertical-align: middle"></label></strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; width: 33%; vertical-align: middle">
                            <strong style="font-size: large">Charge: <span
                                        id="charge_sell_vlt">0.00</span> ' . /*$currency .*/ '</strong>
                        </td>
                        <td style="text-align: center; width: 33%; vertical-align: middle">
                            <strong style="font-size: large">Subtotal: <span
                                        id="subtotal_sell_vlt">0.00</span> ' . /*$currency .*/ '</strong>
                        </td>
                        <td>
                            <div style="alignment: center">
                                <strong style="font-size: large">' . /*$token_name .*/ ' Shares: <span
                                            class="fmc_bal_now_user">' . number_format($user->balance_fmc, 8) .
				'</span> ' . $token_name . '</strong>
                            </div>
                        </td>
                    </tr>
                </table>';
//		}

		$str .= '</div>';
//	}

	$str .= api_coin(/*$currency, $settings_trading->fmc_to_usd*/);
	$str .= amount_buy_vlt($user_id);
	$str .= buy_vlt($user_id);
	$str .= amount_sell_vlt($user_id);
	$str .= sell_vlt($user_id);

	return $str;
}