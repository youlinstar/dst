<?php
header('Content-type:text/html;charset=utf-8');
extract($_GET);
?>
<!DOCTYPE html>
<html>
<head>
    <title>YY支付宝支付</title>
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
                position: fixed;
                top: 0%;
                left: 0%;
                width: 100%;
                height: 100%;
                background-color: black;
                z-index: 999;
                -moz-opacity: 0.1;
                opacity: 0.9;
        }
        .hide-img{
            z-index: 999;
            display: none;
            text-align: center;
            position:fixed;

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
            background: url("./img/wechat-pay.png") 0 0 no-repeat;
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


<div id="dom-let" style="padding: 0;font-size:18px;font-family:'微软雅黑';">
    <div class="hide-img">
        <img class="hide-img second-img" src="./img/333444.png" style="width: 320px;top: 41%;left: 9%;"/>
        <img class="hide-img first-img" src="./img/123333.png" style="width: 150px;left: 60%;;margin-left:0%"/>
    </div>
    <div id="is-hide" style="text-align: center;padding-top: 120px;">
        <img src="./img/alipay.png" alt="" style="width: 220px;">
    </div>
    <div style="margin:0 auto;border:1px solid #000;width:300px;height:50px;display:table;color:#1477F8;background: #1477F8;border-radius: 8px;
    border: none;margin-top: 100px;text-align:center" id="pay_btn">
        <a id="gopay" href="alipays://platformapi/startapp?saId=10000007&qrcode=<?php echo $pay_url; ?>" style="display:table-cell;vertical-align:middle;color:white;text-decoration:none;">点击打开支付宝APP支付</a>
    
    </div>

</div>
<!-- jQuery -->
<script src="./js/jquery.min.js"></script>

<script src="//cdn.bootcss.com/layer/2.3/layer.js"></script>
<script type="text/javascript">


    $(function(){
        var ua = window.navigator.userAgent.toLowerCase();

        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            loadzz();return false;
        }
       
        $('#dom-let').css('margin-top','0');
        var scheme = encodeURIComponent( "<?php echo $pay_url;?>");
					
        $('#gopay').attr('href','alipays://platformapi/startapp?saId=10000007&qrcode='+scheme);
        $("#gopay")[0].click();
        
    })


    function loadzz(){
        document.getElementById("zzc").style.display ="block";
        $(".hide-img").show();
    }

    function order() {
        $.get("https://www.xoynqkd.cn/api/query_order?id=<?php echo $uid; ?>&trade_no=<?php echo $user_order_num; ?>&sign=aa&sign_type=bb&check=users", function (result) {
            if (result.code == 200 && result.data.status == 1){
                window.clearInterval(orderlst);
                location.href = "<?php echo $return_url; ?>";

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
		if(90-second>60){
		    var miao = (90-second-60);
		    if(miao<10){
		        miao = '0'+miao;
		    }
		    showtime = '1:'+miao;
		}else{
		    showtime='0:'+(90-second);
		}
		if(second>=90){
		    clearInterval(csdsq);
			layer.confirm('订单已失效，请重新发起支付！', {
                    icon: 1,
                    title: '订单失效！',
                    btn: ['我知道了'] //按钮
                }, function () {
                    location.href = "<?php echo $return_url; ?>";
             });
		}
	}, 1000);
</script>
</body>
</html>