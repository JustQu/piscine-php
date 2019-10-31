#! /usr/bin/php
<?PHP
if ($argc > 1)
{
	$first_word = strtok($argv[1], ' ');
	$argv[1] = str_replace($first_word, "", $argv[1]);
	$argv[1] = trim($argv[1]);
	$first_word = $argv[1] . " " . $first_word . "\n";
	$first_word = ltrim($first_word);
	echo $first_word;
}
?>