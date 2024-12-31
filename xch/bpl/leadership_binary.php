<?php

namespace BPL\Leadership_Binary;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/cd_filter.php';
//require_once 'bpl/upline_support.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Database\Query\update;
use function BPL\Mods\Database\Query\insert;

use function BPL\Mods\Commission_Deduct\Filter\main as cd_filter;

//use function BPL\Upline_Support\main as upline_support;
use function BPL\Mods\Url_SEF\sef;
use function BPL\Mods\Url_SEF\qs;

use function BPL\Mods\Helpers\db;

//use function BPL\Mods\Helpers\user;
use function BPL\Mods\Helpers\users;
use function BPL\Mods\Helpers\settings;

/**
 *
 *
 * @since version
 */
function main()
{
	foreach (users() as $user)
	{
		$slb = settings('leadership');

		$account_type  = $user->account_type;
		$user_bonus_lb = $user->bonus_leadership;

		$sponsored = user_directs($user->id);

		$type_level       = $slb->{$account_type . '_leadership_level'};
		$required_directs = $slb->{$account_type . '_leadership_sponsored'};
		$max_daily_income = $slb->{$account_type . '_leadership_max_daily_income'};
		$max_income_total = $slb->{$account_type . '_leadership_max'};

		$ulb = user_leadership($user->id);

		$income_today = $ulb->income_today;

		if (
			$type_level
//	        && empty(user_cd($user->id))
			&& count($sponsored) >= $required_directs
		)
		{
			$lb     = bonus_total($user);
			$lb_add = $lb - $ulb->bonus_leadership_last;

			if ($lb_add > 0)
			{
				if ($max_daily_income > 0 && ($income_today + $lb_add) >= $max_daily_income)
				{
					$lb_add = non_zero($max_daily_income - $income_today);
				}

				if ($max_income_total > 0 && ($user_bonus_lb + $lb_add) >= $max_income_total)
				{
					$lb_add = non_zero($max_income_total - $user_bonus_lb);
				}

				update_bonus_lb($lb_add, $lb, $user);
			}
		}
	}
}

/**
 * @param $lb_add
 * @param $lb
 * @param $user
 *
 *
 * @since version
 */
function update_bonus_lb($lb_add, $lb, $user)
{
	$db = db();

//    $se = settings('entry');
//    $sf = settings('freeze');

	$user_id = $user->id;
//    $account_type = $user->account_type;

//    $income_cycle_global = $user->income_cycle_global;

//    $entry  = $se->{$account_type . '_entry'};
//    $factor = $sf->{$account_type . '_percentage'} / 100;

//    $freeze_limit = $entry * $factor;

//    $status = $user->status_global;

//    if ($income_cycle_global >= $freeze_limit)
//    {
//        if ($status === 'active')
//        {
//            update(
//                'network_users',
//                [
//                    'status_global = ' . $db->quote('inactive'),
//                    'income_flushout = income_flushout + ' . $lb_add
//                ],
//                ['id = ' . $db->quote($user_id)]
//            );
//        }
//
//        update_leadership(0, $lb, $user_id);
//    }
//    else
//    {
//        $diff = $freeze_limit - $income_cycle_global;
//
//        if ($diff < $lb_add)
//        {
//            $flushout_global = $lb_add - $diff;
//
//            if ($status === 'active')
//            {
//                $field_user = ['bonus_leadership = bonus_leadership + ' . $diff];
//
//                $field_user[] = 'status_global = ' . $db->quote('inactive');
//                $field_user[] = 'income_cycle_global = income_cycle_global + ' . cd_filter($user_id, $diff);
//                $field_user[] = 'income_flushout = income_flushout + ' . $flushout_global;
//
//                if (settings('ancillaries')->withdrawal_mode === 'standard')
//                {
//                    $field_user[] = 'balance = balance + ' . cd_filter($user_id, $diff);
//                }
//                else
//                {
//                    $field_user[] = 'payout_transfer = payout_transfer + ' . cd_filter($user_id, $diff);
//                }
//
//                update(
//                    'network_users',
//                    $field_user,
//                    ['id = ' . $db->quote($user_id)]
//                );
//            }
//
//            update_leadership($diff, $lb, $user_id);
//        }
//        else
//        {
	$field_user = ['bonus_leadership = bonus_leadership + ' . $lb_add];

//	$field_user[] = 'income_cycle_global = income_cycle_global + ' . cd_filter($user_id, $lb_add);

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . cd_filter($user_id, $lb_add);
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . cd_filter($user_id, $lb_add);
	}

	update(
		'network_users',
		$field_user,
		['id = ' . $db->quote($user_id)]
	);

	update_leadership($lb_add, $lb, $user_id);
