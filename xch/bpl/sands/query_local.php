<?php

namespace Onewayhi\Database\Local\Query;

require_once '../lib/db_connect.php';

use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

function insert($table = '', $columns = [], $values = [])
{
	$dbh = DB::connect();

	$sql = 'INSERT ' .
		'INTO ' . $table .
		' (' . columns_insert($columns) .
		') VALUES (' . values_insert($values) . ')';

	if ($table && $values && $columns)
	{
		try
		{
			$sth = $dbh->prepare($sql);
			$sth->execute($values);
			/* *
			$db->query(
				'PREPARE statement FROM ' . quote($sql) .
				';SET ' . set_insert($columns, $values) .
				';EXECUTE statement USING ' . columns_insert_execute($columns) .
				';DEALLOCATE PREPARE statement;'
			);
			/* */
			//$db->query(';SET ' . set_insert($columns, $values));
			//$db->query(';EXECUTE statement USING ' . columns_insert_execute($columns));
			//$db->query('DEALLOCATE PREPARE statement;');
		}
		catch (\Exception $e)
		{
			return $e;
		}

		return true;
	}

	return false;
}

function update($table = '', $fields = [], $condition = '')
{
	$dbh = DB::connect();

	$sql = 'UPDATE ' . $table . ' ' .
		'SET ' . set_fields($fields) . ' ' .
		'WHERE ' . set_condition($condition);

	if ($table && $fields && $condition)
	{
		try
		{
			$sth = $dbh->prepare($sql);
			$sth->execute(values_update($fields, $condition));

			/* *
			$db->query('PREPARE statement FROM ' . quote($sql));
			$db->query('SET ' . set_update($fields, $condition));
			$db->query('EXECUTE statement ' . 'USING ' . columns_update($fields, $condition));
			$db->query('DEALLOCATE PREPARE statement');
			/* */

		}
		catch (\Exception $e)
		{
			return $e;
		}

		return true;
	}

	return false;
}

function delete($table = '', $condition = '')
{
	$dbh = DB::connect();

	$sql = 'DELETE ' .
		'FROM ' . $table . ' ' .
		'WHERE ' . set_condition($condition);

	if ($table && $condition)
	{
		try
		{
			$sth = $dbh->prepare($sql);
			$sth->execute(values_delete($condition));

			/* *
			$db->query('PREPARE statement FROM ' . quote($sql));
			$db->query('SET ' . set_delete($condition));
			$db->query('EXECUTE statement ' . 'USING ' . column_delete($condition));
			$db->query('DEALLOCATE PREPARE statement');
			/* */

		}
		catch (\Exception $e)
		{
			return $e;
		}

		return true;
	}

	return false;
}

function columns_insert($columns = [])
{
	$col_str = '';

	if ($columns)
	{
		foreach ($columns as $column)
		{
			$col_str .= $column . ', ';
		}

		$explode = explode(', ', $col_str);

		array_pop($explode);

		return implode(', ', $explode);
	}

	return '';
}

function values_insert($values = [])
{
	$val_str = '';

	if ($values)
	{
		for ($i_i = 0; $i_i < count($values); $i_i++)
		{
			$val_str .= '?, ';
		}

		$explode = explode(', ', $val_str);

		array_pop($explode);

		return implode(', ', $explode);
	}

	return '';
}

function set_insert($columns = [], $values = [])
{
	$set_str = '';

	if ($columns && $values)
	{
		for ($i_i = 0; $i_i < count($columns); $i_i++)
		{
			$set_str .= $columns[$i_i] . ' = ' . quote($values[$i_i]) . ', ';
		}

		$explode = explode(', ', $set_str);

		array_pop($explode);

		return implode(', ', $explode);
	}

	return '';
}

function columns_insert_execute($columns = [])
{
	$col_str = '';

	if ($columns)
	{
		foreach ($columns as $column)
		{
			$col_str .= '@' . $column . ', ';
		}

		$explode = explode(', ', $col_str);

		array_pop($explode);

		return implode(', ', $explode);
	}

	return '';
}

function set_fields($fields = [])
{
	$set_str = '';

	if ($fields)
	{
		foreach ($fields as $field)
		{
			$explode = explode('=', $field);
			$set_str .= trim($explode[0]) . ' = ?, ';
		}

		$set_field = explode(', ', $set_str);

		array_pop($set_field);

		return implode(', ', $set_field);
	}

	return '';
}

function set_condition($condition = '')
{
	if ($condition)
	{
		$explode = explode('=', $condition);

		return trim($explode[0]) . ' = ?';
	}

	return '';
}

function set_update($fields = [], $condition = '')
{
	$set_str = '';

	if ($fields && $condition)
	{
		foreach ($fields as $field)
		{
			$explode_field = explode('=', $field);
			$set_str       .= '@' . trim($explode_field[0]) . ' = ' . quote(trim($explode_field[1])) . ', ';
		}

		$explode_condition = explode('=', $condition);

		return $set_str . '@' . trim($explode_condition[0]) . ' = ' . quote(trim($explode_condition[1]));
	}

	return '';
}

function values_update($fields = [], $condition = '')
{
	//$set_str = '';
	$set_arr = [];

	if ($fields && $condition)
	{
		foreach ($fields as $field)
		{
			$explode_field = explode('=', $field);
			//$set_str       .= '@' . trim($explode_field[0]) . ' = ' . quote(trim($explode_field[1])) . ', ';
			array_push($set_arr, trim($explode_field[1]));
		}

		$explode_condition = explode('=', $condition);

		array_push($set_arr, trim($explode_condition[1]));

		//return $set_str . '@' . trim($explode_condition[0]) . ' = ' . quote(trim($explode_condition[1]));
	}

	return $set_arr;
}

function values_delete($condition = '')
{
	$set_arr = [];

	if ($condition)
	{
		$explode_condition = explode('=', $condition);
		array_push($set_arr, trim($explode_condition[1]));
	}

	return $set_arr;
}

function set_delete($condition = '')
{
	if ($condition)
	{
		$explode = explode('=', $condition);

		return '@' . trim($explode[0]) . ' = ' . quote(trim($explode[1]));
	}

	return '';
}

function columns_update($fields = [], $condition = '')
{
	$col_str = '';

	if ($fields && $condition)
	{
		foreach ($fields as $field)
		{
			$explode_field = explode('=', $field);
			$col_str       .= '@' . $explode_field[0] . ', ';
		}

		$explode_condition = explode('=', $condition);

		return $col_str . '@' . $explode_condition[0];
	}

	return '';
}

function column_delete($condition = '')
{
	if ($condition)
	{
		$explode_condition = explode('=', $condition);

		return '@' . $explode_condition[0];
	}

	return '';
}

function mysql_entities_fix_string($string)
{
	return htmlentities(mysql_fix_string($string));
}

function mysql_fix_string($string)
{
	$db = db::connect();

	if (get_magic_quotes_gpc())
	{
		$string = stripslashes($string);
	}

	return $db->real_escape_string($string);
}

function quote($text, $escape = true)
{
	if (is_array($text))
	{
		foreach ($text as $k => $v)
		{
			$text[$k] = quote($v, $escape);
		}

		return $text;
	}
	else
	{
		return '\'' . ($escape ? mysql_fix_string($text) : $text) . '\'';
	}
}