<?php

namespace Onewayhi\Sands\Database;

require_once '../lib/db_connect.php';
require_once '../mods/query_local.php';

use \Exception;
use \Onewayhi\Database\Local\Connect\Db_Connect as DB;

use function \Onewayhi\Database\Local\Query\fetch;
use function \Onewayhi\Database\Local\Query\fetch_all;
use function \Onewayhi\Database\Local\Query\crud;

/* *
$test = insert(
	'classics',
	[
		'author',
		'title',
		'category',
		'year_entry',
		'isbn'
	],
	[
		'Emily Brontë',
		'Wuthering Heights',
		'Classic Fiction',
		1847,
		9780
	]
);
/* */

$dbh = DB::connect();

//DB::backup();

/* *

try
{
	$dbh->beginTransaction();

	$author_update     = 'Emily Brontë_';
	$title_update      = 'Wuthering Heights_';
	$category_update   = 'Classic Fiction_';
	$year_entry_update = 18470;
	$isbn_update       = 97800;
	$id_update         = 5;

	crud(
		'UPDATE classics ' .
		'SET author = :author, ' .
		'title = :title, ' .
		'category = :category, ' .
		'year_entry = :year_entry, ' .
		'isbn = :isbn ' .
		'WHERE id = :id',
		[
			'author'     => $author_update,
			'title'      => $title_update,
			'category'   => $category_update,
			'year_entry' => $year_entry_update,
			'isbn'       => $isbn_update,
			'id'         => $id_update
		]
	);

	$dbh->commit();
}
catch (Exception $e)
{
	print ("Transaction failed, rolling back. Error was:\n");
	print ($e->getMessage() . "\n");

	try
	{
		$dbh->rollback();
	}
	catch (Exception $e2)
	{
	}
}
/* *

$dbh = DB::connect();

$author1     = 'Emily Brontëëëë';
$title1      = 'Wuthering Heightsëëë';
$category1   = 'Classic Fictionëëë';
$year_entry1 = 1847;
$isbn1       = 9780000;

try
{
	$dbh->beginTransaction();

	query(
		'INSERT ' .
		'INTO classics (' .
		'author, ' .
		'title, ' .
		'category, ' .
		'year_entry, ' .
		'isbn' .
		') VALUES (' .
		':author, ' .
		':title, ' .
		':category, ' .
		':year_entry, ' .
		':isbn' .
		')',
		[
			'author'     => $author1,
			'title'      => $title1,
			'category'   => $category1,
			'year_entry' => $year_entry1,
			'isbn'       => $isbn1
		]
	);

	query(
		'INSERT ' .
		'INTO classics (' .
		'author, ' .
		'title, ' .
		'category, ' .
		'year_entry, ' .
		'isbn' .
		') VALUES (' .
		':author, ' .
		':title, ' .
		':category, ' .
		':year_entry, ' .
		':isbn' .
		')',
		[
			'author'     => $author1,
			'title'      => $title1,
			'category'   => $category1,
			'year_entry' => $year_entry1,
			'isbn'       => $isbn1
		]
	);

	$dbh->commit();
}
catch (Exception $e)
{
	print ("Transaction failed, rolling back. Error was:\n");
	print ($e->getMessage() . "\n");
# empty exception handler in case rollback fails
	try
	{
		$dbh->rollback();
	}
	catch (Exception $e2)
	{
	}
}

/* *
try
{
	$dbh->beginTransaction();
	insert(
		'classics',
		[
			'author',
			'title',
			'category',
			'year_entry',
			'isbn'
		],
		[
			'Emily Brontë',
			'Wuthering Heights',
			'Classic Fiction',
			1847,
			9780
		]
	);
	insert(
		'classics',
		[
			'author',
			'title',
			'category',
			'year_entry',
			'isbn'
		],
		[
			'Emily Brontë_',
			'Wuthering Heights_',
			'Classic Fiction_',
			18470000,
			97800000
		]
	);
	$dbh->commit();
}
catch (Exception $e)
{
	try
	{
		$dbh->rollback();
	}
	catch (Exception $e2)
	{
	}
}
/* */

//$test = delete('classics', 'id = 4');

//var_dump($test);

/* *
$results = $dbh->query(
	'SELECT * ' .
	'FROM classics',
	PDO::FETCH_ASSOC
)->fetchAll();
/* */

/* *
$classics = [];

foreach ($results as $result)
{
	array_push($classics, $result['author']);
}
/* */

/* *
$results = fetch(
	'SELECT * ' .
	'FROM classics'
);

var_dump($results);
/* */

