<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:66:"/www/wwwroot/dst/public/../application/admin/view/link/trysee.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
                                
<style>
    #ribbon{
        display: none;
    }
</style>


    <div class="content-main">

        <div class="layui-fluid">

            <div class="layui-card">

                <div class="layui-card-header">

                    (单位：秒)

                </div>

                <div class="layui-card-body">

                    <form class="layui-form">

                        <div class="layui-form-item">

                            <input type="text"  id="try_see" name="try_see" autocomplete="off" placeholder="请输入试看时间【秒】" class="layui-input" value="<?php echo rand(3,10); ?>">
                        </div>
                        <button type="button" class="layui-btn layui-btn-sm" lay-submit="" lay-filter="sub">修改</button>


                    </form>

                </div>

            </div>

        </div>

    </div>





<script type="text/javascript" src="/assets/libs/layui/layui.all.js"></script>
<script defer type="text/javascript">

    var forms = layui.form,$=layui.jquery;

    console.log($);
    $(document).ready(function(){

        $(".layui-btn").click(function(){
            $.ajax({
                url: "",
                type : "POST",
                dataType:'json',
                data:{

                    try_see:$("#try_see").val(),
                },
                cache: false,
                async:false,
                success: function (data) {
                    if (data.code == 0) {

                        layer.msg(data.msg,{time:1500},function(){

                            parent.layer.closeAll();

                            window.parent.location.reload();
                        });

                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        });


        // layer.alert(JSON.stringify(data.field), {

        //     title: '最终的提交信息'

        // });

        return false;
    });

</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require.js" data-main="/assets/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>