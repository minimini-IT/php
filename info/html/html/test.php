<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>javascript -> php</title>
  <script src="./jquery-3.3.1.min.js"></script>
</head>
<body>
<?php
$exercise = ($_POST["exercise"]);
if ($exercise == 0){
?>
<p id="exercise_start">演習開始</p>
<?php
print($exercise);
}elseif ($exercise == 1){
?>
<p>演習中</p>
<p id="exercise_end">演習終了</p>
<?php
}
?>
<script type="text/javascript" src="./jstest.js"></script>
</body>
</html>
