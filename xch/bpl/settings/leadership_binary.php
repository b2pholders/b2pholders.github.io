<?php

namespace BPL\Settings\Leadership_Binary;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\update as query_update;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\settings;

/**
 *
 * @return array
 *
 * @since version
 */
function get_input(): array
{
	return [
		'chairman_leadership_share_1'  => input_get('chairman_leadership_share_1'),
		'executive_leadership_share_1' => input_get('executive_leadership_share_1'),
		'regular_leadership_share_1'   => input_get('regular_leadership_share_1'),
		'associate_leadership_share_1' => input_get('associate_leadership_share_1'),
		'basic_leadership_share_1'     => input_get('basic_leadership_share_1'),

		'chairman_leadership_share_2'  => input_get('chairman_leadership_share_2'),
		'executive_leadership_share_2' => input_get('executive_leadership_share_2'),
		'regular_leadership_share_2'   => input_get('regular_leadership_share_2'),
		'associate_leadership_share_2' => input_get('associate_leadership_share_2'),
		'basic_leadership_share_2'     => input_get('basic_leadership_share_2'),

		'chairman_leadership_share_3'  => input_get('chairman_leadership_share_3'),
		'executive_leadership_share_3' => input_get('executive_leadership_share_3'),
		'regular_leadership_share_3'   => input_get('regular_leadership_share_3'),
		'associate_leadership_share_3' => input_get('associate_leadership_share_3'),
		'basic_leadership_share_3'     => input_get('basic_leadership_share_3'),

		'chairman_leadership_share_4'  => input_get('chairman_leadership_share_4'),
		'executive_leadership_share_4' => input_get('executive_leadership_share_4'),
		'regular_leadership_share_4'   => input_get('regular_leadership_share_4'),
		'associate_leadership_share_4' => input_get('associate_leadership_share_4'),
		'basic_leadership_share_4'     => input_get('basic_leadership_share_4'),

		'chairman_leadership_share_5'  => input_get('chairman_leadership_share_5'),
		'executive_leadership_share_5' => input_get('executive_leadership_share_5'),
		'regular_leadership_share_5'   => input_get('regular_leadership_share_5'),
		'associate_leadership_share_5' => input_get('associate_leadership_share_5'),
		'basic_leadership_share_5'     => input_get('basic_leadership_share_5'),

		'chairman_leadership_share_6'  => input_get('chairman_leadership_share_6'),
		'executive_leadership_share_6' => input_get('executive_leadership_share_6'),
		'regular_leadership_share_6'   => input_get('regular_leadership_share_6'),
		'associate_leadership_share_6' => input_get('associate_leadership_share_6'),
		'basic_leadership_share_6'     => input_get('basic_leadership_share_6'),

		'chairman_leadership_share_7'  => input_get('chairman_leadership_share_7'),
		'executive_leadership_share_7' => input_get('executive_leadership_share_7'),
		'regular_leadership_share_7'   => input_get('regular_leadership_share_7'),
		'associate_leadership_share_7' => input_get('associate_leadership_share_7'),
		'basic_leadership_share_7'     => input_get('basic_leadership_share_7'),

		'chairman_leadership_share_8'  => input_get('chairman_leadership_share_8'),
		'executive_leadership_share_8' => input_get('executive_leadership_share_8'),
		'regular_leadership_share_8'   => input_get('regular_leadership_share_8'),
		'associate_leadership_share_8' => input_get('associate_leadership_share_8'),
		'basic_leadership_share_8'     => input_get('basic_leadership_share_8'),

		'chairman_leadership_share_9'  => input_get('chairman_leadership_share_9'),
		'executive_leadership_share_9' => input_get('executive_leadership_share_9'),
		'regular_leadership_share_9'   => input_get('regular_leadership_share_9'),
		'associate_leadership_share_9' => input_get('associate_leadership_share_9'),
		'basic_leadership_share_9'     => input_get('basic_leadership_share_9'),

		'chairman_leadership_share_10'  => input_get('chairman_leadership_share_10'),
		'executive_leadership_share_10' => input_get('executive_leadership_share_10'),
		'regular_leadership_share_10'   => input_get('regular_leadership_share_10'),
		'associate_leadership_share_10' => input_get('associate_leadership_share_10'),
		'basic_leadership_share_10'     => input_get('basic_leadership_share_10'),

		'chairman_leadership_share_11'  => input_get('chairman_leadership_share_11'),
		'executive_leadership_share_11' => input_get('executive_leadership_share_11'),
		'regular_leadership_share_11'   => input_get('regular_leadership_share_11'),
		'associate_leadership_share_11' => input_get('associate_leadership_share_11'),
		'basic_leadership_share_11'     => input_get('basic_leadership_share_11'),

		'chairman_leadership_share_12'  => input_get('chairman_leadership_share_12'),
		'executive_leadership_share_12' => input_get('executive_leadership_share_12'),
		'regular_leadership_share_12'   => input_get('regular_leadership_share_12'),
		'associate_leadership_share_12' => input_get('associate_leadership_share_12'),
		'basic_leadership_share_12'     => input_get('basic_leadership_share_12'),

		'chairman_leadership_share_13'  => input_get('chairman_leadership_share_13'),
		'executive_leadership_share_13' => input_get('executive_leadership_share_13'),
		'regular_leadership_share_13'   => input_get('regular_leadership_share_13'),
		'associate_leadership_share_13' => input_get('associate_leadership_share_13'),
		'basic_leadership_share_13'     => input_get('basic_leadership_share_13'),

		'chairman_leadership_share_14'  => input_get('chairman_leadership_share_14'),
		'executive_leadership_share_14' => input_get('executive_leadership_share_14'),
		'regular_leadership_share_14'   => input_get('regular_leadership_share_14'),
		'associate_leadership_share_14' => input_get('associate_leadership_share_14'),
		'basic_leadership_share_14'     => input_get('basic_leadership_share_14'),

		'chairman_leadership_share_15'  => input_get('chairman_leadership_share_15'),
		'executive_leadership_share_15' => input_get('executive_leadership_share_15'),
		'regular_leadership_share_15'   => input_get('regular_leadership_share_15'),
		'associate_leadership_share_15' => input_get('associate_leadership_share_15'),
		'basic_leadership_share_15'     => input_get('basic_leadership_share_15'),

		'chairman_leadership_share_16'  => input_get('chairman_leadership_share_16'),
		'executive_leadership_share_16' => input_get('executive_leadership_share_16'),
		'regular_leadership_share_16'   => input_get('regular_leadership_share_16'),
		'associate_leadership_share_16' => input_get('associate_leadership_share_16'),
		'basic_leadership_share_16'     => input_get('basic_leadership_share_16'),

		'chairman_leadership_share_17'  => input_get('chairman_leadership_share_17'),
		'executive_leadership_share_17' => input_get('executive_leadership_share_17'),
		'regular_leadership_share_17'   => input_get('regular_leadership_share_17'),
		'associate_leadership_share_17' => input_get('associate_leadership_share_17'),
		'basic_leadership_share_17'     => input_get('basic_leadership_share_17'),

		'chairman_leadership_share_18'  => input_get('chairman_leadership_share_18'),
		'executive_leadership_share_18' => input_get('executive_leadership_share_18'),
		'regular_leadership_share_18'   => input_get('regular_leadership_share_18'),
		'associate_leadership_share_18' => input_get('associate_leadership_share_18'),
		'basic_leadership_share_18'     => input_get('basic_leadership_share_18'),

		'chairman_leadership_share_19'  => input_get('chairman_leadership_share_19'),
		'executive_leadership_share_19' => input_get('executive_leadership_share_19'),
		'regular_leadership_share_19'   => input_get('regular_leadership_share_19'),
		'associate_leadership_share_19' => input_get('associate_leadership_share_19'),
		'basic_leadership_share_19'     => input_get('basic_leadership_share_19'),

		'chairman_leadership_share_20'  => input_get('chairman_leadership_share_20'),
		'executive_leadership_share_20' => input_get('executive_leadership_share_20'),
		'regular_leadership_share_20'   => input_get('regular_leadership_share_20'),
		'associate_leadership_share_20' => input_get('associate_leadership_share_20'),
		'basic_leadership_share_20'     => input_get('basic_leadership_share_20'),

		/*-------------------------------------------------------------------------------------------------*/

		'chairman_leadership_share_cut_1'  => input_get('chairman_leadership_share_cut_1'),
		'executive_leadership_share_cut_1' => input_get('executive_leadership_share_cut_1'),
		'regular_leadership_share_cut_1'   => input_get('regular_leadership_share_cut_1'),
		'associate_leadership_share_cut_1' => input_get('associate_leadership_share_cut_1'),
		'basic_leadership_share_cut_1'     => input_get('basic_leadership_share_cut_1'),

		'chairman_leadership_share_cut_2'  => input_get('chairman_leadership_share_cut_2'),
		'executive_leadership_share_cut_2' => input_get('executive_leadership_share_cut_2'),
		'regular_leadership_share_cut_2'   => input_get('regular_leadership_share_cut_2'),
		'associate_leadership_share_cut_2' => input_get('associate_leadership_share_cut_2'),
		'basic_leadership_share_cut_2'     => input_get('basic_leadership_share_cut_2'),

		'chairman_leadership_share_cut_3'  => input_get('chairman_leadership_share_cut_3'),
		'executive_leadership_share_cut_3' => input_get('executive_leadership_share_cut_3'),
		'regular_leadership_share_cut_3'   => input_get('regular_leadership_share_cut_3'),
		'associate_leadership_share_cut_3' => input_get('associate_leadership_share_cut_3'),
		'basic_leadership_share_cut_3'     => input_get('basic_leadership_share_cut_3'),

		'chairman_leadership_share_cut_4'  => input_get('chairman_leadership_share_cut_4'),
		'executive_leadership_share_cut_4' => input_get('executive_leadership_share_cut_4'),
		'regular_leadership_share_cut_4'   => input_get('regular_leadership_share_cut_4'),
		'associate_leadership_share_cut_4' => input_get('associate_leadership_share_cut_4'),
		'basic_leadership_share_cut_4'     => input_get('basic_leadership_share_cut_4'),

		'chairman_leadership_share_cut_5'  => input_get('chairman_leadership_share_cut_5'),
		'executive_leadership_share_cut_5' => input_get('executive_leadership_share_cut_5'),
		'regular_leadership_share_cut_5'   => input_get('regular_leadership_share_cut_5'),
		'associate_leadership_share_cut_5' => input_get('associate_leadership_share_cut_5'),
		'basic_leadership_share_cut_5'     => input_get('basic_leadership_share_cut_5'),

		'chairman_leadership_share_cut_6'  => input_get('chairman_leadership_share_cut_6'),
		'executive_leadership_share_cut_6' => input_get('executive_leadership_share_cut_6'),
		'regular_leadership_share_cut_6'   => input_get('regular_leadership_share_cut_6'),
		'associate_leadership_share_cut_6' => input_get('associate_leadership_share_cut_6'),
		'basic_leadership_share_cut_6'     => input_get('basic_leadership_share_cut_6'),

		'chairman_leadership_share_cut_7'  => input_get('chairman_leadership_share_cut_7'),
		'executive_leadership_share_cut_7' => input_get('executive_leadership_share_cut_7'),
		'regular_leadership_share_cut_7'   => input_get('regular_leadership_share_cut_7'),
		'associate_leadership_share_cut_7' => input_get('associate_leadership_share_cut_7'),
		'basic_leadership_share_cut_7'     => input_get('basic_leadership_share_cut_7'),

		'chairman_leadership_share_cut_8'  => input_get('chairman_leadership_share_cut_8'),
		'executive_leadership_share_cut_8' => input_get('executive_leadership_share_cut_8'),
		'regular_leadership_share_cut_8'   => input_get('regular_leadership_share_cut_8'),
		'associate_leadership_share_cut_8' => input_get('associate_leadership_share_cut_8'),
		'basic_leadership_share_cut_8'     => input_get('basic_leadership_share_cut_8'),

		'chairman_leadership_share_cut_9'  => input_get('chairman_leadership_share_cut_9'),
		'executive_leadership_share_cut_9' => input_get('executive_leadership_share_cut_9'),
		'regular_leadership_share_cut_9'   => input_get('regular_leadership_share_cut_9'),
		'associate_leadership_share_cut_9' => input_get('associate_leadership_share_cut_9'),
		'basic_leadership_share_cut_9'     => input_get('basic_leadership_share_cut_9'),

		'chairman_leadership_share_cut_10'  => input_get('chairman_leadership_share_cut_10'),
		'executive_leadership_share_cut_10' => input_get('executive_leadership_share_cut_10'),
		'regular_leadership_share_cut_10'   => input_get('regular_leadership_share_cut_10'),
		'associate_leadership_share_cut_10' => input_get('associate_leadership_share_cut_10'),
		'basic_leadership_share_cut_10'     => input_get('basic_leadership_share_cut_10'),

		'chairman_leadership_share_cut_11'  => input_get('chairman_leadership_share_cut_11'),
		'executive_leadership_share_cut_11' => input_get('executive_leadership_share_cut_11'),
		'regular_leadership_share_cut_11'   => input_get('regular_leadership_share_cut_11'),
		'associate_leadership_share_cut_11' => input_get('associate_leadership_share_cut_11'),
		'basic_leadership_share_cut_11'     => input_get('basic_leadership_share_cut_11'),

		'chairman_leadership_share_cut_12'  => input_get('chairman_leadership_share_cut_12'),
		'executive_leadership_share_cut_12' => input_get('executive_leadership_share_cut_12'),
		'regular_leadership_share_cut_12'   => input_get('regular_leadership_share_cut_12'),
		'associate_leadership_share_cut_12' => input_get('associate_leadership_share_cut_12'),
		'basic_leadership_share_cut_12'     => input_get('basic_leadership_share_cut_12'),

		'chairman_leadership_share_cut_13'  => input_get('chairman_leadership_share_cut_13'),
		'executive_leadership_share_cut_13' => input_get('executive_leadership_share_cut_13'),
		'regular_leadership_share_cut_13'   => input_get('regular_leadership_share_cut_13'),
		'associate_leadership_share_cut_13' => input_get('associate_leadership_share_cut_13'),
		'basic_leadership_share_cut_13'     => input_get('basic_leadership_share_cut_13'),

		'chairman_leadership_share_cut_14'  => input_get('chairman_leadership_share_cut_14'),
		'executive_leadership_share_cut_14' => input_get('executive_leadership_share_cut_14'),
		'regular_leadership_share_cut_14'   => input_get('regular_leadership_share_cut_14'),
		'associate_leadership_share_cut_14' => input_get('associate_leadership_share_cut_14'),
		'basic_leadership_share_cut_14'     => input_get('basic_leadership_share_cut_14'),

		'chairman_leadership_share_cut_15'  => input_get('chairman_leadership_share_cut_15'),
		'executive_leadership_share_cut_15' => input_get('executive_leadership_share_cut_15'),
		'regular_leadership_share_cut_15'   => input_get('regular_leadership_share_cut_15'),
		'associate_leadership_share_cut_15' => input_get('associate_leadership_share_cut_15'),
		'basic_leadership_share_cut_15'     => input_get('basic_leadership_share_cut_15'),

		'chairman_leadership_share_cut_16'  => input_get('chairman_leadership_share_cut_16'),
		'executive_leadership_share_cut_16' => input_get('executive_leadership_share_cut_16'),
		'regular_leadership_share_cut_16'   => input_get('regular_leadership_share_cut_16'),
		'associate_leadership_share_cut_16' => input_get('associate_leadership_share_cut_16'),
		'basic_leadership_share_cut_16'     => input_get('basic_leadership_share_cut_16'),

		'chairman_leadership_share_cut_17'  => input_get('chairman_leadership_share_cut_17'),
		'executive_leadership_share_cut_17' => input_get('executive_leadership_share_cut_17'),
		'regular_leadership_share_cut_17'   => input_get('regular_leadership_share_cut_17'),
		'associate_leadership_share_cut_17' => input_get('associate_leadership_share_cut_17'),
		'basic_leadership_share_cut_17'     => input_get('basic_leadership_share_cut_17'),

		'chairman_leadership_share_cut_18'  => input_get('chairman_leadership_share_cut_18'),
		'executive_leadership_share_cut_18' => input_get('executive_leadership_share_cut_18'),
		'regular_leadership_share_cut_18'   => input_get('regular_leadership_share_cut_18'),
		'associate_leadership_share_cut_18' => input_get('associate_leadership_share_cut_18'),
		'basic_leadership_share_cut_18'     => input_get('basic_leadership_share_cut_18'),

		'chairman_leadership_share_cut_19'  => input_get('chairman_leadership_share_cut_19'),
		'executive_leadership_share_cut_19' => input_get('executive_leadership_share_cut_19'),
		'regular_leadership_share_cut_19'   => input_get('regular_leadership_share_cut_19'),
		'associate_leadership_share_cut_19' => input_get('associate_leadership_share_cut_19'),
		'basic_leadership_share_cut_19'     => input_get('basic_leadership_share_cut_19'),

		'chairman_leadership_share_cut_20'  => input_get('chairman_leadership_share_cut_20'),
		'executive_leadership_share_cut_20' => input_get('executive_leadership_share_cut_20'),
		'regular_leadership_share_cut_20'   => input_get('regular_leadership_share_cut_20'),
		'associate_leadership_share_cut_20' => input_get('associate_leadership_share_cut_20'),
		'basic_leadership_share_cut_20'     => input_get('basic_leadership_share_cut_20'),

		'chairman_leadership_level'  => input_get('chairman_leadership_level'),
		'executive_leadership_level' => input_get('executive_leadership_level'),
		'regular_leadership_level'   => input_get('regular_leadership_level'),
		'associate_leadership_level' => input_get('associate_leadership_level'),
		'basic_leadership_level'     => input_get('basic_leadership_level'),

		'chairman_leadership_sponsored'  => input_get('chairman_leadership_sponsored'),
		'executive_leadership_sponsored' => input_get('executive_leadership_sponsored'),
		'regular_leadership_sponsored'   => input_get('regular_leadership_sponsored'),
		'associate_leadership_sponsored' => input_get('associate_leadership_sponsored'),
		'basic_leadership_sponsored'     => input_get('basic_leadership_sponsored'),

		'chairman_leadership_max'  => input_get('chairman_leadership_max'),
		'executive_leadership_max' => input_get('executive_leadership_max'),
		'regular_leadership_max'   => input_get('regular_leadership_max'),
		'associate_leadership_max' => input_get('associate_leadership_max'),
		'basic_leadership_max'     => input_get('basic_leadership_max'),

		'chairman_leadership_max_daily_income'  => input_get('chairman_leadership_max_daily_income'),
		'executive_leadership_max_daily_income' => input_get('executive_leadership_max_daily_income'),
		'regular_leadership_max_daily_income'   => input_get('regular_leadership_max_daily_income'),
		'associate_leadership_max_daily_income' => input_get('associate_leadership_max_daily_income'),
		'basic_leadership_max_daily_income'     => input_get('basic_leadership_max_daily_income')
	];
}

