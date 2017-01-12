<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];
	
	
	$money = $_POST['total_fee'];
	
	
	$user = $_POST['subject'];
	
	$time = date("Y-m-d H:i:s",time());


    if($_POST['trade_status'] == 'TRADE_FINISHED') {//这是普通及时到账的成功的参数
	
	  $mysql = mysql_connect('localhost', 'root', 'root');
	  
      mysql_select_db('sq', $mysql);
	  
	  mysql_query("SET NAMES 'utf8'", $mysql);
	  
      $sql = mysql_query("SELECT * FROM order WHERE orderid='".$out_trade_no."'", $mysql);//这里查询订单是否存在,根据商户订单检查  uorder是支付宝交易号
	  
    if(mysql_num_rows($sq, $mysql)>=1){  
	  
      echo "当查询到订单记录,那么跳过订单的添加,防止重复";
	  
	}else{
	  
	  $sql = mysql_query("INSERT INTO `order` SET `orderid`='".$out_trade_no."',`uorder`='".$trade_no."',`user`='".$user."',`money`='".$money."',`time`='".$time."',`state`='1',`lx`='网站';", $mysql);//执行数据的添加
	}
		
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {//这是高级即时到帐的成功的参数
		
    }

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>