<?php

echo "<table>\n";

foreach (new DirectoryIterator('../jumi') as $file)
{
	$file = '<?php require_once \'bpl/jumi/' . $file . '\';';

	echo '<tr><td>' . htmlentities($file) . "</td></tr>\n";
}

echo '</table>';

/*echo "<table>\n";

foreach (new DirectoryIterator('../jumi') as $file)
{
	// remove .php at the end of the file
	$file = substr_replace($file, '', strpos($file, '.php'));

	$file = explode('_', $file);
	$file = ucwords(implode(' ', $file));

	echo '<tr><td>' . htmlentities($file) . "</td></tr>\n";
}

echo '</table>';*/