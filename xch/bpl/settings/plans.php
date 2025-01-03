<?php

namespace BPL\Settings\Plans;

require_once 'bpl/mods/query.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Exception\ExceptionHandler;

use function BPL\Mods\Database\Query\update as query_update;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\input_get;
use function BPL\Mods\Helpers\db;
use function BPL\Mods\Helpers\application;
use function BPL\Mods\Helpers\settings;

/**
 * @throws Exception
 * @since 2021
 */
function input(): array
{
	$inputs['account_freeze']['name'] = input_get('account_freeze_name', '', 'RAW');
	$inputs['account_freeze']['status'] = input_get('account_freeze', 0);

	$inputs['direct_referral']['name'] = input_get('direct_referral_name', '', 'RAW');
	$inputs['direct_referral']['status'] = input_get('direct_referral', 0);

	$inputs['indirect_referral']['name'] = input_get('indirect_referral_name', '', 'RAW');
	$inputs['indirect_referral']['status'] = input_get('indirect_referral', 0);

	$inputs['unilevel']['name'] = input_get('unilevel_name', '', 'RAW');
	$inputs['unilevel']['status'] = input_get('unilevel', 0);

	$inputs['binary_pair']['name'] = input_get('binary_pair_name', '', 'RAW');
	$inputs['binary_pair']['status'] = input_get('binary_pair', 0);

	$inputs['leadership_binary']['name'] = input_get('leadership_binary_name', '', 'RAW');
	$inputs['leadership_binary']['status'] = input_get('leadership_binary', 0);

	$inputs['leadership_passive']['name'] = input_get('leadership_passive_name', '', 'RAW');
	$inputs['leadership_passive']['status'] = input_get('leadership_passive', 0);

	$inputs['redundant_binary']['name'] = input_get('redundant_binary_name', '', 'RAW');
	$inputs['redundant_binary']['status'] = input_get('redundant_binary', 0);

	$inputs['royalty']['name'] = input_get('royalty_name', '', 'RAW');
	$inputs['royalty']['status'] = input_get('royalty', 0);

	$inputs['echelon']['name'] = input_get('echelon_name', '', 'RAW');
	$inputs['echelon']['status'] = input_get('echelon', 0);

	$inputs['etrade']['name'] = input_get('etrade_name', '', 'RAW');
	$inputs['etrade']['status'] = input_get('etrade', 0);

	$inputs['top_up']['name'] = input_get('top_up_name', '', 'RAW');
	$inputs['top_up']['status'] = input_get('top_up', 0);

	$inputs['fast_track']['name'] = input_get('fast_track_name', '', 'RAW');
	$inputs['fast_track']['status'] = input_get('fast_track', 0);

	$inputs['fixed_daily']['name'] = input_get('fixed_daily_name', '', 'RAW');
	$inputs['fixed_daily']['status'] = input_get('fixed_daily', 0);

	$inputs['trading']['name'] = input_get('trading_name', '', 'RAW');
	$inputs['trading']['status'] = input_get('trading', 0);

	$inputs['p2p_trading']['name'] = input_get('p2p_trading_name', '', 'RAW');
	$inputs['p2p_trading']['status'] = input_get('p2p_trading', 0);

	$inputs['p2p_commerce']['name'] = input_get('p2p_commerce_name', '', 'RAW');
	$inputs['p2p_commerce']['status'] = input_get('p2p_commerce', 0);

	$inputs['merchant']['name'] = input_get('merchant_name', '', 'RAW');
	$inputs['merchant']['status'] = input_get('merchant', 0);

	$inputs['upline_support']['name'] = input_get('upline_support_name', '', 'RAW');
	$inputs['upline_support']['status'] = input_get('upline_support', 0);

	// $inputs['passup']['name'] = input_get('passup_name', '', 'RAW');
	// $inputs['passup']['status'] = input_get('passup', 0);

	$inputs['passup_binary']['name'] = input_get('passup_binary_name', '', 'RAW');
	$inputs['passup_binary']['status'] = input_get('passup_binary', 0);

	$inputs['elite_reward']['name'] = input_get('elite_reward_name', '', 'RAW');
	$inputs['elite_reward']['status'] = input_get('elite_reward', 0);

	$inputs['harvest']['name'] = input_get('harvest_name', '', 'RAW');
	$inputs['harvest']['status'] = input_get('harvest', 0);

	$inputs['stockist']['name'] = input_get('stockist_name', '', 'RAW');
	$inputs['stockist']['status'] = input_get('stockist', 0);

	$inputs['franchise']['name'] = input_get('franchise_name', '', 'RAW');
	$inputs['franchise']['status'] = input_get('franchise', 0);

	return $inputs;
}

/**
 * @throws Exception
 * @since 2021
 */
