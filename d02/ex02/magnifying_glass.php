#! /usr/bin/php
<?php

if ($argc < 2 || !file_exists($argv[1]))
		exit();
	$read = fopen($argv[1], 'r');
	$text = "";
    while ($read && !feof($read)) {
        $text .= fgets($read);
    }

$text =  preg_replace_callback('/(<a.*?title=)(.*?)(>)(.*?)(<\/a>)/', function($match) {
	return $match[1] . strtoupper($match[2]) . $match[3] . strtoupper($match[4]) . $match[5];
}, $text);

$text = preg_replace_callback('/(<a.*?>)(.*?)(<)/', function($match) {
	return $match[1] . strtoupper($match[2]) . $match[3] . strtoupper($match[4]) . $match[5];
}, $text);


echo $text;
?>