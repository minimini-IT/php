<?php
//タイトルで検索があれば
if (isset($_GET["title_search"])){
  $title_search = htmlspecialchars($_GET["title_search"]);
  $title_search_value = $title_search;
}else{
  $title_search = "";
  $title_search_value ="";
}
//種類で検索があれば
if (isset($_GET["category_search"])){
  $category_search = htmlspecialchars($_GET["category_search"]);
  $category_search_value = $category_search;
  if($category_search == "Binary"){
    $binary = "selected";
  }else if ($category_search == "Forensic"){
    $forensic = "selected";
  }else if ($category_search == "Web"){
    $web = "selected";
  }else if ($category_search == "Crypto"){
    $crypto = "selected";
  }else if ($category_search == "Network"){
    $network = "selected";
  }else if ($category_search == "Misc"){
    $misc = "selected";
  }
}else{
  $category_search = "";
  $category_search_value ="";
}
//点数で検索があれば
if (isset($_GET["mark_search"])){
  $mark_search = htmlspecialchars($_GET["mark_search"]);
  $mark_search_value = $mark_search;
  if($mark_search == "100"){
    $one = "selected";
  }else if ($mark_search == "300"){
    $three = "selected";
  }else if ($mark_search == "500"){
    $five = "selected";
  }
}else{
  $mark_search = "";
  $mark_search_value ="";
}
//ファイルアップロード関数
function upload_files(){
  for ($i = 0; $i < count($_FILES["uploadfile"]["tmp_name"]); $i++){
    //if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"][$i], "/var/www/html/files/question_file/" . $_FILES["uploadfile"]["name"][$i])){
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"][$i], "/var/download/" . $_FILES["uploadfile"]["name"][$i])){
      chmod("/var/download/" . $_FILES["uploadfile"]["name"][$i], 0755);
      //挿入したデータのid取得
      require_once("mydb.php");
      $pdo = db_connect();
      try{
        $pdo -> beginTransaction();
        $sql = "select max(q_id) from question";
        $stmh = $pdo -> query($sql);
        $id = $stmh -> fetch(pdo::FETCH_ASSOC);
        $id = array_shift($id);
        //idとファイル名をfilesに挿入
        $sql = "insert into files(q_id, name) values(:id, :file)";
        $stmh = $pdo -> prepare($sql);
        $stmh -> bindValue(":id", $id, pdo::PARAM_INT);
        $stmh -> bindValue(":file", $_FILES["uploadfile"]["name"][$i], pdo::PARAM_STR);
        $stmh -> execute();
        $pdo -> commit();
      }catch(pdoException $Exception){
        $pdo -> rollBack();
        print "イベントエラー" .$Exception -> getMessage();
      }
    }else{
      echo $_FILES["uploadfile"]["name"][$i] . "をアップロードできませんでした。";
    }
  }
}
/*データベース接続*/
require_once("mydb.php");
$pdo = db_connect();

