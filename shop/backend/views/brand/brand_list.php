<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>品牌-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="/public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;品牌管理
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="add">
					<a class="addA" href="/brand/brand_add">上传品牌&nbsp;&nbsp;+</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="cfD" style="display:inline-block">
					<input class="addUser" id="search" type="text" placeholder="输入品牌名称/ID" />
					<button class="button">搜索</button>
				</div>
				</div>
				<!-- banner 表格 显示 -->
				<div class="banShow">
				<div id="tbody">
				<?php foreach ($data['res'] as $key => $v): ?>
					<dl style="width:20%; float:left; margin-left:10px; border:1px solid #ddd; line-height:24px; margin-bottom:30px;">
						<dt style="text-align:center; border-bottom:1px solid #ddd;"><img src="<?php echo $v['logo'] ?>" alt="" width="200px" height="200px" /></dt>
						<dd style="text-align:center; border-bottom:1px solid #ddd;"><?php echo $v['name'] ?></dd>
						<dd style="text-align:center;"><?php echo $v['intro'] ?><img src="/public/img/delete.png" class="operation" width="15px" id="delete" alt="<?php echo $v['id'] ?>" /><a href="/brand/update_brand?id=<?php echo $v['id'] ?>"><img src="/public/img/update.png" class="operation" width="15px"/></a></dd>
					</dl>
				<?php endforeach ?>
					</div>
					<div style="clear:both; margin-top:30px;" class="paging" id="page"><?php echo $data['page'] ?></div>
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
				url:'/brand/brand_list',
				data:{p:p,search:search},
				dataType:'json',
				success:function(data){
					if(data == 0){
						alert('搜索条件不存在');
						history.go(0);
					}
					$('#tbody').empty();
					$.each(data.res,function(k,v){
						var tr = $('<dl style="width:20%; float:left; margin-left:10px; border:1px solid #ddd; line-height:24px; margin-bottom:30px;"></dl>');
						tr.append('<dt style="text-align:center; border-bottom:1px solid #ddd;"><img src="'+v.logo+'" alt="" width="200px" height="200px" /></dt>');
						tr.append('<dd style="text-align:center; border-bottom:1px solid #ddd;">'+v.name+'</dd>');
						tr.append('<dd style="text-align:center;">'+v.intro+'<img src="/public/img/delete.png" class="operation" width="15px" id="delete" alt="'+v.id+'" /><a href="/brand/update_brand?id='+v.id+'"><img src="/public/img/update.png" class="operation" width="15px"/></a></dd>');
						$("#tbody").append(tr);
					})
					$('#page').html(data.page);
					$('#totlepage').val(data.totlepage);
					$('#p').val(data.p);
				}
			})
	})
	$(document).on('click','#delete',function(){
		if(!confirm('您确定要删除此品牌么')){
			return;
		}
		var id = $(this).attr('alt');
		var p = $('#p').val();
		$.ajax({
			url:'/brand/brand_delete',
			data:{id:id,p:p},
			type:'post',
			dataType:'json',
			success:function(data){

				if(data){
					$('#tbody').empty();
					$.each(data.res,function(k,v){
						var tr = $('<dl style="width:20%; float:left; margin-left:10px; border:1px solid #ddd; line-height:24px; margin-bottom:30px;"></dl>');
						tr.append('<dt style="text-align:center; border-bottom:1px solid #ddd;"><img src="'+v.logo+'" alt="" width="200px" height="200px" /></dt>');
						tr.append('<dd style="text-align:center; border-bottom:1px solid #ddd;">'+v.name+'</dd>');
						tr.append('<dd style="text-align:center;">'+v.intro+'<img src="/public/img/delete.png" class="operation" width="15px" id="delete" alt="'+v.id+'" /><img src="/public/img/update.png" class="operation" id="update" width="15px" alt="'+v.id+'" /></dd>');
						$("#tbody").append(tr);
					})
					$('#page').html(data.page);
					$('#totlepage').val(data.totlepage);
					$('#p').val(data.p);
				}else{
					alert('删除失败');
				}
			}
		})
	})
})

</script>
</html>