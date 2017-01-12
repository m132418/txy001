<?php



$a = "total_amount=0.01&buyer_id=2088702771341220&trade_no=2016112121001004220251024909&body=txy-VIP1nyear&notify_time=2016-11-21+19%3A30%3A58&subject=txy-vip&sign_type=RSA&buyer_logon_id=183****8211&auth_app_id=2016101702210607&charset=utf-8&notify_type=trade_status_sync&invoice_amount=0.01&out_trade_no=TXY20161121a73477e16433&trade_status=TRADE_SUCCESS&gmt_payment=2016-11-21+19%3A30%3A58&version=1.0&point_amount=0.00&sign=hVCwSpC4tgT2JdZXvWDvt8K0n3o060%2BHjNUg8%2BL7GLdZAq%2FCkQvUeqFnuAtKikQm9dI047AnCScZ0mBefvAL0xq5RTa%2Bhdd2R7ReVveyl3g%2FdKymq2YKmSOE%2F%2FFv30VVhH8OEFfaQaWrFCYB9AF2TbonNpYs8NCWg0FUR3NrMLo%3D&gmt_create=2016-11-21+19%3A30%3A57&buyer_pay_amount=0.01&receipt_amount=0.01&fund_bill_list=%5B%7B%22amount%22%3A%220.01%22%2C%22fundChannel%22%3A%22ALIPAYACCOUNT%22%7D%5D&app_id=2016101702210607&seller_id=2088021988626903&notify_id=cc50d478daefa1fbb7bb0cd839dd986hp6&seller_email=tianxiazaixian%40vip.qq.com";




$bc = "total_amount=2.00&buyer_id=2088102116773037&body=大乐透2.1&trade_no=2016071921001003030200089909&refund_fee=0.00&notify_time=2016-07-19 14:10:49&subject=大乐透2.1&sign_type=RSA&charset=utf-8&notify_type=trade_status_sync&out_trade_no=0719141034-6418&gmt_close=2016-07-19 14:10:46&gmt_payment=2016-07-19 14:10:47&trade_status=TRADE_SUCCESS&version=1.0&sign=kPbQIjX+xQc8F0/A6/AocELIjhhZnGbcBN6G4MM/HmfWL4ZiHM6fWl5NQhzXJusaklZ1LFuMo+lHQUELAYeugH8LYFvxnNajOvZhuxNFbN2LhF0l/KL8ANtj8oyPM4NN7Qft2kWJTDJUpQOzCzNnV9hDxh5AaT9FPqRS6ZKxnzM=&gmt_create=2016-07-19 14:10:44&app_id=2015102700040153&seller_id=2088102119685838&notify_id=4a91b7a78a503640467525113fb7d8bg8e";



/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilter($para) {
	$para_filter = array();
	while (list ($key, $val) = each ($para)) {
		if($key == "sign" || $key == "sign_type" || $val == "")continue;
		else	$para_filter[$key] = $para[$key];
	}
	return $para_filter;
}



/**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
	function getSignVeryfy($para_temp, $sign) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = paraFilter($para_temp);
		
		print_r($para_filter);
		echo "<hr>";
		//对待签名参数数组排序
		$para_sort = argSort($para_filter);
		print_r($para_sort);
		echo "<hr>";
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = createLinkstring($para_sort);
		echo $prestr;
		echo "<hr>";
		//$prestr = urldecode($prestr);
		//$sign = urldecode($sign);
		$isSgin = false;
		switch (strtoupper(trim("RSA"))) {
			case "RSA" :
				$isSgin = rsaVerify($prestr, trim("MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCsdVe9BQZMQrvZTqaNHiNCm4i1
as0BmT++1aynHMYPOpxK/9egE6JCd6QuzvTunO6YtruU4QptUfQoYOm91mg9eV7Q
LKxjtff4Q4EbK8cghF7yRjmi/A+++GNU04wd21AotbZCRwMkuQ2rf9t8ETVJCCQ9
DsXeO+eebDIV9sk2DwIDAQAB"), $sign);
				break;
			default :
				$isSgin = false;
		}
		return $isSgin;
	}


/**
 * RSA验签
 * @param $data 待签名数据
 * @param $alipay_public_key 支付宝的公钥字符串
 * @param $sign 要校对的的签名结果
 * return 验证结果
 */
function rsaVerify($data, $alipay_public_key, $sign)  {
    //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
	$alipay_public_key=str_replace("-----BEGIN PUBLIC KEY-----","",$alipay_public_key);
	$alipay_public_key=str_replace("-----END PUBLIC KEY-----","",$alipay_public_key);
	$alipay_public_key=str_replace("\n","",$alipay_public_key);

    $alipay_public_key='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($alipay_public_key, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';
	echo $alipay_public_key;
    $res=openssl_get_publickey($alipay_public_key);
	
    if($res)
    {
		
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
		
    }
    else {
        echo "您的支付宝公钥格式不正确!"."<br/>"."The format of your alipay_public_key is incorrect!";
        exit();
    }
    openssl_free_key($res);    
    return $result;
}


/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSort($para) {
	ksort($para);
	reset($para);
	return $para;
}


/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstring($para) {
	$arg  = "";
	while (list ($key, $val) = each ($para)) {
		$arg.=$key."=".$val."&";
	}
	//去掉最后一个&字符
	$arg = substr($arg,0,count($arg)-2);
	
	//如果存在转义字符，那么去掉转义
	if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
	return $arg;
}


echo $bc;
echo "<br>";
$arr = explode('&',$a);

$newarr = array(); //待验签的参数
$sign = '';
$sign_type = '';
foreach($arr as $key=>$value){
	$varr = explode('=',$value);
	if($varr[0] == 'sign'){
		$sign = $varr[1];
	}
	//if($varr[0] == 'app_id' || $varr[0] == 'gmt_create' || $varr[0] == 'notify_id' || $varr[0] == 'seller_id'){
		//continue;
	//}
	if($varr[0] == 'sign_type'){
		$sign_type = $varr[1];	
	}
	$newarr[$varr[0]] = $varr[1];
	
}

print_r($newarr);
echo "<br>";
$results = getSignVeryfy($newarr,$sign);

var_dump($results);













