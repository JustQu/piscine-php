#! /usr/bin/php
<?PHP

if ($argc != 4){
	echo "Incorrect parameters\n";
	return -1;
}

$a = trim($argv[1]);

$b = trim($argv[3]);

$op = trim($argv[2]);
if ($op == "+"){
	echo $a + $b . "\n";
}
elseif ($op == "-"){
	echo $a - $b . "\n";
}
elseif ($op == "*"){
	echo $a * $b . "\n";
}
elseif ($op == "/"){
	echo $a / $b . "\n";
}
elseif ($op == "%"){
	echo $a % $b . "\n";
}

?>