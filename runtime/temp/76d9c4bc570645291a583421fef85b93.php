<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"/www/wwwroot/dst/public/../application/index/view/list/muban1.html";i:1655643092;}*/ ?>
<!DOCTYPE html>

<html lang="zh-CN" class="pixel-ratio-1">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>爱你一万年</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <link rel="stylesheet" href="/assets/list/muban1/static/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/list/muban1/static/css/main.css">
    <link rel="stylesheet" href="/assets/list/muban1/static/css/wx.css">
    <script src="/assets/list/muban1/static/lib/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-router@2.0.0/dist/vue-router.js"></script>
    <script src="/assets/list/muban1/static/lib/vant/js/vant.min.js"></script>
    <link rel="stylesheet" href="/assets/list/muban1/static/lib/vant/css/index.css" />
    <script src="/assets/list/muban1/static/js/jquery.min.js"></script>
    <script src="/assets/list/muban1/static/lib/layer/layer.js"></script>
    <link rel="stylesheet" href="/assets/list/muban1/static/lib/el-ui/css/index.css">
    <script src="/assets/list/muban1/static/lib/el-ui/index.js"></script>
    <script src="/assets/list/muban1/static/clipboard/clipboard.min.js" type="text/javascript"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xgplayer@1.1.4/browser/index.js" charset="utf-8"></script>
    <script src=https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js></script>
    <script src=/assets/list/muban1/static/js/gundong.js></script>

</head>

