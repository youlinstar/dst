<?php
///////请注意路径///////
$payurl = "http://pay.fangyoufang.net/api/mp_pay.html";//网关地址
$paykey = "d21c6fbbfc621dffa16f2e42266e77ca";
$tzurl = "http://" . $_SERVER['HTTP_HOST'] . "/pay/notify.php";//异步回调地址
$back = "http://" . $_SERVER['HTTP_HOST'] . "/pay/callback.php";//同步回调地址
$path = "http://" . $_SERVER['HTTP_HOST'] . "/pay/rquery.php";//此文件路径要对 不然没有同步回调
$payid = 11;


$parameter = array(
    "mtype" => 1016,//1016捕鱼
    "id" => $payid,
    "notify_url" => $tzurl,
    "return_url" => $back,
    "trade_no" => rand(100000000, 9999999999),//订单号
    "name" => '测试', //名称
    "money" => 1,//金额为整数型 字符串会导致签名失败
    "json" => '1'//保持
);
ksort($parameter);
reset($parameter);
$fieldString = [];
foreach ($parameter as $key => $value) {
    if (!empty($value)) {
        $fieldString[] = $key . "=" . $value . "";
    }
}
$fieldString = implode('&', $fieldString);
$sign = md5($fieldString . $paykey);
$purl = $payurl . "?" . $fieldString . "&sign=" . $sign . "&sign_type=MD5";
$data = file_get_contents($purl);
$data = json_decode($data, true);
$tjurl = $data['url'];
$data = $data['data'];
$header = array('Ktype:iscurl', 'User-Agent:' . $_SERVER['HTTP_USER_AGENT']);
$data = http_post($tjurl, $header, $data);
$fdata = json_decode($data, true);
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {//判断是否在微信里打开
    if ($fdata['code'] == 1) {//微信内扫码付款

        $tjdata = 'wxurl=' . $fdata['wxurl'] . '&sign=' . $fdata['sign'] . '&serial_no=' . $fdata['serial_no'] . '&qtype=' . $fdata['qtype'] . '&url=' . $fdata['url'] . '&return=' . $parameter['return_url'] . '&path=' . $path;
        //$tjurl路径要对
        $tjurl = "http://" . $_SERVER['HTTP_HOST'] . "/pay/2dcdc/bypay.php?" . $tjdata; //付款页面文件的路径  请注意路径

        header("Location:$tjurl");
    } else {
        echo('error');
    }
} else {
    if ($fdata['code'] == 1) {//h5拉起付款

        $tjdata = 'wxurl=' . $fdata['wxurl'] . '&sign=' . $fdata['sign'] . '&serial_no=' . $fdata['serial_no'] . '&qtype=' . $fdata['qtype'] . '&url=' . $fdata['url'] . '&return=' . $parameter['return_url'] . '&path=' . $path . '&money=' . $parameter['money'];
        //$tjurl路径要对
        $tjurl = "http://" . $_SERVER['HTTP_HOST'] . "/pay/2dcdc/byh5.php?" . $tjdata; //付款页面文件的路径    请注意路径
        header("Location:$tjurl");
    } else {
        echo('error');
    }
}

function http_post($sUrl, $aHeader, $aData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
    $sResult = curl_exec($ch);
    if ($sError = curl_error($ch)) {
        die($sError);
    }
    curl_close($ch);
    return $sResult;
}
