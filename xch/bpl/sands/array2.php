<?php

$array['test']  = ['test1', 'test2'];
$array['test1'] = ['test3', 'test4'];
$array['test2'] = ['test5', 'test6'];
$array['test3'] = [];
$array['test4'] = [];
$array['test5'] = [];
$array['test6'] = [];

echo '<pre>';
print_r($array);
echo '</pre>';

function populate($parent, $array, &$children)
{
	if ($array[$parent])
	{
		$children[$parent] = [];

		foreach ($array[$parent] as $child)
		{
			array_push($children[$parent], $child);
			populate($child, $array[$parent], $children[$parent]);
		}
	}
}

$parent = 'test';

$children = [];

populate('test1', $array, $children);

echo '<pre>';
print_r($children);
echo '</pre>';