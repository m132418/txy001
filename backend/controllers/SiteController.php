<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\ChgpwdForm;
use common\models\User;
use backend\services\IndexCountService;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index',
                    'logout',
                    'signup',
                    'chgpwd'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'login'
                        ],
                        'allow' => true,
                        'roles' => [
                            '?'
                        ]
                    ],
                    [
                        'actions' => [
                            'logout',
                            'chgpwd',
                            'index'
                        ],
                        'allow' => true,
                        'roles' => [
                            'appadmin'
                        ]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'cards_all' => IndexCountService::count_cards_all(),
            'cards_today' => IndexCountService::count_cards_today(),
            'inmoney' => IndexCountService::count_in_money_all(),
            'inusers' => IndexCountService::count_users()
        ]);
    }

    public function actionChgpwd()
    {
        $model = new ChgpwdForm();
        if ($model->load(Yii::$app->request->post())) {
            
            $user = User::findIdentity(Yii::$app->user->identity->id);
            $user->setPassword($model->password);
            $user->generateAuthKey();
            $user->save(false);
            
            Yii::$app->session->setFlash('success', '密码改完了哈');
            
            return $this->goBack();
        } else {
            return $this->render('chgpwd', [
                'model' => $model
            ]);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        

        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            
//             if (! \Yii::$app->user->can('appadmin')) {
//                 throw  new HttpException(404) ;
//             }
            $model->login();
            
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
    public function actionMessage($message)
    {
        //         return $this->render(['message','message'=>$message]) ;
        return $this->render('message', [
            'message' => $message,
        ]);
    }
public function actionError()
{
    $exception = Yii::$app->errorHandler->exception;
    if ($exception !== null) {
        return $this->render('error', ['exception' => $exception]);
    }
}
}
