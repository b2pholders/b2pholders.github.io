<?php

namespace BPL\Lib\Local\Database;

use Exception;

class Db_Import
{
	public static bool $success = false;
	public static string $message = '';

	/**
	 * @param $sqlfile
	 * @param $db
	 *
	 *
	 * @return bool
	 * @since version
	 */
	public static function devImportSQL($sqlfile, $db): bool
	{
		$file = file($sqlfile);

		$file = array_filter($file, static function ($line) {
			return strpos(ltrim($line), '--') !== 0;
		});

		$file = array_filter($file, static function ($line) {
			return strpos(ltrim($line), '/*') !== 0;
		});

		$sql = '';

		$del_num = false;

		foreach ($file as $line)
		{
			$query = trim($line);

			try
			{
				$delimiter = is_int(strpos($query, 'DELIMITER'));

				if ($delimiter || $del_num)
				{
					if ($delimiter && !$del_num)
					{
						$sql = $query . '; ';

						echo 'OK';
						echo '<br/>';
						echo '---';
						echo '<br/>';

						$del_num = true;
					}
					else if ($delimiter && $del_num)
					{
						$sql .= $query . ' ';

						$del_num = false;

						echo $sql;
						echo '<br/>';
						echo 'do---do';
						echo '<br/>';

						$db->setQuery($sql);
						$db->execute();

						$sql = '';
					}
					else
					{
						$sql .= $query . '; ';
					}
				}
				else
				{
					$delimiter = is_int(strpos($query, ';'));

					if ($delimiter)
					{
						$db->setQuery($sql . ' ' . $query);
						$db->execute();

						echo $sql . ' ' . $query;
						echo '<br/>';
						echo '---';
						echo '<br/>';

						$sql = '';
					}
					else
					{
						$sql .= ' ' . $query;
					}
				}
			}
			catch (Exception $e)
			{
				self::$success = false;
				self::$message .= $e->getMessage() . "<br /> <p>The sql is: $query</p>";

				return false;
			}
		}

		self::$success = true;
		self::$message .= 'Database Reset Successful!';

		return true;
	}
}