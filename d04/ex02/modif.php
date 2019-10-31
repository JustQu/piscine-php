<?php
	if (!($_POST['submit'] == "OK" &&
    (($_POST['login']) || ($_POST['login'] === "0")) &&
    (($_POST['oldpw']) || ($_POST['oldpw'] === "0")) &&
    (($_POST['newpw']) || ($_POST['newpw'] === "0")))){
    echo "ERROR\n";
    return;
}

$path = "../private/passwd";
$file = unserialize(file_get_contents($path));
foreach($file as $key => $value){
    if ($value['login'] === $_POST['login']){
        if ($value['passwd'] == hash('whirlpool', $_POST['oldpw'])){
            $value['passwd'] = hash('whirlpool', $_POST['newpw']);
            $file[$key] = $value;
            file_put_contents($path, serialize($file));
            echo "OK\n";
            return;
        }
        break;
    }
}
echo "ERROR\n";
?>