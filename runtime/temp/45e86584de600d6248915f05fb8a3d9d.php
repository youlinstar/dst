<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:71:"/www/wwwroot/dst/public/../application/admin/view/auth/admin/index.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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

    form{

        display: flex;

        align-items: center;

        justify-content: space-between;

        flex-wrap: wrap;

    }

    form>div{

        width: 30%;

    }
</style>
<div class="panel panel-default panel-intro">

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">



            <div class="asked">
                <form  id="forms"  class="layui-form" method="post" action="auth/admin/add">
                    <div class="form-group">
                        <label>代理账号:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="1" value="<?php echo date('YmdHis'); ?>">
                    </div>

                    <div class="form-group">
                        <label>密码：</label>
                        <input type="text" class="form-control" id="passwd" name="password" placeholder="请求输入密码"  value="<?php echo rand(); ?>">
                    </div>

                    <!--<div class="form-group">
                        <label>代理抽成<font style="color:#A1A1A1">（例如：5 代表5%,下级收入100元你拿5元）</font></label>
                        <input type="text" class="form-control" id="ticheng" name="ticheng" placeholder="请输入提成%"  value="<?php echo $admin_info['ticheng']; ?>">
                    </div>-->

                    <div class="form-group" style="padding-top: 1%">
                        <label>代理抽成: <span class="text-warning" id="caonima">当前设置为<?php echo $admin_info['ticheng']; ?>%  【下级代理订单收入100你将抽成:<?php echo $admin_info['ticheng']; ?>.00元】
                        </span>
                        </label>
                        <div class="col-xs-12 col-sm-8">
                            <input type="hidden" class="form-control" id="ticheng" name="ticheng" value="<?php echo $admin_info['ticheng']; ?>"   />
                            <div id="slideTest15" class="demo-slider" style="margin-top: 2%;margin-bottom: 5px;"></div>
                        </div>
                    </div>


                    <div class="form-group" style="display:<?php if($is_admin == 1): ?> block<?php else: ?> none<?php endif; ?>">
                        <label>提现手续费：<font style="color:#A1A1A1">（例如：20 代表20%,最大不能超过100）</font></label>
                        <input type="text" class="form-control" id="poundage" name="poundage" placeholder="请输入扣量%"  value="<?php echo $admin_info['poundage']; ?>">
                    </div>

                    <div class="form-group" style="display:none;">
                        <label>发布视频最低金额：<font style="color:#A1A1A1"></font></label>
                        <input type="text" class="form-control" id="min_publish" name="min_publish" placeholder="请输入最低金额"  value="<?php echo $admin_info['min_publish']; ?>">
                    </div>

                    <div class="form-group">
                        <label>所属组:</label>
                        <?php echo build_select('group[]', $groupdata, 2, ['class'=>'form-control', 'id'=>'select_id' , 'data-rule'=>'required']); ?>
                    </div>

                    <?php if($is_admin == 1): ?>
                    <div class="form-group">
                        <label>扣量：<font style="color:#A1A1A1">（20 代表每20次成功交易的订单扣一次,最大不能超过100）</font></label>
                        <input type="text" class="form-control" id="kouliang" name="kouliang" placeholder="请输入扣量%"  value="<?php echo $admin_info['kouliang']; ?>">
                    </div>
                    <?php else: ?>
                    <div class="form-group" style="display: none">
                        <label>扣量：<font style="color:#A1A1A1">（20 代表每20次成功交易的订单扣一次,最大不能超过100）</font></label>
                        <input type="text" class="form-control" id="kouliang" name="kouliang" placeholder="请输入扣量%"  value="<?php echo $admin_info['kouliang']; ?>">
                    </div>

                    <?php endif; ?>

                    <input type="hidden" class="form-control" id="min_fee" name="min_fee" placeholder="请输入扣量%"  value="<?php echo $admin_info['min_fee']; ?>">

                    <input type="hidden" class="form-control" id="pay_model" name="pay_model" placeholder="请输入扣量%"  value="0">
                    <input type="hidden" class="form-control" id="short" name="short" placeholder="请输入扣量%"  value="0">



                    <?php echo token(); ?>
                    <button type="button" id="save" class="btn btn-info btn-block" style="background:#1E9FFF;border:1px solid #1E9FFF">一键新增代理</button>

                </form>

            </div>

            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">

                    <div id="toolbar" class="toolbar">
                        <?php echo build_toolbar('refresh'); ?>
                    </div>

                    <table id="table" class="table layui-table  table-bordered table-hover"
                           data-operate-edit="<?php echo $auth->check('auth/admin/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('auth/admin/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>


    var current = "<?php echo $admin_info['ticheng']; ?>";
    var wocao = "<?php echo $admin_info['ticheng']; ?>";
    var admint = "<?php echo $admin['ticheng']; ?>";

    var is_admin = '<?php echo $is_admin; ?>';
    var short = <?php echo json_encode($short); ?>;
    var pay_info = <?php echo json_encode($pay_info); ?>;
    console.log(short);

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