<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>为角色分配权限-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/jq.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="/public/#">首页</a>&nbsp;-&nbsp;<a
					href="/role/role_list">角色管理</a>&nbsp;-</span>&nbsp;为角色分配权限
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
						<span style="color:orange;">请选择权限&nbsp;&nbsp;:</span>
					</div>
					
						
						<div style="width:500px;" id="div">
							<?php foreach ($data['access'] as $key => $v): ?>
								<?php if(isset($v['is_access'])){ ?>
									<input type="checkbox" disabled="false"/>&nbsp;&nbsp;
									<?php }else{ ?>
										<input type="checkbox" id="<?php echo $v['parent_id'] ?>" class="box" name="<?php echo $v['newpath'] ?>-" value="<?php echo $v['id'] ?>" />&nbsp;&nbsp;
										<?php } ?>
							
							<?php if(substr_count($v['path'],'-') == 0){
								echo "<font color='blue'>|-".$v['access_name']."</font><br />";
								}else{
									echo "|-";
									for ($i=substr_count($v['path'],'-'); $i >=1 ; $i--) { 
										echo "----";
									}echo $v['access_name']."<br />";
							}
							 ?>
							<?php endforeach ?>
						</div>
					
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes" id="button">提交</button>
							<input type="hidden" id="role_id" value="<?php echo $data['id'] ?>" />
						</p>
					</div>
					<div class="baTopNo">
						<a  style="font-size:16px;" href="/role_access/del_access?role_id=<?php echo $data['id'] ?>&role_name=<?php echo $data['name'] ?>">管理当前角色权限</a>
					</div>
				</div>
			</div>

			<!-- 会员注册页面样式end -->
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$(document).on('click','.box',function(){
			var path = $(this).attr('name');
			$("input[name^='"+path+"']").prop('checked',this.checked);
			var id = $(this).attr('id');
			obj(id);
			function obj(id){
				var parent_id = $("input[value='"+id+"']").attr('id');
				if(parent_id == undefined){
					$("input[value='"+id+"']").prop('checked',true);
				}else{
					$("input[value='"+id+"']").prop('checked',true);
					obj(parent_id);
				}
			}
			obj2(id);
			function obj2(id){
				var parent_id = $("input[value='"+id+"']").attr('id');
				if(parent_id == 0){
					var path = $("input[value='"+id+"']").attr('name');
					var length = $("input:checked[name^='"+path+"']").length;
					if(length == 1){
					$("input[value='"+id+"']").prop('checked',false);
					var parent_id = $("input[value='"+id+"']").attr('id');
					obj2(parent_id);
					}
				}
			}
		})
		$(document).on('click','#button',function(){
			var str = "";
			if($('.box:checked').length>1){
				$('.box:checked').each(function(k,v){
				str+= ','+v.value;
				})
				str = str.substr(1);
			}else{
				var str = $('.box:checked').val();
			}

			if(str == undefined){
				alert('请选择权限');return;
			}
			var role_id = $('#role_id').val();
			$.ajax({
				url:"/role_access/add_access",
				data:{str:str,role_id:role_id},
				dataType:'json',
				type:'post',
				success:function(res){
					if(res){
						$('#div').empty();
						$.each(res,function(k,v){
							if(v.is_access != undefined){
								var input = $('<input type="checkbox" style="margin-right:1em;" disabled="false"/>'+'<?php echo "&nbsp;&nbsp;"; ?>');
							}else{
								var input = $('<input type="checkbox" style="margin-right:1em;" id="'+v.parent_id+'" class="box" name="'+v.newpath+'-" value="'+v.id+'" />&nbsp;&nbsp;');
							}
							if(v.path.split('-').length-1 == 0){
								input.after('|-<font color="blue">'+v.access_name+'</font><br />');
							}else{
								var str = "";
								for (var i =0; i <v.path.split('-').length-1;i++) {
									str+= "----";
								};
								input.after('|-'+str+v.access_name+'<br />');
							}
							$('#div').append(input);
						})
						alert('分配成功')
					}else{
						alert('分配失败');
					}
				}
			})
		})
	})
</script>
</html>