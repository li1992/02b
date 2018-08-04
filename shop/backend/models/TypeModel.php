<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;

class TypeModel extends Model{
	public function type_list(){
		$sql = "select * from type where parent_id=0";
		$data = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function add_do($data){
		$name = $data['name'];
		$sql = "select * from type where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into type({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return 1;
		}
		return 0;
	}
	public function show_type($id){
		$sql = "select *,concat(path,'-',id) as newpath from type where type=$id group by newpath order by newpath";
		$data = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function add_type($data){
		$name = $data['name'];
		$sql = "select * from type where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into type({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$id = yii::$app->db->getLastInsertID();
			return $id;
		}
		return $data;
		
		
	}
	public function add_type3($data){
		$name = $data['name'];
		$parent_id = $data['parent_id'];
		$sql = "select * from type where name='$name' and parent_id=$parent_id";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 2;
		}
		$data['path'] = $data['path'].'-'.$data['parent_id'];
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into type({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$id = yii::$app->db->getLastInsertID();
			return $id;
		}
		return $data;
	}
	public function update_status($data){
		if($data['status'] == 1){
			$update = "status=0";
		}else{
			$update = "status=1";
		}
		$id = $data['id'];
		$sql = "update type set {$update} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function update_info($data){
		$id = $data['id'];
		unset($data['id']);
		$name = $data['name'];
		$sql = "select * from type where name='$name' and id!=$id";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$str = "";
		foreach ($data as $key => $v) {
			$str.= ','.$key."='".$v."'";
		}
		$str = substr($str,1);
		$sql = "update type set {$str} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return 1;
		}
		return 0;
	}
}



 ?>