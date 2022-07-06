<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\response\Json;
use think\Db;
/**
 * 域名库
 *
 * @icon fa fa-circle-o
 */
class Domain extends Backend
{

    /**
     * Domain模型对象
     * @var \app\admin\model\Domain
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->request->filter('trim');

        $this->model = new \app\admin\model\Domain;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function deleteList()
    {
        $data = $this->model
            ->where('status',0)
            ->delete();
        return Json($data);
    }
    public function add()
    {
     
        if ($this->request->isPost()) {
            $params = $this->request->post();
            if($params) {
                $key_arr = explode(PHP_EOL,$params["row"]["domain"]);
                Db::startTrans();
                foreach ($key_arr as $k=>$v)
                {
                    $post = array(
                        'domain'=>str_replace(array("\r\n", "\r", "\n"), "", $v),
                        'status'=>$params["row"]['status'],
                        'type'=>$params["row"]['type'],
                    );

                    $r = $k+1;
                    //验证
                    $result = $this->validate($post,[
                        //['domain|第'.$r.'行域名','require|length:5,150|unique:domain'],
                    ]);

                    if (true !== $result) {
                        Db::rollback();
                        $this->error($result);
                    }else{
                         $this->model->create($post);
                    }
                }
                Db::commit();
                $this->success('添加成功');
            }

        }
        return $this->view->fetch();
    }
}
