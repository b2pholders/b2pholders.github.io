<?php

namespace BPL\Jumi\Redeem_Point_Rewards;

require_once 'bpl/menu.php';
//require_once 'bpl/mods/rewards_items.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\page_validate;
use function bpl\Mods\Helpers\paginate;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
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
	$username     = session_get('username');
	$usertype     = session_get('usertype');
	$admintype    = session_get('admintype');
	$account_type = session_get('account_type');

	$user_id = session_get('user_id');

	$pg = input_get('pg', 0);

	$rows = 5;

	$uid = input_get('uid');

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, $user_id);

	$str .= view_points($user_id);

	if ($uid === '')
	{
		$str .= view_items($pg, $rows);
	}
	else
	{
		$final    = input_get('final');
		$quantity = input_get('quantity');

		if ((int) $final !== 2)
		{
			$str .= view_confirm($uid, $final, $quantity);
		}
		else
		{
			Session::checkToken() or die(Text::_('Invalid Token'));

			validate_input($user_id, $uid, $quantity);
			process_reward($user_id, $uid, $quantity);
		}
	}

	echo $str;
}

/**
 * @param $usertype
 * @param $admintype
 * @param $account_type
 * @param $username
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function menu($usertype, $admintype, $account_type, $username, $user_id): string
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
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_points($user_id): string
{
	return '<div style="float:right; margin-top:25px"><a class="uk-button uk-button-primary">
    <strong>Token: ' . number_format(user($user_id)->points) . '</strong></a></div>';
}

/**
 * @param $lim_from
 * @param $lim_to
 *
 * @return array|mixed
 *
 * @since version
 */
function items_incentive_lim_desc($lim_from, $lim_to)
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
		'ORDER BY item_id DESC ' .
		'LIMIT ' . $lim_from . ', ' . $lim_to
	)->loadObjectList();
}

function items_incentive()
{
	return db()->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive'
	)->loadObjectList();
}

/**
 * @param $uid
 *
 * @return mixed|null
 *
 * @since version
 */
function item_incentive_single($uid)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_items_incentive ' .
		'WHERE item_id = ' . $db->quote($uid)
	)->loadObject();
}

/**
 *
 * @param        $pg
 * @param   int  $rows
 *
 * @return string
 *
 * @since version
 */
function view_items($pg, int $rows = 10): string
{
	$str = '<article class="uk-article">';
	$str .= '<h1 class="uk-article-title">Redeem Tokens</h1>';
	$str .= '<p class="uk-article-lead">Use your tokens to redeem items here.</p>';

	$lim_to   = $rows;
	$lim_from = $lim_to * $pg;

	$items = items_incentive_lim_desc($lim_from, $lim_to);

	if (!empty($items))
	{
		$str .= '<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-5" data-uk-grid-margin="">';

		foreach ($items as $item)
		{
			$str .= '<li class="uk-row-first">';
			$str .= '<a class="uk-thumbnail uk-overlay-hover" href="#modal-' .
				$item->item_id . '" data-uk-modal="{center:true}">';
			$str .= '<div class="uk-overlay">';

			$src = 'images/no-image.png';

			if (!empty($item->picture))
			{
				$src = 'images/incentive/tmb_' . $item->picture;
			}

			$str .= '<img src="' . $src . '" height="150" alt="' . $item->item_name . '">';
			$str .= '<div class="uk-overlay-panel uk-overlay-icon uk-overlay-background uk-overlay-fade"></div>';
			$str .= '</div>';
			$str .= '<div class="uk-thumbnail-caption"><b>' . $item->item_name . '</b></div>';
			$str .= '</a>';
			$str .= '</li>';
		}

		$str .= '</ul>';

		$str .= show_modals($items);

		$str .= script_readmore();
	}
	else
	{
		$str .= '<hr><p>No items available at this time.</p>';
	}

	$str .= paginate($pg, items_incentive(), 64, $rows);

	$str .= '</article>';

	return $str;
}