//        }

	log_activity($user, $lb);
//    }
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
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function view($user): string
{
	$account_type = $user->account_type;

	$required_directs = settings('leadership')->{$account_type . '_leadership_sponsored'};
	$level            = settings('leadership')->{$account_type . '_leadership_level'};

	$status = count(user_directs($user->id)) >= $required_directs ? '' : ' (inactive)';

	$currency = settings('ancillaries')->currency;

	$str = '<h3>Profit Summary</h3>
        <table class="category table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>
                    <div style="text-align: center"><h4>Level</h4></div>
                </th>
                <th>
                    <div style="text-align: center"><h4>Team</h4></div>
                </th>
                <th>
                    <div style="text-align: center"><h4>Profit (' . $currency . ')</h4></div>
                </th>
                <th>
                    <div style="text-align: center"><h4>Percentage (%)</h4></div>
                </th>
            </tr>
            </thead>
            <tbody>';

	switch ((int) $level)
	{
		case 1:
			$str .= view_row(1, $user);

			break;
		case 2:
			$str .= view_row(1, $user);
			$str .= view_row(2, $user);

			break;
		case 3:
			$str .= view_row(1, $user);
			$str .= view_row(2, $user);
			$str .= view_row(3, $user);

			break;
		case 4:
			$str .= view_row(1, $user);
			$str .= view_row(2, $user);
			$str .= view_row(3, $user);
			$str .= view_row(4, $user);

			break;
		case 5:
			$str .= view_row(1, $user);
			$str .= view_row(2, $user);
			$str .= view_row(3, $user);
			$str .= view_row(4, $user);
			$str .= view_row(5, $user);

			break;
		case 6:
			$str .= view_row(1, $user);
			$str .= view_row(2, $user);
			$str .= view_row(3, $user);
			$str .= view_row(4, $user);
			$str .= view_row(5, $user);
			$str .= view_row(6, $user);

			break;
		case 7:
			$str .= get_str_row7($user);

			break;
		case 8:
			$str .= get_str_row7($user);
			$str .= view_row(8, $user);

			break;
		case 9:
			$str .= get_str_row7($user);
			$str .= view_row(8, $user);
			$str .= view_row(9, $user);

			break;
		case 10:
			$str .= get_str_row7($user);
			$str .= view_row(8, $user);
			$str .= view_row(9, $user);
			$str .= view_row(10, $user);

			break;
	}

	$str .= '<tr>
                <td>
                    <div style="text-align: center"><strong>Total' . $status . '</strong></div>
                </td>
                <td>
                    <div style="text-align: center">' . (members_total($user)) . '</div>
                </td>
                <td>
                    <div style="text-align: center">' . number_format(/*bonus_total($user)*/ $user->bonus_leadership, 8) . '</div>
                </td>
                <td>
                    <div style="text-align: center">N/A</div>
                </td>
            </tr>
            </tbody>
        </table>';

	return $str;
}

