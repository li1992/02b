<?php 

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\AdminModel;
use yii\web\Page;
class AdminController extends BaseController{
	/**
	 * 管理员列表
     * admin_list action.
     * params 
     * type get
     * @return array管理员数据
     */
	public function actionAdmin_list(){
        $request = yii::$app->request;
        $p = $request->post('p',1);
        $search = $request->post('search','');
		$model = new AdminModel;
		$data = $model->getAdmin($p,$search);

        
        if($request->isAjax){
            echo json_encode($data);
            return;
        }
		return $this->renderpartial('admin_list',['data'=>$data]);
	}
	/**
	 * 管理员添加
     * admin_add action.
     * params uname pwd
     * type ajax-post
     * @return 0添加失败 2用户名已被占用 array 管理员数据 
     */
	public function actionAdmin_add(){
		$request = yii::$app->request;
		$data = $request->post();
		$data['c_time'] = date('Y-m-d H:i:s',time());
		$model = new AdminModel;
		$data = $model->admin_add($data);
		echo json_encode($data);
	}
	/**
	 * 是否禁用管理员
     * update_status action.
     * params id status
     * type ajax-post
     * @return 0修改失败 1修改成功 
     */
    public function actionUpdate_status(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$model = new AdminModel;
    	$data = $model->update_status($data);
    	echo $data;
    }
    /**
	 * 修改管理员密码页面
     * update_pwd action.
     * params 
     * type get
     * @return 
     */
    public function actionUpdate_pwd(){
    	return $this->renderpartial("update_pwd");
    }
    /**
	 * 修改管理员密码
     * update_pwd_do action.
     * params id oldpwd newpwd qpwd
     * type post
     * @return 0修改失败 1修改成功 2原密码错误 3两次输入密码不一致
     */
    public function actionUpdate_pwd_do(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$session = yii::$app->session;
    	$id = $session->get('admin_id');
    	$model = new AdminModel;
    	$data = $model->update_pwd($data,$id);
    	$arr = array(
    			0=>'修改密码失败',
    			2=>'输入密码错误',
    			3=>'两次输入密码不一致',

    		);
    	if($data == 1){
    		$session = yii::$app->session;
    		$session->removeAll();
    		echo "<script>alert('修改成功');history.go(0)</script>";
    	}else{
    		echo "<script>alert('$arr[$data]');history.go(-1)</script>";
    	}
    }
}


 ?>