<?php
namespace frontend\controllers;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\SignupForm ;
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
                        'roles' => ['@'],
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
    
//     public function actionIndex()
//     {
//         $searchModel = new UserSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new User();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())  ) {            
            $model->email = $_POST["User"]["email"] ;            
          $res =  $model->save() ;            
            if ($res) {
                Yii::$app->session->setFlash('success', '资料改了');
                return $this->goHome() ;
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
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

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
    
//     public function actionSignup()
//     {
//         $model = new SignupForm();
//         if ($model->load(Yii::$app->request->post())) {
//             if ($user = $model->signup()) {
// //                 if (Yii::$app->getUser()->login($user)) {
// //                     return $this->goHome();
// //                 }
//                     // redirect 
// //                     $this->title = "通知消息" ;
// //                     $this->redirect(['site/message','message'=>"注册成功了"]) ;
//                     $this->redirect(['/msg/index', 'sec'=>3 ,'url'=>'/user/index' ,'msg' => "注册成功了"]);
//             }
//         }
    
//         return $this->render('signup', [
//             'model' => $model,
//         ]);
//     }
}
