#! /usr/bin/php
<?php

date_default_timezone_set('Europe/Moscow');
$str = $argv[1];

$days = [
	0 => "/^[lL]undi$/",
	1 => "/^[mM]ardi$/" ,
	2 => "/^[mM]ercredi$/",
	3 => "/^[jJ]eudi$/",
	4 => "/^[vV]endredi$/",
	5 => "/^[sS]amedi$/",
	6 => "/^[dD]imanche$/"
];

$months = [
	0 => "/^[Jj]anvier$/",
	1 => "/^[Ff]evrier$/",
	2 => "/^[Mm]ars$/",
	3 => "/^[Aa]vril$/",
	4 => "/^[Mm]ai$/",
	5 => "/^[Jj]uin$/",
	6 => "/^[Jj]uillet$/",
	7 => "/^[Aa]out$/",
	8 => "/^[Ss]eptembre$/",
	9 => "/^[Oo]ctobre$/",
	10 => "/^[Nn]ovembre$/",
	11 => "/^[Dd]ecembre$/"
];


$data = explode(' ', $str);

if (count($data) == 0){
	echo "Wrong Format\n";
	return -1;
}

foreach ($data as $key => $e){
	$e = trim($e);
}

/* DayOfWeek NumberOfDay Month Year Hours:Minutes:Seconds */ 

/* Hours:Minutes:Seconds */ 
if (preg_match('/^(?:[01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $data[4]) == 0){
	echo "Wrong Format\n";
	return -1;
}

$time = explode(":", $data[4]);

/* Year */
/* 0000-9999*/
if (preg_match('/^[0-9]{4}$/', $data[3]) == 0){
	echo "Wrong Format\n";
	return -1;
}

/* {01-31} | {1 - 9}
/* NumberOfDay */
if (preg_match('/^([12]\d|3[01]|0?[1-9])$/', $data[1]) == 0){
	echo "Wrong Format\n";
	return -1;
}

$correct = false;
foreach($days as $key => $day){
	if (preg_match($day, $data[0])){
		$correct = true;
		$data[0] = $key;
	}
}
if ($correct === false){
	echo "Wrong Format\n";
	return -1;
}

$correct = false;
foreach($months as $key => $month){
	if (preg_match($month, $data[2])){
		$correct = true;
		$data[2] = $key;
	}
}
if ($correct === false){
	echo "Wrong Format\n";
	return -1;
}

if (($a = mktime($time[0], $time[1], $time[2], $data[2] + 1, $data[1], $data[3])) === false){
	echo "Wrong Format\n";
	return -1;
}
if (date("N", $a) != $data[0] + 1){
	echo "Wrong Format\n";
	return -1;
}
echo $a."\n";
?>