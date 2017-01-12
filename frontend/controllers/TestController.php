<?php
namespace frontend\controllers;
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
use common\services\AgentsService ;
use common\models\OpLog ;
use frontend\services\UserViewSumService ;
/**
 * Site controller
 */
class TestController extends Controller
{
    /**
     * @inheritdoc
     */
//     public function behaviors()
//     {
//         return [
//             'access' => [
//                 'class' => AccessControl::className(),
// //                 'only' => ['t1', 'signup','chgpwd'],
//                 'rules' => [
// //                     [
// //                         'actions' => ['signup'],
// //                         'allow' => true,
// //                         'roles' => ['?'],
// //                     ],
//                     [
//                         'actions' => ['t1','chgpwd','t4'],
//                         'allow' => true,
//                         'roles' => ['@'],
//                     ],
//                 ],
//             ],
//             'verbs' => [
//                 'class' => VerbFilter::className(),
//                 'actions' => [
//                     'logout' => ['post'],
//                 ],
//             ],
//         ];
//     }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

public function afterAction($action, $result)
{
    $result = parent::afterAction($action, $result);

    return $result;
}
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
       $re = Yii::$app->params['pubk1'] ;
       
       var_dump($re) ;
       
      $r2= MyHelpers::check_vcd("2") ;
      var_dump($r2) ;
       
       exit() ;
        return $this->render('index');
    }
    public function actionT1()
    {
        echo  date('YmdHis') .  rand(100000,999999);
//         var_dump(ArrayHelper::map(RefApp::find()->all(), 'id', 'appname'))  ;
        
            var_dump(  Yii::$app->session['user']);
            $a =Yii::$app->session['user'] ;
            $a["level"]= Yii::$app->session['user']["level"]+1 ;
            Yii::$app->getSession()->set("user", $a);
             var_dump(Yii::$app->session['user']);
            
        
    }
    public function actionT2()
    {
//       var_dump(Yii::getAlias("@vendor/zfb/lib/alipay_submit.class.php"))  ;
$num = MyHelpers::gen_random_num_cd(20) ;
// echo $num ;
echo date('Y-m-d H:i:s', 1299446702);
//         var_dump(@vendor . '/zfb/' . 'sdfsd.php') ;
$u = UserInfo::findOne(['id'=>149]) ; 
var_dump($u->user_name) ;
    }
    public function actionT3()
    {
        $uid = 1 ;
        $level = 2 ;
        
        $sum_now_in_money_sql = "SELECT SUM(howmuch) FROM `order` where whose =".$uid;
        $next_level_point_sql = "SELECT set_point FROM ref_agents where id = " . ($level +1) ;
//         var_dump($next_level_point_sql);exit();
        
            $sum_now_in_money = Yii::$app->db
            ->createCommand($sum_now_in_money_sql)->queryScalar();
            $next_level_point = Yii::$app->db
            ->createCommand($next_level_point_sql)->queryOne();
        
        var_dump($sum_now_in_money);
        var_dump($next_level_point["set_point"]);
        var_dump((int)$sum_now_in_money >= (int)$next_level_point["set_point"]);
        
    }
    public function actionT4()
    {
//         var_dump( Yii::$app->session['user']) ;exit() ;
//           $this->redirect(['msg/index', 'sec'=>3 ,'url'=>'/card/index' ,'msg' => "wehiuhuiwsdfshf上帝发誓地方"]);
//        $r = AgentsService::compute_agents_level(Yii::$app->user->identity->id,  Yii::$app->session['user']["level"]) ;
//        var_dump($r) ;
//         $opra = (Yii::$app->controller->id . "/".   Yii::$app->controller->action->id);
//         $ip = (Yii::$app->request->userIp) ;
//         $this->opra_log($opra, $ip);
//         $ord_id = '14840415771' ;
//        var_dump( substr($ord_id,10)) ;

//        $res = Yii::$app->db->createCommand("CALL asyc_ord_score(" . 1 . ",'"."ali_payed_sn1" ."')")->execute() ;        
//         $res = Yii::$app->db->createCommand(
//             "SELECT FROM_UNIXTIME(created_at, '%Y-%m') x , SUM(howmany) amt FROM `order` where is_payed =1 and whose = 1 GROUP BY FROM_UNIXTIME(created_at, '%Y-%m')"
//             )->queryAll() ;
//        $a1= ["2016-12"=>139,"2017-01"=>942];
//         var_dump($res);
      $re2=  UserViewSumService::sum_user_in_cash_score(1) ;
      var_dump($re2) ;
      $re3=  UserViewSumService::sum_user_score(1) ;
      var_dump($re3) ;
      
      //1 make x 轴
//      $re_x2 = array_column($re2[0], "x") ;
     $re_x2 = ArrayHelper::getColumn($re2[0], "x") ;
//       var_dump($re_x2) ;
//       $re_x3 = array_column($re3[0], "x") ;
      $re_x3 = ArrayHelper::getColumn($re3[0], "x") ;
//       var_dump($re_x3) ;
      $re_x_merge = array_unique( array_merge($re_x2,$re_x3) );
      var_dump($re_x_merge) ;
      

      
      //2 build 充值 数组
      $arr_incash =[] ;
     foreach ($re_x_merge as $key => $value) {
        $k =   array_search( $value, ArrayHelper::getColumn($re2[0], 'x'));
        
         if (in_array( $value, ArrayHelper::getColumn($re2[0], 'x') ) ) {
             array_push($arr_incash, $re2[0][$k]['amt']);
         }else 
             array_push($arr_incash, "0");
       
       
     }
     var_dump($arr_incash);
     
     //2 build 积分 数组
    
     $arr_score =[] ;
     foreach ($re_x_merge as $key => $value) {
         $k =   array_search( $value, ArrayHelper::getColumn($re3[0], 'x'));
     
         if (in_array( $value, ArrayHelper::getColumn($re3[0], 'x') ) ) {
             array_push($arr_score, $re3[0][$k]['amt']);
         }else 
             array_push($arr_score, "0");
         
     }
     var_dump($arr_score);

    }
 private function opra_log($opra, $ip)
    {
        $op = new OpLog() ;
        $op->ipadd = $ip ;
        $op->opr = $opra ;
        $op->save(false) ;
    }

}
