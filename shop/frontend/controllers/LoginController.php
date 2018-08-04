<?php 
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
class LoginController extends Controller{
	//登录页面
	public function actionLogin(){
		return $this->renderpartial('login');
	}
	//注册页面
	public function actionRegist(){
		return $this->renderpartial('regist');
	}
}


 ?>