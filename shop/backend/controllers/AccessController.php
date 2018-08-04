<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\AccessModel;
header('content-type:text/html;charset=utf-8');
class AccessController extends BaseController{
	/**
	 * 权限列表
     * access_list action.
     * params 
     * type get
     * @return array管理员数据
     */
	public function actionAccess_list(){
		$request = yii::$app->request;
        $p = $request->post('p',1);
        $search = $request->post('search','');
		$model = new AccessModel;
		$data = $model->getAccess($p,$search);
		if($request->isAjax){
            echo json_encode($data);
            return;
        }
        // print_r($data);die;
        return $this->renderpartial('access_list',['data'=>$data]);
	}
    /**
     * 权限添加
     * access_add action.
     * params access_name access_url parent_id path
     * type ajax-post
     * @return 0添加失败 2权限名已被占用 array 权限数据 
     */
    public function actionAccess_add(){
        $request = yii::$app->request;
        $data = $request->post();
        $model = new AccessModel;
        $data = $model->access_add($data);
        echo json_encode($data);
    }
}

 ?>