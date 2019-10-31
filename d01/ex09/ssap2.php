#! /usr/bin/php
<?PHP

function compare($a, $b)
{
	$i = 0;
        $a = strtolower($a);
        $b = strtolower($b);
        while ($a[$i] == $b[$i] && $a[$i])
            $i++;
        if (ctype_alpha($a[$i]) && ctype_alpha($b[$i]))
            return (ord($a[$i]) - ord($b[$i]));
        elseif (ctype_alpha($a[$i]) && !ctype_alpha($b[$i]))
            return (-1);
        elseif (ctype_digit($a[$i]) && ctype_digit($b[$i]))
            return (ord($a[$i]) - ord($b[$i]));
        elseif (ctype_digit($a[$i]) && !ctype_digit($b[$i]) && !ctype_alpha($b[$i]))
            return -1;
        elseif (!ctype_alpha($a[$i]) && !ctype_alpha($b[$i]) && !ctype_digit($b[$i]) && !ctype_digit($a[$i]))
            return (ord($a[$i]) - ord($b[$i]));
        else
            return (1);
        return (0);
}

if ($argc == 1)
	return 1;

foreach ($argv as $key => $arg) {
	if ($key == 0)
		continue;
	$tmp = explode(" ", trim($arg));
	foreach ($tmp as $t){
		$arr[] = $t;
	}
}

usort($arr, compare);

foreach ($arr as $a)
	echo $a . "\n";
?>