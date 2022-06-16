<?php
header('Content-type:text/html;charset=utf-8');
extract($_GET);
?>
<!DOCTYPE html>
<html>
<head>
    <title>支付宝安全支付</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <style type="text/css">
        html {
            font-size: 62.5%;
            font-family: 'helvetica neue',tahoma,arial,'hiragino sans gb','microsoft yahei','Simsun',sans-serif
        }

        body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,button,textarea,p,blockquote,th,td,hr {
            margin: 0;
            padding: 0
        }

        body {
            line-height: 1.333;
            font-size: 12px
        }

        h1,h2,h3,h4,h5,h6 {
            font-size: 100%;
            font-family: arial,'hiragino sans gb','microsoft yahei','Simsun',sans-serif
        }

        input,textarea,select,button {
            font-size: 12px;
            font-weight: normal
        }

        input[type="button"],input[type="submit"],select,button {
            cursor: pointer
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        address,caption,cite,code,dfn,em,th,var {
            font-style: normal;
            font-weight: normal
        }

        li {
            list-style: none
        }

        caption,th {
            text-align: left
        }

        q:before,q:after {
            content: ''
        }

        abbr,acronym {
            border: 0;
            font-variant: normal
        }

        sup {
            vertical-align: text-top
        }

        sub {
            vertical-align: text-bottom
        }

        fieldset,img,a img,iframe {
            border-width: 0;
            border-style: none
        }

        img {
            -ms-interpolation-mode: bicubic
        }

        textarea {
            overflow-y: auto
        }

        legend {
            color: #000
        }

        a:link,a:visited {
            text-decoration: none
        }

        hr {
            height: 0
        }

        label {
            cursor: pointer
        }

        .clearfix:after {
            content: "\200B";
            display: block;
            height: 0;
            clear: both
        }

        .clearfix {
            *zoom: 1
        }

        a {
            color: #328CE5
        }

        a:hover {
            color: #2b8ae8;
            text-decoration: none
        }

        a.hit {
            color: #C06C6C
        }

        a:focus {
            outline: none
        }

        .hit {
            color: #8DC27E
        }

        .txt_auxiliary {
            color: #A2A2A2
        }

        .clear {
            *zoom: 1
        }

        .clear:before,.clear:after {
            content: "";
            display: table
        }

        .clear:after {
            clear: both
        }

        body,.body {
            background: #eeeeee;
            height: 100%
        }
        .panel-tp-bd{
            background: radial-gradient(circle, #eeeeee, #eeeeee 50%, white 50%, white 100% ) -9px -8px / 16px 16px repeat-x;
            height: 8px;
        }
        .panel-bt-bd{
            background: radial-gradient(circle, #eeeeee, #eeeeee 50%, white 50%, white 100% ) -9px -0px / 16px 16px repeat-x;
            height: 8px;
        }
        .mod-title {
            height: 60px;
            line-height: 60px;
            text-align: center;
            border-bottom: dashed #e5e5e5 1px;
            background: #fff
        }

        .mod-title .ico-wechat {
            display: inline-block;
            width: 41px;
            height: 36px;
            background: url("img/wechat-pay.png") 0 -115px no-repeat;
            vertical-align: middle;
            margin-right: 7px
        }

        .mod-title .text {
            font-size: 20px;
            color: #333;
            font-weight: normal;
            vertical-align: middle
        }

        .mod-ct {
            width: 610px;
            padding: 0 135px;
            margin: 0 auto;
            margin-top: 15px;
            background: #fff url("img/wave.png") top center repeat-x;
            text-align: center;
            color: #333;
            border: 1px solid #e5e5e5;
            border-top: none
        }

        .mod-ct .order {
            font-size: 20px;
            padding-top: 30px
        }

        .mod-ct .amount {
            font-size: 48px;
            margin-top: 20px
        }

        .mod-ct .qr-image {
            margin-top: 30px
        }

        .mod-ct .qr-image img {
            width: 230px;
            height: 230px
        }

        .mod-ct .detail {
            margin-top: 10px;
            padding-top: 15px
        }

        .mod-ct .detail .arrow .ico-arrow {
            display: inline-block;
            width: 20px;
            height: 11px;
            background: url("img/wechat-pay.png") -25px -100px no-repeat
        }

        .mod-ct .detail .detail-ct {
            display: none;
            font-size: 14px;
            text-align: right;
            line-height: 28px
        }

        .mod-ct .detail .detail-ct dt {
            float: left
        }

        .mod-ct .detail-open {
            border-top: 1px solid #e5e5e5
        }

        .mod-ct .detail .arrow {
            padding: 6px 34px;
            border: 1px solid #e5e5e5
        }

        .mod-ct .detail .arrow .ico-arrow {
            display: inline-block;
            width: 20px;
            height: 11px;
            background: url("img/wechat-pay.png") -25px -100px no-repeat
        }

        .mod-ct .detail-open .arrow .ico-arrow {
            display: inline-block;
            width: 20px;
            height: 11px;
            background: url("img/wechat-pay.png") 0 -100px no-repeat
        }

        .mod-ct .detail-open .detail-ct {
            display: block
        }

        .mod-ct .tip {
            margin-top: 40px;
            border-top: 1px dashed #e5e5e5;
            padding: 30px 0;
            position: relative
        }

        .mod-ct .tip .ico-scan {
            display: inline-block;
            width: 56px;
            height: 55px;
            background: url("img/wechat-pay.png") 0 0 no-repeat;
            vertical-align: middle;
            *display: inline;
            *zoom: 1
        }

        .mod-ct .tip .tip-text {
            display: inline-block;
            vertical-align: middle;
            text-align: left;
            margin-left: 23px;
            font-size: 16px;
            line-height: 28px;
            *display: inline;
            *zoom: 1
        }

        .mod-ct .tip .dec {
            display: inline-block;
            width: 22px;
            height: 45px;
            background: url("img/wechat-pay.png") 0 -55px no-repeat;
            position: absolute;
            top: -23px
        }

        .mod-ct .tip .dec-left {
            background-position: 0 -55px;
            left: -136px
        }

        .mod-ct .tip .dec-right {
            background-position: -25px -55px;
            right: -136px
        }
        #footer{
            margin-top: 20px;
            border-top: 1px dashed #e5e5e5;
            padding: 10px 0;
            position: relative;
        }
        #footer .tip-text{
            display: inline-block;
            vertical-align: middle;
            text-align: left;
            margin-left: 10px;
            font-size: 16px;
            line-height: 28px;
        }
        #footer .ico-scan {
            display: inline-block;
            width: 56px;
            height: 55px;
            background: url('img/wechat-pay.png') 0 0 no-repeat;
            vertical-align: middle;
            margin-right: 7px;
        }
        .foot {
            text-align: center;
            margin: 30px auto;
            color: #888888;
            font-size: 12px;
            line-height: 20px;
            font-family: "simsun"
        }

        .foot .link {
            color: #0071ce
        }
        .panel-heading h5{
            font-size: 14px;
            color: #ff5500 !important;
            padding: 5px 0;
            font-weight: bold;
        }
        .layui-layer-content{
            height: auto !important;
        }

        #qrcode{
            text-align: center;
        }
    </style>
