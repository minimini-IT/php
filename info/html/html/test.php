<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>php mysql</title>
</head>
<body>
<?php
require_once("mydb.php");
$pdo = db_connect();
$sql = "select * from menu where id = 1";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
  if ($row["name"] == null){
    echo "null";
  }elseif ($row["name"] == ""){
    echo "ダブルクォーテーション";
  }else{
    echo "そのた";
  }
}
$pdo = null;
?>
</body>
</html>
