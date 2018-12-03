<?php
session_start();
var_dump($_SESSION["exercise"]);
var_dump($_SESSION["user"]);
?>
<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>CTFチャレンジ</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
  <header>CTFチャレンジ</header>
  <div id="exercise_back">
    <div id="exercise_menu">
      <h2>演習を開始しますか？</h2>
      <label class="exercise_menu" id="yes">はい</label>
      <label class="exercise_menu" id="no">いいえ</label></br>
    </div>
    <div id="exercise_form">
      <form action="exercise.php" method="post">
        <label>ユーザ名：</label>
        <input type="text" name="username"></br>
        <label>チーム名：</label>
        <input type="text" name="team"></br>
        <input type="submit" value="送信">
      </form>
      <a href="top.php">戻る</a>
    </div>
    <div>
      <div id="end_exercise_form">
        <h2>演習を終了しますか？</h2>
        <label><a href="end_exercise.php">はい</a></label>
        <label id="end_exercise_no">いいえ</label>
      </div>
    </div>
  </div>
  <div class="side_menu">
    <div class="menu">
    <p>メニュー</p>
    </div>
    <ul>
      <li><a href="questions.php">問題一覧</a></li>
      <li><a href="index.php">おしらせ</a></li>
<?php
if ($_SESSION["exercise"] == "on"){
?>
      <li><label id="exercise_on">演   習</label></li>
<?php
}else{
?>
      <li><label id="exercise">演   習</label></li>
<?php
}
if ($_SESSION["exercise"] == "on"){
?>
      <li><label id="end_exercise">演習をおわる</label></li>
<?php
}
?>
      <li><a href="support.html">演習状況</a></li>
      <li><a href="logout.php">ログアウト</a></li>
     </ul>
  </div>
  <div class="main_menu">
    <h3>最新の問題</h3>
    <table>
      <tbody>
      <tr>
        <th>タイトル</th>
        <th>カテゴリー</th>
        <th>点数</th>
        <th>作成日時</th>
      </tr>
<?php
require_once("mydb.php");
$pdo = db_connect();
/*  最新の問題3件表示 */
$sql = "select q_id, title, category, mark, date from question where questions is null order by q_id desc limit 3";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
      <tr>
        <td><a href="question.php?id=<?=htmlspecialchars($row['q_id'])?>" target="_blank"><?=htmlspecialchars($row["title"])?></td>
        <td><?=htmlspecialchars($row["category"])?></td>
        <td><?=htmlspecialchars($row["mark"])?></td>
        <td><?=htmlspecialchars($row["date"])?></td>
      </tr>
<?php
}
?>
      </tbody>
    </table>
    <h3>最新のお知らせ</h3>
    <table>
      <tbody>
        <tr>
          <th>タイトル</th>
          <th>作成者</th>
          <th>更新時間</th>
        </tr>
<?php
$sql = "select id, title, name, time from menu order by id desc limit 3";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
      <tr>
        <td><a href="info.php?id=<?=htmlspecialchars($row['id'])?>"><?=htmlspecialchars($row["title"])?></a></td>
        <td><?=htmlspecialchars($row["name"])?></td>
        <td><?=htmlspecialchars($row["time"])?></td>
      </tr>
<?php
}
?>
      </tbody>
    </table>
  <h2>演習の状況</h2>
<?php
if($_SESSION["exercise"] == "on"){
?>
  <p>演習NOW！！</p>
  <a href="support.html">見に行く</a>
<?php
}else{
?>
  <p>現在演習は行われておりません</p>
<?php
}
?>
  </div>
<?php
$pdo = null;
?>
<script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
