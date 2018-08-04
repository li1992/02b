<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\RoleModel;
header('content-type:text/html;charset=utf-8');
class RoleController extends BaseController{
	/**
	 * 角色列表
     * role_list action.
     * params 
     * type get
     * @return array角色数据
     */
	public function actionRole_list(){
		$request = yii::$app->request;
        $p = $request->post('p',1);
        $search = $request->post('search','');
        $model = new RoleModel;
		$data = $model->getRole($p,$search);
		if($request->isAjax){
            echo json_encode($data);
            return;
        }
		return $this->renderpartial('role_list',['data'=>$data]);
	}


	/**
	 * 角色添加
     * role_add action.
     * params role_name
     * type ajax-post
     * @return 0添加失败 2角色名为空 3角色名已存在array角色数据
     */
	public function actionRole_add(){
		$request = yii::$app->request;
		$role_name = $request->post('role_name');
		
		$model = new RoleModel;
		$data = $model->role_add($role_name);
		echo json_encode($data);
	}
}


 ?>