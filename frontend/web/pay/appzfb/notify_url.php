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
    $sign = base64_encode($sign);
    return $sign;
}//RSA签名算法、不可修改

$out_trade_no = $_POST['out_trade_no'];

$trade_no = $_POST['trade_no'];

$notify_time=$_POST['notify_time'];

$notify_type="trade_status_sync";

$notify_id=$_POST['notify_id'];

$trade_status=$_POST['trade_status'];

$app_id="2016101702210607";

$charset="utf-8";

$version="1.0";

$sign_type="RSA";

$passback_params=urlencode('txy');//这是传入的用户名参数

$total_amount='0.1';

$trade_status=$_POST['trade_status'];

$post_string = rsaSign("app_id=".$app_id."&charset=".$charset."&notify_time=".$notify_time."&notify_type=".$notify_type."&notify_id=".$notify_id."&out_trade_no=".$out_trade_no."&passback_params=".$passback_params."&total_amount=".$total_amount."&trade_no=".$trade_no."&trade_status=".$trade_status."&trade_status=".$trade_status."&version=".$version."","MIICXgIBAAKBgQCsdVe9BQZMQrvZTqaNHiNCm4i1as0BmT++1aynHMYPOpxK/9eg
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
$sign=$post_string;
$post_string = "out_trade_no=".$out_trade_no."&trade_no=".$trade_no."&notify_time=".$notify_time."&notify_type=".$notify_type."&notify_id=".$notify_id."&app_id=".$app_id."&charset=".$charset."&version=".$version."&sign_type=".$sign_type."&trade_status=".$trade_status."&sign=".$sign."&passback_params=".$passback_params."&total_amount=".$total_amount."&trade_status=".$trade_status."";//POST提交数据
$wenben=request_by_curl('http://notify.alipay.com/trade/notify_query.do?',$post_string);//POST提交地址+数据
echo $wenben;
exit;
if($_POST['trade_status']=="TRADE_SUCCESS"){
$mysql = mysql_connect('localhost', 'root', 'root');
mysql_select_db('sq', $mysql);
$sql = mysql_query("SELECT * FROM order WHERE orderid='".$out_trade_no."'", $mysql);//执行判断订单是否存在
mysql_query("SET NAMES 'utf8'", $mysql);
  if(mysql_num_rows($sq, $mysql)>=1){  
	  
      echo "当查询到订单记录,那么跳过订单的添加,防止重复";
	  
	}else{
	  
$sql = mysql_query("INSERT INTO `order` SET `orderid`='".$out_trade_no."',`uorder`='".$trade_no."',`user`='".$passback_params."',`money`='".$total_amount."',`time`='".$notify_time."',`state`='1',`lx`='APP';", $mysql);//执行数据的添加
	  
	}

}
    