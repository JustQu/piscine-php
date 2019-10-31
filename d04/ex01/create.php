<?php
	$path = "../private";
	$pathtofile = "../private/passwd";
	if (!($_POST['submit'] == "OK" &&
		(($_POST['login']) || ($_POST['login'] === "0")) &&
		(($_POST['passwd']) || ($_POST['passwd'] === "0")))){
		echo "ERROR\n";
		return -1; 
	}
	$file = array();
	if (!file_exists($path))
		mkdir($path);
	if (file_exists($pathtofile))
		$file = unserialize(file_get_contents($pathtofile));
	foreach($file as $value){
		if ($value['login'] === $_POST['login']){
			echo "ERROR\n";
			return;
		}
	}
	$user['login'] = $_POST['login'];
	$user['passwd'] = hash("whirlpool", $_POST['passwd']);
	$file[] = $user;
	if (file_put_contents($pathtofile, serialize($file)) === false){
		echo "ERROR\n";
		return;
	}
	echo "OK\n";
?>
