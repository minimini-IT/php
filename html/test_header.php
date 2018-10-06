<?php
if (isset($_POST["action"])){
  $file_path = dirname(__FILE__)."/test/";
  $file_name = "test.zip";
  //echo $file_path . $file_name;
  //echo "\n";
  //echo filesize($file_path.$file_name);
  //$file = file_exists($file_path.$file_name);
  
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
    <input type="hidden" name="action" value="download">
    <input type="submit" value="ダウンロード">
  </form>
</body>
</html>

