<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>test</title>
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
<?php
$i = $_POST[$i];
if($i == 100){
?>
<p>iは100</p>
<p><?=htmlspecialchars($i)?></p>
<?php
}else{
?>
<p>通信できてない</p>
<?php
}
?>
<script type="text/javascript" src="./jstest.js"></script>
</body>
</html>
