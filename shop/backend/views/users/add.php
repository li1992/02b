<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center>
		<h1>商品添加</h1>
		<form action="add_do" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>商品名称:</td>
					<td><input type="text" name="name"></td>
				</tr>
				<tr>
					<td>商品价格:</td>
					<td><input type="text" name="sell_price"></td>
				</tr>
				<tr>
					<td>商品图片:</td>
					<td><input type="file" name="img1"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="上传"></td>
				</tr>
			</table>
		</form>
	</center>
</body>
</html>