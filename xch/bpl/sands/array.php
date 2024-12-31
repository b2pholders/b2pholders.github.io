<?php

/* *
$values = ['one', 'two', 'three', 'four', 'five'];

$val_str = '';

if ($values)
{
	for ($i_i = 0; $i_i < count($values); $i_i++)
	{
		$val_str .= '?, ';
	}
}

$explode = explode(', ', $val_str);

array_pop($explode);

$implode = implode(', ', $explode);

echo $implode;
/* */

$users = [
	1  => [
		'username'  => 'user1',
		'upline_id' => 0
	],
	2  => [
		'username'  => 'user2',
		'upline_id' => 1
	],
	3  => [
		'username'  => 'user3',
		'upline_id' => 1
	],
	4  => [
		'username'  => 'user4',
		'upline_id' => 2
	],
	5  => [
		'username'  => 'user5',
		'upline_id' => 2
	],
	6  => [
		'username'  => 'user6',
		'upline_id' => 3
	],
	7  => [
		'username'  => 'user7',
		'upline_id' => 3
	],
	8  => [
		'username'  => 'user8',
		'upline_id' => 4
	],
	9  => [
		'username'  => 'user9',
		'upline_id' => 4
	],
	10 => [
		'username'  => 'user10',
		'upline_id' => 5
	],
	11 => [
		'username'  => 'user11',
		'upline_id' => 5
	],
	12 => [
		'username'  => 'user12',
		'upline_id' => 6
	],
	13 => [
		'username'  => 'user13',
		'upline_id' => 6
	],
	14 => [
		'username'  => 'user14',
		'upline_id' => 7
	],
	15 => [
		'username'  => 'user15',
		'upline_id' => 7
	]
];

// fetch downlines

$head = 1;

$children = [];

/*foreach ($users as $key => $value)
{
	if ($key == $head)
	{
		$children['username'] = $value['username'];
	}

	if ($value['upline_id'] == $head)
	{
		$children['children'] = $children;
	}
}

echo '<pre>' . print_r($children, 1) . '</pre>';*/

function get_child($head, $users, &$children)
{
	foreach ($users as $key => $value)
	{
		if ($key == $head)
		{
			$children['username'] = $value['username'];
		}

		if ($value['upline_id'] == $head)
		{
			$children['children'] = $children;
		}
	}
}

$cut = [
	1 => 5,
	2 => 3,
	3 => 2
];

//echo $cut[1];

$sum = 0;

foreach ($cut as $key => $value)
{
	$sum += $value;
}

echo $sum;