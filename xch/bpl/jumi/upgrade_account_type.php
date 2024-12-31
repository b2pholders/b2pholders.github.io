<?php

namespace BPL\Jumi\Upgrade_Account_Type;

require_once 'bpl/upline_support.php';
require_once 'bpl/mods/cd_filter.php';
require_once 'bpl/indirect_referral.php';
//require_once 'bpl/binary_activate_bonus.php';
//require_once 'bpl/mods/binary/core.php';
require_once 'bpl/binary_redundant_bonus.php';
//require_once 'bpl/mods/binary/validate.php';
require_once 'bpl/mods/autoupline_binary.php';
//require_once 'bpl/leadership_binary.php';
require_once 'bpl/leadership_passive.php';
require_once 'bpl/unilevel.php';
require_once 'bpl/passup.php';
//require_once 'bpl/harvest.php';

require_once 'bpl/mods/usdt_currency.php';
require_once 'bpl/menu.php';

require_once 'bpl/mods/ajax.php';
require_once 'bpl/mods/query.php';
require_once 'bpl/mods/mailer.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

use function BPL\Leadership_Passive\insert_leadership_passive;

//use function BPL\Mods\Binary\Core\user_binary;
use function BPL\Mods\USDT_Currency\main as usdt_currency;

use function BPL\Mods\Ajax\check_input;
use function BPL\Mods\Ajax\check_position;

use function BPL\Indirect_Referral\main as indirect_referral;

//use function BPL\Mods\Binary\Core\main as binary_upgrade;
use function BPL\Binary_Redundant\main as binary_upgrade;

//use function BPL\Mods\Binary\Validate\main as binary_validate;

use function BPL\Mods\AutoUpline_Binary\get_upline;

//use function BPL\Mods\AutoUpline_Binary\get_position;
use function BPL\Mods\AutoUpline_Binary\option_position;

//use function BPL\Leadership_Binary\main as leadership_binary;

use function BPL\Unilevel\insert_unilevel;

use function BPL\Passup_Bonus\main as passup;

//use function BPL\Harvest\main as harvest;

use function BPL\Menu\admin as menu_admin;
use function BPL\Menu\member as menu_member;
use function BPL\Menu\manager as menu_manager;

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Mailer\main as send_mail;

use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\session_get;
use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\time;
use function BPL\Mods\Helpers\page_validate;

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
//	$merchant_type    = session_get('merchant_type');
	$user_id          = session_get('user_id');
	$account_type_old = input_get('account_type_old', '', 'RAW');
	$account_type_new = input_get('account_type_new', '', 'RAW');
	$price            = input_get('price', '', 'RAW');
	$method           = input_get('method', '', 'RAW');
	$final            = input_get('final');

//	$upline   = input_get('upline', get_upline($user_id));
//	$position = input_get('position', get_position($upline));

	page_validate();

	$str = menu($usertype, $admintype, $account_type, $username, /*$merchant_type,*/ $user_id);

	if ((int) $final !== 1 && ($account_type_new === '' || ($method === '' && settings('plans')->trading)))
	{
		$str .= view_form($user_id);
	}

	if ((int) $final === 1)
	{
		$str .= view_form_confirm($user_id, $account_type_old, $account_type_new, $method);
	}

	if ((int) $final === 2)
	{
		process_upgrade($user_id, $price, $method, $account_type_old, $account_type_new);
	}

	echo $str;
}

/**
 * @param $user_id
 * @param $account_type_new
 * @param $price
 * @param $method
 *
 *
 * @since version
 */
function update_user($user_id, $account_type_new, $price, $method)
{
	$db = db();

	switch ($method)
	{
		case 'points':
			$field_method = 'points = points - ' . $price;
			break;
		default:
			$field_method = 'payout_transfer = payout_transfer - ' . $price;
			break;
	}

	update(
		'network_users',
		[
			/*($method === 'efund' ? ('payout_transfer = payout_transfer - ' .
				$price) : ('balance_fmc = balance_fmc - ' .
				($price * usdt_currency() * settings('trading')->fmc_to_usd)))*/ $field_method,
			'account_type = ' . $db->quote($account_type_new),
			'date_activated = ' . (time())],
		[
			'id = ' . $db->quote($user_id)
		]
	);
}

/**
 * @param $user_id
 *
 * @param $account_type_new
 *
 * @since version
 */
