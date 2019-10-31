<?php
	$arr = file("list.csv");
	file_put_contents("list.csv", '');
	foreach ($arr as $key => $value) {
		if ($_POST['id'] == strtok($value, ';')){
			unset($arr[$key]);
			continue;
		}
		file_put_contents("list.csv", $value, FILE_APPEND);
	}
?>