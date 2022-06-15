<?php

namespace app\admin\controller\general;

use app\admin\model\Admin;
use app\common\controller\Backend;
use fast\Random;
use think\Request;
use think\Session;
use think\Validate;

/**
 * 个人配置
 *
 * @icon fa fa-user
 */
class Profile extends Backend
{

    public function __construct(Request $request = null)
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
        //设置过滤方法
        $this->request->filter(['strip_tags']);

        $pay = array_column(db('pay_setting')->select() , 'title' , 'model');
        $short = array_column(array_filter(config('short')) , 'title' , 'model');

        $jiance = [
            '-' => '--请选择--',
            'wechat' => '微信',
            'qq' => 'QQ',
            'douyin' => '抖音',
            'all'=>'全部检测',
        ];
        array_unshift($pay,'--请选择--');
        $this->assign('is_admin',$this->auth->isSuperAdmin());
        $this->assign('jiance' , $jiance);
        $this->assign('pay',$pay);
        $this->assign('short',$short);
        $check_url = $this->request->scheme()."://".$this->request->host().'/api/index/jiance';
        $check_url1 = $this->request->scheme()."://".$this->request->host().'/api/index/domain';
        $this->assign('check_url' , $check_url);
        $this->assign('check_url1' , $check_url1);
        if ($this->request->isAjax()) {
            $model = model('AdminLog');
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $model
                ->where($where)
                ->where('admin_id', $this->auth->id)
                ->order($sort, $order)
                ->count();

            $list = $model
                ->where($where)
                ->where('admin_id', $this->auth->id)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 更新个人信息
     */
    public function update()
    {
        if ($this->request->isPost()) {
            //$this->token();
            $params = $this->request->post("row/a");

            if($this->auth->isSuperAdmin())
            {
                $param = array('email',
                    'nickname',
                    'password',
                    'avatar',
                    'qq',
                    'kouliang',
                    'poundage',
                    'min_fee',
                    'min_publish',
                    'jiance',
                    'jiance_token',
                    'wx_check_api',
                    'pay_model',
                    'pay_model1',
                    'short'
                );
            }
            else
            {
                $param = ['nickname',
                    'email',
                    'password',
                    'avatar',
                    'qq','short'];
            }

            $params = array_intersect_key(
                $params,
                array_flip($param)
            );
            //修改全局手续费
            if(isset($params['poundage']))
            {
              //  (new Admin())->whereRaw(' 1=1')->update(['poundage' => $params['poundage']]);
            }
            //修改全局最小提现费用
            if(isset($params['min_fee']))
            {
                (new Admin())->whereRaw(' 1=1')->update(['min_fee' => $params['min_fee']]);
            }
            //修改全局支付类型
            if(isset($params['pay_model']))
            {
                //(new Admin())->whereRaw(' 1=1')->update(['pay_model' => $params['pay_model']]);
            }
            
            
            if(empty($params['password']))
            {
                unset($params['password']);
            }
            unset($v);
            /*if (!Validate::is($params['email'], "email")) {
                $this->error(__("Please input correct email"));
            }*/
            if (isset($params['password']) && !empty($params['password'])) {
                if (!Validate::is($params['password'], "/^[\S]{6,16}$/")) {
                    $this->error(__("Please input correct password"));
                }
                $params['salt'] = Random::alnum();
                $params['password'] = md5(md5($params['password']) . $params['salt']);
            }
            /* $exist = Admin::where('email', $params['email'])->where('id', '<>', $this->auth->id)->find();
             if ($exist) {
                 $this->error(__("Email already exists"));
             }*/
            if ($params) {
                $admin = Admin::get($this->auth->id);
                $admin->save($params);
                //因为个人资料面板读取的Session显示，修改自己资料后同时更新Session
                Session::set("admin", $admin->toArray());
                $this->success();
            }
            $this->error();
        }
        return;
    }
}
