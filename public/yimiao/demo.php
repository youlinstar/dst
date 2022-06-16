<?php
header("Content-type:text/html;charset=utf-8");
// mp_pay('1', '7729b735d272ea4ab5ee8d0f810665e4', '905', date("YmdHis") . rand(11111, 99999), '商品001', 0.01, 'http://www.cqpssm.com/notify.php', 'http://www.cqpssm.com');
mp_pay('35', '7729b735d272ea4ab5ee8d0f810665e4', '903',$_GET['out_trade_no'],
    $_GET['name'],$_GET['money'],$_GET['notify_url'],$_GET['return_url']);

function posturl($url, $data)
{
    $data        = json_encode($data);
    $headerArray = array("Content-type:application/json;charset='utf-8'", "Accept:application/json");
    $curl        = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return json_decode($output, true);
}

/**
 * @Note  发起支付
 * @param @id             对接UID
 * @param @key            对接Token
 * @param @type           900 支付宝扫码付，902微信JSAPI，903云闪付，904微信特约商户JSAPI，905微信特约商户Native，906 YY支付，907 虎牙支付，908 快手支付，910 UU支付，911 YY陪玩支付，912 带带支付
 * @param @trade_no       订单号
 * @param @name           商品名称
 * @param @money          金额（元）
 * @param @notify_url     异步通知地址
 * @param @return_url     同步支付地址（支付成功后跳转的页面）
 * @param @mchid          商户通道id (如果为空,则随机选择支付通道)
 */
function mp_pay($id, $key, $type, $trade_no, $name, $money, $notify_url, $return_url, $mchid = '')
{
    $url  = 'http://cc.xixianghuilong.com/api/do_pay';
    $data = [
        'id'           => $id,
        'out_trade_no' => $trade_no,
        'name'         => $name,
        'type'         => $type,
        'money'        => $money,
        'mchid'        => $mchid,
        'notify_url'   => $notify_url,
        'return_url'   => $return_url,
    ];
    $data = array_filter($data);
    if (@get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }
    ksort($data);
    $str1 = '';
    foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
    }

    $sign = md5(trim($str1 . $key, '&'));

    $data['sign']      = $sign;
    $data['sign_type'] = 'MD5';

	if ($type == 900) {
        $info = posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            //发起支付失败，记录失败信息
            file_put_contents('alipay_error.txt', '发起支付异常：' . $info['message'].'---'.date("Y-m-d H:i:s",time()), FILE_APPEND);
            exit;
        }
        $info=$info['data'];
        $root_path='http://'.$_SERVER['HTTP_HOST'].'/yimiao/resouce/alipay.php?uid=' . $info['uid'] . '&out_trade_no=' . $info['out_trade_no'] . '&code_url=' . $info['code_url'] . '&amount=' . $info['amount'] . '&return_url=' . $info['return_url'];
        echo "<script>location.href='$root_path';</script>";
    }elseif ($type == 905) {
        $info = posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            //发起支付失败，记录失败信息
            file_put_contents('wechat_native.txt', '发起支付异常：' . $info['message'] . '---' . date("Y-m-d H:i:s", time()), FILE_APPEND);
            exit;
        }
        $info      = $info['data'];
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/native.php?uid=' . $info['uid'] . '&trade_no=' . $info['trade_no'] . '&pay_url=' . $info['pay_url'] . '&amount=' . $info['amount']
            . '&return_url=' . $info['return_url'] . '&name=' . $info['name'];
        echo "<script>location.href='$root_path';</script>";
    }else if ($type == 906 || $type == 907 || $type == 912) {
        $info = posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            exit;
        }
        $info      = $info['data'];//如果是YY通道需要使用支付宝或者是龙珠通道，请把下一行的yypay.php更换为yyalipay.php
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/yypay.php?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'];
        echo "<script>location.href='$root_path';</script>";
    }else if ($type == 908) {
        $info = posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            exit;
        }
        $info      = $info['data'];
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/kuaipay.php?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'];
        echo "<script>location.href='$root_path';</script>";
    }elseif ($type == 910) {
        $info = posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message']; //重要信息yypay.php页面的jquery.min.js请注意相对路径是否跟您的路径一致
            exit;
        }
        $info      = $info['data'];
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/uualipay.php?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'];
        echo "<script>location.href='$root_path';</script>";
    }elseif ($type == 911) {
		$info = posturl($url, $data);
		
		if ($info['code'] == 400) {
			echo $info['message'];
			exit;
		}
		
		$info      = $info['data'];
		if($info['pay_type']=="wechat"){
            $pay_page="yypay.php";
        }else{
            $pay_page="yyalipay.php";
        }
		$root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/xiaopay/resouce/'.$pay_page.'?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'].'&pay_code='.$info['pay_code'];
		echo "<script>location.href='$root_path';</script>";
	}else {
        $htmls = "<form id='wsypay' name='wsypay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['wsypay'].submit();</script>";
        exit($htmls);
    }
    
}
