<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\Role_accessModel;

class Role_accessController extends BaseController{
	/**
	 * 进入为角色分配权限页面
     * Role_access action.
     * params role_id role_name
     * type get
     * @return array 权限数据
     */
	public function actionRole_access(){
		$request = yii::$app->request;
		$data['name'] = $request->get('name');
		$id = $request->get('id');
		$model = new Role_accessModel;
		$data['access'] = $model->role_access($id);
		$data['id'] = $id;
		return $this->renderpartial('role_access',['data'=>$data]);
	}
	/**
	 * 为角色分配权限
     * Add_access action.
     * params role_id access_id
     * type ajax-post
     * @return 0 分配失败 array 权限数据
     */
	public function actionAdd_access(){
		$request = yii::$app->request;
		$str = $request->post('str');
		$role_id = $request->post('role_id');
		$model = new Role_accessModel;
		$data = $model->add_access($role_id,$str);
		echo json_encode($data);
	}
	/**
	 * 进入管理对应角色权限页面
     * Del_access action.
     * params role_id
     * type get
     * @return array 权限数据
     */
	public function actionDel_access(){
		$request = yii::$app->request;
		$role_id = $request->get('role_id');
		$data['name'] = $request->get('role_name');
		$model = new Role_accessModel;
		$data['access'] = $model->del_access($role_id);
		$data['id'] = $role_id;
		
		return $this->renderpartial('del_access',['data'=>$data]);
	}
	/**
	 * 移除当前角色下的权限
     * Del_access_do action.
     * params role_id access_id
     * type ajax-post
     * @return 0 移除失败 null当前角色没有管理员 array当前角色下的权限
     */
	public function actionDel_access_do(){
		$request = yii::$app->request;
		$str = $request->post('str');
		$role_id = $request->post('role_id');
		$model = new Role_accessModel;
		$data = $model->del_access_do($role_id,$str);
		echo json_encode($data);
	}
}


 ?>