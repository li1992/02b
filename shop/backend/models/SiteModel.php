<?php 
namespace backend\models;
use yii\base\Model;
use yii;
class SiteModel extends Model{
	public function Login_do($data){
		if(in_array("", $data)){
			return 0;die;
		}
		$uname = $data['uname'];
		$sql = "select * from admin where uname='$uname'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			if($res['status'] == 0){
				return 2;
			}
			$pwd = md5($data['pwd']);
			if($pwd != $res['pwd']){
				return 3;
			}
			return $res;
		}else{
			return 1;
		}
	}
}


 ?>