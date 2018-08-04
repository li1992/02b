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
			<div style="margin-top:30px; margin-left:70px; display:inline-block;">
				<dl style="display:inline-block; width:150px; height:100px;">
					<dt><img src="<?php echo $data['res'][0]['img'] ?>" name="<?php echo $data['res'][0]['type'] ?>" id="img" /></dt>
					<dd style="color:orange;"><?php echo $data['res'][0]['name'] ?></dd>
				</dl>
				
						<div class="cfD" style=" margin-left:70px; display:inline-block; position:relative; bottom:12px">
							<input id="name" class="userinput" type="text" placeholder="输入二级分类名称" />&nbsp;&nbsp;&nbsp;
							<button class="userbtn" id="add">添加</button>
						</div>
				<hr style="margin-bottom:30px; color:#ddd;" width="10000px" />
			</div>
			<div style="width:93%; margin:0 auto; margin-left:100px;" id="big">
			<?php foreach ($data['res'] as $k => $v): ?>
				<?php if ($v['parent_id'] == $data['type']) { ?>
					<div style="border:1px dashed #aaa; display:inline-block; width:23%; height:500px; margin-right:15px; margin-top:20px; float:left;">
						<ul style="margin-left:10px; line-height:25px;">
							<li style="color:#f4a; font-size:20px" name="<?php echo $v['path'] ?>" class="<?php echo $v['id'] ?>"><b><?php echo $v['name'] ?></b></li>
							<?php foreach ($data['res'] as $key => $val): ?>
								<?php if($v['id'] == $val['parent_id']){ ?>
									<li style="margin-left:1em" name="<?php echo $val['id'] ?>"><span><?php echo $val['name'] ?></span><span style="float:right"><img style="margin-right:5px" src="/public/img/<?php echo $val['status']? 'yes.gif' :'no.gif' ?>" id="status" alt="<?php echo $val['status'] ?>" /><img style="margin-right:5px" width="15px" src="/public/img/update.png" alt="<?php echo $val['id'] ?>" class="update" /></span></li>
								<?php } ?>
							<?php endforeach ?>
							<li style="margin-left:1em"><img src="/public/img/add.png" width="15" class="add_type" /></li>
						</ul>
					</div>	
				<?php } ?>
			<?php endforeach ?>
				

				</div>
			
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
	$(document).on('click','#add',function(){
		var name = $('#name').val();
		var type = $('#img').attr('name');
		$.ajax({
			url:"/type/add_type",
			data:{name:name,type:type},
			type:'post',
			dataType:'json',
			success:function(data){
				if(data == 0){
					alert('添加失败');
					history.go(0);
				}else if(data == 2){
					alert('元素不能为空');
					history.go(0);
				}else if(data == 3){
					alert('分类名称已被占用');
					history.go(0)
				}else{
					var div = $('<div style="border:1px dashed #aaa; display:inline-block; width:23%; height:500px; margin-right:15px; margin-top:20px; float:left;"></div>');
					div.append('<ul style="margin-left:10px; line-height:25px;"><li style="color:#f4a; font-size:20px" name="'+data.path+'" class="'+data.id+'"><b>'+data.name+'</b><li style="margin-left:1em"><img src="/public/img/add.png" width="15" class="add_type" /></li></ul>')
					$('#big').append(div);
				}
			}
		})
	})
	$(document).on('click','.add_type',function(){
		if($('#input').length >0){
			alert('不能同时操作');return;
		}
		$(this).parents('li').html('<input type="text" id="input" />');
		$('#input').focus();
		$('#input').blur(function(){
			var name = $('#input').val();
			if(name == ""){
				$('#input').parents('li').html('<img src="/public/img/add.png" width="15" class="add_type" />');return;
			}
			var type = $('#img').attr('name');
			var path = $(this).parents('ul').children().eq(0).attr('name');
			var parent_id = $(this).parents('ul').children().eq(0).attr('class');
			$.ajax({
				url:'/type/add_type3',
				data:{name:name,type:type,path:path,parent_id:parent_id},
				type:'post',
				dataType:'json',
				success:function(data){
					if(data == 0){
						alert('添加失败');
						history.go(0);
					}else if(data == 2){
						alert('分类名称已被占用');history.go(0);
					}else{
						$('#input').parents('li').before('<li style="margin-left:1em" name="'+data+'"><span>'+name+'</span><span style="float:right"><img style="margin-right:5px" src="/public/img/yes.gif" id="status" alt="1" /><img style="margin-right:5px" width="15px" src="/public/img/update.png" alt="'+data+'" class="update" /></span></li>');
						$('#input').parents('li').html('<img src="/public/img/add.png" width="15" class="add_type" />');
					}
				}
			})
		})
	})
	$(document).on('click','#status',function(){
		var id = $(this).parents('li').attr('name');
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
			url:"/type/update_status",
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
	$(document).on('click','.update',function(){
		var id = $(this).attr('alt');
		var name = $(this).parents('li').children().eq(0).text();
		$(this).parents('li').children().eq(0).html('<input type="text" id="update" />');
		$('#update').val(name);
		$('#update').focus();
		$('#update').blur(function(){
			var newname = $('#update').val();
			if(newname == ""){
				alert('分类名称不能为空');
				$('#update').parents('li').children().eq(0).html('<span>'+name+'</span>');
				return;
			}else if(name == newname){
				$('#update').parents('li').children().eq(0).html('<span>'+name+'</span>');
				return;
			}
			$.ajax({
				url:'/type/update_info',
				data:{id:id,name:newname},
				type:'post',
				dataType:'json',
				success:function(data){
					if(data == 1){
						alert('修改成功');
						$('#update').parents('li').children().eq(0).html('<span>'+newname+'</span>');
						return;
					}else if(data == 2){
						alert('分类名称不能为空');
						return;
					}else if(data == 3){
						alert('分类名称已被占用');
						return;
					}else{
						alert('修改失败');return;
					}
				}
			})
		})
	})
})

</script>
</html>