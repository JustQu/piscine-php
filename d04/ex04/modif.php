<?php
	if ($_POST['submit'] == "OK" &&
		($_POST['login'] || $_POST['login'] === "0") &&
		($_POST['oldpw'] || $_POST['oldpw'] === "0") &&
		($_POST['newpw'] || $_POST['newpw'] === "0") &&
		file_exists("../private/passwd"))
	{
		$finded = false;
		if (!file_exists("../private"))
			mkdir("../private");
		$data = unserialize(file_get_contents("../private/passwd"));
		foreach($data as $key => $val)
		{
			if ($val['login'] == $_POST['login'])
			{
				if ($val['passwd'] == hash("whirlpool", $_POST['oldpw']))
				{
					$finded = true;
					$val['passwd'] = hash("whirlpool", $_POST['newpw']);
					$data[$key] = $val;
				}
				break;
			}
		}
		if ($finded)
		{
			file_put_contents("../private/passwd", serialize($data));
			header("Location: index.html");
			echo "OK\n";
			return ;
		}
	}
	echo "ERROR\n";
?>