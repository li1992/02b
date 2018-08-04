<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\AdverModel;
use yii\web\UploadedFile;  
class AdverController extends BaseController{
	/**
	 * 广告列表
     * Adver_list action.
     * params p
     * type get
     * @return array广告数据
     */
	public function actionAdver_list(){
		$request = yii::$app->request;
		$p = $request->post('p',1);
		$search = $request->post('search','');
		$model = new AdverModel;
		$data = $model->adver_list($p,$search);
		if($request->isAjax){
            echo json_encode($data);return;
        }
		return $this->renderpartial('adver_list',['data'=>$data]);
	}
	/**
	 * 添加广告页面
     * Adver_add action.
     * params 
     * type get
     * @return array 广告位数据
     */
	public function actionAdver_add(){
		$model = new AdverModel;
		$data = $model->adver_add();
		return $this->renderpartial('adver_add',['data'=>$data]);
	}
	/**
	 * 添加广告
     * Add_do action.
     * params 表单元素
     * type post
     * @return 0添加失败 1添加成功 2表单元素为空 3广告名称已被占用
     */
	public function actionAdd_do(){
		$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			echo "<script>alert('元素不能为空');history.go(-1)</script>";die;
		}
		$img = $this->upload($_FILES['img']);
		if(!strpos($img,'/')){
			echo "<script>alert('$img');history.go(-1)</script>";die;
		}
		$data['img'] = '/'.$img;
		$model = new AdverModel;
		$data = $model->add_do($data);
		if($data == 1){
			echo "<script>alert('添加成功');history.go(-2)</script>";
		}elseif($data == 3){
			echo "<script>alert('广告名称已被占用');history.go(-1)</script>";
		}else{
			echo "<script>alert('添加失败');history.go(-1)</script>";
		}
	}
	/**
	 * 是否启用广告
     * update_status action.
     * params id status
     * type ajax-post
     * @return 0修改失败 1修改成功 
     */
    public function actionUpdate_status(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$model = new AdverModel;
    	$data = $model->update_status($data);
    	echo $data;
    }
    /**
	 * 进入修改广告页面
     * update_adver action.
     * params id 
     * type post
     * @return 0查找失败 array对应广告数据
     */
    public function actionUpdate_adver(){
    	$request = yii::$app->request;
    	$id = $request->get('id');
    	$model = new AdverModel;
    	$data = $model->update_adver($id);
    	if(!$data){
    		echo "<script>alert('该广告不存在');history.go(-1)</script>";
    	}
    	return $this->renderpartial('update_adver',['data'=>$data]);
    }
    /**
	 * 修改广告
     * Update_do action.
     * params 表单元素
     * type post
     * @return 0修改失败 1修改成功 2表单元素为空 3广告名称已被占用
     */
    public function actionUpdate_do(){
    	$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			echo "<script>alert('元素不能为空');history.go(-1)</script>";die;
		}
		if($_FILES['img']['name'] != ""){
			$img = $this->upload($_FILES['img']);
			if(!strpos($img,'/')){
				echo "<script>alert('$img');history.go(-1)</script>";die;
			}
			$data['img'] = '/'.$img;
		}
		$model = new AdverModel;
		$data = $model->update_do($data);
		if($data == 1){
			echo "<script>alert('修改成功');history.go(-2)</script>";
		}elseif($data == 3){
			echo "<script>alert('广告名称已被占用');history.go(-1)</script>";
		}else{
			echo "<script>alert('修改失败');history.go(-1)</script>";
		}
    }
}


 ?>