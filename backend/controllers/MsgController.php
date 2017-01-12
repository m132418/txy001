<?php
namespace backend\controllers;
use common\models\UserInfo;
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
use common\models\User;
use common\models\RefApp;
use yii\helpers\ArrayHelper;
use common\components\MyHelpers;
/**
 * Site controller
 */
class MsgController extends Controller
{
 

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }


    public function actionIndex($sec ,$url,$msg)
    {   
        return $this->render('index', [
            'sec' =>$sec,
            'url' =>$url ,
            'msg' =>$msg          
        ]);
    }
    public function actionT1()
    {
        echo  date('YmdHis') .  rand(100000,999999);

    }
  
}
