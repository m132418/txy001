<?php
namespace backend\controllers;
use Yii;
use common\models\Card;
use common\models\CardSearch2;
use backend\models\CardGenForm ;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\services\CardService ;
use yii\helpers\ArrayHelper;
use common\models\UserInfo;
use backend\services\TraceService;
use common\models\User;
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
                'rules' => [
                     
                    [
                        'actions' => [ 'index','view','delete','create','update','gen'],
                        'allow' => true,
                        'roles' => ['appadmin'],
                    ]
            
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $searchModel = new CardSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
//         $uinfos = ArrayHelper::map(UserInfo::find()->where([])->asArray()->all(), 'id', 'user_name') ;
//         var_dump($uinfos) ;exit() ;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//             'uinfos'=>$uinfos
        ]);
    }

    /**
     * Displays a single Card model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Card();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',
//                  'id' => $model->id
                
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionGen()
    {      
        $model = new CardGenForm();
        if ($model->load(Yii::$app->request->post()) ) {
        
            
            $k = $model->amt ;
            while ($k > 0) {
                $insertCount = CardService::batch_gen_card($k, $model->period, $model->uid) ;
                $k = $k - $insertCount ;
            }
            $opra = (Yii::$app->controller->id . "/".   Yii::$app->controller->action->id);
            $ip = (Yii::$app->request->userIp) ;
            
            TraceService::opra_log($opra, $ip,"赠送给". User::ref_lebel($model->uid) ."用户," . $model->amt. "张" . Card::ref_period_lebels( $model->period) . "卡");
        
            return $this->redirect(['index']);
        } else {
            return $this->render('gen', [
                'model' => $model,
            ]);
        }
    
          
    }

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
}
