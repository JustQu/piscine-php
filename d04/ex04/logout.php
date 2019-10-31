<?php
	session_start();
	$_SESSION['loggued_on_user'] = NULL;
	$_SESSION['login'] = NULL;
	$_SESSION['passwd'] = NULL;
	header("Location:index.html");
?>