<?php

namespace BPL\Settings\Investment;

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
        'executive_principal' => input_get('executive_principal'),
        'regular_principal' => input_get('regular_principal'),
        'associate_principal' => input_get('associate_principal'),
        'basic_principal' => input_get('basic_principal'),

        'executive_principal_cut' => input_get('executive_principal_cut'),
        'regular_principal_cut' => input_get('regular_principal_cut'),
        'associate_principal_cut' => input_get('associate_principal_cut'),
        'basic_principal_cut' => input_get('basic_principal_cut'),

        'executive_interest' => input_get('executive_interest'),
        'regular_interest' => input_get('regular_interest'),
        'associate_interest' => input_get('associate_interest'),
        'basic_interest' => input_get('basic_interest'),

        'executive_maturity' => input_get('executive_maturity'),
        'regular_maturity' => input_get('regular_maturity'),
        'associate_maturity' => input_get('associate_maturity'),
        'basic_maturity' => input_get('basic_maturity'),

        'executive_processing' => input_get('executive_processing'),
        'regular_processing' => input_get('regular_processing'),
        'associate_processing' => input_get('associate_processing'),
        'basic_processing' => input_get('basic_processing'),

        'executive_minimum_deposit' => input_get('executive_minimum_deposit'),
        'regular_minimum_deposit' => input_get('regular_minimum_deposit'),
        'associate_minimum_deposit' => input_get('associate_minimum_deposit'),
        'basic_minimum_deposit' => input_get('basic_minimum_deposit'),

        'executive_maximum_deposit' => input_get('executive_maximum_deposit'),
        'regular_maximum_deposit' => input_get('regular_maximum_deposit'),
        'associate_maximum_deposit' => input_get('associate_maximum_deposit'),
        'basic_maximum_deposit' => input_get('basic_maximum_deposit'),

        'executive_required_directs' => input_get('executive_required_directs'),
        'regular_required_directs' => input_get('regular_required_directs'),
        'associate_required_directs' => input_get('associate_required_directs'),
        'basic_required_directs' => input_get('basic_required_directs'),

        /* --------------------------- fixed daily --------------------------------- */

        'executive_fixed_daily_principal' => input_get('executive_fixed_daily_principal'),
        'regular_fixed_daily_principal' => input_get('regular_fixed_daily_principal'),
        'associate_fixed_daily_principal' => input_get('associate_fixed_daily_principal'),
        'basic_fixed_daily_principal' => input_get('basic_fixed_daily_principal'),

        'executive_fixed_daily_principal_cut' => input_get('executive_fixed_daily_principal_cut'),
        'regular_fixed_daily_principal_cut' => input_get('regular_fixed_daily_principal_cut'),
        'associate_fixed_daily_principal_cut' => input_get('associate_fixed_daily_principal_cut'),
        'basic_fixed_daily_principal_cut' => input_get('basic_fixed_daily_principal_cut'),

        'executive_fixed_daily_interest' => input_get('executive_fixed_daily_interest'),
        'regular_fixed_daily_interest' => input_get('regular_fixed_daily_interest'),
        'associate_fixed_daily_interest' => input_get('associate_fixed_daily_interest'),
        'basic_fixed_daily_interest' => input_get('basic_fixed_daily_interest'),

        'executive_fixed_daily_maturity' => input_get('executive_fixed_daily_maturity'),
        'regular_fixed_daily_maturity' => input_get('regular_fixed_daily_maturity'),
        'associate_fixed_daily_maturity' => input_get('associate_fixed_daily_maturity'),
        'basic_fixed_daily_maturity' => input_get('basic_fixed_daily_maturity'),

        'executive_fixed_daily_interval' => input_get('executive_fixed_daily_interval'),
        'regular_fixed_daily_interval' => input_get('regular_fixed_daily_interval'),
        'associate_fixed_daily_interval' => input_get('associate_fixed_daily_interval'),
        'basic_fixed_daily_interval' => input_get('basic_fixed_daily_interval'),

        'executive_fixed_daily_processing' => input_get('executive_fixed_daily_processing'),
        'regular_fixed_daily_processing' => input_get('regular_fixed_daily_processing'),
        'associate_fixed_daily_processing' => input_get('associate_fixed_daily_processing'),
        'basic_fixed_daily_processing' => input_get('basic_fixed_daily_processing'),

        'executive_fixed_daily_donation' => input_get('executive_fixed_daily_donation'),
        'regular_fixed_daily_donation' => input_get('regular_fixed_daily_donation'),
        'associate_fixed_daily_donation' => input_get('associate_fixed_daily_donation'),
        'basic_fixed_daily_donation' => input_get('basic_fixed_daily_donation'),

        'executive_fixed_daily_minimum_deposit' => input_get('executive_fixed_daily_minimum_deposit'),
        'regular_fixed_daily_minimum_deposit' => input_get('regular_fixed_daily_minimum_deposit'),
        'associate_fixed_daily_minimum_deposit' => input_get('associate_fixed_daily_minimum_deposit'),
        'basic_fixed_daily_minimum_deposit' => input_get('basic_fixed_daily_minimum_deposit'),

        'executive_fixed_daily_maximum_deposit' => input_get('executive_fixed_daily_maximum_deposit'),
        'regular_fixed_daily_maximum_deposit' => input_get('regular_fixed_daily_maximum_deposit'),
        'associate_fixed_daily_maximum_deposit' => input_get('associate_fixed_daily_maximum_deposit'),
        'basic_fixed_daily_maximum_deposit' => input_get('basic_fixed_daily_maximum_deposit'),

        'executive_fixed_daily_required_directs' => input_get('executive_fixed_daily_required_directs'),
        'regular_fixed_daily_required_directs' => input_get('regular_fixed_daily_required_directs'),
        'associate_fixed_daily_required_directs' => input_get('associate_fixed_daily_required_directs'),
        'basic_fixed_daily_required_directs' => input_get('basic_fixed_daily_required_directs'),

        /* --------------------------- top up --------------------------------- */
        'executive_top_up_principal_cut' => input_get('executive_top_up_principal_cut'),
        'regular_top_up_principal_cut' => input_get('regular_top_up_principal_cut'),
        'associate_top_up_principal_cut' => input_get('associate_top_up_principal_cut'),
        'basic_top_up_principal_cut' => input_get('basic_top_up_principal_cut'),

        'executive_top_up_interest' => input_get('executive_top_up_interest'),
        'regular_top_up_interest' => input_get('regular_top_up_interest'),
        'associate_top_up_interest' => input_get('associate_top_up_interest'),
        'basic_top_up_interest' => input_get('basic_top_up_interest'),

        'executive_top_up_maturity' => input_get('executive_top_up_maturity'),
        'regular_top_up_maturity' => input_get('regular_top_up_maturity'),
        'associate_top_up_maturity' => input_get('associate_top_up_maturity'),
        'basic_top_up_maturity' => input_get('basic_top_up_maturity'),

        'executive_top_up_minimum' => input_get('executive_top_up_minimum'),
        'regular_top_up_minimum' => input_get('regular_top_up_minimum'),
        'associate_top_up_minimum' => input_get('associate_top_up_minimum'),
        'basic_top_up_minimum' => input_get('basic_top_up_minimum'),

        'executive_top_up_maximum' => input_get('executive_top_up_maximum'),
        'regular_top_up_maximum' => input_get('regular_top_up_maximum'),
        'associate_top_up_maximum' => input_get('associate_top_up_maximum'),
        'basic_top_up_maximum' => input_get('basic_top_up_maximum'),

        'executive_top_up_principal_maximum' => input_get('executive_top_up_principal_maximum'),
        'regular_top_up_principal_maximum' => input_get('regular_top_up_principal_maximum'),
        'associate_top_up_principal_maximum' => input_get('associate_top_up_principal_maximum'),
        'basic_top_up_principal_maximum' => input_get('basic_top_up_principal_maximum'),

        'executive_top_up_processing' => input_get('executive_top_up_processing'),
        'regular_top_up_processing' => input_get('regular_top_up_processing'),
        'associate_top_up_processing' => input_get('associate_top_up_processing'),
        'basic_top_up_processing' => input_get('basic_top_up_processing'),

        'executive_top_up_donation' => input_get('executive_top_up_donation'),
        'regular_top_up_donation' => input_get('regular_top_up_donation'),
        'associate_top_up_donation' => input_get('associate_top_up_donation'),
        'basic_top_up_donation' => input_get('basic_top_up_donation'),

        'executive_top_up_minimum_deposit' => input_get('executive_top_up_minimum_deposit'),
        'regular_top_up_minimum_deposit' => input_get('regular_top_up_minimum_deposit'),
        'associate_top_up_minimum_deposit' => input_get('associate_top_up_minimum_deposit'),
        'basic_top_up_minimum_deposit' => input_get('basic_top_up_minimum_deposit'),

        'executive_top_up_maximum_deposit' => input_get('executive_top_up_maximum_deposit'),
        'regular_top_up_maximum_deposit' => input_get('regular_top_up_maximum_deposit'),
        'associate_top_up_maximum_deposit' => input_get('associate_top_up_maximum_deposit'),
        'basic_top_up_maximum_deposit' => input_get('basic_top_up_maximum_deposit'),

        'executive_top_up_required_directs' => input_get('executive_top_up_required_directs'),
        'regular_top_up_required_directs' => input_get('regular_top_up_required_directs'),
        'associate_top_up_required_directs' => input_get('associate_top_up_required_directs'),
        'basic_top_up_required_directs' => input_get('basic_top_up_required_directs'),

        /* --------------------------- fast track --------------------------------- */
        'executive_fast_track_principal_cut' => input_get('executive_fast_track_principal_cut'),
        'regular_fast_track_principal_cut' => input_get('regular_fast_track_principal_cut'),
        'associate_fast_track_principal_cut' => input_get('associate_fast_track_principal_cut'),
        'basic_fast_track_principal_cut' => input_get('basic_fast_track_principal_cut'),

        'executive_fast_track_interest' => input_get('executive_fast_track_interest'),
        'regular_fast_track_interest' => input_get('regular_fast_track_interest'),
        'associate_fast_track_interest' => input_get('associate_fast_track_interest'),
        'basic_fast_track_interest' => input_get('basic_fast_track_interest'),

        'executive_fast_track_maturity' => input_get('executive_fast_track_maturity'),
        'regular_fast_track_maturity' => input_get('regular_fast_track_maturity'),
        'associate_fast_track_maturity' => input_get('associate_fast_track_maturity'),
        'basic_fast_track_maturity' => input_get('basic_fast_track_maturity'),

        'executive_fast_track_minimum' => input_get('executive_fast_track_minimum'),
        'regular_fast_track_minimum' => input_get('regular_fast_track_minimum'),
        'associate_fast_track_minimum' => input_get('associate_fast_track_minimum'),
        'basic_fast_track_minimum' => input_get('basic_fast_track_minimum'),

        'executive_fast_track_maximum' => input_get('executive_fast_track_maximum'),
        'regular_fast_track_maximum' => input_get('regular_fast_track_maximum'),
        'associate_fast_track_maximum' => input_get('associate_fast_track_maximum'),
        'basic_fast_track_maximum' => input_get('basic_fast_track_maximum'),

        'executive_fast_track_principal_maximum' => input_get('executive_fast_track_principal_maximum'),
        'regular_fast_track_principal_maximum' => input_get('regular_fast_track_principal_maximum'),
        'associate_fast_track_principal_maximum' => input_get('associate_fast_track_principal_maximum'),
        'basic_fast_track_principal_maximum' => input_get('basic_fast_track_principal_maximum'),

        'executive_fast_track_interval' => input_get('executive_fast_track_interval'),
        'regular_fast_track_interval' => input_get('regular_fast_track_interval'),
        'associate_fast_track_interval' => input_get('associate_fast_track_interval'),
        'basic_fast_track_interval' => input_get('basic_fast_track_interval'),

        'executive_fast_track_processing' => input_get('executive_fast_track_processing'),
        'regular_fast_track_processing' => input_get('regular_fast_track_processing'),
        'associate_fast_track_processing' => input_get('associate_fast_track_processing'),
        'basic_fast_track_processing' => input_get('basic_fast_track_processing'),

        'executive_fast_track_donation' => input_get('executive_fast_track_donation'),
        'regular_fast_track_donation' => input_get('regular_fast_track_donation'),
        'associate_fast_track_donation' => input_get('associate_fast_track_donation'),
        'basic_fast_track_donation' => input_get('basic_fast_track_donation'),

        'executive_fast_track_minimum_deposit' => input_get('executive_fast_track_minimum_deposit'),
        'regular_fast_track_minimum_deposit' => input_get('regular_fast_track_minimum_deposit'),
        'associate_fast_track_minimum_deposit' => input_get('associate_fast_track_minimum_deposit'),
        'basic_fast_track_minimum_deposit' => input_get('basic_fast_track_minimum_deposit'),

        'executive_fast_track_maximum_deposit' => input_get('executive_fast_track_maximum_deposit'),
        'regular_fast_track_maximum_deposit' => input_get('regular_fast_track_maximum_deposit'),
        'associate_fast_track_maximum_deposit' => input_get('associate_fast_track_maximum_deposit'),
        'basic_fast_track_maximum_deposit' => input_get('basic_fast_track_maximum_deposit'),

        'executive_fast_track_required_directs' => input_get('executive_fast_track_required_directs'),
        'regular_fast_track_required_directs' => input_get('regular_fast_track_required_directs'),
        'associate_fast_track_required_directs' => input_get('associate_fast_track_required_directs'),
        'basic_fast_track_required_directs' => input_get('basic_fast_track_required_directs')
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
        $input['executive_principal'],
        $input['regular_principal'],
        $input['associate_principal'],
        $input['basic_principal'],

        $input['executive_principal_cut'],
        $input['regular_principal_cut'],
        $input['associate_principal_cut'],
        $input['basic_principal_cut'],

        $input['executive_interest'],
        $input['regular_interest'],
        $input['associate_interest'],
        $input['basic_interest'],

        $input['executive_maturity'],
        $input['regular_maturity'],
        $input['associate_maturity'],
        $input['basic_maturity'],

        $input['executive_processing'],
        $input['regular_processing'],
        $input['associate_processing'],
        $input['basic_processing'],

        $input['executive_minimum_deposit'],
        $input['regular_minimum_deposit'],
        $input['associate_minimum_deposit'],
        $input['basic_minimum_deposit'],

	    $input['executive_maximum_deposit'],
	    $input['regular_maximum_deposit'],
	    $input['associate_maximum_deposit'],
	    $input['basic_maximum_deposit'],

        //-----------------------------------------

        $input['executive_fixed_daily_principal'],
        $input['regular_fixed_daily_principal'],
        $input['associate_fixed_daily_principal'],
        $input['basic_fixed_daily_principal'],

        $input['executive_fixed_daily_interest'],
        $input['regular_fixed_daily_interest'],
        $input['associate_fixed_daily_interest'],
        $input['basic_fixed_daily_interest'],

        $input['executive_fixed_daily_maturity'],
        $input['regular_fixed_daily_maturity'],
        $input['associate_fixed_daily_maturity'],
        $input['basic_fixed_daily_maturity'],

        $input['executive_fixed_daily_interval'],
        $input['regular_fixed_daily_interval'],
        $input['associate_fixed_daily_interval'],
        $input['basic_fixed_daily_interval'],

        $input['executive_fixed_daily_processing'],
        $input['regular_fixed_daily_processing'],
        $input['associate_fixed_daily_processing'],
        $input['basic_fixed_daily_processing'],

        $input['executive_fixed_daily_minimum_deposit'],
        $input['regular_fixed_daily_minimum_deposit'],
        $input['associate_fixed_daily_minimum_deposit'],
        $input['basic_fixed_daily_minimum_deposit'],

	    $input['executive_fixed_daily_maximum_deposit'],
	    $input['regular_fixed_daily_maximum_deposit'],
	    $input['associate_fixed_daily_maximum_deposit'],
	    $input['basic_fixed_daily_maximum_deposit'],

        //----------------------------------------

        $input['executive_top_up_interest'],
        $input['regular_top_up_interest'],
        $input['associate_top_up_interest'],
        $input['basic_top_up_interest'],

        $input['executive_top_up_maturity'],
        $input['regular_top_up_maturity'],
        $input['associate_top_up_maturity'],
        $input['basic_top_up_maturity'],

        $input['executive_top_up_processing'],
        $input['regular_top_up_processing'],
        $input['associate_top_up_processing'],
        $input['basic_top_up_processing'],

        $input['executive_top_up_minimum'],
        $input['regular_top_up_minimum'],
        $input['associate_top_up_minimum'],
        $input['basic_top_up_minimum'],

        $input['executive_top_up_maximum'],
        $input['regular_top_up_maximum'],
        $input['associate_top_up_maximum'],
        $input['basic_top_up_maximum'],

        $input['executive_top_up_principal_maximum'],
        $input['regular_top_up_principal_maximum'],
        $input['associate_top_up_principal_maximum'],
        $input['basic_top_up_principal_maximum'],

        $input['executive_top_up_minimum_deposit'],
        $input['regular_top_up_minimum_deposit'],
        $input['associate_top_up_minimum_deposit'],
        $input['basic_top_up_minimum_deposit'],

	    $input['executive_top_up_maximum_deposit'],
	    $input['regular_top_up_maximum_deposit'],
	    $input['associate_top_up_maximum_deposit'],
	    $input['basic_top_up_maximum_deposit'],

        //----------------------------------------

        $input['executive_fast_track_principal_cut'],
        $input['regular_fast_track_principal_cut'],
        $input['associate_fast_track_principal_cut'],
        $input['basic_fast_track_principal_cut'],

        $input['executive_fast_track_interest'],
        $input['regular_fast_track_interest'],
        $input['associate_fast_track_interest'],
        $input['basic_fast_track_interest'],

        $input['executive_fast_track_maturity'],
        $input['regular_fast_track_maturity'],
        $input['associate_fast_track_maturity'],
        $input['basic_fast_track_maturity'],

        $input['executive_fast_track_minimum'],
        $input['regular_fast_track_minimum'],
        $input['associate_fast_track_minimum'],
        $input['basic_fast_track_minimum'],

        $input['executive_fast_track_maximum'],
        $input['regular_fast_track_maximum'],
        $input['associate_fast_track_maximum'],
        $input['basic_fast_track_maximum'],

        $input['executive_fast_track_principal_maximum'],
        $input['regular_fast_track_principal_maximum'],
        $input['associate_fast_track_principal_maximum'],
        $input['basic_fast_track_principal_maximum'],

        $input['executive_fast_track_interval'],
        $input['regular_fast_track_interval'],
        $input['associate_fast_track_interval'],
        $input['basic_fast_track_interval'],

        $input['executive_fast_track_processing'],
        $input['regular_fast_track_processing'],
        $input['associate_fast_track_processing'],
        $input['basic_fast_track_processing'],

        $input['executive_fast_track_donation'],
        $input['regular_fast_track_donation'],
        $input['associate_fast_track_donation'],
        $input['basic_fast_track_donation'],

        $input['executive_fast_track_minimum_deposit'],
        $input['regular_fast_track_minimum_deposit'],
        $input['associate_fast_track_minimum_deposit'],
        $input['basic_fast_track_minimum_deposit'],

	    $input['executive_fast_track_maximum_deposit'],
	    $input['regular_fast_track_maximum_deposit'],
	    $input['associate_fast_track_maximum_deposit'],
	    $input['basic_fast_track_maximum_deposit']
    ];

    if (!in_array('', $test, true)) {
        try {
            $db->transactionStart();

            query_update(
                'network_settings_investment',
                [
                    'executive_principal = ' . $db->quote($input['executive_principal']),
                    'regular_principal = ' . $db->quote($input['regular_principal']),
                    'associate_principal = ' . $db->quote($input['associate_principal']),
                    'basic_principal = ' . $db->quote($input['basic_principal']),

                    'executive_principal_cut = ' . $db->quote($input['executive_principal_cut']),
                    'regular_principal_cut = ' . $db->quote($input['regular_principal_cut']),
                    'associate_principal_cut = ' . $db->quote($input['associate_principal_cut']),
                    'basic_principal_cut = ' . $db->quote($input['basic_principal_cut']),

                    'executive_interest = ' . $db->quote($input['executive_interest']),
                    'regular_interest = ' . $db->quote($input['regular_interest']),
                    'associate_interest = ' . $db->quote($input['associate_interest']),
                    'basic_interest = ' . $db->quote($input['basic_interest']),

                    'executive_maturity = ' . $db->quote($input['executive_maturity']),
                    'regular_maturity = ' . $db->quote($input['regular_maturity']),
                    'associate_maturity = ' . $db->quote($input['associate_maturity']),
                    'basic_maturity = ' . $db->quote($input['basic_maturity']),

                    'executive_processing = ' . $db->quote($input['executive_processing']),
                    'regular_processing = ' . $db->quote($input['regular_processing']),
                    'associate_processing = ' . $db->quote($input['associate_processing']),
                    'basic_processing = ' . $db->quote($input['basic_processing']),

                    'executive_minimum_deposit = ' . $db->quote($input['executive_minimum_deposit']),
                    'regular_minimum_deposit = ' . $db->quote($input['regular_minimum_deposit']),
                    'associate_minimum_deposit = ' . $db->quote($input['associate_minimum_deposit']),
                    'basic_minimum_deposit = ' . $db->quote($input['basic_minimum_deposit']),

	                'executive_maximum_deposit = ' . $db->quote($input['executive_maximum_deposit']),
	                'regular_maximum_deposit = ' . $db->quote($input['regular_maximum_deposit']),
	                'associate_maximum_deposit = ' . $db->quote($input['associate_maximum_deposit']),
	                'basic_maximum_deposit = ' . $db->quote($input['basic_maximum_deposit']),

                    'executive_required_directs = ' . $db->quote($input['executive_required_directs']),
                    'regular_required_directs = ' . $db->quote($input['regular_required_directs']),
                    'associate_required_directs = ' . $db->quote($input['associate_required_directs']),
                    'basic_required_directs = ' . $db->quote($input['basic_required_directs']),

                    'executive_fixed_daily_principal = ' . $db->quote($input['executive_fixed_daily_principal']),
                    'regular_fixed_daily_principal = ' . $db->quote($input['regular_fixed_daily_principal']),
                    'associate_fixed_daily_principal = ' . $db->quote($input['associate_fixed_daily_principal']),
                    'basic_fixed_daily_principal = ' . $db->quote($input['basic_fixed_daily_principal']),

                    'executive_fixed_daily_principal_cut = ' . $db->quote($input['executive_fixed_daily_principal_cut']),
                    'regular_fixed_daily_principal_cut = ' . $db->quote($input['regular_fixed_daily_principal_cut']),
                    'associate_fixed_daily_principal_cut = ' . $db->quote($input['associate_fixed_daily_principal_cut']),
                    'basic_fixed_daily_principal_cut = ' . $db->quote($input['basic_fixed_daily_principal_cut']),

                    'executive_fixed_daily_interest = ' . $db->quote($input['executive_fixed_daily_interest']),
                    'regular_fixed_daily_interest = ' . $db->quote($input['regular_fixed_daily_interest']),
                    'associate_fixed_daily_interest = ' . $db->quote($input['associate_fixed_daily_interest']),
                    'basic_fixed_daily_interest = ' . $db->quote($input['basic_fixed_daily_interest']),

                    'executive_fixed_daily_maturity = ' . $db->quote($input['executive_fixed_daily_maturity']),
                    'regular_fixed_daily_maturity = ' . $db->quote($input['regular_fixed_daily_maturity']),
                    'associate_fixed_daily_maturity = ' . $db->quote($input['associate_fixed_daily_maturity']),
                    'basic_fixed_daily_maturity = ' . $db->quote($input['basic_fixed_daily_maturity']),

                    'executive_fixed_daily_interval = ' . $db->quote($input['executive_fixed_daily_interval']),
                    'regular_fixed_daily_interval = ' . $db->quote($input['regular_fixed_daily_interval']),
                    'associate_fixed_daily_interval = ' . $db->quote($input['associate_fixed_daily_interval']),
                    'basic_fixed_daily_interval = ' . $db->quote($input['basic_fixed_daily_interval']),

                    'executive_fixed_daily_processing = ' . $db->quote($input['executive_fixed_daily_processing']),
                    'regular_fixed_daily_processing = ' . $db->quote($input['regular_fixed_daily_processing']),
                    'associate_fixed_daily_processing = ' . $db->quote($input['associate_fixed_daily_processing']),
                    'basic_fixed_daily_processing = ' . $db->quote($input['basic_fixed_daily_processing']),

                    'executive_fixed_daily_donation = ' . $db->quote($input['executive_fixed_daily_donation']),
                    'regular_fixed_daily_donation = ' . $db->quote($input['regular_fixed_daily_donation']),
                    'associate_fixed_daily_donation = ' . $db->quote($input['associate_fixed_daily_donation']),
                    'basic_fixed_daily_donation = ' . $db->quote($input['basic_fixed_daily_donation']),

                    'executive_fixed_daily_minimum_deposit = ' . $db->quote($input['executive_fixed_daily_minimum_deposit']),
                    'regular_fixed_daily_minimum_deposit = ' . $db->quote($input['regular_fixed_daily_minimum_deposit']),
                    'associate_fixed_daily_minimum_deposit = ' . $db->quote($input['associate_fixed_daily_minimum_deposit']),
                    'basic_fixed_daily_minimum_deposit = ' . $db->quote($input['basic_fixed_daily_minimum_deposit']),

	                'executive_fixed_daily_maximum_deposit = ' . $db->quote($input['executive_fixed_daily_maximum_deposit']),
	                'regular_fixed_daily_maximum_deposit = ' . $db->quote($input['regular_fixed_daily_maximum_deposit']),
	                'associate_fixed_daily_maximum_deposit = ' . $db->quote($input['associate_fixed_daily_maximum_deposit']),
	                'basic_fixed_daily_maximum_deposit = ' . $db->quote($input['basic_fixed_daily_maximum_deposit']),

                    'executive_fixed_daily_required_directs = ' . $db->quote($input['executive_fixed_daily_required_directs']),
                    'regular_fixed_daily_required_directs = ' . $db->quote($input['regular_fixed_daily_required_directs']),
                    'associate_fixed_daily_required_directs = ' . $db->quote($input['associate_fixed_daily_required_directs']),
                    'basic_fixed_daily_required_directs = ' . $db->quote($input['basic_fixed_daily_required_directs']),

                    'executive_top_up_principal_cut = ' . $db->quote($input['executive_top_up_principal_cut']),
                    'regular_top_up_principal_cut = ' . $db->quote($input['regular_top_up_principal_cut']),
                    'associate_top_up_principal_cut = ' . $db->quote($input['associate_top_up_principal_cut']),
                    'basic_top_up_principal_cut = ' . $db->quote($input['basic_top_up_principal_cut']),

                    'executive_top_up_interest = ' . $db->quote($input['executive_top_up_interest']),
                    'regular_top_up_interest = ' . $db->quote($input['regular_top_up_interest']),
                    'associate_top_up_interest = ' . $db->quote($input['associate_top_up_interest']),
                    'basic_top_up_interest = ' . $db->quote($input['basic_top_up_interest']),

                    'executive_top_up_maturity = ' . $db->quote($input['executive_top_up_maturity']),
                    'regular_top_up_maturity = ' . $db->quote($input['regular_top_up_maturity']),
                    'associate_top_up_maturity = ' . $db->quote($input['associate_top_up_maturity']),
                    'basic_top_up_maturity = ' . $db->quote($input['basic_top_up_maturity']),

                    'executive_top_up_minimum = ' . $db->quote($input['executive_top_up_minimum']),
                    'regular_top_up_minimum = ' . $db->quote($input['regular_top_up_minimum']),
                    'associate_top_up_minimum = ' . $db->quote($input['associate_top_up_minimum']),
                    'basic_top_up_minimum = ' . $db->quote($input['basic_top_up_minimum']),

                    'executive_top_up_maximum = ' . $db->quote($input['executive_top_up_maximum']),
                    'regular_top_up_maximum = ' . $db->quote($input['regular_top_up_maximum']),
                    'associate_top_up_maximum = ' . $db->quote($input['associate_top_up_maximum']),
                    'basic_top_up_maximum = ' . $db->quote($input['basic_top_up_maximum']),

                    'executive_top_up_principal_maximum = ' . $db->quote($input['executive_top_up_principal_maximum']),
                    'regular_top_up_principal_maximum = ' . $db->quote($input['regular_top_up_principal_maximum']),
                    'associate_top_up_principal_maximum = ' . $db->quote($input['associate_top_up_principal_maximum']),
                    'basic_top_up_principal_maximum = ' . $db->quote($input['basic_top_up_principal_maximum']),

                    'executive_top_up_processing = ' . $db->quote($input['executive_top_up_processing']),
                    'regular_top_up_processing = ' . $db->quote($input['regular_top_up_processing']),
                    'associate_top_up_processing = ' . $db->quote($input['associate_top_up_processing']),
                    'basic_top_up_processing = ' . $db->quote($input['basic_top_up_processing']),

                    'executive_top_up_donation = ' . $db->quote($input['executive_top_up_donation']),
                    'regular_top_up_donation = ' . $db->quote($input['regular_top_up_donation']),
                    'associate_top_up_donation = ' . $db->quote($input['associate_top_up_donation']),
                    'basic_top_up_donation = ' . $db->quote($input['basic_top_up_donation']),

                    'executive_top_up_minimum_deposit = ' . $db->quote($input['executive_top_up_minimum_deposit']),
                    'regular_top_up_minimum_deposit = ' . $db->quote($input['regular_top_up_minimum_deposit']),
                    'associate_top_up_minimum_deposit = ' . $db->quote($input['associate_top_up_minimum_deposit']),
                    'basic_top_up_minimum_deposit = ' . $db->quote($input['basic_top_up_minimum_deposit']),

	                'executive_top_up_maximum_deposit = ' . $db->quote($input['executive_top_up_maximum_deposit']),
	                'regular_top_up_maximum_deposit = ' . $db->quote($input['regular_top_up_maximum_deposit']),
	                'associate_top_up_maximum_deposit = ' . $db->quote($input['associate_top_up_maximum_deposit']),
	                'basic_top_up_maximum_deposit = ' . $db->quote($input['basic_top_up_maximum_deposit']),

                    'executive_top_up_required_directs = ' . $db->quote($input['executive_top_up_required_directs']),
                    'regular_top_up_required_directs = ' . $db->quote($input['regular_top_up_required_directs']),
                    'associate_top_up_required_directs = ' . $db->quote($input['associate_top_up_required_directs']),
                    'basic_top_up_required_directs = ' . $db->quote($input['basic_top_up_required_directs']),

                    'executive_fast_track_principal_cut = ' . $db->quote($input['executive_fast_track_principal_cut']),
                    'regular_fast_track_principal_cut = ' . $db->quote($input['regular_fast_track_principal_cut']),
                    'associate_fast_track_principal_cut = ' . $db->quote($input['associate_fast_track_principal_cut']),
                    'basic_fast_track_principal_cut = ' . $db->quote($input['basic_fast_track_principal_cut']),

                    'executive_fast_track_interest = ' . $db->quote($input['executive_fast_track_interest']),
                    'regular_fast_track_interest = ' . $db->quote($input['regular_fast_track_interest']),
                    'associate_fast_track_interest = ' . $db->quote($input['associate_fast_track_interest']),
                    'basic_fast_track_interest = ' . $db->quote($input['basic_fast_track_interest']),

                    'executive_fast_track_maturity = ' . $db->quote($input['executive_fast_track_maturity']),
                    'regular_fast_track_maturity = ' . $db->quote($input['regular_fast_track_maturity']),
                    'associate_fast_track_maturity = ' . $db->quote($input['associate_fast_track_maturity']),
                    'basic_fast_track_maturity = ' . $db->quote($input['basic_fast_track_maturity']),

                    'executive_fast_track_minimum = ' . $db->quote($input['executive_fast_track_minimum']),
                    'regular_fast_track_minimum = ' . $db->quote($input['regular_fast_track_minimum']),
                    'associate_fast_track_minimum = ' . $db->quote($input['associate_fast_track_minimum']),
                    'basic_fast_track_minimum = ' . $db->quote($input['basic_fast_track_minimum']),

                    'executive_fast_track_maximum = ' . $db->quote($input['executive_fast_track_maximum']),
                    'regular_fast_track_maximum = ' . $db->quote($input['regular_fast_track_maximum']),
                    'associate_fast_track_maximum = ' . $db->quote($input['associate_fast_track_maximum']),
                    'basic_fast_track_maximum = ' . $db->quote($input['basic_fast_track_maximum']),

                    'executive_fast_track_principal_maximum = ' . $db->quote($input['executive_fast_track_principal_maximum']),
                    'regular_fast_track_principal_maximum = ' . $db->quote($input['regular_fast_track_principal_maximum']),
                    'associate_fast_track_principal_maximum = ' . $db->quote($input['associate_fast_track_principal_maximum']),
                    'basic_fast_track_principal_maximum = ' . $db->quote($input['basic_fast_track_principal_maximum']),

                    'executive_fast_track_interval = ' . $db->quote($input['executive_fast_track_interval']),
                    'regular_fast_track_interval = ' . $db->quote($input['regular_fast_track_interval']),
                    'associate_fast_track_interval = ' . $db->quote($input['associate_fast_track_interval']),
                    'basic_fast_track_interval = ' . $db->quote($input['basic_fast_track_interval']),

                    'executive_fast_track_processing = ' . $db->quote($input['executive_fast_track_processing']),
                    'regular_fast_track_processing = ' . $db->quote($input['regular_fast_track_processing']),
                    'associate_fast_track_processing = ' . $db->quote($input['associate_fast_track_processing']),
                    'basic_fast_track_processing = ' . $db->quote($input['basic_fast_track_processing']),

                    'executive_fast_track_donation = ' . $db->quote($input['executive_fast_track_donation']),
                    'regular_fast_track_donation = ' . $db->quote($input['regular_fast_track_donation']),
                    'associate_fast_track_donation = ' . $db->quote($input['associate_fast_track_donation']),
                    'basic_fast_track_donation = ' . $db->quote($input['basic_fast_track_donation']),

                    'executive_fast_track_minimum_deposit = ' . $db->quote($input['executive_fast_track_minimum_deposit']),
                    'regular_fast_track_minimum_deposit = ' . $db->quote($input['regular_fast_track_minimum_deposit']),
                    'associate_fast_track_minimum_deposit = ' . $db->quote($input['associate_fast_track_minimum_deposit']),
                    'basic_fast_track_minimum_deposit = ' . $db->quote($input['basic_fast_track_minimum_deposit']),

	                'executive_fast_track_maximum_deposit = ' . $db->quote($input['executive_fast_track_maximum_deposit']),
	                'regular_fast_track_maximum_deposit = ' . $db->quote($input['regular_fast_track_maximum_deposit']),
	                'associate_fast_track_maximum_deposit = ' . $db->quote($input['associate_fast_track_maximum_deposit']),
	                'basic_fast_track_maximum_deposit = ' . $db->quote($input['basic_fast_track_maximum_deposit']),

                    'executive_fast_track_required_directs = ' . $db->quote($input['executive_fast_track_required_directs']),
                    'regular_fast_track_required_directs = ' . $db->quote($input['regular_fast_track_required_directs']),
                    'associate_fast_track_required_directs = ' . $db->quote($input['associate_fast_track_required_directs']),
                    'basic_fast_track_required_directs = ' . $db->quote($input['basic_fast_track_required_directs'])
                ]
            );

            $db->transactionCommit();
        } catch (Exception $e) {
            $db->transactionRollback();
            ExceptionHandler::render($e);
        }

        application()->redirect(Uri::root(true) . '/' . sef(83),
            'Investment Settings Updated Successfully!', 'success');
    }
}

