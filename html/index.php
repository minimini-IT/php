<?php
//タイトルで検索があれば
if (isset($_GET["title_search"])){
  $title_search = htmlspecialchars($_GET["title_search"]);
  $title_search_value = $title_search;
}else{
  $title_search = "";
  $title_search_value ="";
}
//作成者で検索があれば
if (isset($_GET["name_search"])){
  $name_search = htmlspecialchars($_GET["name_search"]);
  $name_search_value = $name_search;
}else{
  $name_search = "";
  $name_search_value ="";
}
//ファイルアップロード関数
function upload_files(){
  for ($i = 0; $i < count($_FILES["uploadfile"]["tmp_name"]); $i++){
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"][$i], "/var/www/html/files/menu_file/" . $_FILES["uploadfile"]["name"][$i])){
      chmod("/var/www/html/files/menu_file/" . $_FILES["uploadfile"]["name"][$i], 0755);
      //挿入したデータのid取得
      require_once("mydb.php");
      $pdo = db_connect();
      try{
        $pdo -> beginTransaction();
        $sql = "select max(id) from menu";
        $stmh = $pdo -> query($sql);
        $stmh -> execute();
        $id = $stmh -> fetch(pdo::FETCH_ASSOC);
        $id = array_shift($id);
        //idとファイル名をfilesに挿入
        $sql = "insert into files(m_id, name) values(:id, :file)";
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
//データベース接続
require_once("mydb.php");
$pdo = db_connect();

//データベース削除
if (isset($_GET["action"]) && $_GET["action"] == "delete" && $_GET["ID"] > 0){
  try{
    $pdo -> beginTransaction();
    $id = $_GET["ID"];
    $sql = "delete from menu where id = :id";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":id", $id, pdo::PARAM_INT);
    $stmh -> execute();
    $pdo -> commit();
  }catch(pdoException $Exception){
    $pdo -> rollBack();
    print "削除エラー：" . $Exception -> getMessage();
  }
}

//データベース挿入
if (isset($_POST["action"]) && $_POST["action"] == "insert"){
  try{
    //テーブルmenuにデータを挿入
    $pdo -> beginTransaction();
    $sql = "insert into menu(title, name, explanation, time)values(:title, :name, :explanation, :time)";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
    $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
    $stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);
    $date = date("Y-m-d", time());
    $stmh -> bindValue(":time", $date, pdo::PARAM_STR);
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
    $sql = "update menu set title = :title, name = :name, explanation = :explanation, time = :time where id = :id";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":id", $_POST["id"], pdo::PARAM_STR);
    $stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
    $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
    $stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);
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
        unlink("/var/www/html/files/menu_file/".$_POST["file_delete"][$i]);
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
  <title>お知らせ</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
  <h1> インフォメーション </h1>
  <div class="side_menu">
    <a href="./top.php">トップに戻る</a>
    <a href="./index_insert.php">お知らせ作成</a>
    <p>検索</p>
    <form action="index.php" method="get">
      <label>タイトル：</label>
      <input type="text" name="title_search" value="<?php echo $title_search_value ?>"></br>
      <label>作成者：</label>
      <input type="text" name="name_search" value="<?php echo $name_search_value ?>"></br>
      <input type="submit" value="検索">
    </form>
  </div>
    <table>
      <tbody>
        <tr>
          <th>No.</th>
          <th>タイトル</th>
          <th>作成者</th>
          <th>日時</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
<!-- データベースにあるだけループで取得 -->
<?php
$i = 1;
$sql = "select id, title, name, time from menu where title like '%$title_search%' and name like '%$name_search%' order by id";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
          <td><?=$i++?></td>
          <td><a href="info.php?id=<?=htmlspecialchars($row['id'])?>"><?=htmlspecialchars($row["title"])?></a></td>
          <td><?=htmlspecialchars($row["name"])?></td>
          <td><?=htmlspecialchars($row["time"])?></td>
          <td><a href="update_info.php?id=<?=htmlspecialchars($row['id'])?>">編集</a></td>
          <td><a onclick="return confirm('<?=htmlspecialchars($row['title'])?>を削除してもよろしいですか？')"; href="index.php?action=delete&ID=<?=htmlspecialchars($row['id'])?>">削除</a></td>
        </tr>
<?php
}
$pdo = null;
?>
      </tbody>
    </table>
  <script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
