<?php

namespace Cron\P2P_Delete;

require_once 'Cron_Db_Info.php';
require_once 'Cron_Db_Connect.php';
require_once 'cron_query_local.php';

use Exception;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

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
    $expiry = 60 * 60 * 24 * 2; // 2 days

    $dbh = DB_Cron::connect();

    $requests = requests_pending();

    if (!empty($requests)) {
        foreach ($requests as $request) {
            $lapse = time() - $request->date_requested;

            if ($lapse > $expiry) {
                try {
                    $dbh->beginTransaction();

                    delete_request($request->request_id);

                    $dbh->commit();
                } catch (Exception $e) {
                    try {
                        $dbh->rollback();
                    } catch (Exception $e2) {
                    }
                }
            }
        }
    }
}

/**
 *
 * @return array|false
 *
 * @since version
 */
function requests_pending()
{
    return fetch_all(
        'SELECT * ' .
        'FROM network_p2p_token_sale ' .
        'WHERE date_confirmed = :date_confirmed',
        ['date_confirmed' => -2]
    );
}

/**
 * @param $user_id
 *
 *
 * @since version
 */
function delete_request($user_id)
{
    crud(
        'DELETE ' .
        'from network_p2p_token_sale ' .
        'WHERE request_id = :id',
        ['id' => $user_id]
    );
}