function log_activity($user_id, $account_type_new)
{
	$db = db();

	$user = user($user_id);

	$settings_entry = settings('entry');

	$activity = '<b>Account Upgrade: </b><a href="' . sef(44) . qs() . 'uid=' . $user_id . '">' .
		$user->username . '</a> upgraded from ' . $settings_entry->{$user->account_type . '_package_name'} .
		' to ' . $settings_entry->{$account_type_new . '_package_name'} . '.';

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
 * @param $price
 * @param $method
 *
 *
 * @since version
 */
function log_transactions($user_id, /*$account_type_new,*/ $price, $method)
{
	$db = db();

	$user = user($user_id);

	$settings_entry = settings('entry');

	/*$price = $settings_entry->{$account_type_new .
		'_entry'} - $settings_entry->{$user->account_type . '_entry'};*/

	$account_type_old_mod = $settings_entry->{$user->account_type . '_package_name'};
	$account_type_new_mod = $settings_entry->{$user->account_type_new . '_package_name'};

	$new_balance = $method === 'efund' ? ($user->payout_transfer - $price) :
		($user->balance_fmc - ($price * usdt_currency() / settings('trading')->fmc_to_usd));

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
			$db->quote('Account Upgrade'),
			$db->quote('Upgrade From ' . $account_type_old_mod . ' to ' . $account_type_new_mod . '.'),
			$db->quote('-' . $price),
			$db->quote($new_balance),
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
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_income ' .
		'ORDER BY income_id DESC'
	)->loadObject();
}

/**
 * @param $user_id
 * @param $price
 *
 * @since version
 */
