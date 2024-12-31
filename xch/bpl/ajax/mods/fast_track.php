<?php

namespace BPL\Ajax\Mods\Fast_Track;

use BPL\Lib\Local\Database\Db_Connect as DB;

use DateTime;
use DateTimeZone;
use Exception;

use function BPL\Mods\Local\Database\Query\fetch_all;
use function BPL\Mods\Local\Database\Query\crud;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;
use function BPL\Mods\Local\Helpers\echo_json;
use function BPL\Mods\Local\Helpers\validate_fast_track;

$input = filter_input(INPUT_POST, 'input', FILTER_VALIDATE_FLOAT);
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($input, $user_id);

/**
 * @param $input
 * @param $user_id
 *
 *
 * @since version
 */
function main($input, $user_id)
{
    header('Content-Type: application/json');

    $dbh = DB::connect();

    $return = $_POST;

    $settings_plans = settings('plans');

    validate_fast_track($input, $user_id, $return);

    try {
        $dbh->beginTransaction();

        insert_fast_track($user_id, $input);
        update_user($user_id, $input);

        $dbh->commit();
    } catch (Exception $e) {
        try {
            $dbh->rollback();
        } catch (Exception $e2) {
        }
    }

    $user_latest = user($user_id);

    $return['principal'] = $user_latest->fast_track_principal;
    $return['balance'] = $user_latest->payout_transfer/*$user_latest->points*/;

    $fast_tracks = user_fast_track($user_id);

    $value_last = 0;

    foreach ($fast_tracks as $fast_track) {
        $value_last += $fast_track->value_last;
    }

    $return['interest'] = $value_last + $user_latest->fast_track_interest;
    $return['input'] = $input;

    $return['success_fast_track'] = $settings_plans->fast_track_name . ' successful!';

    try {
        $return['fast_track_json'] = json_encode($return, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    } catch (Exception $e) {

    }

    echo_json($return);
}

/**
 * @param $user_id
 * @param $input
 *
 *
 * @since version
 */
function insert_fast_track($user_id, $input)
{
    $settings_investment = settings('investment');

    $account_type = user($user_id)->account_type;

//    $fast_track_maturity = $settings_investment->{$account_type . '_fast_track_maturity'};
    $fast_track_processing = $settings_investment->{$account_type . '_fast_track_processing'};

    $time = new DateTime('now');
    $time->setTimezone(new DateTimeZone('Asia/Manila'));
    $now = $time->format('U'); // seconds since unix epoch

    crud(
        'INSERT ' .
        'INTO network_fast_track (' .
        'user_id, ' .
        'time_last, ' .
        'value_last, ' .
        'day, ' .
        'principal, ' .
        'date_entry, ' .
        'processing, ' .
//        'maturity, ' .
        'date_last_cron' .
        ') VALUES (' .
        ':user_id, ' .
        ':time_last, ' .
        ':value_last, ' .
        ':day, ' .
        ':principal, ' .
        ':date_entry, ' .
        ':processing, ' .
//        ':maturity, ' .
        ':date_last_cron' .
        ')',
        [
            'user_id' => $user_id,
            'time_last' => 0,
            'value_last' => 0,
            'day' => 0,
            'principal' => $input,
            'date_entry' => $now,
            'processing' => $fast_track_processing,
//            'maturity' => $fast_track_maturity,
            'date_last_cron' => $now
        ]
    );
}

/**
 * @param $user_id
 * @param $input
 *
 *
 * @since version
 */
function update_user($user_id, $input)
{
    $user = user($user_id);

    $balance = $user->payout_transfer/*$user->points*/;
    $fast_track_principal = $user->fast_track_principal;

    crud(
        'UPDATE network_users ' .
        'SET fast_track_principal = :principal, ' .
        'payout_transfer = :payout_transfer '/*'points = :points '*/ .
        'WHERE id = :id',
        [
            'principal' => ($fast_track_principal + $input),
            'payout_transfer' => ($balance - $input)/*'points' => ($balance - $input)*/,
            'id' => $user_id
        ]
    );
}

/**
 * @param $user_id
 *
 * @return array|false
 *
 * @since version
 */
function user_fast_track($user_id)
{
    return fetch_all(
        'SELECT * ' .
        'FROM network_fast_track ' .
        'WHERE user_id = :user_id ' .
        'ORDER BY id DESC',
        ['user_id' => $user_id]
    );
}