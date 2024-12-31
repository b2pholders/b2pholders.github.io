<?php

namespace BPL\Settings\Indirect_Referral;

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
		'chairman_indirect_referral_share_1'  => input_get('chairman_indirect_referral_share_1'),
		'executive_indirect_referral_share_1' => input_get('executive_indirect_referral_share_1'),
		'regular_indirect_referral_share_1'   => input_get('regular_indirect_referral_share_1'),
		'associate_indirect_referral_share_1' => input_get('associate_indirect_referral_share_1'),
		'basic_indirect_referral_share_1'     => input_get('basic_indirect_referral_share_1'),

		'chairman_indirect_referral_share_2'  => input_get('chairman_indirect_referral_share_2'),
		'executive_indirect_referral_share_2' => input_get('executive_indirect_referral_share_2'),
		'regular_indirect_referral_share_2'   => input_get('regular_indirect_referral_share_2'),
		'associate_indirect_referral_share_2' => input_get('associate_indirect_referral_share_2'),
		'basic_indirect_referral_share_2'     => input_get('basic_indirect_referral_share_2'),

		'chairman_indirect_referral_share_3'  => input_get('chairman_indirect_referral_share_3'),
		'executive_indirect_referral_share_3' => input_get('executive_indirect_referral_share_3'),
		'regular_indirect_referral_share_3'   => input_get('regular_indirect_referral_share_3'),
		'associate_indirect_referral_share_3' => input_get('associate_indirect_referral_share_3'),
		'basic_indirect_referral_share_3'     => input_get('basic_indirect_referral_share_3'),

		'chairman_indirect_referral_share_4'  => input_get('chairman_indirect_referral_share_4'),
		'executive_indirect_referral_share_4' => input_get('executive_indirect_referral_share_4'),
		'regular_indirect_referral_share_4'   => input_get('regular_indirect_referral_share_4'),
		'associate_indirect_referral_share_4' => input_get('associate_indirect_referral_share_4'),
		'basic_indirect_referral_share_4'     => input_get('basic_indirect_referral_share_4'),

		'chairman_indirect_referral_share_5'  => input_get('chairman_indirect_referral_share_5'),
		'executive_indirect_referral_share_5' => input_get('executive_indirect_referral_share_5'),
		'regular_indirect_referral_share_5'   => input_get('regular_indirect_referral_share_5'),
		'associate_indirect_referral_share_5' => input_get('associate_indirect_referral_share_5'),
		'basic_indirect_referral_share_5'     => input_get('basic_indirect_referral_share_5'),

		'chairman_indirect_referral_share_6'  => input_get('chairman_indirect_referral_share_6'),
		'executive_indirect_referral_share_6' => input_get('executive_indirect_referral_share_6'),
		'regular_indirect_referral_share_6'   => input_get('regular_indirect_referral_share_6'),
		'associate_indirect_referral_share_6' => input_get('associate_indirect_referral_share_6'),
		'basic_indirect_referral_share_6'     => input_get('basic_indirect_referral_share_6'),

		'chairman_indirect_referral_share_7'  => input_get('chairman_indirect_referral_share_7'),
		'executive_indirect_referral_share_7' => input_get('executive_indirect_referral_share_7'),
		'regular_indirect_referral_share_7'   => input_get('regular_indirect_referral_share_7'),
		'associate_indirect_referral_share_7' => input_get('associate_indirect_referral_share_7'),
		'basic_indirect_referral_share_7'     => input_get('basic_indirect_referral_share_7'),

		'chairman_indirect_referral_share_8'  => input_get('chairman_indirect_referral_share_8'),
		'executive_indirect_referral_share_8' => input_get('executive_indirect_referral_share_8'),
		'regular_indirect_referral_share_8'   => input_get('regular_indirect_referral_share_8'),
		'associate_indirect_referral_share_8' => input_get('associate_indirect_referral_share_8'),
		'basic_indirect_referral_share_8'     => input_get('basic_indirect_referral_share_8'),

		'chairman_indirect_referral_share_9'  => input_get('chairman_indirect_referral_share_9'),
		'executive_indirect_referral_share_9' => input_get('executive_indirect_referral_share_9'),
		'regular_indirect_referral_share_9'   => input_get('regular_indirect_referral_share_9'),
		'associate_indirect_referral_share_9' => input_get('associate_indirect_referral_share_9'),
		'basic_indirect_referral_share_9'     => input_get('basic_indirect_referral_share_9'),

		'chairman_indirect_referral_share_10'  => input_get('chairman_indirect_referral_share_10'),
		'executive_indirect_referral_share_10' => input_get('executive_indirect_referral_share_10'),
		'regular_indirect_referral_share_10'   => input_get('regular_indirect_referral_share_10'),
		'associate_indirect_referral_share_10' => input_get('associate_indirect_referral_share_10'),
		'basic_indirect_referral_share_10'     => input_get('basic_indirect_referral_share_10'),

		'chairman_indirect_referral_share_11'  => input_get('chairman_indirect_referral_share_11'),
		'executive_indirect_referral_share_11' => input_get('executive_indirect_referral_share_11'),
		'regular_indirect_referral_share_11'   => input_get('regular_indirect_referral_share_11'),
		'associate_indirect_referral_share_11' => input_get('associate_indirect_referral_share_11'),
		'basic_indirect_referral_share_11'     => input_get('basic_indirect_referral_share_11'),

		'chairman_indirect_referral_share_12'  => input_get('chairman_indirect_referral_share_12'),
		'executive_indirect_referral_share_12' => input_get('executive_indirect_referral_share_12'),
		'regular_indirect_referral_share_12'   => input_get('regular_indirect_referral_share_12'),
		'associate_indirect_referral_share_12' => input_get('associate_indirect_referral_share_12'),
		'basic_indirect_referral_share_12'     => input_get('basic_indirect_referral_share_12'),

		'chairman_indirect_referral_share_13'  => input_get('chairman_indirect_referral_share_13'),
		'executive_indirect_referral_share_13' => input_get('executive_indirect_referral_share_13'),
		'regular_indirect_referral_share_13'   => input_get('regular_indirect_referral_share_13'),
		'associate_indirect_referral_share_13' => input_get('associate_indirect_referral_share_13'),
		'basic_indirect_referral_share_13'     => input_get('basic_indirect_referral_share_13'),

		'chairman_indirect_referral_share_14'  => input_get('chairman_indirect_referral_share_14'),
		'executive_indirect_referral_share_14' => input_get('executive_indirect_referral_share_14'),
		'regular_indirect_referral_share_14'   => input_get('regular_indirect_referral_share_14'),
		'associate_indirect_referral_share_14' => input_get('associate_indirect_referral_share_14'),
		'basic_indirect_referral_share_14'     => input_get('basic_indirect_referral_share_14'),

		'chairman_indirect_referral_share_15'  => input_get('chairman_indirect_referral_share_15'),
		'executive_indirect_referral_share_15' => input_get('executive_indirect_referral_share_15'),
		'regular_indirect_referral_share_15'   => input_get('regular_indirect_referral_share_15'),
		'associate_indirect_referral_share_15' => input_get('associate_indirect_referral_share_15'),
		'basic_indirect_referral_share_15'     => input_get('basic_indirect_referral_share_15'),

		'chairman_indirect_referral_share_16'  => input_get('chairman_indirect_referral_share_16'),
		'executive_indirect_referral_share_16' => input_get('executive_indirect_referral_share_16'),
		'regular_indirect_referral_share_16'   => input_get('regular_indirect_referral_share_16'),
		'associate_indirect_referral_share_16' => input_get('associate_indirect_referral_share_16'),
		'basic_indirect_referral_share_16'     => input_get('basic_indirect_referral_share_16'),

		'chairman_indirect_referral_share_17'  => input_get('chairman_indirect_referral_share_17'),
		'executive_indirect_referral_share_17' => input_get('executive_indirect_referral_share_17'),
		'regular_indirect_referral_share_17'   => input_get('regular_indirect_referral_share_17'),
		'associate_indirect_referral_share_17' => input_get('associate_indirect_referral_share_17'),
		'basic_indirect_referral_share_17'     => input_get('basic_indirect_referral_share_17'),

		'chairman_indirect_referral_share_18'  => input_get('chairman_indirect_referral_share_18'),
		'executive_indirect_referral_share_18' => input_get('executive_indirect_referral_share_18'),
		'regular_indirect_referral_share_18'   => input_get('regular_indirect_referral_share_18'),
		'associate_indirect_referral_share_18' => input_get('associate_indirect_referral_share_18'),
		'basic_indirect_referral_share_18'     => input_get('basic_indirect_referral_share_18'),

		'chairman_indirect_referral_share_19'  => input_get('chairman_indirect_referral_share_19'),
		'executive_indirect_referral_share_19' => input_get('executive_indirect_referral_share_19'),
		'regular_indirect_referral_share_19'   => input_get('regular_indirect_referral_share_19'),
		'associate_indirect_referral_share_19' => input_get('associate_indirect_referral_share_19'),
		'basic_indirect_referral_share_19'     => input_get('basic_indirect_referral_share_19'),

		'chairman_indirect_referral_share_20'  => input_get('chairman_indirect_referral_share_20'),
		'executive_indirect_referral_share_20' => input_get('executive_indirect_referral_share_20'),
		'regular_indirect_referral_share_20'   => input_get('regular_indirect_referral_share_20'),
		'associate_indirect_referral_share_20' => input_get('associate_indirect_referral_share_20'),
		'basic_indirect_referral_share_20'     => input_get('basic_indirect_referral_share_20'),

		/*-------------------------------------------------------------------------------------------------*/

