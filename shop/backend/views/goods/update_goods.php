<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品修改-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;<a
					href="/public/#">商品管理</a>&nbsp;-</span>&nbsp;商品修改
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>商品修改</span>
				</div>
				<form action="update_do" method="post" enctype="multipart/form-data">
				<div class="baBody">
					<input type="hidden" name="id" value="<?php echo $data['goods']['id'] ?>" />
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商品名称：<input type="text"
							class="input3" name="name" value="<?php echo $data['goods']['name'] ?>" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;销售价格：<input type="text"
							class="input3" name="sell_price" value="<?php echo $data['goods']['sell_price'] ?>" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;现有库存：<input type="text"
							class="input3" name="nums" value="<?php echo $data['goods']['nums'] ?>" />
					</div>
					<div class="bbD">
						购买获得积分：<input type="text"
							class="input3" name="point" value="<?php echo $data['goods']['point'] ?>" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;所属品牌：
						<select name="brand_id" id="" class="input3">
							<option value="">请选择</option>
							<?php foreach ($data['brand'] as $key => $v): ?>
								<?php if($v['id'] == $data['goods']['brand_id']){ ?>
									<option value="<?php echo $v['id'] ?>" selected><?php echo $v['name'] ?></option>
									<?php } ?>
								<option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;所属分类：
						<select id="type" class="input3">
							<option value="">请选择</option>
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
					<div class="bbD">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<img src="<?php echo $data['goods']['img1'] ?>" alt="" width="80px" />
						<img src="<?php echo $data['goods']['img2'] ?>" alt="" width="80px" />
						<img src="<?php echo $data['goods']['img3'] ?>" alt="" width="80px" />
						<img src="<?php echo $data['goods']['img4'] ?>" alt=""  width="80px"/>
						<img src="<?php echo $data['goods']['img5'] ?>" alt=""  width="80px"/>
					</div>
					<div class="bbD" style="display:inline-block">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商品图片：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="" style="display:inline-block">
							<input type="file" name="img[]" /> 
						</div><img src="/public/img/add.png" width="15px" class="operation" id="add" alt="" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商品简介：
						<div class="btext2">
							<textarea class="text2" name="content"><?php echo $data['goods']['content'] ?></textarea>
						</div>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否免邮：
						<?php if ($data['goods']['is_fee'] == 1) { ?>
							<label><input
							type="radio" checked="checked" name="is_fee" value='1' />&nbsp;是</label><label><input
							type="radio" name="is_fee" value="0" />&nbsp;否</label>
						<?php }else{ ?>
							<label><input
							type="radio" name="is_fee" value='1' />&nbsp;是</label><label><input
							type="radio" checked="checked" name="is_fee" value="0" />&nbsp;否</label>
						<?php } ?>
						
					</div>
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes" href="/public/#">提交</button>
							<a class="btn_ok btn_no" href="/public/#">取消</a>
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
		$(document).on('change','#type',function(){
			if($('#append>input').length > 4){
				alert('最多选择五个分类');return;
			}
			var id = $('#type option:selected').val();
			var name = $('#type option:selected').text();
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
		$(document).on('click','#add',function(){
			if($(':file').length>4){
				alert('最多添加五张图片');
				return;
			}
			$(this).before('<br /><div class="bbD" style="display:inline-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商品图片：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="" style="display:inline-block"><input type="file" name="img[]" /> </div>')
		})
	})
</script>
</html>