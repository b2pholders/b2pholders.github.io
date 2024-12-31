<?php

namespace BPL\Mods\Savings_Transfer_History;

require_once 'bpl/mods/helpers.php';

use function BPL\Mods\Url_SEF\qs;
use function BPL\Mods\Url_SEF\sef;

use function BPL\Mods\Helpers\user;

/**
 * @param $user_transfers
 *
 * @return string
 *
 * @since version
 */
function view_row_transfers($user_transfers): string
{
	$str = '';

	foreach ($user_transfers as $transfer)
	{
		$transfer_from = user($transfer->transfer_from);
		$transfer_to = user($transfer->transfer_to);

		$str .= '<tr><td>' . date('M j, Y - g:i A', $transfer->date) . '</td>';
		$str .= '<td><a href="' . sef(44) . qs() . 'uid=' . $transfer_from->id . '">' .
			$transfer_from->username . '</a></td>';
		$str .= '<td><a href="' . sef(44) . qs() . 'uid=' . $transfer_to->id . '">' .
			$transfer_to->username . '</a></td>';
		$str .= '<td>' . number_format($transfer->amount, 5) . ' ' .
			/*settings('ancillaries')->efund_name .*/ '</td></tr>';
	}

	return $str;
}