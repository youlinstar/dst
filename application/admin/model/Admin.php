<?php

namespace app\admin\model;

use app\common\model\MoneyLog;
use think\Model;
use think\Session;

class Admin extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * 重置用户密码
     * @author baiyouwen
     */
    public function resetPassword($uid, $NewPassword)
    {
        $passwd = $this->encryptPassword($NewPassword);
        $ret = $this->where(['id' => $uid])->update(['password' => $passwd]);
        return $ret;
    }


    public static function money($money, $user_id, $memo)
    {
        $user = self::get($user_id);
        if ($user && $money != 0) {
            $before = $user->balance;
            $after = $user->balance + $money;
            //更新会员信息
            $user->save(['balance' => $after]);
            //写入日志
            MoneyLog::create(['uid' => $user_id, 'type' => 1,'money' => $money, 'before' => $before, 'after' => $after, 'memo' => $memo]);
        }
    }

    public static function jmoney($money, $user_id, $memo)
    {
        $user = self::get($user_id);
        if ($user && $money != 0) {
            $before = $user->balance;
            $after = $user->balance - $money;
            //更新会员信息
            $user->save(['balance' => $after]);
            //写入日志
            MoneyLog::create(['uid' => $user_id, 'type' => 2 , 'money' => $money, 'before' => $before, 'after' => $after, 'memo' => $memo]);
        }
    }

    public static function getUser($id)
    {
        $user = self::find($id);
        if(empty($user))
        {
            exit("账号不存在.或者已删除");
        }

        return self::find($id)->toArray();
    }

    // 密码加密
    protected function encryptPassword($password, $salt = '', $encrypt = 'md5')
    {
        return $encrypt($password . $salt);
    }

}
