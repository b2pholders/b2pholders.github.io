<?php

namespace BPL\Jumi\Buy_Items;

require_once 'bpl/binary_product_bonus.php';
require_once 'bpl/unilevel.php';
require_once 'bpl/royalty_bonus.php';
require_once 'bpl/elite_bonus.php';
require_once 'bpl/stockist_bonus.php';
require_once 'bpl/franchise_bonus.php';

//require_once 'bpl/mods/binary/points.php';
require_once 'bpl/mods/code_generate.php';
require_once 'bpl/mods/usdt_currency.php';
require_once 'bpl/mods/repeat_items.php';
require_once 'bpl/mods/category_items.php';

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\HTML\HTMLHelper;

use function BPL\Binary_Product\main as binary_product;
use function BPL\Unilevel\main as unilevel;
use function BPL\Royalty_Bonus\main as royalty_bonus;
use function BPL\Elite_Bonus\main as elite_bonus;
use function BPL\Stockist_Bonus\main as stockist_bonus;
use function BPL\Franchise_Bonus\main as franchise_bonus;

//use function bpl\Mods\Binary\Points\main as points_update;
use function BPL\Mods\Codes_Generate\generate;

use function BPL\Mods\USDT_Currency\main as usdt_currency;

use function BPL\Mods\Repeat_Items\items;

use function bpl\Mods\Database\Query\insert;
use function bpl\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function bpl\Mods\Url_SEF\sef;
use function bpl\Mods\Url_SEF\qs;

use function bpl\Mods\Helpers\session_get;
use function bpl\Mods\Helpers\application;
use function bpl\Mods\Helpers\input_get;
use function bpl\Mods\Helpers\db;
use function bpl\Mods\Helpers\settings;
use function bpl\Mods\Helpers\page_validate;
use function bpl\Mods\Helpers\user;
use function bpl\Mods\Helpers\menu;
use function bpl\Mods\Helpers\time;

main();

/**
 *
 *
 * @since version
 */
function main()
{
	$user_id  = session_get('user_id');
	$position = substr(input_get('position', 'Left'), 0, 5);

	$quantity = input_get('quantity', '0');
	$method   = input_get('method', '', 'RAW');
	$final    = input_get('final');

	$pg  = input_get('pg', 0);
	$cat = input_get('cat', 0);

	$rows = 10;

	page_validate();

	$uid = input_get('uid');

	$str = menu();

	$str .= view_efund($user_id);

	if ($uid === '')
	{
//		echo '<pre>';
//		var_dump(!empty(user_unilevel($user_id)));
//		exit;
		$str .= view_items($pg, $cat, $user_id, $rows);
	}
	else
	{
		$str .= buy_items($user_id, $uid, $position, $quantity, $method, $final);
	}

	echo $str;
}

/**
 *
 * @param        $pg
 * @param        $cat_id
 * @param   int  $user_id
 * @param   int  $rows
 *
 * @return string
 *
 * @since version
 */
function view_items($pg, $cat_id, int $user_id = 0, int $rows = 10): string
{
	$sa = settings('ancillaries');

	$str = '<article class="uk-article">';
	$str .= '<h1 class="uk-article-title">Buy Items</h1>';
	$str .= '<p class="uk-article-lead">Buy items here using your available balance ' . /*$sa->efund_name .*/ '. 
			Purchases are non-refundable since points are added immediately.</p>';

	$str .= items($cat_id, $pg, $rows, $user_id);

	$str .= '</article>';

	return $str;
}

