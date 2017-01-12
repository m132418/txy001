<?php
namespace frontend\controllers;
use Yii;
use common\models\CardSuite;
use common\models\CardSuiteSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Order;
use common\components\MyHelpers ;
use yii\web\HttpException;
use common\services\AgentsService ;
class CardSuiteController extends Controller
{
  
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                 'only' => ['list', 'ord','gen'],
                'rules' => [
//                     [
//                         'actions' => ['signup'],
//                         'allow' => true,
//                         'roles' => ['?'],
//                     ],
                    [
                        'actions' => ['index','list','ord','gen'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    


    public function actionList()
    {

        AgentsService::compute_agents_level(Yii::$app->user->identity->id,  Yii::$app->session['user']["level"]);

        $l = Yii::$app->user->identity->level ;
        if ($l > 0)
            ;
            else
                throw  new Exception("是什么级别的代理商?") ;
        
            $model = CardSuite::find()->where(['req_level' => $l])->orderBy(['period' => SORT_ASC])->all() ;

        return $this->render('list', [
            'model' => $model
        ]);
    }
    public function actionOrd()
    {

        if (isset($_POST['id'])) 
            ;
        else
            throw  new Exception("参数错误");
        
        $uid = Yii::$app->user->identity->id ;
        
        if (isset($uid)) 
            ;
        else 
            throw  new Exception("取不到用户信息");
        

        $card_suite = CardSuite::findOne(['id'=> $_POST['id']]) ;
        // create order 
        
       $ord = new Order() ;
       $ord->pay_suite = $card_suite->id ;
       $ord->howmany = $card_suite->amount ;
       $ord->howmuch = $card_suite->price;
       $ord->whose = $uid ;
       $ord->channel = Order::CHANNEL_ALI ;
       $ord->save(false) ;
        
       return $this->redirect(['/pay/submit', 'id' => $ord->id,'vcd'=> MyHelpers::check_vcd("".$ord->id)]);
        
    }
//     public function actionGen()
//     {

//         if (isset($_POST["id"])) 
//             ;
//         else 
//             throw new HttpException(404) ;
        
//        $ord = Order::findOne($_POST["id"] ) ;
//         if (is_null($ord)) {
//             throw  new Exception("订单信息错误");
//         }elseif ($ord->is_payed == 0)
//         throw  new Exception("支付未同步过来");
//         elseif ($ord->is_gen == 1)
//         throw  new Exception("不能重复生成");
//         elseif (!isset(\Yii::$app->user->identity->id ))
//         throw  new Exception("取不到用户信息");

// $k = $ord->howmany ;       
// while ($k > 0) {
//    $insertCount = $this->batch_gen_card($k,$ord->period);
//    $k = $k - $insertCount ;
// } 


        
//         $msg = "生成了" .$insertCount ."个卡" ;
        
//         $ord->is_gen = Order::IS_GEN_DONE ;
//         $ord->save(false);
        
//         return $this->render('gen', [
//             'msg' => $msg
            
//         ]);
        
//     }
 private function batch_gen_card($amt,$period)
    {

                $uid = \Yii::$app->user->identity->id ;
                $t = time() ;
                $data =null ;
                for ($x = 1; $x <= $amt; $x++) {
                    $data[$x-1] = [
//                         'sn'=> 'T' .date('YmdHis') .  rand(100000,999999),
                        'sn'=> 'T' .  MyHelpers::gen_random_num_cd(20) ,
                        'refapp'=>1,
                        'period'=>$period,
                        'whoissue'=>$uid,
                        'created_at'=>$t ,
                        'updated_at'=>$t ,
                    ] ;
                }
                

                $clomns = ['sn','refapp','period','whoissue','created_at' ,'updated_at'] ;

                
                
                try {
                    $insertCount = Yii::$app->db->createCommand()
                    ->batchInsert("card", $clomns, $data)
                    ->execute();
                } catch (Exception $e) {
                    return $amt ;
                }
               
        return $insertCount;
    }

//     public function actionIndex()
//     {
//         $searchModel = new CardSuiteSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single CardSuite model.
     * @param integer $id
     * @return mixed
     */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

    /**
     * Creates a new CardSuite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new CardSuite();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing CardSuite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Deletes an existing CardSuite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

    /**
     * Finds the CardSuite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CardSuite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CardSuite::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
