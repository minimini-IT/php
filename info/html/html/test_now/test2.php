<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>test</title>
  <link rel="stylesheet" type="text/css" href="./test.css">
  <script src="../jquery-3.3.1.min.js"></script>
</head>
<body>
  <div id="exercise_menu">
  <h2>演習を開始しますか？</h2>
 <!-- <form action="test2.php" method="post">
    <input class="exercise_menu" type="submit" value="はい">
    <input type="hidden" name="yes" value="1">
    </form>
    <form action="test2.php" method="post">
    <input class="exercise_menu" type="submit" value="いいえ">
    <input type="hidden" name="no" value="0">
    </form>-->
    <label class="exercise_menu" id="yes">はい</label>
    <label class="exercise_menu" id="no">いいえ</label>
  </div>
  <div id="exercise_form">
    <label>ユーザ名：</label>
    <input type="text" name="username"></br>
    <label>チーム名：</label>
    <input type="text" name="team"></br>
    <input type="submit" value="送信">
  </div>
  <p id="swich">演習はおこなわれていません</p>
<script type="text/javascript" src="./jstest.js"></script>
</body>
</html>
