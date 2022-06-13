<?php

namespace app\admin\model;

use think\Model;


class Payset extends Model
{

    

    

    // 表名
    protected $name = 'pay_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text'
    ];
    

    public static function getPayInfo($flg = null)
    {
        return self::where(['model' => $flg])->find();
    }
    public function getStatusList()
    {
        return ['2' => __('Status 2'), '1' => __('Status 1')];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
