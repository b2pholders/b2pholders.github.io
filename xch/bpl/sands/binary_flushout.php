<?php

function main()
{
	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	try
	{
		$st = $db->prepare(
			'SELECT * ' .
			'FROM `binary`'
		);
		$st->execute();

		$users = $st->fetchAll(PDO::FETCH_OBJ);

		if ($users)
		{
			$now_yr  = date('Y');
			$now_mon = date('m');
			$now_day = date('d');
			$now_hr  = date('G');
			$now_min = date('i');
			$now_sec = date('s');

			foreach ($users as $user)
			{
				$pairs_today       = $user->pairs_today;
				$pairs_today_total = $user->pairs_today_total;

				$max_cycle    = 15; // points
				$pairs_period = 1; // hour

				$binary_data = [];

				$st = $db->prepare(
					'SELECT * ' .
					'FROM `binary_entry` ' .
					'WHERE `user_id` = :user_id'
				);
				$st->execute(['user_id' => $user->id]);

				$binary_entries = $st->fetchAll(PDO::FETCH_OBJ);

				if ($binary_entries)
				{
					foreach ($binary_entries as $binary_entry)
					{
						array_push($binary_data, [
							$binary_entry->date,
							$binary_entry->amount,
							$binary_entry->user_id
						]);
					}
				}

				getPairs($binary_data, $pairs_period, $now_yr, $now_mon, $now_day, $max_cycle, $now_hr, $now_min, $now_sec, $user, $pairs_today, $pairs_today_total, $pairs);
			}
		}
	}
	catch (Exception $e)
	{
		echo 'Database Problem: ' . $e->getMessage();
		exit;
	}

	return true;
}

function reset_pairs_today($user_id, $pairs_today, $pairs_today_total, $max_cycle)
{
	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$update = 0;

	if ($pairs_today >= $max_cycle)
	{
		$pairs_today = 0;
		$update      = 1;
	}

	if ($pairs_today_total >= $max_cycle)
	{
		$pairs_today_total = 0;
		$update            = 1;
	}

	if ($update)
	{
		$st = $db->prepare(
			'UPDATE `binary` ' .
			'SET `pairs_today` = ' . $pairs_today . ', ' .
			'`pairs_today_total` = ' . $pairs_today_total .
			' WHERE `id` = :id'
		);

		$st->execute(['id' => $user_id]);
	}
}

function delete_entries($pairs)
{
	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	if ($pairs)
	{
		foreach ($pairs as $pair)
		{
			$st = $db->prepare(
				'DELETE ' .
				'FROM `binary_entry` ' .
				' WHERE `id` = :id'
			);

			$st->execute(['user_id = ' . $pair[1]]);
		}
	}
}

function pair_sum($pairs)
{
	$sum = 0;

	if (!empty($pairs))
	{
		foreach ($pairs as $pair)
		{
			$sum += $pair[0];
		}
	}

	return $sum;
}

function ranged($range, $time)
{
	if ($range)
	{
		foreach ($range as $element)
		{
			if ($time > $element)
			{
				return true;
				break;
			}
		}
	}

	return false;
}

function hedged($range, $time)
{
	if ($range)
	{
		foreach ($range as $element)
		{
			if ($time <= $element)
			{
				return true;
				break;
			}
		}
	}

	return false;
}