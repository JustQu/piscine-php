<?php
session_start();
if ($_SESSION['loggued_on_user'] || $_SESSION['loggued_on_user'] === "0"){
    echo $_SESSION['loggued_on_user'] . "\n";
}
else {
    echo "ERROR\n";
}
?>