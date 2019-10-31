#! /usr/bin/php
<?PHP

if ($argc == 1)
	return 1;

foreach ($argv as $key => $arg) {
	if ($key == 0)
		continue;
	$tmp = array_filter(explode(' ', $arg));
	foreach ($tmp as $t){
		$array[] = $t;
	}
}

sort($array, SORT_STRING);

foreach ($array as $elem)
	echo $elem . "\n";
?>