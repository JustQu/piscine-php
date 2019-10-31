#! /usr/bin/php
<?PHP

function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        return substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

if ($argc != 2){
	echo "Incorrect Parameters\n";
	return -1;
}
$sign = 0;
$a = trim($argv[1]);

$num1 = floatval($a);

if ($a[0] == '-' || $a[0] == '+'){
	if ($a[0] == '-')
		$sign = -1;
	else if($a[0] == '+'){
		$sign = 1;
	}
	$a = substr($a, 1);
}

$a = ltrim($a, "0");

if ($num1 == -0){
	$a = substr($a, 1);
}

if ($num1 < 1 && $num1 > 0){
	$a = "0" . $a;
}
elseif ($num1 < 0 && $num1 > -1){
	$a = "0" . $a;
}

if ($num1 == -0){
	$a = "0" . $a;
}

if ($sign == -1)
	$a = "-" . $a;

if (($pos = strpos($a, "$num1")) !== 0){
	echo "Syntax error\n";
	return -1;
}

$a = substr_replace($a, "", $pos, strlen($num1));

$a = trim($a);
$op = $a[0];

$a = substr($a, 1);
$a = trim($a);
$a = ltrim($a, "0");

$sign = 0;

$num2 = floatval($a);

if ($a[0] == '-' || $a[0] == '+'){
	if ($a[0] == '-')
		$sign = -1;
	else if($a[0] == '+'){
		$sign = 1;
	}
	$a = substr($a, 1);
}

$a = ltrim($a, "0");

if ($num2 == -0){
	$a = substr($a, 1);
}

if ($num2 < 1 && $num2 > 0){
	$a = "0" . $a;
}
elseif ($num2 < 0 && $num2 > -1){
	$a = "0" . $a;
}

if ($num2 == -0){
	$a = "0" . $a;
}

if ($sign == -1)
	$a = "-" . $a;

if (($pos = strpos($a, "$num2")) !== 0){
	echo "Syntax error\n";
	return -1;
}
$a = substr_replace($a, "", $pos, strlen($num2));

$a = trim($a);

if (strlen($a) > 0){
	echo "Syntax error\n";
	return -1;
}

if ($op == "+"){
	echo $num1 + $num2 . "\n";
}
elseif ($op == "-"){
	echo $num1 - $num2 . "\n";
}
elseif ($op == "*"){
	echo $num1 * $num2 . "\n";
}
elseif ($op == "/"){
	echo $num1 / $num2 . "\n";
}
elseif ($op == "%"){
	echo $num1 % $num2 . "\n";
}
else{
	echo "Syntax error\n";
	return -1;
}
return 0;
?>
