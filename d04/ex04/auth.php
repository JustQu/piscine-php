<?php
	function auth($login, $passwd)
	{
		if (!file_exists("../private/passwd"))
			return false;
		$data = unserialize(file_get_contents("../private/passwd"));
		foreach($data as $val)
		{
			if ($val['login'] == $login)
			{
				if ($val['passwd'] == hash("whirlpool", $passwd))
					return true;
				break;
			}
		}
		return false;
	}
?>