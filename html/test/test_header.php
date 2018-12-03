<?php
if (isset($_POST["action"])){
  require_once("testdb.php");
  $pdo = db_connect();
  $sql = "select name from test where id = :id";
  $stmh = $pdo -> prepare($sql);
  $stmh -> bindValue(":id", $_POST["id"], PDO::PARAM_STR);
  $stmh -> execute();
  $row = $stmh -> fetch(PDO::FETCH_ASSOC);

  $pdo = null;

  $file_path = dirname(__FILE__)."/test/";
  $file_name = $row["name"];
  //echo $file_path . $file_name;
  //echo "\n";
  //echo filesize($file_path.$file_name);
  //$file = file_exists($file_path.$file_name);
    //file_exists -> ファイルが存在するか確認
  
  header('Content-Disposition: attachment; filename='.$file_name);  //保存ファイル名
  header('Content-Length: '.filesize($file_path . $file_name));  //ドキュメントサイズ
  header('Content-Type: application/force-download;');  //Documentのtype
  
  readfile($file_path.$file_name);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>file download</title>
</head>
<body>
  <form action="test_header.php" method="post">
    <input type="hidden" name="id" value=1>
    <input type="hidden" name="action" value="download">
    <input type="submit" value="ダウンロード">
  </form>
</body>
</html>

