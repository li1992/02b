<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;
class Adver_positionModel extends Model{
	public function adver_position($p){
		$Page = new Page();
		$data = $Page->page($p,'adver_position',3,'');
		return $data;
	}
	public function add_do($data){
		$name = $data['name'];
		$sql = "select * from adver_position where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into adver_position({$key}) value('{$val}')";
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
		$sql = "update adver_position set {$update} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function update_position($data){
		$id = $data['id'];
		unset($data['id']);
		print_r($data);die;
		$name = $data['name'];
		$sql = "select * from adver_position where name='$name' and id!=$id";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$str = "";
		foreach ($data as $key => $v) {
			$str.= ','.$key."='".$v."'";
		}
		$str = substr($str,1);
		$sql = "update adver_position set {$str} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
}


 ?>