<?php
session_start();
$user_name = $_POST["name"]; 
$user_pass = $_POST["password"]; 
if(isset($_POST["action"]) && $_POST["action"] == "login_user"){
  if(isset($user_name) && isset($user_pass)){
    require_once("mydb.php");
    $pdo = db_connect();
    $sql = "select name, password from users where name = :name";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":name", $user_name, PDO::PARAM_STR);
    $stmh -> execute();
    foreach($stmh as $row){
      echo count($row);
      var_dump($row["name"]);
      var_dump($row["password"]);
      if($user_name == $row["name"] && password_verify($user_pass, $row["password"])){
        if(isset($_SESSION["login_error"])){
          unset($_SESSION["login_error"]);
        }
        $_SESSION["user"] = $user_name;
        echo "OK!";
        //header("location: http://192.168.122.1/top.php");
        //exit();
      }else{
        $_SESSION["login_error"] = 1;
      }
    }
  $pdo = null;
  }else{
    echo "※値が入力されていません";
  }
}
?>
<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>login</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
<h2>ログイン</h2>
<?php
if(isset($_SESSION["login_error"])){
?>
<h2 style="color: red">ユーザー名 又は パスワードが違います</h2>
<?php
unset($_SESSION["login_error"]);
}
?>
<form method="post" action="login.php">
  <label>ユーザー名：
    <input type="text" name="name"></input></br>
  <label>パスワード：
    <input type="text" name="password"></input></br>
    <input type="hidden" name="action" value="login_user">
  <input type="submit" value="login"></input>
</form>
</body>
</html>
