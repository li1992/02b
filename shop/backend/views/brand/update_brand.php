<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>品牌修改-有点</title>
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
					href="/public/#">公共管理</a>&nbsp;-</span>&nbsp;品牌修改
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>品牌修改</span>
				</div>
				
				<form action="/brand/update_do" method="post" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo $data['brand']['id'] ?>" name="id" />
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌名称：<input type="text" class="input1" name="name" value="<?php echo $data['brand']['name'] ?>" />
					</div>
					
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌分类：
						<select id="type" style="width:300px;height:40px;">
							<option value="">&nbsp;&nbsp;请选择</option>
							<?php foreach ($data['type'] as $key => $v): ?>
								<option value="<?php echo $v['id'] ?>">
									|-<?php for ($i=1; $i <= substr_count($v['path'],'-'); $i++) { 
										echo "----";
									} ?><?php echo $v['name'] ?>
									</option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="bbD" id="append">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php foreach ($data['check_type'] as $key => $v): ?>
							<input type="checkbox" name="type_id[]" checked value="'<?php echo intval($v['id']) ?>'" class="input" /><span>|-<?php for ($i=1; $i <= substr_count($v['path'],'-'); $i++) { 
										echo "----";
									} ?><?php echo $v['name'] ?></span>
						<?php endforeach ?>
					</div>
					<div class="bbD" style="display:inline-block">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌logo：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="" style="display:inline-block">
							
							<input type="file" name="img" /> <img src="<?php echo $data['brand']['logo'] ?>" width="80px" alt="" />
						</div>
					</div>
					
					
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>品牌简介：</span><textarea name="intro" id="" cols="60" rows="2"><?php echo $data['brand']['intro'] ?></textarea>
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

			<!-- 上传品牌页面样式end -->
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$(document).on('change','#type',function(){
			if($(':input').length > 10){
				alert('最多选择五个分类');return;
			}
			var id = $('select option:selected').val();
			var name = $('select option:selected').text();
			$("select [value="+id+"]").remove();
			$('#append').append('<input type="checkbox" name="type_id[]" checked value="'+id+'" class="input" /><span>'+name+'</span>')
			
		})
		$(document).on('click','.input',function(){
				if($(this).prop('checked') == false){
					var id = $(this).val();
					var name = $(this).next().text();
					$('#type').append('<option value="'+id+'">'+name+'</option>');
					$(this).next('span').remove();
					$(this).remove();
				}
			})
		$('#reset').click(function(){
			history.go(-1);
		})
	})
</script>
</html>