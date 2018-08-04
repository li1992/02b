<?php 

namespace backend\models;
use yii;
use yii\base\Model;
use yii\web\Page;

class BrandModel extends Model{
	public function brand_list($p,$search){
		$Page = new Page();
		$where = "where status=1 and name like '%$search%' or id='$search'";
		$data = $Page->page($p,'brand',12,$where);
		if($data){
			foreach ($data['res'] as $key => $v) {
				$data['res'][$key]['intro'] = strlen($v['intro'])>60?mb_substr($v['intro'],0,20,'utf-8').'...':$v['intro'];
			}
		}
		
		return $data;
	}
	public function brand_add(){
		$sql = "select *,concat(path,'-',id) as newpath from type where status=1 order by newpath";
		$data = yii::$app->db->createCommand($sql)->queryall();
		return $data;
	}
	public function add_do($data){
		$name = $data['name'];
		$sql = "select * from brand where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return 3;
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into brand({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return 1;
		}
		return 0;
	}
	public function brand_delete($data){
		$id = $data['id'];
		$sql = "update brand set status=0 where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			$data = $this->brand_list($data['p']);
			return $data;
		}
		return $data;
	}
	public function update_brand($id){
		$sql = "select * from brand where id=$id";
		$data['brand'] = yii::$app->db->createCommand($sql)->queryone();
		if($data['brand'] != ""){
			$type_id = $data['brand']['type_id'];
			$sql = "select id,name,path,concat(path,'-',id) as newpath from type where status=1 and id not in($type_id) order by newpath";
			$data['type'] = yii::$app->db->createCommand($sql)->queryall();
			$sql = "select id,name,path from type where id in($type_id)";
			$data['check_type'] = yii::$app->db->createCommand($sql)->queryall();
			return $data;
		}else{
			return 0;
		}
	}
		public function update_do($data){
			$id = $data['id'];
			unset($data['id']);
			$name = $data['name'];
			$sql = "select * from brand where name='$name' and id!=$id";
			$res = yii::$app->db->createCommand($sql)->queryone();
			if($res){
				return 3;
			}
			$str = "";
			foreach ($data as $key => $v) {
				$str.= ','.$key."='".$v."'";
			}
			$str = substr($str,1);
			$sql = "update brand set {$str} where id=$id";
			$data = yii::$app->db->createCommand($sql)->execute();
			if($data){
				return 1;
			}
			return 0;
		}
}

 ?>