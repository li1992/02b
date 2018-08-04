<?php 
namespace backend\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends BaseController{
	/**
	 * 后台首页
     * index action.
     * params 
     * type get
     * @return array 管理员名称
     */
	public function actionIndex(){
		$request = Yii::$app->request;
		if($request->isAjax){
			return $this->redirect('site/index');
		}
		$session = \Yii::$app->session;
		$admin_name = $session->get('admin_name');
		return $this->renderpartial('index',['admin_name'=>$admin_name]);
	}

}


 ?>