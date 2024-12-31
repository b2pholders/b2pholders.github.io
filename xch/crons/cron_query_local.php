<?php

namespace Cron\Database\Query;

use PDO;

use Cron\Db\Connect\Cron_Db_Connect as DB_Cron;

/**
 * @param          $sql
 * @param   array  $val
 *
 * @return mixed
 *
 * @since version
 */
function fetch($sql, array $val = [])
{
	$dbh = DB_Cron::connect();
	$sth = $dbh->prepare($sql);

	$sth->execute($val);

	return $sth->fetch(PDO::FETCH_OBJ);
}

/**
 * @param          $sql
 * @param   array  $val
 *
 * @return array|false
 *
 * @since version
 */
function fetch_all($sql, array $val = [])
{
	$dbh = DB_Cron::connect();
	$sth = $dbh->prepare($sql);

	$sth->execute($val);

	return $sth->fetchAll(PDO::FETCH_OBJ);
}

/**
 * @param          $sql
 * @param   array  $val
 *
 * @return bool
 *
 * @since version
 */
function crud($sql, array $val = []): bool
{
	$dbh = DB_Cron::connect();

	return $dbh->prepare($sql)->execute($val);
}