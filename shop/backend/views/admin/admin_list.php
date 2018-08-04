<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
<!-- <script type="text/javascript" src="/public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;-</span>&nbsp;管理员管理
			</div>
		</div>

		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					
						<div class="cfD">
							<input class="userinput" type="text" placeholder="输入用户名" id="uname" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="userinput vpr" type="text" placeholder="输入用户密码" id="pwd" />
							<button class="userbtn" id="add">添加</button>
							<div class="cfD">
					<input class="userinput" id="search" type="text" placeholder="输入角色名称/ID" />
					<button class="button userbtn">搜索</button>
				</div>
						</div>
					
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="435px" class="tdColor">用户名</td>
							<td width="630px" class="tdColor">添加时间</td>
							<td width="400px" class="tdColor">管理员状态</td>
							
						</tr>
						<tbody id="tbody">
						<?php foreach ($data['res'] as $key => $v): ?>
							<tr height="40px">
							<td><?php echo $v['id'] ?></td>
							<td><?php echo $v['uname'] ?></td>
							<td><?php echo $v['c_time'] ?></td>
							<td><img id="status" src="/public/img/<?php echo $v['status']?'yes.gif':'no.gif' ?>" alt="<?php echo $v['status'] ?>"/></td>
							
						</tr>
						<?php endforeach ?>
						</tbody>
					</table>
					<div class="paging" id="page"><?php echo $data['page'] ?></div>
				</div>
				<input type="hidden" value="<?php echo $data['totlepage'] ?>" id="totlepage" />
				<input type="hidden" value="<?php echo $data['p'] ?>" id="p" />
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
		var uname = $('#uname').val();
		var pwd = $('#pwd').val();
		if(uname=="" || pwd == ""){
			alert('用户名或密码不能为空');
		}else{
			$.ajax({
				type:'post',
				url:'/admin/admin_add',
				data:{uname:uname,pwd:pwd},
				dataType:'json',
				success:function(res){
					if(res == 2){
						alert('用户名已被占用');
					}else if(res == 0){
						alert('添加失败');
					}else{
						$('#tbody').empty();
						$.each(res.res,function(k,v){
							var tr = $('<tr height="40px"></tr>');
							tr.append('<td>'+v.id+'</td>');
							tr.append('<td>'+v.uname+'</td>');
							tr.append('<td>'+v.c_time+'</td>');
							if(v.status == 1){
								var status = 'yes.gif';
							}else{
								var status = "no.gif";
							}
							tr.append('<td><img id="status" src="/public/img/'+status+'"/></td> alt="'+v.status+'"');
							$("#tbody").append(tr);
						})
						$('#page').html(res.page);
						$('#totlepage').val(res.totlepage);
						$('#p').val(res.p);
						alert('添加成功');
					}
				}
			})
		}
	})
	$(document).on('click','#status',function(){
		var id = $(this).parents('tr').children('td').eq(0).text();
		var status = $(this).attr('alt');
		if(status == 1){
			$(this).attr('src',"/public/img/no.gif");
			$(this).attr('alt',0);
		}else{
			$(this).attr('src',"/public/img/yes.gif");
			$(this).attr('alt',1);
		}
		$.ajax({
			type:'post',
			data:{id:id,status:status},
			dataType:'json',
			url:"/admin/update_status",
			success:function(res){
				if(res){
					alert('修改成功');
				}else{
					alert('修改失败');
					history.go(0);
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
				url:'/admin/admin_list',
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
						tr.append('<td>'+v.uname+'</td>');
						tr.append('<td>'+v.c_time+'</td>');
						if(v.status == 1){
							var status = 'yes.gif';
						}else{
							var status = "no.gif";
						}
						tr.append('<td><img id="status" src="/public/img/'+status+'"/></td> alt="'+v.status+'"');
						$("#tbody").append(tr);
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