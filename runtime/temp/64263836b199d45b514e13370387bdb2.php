<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"/www/wwwroot/dst/public/../application/admin/view/cash/add.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
                                <form id="add-form" class="form-horizontal   " role="form" data-toggle="validator" method="POST" action="">


    <input id="c-uid" class="form-control" name="row[uid]" type="hidden" value="<?php echo $admin['id']; ?>">



    <input id="c-pid"  class="form-control" name="row[pid]" value="<?php echo $admin['pid_top']; ?>" type="hidden">

    <input   class="form-control" name="row[fee]" value="<?php echo $poundage; ?>" type="hidden">

    <input   class="form-control" name="row[account]" id="account" value="" type="hidden">



    <?php echo token(); ?>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">金额:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-account"   data-rule="required" class="aaa form-control" name="row[blance]" type="number" value="">
            <span class="text-warning" style="font-size: 15px;font-weight: 500">最低提现金额为<span class="text-danger"><?php echo $user['min_fee']; ?>元 </span>可提现金额为 <span class="text-danger"><?php echo $balance; ?>元</span> 提现费率 [:<span class="text-danger"><?php echo $poundage; ?>%</span>] 手续费为:<span class="text-danger" id="shouxufei">0元</span></span>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-image" class="form-control" size="50" name="row[image]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-image"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remark'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-remark" data-rule="required" class="form-control" name="row[remark]" type="text" value="">
        </div>
    </div>
   <!-- <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Code_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-code_id" data-rule="required" data-source="code/index" class="form-control selectpage" name="row[code_id]" type="text" value="">
        </div>
    </div>-->
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-type" data-rule="required" class="form-control " name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"1"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

<script>

var min_fee = "<?php echo $user['min_fee']; ?>";
var balances = "<?php echo $balance; ?>";
console.log("可提现金额为:"+balances);
console.log("最低为:"+min_fee);
var poundages = "<?php echo $poundage; ?>";
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