<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\Adver_positionModel;

class Adver_positionController extends BaseController{
	/**
	 * 广告位列表
     * Adver_position action.
     * params p
     * type get
     * @return array广告位数据
     */
	public function actionAdver_position(){
		$request = yii::$app->request;
		$p = $request->post('p',1);
		$model = new Adver_positionModel;
		$data = $model->adver_position($p);
		 if($request->isAjax){
            echo json_encode($data);return;
        }
		return $this->renderpartial('adver_position',['data'=>$data]);
	}
	/**
	 * 添加广告位页面
     * Position_add action.
     * params 
     * type get
     * @return 
     */
	public function actionPosition_add(){
		return $this->renderpartial('position_add');
	}
	/**
	 * 添加广告位
     * Add_do action.
     * params 表单元素
     * type ajax-post
     * @return 0添加失败 1添加成功 2表单元素为空 3广告位名称已被占用
     */
	public function actionAdd_do(){
		$request = yii::$app->request;
		$data = $request->post();
		if(in_array("",$data)){
			return 2;
		}
		$model = new Adver_positionModel;
		$data = $model->add_do($data);
		return $data;
	}
	/**
	 * 是否启用广告位
     * update_status action.
     * params id status
     * type ajax-post
     * @return 0修改失败 1修改成功 
     */
    public function actionUpdate_status(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$model = new Adver_positionModel;
    	$data = $model->update_status($data);
    	echo $data;
    }
    /**
	 * 修改广告位信息
     * Update_position action.
     * params 表单元素
     * type ajax-post
     * @return 0修改失败 1修改成功 2表单元素为空 3广告位名称已被占用
     */
    public function actionUpdate_position(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	if(in_array("",$data)){
			return 2;
		}
    	$model = new Adver_positionModel;
    	$data = $model->update_position($data);
    	echo $data;
    }
}


 ?>