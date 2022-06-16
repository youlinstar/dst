<?php 
date_default_timezone_set('PRC'); 
header("Content-type: text/html; charset=utf-8");
include_once("../../php/fun.php");
if($_POST){
    $check_str = $_POST['check_str'];
    $check_str = encrypt($check_str,"D");//订单查询网关
    $check_str = json_decode($check_str,true);
    
    //订单查询地址
    $check_url = $check_str['check_url'];
    //订单信息加密字符串
    $check_sign = $check_str['check_sign'];
    /*
    $arr['code']=0;
    $arr['msg']= $check_url;
    echo json_encode($arr);
    exit;
    */
    $arrdata = array(
        "check_sign"=>$check_sign
    );
    $header = array('Ktype:iscurl', 'User-Agent:' . $_SERVER['HTTP_USER_AGENT']);
    // CURL POST请求
    $result =  http_post($check_url,$header,$arrdata);
    $result = json_decode($result,true);
    if($result['code'] == 1){
        $arr['code']=1;
        $arr['msg']=$result['msg'];
    }else{
        $arr['code']=0;
        $arr['msg']=$result['msg'];
    }
}
echo json_encode($arr);


?>