<?php
$questions_title = $_POST["title"];
require_once("mydb.php");
$pdo = db_connect();
$sql = "select questions from exercise where title = :title";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":title", $questions_title, pdo::PARAM_SYR);
$stmh -> execute();
foreach($stmt as $row){
  $questions_number = int($row["questions"]);
}
?>
<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>問題作成</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
  <h1>問題作成</h1>
  <a href="./top.php">トップに戻る</a>
  <form action="questions.php" method="post" enctype="multipart/form-data">
    <ul>
      <li>タイトル</li>
        <input type="text" name="title">
      <li>種類</li>
        <select name="category">
          <option>Binary</option>
          <option>Forensic</option>
          <option>Web</option>
          <option>Crypto</option>
          <option>Network</option>
          <option>Misc</option>
        </select>
      <li>点数</li>
        <select name="mark">
          <option>100</option>
          <option>300</option>
          <option>500</option>
        </select>
      <li>問題文</li>
        <textarea cols=40 rows=10 name="explanation"></textarea>
      <!--<li>演習問題集番号</li>
        <input type="text" name="questions" placeholder="半角数字入力">-->
      <li>ファイル</li>
        <input type="file" name="uploadfile[]" multiple>
      <li>解答</li>
        <input type="text" name="answer">
    </ul>
  <input type="hidden" name="action" value="insert">
  <input type="hidden" name="questions" value="<?=htmlspecialchars($questions_number)?>">
  <input type="submit" value="送信">
  </form>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
