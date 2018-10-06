<!DOCTYPE html>
<html>
<head lang="ja">
  <meta charset="utf-8">
  <title>問題作成</title>
</head>
<body>
  <h1>問題作成</h1>
		<form action="example.php" name="form1" method="post" enctype="multipart/form-data">
			<ul>
				<li>題名</li>
					<input type="text" name="title">
				<li>種類</li>
					<select name="category">
						<option>Binary</option>
						<option>Forensic</option>
						<option>Web</option>
						<option>Crypto</option>
						<option>Network</option>
						<option>Misc</option>
					</select>
				<li>問題文</li>
					<textarea cols=40 rows=10 name="explanation"></textarea>
				<li>ファイル</li>
					<input type="file" name="uploadfile">
			</ul>
				<input type="hidden" name="action" value="insert">
				<input type="submit" value="送信">
	</form>
</body>
</html>
