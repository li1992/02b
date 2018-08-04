<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Db;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * 商城首页
     * index action.
     * params 
     * type get
     * @return array 
     */
    public function actionIndex()
    {
        $db = new DB;
        $table = "notice";
        $where = "where status=1";
        $limit = "limit 0,5";
        $order = "order by time";
        $data['notice'] = $db->selectAll($table,$where,$order,$limit,'*');
        return $this->renderpartial('index',['data'=>$data]);
    }
    
}
