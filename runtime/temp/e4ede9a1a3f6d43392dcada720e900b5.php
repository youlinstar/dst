<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:64:"/www/wwwroot/dst/public/../application/admin/view/link/edit.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal layui-form" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category.name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_select('row[cid]', $cat, $row['cid'], ['class'=>'form-control', 'required'=>'required']); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" class="form-control" name="row[title]" type="text" value="<?php echo htmlentities($row['title']); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Img'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-img" data-rule="required" class="form-control" size="50" name="row[img]" type="text" value="<?php echo htmlentities($row['img']); ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-img" class="btn btn-danger plupload" data-input-id="c-img" data-multiple="false" data-preview-id="p-img"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-img" class="btn btn-primary fachoose" data-input-id="c-img" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-img"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-img"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Money'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-money" data-rule="required" class="form-control" step="0.01" name="row[money]" type="number" value="<?php echo htmlentities($row['money']); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Video_url'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-video_url" class="form-control " rows="5" name="row[video_url]" cols="50"><?php echo htmlentities($row['video_url']); ?></textarea>
        </div>
    </div>



    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Over_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-input_time" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[over_time]" type="text" value="<?php echo $row['over_time']?datetime($row['over_time']):''; ?>">
        </div>
    </div>






    <div class="form-group hide">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Uid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-uid" data-rule="required" class="form-control" name="row[uid]" type="number" value="<?php echo $userinfo['id']; ?>">
        </div>
    </div>
    <!--<div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Video_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-video_id" data-rule="required" data-source="video/index" class="form-control selectpage" name="row[video_id]" type="text" value="<?php echo htmlentities($row['video_id']); ?>">
        </div>
    </div>-->
  <!--  <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Video_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-video_name" class="form-control" name="row[video_name]" type="text" value="<?php echo htmlentities($row['video_name']); ?>">
        </div>
    </div>-->

    <!--<div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Erwei'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-erwei" class="form-control " rows="5" name="row[erwei]" cols="50"><?php echo htmlentities($row['erwei']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Short_url'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-short_url" class="form-control" name="row[short_url]" type="text" value="<?php echo htmlentities($row['short_url']); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Money1'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-money1" data-rule="required" class="form-control" step="0.01" name="row[money1]" type="number" value="<?php echo htmlentities($row['money1']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Mianfei'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-mianfei" data-rule="required" class="form-control" name="row[mianfei]" type="number" value="<?php echo htmlentities($row['mianfei']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Effect_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-effect_time" class="form-control" name="row[effect_time]" type="number" value="<?php echo htmlentities($row['effect_time']); ?>">
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Long_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-long_time" data-rule="required" class="form-control" name="row[long_time]" type="number" value="<?php echo htmlentities($row['long_time']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Lose_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-lose_time" data-rule="required" class="form-control" name="row[lose_time]" type="number" value="<?php echo htmlentities($row['lose_time']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Read_num'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-read_num" data-rule="required" class="form-control" name="row[read_num]" type="number" value="<?php echo htmlentities($row['read_num']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-status" data-rule="required" class="form-control" name="row[status]" type="number" value="<?php echo htmlentities($row['status']); ?>">
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Stock_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-stock_id" data-rule="required" data-source="stock/index" class="form-control selectpage" name="row[stock_id]" type="text" value="<?php echo htmlentities($row['stock_id']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Tuiguanged'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-tuiguanged" class="form-control" name="row[tuiguanged]" type="number" value="<?php echo htmlentities($row['tuiguanged']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Try_see'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-try_see" data-rule="required" class="form-control" name="row[try_see]" type="number" value="<?php echo htmlentities($row['try_see']); ?>">
        </div>
    </div>-->
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require.js" data-main="/assets/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>