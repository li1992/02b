<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\GoodsModel;

class GoodsController extends BaseController{
	/**
	 * 商品列表
     * Goods_list action.
     * params p
     * type get
     * @return array 商品数据
     */
	public function actionGoods_list(){
		$request = yii::$app->request;
		$p = $request->post('p',1);
		$search = $request->post('search','');
		$key = $request->post('key','');
		$order = $request->post('order','');
		$model = new GoodsModel;
		$data = $model->goods_list($p,$search,$key,$order);
		if($request->isAjax){
            return json_encode($data);
        }
		return $this->renderpartial('goods_list',['data'=>$data]);
	}
	/**
	 * 添加商品页面
     * Goods_add action.
     * params 
     * type get
     * @return array 分类,品牌数据
     */
	public function actionGoods_add(){
		$model = new GoodsModel;
		$data = $model->goods_add();
		return $this->renderpartial('goods_add',['data'=>$data]);
	}
	/**
	 * 添加商品
     * Add_do action.
     * params 表单元素
     * type post
     * @return 0添加失败 1添加成功 2表单元素为空 3商品名称已被占用
     */
    public function actionAdd_do(){
    	$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			return "<script>alert('元素不能为空');history.go(-1)</script>";
		}
		$data['type_id'] = implode(',',$data['type_id']);
		$res = [];
		for ($i=0; $i < count($_FILES['img']['name']); $i++) { 
			$res[$i]['name'] = $_FILES['img']['name'][$i];
			$res[$i]['type'] = $_FILES['img']['type'][$i];
			$res[$i]['tmp_name'] = $_FILES['img']['tmp_name'][$i];
			$res[$i]['error'] = $_FILES['img']['error'][$i];
			$img = $this->upload($res[$i]);
			if(!strpos($img,'/')){
				return "<script>alert('$img');history.go(-1)</script>";
			}
			$n = $i+1;
			$str = 'img'.$n;
			$data[$str] = '/'.$img;
		}
		$model = new GoodsModel;
		$data = $model->add_do($data);
		if($data == 1){
			return "<script>alert('添加成功');history.go(-2)</script>";
		}elseif($data == 3){
			return "<script>alert('商品名称已被占用');history.go(-1)</script>";
		}else{
			return "<script>alert('添加失败');history.go(-1)</script>";
		}
    }
    /**
	 * 修改商品状态
     * update_status action.
     * params id status
     * type ajax-post
     * @return 0修改失败 1修改成功 
     */
    public function actionUpdate_status(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$model = new GoodsModel;
    	$data = $model->update_status($data);
    	return json_encode($data);
    }
    /**
	 * 进入修改商品页面
     * update_goods action.
     * params id 
     * type get
     * @return 0查找失败 array对应商品数据
     */
    public function actionUpdate_goods(){
    	$request = yii::$app->request;
    	$id = $request->get('id');
    	$model = new GoodsModel;
    	$data = $model->update_goods($id);
    	if(!$data){
    		echo "<script>alert('该商品不存在');history.go(-1)</script>";
    	}
    	return $this->renderpartial('update_goods',['data'=>$data]);
    }
    /**
	 * 修改商品
     * Update_do action.
     * params 表单元素
     * type post
     * @return 0修改失败 1修改成功 2表单元素为空 3商品名称已被占用
     */
    public function actionUpdate_do(){
    	$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data) || empty($data['type_id'])){
			return "<script>alert('元素不能为空');history.go(-1)</script>";
		}
		$data['type_id'] = str_replace("'","",implode(',',$data['type_id']));
			$res = [];
			for ($i=0; $i < 5; $i++) { 
				if(empty($_FILES['img']['name'][$i])){
					continue;
				}else{
					$res[$i]['name'] = $_FILES['img']['name'][$i];
					$res[$i]['type'] = $_FILES['img']['type'][$i];
					$res[$i]['tmp_name'] = $_FILES['img']['tmp_name'][$i];
					$res[$i]['error'] = $_FILES['img']['error'][$i];
					$img = $this->upload($res[$i]);
					if(!strpos($img,'/')){
						return "<script>alert('$img');history.go(-1)</script>";
					}
					$n = $i+1;
					$str = 'img'.$n;
					$data[$str] = '/'.$img;
				}
				
			}
		
		$model = new GoodsModel;
		$data = $model->update_do($data);
		if($data == 1){
			return "<script>alert('修改成功');history.go(-2)</script>";
		}elseif($data == 3){
			return "<script>alert('商品名称已被占用');history.go(-1)</script>";
		}else{
			return "<script>alert('修改失败');history.go(-1)</script>";
		}
    }
}


 ?>