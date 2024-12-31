<?php

namespace BPL\Jumi\Purchase_Items_Invoice;

require_once 'bpl/menu.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/url_sef.php';

use Exception;

use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\Uri\Uri;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\application;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');
	$user_id      = session_get('user_id');
	$username     = session_get('username');
	$usertype     = session_get('usertype');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $user_id, $username);

	$uid = input_get('uid');
	$cid = input_get('cid');

	if ($usertype === 'Admin' || $usertype === 'manager')
	{
		if ($uid !== '')
		{
			$str .= view_invoice($user_id, $uid);
		}

		if ((int) $cid === 1)
		{
			process_confirm($user_id, $uid);
		}
	}

	$str .= script();

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $user_id
 * @param $username
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $user_id, $username): string
{
	$str = '';

	switch ($usertype)
	{
		case 'Admin':
			$str .= menu_admin($admintype, $account_type, $user_id, $username);
			break;
		case 'manager':
			$str .= menu_manager();
			break;
	}

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function script(): string
{
	$print_js = 'bpl/plugins/jquery.PrintArea.js';

	$str = '<script src="' . $print_js . '"></script>';
	$str .= '<script>
		(function ($) {
	        $("#print").click(function () {
	            $("div.PrintableArea").printArea();
	        });
	    })(jQuery);
    </script>';

	return $str;
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function repeat_purchase($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_repeat ' .
		'WHERE repeat_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function item($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_repeat ' .
		'WHERE item_id = ' . $db->quote($item_id)
	)->loadObject();
}

function country(array $address)
{
	$db = db();

	$result = [];

	if (array_key_exists(4, $address) && $address[4] !== '')
	{
		$result = $db->setQuery(
			'SELECT * ' .
			'FROM countries ' .
			'WHERE idCountry = ' . $db->quote($address[4])
		)->loadObject();
	}

	return $result;
}

/**
 * @param $user_id
 * @param $uid
 *
 * @return string
 *
 * @since version
 */
function view_invoice($user_id, $uid): string
{
	$sa = settings('ancillaries');

	$currency = $sa->currency;

	$user = user($user_id);

	$purchase = repeat_purchase($uid);

	$str = '<div class="PrintableArea" style="margin: 33px 7px 0 7px">';
	$str .= '<h1>' . $sa->company_name . ' <span style="float: right; font-size: large">Invoice # <b>' .
		date('Y-m-jHi' . $uid, $purchase->date) . '</b></span></h1>';
	$str .= '<hr>';
	$str .= '<table>';
	$str .= '<tr>';
	$str .= '<td style="width: 70%">';
	$str .= '<b style="font-size: medium">' . $user->fullname . '</b><br>';

	$address = explode('|', $user->address);

	$country = country($address);

	if ($country)
	{
		array_pop($address);

		$address[] = $country->countryName;
	}

	$str .= implode(', ', $address) . '<br>';

	$str .= 'E-mail: ' . $user->email . '<br>';

	$arr_contact = json_decode($user->contact);

	if (!empty($arr_contact))
	{
		foreach ($arr_contact as $k => $v)
		{
			switch ($k)
			{
				case 'mobile':
					$str .= 'Mobile No.: ' . $v . '<br>';
					break;
				case 'landline':
					$str .= 'Landline No.: ' . $v . '<br>';
					break;
				case 'messenger':
					$str .= 'Messenger Url: ' . $v . '<br>';
					break;
			}
		}
	}

	$str .= '</td>';
	$str .= '<td style="font-size: medium">
                    <div style="alignment: right">
                        <p><b>Order Date:</b> ' . date('M d, Y', $purchase->date) . '</p>
                        <p><b>Order Status:</b> ' . $purchase->status . '</p>
                        <p><b>Order Code:</b> ' . $purchase->code . '</p>
                    </div>
                </td>
            </tr>
        </table>';

	if (!empty($purchase))
	{
		$str .= '<table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Item</th>
                <th style="width: 500px">Description</th>
                <th>Quantity</th>
                <th>Unit Cost (' . $currency . ')</th>
                <th>Total (' . $currency . ')</th>
            </tr>
            </thead>
            <tbody>';

		$item = item($purchase->item_id);

		$str .= '
			<tr style="font-size: medium;">
				<td>' . date('Y-m-jHi' . $uid, $purchase->date) . '</td>
				<td>' . $item->item_name . '</td>
				<td>' . $item->description . '</td>
				<td>' . $purchase->quantity . '</td>
				<td>' . number_format($purchase->price, 8) . '</td>
			    <td>' . number_format($purchase->quantity * $purchase->price, 8) . '</td>
			</tr>';

		$str .= '<tr style="height: 33px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="height: 33px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="height: 33px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>';
	}
	else
	{
		$str .= '<p>No pending repeat purchases.</p>';
	}

	$str .= '<table>
        <tr>
            <td style="font-size: small; width: 33%; padding-right: 30px">
                PAYMENT TERMS AND POLICIES<br>
                Charges may apply, upon receipt of the invoice, if the product is to be delivered to the supplied 
                customer address. No charges will be applied if the buyer, or any of its designated agents, agrees to 
                pick up the product from the seller\'s location.
            </td>
            <td>
                <p style="font-size: large; alignment: right">
                    <b>Sub-total: </b>' . number_format($purchase->quantity * $purchase->price, 2) .
		' ' . $currency . '</p>
                <p style="font-size: large; alignment: right">Discount: 12.9%</p>
                <p style="font-size: large; alignment: right">VAT: 12.9%</p>
                <p style="font-size: large; alignment: right">Service Charge: 5%</p>
                <hr>
                <p style="font-size: large; alignment: right"><b
                            style="font-size: x-large">' .
		number_format($purchase->quantity * $purchase->price * (1 + 0.05),
			2) . ' ' . $currency . '</b></p>
            </td>
        </tr>
    </table>';

	$str .= '</div>
    <div class="uk-width-1-1" data-uk-margin style="alignment: right">
        <button id="print" class="uk-button uk-button-primary">
            <i class="uk-icon-print"></i></button>';

	if ($purchase->status !== 'Delivered')
	{
		$str .= '<a href="' . sef(62) . qs() . 'uid=' . $uid . '&cid=1"
           class="uk-button uk-button-primary">Confirm</a>';
	}

	$str .= '</div>';

	return $str;
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function process_confirm($user_id, $uid)
{
	$db = db();

	try
	{
		$db->transactionStart();

		update_purchase($uid);

		logs($user_id, $uid);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(62),
		'Purchased item delivery confirmed.', 'notice');
}

/**
 * @param $uid
 *
 *
 * @since version
 */
function update_purchase($uid)
{
	$db = db();

	update(
		'network_repeat',
		['status = ' . $db->quote('Delivered')],
		['repeat_id = ' . $db->quote($uid)]
	);
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function logs($user_id, $uid)
{
	$db = db();

	$repeat_user = repeat_user($uid);

	$item = item($repeat_user->item_id);

	$activity = '<b>Purchased Item Delivery Confirmation: </b>' . $item->item_name .
		' by <a href="' . sef(44) . qs() . 'uid=' . $repeat_user->user_id . '">' .
		$repeat_user->username . '</a>.';

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
			$db->quote(1),
			$db->quote(1),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function repeat_user($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u, network_repeat r ' .
		'WHERE u.id = r.user_id ' .
		'AND r.repeat_id = ' . $db->quote($uid)
	)->loadObject();
}