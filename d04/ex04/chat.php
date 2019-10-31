<?php
	date_default_timezone_set('Europe/Moscow');
	if (!file_exists("../private"))
		mkdir("../private");
	$fd = fopen("../private/chat", "r+");
	flock($fd, LOCK_SH);
	$data = unserialize(file_get_contents("../private/chat"));
	if ($data !== false)
		foreach ($data as $key => $value)
			echo "[" . date("G:i", $value['time']) . "] " . "<b>" . $value['login'] . "</b>: " . $value['msg'] . "<br />";
	flock($fd, LOCK_UN);
	fclose($fd);
?>