/**
 * @param $uid
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form_buy_confirm($uid, $user_id): string
{
	$sa = settings('ancillaries');

	$sp = settings('plans');

	$items = item_get($uid);

	$str = '<p><strong style="font-size: large">Set Quantity' .
		($sp->redundant_binary ? ' and Position' : '') . '</strong></p>
			<form method="post" onsubmit="submit.disabled = true; return true;">
				<input type="hidden" name="final" value="1">
				<input type="hidden" name="uid" value="' . $uid . '">
			<table class="category table table-striped table-bordered table-hover">
				<tr><td style="width: 200px"><strong>Item</strong>:</td><td>' . $items->item_name . '</td></tr>
				<tr><td><strong>Price</strong>:</td><td>' . number_format($items->price, 8) . ' ' .
		$sa->currency . '</td></tr>';
	$str .= !$sp->redundant_binary ? '' :
		'<tr><td><strong>Binary Points</strong>:</td><td>' . $items->binary_points . ' pts.</td></tr>';
	$str .= !$sp->unilevel ? '' :
		'<tr><td><strong>Unilevel Points</strong>:</td><td>' . $items->unilevel_points . ' pts.</td></tr>';
	$str .= '<tr><td><strong>Purchased Rewards</strong>:</td><td>' . $items->reward_points . ' tkn.</td></tr>';
	$str .= '<tr>
                    <td><label for="quantity"><strong>Quantity:</strong></label></td>
                    <td>
                        <select name="quantity" id="quantity">';

	for ($ctr = 0; $ctr <= 100; $ctr++)
	{
		$str .= '<option value="' . $ctr . '" ' . ($ctr === 1 ? 'selected' : '') . '>' . $ctr . '</option>';
	}

	$str .= '</select></td></tr>';

	if ($sp->trading)
	{
		$str .= '<tr><td><label for="method"><strong>Method:</strong></label></td>';
		$str .= '<td><select name="method" id="method" style="float: left">
            			<option value="none" selected>Payment method</option>';
		$str .= '<option value="token">' . settings('trading')->token_name . '</option>';
		$str .= '<option value="efund">' . $sa->efund_name . '</option>';
		$str .= '</select></td></tr>';
	} else {
		$str .= '<input type="hidden" name="method" value="efund">';
	}

	$str .= ($sp->redundant_binary && !empty(user_binary($user_id)) ? ('
				<tr>
					<td><strong>Binary Position</strong>: </td>
					<td>
						<select name="position" id="position">
							<option value="Left">Left</option>
							<option value="Right">Right</option>
						</select>
					</td>
				</tr>') : '') . '</table>' . HTMLHelper::_('form.token');

	$str .= '
			<input type="submit" name="submit" value="Confirm Quantity" class="uk-button uk-button-primary">
				<a href="' . sef(9) . '" class="uk-button uk-button-primary">Back to Items List</a>
			</form>';

	return $str;
}

/**
 * @param $uid
 * @param $user_id
 * @param $position
 * @param $quantity
 * @param $method
 *
 * @return string
 *
 * @since version
 */
function view_form_buy_confirm_final($uid, $user_id, $position, $quantity, $method): string
{
	$sp = settings('plans');

	$sa = settings('ancillaries');

	$items = item_get($uid);

	$str = '<p><strong style="font-size: large">Final confirmation.</strong></p>
			<form method="post" ' . disable_on_submit() . '>
				<input type="hidden" name="final" value="2">
				<input type="hidden" name="uid" value="' . $uid . '">
				<input type="hidden" name="method" value="' . $method . '">
				<input type="hidden" name="quantity" value="' . $quantity . '">';
	$str .= $sp->redundant_binary ?
		'<input type="hidden" name="position" value="' . $position . '">' : '';
	$str .= '<table class="category table table-striped table-bordered table-hover">';
	$str .= '<tr><td style="width: 200px"><strong>Item</strong>:</td><td>' . $items->item_name . '</td></tr>';
	$str .= '<tr><td><strong>Price</strong>:</td><td>' .
		number_format($items->price, 8) . ' ' . $sa->currency . '</td></tr>';

	$str .= !$sp->redundant_binary ? '' :
		'<tr><td><strong>Binary Points</strong>:</td><td>' . $items->binary_points . ' pts.</td></tr>';
	$str .= !$sp->unilevel ? '' :
		'<tr><td><strong>Unilevel Points</strong>:</td><td>' . $items->unilevel_points . ' pts.</td></tr>';
	$str .= '<tr><td><strong>Purchased Rewards</strong>:</td><td>' . $items->reward_points . ' tkn.</td></tr>';

	$str .= '<tr><td><strong>Quantity</strong>:</td><td>' . number_format($quantity) . '</td></tr>';
	$str .= $sp->trading && $method === 'token' ?
		'<tr><td><strong>Method</strong>: </td><td>' . $method . '</td></tr>' : '';
	$str .= $sp->redundant_binary && !empty(user_binary($user_id)) ?
		'<tr><td><strong>Binary Position</strong>: </td><td>' . $position . '</td></tr>' : '';
	$str .= '</table>' . HTMLHelper::_('form.token');
	$str .= '<input type="submit" name="submitFinal" value="Confirm Purchase" class="uk-button uk-button-primary"> 
                <a href="' . sef(9) . qs() . 'uid=' . $uid .
		'" class="uk-button uk-button-primary">Change Quantity' .
		($sp->redundant_binary && user_binary($user_id) ? ' / Position' : '') . '</a>
			</form>';

	return $str;
}

