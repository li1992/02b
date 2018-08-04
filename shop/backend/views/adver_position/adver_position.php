<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="/public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;广告位管理
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="add">
					<a class="addA" href="/adver_position/position_add">添加广告位&nbsp;&nbsp;+</a>
				</div>
				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="315px" class="tdColor">广告位名称</td>
							<td width="308px" class="tdColor">宽度</td>
							<td width="450px" class="tdColor">高度</td>
							<td width="215px" class="tdColor">是否启用</td>
							
							<td width="125px" class="tdColor">操作</td>
						</tr>
						<tbody id="tbody">
						<?php foreach ($data['res'] as $key => $v): ?>
							<tr height="40px">
							<td><?php echo $v['id'] ?></td>
							<td><?php echo $v['name'] ?></td>
							<td><?php echo $v['width'] ?></td>
							<td><?php echo $v['height'] ?></td>
							<td><img id="status" src="/public/img/<?php echo $v['status']?'yes.gif':'no.gif' ?>" alt="<?php echo $v['status'] ?>"/</td>
							<td><a href="#" id="upd" class="upd"><img class="operation"
									src="/public/img/update.png"></a></td>
						</tr>
						<?php endforeach ?>
						</tbody>
						
					</table>
					<div class="paging" id="page"><?php echo $data['page'] ?></div>
				</div>
				<input type="hidden" value="<?php echo $data['totlepage'] ?>" id="totlepage" />
				<input type="hidden" value="<?php echo $data['p'] ?>" id="p" />
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
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
				<a href="/public/#" class="ok yes" onclick="del()">确定</a><a class="ok no">取消</a>
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
			url:"/adver_position/update_status",
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
	$(document).on('click','#page a',function(event){
		event.preventDefault();
		var p = $(this).text();
		if(p == "首页"){
			p=1;
		}else if(p == "尾页"){
			p = $("#totlepage").val();
		}
		$.ajax({
				type:'post',
				url:'/adver_position/adver_position',
				data:{p:p},
				dataType:'json',
				success:function(data){
					$('#tbody').empty();
					$.each(data.res,function(k,v){
						var tr = $('<tr height="40px"></tr>');
						tr.append('<td>'+v.id+'</td>');
						tr.append('<td>'+v.name+'</td>');
						tr.append('<td>'+v.width+'</td>');
						tr.append('<td>'+v.height+'</td>');
						if(v.status == 1){
							var status = 'yes.gif';
						}else{
							var status = "no.gif";
						}
						tr.append('<td><img id="status" src="/public/img/'+status+'"/></td> alt="'+v.status+'"');
						tr.append('<td><a href="#" id="upd"><img class="operation" src="/public/img/update.png"></a></td>');
						$("#tbody").append(tr);
					})
					$('#page').html(data.page);
					$('#totlepage').val(data.totlepage);
					$('#p').val(data.p);
				}
			})
	})
	$(document).on('click','#upd',function(){
		var length = $('input').length-3;
		if(length > 1){
			alert('请先完善信息');return;
		}
		var id = $(this).parents('tr').children('td').eq(0).text();
		var name = $(this).parents('tr').children('td').eq(1).text();
		var width = $(this).parents('tr').children('td').eq(2).text();
		var height = $(this).parents('tr').children('td').eq(3).text();
		$(this).parents('tr').children('td').eq(1).html('<input type="text" id="upd_name" style="width:200px;height:38px;" value="'+name+'" />');
		$(this).parents('tr').children('td').eq(2).html('<input type="text" id="upd_width" style="width:200px;height:38px;" value="'+width+'" />');
		$(this).parents('tr').children('td').eq(3).html('<input type="text" id="upd_height" style="width:300px;height:38px;" value="'+height+'" />');
		$(this).parents('tr').children('td').eq(5).html('<button id="button">确定</button>');
		$(document).on('click','#button',function(){
			var newname = $('#upd_name').val();
			var newwidth = $('#upd_width').val();
			var newheight = $('#upd_height').val();
			if(newname == name && newwidth == width && newheight == height){
				$(this).parents('tr').children('td').eq(1).text(name);
				$(this).parents('tr').children('td').eq(2).text(width);
				$(this).parents('tr').children('td').eq(3).text(height);
				$(this).parents('tr').children('td').eq(5).html('<a href="#" id="upd"><img class="operation" src="/public/img/update.png"></a>');
				return;
			}else{
				$(this).parents('tr').children('td').eq(1).text(newname);
				$(this).parents('tr').children('td').eq(2).text(newwidth);
				$(this).parents('tr').children('td').eq(3).text(newheight);
				$(this).parents('tr').children('td').eq(5).html('<a href="#" id="upd"><img class="operation" src="/public/img/update.png"></a>');
				$.ajax({
					type:'post',
					url:'/adver_position/update_position',
					data:{name:newname,width:newwidth,height:newheight,id:id},
					dataType:'json',
					success:function(res){
						if(res == 1){
							alert('修改成功');return;
						}else if(res == 2){
							alert('元素不能为空');return;
						}else if(res == 3){
							alert('广告位名称已被占用');return;
						}else{
							alert('修改失败');
							history.go(0);
						}
					}
				})
			}
		})
	})
})

</script>
</html>