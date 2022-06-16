<?php 
date_default_timezone_set('PRC'); 
header("Content-type: text/html; charset=utf-8");


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
         
		<title>充值服务</title>

		<!--<link href="__STATIC__/css/wechat_pay.css" rel="stylesheet" media="screen">-->
		<link href="css/wechat_pay.css" rel="stylesheet" media="screen">
		<script src="js/jquery-1.10.2.min.js"></script>
		<!--<script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		<script src="js/layer.js"></script>
		<!--<script src="https://cdn.bootcdn.net/ajax/libs/layer/3.1.1/layer.js"></script>-->
		<!--<script src="__STATIC__/js/jquery.mobile-1.3.2.min.js"></script>
		<meta name="__hash__" content="35cc57167e6029e5d986317b0740fab4_d33d967ce6e5607099d02e0985f82db2" />-->
		
        
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

				<!--<span class="ico_log ico-3"></span>-->
				<span class="fleft">收款方</span>
				<span class="rleft">充值服务</span>
			</h1>



			<div class="mod-ct">

				<div class="order">

				</div>

				<!--<div class="amount" id="money">￥{$arge.amt}</div>-->
				<div class="tipa" style="color:#2eb228;font-size:18px"><b>识别二维码后,请耐心几秒！</b></div>


				<div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">

					<div data-role="qrPayImg" class="qrcode-img-area">

						<!-- <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>-->

						<div class="qrcode" style="position: relative;display: inline-block;">
                     	<img id="show_qrcode" alt="加载中..." src="http://api.k780.com:88/?app=qr.get&data=<?php echo $_GET['wxurl']   ?>" width="250" height="250" style="display: block;padding-bottom: 10px;text-align:center;"><!--二维码接口-->
							

						</div>

					</div>





				</div>





				<div class="tip">

					<!--<div class="ico-scan"></div>-->

					<div class="tip-text" style="color:#12b116;text-align:center;">

						<p style="font-size: 18px;"><b>按住二维码识别付款！</b></p>

						<p style="font-size: 18px;"><b>付款后如不跳转，请耐心等待</b></p>

					

					</div>

				</div>



			


				<div class="tip-text">

				</div>





			</div>

			<div class="foot">

				<div class="inner">

					<!--<div><img src="__STATIC__/img/123.png" width="150px"></div>-->
					<div><img src="img/123.png" width="150px"></div>
					<p><b>支付安全由中国人民财产保险股份有限公司承保</b></p>

					<!--<p>在微信扫一扫中选择“相册”即可</p>-->

				</div>

			</div>



		</div>

		<div class="copyRight">



		</div>

		<!--注意下面加载顺序 顺序错乱会影响业务-->



	
		<script src="js/notify.js"></script>
		<script src="js/jquery.min.js"></script>
	
		
       <script>
       
         function query_pay()
                {
                    $.ajax({
                		type : "post",
                		url : "<?php echo $_GET['path'] ?>",
                		dataType: "json",  
                		async:true,
                		 data: {serial_no:'<?php echo $_GET['serial_no'] ?>',sign:'<?php echo $_GET['sign'] ?>',qtype:'<?php echo $_GET['qtype'] ?>'},
                		timeout : 10000 ,
                		success : function(data){
                			if(data.code == 1 || data.code == 4){ 
                                setTimeout(function(){
                                   window.location.href = '<?php echo $_GET['return'] ?>';
                			    },2000);//延迟两秒跳转  这里延迟两秒保证异步已经通知
                			}
                		}
                		
                	});
                }
                for (var i=0;i<180;i++)
                { 
                    setTimeout("query_pay()",3000*(i+1));//延迟3秒
                }
    </script>
	</body>
<!--ps 奶罩  东辰支付--> 
</html>