function script_readmore(): string
{
	$str = '<style>
		.more_content span {
		  	display: none;
		}
		
		.more_link {
		  	display: block;
		}
	</style>';

	$str .= '<script>
		(function ($) {			    
            const max_len = 10; 
            const ellipsis = "...";
            const mrk_more = "<small>Show more</small>";
            const mrk_less = "<small>Show less</small>";

  			$(".more").each(function() {
    			const my_str = $(this).text();

    			if ($.trim(my_str).length > max_len) {                      
                    let reduced_str = my_str.split(" ").splice(0, max_len).join(" ");
                    let removed_str = my_str.split(" ").splice(max_len, $.trim(my_str).length).join(" ");

      				let html = reduced_str + \'<span>\' + ellipsis + 
      					\'</span><span class="more_content"><span>&nbsp;\' + removed_str + 
      					\'</span>&nbsp;&nbsp;<a href="" class="more_link">\' + mrk_more + \'</a></span\';

      				$(this).html(html);
    			}
    		});

  			$(".more_link").click(function() {
    			if ($(this).hasClass("less")) {
      				$(this).removeClass("less");                  
      				$(this).html(mrk_more);
    			} else {
      				$(this).addClass("less");
      				$(this).html(mrk_less);
                }
                
    			$(this).parent().prev().toggle();
    			$(this).prev().toggle();
                
    			return false;
  			});
		})(jQuery);
	</script>';

	return $str;
}

/**
 * @param $items
 *
 * @return string
 *
 * @since version
 */
function show_modals($items): string
{
	$str = '';

	foreach ($items as $item)
	{
		$str .= modal_reward($item);
	}

	return $str;
}

/**
 * @param $item
 *
 * @return string
 *
 * @since version
 */
function modal_reward($item): string
{
	$str = '<div id="modal-' . $item->item_id . '" class="uk-modal" style="z-index: 1030;">';
	$str .= '<div class="uk-modal-dialog uk-modal-dialog-lightbox">';
	$str .= '<div class="uk-width-1-1 uk-row-first">';
	$str .= '<div class="uk-panel uk-panel-box">';
	$str .= '<button type="button" class="uk-modal-close uk-close" style="float: right"></button>';
	$str .= '<div class="uk-grid" data-uk-grid-margin="">';

	$str .= '<div class="uk-width-medium-1-3 uk-width-large-1-3 uk-text-center uk-row-first">';
	$str .= '<img src="images/incentive/' . $item->picture . '" alt="' . $item->item_name . '">';
	$str .= '<p><a href="' . sef(64) . qs() . 'uid=' . $item->item_id .
		'" class="uk-button uk-button-primary">Redeem</a></p>';
	$str .= '</div>';

	$str .= '<div class="uk-width-medium-2-3 uk-width-large-2-3 uk-text-center-small">';
	$str .= '<h3 class="uk-panel-title">' . $item->item_name . '</h3>';
	$str .= '<p class="more">' . $item->description . '</p>';
//	$str .= '<input type="button" class="uk-button" value="' .
//		number_format($item->price, 2) . ' ' . settings('ancillaries')->currency . '">';
	$str .= '<input type="button" class="uk-button" value="Value: ' . $item->price . ' usd">&nbsp;';
	$str .= '<input type="button" class="uk-button" value="Available Items: ' . $item->quantity . ' pcs.">';

	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</div>';

	return $str;
}

/**
 * @param $user_id
 * @param $uid
 *
 * @param $quantity
 *
 * @since version
 */
function validate_input($user_id, $uid, $quantity)
{
	$app = application();

	$item = item_incentive_single($uid);

	$user = user($user_id);

	$points  = $user->points;
	$savings = $user->savings;

	$net_points = $points - $savings;

	$price_total = $item->price * $quantity;

	if ($item->quantity < $quantity)
	{
		$err = 'Asset is out-of-stock at this time.';

		$app->redirect(Uri::root(true) . '/' . sef(64), $err, 'notice');
	}

	if ($net_points < $price_total)
	{
		$err = 'Insufficient token to purchase item.';

		$app->redirect(Uri::root(true) . '/' . sef(64), $err, 'error');
	}

	if ($uid === '')
	{
		$err = 'Insufficient info to purchase asset.';

		$app->redirect(Uri::root(true) . '/' . sef(64), $err, 'error');
	}

	if ($quantity <= 0)
	{
		$err = 'Invalid Quantity';

		$app->redirect(Uri::root(true) . '/' . sef(64), $err, 'notice');
	}
}

function arr_payment_method($user): array
{
	$payment_method = empty($user->payment_method) ? '{}' : $user->payment_method;

	return json_decode($payment_method, true);
}

