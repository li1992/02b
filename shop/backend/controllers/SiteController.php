<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
// use yii\filters\VerbFilter;
// use yii\filters\AccessControl;
// use common\models\LoginForm;
use backend\models\SiteModel;
/**
 * Site controller
 */
class SiteController extends Controller
{
    //管理员登录
    public function actionIndex()
    {
        return $this->renderpartial('login');
    }

    /**
     * 验证登录
     * Login_do action.
     * params input
     * type post
     * @return 0用户名或密码为空 1用户名错误 2已被禁用 3密码错误 array管理员数据
     */
    
    public function actionLogin_do(){
        
        $request = Yii::$app->request;
        $data = $request->post();
        $model = new SiteModel;
        $res = $model->login_do($data);
        $arr = array(
                0=>"用户名或密码不能为空",
                1=>"对不起,用户名错误",
                2=>"你已被管理员禁用,请联系管理员",
                3=>"对不起,密码错误",
            );
        if(is_array($res)){
            $session = \Yii::$app->session;
            $session->set('admin_id',$res['id']);
            $session->set('admin_name',$res['uname']);
            $this->redirect("/index/index");
        }else{
            echo "<script>alert('$arr[$res]');history.go(-1)</script>";
        }
    }
    /**
     * 退出登录
     * login_out action.
     * params 
     * type get
     * @return 
     */
    
    public function actionLogin_out(){
        $session = \Yii::$app->session;
        $session->removeAll();
        echo "<script>history.go('www.backshop.com')</script>";
    }
}
