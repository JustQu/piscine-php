<?php
function auth($login, $passwd){
    $path = "../private/passwd";
    $contents = unserialize(file_get_contents($path));
    foreach($contents as $key => $value){
        if ($value['login'] === $login){
            if ($value['passwd'] == hash('whirlpool', $passwd)){
                return true;
            }
            return false;
        }
    }
    return false;
}
?>