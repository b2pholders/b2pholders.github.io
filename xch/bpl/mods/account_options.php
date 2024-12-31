<?php

namespace BPL\Mods\Options_Account;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Helpers\settings;

/**
 * @param           $account_type
 * @param           $admintype
 * @param   string  $cd_mode
 *
 * @return string
 *
 * @since version
 */
function main($account_type, $admintype, string $cd_mode = 'no_cd'): string
{
	$settings_entry = settings('entry');

//	switch ($account_type)
//	{
//		case 'executive':
//			$str = $settings_entry->executive_entry > 0 ? '<option value="executive' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->executive_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			$str .= $settings_entry->regular_entry > 0 ? '<option value="regular' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->regular_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			$str .= $settings_entry->associate_entry > 0 ? '<option value="associate' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->associate_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			$str .= $settings_entry->basic_entry > 0 ? '<option value="basic' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->basic_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			break;
//		case 'regular':
//			$str = $settings_entry->regular_entry > 0 ? '<option value="regular' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->regular_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			$str .= $settings_entry->associate_entry > 0 ? '<option value="associate' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->associate_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			$str .= $settings_entry->basic_entry > 0 ? '<option value="basic' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->basic_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			break;
//		case 'associate':
//			$str = $settings_entry->associate_entry > 0 ? '<option value="associate' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->associate_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			$str .= $settings_entry->basic_entry > 0 ? '<option value="basic' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->basic_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			break;
//		default:
//			$str = $settings_entry->basic_entry > 0 ? '<option value="basic' .
//				($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->basic_package_name .
//				($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//			break;
//	}

	$str = $settings_entry->chairman_entry > 0 ? '<option value="chairman' .
		($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->chairman_package_name .
		($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
	$str .= $settings_entry->executive_entry > 0 ? '<option value="executive' .
		($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->executive_package_name .
		($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
	$str .= $settings_entry->regular_entry > 0 ? '<option value="regular' .
		($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->regular_package_name .
		($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
	$str .= $settings_entry->associate_entry > 0 ? '<option value="associate' .
		($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->associate_package_name .
		($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
	$str .= $settings_entry->basic_entry > 0 ? '<option value="basic' .
		($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->basic_package_name .
		($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';

//	$str = $settings_entry->basic_entry > 0 ? '<option value="basic' .
//		($cd_mode === 'cd' ? '_cd' : '') . '">' . $settings_entry->basic_package_name .
//		($cd_mode === 'cd' ? ' (CD)' : '') . '</option>' : '';
//
//	if ($cd_mode === 'cd')
//	{
//		$str .= $admintype === 'Super' ? '<option value="starter">' .
//			$settings_entry->starter_package_name . '</option>' : '';
//	}

	return $str;
}