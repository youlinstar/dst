<?php

namespace app\admin\controller;

use app\admin\controller\auth\Admin;
use app\common\controller\Backend;
use app\common\library\token\driver\Redis;
use app\common\model\MoneyLog;
use think\Config;
use think\Request;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $sign = $this->psign();
        $key = "ds_3wo#cao3ni2ma/s678ghsdkf/07/20/!@#$!#%@A/SD##!@**@!_+@";
        $signs = md5($key.$sign['time']);
        if($signs != $sign['sign'])
        {
            exit("兄弟你想干嘛?替换文件是不行的.....QQ:1214014194");
        }
    }

    public static function sign()
    {
        $key = "ds_3wo#cao3ni2ma/bi_2020/07/20/!@#$!#%@A/SD##!@**@!_+@";

        $time = time();
        return [
            'time' => $time,
            'sign' => md5($key.$time)
        ];
    }
    /**
     * 查看
     */
    public function index()
    {

        $notify = db('notify')->where(['uid' => 1 , 'is_show' => 1])->order('createtime','desc')->select();
        $this->view->assign('notify' ,$notify);
        $ajax = $this->request->param('ajax',0);

        $toDayTime = strtotime(date('Y-m-d') . "00:00:00");
        $toDayEndTime = strtotime(date('Y-m-d') . "23:59:59");
        $yesterdayDate = $toDayTime - 86400;
        $yesterdayEndTime = $toDayEndTime - 86400;
        $yesDate = date('Y-m-d' ,$yesterdayDate );
        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];

        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');
        $uid = $this->auth->id;
        $date = date('Y-m-d');
        $redis = redisInstance()->handler();
        //总访问数
        $accessKey = "access_{$this->auth->id}_*";
        $orderCount = 0;
        $money = 0;
        $toDayMoney = 0;
        $yesterdayMoney = 0;
        $todayUserAccessCount = 0;
        $toDayOrder = 0;
        $toDaySuccessOrder = 0;
        $toDayFailureOrder = 0;
        $toDayKouliang = 0;
        $toDayKouliangMoney = 0;
        $hour = $this->getHour();
        if($this->auth->isSuperAdmin())
        {

            for ($i = 0; $i < 7; $i++)
            {
                $day = date("Y-m-d", $seventtime + ($i * 86400));
                $createlist[$day] = 0;
                $n = [];
                $create = [];
                $orderEveryDayKey = $redis->keys("success_order_*_{$day}");
                $orderEveryDayCreateKey = $redis->keys("order_*_{$day}");
                $paylist[$day] = 0;

                if(!empty($orderEveryDayKey))
                {
                    foreach ($orderEveryDayKey as $keys)
                    {
                        $n[] = $redis->zcard($keys);
                    }
                    $paylist[$day] = array_sum($n);
                }
                if(!empty($orderEveryDayCreateKey))
                {
                    foreach ($orderEveryDayCreateKey as $ckeys)
                    {
                        $create[] = $redis->zcard($ckeys);
                    }
                    $createlist[$day] = array_sum($create);
                }

            }


            $accessKey = $redis->keys("access_*");
            $orderCount = (new \app\admin\model\Order())->where(['status' => 1])->count();
            $money = (new \app\admin\model\Admin())->where(['status' => 'normal'])->sum('balance');
            //今日收入
            $toDayMoney = (new MoneyLog())
                ->where('createtime','>=' , $toDayTime)
                ->where('createtime' ,'<=' , $toDayEndTime)
                ->where('type','=',1)
                ->field('money')->select();
            $toDayMoney = array_sum(array_column($toDayMoney , 'money'));
            //昨日收入
            $yesterdayMoney = (new MoneyLog())
                ->where('createtime','>=' , $yesterdayDate)
                ->where('createtime' ,'<=' , $yesterdayEndTime)
                ->where('type','=',1)
                ->field('money')->select();
            $yesterdayMoney = array_sum(array_column($yesterdayMoney , 'money'));
            //今日访问
            $toDayAccessKey = $redis->keys("access_*_{$date}_*");
            //昨日访问
            $yesterdayAccessKey = $redis->keys("access_*_{$yesDate}_*");
            //今日总订单
            $toDayOrder = (new \app\admin\model\Order())
                ->where('createtime' , '>=' , $toDayTime)
                ->where('createtime','<=',$toDayEndTime)
                ->count();
            //今日成交订单
            $toDaySuccessOrder = (new \app\admin\model\Order())
                ->where('status' , '=' , '1')
                ->where('createtime' , '>=' , $toDayTime)
                ->where('createtime','<=',$toDayEndTime)
                ->count();
            //今日扣量
            $toDayKouliang = (new \app\admin\model\Order())
                ->where('is_kouliang' , '=' , '2')
                ->where('createtime' , '>=' , $toDayTime)
                ->where('createtime','<=',$toDayEndTime)
                ->count();
            //今日扣量金额
            $toDayKouliangMoney = (new \app\admin\model\Order())
                ->where('is_kouliang' , '=' , '2')
                ->where('createtime' , '>=' , $toDayTime)
                ->where('createtime','<=',$toDayEndTime)
                ->sum('price');
        }
        else
        {
            
            for ($i = 0; $i < 7; $i++)
            {
                $day = date("Y-m-d", $seventtime + ($i * 86400));
                $createlist[$day] = 0;
                $n = [];
                $create = [];
                $orderEveryDayKey = $redis->keys("success_order_*_{$day}");
                $orderEveryDayCreateKey = $redis->keys("order_{$uid}_{$day}");
                $paylist[$day] = 0;

                if(!empty($orderEveryDayKey))
                {
                    foreach ($orderEveryDayKey as $keys)
                    {
                        $n[] = $redis->zcard($keys);
                    }
                    $paylist[$day] = array_sum($n);
                }

                if(!empty($orderEveryDayCreateKey))
                {
                    foreach ($orderEveryDayCreateKey as $ckeys)
                    {
                        $create[] = $redis->zcard($ckeys);
                    }
                    $createlist[$day] = array_sum($create);
                }
            }
            $accessKey = $redis->keys("access_{$uid}_*");
            $orderCount = (new \app\admin\model\Order())->where(['status' => 1 ,'is_kouliang' => '1', 'uid' => $this->auth->id])->count();
            $money = (new \app\admin\model\Admin())->field('balance')->find($this->auth->id)->balance;
            //今日收入
            $toDayMoney = (new MoneyLog())
                ->where('uid' , '=' , $this->auth->id)
                ->where('createtime','>=' , $toDayTime)
                ->where('createtime' ,'<=' , $toDayEndTime)
                ->where('type','=',1)
                ->field('money')->select();
            $toDayMoney = array_sum(array_column($toDayMoney , 'money'));
            //昨日收入
            $yesterdayMoney = (new MoneyLog())
                ->where('uid' , '=' , $this->auth->id)
                ->where('createtime','>=' , $yesterdayDate)
                ->where('createtime' ,'<=' , $yesterdayEndTime)
                ->where('type','=',1)
                ->field('money')->select();
            $yesterdayMoney = array_sum(array_column($yesterdayMoney , 'money'));
            //今日访问
            $toDayAccessKey = $redis->keys("access_{$uid}_{$date}_*");
            //昨日访问
            $yesterdayAccessKey = $redis->keys("access_$uid}_{$yesDate}_*");
            //今日总订单
            $toDayOrder = (new \app\admin\model\Order())
                ->where('uid' , '=' , $uid)
                ->where('createtime' , '>=' , $toDayTime)
                ->where('createtime','<=',$toDayEndTime)
                ->where('is_kouliang' , '=' , '1')
                ->count();
            //今日成交订单
            $toDaySuccessOrder = (new \app\admin\model\Order())
                ->where('uid' , '=' , $uid)
                ->where('status' , '=' , '1')
                ->where('createtime' , '>=' , $toDayTime)
                ->where('createtime','<=',$toDayEndTime)
                ->where('is_kouliang' , '=' , '1')

                ->count();
        }
        //总访问
        $accessCount = array_sum((array)$redis->mget($accessKey));
        //今日访问
        $todayUserAccessCount = array_sum((array) $redis->mget($toDayAccessKey));
        //昨日访问
        $yesterdayAccessCount = array_sum((array) $redis->mget($yesterdayAccessKey));
        //今日未成交订单
        $toDayFailureOrder = $toDayOrder - $toDaySuccessOrder;

        $totla = [
            'totaluser' => 1,
            'toDayMoney'        => $toDayMoney, //今日收入
            'yesterdayMoney'    => $yesterdayMoney,
            'totalviews'       => $accessCount,
            'totalorder'       => $orderCount,
            'totalorderamount' => $money, //每小时实时收入
            'todayuserlogin'   => 321,
            'todayUserAccessCount'  => $todayUserAccessCount, //今日访问
            'yesterdayAccessCount' => $yesterdayAccessCount,//昨日访问
            'toDayOrder'       => $toDayOrder,
            'toDaySuccessOrder' => $toDaySuccessOrder,
            'toDayFailureOrder' => $toDayFailureOrder,
            'toDayKouliang' => $toDayKouliang,
            'toDayKouliangMoney' => $toDayKouliangMoney,
            'unsettleorder'    => 132,
            'sevendnu'         => '80%',
            'sevendau'         => '32%',
            'paylist'          => $paylist, //订单数
            'createlist'       => $createlist, //创建订单数
            'addonversion'       => $addonVersion,
            'uploadmode'       => $uploadmode,
            'hour' => $hour,
            'hour_key' => array_keys($hour)
        ];
        //dump($totla);die;
        if($ajax)
        {
            return json(['data' =>$totla ]);
        }
        //总订单数
        $this->view->assign($totla);



        return $this->view->fetch();
    }

    protected function getHour()
    {
        $redis = redisInstance()->handler();
        $h = date('H',time());
        $hour = [];
        $user_id = $this->auth->id;
        $date = date('Y-m-d',time());

        for ($i =0; $i<= $h;$i++)
        {
            $total = 0;
            $index= $i;

            if($i < 10)
            {
                $index = "0".$i;
            }
            if($this->auth->isSuperAdmin())
            {
                $key = "hour_access_*_{$date}_{$index}";
                $key = $redis->keys($key);
                $total = array_sum((array)$redis->mget($key));
                $hour[$index] = $total;
            }
            else
            {
                $key = "hour_access_{$user_id}_{$date}_{$index}";
                $total = $redis->get($key);
                $hour[$index] = $total ? $total : 0;
            }
        }
        return $hour;
    }

}
