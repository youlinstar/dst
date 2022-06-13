<?php
header('Content-type:text/html;charset=utf-8');
extract($_GET);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Native支付</title>
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
            font-size: 14px
        }

        h1,h2,h3,h4,h5,h6 {
            font-size: 100%;
            font-family: arial,'hiragino sans gb','microsoft yahei','Simsun',sans-serif
        }
        #divMain{
            width: 100%;
            height: 100%;
            background: #EFEFEF;
            position: absolute;
        }

        img {
            -ms-interpolation-mode: bicubic
        }
        .money{
            margin-top: 2rem;
            font-family: monospace;
            color: black;
        }
        .parent—fox{
            margin-top: 3rem;
            font-size: 17px;
            color: black;
            line-height: 55px;
        }
        .list-fox{
            height: 60px;
            width: 100%;
            background: white;
        }
        .left-way{
            float: left;
            margin-left: 12px;
        }
        .right-way{
            float: right;
            margin-right: 12px;
        }
        .clear-way{
            clear:both;
        }
        hr{
            margin:0px;
            height:1px;
            border:0px;
            background-color:#D5D5D5;
            color:#D5D5D5;
        }
        #button {
            background: #1AAD19;
            /* background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9); */
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 10px;
            font-family: Arial;
            color: #ffffff;
            font-size: 16px;
            padding: 12px 30px 12px 30px;
            text-decoration: none;
            width: 90%;
            border: none;
            margin-top: 6rem;
        }
        .layui-layer{
            left: 25px !important;
            top: 30% !important;
        }
        #zzc {
            display: none;
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            /*background-color: black;*/
            z-index: 998;
            -moz-opacity: 0.1;
            opacity: 0.5;
            filter: alpha(opacity=100);

        }
        .hide-img{
            position: absolute;
            z-index: 999;
            display: none;
            text-align: center;
            position:relative;

			text-align:center;
			vertical-align:middle;
            line-height: 300px;
        }
        .second-img{
            width: 82%;
            left: 10%;
            top: 250px;
        }
        .first-img{
            width: 31%;
            /* left: 1%; */
            margin-left: 65%;
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
            background: url('./img/wechat-pay.png') 0 0 no-repeat;
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
        .lebel-line{
            display:inline-block;
            height: 40px;
            line-height: 36px;
            font-size: 18px;

        }
        hr{
            width: 90%;
            margin-left: 5%;
        }
        .hide-imgs{
            position: absolute;
            z-index: 999;
            display: none;
            text-align: center;
            position:relative;

			text-align:center;
			vertical-align:middle;
            line-height: 300px;
        }

    </style>
</head>
<body>
<div id="zzc">

</div>
<div class="hide-img">
                <a style="font-size: 20px;font-family: '微软雅黑';">请在微信浏览器内打开此地址</a>
</div>

<div id="divMain" style="text-align: center;font-family:微软雅黑; margin-bottom: 20px;">
        <img class="hide-imgs first-img" src="./img/123333.png"/>
        <img class="hide-imgs second-img" src="./img/333444.png"/>
        <span id="check-out"></span>
        <div class="money">
            <span>
                <a class="text-fourth" style="font-size: 20px;">长按识别完成支付</a>
            </span><br>
            <div style="margin-top: 20px;"></div>
            <hr>
            <div>
                <span class="lebel-line" style="float:left;margin-left:30px">收款方</span>
                <span class="lebel-line" style="float:right;margin-right:30px">充值服务</span>
                <div style="clear: both;"></div>
            </div>
            <hr>
        </div>
        <hr>
        <div class="parent—fox">
            <img src="http://api.k780.com:88/?app=qr.get&data=<?php echo urlencode($pay_url) ?>&level=L&size=8" style="width: 300px;">
        </div>
        <div style="display: hidden;margin-top:10px;">

            <p href="#" class="text-third" style="color:red;font-size:18px">
               长按二维码识别完成支付
            </p>

        </div>

        <div style="margin-top:2px;">

            <p href="#" class="text-make" style="color:red;font-size:18px">
               支付完毕等待一到三秒即可查看商品
            </p>
        </div>


        <div id="footer" style="margin-top: 40px;">
                <div ><img style="width: 240px;" src="./img/label-wechat-pay.png" alt=""></div>
        </div>

        <div style="color:grey;font-size:16px;font-family:微软雅黑;">
            <p>友情提示：充值为提供寄售点充值，充值秒到账！！</p>
        </div>


</div>

<!-- jQuery -->
<script src="./js/jquery.min.js"></script>
<script src="//cdn.bootcss.com/layer/2.3/layer.js"></script>
<script type="text/javascript">


    $(function(){
        var ua = window.navigator.userAgent.toLowerCase();

        if (ua.match(/MicroMessenger/i) != 'micromessenger') {
            loadzz();
        }
            $('#dom-let').css('margin-top','0')
    })


    function loadzz(){
            $(".text-one").text("打开微信");
            $(".text-second").text("使用微信扫一扫");
            $(".text-third").text(" ↑ → 打开微信扫一扫完成支付 ← ↑ ");
            $(".text-fourth").text("打开微信扫一扫完成支付");
    }

    function order() {
       $.get("https://www.xoynqkd.cn/api/query_order?id=<?php echo $uid?>&trade_no=<?php echo $trade_no;?>&sign=aa&sign_type=bb",function (result) {
            //成功
            if (result.code == 1 && result.data.state == 1) {
                //回调页面
                window.clearInterval(orderlst);
                layer.confirm(result.msg, {
                    icon: 1,
                    title: '支付成功！',
                    btn: ['我知道了'] //按钮
                }, function () {
                    location.href = "<?php echo $return_url; ?>";
                });
                setTimeout(function () {
                    location.href = "<?php echo $return_url; ?>";
                }, 500);
            }
        });
    }
    var orderlst = setInterval("order()", 2000);

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