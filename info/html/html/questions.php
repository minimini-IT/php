<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>問題一覧</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
  <div id="exercise_back">
    <div id="exercise_menu">
      <h2>どちらの問題を作成しますか？</h2>
      <label class="exercise_menu"><a href="create_question_exercise.html">演習問題</a></label>
      <label class="exercise_menu"><a href="create_question.html">練習問題</a></label>
      <label class="exercise_menu" id="no">作成しない</label>
    </div>
  </div>
  <div class="side_menu">
    <h4>フィルタ設定</h4>
			<p id="exercise">問題作成</p>
<!--    <a href="./create_question.html">問題作成</a>-->
    <a href="./top.php">トップに戻る</a>
    <ul>
      <li>タイトル</li>
        <form>
          <input type="text">
     <li>種類</li>
        <select>
          <option>Binary</option>
          <option>Forensic</option>
          <option>Web</option>
          <option>Crypto</option>
          <option>Network</option>
          <option>Misc</option>
        </select>
      <li>点数</li>
        <select>
          <option>100</option>
          <option>300</option>
          <option>500</option>
        </select><br>
        <button>検索</button>
        </form>
      </ul>
  </div>
<?php
/*  ファイルアップロード関数    */
function upload_files(){
  if (is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "/var/www/html/files/question_file/" . $_FILES["uploadfile"]["name"])){
      chmod("files/question_file/" . $FILES["uploadfile"]["name"], 0755);
    }else{
      echo "ファイルをアップロードできませんでした。";
    }
  }
}
/*	データベース接続		*/
require_once("mydb.php");
$pdo = db_connect();
/*	問題作成		*/
if (isset($_POST["action"]) && $_POST["action"] == "insert"){
	try{
		$pdo -> beginTransaction();
		$sql = "insert into question(title, category, mark, explanation, file, answer, questions, date)values(:title, :category, :mark, :explanation, :file, :answer, :questions, :date)";
		$stmh = $pdo -> prepare($sql);
		$stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
		$stmh -> bindValue(":category", $_POST["category"], pdo::PARAM_STR);
		$stmh -> bindValue(":mark", $_POST["mark"], pdo::PARAM_INT);		
		$stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);		
		$stmh -> bindValue(":file", $_FILES["uploadfile"]["name"], pdo::PARAM_STR);	
		$stmh -> bindValue(":answer", $_POST["answer"], pdo::PARAM_STR);	
		$stmh -> bindValue(":questions", $_POST["questions"], pdo::PARAM_INT);
    $date = date("Y-m-d", time());
		$stmh -> bindValue(":date", $date, pdo::PARAM_STR);	
    $stmh -> execute();
    upload_files();
    $pdo -> commit();
  }catch(PDOException $Exception){
    $pdo -> rollBack();
    echo "エラー：" . $Exception -> getMessage();
  }
}
?>
  <h2>問題一覧</h2>
  <table>
    <tbody>
      <tr>
        <th>No.</th>
        <th>タイトル</th>
        <th>種類</th>
        <th>点数</th>
        <th>編集</th>
      </tr>
    <!-- 以下ループでテーブルにあるだけ表示 -->
<?php
$sql = "select * from question where questions = ''";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
$i = 1;
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<tr>
    <td><?=$i++?></td>
    <td><?=htmlspecialchars($row["title"])?></td>
    <td><?=htmlspecialchars($row["category"])?></td>
    <td><?=htmlspecialchars($row["mark"])?></td>
</tr>    
<?php
}
?>  
    </tbody>
  </table>
<?php
$pdo = null;
?>  
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
