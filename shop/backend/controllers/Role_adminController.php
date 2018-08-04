<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\Role_adminModel;
class Role_adminController extends BaseController{
	/**
	 * 进入为角色分配管理员页面
     * Role_admin action.
     * params role_id role_name
     * type get
     * @return array管理员数据
     */
	public function actionRole_admin(){
		$request = yii::$app->request;
		$data['name'] = $request->get('name');
		$id = $request->get('id');
		$model = new Role_adminModel;
		$data['admin_name'] = $model->getAdminName($id);
		$data['id'] = $id;
		
		return $this->renderpartial('role_admin',['data'=>$data]);
	}
	/**
	 * 为角色分配管理员
     * add_admin action.
     * params role_id admin_id
     * type ajax-post
     * @return 0 分配失败 null当前角色已分配给所有管理员 array除已分配此角色的管理员
     */
	public function actionAdd_admin(){
		$request = yii::$app->request;
		$str = $request->post('str');
		$role_id = $request->post('role_id');
		$model = new Role_adminModel;
		$data = $model->add_admin($role_id,$str);
		echo json_encode($data);
	}
	/**
	 * 进入管理对应角色用户组页面
     * Del_admin action.
     * params role_id
     * type get
     * @return array 管理员数据
     */
	public function actionDel_admin(){
		$request = yii::$app->request;
		$role_id = $request->get('role_id');
		$data['name'] = $request->get('role_name');
		$model = new Role_adminModel;
		$data['admin_name'] = $model->del_admin($role_id);
		$data['id'] = $role_id;
		
		return $this->renderpartial('del_admin',['data'=>$data]);
	}
	/**
	 * 移除当前角色下的管理员
     * Del_admin_do action.
     * params role_id admin_id
     * type ajax-post
     * @return 0 移除失败 null当前角色没有管理员 array当前角色下的用户组
     */
	public function actionDel_admin_do(){
		$request = yii::$app->request;
		$str = $request->post('str');
		$role_id = $request->post('role_id');
		$model = new Role_adminModel;
		$data = $model->del_admin_do($role_id,$str);
		return json_encode($data);
	}
}

 ?>