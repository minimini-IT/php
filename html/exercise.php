<?php
//問題集のタイトルで検索があれば
if (isset($_GET["title_search"])){
  $title_search = htmlspecialchars($_GET["title_search"]);
  $title_search_value = $title_search;
}else{
  $title_search = "";
  $title_search_value ="";
}
//演習フラグon
session_start();
if(empty($_SESSION["exercise"])){
  $_SESSION["exercise"]= "on";
}
var_dump($_SESSION["exercise"]);
require_once("mydb.php");
$pdo = db_connect();
?>
<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>問題一覧</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
    <h1>演習問題集</h1>
    <div class="side_menu">
      <h4>フィルタ設定</h4>
      <a href="./top.php">トップに戻る</a>
      <form action="exercise.php" method="get">
        <ul>
          <li>タイトル</li>
          <input type="text" name="title_search" value="<?=htmlspecialchars($title_search)?>">
          <input type="submit" value="検索">
        </ul>
      </form>
      <a href="exercise.php">検索結果を戻す</a>
    </div>
  <table>
    <tbody>
      <tr>
        <th>No.</th>
        <th>タイトル</th>
        <th>問題数</th>
      </tr>
<?php
$sql = "select exercise.title, count(question.title) from exercise inner join question using(questions) where exercise.title like '%$title_search%' group by exercise.title";
$stmh = $pdo -> query($sql);
$i = 1;
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<tr>
    <td><?=$i++?></td>
    <td><a href="" target="_blank"><?=htmlspecialchars($row["title"])?></a>
    <td><?=htmlspecialchars($row["count(question.title)"])?></td>
</tr>    
<?php
}
?>  
    </tbody>
  </table>
  <script type="text/javascript" src="./jquery.js"></script>
</body>
</html>