/**
 * @param   array  $address
 *
 * @return array|mixed|null
 *
 * @since version
 */
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
 * @param $address
 *
 * @return bool
 *
 * @since version
 */
function validate_address($address): bool
{
	$ua = explode('|', $address);

	$country = country($ua);

	if (!empty($ua[0]) && !empty($ua[1]) && !empty($ua[2]) && !empty($ua[3]) && $country)
	{
		return true;
	}

	return false;
}

function list_token(): array
{
	return [
		'USDT',
		'BTC',
		'ETH',
		'BNB',
		'LTC',
		'ADA',
		'USDC',
		'LINK',
		'DOGE',
		'DAI',
		'BUSD',
		'SHIB',
		'UNI',
		'MATIC',
		'DOT',
		'TRX',
		'BTC3',
		'BTCB',
		'BTCW',
		'GOLD',
		'PAC',
		'P2P',
		'PESO'
	];
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

function has_wallet_addr($item_name, $user): bool
{
	$arr = arr_payment_method($user);

	if ($arr)
	{
		foreach ($arr as $k => $v)
		{
			if (strtolower($item_name) === $k)
			{
				return true;
			}
		}
	}

	return false;
}

/**
 * @param $user_id
 * @param $uid
 * @param $position
 * @param $quantity
 * @param $method
 * @param $final
 *
 * @return string
 *
 * @since version
 */
function buy_items($user_id, $uid, $position, $quantity, $method, $final): string
{
	$sa = settings('ancillaries');

	$app = application();

	$user = user($user_id);

	$item = item_get($uid);

	$price_item = $item->price;

	if ((int) $item->quantity === 0 || $item->quantity < $quantity)
	{
		$app->redirect(Uri::root(true) . '/' . sef(9),
			'Item is out-of-stock at this time!', 'notice');
	}

	$minimum_bal_usd = $sa->{$user->account_type . '_min_bal_usd'};

	if ($user->payout_transfer < (($price_item * $quantity) + $minimum_bal_usd))
	{
		$app->redirect(Uri::root(true) . '/' . sef(9),
			('Insufficient ' . $sa->efund_name . ', please maintain at least ' .
				number_format(($price_item + $minimum_bal_usd), 8) .
				' ' . $sa->currency), 'error');
	}

	if (empty($user->fullname)
		|| empty($user->email)
		|| !validate_address($user->address)
		|| empty(json_decode($user->contact))
		|| (!has_wallet_addr($item->item_name, $user)
			&& in_array($item->item_name, list_token())))
	{
		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please fill up the following if empty: Full Name, Address, E-mail, Contacts, Payment Method (' .
			$item->item_name . ')', 'error');
	}

	$str = '';

	if ((int) $final !== 2)
	{
		$str .= '<h1>Confirm Item Purchase</h1>';

		if ((int) $final !== 1)
		{
			$str .= view_form_buy_confirm($uid, $user_id);
		}
		else
		{
			$str .= view_form_buy_confirm_final($uid, $user_id, $position, $quantity, $method);
		}
	}
	else
	{
//		echo '<pre>';
//		var_dump($method);
//		exit;

		process_buy($user_id, $uid, $quantity, $position, $method);
	}

	return $str;
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 * @param $method
 *
 *
 * @since version
 */
function validate_input($user_id, $uid, $quantity, $position, $method)
{
	$app = application();

	$settings_trading = settings('trading');

	if ($quantity <= 0)
	{
		$app->redirect(Uri::root(true) . '/' . sef(9), 'Invalid Quantity!', 'notice');
	}

	if ($position === '')
	{
		$app->redirect(Uri::root(true) . '/' . sef(9), 'Invalid transaction.', 'error');
	}

	$total = $method === 'token' ?
		(item_get($uid)->price * $quantity * usdt_currency() / $settings_trading->fmc_to_usd) :
		item_get($uid)->price * $quantity;

	if ($method === 'token' && user($user_id)->balance_fmc < $total)
	{
		$app->redirect(Uri::root(true) . '/' .
			sef(10), 'Not enough ' . $settings_trading->token_name . '!', 'error');
	}
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 * @param $method
 *
 * @since version
 */
function insert_purchase($user_id, $uid, $quantity, $position, $method)
{
	$db = db();

	$items = item_get($uid);

	$price_item = $items->price;
	$cat_id = $items->cat_id;

	$fields = [];
	$values = [];

	$data = [
		'user_id' => $db->quote($user_id),
		'item_id' => $db->quote($uid),
		'date' => $db->quote(time()),
		'reward_points' => $db->quote(($items->reward_points * $quantity)),
		'unilevel_points' => $db->quote(($items->unilevel_points * $quantity)),
		'price' => $db->quote($price_item),
		'quantity' => $db->quote($quantity),
		'method' => $db->quote($method),
		'total_purchases' => $db->quote(($price_item * $quantity)),
		'code' => $db->quote(generate())
	];

//	$fields = [
//		'user_id',
//		'item_id',
//		'date',
//		'reward_points',
//		'unilevel_points',
////		'binary_points',
//		'price',
//		'quantity',
////		'position',
//		'method',
//		'total_purchases',
//		'code'
//	];

//	$values = [
//		$db->quote($user_id),
//		$db->quote($uid),
//		$db->quote(time()),
//		$db->quote(($items->reward_points * $quantity)),
//		$db->quote(($items->unilevel_points * $quantity)),
////		$db->quote(($items->binary_points * $quantity)),
//		$db->quote($price_item),
//		$db->quote($quantity),
////		$db->quote($position),
//		$db->quote($method),
//		$db->quote(($price_item * $quantity)),
//		$db->quote(generate())
//	];

	if ($cat_id == 22) {
		$data['status'] = $db->quote('Delivered');
	}

	if (settings('plans')->redundant_binary)
	{
		$data['binary_points'] = $db->quote(($items->binary_points * $quantity));
		$data['position'] = $db->quote($position);
	}

	split_key_val($data, $fields, $values);

	insert('network_repeat', $fields, $values);
}

function split_key_val($array, &$fields, &$values)
{
	foreach ($array as $key => $value) {
		$fields[] = $key;
		$values[] = $value;
	}
}

/**
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function update_items_repeat($uid, $quantity)
{
	update(
		'network_items_repeat',
		['quantity = quantity - ' . $quantity],
		['item_id = ' . db()->quote(item_get($uid)->item_id)]
	);
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function update_users($user_id, $uid, $quantity)
{
	$items = item_get($uid);

	update(
		'network_users',
		[
			'payout_transfer = payout_transfer - ' . ($items->price * $quantity),
			'points = points + ' . ($items->reward_points * $quantity)
		],
		['id = ' . db()->quote($user_id)]
	);
}

/**
 * @param $user
 *
 * @return mixed
 *
 * @since version
 */
function arr_contact_info($user)
{
	$contact_info = empty($user->contact) ? '{}' : $user->contact;

	return json_decode($contact_info, true);
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 * @param $method
 *
 * @since version
 */
function process_buy($user_id, $uid, $quantity, $position, $method)
{
	$db = db();

	Session::checkToken() or die(Text::_('Invalid Token'));

	validate_input($user_id, $uid, $quantity, $position, $method);

	$settings_ancillaries = settings('ancillaries');

	$user = user($user_id);

	$email = $user->email;

	$items = item_get($uid);

	$tmp_addr = explode('|', $user->address);

	$contact_info = arr_contact_info($user);

	$messenger = '';
	$mobile    = '';
	$landline  = '';

	if (!empty($contact_info))
	{
		$messenger = $contact_info['messenger'] ?? '';
		$mobile    = $contact_info['mobile'] ?? '';
		$landline  = $contact_info['landline'] ?? '';
	}

	$contact = 'Messenger URL: ' . $messenger . '<br>';
	$contact .= 'Mobile Number: ' . $mobile . '<br>';
	$contact .= 'Landline Number: ' . $landline . '<br>';

	$body = 'Username: ' . $user->username . '<br>
		Full Name: ' . $user->fullname . '<br>
		Address: ' . $tmp_addr[0] . ', ' . $tmp_addr[1] . ', ' . $tmp_addr[2] . ', ' .
		$tmp_addr[3] . ', ' . country($tmp_addr)->countryName . '<br>
		Email: ' . $email . '<br>';

	$body .= $contact;

	$body .= 'Item Purchased: ' . $items->item_name . '<br>
		Quantity: ' . $items->quantity . ' pcs<br>
		Price: ' . number_format($items->price, 8) . ' ' . $settings_ancillaries->currency;

	$message_admin = 'A member has made an item purchase.<br><hr>' . $body;

	$message_user = 'Thank you for your purchase. Your points have been added to your account. ' .
		'You will be contacted accordingly with regards to the receipt of your purchase.<br>
			<hr>' . $body;

	try
	{
		$db->transactionStart();

		insert_purchase($user_id, $uid, $quantity, $position, $method);

		update_items_repeat($uid, $quantity);

		update_users($user_id, $uid, $quantity);

		logs($user_id, $uid, $quantity, $position);

		process_plans($user_id, $uid, $quantity, $position);

//		points_update(items_get($uid)->reward_points * $quantity, $user_id);

		send_mail($message_admin, 'Item Purchase');
		send_mail($message_user, 'Item Purchase Confirmation', [$email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(72),
		'Item purchase successful!', 'success');
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function log_activity($user_id, $uid, $quantity)
{
	$db = db();

	$user = user($user_id);

	$items = item_get($uid);

	$activity = '<b>Item Purchase: </b>' . $quantity . ' pcs of <a href="' .
		sef(9) . qs() . 'uid=' . $items->item_id . '" target="_blank">' . $items->item_name .
		'</a> by <a href="' . sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a>.';

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
			$db->quote(user_binary($user_id)->upline_id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 *
 *
 * @since version
 */
function log_transactions($user_id, $uid, $quantity, $position)
{
	$db = db();

	$binary = user_binary($user_id);

	$items = item_get($uid);

	$points_item = $items->binary_points;
	$price_item  = $items->price;

	$details = $items->quantity . ' pcs of <a href="' . sef(44) . qs() . 'uid=' .
		$items->item_id . '" target="_blank">' . $items->item_name . '</a>. <br>';

	if (!empty($binary) && settings('plans')->redundant_binary)
	{
		if ($position === 'Left')
		{
			$details .= 'Group A: + ' . ($points_item * $quantity) . ' pts.<br>New Group Status (A/B): ' .
				($binary->ctr_left + $points_item * $quantity) . ' pts. / ' . $binary->ctr_right . ' pts.';
		}
		else
		{
			$details .= 'Group B: + ' . ($points_item * $quantity) . ' pts.<br>New Group Status (A/B): ' .
				$binary->ctr_left . ' pts. / ' . ($binary->ctr_right + $points_item * $quantity) . ' pts.';
		}
	}

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
			$user_id,
			$db->quote('Item Purchase'),
			$db->quote($details),
			$db->quote($price_item * $quantity),
			(user($user_id)->payout_transfer - $price_item * $quantity),
			$db->quote(time())
		]
	);
}

/**
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function log_income($uid, $quantity)
{
	$db = db();

	$price_item = item_get($uid)->price;

	$income = (income_admin()->income_total ?? 0) + $price_item * $quantity;

	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($db->insertid()),
			$db->quote($price_item * $quantity),
			$db->quote($income),
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
function income_admin()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 *
 *
 * @since version
 */
function logs($user_id, $uid, $quantity, $position)
{
	log_activity($user_id, $uid, $quantity);
	log_transactions($user_id, $uid, $quantity, $position);
	log_income($uid, $quantity);
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 *
 * @since version
 */
function process_plans($user_id, $uid, $quantity, $position)
{
	if (!empty(user_binary($user_id)))
	{
		process_redundant_binary($user_id, $uid, $quantity, $position);
	}

	if (!empty(user_unilevel($user_id)))
	{
		process_unilevel($user_id, $uid, $quantity);
	}
	else
	{
		$items = item_get($uid);

		$cat_id = $items->cat_id;

		if ($cat_id == 22)
		{
			insert_unilevel($user_id);
		}
	}

	process_royalty($uid, $quantity);
	process_elite($uid, $quantity);
	process_stockist($uid, $quantity);
	process_franchise($uid, $quantity);
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function insert_unilevel($user_id)
{
	insert(
		'network_unilevel',
		['user_id'],
		[db()->quote($user_id)]
	);
}

/**
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function process_franchise($uid, $quantity)
{
	if (settings('entry')->executive_global)
	{
		franchise_bonus((item_get($uid)->reward_points * $quantity));
	}
}

/**
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function process_stockist($uid, $quantity)
{
	if (settings('entry')->regular_global)
	{
		stockist_bonus((item_get($uid)->reward_points * $quantity));
	}
}

/**
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function process_elite($uid, $quantity)
{
	if (settings('plans')->elite_reward)
	{
		elite_bonus(0, (item_get($uid)->reward_points * $quantity));
	}
}

/**
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function process_royalty($uid, $quantity)
{
	if (settings('plans')->royalty)
	{
		royalty_bonus(0, (item_get($uid)->reward_points * $quantity));
	}
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function process_unilevel($user_id, $uid, $quantity)
{
	if (settings('plans')->unilevel)
	{
		update(
			'network_unilevel',
			['period_unilevel = period_unilevel + ' .
				(item_get($uid)->unilevel_points * $quantity)],
			['user_id = ' . db()->quote($user_id)]
		);

		unilevel();
	}
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 * @param $position
 *
 *
 * @since version
 */
function process_redundant_binary($user_id, $uid, $quantity, $position)
{
	$items = item_get($uid);

	if (settings('plans')->redundant_binary)
	{
		$p_id        = $items->item_id;
		$p_name      = $items->item_name;
		$p_points    = $items->binary_points * $quantity;
		$price_total = $items->price * $quantity;

		// reset binary status as per condition
		if (bouncer($user_id, $price_total) && $p_points > 0)
		{
			binary_product($user_id, $p_id, $p_name, $p_points, $position);
		}
	}
}

function bouncer($user_id, $price_total): bool
{
//	$flag = false;

	if (can_reactivate_binary($user_id, $price_total))
	{
		reset_binary_status($user_id);

//		$flag = true;
	}

	return true;
}

function reset_binary_status($user_id)
{
	$db = db();

	return update(
		'network_binary',
		[
			'status = ' . $db->quote(/*'reactivated'*/ 'active')
			, 'capping_cycle = ' . $db->quote(0)
			, 'status_cycle = ' . $db->quote(1)
			, 'ctr_left = ' . $db->quote(0)
			, 'ctr_right = ' . $db->quote(0)
			, 'pairs_today = ' . $db->quote(0)
			, 'reactivate_count = ' . $db->quote(
				binary_user($user_id)->reactivate_count + 1
			)
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

function can_reactivate_binary($user_id, $price_total): bool
{
	$sb = settings('binary');

	$binary_user = binary_user($user_id);

	$account_type = $binary_user->account_type;

	$reactivate_count = $binary_user->reactivate_count;

	$cost_reactivate   = $sb->{$account_type . '_pairs_reactivate'};
	$capping_cycle_max = $sb->{$account_type . '_capping_cycle_max'};

	return $reactivate_count < $capping_cycle_max
		&& $binary_user->payout_transfer > $cost_reactivate
		&& $price_total >= $cost_reactivate;
}

function binary_user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_binary($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_binary ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_unilevel($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_unilevel ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $item_id
 *
 * @return mixed|null
 *
 * @since version
 */
function item_get($item_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_repeat ' .
		'WHERE item_id = ' . $db->quote($item_id)
	)->loadObject();
}

/**
 *
 * @return string
 *
 * @since version
 */
function disable_on_submit(): string
{
	return 'onsubmit="submitFinal.disabled = true; return true;"';
}

/**
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_efund($user_id): string
{
	return '<div style="float:right;">
            <a href="javascript:void(0)" class="uk-button uk-button-primary">
                <strong>Available Token: ' . /*settings('ancillaries')->efund_name .*/ ': ' .
		number_format(user($user_id)->payout_transfer, 8) . ' ' .
		settings('ancillaries')->currency . '</strong>
            </a>
        </div>';
}