</head>
<body>


<div id="divMain" style="text-align: center;font-family:微软雅黑; margin-bottom: 20px;">
    <div id="panelWrap" class="panel-wrap">
        <div class="panel-tp-bd"></div>
        <div class="panel panel-easypay">
            <h1 class="mod-title">
                <span class="ico-alipay"></span><span class="text">支付宝支付</span>
            </h1>
            <div class="panel-heading">
                <h3>
                    <small>订单号：<?php echo $out_trade_no;?></small>

                </h3>
                <div class="money">
                    <span class="price"><?php echo $amount?></span>
                    <span class="currency">元</span>
                </div>
                <script type="text/javascript">
					var scheme = 'alipays://platformapi/startapp?saId=10000007&qrcode=';
					scheme += encodeURIComponent( "<?php echo $code_url;?>");

                    var ua = navigator.userAgent;

                    var ipad = ua.match(/(iPad).*OS\s([\d_]+)/),
                        isIphone =!ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/),
                        isAndroid = ua.match(/(Android)\s+([\d.]+)/),
                        isMobile = isIphone || isAndroid;
                    //判断
                    if(isMobile){
						if (isIphone && ua.match(/QQ/i) == "QQ") {
							document.write('<a href="'+scheme+'"><img src="img/alipaybtn.gif" style="width: 70%;"></a>');
						}else{
							document.write('<a href="javascript:void(0)" onclick="openZfb();"><img src="img/alipaybtn.gif" style="width: 70%;"></a>');
						}
                        
                    }
                </script>
            </div>
            <div class="qrcode-warp">
                <div id="qrcode">
                    <img id="qrcode_load" src="http://api.k780.com:88/?app=qr.get&data=<?php echo urlencode($pay_url) ?>&level=L&size=8">
                </div>
            </div>

            <div id="footer">
                <div class="ico-scan"></div>
                <div class="tip-text">
                    <p>&nbsp;自动跳转支付宝付款</p>
                    <p>或使用支付宝'扫一扫'</p>
                </div>
            </div>
        </div>
        <div class="panel-bt-bd"></div>
    </div>
