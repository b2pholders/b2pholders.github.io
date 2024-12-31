<?php

namespace Onewayhi\Database\Sand;

interface Db_Info
{
	const HOST = 'localhost';
	/*const USERNAME = 'onewayhi_admin';
	const PASSWORD = 'JmJYZCL4AcbiB64';*/
	const USERNAME = 'root';
	const PASSWORD = 'root';
	const DATABASE = 'onewayhi_db_live';

	public static function connect();
}

use \PDO;
use \PDOException;

class Db_Connect implements Db_Info
{
	private static $host = Db_Info::HOST;
	private static $username = Db_Info::USERNAME;
	private static $password = Db_Info::PASSWORD;
	private static $database = Db_Info::DATABASE;
	private static $hookup;

	public static function connect()
	{
		try
		{
			$dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$database . ';charset=utf8';

			self::$hookup = new PDO($dsn, self::$username, self::$password);
		}
		catch (PDOException $e)
		{
			trigger_error('Could not connect to database');
		}

		return self::$hookup;
	}
}

$dbh = Db_Connect::connect();

$sth = $dbh->prepare('SELECT * FROM network__settings_entry');
$sth->execute();

$settings_entry = $sth->fetch(PDO::FETCH_OBJ);

$sth = $dbh->prepare('SELECT * FROM network__users WHERE id <> :id');
$sth->execute(['id' => 1]);

$users = $sth->fetchAll(PDO::FETCH_OBJ);

echo '<table>';
echo '<thead><th>username</th><th>sponsor_name</th><th>account_type</th></thead>';

foreach ($users as $user)
{
	$sth = $dbh->prepare('SELECT * FROM network__commission_deduct WHERE id = :id');
	$sth->execute(['id' => $user->id]);

	$user_cd = $sth->fetch(PDO::FETCH_OBJ);

	$sth = $dbh->prepare('SELECT username FROM network__users WHERE id = :id');
	$sth->execute(['id' => $user->sponsor_id]);

	$sponsor = $sth->fetch(PDO::FETCH_OBJ);

	echo '<tr><td>' .
		$user->username .
		'</td><td>' .
		$sponsor->username .
		'</td><td>' .
		$settings_entry->{$user->account_type . '_package_name'} . ($user_cd ? ' CD' : '') .
		'</td></tr>';
}
echo '</table>';