function update()
{
	$db = db();

	$settings_plans = settings('plans');

	$input = get_input();

	$test = [
		$input['chairman_leadership_level'],
		$input['executive_leadership_level'],
		$input['regular_leadership_level'],
		$input['associate_leadership_level'],
		$input['basic_leadership_level']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_leadership',
				[
					'chairman_leadership_share_1 = ' . $db->quote($input['chairman_leadership_share_1']),
					'executive_leadership_share_1 = ' . $db->quote($input['executive_leadership_share_1']),
					'regular_leadership_share_1 = ' . $db->quote($input['regular_leadership_share_1']),
					'associate_leadership_share_1 = ' . $db->quote($input['associate_leadership_share_1']),
					'basic_leadership_share_1 = ' . $db->quote($input['basic_leadership_share_1']),

					'chairman_leadership_share_2 = ' . $db->quote($input['chairman_leadership_share_2']),
					'executive_leadership_share_2 = ' . $db->quote($input['executive_leadership_share_2']),
					'regular_leadership_share_2 = ' . $db->quote($input['regular_leadership_share_2']),
					'associate_leadership_share_2 = ' . $db->quote($input['associate_leadership_share_2']),
					'basic_leadership_share_2 = ' . $db->quote($input['basic_leadership_share_2']),

					'chairman_leadership_share_3 = ' . $db->quote($input['chairman_leadership_share_3']),
					'executive_leadership_share_3 = ' . $db->quote($input['executive_leadership_share_3']),
					'regular_leadership_share_3 = ' . $db->quote($input['regular_leadership_share_3']),
					'associate_leadership_share_3 = ' . $db->quote($input['associate_leadership_share_3']),
					'basic_leadership_share_3 = ' . $db->quote($input['basic_leadership_share_3']),

					'chairman_leadership_share_4 = ' . $db->quote($input['chairman_leadership_share_4']),
					'executive_leadership_share_4 = ' . $db->quote($input['executive_leadership_share_4']),
					'regular_leadership_share_4 = ' . $db->quote($input['regular_leadership_share_4']),
					'associate_leadership_share_4 = ' . $db->quote($input['associate_leadership_share_4']),
					'basic_leadership_share_4 = ' . $db->quote($input['basic_leadership_share_4']),

					'chairman_leadership_share_5 = ' . $db->quote($input['chairman_leadership_share_5']),
					'executive_leadership_share_5 = ' . $db->quote($input['executive_leadership_share_5']),
					'regular_leadership_share_5 = ' . $db->quote($input['regular_leadership_share_5']),
					'associate_leadership_share_5 = ' . $db->quote($input['associate_leadership_share_5']),
					'basic_leadership_share_5 = ' . $db->quote($input['basic_leadership_share_5']),

					'chairman_leadership_share_6 = ' . $db->quote($input['chairman_leadership_share_6']),
					'executive_leadership_share_6 = ' . $db->quote($input['executive_leadership_share_6']),
					'regular_leadership_share_6 = ' . $db->quote($input['regular_leadership_share_6']),
					'associate_leadership_share_6 = ' . $db->quote($input['associate_leadership_share_6']),
					'basic_leadership_share_6 = ' . $db->quote($input['basic_leadership_share_6']),

					'chairman_leadership_share_7 = ' . $db->quote($input['chairman_leadership_share_7']),
					'executive_leadership_share_7 = ' . $db->quote($input['executive_leadership_share_7']),
					'regular_leadership_share_7 = ' . $db->quote($input['regular_leadership_share_7']),
					'associate_leadership_share_7 = ' . $db->quote($input['associate_leadership_share_7']),
					'basic_leadership_share_7 = ' . $db->quote($input['basic_leadership_share_7']),

					'chairman_leadership_share_8 = ' . $db->quote($input['chairman_leadership_share_8']),
					'executive_leadership_share_8 = ' . $db->quote($input['executive_leadership_share_8']),
					'regular_leadership_share_8 = ' . $db->quote($input['regular_leadership_share_8']),
					'associate_leadership_share_8 = ' . $db->quote($input['associate_leadership_share_8']),
					'basic_leadership_share_8 = ' . $db->quote($input['basic_leadership_share_8']),

					'chairman_leadership_share_9 = ' . $db->quote($input['chairman_leadership_share_9']),
					'executive_leadership_share_9 = ' . $db->quote($input['executive_leadership_share_9']),
					'regular_leadership_share_9 = ' . $db->quote($input['regular_leadership_share_9']),
					'associate_leadership_share_9 = ' . $db->quote($input['associate_leadership_share_9']),
					'basic_leadership_share_9 = ' . $db->quote($input['basic_leadership_share_9']),

					'chairman_leadership_share_10 = ' . $db->quote($input['chairman_leadership_share_10']),
					'executive_leadership_share_10 = ' . $db->quote($input['executive_leadership_share_10']),
					'regular_leadership_share_10 = ' . $db->quote($input['regular_leadership_share_10']),
					'associate_leadership_share_10 = ' . $db->quote($input['associate_leadership_share_10']),
					'basic_leadership_share_10 = ' . $db->quote($input['basic_leadership_share_10']),

					'chairman_leadership_share_11 = ' . $db->quote($input['chairman_leadership_share_11']),
					'executive_leadership_share_11 = ' . $db->quote($input['executive_leadership_share_11']),
					'regular_leadership_share_11 = ' . $db->quote($input['regular_leadership_share_11']),
					'associate_leadership_share_11 = ' . $db->quote($input['associate_leadership_share_11']),
					'basic_leadership_share_11 = ' . $db->quote($input['basic_leadership_share_11']),

					'chairman_leadership_share_12 = ' . $db->quote($input['chairman_leadership_share_12']),
					'executive_leadership_share_12 = ' . $db->quote($input['executive_leadership_share_12']),
					'regular_leadership_share_12 = ' . $db->quote($input['regular_leadership_share_12']),
					'associate_leadership_share_12 = ' . $db->quote($input['associate_leadership_share_12']),
					'basic_leadership_share_12 = ' . $db->quote($input['basic_leadership_share_12']),

					'chairman_leadership_share_13 = ' . $db->quote($input['chairman_leadership_share_13']),
					'executive_leadership_share_13 = ' . $db->quote($input['executive_leadership_share_13']),
					'regular_leadership_share_13 = ' . $db->quote($input['regular_leadership_share_13']),
					'associate_leadership_share_13 = ' . $db->quote($input['associate_leadership_share_13']),
					'basic_leadership_share_13 = ' . $db->quote($input['basic_leadership_share_13']),

					'chairman_leadership_share_14 = ' . $db->quote($input['chairman_leadership_share_14']),
					'executive_leadership_share_14 = ' . $db->quote($input['executive_leadership_share_14']),
					'regular_leadership_share_14 = ' . $db->quote($input['regular_leadership_share_14']),
					'associate_leadership_share_14 = ' . $db->quote($input['associate_leadership_share_14']),
					'basic_leadership_share_14 = ' . $db->quote($input['basic_leadership_share_14']),

					'chairman_leadership_share_15 = ' . $db->quote($input['chairman_leadership_share_15']),
					'executive_leadership_share_15 = ' . $db->quote($input['executive_leadership_share_15']),
					'regular_leadership_share_15 = ' . $db->quote($input['regular_leadership_share_15']),
					'associate_leadership_share_15 = ' . $db->quote($input['associate_leadership_share_15']),
					'basic_leadership_share_15 = ' . $db->quote($input['basic_leadership_share_15']),

					'chairman_leadership_share_16 = ' . $db->quote($input['chairman_leadership_share_16']),
					'executive_leadership_share_16 = ' . $db->quote($input['executive_leadership_share_16']),
					'regular_leadership_share_16 = ' . $db->quote($input['regular_leadership_share_16']),
					'associate_leadership_share_16 = ' . $db->quote($input['associate_leadership_share_16']),
					'basic_leadership_share_16 = ' . $db->quote($input['basic_leadership_share_16']),

					'chairman_leadership_share_17 = ' . $db->quote($input['chairman_leadership_share_17']),
					'executive_leadership_share_17 = ' . $db->quote($input['executive_leadership_share_17']),
					'regular_leadership_share_17 = ' . $db->quote($input['regular_leadership_share_17']),
					'associate_leadership_share_17 = ' . $db->quote($input['associate_leadership_share_17']),
					'basic_leadership_share_17 = ' . $db->quote($input['basic_leadership_share_17']),

					'chairman_leadership_share_18 = ' . $db->quote($input['chairman_leadership_share_18']),
					'executive_leadership_share_18 = ' . $db->quote($input['executive_leadership_share_18']),
					'regular_leadership_share_18 = ' . $db->quote($input['regular_leadership_share_18']),
					'associate_leadership_share_18 = ' . $db->quote($input['associate_leadership_share_18']),
					'basic_leadership_share_18 = ' . $db->quote($input['basic_leadership_share_18']),

					'chairman_leadership_share_19 = ' . $db->quote($input['chairman_leadership_share_19']),
					'executive_leadership_share_19 = ' . $db->quote($input['executive_leadership_share_19']),
					'regular_leadership_share_19 = ' . $db->quote($input['regular_leadership_share_19']),
					'associate_leadership_share_19 = ' . $db->quote($input['associate_leadership_share_19']),
					'basic_leadership_share_19 = ' . $db->quote($input['basic_leadership_share_19']),

					'chairman_leadership_share_20 = ' . $db->quote($input['chairman_leadership_share_20']),
					'executive_leadership_share_20 = ' . $db->quote($input['executive_leadership_share_20']),
					'regular_leadership_share_20 = ' . $db->quote($input['regular_leadership_share_20']),
					'associate_leadership_share_20 = ' . $db->quote($input['associate_leadership_share_20']),
					'basic_leadership_share_20 = ' . $db->quote($input['basic_leadership_share_20']),

					'chairman_leadership_share_cut_1 = ' . $db->quote($input['chairman_leadership_share_cut_1']),
					'executive_leadership_share_cut_1 = ' . $db->quote($input['executive_leadership_share_cut_1']),
					'regular_leadership_share_cut_1 = ' . $db->quote($input['regular_leadership_share_cut_1']),
					'associate_leadership_share_cut_1 = ' . $db->quote($input['associate_leadership_share_cut_1']),
					'basic_leadership_share_cut_1 = ' . $db->quote($input['basic_leadership_share_cut_1']),

					'chairman_leadership_share_cut_2 = ' . $db->quote($input['chairman_leadership_share_cut_2']),
					'executive_leadership_share_cut_2 = ' . $db->quote($input['executive_leadership_share_cut_2']),
					'regular_leadership_share_cut_2 = ' . $db->quote($input['regular_leadership_share_cut_2']),
					'associate_leadership_share_cut_2 = ' . $db->quote($input['associate_leadership_share_cut_2']),
					'basic_leadership_share_cut_2 = ' . $db->quote($input['basic_leadership_share_cut_2']),

					'chairman_leadership_share_cut_3 = ' . $db->quote($input['chairman_leadership_share_cut_3']),
					'executive_leadership_share_cut_3 = ' . $db->quote($input['executive_leadership_share_cut_3']),
					'regular_leadership_share_cut_3 = ' . $db->quote($input['regular_leadership_share_cut_3']),
					'associate_leadership_share_cut_3 = ' . $db->quote($input['associate_leadership_share_cut_3']),
					'basic_leadership_share_cut_3 = ' . $db->quote($input['basic_leadership_share_cut_3']),

					'chairman_leadership_share_cut_4 = ' . $db->quote($input['chairman_leadership_share_cut_4']),
					'executive_leadership_share_cut_4 = ' . $db->quote($input['executive_leadership_share_cut_4']),
					'regular_leadership_share_cut_4 = ' . $db->quote($input['regular_leadership_share_cut_4']),
					'associate_leadership_share_cut_4 = ' . $db->quote($input['associate_leadership_share_cut_4']),
					'basic_leadership_share_cut_4 = ' . $db->quote($input['basic_leadership_share_cut_4']),

					'chairman_leadership_share_cut_5 = ' . $db->quote($input['chairman_leadership_share_cut_5']),
					'executive_leadership_share_cut_5 = ' . $db->quote($input['executive_leadership_share_cut_5']),
					'regular_leadership_share_cut_5 = ' . $db->quote($input['regular_leadership_share_cut_5']),
					'associate_leadership_share_cut_5 = ' . $db->quote($input['associate_leadership_share_cut_5']),
					'basic_leadership_share_cut_5 = ' . $db->quote($input['basic_leadership_share_cut_5']),

					'chairman_leadership_share_cut_6 = ' . $db->quote($input['chairman_leadership_share_cut_6']),
					'executive_leadership_share_cut_6 = ' . $db->quote($input['executive_leadership_share_cut_6']),
					'regular_leadership_share_cut_6 = ' . $db->quote($input['regular_leadership_share_cut_6']),
					'associate_leadership_share_cut_6 = ' . $db->quote($input['associate_leadership_share_cut_6']),
					'basic_leadership_share_cut_6 = ' . $db->quote($input['basic_leadership_share_cut_6']),

					'chairman_leadership_share_cut_7 = ' . $db->quote($input['chairman_leadership_share_cut_7']),
					'executive_leadership_share_cut_7 = ' . $db->quote($input['executive_leadership_share_cut_7']),
					'regular_leadership_share_cut_7 = ' . $db->quote($input['regular_leadership_share_cut_7']),
					'associate_leadership_share_cut_7 = ' . $db->quote($input['associate_leadership_share_cut_7']),
					'basic_leadership_share_cut_7 = ' . $db->quote($input['basic_leadership_share_cut_7']),

					'chairman_leadership_share_cut_8 = ' . $db->quote($input['chairman_leadership_share_cut_8']),
					'executive_leadership_share_cut_8 = ' . $db->quote($input['executive_leadership_share_cut_8']),
					'regular_leadership_share_cut_8 = ' . $db->quote($input['regular_leadership_share_cut_8']),
					'associate_leadership_share_cut_8 = ' . $db->quote($input['associate_leadership_share_cut_8']),
					'basic_leadership_share_cut_8 = ' . $db->quote($input['basic_leadership_share_cut_8']),

					'chairman_leadership_share_cut_9 = ' . $db->quote($input['chairman_leadership_share_cut_9']),
					'executive_leadership_share_cut_9 = ' . $db->quote($input['executive_leadership_share_cut_9']),
					'regular_leadership_share_cut_9 = ' . $db->quote($input['regular_leadership_share_cut_9']),
					'associate_leadership_share_cut_9 = ' . $db->quote($input['associate_leadership_share_cut_9']),
					'basic_leadership_share_cut_9 = ' . $db->quote($input['basic_leadership_share_cut_9']),

					'chairman_leadership_share_cut_10 = ' . $db->quote($input['chairman_leadership_share_cut_10']),
					'executive_leadership_share_cut_10 = ' . $db->quote($input['executive_leadership_share_cut_10']),
					'regular_leadership_share_cut_10 = ' . $db->quote($input['regular_leadership_share_cut_10']),
					'associate_leadership_share_cut_10 = ' . $db->quote($input['associate_leadership_share_cut_10']),
					'basic_leadership_share_cut_10 = ' . $db->quote($input['basic_leadership_share_cut_10']),

					'chairman_leadership_share_cut_11 = ' . $db->quote($input['chairman_leadership_share_cut_11']),
					'executive_leadership_share_cut_11 = ' . $db->quote($input['executive_leadership_share_cut_11']),
					'regular_leadership_share_cut_11 = ' . $db->quote($input['regular_leadership_share_cut_11']),
					'associate_leadership_share_cut_11 = ' . $db->quote($input['associate_leadership_share_cut_11']),
					'basic_leadership_share_cut_11 = ' . $db->quote($input['basic_leadership_share_cut_11']),

					'chairman_leadership_share_cut_12 = ' . $db->quote($input['chairman_leadership_share_cut_12']),
					'executive_leadership_share_cut_12 = ' . $db->quote($input['executive_leadership_share_cut_12']),
					'regular_leadership_share_cut_12 = ' . $db->quote($input['regular_leadership_share_cut_12']),
					'associate_leadership_share_cut_12 = ' . $db->quote($input['associate_leadership_share_cut_12']),
					'basic_leadership_share_cut_12 = ' . $db->quote($input['basic_leadership_share_cut_12']),

					'chairman_leadership_share_cut_13 = ' . $db->quote($input['chairman_leadership_share_cut_13']),
					'executive_leadership_share_cut_13 = ' . $db->quote($input['executive_leadership_share_cut_13']),
					'regular_leadership_share_cut_13 = ' . $db->quote($input['regular_leadership_share_cut_13']),
					'associate_leadership_share_cut_13 = ' . $db->quote($input['associate_leadership_share_cut_13']),
					'basic_leadership_share_cut_13 = ' . $db->quote($input['basic_leadership_share_cut_13']),

					'chairman_leadership_share_cut_14 = ' . $db->quote($input['chairman_leadership_share_cut_14']),
					'executive_leadership_share_cut_14 = ' . $db->quote($input['executive_leadership_share_cut_14']),
					'regular_leadership_share_cut_14 = ' . $db->quote($input['regular_leadership_share_cut_14']),
					'associate_leadership_share_cut_14 = ' . $db->quote($input['associate_leadership_share_cut_14']),
					'basic_leadership_share_cut_14 = ' . $db->quote($input['basic_leadership_share_cut_14']),

					'chairman_leadership_share_cut_15 = ' . $db->quote($input['chairman_leadership_share_cut_15']),
					'executive_leadership_share_cut_15 = ' . $db->quote($input['executive_leadership_share_cut_15']),
					'regular_leadership_share_cut_15 = ' . $db->quote($input['regular_leadership_share_cut_15']),
					'associate_leadership_share_cut_15 = ' . $db->quote($input['associate_leadership_share_cut_15']),
					'basic_leadership_share_cut_15 = ' . $db->quote($input['basic_leadership_share_cut_15']),

					'chairman_leadership_share_cut_16 = ' . $db->quote($input['chairman_leadership_share_cut_16']),
					'executive_leadership_share_cut_16 = ' . $db->quote($input['executive_leadership_share_cut_16']),
					'regular_leadership_share_cut_16 = ' . $db->quote($input['regular_leadership_share_cut_16']),
					'associate_leadership_share_cut_16 = ' . $db->quote($input['associate_leadership_share_cut_16']),
					'basic_leadership_share_cut_16 = ' . $db->quote($input['basic_leadership_share_cut_16']),

					'chairman_leadership_share_cut_17 = ' . $db->quote($input['chairman_leadership_share_cut_17']),
					'executive_leadership_share_cut_17 = ' . $db->quote($input['executive_leadership_share_cut_17']),
					'regular_leadership_share_cut_17 = ' . $db->quote($input['regular_leadership_share_cut_17']),
					'associate_leadership_share_cut_17 = ' . $db->quote($input['associate_leadership_share_cut_17']),
					'basic_leadership_share_cut_17 = ' . $db->quote($input['basic_leadership_share_cut_17']),

					'chairman_leadership_share_cut_18 = ' . $db->quote($input['chairman_leadership_share_cut_18']),
					'executive_leadership_share_cut_18 = ' . $db->quote($input['executive_leadership_share_cut_18']),
					'regular_leadership_share_cut_18 = ' . $db->quote($input['regular_leadership_share_cut_18']),
					'associate_leadership_share_cut_18 = ' . $db->quote($input['associate_leadership_share_cut_18']),
					'basic_leadership_share_cut_18 = ' . $db->quote($input['basic_leadership_share_cut_18']),

					'chairman_leadership_share_cut_19 = ' . $db->quote($input['chairman_leadership_share_cut_19']),
					'executive_leadership_share_cut_19 = ' . $db->quote($input['executive_leadership_share_cut_19']),
					'regular_leadership_share_cut_19 = ' . $db->quote($input['regular_leadership_share_cut_19']),
					'associate_leadership_share_cut_19 = ' . $db->quote($input['associate_leadership_share_cut_19']),
					'basic_leadership_share_cut_19 = ' . $db->quote($input['basic_leadership_share_cut_19']),

					'chairman_leadership_share_cut_20 = ' . $db->quote($input['chairman_leadership_share_cut_20']),
					'executive_leadership_share_cut_20 = ' . $db->quote($input['executive_leadership_share_cut_20']),
					'regular_leadership_share_cut_20 = ' . $db->quote($input['regular_leadership_share_cut_20']),
					'associate_leadership_share_cut_20 = ' . $db->quote($input['associate_leadership_share_cut_20']),
					'basic_leadership_share_cut_20 = ' . $db->quote($input['basic_leadership_share_cut_20']),

					'chairman_leadership_level = ' . $db->quote($input['chairman_leadership_level']),
					'executive_leadership_level = ' . $db->quote($input['executive_leadership_level']),
					'regular_leadership_level = ' . $db->quote($input['regular_leadership_level']),
					'associate_leadership_level = ' . $db->quote($input['associate_leadership_level']),
					'basic_leadership_level = ' . $db->quote($input['basic_leadership_level']),

					'chairman_leadership_sponsored = ' . $db->quote($input['chairman_leadership_sponsored']),
					'executive_leadership_sponsored = ' . $db->quote($input['executive_leadership_sponsored']),
					'regular_leadership_sponsored = ' . $db->quote($input['regular_leadership_sponsored']),
					'associate_leadership_sponsored = ' . $db->quote($input['associate_leadership_sponsored']),
					'basic_leadership_sponsored = ' . $db->quote($input['basic_leadership_sponsored']),

					'chairman_leadership_max = ' . $db->quote($input['chairman_leadership_max']),
					'executive_leadership_max = ' . $db->quote($input['executive_leadership_max']),
					'regular_leadership_max = ' . $db->quote($input['regular_leadership_max']),
					'associate_leadership_max = ' . $db->quote($input['associate_leadership_max']),
					'basic_leadership_max = ' . $db->quote($input['basic_leadership_max']),

					'chairman_leadership_max_daily_income = ' . $db->quote($input['chairman_leadership_max_daily_income']),
					'executive_leadership_max_daily_income = ' . $db->quote($input['executive_leadership_max_daily_income']),
					'regular_leadership_max_daily_income = ' . $db->quote($input['regular_leadership_max_daily_income']),
					'associate_leadership_max_daily_income = ' . $db->quote($input['associate_leadership_max_daily_income']),
					'basic_leadership_max_daily_income = ' . $db->quote($input['basic_leadership_max_daily_income'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(84),
			$settings_plans->leadership_binary_name . ' Settings Updated Successfully!', 'success');
	}
}

/**
 *
 * @return string
 *
 * @since version
 */
function style(): string
{
	return '<style>
		.table th, .table td {
			vertical-align: middle;
			text-align: center;
		}
        .net_align {
            width: 120px;
            text-align: center;
        }
        
        .center_align {
        	text-align: center;
        	display: block;    
        	margin: 0;
        }   
        
        label {
        	margin-bottom: 0;
        }       

        select {
            text-align-last: center;
            direction: ltr;
        }
    </style>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view(): string
{
	$settings_entry = settings('entry');

	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
	<form method="post">
		<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="6"><h3 class="center_align">' . settings('plans')->leadership_binary_name .
		' (' . settings('ancillaries')->currency . ')' . '</h3></td>
			</tr>
			<tr>
				<td></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
				<td><h4 style="margin:0" class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
			</tr>';

	$str .= view_row_share();
	$str .= view_row_share_cut();
	$str .= view_row_level();
	$str .= view_row_sponsored_members();
	$str .= view_row_income_max();
	$str .= view_row_income_max_daily();

	$str .= '</table>
		<input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
	</form>
    </div></div></section>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_share(): string
{
	$settings_leadership = settings('leadership');

	return '<tr>
				<td>
					<div class="center_align">Share (%):</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share('chairman', $settings_leadership->chairman_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share('executive', $settings_leadership->executive_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share('regular', $settings_leadership->regular_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share('associate', $settings_leadership->associate_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share('basic', $settings_leadership->basic_leadership_level) .
		'</ul>
					</div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_share_cut(): string
{
	$settings_leadership = settings('leadership');

	return '<tr>
				<td>
					<div class="center_align">Share Cut (%):</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share_cut('chairman', $settings_leadership->chairman_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share_cut('executive', $settings_leadership->executive_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share_cut('regular', $settings_leadership->regular_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share_cut('associate', $settings_leadership->associate_leadership_level) .
		'</ul>
					</div>
				</td>
				<td>
					<div class="center_align">
						<ul class="uk-nav">' .
		view_share_cut('basic', $settings_leadership->basic_leadership_level) .
		'</ul>
					</div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_level(): string
{
	return '<tr>
				<td>
					<div class="center_align">Level:</div>
				</td>
				<td>
					<div class="center_align"><label><select name="chairman_leadership_level" style="width:150px">' .
		view_level('chairman', 20) .
		'</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="executive_leadership_level" style="width:150px">' .
		view_level('executive', 20) .
		'</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="regular_leadership_level" style="width:150px">' .
		view_level('regular', 20) .
		'</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="associate_leadership_level" style="width:150px">' .
		view_level('associate', 20) .
		'</select></label></div>
				</td>
				<td>
					<div class="center_align"><label><select name="basic_leadership_level" style="width:150px">' .
		view_level('basic', 20) .
		'</select></label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_sponsored_members(): string
{
	$settings_leadership = settings('leadership');

	return '<tr>
				<td>
					<div class="center_align">Sponsored Members:</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="chairman_leadership_sponsored" class="net_align"
						              value="' .
		number_format($settings_leadership->chairman_leadership_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="executive_leadership_sponsored" class="net_align"
						              value="' .
		number_format($settings_leadership->executive_leadership_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="regular_leadership_sponsored" class="net_align"
						              value="' .
		number_format($settings_leadership->regular_leadership_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="associate_leadership_sponsored" class="net_align"
						              value="' .
		number_format($settings_leadership->associate_leadership_sponsored) . '" required>
						</label>
					</div>
				</td>
				<td>
					<div class="center_align">
						<label><input name="basic_leadership_sponsored" class="net_align"
						              value="' .
		number_format($settings_leadership->basic_leadership_sponsored) . '" required>
						</label>
					</div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_income_max(): string
{
	$settings = settings('leadership');

	return '<tr>
				<td>
					<div class="center_align">Maximum Income (' . settings('ancillaries')->currency . '):</div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="chairman_leadership_max" class="net_align" value="' .
		number_format($settings->chairman_leadership_max, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="executive_leadership_max" class="net_align" value="' .
		number_format($settings->executive_leadership_max, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="regular_leadership_max" class="net_align" value="' .
		number_format($settings->regular_leadership_max, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="associate_leadership_max" class="net_align" value="' .
		number_format($settings->associate_leadership_max, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="basic_leadership_max" class="net_align" value="' .
		number_format($settings->basic_leadership_max, 8) . '" required>
					</label></div>
				</td>
			</tr>';
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_income_max_daily(): string
{
	$settings = settings('leadership');

	return '<tr>
				<td>
					<div class="center_align">Max. Income / Cycle (' . settings('ancillaries')->currency . '):</div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="chairman_leadership_max_daily_income" class="net_align" value="' .
		number_format($settings->chairman_leadership_max_daily_income, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="executive_leadership_max_daily_income" class="net_align" value="' .
		number_format($settings->executive_leadership_max_daily_income, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="regular_leadership_max_daily_income" class="net_align" value="' .
		number_format($settings->regular_leadership_max_daily_income, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="associate_leadership_max_daily_income" class="net_align" value="' .
		number_format($settings->associate_leadership_max_daily_income, 8) . '" required>
					</label></div>
				</td>
				<td>
					<div class="center_align"><label>
						<input name="basic_leadership_max_daily_income" class="net_align" value="' .
		number_format($settings->basic_leadership_max_daily_income, 8) . '" required>
					</label></div>
				</td>
			</tr>';
}

/**
 * @param        $account
 * @param   int  $level
 * @param   int  $decimal
 *
 * @return string
 *
 * @since version
 */
function view_share($account, int $level = 10, int $decimal = 2): string
{
	$str = '';

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$str .= '<li><label>
				<input name="' . $account . '_leadership_share_' . $i_i . '" style="width:150px"
				       class="net_align"
				       value="' . number_format(settings('leadership')->{$account .
			'_leadership_share_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
	}

	return $str;
}

/**
 * @param        $account
 * @param   int  $level
 * @param   int  $decimal
 *
 * @return string
 *
 * @since version
 */
function view_share_cut($account, int $level = 10, int $decimal = 2): string
{
	$str = '';

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$str .= '<li>
            <label>
                <input name="' . $account . '_leadership_share_cut_' . $i_i . '" style="width:150px"
                       class="net_align"
                       value="' . number_format(settings('leadership')->{$account .
			'_leadership_share_cut_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
	}

	return $str;
}

/**
 * @param $account_type
 *
 * @return mixed
 *
 * @since version
 */
function get_level($account_type)
{
	return settings('leadership')->{$account_type . '_leadership_level'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function level_leadership_binary($account_type, $value): string
{
	return (int) get_level($account_type) === (int) $value ? 'selected' : '';
}

/**
 * @param        $account_type
 * @param   int  $level
 *
 * @return string
 *
 * @since version
 */
function view_level($account_type, int $level = 10): string
{
	$str = '';

	for ($i_i = 0; $i_i <= $level; $i_i++)
	{
		$str .= '<option value="' . $i_i . '" ' .
			level_leadership_binary($account_type, $i_i) . '> ' . $i_i . '</option>';
	}

	return $str;
}