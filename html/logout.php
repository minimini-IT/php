<?php
session_start();
unset($_SESSION["user"]);
header("Location: http://192.168.122.1/login.php");
exit();
?>
