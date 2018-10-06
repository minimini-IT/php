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
//numにファイルの個数入れる
$sql = "select count(name) from files where m_id = :id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":id", $id, PDO::PARAM_INT);
$stmh -> execute();
$num = $stmh -> fetch(pdo::FETCH_ASSOC);
$num = array_shift($num);

$sql = "select * from menu where id = :id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<form action="index.php" method="post" enctype="multipart/form-data">
  <label>タイトル：
    <input type="text" name="title" value="<?=htmlspecialchars($row['title'])?>"></label></br>
  <label>作成者：
    <input type="text" name="name" value="<?=htmlspecialchars($row['name'])?>"></label></br>
  <label>お知らせ内容</br>
    <textarea name="explanation"><?=nl2br(htmlspecialchars($row['explanation']))?></textarea></label></br>
  <label>ファイル：
    <input type="file" name="uploadfile[]" multiple></label></br>
<p style="color: red">※複数ファイルを選択する場合は同フォルダ内にアップロードしたいファイルを入れてください</p>
<p style="color: red">複数選択はShiftかCtrlを押しながら</p>
<?php
}
//ファイルの確認
if ($num > 0){
?>
  <p>ファイルが<?=htmlspecialchars($num)?>個あります。</p>
<?php
  $sql = "select name from files where m_id = :id";
  $stmh = $pdo -> prepare($sql);
  $stmh -> bindValue(":id", $id, PDO::PARAM_INT);
  $stmh -> execute();
  while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
      <p><?=htmlspecialchars($row["name"])?></p>
      <input type="checkbox" name="file_delete[]" value="<?=htmlspecialchars($row['name'])?>">削除
      </br>
<?php
  }
}else{
?>
<p>ファイルはありません</p>
<?php
}
?>
  <input type="hidden" name="action" value="update">
  <input type="hidden" name="id" value="<?=htmlspecialchars($id)?>">
  <input type="reset" value="もとに戻す">
  <input type="submit" value="送信">
</form>
<?php
$pdo = null;
?>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
