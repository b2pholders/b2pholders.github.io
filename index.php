<?php

require_once './xch/bpl/lib/Db_Connect.php';
require_once './xch/bpl/mods/query_local.php';

use function BPL\Mods\Local\Database\Query\fetch;
use function BPL\Mods\Local\Database\Query\fetch_all;

$s = !empty($_GET['s']) ? $_GET['s'] : false;

$root = '';
$http = 'http';

if (!$s) {
	$url = $http . '://' . $_SERVER['HTTP_HOST'] . $root . '/home/index.html';

	header('location: ' . $url);
	exit;
}

$sa = fetch('SELECT * ' . 'FROM network_settings_ancillaries');

$results = fetch_all(
	'SELECT username ' .
	'FROM network_users'
);

if (!empty($results)) {
	foreach ($results as $result) {
		if ($result->username === $s) {
			$url = $http . '://' . $_SERVER['HTTP_HOST'] . $root . '/xch/' .
				($sa->payment_mode === 'CODE' ? 'registration' : 'join') . '?s=' . $result->username;

			header('location: ' . $url);
			exit;
		}
	}
}