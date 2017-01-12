<?php
namespace backend\controllers;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\SignupForm ;
use frontend\services\UserViewSumService;
use yii\helpers\ArrayHelper;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                   
                    [
                        'actions' => [ 'index','view','delete','create','update','signup'],
                        'allow' => true,
                        'roles' => ['appadmin'],
                    ]
                    
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
    
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        
        
        $re2=  UserViewSumService::sum_user_in_cash_score($id) ;
//         var_dump($re2) ;
        $re3=  UserViewSumService::sum_user_score($id) ;
//         var_dump($re3) ;
        
        //1 make x 轴
        $re_x2 = ArrayHelper::getColumn($re2[0], "x") ;
        //       var_dump($re_x2) ;
        $re_x3 = ArrayHelper::getColumn($re3[0], "x") ;
        //       var_dump($re_x3) ;
        $re_x_merge = array_unique( array_merge($re_x2,$re_x3) );
//         var_dump($re_x_merge) ;exit();
        
        
        
        //2 build 充值 数组
        $arr_incash =[] ;
        foreach ($re_x_merge as $key => $value) {
            $k =   array_search( $value, ArrayHelper::getColumn($re2[0], 'x'));
        
            if (in_array( $value, ArrayHelper::getColumn($re2[0], 'x') ) ) {
                array_push($arr_incash, $re2[0][$k]['amt']);
            }else
                array_push($arr_incash, "0");
             
             
        }
//         var_dump($arr_incash);
         
        //2 build 积分 数组
        
        $arr_score =[] ;
        foreach ($re_x_merge as $key => $value) {
            $k =   array_search( $value, ArrayHelper::getColumn($re3[0], 'x'));
             
            if (in_array( $value, ArrayHelper::getColumn($re3[0], 'x') ) ) {
                array_push($arr_score, $re3[0][$k]['amt']);
            }else
                array_push($arr_score, "0");
             
        }
//         var_dump($arr_score);
        
        
//         exit() ;
        
        
        
        
        
        return $this->render('view', [
            'id'=>$id,
            'model' => $this->findModel($id),
            'count_cards_all'=>\frontend\services\IndexCountService::count_cards_all($id) ,
            'sum_2nd'=>[$re_x_merge,$arr_incash,$arr_score]
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())  ) {            
            $model->email = $_POST["User"]["email"] ;            
          $res =  $model->save() ;            
            if ($res) {
                return $this->redirect(['index', 
//                     'id' => $model->id
                    
                ]);
            }else 
               $this->redirect(['site/message','message'=>"数据校验不通过"]) ;
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
//                 if (Yii::$app->getUser()->login($user)) {
//                     return $this->goHome();
//                 }
                    // redirect 
//                     $this->title = "通知消息" ;
//                     $this->redirect(['site/message','message'=>"注册成功了"]) ;
                    $this->redirect(['/msg/index', 'sec'=>3 ,'url'=>'/user/index' ,'msg' => "注册成功了"]);
            }
        }
    
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
