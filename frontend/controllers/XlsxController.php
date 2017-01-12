<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\MyHelpers;
use common\models\Card;
// require_once Yii::getAlias("@vendor/codemix/yii2-excelexport/src/ActiveExcelSheet.php");
// require_once Yii::getAlias("@vendor/codemix/yii2-excelexport/src/ExcelFile.php");
// require_once Yii::getAlias("@vendor/codemix/yii2-excelexport/src/ExcelSheet.php");
/**
 * Site controller
 */
class XlsxController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['t1', 'signup','chgpwd'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['cards'],
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

        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionT1()
    {
        echo  date('YmdHis') .  rand(100000,999999);
//         var_dump(ArrayHelper::map(RefApp::find()->all(), 'id', 'appname'))  ;
    }
    public function actionT2()
    {
//       var_dump(Yii::getAlias("@vendor/zfb/lib/alipay_submit.class.php"))  ;
$num = MyHelpers::gen_random_num_cd(20) ;
// echo $num ;
echo date('Y-m-d H:i:s', 1299446702);
//         var_dump(@vendor . '/zfb/' . 'sdfsd.php') ;

$data = Card::find()->where(['status'=>Card::STATUS_USED ,'whoissue'=>Yii::$app->user->identity->id])->all() ;
var_dump($data) ;


    }
    public function actionCards()
    {
//         $this->title = "Cards" ;       
        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Cards' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => Card::find()->where(['status'=>Card::STATUS_CREATED ,'whoissue'=>Yii::$app->user->identity->id]),
                    'attributes' => [
//                         'id',
                        'sn',
//                         'period',
                     
                    ],
                ]
            ]
        ]);
        $file->send('Cards.xlsx');
    }
}
