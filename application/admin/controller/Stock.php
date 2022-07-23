<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Category;
use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;
use function fast\array_get;
use think\Config;

/**
 * 公共片库
 *
 * @icon fa fa-circle-o
 */
class Stock extends Backend
{
    
    /**
     * Stock模型对象
     * @var \app\admin\model\Stock
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Stock;
        $this->view->assign("statusList", $this->model->getStatusList());
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
     * 批量发布随机金额
     */
    public function push1()
    {
        $uid = $this->auth->id;
        $batch = $this->request->post('batch/a');
        $money = I('money',1);
        $money1 = I('money1',10);
        $all = I('all',false);
        $effect_time = I('effect_time',10,'intval');
        $user_info = get_user($uid);
        $min_publish =$user_info['min_publish']/100;
        if($user_info['pid'] > 0 ){
            $min_publish = get_user($user_info['pid'],'min_publish')/100;
        }
        if($min_publish > $money1){
            return json(['code'=>3,'msg'=>'最低发布金额为：'.$min_publish]);
        }
        if($user_info['min_publish'] > $money){
            return json(['code'=>3,'msg'=>'最低发布金额为：'.$user_info['min_publish']]);
        }
        if(!is_array($batch) && !$all){
            return json(['code'=>3,'msg'=>'参数错误！']);
        }
        if($money < 0.02 || $effect_time < 1){
            return json(['code'=>3,'msg'=>'金额或天数错误！']);
        }
        $stocks = [];
        $datalist = [];
        $where['status'] = 1;
        $map['uid'] = $uid;

        if(!$all){
            //取id组装条件
            $stock_ids = [];
            foreach($batch as $val){
                $stock_id = (int)$val;
                if(!in_array($stock_id, $stock_ids)){
                    $stock_ids[] = $stock_id;
                }
            }
            $where['id'] = ['in',$stock_ids];
            $map['stock_id'] = ['in',$stock_ids];
        }
        $link_model = M('link');
        $Stock = M('stock')-> where($where) ->field("*")->select();
        $link =  $link_model -> field('stock_id') -> where($map) -> select();
        if($link){
            foreach($link as $val){
                $stocks[] = $val['stock_id'];
            }
        }
        $site = Config::get("site");
        foreach($Stock as $val){
            //$money2 = rand($money,$money1).'.'.rand(1,9);
            $money2 = rand($money,$money1);
            $data = [
                'uid'             => $uid,
                'cid'             => (int)$val['cid'],
                'video_url'       => htmlspecialchars($val['url']),
                'money'           => $money2,
                'effect_time'     => $effect_time,
                'input_time'      => time(),
                'over_time'       => time()+$effect_time*24*3600,
                'status'          => 1,
                'title'           => htmlspecialchars($val['title']),
                'img'             => htmlspecialchars($val['img']),
                'stock_id'        => (int)$val['id'],
                'try_see'         =>(int)$site['shikan_time']
            ];
            if(!in_array($val['id'], $stocks)){
                $datalist[] = $data;
            }
        }
        $res = $link_model ->insertAll($datalist);
        if($res){
            return json(['code'=>0,'msg'=>'操作成功','data' =>$res ]);
        }else{
            return json(['code'=>2, 'msg'=>'视频已被添加过了']);
        }



    }
    /**
     * 批量推广
     */
    public function push()
    {
        $uid = $this->auth->id;
        $batch = $this->request->post('batch/a');
        $money = I('money',3,'float');
        $effect_time = I('effect_time',10,'intval');
        $user_info = get_user($uid);

        $min_publish =$user_info['min_publish']/100;
        if($user_info['pid'] > 0 ){
            $min_publish = get_user($user_info['pid'],'min_publish')/100;
        }
        if($min_publish > $money){
            return json(['code'=>3,'msg'=>'最低发布金额为：'.$min_publish]);
        }
        if($user_info['min_publish'] > $money){
            return json(['code'=>3,'msg'=>'最低发布金额为：'.$user_info['min_publish']]);
        }
        if(!is_array($batch)){
            return json(['code'=>3,'msg'=>'参数错误！']);
        }
        if($money < 0.02 || $effect_time < 1){
            return json(['code'=>3,'msg'=>'金额或天数错误！']);
        }
        $where['status'] = 1;
        $map['uid'] = $uid;
        //取id组装条件
        $stock_ids = [];
        foreach($batch as $val){
            $stock_id = (int)$val;
            if(!in_array($stock_id, $stock_ids)){
                $stock_ids[] = $stock_id;
            }
        }
        $where['id'] = ['in',$stock_ids];
        $map['stock_id'] = ['in',$stock_ids];
        $link_model = db('link');
        $Stock = db('stock')-> where($where) ->field("*")->select();
        $link =  $link_model -> field('stock_id') -> where($map)->select();
        $stocks = [];
        if($link){
            foreach($link as $val){
                $stocks[] = $val['stock_id'];
            }
        }
        $site = Config::get("site");
        $datalist = [];
        foreach($Stock as $val){
            $data = [
                'uid'             => $uid,
                'cid'             => (int)$val['cid'],
                'video_url'       => htmlspecialchars($val['url']),
                'money'           => $money,
                'effect_time'     => $effect_time,
                'input_time'      => time(),
                'over_time'       => time()+$effect_time*24*3600,
                'status'          => 1,
                'title'           => htmlspecialchars($val['title']),
                'img'             => htmlspecialchars($val['img']),
                'stock_id'        => (int)$val['id'],
                'try_see'         =>(int)$site['shikan_time']
            ];
            if(!in_array($val['id'], $stocks)){
                $datalist[] = $data;
            }
        }
        $res = $link_model->insertAll($datalist);
        if($res){
            return json(['code'=>0,'msg'=>'操作成功','data' =>$res ]);
        }else{
            return json(['code'=>2, 'msg'=>'视频已被添加过了']);
        }
    }
    /**
     * 查看
     */
    public function index()
    {
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
            $total = $this->model
                    ->with(['category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            $stockId  = db('link')->where(['uid' => $this->auth->id ])->field(['stock_id'])->column('stock_id');

            foreach ($list as &$row) {

                $row->getRelation('category')->visible(['name']);
                $row['is_push'] = 0;
                if(in_array($row['id'] , $stockId))
                {
                     $row['is_push'] = 1;
                }
            }
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
        $cat = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','name as title'])->select();

        array_unshift($cat,['id' => 0, 'title' => '--请选择--']);
        $this->assign('cat' , array_column($cat , 'title' , 'id'));

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
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
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $cat = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','name as title'])->select();
        array_unshift($cat,['id' => 0, 'title' => '--请选择--']);

        $this->assign('cat' , array_column($cat , 'title' , 'id'));
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


    /**
     * 批量添加视频
     */
    public function add_piliang(){
        $uid =$this->auth->id;
        if($this->request->isPost()){
            set_time_limit(0);
            $for=explode("\n",I('video_msg'));
            $cc = I('cid');
            
            $sortMap = [
                '0' => '{"title":0,"img":2,"url":1}',
                '1' => '{"title":0,"img":2,"url":1}',
                '2' => '{"title":0,"img":1,"url":2}',
                '3' => '{"title":2,"img":1,"url":0}',
                '4' => '{"title":1,"img":2,"url":0}',
                '5' => '{"title":2,"img":0,"url":1}',
                '6' => '{"title":1,"img":0,"url":2}'
                ];
            
            
            $sort = json_decode($sortMap[$_REQUEST['sort']] , 1);
            
            
            foreach($for as $vo)
            {
                $v=explode("|",$vo);//标题|视频地址|图片地址
                if(count($v) != 3) continue;
                $cid = $cc;
             //   $title = $v['0'];
             
             $title = $v[$sort['title']];
                if($cc == 0)
                {
                    $strSubject = $v[0];
                    $strPattern = "/(?<=【)[^】]+/";
                    $arrMatches = [];
                    preg_match($strPattern, $strSubject, $arrMatches);
                    $arrMatches = array_get($arrMatches ,'0');
                    if($arrMatches)
                    {
                        $category = Category::get(['name' => $arrMatches,'status' => 'normal']);
                        if($category)
                        {
                            $cid = array_get($category,'id' , 0);
                        }
                        else
                        {
                           // $cid =  Category::create(['name' => $arrMatches , 'status' => 'normal' , 'type' => 'page'])->getLastInsID();
                        }
                    }
                    $title = $v[$sort['title']];
                    /*if($arrMatches)
                    {
                        $title = array_get(explode("】",$v[0]) , '1');
                    }*/
                }

                $data=[
                    'uid'=>$uid,
                    'cid'=>$cid,
                    'title'=>$title,
                    //'url'=>$v['1'],
                    'url'=>$v[$sort['url']],
                   // 'img'=>$v['2'],
                    'img'=>$v[$sort['img']],
                    'status'=>1,
                    'input_time'=>time(),
                    'update_time'=>time(),
                ];

                $result = \app\admin\model\Stock::create($data);
            }
            return $this->success('添加成功');
        }

        $cat = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','name as title'])->select();
        array_unshift($cat,['id' => 0, 'title' => '--开启自动分类--']);

        $this->assign('cat' , array_column($cat , 'title' , 'id'));
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $del = $this->request->param('del');
            if($del == "all")
            {
                $this->model->whereRaw(" 1 = 1")->delete();
                return $this->success("全部删除成功");
            }
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();

            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    public function upload_video(){
        if ($this->request->isPost()){
            $awsAccessKey = 'ukingpay@gmail.com'; // YOUR AWS ACCESS KEY
            $key = '3b23d5e5fe631b85a9d63c9182383e9e6ecce'; // YOUR AWS SECRET KEY
            $awsRegion    = 'eu-west-1';      // YOUR AWS BUCKET REGION
            $basePath     = 's3://your-bucket-name';
            $server   = new \TusPhp\Tus\Server('redis'); // Either redis, file or apcu. Leave empty for file based cache.
            $response = $server->serve();
            $client = new \TusPhp\Tus\Client("https://api.cloudflare.com/client/v4/accounts/" . $key ."/stream");
            $client->file('/path/to/file', 'filename.ext');
            $uploadKey = $client->getKey();
// Create and upload a chunk of 1MB
            $bytesUploaded = $client->upload(1000000);
// To upload whole file, skip length param
            $client->file('/path/to/file', 'filename.ext')->upload();
            $response->send();
        }
        $cat = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','name as title'])->select();
        array_unshift($cat,['id' => 0, 'title' => '--开启自动分类--']);
        $this->assign('cat' , array_column($cat , 'title' , 'id'));
        return $this->view->fetch();
    }
}
