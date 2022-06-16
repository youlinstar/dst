<?php

namespace app\index\controller;

use app\admin\model\Admin;
use app\admin\model\Category;
use app\admin\model\Domain;
use app\admin\model\Hezi;
use app\admin\model\Link;
use app\admin\model\Muban;
use app\admin\model\Stock;
use app\commom\model\Payed;
use app\common\controller\Frontend;
use think\Db;
use function fast\array_get;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        $this->fangfeng();
        $this->checkFlg();
        $this->accessStatistical();
        $d = config('site.doiyin');
        $this->assign('dy',$d);
    }

    //入口
    public function index()
    {
        //111.com/index/index/index?f=14792
        $ua = md5($this->request->server('HTTP_USER_AGENT'));
        $sn = $this->request->param('sn');
        $order = (new Payed)->where(['order_sn' => $sn])->where('expire','>',time())->find();
        if($order) {
            $ua = $order->ua;
            cookie('ua',$ua,3600);
            cookie('sn',$sn,3600);
            cookie('ip',$order->ip,3600);
            cookie('is_sn',1,3600);
        } else {
             cookie('ua','',3600);
            cookie('ip','',3600);
            cookie('is_sn',0,3600);
            
        }
        $url = $this->request->url();
        $qiantao = config('site.qiantao');
        $url = str_replace("/index/index/index","/index/index/lists",$url);
        if($qiantao == 1 && !$this->is_wxBrowers()) {
            //$url = $url . "&qiantao=$qiantao";
            $p = $this->request->param();
            unset($p['qiantao']);
            $d = $this->getDomain(2,"/index/index/lists");
            $d .= http_build_query($p);
            $this->view->engine->layout(false);
            $this->assign('url' , $d);
            return $this->fetch("list/qiantao");
        }
        $param = $this->request->param();
        $userInfo = Admin::getUser($this->id);
        if($userInfo['status'] != 'normal')
        {
            return $this->error("该用户已经被禁用!");
        }
        
        $d = config('site.doiyin');
        $domain = trim(getDomain(2)).urldecode($url);
        if($d == 1)
        {
          //  $url = str_replace("/index/index/lists","/index/index/dlist",$url);
            $domain = getDomain(2).urldecode($url);
            $this->assign('url' , $domain);
            return $this->view->fetch("third/jump");
        }
        header("location:{$domain}");
        die;
    }
    
    //落地
    public function lists($f)
    {
        $qiantao = $this->request->param('qiantao');
        if($qiantao == 1) {
            $d = $this->getDomain(2,"/index/index/lists");
            $p = $this->request->param();
            unset($p['qiantao']);
            $d .= http_build_query($p);
            $this->view->engine->layout(false);
            $this->assign('url' , $d);
            return $this->fetch("list/qiantao");
        }
        $hezi = $this->request->param('hezi');
        if(cookie('is_sn') != 1) {
            cookie('ua',md5($this->request->server('HTTP_USER_AGENT')),3600);
        }
        $domain = $this->request->host().$this->request->url();
        //$this->assign('pay' , $this->pay($f));
        $this->assign('fov', $domain);
        $this->assign('hezi',['video' => '']);
        if($hezi) {
            $this->assign('hezi' ,(new Hezi())->find($hezi));
        }
        $userInfo = Admin::getUser($this->id);
        $view = $this->muBan;
        $muban = (new Muban())->find($userInfo['view_id']);
        if(!empty($muban)) {
            $view = $muban['muban'];
        }
        
        $cat = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','image','name as title'])->order('weigh','desc')->select();
        $this->assign('cat',$cat);
        $this->assign('cookieip' , '');
        $this->assign('userinfo',$userInfo);
        $this->assign('domain' , $this->request->domain());
        //显示前台模版
        return $this->fetch("list/".$view);
    }

    //分类
    public function pagecat()
    {
        $data = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','image','name as title'])->order('weigh','desc')->select();
        $keyword = $this->request->param('keyword');
        $cid = $this->request->param('cid');
        $this->assign('cat' ,$data);
        $this->assign('cats' ,$data);
        return $this->fetch("list/cat");
    }

    //视频播放页
    public function video()
    {
        $ip = $this->request->ip();
        $ua = cookie('ua');
        if(cookie('is_sn') == 1){
            $ip = cookie('ip');
        }
        $vid = $this->request->param('vid');
        $linkInfo = Link::getLink($vid);
        if(empty($linkInfo)) {
            return $this->error("视频资源丢失!" , '' , '' ,200);
        }
        $payedVid = $this->getPayedVideoId();
        $vidArr = $payedVid['vid'];
        $expire = date('Y-m-d H:i:s' , $payedVid['expire']);
        $desc = '单片';
        if($payedVid['is_date'] == 2) {
            $desc = "包天";
        }
        if($payedVid['is_week'] == 2) {
            $desc = "包周";
        }
        if($payedVid['is_month'] == 2) {
            $desc = "包月";
        }
        $this->assign('desc' ,$desc);
        $this->assign('expire' , $expire);
        $f = $this->request->param('f');
        $sn = $payedVid['sn'];
        $d= trim(getDomain(1))."/index/index/index?sn={$sn}&f={$f}";
        $this->assign('d',$d);
        $d = urlencode($d);
        $uu = "/qrcode/build?text={$d}"."&label=(%E5%A6%82%E5%BE%AE%E4%BF%A1%E6%89%AB%E7%A0%81%E8%BF%9B%E4%B8%8D%E5%8E%BB%E9%93%BE%E6%8E%A5%2C%E8%AF%B7%E4%BD%BF%E7%94%A8%E6%B5%8F%E8%A7%88%E5%99%A8%E6%89%AB%E7%A0%81%E8%A7%82%E7%9C%8B%E6%B0%B8%E4%B8%8D%E8%BF%B7%E8%B7%AF)&logo=0&labelhalign=0&labelvalign=3&foreground=%23ffffff&background=%23000000&size=500&padding=10&logosize=100&labelfontsize=14&errorcorrection=medium";
        $this->assign('uu',$uu);
        $pay = 0;
        $vid = array_intersect($vidArr , [$vid]);
        $payed = false;
        if($vid) {
            $where['vid'] = array('in', $vid);
            $payed = (new Payed())
            ->where($where)
            ->where('expire','>' , time())
            ->where(function($query) use($ip , $ua){
                return $query->whereOr('ip',"=" , $ip )->whereOr('ua' , "=" , $ua );
            })
            ->find();
            if($payed) {
                 $pay = 1;
            }
        }
        if($payedVid['is_date'] == 2 || $payedVid['is_month'] == 2  || $payedVid['is_week'] == 2 ) {
            $pay = 1;
            $payed = true;
        }
        if($payed == false && $linkInfo['try_see'] == 0) {
            return $this->error('视频不存在!或者已过期!' , '' ,'' ,200);
        }
        $this->assign('payed' , $payed);
        $this->assign('pay' , $pay);
        $this->assign('link' , $linkInfo);
        return view('video');
    }

    public function payed_list()
    {
        return $this->vlist();
    }

    public function vlist()
    {
        $f = $this->request->param('f');
        $key = $this->request->param('key');
        $cid = $this->request->param('cid');
        $payed = $this->request->param('payed');
       // $userInfo = Admin::getUser($this->id);
        $payedVid = $this->getPayedVideoId();
        $where = ['uid' => ['=' , $this->id]];
        if($key) {
            $where = array_merge($where , ['title' =>['like' , "%{$key}%"]]);
        }
        if($cid) {
           $cname =  (new Category)->find($cid)->name;
           $where = array_merge($where , ['title' =>['like' , "%{$cname}%"]]);
           // dump($cname);die;
            //$where = array_merge($where , ['' =>['=' , "$cid"]]);
        }
        if($payed && ($payedVid['is_date'] == 1 && $payedVid['is_month'] == 1 && $payedVid['is_week'] == 1) ) {
            $where['id'] = ['in',$payedVid['vid']];
        }
        $link = (new Link())->where($where)->field(['id','cid','video_url','title','img','money','money3','money2','money1','read_num','try_see'])->orderRaw('rand()')->paginate(10 );//前缀加载视频资源数 建议10-15数字越大加载越多访问速度会变慢
        foreach ($link as &$item)
        {
            $item['rand'] = rand(999 , 7777);
            $item['h'] = rand(90 , 99);
            if(in_array($item['id'], $payedVid['vid'], true) ||  ($payedVid['is_week'] == 2 || $payedVid['is_date'] == 2 || $payedVid['is_month'] == 2) || $item['try_see'] > 0) {
                $item['pay'] = 1;
                $item['url'] = $this->getDomain(2,"/index/index/video")."vid={$item['id']}&f={$f}";
            } else {
                if(!empty($this->getDomain(3,"/index/trading/index"))) {
                    $item['url'] = $this->getDomain(3,"/index/trading/index")."vid={$item['id']}&f={$f}";
                }else{
                    $item['url'] = $this->getDomain(2,"/index/trading/index")."vid={$item['id']}&f={$f}";
                }
                $item['pay'] = 0;
            }
            // $item['pay'] = 1;
              //  $item['url'] = $domain ."/index/index/video?vid={$item['id']}&f={$f}";
        }
        $total = $link->total();
        $list = $link->getCollection()->toArray();
        shuffle($list);
        shuffle($list);
        shuffle($list);
        $data = $list;
        if($this->request->param('encode',0) == 0) {
            $data = strrev(base64_encode(json_encode($list)));
        }
        return json(['status' => 1, 'msg' => '' , 'data' => $data  ,'total' =>$total]);
    }

    public function cat()
    {
        $limit = $this->request->param('limit',9999);
        $data = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','image','name as title'])->limit($limit)->order('weigh','desc')->select();
        if($this->request->param('encode') == 1)
        {
            exit(json_encode(['status' => 1, 'msg' => 'success', 'data' => $data]));
        }
        $data = base64_encode(json_encode($data));
        $data = strrev($data);
        $data = str_replace('==', '', $data);
        $data = str_replace('=', '', $data);
        echo json_encode(['status' => 1, 'msg' => 'success', 'data' => $data]);
    }

    public function pay($f)
    {
        $userInfo = get_user($this->id);
        $m = $this->request->param('money',0);
        $vid = $this->request->param('vid',0);
        $domain = $this->getDomain(2);
        $payDomain = $this->getDomain(3);
        if($payDomain)
        {
            $domain = $payDomain;
        }
        $pay_model = $userInfo['pay_model'];
        if($pay_model == "xsdwrkj002") {
            $q = 1.4;
            $m = round($m * $q);
            $userInfo['date_fee'] = round($userInfo['date_fee'] * $q);
            $userInfo['month_fee'] = round($userInfo['month_fee'] * $q);
            $userInfo['week_fee'] = round($userInfo['week_fee'] * $q);
        }
        $pay = [[
            'name' => "单片购买 {$m} 元",
            'url' => $this->getDomain(2,"/index/trading/index")."f={$f}&vid={$vid}",
            'flg' => 'dan',
            'money' => 0,
            'img' => "/assets/list/muban1/vipicon.png"  //图标地址
        ]];
        if($userInfo['date_fee'] > 0) {
            $pay[] = [
                'name' => "包日观看全部 {$userInfo['date_fee']} 元",
                'url' => $this->getDomain(2,"/index/trading/index")."f={$f}&is_date=2&vid=$vid",
                'flg' => 'date_fee',
                'money' => $userInfo['date_fee'],
                'img' => "/assets/list/muban1/vipicon.png"  //图标地址
            ];
        }
        if($userInfo['week_fee'] > 0) {
            $pay[] = [
                'name' => "包周观看全部 {$userInfo['week_fee']} 元",
                'url' => $this->getDomain(2,"/index/trading/index")."f={$f}&is_week=2&vid=$vid",
                'flg' => 'week_fee',
                'money' => $userInfo['week_fee'],
                'img' => "/assets/list/muban1/vipicon.png"  //图标地址
            ];
        }
        if($userInfo['month_fee'] > 0) {
            $pay[] = [
                'name' => "包月观看全部 {$userInfo['month_fee']} 元",
                'url' => $this->getDomain(2,"/index/trading/index")."f={$f}&is_month=2&vid=$vid",
                'flg' => 'month_fee',
                'money' => $userInfo['month_fee'],
                'img' => "/assets/list/muban1/vipicon.png"  //图标地址
            ];
        }
        return json($pay);
        /*return $pay;
        return $pay;
        $where = [$userInfo['pay_model'] , $userInfo['pay_model1']];
        $pay = \db('pay_setting')->whereIn('model' , array_filter($where))->select();
        foreach ($pay as &$item)
        {
            $item['name'] = $item['title'];
            $item['url'] = "/index/trading/index?f={$f}&model={$item['model']}&vid=";
        }
        return $pay;*/
    }

    protected function getPayedVideoId(){
        $ip = $this->request->ip();
        $ua = $this->request->cookie('ua');
        if(cookie('is_sn') == 1) {
            $ip = cookie('ip');
        }
       // $where['ip'] = ['=',$ip];
        //$where['uid'] = ['=',$this->id];
        $where['expire'] = ['>' , time()];
        //ua 条件待定
        $pay = (new Payed())->where($where)->where(function($q) use ($ip , $ua){
            return $q->whereRaw(" (ip = '{$ip}' or ua = '{$ua}') ");//判断ip加浏览器指纹ua
         //   return $q->whereRaw(" (ip = '{$ip}') ");//单判断ip
        })->order('expire','desc')->select();
        $is_date = 1;
        $is_week = 1;
        $is_month = 1;
        foreach ($pay as $k => $item) {
            //是否有包天
            if($item['is_date'] == 2 && $item['expire'] > time()) {
                $is_date = 2;
            }
            if($item['is_month'] == 2 && $item['expire'] > time()) {
                $is_month = 2;
            }
            if($item['is_week'] == 2 && $item['expire'] > time()) {
                $is_week = 2;
            }
        }
        $expire = 0;
        $sn = 0;
        if($pay) {
            $expire = $pay[0]['expire'];
            $sn = $pay[0]['order_sn'];
        }
        return ['vid' => array_column($pay, 'vid') ,'sn'=>$sn, 'is_date' => $is_date ,'is_week' => $is_week, 'is_month' => $is_month ,'expire' => $expire];
    }
    protected function getDomain($type = 1,$path="")
    {
        $url = "";
        $uid = $this->id;
        $sid = $uid;
        $pinfo = get_user($uid);
        if ($pinfo['pid'] > 0) {
            $sid = $pinfo['pid_top'];
        }
        if (!empty($pinfo['wx_check_api'])) {
            $fangfeng_url = $pinfo['wx_check_api'];
        } else {
            $fangfeng_url = get_user($sid, 'wx_check_api');
        }
        if ($fangfeng_url) {
            $url = $fangfeng_url."?path=".$path."&";
        } else {
            $domain = trim(getDomain($type));
            if ($domain) {
                $hezi_url = $domain;
                $url = $hezi_url."?".$path;
            } else {
                $url = '需要添加主域名才能生成盒子链接';
            }
        }
        return trim($url);
       // return getDomain($type);
    }
    
    protected function is_wxBrowers()
    {
     	$str=strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger');
     	if($str!==false)
     	{
    		return true; //微信浏览器
     	}
    	return false; //非微信浏览器
    }
}
