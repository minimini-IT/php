<?php
require_once("mydb.php");
$pdo = db_connect();
?>

<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>test</title>
</head>
<body>
<?php
$sql = "select * from test";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
$result = $stmh -> fetch()
//while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<p><?=htmlspecialchars($result["name"])?></p>
<!--<p><?=htmlspecialchars($stmh["age"])?></p>-->
<?php
//}
?>
</body>
<?php
$pdo = null;
?>
</html>
