<?php 

namespace backend\controllers;
use yii;
use yii\web\Controller;
use backend\models\NoticeModel;

class NoticeController extends BaseController{
	/**
	 * 公告列表
     * Notice_list action.
     * params p
     * type get
     * @return array广告数据
     */
	public function actionNotice_list(){
		$request = yii::$app->request;
        $p = $request->post('p',1);
		$search = $request->post('search','');
		$model = new NoticeModel;
		$data = $model->notice_list($p,$search);
        if($data){
            foreach ($data['res'] as $key => $v) {
                $data['res'][$key]['content'] = strlen($v['content'])<30?$v['content']:substr($v['content'],0,30).'...';
            }
        }
		if($request->isAjax){
            echo json_encode($data);return;
        }
		return $this->renderpartial('notice_list',['data'=>$data]);
	}
	/**
	 * 添加广告页面
     * Notice_add action.
     * params 
     * type get
     * @return 
     */
	public function actionNotice_add(){
		return $this->renderpartial('notice_add');
	}
	/**
	 * 添加公告
     * Add_do action.
     * params 表单元素
     * type post
     * @return 0添加失败 1添加成功 2表单元素为空 3公告标题已被占用
     */
	public function actionAdd_do(){
		$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			return 2;
		}
		$model = new NoticeModel;
		$data = $model->add_do($data);
		return $data;
	}
	/**
	 * 是否启用公告
     * update_status action.
     * params id status
     * type ajax-post
     * @return 0修改失败 1修改成功 
     */
    public function actionUpdate_status(){
    	$request = yii::$app->request;
    	$data = $request->post();
    	$model = new NoticeModel;
    	$data = $model->update_status($data);
    	echo $data;
    }
     /**
	 * 进入修改公告页面
     * update_notice action.
     * params id 
     * type post
     * @return 0查找失败 array对应广告数据
     */
    public function actionUpdate_notice(){
    	$request = yii::$app->request;
    	$id = $request->get('id');
    	$model = new NoticeModel;
    	$data = $model->update_notice($id);
    	if(!$data){
    		echo "<script>alert('该公告不存在');history.go(-1)</script>";
    	}
    	return $this->renderpartial('update_notice',['data'=>$data]);
    }
    /**
	 * 修改公告
     * Update_do action.
     * params 表单元素
     * type post
     * @return 0修改失败 1修改成功 2表单元素为空 3公告名称已被占用
     */
    public function actionUpdate_do(){
    	$request = yii::$app->request;
		$data = $request->post();
		if(in_array('',$data)){
			return 2;
		}
		$model = new NoticeModel;
		$data = $model->update_do($data);
		return $data;
    }
}



 ?>