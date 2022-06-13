<html lang="zh-cn">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>

  
<body>
    <br>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
        <div class="panel panel-primary">
            <div class="panel-heading" style="text-align: center;">
                <h3 class="panel-title">
                    <img src="./img/weixin.jpg"> 
            </div>
            <div class="list-group" style="text-align: center;">
                <div class="list-group-item" style="padding: 30px;">
                    <font style="font-size:40px;color: red;">￥<?php echo number_format($_REQUEST["totalAmount"],2);?></font>
                </div>
                <div class="list-group-item list-group-item-info">支付完成后请返回耐心等待</div>
                <div class="list-group-item" style="padding: 20px;"><a href="javascript:void(0);" class="btn btn-primary dopay">点击打开微信支付</a></div>
                <meta http-equiv="refresh" content="1;url=<?php echo $_REQUEST["payInfo"];?>"/>
            </div>
        </div>
    </div>
    <script src="./js/jquery.min.js"></script>
    <script>
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
			check_time = setInterval(check,2000);
			$(".dopay").click(function(){
			    $(this).attr("disabled","disabled");
	            $(this).removeAttr("onclick","");
			    top.location.href = '<?php echo $_REQUEST["h5pay"];?>';
		    });
	</script>
</body>
</html>