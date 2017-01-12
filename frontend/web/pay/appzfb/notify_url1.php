<?php

$private_key= 'MIICXgIBAAKBgQCsdVe9BQZMQrvZTqaNHiNCm4i1as0BmT++1aynHMYPOpxK/9eg
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
qsQbu57Fkpx3fHk/zF6xzBWDrboRMiUy5hnWc1Km6pj2Uw==
';//这里是公匙,可以删除



function request_by_curl($remote_server, $post_string)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
} //执行POST提交



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




$mygoods['app_id']="2016101702210607";
$out_trade_no = "TXY".date("Ymd").substr(md5(time()), 0, 12);
$mygoods['timestamp'] = "2016-07-29 16:55:53";//date('Y-m-d h:i:s',time());
//$mygoods['biz_content'] = '{"seller_id":"2088021988626903","product_code":"QUICK_MSECURITY_PAY","total_amount":"0.01","subject":"天下游-vip","body":"天下游-VIP 1年增值服务","out_trade_no":"56746546464646"}';
//$mygoods['biz_content'] = '{"timeout_express":"30m","product_code":"QUICK_MSECURITY_PAY","total_amount":"0.01","subject":"天下游-vip","body":"天下游-VIP 1年增值服务","out_trade_no":$out_trade_no}';
$mygoods['biz_content'] = json_encode(array(
		'timeout_express'=>	'30m',
		'product_code'=> 'QUICK_MSECURITY_PAY',
		'total_amount'=> '0.01',
		'subject'=>	'txy-vip',
		'body'=> 'txy-VIP1nyear',
		'out_trade_no'=> $out_trade_no
));
//$mygoods['out_trade_no'] = "TXY".date("Ymd").substr(md5(time()), 0, 12);
$mygoods['method'] = "alipay.trade.app.pay";//接口名称
$mygoods['charset'] = "utf-8";
$mygoods['notify_url'] = 'http://121.43.32.123:7658/alicallback/notifyurl';
$mygoods['version'] = "1.0";
$mygoods['sign_type'] = 'RSA';

print_r($mygoods);
//拼接
$mystr = createLinkstringUrlencode($mygoods);
echo $mystr;
echo "<br>";
//排序

$newmygoods = argSort($mygoods);
$newmystr = createLinkstring($newmygoods);
echo $newmystr;
echo "<br>";
echo '----------';

  

$sign = rsaSign($newmystr,"MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAKx1V70FBkxCu9lO
po0eI0KbiLVqzQGZP77VrKccxg86nEr/16ATokJ3pC7O9O6c7pi2u5ThCm1R9Chg
6b3WaD15XtAsrGO19/hDgRsrxyCEXvJGOaL8D774Y1TTjB3bUCi1tkJHAyS5Dat/
23wRNUkIJD0Oxd47555sMhX2yTYPAgMBAAECgYEAmYe9nGEkwi+G3GbQj0ENUvb0
Nc3mxE2SGmpPUlajXFtpWLt7Ut8nzNSGLcXA98xt/TZwuJG/nqMfIfNlI8QE935v
jLvzbG3Pj/Pxun9dVBzAAF52Zwege4G591uSKVI5Rlt6lLWW6nUhVvNACZJ4iXnt
1XQWt7kx5oUEVXpC3oECQQDgbJzZjZuebLSj6Hxn52d6HI5jW3EEw7eBORZA6ot9
GyqghFSmPPqPWFmxEz7LRRQ2FlwVjoVVMTCqXegnZQcnAkEAxLkBUuiwAahopAv5
AgpkS1sUYvYKYSHSl4pQc1k0aldI5lRc1LWYpZEueY8Abh767R757DXJOn6MIBDK
F1Bq2QJBALT5wS6KzDBgNvdqdlAPwlktiAFFbwlJjsRtNa3ZteyIKMLSk7SOvfs0
YvexrlSa+yZ2t4FGsey2QylPmvORu8cCQQCMTLWY/8KnLAiVFsTco7Sr2aVMftUg
ORMMaOS/n1s2jFG9k2UxfuIDEuvmXgqcfxPOkU0FHccKJL6jD9ZRklThAkAW6nYQ
YmGsii5S0LIgxGFf43vIhvz7t0c9Uza9JI6qxBu7nsWSnHd8eT/MXrHMFYOtuhEy
JTLmGdZzUqbqmPZT");//进行RSA加密,具体可以看官方文档,方式和官方文章相同


//生成最终签名信息
$orderInfor = $mystr."&sign=".urlencode($sign);

echo $orderInfor;
exit;

	
	
	