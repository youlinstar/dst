<?php
header('Content-type:text/html;charset=utf-8');
extract($_GET);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>扫码支付</title>
    <link href="css/pay.css" rel="stylesheet" media="screen">
    <link href="css/paybtn.css" rel="stylesheet" media="screen">
    <link href="css/toastr.min.css" rel="stylesheet" media="screen">
    <script src="js/jquery.min.js"></script>
</head>

<body>
<div class="body" id="body">

    <h1 class="mod-title">
        <span class="ico_log ico-1"></span>
    </h1>

    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="timeOut" style="font-size: 20px;color: red;display: none;"><p>订单已过期，请您返回网站重新发起支付</p><br></div>
        <div id="orderbody">
            <div class="amount" id="money">￥<span id="copy_money"><?php echo $money; ?></span></div>
            <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
                <div data-role="qrPayImg" class="qrcode-img-area">
                    <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                    <div style="position: relative;display: inline-block;">
                        <img  id='show_qrcode' alt="扫码ing" src="http://api.k780.com:88/?app=qr.get&data=<?php echo urlencode($pay_url) ?>&level=L&size=8" width="275" height="275" style="display: block;">

                        <img onclick="$('#use').hide()" id="use" src="picture/use_1.png" style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -16px;margin-top: -16px">
                    </div>
                </div>

            </div>


            <div class="time-item">
                <div class="time-item" id="msg">
                    <h1><span style="color:red">温馨提示：请长按二维码识别付款,支付后耐心等待几秒！
                    </span><br></h1>
                </div>

                <strong id="hour_show">0时</strong>
                <strong id="minute_show">0分</strong>
                <strong id="second_show">0秒</strong>
            </div>


            <div class="tip">
                <div class="ico-scan"></div>
                <div class="tip-text">
                    <p>请使用微信扫一扫</p>
                </div>
            </div>

            <div class="detail" id="orderDetail">
                <dl class="detail-ct" id="desc" style="display: none;">
                    <dt>订单金额：</dt>
                    <dd><?php echo $money; ?></dd>
                    <dt>商户订单号：</dt>
                    <dd><?php echo $user_order_num; ?></dd>
                    <dt>订单状态</dt>
                    <dd>等待支付</dd>
                </dl>

                <a href="javascript:void(0)" class="arrow" onclick="aaa()"><i class="ico-arrow"></i></a>
            </div>
        </div>

        <div class="tip-text"></div>

    </div>
    <div class="foot">
        <div class="inner">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在微信扫一扫中选择“相册”即可</p>
        </div>
    </div>
</div>


<div class="copyRight"></div>

<script src="js/toastr.min.js"></script>

<script>
    function aaa() {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    }
    function formatDate(now) {
        now = new Date(now*1000)
        return now.getFullYear()
            + "-" + (now.getMonth()>8?(now.getMonth()+1):"0"+(now.getMonth()+1))
            + "-" + (now.getDate()>9?now.getDate():"0"+now.getDate())
            + " " + (now.getHours()>9?now.getHours():"0"+now.getHours())
            + ":" + (now.getMinutes()>9?now.getMinutes():"0"+now.getMinutes())
            + ":" + (now.getSeconds()>9?now.getSeconds():"0"+now.getSeconds());

    }
    var myTimer;
    function timer(intDiff) {
        var i = 0;
        i++;
        var day = 0,
            hour = 0,
            minute = 0,
            second = 0;//时间默认值
        if (intDiff > 0) {
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
        }
        if (minute <= 9) minute = '0' + minute;
        if (second <= 9) second = '0' + second;
        $('#hour_show').html('<s id="h"></s>' + hour + '时');
        $('#minute_show').html('<s></s>' + minute + '分');
        $('#second_show').html('<s></s>' + second + '秒');
        if (hour <= 0 && minute <= 0 && second <= 0) {
            qrcode_timeout()
            clearInterval(myTimer);

        }
        intDiff--;

        myTimer = window.setInterval(function () {
            i++;
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            if (hour <= 0 && minute <= 0 && second <= 0) {
                qrcode_timeout()
                clearInterval(myTimer);

            }
            intDiff--;
        }, 1000);
    }



    function qrcode_timeout(){
        document.getElementById("orderbody").style.display = "none";
        document.getElementById("timeOut").style.display = "";
    }


    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return null;
    }



	timer(90);
	check();

    function check() {
        $.get("https://www.xoynqkd.cn/api/query_order?id=<?php echo $uid; ?>&trade_no=<?php echo $user_order_num; ?>&sign=aa&sign_type=bb&check=users",function (result) {
            if (result.code == 200 && result.data.status == 1){
                window.clearInterval(myTimer);
                location.href = "<?php echo $return_url; ?>";

                setTimeout(function () {
                    location.href = "<?php echo $return_url; ?>";
                }, 500);
            } else{
                setTimeout("check()",1000);
            }
        })
    }

</script>
</body>
</html>