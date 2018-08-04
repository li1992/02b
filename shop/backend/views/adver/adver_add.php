<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告添加-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<link rel="stylesheet" type="text/css" href="/public/css/manhuaDate.1.0.css">
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/js/manhuaDate.1.0.js"></script>
<script type="text/javascript" src="/public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
<script>
	$(function (){
  $("input.mh_date").manhuaDate({
    Event : "click",//可选               
    Left : 0,//弹出时间停靠的左边位置
    Top : -16,//弹出时间停靠的顶部边位置
    fuhao : "-",//日期连接符默认为-
    isTime : false,//是否开启时间值默认为false
    beginY : 1949,//年份的开始默认为1949
    endY :2100//年份的结束默认为2049
  });
});
</script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;<a
					href="/public/#">公共管理</a>&nbsp;-</span>&nbsp;意见管理
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>上传广告</span>
				</div>
				<form action="/adver/add_do" method="post" enctype="multipart/form-data">
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告名称：<input type="text" class="input1" name="name" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告地址：<input type="text" class="input1" name="link" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告位：
						<select name="position_id" id="" style="width:300px;height:40px;">
							<option value="">&nbsp;&nbsp;请选择</option>
							<?php foreach ($data as $key => $v): ?>
								<option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="bbD" style="display:inline-block">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上传图片：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="" style="display:inline-block">
							
							<input type="file" name="img" /> 
						</div>
					</div>
					<div class="bbD">
						开始结束时间：<div style="display:inline-block" class="cfD">
							<input class="vinput mh_date" type="text" readonly="true" name="start_time" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="vinput mh_date" type="text" readonly="true" name="end_time" />
						</div>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否显示：<label><input type="radio" checked="checked" name="status" value="1" />是</label> <label><input
							type="radio" name="status" value="0" />否</label>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>简介：</span><textarea name="intro" id="" cols="60" rows="2"></textarea>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<input type="submit" class="btn_ok btn_yes" value="提交" />
							<a class="btn_ok btn_no">取消</a>
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