function log_income_admin($user_id, /*$account_type_new,*/ $price)
{
	$db = db();

//	$settings_entry = settings('entry');

//	$price = $settings_entry->{$account_type_new .
//		'_entry'} - $settings_entry->{user($user_id)->account_type . '_entry'};

	$income_total = income_admin();

	$income = $income_total ? ($income_total->income_total + $price) : 0;

	insert(
		'network_income',
		[
			'transaction_id',
			'amount',
			'income_total',
			'income_date'
		],
		[
			$db->quote($user_id),
			$db->quote($price),
			$db->quote($income),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $account_type_new
 * @param $price
 * @param $method
 *
 *
 * @since version
 */
function logs($user_id, $account_type_new, $price, $method)
{
	log_activity($user_id, $account_type_new);
	log_transactions($user_id, $price, $method);
	log_income_admin($user_id, $price);
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function directs($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE sponsor_id = ' . $db->quote($user_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 * @param $account_type_old
 * @param $account_type_new
 *
 * @since version
 */
function process_direct_referral($user_id, $account_type_old, $account_type_new)
{
	if (settings('plans')->direct_referral)
	{
		$settings_referral = settings('referral');

		$user_direct_referral_old = $settings_referral->{$account_type_old . '_referral'};
		$user_direct_referral_new = $settings_referral->{$account_type_new . '_referral'};

		$referral_final = non_zero($user_direct_referral_new - $user_direct_referral_old);

		$sponsor_id = user($user_id)->sponsor_id;

// 		$sponsor = user($sponsor_id);

// 		$sponsor_account_type = $sponsor->account_type;

// 		$sponsor_direct_referral = $settings_referral->{$sponsor_account_type . '_referral'};

// 		$referral_final = $referral_final > $sponsor_direct_referral ? $sponsor_direct_referral : $referral_final;

		update_sponsor_income_referral($sponsor_id, $referral_final);

		log_direct_referral($user_id, $referral_final, $account_type_old, $account_type_new);
	}
}

/**
 * @param $sponsor_id
 * @param $value
 *
 * @since version
 */
function update_sponsor_income_referral($sponsor_id, $value)
{
	$db = db();

//	$user = user($user_id);

//	$sponsor_id = user($user_id)->sponsor_id;

//	$settings_referral = settings('referral');
//
//	$user_direct_referral_old = $settings_referral->{$account_type_old . '_referral'};
//	$user_direct_referral_new = $settings_referral->{$account_type_new . '_referral'};
//
//	$referral_final = non_zero($user_direct_referral_new - $user_direct_referral_old);

	$sponsor_direct_referral = sponsor_referral_add($value, $sponsor_id);
//	$direct_referral_bonus = count(directs($user_id)) * $user_direct_referral;

	update('network_users',
		[
			'income_referral = income_referral + ' . $sponsor_direct_referral,
			'payout_transfer = payout_transfer + ' . $db->quote($sponsor_direct_referral)
		],
		['id = ' . $db->quote($sponsor_id)]);
}

function non_zero($value)
{
	return $value < 0 ? 0 : $value;
}

/**
 * @param $value
 * @param $sponsor_id
 *
 * @return float|int
 *
 * @since version
 */
function sponsor_referral_add($value, $sponsor_id)
{
//	$sponsor_id = user($user_id)->sponsor_id;
//	$sponsor_account_type = user($sponsor_id)->account_type;
//
//	$settings_referral = settings('referral');
//
//	$val_user    = $settings_referral->{$code_type_new . '_referral'};
//	$val_sponsor = $settings_referral->{$sponsor_account_type . '_referral'};
//
//	$value = $val_user > $val_sponsor ? $val_sponsor : $val_user;

	return deduct($value, $sponsor_id);
}

/**
 * @param $value
 * @param $user_id
 *
 * @return int|mixed
 *
 * @since version
 */
function deduct($value, $user_id)
{
	return cd_filter($user_id, upline_support($value, $user_id));
}

/**
 * @param $user_id
 * @param $account_type_old
 * @param $account_type_new
 *
 * @param $value
 *
 * @since version
 */
function log_direct_referral($user_id, $value, $account_type_old, $account_type_new)
{
	$db = db();

	$user = user($user_id);

	$sponsor_id = $user->sponsor_id;

	$sponsor = user($sponsor_id);

	$settings_entry = settings('entry');

	$settings_plans = settings('plans');

//	$price = $settings_entry->{$account_type_new .
//		'_entry'} - $settings_entry->{$user->account_type . '_entry'};

//	$user_direct_referral = settings('referral')->{$account_type_new . '_referral'};

//	$direct_referral_bonus = count(directs($user_id)) * $price * $user_direct_referral / 100;

	$activity = '<b>Direct Referral Bonus: </b> <a href="' . sef(44) . qs() . 'uid=' . $sponsor_id . '">' .
		$sponsor->username . '</a> gained ' . number_format($value, 2) . ' ' .
		settings('ancillaries')->currency . ' ' . $settings_plans->direct_referral_name . ' Bonus from ' .
		$user->username . '\'s upgrade (' . ucfirst($settings_entry->{$account_type_old . '_package_name'}) . ' to ' .
		ucfirst($settings_entry->{$account_type_new . '_package_name'}) . ')';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			($user->sponsor_id === '0' ? '1' : $db->quote($sponsor_id)),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $account_type_new
 *
 *
 * @since version
 */
function process_indirect_referral($user_id, $account_type_new)
{
	$db = db();

	$settings_indirect_referral = settings('indirect_referral');
	$settings_plans             = settings('plans');

	if ($settings_indirect_referral->{$account_type_new . '_indirect_referral_level'} &&
		$settings_plans->indirect_referral)
	{
		if (empty(user_plan($user_id, 'indirect')))
		{
			insert('network_indirect',
				['user_id'],
				[$db->quote($user_id)]);

			logs_indirect_referral($user_id, $account_type_new, time());
		}

		indirect_referral(/*$user_id, time()*/);
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $date
 *
 * @return void
 *
 * @since version
 */
function logs_indirect_referral($user_id, $type, $date)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($user->sponsor_id),
			$db->quote('<b>' . $settings_plans->indirect_referral_name . ' Entry: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username . '</a> has entered into ' .
				$settings_plans->indirect_referral_name . ' upon ' .
				ucfirst(settings('entry')->{$type . '_package_name'}) . ' upgrade.'),
			$db->quote($date)
		]
	);
}

/**
 * @param $user_id
 * @param $plan
 *
 * @return mixed|null
 *
 * @since version
 */
function user_plan($user_id, $plan)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_' . $plan .
		' WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user_id
 *
 * @since version
 */
function process_binary($user_id)
{
//	$user_binary = user_binary($user_id);

	if (settings('plans')->binary_pair)
	{
//		$max_pairs_new = settings('binary')->{$account_type_new . '_max_pairs'};

//		if (/*$user_binary->capping_cycle < $max_pairs_new && */user_binary($user_id)->status !== 'active')
//		{
		if (update_binary($user_id))
		{
			binary_upgrade($user_id, 'upgrade');
		}
//		}
	}
}

function update_binary($user_id)
{
	$db = db();

	return update('network_binary',
		[
			'status = ' . $db->quote('active')
			, 'capping_cycle = ' . $db->quote(0)
			, 'status_cycle = ' . $db->quote(1)
			, 'ctr_left = ' . $db->quote(0)
			, 'ctr_right = ' . $db->quote(0)
			, 'pairs_today = ' . $db->quote(0)
			, 'reactivate_count = ' . $db->quote(0)
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $user_id
 *
 * @param $type
 *
 * @since version
 */
function process_leadership_binary($user_id, $type)
{
	$settings_plans = settings('plans');

	$type_level = settings('leadership')->{$type . '_leadership_level'};

	if ($type_level > 0 && $settings_plans->leadership_binary)
	{
		if (empty(user_plan($user_id, 'leadership')))
		{
			insert('network_leadership',
				['user_id'],
				[db()->quote($user_id)]);

//			logs_indirect_referral($user_id, $type, $date);
		}

//		leadership_binary(/*$user_id, 'upgrade'*/);
	}
}

/**
 * @param $username
 *
 * @return array|mixed
 *
 * @since version
 */
function user_username($username)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE username = ' . $db->quote($username)
	)->loadObject();
}

/**
 * @param $user_id
 * @param $code_type
 *
 * @since version
 */
function process_compound_daily($user_id, $code_type)
{
	if (settings('investment')->{$code_type . '_principal'} > 0 &&
		settings('plans')->etrade)
	{
		if (empty(user_plan($user_id, 'compound')))
		{
			$settings_investment = settings('investment');

			$db = db();

			insert(
				'network_compound',
				[
					'user_id',
					'time_last',
					'value_last',
					'day',
					'processing',
					'maturity'
				],
				[
					$db->quote($user_id),
					0,
					0,
					0,
					$db->quote($settings_investment->{$code_type . '_processing'}),
					$db->quote($settings_investment->{$code_type . '_maturity'})
				]
			);

			logs_compound_daily_entry($user_id, $code_type);
		}

//		update_compound($user_id, $code_type);

//		logs_compound_daily_upgrade($user_id, $code_type);
	}
}

/**
 * @param $user_id
 * @param $type
 *
 * @since version
 */
function logs_compound_daily_entry($user_id, $type)
{
	$db = db();

	$settings_plans = settings('plans');

	$user = user($user_id);

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user_id),
			$db->quote($user->sponsor_id),
			$db->quote('<b>' . $settings_plans->etrade_name . ' Entry: </b> <a href="' .
				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username .
				'</a> has entered into ' . $settings_plans->etrade_name . ' upon ' .
				ucfirst(settings('entry')->{$type . '_package_name'}) . ' Upgrade'
			),
			$db->quote(time())
		]
	);
}

/**
 * @param $user_id
 * @param $code_type
 *
 * @since version
 */
//function logs_compound_daily_upgrade($user_id, $code_type)
//{
//	$db = db();
//
//	$settings_plans = settings('plans');
//
//	$user = user($user_id);
//
//	$activity = '<b>' . ucwords($settings_plans->etrade_name) . ' Upgrade: </b> <a href="' . sef(44) . qs() .
//		'uid=' . $user_id . '">' . $user->username . '\'s</a> ' . ucwords($settings_plans->etrade_name) .
//		' has been upgraded to ' . ucwords($code_type) . '.';
//
//	insert(
//		'network_activity',
//		[
//			'user_id',
//			'sponsor_id',
//			'activity',
//			'activity_date'
//		],
//		[
//			$db->quote($user_id),
//			$db->quote($user->sponsor_id),
//			$db->quote($activity),
//			$db->quote(time())
//		]
//	);
//}

/**
 * @param $user_id
 * @param $code_type
 *
 *
 * @since version
 */
//function update_compound($user_id, $code_type)
//{
//	$db = db();
//
//	$settings_investment = settings('investment');
//
//	update(
//		'network_compound',
//		[
//			'time_last = ' . $db->quote(0),
//			'value_last = ' . $db->quote(0),
//			'day = ' . $db->quote(0),
//			'processing = ' . $db->quote($settings_investment->{$code_type . '_processing'}),
//			'maturity = ' . $db->quote($settings_investment->{$code_type . '_maturity'})
//		],
//		['user_id = ' . $db->quote($user_id)]
//	);
//}

/**
 * @param $user_id
 * @param $code_type
 *
 * @since version
 */
function process_fixed_daily($user_id, $code_type)
{
	if (settings('investment')->{$code_type . '_fixed_daily_principal'} &&
		settings('plans')->fixed_daily)
	{
		if (empty(user_plan($user_id, 'fixed_daily')))
		{
			$settings_investment = settings('investment');

			$db = db();

			insert(
				'network_fixed_daily',
				[
					'user_id',
					'time_last',
					'value_last',
					'day',
					'processing'
				],
				[
					$db->quote($user_id),
					0,
					0,
					0,
					$db->quote($settings_investment->{$code_type . '_processing'})
				]
			);

			logs_compound_daily_entry($user_id, $code_type);
		}

//		update_fixed_daily($user_id, $code_type);

//		logs_fixed_daily($user_id, $code_type);
	}
}

/**
 * @param $user_id
 * @param $code_type
 *
 * @since version
 */
//function logs_fixed_daily($user_id, $code_type)
//{
//	$settings_plans = settings('plans');
//
//	$sponsor_id = '';
//
//	$user = user($user_id);
//
//	$db = db();
//
//	$activity = '<b>' . ucwords($settings_plans->fixed_daily_name) . ' Upgrade: </b> <a href="' . sef(44) . qs() .
//		'uid=' . $user_id . '">' . $user->username . '\'s</a> ' . ucwords($settings_plans->fixed_daily_name) .
//		' has been upgraded to ' . ucwords($code_type) . '.';
//
//	insert(
//		'network_activity',
//		[
//			'user_id',
//			'sponsor_id',
//			'activity',
//			'activity_date'
//		],
//		[
//			$db->quote($user_id),
//			$db->quote($sponsor_id),
//			$db->quote($activity),
//			$db->quote(time())
//		]
//	);
//}

/**
 * @param $user_id
 * @param $code_type
 *
 *
 * @since version
 */
//function update_fixed_daily($user_id, $code_type)
//{
//	$settings_investment = settings('investment');
//
//	$db = db();
//
//	update(
//		'network_fixed_daily',
//		[
//			'time_last = ' . $db->quote(0),
//			'value_last = ' . $db->quote(0),
//			'day = ' . $db->quote(0),
//			'processing = ' . $db->quote($settings_investment->{$code_type . '_fixed_daily_processing'}),
//			'maturity = ' . $db->quote($settings_investment->{$code_type . '_fixed_daily_maturity'})
//		],
//		['user_id = ' . $db->quote($user_id)]
//	);
//}

/**
 *
 * @return void|null
 *
 * @since version
 */
//function process_harvest()
//{
//	$settings_plans = settings('plans');
//
//	if ($settings_plans->harvest)
//	{
//		harvest();
//
//		return null;
//	}
//}

/**
 * @param $user_id
 * @param $account_type_old
 * @param $account_type_new
 *
 * @since version
 */
function process_plans($user_id, $account_type_old, $account_type_new)
{
	$user = user($user_id);

	$username   = $user->username;
	$sponsor_id = $user->sponsor_id;

	process_direct_referral($user_id, $account_type_old, $account_type_new);
	process_indirect_referral($user_id, $account_type_new);
	process_binary($user_id);
	process_leadership_binary($user_id, $account_type_new);
	process_leadership_passive($user_id, $account_type_new, $username, $sponsor_id, time(), 'upgrade');
	process_unilevel($user_id, $account_type_new, time(), 'upgrade');
	process_passup($user_id, 'upgrade', $account_type_new);

	process_compound_daily($user_id, $account_type_new);
	process_fixed_daily($user_id, $account_type_new);

//	process_harvest();
}

/**
 * @param $user_id
 * @param $prov
 * @param $account_type_new
 *
 *
 * @since version
 */
function process_passup($user_id, $prov, $account_type_new)
{
	if (settings('plans')->passup)
	{
		$user = user($user_id);

		passup($user_id, $user->account_type, $user->username, $user->sponsor_id, $prov, $account_type_new);
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $date
 * @param $prov
 *
 * @since version
 */
function process_unilevel($user_id, $type, $date, $prov)
{
	if (settings('plans')->unilevel &&
		settings('unilevel')->{$type . '_unilevel_level'})
	{
		$user = user($user_id);

		$username = $user->username;
		$sponsor  = user($user->sponsor_id)->username;

		insert_unilevel($user_id, $type, $username, $sponsor, $date, $prov);

//		if ($insert_unilevel)
//		{
//			logs_unilevel($user_id, $type, $date);
//		}
	}
}

/**
 * @param $user_id
 * @param $type
 * @param $date
 *
 * @since version
 */
//function logs_unilevel($user_id, $type, $date)
//{
//	$db = db();
//
//	$settings_plans = settings('plans');
//
//	$user = user($user_id);
//
//	insert(
//		'network_activity',
//		[
//			'user_id',
//			'sponsor_id',
//			'activity',
//			'activity_date'
//		],
//		[
//			$db->quote($user_id),
//			$db->quote($user->sponsor_id),
//			$db->quote('<b>' . $settings_plans->unilevel_name . ' Entry via Upgrade: </b> <a href="' .
//				sef(44) . qs() . 'uid=' . $user_id . '">' . $user->username .
//				'</a> has entered into ' . $settings_plans->unilevel_name . ' upon ' .
//				ucfirst(settings('entry')->{$type . '_package_name'}) . ' activation.'),
//			$db->quote($date)
//		]
//	);
//}

/**
 * @param $user_id
 * @param $type
 * @param $username
 * @param $sponsor
 * @param $date
 * @param $prov
 *
 * @since version
 */
function process_leadership_passive($user_id, $type, $username, $sponsor, $date, $prov)
{
	if (settings('plans')->leadership_passive &&
		settings('leadership_passive')->{$type . '_leadership_passive_level'})
	{
		insert_leadership_passive($user_id, $type, $username, $sponsor, $date, $prov);
	}
}

/**
 * @param $user_id
 * @param $price
 * @param $method
 * @param $account_type_old
 * @param $account_type_new
 *
 *
 * @since version
 */
function process_upgrade($user_id, $price, $method, $account_type_old, $account_type_new)
{
	Session::checkToken() or die(Text::_('Invalid Token'));

	$db = db();

	$app = application();

	$user = user($user_id);

//	$settings_plans       = settings('plans');
	$settings_trading     = settings('trading');
	$settings_ancillaries = settings('ancillaries');

//	$min_bal_usd = $settings_ancillaries->{$user->account_type . '_min_bal_usd'};
	$currency = $settings_ancillaries->currency;

	if ($method === 'token' && $user->balance_fmc < ($price * usdt_currency() * $settings_trading->fmc_to_usd))
	{
		$msg = 'Not enough ' . $settings_trading->token_name . '!';
		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'error');
	}

	if ($method === 'efund' && $user->payout_transfer < ($price/* + $min_bal_usd*/))
	{
		$msg = 'Not enough ' . $settings_ancillaries->efund_name . ', please maintain at least ' .
			number_format($price /*+ $min_bal_usd*/, 2) . ' ' . $currency;

		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'error');
	}

	if ($method === 'points' && $user->points < ($price/* + $min_bal_usd*/))
	{
		$msg = 'Not enough token ' /*. $settings_ancillaries->efund_name*/ . ', please maintain at least ' .
			number_format($price /*+ $min_bal_usd*/, 2) . ' tokens '/* . $currency*/
		;

		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'error');
	}

//	binary_validate($user_id, $upline, $position, $account_type_new, 'upgrade');

	$user = user($user_id);

	$settings_entry = settings('entry');

	$account_type_old_mod = $settings_entry->{$user->account_type . '_package_name'};
	$account_type_new_mod = $settings_entry->{$account_type_new . '_package_name'};

	$user = user($user_id);

	// mail admin
	$message_admin = 'Username: ' . $user->username . ($user->fullname ? ('<br>
		Full Name: ' . $user->fullname) : '') . '<br>
		Email: ' . $user->email . ($user->contact ? ('<br>
		Contact Number: ' . $user->contact) : '') . '<br><br>

		Old Account Type: ' . $account_type_old_mod . '<br>
		New Account Type: ' . $account_type_new_mod;

	$message_user = 'Your account has been upgraded from ' . $account_type_old_mod .
		' to ' . $account_type_new_mod . '.<br> Thank you for upgrading.<br><hr>';

	try
	{
		$db->transactionStart();

		update_user($user_id, $account_type_new, $price, $method);

		logs($user_id, $account_type_new, $price, $method);

		process_plans($user_id, $account_type_old, $account_type_new);

		send_mail($message_admin, 'Account Type Upgrade');
		send_mail($message_user, 'Account Type Upgrade Confirmation', [$user->email]);

		$db->transactionCommit();
	}
	catch (Exception $e)
	{
		$db->transactionRollback();
		ExceptionHandler::render($e);
	}

	application()->redirect(Uri::root(true) . '/' . sef(41), $user->username .
		' successfully upgraded from ' . ucfirst($account_type_old_mod) . ' to ' .
		ucfirst($account_type_new_mod), 'notice');
}

/**
 *
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
function menu($usertype, $admintype, $account_type, $username, /*$merchant_type,*/ $user_id): string
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
function row_balance_remaining($user_id): string
{
	$user = user($user_id);

	$token  = $user->balance_fmc;
	$efund  = $user->payout_transfer;
	$points = $user->points;

	$str = '<tr><td colspan="2">';

	$str .= settings('plans')->trading ? ('<strong>Token Balance: </strong>' .
		number_format($token, 2) . ' ' .
		settings('trading')->token_name . '<span style="float: right">') : '';
	$str .= '<strong>' . settings('ancillaries')->efund_name . ' Balance: </strong>' .
		number_format($efund, 2) . '</span>';

	$str .= '<b style="float: right">Token Balance: ' . number_format($points, 2) . '</b>';

	$str .= '</td></tr>';

	return $str;
}

/**
 *
 * @param $user_id
 *
 * @return string
 *
 * @since version
 */
function view_form($user_id): string
{
	$app = application();

	$user = user($user_id);

	if ($user->account_type === 'executive' || $user->account_type === 'starter')
	{
		$msg = 'No need to upgrade';

		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'notice');
	}

	$user = user($user_id);

	$settings_entry       = settings('entry');
	$settings_ancillaries = settings('ancillaries');
//	$settings_trading     = settings('trading');
	$settings_plans = settings('plans');

	$account_type_old = $user->account_type;

	$account_price_old = $settings_entry->{$account_type_old . '_entry'};

	$currency = $settings_ancillaries->currency;

	$str = '<h1>Upgrade Account Type</h1>';
	$str .= '<form name="regForm" method="post" onsubmit="submit.disabled = true; return true;">
		<input type="hidden" name="final" value="1">
		<input type="hidden" name="account_type_old" value="' . $account_type_old . '">
        <p><strong>Note: Account upgrade once processed is final and non-refundable.</strong>
        </p>
        <table class="category table table-striped table-bordered table-hover">';

	$str .= row_balance_remaining($user_id);

	$str .= '<tr>
                <td>Current Account Type:</td>
                <td>' . $settings_entry->{$account_type_old . '_package_name'} .
		' (worth ' . number_format($account_price_old, 2) . ' ' . $currency . ')' . '</td>
            </tr>';
	$str .= '<tr>
                <td style="width: 200px"><label for="account_type_new">Packages: *</label></td>
                <td>';
	$str .= '<select name="account_type_new" id="account_type_new" style="float:left">
				<option value="none" selected>Packages</option>';

	switch ($user->account_type)
	{
		case 'associate':
			$str .= ($settings_entry->regular_entry ? ('<option value="regular">' .
				$settings_entry->regular_package_name . '</option>') : '');
			$str .= ($settings_entry->executive_entry ? ('<option value="executive">' .
				$settings_entry->executive_package_name . '</option>') : '');

			break;
		case 'regular':
			$str .= ($settings_entry->executive_entry ? ('<option value="executive">' .
				$settings_entry->executive_package_name . '</option>') : '');
			break;
		case 'executive':
			$str .= '';
			break;
		default:
			$str .= ($settings_entry->associate_entry ? ('<option value="associate">' .
				$settings_entry->associate_package_name . '</option>') : '');
			$str .= ($settings_entry->regular_entry ? ('<option value="regular">' .
				$settings_entry->regular_package_name . '</option>') : '');
			$str .= ($settings_entry->executive_entry ? ('<option value="executive">' .
				$settings_entry->executive_package_name . '</option>') : '');

			break;
	}

	$str .= '</select>';

//	if ($settings_plans->trading)
//	{
	$str .= '<select name="method" id="method" style="float: left">';
//		$str .= '<option value="none" selected>Payment method</option>';
//		$str .= '<option value="token">' . $settings_trading->token_name . '</option>';
	$str .= '<option value="efund" selected>' . $settings_ancillaries->efund_name . '</option>';
	$str .= '<option value="points">Token</option>';
	$str .= '</select>';
//	}

	$str .= '<input type="submit" name="submit" value="Upgrade" class="uk-button uk-button-primary" style="float:left">
    </td>
    </tr>
    </table>
    </form>';

	return $str;
}

/**
 *
 * @param $user_id
 * @param $account_type_old
 * @param $account_type_new
 * @param $method
 *
 * @return string
 *
 * @since version
 */
function view_form_confirm($user_id, $account_type_old, $account_type_new, $method): string
{
	$user = user($user_id);

	$settings_ancillaries = settings('ancillaries');

//	$app = application();

	$settings_entry = settings('entry');
	$settings_plans = settings('plans');
//	$settings_trading = settings('trading');

	$account_price = $settings_entry->{$user->account_type . ($method == 'efund' ? '_entry' : '_points')};

	$currency = settings('ancillaries')->currency;

	$account_price_new    = $settings_entry->{$account_type_new . ($method == 'efund' ? '_entry' : '_points')};
	$account_type_new_mod = $settings_entry->{$account_type_new . '_package_name'};

	$price = $account_price_new - $account_price;

	$account_type_mod = $settings_entry->{$user->account_type . '_package_name'};

	$app = application();

	if ($user->account_type === 'executive')
	{
		$msg = 'No need to upgrade, you have the highest account.';

		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'notice');
	}

	if ($account_type_new === 'none')
	{
		$msg = 'Select package';

		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'error');
	}

	if ($method === 'none' && $settings_plans->trading)
	{
		$msg = 'Select method';

		$app->redirect(Uri::root(true) . '/' . sef(110), $msg, 'error');
	}

	$str = '<form name="regForm" method="post" onsubmit="submit.disabled = true; return true;">
            <input type="hidden" name="final" value="2">
            <input type="hidden" name="account_type_old" value="' . $account_type_old . '">
            <input type="hidden" name="account_type_new" value="' . $account_type_new . '">
            <input type="hidden" name="price" value="' . $price . '">
            <input type="hidden" name="method" value="' . /*($settings_plans->trading ? $method : 'efund')*/
		$method . '">         
            <p><strong>Final confirmation</strong></p>
            <table class="category table table-striped table-bordered table-hover">';

	if ($method === 'token')
	{
		$str .= '<tr>
                    <td>' . settings('trading')->token_name . ':</td>
                    <td>' . number_format($user->balance_fmc, 2) . ' ' . $currency . '</td>
                </tr>';
	}
	elseif ($method === 'points')
	{
		$str .= '<tr>
                    <td>Token' . /*$settings_ancillaries->efund_name .*/
			':</td>
                    <td>' . number_format($user->/*payout_transfer*/points, 2) . ' ' . $currency . '</td>
                </tr>';
	}
	else
	{
		$str .= '<tr>
                    <td>' . $settings_ancillaries->efund_name . ':</td>
                    <td>' . number_format($user->payout_transfer, 2) . ' ' . $currency . '</td>
                </tr>';
	}

	$str .= '<tr>
                    <td>Current Account Type:</td>
                    <td>' . $account_type_mod . '</td>
                </tr>
                <tr>
                    <td style="width: 200px">Upgrade to:</td>
                    <td>' . $account_type_new_mod . '</td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>' . number_format($price, 2) . ' ' . $currency . '</td>
                </tr>';

	$str .= !$settings_plans->trading ? '' : '<tr>
                    <td>Method:</td>
                    <td>' . $method . '</td>
                </tr>';

	if (settings('binary')->{$account_type_new . '_pairs'} > 0 &&
		settings('plans')->binary_pair &&
		empty(user_plan($user_id, 'binary')))
	{
		$str .= '<tr>
            <td><label for="upline">Upline Username: *</label></td>
            <td><input type="text"
                       name="upline"
                       id="upline"
                       value="' . get_upline($user_id) . '"
                       size="40"                       
                       required="required"
                       style="float:left">
                <a href="javascript:void(0)" onClick="checkInput(\'upline\')" class="uk-button uk-button-primary" 
                style="float:left">Verify</a>
                <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
                     id="uplineDiv"></div>
            </td>
        </tr>
        <tr>
            <td><label for="position">Position:</label></td>
            <td>
                <select name="position" id="position" style="float:left">' .
			option_position(get_upline($user_id)) . '
                    <!--<option value="Left">Left</option>
                    <option value="Right">Right</option>-->
                </select>
                <a href="javascript:void(0)" onClick="checkPosition(\'upline\', \'position\')" class="uk-button uk-button-primary" 
                style="float:left">Verify</a>
        <div style="width:200px; height:20px; font-weight:bold; float:left; padding:7px 0 0 10px;"
             id="positionDiv"></div>
        </td>
        </tr>';
	}

	$str .= '</table>' . HTMLHelper::_('form.token') .
		'<input type="submit" value="Confirm" name="submit" class="uk-button uk-button-primary">
            <a href="' . sef(110) . '" class="uk-button uk-button-primary">Cancel</a>
        </form>';

	$str .= check_input();
	$str .= check_position();

	return $str;
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
		'FROM network_users u ' .
		'INNER JOIN network_binary b ' .
		'ON u.id = b.user_id ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}