//		'executive_indirect_referral_share_cut_1' => input_get('executive_indirect_referral_share_cut_1'),
//		'regular_indirect_referral_share_cut_1'   => input_get('regular_indirect_referral_share_cut_1'),
//		'associate_indirect_referral_share_cut_1' => input_get('associate_indirect_referral_share_cut_1'),
//		'basic_indirect_referral_share_cut_1'     => input_get('basic_indirect_referral_share_cut_1'),
//
//		'executive_indirect_referral_share_cut_2' => input_get('executive_indirect_referral_share_cut_2'),
//		'regular_indirect_referral_share_cut_2'   => input_get('regular_indirect_referral_share_cut_2'),
//		'associate_indirect_referral_share_cut_2' => input_get('associate_indirect_referral_share_cut_2'),
//		'basic_indirect_referral_share_cut_2'     => input_get('basic_indirect_referral_share_cut_2'),
//
//		'executive_indirect_referral_share_cut_3' => input_get('executive_indirect_referral_share_cut_3'),
//		'regular_indirect_referral_share_cut_3'   => input_get('regular_indirect_referral_share_cut_3'),
//		'associate_indirect_referral_share_cut_3' => input_get('associate_indirect_referral_share_cut_3'),
//		'basic_indirect_referral_share_cut_3'     => input_get('basic_indirect_referral_share_cut_3'),
//
//		'executive_indirect_referral_share_cut_4' => input_get('executive_indirect_referral_share_cut_4'),
//		'regular_indirect_referral_share_cut_4'   => input_get('regular_indirect_referral_share_cut_4'),
//		'associate_indirect_referral_share_cut_4' => input_get('associate_indirect_referral_share_cut_4'),
//		'basic_indirect_referral_share_cut_4'     => input_get('basic_indirect_referral_share_cut_4'),
//
//		'executive_indirect_referral_share_cut_5' => input_get('executive_indirect_referral_share_cut_5'),
//		'regular_indirect_referral_share_cut_5'   => input_get('regular_indirect_referral_share_cut_5'),
//		'associate_indirect_referral_share_cut_5' => input_get('associate_indirect_referral_share_cut_5'),
//		'basic_indirect_referral_share_cut_5'     => input_get('basic_indirect_referral_share_cut_5'),
//
//		'executive_indirect_referral_share_cut_6' => input_get('executive_indirect_referral_share_cut_6'),
//		'regular_indirect_referral_share_cut_6'   => input_get('regular_indirect_referral_share_cut_6'),
//		'associate_indirect_referral_share_cut_6' => input_get('associate_indirect_referral_share_cut_6'),
//		'basic_indirect_referral_share_cut_6'     => input_get('basic_indirect_referral_share_cut_6'),
//
//		'executive_indirect_referral_share_cut_7' => input_get('executive_indirect_referral_share_cut_7'),
//		'regular_indirect_referral_share_cut_7'   => input_get('regular_indirect_referral_share_cut_7'),
//		'associate_indirect_referral_share_cut_7' => input_get('associate_indirect_referral_share_cut_7'),
//		'basic_indirect_referral_share_cut_7'     => input_get('basic_indirect_referral_share_cut_7'),
//
//		'executive_indirect_referral_share_cut_8' => input_get('executive_indirect_referral_share_cut_8'),
//		'regular_indirect_referral_share_cut_8'   => input_get('regular_indirect_referral_share_cut_8'),
//		'associate_indirect_referral_share_cut_8' => input_get('associate_indirect_referral_share_cut_8'),
//		'basic_indirect_referral_share_cut_8'     => input_get('basic_indirect_referral_share_cut_8'),
//
//		'executive_indirect_referral_share_cut_9' => input_get('executive_indirect_referral_share_cut_9'),
//		'regular_indirect_referral_share_cut_9'   => input_get('regular_indirect_referral_share_cut_9'),
//		'associate_indirect_referral_share_cut_9' => input_get('associate_indirect_referral_share_cut_9'),
//		'basic_indirect_referral_share_cut_9'     => input_get('basic_indirect_referral_share_cut_9'),
//
//		'executive_indirect_referral_share_cut_10' => input_get('executive_indirect_referral_share_cut_10'),
//		'regular_indirect_referral_share_cut_10'   => input_get('regular_indirect_referral_share_cut_10'),
//		'associate_indirect_referral_share_cut_10' => input_get('associate_indirect_referral_share_cut_10'),
//		'basic_indirect_referral_share_cut_10'     => input_get('basic_indirect_referral_share_cut_10'),

		'chairman_indirect_referral_level'  => input_get('chairman_indirect_referral_level'),
		'executive_indirect_referral_level' => input_get('executive_indirect_referral_level'),
		'regular_indirect_referral_level'   => input_get('regular_indirect_referral_level'),
		'associate_indirect_referral_level' => input_get('associate_indirect_referral_level'),
		'basic_indirect_referral_level'     => input_get('basic_indirect_referral_level'),

		'chairman_indirect_referral_sponsored'  => input_get('chairman_indirect_referral_sponsored'),
		'executive_indirect_referral_sponsored' => input_get('executive_indirect_referral_sponsored'),
		'regular_indirect_referral_sponsored'   => input_get('regular_indirect_referral_sponsored'),
		'associate_indirect_referral_sponsored' => input_get('associate_indirect_referral_sponsored'),
		'basic_indirect_referral_sponsored'     => input_get('basic_indirect_referral_sponsored'),

		'chairman_indirect_referral_max_daily_income'  => input_get('chairman_indirect_referral_max_daily_income'),
		'executive_indirect_referral_max_daily_income' => input_get('executive_indirect_referral_max_daily_income'),
		'regular_indirect_referral_max_daily_income'   => input_get('regular_indirect_referral_max_daily_income'),
		'associate_indirect_referral_max_daily_income' => input_get('associate_indirect_referral_max_daily_income'),
		'basic_indirect_referral_max_daily_income'     => input_get('basic_indirect_referral_max_daily_income'),

		'chairman_indirect_referral_maximum'  => input_get('chairman_indirect_referral_maximum'),
		'executive_indirect_referral_maximum' => input_get('executive_indirect_referral_maximum'),
		'regular_indirect_referral_maximum'   => input_get('regular_indirect_referral_maximum'),
		'associate_indirect_referral_maximum' => input_get('associate_indirect_referral_maximum'),
		'basic_indirect_referral_maximum'     => input_get('basic_indirect_referral_maximum')
	];
}

