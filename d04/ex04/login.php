<?php
	include 'auth.php';
	session_start();
	if (($_POST['login'] || $_POST['login'] === "0") && ($_POST['passwd'] || $_POST['passwd'] === "0"))
	{
		if (auth($_POST['login'], $_POST['passwd']))
		{
			$_SESSION['loggued_on_user'] = $_POST['login'];
			?>
			<html>
			<head>
			<meta charset="UTF-8">
			<title>42Chat</title>
			<style>
			#koko {
				background-color: pink;
				background-image: url(https://psv4.userapi.com/c856424/u62671918/docs/d9/d83303c98b4a/3812512_1.png?extra=o4UFghjUB-V5szR0DRtQgdb069ckfp4xK05vpf-nvz7fSzr7tchcTwiiH-QQWAjG7VlkhuYj5zan3hhYlxP66El_SKICIo-KcZRtshTIf8tzGvJb8lb1E6bjYjKc_bZhGAu0n-1JpRt-sGkyXRK0et0);
				background-repeat: repeat;
			}
			</style>
			</head><body>
			<iframe id="koko" name="chat" src="chat.php" width="100%" height="550px"></iframe>
			<iframe name="speak" src="speak.php" width="100%" height="50px"></iframe>
			<span><a href="logout.php">LOGOUT</a></span>
			</body>
			</html>
			<?php
			return;
		}
	}
	$_SESSION['loggued_on_user'] = "";
	echo "ERROR\n";
?>