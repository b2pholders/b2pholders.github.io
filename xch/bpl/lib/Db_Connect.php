<?php

namespace BPL\Lib\Local\Database;

require_once 'Db_Info.php';

use PDO;
use PDOException;

class Db_Connect implements Db_Info
{
	private static string $host = Db_Info::HOST;
	private static string $username = Db_Info::USERNAME;
	private static string $password = Db_Info::PASSWORD;
	private static string $database = Db_Info::DATABASE;
	private static string $backup_path = '/sql_backup/';
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

	public static function backup(): void
	{
		$cmd = 'mysqldump --routines -h ' . self::$host .
			' -u ' . self::$username . ' -p ' . self::$password . ' ' . self::$database . ' > ' .
			self::$backup_path . date('Ymd') . '_' . self::$database . '.sql';

		exec($cmd);
	}
}