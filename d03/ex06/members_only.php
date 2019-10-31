<?php
	if( $_SERVER['PHP_AUTH_USER'] == 'Guest' && $_SERVER['PHP_AUTH_PW'] == 'lol1'){
		$pic = file_get_contents("../img/42.png");
		echo "<html><body><img src=\"data:image/png;base64," . base64_encode($pic)."\"</img></body></html>\n";
	}
	else{	
		header('HTTP/1.0 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="User Visible Realm"');
		echo "<html><body>That area is accessible for members only</body></html>\n";
	}
