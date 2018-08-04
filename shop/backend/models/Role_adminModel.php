<?php 
namespace backend\models;
use yii;
use yii\base\Model;
header('content-type:text/html;charset=utf-8');
class Role_adminModel extends Model{
	public function getAdminName($role_id){
		$sql = "select admin_id from admin_role where role_id=$role_id";
		$admin_id = yii::$app->db->createCommand($sql)->queryall();
		$sql = "select uname,id from admin where status=1 and id>1";
		$arr = [];
		if(is_array($admin_id)){
			for ($i=0; $i < count($admin_id); $i++) { 
				$sql.=' and id!='.$admin_id[$i]['admin_id'];
			}
		}
		$data = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function add_admin($role_id,$admin_id){
		$sql = "insert into admin_role(role_id,admin_id) values($role_id,$admin_id)";
		if(strlen($admin_id)!=1){
			$admin_id = explode(',',$admin_id);
			$sql = "insert into admin_role(role_id,admin_id) values";
			
			for ($i=0; $i < count($admin_id); $i++) { 
				$sql.= '('.$role_id.','.$admin_id[$i].'),';
			}
			$sql = substr($sql,0,-1);
		}
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->getAdminName($role_id);
		}
		return $data;
		
	}
	public function del_admin($role_id){
		$sql = "select admin_id from admin_role where role_id=$role_id";
		$admin_id = yii::$app->db->createCommand($sql)->queryall();
		if(!$admin_id){
			return 0;
		}
		
		$str = "";
		if($admin_id != ""){
			for ($i=0; $i < count($admin_id); $i++) { 
				$str .= ','.$admin_id[$i]['admin_id'];
			}
			$str = substr($str,1);
			$sql = "select uname,id from admin where status=1 and id in({$str})";
			$data = yii::$app->db->createCommand($sql)->queryall();
		}
		return $data;
		
	}
	public function del_admin_do($role_id,$admin_id){
		$sql = "delete from admin_role where role_id=$role_id and admin_id=$admin_id";
		if(strlen($admin_id)!=1){	
			$sql = "delete from admin_role where role_id=$role_id and admin_id in({$admin_id})";
		}
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->del_admin($role_id);
		}
		return $data;
	}
}



 ?>