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
					href="#">公共管理</a>&nbsp;-</span>&nbsp;广告管理
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="add" style="display:inline-block">
					<a class="addA" href="/adver/adver_add">上传广告&nbsp;&nbsp;+</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="cfD" style="display:inline-block">
					<input class="addUser" id="search" type="text" placeholder="输入广告名/ID" />
					<button class="button">搜索</button>
				</div>
				</div>

				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="315px" class="tdColor">图片</td>
							<td width="308px" class="tdColor">名称</td>
							<td width="308px" class="tdColor">所属广告位</td>
							<td width="308px" class="tdColor">广告网址</td>
							<td width="450px" class="tdColor">简介</td>
							<td width="215px" class="tdColor">是否显示</td>
							<td width="180px" class="tdColor">到期时间</td>
							<td width="125px" class="tdColor">操作</td>
						</tr>
						<tbody id="tbody">
						<?php foreach ($data['res'] as $key => $v): ?>
							<tr height="40px">
							<td><?php echo $v['id'] ?></td>
							<td><div class="bsImg">
									<img src="<?php echo $v['img'] ?>">
								</div></td>
							<td><?php echo $v['name'] ?></td>
							<td><?php echo $v['position_id'] ?></td>
							<td><?php echo $v['link'] ?></td>
							<td><?php echo $v['intro'] ?></td>
							<td><img id="status" src="/public/img/<?php echo $v['status']?'yes.gif':'no.gif' ?>" alt="<?php echo $v['status'] ?>"/</td>
							<td><?php echo $v['end_time'] ?></td>
							<td><a href="/adver/update_adver?id=<?php echo $v['id'] ?>"><img class="operation"
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
			url:"/adver/update_status",
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
				url:'/adver/adver_list',
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
						tr.append('<td><div class="bsImg"><img src="'+v.img+'"></div></td>');
						tr.append('<td>'+v.name+'</td>');
						tr.append('<td>'+v.position_id+'</td>');
						tr.append('<td>'+v.link+'</td>');
						tr.append('<td>'+v.intro+'</td>');
						if(v.status == 1){
							var status = 'yes.gif';
						}else{
							var status = "no.gif";
						}
						tr.append('<td><img id="status" src="/public/img/'+status+'"/></td> alt="'+v.status+'"');
						tr.append('<td>'+v.end_time+'</td>');
						tr.append('<td><a href="#" id="upd"><img class="operation" src="/public/img/update.png"></a></td>');
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