<?php
	session_start();
?>
<script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
<?php
	date_default_timezone_set('Europe/Moscow');
	if ($_SESSION['loggued_on_user'] || $_SESSION['logged_on_user'] === "0" && $_POST['submit'])
	{
		if (!file_exists("../private"))
			mkdir("../private");
		if (!file_exists("../private/chat"))
			$fd = fopen("../private/chat", "w+");
		else
			$fd = fopen("../private/chat", "r+");
		flock($fd, LOCK_EX);
		$data = unserialize(file_get_contents("../private/chat"));
		$array['login'] = $_SESSION['loggued_on_user'];
		$array['time'] = time();
		$array['msg'] = $_POST['msg'];
		if ($array['msg'] != "")
		{
			$data[] = $array;
			file_put_contents("../private/chat", serialize($data));
		}
		flock($fd, LOCK_UN);
		fclose($fd);
	}
?>
<html>
	<head>
	<script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
		</head>
<style>
	form input{
		width: 45%;
		height: 30px;
		margin:0;
		padding:0;
		background-color: rgb(221, 117, 117);
		color: white;
		border: none;
		text-align: center;
	}
	body
	{
		background-color: pink;
	}
	#popa
	{

		margin-left: 10px;
		box-shadow: 0 0px 5px black;
	}

	</style>
<form action="speak.php" method="post">
<input type="text" name="msg">
<input id = popa type="submit" name="submit" value="SEND">
</form>
</html>