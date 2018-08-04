<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分类添加-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<link rel="stylesheet" type="text/css" href="/public/css/manhuaDate.1.0.css">
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/js/manhuaDate.1.0.js"></script>
<script type="text/javascript" src="/public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>

</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;<a
					href="/type/type_list">分类列表</a>&nbsp;-</span>&nbsp;添加一级分类
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>添加一级分类</span>
				</div>
				<form action="/type/add_do" method="post" enctype="multipart/form-data">
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类名称：<input type="text" class="input1" name="name" />
					</div>
					<div class="bbD" style="display:inline-block">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上传图片：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="" style="display:inline-block">
							
							<input type="file" name="img" /> 
						</div>
					</div>
					
					<div class="bbD">
						<p class="bbDP">
							<input type="submit" class="btn_ok btn_yes" value="提交" />
							<a class="btn_ok btn_no" id="reset">取消</a>
						</p>
					</div>
				</div>
				</form>
			</div>

			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$(document).on('click','#button',function(){
			var title = $('#title').val();
			var content = $('#content').val();
			$.ajax({
				url:'/notice/add_do',
				type:'post',
				dateType:'json',
				data:{title:title,content:content},
				success:function(res){
					if(res == 2){
						alert('元素不能为空');return;
					}else if(res == 3){
						alert('公告标题已被占用');return;
					}else if(res == 1){
						alert('添加成功');
						history.go(-1);
					}else{
						alert('添加失败');return;
					}
				}
			})
		})
		$(document).on('click','#reset',function(){
			history.go(-1);
		})
	})
</script>
</html>