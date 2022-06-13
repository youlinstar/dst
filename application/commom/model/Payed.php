<?php

namespace app\commom\model;

use think\Model;

class Payed extends Model
{
    // 表名
    protected $name = 'payed_show';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
}
