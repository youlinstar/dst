<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Payset;
use app\common\controller\Backend;
use think\response\Json;

/**
 * 支付记录
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    
    /**
     * Order模型对象
     * @var \app\admin\model\Order
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Order;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("isKouliangList", $this->model->getIsKouliangList());
        $this->view->assign("isMonthList", $this->model->getIsMonthList());
        $this->view->assign("isDateList", $this->model->getIsDateList());

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
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams(null , null , !$this->auth->isSuperAdmin());

            if($this->auth->isSuperAdmin())
            {
                $total = $this->model
                    ->where($where)
                    //->where(['status' => 1])
                    ->order($sort, $order)
                    ->count();

                $list = $this->model
                    ->where($where)
                    //->where(['status' => 1])
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            }
            else
            {
                $total = $this->model
                    ->where($where)
                    ->Where(['is_kouliang' => 1])
                    //->where(['status' => 1])
                    ->order($sort, $order)
                    ->count();

                $list = $this->model
                    ->where($where)
                    ->Where(['is_kouliang' => 1])
                    //->where(['status' => 1])
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            }


            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        $userInfo = array_column(Admin::all(['status' => 'normal']) , 'username' , 'id');
        $this->assign('userInfo',$userInfo);
        $this->assign('is_admin' , (Int) $this->auth->isSuperAdmin());
        $this->assign('pay_info' ,Payset::all());
        return $this->view->fetch();
    }

    public function getOrderCount()
    {
        $userId = $this->auth->id;
        $redis = redisInstance()->handler();
        $date = date('Y-m-d');
        $orderKey = ["order_{$userId}_".$date];
        $successOrderKey = ["success_order_{$userId}_{$date}"];
        $hour = date('H',time());
        $hourKey = ["hour_access_{$userId}_{$date}_{$hour}"];
        if($this->auth->isSuperAdmin())
        {
            $orderKey = $redis->keys("order_*_{$date}");
            $successOrderKey = $redis->keys("success_order_*_{$date}");
            $hourKey = $redis->keys("hour_access_*_{$date}_{$hour}");
        }
        $endTime  = time();
        $startTime = $endTime - 3;
        $orderCount = [];
        $successOrderCount = [];
        foreach ($orderKey as $orderKeyItem)
        {
            //总订单数
            $orderCount[] = $redis->ZCOUNT($orderKeyItem , $startTime , $endTime);
        }
        foreach ($successOrderKey as $successKeyItem)
        {
            $successOrderCount[] = $redis->ZCOUNT($successKeyItem , $startTime , $endTime);
        }
        $hour = array_sum((array)$redis->mget($hourKey));


        //$hour = rand(2,30);


        return json([
            'createdata' => array_sum((array) $orderCount),//下单数
            'paydata' => array_sum((array) $successOrderCount),
            'failure' => rand(0,2),
            'hour' => $hour,
            'hour_key' => date('H:i:s',time())
        ]);
    }

    public function access()
    {
        $date = date('Y-m-d');
        $yesterdayDate = date("Y-m-d",strtotime("-1 day"));
        $redis = redisInstance()->handler();
        $m = date('H');
        $dateHourKey = "hour_access_".$this->auth->id."_$m";
        $yesterdayDateKey = "access_".$this->auth->id."_{$yesterdayDate}";
        if($this->auth->isSuperAdmin())
        {
            $yesterdayDateKey = $redis->keys("access_*_{$yesterdayDate}");
            $DateKey = $redis->keys("access_*_{$date}");
            $dateHourKey = $redis->keys("hour_access_*_$m");
        }
        //昨日总数
        $yesterdayDateCount = array_sum((array)$redis->mget($yesterdayDateKey));
        //今日实时总数
        $dateCount = array_sum((array)$redis->mget($DateKey));
        //今日按小时候总数
        $dateHourCount = array_sum((array)$redis->mget($dateHourKey));
        return json(['code' => 0 , 'data' => [
            'yesterdayDateCount' => $yesterdayDateCount,
            'dateCount' => $dateCount,
            'dateHourCount' =>$dateHourCount,
            'column' => $m
        ]]);
    }

}
