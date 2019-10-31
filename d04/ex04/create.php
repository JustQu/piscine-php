<?php
	session_start();
	if ($_POST['submit'] == "OK" && (($_POST['login']) || ($_POST['login'] === "0"))&& (($_POST['passwd']) || ($_POST['passwd'] === "0")))
	{
		if (!file_exists("../private"))
			mkdir("../private");
		if (file_exists("../private/passwd"))
		{
			$data = unserialize(file_get_contents("../private/passwd"));
			foreach($data as $val)
			{
				if ($val['login'] == $_POST['login'])
				{
					echo "ERROR\n";
					return;
				}
			}
		}
		$hpass = hash("whirlpool", $_POST['passwd']);
		$data[] = array(
			'login' => $_POST['login'],
			'passwd' => $hpass
		);
		file_put_contents("../private/passwd", serialize($data));
		header("Location: index.html");
		echo "OK\n";
		return ;
	}
	echo "ERROR\n";
?>