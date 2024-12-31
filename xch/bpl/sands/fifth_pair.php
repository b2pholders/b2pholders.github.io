<?php

$tmp_pairs = 14;
$tmp_pairs_safety = 3;
$pairs_add_limited = 1;

$old = $tmp_pairs - $tmp_pairs % $tmp_pairs_safety;
$new = $tmp_pairs + $pairs_add_limited - ($tmp_pairs + $pairs_add_limited) % $tmp_pairs_safety;

$nth_pair = +(
		/*($tmp_pairs_today_total + $pairs_add_actual) <= $tmp_max_cycle
		&&*/
		$tmp_pairs_safety > 0
		&&
		$new > $old
	) * ($new - $old) / $tmp_pairs_safety;

echo $nth_pair;