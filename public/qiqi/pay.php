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
    <title></title>
    <link href="./css/pay.css" rel="stylesheet" media="screen">
    <link href="./css/paybtn.css" rel="stylesheet" media="screen">
    <link href="./css/toastr.min.css" rel="stylesheet" media="screen">
    <script src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="//static.runoob.com/assets/qrcode/qrcode.min.js"></script>
</head>
<body>
   
<div class="body" id="body">
    <h1 class="mod-title">
        <span class="ico_log ico-1"></span>
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="timeOut" style="font-size:18px;color: red;display: none;"><p>订单已过期，请您返回网站重新发起支付</p><br></div>
        <div id="orderbody">
            <div class="amount" id="money" style="font-size:18px;color: #ec3813;"><span id="copy_money">长按二维码识别支付后自动播放</span></div> 
            <div class="amount" id="money">￥<span id="copy_money"><?php echo number_format($_REQUEST["totalAmount"],2);?></span></div>          
            <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
                <div data-role="qrPayImg" class="qrcode-img-area">
                    <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                    <div style="position: relative;display: inline-block;padding:5px;" id="qrcodePay"></div>
                    <!--用于存放canvas，隐藏-->
					<div id="QRCodeNone" style="display:none;"></div>
                </div>
            </div>
            <div class="time-item">
                <div class="time-item" id="msg" style="margin-bottom:6px;">
                    <h1><span style="color:red; font-size:1.7rem;">网络延迟没有跳转，请返回已购里观看</span><br></h1>
                </div>
                <strong id="hour_show">0时</strong>
                <strong id="minute_show">0分</strong>
                <strong id="second_show">0秒</strong>
            </div>

            <div class="tip" style="margin-top:10px;">
                <div class="ico-scan"></div>
                <div class="tip-text" style="margin-left:10px;">
                    <p>请使用微信扫一扫</p>
                </div>
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="inner">
            <p>微信用户请长按识别二维码支付</p>
            <p>或者用另一台微信手机扫码支付</p>
        </div>
    </div>
</div>
<div class="copyRight"></div>
<script src="./js/toastr.min.js"></script>
<script>
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
	timer(120);
	
    function check(){
		$.ajax({
			type: "post",
			url: "<?php echo $_REQUEST["checkUrl"];?>",
			dataType: "json",
			timeout : 5000,
			data: {tradeNo:'<?php echo $_REQUEST["tradeNo"] ?>'},
			success: function(obj){
				if(obj.data.status==1){ 
					window.location.href = '<?php echo $_REQUEST["returnUrl"]?>';
				}else{
				    //alert(obj.message);
				}
			}
		});
	}
	var check_time = setInterval(check,2000);
</script>
<script type="text/javascript">
/**
 * 显示二维码
 */
function makeCode () {
	var qrcode = new QRCode(document.getElementById("QRCodeNone"), {
		text: "<?php echo $_REQUEST["payInfo"]?>", //二维码数据
		width : 200,
		height : 200,
		correctLevel : QRCode.CorrectLevel.H
	});
    var myCanvas = document.getElementsByTagName('canvas')[0];
    var img = convertCanvasToImage(myCanvas);
    $("#qrcodePay").append(img);
}
//将canvas返回的图片添加到image里
function convertCanvasToImage(canvas){
	var image = new Image();
	image.src = canvas.toDataURL("image/png");
	return image;
}
makeCode();
</script>


</body>
</html>
<script>
    //禁止滚动
    document.body.addEventListener('touchmove', function (e) {e.preventDefault();}, {passive: false});
</script>