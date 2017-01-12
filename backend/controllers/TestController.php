<?php
namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionT1()
    {
//         var_dump( Yii::$app->getSession("user"));
//         echo file_put_contents("test.txt",var_export(1 , true),FILE_APPEND);
//         file_put_contents("test.txt", "\r\n",FILE_APPEND);
// MyHelpers::log("log.txt", Yii::$app->session);
   $res = Yii::$app->user->identity->getRole() ;
  var_dump($res);
    }
    public function actionT2()
    {
      $re =  Yii::$app->params['pubk1'] ;
        var_dump($re) ;
//         $this->redirect(['/msg/index', 'sec'=>3 ,'url'=>'/user/index' ,'msg' => "注册成功了"]);

        var_dump(\Yii::$app->user->can('appadmin')) ;
    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

 

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }





}