/**
 * @param $level
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function view_row($level, $user): string
{
	$sl = settings('leadership');

	switch ((int) $level)
	{
		case 1:
			$members = members_lvl1($user);
			$bonus   = leadership_lvl1($user);
			break;
		case 2:
			$members = members_lvl2($user);
			$bonus   = leadership_lvl2($user);
			break;
		case 3:
			$members = members_lvl3($user);
			$bonus   = leadership_lvl3($user);
			break;
		case 4:
			$members = members_lvl4($user);
			$bonus   = leadership_lvl4($user);
			break;
		case 5:
			$members = members_lvl5($user);
			$bonus   = leadership_lvl5($user);
			break;
		case 6:
			$members = members_lvl6($user);
			$bonus   = leadership_lvl6($user);
			break;
		case 7:
			$members = members_lvl7($user);
			$bonus   = leadership_lvl7($user);
			break;
		case 8:
			$members = members_lvl8($user);
			$bonus   = leadership_lvl8($user);
			break;
		case 9:
			$members = members_lvl9($user);
			$bonus   = leadership_lvl9($user);
			break;
		case 10:
			$members = members_lvl10($user);
			$bonus   = leadership_lvl10($user);
			break;
		default:
			$members = 0;
			$bonus   = 0;
			break;
	}

	$str = '<tr>';

	$str .= '<td>
                        <div style="text-align: center" ' .
		($level === 1 ? 'style="color: red"' : '') . '>
                            <strong>' . ((int) $level !== 1 ? $level : '') .
		($level === 1 ? ' (Direct)' : '') . '</strong>
                        </div>
                    </td>';

	$str .= '<td>
                        <div style="text-align: center" ' .
		($level === 1 ? 'style="color: red"' : '') . '>' .
		($level === 1 ? ('(' . $members . ')') : $members) . '</div>
                    </td>';

	$str .= '<td>
                        <div style="text-align: center" ' .
		((int) $level === 1 ? 'style="color: red"' : '') . '>' .
		((int) $level === 1 ? ('(' . number_format($bonus, 8) . ')') :
			number_format($bonus, 8)) . '</div>
                    </td>';

	$share     = $sl->{$user->account_type . '_leadership_share_' . $level};
	$share_cut = $sl->{$user->account_type . '_leadership_share_cut_' . $level};

	$percentage = $share * $share_cut / 100;

	$str .= '<td>
                        <div style="text-align: center" ' .
		((int) $level === 1 ? 'style="color: red"' : '') . '>' .
		((int) $level === 1 ? ('(' . number_format($percentage, 2) . ')') :
			number_format($percentage, 2)) . '</div>
                    </td>';

	$str .= '</tr>';

	return $str;
}

function log_activity($user, $bonus)
{
	$db = db();

	insert(
		'network_activity',
		[
			'user_id',
			'sponsor_id',
			'activity',
			'activity_date'
		],
		[
			$db->quote($user->id),
			$db->quote($user->sponsor_id),
			$db->quote('<b>' . settings('plans')->leadership_binary_name .
				' Bonus: </b> <a href="' . sef(44) . qs() . 'uid=' . $user->id . '">' .
				$user->username . '</a> has earned ' . number_format($bonus, 2) .
				' ' . settings('ancillaries')->currency
			),
			($db->quote(time()))
		]
	);
}

/**
 * @param $user
 *
 * @return string
 *
 * @since version
 */
