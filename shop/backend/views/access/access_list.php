<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>权限管理-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
<!-- <script type="text/javascript" src="/public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;-</span>&nbsp;权限管理
			</div>
		</div>

		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					
						<div class="cfD">
							<input class="userinput" type="text" placeholder="输入权限名称" id="access_name" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="userinput vpr" type="text" placeholder="输入权限URL" id="access_url" />-&nbsp;&nbsp;&nbsp;
							<select name="" id="select" class="userinput vpr">
								<option value="">请选择父级菜单</option>
								<option value="0">一级菜单</option>
								<?php foreach ($data['access_name'] as $key => $v): ?>

									<option value="<?php echo $v['id'] ?>" name="<?php echo $v['path'] ?>">
									|-<?php for ($i=1; $i <= substr_count($v['path'],'-'); $i++) { 
										echo "----";
									} ?><?php echo $v['access_name'] ?>
									</option>
								<?php endforeach ?>
							</select>
							<button class="userbtn" id="add">添加</button>
						</div>
						<div class="cfD">
					<input class="userinput" id="search" type="text" placeholder="输入权限名称/ID" />
					<button class="button userbtn">搜索</button>
				</div>
					
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="435px" class="tdColor">权限名称</td>
							<td width="400px" class="tdColor">权限URL</td>
							<td width="300px" class="tdColor">父级ID</td>
							<td width="330px" class="tdColor">path路径</td>
							
						</tr>
						<tbody id="tbody">
						<?php foreach ($data['res'] as $key => $v): ?>
							<tr height="40px">
							<td><?php echo $v['id'] ?></td>
							<td><?php echo $v['access_name'] ?></td>
							<td><?php echo $v['access_url'] ?></td>
							<td><?php echo $v['parent_id'] ?></td>
							<td><?php echo $v['path'] ?></td>
							
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
		
		var access_name = $('#access_name').val();
		var access_url = $('#access_url').val();
		var parent_id = $('select option:selected').val();
		var path = $('select option:selected').attr('name');
		
		if(access_name=="" || parent_id == ""){
			alert('权限信息不能为空');return;
		}else{
			if(parent_id == 0){
				path = 0;
			}else{
				if(access_url == ""){
					alert('权限URL不能为空')
				}
				path = path+'-'+parent_id;
			}
			$.ajax({
				type:'post',
				url:'/access/access_add',
				data:{access_name:access_name,access_url:access_url,parent_id:parent_id,path:path},
				dataType:'json',
				success:function(res){
					if(res == 2){
						alert('权限名已被占用');
					}else if(res == 0){
						alert('添加失败');
					}else{
						$('#tbody').empty();
						$.each(res.res,function(k,v){
							var tr = $('<tr height="40px"></tr>');
							tr.append('<td>'+v.id+'</td>');
							tr.append('<td>'+v.access_name+'</td>');
							var access_url = v.access_url ? v.access_url :'';
							tr.append('<td>'+access_url+'</td>');
							tr.append('<td>'+v.parent_id+'</td>');
							tr.append('<td>'+v.path+'</td>');
							$("#tbody").append(tr);
						})
						$('#select').empty();
						$('#select').append('<option value="">请选择父级菜单</option>');
						$('#select').append('<option value="0">一级菜单</option>');
						$.each(res.access_name,function(k,v){
							var num = v.path.split('-').length-1;
							var str = "";
							for(var i=0;i<num; i++){
								str+="----";
							}
							$('#select').append('<option value="'+v.id+'" name="'+v.path+'">|-'+str+''+v.access_name+'</option>');
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
				url:'/access/access_list',
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
						tr.append('<td>'+v.access_name+'</td>');
						var access_url = v.access_url ? v.access_url :'';
						tr.append('<td>'+access_url+'</td>');
						tr.append('<td>'+v.parent_id+'</td>');
						tr.append('<td>'+v.path+'</td>');
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