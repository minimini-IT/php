<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>問題一覧</title>
</head>
<body>
<?php
/*  ファイルアップロード関数    */
function upload_files(){
  if (is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "/var/www/html/files/" . $_FILES["uploadfile"]["name"])){
      chmod("files/" . $FILES["uploadfile"]["name"], 0755);
      echo $_FILES["uploadfile"]["name"] . "をアップロードしました。";
    }else{
      echo "ファイルをアップロードできませんでした。";
    }
  }
}
/*	データベース接続		*/
require_once("mydb.php");
$pdo = db_connect();
/*	問題作成		*/
if(isset($_POST["action"]) && $_POST["action"] == "insert"){
	try{
		$pdo -> beginTransaction();
		$sql = "insert into question(title, category, explanation, file)values(:title, :category, :explanation, :file)";
		$stmh = $pdo -> prepare($sql);
		$stmh -> bindValue(":title", $_POST["title"], pdo::PARAM_STR);
		$stmh -> bindValue(":category", $_POST["category"], pdo::PARAM_STR);
		$stmh -> bindValue(":explanation", $_POST["explanation"], pdo::PARAM_STR);		
		$stmh -> bindValue(":file", $_FILES["uploadfile"]["name"], pdo::PARAM_STR);	
    $stmh -> execute();
    upload_files();
    $pdo -> commit();
    
  }catch(PDOException $Exception){
    $pdo -> rollBack();
    echo "エラー：" . $Exception -> getMessage();
  }
}
?>
<table>
<tbody>
<?php
$sql = "select * from question";
$stmh = $pdo -> prepare($sql);
$stmh -> execute();
$i = 1;
while($row = $stmh -> fetch(pdo::FETCH_ASSOC)){
?>
<tr>
    <td><?=$i++?></td>
    <td><?=htmlspecialchars($row["title"])?></td>
    <td><?=htmlspecialchars($row["category"])?></td>
    <td><?=htmlspecialchars($row["explanation"])?></td>
    <td><a href="files/<?=htmlspecialchars($row["file"])?>"><?=htmlspecialchars($row["file"])?></a></td>
</tr>    
<?php
}
$pdo = null;
?>  
</tbody>
</table>
</body>
</html>
