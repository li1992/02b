<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;

class GoodsModel extends Model{
	public function Goods_list($p,$search,$key,$order){
		$Page = new Page();
		$where = "where name like '%$search%' or id='$search'";
		if($key != "" && $order != ""){
			$where = "where name like '%$search%' or id='$search' order by $key $order";
			if($order == 'asc'){
				$order = 'desc';
			}else{
				$order = 'asc';
			}
		}
		$data = $Page->page($p,'goods',3,$where);
		$data['key'] = $key;
		$data['order'] = $order;
		return $data;
	}
	public function goods_add(){
		$sql = "select id,name,path,concat(path,'-',id) as newpath from type where status=1 order by newpath";
		$data['type'] = yii::$app->db->createCommand($sql)->queryall();
		$sql = "select id,name from brand where status=1";
		$data['brand'] = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function add_do($data){
		$name = $data['name'];
		$sql = "select * from goods where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into goods({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return 1;
		}
		return 0;
	}
	public function update_status($data){
		if($data['status'] == 1){
			$date = date("Y-m-d H:i:s",time());
			$update = "status=0,down_time='$date'";
		}else{
			
			$update = "status=1,down_time=null";
		}
		$id = $data['id'];
		$sql = "update goods set {$update} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function update_goods($id){
		$sql = "select * from goods where id=$id";
		$data['goods'] = yii::$app->db->createCommand($sql)->queryone();
		if($data['goods'] != ""){
			$type_id = $data['goods']['type_id'];
			$sql = "select id,name,path,concat(path,'-',id) as newpath from type where status=1 and id not in($type_id) order by newpath";
			$data['type'] = yii::$app->db->createCommand($sql)->queryall();
			$sql = "select id,name,path from type where id in($type_id)";
			$data['check_type'] = yii::$app->db->createCommand($sql)->queryall();
			$sql = "select id,name from brand where status=1";
			$data['brand'] = yii::$app->db->createCommand($sql)->queryall();
			return $data;
		}else{
			return 0;
		}
	}
	public function update_do($data){
		$id = $data['id'];
		unset($data['id']);
		$name = $data['name'];
		$sql = "select * from goods where name='$name' and id!=$id";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$str = "";
		foreach ($data as $key => $v) {
			$str.= ','.$key."='".$v."'";
		}
		$str = substr($str,1);
		$sql = "update goods set {$str} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return 1;
		}
		return 0;
	}
}



 ?>