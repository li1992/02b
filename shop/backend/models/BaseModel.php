<?php 

namespace backend\models;
use yii;
use yii\base\Model;

class BaseModel extends Model{
	public function getrole_id($admin_id){
		$sql = "select role_id from admin_role where admin_id=$admin_id";
		$data = yii::$app->db->createCommand($sql)->queryall();
		if($data){
			$str = "";
			for ($i=0; $i < count($data); $i++) { 
				$str.=','.$data[$i]['role_id'];
				$str = substr($str,1);
				return $str;
			}
		}else{
			return 0;
		}
	}
	public function getaccess_id($role_id){
		$sql = "select access_id from role_access where role_id in($role_id)";
		$data = yii::$app->db->createCommand($sql)->queryall();
		if($data){
			$str = "";
			for ($i=0; $i < count($data); $i++) { 
				$str.=','.$data[$i]['access_id'];
			}
			$str = substr($str,1);
			return $str;
		}else{
			return 0;
		}

	}
	public function getaccess_url($access_id){
		$sql = "select access_url from access where id in($access_id)";
		$data = yii::$app->db->createCommand($sql)->queryall();
		$arr = [];
		for ($i=0; $i < count($data); $i++) { 
			$arr[$i] = $data[$i]['access_url'];
		}
		return $arr;
		
		
	}
}


 ?>