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
      <label class="exercise_menu" id="no">いいえ</label>
    </div>
    <div id="exercise_form">
      <label>ユーザ名：</label>
      <input type="text" name="username"></br>
      <label>チーム名：</label>
      <input type="text" name="team"></br>
      <input type="submit" value="送信">
    </div>
  </div>
  <div class="side_menu">
    <div class="menu">
    <p>メニュー</p>
    </div>
    <ul>
      <li><a href="questions.php">問題一覧</a></li>
      <li><a href="index.php">おしらせ</a></li>
      <li><label id="exercise">演   習</label></li>
      <li><a href="support.html">演習状況</a></li>
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
        <th>詳細</th>
      </tr>
<?php
require_once("mydb.php");
$pdo = db_connect();
/*  最新の問題3件表示 */
$sql = "select title, category, mark, date from question where questions = '' order by q_id desc limit 3";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
      <tr>
        <td><?=htmlspecialchars($row["title"])?></td>
        <td><?=htmlspecialchars($row["category"])?></td>
        <td><?=htmlspecialchars($row["mark"])?></td>
        <td><?=htmlspecialchars($row["date"])?></td>
        <td><a href="">詳細</a></td>
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
          <th>詳細</th>
        </tr>
<?php
$sql = "select id, title, name, time from menu order by id desc limit 3";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
      <tr>
        <td><?=htmlspecialchars($row["title"])?></td>
        <td><?=htmlspecialchars($row["name"])?></td>
        <td><?=htmlspecialchars($row["time"])?></td>
        <td><a href="info.php?id=<?=htmlspecialchars($row['id'])?>">詳細</a></td>
      </tr>
<?php
}
?>
      </tbody>
    </table>
  <h2>演習の状況</h2>
<?php
if ($exercise == 0){
?>
      <p>現在演習は行われておりません</p>
<?php
}elseif ($exercise == 1){
?>
      <p>演習NOW！！</p>
      <a href="support.html">見に行く</a>
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
