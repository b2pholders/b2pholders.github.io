<?php

namespace BPL\Mods\Database\Query;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Helpers\db;

/**
 * @param   string  $table
 * @param   array   $columns
 * @param   array   $values
 *
 * @return false|mixed
 *
 * @since version
 */
function insert(string $table = '', array $columns = [], array $values = [])
{
	$db = db();

	$query = $db->getQuery(true);

	if ($query)
	{
		$query
			->insert($db->quoteName($table))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));

		$db->setQuery($query);

		return $db->execute();
	}

	return false;
}

/**
 * @param   string  $table
 * @param   array   $fields
 * @param   array   $conditions
 *
 * @return false|mixed
 *
 * @since version
 */
function update(string $table = '', array $fields = [], array $conditions = [])
{
	$db = db();

	$query = $db->getQuery(true);

	if ($query)
	{
		if (!empty($conditions))
		{
			$query
				->update($db->quoteName($table))
				->set($fields)
				->where($conditions);
		}
		else
		{
			$query->update($db->quoteName($table))->set($fields);
		}

		$db->setQuery($query);

		return $db->execute();
	}

	return false;
}

/**
 * @param   string  $table
 * @param   array   $conditions
 *
 * @return false|mixed
 *
 * @since version
 */
function delete(string $table = '', array $conditions = [])
{
	$db = db();

	$query = $db->getQuery(true);

	if ($query)
	{
		if (!empty($conditions))
		{
			$query
				->delete($db->quoteName($table))
				->where($conditions);
		}
		else
		{
			$query->delete($db->quoteName($table));
		}

		$db->setQuery($query);

		return $db->execute();
	}

	return false;
}