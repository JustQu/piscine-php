<?php
	file_put_contents(
		"list.csv",
		$_POST['id'] . ';' . $_POST['dat'] . PHP_EOL,
		FILE_APPEND);
?>