<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加广告位-有点</title>
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
					href="/public/#">公共管理</a>&nbsp;-</span>&nbsp;添加广告位
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>添加广告位</span>
				</div>
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告位名称：<input type="text" class="input1" id="name" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告位宽度：<input type="text" class="input1" id='width' />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告位高度：<input type="text" class="input1" id="height" />
						
					</div>
					<div class="bbD" style="display:inline-block">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否启用：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" checked="" name="status" value="1" />是&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="status" />否
					</div>
					
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes" href="#" id="button">提交</button>
							<a class="btn_ok btn_no" href="/public/#">取消</a>
						</p>
					</div>
				</div>
			</div>

			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$(document).on('click','#button',function(){
			var name = $('#name').val();
			var width = $('#width').val();
			var height = $('#height').val();
			var status = $("input:checked").val();
			if(name == "" || width == "" || height == ""){
				alert('元素不能为空');return;
			}
			$.ajax({
				url:'/adver_position/add_do',
				type:'post',
				dateType:'json',
				data:{name:name,width:width,height:height,status:status},
				success:function(res){
					if(res == 2){
						alert('元素不能为空');return;
					}else if(res == 3){
						alert('广告位名称已被占用');return;
					}else if(res == 1){
						alert('添加成功');
						history.go(-1);
					}else{
						alert('添加失败');return;
					}
				}
			})
		})
	})
</script>
</html>