<?php
	switch ($_GET['action']) {
		case 'set':
			if ($_GET['name'] && ($_GET['value'])){
				setcookie($_GET['name'], $_GET['value']);
			}
			break;
		case 'get':
			if ($_GET['name'] && ($_COOKIE[$_GET['name']])){
				echo $_COOKIE[$_GET['name']] . "\n";
			}
			break;
		case 'del':
			if($_GET['name']){
				setcookie($_GET['name'], '', 1);
			}
			break;
	}
?>