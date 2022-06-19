<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:64:"/www/wwwroot/dst/public/../application/admin/view/link/play.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
                                <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no,minimal-ui">
    <meta name="referrer" content="no-referrer">
    <title>播放器</title>
    <style type="text/css">
        html, body {width:100%;height:100%;margin:auto;overflow: hidden;}
        body {display:flex;}
        #mse {flex:auto;}
        #ribbon{
            display: none;
        }
        .content {
            min-height: 250px;
            padding: 0px;
            margin-right: auto;
            margin-left: auto;
            padding-left: 0px;
            padding-right: 0px;
        }
    </style>
    <script type="text/javascript">
        window.addEventListener('resize',function(){document.getElementById('mse').style.height=window.innerHeight+'px';});
    </script>
</head>
<body>
<div id="mse"></div>
<script src="//cdn.jsdelivr.net/npm/xgplayer@2.9.6/browser/index.js" charset="utf-8"></script>
<script src="//cdn.jsdelivr.net/npm/xgplayer-mp4@1.1.8/browser/index.js" charset="utf-8"></script>
<script src="//cdn.jsdelivr.net/npm/xgplayer-flv/dist/index.min.js" charset="utf-8"></script>
<script src="//cdn.jsdelivr.net/npm/xgplayer-hls/dist/index.min.js" charset="utf-8"></script>
<script type="text/javascript">
    let player=new Player({
        id: 'mse',
        autoplay: true,
        volume: 0.3,
        url:'<?php echo $video_url; ?>',
        //poster: "//s2.pstatp.com/cdn/expire-1-M/byted-player-videos/1.0.0/poster.jpg",
        playsinline: true,
        height: window.innerHeight,
        width: window.innerWidth,
        whitelist: ['']
    });
    player.emit('resourceReady', [{ name: '超清', url: '/video/mp4/xgplayer-demo-720p.mp4' }, { name: '高清', url: '/video/mp4/xgplayer-demo-480p.mp4' }, { name: '标清', url: '/video/mp4/xgplayer-demo-360p.mp4' }]);
</script>
</body>
</html>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require.js" data-main="/assets/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>