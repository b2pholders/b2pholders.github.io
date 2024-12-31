<?php

namespace BPL\Passup_Bonus;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\time;
use function BPL\Mods\Helpers\user;

/**
 * @param           $insert_id
 * @param           $account_type
 * @param           $entry_name
 * @param           $sponsor_id
 *
 * @param   string  $prov
 * @param   string  $account_type_new
 *
 * @since version
 */
function main(
	$insert_id,
	$account_type,
	$entry_name,
	$sponsor_id,
	string $prov = 'code',
	string $account_type_new = ''
)
{
	$bonus = settings('passup')->{$account_type . '_passup_bonus'};

	if ($prov === 'upgrade')
	{
		$bonus_upgrade = settings('passup')->{$account_type_new . '_passup_bonus'};
		$bonus         = non_zero($bonus_upgrade - $bonus);
	}

	$field_user = ['passup_bonus = passup_bonus + ' . $bonus];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . $bonus;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $bonus;
	}

	$tmp_user_id    = $insert_id;
	$tmp_sponsor_id = $sponsor_id;

	while ($tmp_sponsor_id > 0)
	{
		$tmp_sponsor = user($tmp_sponsor_id);

		$db = db();

		if (is_passup($tmp_sponsor_id, $tmp_user_id))
		{
			update(
				'network_users',
				$field_user,
				['id = ' . $db->quote($tmp_sponsor->sponsor_id)]
			);

			$recipient = user($tmp_sponsor->sponsor_id);

			logs_passup($bonus, $recipient, $entry_name, $tmp_user_id);
		}
//		else
//		{
//			update(
//				'network_users',
//				$field_user,
//				['id = ' . $db->quote($tmp_sponsor_id)]
//			);
//
//			logs_passup($bonus, $tmp_sponsor, $entry_name, $tmp_user_id);
//		}

		$tmp_user_id    = $sponsor_id;
		$tmp_sponsor_id = $tmp_sponsor->sponsor_id;
	}
}

/**
 * @param $value
 *
 * @return int|mixed
 *
 * @since version
 */
function non_zero($value)
{
	return $value < 0 ? 0 : $value;
}

/**
 * @param $sponsor_id
 * @param $insert_id
 *
 * @return bool
 *
 * @since version
 */
function is_passup($sponsor_id, $insert_id): bool
{
	$sponsor = user($sponsor_id);

	$settings_passup = settings('passup');

	$account_type = $sponsor->account_type;

	$interval = $settings_passup->{$account_type . '_passup_interval'};
	$width    = $settings_passup->{$account_type . '_passup_width'};

	$directs = sponsored($sponsor_id);

	$arr_pos = array_search($insert_id, $directs);

	if ($arr_pos)
	{
		$position = (int) $arr_pos + 1;

		$residue = $position % $interval;

		return (
			$sponsor->sponsor_id > 0
			&& $residue == 0
			&& (($width > 0 && count($directs) <= $width) || !$width)
		);
	}

	return false;
}

/**
 * @param $user_id
 *
 * @return array|mixed
 *
 * @since version
 */
function get_directs($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		' AND sponsor_id = ' . $db->quote($user_id) .
		' ORDER BY date_registered'
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return array
 *
 * @since version
 */
function sponsored($user_id): array
{
	// repository for first step directs
	$sponsored = [];

	foreach (get_directs($user_id) as $direct)
	{
		// collect all direct id
		$sponsored[] = $direct->id;
	}

	return $sponsored;
}

/**
 * @param $amount
 * @param $recipient
 * @param $entry_name
 * @param $insert_id
 *
 *
 * @since version
 */
function logs_passup($amount, $recipient, $entry_name, $insert_id)
{
	$sponsor2_id = $recipient->id;

	$db = db();

	$passup_name = ucfirst(settings('plans')->passup_name);

	$activity = '<b>' . $passup_name . ' Bonus: </b> ' . '<a href="' . sef(44) . qs() . 'uid=' . $sponsor2_id .
		'">' . $recipient->username . '</a> gained ' . number_format($amount, 2) . ' ' .
		settings('ancillaries')->currency . ' ' . $passup_name . ' Bonus from the entry of <a href="' .
		sef(44) . qs() . 'uid=' . $insert_id . '">' . $entry_name . '</a>.';

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($sponsor2_id),
			$db->quote($sponsor2_id),
			$db->quote($activity),
			$db->quote(time())
		]
	);
}