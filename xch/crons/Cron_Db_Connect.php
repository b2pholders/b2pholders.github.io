<?php

namespace Cron\Db\Connect;

use Cron\Db\Info\Cron_Db_Info as Db_Info;

use PDO;
use PDOException;

class Cron_Db_Connect implements Db_Info
{
	private static string $host = Db_Info::HOST;
	private static string $username = Db_Info::USERNAME;
	private static string $password = Db_Info::PASSWORD;
	private static string $database = Db_Info::DATABASE;

	private static PDO $hookup;

	public static function connect(): PDO
	{
		static $db = null;

		if ($db === null)
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
		}

		return self::$hookup;
	}
}