/**
 *
 * @return string
 *
 * @since version
 */
function view(): string
{
    $str = '<section class="tm-top-b uk-grid" data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
	    <div class="uk-width-1-1 uk-row-first">
	        <div class="uk-panel uk-text-center">
	            <form method="post">';
    $str .= view_etrade();
    $str .= view_fixed_daily();
    $str .= view_top_up();
    $str .= view_fast_track();
    $str .= '<input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
	            </form>
	        </div>
	    </div>
	</section>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function style_etrade(): string
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
function view_etrade(): string
{
    $settings_entry = settings('entry');

    $str = style_etrade();

    $str .= '<table class="category table table-striped table-bordered table-hover">
	    <tr>
	        <td colspan="5"><h3 class="center_align">' . settings('plans')->etrade_name . '</h3></td>
	    </tr>
	    <tr>
	        <td></td>
	        <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
	        <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
	        <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
	        <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
	    </tr>';

    $str .= view_row_compound_principal();
    $str .= view_row_compound_principal_cut();
    $str .= view_row_compound_interest();
    $str .= view_row_compound_maturity();
    $str .= view_row_compound_processing();
    $str .= view_row_compound_min_deposit();
	$str .= view_row_compound_max_deposit();
    $str .= view_row_compound_required_directs();

    $str .= '</table>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_compound_principal(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Principal (' . settings('ancillaries')->currency . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_principal"
		                              value="' . number_format($settings_investment->executive_principal, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_principal"
		                              value="' . number_format($settings_investment->regular_principal, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_principal"
		                              value="' . number_format($settings_investment->associate_principal, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_principal"
		                              value="' . number_format($settings_investment->basic_principal, 8) . '"></label>
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
function view_row_compound_principal_cut(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Principal Cut (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_principal_cut"
		                              value="' .
        number_format($settings_investment->executive_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_principal_cut"
		                              value="' .
        number_format($settings_investment->regular_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_principal_cut"
		                              value="' .
        number_format($settings_investment->associate_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_principal_cut"
		                              value="' .
        number_format($settings_investment->basic_principal_cut, 5) . '"></label>
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
function view_row_compound_interest(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Compound Interest Rate (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_interest"
		                              value="' .
        number_format($settings_investment->executive_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_interest"
		                              value="' .
        number_format($settings_investment->regular_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_interest"
		                              value="' .
        number_format($settings_investment->associate_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_interest"
		                              value="' .
        number_format($settings_investment->basic_interest, 5) . '"></label>
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
function view_row_compound_maturity(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Maturity (day):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_maturity"
	                              value="' . number_format($settings_investment->executive_maturity) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_maturity"
	                              value="' . number_format($settings_investment->regular_maturity) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_maturity"
	                              value="' . number_format($settings_investment->associate_maturity) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_maturity"
	                              value="' . number_format($settings_investment->basic_maturity) . '"></label>
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
function view_row_compound_processing(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Processing (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_processing"
		                              value="' .
        number_format($settings_investment->executive_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_processing"
		                              value="' .
        number_format($settings_investment->regular_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_processing"
		                              value="' .
        number_format($settings_investment->associate_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_processing"
		                              value="' .
        number_format($settings_investment->basic_processing) . '"></label>
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
function view_row_compound_min_deposit(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Minimum Deposit (' . settings('ancillaries')->currency . '):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_minimum_deposit"
	                              value="' .
        number_format($settings_investment->executive_minimum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_minimum_deposit"
	                              value="' .
        number_format($settings_investment->regular_minimum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_minimum_deposit"
	                              value="' .
        number_format($settings_investment->associate_minimum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_minimum_deposit"
	                              value="' .
        number_format($settings_investment->basic_minimum_deposit, 8) . '"></label>
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
function view_row_compound_max_deposit(): string
{
	$settings_investment = settings('investment');

	return '<tr>
	        <td>
	            <div class="center_align">Maximum Deposit (' . settings('ancillaries')->currency . '):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_maximum_deposit"
	                              value="' .
		number_format($settings_investment->executive_maximum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_maximum_deposit"
	                              value="' .
		number_format($settings_investment->regular_maximum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_maximum_deposit"
	                              value="' .
		number_format($settings_investment->associate_maximum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_maximum_deposit"
	                              value="' .
		number_format($settings_investment->basic_maximum_deposit, 8) . '"></label>
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
function view_row_compound_required_directs(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Required Directs:</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_required_directs"
	                              value="' .
        number_format($settings_investment->executive_required_directs) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_required_directs"
	                              value="' .
        number_format($settings_investment->regular_required_directs) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_required_directs"
	                              value="' .
        number_format($settings_investment->associate_required_directs) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_required_directs"
	                              value="' .
        number_format($settings_investment->basic_required_directs) . '"></label>
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
function style_fixed_daily(): string
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
function view_fixed_daily(): string
{
    $settings_entry = settings('entry');

    $str = style_fixed_daily();

    $str .= '<table class="category table table-striped table-bordered table-hover">
		    <tr>
		        <td colspan="5"><h3 class="center_align">' . settings('plans')->fixed_daily_name . '</h3></td>
		    </tr>
		    <tr>
		        <td></td>
		        <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
		        <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
		        <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
		        <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
		    </tr>';

    $str .= view_row_fixed_daily_principal();
    $str .= view_row_fixed_daily_principal_cut();
    $str .= view_row_fixed_daily_interest();
    $str .= view_row_fixed_daily_maturity();
    $str .= view_row_fixed_daily_interval();
    $str .= view_row_fixed_daily_processing();
    $str .= view_row_fixed_daily_donation();
    $str .= view_row_fixed_daily_min_deposit();
	$str .= view_row_fixed_daily_max_deposit();
    $str .= view_row_fixed_daily_required_directs();

    $str .= '</table>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_fixed_daily_principal(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Principal (' . settings('ancillaries')->currency . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_principal"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_principal, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_principal"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_principal, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_principal"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_principal, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_principal"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_principal, 8) . '"></label>
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
function view_row_fixed_daily_principal_cut(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Principal Cut (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_principal_cut"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_principal_cut"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_principal_cut"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_principal_cut"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_principal_cut, 5) . '"></label>
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
function view_row_fixed_daily_interest(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Fixed Interest Rate (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_interest"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_interest"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_interest"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_interest"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_interest, 5) . '"></label>
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
function view_row_fixed_daily_maturity(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Maturity (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_maturity"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_maturity"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_maturity"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_maturity"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_maturity) . '"></label>
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
function view_row_fixed_daily_interval(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Interval (seconds):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_interval"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_interval) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_interval"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_interval) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_interval"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_interval) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_interval"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_interval) . '"></label>
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
function view_row_fixed_daily_processing(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Processing (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_processing"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_processing"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_processing"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_processing"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_processing) . '"></label>
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
function view_row_fixed_daily_donation(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Donation (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_donation"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_donation"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_donation"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_donation"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_donation, 5) . '"></label>
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
function view_row_fixed_daily_min_deposit(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Minimum Deposit (' . settings('ancillaries')->currency . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_minimum_deposit"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_minimum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_minimum_deposit"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_minimum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_minimum_deposit"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_minimum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_minimum_deposit"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_minimum_deposit, 8) . '"></label>
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
function view_row_fixed_daily_max_deposit(): string
{
	$settings_investment = settings('investment');

	return '<tr>
		        <td>
		            <div class="center_align">Maximum Deposit (' . settings('ancillaries')->currency . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_maximum_deposit"
		                              value="' .
		number_format($settings_investment->executive_fixed_daily_maximum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_maximum_deposit"
		                              value="' .
		number_format($settings_investment->regular_fixed_daily_maximum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_maximum_deposit"
		                              value="' .
		number_format($settings_investment->associate_fixed_daily_maximum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_maximum_deposit"
		                              value="' .
		number_format($settings_investment->basic_fixed_daily_maximum_deposit, 8) . '"></label>
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
function view_row_fixed_daily_required_directs(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Required Directs:</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fixed_daily_required_directs"
		                              value="' .
        number_format($settings_investment->executive_fixed_daily_required_directs) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fixed_daily_required_directs"
		                              value="' .
        number_format($settings_investment->regular_fixed_daily_required_directs) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fixed_daily_required_directs"
		                              value="' .
        number_format($settings_investment->associate_fixed_daily_required_directs) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fixed_daily_required_directs"
		                              value="' .
        number_format($settings_investment->basic_fixed_daily_required_directs) . '"></label>
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
function style_top_up(): string
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
function view_top_up(): string
{
    $settings_entry = settings('entry');

    $str = style_top_up();

    $str .= '<table class="category table table-striped table-bordered table-hover">
	    <tr>
	        <td colspan="5"><h3 class="center_align">' . settings('plans')->top_up_name . '</h3></td>
	    </tr>
	    <tr>
	        <td></td>
	        <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
	        <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
	        <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
	        <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
	    </tr>';

    $str .= view_row_top_up_principal_cut();
    $str .= view_row_top_up_compound_interest();
    $str .= view_row_top_up_maturity();
    $str .= view_row_top_up_processing();
    $str .= view_row_top_up_min_input();
    $str .= view_row_top_up_max_input();
    $str .= view_row_top_up_max_principal();
    $str .= view_row_top_up_donation();
    $str .= view_row_top_up_min_deposit();
	$str .= view_row_top_up_max_deposit();
    $str .= view_row_top_up_required_directs();

    $str .= '</table>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_top_up_principal_cut(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Principal Cut (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_top_up_principal_cut"
		                              value="' .
        number_format($settings_investment->executive_top_up_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_top_up_principal_cut"
		                              value="' .
        number_format($settings_investment->regular_top_up_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_top_up_principal_cut"
		                              value="' .
        number_format($settings_investment->associate_top_up_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_top_up_principal_cut"
		                              value="' .
        number_format($settings_investment->basic_top_up_principal_cut, 5) . '"></label>
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
function view_row_top_up_compound_interest(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Compound Interest Rate (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_top_up_interest"
		                              value="' .
        number_format($settings_investment->executive_top_up_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_top_up_interest"
		                              value="' .
        number_format($settings_investment->regular_top_up_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_top_up_interest"
		                              value="' .
        number_format($settings_investment->associate_top_up_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_top_up_interest"
		                              value="' .
        number_format($settings_investment->basic_top_up_interest, 5) . '"></label>
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
function view_row_top_up_maturity(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Maturity (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_top_up_maturity"
		                              value="' .
        number_format($settings_investment->executive_top_up_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_top_up_maturity"
		                              value="' .
        number_format($settings_investment->regular_top_up_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_top_up_maturity"
		                              value="' .
        number_format($settings_investment->associate_top_up_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_top_up_maturity"
		                              value="' .
        number_format($settings_investment->basic_top_up_maturity) . '"></label>
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
function view_row_top_up_processing(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Processing (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_top_up_processing"
		                              value="' .
        number_format($settings_investment->executive_top_up_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_top_up_processing"
		                              value="' .
        number_format($settings_investment->regular_top_up_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_top_up_processing"
		                              value="' .
        number_format($settings_investment->associate_top_up_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_top_up_processing"
		                              value="' .
        number_format($settings_investment->basic_top_up_processing) . '"></label>
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
function view_row_top_up_min_input(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Minimum Input (' . settings('ancillaries')->currency . '):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_top_up_minimum"
	                              value="' .
        number_format($settings_investment->executive_top_up_minimum, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_top_up_minimum"
	                              value="' .
        number_format($settings_investment->regular_top_up_minimum, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_top_up_minimum"
	                              value="' .
        number_format($settings_investment->associate_top_up_minimum, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_top_up_minimum"
	                              value="' .
        number_format($settings_investment->basic_top_up_minimum, 8) . '"></label>
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
function view_row_top_up_max_input(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Maximum Input (' . settings('ancillaries')->currency . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_top_up_maximum"
		                              value="' .
        number_format($settings_investment->executive_top_up_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_top_up_maximum"
		                              value="' .
        number_format($settings_investment->regular_top_up_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_top_up_maximum"
		                              value="' .
        number_format($settings_investment->associate_top_up_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_top_up_maximum"
		                              value="' .
        number_format($settings_investment->basic_top_up_maximum, 8) . '"></label>
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
function view_row_top_up_max_principal(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Maximum Principal (' . settings('ancillaries')->currency . '):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_top_up_principal_maximum"
	                              value="' .
        number_format($settings_investment->executive_top_up_principal_maximum, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_top_up_principal_maximum"
	                              value="' .
        number_format($settings_investment->regular_top_up_principal_maximum, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_top_up_principal_maximum"
	                              value="' .
        number_format($settings_investment->associate_top_up_principal_maximum, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_top_up_principal_maximum"
	                              value="' .
        number_format($settings_investment->basic_top_up_principal_maximum, 8) . '"></label>
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
function view_row_top_up_donation(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Donation (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_top_up_donation"
		                              value="' .
        number_format($settings_investment->executive_top_up_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_top_up_donation"
		                              value="' .
        number_format($settings_investment->regular_top_up_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_top_up_donation"
		                              value="' .
        number_format($settings_investment->associate_top_up_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_top_up_donation"
		                              value="' .
        number_format($settings_investment->basic_top_up_donation, 5) . '"></label>
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
function view_row_top_up_min_deposit(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Minimum Deposit (' . settings('ancillaries')->currency . '):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_top_up_minimum_deposit"
	                              value="' . number_format($settings_investment->executive_top_up_minimum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_top_up_minimum_deposit"
	                              value="' . number_format($settings_investment->regular_top_up_minimum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_top_up_minimum_deposit"
	                              value="' . number_format($settings_investment->associate_top_up_minimum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_top_up_minimum_deposit"
	                              value="' . number_format($settings_investment->basic_top_up_minimum_deposit, 8) . '"></label>
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
function view_row_top_up_max_deposit(): string
{
	$settings_investment = settings('investment');

	return '<tr>
	        <td>
	            <div class="center_align">Maximum Deposit (' . settings('ancillaries')->currency . '):</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_top_up_maximum_deposit"
	                              value="' . number_format($settings_investment->executive_top_up_maximum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_top_up_maximum_deposit"
	                              value="' . number_format($settings_investment->regular_top_up_maximum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_top_up_maximum_deposit"
	                              value="' . number_format($settings_investment->associate_top_up_maximum_deposit, 8) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_top_up_maximum_deposit"
	                              value="' . number_format($settings_investment->basic_top_up_maximum_deposit, 8) . '"></label>
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
function view_row_top_up_required_directs(): string
{
    $settings_investment = settings('investment');

    return '<tr>
	        <td>
	            <div class="center_align">Required Directs:</div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="executive_top_up_required_directs"
	                              value="' . number_format($settings_investment->executive_top_up_required_directs) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="regular_top_up_required_directs"
	                              value="' . number_format($settings_investment->regular_top_up_required_directs) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="associate_top_up_required_directs"
	                              value="' . number_format($settings_investment->associate_top_up_required_directs) . '"></label>
	            </div>
	        </td>
	        <td>
	            <div class="center_align">
	                <label><input class="net_align" name="basic_top_up_required_directs"
	                              value="' . number_format($settings_investment->basic_top_up_required_directs) . '"></label>
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
function style_fast_track(): string
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
function view_fast_track(): string
{
    $settings_entry = settings('entry');

    $str = style_fast_track();

    $str .= '<table class="category table table-striped table-bordered table-hover">
		    <tr>
		        <td colspan="5"><h3 class="center_align">' . settings('plans')->fast_track_name . '</h3></td>
		    </tr>
		    <tr>
		        <td></td>
		        <td><h4 class="center_align">' . $settings_entry->executive_package_name . '</h4></td>
		        <td><h4 class="center_align">' . $settings_entry->regular_package_name . '</h4></td>
		        <td><h4 class="center_align">' . $settings_entry->associate_package_name . '</h4></td>
		        <td><h4 class="center_align">' . $settings_entry->basic_package_name . '</h4></td>
		    </tr>';

    $str .= view_row_fast_track_principal_cut();
    $str .= view_row_fast_track_fixed_interest();
    $str .= view_row_fast_track_maturity();
    $str .= view_row_fast_track_interval();
    $str .= view_row_fast_track_processing();
    $str .= view_row_fast_track_min_input();
    $str .= view_row_fast_track_max_input();
    $str .= view_row_fast_track_max_principal();
    $str .= view_row_fast_track_donation();
    $str .= view_row_fast_track_min_deposit();
	$str .= view_row_fast_track_max_deposit();
    $str .= view_row_fast_track_required_directs();

    $str .= '</table>';

    return $str;
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_row_fast_track_principal_cut(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Principal Cut (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_principal_cut"
		                              value="' .
        number_format($settings_investment->executive_fast_track_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_principal_cut"
		                              value="' .
        number_format($settings_investment->regular_fast_track_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_principal_cut"
		                              value="' .
        number_format($settings_investment->associate_fast_track_principal_cut, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_principal_cut"
		                              value="' .
        number_format($settings_investment->basic_fast_track_principal_cut, 5) . '"></label>
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
function view_row_fast_track_fixed_interest(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Fixed Interest Rate (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_interest"
		                              value="' .
        number_format($settings_investment->executive_fast_track_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_interest"
		                              value="' .
        number_format($settings_investment->regular_fast_track_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_interest"
		                              value="' .
        number_format($settings_investment->associate_fast_track_interest, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_interest"
		                              value="' .
        number_format($settings_investment->basic_fast_track_interest, 5) . '"></label>
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
function view_row_fast_track_maturity(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Maturity (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_maturity"
		                              value="' .
        number_format($settings_investment->executive_fast_track_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_maturity"
		                              value="' .
        number_format($settings_investment->regular_fast_track_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_maturity"
		                              value="' .
        number_format($settings_investment->associate_fast_track_maturity) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_maturity"
		                              value="' .
        number_format($settings_investment->basic_fast_track_maturity) . '"></label>
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
function view_row_fast_track_interval(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Interval (seconds):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_interval"
		                              value="' .
        number_format($settings_investment->executive_fast_track_interval) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_interval"
		                              value="' .
        number_format($settings_investment->regular_fast_track_interval) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_interval"
		                              value="' .
        number_format($settings_investment->associate_fast_track_interval) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_interval"
		                              value="' .
        number_format($settings_investment->basic_fast_track_interval) . '"></label>
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
function view_row_fast_track_processing(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Processing (day):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_processing"
		                              value="' .
        number_format($settings_investment->executive_fast_track_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_processing"
		                              value="' .
        number_format($settings_investment->regular_fast_track_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_processing"
		                              value="' .
        number_format($settings_investment->associate_fast_track_processing) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_processing"
		                              value="' .
        number_format($settings_investment->basic_fast_track_processing) . '"></label>
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
function view_row_fast_track_min_input(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Minimum Input (' . /*settings('ancillaries')->currency*/'pts.' . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_minimum"
		                              value="' .
        number_format($settings_investment->executive_fast_track_minimum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_minimum"
		                              value="' .
        number_format($settings_investment->regular_fast_track_minimum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_minimum"
		                              value="' .
        number_format($settings_investment->associate_fast_track_minimum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_minimum"
		                              value="' .
        number_format($settings_investment->basic_fast_track_minimum, 8) . '"></label>
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
function view_row_fast_track_max_input(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Maximum Input (' . /*settings('ancillaries')->currency*/'pts.' . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_maximum"
		                              value="' .
        number_format($settings_investment->executive_fast_track_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_maximum"
		                              value="' .
        number_format($settings_investment->regular_fast_track_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_maximum"
		                              value="' .
        number_format($settings_investment->associate_fast_track_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_maximum"
		                              value="' .
        number_format($settings_investment->basic_fast_track_maximum, 8) . '"></label>
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
function view_row_fast_track_max_principal(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Maximum Principal (' .
        /*settings('ancillaries')->currency*/'pts.' . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_principal_maximum"
		                              value="' .
        number_format($settings_investment->executive_fast_track_principal_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_principal_maximum"
		                              value="' .
        number_format($settings_investment->regular_fast_track_principal_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_principal_maximum"
		                              value="' .
        number_format($settings_investment->associate_fast_track_principal_maximum, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_principal_maximum"
		                              value="' .
        number_format($settings_investment->basic_fast_track_principal_maximum, 8) . '"></label>
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
function view_row_fast_track_donation(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Donation (%):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_donation"
		                              value="' .
        number_format($settings_investment->executive_fast_track_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_donation"
		                              value="' .
        number_format($settings_investment->regular_fast_track_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_donation"
		                              value="' .
        number_format($settings_investment->associate_fast_track_donation, 5) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_donation"
		                              value="' .
        number_format($settings_investment->basic_fast_track_donation, 5) . '"></label>
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
function view_row_fast_track_min_deposit(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Minimum Deposit (' . /*settings('ancillaries')->currency*/'pts.' . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_minimum_deposit"
		                              value="' .
        number_format($settings_investment->executive_fast_track_minimum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_minimum_deposit"
		                              value="' .
        number_format($settings_investment->regular_fast_track_minimum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_minimum_deposit"
		                              value="' .
        number_format($settings_investment->associate_fast_track_minimum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_minimum_deposit"
		                              value="' .
        number_format($settings_investment->basic_fast_track_minimum_deposit, 8) . '"></label>
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
function view_row_fast_track_max_deposit(): string
{
	$settings_investment = settings('investment');

	return '<tr>
		        <td>
		            <div class="center_align">Maximum Deposit (' . /*settings('ancillaries')->currency*/'pts.' . '):</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_maximum_deposit"
		                              value="' .
		number_format($settings_investment->executive_fast_track_maximum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_maximum_deposit"
		                              value="' .
		number_format($settings_investment->regular_fast_track_maximum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_maximum_deposit"
		                              value="' .
		number_format($settings_investment->associate_fast_track_maximum_deposit, 8) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_maximum_deposit"
		                              value="' .
		number_format($settings_investment->basic_fast_track_maximum_deposit, 8) . '"></label>
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
function view_row_fast_track_required_directs(): string
{
    $settings_investment = settings('investment');

    return '<tr>
		        <td>
		            <div class="center_align">Required Directs:</div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="executive_fast_track_required_directs"
		                              value="' .
        number_format($settings_investment->executive_fast_track_required_directs) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="regular_fast_track_required_directs"
		                              value="' .
        number_format($settings_investment->regular_fast_track_required_directs) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="associate_fast_track_required_directs"
		                              value="' .
        number_format($settings_investment->associate_fast_track_required_directs) . '"></label>
		            </div>
		        </td>
		        <td>
		            <div class="center_align">
		                <label><input class="net_align" name="basic_fast_track_required_directs"
		                              value="' .
        number_format($settings_investment->basic_fast_track_required_directs) . '"></label>
		            </div>
		        </td>
		    </tr>';
}
