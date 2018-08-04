<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\TypeModel;

class TypeController extends BaseController{
	/**
	 * 分类列表
     * Type_list action.
     * params 
     * type get
     * @return array一级分类数据
     */
	public function actionType_list(){
		$model = new TypeModel;
		$data = $model->type_list();
		return $this->renderPartial('type_list',['data'=>$data]);
	}
	/**
	 * 添加一级分类页面
     * Type_add action.
     * params 
     * type get
     * @return 
     */
	public function actionType_add(){
		return $this->renderPartial('type_add');
	}
	/**
	 * 添加一级分类
     * Add_do action.
     * params 表单元素
     * type post
     * @return 0 添加失败 1添加成功 2元素不能为空 3名称已被占用 
     */
	public function actionAdd_do(){
		$request = yii::$app->request;
		$data = $request->post();
		if($data['name'] == ""){
			return "<script>alert('元素不能为空');history.go(-1)</script>";
		}
		$img = $this->upload($_FILES['img']);
		if(!strpos($img,'/')){
			return "<script>alert('$img');history.go(-1)</script>";
		}
		$data['img'] = '/'.$img;
		$data['parent_id'] = 0;
		$data['path'] = 0;
		$model = new TypeModel;
		$data = $model->add_do($data);
		if($data == 1){
			return "<script>alert('添加成功');history.go(-2)</script>";
		}elseif($data == 3){
			return "<script>alert('分类名称已被占用');history.go(-1)</script>";
		}else{
			return "<script>alert('添加失败');history.go(-1)</script>";
		}
	}
	/**
	 * 展示一级分类下的分类
     * Show_type action.
     * params type_id
     * type get
     * @return array 分类下的数据 
     */
	public function actionShow_type(){
		$request = yii::$app->request;
		$id = $request->get('type');
		$model = new TypeModel;
		$data['res'] = $model->show_type($id);
		$data['type'] = $id;
		return $this->renderpartial('show_type',['data'=>$data]);
	}
	/**
	 * 添加对应一级分类下的二级分类
     * Add_type action.
     * params 分类名称 type_id
     * type ajax-post
     * @return 0 添加失败  2元素不能为空 3名称已被占用 array 分类下的数据 
     */
	public function actionAdd_type(){
		$request = yii::$app->request;
		$data = $request->post();
		if($data['name'] == ""){
			return 2;
		}
		$data['parent_id'] = $data['type'];
		$data['path'] = "0-".$data['type'];
		$model = new TypeModel;
		$res = $model->add_type($data);
		if($res){
			$data['id'] = $res;
			return json_encode($data);
		}
		return $res;
	}
	/**
	 * 添加三级分类
     * Add_type3 action.
     * params name,parent_id,path,type
     * type ajax-post
     * @return 0 添加失败 1 添加成功 2名称已被占用
     */
    public function actionAdd_type3(){
    	$request = yii::$app->request;
		$data = $request->post();
		$model = new TypeModel;
		$res = $model->add_type3($data);
		return $res;
    }
    /**
	 * 是否启用分类
     * update_status action.
     * params id status
     * type ajax-post
     * @return 0修改失败 1修改成功 
     */
    public function actionUpdate_status(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$model = new TypeModel;
    	$data = $model->update_status($data);
    	return $data;
    }
    /**
	 * 修改分类信息
     * Update_info action.
     * params id name
     * type ajax-post
     * @return 0修改失败 1修改成功 2表单元素为空 3分类名称已被占用
     */
    public function actionUpdate_info(){
    	$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			return 2;
		}
		$model = new TypeModel;
		$data = $model->update_info($data);
		return $data;
    }
}



 ?>