<?php 
namespace backend\models;
use yii;
use yii\web\Page;
use yii\base\Model;

class RoleModel extends Model{
	public function getRole($p,$search){
		$Page = new Page();
		$where = "where role_name like '%$search%' or id='$search'";
		$data = $Page->page($p,'role',3,$where);
		return $data;
	}
	public function role_add($role_name){
		if($role_name == ""){
			return 2;
		}
		$sql = "select * from role where role_name='$role_name'";
		$data = yii::$app->db->createCommand($sql)->queryone();
		if($data){
			return 3;
		}
		$sql = "insert into role(role_name) value('$role_name')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->getRole(1,'');
			return $data;
		}
		return 0;
	}
}


 ?>