<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 提现明细
 *
 * @icon fa fa-circle-o
 */
class Cash extends Backend
{
    
    /**
     * Cash模型对象
     * @var \app\admin\model\Cash
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Cash;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("typeList", $this->model->getTypeList());

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
        $this->assign('is_admin' , (Int) $this->auth->isSuperAdmin());
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams(null , null , false);
            $field = $this->auth->isSuperAdmin() ? "pid" : "uid";
            $total = $this->model
                    ->with(['admin'])
                    ->where($where)
                ->where(["ds_cash_addvance.{$field}" => $this->auth->id])
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['admin'])
                ->where(["ds_cash_addvance.$field" => $this->auth->id])

                ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();


            $list = collection($list)->toArray();
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
        if ($this->request->isPost()) {

            $no = (new \app\admin\model\Cash())->where(['uid' => $this->auth->id])->whereRaw('status = 1')->find();
            if($no)
            {
                return $this->error("已经有一单正在审批,切勿重复提交申请!");
            }
            $params = $this->request->post("row/a");
            $this->token();
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $user = get_user($this->auth->id);
        //余额
        $balance = $user['balance'];
        //提现手续费
        $poundage = $user['poundage'];
        //手续费
        $shouxufei = $balance * (30 / 100);
        $this->assign('user',$user);
        $this->assign('shouxufei' , $shouxufei);
        $this->assign('balance',$balance);
        $this->assign('poundage' , $poundage);
        $this->assign('money' , $balance - $shouxufei);
        return $this->view->fetch();
    }

    /**
     * 提现审批
     */
    public function approval()
    {
        $id = $this->request->param('id');
        $flg = $this->request->param('flg');
        $info = (new \app\admin\model\Cash())->find($id);
        if($info['status'] == 4)
        {
            return $this->success("该申请已经打款!切勿重复提交");
        }
        if($info['status'] == 4 && $flg == "tongguo")
        {
            return $this->success("该申请已经打款!状态以不能更改");
        }
        $map = [
            'tongguo' => 3,
            'dakuan' => 4,
        ];
        $res = (new \app\admin\model\Cash())->where(['id' => $id])->Update([
            'status' => $map[$flg],
            'edit_time' => time()
        ]);
        if($res)
        {
            $m = ['tongguo' => '不通过标记成功' , 'dakuan' => '打款标记成功'];
            if($map[$flg] == 4)
            {
                Admin::jmoney($info['blance'] , $info['uid'] , '提现支出');
            }
            return $this->success($m[$flg]);
        }
        return $this->error('error');
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
}
