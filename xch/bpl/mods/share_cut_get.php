<?php

namespace BPL\Mods\Share_Cut_Get;

/**
 * @param   string  $account_type
 * @param           $level
 * @param   object  $settings
 *
 * @return array
 *
 * @since version
 */
function main(string $account_type, $level, object $settings): array
{
	$cut = [];

	for ($i_i = 1; $i_i <= $level; $i_i++)
	{
		$share     = $settings->{$account_type . '_upline_support_share_' . $i_i};
		$share_cut = $settings->{$account_type . '_upline_support_share_cut_' . $i_i};

		$cut[$i_i] = $share * $share_cut / 100 / 100;
	}

	return $cut;
}