function update()
{
	$app = application();

	$db = db();

	$inputs = input();

	$test = [];

	if (!empty($inputs)) {
		foreach ($inputs as $input) {
			foreach ($input as $value) {
				if (!empty($value) && $value !== '0' && $value !== '') {
					$test[] = $value;
				}
			}
		}
	}

	if (!empty($test)) {
		$fields = [];

		foreach ($inputs as $k => $v) {
			foreach ($v as $u => $y) {
				if ($u === 'status') {
					$fields[] = $k . ' = ' . $db->quote($y);
				} elseif ($u === 'name') {
					$fields[] = $k . '_' . $u . ' = ' . $db->quote($y);
				}
			}
		}

		try {
			$db->transactionStart();

			query_update('network_settings_plans', $fields);

			$db->transactionCommit();
		} catch (Exception $e) {
			$db->transactionRollback();
			ExceptionHandler::render($e);
		}

		$app->enqueueMessage('Compensation Plan Settings Updated Successfully!', 'success');
		$app->redirect(Uri::root(true) . '/' . sef(88));
	}
}

/**
 *
 * @return string
 *
 * @since version
 */
function view_styles(): string
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
 * @throws Exception
 *
 * @since 2021
 */
function view(): string
{
	$inputs = input();

	$settings_plans = settings('plans');

	$str = view_styles();

	$str .= '<section class="tm-top-b uk-grid" 
			data-uk-grid-match="{target:\'> div > .uk-panel\'}" data-uk-grid-margin="">
	    <div class="uk-width-1-1 uk-row-first">
	        <div class="uk-panel uk-text-center">
	            <form method="post">
	                <table class="category table table-striped table-bordered table-hover">
	                    <tr>
	                        <td colspan="3"><h3 class="center_align">Plans</h3></td>
	                    </tr>
	                    <tr>
	                        <td><h4 style="margin:0" class="center_align">Plan</h4></td>
	                        <td><h4 style="margin:0" class="center_align">Alias</h4></td>
	                        <td><h4 style="margin:0" class="center_align">Active</h4></td>
	                    </tr>';

	foreach ($inputs as $k => $v) {
		$str .= '<tr>';

		foreach ($v as $u => $y) {
			$name = ($u === 'name' ? ($k . '_' . $u) : '');
			$value = ($u === 'status' ? $k : '');

			$default = name_default();

			$str .= $name !== '' ? '<td>
                    <div class="center_align">
                        <label>' . $default[$name] . '</label>
                    </div>
                </td>
                <td>
                    <div class="center_align">
                        <label class="input_align">
							<input type="text" name="' . $name . '" style="text-align: center" value="' .
				$settings_plans->$name . '"></label>
                    </div>
                </td>' : '';

			$str .= $value !== '' ? '<td>
                    <div class="center_align">
                        <label>
                            <input type="checkbox" name="' . $value . '" id="' . $value . '" class="net_align" 
                                value="1" ' . ($settings_plans->$value ? 'checked' : '') . '></label>
                    </div>
                </td>' : '';
		}

		$str .= '</tr>';
		$str .= "\n";
	}

	$str .= '</table>
	                <input type="submit" name="submit" value="Update Settings" class="uk-button uk-button-primary">
	            </form>
	        </div>
	    </div>
	</section>';

	return $str;
}

/**
 *
 * @return string[]
 *
 * @since version
 */
function name_default(): array
{
	return [
		'account_freeze_name' => 'Account Freeze',
		'direct_referral_name' => 'Direct Referral',
		'indirect_referral_name' => 'Indirect Referral',
		'unilevel_name' => 'Unilevel',
		'binary_pair_name' => 'Binary',
		'leadership_binary_name' => 'Leadership Binary',
		'leadership_passive_name' => 'Leadership Passive',
		'redundant_binary_name' => 'Redundant Binary',
		'matrix_name' => 'Matrix',
		'power_name' => 'Power',
		'royalty_name' => 'Royalty',
		'echelon_name' => 'Echelon',
		'etrade_name' => 'Etrade',
		'top_up_name' => 'Top Up',
		'fast_track_name' => 'Fast Track',
		'fixed_daily_name' => 'Fixed Daily',
		'trading_name' => 'Trading',
		'table_matrix_name' => 'Table Matrix',
		'merchant_name' => 'Merchant',
		'upline_support_name' => 'Upline Support',
		'passup_name' => 'Passup',
		'passup_binary_name' => 'Passup Binary',
		'elite_reward_name' => 'Elite Reward',
		'stockist_name' => 'Stockist',
		'franchise_name' => 'Franchise',
		'harvest_name' => 'Harvest',
		'p2p_trading_name' => 'P2P Trading',
		'p2p_commerce_name' => 'P2P Commerce'
	];
}