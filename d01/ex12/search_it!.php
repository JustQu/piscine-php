#! /usr/bin/php
<?PHP
	if ($argc < 3){
		return -1;
	}
	foreach ($argv as $key => $arg){
		if ($key == 0 || $key == 1){
			continue;
		}
		$arr = explode(':', $arg);
		if (count($arr) != 2){
			continue;
		}
		if ($argv[1] == $arr[0]){
			$val = $arr[1];
		}
	}
if (isset($val)){
	echo $val."\n";
}
?>