function get_str_row7($user): string
{
	$str = view_row(1, $user);
	$str .= view_row(2, $user);
	$str .= view_row(3, $user);
	$str .= view_row(4, $user);
	$str .= view_row(5, $user);
	$str .= view_row(6, $user);
	$str .= view_row(7, $user);

	return $str;
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function bonus_total($user)
{
	$settings_leadership = settings('leadership');

	$account_type = $user->account_type;

	$required_directs = $settings_leadership->{$account_type . '_leadership_sponsored'};
	$type_level       = $settings_leadership->{$account_type . '_leadership_level'};

	$total = 0;

	if (count(user_directs($user->id)) >= $required_directs)
	{
		switch ($type_level)
		{
			case 1:
				$total = leadership_lvl1($user);

				break;
			case 2:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user));

				break;
			case 3:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user));

				break;
			case 4:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user));

				break;
			case 5:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user) +
					leadership_lvl5($user));

				break;
			case 6:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user) +
					leadership_lvl5($user) +
					leadership_lvl6($user));

				break;
			case 7:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user) +
					leadership_lvl5($user) +
					leadership_lvl6($user) +
					leadership_lvl7($user));

				break;
			case 8:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user) +
					leadership_lvl5($user) +
					leadership_lvl6($user) +
					leadership_lvl7($user) +
					leadership_lvl8($user));

				break;
			case 9:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user) +
					leadership_lvl5($user) +
					leadership_lvl6($user) +
					leadership_lvl7($user) +
					leadership_lvl8($user) +
					leadership_lvl9($user));

				break;
			case 10:
				$total = (
					leadership_lvl1($user) +
					leadership_lvl2($user) +
					leadership_lvl3($user) +
					leadership_lvl4($user) +
					leadership_lvl5($user) +
					leadership_lvl6($user) +
					leadership_lvl7($user) +
					leadership_lvl8($user) +
					leadership_lvl9($user) +
					leadership_lvl10($user));

				break;
		}
	}

	return $total;
}

/**
 * @param $level
 * @param $indirects
 * @param $head_account_type
 *
 * @return float|int
 *
 * @since version
 */
