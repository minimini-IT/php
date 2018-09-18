<?php
if (isset($_GET["title_search"])){
  $title_search = htmlspecialchars($_GET["title_search"]);
  $title_search_value = $title_search;
}else{
  $title_search = "";
  $title_search_value ="";
}
if (isset($_GET["name_search"])){
  $name_search = htmlspecialchars($_GET["name_search"]);
  $name_search_value = $name_search;
}else{
  $name_search = "";
  $name_search_value ="";
}
//ファイルアップロード関数
function upload_files(){
  if (is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "/var/www/html/files/menu_file/" . $_FILES["uploadfile"]["name"])){
      chmod("files/menu_file/" . $FILES["uploadfile"]["name"], 0755);
    }else{
      echo "ファイルをアップロードできませんでした。";
    }
  }
}
//データベース接続
require_once("mydb.php");
$pdo = db_connect();

//データベース挿入
if (isset($_POST["action"]) && $_POST["action"] == "insert"){
  try{
    $pdo -> beginTransaction();
    $sql = "insert into menu(title, name, explanation, time, file)values(:title, :name, :explanation, :time, :file)";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
    $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
    $stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);
    $stmh -> bindValue(":file", $_FILES["uploadfile"]["name"], pdo::PARAM_STR);
    $date = date("Y-m-d", time());
    $stmh -> bindValue(":time", $date, pdo::PARAM_STR);
    $stmh -> execute();
    upload_files();
    $pdo -> commit();
  }catch(PDOException $Exception){
    $pdo -> rollBack();
    echo "エラー：" . $Exception -> getMessage();
  }
}
//データベース編集
if (isset($_POST["action"]) && $_POST["action"] == "update"){
  try{
    $pdo -> beginTransaction();
    $sql = "update menu set title = :title, name = :name, explanation = :explanation, file = :file where id = :id";
    $stmh = $pdo -> prepare($sql);
    $stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
    $stmh -> bindValue(":name", $_POST["name"], pdo::PARAM_STR);
    $stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);
    $stmh -> bindValue(":file", $_FILES["uploadfile"]["name"], pdo::PARAM_STR);

    //  お知らせ編集機能
    //  ファイルをそのままDBに挿入すると上書きされるかな？
    //    確認・対策・追加ってできるかな？
    //  update_indo.phpで各お知らせ記事に対するファイルを削除するかどうか聞いたので、
    //    削除するならファイルの削除をする
    //    ファイル追加するならする



    $date = date("Y-m-d", time());
    $stmh -> bindValue(":time", $date, pdo::PARAM_STR);
    $stmh -> execute();
    upload_files();
    $pdo -> commit();
  }catch(PDOException $Exception){
    $pdo -> rollBack();
    echo "エラー：" . $Exception -> getMessage();
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
          <th>詳細</th>
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
          <td><?=htmlspecialchars($row["title"])?></td>
          <td><?=htmlspecialchars($row["name"])?></td>
          <td><?=htmlspecialchars($row["time"])?></td>
          <td><a href="info.php?id=<?=htmlspecialchars($row['id'])?>">詳細</a></td>
          <td><a href="update_info.php?id=<?=htmlspecialchars($row['id'])?>">編集</a></td>
          <td><a onclick="return confirm('削除してもよろしいですか？')"; href="index.php?action=delete&ID=<?=htmlspecialchars($row['id'])?>">削除</a></td>
        </tr>
<?php
}
$pdo = null;
?>
      </tbody>
    </table>
  <script type="text/javascript" src="./jquery.js"></script>
</body>
</html>
