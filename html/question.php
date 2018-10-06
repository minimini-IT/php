<?php
require_once("mydb.php");
$pdo = db_connect();
$id = $_GET["id"];
$sql = "select title, explanation from question where q_id = :q_id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":q_id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
  $q_title = $row["title"];
  $q_explanation = $row["explanation"];
}
$sql = "select name from files where q_id = :q_id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":q_id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
  $f_title = $row["title"];
  $f_explanation = $row["explanation"];
}
//ファイルダウンロードに関する処理
//エラーハンドラ関数の作成 〇詳しくはinfo/error_handler & php_Exception
$errHandler = function($errno, $errstr, $errfile, $errline){
  throw new Exception($errstr, $errno);
};
set_error_handler($errHandler);

//拡張子のチェック & download_dirctoryの指定
// Download directory
define("DOWNLOAD_DIR", "/var/download");

// Directory and Extension Check  あらかじめfile変数にファイル名をいれる必要あり？
if (!preg_match('#^'.DOWNLOAD_DIR.'.*\.zip$#', $file)){
  trigger_error("Error: File is not permitted."); //trigger_error：エラーを発生させる
}
//ダウンロードファイルの読み込み＆出力
//file read
$read_data = file_get_contents($file); //file_get_contents：ファイルの内容を全て文字列に読み込む

//output HTTP header
//以下のHTTPヘッダーで、任意のファイル名で出力内容をダウンロードさせることができる。
header('Content-Disposition: inline; filename="'.basename($file).'"');
header('Content-Length: '.$content_length);
header('Content-Type: application/octet-stream');

//output file data
echo $read_data;

?>
<!DOCTYPE html>
<html>
<head>
<!--  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">-->
  <title><?=htmlspecialchars($q_title)?></title>
<!--  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">-->
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
<h1><?=htmlspecialchars("$q_title")?></h1>
<?php
$sql = "select * from question where q_id = :id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
  <p><?=htmlspecialchars($row["name"])?>より</p></br>
  <p><?=htmlspecialchars($row["explanation"])?></p>
  <p>回答形式：CTF{CTF_XXXXXXXXX}</p>
<?php
}
$sql = "select name from files where q_id = :id";
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
  <script src="./bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
