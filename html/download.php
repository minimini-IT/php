<?php
require_once("mydb.php");
$pdo = db_connect();
if (isset($_POST["id"])){
  $id = $_POST["id"];
}
$sql = "select name, title, explanation from question where q_id = :q_id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":q_id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
  $q_title = $row["title"];
  $q_explanation = $row["explanation"];
  $q_name = $row["name"];
}
$sql = "select name from files where q_id = :q_id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":q_id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
  $file_name = $row["name"];
}
$pdo = null;
if (isset($_POST["action"])){
  //ファイルダウンロードに関する処理
  //エラーハンドラ関数の作成 〇詳しくはinfo/error_handler & php_Exception
  $errHandler = function($errno, $errstr, $errfile, $errline){
    throw new Exception($errstr, $errno);
  };
  set_error_handler($errHandler);
  //拡張子のチェック & download_dirctoryの指定
  // Download directory
  define("DOWNLOAD_DIR", "/var/download/");
  $file_path = DOWNLOAD_DIR . $file_name;
  // Directory and Extension Check  あらかじめfile変数にファイル名をいれる必要あり？
  //preg_match('#^'.DOWNLOAD_DIR.'.*\.zip$#', $file);
  if ( !preg_match('#^'.DOWNLOAD_DIR.'.*\.zip$#', $file_path)){
    trigger_error("Error: File is not permitted.");
    //trigger_error：エラーを発生させる
  }

  //ダウンロードファイルの読み込み＆出力
  //file read
  //$read_data = file_get_contents($file);
  //file_get_contents：ファイルの内容を全て文字列に読み込む

  //output HTTP header
  //以下のHTTPヘッダーで、任意のファイル名で出力内容をダウンロードさせることができる。
/* 例
header('Content-Disposition: inline; filename="'.basename($file).'"');
header('Content-Length: '.$content_length);
header('Content-Type: application/octet-stream');
 */
  header('Content-Disposition: attachment; filename='.$file_name);  //保存ファイル名
  header('Content-Length: '.filesize($file_path));  //ドキュメントサイズ
  header('Content-Type: application/force-download;');  //Documentのtype
  readfile($file_path);
}

//header("location: question.php?id=$id");
//exit();
?>
