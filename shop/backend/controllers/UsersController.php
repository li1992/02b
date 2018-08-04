<?php 
namespace backend\controllers;
use yii;
use yii\web\Controller;

class UsersController extends Controller{
	public function actionLogin(){
		return $this->renderpartial('login');
	}
	public function actionLogin_do(){
		$request = yii::$app->request;
		$name = $request->post('name');
		$pwd = $request->post('pwd');
		$sql = "select name from users where name='$name' and pwd='$pwd'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return $this->redirect('/users/show');
		}
		return "<script>alert('对不起,登录失败');history.go(-1)</script>";
	}
	public function actionRegist(){
		return $this->renderpartial('regist');
	}
	public function actionRegist_do(){
		$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			return "<script>alert('对不起,元素不能为空');history.go(-1)</script>";
		}
		if(!preg_match('/^[\x{4e00}-\x{9fa5}]{4,6}$/u',$data['name'])){
			return "<script>alert('用户名为4-6位中文');history.go(-1)</script>";
		}
		if(!preg_match('/^\w{8,16}$/',$data['pwd'])){
			return "<script>alert('密码为8-16位英文数字');history.go(-1)</script>";
		}
		if(!preg_match('/^(131|135|138|151|170|171|186)\d{8}$/',$data['tel'])){
			return "<script>alert('请输入正确的手机号码');history.go(-1)</script>";
		}
		if(!preg_match('/^\w+@\w+(.com|.cn|.net)$/',$data['email'])){
			return "<script>alert('请输入正确的邮箱');history.go(-1)</script>";
		}
		$name = $data['name'];
		$sql = "select name from users where name='$name'";
		$res = yii::$app->db->createCommand($sql)->queryone();
		if($res){
			return "<script>alert('对不起,用户名已被注册');history.go(-1)</script>";
		}
		$key = implode(',',array_keys($data));
		$val = implode("','",array_values($data));
		$sql = "insert into users({$key}) value('{$val}')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return $this->redirect('/users/show');
		}
		return "<script>alert('对不起,注册失败');history.go(-1)</script>";
	}
	public function actionShow(){
		$request = yii::$app->request;
		$p = $request->post('p',1);
		$name = $request->post('name');
		$order = $request->post('order');
		$size = 3;
		$sql = "select count(*) from goods where status=1";
		$res = yii::$app->db->createCommand($sql)->queryone();
		$count = $res['count(*)'];
		$totle = ceil($count/$size);
		$offset = ($p-1)*$size;
		$sql = "select id,name,img1,sell_price,sale from goods where status=1 limit $offset,$size";
		if($name != '' && $order != ''){
			$sql = "select id,name,img1,sell_price,sale from goods where status=1 order by $name $order limit $offset,$size";
		}
		$data['data'] = yii::$app->db->createCommand($sql)->queryall();
		$str = "";
		for ($i=1; $i <= $totle; $i++) { 
			if($i == $p){
				$str.= "&nbsp;".$i;
			}else{
				$str.= "&nbsp;<a href='#'>".$i."</a>";
			}
		}
		$first = "<a href='#'>首页</a>&nbsp;";
		$last = '&nbsp;<a href="#">尾页</a>';
		$data['page'] = $first.$str.$last;
		$data['totle'] = $totle;
		if($request->isAjax){
			return json_encode($data);
		}
		return $this->renderpartial('show',['data'=>$data]);
	}
	public function actionDel(){
		$request = yii::$app->request;
		$id = $request->post('id');
		$sql = "update goods set status=0 where id=$id";
		$data = yii::$app->db->createCommand($sql)->execute();
		return $data;
	}
	public function actionAdd(){
		return $this->renderpartial('add');
	}
	public function actionAdd_do(){
		$request = yii::$app->request;
		$name = $request->post('name');
		$sell_price = $request->post('sell_price');
		$tmp_name  = $_FILES['img1']['tmp_name'];
		$path = '/'.$_FILES['img1']['name'];
		$data = move_uploaded_file($tmp_name,$path);
		$img1 = $path;
		$sql = "insert into goods (name,sell_price,img1) value('$name','$sell_price','$img1')";
		$data = yii::$app->db->createCommand($sql)->execute();
		if($data){
			return "<script>alert('添加成功');history.go(-2)</script>";
		}else{
			return "<script>alert('对不起,添加失败');history.go(-1)</script>";
		}
		
	}
}



 ?>