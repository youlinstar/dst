<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"/www/wwwroot/dst/public/../application/admin/view/hezi/index.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
    .content{
        margin:10px
    }
    .fa fa-wechat{
        background-color: red;
    }
    .content{
        margin:10px
    }
    .link-img{
        width:45px;
        height:45px;
        color:#5a8bff;
        border-radius: 10px;
        margin-top: 5%;
    }
    .link-text{
        color: #2d2424;
        position: relative;
        top: 13%;
        font-size: 15px;
    }
</style>

<div class="layui-row layui-col-space10" style="margin-bottom: 10px">
    <div class="layui-col-sm4 layui-col-xs12">
        <div class=" layui-card muban " onclick="add();">
            <a href="javascript:;" class="layui-card-body btn-Method btn-add <?php echo $auth->check('hezi/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" style="display:block;text-align: center; -moz-box-shadow: 1px 1px 5px #888888; /* 老的 Firefox */
        box-shadow: 1px 1px 5px #888888; overflow: hidden; height: 100px;">
                <img src="/assets/img/ico/hztj.png" class="link-img">
                <span class="link-text">添加盒子试看</span>
            </a>
        </div>
    </div>



    <div class="layui-col-sm4 layui-col-xs12">
        <div class="layui-card tgqrcode" onclick="inforList()">
            <a class="layui-card-body btn-Method getCheckData1" data-all="all" data-type="tgqrcode" style="display:block;text-align: center;ursor:pointer; -moz-box-shadow: 1px 1px 5px #888888; /* 老的 Firefox */
        box-shadow: 1px 1px 5px #888888; overflow: hidden; height: 100px;">
                <img src="/assets/img/ico/hqsj.png" class="link-img">
                <span class="link-text">获取全部盒子链接</span>
            </a>
        </div>
    </div>


    <div class="layui-col-sm4 layui-col-xs12">
        <div class="layui-card muban" onclick="Refresh();">
            <a class="layui-card-body btn-Method del-all" data-type="muban" style="display:block;text-align: center; -moz-box-shadow: 1px 1px 5px #888888; /* 老的 Firefox */
        box-shadow: 1px 1px 5px #888888; overflow: hidden; height: 100px;">
                <img src="/assets/img/ico/sx.png" class="link-img">
                <span class="link-text">刷新页面</span>
            </a>
        </div>
    </div>


</div>
<div class="panel panel-default panel-intro">

    <!--<div class="panel-heading">
        <?php echo build_heading(null,FALSE); ?>
        <ul class="nav nav-tabs" data-field="status">
            <li class="active"><a href="#t-all" data-value="" data-toggle="tab"><?php echo __('All'); ?></a></li>
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <li><a href="#t-<?php echo $key; ?>" data-value="<?php echo $key; ?>" data-toggle="tab"><?php echo $vo; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>-->


    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;"  id="Refresh" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" style="display: none" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" id="add" class="btn btn-success btn-add <?php echo $auth->check('hezi/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" style="display: none" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>
                    </div>
                    <table id="table" class="table  table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('hezi/edit'); ?>"
                           data-operate-del="<?php echo $auth->check('hezi/del'); ?>"
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var push_url = "<?php echo $url; ?>";
    console.log(push_url);
    function add() {
        document.getElementById("add").click();
    }
    function Refresh() {
        document.getElementById("Refresh").click();
    }
    function inforList() {
        layer.open({
            type: 2,
            area: ['700px', '450px'],
            fixed: false, //不固定
            maxmin: true,
            title:'全部盒子连接',
            content: 'Hezi/inforList.html?url='+push_url,
        });
    }
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