<body>

    <script>
        function onBridgeReady() {
            WeixinJSBridge.call('hideOptionMenu');
        }

        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady();
        }
    </script>

    <style>
        .van-list__finished-text {
            margin-bottom: 10%;
        }

        .likelist li {

            margin-bottom: 10px;

            height: 60px;

            overflow: hidden;

            display: block;

        }

        .likelist li img {

            width: 30%;

            display: block;

            float: left;

            height: 60px;

        }

        .likelist p {

            width: 70%;

            float: left;

            height: 60px;

            line-height: 25px;

            padding: 5px 10px;

            text-overflow: ellipsis;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            overflow: hidden;

            -webkit-box-orient: vertical;

        }

        .liketitle {

            margin-top: 10px;

        }

        #myvideo {
            margin-top: 10px;
        }

        .pay-item {
            display: inline-block;
            width: 46%;
            height: 2rem;
            line-height: 2rem;
            margin-bottom: 4%;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            margin-right: 1rem;
            background: -webkit-linear-gradient(left, rgb(33, 45, 77), rgb(62, 147, 140));
            /*background: -webkit-linear-gradient(left, #8aeda2, #68a0fb)*/
        }

        .pay-item:nth-child(2n) {
            margin-right: 0;
        }

        html,
        body {
            height: 100%;
            font-size: calc(100vw/18.375);
        }

        .licat {
            width: 10px;
        }

        .con {
            width: 100%;
            height: 35px;
            background-color: rgba(0, 0, 0, 0.8);
            position: fixed;
            color: #fff;
            text-align: center;
            border-radius: 10px;
            line-height: 35px;
            z-index: 999;
            display: none;
            font-size: 16px;
        }

        .body .banner {
            border-radius: 0;
            margin: 0;
        }

        .home .header {
            background: -webkit-linear-gradient(left, rgb(33, 45, 77), rgb(62, 147, 140));
            color: #fff;
            padding: 5px;
            position: relative;
            height: 2.5rem;
            margin-top: 0;
        }

        .home {
            padding-top: 0;
        }

        .home .header .search {
            background: -webkit-linear-gradient(left, rgb(30, 50, 72), rgb(30, 50, 72));
            color: rgba(255, 255, 255, 0.814);
            text-align: left;
            padding: 0 5%;
            position: relative;
            height: 1.5rem;
            line-height: 1.5rem;
            margin: 0;
            vertical-align: middle;
            /* display: inline-block; */
            margin-top: .25rem;
            width: 12rem;
        }

        .home .header .search input {
            background: none;
            width: 100%;
            height: 100%;
            line-height: 100%;
            border: none;
            color: #fff;
        }

        .home .header .search::after {
            position: absolute;
            right: .5rem;
            top: 50%;
            transform: translateY(-50%);
            content: '';
            width: .8rem;
            height: .8rem;
            background: url(/assets/img/iconsousuo@2x.png) no-repeat right center;
            background-size: 100% 100%;

        }

        .home .header .collect-btn {
            background: url(/assets/img/iconshipin@2x.png) no-repeat center;
            width: 1rem;
            height: 1.02rem;
            background-size: 100% 100%;
            margin: .5rem auto;
        }

        .home .header .yigou {
                background:url(/assets/img/iconyigou@2x.png) no-repeat top;
                width: 2.3rem;
                height: 2rem;
                background-size: .85rem .9rem;
                /* margin: .5rem auto; */
                margin-left: .23rem;
                line-height: 2.8rem;
                font-size: .5rem;
                 margin-top: 1%; 
        }
        .home .header .yigou img{
            display: block;
            width:100%;
            margin-top:1.2rem;
        }

        .swipe .el-carousel__indicators--horizontal {
            left: auto;
            transform: none;
            right: 10px;
        }
        .swipe .el-carousel__container{
            height: 7rem;
        }
        .swipe .el-carousel__button {
            width: 10px;
            height: 5px;
            border-radius: 5px;
        }

        .swipe .el-carousel__indicator.is-active button {
            background-color: #00cc36;
        }

        .channel {
            padding-top: 10px;
        }

        .body .channel .van-swipe__indicators {
            bottom: 0;
            height:.2rem;
        }

        .body .channel .el-carousel__indicators li {
            width: auto;
            margin: 0;
            height: auto;
            float: none;
            padding: 0;
        }

        .body .channel .van-swipe__indicator {
            width: .65rem;
            margin: 0;
            border-radius: 5px;

        }

        .body .channel .el-carousel__indicators button {
            background-color: #e5e5e5;
            height: 5px;
            border-radius: 5px;
        }

        .body .channel .is-active button {
            background-color: #00cc36;
        }

        .newp {
            margin: 0 .5rem;
            height: .75rem;
            width: 2.5rem;
            background: url(/assets/img/newp.png) no-repeat left center;
            background-size: 100% 100%;
        }

        .list {
            padding: 1%;
        }

        .foot {
            background: #00cd55;
            height: 70px;
            line-height: 70px;
            width: 90%;
            position: fixed;
            bottom: 20px;
            border-radius: 35px;
            box-shadow: 0px 0px 16px rgb(0 0 0 / 30%);
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: space-around;
            color: #fff;
            font-size: 0.30rem;
            z-index: 100;
            display: none;
        }
        .my-swipe{
            height: 3rem;
        }
        .body .channel ul li{width:2.5rem;height:3rem;margin-left:.5rem;position:relative}
        .body .channel ul li img{
            width:1.9rem;
            height:1.5rem;
        }
        .body .channel ul li a{
            display: block;
        }
        .body .channel ul li.active::after{
        	    content: "";
                display: block;
                position: absolute;
                right: .25rem;
                top: 1.95rem;
                width: .25rem;
                height: .25rem;
                background: #00cc36;
                z-index: 20;
                border-radius: 100%;
        }

        .foot-item {
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.10rem;
            font-size: 0.65em;
            width: fit-content
        }
        .list .list-item {height:auto;margin-bottom:.5rem}
        .list .list-item .plays {
            color: #CCCCCC;
            padding-left: 0;
            font-size: .6rem;
            margin: 0;
        }

        .list .list-item .name {
            line-height: 1.5rem;
            font-size: .65rem;
            margin:0;
            background: linear-gradient(45deg, #bd58ef, #af4261);
              background-clip: text;
              -webkit-background-clip: text;
              -moz-background-clip: text;
              -moz-text-fill-color: transparent;
              -webkit-text-fill-color: transparent;
        }

        .tuiguang img {
            width: 20px;
            height: 20px;
            display: block;
        }

        .home .home-thumb {
            position: relative;
        }

        .home .home-thumb .momeny-icon {
                position: absolute;
                right: 0;
                z-index: 10;
                background: -webkit-linear-gradient(left, rgb(33, 45, 77), rgb(62, 147, 140));
                color: #fff;
                /* border-radius: 3px; */
                padding: 1%;
                font-size: .4rem;
                display: block;
                /* box-sizing: content-box; */
                text-align: left;
                width: 100%;
                bottom: 0;
                margin: 0;
                border-bottom-right-radius: 5px;
                border-bottom-left-radius: 5px;
        }
        .home .home-thumb .momeny-icon span{
            float:right;
            font-size: .4rem;
        }

        .WX-window-shade .WX-Window-main {
            background: #08120e;
            width: 90%;
            /* height: 80%; */
            color: #fff;
            max-width: 90%;
        }

        .WX-window-box h2 {
            background: #08120e url(/assets/img/goumai@2x.png) no-repeat left center;
            height: 32px;
            background-size: 74px 32px;
            border: none;
            margin-bottom: 10px;
        }

        .WX-window-box h2 span {
            display: block;
            float: right;
            height: 22px;
            width: 22px;
            background: url(/assets/img/guanbi@2x.png) no-repeat center;
            margin-top: 10px;
            margin-right: 10px;
            background-size: 100% 100%;
        }

        .CopyUrl {
            width: 90%;
            height: 70px;
            margin: auto;
        }

        .CopyUrl span {
            display: block;
            float: left;
            padding: 5px 0px;
        }

        .CopyUrl a {
            display: block;
            padding: 5px 10px;
            color: #13ce66;
            float: right;
        }

        .ds_tankuang {
            height: 10rem;
            width: 100%;
            margin-bottom: 4%;
        }

        .niubi {
            font-size: 1.2em;

        }

        .WX-window-box .WX-Window-body {
            padding: 0;
        }
        .list .list-item .thumb {
            height: 4.2rem;
            position: relative;
        }
        .list .list-item .thumb img{
            box-shadow: 0 0 10px rgb(0 0 0 / 10%);
            border-radius: 5px;
        }
    </style>
    <style>
        .back {
            vertical-align: middle;
            width: 1rem;
            height: 2.2rem;
            background: url(/assets/img/fanhui@2x.png) no-repeat center;
            background-size: .65rem .65rem;
            float: left;
            margin-left: .25rem;
            line-height: 1;
        }

        .payed .header {
            height: 2.2rem;
            text-align: center;
            line-height: 2.2rem;
            padding: 0;
        }

        .payed .header img {
            width: 3rem;
            height: .8rem;
            display: inline-block;
            vertical-align: middle;
        }

        .payed .list .list-item {
            width: 100%;
            display: flex;
            height: auto;
        }

        .payed .list .list-item .thumb {
            width: 6.5rem;
            height: 3.7rem;
            position: relative;
        }

        .payed .list .list-item .thumb img {
            width: 6.5rem;
            height: 3.7rem;
            position: relative;
            background: url(/assets/img/list.png) no-repeat center;
            background-size: 100% 100%;
        }

        .payed .list .list-item .thumb video {
            width: 6.5rem;
            height: 3.7rem;
            position: relative;
        }

        .desc {
            flex: 1;
        }

        .payed .list .list-item .name {
            margin: 0;
            font-size: .75rem;
            margin-left: .25rem;
            height: 2.9rem;
            line-height: 1.2;
            text-overflow: inherit;
            white-space: inherit;
            width: 90%;
            overflow: hidden;
            color: #000;
            text-align: justify;
        }

        .payed .list .list-item .plays {
            font-size: .7rem;
            margin: 0;
            margin-left: .25rem;
            padding-left: 1rem;
            background: url(/assets/img/phone.png) no-repeat 2% 52%;
            background-size: .5rem .6rem;
            color: #878787;
            height: 1rem;
            line-height: 1rem;
        }

        .icon {
            display: block;
            width: 1.8rem;
            height: 1.45rem;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 2;
            background: url(/assets/img/jiaobiao@2x.png) no-repeat center;
            background-size: 100% 100%;
        }
    </style>
    <div id="app">
        <!-- <p class=con></p> -->
        <router-view></router-view>
    </div>
    <script type="text/x-template" id="home-template">
            <div class="box body home" style="display:block;" data-href="0">

                <div class="header">
                    <li class="agency" @click="doFav">
                        <!-- <div class="collect-btn">收藏<i></i></div> -->
                        <div class="collect-btn"></div>
                    </li>
                    <li class="search"><input class="inputKey" v-model="params.key" type="text" @change="sousuoa" @key.enter="sousuoa" placeholder="输入搜索关键词"></li>
                     <li class="request yigou" @click="toYigou"><img src="/assets/img/yigouicon.png" alt=""></li>
                    
                </div>
                <!-- <div class="hezi" v-if="hezi">
                    <div id="mse" style="width: 100%"></div>
                </div> -->
                <div class="banner">
                    <div class="swipe" id="mySwipe">
                        <el-carousel indicator-position="right">
                            <el-carousel-item v-for="src in banner">
                                <img width="100%" height="100%" :src="src.img" @click="linkTo(src.url)">
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                </div>
                <div class="channel">
                    <van-swipe height="84" class="my-swipe" indicator-color="#00cc36">
                        <van-swipe-item v-for="item in category">
                            <ul>
                                <li class="licat"  v-for="cate in item" :class="[activeIndex==cate.id?'active':'',cate.id]">
                                    <a style="color: black" @click="doGetList(cate.id=== '-1'?'cat':cate)">
                                        <img v-if="cate.icon||cate.image" :src="cate.icon||cate.image" width="48" height="48">
                                        <div v-else class="thumb"><img src="/assets/list/muban1/static/images/icon1.png">
                                        </div>
                                        <span>{{ cate.name||cate.title }}</span>
                                    </a>
                                </li>
                                <div style="clear:both;"></div>
                            </ul>
                        </van-swipe-item>
                    </van-swipe>
                </div>
                <p class="newp"></p>
                <div class="list">
                    <div id="list">
                        <van-list v-model="loading" :finished="finished" :finished-text="msg" @load="doGetList" offset="300"
                            direction="down">
                            <div class="van-clearfix">
                                <lazy-component>
                                    <li class="list-item" v-for="item in list" @click="doPay(item)">
                                        <div v-if="item.img" class="thumb home-thumb">
                                            <p class="momeny-icon">{{item.money}}元观看<span>{{ item.rand }}人观看&nbsp;&nbsp;</span>
                                            </p>
                                            <img v-lazy="item.img">
                                        </div>
                                        <p class="name">{{ item.title }}</p>
                                    </li>
                                </lazy-component>
                            </div>
                        </van-list>
                        <div style="clear:both;"></div>
                    </div>
                </div>


            <!--打赏代码-->
            <div id="WX-window-TKEy5SPt5wisSxt-Shade" v-if="dialog.pay.status" class="WX-window-shade">
                <div id="WX-window-TKEy5SPt5wisSxt-box" class="WX-window-box animated fadeInUp">
                    <div class="WX-Window-main">
                        <h2> <span class="close_btn" @click="dialog.pay.status = false, dialog.pay.pay = []"></span></h2>
                        <div class="WX-Window-body">
                            <div class="ds_tankuang">
                                <img :src="ds_img" style="width:100%;height:100%">
                            </div>
                            <div style="padding:2%">
                                <span class="niubi">{{ ds_title }}</span>
                                <p style="line-height:25px;margin:10px auto;">
                                    若购买后无法观看，请到已购观看。<br>
                                </p>
                                <ul>
                                    <li v-for="(item, index) in dialog.pay.pay" class="pay-item" @click="linkTo(item.url)">
                                        <a style="">
                                            <!-- <img height="32px" style="display: inline-block; vertical-align: middle;"
                                        :src="item.img"> -->
                                            {{ item.name }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--收藏代码-->
            <div id="WX-window-TKEy5SPt5wisSxt-Shadee" v-if="dialog.fav.status" class="WX-window-shade"
                style="display:none">
                <div id="WX-window-TKEy5SPt5wisSxt-box" class="WX-window-box animated fadeInUp">
                    <div class="WX-Window-main" style="width:80%">
                        <h2>保存本站</h2>
                        <div class="WX-Window-body">
                            <p style="color:#f74550;line-height:25px;margin-top:10px;text-align:center;">
                                长按保存二维码或复制链接收藏本站
                            </p>
                            <img width="100%" :src="'/qrcode/build?text=' + dialog.fav.url"
                                style="display:block;margin:auto;">
                            <!--<div class="CopyUrl">
                            <span class="UrlData">{{dialog.fav.url}}</span>
                            <a href="javascript:void(0);" id="doCopyValue" :data-clipboard-text="dialog.fav.url"
                            @click="doCopyUrl()" class="CopyUrlBtn">复制</a>
                        </div>-->
                        </div>
                        <div class="WX-Window-footer"><a @click="dialog.fav.status = false" href="javascript:void(0);"
                                style="width:calc(95% - 10px);" class="WX-Window-btn cannel">关闭</a></div>
                    </div>
                </div>
            </div>

            <div class="box ListPage"></div>
            <div class="foot">
                <div class="foot-item btn">剩余积分:10</div>
                <div class="foot-item btn" @click="doGetVip">进VIP群</div>
                <div class="foot-item btn" @click="doGetList()">换一批</div>
                <div class="foot-item btn tuiguang" @click="doGetTgm"><img src="/assets/img/iconerweima@2x.png" alt=""
                        srcset=""></div>
            </div>
            <form action="" method="post" name="form" style="display:none">
            </form>
            <van-dialog class="demo-dialog van-dialog" style="width:90%;" v-model="dialog.tgm.status" :title="tgm_title"
                :before-close="closeDig" confirm-button-text="关闭">
                <div
                    style="text-align: center;padding: 20px;background: -webkit-linear-gradient(left,rgb(138,236,163),rgb(104,162,250));">
                    <img :src="tgm_img" class="tgm-img">
                </div>
            </van-dialog>
            <van-dialog class="demo-dialog van-dialog" style="width:90%;" v-model="dialog.vip.status" :title="vip_title"
                :before-close="closeDig" confirm-button-text="关闭">
                <div
                    style="text-align: center;padding: 20px;background: -webkit-linear-gradient(left,rgb(138,236,163),rgb(104,162,250));">
                    <img :src="vip_img" class="tgm-img">
                </div>
            </van-dialog>
         </div>
    </script>
    <script type="text/x-template" id="payed-template">
        <div class="box body home payed" style="display:block;" data-href="0">
                <div class="header">
                    <span class="back" @click="back"></span>
                    <img src="/assets/img/yigouicon.png" alt="">
                </div>
                <div class="list">
                    <div id="list">
                        <van-list v-model="loading" :finished="finished" key="payed" :finished-text="msg" @load="yigou" offset="300"
                            direction="down">
                            <div class="van-clearfix">
                                <lazy-component>

                                    <li class="list-item" v-for="item in list" @click="doJump(item)">
                                        <div class="thumb">
                                            <span class="icon"></span>
                                            <img v-lazy="item.img">
                                            // <video v-else :src="item.video_url" :poster="item.img"></video>
                                        </div>

                                        <div class="desc">
                                            <p class="name">{{ item.title }}</p>
                                            <p class="plays">已有{{ item.rand }}人观看&nbsp;&nbsp;</p>
                                        </div>
                                    </li>
                                </lazy-component>
                            </div>
                        </van-list>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>
    </script>
    <script>
        $(document).ready(function () {
            let player = new Player({
                "id": "mse",
                "url": "<?php echo $hezi['video']; ?>",
                "playsinline": true,
                "x5-video-player-fullscreen": "false",
                "x5-video-orientation": "portraint",
                "x5-video-player-type": "h5",
                "fluid": true,
                "autoplay": true
            });
        });

        Vue.config.productionTip = false;
        Vue.config.lang = 'zh-CN';
        Vue.use(vant.Lazyload, {
            lazyComponent: true,
        });
        var dy = "<?php echo $dy; ?>";
        var Home = {
            template: '#home-template',
            data: function () {
                return {
                    list: [],
                    banners: true,
                    hezi: false,
                    cat: [],
                    ds_img: "",
                    ds_title: "",
                    banner: [
                        { img: '/assets/img/IMG_1674.png', url: '这里填写要跳转的广告连接' },
                        { img: '/assets/img/IMG_1693.png', url: '这里填写要跳转的广告连接' },
                        { img: '/assets/img/IMG_1683.png', url: '这里填写要跳转的广告连接' },
                    ],
                    category: [[
                        {
                            name: '全部',
                            icon: '/assets/img/iconall@2x.png'
                        }, {
                            name: '萝莉',
                            icon: '/assets/img/iconluoli@2x.png'
                        }, {
                            name: '另类',
                            icon: '/assets/img/iconlinglei@2x.png'
                        }, {
                            name: '三级',
                            icon: '/assets/img/iconsanji@2x.png'
                        }, {
                            name: '户外',
                            icon: '/assets/img/iconhuwai@2x.png'
                        }], [
                        {
                            name: '巨乳',
                            icon: '/assets/img/iconjuru@2x.png'
                        }, {
                            name: '剧情',
                            icon: '/assets/img/iconjuqing@2x.png'
                        }, {
                            name: '乱伦',
                            icon: '/assets/img/iconluanlun@2x.png'
                        }, {
                            name: '欧美',
                            icon: '/assets/img/iconoumei@2x.png'
                        }, {
                            name: '强奸',
                            icon: '/assets/img/iconqiangjian@2x.png'
                        }], [
                        {
                            name: '群交',
                            icon: '/assets/img/iconqunjiao@2x.png'
                        }, {
                            name: '人妻',
                            icon: '/assets/img/iconrenqi@2x.png'
                        }, {
                            name: '人兽',
                            icon: '/assets/img/iconrenshou@2x.png'
                        }, {
                            name: '人妖',
                            icon: '/assets/img/iconrenyao@2x.png'
                        }, {
                            name: '日韩',
                            icon: '/assets/img/iconrihan@2x.png'
                        }], [
                        {
                            name: '孕妇',
                            icon: '/assets/img/iconyunfu@2x.png'
                        }, {
                            name: '重口',
                            icon: '/assets/img/iconzhongkou@2x.png'
                        }, {
                            name: '自慰',
                            icon: '/assets/img/iconziwei@2x.png'
                        }, {
                            name: 'SM',
                            icon: '/assets/img/iconsm@2x.png'
                        }, {
                            name: '恋物',
                            icon: '/assets/img/iconlianwu@2x.png'
                        }], [{
                            name: '肛门',
                            icon: '/assets/img/icongangmen@2x.png'
                        }]],
                    loading: false,
                    finished: false,
                    vid: 0,
                    msg: '没有更多了',
                    params: {
                        action: "list",
                        f: "<?php echo $_GET['f']?>",
                        // f: "TURBd01EQXdNREF3TUlXTmZONmJxS2Fo",
                        page: 1,
                        row: 50,
                        encode: 1,
                        cid: '',
                        key: '',
                        payed: ''
                    },
                    catParam: {
                        limit: 9,
                        f: "<?php echo $_GET['f']?>",
                        // f: "TURBd01EQXdNREF3TUlXTmZONmJxS2Fo",
                        encode: 1,
                    },
                    activeIndex:'cat',
                    tgm_img: "uploads/qrocde/1655128717.png",
                    tgm_title: "长按二维码，转发朋友或群赚积分",
                    vip_img: "/uploads/20220602/897830ea4b0bcc0eae624a89262ec4a2.png",
                    vip_title: "长按识别保存扫描可看更多精彩",
                    dialog: {
                        fav: {
                            status: false,
                            img: "",
                            url: "",
                        },
                        pay: {
                            status: false,
                            pay: [],

                        },
                        tgm: {
                            status: false,
                            img: ""
                        },
                        vip: {
                            status: false,
                            img: ""
                        }
                    }
                }
            },
            mounted: function () {
                //this.doFav();
                this.getCat();

                var hezi = this.getQueryVariable('hezi');
                if (hezi > 0) {
                    this.hezi = true;
                    this.banners = false;
                }

            },
            methods: {
               
                closeDig(action, done) {
                    if (this.try_player) {
                        this.try_player.destroy();
                        this.try_player = '';
                    }
                    done(); // 关闭提示框
                },
                sousuoa(e) {
                    let vm = this;
                    vm.params.page = 1;
                    vm.list = [];
                    this.doGetList("-1", '');
                },
                getQueryVariable(variable) {
                    var query = window.location.search.substring(1);
                    var vars = query.split("&");
                    for (var i = 0; i < vars.length; i++) {
                        var pair = vars[i].split("=");
                        if (pair[0] == variable) { return pair[1]; }
                    }
                    return (false);
                },
                doRate() {
                    return parseInt(Math.random() * (100 - 90) + 90);
                },
                doRates() {
                    return parseInt(Math.random() * (10000 - 90) + 90);
                },
                linkTo(e) {

                    layer.msg("正在调起支付...", {
                        icon: 16,
                        time: 3000
                    });

                    if (dy == "1") {
                        document.form.action = e;
                        document.form.submit();
                        return
                    }

                    location.href = e;
                },
                doCopyUrl() {
                    let vm = this;
                    var clipboard = new Clipboard("#doCopyValue");
                    clipboard.on('success', function (e) {
                        vm.$message.success('复制成功');
                        clipboard.destroy();
                    });
                    clipboard.on('error', function (e) {
                        vm.$message.errot('复制失败');
                        console.log(e);
                    });
                },
                doPay(item) {
                    console.log(item);
                    let vm = this;
                    vm.vid = item.id;
                    vm.ds_img = item.img;
                    vm.ds_title = item.title;
                    

                    if (item.pay == 1) {
                        if (dy == "1") {
                            document.form.action = item.url;
                            document.form.submit();
                            return
                        }
                        window.location.href = item.url;
                        return;
                    }
                    $.ajax({
                        url: "/index/index/pay/?f=<?php echo $_GET['f']?>&vid=" + item.id + "&money=" + item.money,
                        type: 'GET',
                        dataType: 'JSON',
                        data: {},
                        complete: function (XMLHttpRequest, textStatus) {
                        },
                        success: function (data) {
                            console.log(data);

                            vm.dialog.pay.pay = data;
                            vm.dialog.pay.status = true;
                        }
                    });
                },
                doGetList(row) {
                    let vm = this;
                    console.log(row);
                    vm.activeIndex = row?row.id?row.id:'-1':'-1'
                    if (row != undefined && row.id != undefined) {
                        vm.list = [];
                        vm.params.page = 1;
                        vm.params.cid = row.id;
                    }
                    if (row == "cat") {
                        vm.list = [];
                        vm.finished = false;
                        vm.params.page = 1;
                        vm.params.cid = '';

                    }
                    if (row == "payed") {
                        vm.list = [];
                        vm.finished = false;
                        vm.params.page = 1;
                        vm.params.payed = 1;
                        vm.params.cid = '';

                        vm.msg = "空空如也,赶紧去选择心仪的影片吧!";
                    }
                    console.log(vm.params);

                    $.ajax({
                        // url: '/h5/api/videolist.php?action=list&uid='+vm.params.uid+'&page='+vm.params.page+'&row='+vm.params.row+'',
                        url: '/index/index/vlist',
                        type: 'GET',
                        dataType: 'JSON',
                        data: vm.params,
                        complete: function (XMLHttpRequest, textStatus) {
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                vm.params.page++;

                                let temp = data.data;
                                vm.list = vm.list.concat(temp);
                                vm.loading = false;
                                if (vm.list.length == data.total) {
                                    vm.finished = true;
                                    if(data.total === 0){
                                        vant.Notify({type:'success', message:'空空如也,赶紧去选择心仪的影片吧!我们即将推送其他精彩内容'})
                                    }
                                    // vant.Notify({ type: 'success', message: vm.msg });
                                }
                            } else {
                                layer.alert(data.msg);
                            }
                        }
                    });


                },
                getCat() {
                    let vm = this;
                    $.ajax({
                        // url: '/h5/api/videolist.php?action=list&uid='+vm.params.uid+'&page='+vm.params.page+'&row='+vm.params.row+'',
                        url: '/index/index/cat',
                        type: 'GET',
                        dataType: 'JSON',
                        data: vm.catParam,
                        complete: function (XMLHttpRequest, textStatus) {
                        },
                        success: function (data) {

                            // vm.cat = data.data;
                            /*if (data.status == 1) {
                                vm.params.page++;
        
                                let temp = data.data;
                                vm.list = vm.list.concat(temp);
                                vm.loading = false;
                                if (vm.list.length == data.total) {
                                    vm.finished = true;
                                }
                            } else {
                                layer.alert(data.msg);
                            }*/
                            if (data.data.length > 0) {
                                data.data.unshift({
                                    id: '-1',
                                    image: '/assets/img/iconall@2x.png',
                                    title: '全部'
                                })
                                let finalArr = []
                                while (data.data.length) {
                                    finalArr.push(data.data.splice(0, 6))
                                }
                                vm.category = finalArr.slice()
                            }

                        }
                    });

                },
                doSearch() {
                    window.location.href = "/index/index/pagecat/?f=<?php echo $_GET['f'];?>";
                },
                toYigou() {
                    this.$router.push('/payed')

                },
                doFav() {
                    let vm = this;
                    vm.dialog.fav.url = "<?php echo $fov; ?>";

                    vm.dialog.fav.status = true;


                    /* $.ajax({
                         // url: '/h5/api/videolist.php?action=list&uid='+vm.params.uid+'&page='+vm.params.page+'&row='+vm.params.row+'',
                         url: '/h5/api/dwz.php',
                         type: 'GET',
                         dataType: 'JSON',
                         data: {action: "getUrl", uid: "1"},
                         complete: function (XMLHttpRequest, textStatus) {
                         },
                         success: function (data) {
                             if (data.status == 1) {
                                 vm.dialog.fav.url = data.data;
         
                                 vm.dialog.fav.status = true;
                             } else {
                                 layer.alert(data.message);
                             }
                         }
                     });*/
                },
                doGetTgm() {
                    let vm = this;
                    vm.dialog.tgm.status = true;

                },
                doGetVip() {
                    let vm = this;
                    vm.dialog.vip.status = true;
                },

            }
        }
        var Payed = {
            template: '#payed-template',
            data: function () {
                return {
                    params: {
                        action: "list",
                        // f: "TURBd01EQXdNREF3TUlXTmZONmJxS2Fo",
                        f: "<?php echo $_GET['f']?>",
                        page: 1,
                        row: 50,
                        encode: 1,
                        cid: '',
                        key: '',
                        payed: ''
                    },
                    msg: '没有更多了',
                    finished: true,
                    list: [],
                    loading: false
                }
            },
            mounted: function () {
                this.yigou()
            }
            , methods: {
                 doJump(item){
                    //  alert(item.url)
                    location.href = item.url+'&img='+item.img
                    
                },
                doGetList(index, row) {
                    let vm = this;
                    console.log(row);
                    vm.params.payed = '';
                    if (row != undefined && row.id != undefined) {
                        vm.list = [];
                        vm.params.page = 1;
                        vm.params.cid = row.id;
                    }
                    if (row == "cat") {
                        vm.list = [];
                        vm.finished = false;
                        vm.params.page = 1;
                        vm.params.key = '';
                        vm.params.cid = '';
                    }
                    console.log(vm.params);
                    $.ajax({
                        // url: '/h5/api/videolist.php?action=list&uid='+vm.params.uid+'&page='+vm.params.page+'&row='+vm.params.row+'',
                        url: '/index/index/vlist',
                        type: 'GET',
                        dataType: 'JSON',
                        data: vm.params,
                        complete: function (XMLHttpRequest, textStatus) {
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                vm.params.page++;

                                vm.total = data.total;
                                let temp = data.data;
                                vm.list = vm.list.concat(temp);
                                vm.loading = false;
                                if (vm.list.length == data.total) {
                                    vm.finished = true;
                                    vm.msg = "没有更多了";

                                }
                            } else {
                                layer.alert(data.msg);
                            }
                        }
                    });


                },
                yigou() {
                    let vm = this;

                    console.log()
                    vm.finished = false;
                    vm.params.page = 1;
                    vm.params.payed = 1;
                    vm.params.key = '';
                    vm.params.cid = '';
                    vm.list = [];
                    // vm.msg = "空空如也,赶紧去选择心仪的影片吧!我们即将推送其他精彩内容";

                    $.ajax({
                        url: '/index/index/vlist',
                        type: 'GET',
                        dataType: 'JSON',
                        data: vm.params,
                        complete: function (XMLHttpRequest, textStatus) {
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                vm.params.page++;

                                vm.total = data.total;
                                let temp = data.data;
                                vm.list = data.data;
                                vm.loading = false;
                                if (vm.list.length == data.total) {
                                    vm.finished = true;
                                    // vant.Notify({ type: 'success', message: vm.msg });
                                    if(data.total === 0){
                                        vant.Notify({type:'success', message:'空空如也,赶紧去选择心仪的影片吧!我们即将推送其他精彩内容'})
                                    }
                                }
                            } else {
                                layer.alert(data.msg);
                            }
                        }
                    });


                },
                back() {
                    history.back()
                }
            }
        }
        new Vue({
            el: '#app',
            router: new VueRouter({
                mode: 'hash',
                routes: [{ path: '/', component: Home }, { path: '/payed', component: Payed }]
            })
        })
    </script>
    <script>
        var topdata = "20px";
        function geturl(url) {
            var httpRequest = new XMLHttpRequest();//第一步：建立所需的对象
            httpRequest.open('GET', url, true);//第二步：打开连接  将请求参数写在url中  ps:"./Ptest.php?name=test&nameone=testone"
            httpRequest.send();//第三步：发送请求  将请求参数写在URL中
            /**
             * 获取数据后的处理程序
             */
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var json = httpRequest.responseText;//获取到json字符串，还需解析
                    console.log(json);
                    return json;
                }
            };
        }
    </script>

</body>

</html>