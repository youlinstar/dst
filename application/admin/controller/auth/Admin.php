<?php

namespace app\admin\controller\auth;

use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\Money;
use app\admin\model\Payset;
use app\common\controller\Backend;
use fast\Random;
use fast\Tree;
use think\Validate;
use function fast\array_get;

/**
 * 管理员管理
 *
 * @icon fa fa-users
 * @remark 一个管理员可以有多个角色组,左侧的菜单根据管理员所拥有的权限进行生成
 */
class Admin extends Backend
{

    /**
     * @var \app\admin\model\Admin
     */
    protected $model = null;
    protected $childrenGroupIds = [];
    protected $childrenAdminIds = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Admin');

        $this->childrenAdminIds = $this->auth->getChildrenAdminIds(true);
        $this->childrenGroupIds = $this->auth->getChildrenGroupIds(true);

        $groupList = collection(AuthGroup::where('id', 'in', $this->childrenGroupIds)->select())->toArray();

        Tree::instance()->init($groupList);
        $groupdata = [];
        if ($this->auth->isSuperAdmin()) {
            $result = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0));
            foreach ($result as $k => $v) {
                $groupdata[$v['id']] = $v['name'];
            }
        } else {
            $result = [];
            $groups = $this->auth->getGroups();
            foreach ($groups as $m => $n) {
                /*$childlist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray($n['id']));
                $temp = [];
                foreach ($childlist as $k => $v) {
                    $temp[$v['id']] = $v['name'];
                }*/
                //$result[__($n['name'])] = $temp;
                $groupdata[$n['id']] = $n['name'];
            }
            //$groupdata = $result;
        }

        $this->view->assign('groupdata', $groupdata);
        $this->assignconfig("admin", ['id' => $this->auth->id]);

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
        $short = array_filter(config('SHORT'));

        $this->assign('short',$short);
        $this->assign('pay_info' ,Payset::all());

        $this->assign('admin_info', get_user(1));
        $this->assign('is_admin', $this->auth->isSuperAdmin());
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            $childrenGroupIds = $this->childrenGroupIds;
            $groupName = AuthGroup::where('id', 'in', $childrenGroupIds)
                ->column('id,name');
            $authGroupList = AuthGroupAccess::where('group_id', 'in', $childrenGroupIds)
                ->field('uid,group_id')
                ->select();

            $adminGroupName = [];
            foreach ($authGroupList as $k => $v) {
                if (isset($groupName[$v['group_id']])) {
                    $adminGroupName[$v['uid']][$v['group_id']] = $groupName[$v['group_id']];
                }
            }
            $groups = $this->auth->getGroups();
            foreach ($groups as $m => $n) {
                $adminGroupName[$this->auth->id][$n['id']] = $n['name'];
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order);
            //->count();

            if (!$this->auth->isSuperAdmin()) {
                $total = $total->where('pid', 'in', $this->auth->id)->count();
            } else {
                $total = $total->where('id', 'in', $this->childrenAdminIds)
                    ->count();
            }

            $list = $this->model
                ->where($where)
                ->field(['password', 'salt', 'token'], true)
                ->order($sort, $order)
                ->limit($offset, $limit);
            //->select();
            if (!$this->auth->isSuperAdmin()) {
                $list = $list->where('pid', 'in', $this->auth->id)->select();
            } else {
                $list = $list->where('id', 'in', $this->childrenAdminIds)->select();
            }

            $pid = array_column($list, 'pid');
            $pidInfo = $this->model->whereIn('id', $pid)->select();

            $uid = array_column($list, 'id');
            $todayMoney = (new Money())
                ->field('id,uid,sum(money) as money')
                ->whereTime('createtime', 'today')
                ->whereIn('uid', $uid)
                ->where(['type' => 1])
                ->group('uid')->select();


            $yesterdayMoney = (new Money())
                ->field('id,uid,sum(money) as money')
                ->whereTime('createtime', 'yesterday')
                ->whereIn('uid', $uid)
                ->where(['type' => 1])
                ->group('uid')->select();

            $todayMoney = array_column($todayMoney, 'money', 'uid');
            $yesterdayMoney = array_column($yesterdayMoney, 'money', 'uid');
            $pidInfo = array_column($pidInfo, 'username', 'id');
            foreach ($list as $k => &$v) {
                $groups = isset($adminGroupName[$v['id']]) ? $adminGroupName[$v['id']] : [];
                $v['groups'] = implode(',', array_keys($groups));
                $v['groups_text'] = implode(',', array_values($groups));
                $v['pid_name'] = isset($pidInfo[$v['pid']]) ? $pidInfo[$v['pid']] : "";
                if (isset($todayMoney[$v['id']])) {
                    $v['day_income'] = $todayMoney[$v['id']];
                }
                if (isset($yesterdayMoney[$v['id']])) {
                    $v['yes_income'] = $yesterdayMoney[$v['id']];
                }
            }
            unset($v);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        $user = get_user($this->auth->id);

        $pay = array_column(db('pay_setting')->select() , 'title' , 'model');
        $short = array_column(array_filter(config('short')) , 'title' , 'model');
        $this->assign('pay' , $pay);
        $this->assign('short' , $short);
        if ($this->request->isPost()) {
            //$this->token();
            $u = $this->getParent();
            if (count($u) == 4 && config('site.daili_model') == 0)
            {
                return $this->error('管理员未开启无限分销功能，三级代理不允许添加代理!');
            }
            $params = $this->request->post();
            if ($params) {
                if (!Validate::is($params['password'], '\S{6,16}')) {
                    $this->error(__("Please input correct password"));
                }
                $params['pwd'] = $params['password'];
                $params['salt'] = Random::alnum();
                $params['password'] = md5(md5($params['password']) . $params['salt']);
                $params['avatar'] = '/assets/img/avatar.png'; //设置新管理员默认头像。
                $params['pid'] = $this->auth->id;
                $params['nickname'] = $params['username'];

                if($params['ticheng'] < $user['ticheng'])
                {
                    //return $this->error("抽成比例必须大于上级比例！（要返佣给上级）您的最低比例为【{$user['ticheng']}】");
                }

                unset($params['group'], $params['__token__']);
                $result = $this->model->save($params);
                if ($result === false) {
                    $this->error($this->model->getError());
                }
                $group = $this->request->post('group/a');

                //过滤不允许的组别,避免越权
                $group = array_intersect($this->childrenGroupIds, $group);
                $dataset = [];
                foreach ($group as $value) {
                    $dataset[] = ['uid' => $this->model->id, 'group_id' => $value];
                }
                model('AuthGroupAccess')->saveAll($dataset);
                $this->success();
            }
            $this->error();
        }
        return $this->view->fetch();
    }


    protected function getParent()
    {
        $parentInfo = (new \app\admin\model\Admin())->query("SELECT T2.id,T2.pid,T2.username,T2.ticheng
FROM ( 
    SELECT 
        @r AS _id, 
        (SELECT @r := pid FROM ds_admin WHERE id = _id) AS pid, 
        @l := @l + 1 AS lvl 
    FROM 
        (SELECT @r := {$this->auth->id}, @l := 0) vars, 
        ds_admin h 
    WHERE @r <> 0) T1 
JOIN ds_admin T2 
ON T1._id = T2.id 
ORDER BY T1.lvl asc;");


        return $parentInfo;
    }
    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $pay = array_column(db('pay_setting')->select() , 'title' , 'model');
        $short = array_column(array_filter(config('short')) , 'title' , 'model');
        $this->assign('pay' , $pay);
        $this->assign('short' , $short);
        //判断编辑账号是否是自己的下级
        $daili = get_user($ids ,'pid');
        if($this->auth->id != 1)
        {
            if($daili != $this->auth->id)
            {
                return $this->error('error 禁止越权操作!');
            }
        }
        if($this->request->isAjax() && $this->request->param('row.update'))
        {
            $row = $this->request->param('row/a');
            unset($row['update']);
            \app\admin\model\Admin::update($row , ['id' => $ids]);
            return $this->success('修改成功!');
        }
        $this->assign('is_admin', $this->auth->isSuperAdmin());
        $user = get_user($ids);
        if($user['pid'] != 0)
        {
            $user = get_user($user['pid']);
        }
        $this->assign('admins'  , $user);
        $row = $this->model->get(['id' => $ids]);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $childrenGroupIds = $this->childrenGroupIds;
        $authGroupList = AuthGroupAccess::where('group_id', 'in', $childrenGroupIds)
            ->field('uid,group_id')
            ->select();
        if (!in_array($row->id, array_column($authGroupList, 'uid'))) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isPost()) {
            //$this->token();
            $params = $this->request->post("row/a");
            if ($params)
            {
                //查找当前账号下级最大提成
                $xjTicheng = db('admin')->where(['pid' => $this->auth->id])->order('ticheng','desc')->find();
                if($xjTicheng && $params['ticheng'] > array_get($xjTicheng ,'ticheng' , 0))
                {
                    $xj = array_get($xjTicheng ,'ticheng' , 0);
                    //return $this->error("请合理设置抽成比例！开通代理后不能增加比例！只能减少。最低可设置【{$xj}%】以下!");
                }
                if($params['ticheng'] < $user['ticheng'])
                {
                    // return $this->error("抽成比例必须大于上级比例！（要返佣给上级）");
                }
                if ($params['password'])
                {
                    if (!Validate::is($params['password'], '\S{6,16}'))
                    {
                        $this->error(__("Please input correct password"));
                    }
                    $params['pwd'] = $params['password'];
                    $params['salt'] = Random::alnum();
                    $params['password'] = md5(md5($params['password']) . $params['salt']);
                } else {
                    unset($params['password'], $params['salt']);
                }
                //这里需要针对username和email做唯一验证
                $adminValidate = \think\Loader::validate('Admin');
                $adminValidate->rule([
                    'username' => 'require|unique:admin,username,' . $row->id,
                    'email' => 'require|email|unique:admin,email,' . $row->id,
                    'password' => 'regex:\S{32}',
                ]);
                $result = $row->validate('Admin.edit')->save($params);
                if ($result === false) {
                    $this->error($row->getError());
                }

                // 先移除所有权限
                model('AuthGroupAccess')->where('uid', $row->id)->delete();

                $group = $this->request->post("group/a");

                // 过滤不允许的组别,避免越权
                $group = array_intersect($this->childrenGroupIds, $group);

                $dataset = [];
                foreach ($group as $value) {
                    $dataset[] = ['uid' => $row->id, 'group_id' => $value];
                }
                model('AuthGroupAccess')->saveAll($dataset);
                $this->success();
            }
            $this->error();
        }
        $grouplist = $this->auth->getGroups($row['id']);
        $groupids = [];
        foreach ($grouplist as $k => $v) {
            $groupids[] = $v['id'];
        }
        $this->view->assign("row", $row);
        $this->view->assign("groupids", $groupids);
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            //$ids = array_intersect($this->childrenAdminIds, array_filter(explode(',', $ids)));
            // 避免越权删除管理员
            
            
            if($this->auth->id != 1)
            {
                if($daili != $this->auth->id)
                {
                 return $this->error('error 禁止越权操作!');
                }
            }
            
        
            $childrenGroupIds = $this->childrenGroupIds;
            $adminList = $this->model->where('id', 'in', [$ids])->select();
            if ($adminList) {
                $deleteIds = [];
                foreach ($adminList as $k => $v) {
                    $deleteIds[] = $v->id;
                }
                $deleteIds = array_values(array_diff($deleteIds, [$this->auth->id]));
                if ($deleteIds) {
                    $this->model->destroy($deleteIds);
                    model('AuthGroupAccess')->where('uid', 'in', $deleteIds)->delete();
                    $this->success();
                }
            }
        }
        $this->error(__('You have no permission'));
    }

    /**
     * 批量更新
     * @internal
     */
    public function multi($ids = "")
    {
        // 管理员禁止批量操作
        $this->error();
    }

    /**
     * 下拉搜索
     */
    public function selectpage()
    {
        $this->dataLimit = 'auth';
        $this->dataLimitField = 'id';
        return parent::selectpage();
    }
}
