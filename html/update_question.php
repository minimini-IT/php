<?php
$id = $_GET["id"];
require_once("mydb.php");
$pdo = db_connect();
$sql = "select * from question where q_id = :q_id";
$stmh = $pdo -> prepare($sql);
$stmh -> bindValue(":q_id", $id, PDO::PARAM_INT);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
  $q_title = $row["title"];
  $q_name = $row["name"];
  $q_category = $row["category"];
  $q_mark = $row["mark"];
  $q_explanation = $row["explanation"];
  $q_answer = $row["answer"];
  $q_questions = $row["questions"];
}
if($q_category == "Binary"){
  $binary = "selected";
}else if ($q_category == "Forensic"){
  $forensic = "selected";
}else if ($q_category == "Web"){
  $web = "selected";
}else if ($q_category == "Crypto"){
  $crypto = "selected";
}else if ($q_category == "Network"){
  $network = "selected";
}else if ($q_category == "Misc"){
  $misc = "selected";
}

if($q_mark == "100"){
  $one = "selected";
}else if ($q_mark == "300"){
  $three = "selected";
}else if ($q_mark == "500"){
  $five = "selected";
}
?>
<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>問題編集</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
  <h1>問題編集</h1>
  <a href="./top.php">トップに戻る</a>
  <form action="questions.php" name="form1" method="post" enctype="multipart/form-data">
    <ul>
      <li>題名</li>
      <input type="text" name="title" value="<?=htmlspecialchars($q_title)?>">
      <li>作成者</li>
        <input type="text" name="name" value="<?=htmlspecialchars($q_name)?>">
      <li>種類</li>
        <select name="category">
          <option <?=htmlspecialchars($binary)?>>Binary</option>
          <option <?=htmlspecialchars($forensic)?>>Forensic</option>
          <option <?=htmlspecialchars($web)?>>Web</option>
          <option <?=htmlspecialchars($crypto)?>>Crypto</option>
          <option <?=htmlspecialchars($network)?>>Network</option>
          <option <?=htmlspecialchars($misc)?>>Misc</option>
        </select>
      <li>点数</li>
        <select name="mark">
          <option <?=htmlspecialchars($one)?>>100</option>
          <option <?=htmlspecialchars($three)?>>300</option>
          <option <?=htmlspecialchars($five)?>>500</option>
        </select>
      <li>問題文</li>
        <textarea cols=40 rows=10 name="explanation"><?=htmlspecialchars($q_explanation)?></textarea>
      <li>ファイル</li>
        <input type="file" name="uploadfile[]" multiple>
      <li>解答</li>
        <input type="text" name="answer" value="<?=htmlspecialchars($q_answer)?>">
    </ul>
    <input type="hidden" name="questions" value="<?=htmlspecialchars($q_questions)?>">
    <input type="hidden" name="action" value="insert">
    <input type="submit" value="送信">
  </form>
<script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
