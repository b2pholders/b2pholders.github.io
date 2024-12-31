<?php

$user_id   = 10;
$upline_id = 4;
$position  = 'Right';

$ctr_add = 100;

// --------------------------------------------------------------------
$tmp_max_cycle    = 0;
$tmp_pairs_safety = 0;

$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$binary_update = false;

try
{
	$binary_insert = $db->prepare(
		'INSERT ' .
		'INTO `binary` (' .
		'`user_id`, ' .
		'`upline_id`, ' .
		'`position`' .
		') VALUES (' .
		':user_id, ' .
		':upline_id, ' .
		':position' .
		')'
	);

	if ($binary_insert->execute(
			[
				'user_id'   => $user_id,
				'upline_id' => $upline_id,
				'position'  => $position
			]
		))
	{
		if ($position === 'Head')
		{
			echo 'Head Inserted!';
		}
		else
		{
			$st = $db->prepare(
				'UPDATE `binary` ' .
				'SET `downline_' . strtolower($position) . '_id` = :user_id' .
				' WHERE `user_id` = :upline_id'
			);

			$binary_update = $st->execute([
				'user_id'   => $user_id,
				'upline_id' => $upline_id
			]);
		}
	}
}
catch (Exception $e)
{
	echo 'Database Problem: ' . $e->getMessage();
	exit;
}

if ($binary_update)
{
	try
	{
		$st = $db->prepare(
			'SELECT * ' .
			'FROM `binary` ' .
			'WHERE `id` = :upline_id'
		);
		$st->execute(['upline_id' => $upline_id]);

		$upline = $st->fetch(PDO::FETCH_OBJ);
	}
	catch (Exception $e)
	{
		echo 'Database Problem: ' . $e->getMessage();
		exit;
	}

	if ($upline_id)
	{
		$tmp_upline_id         = $upline->id;
		$tmp_pairs             = $upline->pairs;
		$tmp_pairs_today       = $upline->pairs_today;
		$tmp_pairs_today_total = $upline->pairs_today_total;
		$tmp_pairs_5th         = $upline->pairs_5th;
		$tmp_ctr_left          = $upline->ctr_left;
		$tmp_ctr_right         = $upline->ctr_right;

		while ($tmp_upline_id)
		{
			if (
				(($position === 'Left') && ($tmp_ctr_right > $tmp_ctr_left))
				||
				(($position === 'Right') && ($tmp_ctr_left > $tmp_ctr_right))
			)
			{
				// max pairable
				$max_pairs_add = (($position === 'Left') ? ($tmp_ctr_right - $tmp_ctr_left) :
					($tmp_ctr_left - $tmp_ctr_right));

				// max countable pairs
				$open_pairs        = $tmp_max_cycle ? ($tmp_max_cycle - $tmp_pairs_today) : 0;
				$open_pairs        = $open_pairs < 0 ? 0 : $open_pairs;
				$max_pairs_limited = $max_pairs_add < $open_pairs ? $max_pairs_add : $open_pairs;

				// limited pairs add
				$pairs_add_limited = $ctr_add < $max_pairs_limited ? $ctr_add : $max_pairs_limited;

				// actual pairs
				$pairs_add_actual = $ctr_add < $max_pairs_add ? $ctr_add : $max_pairs_add;

				// nth pair
				$old = $tmp_pairs_safety ? ($tmp_pairs - $tmp_pairs % $tmp_pairs_safety) : 0;

				$new = $tmp_pairs_safety ? ($tmp_pairs + $pairs_add_actual -
					($tmp_pairs + $pairs_add_actual) % $tmp_pairs_safety) : 0;

				$nth_pair = $tmp_pairs_safety ? (+(
						$tmp_max_cycle
						&&
						$tmp_pairs_safety
						&&
						($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle
						&&
						$new > $old
					) * ($new - $old) / $tmp_pairs_safety) : 0;

				// flushout
				$flushout  = 0;
				$tmp_maxed = '';

				if ($tmp_max_cycle && ($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle)
				{
					$tmp_add_limited = abs($pairs_add_limited - $nth_pair);
				}
				elseif (!$nth_pair)
				{
					$tmp_add_limited = $pairs_add_limited;
				}
				else
				{
					$tmp_add_limited = 0;
					$flushout        = $pairs_add_limited;
					$tmp_maxed       = '1';
				}

				try
				{
					$binary_update = $db->prepare(
						'UPDATE `binary` ' .
						'SET `income_cycle` = `income_cycle` + ' . $tmp_add_limited . ', ' .
						'`pairs_5th` = `pairs_5th` + ' . $nth_pair . ', ' .
						'`income_giftcheck` = `income_giftcheck` + ' . $nth_pair . ', ' .
						'`pairs` = `pairs` + ' . $pairs_add_actual . ', ' .
						'`income_flushout` = `income_flushout` + ' . $flushout . ', ' .
						'`pairs_today` = `pairs_today` + ' . $tmp_add_limited . ', ' .
						'`pairs_today_total` = `pairs_today_total` + ' . $pairs_add_actual . ', ' .
						($position === 'Left' ? '`ctr_left` = `ctr_left`' :
							'`ctr_right` = `ctr_right`') . ' + ' . $ctr_add .
						' WHERE `id` = :id'
					);

					if ($binary_update->execute(['id' => $tmp_upline_id]))
					{
						$st = $db->prepare(
							'INSERT ' .
							'INTO `binary_entry` (' .
							'`user_id`, ' .
							'`amount`, ' .
							'`date`' .
							') VALUES (' .
							':user_id, ' .
							':amount, ' .
							':date' .
							')'
						);

						$st->execute(
							[
								'user_id' => $tmp_upline_id,
								'amount'  => $tmp_add_limited,
								'date'    => time()
							]
						);
					}
				}
				catch (Exception $e)
				{
					echo 'Database Problem: ' . $e->getMessage();
					exit;
				}
			}
			else
			{
				try
				{
					$st = $db->prepare(
						'UPDATE `binary` ' .
						'SET ' . ($position === 'Left' ? '`ctr_left` = `ctr_left`' :
							'`ctr_right` = `ctr_right`') . ' + ' . $ctr_add .
						' WHERE `id` = :id'
					);

					$st->execute(['id' => $tmp_upline_id]);
				}
				catch (Exception $e)
				{
					echo 'Database Problem: ' . $e->getMessage();
					exit;
				}
			}

			$position      = $upline->position;
			$tmp_upline_id = $upline->upline_id;

			if (!$tmp_upline_id)
			{
				break;
			}

			try
			{
				$st = $db->prepare(
					'SELECT * ' .
					'FROM `binary` ' .
					'WHERE `id` = :upline_id'
				);
				$st->execute(['upline_id' => $tmp_upline_id]);

				$upline = $st->fetch(PDO::FETCH_OBJ);
			}
			catch (Exception $e)
			{
				echo 'Database Problem: ' . $e->getMessage();
				exit;
			}

			$tmp_pairs             = $upline->pairs;
			$tmp_pairs_today       = $upline->pairs_today;
			$tmp_pairs_today_total = $upline->pairs_today_total;
			$tmp_ctr_left          = $upline->ctr_left;
			$tmp_ctr_right         = $upline->ctr_right;
		}
	}

	echo 'success';
}