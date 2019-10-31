#! /usr/bin/php
<?PHP
if ($argc < 2)
	return;
$str = $argv[1];
$str = trim($str);
$str = preg_replace('/[ \t]+/', ' ', $str);
echo $str."\n";
?>