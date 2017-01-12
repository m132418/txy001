<?php




function argSort($para) {
	ksort($para);
	reset($para);
	return $para;
}

function rsaSign($data, $private_key) {
    //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
    $private_key=str_replace("-----BEGIN RSA PRIVATE KEY-----","",$private_key);
	$private_key=str_replace("-----END RSA PRIVATE KEY-----","",$private_key);
	$private_key=str_replace("\n","",$private_key);

	$private_key="-----BEGIN RSA PRIVATE KEY-----".PHP_EOL .wordwrap($private_key, 64, "\n", true). PHP_EOL."-----END RSA PRIVATE KEY-----";

    $res=openssl_get_privatekey($private_key);

    if($res)
    {
        openssl_sign($data, $sign,$res);
    }
    else {
        echo "您的私钥格式不正确!"."<br/>"."The format of your private_key is incorrect!";
        exit();
    }
    openssl_free_key($res);
	//base64编码
    $sign = base64_encode($sign);
    return $sign;
}



/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstringUrlencode($para) {
	$arg  = "";
	while (list ($key, $val) = each ($para)) {
		$arg.=$key."=".urlencode($val)."&";
	}
	//去掉最后一个&字符
	$arg = substr($arg,0,count($arg)-2);
	
	//如果存在转义字符，那么去掉转义
	if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
	return $arg;
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




/*"total_amount":"0.01","buyer_id":"2088812443944434","trade_no":"2016112221001004430238457981","body":"\u5929\u4e0b\u6e38-VIP 1\u5e74\u589e\u503c\u670d\u52a1","notify_time":"2016-11-22 17:10:44","subject":"\u5929\u4e0b\u6e38-vip","sign_type":"RSA","buyer_logon_id":"897***@qq.com","auth_app_id":"2016101702210607","charset":"utf-8","notify_type":"trade_status_sync","invoice_amount":"0.01","out_trade_no":"TXY20161122ce681e3b3c04","trade_status":"TRADE_SUCCESS","gmt_payment":"2016-11-22 17:10:44","version":"1.0","point_amount":"0.00","sign":"H4KBCiVAil6cA+CW8S4dNGZkCrLpC7X07lNCozG3BjamEMhc380oZ+SCIw4iJfRBlSlUeWu1\/5koWzpvGLe0xekStdq59DVoqMo0G1kJx\/mcUfGtgD31H3LqL8TlNTTAVMJZA+MDILJNv1t943RT0rqlqNCtscZiHWP3JK35B5s=","gmt_create":"2016-11-22 17:10:42","buyer_pay_amount":"0.01","receipt_amount":"0.01","fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","app_id":"2016101702210607","seller_id":"2088021988626903","notify_id":"84e986316f4760c1b7ed4f68e02efa4jbi","seller_email":"tianxiazaixian@vip.qq.com"*/



$url = "https://openapi.alipay.com/gateway.do?";
$mygoods['timestamp'] = date('Y-m-d h:i:s',time());
$mygoods['method'] = "alipay.trade.query";
$mygoods['app_id'] = "2016101702210607";
$mygoods['charset'] = "utf-8";
$mygoods['sign_type'] = "RSA";
$mygoods['version'] = "1.0";
$mygoods['biz_content'] =  json_encode(array(
		'out_trade_no'=> 'TXY20161216b93068cc9bb677203'
		
));

$mystr = createLinkstringUrlencode($mygoods);


$newmygoods = argSort($mygoods);
$newmystr = createLinkstring($newmygoods);
//生成签名
$sign = rsaSign($newmystr,"MIICXgIBAAKBgQCsdVe9BQZMQrvZTqaNHiNCm4i1as0BmT++1aynHMYPOpxK/9eg
E6JCd6QuzvTunO6YtruU4QptUfQoYOm91mg9eV7QLKxjtff4Q4EbK8cghF7yRjmi
/A+++GNU04wd21AotbZCRwMkuQ2rf9t8ETVJCCQ9DsXeO+eebDIV9sk2DwIDAQAB
AoGBAJmHvZxhJMIvhtxm0I9BDVL29DXN5sRNkhpqT1JWo1xbaVi7e1LfJ8zUhi3F
wPfMbf02cLiRv56jHyHzZSPEBPd+b4y782xtz4/z8bp/XVQcwABedmcHoHuBufdb
kilSOUZbepS1lup1IVbzQAmSeIl57dV0Fre5MeaFBFV6Qt6BAkEA4Gyc2Y2bnmy0
o+h8Z+dnehyOY1txBMO3gTkWQOqLfRsqoIRUpjz6j1hZsRM+y0UUNhZcFY6FVTEw
ql3oJ2UHJwJBAMS5AVLosAGoaKQL+QIKZEtbFGL2CmEh0peKUHNZNGpXSOZUXNS1
mKWRLnmPAG4e+u0e+ew1yTp+jCAQyhdQatkCQQC0+cEuiswwYDb3anZQD8JZLYgB
RW8JSY7EbTWt2bXsiCjC0pO0jr37NGL3sa5UmvsmdreBRrHstkMpT5rzkbvHAkEA
jEy1mP/CpywIlRbE3KO0q9mlTH7VIDkTDGjkv59bNoxRvZNlMX7iAxLr5l4KnH8T
zpFNBR3HCiS+ow/WUZJU4QJAFup2EGJhrIouUtCyIMRhX+N7yIb8+7dHPVM2vSSO
qsQbu57Fkpx3fHk/zF6xzBWDrboRMiUy5hnWc1Km6pj2Uw==");//进行RSA加密,具体可以看官方文档,方式和官方文章相同


//生成支付宝请求参数
$orderInfor = $mystr."&sign=".urlencode($sign);
$result = file_get_contents($url.$orderInfor);

$objsult = json_decode($result);

$arrsult = $objsult->alipay_trade_query_response;
echo $arrsult->out_trade_no;
print_r($arrsult);





