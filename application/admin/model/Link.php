<?php

namespace app\admin\model;

use think\Model;


class Link extends Model
{

    

    

    // 表名
    protected $name = 'link';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'input_time_text'
    ];
    

    


    public static function getLink($id)
    {
        return self::find($id);
    }
    public function getInputTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['input_time']) ? $data['input_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setInputTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }



    public function category()
    {
        return $this->belongsTo('Category', 'cid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
