<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:66:"/www/wwwroot/dst/public/../application/admin/view/stock/index.html";i:1655645264;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
</style>

<style>
    .no-margins{
        font-size: 31px;
        text-align: center;
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
        <div class="layui-card shortUrl">
            <a class="layui-card-body btn-Method add_btn_piliang" data-type="shortUrl" style="text-align: center;display:block; -moz-box-shadow: 1px 1px 5px #888888; /* 老的 Firefox */
        box-shadow: 1px 1px 5px #888888; overflow: hidden; height: 100px;  ">
                <img src="/assets/img/ico/piliangs.png" class="link-img">
                <span class="link-text">批量添加资源</span>
            </a>
        </div>
    </div>


    <div class="layui-col-sm4 layui-col-xs12">
        <div class="layui-card tgqrcode">
            <a class="layui-card-body btn-Method getCheckData1" data-all="all" data-type="tgqrcode" style="display:block;text-align: center;ursor:pointer; -moz-box-shadow: 1px 1px 5px #888888; /* 老的 Firefox */
        box-shadow: 1px 1px 5px #888888; overflow: hidden; height: 100px;">
                <img src="/assets/img/ico/yijian.png" class="link-img">
                <span class="link-text">一键发布视频</span>
            </a>
        </div>
    </div>


    <div class="layui-col-sm4 layui-col-xs12">
        <div class="layui-card muban">
            <a class="layui-card-body btn-Method del-all" data-type="muban" style="display:block;text-align: center; -moz-box-shadow: 1px 1px 5px #888888; /* 老的 Firefox */
        box-shadow: 1px 1px 5px #888888; overflow: hidden; height: 100px;">
                <img src="/assets/img/ico/dels.png" class="link-img">
                <span class="link-text">全部删除</span>
            </a>
        </div>
    </div>

</div>

<div class="panel panel-default panel-intro">
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" class="btn btn-warning btn-push" title="批量推广" > 批量推广</a>
                        <a href="javascript:;" class="btn btn-warning getCheckData1 " title="批量发布随机金额" > 批量发布随机金额</a>
                      
                        <a href="javascript:;" class="btn btn-success btn-add <?php echo $auth->check('stock/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>

                        <!--<a href="javascript:;" class="btn btn-warning uploadVideo" title="上传视频" > 上传视频</a>
                        <a href="javascript:;" class="btn btn-warning uploadVideoUrl" title="上传链接视频" > 上传链接视频</a>-->

                    </div>
                    <table id="table" class="table layui-table  table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('stock/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('stock/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="myPublic" tabindex="1" role="dialog" aria-labelledby="myPublicLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">发布视频</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" class="form-control" id="recipient-id">
                <div class="form-group">
                    <div class="layui-inline">

                        <div class="layui-input-block">
                            <div style=" margin: 10px 0; ">打赏金额</div>
                            <input type="number"  name="ds_money"  class="layui-input" value="<?php echo htmlentities($admin['min_publish']); ?>" min="<?php echo htmlentities($admin['min_publish']); ?>">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-block">
                            <div style="  margin: 10px 0;">链接有效天数</div>
                            <input type="tel"  name="effect_time"  class="layui-input" value="10" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" data-dismiss="modal" title="取消">取消</a>
                        <a class="layui-btn layui-btn-sm layui-btn-normal batch-add-post" title="确定">确定</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--随机金额-->
<div class="modal fade" id="myPublic1" tabindex="1" role="dialog" aria-labelledby="myPublicLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel1">发布视频</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" class="form-control" id="recipient-id1">
                <div class="form-group">
                    <div class="layui-inline">

                        <div class="layui-input-block">
                            <div style=" margin: 10px 0; ">随机金额</div>
                            <input type="number"  name="ds_money2"  class="layui-input" value="<?php echo htmlentities($admin['min_publish']); ?>" min="<?php echo htmlentities($admin['min_publish']); ?>">
                            到
                            <input type="tel"  name="ds_money1"  class="layui-input" value="10" >
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-block">
                            <div style="  margin: 10px 0;">链接有效天数</div>
                            <input type="tel"  name="effect_time"  class="layui-input" value="10" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" data-dismiss="modal" title="取消">取消</a>
                        <a class="layui-btn layui-btn-sm layui-btn-normal batch-add-post batch-add-post1" title="确定">确定</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require.js" data-main="/assets/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>