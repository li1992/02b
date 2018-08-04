<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;

class AdverModel extends Model{
	public function adver_list($p,$search){
		$Page = new Page();
		$where = "where name like '%$search%' or id='$search'";
		$data = $Page->page($p,'adver',3,$where);
		return $data;
	}
	public function adver_add(){
		$sql = "select * from adver_position";
		$data = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function add_do($data){
		$name = $data['name'];
		$sql = "select * from adver where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into adver({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return 1;
		}
		return 0;
	}
	public function update_status($data){
		if($data['status'] == 1){
			$update = "status=0";
		}else{
			$update = "status=1";
		}
		$id = $data['id'];
		$sql = "update adver set {$update} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function update_adver($id){
		$sql = "select * from adver where id=$id";
		$data['adver'] = yii::$app->db->createCommand($sql)->queryone();
		if($data['adver'] != ""){
			$sql = "select * from adver_position";
			$data['res'] = yii::$app->db->createCommand($sql)->queryall();
			return $data;
		}else{
			return 0;
		}
	}
		public function update_do($data){
			$id = $data['id'];
			unset($data['id']);
			$name = $data['name'];
			$sql = "select * from adver where name='$name' and id!=$id";
			$res = yii::$app->db->createCommand($sql)->queryone();
			if($res){
				return 3;
			}
			$str = "";
			foreach ($data as $key => $v) {
				$str.= ','.$key."='".$v."'";
			}
			$str = substr($str,1);
			$sql = "update adver set {$str} where id=$id";
			$data = yii::$app->db->createCommand($sql)->execute();
			if($data){
				return 1;
			}
			return 0;
		}
	
}

 



 ?>