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
require_once("mydb.php");
$i = 1;
$pdo = db_connect();
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
