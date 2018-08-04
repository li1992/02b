<?php 
namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;

class AccessModel extends Model{
	public function getAccess($p,$search){
		$Page = new Page();
		$where = "where access_name like '%$search%' or id='$search'";
		$data = $Page->page($p,'access',3,$where);
		if(!$data){
			return 0;
		}
		$sql = "select *,CONCAT(path,'-',id) as newpath from access order by newpath";
		$data['access_name'] = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function access_add($data){
		$access_name = $data['access_name'];
		$sql = "select access_name from access where access_name='$access_name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 2;
		}
		$data['access_url'] = strtolower($data['access_url']);
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into access ({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->getAccess(1,'');
			$sql = "select *,CONCAT(path,'-',id) as newpath from access order by newpath";
			$data['access_name'] = yii::$app->db->createCommand($sql)->queryall();
			return $data;
		}
		return 0;
	}
}

 ?>