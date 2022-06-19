<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"/www/wwwroot/dst/public/../application/index/view/index/video.html";i:1655648570;}*/ ?>
<!DOCTYPE html>

<html lang="zh-CN">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>视频播放</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no">
  <meta name="screen-orientation" content="portrait">
  <meta name="x5-orientation" content="portrait">
  <meta name="full-screen" content="yes">
  <meta name="x5-fullscreen" content="true">
  <style>
    html,
    body {
      background-color: #FFFFFF;
      font-size: calc(100vw/18.375) !important;
    }
  </style>
</head>

<body style="display: block;">



  <script src="/assets/list/muban1/static/lib/vue/vue.js"></script>


  <link rel="stylesheet" href="/assets/list/muban1/static/css/main.css">

  <link rel="stylesheet" href="/assets/list/muban1/static/css/wx.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.10/lib/index.css" />
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.7/jquery.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/vue@2.6/dist/vue.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vant@2.10/lib/vant.min.js"></script>

  <script src="/assets/list/muban1/static/lib/layer/layer.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/xgplayer@2.9.6/browser/index.js" charset="utf-8"></script>
  <script src="/assets/list/muban1/static/clipboard/clipboard.min.js" type="text/javascript"></script>


  <script src="https://cdn.bootcdn.net/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


  <style>
    .copydata {
      border: none;
      display: inline-block;
      width: 78%;
      padding-top: 1%;

    }

    .weui-search-bar {
      position: relative;
      padding: 8px 10px;
      display: -webkit-box;
      display: -webkit-flex;
      display: flex;
      box-sizing: border-box;
      background-color: #efeff4;
      -webkit-text-size-adjust: 100%;
      -webkit-box-align: center;
      -webkit-align-items: center;
      align-items: center;
    }

    .van-list__finished-text {
      margin-bottom: 10%;
    }

    .likelist {
      margin-top: 10px;
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
      width: 46%;
      height: 2rem;
      line-height: 2rem;
      margin-top: .25rem;
      border-radius: 5px;
      text-align: center;
      color: #fff;
      background: -webkit-linear-gradient(left, rgb(33, 45, 77), rgb(62, 147, 140));
      display: inline-block;
      margin-right:1rem;
    }

    .pay-item:last-child {
      margin-bottom: 10px;
      margin-right:0;
    }

    .weui-search-bar__cancel-btn1 {
      display: block;
      margin-left: 10px;
      line-height: 28px;
      color: #09bb07;
      white-space: nowrap;
    }

    input::-ms-input-placeholder {
      text-align: center;
    }

    input::-webkit-input-placeholder {
      text-align: center;
    }

    #mse {
      background-color: #0d0d0d;
    }

    .player_bot {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-pack: distribute;
      justify-content: space-around;
      margin: .5rem .7rem;
      padding: 1rem;
      background: #f7f7f7;
      border-radius: 5px;
    }

    .player_bot div {
      font-size: .6rem;
      text-align: center;
    }

    .player_bot p {
      font-size: .6rem;
      color: #575757;
      margin: 0;
    }

    .player_bot div img {
      width: .98rem;
      height: .9rem;
      margin-bottom: .15rem;
    }

    .details span {
      font-size: .9rem;
    }

    .details .coup,
    .details .liker {
      display: inline-block;
      font-size: .6rem;
      margin: 0;
      box-sizing: content-box;
    }

    .details .liker {
      float: right;
      margin-right: .7rem;
      padding: 2px 1%;
    }

    .details .liker span {
      display: block;
      width: 100%;
      box-sizing: content-box;
      min-width: 1rem;
      padding-left: 1rem;
      font-size: .6rem;
    }

    .details p img {
      width: 15px;
      height: 15px;
    }

    #mse {
      height: 12.6rem;
      width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, .5);
    }

    .title {
      font-size: .9rem;
      display: block;
      color: #333;
      margin: .7rem;
    }

    .coup {
      margin-left: .5rem;
      min-width: 50%;
      width: 60%;
      padding-left: .7rem;
    }

    .coup span {
      padding: 1%;
      display: inline-block;
      min-width: 2rem;
      background: url(/assets/img/huo@2x.png) no-repeat left center;
      background-size: .4rem .5rem;
      padding-left: .5rem;
      font-size: .6rem;
    }

    .coup span:last-child {
      background-image: url(/assets/img/dashang@2x.png);
    }

    .liker {
      background: #25C84F;
      color: #fff;
      border-radius: 3px;
    }

    .liker span {
      background: url(/assets/img/aixin@2x.png) no-repeat left center;
      background-size: .55rem .5rem;
    }

    .list .list-item {
      height: auto;
      margin-left: .7rem;
      width: 8rem;
      overflow: hidden;
    }

    .list .list-item .thumb {
      width: 8rem;
      height: 9.8rem;
      border-radius: 5px;
      overflow: hidden;
    }

    .list .list-item .thumb img {
      display: block;
    }

    .list .list-item:nth-child(2n) {
      margin-left: .55rem;
    }

    .list .list-item .name {
      font-size: .7rem;
      color: #222;
      margin: 0;
      padding: 0;
      line-height: normal;
      margin: .5rem 0;
      width: 100%;
    }

    .list .list-item .plays {
      color: #a2a2a2;
      font-size: .6rem;
      line-height: normal;
      margin: 0;
      width: 100%;

    }

    .back_btn {
      position: absolute;
      left: 0;
      top: 0;
      width: 2rem;
      height: 2rem;
      background: url(/assets/img/arrowleft@2x.png) no-repeat center;
      background-size: .45rem .8rem;
      z-index: 10000;
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

    .WX-window-box .WX-Window-body {
      padding: 0;
    }

    .niubi {
      font-size: 1.2em;

    }

    .ds_tankuang {
      height: 10rem;
      width: 100%;
      margin-bottom: 4%;
    }
  </style>


  <div class="box body channelbox" data-href="type" style="display: block;">


    <div id="app">
      <div class="back_btn" @click="back"></div>
      <div id="mse"></div>
      <p class="title">
        <?php echo $link['title']; ?>
      </p>
      <div class="details">
        <p class="coup">
          <span>
            <?php echo rand(0,100000)?>
          </span>/
          <span> 打赏
            <?php echo rand(100,5633)?>
          </span>
        </p>
        <!-- <p class="">
          <?php echo rand(0,100000)?> /
          <?php echo rand(100,5633)?>(金币)
          <?php echo rand(400,54321)?>次打赏
        </p> -->
        <p class="liker">
          <span>
            <?php echo rand(1000,33322)?>喜欢
          </span>
        </p>
      </div>
      <div class="player_bot">
        <div class="shoucang">
          <img src="/assets/img/shoucang@2x.png" alt="" @click="doFav">
          <p @click="doFav">收藏</p>
        </div>
        <div id="playId" class="yigou">
          <img src="/assets/img/dingdan-3@2x.png" alt="">
          <p @click="doGetList('pay')">已购</p>

        </div>
        <div class="callback"><img src="/assets/img/taolunqu@2x.png" alt="" onclick="location.href='/tousu'">
          <p><a href="/tousu" style="color: #8f8f94">投诉</a></p>
        </div>
      </div>

      <div class="weui-panel__hd"
        style="text-align: left;color:#333;font-size: .8rem;padding-left:.7rem;font-weight:bold;">精彩视频推荐</div>

      <div v-if="list.length>0">
        <!-- <div class="list">
          <van-list v-model="loading" :finished="finished" finished-text="没有更多了" @load="doGetList" offset="150"
            direction="down">
            <div class="van-clearfix">
              <li class="list-item" v-for="item in list" @click="doPay(item)">
                <div class="thumb"><img :src="item.img"></div>
                <p class="name">{{item.title}}</p>
                <p class="plays">{{doRate()}}人已付费观看</p>
              </li>
            </div>
          </van-list>
        </div> -->
        <div class="list">
          <div id="list">
            <van-list v-model="loading" :finished="finished" finished-text="没有更多了" @load="doGetList" offset="300"
              direction="down">
              <div class="van-clearfix">
                <lazy-component>
                  <li class="list-item" v-for="item in list" @click="doPay(item)">
                    <div v-if="item.img" class="thumb home-thumb">
                      <p class="momeny-icon">{{item.money}}元观看<span>{{ item.rand }}人观看&nbsp;&nbsp;</span>
                      </p>
                      <img v-lazy="item.img.replace('.gpj','.jpg')">
                    </div>
                    <p class="name">{{ item.title }}</p>
                  </li>
                </lazy-component>
              </div>
            </van-list>
            <div style="clear:both;"></div>
          </div>
        </div>
      </div>




      <!--收藏代码-->
      <!--<div id="WX-window-TKEy5SPt5wisSxt-Shadee" v-if="dialog.fav.status" class="WX-window-shade">-->
      <!--    <div id="WX-window-TKEy5SPt5wisSxt-box" class="WX-window-box animated fadeInUp">-->
      <!--        <div class="WX-Window-main" style="width:80%"><h2>保存本站</h2>-->
      <!--            <div class="WX-Window-body">-->
      <!--                <p style="color:#f74550;line-height:25px;margin-top:10px;text-align:center;">-->
      <!--                    为了防止网络IP切换导致会员失效强烈建议您截图或长按保存二维码打开观看-->
      <!--                </p>-->
      <!--                <img width="100%" :src="dialog.fav.url"-->
      <!--                     style="display:block;margin:auto;">-->

      <!--                <div class="CopyUrl">-->

      <!--                    <input type="text" class="copydata"v-model="dialog.fav.u" >-->
      <!--                    <a href="javascript:void(0);" id="doCopyValue" :data-clipboard-text="dialog.fav.u"-->
      <!--                       @click="doCopyUrl()" class="CopyUrlBtn">复制连接</a>-->
      <!--                </div>-->



      <!--                <p style="color:#f74550;padding:0%;margin:0;line-height:25px;text-align:center;">-->
      <!--                    购买类型:<?php echo $desc; ?>,到期时间:<?php echo $expire; ?>-->
      <!--                </p>-->

      <!--                <p style="color:#f74550;padding:1%;margin:0;line-height:25px;text-align:center;">-->
      <!--                    <input type="checkbox" v-model="checked" id="in2"><label for="in2">我已保存不再提醒</label>-->
      <!--                </p>-->



      <!--            </div>-->
      <!--            <div class="WX-Window-footer"><a @click="guanbi" href="javascript:void(0);"-->
      <!--                                             style="width:calc(95% - 10px);"-->
      <!--                                             class="WX-Window-btn cannel">关闭</a></div>-->
      <!--        </div>-->
      <!--    </div>-->
      <!--</div>-->


      <!--打赏代码-->
      <div id="WX-window-TKEy5SPt5wisSxt-Shade" v-if="dialog.pay.status" class="WX-window-shade">
        <div id="WX-window-TKEy5SPt5wisSxt-box" class="WX-window-box animated fadeInUp">
          <div class="WX-Window-main">
            <!--<h2>购买后观影</h2>-->
            <h2> <span class="close_btn" @click="dialog.pay.status = false, dialog.pay.pay = []"></span></h2>
            <div class="ds_tankuang">
              <img :src="ds_img.replace('.gpj','.jpg')" style="width:100%;height:100%">
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

 

    <div class="dialog_cover" v-if='dialogDashang'>
      <div class="dialog_dashang">
        <h3 class="d_title">试看结束，请点击打赏观看完整视频</h3>
        <div class="btns">
          <div class="btn_left" @click="dialogDashang = false;">再选选看</div>
          <div class="btn_right" @click="sureDashang">打赏观看</div>
        </div>
      </div>
    </div>
   </div>
    <form action="" method="post" name="form" style="display:none">

    </form>
  </div>
  <!-- 
  <div class="footer">
    <ul>
      <li class="">
        <a href="/index/index/lists/?f=<?php echo $_GET['f'];?>">
          <img src="/assets/list/muban1/tab-home.png">
          <span>首页</span>
        </a>
      </li>
      <li class="">
        <a href="/index/index/pagecat/?f=<?php echo $_GET['f'];?>">
          <img src="/assets/list/muban1/tab-cate.png">
          <span>分类</span>
        </a>
      </li>

      <li>
        <a href="/index/index/lists/?f=<?php echo $_GET['f'];?>#/payed">
          <img src="/assets/list/muban1/tab-cart.png">
          <span>已购</span>
        </a>
      </li>
    </ul>
  </div> -->
  <style>
    .dialog_dashang {
      /*display: none;*/
      width: 16.5rem;
      min-height: 7.8rem;
      background: #FFFFFF;
      border-radius: 5px;
      padding-top: 2rem;
      padding-bottom: 1rem;
      padding-left: 1.5rem;
      padding-right: 1.5rem;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .dialog_cover {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 10001;
      background: rgba(0, 0, 0, .3);
    }

    .d_title {
      color: #333;
      font-weight: normal;
      font-size: .8rem;
      margin-bottom:2rem;
    }

    .dialog_dashang .btns {
      display: flex;
    }

    .dialog_dashang .btn_left {
      width: 6.25rem;
      height: 2rem;
      border-radius: 5px;
      text-align: center;
      border: 2px solid #25C84F;
      color: #25C84F;
      line-height: 2rem;
      font-size: .7rem;
      margin-right: 1.25rem;
    }

    .dialog_dashang .btn_right {
      width: 6.25rem;
      height: 2rem;
      text-align: center;
      border-radius: 5px;
      color: #fff;
      line-height: 2rem;
      font-size: .7rem;
      background: -webkit-linear-gradient(left, rgb(33, 45, 77), rgb(62, 147, 140));
    }

    .list {
      padding: 1%;
    }

    .list .list-item {
      height: auto;
      margin-bottom: .5rem
    }

    .list .list-item .plays {
      color: #CCCCCC;
      padding-left: 0;
      font-size: .6rem;
      margin: 0;
    }

    .list .list-item .name {
      line-height: 1.5rem;
      font-size: .65rem;
      margin: 0;
      background: linear-gradient(45deg, #bd58ef, #af4261);
      background-clip: text;
      -webkit-background-clip: text;
      -moz-background-clip: text;
      -moz-text-fill-color: transparent;
      -webkit-text-fill-color: transparent;
    }

    .list .list-item .thumb {
      height: 4.2rem;
      position: relative;
    }

    .list .list-item .thumb img {
      box-shadow: 0 0 10px rgb(0 0 0 / 10%);
      border-radius: 5px;
    }

    .home-thumb {
      position: relative;
    }

    .home-thumb .momeny-icon {
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

    .home-thumb .momeny-icon span {
      float: right;
      font-size: .4rem;
    }
  </style>

  <script>



    console.log(vant);
    Vue.config.productionTip = false;
    Vue.config.lang = 'zh-CN';
    // Vue.use(vant.Dialog);

    var dy = "<?php echo $dy; ?>";
    var payed = "<?php echo $pay; ?>";
    vues = new Vue({
      el: '#app',
      data: {
        list: [],
        cat: [],
        checked: false,
        banner: [
        ],
        ds_img: "",
        ds_title: "",
        dialogDashang: false,
        tempForDashang: null,
        loading: false,
        finished: false,
        msg: '没有更多了',
        params: {
          action: "list",
          f: "<?php echo $_GET['f']?>",
          page: 1,
          row: 50,
          encode: 1,
          cid: "<?php echo isset($_GET['cid']) ? $_GET['cid'] : ''; ?>",
          key: "<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>",
          payed: ''
        },
        catParam: {
          limit: 9, f: "<?php echo $_GET['f']?>",
          encode: 1,
        },

        dialog: {
          fav: {
            status: false,
            url: "",
            u: "<?php echo $d; ?>"
          },
          pay: {
            status: false,
            data: [],
            pay: []
          }
        }
      },
      mounted: function () {


        if (typeof (Storage) !== "undefined") {
          // 存储
          var close = localStorage.getItem("close");
          console.log(close);
          if (close == 'false' || close == null) {
            this.doFav();

          }
        }
        this.doGetList();


      },
      methods: {
        back() { history.back() },
        onChange(event) {
          console.log(event);
        },
        try_see(item) {
          this.tempForDashang = item
          this.dialogDashang = true
          // vant.Dialog.confirm({
          //   title: '',
          //   message: '试看以结束，请点击打赏观看完整视频',
          //   cancelButtonText: "我在选选",
          //   confirmButtonText: "打赏观看"

          // })
          //   .then(() => {
          //     this.doPay(item)
          //   })
          //   .catch(() => {
          //     // on cancel
          //   });
        },
        sureDashang() {
          this.dialogDashang = false;
          this.doPay(this.tempForDashang)
        },
        doRate() {
          return parseInt(Math.random() * (10000 - 90) + 90);
        },
        linkTo(e) {
          layer.msg("正在吊起支付...", {
            icon: 16,
            time: -1
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
            layer.msg('复制成功');
            clipboard.destroy();
          });
          clipboard.on('error', function (e) {
            layer.msg('复制失败');
            console.log(e);
          });
        },
        doPay(item) {
          console.log(item);
          let vm = this;
          vm.vid = item.id;
          vm.ds_img = item.img || item.image;
          vm.ds_title = item.title

          if (item.pay == 1) {
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
              if (dy == "1") {
                document.form.action = item.url;
                document.form.submit();
                return
              }
              vm.dialog.pay.pay = data;
              vm.dialog.pay.status = true;
            }
          });
        },
        doGetList(pay) {
          let vm = this;
          if (pay == "pay") {
            vm.params.page = 1;
            vm.params.payed = 1;
            vm.list = [];
          }
          //   vm.params.f = "TURBd01EQXdNREF3TUlXTmZONmJxS2Fo"
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
                }
              } else {
                layer.alert(data.msg);
              }
            }
          });


        },
        doSearch() {
          window.location.href = '/user.php?uid=1&type=channel';
        },

        guanbi() {

          let vm = this;
          if (typeof (Storage) !== "undefined") {
            // 存储
            localStorage.setItem("close", vm.checked);
            //localStorage.getItem("lastname");
          }
          else {
            console.log("不支持本地存储");
          }



          console.log(vm.checked)
          vm.dialog.fav.status = false

        },
        doFav() {
          let vm = this;

          if (typeof (Storage) !== "undefined") {
            // 存储
            //localStorage.setItem("close", vm.checked);
            var close = localStorage.getItem("close");
            if (close == 'true') {
              vm.checked = true;
            }
          }



          var d = "<?php echo $uu; ?>"
          console.log(d);
          vm.dialog.fav.url = d;


          console.log(vm.dialog.fav.url)

          vm.dialog.fav.status = true;
        },

      }
    })

    $(document).ready(function () {

      $("#searchSubmit1").click(function () {
        var keys = $("#keys").val();
        location.href = "/index/index/pagecat?f=<?php echo $_GET['f']?>&type=search&keyword=" + keys;
      });

      let player = new Player({
        "id": "mse",
        "url": "<?php echo $link['video_url']; ?>",
        "playsinline": true,
        "poster": "<?php echo $link['img']; ?>",
        "x5-video-player-fullscreen": "false",
        "x5-video-orientation": "portraint",
        "x5-video-player-type": "h5",
        "fluid": true,
      });

      player.on('timeupdate', function (e) {
        var currentTime = parseInt(e.currentTime);

        var try_see = "<?php echo $link['try_see']; ?>"
        if (currentTime >= try_see) {
          console.log('试看结束');


          //e.exitFullscreen(e.root)
          if (payed == 0) {
            e.pause();
            vues.try_see({
              id: "<?php echo $link['id']; ?>",
              pay: 0,
              money: "<?php echo $link['money']; ?>",
              img: "<?php echo $link['img']; ?>"
            });
          }

        }
      })

    });


  </script>

</body>

</html>