<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;
class AdminModel extends Model{
	public function getAdmin($p,$search){
		$Page = new Page();
		$where = "where uname like '%$search%' or id='$search'";
		$data = $Page->page($p,'admin',3,$where);
		return $data;
	}
	public function admin_add($data){
		$uname = $data['uname'];
		$sql = "select uname from admin where uname='$uname'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 2;
		}
		$data['pwd'] = md5($data['pwd']);
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		
		$sql = "insert into admin ({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->getAdmin(1,'');
			return $data;
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
		$sql = "update admin set {$update} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function update_pwd($data,$id){
		if($data['newpwd'] != $data['qpwd']){
			return 3;
		}
		$sql = "select pwd from admin where id=$id";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res['pwd']!=md5($data['oldpwd'])){
			return 2;
		}
		$pwd = md5($data['newpwd']);
		$sql = "update admin set pwd='$pwd' where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
}


 ?>