/**
 * @param $uid
 * @param $final
 * @param $quantity
 *
 * @return string
 *
 * @since version
 */
function view_confirm($uid, $final, $quantity): string
{
	$user_id = session_get('user_id');

	$user = user($user_id);

	$item = item_incentive_single($uid);

	$tokens = ['AET', 'B2P', 'TPAY', 'PESO'];
	$found = false;

	foreach ($tokens as $token) {
		if ($item->item_name === $token || strpos($token, $item->item_name) !== false) {
			$found = true;
			break;
		}
	}

	$str = '<h1>Confirm Token Redemption</h1>';

	if ((int) $final !== 1)
	{
		$str .= '<p><strong>Select Quantity</strong></p>';
		$str .= '<form method="post" onsubmit="submit.disabled = true; return true;">';
		$str .= '<input type="hidden" name="final" value="1">';
		$str .= '<input type="hidden" name="uid" value="' . $uid . '">';
		$str .= '<table class="category table table-striped table-bordered table-hover">';

		$str .= '<tr>';
		$str .= '<td style="width: 200px"><strong>Item</strong>:</td>';
		$str .= '<td>' . $item->item_name . '</td>';
		$str .= '</tr>';

		$str .= '<tr>';
		$str .= '<td><strong>Price</strong>:</td>';
		$str .= '<td>' . number_format($item->price) . ' usd</td>';
		$str .= '</tr>';

		$str .= '<tr>';
		$str .= '<td><label for="quantity"><strong>Quantity: *</strong></label></td>';
		$str .= '<td>';

		if ($found) {
			$str .= '<input type="text" name="quantity" value="1">';
		} else {
			$str .= '<select name="quantity" id="quantity">';

			for ($ctr = 0; $ctr <= 100; $ctr++)
			{
				$str .= '<option value="' . $ctr . '">' . $ctr . '</option>';
			}

			$str .= '</select>';
		}

		$str .= '</td>';
		$str .= '</tr>';

		if ($found) {
			$app = application();

			$arr_payment_method = arr_payment_method($user);

			if (empty($arr_payment_method) || empty($arr_payment_method[strtolower($item->item_name)]))
			{
				$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
					'Your Wallet Address for ' . strtoupper($item->item_name) . ' is Required.', 'error');
			}

			$str .= '<tr>';
			$str .= '<td><label for="wallet_address"><strong>Wallet Address: *</strong></label></td>';
			$str .= '</td>';
			$str .= '<td>';
			$str .= has_wallet_addr($item->item_name, $user) ?? '';
			$str .= '</td>';
			$str .= '</tr>';
		}

		$str .= '</table>';

		$str .= HTMLHelper::_('form.token');

		$str .= '
            <input type="submit" name="submit" value="Confirm Quantity" 
            class="uk-button uk-button-primary"> <a href="' . sef(64) . '" 
            class="uk-button uk-button-primary">Back to Items List</a>';
		$str .= '</form>';
	}
	else
	{
		$str .= '
                <p><strong>Final Confirmation</strong></p>
                <form method="post" onsubmit="submit.disabled = true; return true;">
                    <input type="hidden" name="final" value="2">
                    <input type="hidden" name="quantity" value="' . $quantity . '">
                    <input type="hidden" name="uid" value="' . $uid . '">
                    <table class="category table table-striped table-bordered table-hover">
                        <tr><td style="width: 200px"><strong>Item</strong>:</td><td>' . $item->item_name . '</td></tr>
                        <tr><td><strong>Price</strong>:</td><td>' . number_format($item->price) . ' usd</td></tr>
                        <tr><td><strong>Quantity</strong>:</td><td>' . number_format($quantity) . '</td></tr>' .
						($found ? '<tr><td><strong>Wallet Address</strong>:</td><td>' .
							has_wallet_addr($item->item_name, $user) . '</td></tr>' : '') .
                    '</table>
                    ' . HTMLHelper::_('form.token');
		$str .= '<input type="submit" name="submit" value="Confirm Item"
                           class="uk-button uk-button-primary">
                           <a href="' . sef(64) . qs() . 'uid=' . $uid .
			'" class="uk-button uk-button-primary">Change Quantity</a>
                </form>';
	}

	return $str;
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

/**
 * @param $user_id
 * @param $uid
 *
 * @param $quantity
 *
 * @since version
 */
