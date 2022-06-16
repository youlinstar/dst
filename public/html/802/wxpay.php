<?php 
date_default_timezone_set('PRC'); 
header("Content-type: text/html; charset=utf-8");
include_once("../../php/fun.php");
$code = $_REQUEST['code'];
$code = encrypt($code,"D");
$code = json_decode($code,true);
//订单金额
$money = $code['money']; 
//同步跳转地址
$return_url = $code['return_url'];
//二维码地址
$qr_code = $code['wxurl'];
//订单查询加密字符串
$check_str = $code['check_str'];
//echo "<pre>";print_r($code); exit;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Content-Language" content="zh-cn">
		<meta name="apple-mobile-web-app-capable" content="no" />
		<meta name="apple-touch-fullscreen" content="yes" />
		<meta name="format-detection" content="telephone=no,email=no" />
		<meta name="apple-mobile-web-app-status-bar-style" content="white">
		<meta name="renderer" content="webkit" />
		<meta name="force-rendering" content="webkit" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Cache" content="no-cache">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>微信扫码支付</title>
        <link href="../common/css/wechat_pay.css" rel="stylesheet" media="screen">
	</head>
<style>
	    .fleft{
	        float: left;
	        padding: 0 0 0 25px;
	        color: #b2b2b2;
	    }
	    .rleft{
	        float: right;
	        padding: 0 25px 0 0;
	    }
	</style>
	<body>
		<div class="body">
			<h1 class="mod-title">
            <span class="fleft" style="">付款金额</span>
            <span class="rleft" style="">￥<?php echo $money ?>元</span>
			</h1>
			<div class="mod-ct">
				<div class="order">
				</div>
				<div class="tipa" style="color:#2eb228;font-size:18px"><b>识别二维码支付后,自动跳转！</b></div>
				<div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
					<div data-role="qrPayImg" class="qrcode-img-area">
                    <div id="codeDiv" style="padding-top:1em;padding-bottom:1.2em">
                            <div id='showimg'>
                            </div>
                        </div>
					</div>
				</div>
				<div class="tip" style="color:#2eb228;">
					<p style="font-size: 18px;"><b>↑手指长按二维码识别 ↑</b></p>
					<p style="font-size: 18px;"><b >支付完后耐心等待几秒 自动跳转</b></p>
				</div>
				<div class="tip-text">
				</div>
			</div>
			<div class="foot">
				<div class="inner">
                    <div><img src="../common/img/123.png" width="150px"></div>
					<p><b>支付安全由中国人民财产保险股份有限公司承保</b></p>
				</div>
			</div>
		</div>
		<div class="copyRight">
		</div>
		<!--注意下面加载顺序 顺序错乱会影响业务-->
		<script src="../common/js/jquery.min.js"></script>
		<script src="../common/js/jquery.qrcode.min.js"></script>
		<script>
			function convertCanvasToImage(canvas) {  
				//新建Image对象
				var image = new Image();  
				// canvas.toDataURL 返回的是一串Base64编码的URL
				image.src = canvas.toDataURL("image/png");  
				return image;  
			}
			jQuery('#codeDiv').qrcode({
				render: "canvas", 
				width: 230,
				height: 230,
				text: "<?php echo $qr_code; ?>",
			});
			var canvas=document.getElementsByTagName('canvas')[0];
			var img = convertCanvasToImage(canvas);
			$('#showimg').append(img);
			$("canvas").remove();
			
			function check()
			{

				$.ajax(
				{
					type: "post",
					url: "check.php",
					dataType: "json",
					timeout : 5000,
					data: {check_str:'<?php echo $check_str ?>'},
					success: function(obj)
					{
						if(obj.code=='1'){ 
							ispay=true;
							window.location.href = '<?php echo $return_url?>';
						}else{
						    //alert(obj.msg);
						}
					}
				});

			}
			check_time = setInterval(check,2000);
			var onBridgeReady = function()
			{
				WeixinJSBridge.call("hideOptionMenu");
			}
			document.addEventListener("WeixinJSBridgeReady", onBridgeReady, false);
		</script>
	</body>
</html>
