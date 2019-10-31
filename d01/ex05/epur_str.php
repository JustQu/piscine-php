#! /usr/bin/php
<?PHP
if ($argc != 2)
	return;
$str = $argv[1];
$str = trim($str);
while (substr_count($str, "  ") > 0){
	$str = str_replace("  ", " ", $str);
}
echo $str . "\n";
?>
