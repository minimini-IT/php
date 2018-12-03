<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>if_test</title>
</head>
<body>
<h1>if_test</h1>
<?php
$test = "default";
echo $test;
var_dump($test);
var_dump(!empty($test));
if(!empty($test)){
?>
<h1>true</h1>
<form action="download.php" method="post">
  <input type="hidden" name="id" value="1">
  <input type="hidden" name="action" value="download">
  <input type="submit" value="ダウンロード">
</form>
<?php
}
?>
<h1>if after</h1>
</body>
</html>
