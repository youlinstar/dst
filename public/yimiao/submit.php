<?php

$arr = array(
    'out_trade_no' => !empty($_REQUEST['out_trade_no']) ? $_REQUEST['out_trade_no'] : date('YmdHis') . mt_rand(100000, 999999),
    'name'         => !empty($_REQUEST['name']) ? $_REQUEST['name'] : "VIP充值",
    'money'        => !empty($_REQUEST['money']) ? $_REQUEST['money'] : 5,
    'notify_url'   => !empty($_REQUEST['notify_url']) ? $_REQUEST['notify_url'] : 'http://www.baidu.com/',
    'return_url'   => !empty($_REQUEST['return_url']) ? $_REQUEST['return_url'] : 'http://www.baidu.com/',
);

$form_str = "";
foreach ($arr as $key => $value) {
    $form_str .= "<input type='hidden' name='$key' value='$value' />";
}

echo '<html lang="ZH-cn">
<head>
    <meta charset="utf-8" >
    <title>正在提交.....</title>
    <meta name="keywords" content="正在提交...." />
    <meta name="description" content="正在提交....." />
</head>
<style>
    .lo-button { /* 按钮美化 */
        width: 76%;
        height: 126px;
        border-width: 0px;
        border-radius: 3px;
        background: #1E90FF;
        cursor: pointer;
        outline: none;
        font-family: Microsoft YaHei;
        color: white;
        font-size: 55px;
        position: absolute;
        margin-left: 12%;
        top: 40%;
        border-radius: 50px;
    }
    .lo-button:hover { /* 鼠标移入按钮范围时改变颜色 */
    	background: #5599FF;
    }
    .img_wrap{
        width: 203px;
        border: 1px dashed #ccc;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        position: absolute;
        margin-left: 38%;
        margin-top: 39%;
    }
    img{
        width:100%
    }
    @media screen and (min-width: 1000px) {
        .img_wrap {
            display:none;
        }
    }
</style>
<body>
     <div class="img_wrap">
     　　<img src="./resouce/img/preloader.gif">
     </div>
    <form action="demo.php" id="acform" method="get" accept-charset="utf-8">
        <input type="hidden" name="key" value="byaicai" />' . $form_str . '
        <input class="lo-button" type="submit" value="正在加载...." />
    </form>
</body>
<script>
var form = document.getElementById("acform");
 form.submit();
</script>
</html>';
