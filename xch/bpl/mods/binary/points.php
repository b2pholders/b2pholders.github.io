<?php

namespace BPL\Mods\Binary\Points;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Database\Query\insert;
use function BPL\Mods\Database\Query\update;

use function BPL\Mods\Helpers\db;

/**
 * @param $points
 * @param $user_id
 *
 *
 * @since version
 */
function main($points, $user_id)
{
	update('network_points',
		[
			'`points` = `points` + ' . $points
		],
		['user_id = ' . db()->quote($user_id)]);

	$user_points = points_user($user_id);

	$points_latest  = $user_points->points;
	$points_spent   = $user_points->points_spent;
	$points_waiting = $user_points->points_waiting;

	$ceiling = 100;

	if ($points_latest >= $ceiling)
	{
		if ($points_spent)
		{
			if ($points_latest > $points_spent)
			{
				$differential = $points_latest - $points_spent;

				if (($differential + $points_waiting) >= $ceiling)
				{
					endowment_points(($differential + $points_waiting - $ceiling), $user_id);
				}
			}
		}
		else
		{
			endowment_points(($points_latest - $ceiling), $user_id);
		}
	}
}

/**
 * @param $points_waiting_new
 * @param $user_id
 *
 *
 * @since version
 */
function endowment_points($points_waiting_new, $user_id)
{
	$db = db();

	if ($points_waiting_new)
	{
		update(
			'network_points',
			[
				'`points_waiting` = ' . $points_waiting_new
			],
			['user_id = ' . $db->quote($user_id)]
		);
	}

	$ceiling  = 100;
	$maturity = 10;

	$points_spent_update = update(
		'network_points',
		['`points_spent` = `points_spent` + ' . $ceiling],
		['user_id = ' . $db->quote($user_id)]
	);

	// add fast track if successful
	if ($points_spent_update)
	{
		insert(
			'network_endowment',
			[
				'user_id',
				'date_entry',
				'maturity'
			],
			[
				$db->quote($user_id),
				$db->quote(time()),
				$db->quote($maturity)
			]
		);
	}
}

/**
 * @param $user_id
 *
 * @return mixed|null
 *
 * @since version
 */
function points_user($user_id)
{
	$db = db();

	return $db->setQuery(
		'SELECT * ' .
		'FROM `network_points` ' .
		'WHERE `user_id` = ' . $db->quote($user_id)
	)->loadObject();
}