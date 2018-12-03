<?php
require_once("mydb.php");
var_dump(password_hash($_POST["password"], PASSWORD_DEFAULT));
//ユーザー作成
if($_POST["action"] == "user_insert"){
  if(isset($_POST["name"]) && isset($_POST["password"])){
    $pdo = db_connect();
    try{
      $pdo -> beginTransaction();
      $sql = "insert into users(name, password)values(:name, :password)";
      $stmh = $pdo -> prepare($sql);
      $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
      $stmh -> bindValue(":password", password_hash($_POST["password"], PASSWORD_DEFAULT), pdo::PARAM_STR);	
      $stmh -> execute();
      $pdo -> commit();
      header("Location: http://192.168.122.1/top.php");
      exit();
    }catch(PDOException $Exception){
      $pdo -> rollBack();
      echo "エラー：" . $Exception -> getMessage();
    }
  }else{
    echo "※値が入力されていません※";
  }
}
?>

<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>ユーザー作成</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
<h2>ユーザー作成</h2>
<form method="post" action="user_add.php">
  <label>名前：
    <input type="text" name="name"></input></br>
  <label>パスワード：
    <input type="text" name="password"></input></br>
    <input type="hidden" name="action" value="user_insert">
  <input type="submit" value="作成"></input>
</form>
</body>
<?php
if(isset($pdo)){
  $pdo = null;
}
?>
</html>
