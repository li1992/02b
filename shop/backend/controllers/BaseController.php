<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\BaseModel;
header('content-type:text/html;charset=utf8');
class BaseController extends Controller{
	/**
	 * 防非法登录 RBAC权限验证
     * init action.
     * params 
     * type get
     * @return 
     */
	public function init(){
		// parent::__construct();
		parent::init();

		$session = \Yii::$app->session;
		$admin_id = $session->get('admin_id');
		if(!$admin_id){
			echo "<script>alert('请先登录')</script>";
			return $this->redirect('/site/index');
		}
		$url = $_SERVER['REQUEST_URI'];
		if(strpos($url,'?')){
			$offset = strpos($url,'?');
			$url = substr($url,0,$offset);
		}
		if($admin_id != 1 && $url != '/index/index'){
			$model = new BaseModel;
			$role_id = $model->getrole_id($admin_id);
			if($role_id == 0){
				echo "<script>alert('对不起,您无权限访问');history.go(-1)</script>";die;
			}
			$access_id = $model->getaccess_id($role_id);
			if($access_id == 0){
				echo "<script>alert('对不起,您无权限访问');history.go(-1)</script>";die;
			}
			$access_url = $model->getaccess_url($access_id);
			if(!in_array($url,$access_url)){
				echo "<script>alert('对不起,您无权限访问');history.go(-1)</script>";die;
			}
		}
	}
	public function upload($img){
		$path = $this->mkdir();
		$arr = array(
    		1=>'上传的文件超过了 php.ini 中 upload_max_filesize选项限制的值',
    		2=>'上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
    		3=>'只有部分文件被上传',
    		4=>'没有文件被上传',
    	);
    	$array = array('.jpg', '.gif', '.png', '.jpeg');
		if(array_key_exists($img['error'],$arr)){
			$error = $img['error'];
			return $arr[$error];
		}
		$name = $img['name'];
		$offset = strpos($name,'.');
		$type = strtolower(substr($name,$offset));
		if(!in_array($type,$array)){
			return "上传文件格式错误";
		}
		$math = rand(0,999);
		$address = $path.'/'.time().$math.$type;
		$tmp_name = $img['tmp_name'];
		$res = move_uploaded_file($tmp_name,$address);
		if($res){
			return $address;
		}
	}
	public function mkdir(){
		$path = "shop/upload/".date("Y").'/'.date("m").'/'.date('d');
			if (is_dir($path)){ 
				return $path;
			}else{
				$res=mkdir($path,0777,true); 
			if ($res){
				return $path;
			}
		}
	}
	
}


 ?>