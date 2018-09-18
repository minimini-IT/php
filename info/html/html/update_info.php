<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>お知らせ編集</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
<h1>編集</h1>
<a href="./index.php">戻る</a>
<a href="./top.php">トップへ戻る</a>
<?php
require_once("mydb.php");
$pdo = db_connect();
$id = $_GET["id"];
$sql = "select * from menu where id = :id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<form action="index.php" method="post" enctype="multipart/form-data">
  <label>タイトル</br>
    <input type="text" name="title" value="<?=htmlspecialchars[$row('title')]?>"></label>
  <label>作成者</br>
    <input type="text" name="name" value="<?=htmlspecialchars[$row('name')]?>"></label>
  <label>お知らせ内容</br>
    <textarea name="explanation"><?=htmlspecialchars[$row('explanation')]?></textarea></label>
  <label>ファイル</br>
    <input type="file" name="uploadfile"></label>
<?php
  //ファイルの確認
  if ($row["file"] == null){
?>
  <p>ファイルはありません</p>
<?php
  }else{
?>
  <p><?=htmlspecialchars($row["file"])?>があります。削除しますか？</p>
  <input type="radio" name="file" value="yes">はい</br>
  <input type="radio" name="file" value="no" checked>いいえ</br>
<?php
}
?>
  <input type="hidden" name="action" value="update">
  <input type="reset" value="もとに戻す">
  <input type="submit" value="送信">
</form>
<?php
}
$pdo = null;
?>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