/**
 *
 *
 * @since version
 */
function update()
{
	$db = db();

	$input = get_input();

	$test = [
		$input['chairman_indirect_referral_level'],
		$input['executive_indirect_referral_level'],
		$input['regular_indirect_referral_level'],
		$input['associate_indirect_referral_level'],
		$input['basic_indirect_referral_level']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_indirect_referral',
				[
					'chairman_indirect_referral_share_1 = ' . $db->quote($input['chairman_indirect_referral_share_1']),
					'executive_indirect_referral_share_1 = ' . $db->quote($input['executive_indirect_referral_share_1']),
					'regular_indirect_referral_share_1 = ' . $db->quote($input['regular_indirect_referral_share_1']),
					'associate_indirect_referral_share_1 = ' . $db->quote($input['associate_indirect_referral_share_1']),
					'basic_indirect_referral_share_1 = ' . $db->quote($input['basic_indirect_referral_share_1']),

					'chairman_indirect_referral_share_2 = ' . $db->quote($input['chairman_indirect_referral_share_2']),
					'executive_indirect_referral_share_2 = ' . $db->quote($input['executive_indirect_referral_share_2']),
					'regular_indirect_referral_share_2 = ' . $db->quote($input['regular_indirect_referral_share_2']),
					'associate_indirect_referral_share_2 = ' . $db->quote($input['associate_indirect_referral_share_2']),
					'basic_indirect_referral_share_2 = ' . $db->quote($input['basic_indirect_referral_share_2']),

					'chairman_indirect_referral_share_3 = ' . $db->quote($input['chairman_indirect_referral_share_3']),
					'executive_indirect_referral_share_3 = ' . $db->quote($input['executive_indirect_referral_share_3']),
					'regular_indirect_referral_share_3 = ' . $db->quote($input['regular_indirect_referral_share_3']),
					'associate_indirect_referral_share_3 = ' . $db->quote($input['associate_indirect_referral_share_3']),
					'basic_indirect_referral_share_3 = ' . $db->quote($input['basic_indirect_referral_share_3']),

					'chairman_indirect_referral_share_4 = ' . $db->quote($input['chairman_indirect_referral_share_4']),
					'executive_indirect_referral_share_4 = ' . $db->quote($input['executive_indirect_referral_share_4']),
					'regular_indirect_referral_share_4 = ' . $db->quote($input['regular_indirect_referral_share_4']),
					'associate_indirect_referral_share_4 = ' . $db->quote($input['associate_indirect_referral_share_4']),
					'basic_indirect_referral_share_4 = ' . $db->quote($input['basic_indirect_referral_share_4']),

					'chairman_indirect_referral_share_5 = ' . $db->quote($input['chairman_indirect_referral_share_5']),
					'executive_indirect_referral_share_5 = ' . $db->quote($input['executive_indirect_referral_share_5']),
					'regular_indirect_referral_share_5 = ' . $db->quote($input['regular_indirect_referral_share_5']),
					'associate_indirect_referral_share_5 = ' . $db->quote($input['associate_indirect_referral_share_5']),
					'basic_indirect_referral_share_5 = ' . $db->quote($input['basic_indirect_referral_share_5']),

					'chairman_indirect_referral_share_6 = ' . $db->quote($input['chairman_indirect_referral_share_6']),
					'executive_indirect_referral_share_6 = ' . $db->quote($input['executive_indirect_referral_share_6']),
					'regular_indirect_referral_share_6 = ' . $db->quote($input['regular_indirect_referral_share_6']),
					'associate_indirect_referral_share_6 = ' . $db->quote($input['associate_indirect_referral_share_6']),
					'basic_indirect_referral_share_6 = ' . $db->quote($input['basic_indirect_referral_share_6']),

					'chairman_indirect_referral_share_7 = ' . $db->quote($input['chairman_indirect_referral_share_7']),
					'executive_indirect_referral_share_7 = ' . $db->quote($input['executive_indirect_referral_share_7']),
					'regular_indirect_referral_share_7 = ' . $db->quote($input['regular_indirect_referral_share_7']),
					'associate_indirect_referral_share_7 = ' . $db->quote($input['associate_indirect_referral_share_7']),
					'basic_indirect_referral_share_7 = ' . $db->quote($input['basic_indirect_referral_share_7']),

					'chairman_indirect_referral_share_8 = ' . $db->quote($input['chairman_indirect_referral_share_8']),
					'executive_indirect_referral_share_8 = ' . $db->quote($input['executive_indirect_referral_share_8']),
					'regular_indirect_referral_share_8 = ' . $db->quote($input['regular_indirect_referral_share_8']),
					'associate_indirect_referral_share_8 = ' . $db->quote($input['associate_indirect_referral_share_8']),
					'basic_indirect_referral_share_8 = ' . $db->quote($input['basic_indirect_referral_share_8']),

					'chairman_indirect_referral_share_9 = ' . $db->quote($input['chairman_indirect_referral_share_9']),
					'executive_indirect_referral_share_9 = ' . $db->quote($input['executive_indirect_referral_share_9']),
					'regular_indirect_referral_share_9 = ' . $db->quote($input['regular_indirect_referral_share_9']),
					'associate_indirect_referral_share_9 = ' . $db->quote($input['associate_indirect_referral_share_9']),
					'basic_indirect_referral_share_9 = ' . $db->quote($input['basic_indirect_referral_share_9']),

					'chairman_indirect_referral_share_10 = ' . $db->quote($input['chairman_indirect_referral_share_10']),
					'executive_indirect_referral_share_10 = ' . $db->quote($input['executive_indirect_referral_share_10']),
					'regular_indirect_referral_share_10 = ' . $db->quote($input['regular_indirect_referral_share_10']),
					'associate_indirect_referral_share_10 = ' . $db->quote($input['associate_indirect_referral_share_10']),
					'basic_indirect_referral_share_10 = ' . $db->quote($input['basic_indirect_referral_share_10']),

					'chairman_indirect_referral_share_11 = ' . $db->quote($input['chairman_indirect_referral_share_11']),
					'executive_indirect_referral_share_11 = ' . $db->quote($input['executive_indirect_referral_share_11']),
					'regular_indirect_referral_share_11 = ' . $db->quote($input['regular_indirect_referral_share_11']),
					'associate_indirect_referral_share_11 = ' . $db->quote($input['associate_indirect_referral_share_11']),
					'basic_indirect_referral_share_11 = ' . $db->quote($input['basic_indirect_referral_share_11']),

					'chairman_indirect_referral_share_12 = ' . $db->quote($input['chairman_indirect_referral_share_12']),
					'executive_indirect_referral_share_12 = ' . $db->quote($input['executive_indirect_referral_share_12']),
					'regular_indirect_referral_share_12 = ' . $db->quote($input['regular_indirect_referral_share_12']),
					'associate_indirect_referral_share_12 = ' . $db->quote($input['associate_indirect_referral_share_12']),
					'basic_indirect_referral_share_12 = ' . $db->quote($input['basic_indirect_referral_share_12']),

					'chairman_indirect_referral_share_13 = ' . $db->quote($input['chairman_indirect_referral_share_13']),
					'executive_indirect_referral_share_13 = ' . $db->quote($input['executive_indirect_referral_share_13']),
					'regular_indirect_referral_share_13 = ' . $db->quote($input['regular_indirect_referral_share_13']),
					'associate_indirect_referral_share_13 = ' . $db->quote($input['associate_indirect_referral_share_13']),
					'basic_indirect_referral_share_13 = ' . $db->quote($input['basic_indirect_referral_share_13']),

					'chairman_indirect_referral_share_14 = ' . $db->quote($input['chairman_indirect_referral_share_14']),
					'executive_indirect_referral_share_14 = ' . $db->quote($input['executive_indirect_referral_share_14']),
					'regular_indirect_referral_share_14 = ' . $db->quote($input['regular_indirect_referral_share_14']),
					'associate_indirect_referral_share_14 = ' . $db->quote($input['associate_indirect_referral_share_14']),
					'basic_indirect_referral_share_14 = ' . $db->quote($input['basic_indirect_referral_share_14']),

					'chairman_indirect_referral_share_15 = ' . $db->quote($input['chairman_indirect_referral_share_15']),
					'executive_indirect_referral_share_15 = ' . $db->quote($input['executive_indirect_referral_share_15']),
					'regular_indirect_referral_share_15 = ' . $db->quote($input['regular_indirect_referral_share_15']),
					'associate_indirect_referral_share_15 = ' . $db->quote($input['associate_indirect_referral_share_15']),
					'basic_indirect_referral_share_15 = ' . $db->quote($input['basic_indirect_referral_share_15']),

					'chairman_indirect_referral_share_16 = ' . $db->quote($input['chairman_indirect_referral_share_16']),
					'executive_indirect_referral_share_16 = ' . $db->quote($input['executive_indirect_referral_share_16']),
					'regular_indirect_referral_share_16 = ' . $db->quote($input['regular_indirect_referral_share_16']),
					'associate_indirect_referral_share_16 = ' . $db->quote($input['associate_indirect_referral_share_16']),
					'basic_indirect_referral_share_16 = ' . $db->quote($input['basic_indirect_referral_share_16']),

					'chairman_indirect_referral_share_17 = ' . $db->quote($input['chairman_indirect_referral_share_17']),
					'executive_indirect_referral_share_17 = ' . $db->quote($input['executive_indirect_referral_share_17']),
					'regular_indirect_referral_share_17 = ' . $db->quote($input['regular_indirect_referral_share_17']),
					'associate_indirect_referral_share_17 = ' . $db->quote($input['associate_indirect_referral_share_17']),
					'basic_indirect_referral_share_17 = ' . $db->quote($input['basic_indirect_referral_share_17']),

					'chairman_indirect_referral_share_18 = ' . $db->quote($input['chairman_indirect_referral_share_18']),
					'executive_indirect_referral_share_18 = ' . $db->quote($input['executive_indirect_referral_share_18']),
					'regular_indirect_referral_share_18 = ' . $db->quote($input['regular_indirect_referral_share_18']),
					'associate_indirect_referral_share_18 = ' . $db->quote($input['associate_indirect_referral_share_18']),
					'basic_indirect_referral_share_18 = ' . $db->quote($input['basic_indirect_referral_share_18']),

					'chairman_indirect_referral_share_19 = ' . $db->quote($input['chairman_indirect_referral_share_19']),
					'executive_indirect_referral_share_19 = ' . $db->quote($input['executive_indirect_referral_share_19']),
					'regular_indirect_referral_share_19 = ' . $db->quote($input['regular_indirect_referral_share_19']),
					'associate_indirect_referral_share_19 = ' . $db->quote($input['associate_indirect_referral_share_19']),
					'basic_indirect_referral_share_19 = ' . $db->quote($input['basic_indirect_referral_share_19']),

					'chairman_indirect_referral_share_20 = ' . $db->quote($input['chairman_indirect_referral_share_20']),
					'executive_indirect_referral_share_20 = ' . $db->quote($input['executive_indirect_referral_share_20']),
					'regular_indirect_referral_share_20 = ' . $db->quote($input['regular_indirect_referral_share_20']),
					'associate_indirect_referral_share_20 = ' . $db->quote($input['associate_indirect_referral_share_20']),
					'basic_indirect_referral_share_20 = ' . $db->quote($input['basic_indirect_referral_share_20']),

//					'executive_indirect_referral_share_cut_1 = ' . $db->quote($input['executive_indirect_referral_share_cut_1']),
//					'regular_indirect_referral_share_cut_1 = ' . $db->quote($input['regular_indirect_referral_share_cut_1']),
//					'associate_indirect_referral_share_cut_1 = ' . $db->quote($input['associate_indirect_referral_share_cut_1']),
//					'basic_indirect_referral_share_cut_1 = ' . $db->quote($input['basic_indirect_referral_share_cut_1']),
//
//					'executive_indirect_referral_share_cut_2 = ' . $db->quote($input['executive_indirect_referral_share_cut_2']),
//					'regular_indirect_referral_share_cut_2 = ' . $db->quote($input['regular_indirect_referral_share_cut_2']),
//					'associate_indirect_referral_share_cut_2 = ' . $db->quote($input['associate_indirect_referral_share_cut_2']),
//					'basic_indirect_referral_share_cut_2 = ' . $db->quote($input['basic_indirect_referral_share_cut_2']),
//
//					'executive_indirect_referral_share_cut_3 = ' . $db->quote($input['executive_indirect_referral_share_cut_3']),
//					'regular_indirect_referral_share_cut_3 = ' . $db->quote($input['regular_indirect_referral_share_cut_3']),
//					'associate_indirect_referral_share_cut_3 = ' . $db->quote($input['associate_indirect_referral_share_cut_3']),
//					'basic_indirect_referral_share_cut_3 = ' . $db->quote($input['basic_indirect_referral_share_cut_3']),
//
//					'executive_indirect_referral_share_cut_4 = ' . $db->quote($input['executive_indirect_referral_share_cut_4']),
//					'regular_indirect_referral_share_cut_4 = ' . $db->quote($input['regular_indirect_referral_share_cut_4']),
//					'associate_indirect_referral_share_cut_4 = ' . $db->quote($input['associate_indirect_referral_share_cut_4']),
//					'basic_indirect_referral_share_cut_4 = ' . $db->quote($input['basic_indirect_referral_share_cut_4']),
//
//					'executive_indirect_referral_share_cut_5 = ' . $db->quote($input['executive_indirect_referral_share_cut_5']),
//					'regular_indirect_referral_share_cut_5 = ' . $db->quote($input['regular_indirect_referral_share_cut_5']),
//					'associate_indirect_referral_share_cut_5 = ' . $db->quote($input['associate_indirect_referral_share_cut_5']),
//					'basic_indirect_referral_share_cut_5 = ' . $db->quote($input['basic_indirect_referral_share_cut_5']),
//
//					'executive_indirect_referral_share_cut_6 = ' . $db->quote($input['executive_indirect_referral_share_cut_6']),
//					'regular_indirect_referral_share_cut_6 = ' . $db->quote($input['regular_indirect_referral_share_cut_6']),
//					'associate_indirect_referral_share_cut_6 = ' . $db->quote($input['associate_indirect_referral_share_cut_6']),
//					'basic_indirect_referral_share_cut_6 = ' . $db->quote($input['basic_indirect_referral_share_cut_6']),
//
//					'executive_indirect_referral_share_cut_7 = ' . $db->quote($input['executive_indirect_referral_share_cut_7']),
//					'regular_indirect_referral_share_cut_7 = ' . $db->quote($input['regular_indirect_referral_share_cut_7']),
//					'associate_indirect_referral_share_cut_7 = ' . $db->quote($input['associate_indirect_referral_share_cut_7']),
//					'basic_indirect_referral_share_cut_7 = ' . $db->quote($input['basic_indirect_referral_share_cut_7']),
//
//					'executive_indirect_referral_share_cut_8 = ' . $db->quote($input['executive_indirect_referral_share_cut_8']),
//					'regular_indirect_referral_share_cut_8 = ' . $db->quote($input['regular_indirect_referral_share_cut_8']),
//					'associate_indirect_referral_share_cut_8 = ' . $db->quote($input['associate_indirect_referral_share_cut_8']),
//					'basic_indirect_referral_share_cut_8 = ' . $db->quote($input['basic_indirect_referral_share_cut_8']),
//
//					'executive_indirect_referral_share_cut_9 = ' . $db->quote($input['executive_indirect_referral_share_cut_9']),
//					'regular_indirect_referral_share_cut_9 = ' . $db->quote($input['regular_indirect_referral_share_cut_9']),
//					'associate_indirect_referral_share_cut_9 = ' . $db->quote($input['associate_indirect_referral_share_cut_9']),
//					'basic_indirect_referral_share_cut_9 = ' . $db->quote($input['basic_indirect_referral_share_cut_9']),
//
//					'executive_indirect_referral_share_cut_10 = ' . $db->quote($input['executive_indirect_referral_share_cut_10']),
//					'regular_indirect_referral_share_cut_10 = ' . $db->quote($input['regular_indirect_referral_share_cut_10']),
//					'associate_indirect_referral_share_cut_10 = ' . $db->quote($input['associate_indirect_referral_share_cut_10']),
//					'basic_indirect_referral_share_cut_10 = ' . $db->quote($input['basic_indirect_referral_share_cut_10']),

					'chairman_indirect_referral_level = ' . $db->quote($input['chairman_indirect_referral_level']),
					'executive_indirect_referral_level = ' . $db->quote($input['executive_indirect_referral_level']),
					'regular_indirect_referral_level = ' . $db->quote($input['regular_indirect_referral_level']),
					'associate_indirect_referral_level = ' . $db->quote($input['associate_indirect_referral_level']),
					'basic_indirect_referral_level = ' . $db->quote($input['basic_indirect_referral_level']),

					'chairman_indirect_referral_sponsored = ' . $db->quote($input['chairman_indirect_referral_sponsored']),
					'executive_indirect_referral_sponsored = ' . $db->quote($input['executive_indirect_referral_sponsored']),
					'regular_indirect_referral_sponsored = ' . $db->quote($input['regular_indirect_referral_sponsored']),
					'associate_indirect_referral_sponsored = ' . $db->quote($input['associate_indirect_referral_sponsored']),
					'basic_indirect_referral_sponsored = ' . $db->quote($input['basic_indirect_referral_sponsored']),

					'chairman_indirect_referral_max_daily_income = ' . $db->quote($input['chairman_indirect_referral_max_daily_income']),
					'executive_indirect_referral_max_daily_income = ' . $db->quote($input['executive_indirect_referral_max_daily_income']),
					'regular_indirect_referral_max_daily_income = ' . $db->quote($input['regular_indirect_referral_max_daily_income']),
					'associate_indirect_referral_max_daily_income = ' . $db->quote($input['associate_indirect_referral_max_daily_income']),
					'basic_indirect_referral_max_daily_income = ' . $db->quote($input['basic_indirect_referral_max_daily_income']),

					'chairman_indirect_referral_maximum = ' . $db->quote($input['chairman_indirect_referral_maximum']),
					'executive_indirect_referral_maximum = ' . $db->quote($input['executive_indirect_referral_maximum']),
					'regular_indirect_referral_maximum = ' . $db->quote($input['regular_indirect_referral_maximum']),
					'associate_indirect_referral_maximum = ' . $db->quote($input['associate_indirect_referral_maximum']),
					'basic_indirect_referral_maximum = ' . $db->quote($input['basic_indirect_referral_maximum'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(82),
			settings('plans')->indirect_referral_name . ' Settings Updated Successfully!', 'success');
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
                <td colspan="6"><h3
                            class="center_align">' . settings('plans')->indirect_referral_name .
		' (' . settings('ancillaries')->currency . ')' . '</h3>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><h4 class="center_align">' . $settings_entry->chairman_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
                <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
            </tr>';

	$str .= view_row_share();
//	$str .= view_row_share_cut();
	$str .= view_row_level();
	$str .= view_row_sponsored_members();
	$str .= view_row_max_daily_income();
	$str .= view_row_max_income();

	$str .= '</table>
        <div class="center_align">
            <input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
        </div>
    </form>
    </div></div></section>';

	return $str;
}

function view_row_share(): string
{
	$settings_indirect_referral = settings('indirect_referral');

	return '<tr>
                <td>
                    <div class="center_align">Bonus (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('chairman', $settings_indirect_referral->chairman_indirect_referral_level, 8) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('executive', $settings_indirect_referral->executive_indirect_referral_level, 8) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('regular', $settings_indirect_referral->regular_indirect_referral_level, 8) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('associate', $settings_indirect_referral->associate_indirect_referral_level, 8) .
		'</ul>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <ul class="uk-nav">' .
		view_share('basic', $settings_indirect_referral->basic_indirect_referral_level, 8) .
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
//function view_row_share_cut(): string
//{
//	$settings_indirect_referral = settings('indirect_referral');
//
//	return '<tr>
//                <td>
//                    <div class="center_align">Share Cut (%):</div>
//                </td>
//                <td>
//                    <div class="center_align">
//                        <ul class="uk-nav">' .
//		view_share_cut('executive', $settings_indirect_referral->executive_indirect_referral_level, 5) .
//		'</ul>
//                    </div>
//                </td>
//                <td>
//                    <div class="center_align">
//                        <ul class="uk-nav">' .
//		view_share_cut('regular', $settings_indirect_referral->regular_indirect_referral_level, 5) .
//		'</ul>
//                    </div>
//                </td>
//                <td>
//                    <div class="center_align">
//                        <ul class="uk-nav">' .
//		view_share_cut('associate', $settings_indirect_referral->associate_indirect_referral_level, 5) .
//		'</ul>
//                    </div>
//                </td>
//                <td>
//                    <div class="center_align">
//                        <ul class="uk-nav">' .
//		view_share_cut('basic', $settings_indirect_referral->basic_indirect_referral_level, 5) .
//		'</ul>
//                    </div>
//                </td>
//            </tr>';
//}

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
                    <div class="center_align"><label><select name="chairman_indirect_referral_level" style="width:150px">' .
		view_level('chairman', 20) . '</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="executive_indirect_referral_level" style="width:150px">' .
		view_level('executive', 20) . '</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="regular_indirect_referral_level" style="width:150px">' .
		view_level('regular', 20) .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="associate_indirect_referral_level" style="width:150px">' .
		view_level('associate', 20) .
		'</select></label></div>
                </td>
                <td>
                    <div class="center_align"><label><select name="basic_indirect_referral_level" style="width:150px">' .
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
	$settings_indirect_referral = settings('indirect_referral');

	return '<tr>
                <td>
                    <div class="center_align">Sponsored Members:</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="chairman_indirect_referral_sponsored" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->chairman_indirect_referral_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_indirect_referral_sponsored" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->executive_indirect_referral_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_indirect_referral_sponsored" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->regular_indirect_referral_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_indirect_referral_sponsored" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->associate_indirect_referral_sponsored) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_indirect_referral_sponsored" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->basic_indirect_referral_sponsored) . '"
                                      required>
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
function view_row_max_daily_income(): string
{
	$settings_indirect_referral = settings('indirect_referral');

	return '<tr>
                <td>
                    <div class="center_align">Max. Income / Cycle (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="chairman_indirect_referral_max_daily_income" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->chairman_indirect_referral_max_daily_income, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_indirect_referral_max_daily_income" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->executive_indirect_referral_max_daily_income, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_indirect_referral_max_daily_income" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->regular_indirect_referral_max_daily_income, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_indirect_referral_max_daily_income" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->associate_indirect_referral_max_daily_income, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_indirect_referral_max_daily_income" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->basic_indirect_referral_max_daily_income, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
            </tr>';
}

function view_row_max_income(): string
{
	$settings_indirect_referral = settings('indirect_referral');

	return '<tr>
                <td>
                    <div class="center_align">Maximum Income (' . settings('ancillaries')->currency . '):</div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="chairman_indirect_referral_maximum" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->chairman_indirect_referral_maximum, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="executive_indirect_referral_maximum" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->executive_indirect_referral_maximum, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="regular_indirect_referral_maximum" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->regular_indirect_referral_maximum, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="associate_indirect_referral_maximum" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->associate_indirect_referral_maximum, 8) . '"
                                      required>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label><input name="basic_indirect_referral_maximum" class="net_align"
                                      value="' .
		number_format($settings_indirect_referral->basic_indirect_referral_maximum, 8) . '"
                                      required>
                        </label>
                    </div>
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
	$settings_indirect_referral = settings('indirect_referral');

	$str = '';

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$str .= '<li><label>
                <input name="' . $account . '_indirect_referral_share_' . $i_i . '" style="width:150px"
                       class="net_align"
                       value="' . number_format($settings_indirect_referral->{$account .
			'_indirect_referral_share_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
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
//function view_share_cut($account, int $level = 10, int $decimal = 2): string
//{
//	$str = '';
//
//	for ($i_i = 1; $i_i <= $level; $i_i++)
//	{
//		$str .= '<li>
//            <label>
//                <input name="' . $account . '_indirect_referral_share_cut_' . $i_i . '" style="width:150px"
//                       class="net_align"
//                       value="' . number_format(settings('indirect_referral')->{$account .
//			'_indirect_referral_share_cut_' . $i_i}, $decimal) . '"> ' . $i_i . '</label></li>';
//	}
//
//	return $str;
//}

/**
 * @param $account_type
 *
 * @return mixed
 *
 * @since version
 */
function get_level($account_type)
{
	return settings('indirect_referral')->{$account_type . '_indirect_referral_level'};
}

/**
 * @param $account_type
 * @param $value
 *
 * @return string
 *
 * @since version
 */
function level_indirect_referral($account_type, $value): string
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
			level_indirect_referral($account_type, $i_i) . '> ' . $i_i . '</option>';
	}

	return $str;
}