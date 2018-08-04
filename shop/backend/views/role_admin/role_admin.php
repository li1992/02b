<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>为角色分配管理员-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;<a
					href="/role/role_list">角色管理</a>&nbsp;-</span>&nbsp;为角色分配管理员
			</div>
		</div>
		<div class="page ">
			<!-- 会员注册页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>当前选择的角色&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $data['name'] ?></span>
				</div>
				<div class="baBody">
					<div class="baTopNo">
						<span style="color:orange;">请选择管理员&nbsp;&nbsp;:</span>
					</div>
					
						<input type="checkbox" id="box" value="" />全选<br /><br />
						<div style="width:500px;" id="div">
					<?php if($data['admin_name']){ ?>
							<?php foreach ($data['admin_name'] as $key => $v): ?>
							<span style="display:inline-block; width:80px; height:30px;"><input class="check" type="checkbox" value="<?php echo $data['admin_name'][$key]['id'] ?>" />	<?php echo $data['admin_name'][$key]['uname']; ?></span>
						<?php endforeach ?>
							<?php }else{
								echo "此角色没有管理员可分配";
								} ?>
						</div>
					
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes" id="button">提交</button>
							<input type="hidden" id="role_id" value="<?php echo $data['id'] ?>" />
						</p>
					</div>
					<div class="baTopNo">
						<a  style="font-size:16px;" href="/role_admin/del_admin?role_id=<?php echo $data['id'] ?>&role_name=<?php echo $data['name'] ?>">管理角色用户组</a>
					</div>
				</div>
			</div>

			<!-- 会员注册页面样式end -->
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$(document).on('click','#box',function(){
			var status = $(this).prop('checked');
			$('input:checkbox').prop('checked',status);
		})
		$(document).on('click','#button',function(){
			var str = "";
			if($('.check:checked').length>1){
				$('.check:checked').each(function(k,v){
				str+= ','+v.value;
				})
				str = str.substr(1);
			}else{
				var str = $('.check:checked').val();
			}
			if(str == undefined){
				alert('请选择管理员');return;
			}
			var role_id = $('#role_id').val();
			$.ajax({
				url:"/role_admin/add_admin",
				data:{str:str,role_id:role_id},
				dataType:'json',
				type:'post',
				success:function(res){
					if(res){
						$('#div').empty();
						$.each(res,function(k,v){
							$('#div').append('<span style="display:inline-block; width:80px; height:30px;"><input class="check" type="checkbox" value="'+v.id+'" />	'+v.uname+'</span>');
						})
						alert('分配成功')
					}else if(res == ""){
						$('#div').empty();
						alert('分配成功');
					}else{
						alert('分配失败');
					}
				}
			})
		})
	})
</script>
</html>