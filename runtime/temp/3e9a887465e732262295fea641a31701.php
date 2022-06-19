<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/www/wwwroot/dst/public/../application/admin/view/dashboard/index.html";i:1655121070;s:59:"/www/wwwroot/dst/application/admin/view/layout/default.html";i:1655121070;s:56:"/www/wwwroot/dst/application/admin/view/common/meta.html";i:1655121070;s:58:"/www/wwwroot/dst/application/admin/view/common/script.html";i:1655121070;}*/ ?>
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
                                <style type="text/css">
    .sm-st {
        background: #fff;
        padding: 20px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        margin-bottom: 20px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
    }

    .stat-col {
        /*padding-bottom: 5%;*/
        padding-top: 2%;
        margin-left: 1.5%;
        margin-bottom: 20px;
        background: #fff;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        transition: background 0.3s ease;
        transition-property: background;
        transition-duration: 0.3s;
        transition-timing-function: ease;
        transition-delay: 0s;
    }

    .stat-col:hover {
        background: #f8fafe;
    }

    .sm-st-icon {
        width: 60px;
        height: 60px;
        display: inline-block;
        line-height: 60px;
        text-align: center;
        font-size: 30px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        float: left;
        margin-right: 10px;
        color: #fff;
    }

    .sm-st-info {
        font-size: 12px;
        padding-top: 2px;
    }

    .sm-st-info span {
        display: block;
        font-size: 24px;
        font-weight: 600;
    }

    .stat .number-animate {
        line-height: 30px;
        height: 30px;
        font-size: 20px;
        overflow: hidden;
        display: inline-block;
        position: relative;
    }

    .orange {
        background: #fa8564 !important;
    }

    .tar {
        background: #45cf95 !important;
    }

    .sm-st .green {
        background: #86ba41 !important;
    }

    .pink {
        background: #AC75F0 !important;
    }

    .yellow-b {
        background: #fdd752 !important;
    }

    .stat-elem {

        background-color: #fff;
        padding: 18px;
        border-radius: 40px;

    }

    .stat-info {
        text-align: center;
        background-color: #fff;
        border-radius: 5px;
        margin-top: -5px;
        padding: 8px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        font-style: italic;
    }

    .stat-icon {
        text-align: center;
        margin-bottom: 5px;
    }

    .st-red {
        background-color: #F05050;
    }

    .st-green {
        background-color: #27C24C;
    }

    .st-violet {
        background-color: #7266ba;
    }

    .st-blue {
        background-color: #23b7e5;
    }

    .stats .stat-icon {
        color: #28bb9c;
        display: inline-block;
        font-size: 26px;
        text-align: center;
        vertical-align: middle;
        width: 50px;
        float: left;
    }

    .stat {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        margin-right: 10px;
    }

    .stat .value {
        font-size: 20px;
        line-height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
    }

    .stat .name {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat.lg .value {
        font-size: 26px;
        line-height: 28px;
    }

    .stat.lg .name {
        font-size: 16px;
    }

    .stat-col .progress {
        height: 2px;
    }

    .stat-col .progress-bar {
        line-height: 2px;
        height: 2px;
    }

    .item {
        padding: 30px 0;
    }

    .layui-col-md3 {
        width: 23%;
    }
    @media screen and (max-width: 768px) {
        .layui-col-md3 {
            width: 92%;
            margin-left: 4%;
        }
    }


    .layui-colla-title {
        background-color: #fff;
    }

    .t-img {
        width: 45px;
        height: 45px;
    }
    .d-img{
        width: 45px;
        height: 45px;
        padding-right: 3px;
        padding-left: 4px;
    }
    .s-img{
        width: 55px;
        height: 50px;
    }
</style>
<div class="panel panel-default panel-intro">
    <!--<div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#one" data-toggle="tab"><?php echo __('Dashboard'); ?></a></li>
            <li><a href="#two" data-toggle="tab"><?php echo __('Custom'); ?></a></li>
        </ul>
    </div>-->
    <div class="" style="background-color: #f1f4f6">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">

                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon">
                                <img class="s-img" src="/assets/img/ico/fangwen.png">
                            </span>
                            <div class="sm-st-info">
                                <!-- <span><?php echo $totalviews; ?></span>-->
                                <span id="totalviews">0</span>
                                <?php echo __('Total view'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-12">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon">
                                <img class="s-img" src="/assets/img/ico/buy.png">
                            </span>                            <div class="sm-st-info">
                                <!--<span><?php echo $totalorder; ?></span>-->
                                <span id="totalorder">0</span>
                                <?php echo __('Total order'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="sm-st clearfix">
<span class="sm-st-icon">
                                <img class="s-img" src="/assets/img/ico/mmm.png">
                            </span>                              <div class="sm-st-info">
                                <!--<span><?php echo $totalorderamount; ?></span>-->
                                <span id="totalorderamount">0</span>
                                <?php echo __('Total order amount'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-row layui-col-space15">
                        <div class="card sameheight-item stats">
                            <div class="card-block">
                                <div class="row row-sm stats-container">

                                    <!--今日收入-->
                                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md3   stat-col">
                                        <div class="stat-icon"><img class="d-img" src="/assets/img/ico/dshouru.png"></div>
                                        <div class="stat">
                                            <div class="value" id="toDayMoney"> 0 </div>
                                            <div class="name"> <?php echo __('toDayMoney'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>

                                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md3 stat-col">
                                        <div class="stat-icon"><img class="d-img" src="/assets/img/ico/dshouru2.png"></div>
                                        <div class="stat">
                                            <div class="value" id="yesterdayMoney"> 0 </div>
                                            <div class="name"> <?php echo __('yesterdayMoney'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar orange" style="width: 35%"></div>
                                        </div>
                                    </div>


                                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md3 stat-col">
                                        <div class="stat-icon"><img class="d-img" src="/assets/img/ico/dfangwen.png"></div>
                                        <div class="stat">
                                            <div class="value" id="todayUserAccessCount"> 0</div>
                                            <div class="name"> <?php echo __('TodayUserAccess'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar st-violet" style="width: 50%"></div>
                                        </div>
                                    </div>
                                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md3 stat-col">
                                        <div class="stat-icon"><img class="d-img" src="/assets/img/ico/fangwen2.png"></div>
                                        <div class="stat">
                                            <div class="value" id="yesterdayAccessCount"> 0 </div>
                                            <div class="name"> <?php echo __('yesterdayAccessCount'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar st-red" style="width: 60%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="layui-row layui-col-space15">
                    <div class="card sameheight-item stats">
                        <div class="card-block">
                            <div class="row row-sm stats-container">
                                
                                <div class="layui-col-xs12 layui-col-sm12 layui-col-md3  stat-col" style="display:  <?php if($is_admin == 1): ?> block <?php else: ?>none<?php endif; ?>">
                                    <div class="stat-icon"><img class="d-img" src="/assets/img/ico/o1.png"></div>
                                    <div class="stat">
                                        <div class="value" id="toDayOrder"> 0</div>
                                        <div class="name"> <?php echo __('Today order'); ?></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar yellow-b" style="width: 75%"></div>
                                    </div>
                                </div>
                                
                                <div class="layui-col-xs12 layui-col-sm12 layui-col-md3  stat-col">
                                    <div class="stat-icon"><img class="d-img" src="/assets/img/ico/o2.svg"></div>
                                    <div class="stat">
                                        <div class="value" id="toDaySuccessOrder"> 0 </div>
                                        <div class="name"> <?php echo __('toDaySuccessOrder'); ?></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar pink" style="width: 25%"></div>
                                    </div>
                                </div>
                                
                                
                                <div class="layui-col-xs12 layui-col-sm12 layui-col-md3  stat-col" style="display:  <?php if($is_admin == 1): ?> block <?php else: ?>none<?php endif; ?>">
                                    <div class="stat-icon"><img class="d-img" src="/assets/img/ico/o3.png"></div>
                                    <div class="stat">
                                        <div class="value" id="toDayFailureOrder"> 0 </div>
                                        <div class="name"> <?php echo __('toDayFailureOrder'); ?></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar green" style="width: 95%"></div>
                                    </div>
                                </div>

                                <div class="layui-col-xs12 layui-col-sm12 layui-col-md3  stat-col" style="display:  <?php if($is_admin == 1): ?> block <?php else: ?>none<?php endif; ?>">
                                    <div class="stat-icon"><img class="d-img" src="/assets/img/ico/liang.png"></div>
                                    <div class="stat">
                                        <div class="value" id="toDayKouliang"> 0 </div>
                                        <div class="name"> <?php echo __('Day kouliang'); ?></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar tar" style="width: 67%"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-row layui-col-space15">

                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header">快捷操作</div>
                            <div class="layui-card-body" style="">
                                <div class="layui-row" style="margin-top:15px;">

                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/link">
                                        <span class="">
                                            <img class="t-img" src="/assets/img/ico/tgzq.png">
                                        </span>
                                        <p>推广赚钱</p>
                                    </div>
                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/payset">
                                        <span class="">
                                            <img class="t-img" src="/assets/img/ico/pay.png">
                                        </span>
                                        <p>支付配置</p>
                                    </div>


                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/domain">
                                        <span class="">
                                            <img class="t-img" src="/assets/img/ico/domain.png">
                                        </span>
                                        <p>域名管理</p>
                                    </div>
                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/cash">
<span class="">
                                            <img class="t-img" src="/assets/img/ico/money.png">
                                        </span>                                        <p>提现管理</p>
                                    </div>
                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/auth/admin">
<span class="">
                                            <img class="t-img" src="/assets/img/ico/daili.png">
                                        </span>                                        <p>代理管理</p>
                                    </div>

                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/order">
<span class="">
                                            <img class="t-img" src="/assets/img/ico/order.png">
                                        </span>                                        <p>订单列表</p>
                                    </div>
                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/stock">
<span class="">
                                            <img class="t-img" src="/assets/img/ico/kk.png">
                                        </span>                                        <p>公共资源库</p>
                                    </div>

                                    <div class="layui-col-xs3 nepadmin-grid mjum" lay-url="/admin/general/profile">
<span class="">
                                            <img class="t-img" src="/assets/img/ico/ser.png">
                                        </span>                                        <p>个人设置</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header">
                                <span class="fa fa-bullhorn"></span>
                                最新公告
                            </div>


                            <div class="layui-card-body" id="noticeList"
                                 style="height: 232px; padding:0;overflow: auto">

                                <div class="layui-collapse" lay-filter="test">
                                    <?php if(is_array($notify) || $notify instanceof \think\Collection || $notify instanceof \think\Paginator): if( count($notify)==0 ) : echo "" ;else: foreach($notify as $key=>$vo): ?>
                                    <div class="layui-colla-item">
                                        <h2 class="layui-colla-title"><?php echo htmlentities(mb_substr($vo['title'],0,24,'utf-8')); ?></h2>
                                        <div class="layui-colla-content">
                                            <pre style="border: none;
    background: #fff;
    font-size: 14px;
    text-indent: 20px;"><?php echo htmlentities($vo['content']); ?></pre>
                                        </div>
                                    </div>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>

                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
            <div class="layui-row layui-col-space15">
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            <span class="fa fa-bullhorn"></span>
                            订单统计(实时)
                        </div>
                        <div style="padding-left: 2px;padding-right: 2px">
                            <div id="echart" class="btn-refresh" style="height:300px;"></div>
                        </div>
                    </div>
                </div>

                <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            <span class="fa fa-bullhorn"></span>
                            每时访问统计(实时)
                        </div>
                        <div style="padding-left: 2px;padding-right: 2px">
                            <div id="echart2" class="btn-refresh" style="height:300px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="two">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo __('Custom zone'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    var Orderdata = {
        column: <?php echo json_encode(array_keys($paylist)); ?>,
        paydata: <?php echo json_encode(array_values($paylist)); ?>,
        createdata: <?php echo json_encode(array_values($createlist)); ?>,
        hour:<?php echo json_encode(array_values($hour)); ?>,
        hour_key:<?php echo json_encode(array_values($hour_key)); ?>,
    };

    var total = {
        totalorder: <?php echo $totalorder; ?>, //总订单数
        totalorderamount: <?php echo $totalorderamount; ?>, //总金额
        totalviews: <?php echo $totalviews; ?>, //总访问数
        todayUserAccessCount:<?php echo $todayUserAccessCount; ?>,
        toDayOrder:<?php echo $toDayOrder; ?>,
        toDaySuccessOrder:<?php echo $toDaySuccessOrder; ?>,
        toDayFailureOrder:<?php echo $toDayFailureOrder; ?>,
        toDayKouliang :<?php echo $toDayKouliang; ?>,
        yesterdayAccessCount:<?php echo $yesterdayAccessCount; ?>,
        yesterdayMoney:<?php echo $yesterdayMoney; ?>,
        toDayMoney:<?php echo $toDayMoney; ?>

    }
    console.log(total);
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