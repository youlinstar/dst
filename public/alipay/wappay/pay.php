<?php
/* *
 * 功能：支付宝手机网站支付接口(alipay.trade.wap.pay)接口调试入口页面
 * 版本：2.0
 */
ini_set("display_errors","On");
error_reporting();
header("Content-type: text/html; charset=utf-8");

function is_weixin(){ 
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
    }   
    return false;
}
function get_true_ip($num_ip = false){
    if(is_weixin() && $_SERVER['HTTP_X_FORWARDED_FOR_POUND']){
        $realip = $_SERVER['HTTP_X_FORWARDED_FOR_POUND'];
    }elseif(is_qqbrowser() && $_SERVER['HTTP_X_FORWARDED_FOR_POUND']){
        $realip = $_SERVER['HTTP_X_FORWARDED_FOR_POUND'];
    }else{
        if(isset($_SERVER)){

            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        }else{
            if(getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
            }elseif(getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            }else{
                $realip = getenv("REMOTE_ADDR");
            }
        }
    }
    if($num_ip){
        return  sprintf('%u',ip2long($realip));
    }
    return $realip;
}
function is_qqbrowser(){
    if (strpos($_SERVER['HTTP_USER_AGENT'],'MQQBrowser/')!== false ) {
        return true;
    }
    return false;
}
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeWapPayContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';
//if (!empty($_POST['WIDout_trade_no'])&& trim($_POST['WIDout_trade_no'])!=""){
    //商户订单号，商户网站订单系统中唯一订单号，必填
    
   
    $out_trade_no = $_GET['out_trade_no'];

    //订单名称，必填
    $subject = "test";
    
    //付款金额，必填
 
    $total_amount = $_GET['money'];
   

    //商品描述，可空
    $body = 'vip';

    
    //超时时间
    $timeout_express="1m";

    //保存订单//
    $create_time = strtotime("now");
    
    $total_amounts = $total_amount*100;
    
  
    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);
    $payResponse = new AlipayTradeService($config);
    $return_url = $_GET['return_url'];
    $notify_url = $_GET['notify_url'];
    $result=$payResponse->wapPay($payRequestBuilder,$return_url,$notify_url);

  //  return ;
//}