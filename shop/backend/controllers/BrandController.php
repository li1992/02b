<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\BrandModel;

class BrandController extends BaseController{
	/**
	 * 品牌列表
     * Brand_list action.
     * params p
     * type get
     * @return array 品牌数据
     */
	public function actionBrand_list(){
		$request = yii::$app->request;
		$p = $request->post('p',1);
		$search = $request->post('search','');
		$model = new BrandModel;
		$data = $model->brand_list($p,$search);
		
		if($request->isAjax){
            return json_encode($data);
        }
		return $this->renderpartial('brand_list',['data'=>$data]);
	}
	/**
	 * 添加品牌页面
     * Brand_add action.
     * params 
     * type get
     * @return array 广告位数据
     */
	public function actionBrand_add(){
		$model = new BrandModel;
		$data = $model->brand_add();
		return $this->renderpartial('brand_add',['data'=>$data]);
	}
	/**
	 * 添加品牌
     * Add_do action.
     * params 表单元素
     * type post
     * @return 0添加失败 1添加成功 2表单元素为空 3品牌名称已被占用
     */
	public function actionAdd_do(){
		$request = yii::$app->request;
		$data = $request->post();

		if(in_array('',$data) || empty($data['type_id'])){
			echo "<script>alert('元素不能为空');history.go(-1)</script>";die;
		}
		$data['type_id'] = implode(',',$data['type_id']);
		$img = $this->upload($_FILES['img']);
		if(!strpos($img,'/')){
			echo "<script>alert('$img');history.go(-1)</script>";die;
		}
		$data['logo'] = '/'.$img;
		$model = new BrandModel;
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
	 * 删除品牌
     * brand_delete action.
     * params id
     * type ajax-post
     * @return 0删除失败 1删除成功 
     */
	public function actionBrand_delete(){
		$request = yii::$app->request;
		$data = $request->post();
		$data['p'] = intval($data['p']);
		$model = new BrandModel;
		$data = $model->brand_delete($data);
		return json_encode($data);
	}
	/**
	 * 进入修改品牌页面
     * update_brand action.
     * params id 
     * type get
     * @return 0查找失败 array对应品牌数据
     */
    public function actionUpdate_brand(){
    	$request = yii::$app->request;
    	$id = $request->get('id');
    	$model = new BrandModel;
    	$data = $model->update_brand($id);
    	if(!$data){
    		echo "<script>alert('该品牌不存在');history.go(-1)</script>";
    	}

    	return $this->renderpartial('update_brand',['data'=>$data]);
    }
    /**
	 * 修改品牌
     * Update_do action.
     * params 表单元素
     * type post
     * @return 0修改失败 1修改成功 2表单元素为空 3品牌名称已被占用
     */
    public function actionUpdate_do(){
    	$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data) || empty($data['type_id'])){
			return "<script>alert('元素不能为空');history.go(-1)</script>";
		}
		if($_FILES['img']['name'] != ""){
			$img = $this->upload($_FILES['img']);
			if(!strpos($img,'/')){
				return "<script>alert('$img');history.go(-1)</script>";
			}
			$data['logo'] = '/'.$img;
		}
		$data['type_id'] = str_replace("'","",implode(',',$data['type_id']));
		$model = new BrandModel;
		$data = $model->update_do($data);
		if($data == 1){
			return "<script>alert('修改成功');history.go(-2)</script>";
		}elseif($data == 3){
			return "<script>alert('品牌名称已被占用');history.go(-1)</script>";
		}else{
			return "<script>alert('修改失败');history.go(-1)</script>";
		}
    }
}


 ?>