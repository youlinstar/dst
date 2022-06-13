<?php
$trade_status = $_REQUEST['trade_status'];//TRADE_SUCCESS成功
$out_trade_no = $_REQUEST['out_trade_no'];//提交的订单号
//回调参数，id，trade_no，out_trade_no，name，money
 //回调sgin算法 
$sign = md5(substr(md5($out_trade_no.$key),10));//$key是你的秘钥
   if($sign == $_REQUEST['$sign'] ){
    //修改成功代码
     echo 'success';//这里是告诉平台支付成功，此信息务必带上，否则异步通知将降速
   }