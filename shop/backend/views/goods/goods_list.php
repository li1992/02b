<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品-有点</title>
<link rel="stylesheet" type="text/css" href="/public/css/css.css" />
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="/public/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/public/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">商品管理</a>&nbsp;-</span>&nbsp;商品列表
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="add" style="display:inline-block">
					<a class="addA" href="/goods/goods_add">上传商品&nbsp;&nbsp;+</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="cfD" style="display:inline-block">
					<input class="addUser" id="search" type="text" placeholder="输入商品名/ID" />
					<button class="button">搜索</button>
				</div>
				</div>
				

				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="315px" class="tdColor">商品主图片</td>
							<td width="308px" class="tdColor">商品名称</td>
							<td width="308px" class="tdColor"><button class="order" name="sell_price" id="desc">商品价格↑↓</button></td>
							<td width="308px" class="tdColor"><button class="order" name="up_time" id="desc">上架时间↑↓</button></td>
							<td width="215px" class="tdColor">库存</td>
							<td width="180px" class="tdColor">购买获赠积分</td>
							<td width="180px" class="tdColor"><button class="order" name="favorite" id="desc">收藏次数↑↓</button></td>
							<td width="180px" class="tdColor"><button class="order" name="sale" id="desc">销量↑↓</button></td>
							<td width="180px" class="tdColor">是否免邮</td>
							<td width="180px" class="tdColor">是否上架</td>
							<td width="125px" class="tdColor">操作</td>
						</tr>
						<tbody id="tbody">
						<?php foreach ($data['res'] as $key => $v): ?>
							<tr height="40px">
							<td><?php echo $v['id'] ?></td>
							<td><div class="bsImg">
									<img src="<?php echo $v['img1'] ?>">
								</div></td>
							<td><?php echo $v['name'] ?></td>
							<td><?php echo $v['sell_price'] ?></td>
							<td><?php echo $v['up_time'] ?></td>
							<td><?php echo $v['nums'] ?></td>
							<td><?php echo $v['point'] ?></td>
							<td><?php echo $v['favorite'] ?></td>
							<td><?php echo $v['sale'] ?></td>
							<td><?php echo $v['is_fee']?'是':'否' ?></td>
							<td><img id="status" src="/public/img/<?php echo $v['status']?'yes.gif':'no.gif' ?>" alt="<?php echo $v['status'] ?>"/</td>
							
							<td><a href="/goods/update_goods?id=<?php echo $v['id'] ?>"><img class="operation"
									src="/public/img/update.png"></a></td>
						</tr>
						<?php endforeach ?>
						</tbody>
					</table>
					<div class="paging" id="page"><?php echo $data['page'] ?></div>
				</div>
				<input type="hidden" value="<?php echo $data['totlepage'] ?>" id="totlepage" />
				<input type="hidden" value="<?php echo $data['p'] ?>" id="p" />
				<input type="hidden" value="" id="key" />
				<input type="hidden" value="" id="order" />
				<!-- banner 表格 显示 end-->
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
// 商品弹出框
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
	$(document).on('click','#status',function(){
		var id = $(this).parents('tr').children('td').eq(0).text();
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
			url:"/goods/update_status",
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
	$(document).on('click','#page a,.button,.order',function(event){
		event.preventDefault();
		var p = $(this).text();
		var search = $('#search').val();
		var key = $('#key').val();
		var order = $('#order').val();
		if(p == "首页"){
			p=1;
		}else if(p == "尾页"){
			p = $("#totlepage").val();
		}else if(p == "搜索"){
			p = 1;
		}else{
			p = 1;
			if(key == "" && order == ""){
				key = $(this).attr('name');
				order = $(this).attr('id');
			}
			
		}
		$.ajax({
				type:'post',
				url:'/goods/goods_list',
				data:{p:p,search:search,key:key,order:order},
				dataType:'json',
				success:function(data){
					if(data == 0){
						alert('搜索条件不存在');
						history.go(0);
					}
					$('#tbody').empty();
					$.each(data.res,function(k,v){
						var tr = $('<tr height="40px"></tr>');
						tr.append('<td>'+v.id+'</td>');
						tr.append('<td><div class="bsImg"><img src="'+v.img1+'"></div></td>');
						tr.append('<td>'+v.name+'</td>');
						tr.append('<td>'+v.sell_price+'</td>');
						tr.append('<td>'+v.up_time+'</td>');
						tr.append('<td>'+v.nums+'</td>');
						tr.append('<td>'+v.point+'</td>');
						tr.append('<td>'+v.favorite+'</td>');
						tr.append('<td>'+v.sale+'</td>');
						if(v.is_fee == 1){
							var is_fee = '是';
						}else{
							var is_fee = "否";
						}
						tr.append('<td>'+is_fee+'</td>');
						if(v.status == 1){
							var status = 'yes.gif';
						}else{
							var status = "no.gif";
						}
						tr.append('<td><img id="status" src="/public/img/'+status+'"/></td> alt="'+v.status+'"');
						tr.append('<td><a href="/goods/update_goods?id='+v.id+'"><img class="operation" src="/public/img/update.png"></a></td>');
						$("#tbody").append(tr);
					})
					$('#page').html(data.page);
					$('#totlepage').val(data.totlepage);
					$('#p').val(data.p);
					$('#key').val(data.key);
					$('#order').val(data.order);
				}
			})
	})
})

</script>
</html>