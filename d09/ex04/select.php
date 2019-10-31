<?php
	$data = file_get_contents("list.csv");
	file_put_contents("list.csv", '');
	$data = array_filter(explode("\n", $data));
	foreach($data as $value){
		$text = explode(";", $value, 2);
		$return = $return . $text[1] . "\n";
	}
	echo $return;
?>