//データベース削除
if (isset($_GET["action"]) && $_GET["action"] == "delete" && $_GET["ID"] > 0){
  try{
    $pdo -> beginTransaction();
    $q_id = $_GET["ID"];
    $sql = "delete from question where q_id = :q_id";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":q_id", $q_id, pdo::PARAM_INT);
    $stmh -> execute();
    $pdo -> commit();
  }catch(pdoException $Exception){
    $pdo -> rollBack();
    print "削除エラー：" . $Exception -> getMessage();
  }
}
/*問題作成*/
if (isset($_POST["action"]) && $_POST["action"] == "insert"){
  try{
    $pdo -> beginTransaction();
    $sql = "insert into question(title, name, category, mark, explanation, answer, questions, date)values(:title, :name, :category, :mark, :explanation, :answer, :questions, :date)";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
    $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
    $stmh -> bindValue(":category", $_POST["category"], pdo::PARAM_STR);
    $stmh -> bindValue(":mark", $_POST["mark"], pdo::PARAM_INT);		
    $stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);		
    $stmh -> bindValue(":answer", $_POST["answer"], pdo::PARAM_STR);	
    $stmh -> bindValue(":questions", $_POST["questions"], pdo::PARAM_INT);
    $date = date("Y-m-d", time());
    $stmh -> bindValue(":date", $date, pdo::PARAM_STR);	
    $stmh -> execute();
    $pdo -> commit();
  }catch(PDOException $Exception){
    $pdo -> rollBack();
    echo "エラー：" . $Exception -> getMessage();
  }
  //ファイルがあればテーブルfilesにデータを挿入
  if (is_uploaded_file($_FILES["uploadfile"]["tmp_name"][0])){
    upload_files();
  }
}
//データベース編集
if (isset($_POST["action"]) && $_POST["action"] == "update"){
  try{
    $pdo -> beginTransaction();
    $sql = "update question set title = :title, name = :name, category = :category, mark = :mark, explanation = :explanation, answer = :answer, questions = :questions, date = :date where q_id = :q_id";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":id", $_POST["q_id"], pdo::PARAM_STR);
    $stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
    $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
    $stmh -> bindValue(":category", $_POST["category"], pdo::PARAM_STR);
    $stmh -> bindValue(":mark", $_POST["mark"], pdo::PARAM_STR);
    $stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);
    $stmh -> bindValue(":answer", $_POST["answer"], pdo::PARAM_STR);
    $stmh -> bindValue(":questions", $_POST["questions"], pdo::PARAM_STR);
    $date = date("Y-m-d", time());
    $stmh -> bindValue(":time", $date, pdo::PARAM_STR);
    $stmh -> execute();
    $pdo -> commit();
  }catch(PDOException $Exception){
    $pdo -> rollBack();
    echo "エラー：" . $Exception -> getMessage();
  }
  //ファイルがあれば
  if (is_uploaded_file($_FILES["uploadfile"]["tmp_name"][$i])){
    upload_files();
  }
  if (isset($_POST["file_delete"][0])){
    $num = count($_POST["file_delete"]);
    for ($i = 0; $i < $num; $i++){
      try{
        $pdo -> beginTransaction();
        $sql = "delete from files where name = :name";
        $stmh = $pdo -> prepare($sql);
        $stmh -> bindValue(":name", $_POST["file_delete"][$i], PDO::PARAM_STR);
        $stmh -> execute();
        $pdo -> commit();
        unlink("/var/download/".$_POST["file_delete"][$i]);
      }catch(pdoException $Exception){
        $pdo -> rollBack();
        print "イベントエラー" .$Exception -> getMessage();
      }
    }    
  }
}
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
  <div id="exercise_back">
    <div id="exercise_menu">
      <h2>どちらの問題を作成しますか？</h2>
      <!--<label class="exercise_menu"><a href="create_question_exercise.html">演習問題</a></label>-->
      <label class="exercise_menu" id="exercise_question_create">演習問題</label>
      <label class="exercise_menu"><a href="create_question.html">練習問題</a></label>
      <label class="exercise_menu" id="no">作成しない</label>
    </div>
    <div id="confirmation">
      <h2>既存の問題集に追加しますか？</h2>
      <label class="exercise_menu" id="confirmation_yes">はい</label>
      <label class="exercise_menu" id="confirmation_no">いいえ</label>
    </div>
    <div id="exercise_questions_select">
      <h2>問題集を選択してください</h2>
      <form method="post" action="create_question_exercise.php"> 
        <select name="title">
<?php
$sql = "select title from exercise";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
          <option value="<?=htmlspecialchars($row['title'])?>"><?=htmlspecialchars($row['title'])?></option>
<?php
}
?>
        </select>
        <input type="submit" value="送信">
      </form>
    </div>
  </div>
  <div class="side_menu">
    <h4>フィルタ設定</h4>
    <p id="exercise">問題作成</p>
    <a href="./top.php">トップに戻る</a>
    <form action="questions.php" method="get">
    <ul>
      <li>タイトル</li>
      <input type="text" name="title_search" value="<?=htmlspecialchars($title_search)?>">
      <li>種類</li>
        <select name="category_search">
          <option></option>
          <option <?=htmlspecialchars($binary)?>>Binary</option>
          <option <?=htmlspecialchars($forensic)?>>Forensic</option>
          <option <?=htmlspecialchars($web)?>>Web</option>
          <option <?=htmlspecialchars($crypto)?>>Crypto</option>
          <option <?=htmlspecialchars($network)?>>Network</option>
          <option <?=htmlspecialchars($misc)?>>Misc</option>
        </select>
      <li>点数</li>
        <select name="mark_search">
          <option></option>
          <option <?=htmlspecialchars($one)?>>100</option>
          <option <?=htmlspecialchars($three)?>>300</option>
          <option <?=htmlspecialchars($five)?>>500</option>
        </select><br>
      <input type="submit" value="検索">
    </ul>
    </form>
    <a href="questions.php">検索結果を戻す</a>
  </div>
  <h2>問題一覧</h2>
  <table>
    <tbody>
      <tr>
        <th>No.</th>
        <th>タイトル</th>
        <th>作成者</th>
        <th>種類</th>
        <th>点数</th>
        <th>編集</th>
        <th>削除</th>
      </tr>
    <!-- 以下ループでテーブルにあるだけ表示 -->
<?php
$sql = "select q_id, title, name, category, mark from question where title like '%$title_search%' and category like '%$category_search%' and mark like '%$mark_search%' and questions is null order by q_id";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
$i = 1;
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<tr>
    <td><?=$i++?></td>
    <td><a href="question.php?id=<?=htmlspecialchars($row['q_id'])?>" target="_blank"><?=htmlspecialchars($row["title"])?></a>
    <td><?=htmlspecialchars($row["name"])?></td>
    <td><?=htmlspecialchars($row["category"])?></td>
    <td><?=htmlspecialchars($row["mark"])?></td>
    <td><a href="update_question.php?id=<?=htmlspecialchars($row['q_id'])?>">編集</a></td>
    <td><a onclick="return confirm('<?=htmlspecialchars($row['title'])?>を削除してもよろしいですか？')"; href="questions.php?action=delete&ID=<?=htmlspecialchars($row['q_id'])?>">削除</a></td>
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