</div>
<script type="text/javascript">
    function is_weixin() {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            return true;
        } else {
            return false;
        }
    }

    //    var cssText = "#weixin-tip{position: fixed; left:0; top:0; background: rgba(0,0,0,0.8); filter:alpha(opacity=80); width: 100%; height:100%; z-index: 100;} #weixin-tip p{text-align: center; margin-top: 10%; padding:0 5%;}";
    if (is_weixin()) {
        document.write("<img style='width: 100%' src='img/wex1.jpg'>");
        document.write("<img style='width: 100%' src='img/tu2.jpg'>");
        document.getElementById("divMain").style.display = "none";
    }
</script>
<div style="text-align: center;margin-top: 15px;">
    <a href="http://www.0816mama.com/" target="_blank" class="copyright">由「晓晓支付平台」提供收款支持</a>
</div>
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.3/layer.js"></script>
<script src="https://open.mobile.qq.com/sdk/qqapi.js"></script>
<script type="text/javascript">

    function openZfb() {
        var scheme = 'alipays://platformapi/startapp?saId=10000007&qrcode=';
        scheme += encodeURIComponent( "<?php echo $code_url;?>");
        if (navigator.userAgent.indexOf("Safari") > -1) {
            window.location.href = scheme;
        } else {
            var iframe = document.createElement("iframe");
            iframe.style.display = "none";
            iframe.src = scheme;
            document.body.appendChild(iframe);
        }
    }
    openZfb();
    //订单监控  {订单监控}
    function order() {
        $.get("https://www.xoynqkd.cn/api/query_order?id=<?php echo $uid?>&trade_no=<?php echo $out_trade_no;?>&sign=aa&sign_type=bb", function (result) {
            //成功
           
            if (result.code == 200 && result.data.status == 1) {
                //回调页面
                window.clearInterval(orderlst);
                layer.confirm(result.message, {
                    icon: 1,
                    title: '支付成功！',
                    btn: ['我知道了'] //按钮
                }, function () {
                    location.href = "<?php echo $return_url;?>";
                });
                setTimeout(function () {
                    location.href = "<?php echo $return_url;?>";
                }, 500);
            }
        });
    }
    var orderlst = setInterval("order()", 1000);
    var second = 0;
	var csdsq = setInterval(function(){
		second++;
		var showtime = '';
		if(120-second>60){
		    var miao = (120-second-60);
		    if(miao<10){
		        miao = '0'+miao;
		    }
		    showtime = '1:'+miao;
		}else{
		    showtime='0:'+(120-second);
		}
		// $('#djs').html(showtime);
		if(second>=120){
		    clearInterval(csdsq);
			layer.confirm('订单已失效，请重新发起支付！', {
                    icon: 1,
                    title: '订单失效！',
                    btn: ['我知道了'] //按钮
                }, function () {
                    location.href = "<?php echo $return_url;?>";
             });
		}
	}, 1000);

</script>
</body>
</html>
