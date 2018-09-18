<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>お知らせ作成</title>
  <link rel="stylesheet" type="text/css" href="coding.css">
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
  <h1>お知らせ作成</h1>
  <a href="./index.php">お知らせに戻る</a>
  <a href="./top.php">トップに戻る</a>
  <form action="index.php" method="post" enctype="multipart/form-data">
    <ul>
      <li>タイトル</li>
        <input type="text" name="title">
      <li>作成者</li>
        <input type="text" name="name">
      <li>お知らせ内容</li>
        <textarea name="explanation"></textarea>
      <li>ファイル</li>
        <input type="file" name="uploadfile">
    </ul>
    <input type="hidden" name="action" value="insert">
    <input type="submit" value="送信">
 </form>
<script type="text/javascript" src="./jQuery.js"></script>
</body>
</html>
