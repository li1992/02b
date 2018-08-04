<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="/public/jq.js"></script>
</head>

<body>

	<center>
	<a href="/users/add">添加商品</a>

		<table border="1">
			<tr>
				<td>ID</td>
				<td>名称</td>
				<td>图片</td>
				<td><button id="button" name="sell_price" class="asc">价格</button></td>
				<td><button id="button" name="sale" class="asc">销量</button></td>
				<td>操作</td>
			</tr>
			<tbody id="tbody">
				<?php foreach ($data['data'] as $key => $v): ?>
					<tr>
						<td><?php echo $v['id'] ?></td>
						<td><?php echo $v['name'] ?></td>
						<td><img src="<?php echo $v['img1'] ?>" width="60px"></td>
						<td><?php echo $v['sell_price'] ?></td>
						<td><?php echo $v['sale'] ?></td>
						<td><a href="#" id="del">删除</a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
			
		</table>
		<div id="page"><?php echo $data['page'] ?></div>
		<input type="hidden" id="totle" value="<?php echo $data['totle'] ?>">
	</center>
</body>
<script>
	$(document).on('click','#page a,#button',function(){
		var p = $(this).text();
		var name = "";
		var order = '';
		if(p == '首页'){
			p = 1;
		}else if(p == "尾页"){
			p = $('#totle').val();
		}else if(p == "价格"){
			name = $(this).attr('name');
			order = $(this).attr('class');
			if(order == "desc"){
				$(this).attr('class','asc');
			}else{
				$(this).attr('class','desc');
			}
			p = 1;
		}else if(p == "销量"){
			name = $(this).attr('name');
			order = $(this).attr('class');
			if(order == "desc"){
				$(this).attr('class','asc');
			}else{
				$(this).attr('class','desc');
			}
			p = 1;
		}
		$.ajax({
			url:'/users/show',
			data:{p:p,name:name,order:order},
			type:'post',
			dataType:'json',
			success:function(data){
				if(data){
					$('#tbody').empty();
					$.each(data.data,function(k,v){
						var tr = $('<tr></tr>');
						tr.append('<td>'+v.id+'</td>');
						tr.append('<td>'+v.name+'</td>');
						tr.append('<td><img src="'+v.img1+'" width="60px"></td>');
						tr.append('<td>'+v.sell_price+'</td>');
						tr.append('<td>'+v.sale+'</td>');
						tr.append('<td><a href="#" id="del">删除</a></td>');
						$('#tbody').append(tr);
					})
					$('#page').html(data.page);
					$('#totle').val(data.totle);
				}
			}
		})
	})
	$(document).on('click','#del',function(){
		var id = $(this).parents('tr').children().eq(0).text();
		$.ajax({
			url:'/users/del',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(data){
				if(data){
					alert('删除成功');
					history.go(0);
				}else{
					alert('删除失败');
					history.go(0);
				}
			}
		})
	})
</script>
</html>