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
}
   if($_POST['url']){

   $url=$_POST['url'];
   $rsa=rsaSign($url,$private_key);
   echo $rsa;
   }





