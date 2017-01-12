<?php
namespace frontend\controllers;
use common\models\UserInfo;
use common\services\DBService;
use frontend\models\BindUserInputForm;
use Yii;
use common\models\Card;
use common\models\CardSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserInfoSearch;
use yii\filters\AccessControl;
use common\components\MyHelpers ;
use yii\web\HttpException;
/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
{
    /**
     * @inheritdoc
     */


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'bind-user-input'],
                'rules' => [
//                     [
//                         'actions' => ['signup'],
//                         'allow' => true,
//                         'roles' => ['?'],
//                     ],
                    [
                        'actions' => ['index','bind-user-input','bind-user' ,'ref-user'],
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
    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CardSearch();
        

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//     public function actionIndex2()
//     {
//         $searchModel = new CardSearch();
    
    
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
//         return $this->render('index2', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single Card model.
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
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new Card();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing Card model.
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
     * Deletes an existing Card model.
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
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionBindUserInput($cid,$vcd)
    {
        $this->layout = "simple" ;
        
//         MyHelpers::check_vcd("".$cid) ;        
//         var_dump($cid) ;var_dump($vcd) ;
//         var_dump(MyHelpers::check_vcd("".$cid) ) ;
//            var_dump(strcmp(MyHelpers::check_vcd("".$cid),$vcd)) ;
//         exit();
        
        if (strcmp(MyHelpers::check_vcd("".$cid),$vcd)==0) ;
        else 
            throw new HttpException(404) ;

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $card = Card::findOne(['id'=>$cid]) ;
        if (!$card)
        return $this->render('bind-user-input-report', [
            'msg' => "卡没找到",
        ]);
        if ($card->status ==Card::STATUS_USED )
        {
            return $this->render('bind-user-input-report', [
                'msg' => "卡已经用过了",
            ]);
        }
        if ($card->whoissue !=Yii::$app->user->identity->id )
        {
            return $this->render('bind-user-input-report', [
                'msg' => "没有这卡",
            ]);
        }
 

        $model = new BindUserInputForm();
     
        $model->cardsn = $card->sn ;
     
        if ($model->load(Yii::$app->request->post()) ) {
     
            $this->layout = "main" ;
//            $user = User::findIdentity(Yii::$app->user->identity->id) ;
            $u = UserInfo::findOne(['user_name'=> trim($model->username) ]) ;
     
            if (!$u)
            {
     
                return $this->render('bind-user-input-report', [
                    'msg' => "对应用户没找到",
                ]);
            }

           
            $card->bind_uid =trim($u->id)  ;
            $card->bind_at = time() ;
            $card->status = Card::STATUS_USED ;
        $card->whoissue = Yii::$app->user->identity->getId();
            $card->save(false) ;
           
            $sql =        DBService::build_postpone_sql($card->period,$u->id) ;
           
            DBService::q_with_native_sql($sql)->execute() ;
           
            $msg = "卡号" . $card->sn ."已经冲入用户:" . $u->user_name ;
            return $this->render('bind-user-input-report', [
                'cardsn'=>$card->sn,
                'username'=>$u->user_name,
                'msg' => $msg,
            ]);
        } else {
            return $this->render('bind-user-input', [
                'model' => $model,
            ]);
        }

    }
//     public function actionRefUser($cid)
//     {

//         $searchModel = new UserInfoSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('userlist', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }
    public function actionBindUser($cid ,$key)
    {
//       var_dump($cid) ;// card id
//        var_dump($key) ;// user id ;
      //1  update card bind user
        $card = Card::findOne(['id'=>$cid]) ;
//        var_dump($card) ;
        $card->bind_uid =trim($key)  ;
        $card->bind_at = time() ;
        if ($card->status ==Card::STATUS_USED )
        {
            throw new Exception("卡已经用过了") ;
        }
        $card->status = Card::STATUS_USED ;
//        $card->whoissue = Yii::$app->user->identity->getId();
        $card->save(false) ;
        // 2 postpone user due to date time
$sql =        DBService::build_postpone_sql($card->period,$key) ;
        DBService::q_with_native_sql($sql)->execute() ;

        // redirect to card detail
        return $this->redirect(['view', 'id' => $cid]);
    }
}
