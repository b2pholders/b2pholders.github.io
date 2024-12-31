<?php

namespace BPL\Mods\Time_Remaining_To_Activate;

require_once 'bpl/mods/seconds_to_time.php';
require_once 'bpl/mods/helpers.php';

use Exception;

use function BPL\Mods\Seconds_To_Time\main as seconds_to_time;

use function BPL\Mods\Helpers\settings;
use function BPL\Mods\Helpers\user;

/**
 * @param $user_id
 *
 * @return string|null
 *
 * @since version
 */
function main($user_id): ?string
{
	$grace_period = settings('ancillaries')->grace_period;

	$remaining = user($user_id)->date_registered + $grace_period * 86400 - time();

	if ($remaining > 0)
	{
		try
		{
			return '<span style="color: red">You have ' .
				seconds_to_time($remaining) . ' to Activate Your Account!' . '</span>';
		}
		catch (Exception $e)
		{

		}
	}

	return null;
}