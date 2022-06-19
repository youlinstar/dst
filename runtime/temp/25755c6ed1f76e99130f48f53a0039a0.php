<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/www/wwwroot/dst/public/../application/admin/view/auth/admin/edit.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
    .layui-slider-tips {
        white-space: nowrap;
        top: -42px;
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%);
        color: #FFF;
        background: #1E9FFF;
        border-radius: 3px;
        height: 25px;
        line-height: 25px;
        padding: 0 10px;
    }
</style>
<form id="edit-form" class="form-horizontal layui-form form-ajax" role="form" data-toggle="validator" method="POST" action="">
    <?php echo token(); ?>

    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2"><?php echo __('Username'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="username" name="row[username]" value="<?php echo htmlentities($row['username']); ?>" data-rule="required" />
        </div>
    </div>

    <div class="form-group">
        <label for="nickname" class="control-label col-xs-12 col-sm-2"><?php echo __('Nickname'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="nickname" name="row[nickname]" autocomplete="off" value="<?php echo htmlentities($row['nickname']); ?>" data-rule="required" />
        </div>
    </div>


    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2"><?php echo __('ticheng'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="hidden" class="form-control" id="ticheng" name="row[ticheng]" value="<?php echo htmlentities($row['ticheng']); ?>" data-rule="required" />
            <div id="slideTest15" class="demo-slider" style="margin-top: 2%;margin-bottom: 5px;"></div>
<!--
            <p class="text-warning" id="caonima">（当前设置百分比：<?php echo htmlentities($row['ticheng']); ?>%,下级代理收入100你将抽成:<?php echo htmlentities($row['ticheng']); ?>元）</p>
-->
            <p class="text-warning" id="caonima">进度条停留百分比<?php echo htmlentities($row['ticheng']); ?>% --上级抽成百分比<?php echo $admin['ticheng']; ?>%= 你的<?php echo htmlentities($row['ticheng']); ?>百分比, 下级代理收入100你将抽成:<?php echo htmlentities($row['ticheng']); ?>.00元</p>


        </div>
    </div>

    <?php if($is_admin):?>
    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2">提现手续费:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="poundage" name="row[poundage]" value="<?php echo htmlentities($row['poundage']); ?>" data-rule="required" />
            <p class="text-warning">（例如：20 代表20%,最大不能超过100）</p>
        </div>
    </div>
    <?php endif;?>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Group'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_select('group[]', $groupdata, $groupids, ['class'=>'form-control', 'multiple'=>'', 'data-rule'=>'required']); ?>
        </div>
    </div>

    <?php if($is_admin):?>

    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2"><?php echo __('kouliang'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="kouliang" name="row[kouliang]" value="<?php echo htmlentities($row['kouliang']); ?>" data-rule="required" />
            <p class="text-warning">（例如：20 代表每20次成功交易的订单扣一次,最大不能超过100）</p>
        </div>
    </div>
    <?php endif;?>


    <div class="form-group">
        <label for="password" class="control-label col-xs-12 col-sm-2"><?php echo __('Password'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="password" class="form-control" placeholder="留空则不修改" id="password" name="row[password]" autocomplete="new-password" value="" data-rule="password" />
        </div>
    </div>

    <?php if($is_admin):?>
    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2"><?php echo __('wx_check_api'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" class="form-control" id="wx_check_api" name="row[wx_check_api]" value="<?php echo htmlentities($row['wx_check_api']); ?>" data-rule="" />
            <p class="text-warning">（设置该代理的独立入口）</p>
        </div>
    </div>

    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2">支付渠道:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_select('row[pay_model]', $pay, $admin['pay_model'], ['class'=>'form-control', 'required'=>'required']); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="username" class="control-label col-xs-12 col-sm-2">短链接:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_select('row[short]', $short, $admin['short'], ['class'=>'form-control', 'required'=>'']); ?>
        </div>
    </div>
    <?php endif;?>



    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')], $row['status']); ?>
        </div>
    </div>
    <div class="form-group hidden layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<script>
    var current = "<?php echo htmlentities($row['ticheng']); ?>";
    var wocao = "<?php echo htmlentities($row['ticheng']); ?>";
    var admint = "<?php echo $admin['ticheng']; ?>";
    console.log(wocao);
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