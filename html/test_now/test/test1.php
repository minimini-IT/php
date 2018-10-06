/*	データベース接続	    */
<?php
require_once("mydb.php");
$pdo = db_connect();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>test</title>
</head>
<body>
<?php
$sql = "select * from test";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
?>

<p><?=htmlspecialchars($stmh)?></p>



/*	データベース切断		*/
<?php
  }
$pdo = null;
?>

</body>
</html>