function insert_incentive($user_id, $uid, $quantity)
{
	$db = db();

	$item = item_incentive_single($uid);

	insert(
		'network_incentive',
		[
			'user_id',
			'item_id',
			'date',
			'price',
			'quantity',
			'total_purchases'
		],
		[
			$db->quote($user_id),
			$db->quote($uid),
			$db->quote(time()),
			$db->quote($item->price),
			$db->quote($quantity),
			$db->quote(($item->price * $quantity))
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
function update_items_incentive($uid, $quantity)
{
	update(
		'network_items_incentive',
		['quantity = quantity - ' . $quantity],
		['item_id = ' . db()->quote(item_incentive_single($uid)->item_id)]
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
function update_user($user_id, $uid, $quantity)
{
	update(
		'network_users',
		['points = points - ' . ($quantity * item_incentive_single($uid)->price)],
		['id = ' . db()->quote(user($user_id)->id)]
	);
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function log_activity($user_id, $uid)
{
	$db = db();

	$user = user($user_id);

	$item = item_incentive_single($uid);

	$activity = '<b>Tokens Redeemed: </b>' . $item->quantity . ' pieces of <a href="' .
		sef(64) . qs() . 'uid=' . $item->item_id . '" target="_blank">' . $item->item_name .
		'</a> by <a href="' . sef(44) . qs() . 'uid=' . $user_id . '">' .
		$user->username . '</a>.';

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
			$db->quote($user->upline_id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $uid
 *
 *
 * @since version
 */
function log_transactions($user_id, $uid)
{
	$db = db();

	$item = item_incentive_single($uid);

	$details = '<a href="' . sef(64) . qs() . 'uid=' . $item->item_id . '" target="_blank">' .
		$item->item_name . '</a>. ' . $item->price . ' tokens consumed.';

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
			$db->quote('Token Redemption'),
			$db->quote($details),
			$db->quote(0),
			$db->quote(user($user_id)->payout_transfer),
			$db->quote(time())
		]
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
	log_activity($user_id, $uid);
	log_transactions($user_id, $uid);
}

function has_wallet_addr($item_name, $user)
{
	$arr = arr_payment_method($user);

	if ($arr)
	{
		foreach ($arr as $k => $v)
		{
			if (strtolower($item_name) === $k)
			{
				return $v;
			}
		}
	}

	return false;
}

/**
 * @param $user_id
 * @param $uid
 * @param $quantity
 *
 *
 * @since version
 */
function process_reward($user_id, $uid, $quantity)
{
	$db = db();

	$app = application();

	$user = user($user_id);

	$item = item_incentive_single($uid);

	if (!has_wallet_addr($item->item_name, $user)
		&& in_array($item->item_name, list_token()))
	{
		$app->redirect(Uri::root(true) . '/' . sef(60) . qs() . 'uid=' . $user_id,
			'Please Fill Up the following: Payment Method (' . $item->item_name . ')', 'error');
	}

	$tmp_addr = explode('|', $user->address);

	// mail admin
	$body = 'Username: ' . $user->username . '<br>
		Full Name: ' . $user->fullname . '<br>
		Address: ' . $tmp_addr[0] . ' ' . $tmp_addr[1] . '<br>' .
		$tmp_addr[2] . ' ' . $tmp_addr[3] . '<br>' .
		$tmp_addr[4] . '
		Email: ' . $user->email . '<br>
		Contact Number: ' . $user->contact . '<br><br>
		Purchased
		Item: ' . $item->item_name . '<br>
		Quantity: ' . $item->quantity . ' pcs.<br>
		Price: ' . $item->price . ' pts.';

	$message_admin = 'A member has made a Token Redemption.<br><hr>' . $body;
	$message_user  = 'Thank you for your token redemption. ' .
		'You will be contacted accordingly with regards to the receipt of your items.<br>
			<hr>' . $body;

	try
	{
		$db->transactionStart();

		insert_incentive($user_id, $uid, $quantity);
		update_items_incentive($uid, $quantity);
		update_user($user_id, $uid, $quantity);

		logs($user_id, $uid);

		send_mail($message_admin, 'Token Redemption');

		if ($user->email !== '')
		{
			send_mail($message_user, 'Item Purchase Confirmation', [$user->email]);
		}

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

//	send_mail($user_id, $uid);

	$app->redirect(Uri::root(true) . '/' . sef(53),
		'Token redemption successful!', 'notice');
}