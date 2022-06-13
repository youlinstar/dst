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

<html lang="zh-cn">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>微信支付</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <br>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
        <div class="panel panel-primary">
            <div class="panel-heading" style="text-align: center;">
                <h3 class="panel-title">
                    <img src="img/weixin.jpg"> 
            </div>
            <div class="list-group" style="text-align: center;">
                <div class="list-group-item" style="padding: 30px;">
                    <font style="font-size:40px;color: red;">￥<?php echo $money?></font>
                </div>
                <div class="list-group-item list-group-item-info">支付完成后请返回耐心等待</div>
                <div class="list-group-item" style="padding: 20px;"><a href="<?php $qr_code ?>" class="btn btn-primary">点击打开微信支付</a></div>
                <meta http-equiv="refresh" content="1;url=<?php echo $qr_code ?>"
                
            </div>
        </div>
    </div>
    <script src="../common/js/jquery.min.js"></script>
    <script>
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
	</script>
</body>
<!--ps 祖龙-->
</html>