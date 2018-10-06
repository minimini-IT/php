<?php
function db_connect(){
  $db_user = "root";
  $db_pass = "MiNi_0ns";
  $db_host = "localhost";
  $db_name = "CTF";
  $db_type = "mysql";
  $dsn = "$db_type:host=$db_host; dbname=$db_name; charset=utf8";

  try{
    $pdo = new pdo($dsn, $db_user, $db_pass);
    $pdo -> setAttribute(pdo::ATTR_ERRMODE, pdo::ERRMODE_EXCEPTION);
    $pdo -> setAttribute(pdo::ATTR_EMULATE_PREPARES. false);
  }catch(pdoException $Exception){
    die("エラー：" . $Exception -> getMessage());
  }
  return $pdo;
}
?>
