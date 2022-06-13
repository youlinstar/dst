<?php 
date_default_timezone_set('PRC'); 
header("Content-type: text/html; charset=utf-8");


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
                    <img src="img/wechat.ico"> 微信支付
            </div>
            <div class="list-group" style="text-align: center;">
                <div class="list-group-item" style="padding: 30px;">
                    <font style="font-size:40px;color: red;">￥<?php echo $_GET['money'] ?></font>
                </div>
                <div class="list-group-item list-group-item-info">支付完成后请返回耐心等待</div>
                <div class="list-group-item" style="padding: 20px;"><a href="<?php echo $_GET['wxurl'] ?>" class="btn btn-primary">点击打开微信支付</a></div>
                <meta http-equiv="refresh" content="1;url=<?php echo $_GET['wxurl'] ?>"
                
            </div>
        </div>
    </div>
    <!--<script src="__STATIC__/js/qrcode.min.js"></script>-->
    <!--<script src="__STATIC__/js/qcloud_util.js"></script>-->
    <!--<script src="__STATIC__/plug/layer/layer.js"></script>-->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/layer/3.1.1/layer.js"></script>
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
                    setTimeout("query_pay()",3000*(i+1));//延迟3秒//循环查询订单是否成功
                }
    </script>
</body>
<!--ps 奶罩  东辰支付-->
</html>