<?php
session_start();
unset($_SESSION["exercise"]);
header("Location: http://192.168.122.1/top.php");
exit();
?>
