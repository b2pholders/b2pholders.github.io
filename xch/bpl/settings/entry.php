<?php

namespace BPL\Settings\Entry;

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
		'chairman_entry'  => input_get('chairman_entry'),
		'executive_entry' => input_get('executive_entry'),
		'regular_entry'   => input_get('regular_entry'),
		'associate_entry' => input_get('associate_entry'),
		'basic_entry'     => input_get('basic_entry'),
		'starter_entry'   => input_get('starter_entry'),

		'chairman_package_name'  => input_get('chairman_package_name'),
		'executive_package_name' => input_get('executive_package_name'),
		'regular_package_name'   => input_get('regular_package_name'),
		'associate_package_name' => input_get('associate_package_name'),
		'basic_package_name'     => input_get('basic_package_name'),
		'starter_package_name'   => input_get('starter_package_name'),

		'chairman_global'  => input_get('chairman_global'),
		'executive_global' => input_get('executive_global'),
		'regular_global'   => input_get('regular_global'),
		'associate_global' => input_get('associate_global'),
		'basic_global'     => input_get('basic_global'),
		'starter_global'   => input_get('starter_global'),

		'chairman_points'  => input_get('chairman_points'),
		'executive_points' => input_get('executive_points'),
		'regular_points'   => input_get('regular_points'),
		'associate_points' => input_get('associate_points'),
		'basic_points'     => input_get('basic_points'),
		'starter_points'   => input_get('starter_points'),

		'chairman_p2p_share'  => input_get('chairman_p2p_share'),
		'executive_p2p_share' => input_get('executive_p2p_share'),
		'regular_p2p_share'   => input_get('regular_p2p_share'),
		'associate_p2p_share' => input_get('associate_p2p_share'),
		'basic_p2p_share'     => input_get('basic_p2p_share'),
		'starter_p2p_share'   => input_get('starter_p2p_share')
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
		$input['chairman_entry'],
		$input['executive_entry'],
		$input['regular_entry'],
		$input['associate_entry'],
		$input['basic_entry'],
		$input['starter_entry'],

		$input['chairman_package_name'],
		$input['executive_package_name'],
		$input['regular_package_name'],
		$input['associate_package_name'],
		$input['basic_package_name'],
		$input['starter_package_name'],

		$input['chairman_global'],
		$input['executive_global'],
		$input['regular_global'],
		$input['associate_global'],
		$input['basic_global'],
		$input['starter_global'],

		$input['chairman_points'],
		$input['executive_points'],
		$input['regular_points'],
		$input['associate_points'],
		$input['basic_points'],
		$input['starter_points'],

		$input['chairman_p2p_share'],
		$input['executive_p2p_share'],
		$input['regular_p2p_share'],
		$input['associate_p2p_share'],
		$input['basic_p2p_share'],
		$input['starter_p2p_share']
	];

	if (!in_array('', $test, true))
	{
		try
		{
			$db->transactionStart();

			query_update(
				'network_settings_entry',
				[
					'chairman_entry = ' . $db->quote($input['chairman_entry']),
					'executive_entry = ' . $db->quote($input['executive_entry']),
					'regular_entry = ' . $db->quote($input['regular_entry']),
					'associate_entry = ' . $db->quote($input['associate_entry']),
					'basic_entry = ' . $db->quote($input['basic_entry']),
					'starter_entry = ' . $db->quote($input['starter_entry']),

					'chairman_package_name = ' . $db->quote($input['chairman_package_name']),
					'executive_package_name = ' . $db->quote($input['executive_package_name']),
					'regular_package_name = ' . $db->quote($input['regular_package_name']),
					'associate_package_name = ' . $db->quote($input['associate_package_name']),
					'basic_package_name = ' . $db->quote($input['basic_package_name']),
					'starter_package_name = ' . $db->quote($input['starter_package_name']),

					'chairman_global = ' . $db->quote($input['chairman_global']),
					'executive_global = ' . $db->quote($input['executive_global']),
					'regular_global = ' . $db->quote($input['regular_global']),
					'associate_global = ' . $db->quote($input['associate_global']),
					'basic_global = ' . $db->quote($input['basic_global']),
					'starter_global = ' . $db->quote($input['starter_global']),

					'chairman_points = ' . $db->quote($input['chairman_points']),
					'executive_points = ' . $db->quote($input['executive_points']),
					'regular_points = ' . $db->quote($input['regular_points']),
					'associate_points = ' . $db->quote($input['associate_points']),
					'basic_points = ' . $db->quote($input['basic_points']),
					'starter_points = ' . $db->quote($input['starter_points']),

					'chairman_p2p_share = ' . $db->quote($input['chairman_p2p_share']),
					'executive_p2p_share = ' . $db->quote($input['executive_p2p_share']),
					'regular_p2p_share = ' . $db->quote($input['regular_p2p_share']),
					'associate_p2p_share = ' . $db->quote($input['associate_p2p_share']),
					'basic_p2p_share = ' . $db->quote($input['basic_p2p_share']),
					'starter_p2p_share = ' . $db->quote($input['starter_p2p_share'])
				]
			);

			$db->transactionCommit();
		}
		catch (Exception $e)
		{
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		application()->redirect(Uri::root(true) . '/' . sef(81),
			'Package Entry Settings Updated Successfully!', 'success');
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
	$se = settings('entry');

	$str = style();

	$str .= '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
			<div class="uk-width-1-1 uk-row-first"><div class="uk-panel uk-text-center">
	<form method="post">
		<table class="category table table-striped table-bordered table-hover">
			<tr>
				<td colspan="7"><h3 class="center_align">Package</h3></td>
			</tr>
			<tr>
				<td></td>
				<td><h4 class="center_align">' . $se->chairman_package_name . '</h4></td>
				<td><h4 class="center_align">' . $se->executive_package_name . '</h4></td>
				<td><h4 class="center_align">' . $se->regular_package_name . '</h4></td>
				<td><h4 class="center_align">' . $se->associate_package_name . '</h4></td>
				<td><h4 class="center_align">' . $se->basic_package_name . '</h4></td>
				<td><h4 class="center_align">' . $se->starter_package_name . '</h4></td>
			</tr>';

	$str .= view_row_name();
	$str .= view_row_entry();
	$str .= view_row_points();
	$str .= view_row_global();
	$str .= view_row_p2p_share();

	$str .= '</table>
		<div class="center_align">
			<input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
		</div>
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
function view_row_name(): string
{
	$se = settings('entry');

	$str = '<tr>';

	$str .= '<td>
				<div class="center_align">Name:</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input type="text" name="chairman_package_name" class="net_align"
					              value="' . $se->chairman_package_name . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input type="text" name="executive_package_name" class="net_align"
					              value="' . $se->executive_package_name . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input type="text" name="regular_package_name" class="net_align"
					              value="' . $se->regular_package_name . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input type="text" name="associate_package_name" class="net_align"
					              value="' . $se->associate_package_name . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input type="text" name="basic_package_name" class="net_align"
					              value="' . $se->basic_package_name . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input type="text" name="starter_package_name" class="net_align"
					              value="' . $se->starter_package_name . '" required></label>
				</div>
			</td>';

	$str .= '</tr>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_entry(): string
{
	$se = settings('entry');

	$str = '<tr>';

	$str .= '<td>
				<div class="center_align">Entry (' . settings('ancillaries')->currency . '):</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="chairman_entry" class="net_align"
					              value="' . number_format($se->chairman_entry, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="executive_entry" class="net_align"
					              value="' . number_format($se->executive_entry, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="regular_entry" class="net_align"
					              value="' . number_format($se->regular_entry, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="associate_entry" class="net_align"
					              value="' . number_format($se->associate_entry, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="basic_entry" class="net_align"
					              value="' . number_format($se->basic_entry, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
			<div class="center_align">
				<label><input name="starter_entry" class="net_align"
				              value="' . number_format($se->starter_entry, 8) . '" required></label>
			</div>
		</td>';

	$str .= '</tr>';

	return $str;
}

function view_row_points(): string
{
	$se = settings('entry');

	$str = '<tr>';

	$str .= '<td>
				<div class="center_align">Token (tkn.):</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="chairman_points" class="net_align"
					              value="' . number_format($se->chairman_points, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="executive_points" class="net_align"
					              value="' . number_format($se->executive_points, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="regular_points" class="net_align"
					              value="' . number_format($se->regular_points, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="associate_points" class="net_align"
					              value="' . number_format($se->associate_points, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="basic_points" class="net_align"
					              value="' . number_format($se->basic_points, 8) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
			<div class="center_align">
				<label><input name="starter_points" class="net_align"
				              value="' . number_format($se->starter_points, 8) . '" required></label>
			</div>
		</td>';

	$str .= '</tr>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_global(): string
{
	$se = settings('entry');

	$str = '<tr>';

	$str .= '<td>
				<div class="center_align" data-uk-tooltip title="Repeat Purchase Global Share">Global (%):</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="chairman_global" class="net_align"
					              value="' . number_format($se->chairman_global, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="executive_global" class="net_align"
					              value="' . number_format($se->executive_global, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="regular_global" class="net_align"
					              value="' . number_format($se->regular_global, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="associate_global" class="net_align"
					              value="' . number_format($se->associate_global, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="basic_global" class="net_align"
					              value="' . number_format($se->basic_global, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="starter_global" class="net_align"
					              value="' . number_format($se->starter_global, 2) . '" required></label>
				</div>
			</td>';

	$str .= '</tr>';

	return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_p2p_share(): string
{
	$se = settings('entry');

	$str = '<tr>';

	$str .= '<td>
				<div class="center_align" data-uk-tooltip title="P2P Share">P2P Buffer (%):</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="chairman_p2p_share" class="net_align"
					              value="' . number_format($se->chairman_p2p_share, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="executive_p2p_share" class="net_align"
					              value="' . number_format($se->executive_p2p_share, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="regular_p2p_share" class="net_align"
					              value="' . number_format($se->regular_p2p_share, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="associate_p2p_share" class="net_align"
					              value="' . number_format($se->associate_p2p_share, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="basic_p2p_share" class="net_align"
					              value="' . number_format($se->basic_p2p_share, 2) . '" required></label>
				</div>
			</td>';

	$str .= '<td>
				<div class="center_align">
					<label><input name="starter_p2p_share" class="net_align"
					              value="' . number_format($se->starter_p2p_share, 2) . '" required></label>
				</div>
			</td>';

	$str .= '</tr>';

	return $str;
}