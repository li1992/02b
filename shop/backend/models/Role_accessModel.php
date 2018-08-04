<?php 

namespace backend\models;
use yii;
use yii\base\Model;

class Role_accessModel extends Model{
	public function role_access($role_id){
		$sql = "select access_id from role_access where role_id=$role_id order by access_id";
		$access_id = yii::$app->db->createCommand($sql)->queryall();
		$sql = "select *,concat(path,'-',id) as newpath from access order by newpath";
		$data = yii::$app->db->createCommand($sql)->queryall();
		foreach ($data as $key => $v) {
			for ($i=0; $i < count($access_id); $i++) { 
				if($v['id'] == $access_id[$i]['access_id']){
					$data[$key]['is_access'] = 1;
				}
			}
			
		}
		return $data;
	}
	public function add_access($role_id,$access_id){
		$sql = "insert into role_access(role_id,access_id) values($role_id,$access_id)";
		if(strlen($access_id)!=1){
			$access_id = explode(',',$access_id);
			$sql = "insert into role_access(role_id,access_id) values";
			
			for ($i=0; $i < count($access_id); $i++) { 
				$sql.= '('.$role_id.','.$access_id[$i].'),';
			}
			$sql = substr($sql,0,-1);
		}
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->role_access($role_id);
		}
		return $data;
		
	}
	public function del_access($role_id){
		$sql = "select access_id from role_access where role_id=$role_id";
		$access_id = yii::$app->db->createCommand($sql)->queryall();
		if(!$access_id){
			return 0;
		}
		$str = "";
		if($access_id != ""){
			for ($i=0; $i < count($access_id); $i++) { 
				$str .= ','.$access_id[$i]['access_id'];
			}
			$str = substr($str,1);
			$sql = "select *,concat(path,'-',id) as newpath from access where id in({$str}) order by newpath";
			$data = yii::$app->db->createCommand($sql)->queryall();
		}

		return $data;
		
	}
	public function del_access_do($role_id,$access_id){
		$sql = "delete from role_access where role_id=$role_id and access_id=$access_id";
		if(strlen($access_id)!=1){	
			$sql = "delete from role_access where role_id=$role_id and access_id in({$access_id})";
		}
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->del_access($role_id);
		}
		return $data;
	}
}

 ?>