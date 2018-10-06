<?php
//require_once("testdb.php");
//$pdo = db_connect();
//try{
//  $pdo -> beginTransaction();
//  $sql = "insert into test(name) values(:name)";
//  $stmh = $pdo -> prepare($sql);
//  $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
//  $stmh -> execute();
//  $sql = "select max(id) from test";
//  $stmh = $pdo -> query($sql);
//  $id = $stmh -> fetch(pdo::FETCH_ASSOC); //配列で取得 
//  $id = array_shift($id); //配列の先頭を取得
//  $pdo -> commit();
//}catch(PDOException $Exception){
//  $pdo -> rollBack();
//  echo "エラー：" . $Exception -> getMessage();
//}
$get = $_GET["test"];
if ($get == "test1"){
  $a = "selected";
}else if($get == "test2"){
  $b = "selected";
}else if($get == "test3"){
  $c = "selected";
}else if($get == "test4"){
  $d = "selected";
}  
  
?>
<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>php mysql</title>
</head>
<body>
<form action="test.php" method="get">
  <select name="test">
    <option value="test1" <?=htmlspecialchars($a)?>>test1</option>
    <option value="test2" <?=htmlspecialchars($b)?>>test2</option>
    <option value="test3" <?=htmlspecialchars($c)?>>test3</option>
    <option value="test4" <?=htmlspecialchars($d)?>>test4</option>
  </select>
  <input type="submit" name="送信">
</form>
<?php
var_dump($get);
?>
</body>
</html>
