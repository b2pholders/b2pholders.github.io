<?php

$server = $_SERVER['SERVER_NAME'];
$base   = 'onewayhi';

$remove = [];

if (!empty($base))
{
	array_push($remove, $base);
}

if (!empty($server))
{
	array_push($remove, $server);
}

$raw_parts = explode('/', $_SERVER['REQUEST_URI']);
unset($raw_parts[0]);

$request = $_SERVER['SERVER_NAME'] . '/' . implode('/', $raw_parts);

var_dump($request);

$parts = explode('/', $request);

var_dump($parts);

foreach ($remove as $value)
{
	if (($key = array_search($value, $parts)) !== false)
	{
		unset($parts[$key]);
	}
}

var_dump($parts);

$s = array_pop(array_reverse($parts));

var_dump($s);