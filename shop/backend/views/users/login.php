<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="/public/jq.js"></script>
</head>
<body>
	<center>
		<h1>用户登录</h1>
		<form action="login_do" method="post" id="form">
		<table>
			<tr>
				<td>用户名:</td>
				<td><input type="text" name="name" id="name"><span id="s_name"></span></td>
			</tr>
			<tr>
				<td>密码:</td>
				<td><input type="password" name="pwd" id="pwd"><span id="s_pwd"></span></td>
			</tr>
			<tr>
				<td><a href="/users/regist">注册</a></td>
				<td><input type="submit" value="登录" id="button"></td>
			</tr>
		</table>
		</form>
	</center>
</body>
<script>
	$(document).ready(function(){
		flag = 1;
		$(document).on('blur','#name',function(){
			
			var name = $('#name').val();
			if(name == ""){
				$('#s_name').html('<font color="red">用户名不能为空</font>');
				flag = 0;
			}else{
				$('#s_name').html(' ');
			}
		})
		$(document).on('blur','#pwd',function(){
			flag = 1;
			var pwd = $('#pwd').val();
			if(pwd == ""){
				$('#s_pwd').html('<font color="red">密码不能为空</font>');
				flag = 0;
			}else{
				$('#s_pwd').html(' ');
			}
		})
		$(document).on('submit','#form',function(){
			if(flag == 0){
				return false;
			}
		})
	})
</script>
</html>