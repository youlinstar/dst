<?php
/**
 * LinkTop
 * @project 111
 * @copyright
 * @author
 * @version
 * @createTime 19:16
 * @filename LinkTop.php
 * @product_name PhpStorm
 * @link
 * @example
 */

namespace app\admin\model;

use think\Model;

class LinkTop extends Model
{
// 表名
    protected $name = 'link_top';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;
}