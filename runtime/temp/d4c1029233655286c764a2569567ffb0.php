<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/www/wwwroot/dst/public/../application/admin/view/hezi/infor_list.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                               <!-- <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>-->
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <font size="5">盒子试看链接已生成</font><br><br><font size="3">[ 微信红包 ] 恭喜发财 大吉大利 今日推荐视频</font><br><font size="2">---顶部免费试看请用手机浏览---</font><br>    <div class="content-main">    </div>    <script type="text/javascript" src="/assets/libs/layui/layui.all.js"></script>    <br><font size="2">---打赏后如无跳转视频, 重新从链接进入点击已购即可观看---</font><script>    var push_url = "<?php echo $_GET['url']; ?>";    console.log(push_url);    layui.use(['jquery','form'], function(){        var form = layui.form            ,$=layui.jquery;        $(document).ready(function(){            $.ajax({                url: "index",                type : "POST",                dataType:'json',                data:{                    // video_msg:$("#video_msg").val(),                    // cid:$("#selects").find("option:selected").val()                },                cache: false,                async:false,                success: function (data) {                    console.log(data);                   var total = data.total;                   var datas = data.rows;                   if(total>=0){                       var information = '';                        for(var i=0;i<total;i++)                        {                            information += datas[i]['title']+'<br>';                            var id=datas[i]['id'];                            var url = push_url+"&hezi="+id;                            $.ajax({                                url:"../short/shortUrl",                                type:'POST',                                dataType:'json',                                data:{                                    url:url,                                    id:id                                },                                cache: false,                                async:false,                                success:function(res){                                    if(res.code == 0){                                        information += res.data+'<br>';                                    }                                },                                error:function(){                                    layer.msg('系统500错误,请联系管理员');                                }                            })                        }                        $('.content-main').html(information);                   }else{                       layer.msg('无数据!');                   }                }            });        });    }); </script></block>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require.js" data-main="/assets/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>