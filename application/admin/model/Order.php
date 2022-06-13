<?php

namespace app\admin\model;

use think\Model;


class Order extends Model
{

    

    

    // 表名
    protected $name = 'pay_order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text',
        'is_kouliang_text',
        'is_month_text',
        'is_date_text'
    ];
    

    public static function getOrderInfo($order)
    {
        return self::where(['transact' => $order])->find();
    }
    public function getStatusList()
    {
        return ['1' => __('Status 1'), '2' => __('Status 2')];
    }

    public function getIsKouliangList()
    {
        return ['1' => __('Is_kouliang 1'), '2' => __('Is_kouliang 2')];
    }

    public function getIsMonthList()
    {
        return ['1' => __('Is_month 1'), '2' => __('Is_month 2')];
    }

    public function getIsDateList()
    {
        return ['1' => __('Is_date 1'), '2' => __('Is_date 2')];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsKouliangTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_kouliang']) ? $data['is_kouliang'] : '');
        $list = $this->getIsKouliangList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsMonthTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_month']) ? $data['is_month'] : '');
        $list = $this->getIsMonthList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsDateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_date']) ? $data['is_date'] : '');
        $list = $this->getIsDateList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
