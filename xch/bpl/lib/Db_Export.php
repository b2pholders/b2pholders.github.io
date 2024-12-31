<?php

namespace BPL\Lib\Local\Database;

require_once 'Db_Info.php';

use PDO;
use PDOException;

class Db_Export
{
	private static string $host = Db_Info::HOST;
	private static string $username = Db_Info::USERNAME;
	private static string $password = Db_Info::PASSWORD;
	private static string $database = Db_Info::DATABASE;
	private static PDO $db;
	private string $sql;
	private bool $removeAI = true;

	public function __construct()
	{
		try
		{
			$dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$database . ';charset=utf8';

			self::$db = new PDO($dsn, self::$username, self::$password);
		}
		catch (PDOException $e)
		{
			trigger_error('Could not connect to database');
		}
	}

	/**
	 * @param   string  $text
	 *
	 *
	 * @since version
	 */
	private function ln(string $text = ''): void
	{
		$this->sql .= $text . "\n";
	}

	/**
	 * @param $file
	 *
	 *
	 * @since version
	 */
	public function dump($file): void
	{
		$this->ln("SET FOREIGN_KEY_CHECKS=0;\n");

		$tables = self::$db->query('SHOW TABLES')->fetchAll(PDO::FETCH_BOTH);

		foreach ($tables as $table)
		{
			$table = $table[0];

			$this->ln('DROP TABLE IF EXISTS ' . $table . ';');

			$schemas = self::$db->query("SHOW CREATE TABLE '{$table}'")->fetchAll(PDO::FETCH_ASSOC);

			foreach ($schemas as $schema)
			{
				$schema = $schema['Create Table'];

				if ($this->removeAI)
				{
					$schema = preg_replace('/AUTO_INCREMENT=(\d+)(\s?)/', '', $schema);
				}

				$this->ln($schema . ";\n\n");
			}
		}

		file_put_contents($file, $this->sql);
	}
}