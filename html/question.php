<?php
require_once("mydb.php");
$pdo = db_connect();
if (isset($_GET["id"])){
  $id = $_GET["id"];
}elseif (isset($_POST["id"])){
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
<h1><?=htmlspecialchars($q_title)?></h1>
<p><?=htmlspecialchars($q_name)?>より</p></br>
<p><?=htmlspecialchars($q_explanation)?></p>
<p>回答形式：CTF{CTF_XXXXXXXXX}</p>

<?php
if(isset($file_name)){
?>
<form action="download.php" method="post">
  <input type="hidden" name="id" value="<?=htmlspecialchars($id)?>">
  <input type="hidden" name="action" value="download">
  <input type="submit" value="ダウンロード">
</form>
<?php
}
$pdo = null;
?>

  <script src="./bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
