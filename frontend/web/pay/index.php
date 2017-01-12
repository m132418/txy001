
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线支付</title>
</head>
<form id="form1" name="form1" method="post" action="./zfb/alipayapi.php">
<body>
<p>充值用户：
  <input name="WIDsubject" type="text" id="WIDsubject" />
</p>
<p>充值金额： 
  <label>
  <input name="WIDtotal_fee" type="text" id="WIDtotal_fee" />
  </label>
</p>
<p> 
  <input type="submit" name="Submit" value="支付宝即时到帐充值" />
</p>
</body>
</form>
</html>
