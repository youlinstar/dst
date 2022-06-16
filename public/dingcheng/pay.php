<?php
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

/**
 * 支付参数
 */
$payurl = "paygo.wuibxkx.cn"; //支付网关联系客服获取
//-----------------------------统一下单接口-----------------------------------------

$dirname = dirname("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$paydata = array (
		'mchId' => "600500014", //商户ID，后台提取
		'billNo' => time ().mt_rand(1111,9999), //商户订单号
		'totalAmount' => 5*100, //金额
		'billDesc' => "在线充值", //商品名称
		'way' => payType(), //支付模式
		'payment' => 'wechat', //微信支付
		'notifyUrl' => "$dirname/notify.php", //回调地址 
		'returnUrl' => "$dirname/ok.php", //同步跳转 
		'attach' => "",
		"accKey" => "JA27049295015825" //收款账号
);
$Md5key = "585568557694abf40e541dce26642ea78e3fe999df7aed3496f56203f5b31edd"; //签名密钥，后台提取
$paydata ['sign'] = markSign ( $paydata, $Md5key );
$payUrl = "http://$payurl/game/unifiedorder"; //请求订单地址
$checkUrl = "http://$payurl/pay/checkTradeNo"; //主动查单地址
$ret = curl ( $payUrl, json_encode ( $paydata ) );
$data = json_decode ( $ret, true );
if ($data ['code'] == 0) {
	$data ['result']["returnUrl"] = $paydata["returnUrl"];
	$data ['result']["checkUrl"] = $checkUrl;
	if (payType() == "qrcode"){
		$url="html/qrcode.php"; //付款页面
		jumpPost($url,$data ['result']);
	} else {
		$url="html/h5.php"; //付款页面
		jumpPost($url,$data ['result']);
	}
} else {
	exit ( $data ['message'] );
}

/**
 * 支付类型，h5或扫码
 * @return string
 */
function payType(){
	if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
		return "qrcode";
	} else {
		return "wap";
	}
}

/**
 * 请求方法
 */
function curl($url, $post_data) {
	$ch = curl_init ();
	$header = [
			'Content-Type: application/json',
			'Content-Length: ' . strlen ( $post_data )
	];
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
	$output = curl_exec ( $ch );
	curl_close ( $ch );
	return $output;
}

/**
 * 签名方法
 */
function markSign($paydata, $signkey) {
	ksort ( $paydata );
	$str = '';
	foreach ( $paydata as $k => $v ) {
		if ($k != "sign" && $v != "") {
			$str .= $k . "=" . $v . "&";
		}
	}
	return strtoupper ( md5 ( $str . "key=" . $signkey ) );
}

/**
 * 表单跳转模式
 * $url 地址
 * $data 数据,支持数组或字符串，可留空
 * $target 是否新窗口提交，默认关闭
 */
function jumpPost($url,$data){
	$html = "<form id='form' name='form' action='".$url."' method='post'>";
	if (!empty($data)){
		if (is_array($data)){
			foreach ($data as $key => $val) {
				$html.= "<input type='hidden' name='".$key."' value='".$val."'/>";
			}
		} else {
			$html.= "<input type='hidden' name='value' value='".$data."'/>";
		}
	}
	$html.= "</form>";
	$html.= "<script>document.forms['form'].submit();</script>";
	exit($html);
}

?>
