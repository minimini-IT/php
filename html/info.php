<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>お知らせ詳細</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
<?php
require_once("mydb.php");
$pdo = db_connect();
?>
</head>
<body>
<h1>詳細</h1>
<a href="./index.php">戻る</a>
<a href="./top.php">トップへ戻る</a>
<?php
$id = $_GET["id"];
$sql = "select * from menu where id = :id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
  <h2><?=htmlspecialchars($row["title"])?></h2></br>
  <label><?=htmlspecialchars($row["time"])?></label>
  <p><?=htmlspecialchars($row["name"])?>より</p></br>
  <p><?=htmlspecialchars($row["explanation"])?></p>
<?php
}
$sql = "select name from files where m_id = :id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
  <a href="files/menu_file/<?=htmlspecialchars($row['name'])?>"><?=htmlspecialchars($row['name'])?></a>
<?php
}  
$pdo = null;
?>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
