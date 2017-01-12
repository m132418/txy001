<?php
namespace frontend\controllers;
use common\models\Order;
use yii\web\Controller;
use Yii;
use common\components\MyHelpers ;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\services\AgentsService ;
// use common\models\Score;
use yii\web\HttpException;
require_once Yii::getAlias("@vendor/zfb/lib/alipay_submit.class.php");
require_once Yii::getAlias("@vendor/zfb/lib/alipay_notify.class.php");
// require_once Yii::getAlias("@vendor/zfb/alipay.config.php");
class PayController extends Controller
{
//    public $enableCsrfValidation = false;
    
    /**
     * @inheritdoc
     */
//     private $ids;
  public function beforeAction($action)
    {
        if (in_array($action->id, ['notify'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['pay'],
                'rules' => [

                    [
                        'actions' => ['pay'],
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionSubmit($id,$vcd)
    {
        if (strcmp(MyHelpers::check_vcd("".$id),$vcd)==0) ;
        else
            throw new HttpException(404) ;
        // order info
       $ord = Order::findOne($id ) ;
        if (is_null($ord)) {
            throw  new Exception("订单信息错误");
        }
        
        
     // build pay
        $subject = $ord->suitename;
        $body="订单:" .$ord->suitename .",支付:" . $ord->howmuch . ",出卡:" . $ord->howmany ;
        header("Content-type:text/html;charset=utf-8");
        $alipay_config['service'] = \Yii::$app->params['zfb']['service'];
        $alipay_config['partner'] = \Yii::$app->params['zfb']['partner'];
        $alipay_config['seller_id'] = \Yii::$app->params['zfb']['seller_id'];
        $alipay_config['payment_type'] = \Yii::$app->params['zfb']['payment_type'];
        $alipay_config['input_charset']= \Yii::$app->params['zfb']['input_charset'];
        $alipay_config['sign_type']= \Yii::$app->params['zfb']['sign_type'];
        $alipay_config['key']= \Yii::$app->params['zfb']['key'];
        


        $notify_url = "http://daili.txyapp.com:8181/pay/notify";
        $return_url =  "http://daili.txyapp.com:8181/pay/return";
        $out_trade_no =$ord->created_at . $ord->id;
        $total_fee =$ord->howmuch    ;
//         $total_fee =0.01    ;
//        $show_url = Yii::$app->urlManager->createAbsoluteUrl(['product/view', 'id' => $firstProduct]);
//         $anti_phishing_key = time();
//         $exter_invoke_ip = "";

        $parameter = [
            "service" => trim($alipay_config['service']),
            "partner" => trim($alipay_config['partner']),
            "seller_id" => trim($alipay_config['seller_id']),
            "payment_type"  => $alipay_config['payment_type'],
            "notify_url"    => $notify_url,
            "return_url"    => $return_url,
            "anti_phishing_key"=>'',
            "exter_invoke_ip"=>'',
            
            "out_trade_no"  => $out_trade_no,
            "subject"   => $subject,
            "total_fee" => $total_fee,
            "body"  => $body,
//            "show_url"  => $show_url,
//             "anti_phishing_key" => $anti_phishing_key,
//             "exter_invoke_ip"   => $exter_invoke_ip,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset'])),
        ];

        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "post", "正在跳转支付宝付款，请稍候...");

        echo $html_text;

    }
//     public function actionFakeNotify($ord)
//     {

//                 $tradeNo = "fake-ali-SN";
               
// //                 $sn = $req->post('out_trade_no');
// //                 $tradeNo = $req->post('trade_no');
//                 $ord = Order::findOne(['id' => substr($ord,10)]) ;
                
                 
//                 //$out_trade_no这里查询订单是否存在,根据商户订单检查  uorder是支付宝交易号
//                 $ord->channel = Order::CHANNEL_ALI ;
//                 $ord->is_payed = Order::ISPAIED_DONE ;
//                 $ord->payed_sn = $tradeNo ;
//                 //                 $ord->save(false) ;
                
//                 // add score
//                 $score = new Score() ;
//                 $score->bindto = \Yii::$app->user->identity->id ;
//                 $score->value = $ord->howmuch ;
//                 $score->ord = $ord->id ;
                
//                 $connection = \Yii::$app->db;
                
//                 $transaction = $connection->beginTransaction();
//                 try {
//                     $ord->save(false) ;$score->save(false) ;
//                     $transaction->commit();
                
//                 } catch(Exception $e) {
//                     $transaction->rollback();
//                 }
                
                
//     }

    public function actionNotify()
    {
//         Yii::$app()->request->enableCsrfValidation = false;
// $this->enableCsrfValidation = false ;

        
        $alipay_config['partner']		= '2088021988626903';
        
        //收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
        $alipay_config['seller_id']	= $alipay_config['partner'];
        
        // MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
        $alipay_config['key']			= '3t70meohzmkvtsl9p09k1yd02e0o78lu';
        
        // 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
        $alipay_config['notify_url'] = "http://daili.txyapp.com:8181/pay/notify";
        
        // 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
        $alipay_config['return_url'] = "http://daili.txyapp.com:8181/pay/return";
        
        //签名方式
        $alipay_config['sign_type']    = strtoupper('MD5');
        
        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']= strtolower('utf-8');
        
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'http';
        
        // 支付类型 ，无需修改
        $alipay_config['payment_type'] = "1";
        
        // 产品类型，无需修改
        $alipay_config['service'] = "create_direct_pay_by_user";
        
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        
        
        //↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        
        // 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
        $alipay_config['anti_phishing_key'] = "";
        
        // 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
        $alipay_config['exter_invoke_ip'] = "";
        
        
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        
//                 $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//                $txt = var_export($_POST) ;
//                fwrite($myfile, $txt);
//                fclose($myfile);
        
        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
            $req = Yii::$app->getRequest();
        
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
        
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
        
            //商户订单号
        
//             $out_trade_no = $_POST['out_trade_no'];
        
            //支付宝交易号
        
//             $trade_no = $_POST['trade_no'];
        
            //交易状态
//             $trade_status = $_POST['trade_status'];
        
        
//             $money = $_POST['total_fee'];
        
        
//             $user = $_POST['subject'];
        
//             $time = date("Y-m-d H:i:s",time());
        
        
            if( in_array($req->post('trade_status'), ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {//这是普通及时到账的成功的参数
                $sn = $req->post('out_trade_no');
                $tradeNo = $req->post('trade_no');
                $ord_id =substr($sn,10) ;
//                 MyHelpers::log("pay.txt", $sn);
//                 MyHelpers::log("pay.txt", $ord_id);
//                 $ord = Order::findOne(['id' => $ord_id]) ;
                $res = Yii::$app->db->createCommand("CALL asyc_ord_score(" .$ord_id. ",'".
                    $tradeNo 
                    ."')")->execute() ;
             
               
               //$out_trade_no这里查询订单是否存在,根据商户订单检查  uorder是支付宝交易号
//                 $ord->channel = Order::CHANNEL_ALI ;
//                 $ord->is_payed = Order::ISPAIED_DONE ;
//                 $ord->payed_sn = $tradeNo ;
//                 $ord->save(false) ;
//                 MyHelpers::log("pay.txt", "a");
//                             // add score
//                 $score = new Score() ;
//                 $score->bindto = \Yii::$app->user->identity->id ;
//                 $score->value = $ord->howmuch ;
//                 $score->ord = $ord->id ;   
//                 $score->save(false) ;
//                 MyHelpers::log("pay.txt", "b");
//                 $connection = \Yii::$app->db;
                
//                 $transaction = $connection->beginTransaction();
//                 try {
//                     MyHelpers::log("pay.txt", "c");
//                     $ord->save(false) ;$score->save(false) ;
//                     $transaction->commit();
                
//                 } catch(Exception $e) {
//                     MyHelpers::log("pay.txt", "d");
//                     $transaction->rollback();
//                 }
                
//                $rtn = AgentsService::compute_agents_level(Yii::$app->user->identity->id,  Yii::$app->session['user']["level"]) ;                
            }
            else {
                //其他状态判断
                echo "success";
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
        
//             $rtn = AgentsService::compute_agents_level(Yii::$app->user->identity->id,  Yii::$app->session['user']["level"]) ;
        
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";
        
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }
//notify_url地址所对应的处理程序； 方法中省略了部分代码，不能直接拿来运行
   

    public function actionReturn()
    {
        $req = \Yii::$app->getRequest();
        if( $req->get('is_success')=='T' && in_array($req->get('trade_status'), ['TRADE_SUCCESS', 'TRADE_FINISHED']) ) {
            
           $sn = $req->get('out_trade_no') ; 
           $b_id = $req->get('buyer_id') ;
           $b_email = $req->get('buyer_email') ;
//            $this->redirect(['card-suite/gen','id' => substr($sn,10)]);
           $insertCount =$this->gen_cards(substr($sn,10),$b_id,$b_email) ;
           AgentsService::compute_agents_level(Yii::$app->user->identity->id,  Yii::$app->session['user']["level"]) ;
           $msg = "生成了" .$insertCount ."个卡" ;
           $this->redirect(['msg/index', 'sec'=>3 ,'url'=>'/card/index' ,'msg' => $msg]);
           
	} else {
            return $this->render('fail');
        }
    }
    
    private function gen_cards($ord_id,$b_id,$b_email)
    {
        //         echo $_POST["id"] ;
    
        // load order check is_gen == 0 ,is_payed ==1
        $ord = Order::findOne($ord_id ) ;
        if (is_null($ord)) {
            throw  new Exception("订单信息错误");
        }elseif ($ord->is_payed == 0)
        throw  new Exception("支付未同步过来");
        elseif ($ord->is_gen == 1)
        throw  new Exception("不能重复生成");
        elseif (!isset(\Yii::$app->user->identity->id ))
        throw  new Exception("取不到用户信息");
    
        $k = $ord->howmany ;

        while ($k > 0) {
            $insertCount = $this->batch_gen_card($k,$ord->period);
            $k = $k - $insertCount ;
        }
    
        $ord->is_gen = Order::IS_GEN_DONE ;
        $ord->buyer_id = $b_id ;
        $ord->buyer_email = $b_email ;
        
        $ord->save(false);

  
        return $insertCount ;
    
    }
    
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
            return 0 ;
        }         
        return $insertCount;
    }

}
