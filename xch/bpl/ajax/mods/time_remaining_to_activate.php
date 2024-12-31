<?php

namespace BPL\Ajax\Mods\Time_Remaining_To_Activate;

use Exception;

use function BPL\Mods\Seconds_To_Time\main as seconds_to_time;

use function BPL\Mods\Local\Helpers\settings;
use function BPL\Mods\Local\Helpers\user;

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

main($user_id);

/**
 * @param $user_id
 *
 *
 * @since version
 */
function main($user_id)
{
	$grace_period = settings('ancillaries')->grace_period;

	$remaining = user($user_id)->date_registered + $grace_period * 86400 - time();

	if ($remaining > 0)
	{
		try
		{
			echo '<span style="color: red">You have ' .
				seconds_to_time($remaining) . ' to Activate Your Account!' . '</span>';
		}
		catch (Exception $e)
		{

		}
	}
}