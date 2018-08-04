<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分类-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="/public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">商品管理</a>&nbsp;-</span>&nbsp;分类管理
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner" id="div">
				<div class="add">
					<a class="addA" href="/type/type_add">添加一级分类&nbsp;&nbsp;+</a>
				</div>
				<hr style="margin-bottom:30px; color:#ddd;" />
				<!-- banner 表格 显示 -->
				<div style="margin-left:110px">
				<?php foreach ($data as $key => $v): ?>
					<dl style="display:inline-block; width:150px; height:100px;">
						<dt><img src="<?php echo $v['img'] ?>" alt="" /></dt>
						<dd><a href="/type/show_type?type=<?php echo $v['type'] ?>" style="color:orange" id="show" name="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></a></dd>
					</dl>
				<?php endforeach ?>
					
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
	
})

</script>
</html>