<?php

namespace Cron\Binary_Flushout;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';

use Exception;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

use function Cron\Database\Query\fetch;
use function Cron\Database\Query\fetch_all;
use function Cron\Database\Query\crud;

main();

/**
 *
 *
 * @since version
 */
function main()
{
//    $interval = 12 * 60 * 60; // 12-hour cycle

    $dbh = DB_Cron::connect();

    $users = binary_users();

    if (!empty($users))
    {
        foreach ($users as $user)
        {
            $flushed = flushed(
                $user->account_type,
                $user->pairs_today,
                $user->pairs_today_total,
                $user->ctr_left,
                $user->ctr_right
            );

//            $diff = time() - $user->date_last_flushout;

            if ($flushed /* && ($diff >= $interval)*/ /*(int) $user->user_id === 4*/)
            {
//	            $max_cycle = settings('binary')->{$user->account_type . '_max_cycle'};
//
//            	return $user->username . '(' . $user->account_type . '): ' . $max_cycle;

	            $leg_retention = settings('binary')->{$user->account_type . '_leg_retention'} / 100;

	            $diff_rdx = $leg_retention * abs($user->ctr_left - $user->ctr_right);

	            $ctr_left_new = $user->ctr_left > $user->ctr_right ? $diff_rdx : 0;
                $ctr_right_new = $user->ctr_right > $user->ctr_left ? $diff_rdx : 0;
            	
                try
                {
                    $dbh->beginTransaction();

                    update_binary($ctr_left_new, $ctr_right_new, $user->user_id);

                    $dbh->commit();
                }
                catch (Exception $e)
                {
                    try
                    {
                        $dbh->rollback();
                    }
                    catch (Exception $e2)
                    {
                    }
                }
            }
        }
    }
}

/**
 * @param $type
 *
 * @return mixed
 *
 * @since version
 */
function settings($type)
{
    return fetch(
        'SELECT * ' .
        'FROM network_settings_' . $type
    );
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function binary_users()
{
    return fetch_all(
        'SELECT * ' .
        'FROM network_binary b ' .
        'INNER JOIN network_users u ' .
        'ON b.user_id = u.id'
    );
}

/**
 * @param $ctr_left_new
 * @param $ctr_right_new
 * @param $id
 *
 * @since version
 */
 
function update_binary($ctr_left_new, $ctr_right_new, $id)
{
    crud('UPDATE network_binary ' .
        'SET pairs_today = :pairs_today, ' .
//        'pairs_today_total = :pairs_today_total, ' .
        'ctr_left = :ctr_left, ' .
        'ctr_right = :ctr_right, ' .
        'date_last_flushout = :date_last_flushout' .
        ' WHERE user_id = :user_id',
        [
            'user_id'            => $id,
            'pairs_today'        => 0,
//            'pairs_today_total'  => 0,
            'ctr_left'           => $ctr_left_new,
            'ctr_right'          => $ctr_right_new,
            'date_last_flushout' => time()
        ]
    );
}

/**
 * @param $account_type
 * @param $pairs_today
 * @param $pairs_today_total
 * @param $ctr_left
 * @param $ctr_right
 *
 * @return bool
 *
 * @since version
 */
function flushed($account_type, $pairs_today, $pairs_today_total, $ctr_left, $ctr_right): bool
{
    $max_cycle = settings('binary')->{$account_type . '_max_cycle'};

    return (/*$pairs_today >= $max_cycle || $pairs_today_total >= $max_cycle ||*/
        ($ctr_left >= $max_cycle && $ctr_right >= $max_cycle));
}