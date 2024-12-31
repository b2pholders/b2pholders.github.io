<?php

echo '<ul>';
main(2);
echo '</ul>';

echo '<ul>';
main(3);
echo '</ul>';

function main($user_id)
{
	$db = new PDO('mysql:host=localhost;dbname=sands_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare(
		'SELECT * ' .
		'FROM `binary` ' .
		'WHERE `id` = :id'
	);
	$st->execute(['id' => $user_id]);

	$user = $st->fetch(PDO::FETCH_OBJ);

	// show main
	if ($user)
	{
		echo '<li><a href="javascript:void(0)">' . $user->id . '</a></li>';

		// left
		if ($user->downline_left_id != 0)
		{
			main($user->downline_left_id);
		}

		// right
		if ($user->downline_right_id != 0)
		{
			main($user->downline_right_id);
		}
	}
}