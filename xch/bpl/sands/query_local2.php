<?php

namespace Onewayhi\Database\Local\Query;

require_once '../lib/db_connect.php';

use \PDO;
use \Exception;
use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

function fetch($sql)
{
	return DB::connect()->query($sql)->fetch(PDO::FETCH_OBJ);
}

function fetch_all($sql)
{
	return DB::connect()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}

function quote($str)
{
	return DB::connect()->quote($str);
}

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
		}
		catch (Exception $e)
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
		}
		catch (Exception $e)
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
		}
		catch (Exception $e)
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

		$set_str = rtrim($set_str, ', ');
	}

	return $set_str;
}

function set_condition($condition = '')
{
	$set_str = '';

	if ($condition)
	{
		$explode = explode('=', $condition);
		$set_str .= trim($explode[0]) . ' = ?';
	}

	return $set_str;
}

function values_update($fields = [], $condition = '')
{
	$set_arr = [];

	if ($fields && $condition)
	{
		foreach ($fields as $field)
		{
			$explode_field = explode('=', $field);
			array_push($set_arr, trim($explode_field[1]));
		}

		$explode_condition = explode('=', $condition);

		array_push($set_arr, trim($explode_condition[1]));
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