function bonus_leadership($level, $indirects, $head_account_type)
{
	$bonus = 0;

	if (!empty($indirects))
	{
		$slb = settings('leadership');

		$head_share     = $slb->{$head_account_type . '_leadership_share_' . $level} / 100;
		$head_share_cut = $slb->{$head_account_type . '_leadership_share_cut_' . $level} / 100;

		$head_bonus_share = $head_share * $head_share_cut;

		foreach ($indirects as $indirect)
		{
			$user_binary = user_binary($indirect->id);

			$indirect_account_type = $user_binary->account_type;

			$indirect_share     = $slb->{$indirect_account_type . '_leadership_share_' . $level} / 100;
			$indirect_share_cut = $slb->{$indirect_account_type . '_leadership_share_cut_' . $level} / 100;

			$indirect_bonus_share = $indirect_share * $indirect_share_cut;

			$share = !empty(user_cd($indirect->id)) ? 0
				: ($indirect_bonus_share < $head_bonus_share ? $indirect_bonus_share : $head_bonus_share);

			$bonus += $user_binary->income_cycle * $share;
		}
	}

	return $bonus;
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
		'WHERE b.user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl1($user)
{
	return bonus_leadership(1, level_directs([$user]), $user->account_type);
}

function leadership_lvl2($user)
{
	return bonus_leadership(2, level_directs(level_directs([$user])), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl3($user)
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);

	return bonus_leadership(3, level_directs($level_2), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl4($user)
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);

	return bonus_leadership(4, level_directs($level_3), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl5($user)
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);

	return bonus_leadership(5, level_directs($level_4), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl6($user)
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);
	$level_5 = level_directs($level_4);

	return bonus_leadership(6, level_directs($level_5), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl7($user)
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);
	$level_5 = level_directs($level_4);
	$level_6 = level_directs($level_5);

	return bonus_leadership(7, level_directs($level_6), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl8($user)
{
	return bonus_leadership(8, get_level7($user), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl9($user)
{
	$level_8 = get_level7($user);

	return bonus_leadership(9, level_directs($level_8), $user->account_type);
}

/**
 * @param $user
 *
 * @return float|int
 *
 * @since version
 */
function leadership_lvl10($user)
{
	$level_8 = get_level7($user);
	$level_9 = level_directs($level_8);

	return bonus_leadership(10, level_directs($level_9), $user->account_type);
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl1($user): int
{
	return count(level_directs([$user]));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl2($user): int
{
	return count(level_directs(level_directs([$user])));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl3($user): int
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);

	return count(level_directs($level_2));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl4($user): int
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);

	return count(level_directs($level_3));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl5($user): int
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);

	return count(level_directs($level_4));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl6($user): int
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);
	$level_5 = level_directs($level_4);

	return count(level_directs($level_5));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl7($user): int
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);
	$level_5 = level_directs($level_4);
	$level_6 = level_directs($level_5);

	return count(level_directs($level_6));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl8($user): int
{
	return count(get_level7($user));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl9($user): int
{
	$level_8 = get_level7($user);

	return count(level_directs($level_8));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_lvl10($user): int
{
	$level_8 = get_level7($user);
	$level_9 = level_directs($level_8);

	return count(level_directs($level_9));
}

/**
 * @param $user
 *
 * @return int
 *
 * @since version
 */
function members_total($user): int
{
	return (members_lvl1($user) +
		members_lvl2($user) +
		members_lvl3($user) +
		members_lvl4($user) +
		members_lvl5($user) +
		members_lvl6($user) +
		members_lvl7($user) +
		members_lvl8($user) +
		members_lvl9($user) +
		members_lvl10($user));
}

/**
 * @param $user
 *
 * @return array
 *
 * @since version
 */
function get_level7($user): array
{
	$level_1 = level_directs([$user]);
	$level_2 = level_directs($level_1);
	$level_3 = level_directs($level_2);
	$level_4 = level_directs($level_3);
	$level_5 = level_directs($level_4);
	$level_6 = level_directs($level_5);
	$level_7 = level_directs($level_6);

	return level_directs($level_7);
}

/**
 * @param   array  $lvl_1
 *
 * @return array
 *
 * @since version
 */
function level_directs(array $lvl_1 = []): array
{
	$lvl_directs = [];

	if (!empty($lvl_1))
	{
		foreach ($lvl_1 as $s1)
		{
			$directs = user_directs($s1->id);

			if (!empty($directs))
			{
				foreach ($directs as $direct)
				{
					$lvl_directs[] = $direct; // user object
				}
			}
		}
	}

	return $lvl_directs;
}

function user_cd($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_commission_deduct ' .
		'WHERE id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $sponsor_id
 *
 * @return array
 *
 * @since version
 */
function user_directs($sponsor_id): array
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_users ' .
		'WHERE account_type <> ' . $db->quote('starter') .
		'AND sponsor_id = ' . $db->quote($sponsor_id)
	)->loadObjectList();
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function user_leadership($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM network_leadership ' .
		'WHERE user_id = ' . $db->quote($user_id)
	)->loadObject();
}

/**
 * @param $leadership_add
 * @param $leadership
 * @param $user_id
 *
 *
 * @since version
 */
function update_leadership($leadership_add, $leadership, $user_id)
{
	$db = db();

	update(
		'network_leadership',
		[
			'bonus_leadership = bonus_leadership + ' . $leadership_add,
			'bonus_leadership_now = bonus_leadership_now + ' . $leadership_add,
			'bonus_leadership_last = ' . $db->quote($leadership),
			'income_today = income_today + ' . $leadership_add
		],
		['user_id = ' . $db->quote($user_id)]
	);
}

/**
 * @param $bonus
 * @param $user_id
 *
 *
 * @since version
 */
function update_user($bonus, $user_id)
{
	$field_user = ['bonus_leadership = bonus_leadership + ' . $bonus];

	if (settings('ancillaries')->withdrawal_mode === 'standard')
	{
		$field_user[] = 'balance = balance + ' . $bonus;
	}
	else
	{
		$field_user[] = 'payout_transfer = payout_transfer + ' . $bonus;
	}

	update(
		'network_users',
		$field_user,
		['id = ' . db()->quote($user_id)]
	);
}