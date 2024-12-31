<?php

namespace Onewayhi\Mods\Settings_Profit_Share;

function main($type = 'basic', $value = 'entry')
{
	$settings = [];

	switch ($type)
	{
		case 'executive':
			$settings['entry']      = 132;
			$settings['width']      = 2;
			$settings['principal']  = 1200 / 50;
			$settings['processing'] = 1;
			break;
		case 'regular':
			$settings['entry']      = 66;
			$settings['width']      = 2;
			$settings['principal']  = 5000 / 50;
			$settings['processing'] = 1;
			break;
		case 'associate':
			$settings['entry']      = 33;
			$settings['width']      = 2;
			$settings['principal']  = 0;
			$settings['processing'] = 0;
			break;
		default:
			$settings['entry']      = 10;
			$settings['width']      = 2;
			$settings['principal']  = 0;
			$settings['processing'] = 0;
			break;
	}

	return $settings[$value];
}