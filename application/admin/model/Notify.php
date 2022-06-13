<?php

namespace app\admin\model;

use think\Model;


class Notify extends Model
{

    

    

    // 表名
    protected $name = 'notify';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'is_show_text'
    ];
    

    
    public function getIsShowList()
    {
        return ['1' => __('Is_show 1'), '2' => __('Is_show 2')];
    }


    public function getIsShowTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_show']) ? $data['is_show'] : '');
        $list = $this->getIsShowList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
