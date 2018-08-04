<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>角色管理-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
<!-- <script type="text/javascript" src="/public//public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;-</span>&nbsp;角色管理
			</div>
		</div>

		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					
						<div class="cfD">
							<input id="role_name" class="userinput" type="text" placeholder="输入角色名" />&nbsp;&nbsp;&nbsp;
							<button class="userbtn" id="add">添加</button>
							<div class="cfD">
					<input class="userinput" id="search" type="text" placeholder="输入角色名称/ID" />
					&nbsp;&nbsp;&nbsp;<button class="button userbtn">搜索</button>
				</div>
						</div>
					
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="435px" class="tdColor">角色名称</td>
							<td width="630px" class="tdColor">角色管理</td>
							
						</tr>
						<tbody id="tbody">
						<?php foreach ($data['res'] as $key => $v): ?>
							<tr height="40px">
								<td><?php echo $v['id'] ?></td>
								<td><?php echo $v['role_name'] ?></td>
								<td><a href="/role_admin/role_admin?name=<?php echo $v['role_name'] ?>&id=<?php echo $v['id'] ?>">为角色添加用户</a> <a href="/role_access/role_access?name=<?php echo $v['role_name'] ?>&id=<?php echo $v['id'] ?>">为角色分配权限</a></td>
								
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
					<div class="paging" id="page"><?php echo $data['page'] ?></div>
					<input type="hidden" id="totlepage" value="<?php echo $data['totlepage'] ?>" />
					<input type="hidden" id="p" value="<?php echo $data['p'] ?>" />
				</div>
				<!-- user 表格 显示 end-->
			</div>
			<!-- user页面样式end -->
		</div>

	</div>


	<!-- 删除弹出框 -->
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="/public/img/shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="/public/#" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
// 广告弹出框
$(".delban").click(function(){
  $(".banDel").show();
});
$(".close").click(function(){
  $(".banDel").hide();
});
$(".no").click(function(){
  $(".banDel").hide();
});
// 广告弹出框 end
$(document).ready(function(){
	$(document).on('click','#add',function(){
		var role_name = $('#role_name').val();
		if(role_name == ""){
			alert('角色名不能为空');
		}
		$.ajax({
			url:'/role/role_add',
			type:'post',
			data:{role_name:role_name},
			dataType:'json',
			success:function(res){
				if(res == 0){
					alert('添加失败');
				}else if(res == 2){
					alert('角色名不能为空');
				}else if(res == 3){
					alert('角色名已被占用');
				}else{
					$('#tbody').empty();
					$.each(res.res,function(k,v){
						var tr = $('<tr height="40px"></tr>');
						tr.append('<td>'+v.id+'</td>');
						tr.append('<td>'+v.role_name+'</td>');
						tr.append('<td><a href="/role_admin/role_admin?name='+v.role_name+'&id='+v.id+'">为角色添加用户</a> <a href="/role_access/role_access?name='+v.role_name+'&id='+v.id+'">为角色分配权限</a></td>');
						$('#tbody').append(tr);
					})
					$('#page').html(res.page);
					$('#totlepage').val(res.totlepage);
					$('#p').val(res.p);
					alert('添加成功');
				}
			}
		})
	})
	$(document).on('click','#page a,.button',function(event){
		event.preventDefault();
		var p = $(this).text();
		var search = $('#search').val();
		if(p == "首页"){
			p=1;
		}else if(p == "尾页"){
			p = $("#totlepage").val();
		}else if(p == "搜索"){
			p = 1;
		}
		$.ajax({
				type:'post',
				url:'/role/role_list',
				data:{p:p,search:search},
				dataType:'json',
				success:function(data){
					if(data == 0){
						alert('搜索条件不存在');
						history.go(0);
					}
					$('#tbody').empty();
					$.each(data.res,function(k,v){
						var tr = $('<tr height="40px"></tr>');
						tr.append('<td>'+v.id+'</td>');
						tr.append('<td>'+v.role_name+'</td>');
						tr.append('<td><a href="/role_admin/role_admin?name='+v.role_name+'&id='+v.id+'">为角色添加用户</a> <a href="/role_access/role_access?name='+v.role_name+'&id='+v.id+'">为角色分配权限</a></td>');
						$('#tbody').append(tr);
					})
					$('#page').html(data.page);
					$('#totlepage').val(data.totlepage);
					$('#p').val(data.p);
				}
			})
	})
})
</script>
</html>