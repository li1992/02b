<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;

class NoticeModel extends Model{
	public function notice_list($p,$search){
		$Page = new Page();
		$where = "where title like '%$search%' or id='$search'";
		$data = $Page->page($p,'notice',3,$where);
		return $data;
	}
	public function add_do($data){
		$title = $data['title'];
		$sql = "select * from notice where title='$title'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$data['time'] = date("Y-m-d H:i:s",time());
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into notice({$key}) value('{$val}')";
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
		$sql = "update notice set {$update} where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function update_notice($id){
		$sql = "select * from notice where id=$id";
		$data['notice'] = yii::$app->db->createCommand($sql)->queryone();
		if($data['notice'] != ""){
			return $data;
		}else{
			return 0;
		}
	}
		public function update_do($data){
			$id = $data['id'];
			unset($data['id']);
			$title = $data['title'];
			$sql = "select * from notice where title='$title' and id!=$id";
			$res = yii::$app->db->createCommand($sql)->queryone();
			if($res){
				return 3;
			}
			$str = "";
			foreach ($data as $key => $v) {
				$str.= ','.$key."='".$v."'";
			}
			$str = substr($str,1);
			$sql = "update notice set {$str} where id=$id";
			$data = yii::$app->db->createCommand($sql)->execute();
			if($data){
				return 1;
			}
			return 0;
		}
}



 ?>