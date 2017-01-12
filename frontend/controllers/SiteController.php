<?php
namespace frontend\controllers;
use frontend\models\ChgpwdForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use common\models\User;
use frontend\services\IndexCountService;
use common\services\AgentsService ;
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
                'only' => ['index','logout', 'signup','chgpwd'],
                'rules' => [
                    [
                        'actions' => ['signup','login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','chgpwd','index'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//             'captcha' => [
//                 'class' => 'yii\captcha\CaptchaAction',
//                 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//             ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
//        var_dump(IndexCountService::count_cards() ) ;

        if (Yii::$app->user->isGuest  ) {
         $this->redirect('/site/login')   ;
        }
        
       
       $boards = IndexCountService::retrieve_boards() ;
       
       AgentsService::compute_agents_level(Yii::$app->user->identity->id,  Yii::$app->session['user']["level"]);
       return $this->render('index', [
           'cards_count_all' => IndexCountService::count_cards_all(Yii::$app->user->identity->id) ,
           'cards_count_today' =>IndexCountService::count_cards_today(Yii::$app->user->identity->id) ,
           'count_in_money' =>IndexCountService::count_in_money_all(Yii::$app->user->identity->id),
           'count_score' =>IndexCountService::count_score_all(Yii::$app->user->identity->id),
           'boards'=>$boards
       ]);
//         return $this->render('index');
   
    }
    public function actionChgpwd()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new ChgpwdForm();
        if ($model->load(Yii::$app->request->post()) ) {

            $user = User::findIdentity(Yii::$app->user->identity->id) ;
            $user->setPassword($model->password);
            $user->generateAuthKey();
            $user->save(false) ;

            return $this->goBack();
        } else {
            return $this->render('chgpwd', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
     * Displays contact page.
     *
     * @return mixed
     */
//     public function actionContact()
//     {
//         $model = new ContactForm();
//         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//             if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                 Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//             } else {
//                 Yii::$app->session->setFlash('error', 'There was an error sending email.');
//             }

//             return $this->refresh();
//         } else {
//             return $this->render('contact', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Displays about page.
     *
     * @return mixed
     */
//     public function actionAbout()
//     {
//         return $this->render('about');
//     }

    /**
     * Signs user up.
     *
     * @return mixed
     */
//     public function actionSignup()
//     {
//         $model = new SignupForm();
//         if ($model->load(Yii::$app->request->post())) {
//             if ($user = $model->signup()) {
//                 if (Yii::$app->getUser()->login($user)) {
//                     return $this->goHome();
//                 }
//             }
//         }

//         return $this->render('signup', [
//             'model' => $model,
//         ]);
//     }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
//     public function actionRequestPasswordReset()
//     {
//         $model = new PasswordResetRequestForm();
//         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//             if ($model->sendEmail()) {
//                 Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

//                 return $this->goHome();
//             } else {
//                 Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//             }
//         }

//         return $this->render('requestPasswordResetToken', [
//             'model' => $model,
//         ]);
//     }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
//     public function actionResetPassword($token)
//     {
//         try {
//             $model = new ResetPasswordForm($token);
//         } catch (InvalidParamException $e) {
//             throw new BadRequestHttpException($e->getMessage());
//         }

//         if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//             Yii::$app->session->setFlash('success', 'New password was saved.');

//             return $this->goHome();
//         }

//         return $this->render('resetPassword', [
//             'model' => $model,
//         ]);
//     }
    public function actionMessage($message)
    {
        //         return $this->render(['message','message'=>$message]) ;
        return $this->render('message', [
            'message' => $message,
        ]);
    }
}
