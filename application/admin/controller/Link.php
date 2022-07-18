<?php

namespace app\admin\controller;

use app\admin\library\Auth;
use app\admin\model\Admin;
use app\admin\model\Category;
use app\admin\model\LinkTop;
use app\common\controller\Backend;
use Exception;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;
use function fast\array_get;

/**
 * 代理片库
 *
 * @icon fa fa-link
 */
class Link extends Backend
{

    /**
     * Link模型对象
     * @var \app\admin\model\Link
     */
    protected $model = null;
    protected $noNeedLogin = ['cao'];
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Link;
        $this->assign('userinfo' , Admin::getUser($this->auth->id));
    }
    /**
     * 一键修改金额
     */
    public function changemoney()
    {
        $uid = $this->auth->id;
        if ($this->request->isPost()) {

            $model = M('Link');
            $money = I('money', '0');
            $user_info = get_user($uid);
            $min_publish = $user_info['min_publish'] / 100;
            if ($user_info['pid'] > 0) {
                $min_publish = get_user($user_info['pid'], 'min_publish') / 100;
            }
            if ($money < $min_publish) {
                return json(['code' => 1, 'msg' => '金额必须大于' . $min_publish . '元']);
            }
            $res = $model->where(['uid' => $uid])->setField('money', $money);
            if ($res !== false) {
                return json(['code' => 0, 'msg' => '保存成功']);
            }
            else {
                return json(['code' => 4, 'msg' => '保存失败']);
            }
        }
        return view('changemoney');
    }
    /**
     * 一键修改试看
     */
    public function trySee() {

        $uid=$this->auth->id;

        if($this->request->isPost()) {
            $model = M('Link');
            $money   = I('try_see', '0');
            $res = $model->where(['uid'=>$uid])->setField('try_see',$money);
            if($res !== false)
            {
                return json(['code'=>0,'msg'=>'保存成功']);
            }
            else
            {
                return json(['code'=>4,'msg'=>'保存失败']);
            }

        }
        return $this->fetch('trysee');
    }
    /**
     * 一键修改包日
     */
    public function dateFee()
    {

        $fee = I('fee', 0, 'int');
        $uid = $this->auth->id;
        $res = M('admin')->where(['id' => $uid])->setField(['date_fee' => $fee]);
        $res = M('link')->where(['uid' => $uid])->setField(['money1' => $fee]);

        if ($res) {
            exit(json_encode(['code' => 0, 'msg' => '操作成功']));
        }
        exit(json_encode(['code' => -2, 'msg' => '数据无改动']));
    }
    
    
     /**
     * 一键修改包周
     */
    public function weekFee()
    {

        $fee = I('fee', 0, 'int');
        $uid = $this->auth->id;
        $res = M('admin')->where(['id' => $uid])->setField(['week_fee' => $fee]);
        $res = M('link')->where(['uid' => $uid])->setField(['money3' => $fee]);

        if ($res) {
            exit(json_encode(['code' => 0, 'msg' => '操作成功']));
        }
        exit(json_encode(['code' => -2, 'msg' => '数据无改动']));
    }
    
    /**
     * 一键修改包月
     */
    public function monthfee()
    {
        $fee = I('fee', 0, 'int');
        $uid = $this->auth->id;
        $res = M('admin')->where(['id' => $uid])->setField(['month_fee' => $fee]);
        $res = M('link')->where(['uid' => $uid])->setField(['money2' => $fee]);
        if ($res) {
            exit(json_encode(['code' => 0, 'msg' => '操作成功']));
        }
        exit(json_encode(['code' => -2, 'msg' => '数据无改动']));
    }

    /**
     * 短链接生成
     */
    public function shortUrl()
    {
        $id = $this->request->param('id');
        
        if($id)
        {
            $url = $this->getPushUrls()."/index/index/index?hezi={$id}&f=".id_encode($this->auth->id);
        }
        else
        {
            $url = $this->getPushUrls()."/index/index/index?f=".id_encode($this->auth->id);
        }
        
       
        
        // $url = $this->add_querystring_var($url, 'cd', time());
        $user = db('admin')->where(['id' => $this->auth->id])->find();

        $short = $user['short'];
        $c = array_filter(config('SHORT'));
        if (empty($short)) {
            exit(json_encode(['code' => 1, 'msg' => '请到【个人设置】选择短链接类型']));
        }

        switch ($short) {
            case 'r6n':
                 $url = urlencode($url);
                $api  = "http://api.ft12.com/api.php?format=json&url={$url}&apikey=18988995777@f95f1fb8875fc82e9887f9f5f626b7e2";
                $res = file_get_contents($api);
                $res = json_decode($res , 1);
                 exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));
                     break;
            case 'newz333333333':
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $date = date('Y-m-d',time()+86400);
                $api = "https://zz3.cn/api/new/?id=21&token={$key}&url={$url}";
                $res = json_decode(file_get_contents($api),1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));

                break;
            case 'newdwz44' :

                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $date = date('Y-m-d',time()+86400);
                $api = "http://mrw.so/api.htm?format=json&url={$url}&key={$key}&expireDate={$date}";
                $res = json_decode(file_get_contents($api),1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));

                break;
            case 'newdwz33':

                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $api = "http://api.tianchu.cc/add.php?key={$key}&url={$url}&rid=0.1&type=hidden&gid=0&short=syamcom&title=春风吹又生";
                $code = json_decode(file_get_contents($api) , true);
                if($code['result'] == 200)
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $code['data']]));
                }
                else
                {
                    exit(json_encode(['code' => 0, 'msg' => $code['msg'], 'data' => $code['msg']]));
                }
                break;
            case 'newdwz3':
                $code = "https://dwz3.cn/apis/authorize/getCode";
                $code = json_decode(file_get_contents($code) , true)['data'];

                $time = date('Y-m-d H:i:s',time());


                $s = array_column($c, 's', 'model');
                $c = array_column($c, 'app_key', 'model');

                $key = $c[$short];
                $api_key = $c[$short];
                $se = $s[$short];

                $sign = strtolower(md5("api_key={$key}code={$code}request_time={$time}{$se}"));
                $access_token_url = "https://dwz3.cn/apis/authorize/getAccessToken";
                $header=array();


                $content = [
                    'api_key' => $key,
                    'code' => $code,
                    'request_time' => $time,
                    'sign' => $sign
                ];
                $access_token = json_decode($this->tocurl($access_token_url , $header , $content) , 1);


                if($access_token['status'] == 0)
                {
                    exit(json_encode(['code' => 0, 'msg' => $access_token['info'], 'data' => '']));
                }
                $access_token = $access_token['data']['access_token'];
                $add = "https://dwz3.cn/apis/urls/add";
                $p_header = [];
                $params = [
                    'real_url' => $url,
                    'access_token' => $access_token
                ];

                $res = json_decode($this->tocurl($add ,$p_header , $params ),1);
                if($res['status'] != 1)
                {
                    exit(json_encode(['code' => 0, 'msg' => $res['info'], 'data' => '']));

                }


                exit(json_encode(['code' => 0, 'msg' => $access_token['info'], 'data' => $res['data']['short_url']]));
                break;
            case 'bd':
                $c = array_column($c, 'app_key', 'model');
                $key = $c[$short];
                $api = "http://tz.hgglptt.cn/v2/$key?m=bd&url=" . urlencode($url); //猫咪防封
                $res = json_decode(file_get_contents($api), true);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['short_url']]));
                break;
            case "git.io":
                $url = "https://mabbs.github.io/jump.html?url=" . urlencode($url);
                $res = $this->curl_post("https://git.io/create", [
                    'url' => $url
                ]);
                $url = "https://git.io/" . $res;
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $url]));
                break;
            case "kz":
                $c = array_column($c, 'app_key', 'model');
                $key = $c[$short];
                if (empty($key)) {
                    exit(json_encode(['code' => 1, 'msg' => '请先设置快站app_key']));
                }
                $api = "https://cloud.kuaizhan.com/api/v1/tbk/genKzShortUrl";
                $res = $this->curl_post($api, [
                    'appKey' => $key,
                    'url' => urlencode($url)
                ]);
                $res = json_decode($res, 1);
                if ($res['code'] != 200) {
                    exit(json_encode(['code' => 1, 'msg' => $res['msg']]));
                }
                exit(json_encode(['code' => 1, 'msg' => $res['data']['shortUrl']]));
                break;
            case 'bdpro':
            case 'sohu':
            case 'wurl':

                $c = array_column($c, 'app_key', 'model');
                $key = $c[$short];
                $api = "http://91up.top/api/tools/$short?token=$key&domain=" . urlencode($url); //新猫咪防封

                $res = json_decode(file_get_contents($api), true);


                if ($res['data']['status_code'] == 0) {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['short_url']]));
                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['message']]));
            case 'tinyurl':
            case 'bdpro':
            case 'yam':
            case "z3":
            case "url":
            case "uv":
            case "bd_pro_plus":
                $c = array_column($c, 'app_key', 'model');
                $key = $c[$short];
                $api = "http://91up.top/api/tools/$short?token=$key&domain=" . urlencode($url); //新猫咪防封
                $res = json_decode(file_get_contents($api), true);
            
                if ($res['data']['status_code'] == 0) {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['short_url']]));
                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['message']]));

                break;
            case "newbd":
                $c = array_column($c, 'app_key', 'model');
                $key = $c[$short];
                $api = "http://91up.top/api/tools/bd?token=$key&domain=" . urlencode($url); //猫咪防封
                $res = json_decode(file_get_contents($api), true);

                if ($res['data']['status_code'] == 0) {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['short_url']]));
                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['message']]));
                break;
         /*   default:
                $token = C('BF_TOKEN');
                $api = "http://yy.gongju.at/?a=addon&m=$short&token=$token&long=" . urlencode($url);
                $res = json_decode(file_get_contents($api), true);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['short']]));
                break;*/
        }

        exit(json_encode(['code' => 1, 'msg' => 'error报错 请到【个人设置】选择短链接类型']));
    }

    /**
     * 模版切换
     */
    public function muban()
    {
        $uid  = $this->auth->id;
        if($this->request->isPost())
        {
            
    
            
            
            
            $id = $this->request->param('id');
            $res = db('admin')->where(['id' => $uid])->setField(['view_id' => $id]);
            if($res)
            {
                exit(json_encode(['code' => 0,'msg'=>'切换成功！']));
            }
            exit(json_encode(['code' => 0,'msg'=>'切换失败！']));
        }
        $list = M('muban')->where(['status' => 1])->select();
        $this->assign('list' , $list);
        $this->assign('userinfo',get_user($uid));

        return $this->fetch('muban');
    }

    /**
     * 视频预览
     */
    public function play()
    {
        $this->assign('video_url' , $this->request->param('video_url'));
        return $this->fetch('play');
    }

    protected  function add_querystring_var($url, $key, $value)
    {
        $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
        $url = substr($url, 0, -1);
        if (strpos($url, '?') === false) {
            return ($url . '?' . $key . '=' . $value);
        } else {
            return ($url . '&' . $key . '=' . $value);
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
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams(null, null, true);
            $total = $this->model
                ->with(['category','linkTop'])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['category','linkTop'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {

                $row->getRelation('category')->visible(['name']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        $this->assign('url' , $this->getPushUrl());
        return $this->view->fetch();
    }

    /**
     * 获取推广总链
     */
    protected function getPushUrls()
    {
        $url = "";
        $uid = $this->auth->id;
        $sid = $uid;
        $pinfo = get_user($uid);
        if ($pinfo['pid'] > 0) {
            $sid = $pinfo['pid_top'];
        }
        if (!empty($pinfo['wx_check_api']))
        {
            $fangfeng_url = $pinfo['wx_check_api'];
        }
        else
        {
            $fangfeng_url = get_user($sid, 'wx_check_api');
        }
        if ($fangfeng_url)
        {
            $url = $fangfeng_url;
        }
        else
        {
            $domain = trim(getDomain(2));

            if ($domain)
            {
                $hezi_url = $domain;
                $url = $hezi_url;
            }
            else
            {
                $url = '需要添加主域名才能生成盒子链接';
            }
        }
        return trim($url);
    }
    protected function getPushUrl()
    {
        $url = "";
        $uid = $this->auth->id;
        $sid = $uid;
        $pinfo = get_user($uid);
        if ($pinfo['pid'] > 0) {
            $sid = $pinfo['pid_top'];
        }
        if (!empty($pinfo['wx_check_api']))
        {
            $fangfeng_url = $pinfo['wx_check_api'];
        }
        else
        {
            $fangfeng_url = get_user($sid, 'wx_check_api');
        }
        if ($fangfeng_url)
        {
            //$url = $fangfeng_url . '/index/index/index?f=' . id_encode($uid);

            $url=$fangfeng_url.'?d='.base64_encode(id_encode($uid));
        }
        else
        {
            $domain = trim(getDomain(2));

            if ($domain)
            {
                $hezi_url = $domain . '/index/index/index?f=' . id_encode($uid);
                $url = $hezi_url;
            }
            else
            {
                $url = '需要添加主域名才能生成盒子链接';
            }
        }
        return trim($url);
    }

    /**
     * 回收站
     */
    public function recyclebin()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->onlyTrashed()
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->onlyTrashed()
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

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
        $cat = Category::get(['type' => 'page', 'status' => 'normal'])->field(['id','name as title'])->select();
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
                $this->model->whereRaw(" 1 = 1")->where(['uid' => $this->auth->id ])->delete();
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

    /**
     * 真实删除
     */
    public function destroy($ids = "")
    {
        $pk = $this->model->getPk();
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            $this->model->where($this->dataLimitField, 'in', $adminIds);
        }
        if ($ids) {
            $this->model->where($pk, 'in', $ids);
        }
        $count = 0;
        Db::startTrans();
        try {
            $list = $this->model->onlyTrashed()->select();
            foreach ($list as $k => $v) {
                $count += $v->delete(true);
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
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    /**
     * 还原
     */
    public function restore($ids = "")
    {
        $pk = $this->model->getPk();
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            $this->model->where($this->dataLimitField, 'in', $adminIds);
        }
        if ($ids) {
            $this->model->where($pk, 'in', $ids);
        }
        $count = 0;
        Db::startTrans();
        try {
            $list = $this->model->onlyTrashed()->select();
            foreach ($list as $index => $item) {
                $count += $item->restore();
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
        }
        $this->error(__('No rows were updated'));
    }

    /**
     * 批量更新
     */
    public function multi($ids = "")
    {
        $ids = $ids ? $ids : $this->request->param("ids");
        if ($ids) {
            if ($this->request->has('params')) {
                parse_str($this->request->post("params"), $values);
                $values = $this->auth->isSuperAdmin() ? $values : array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                if ($values) {
                    $adminIds = $this->getDataLimitAdminIds();
                    if (is_array($adminIds)) {
                        $this->model->where($this->dataLimitField, 'in', $adminIds);
                    }
                    $count = 0;
                    Db::startTrans();
                    try {
                        $list = $this->model->where($this->model->getPk(), 'in', $ids)->select();
                        foreach ($list as $index => $item) {
                            $count += $item->allowField(true)->isUpdate(true)->save($values);
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
                        $this->error(__('No rows were updated'));
                    }
                } else {
                    $this->error(__('You have no permission'));
                }
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    /**
     * 导入
     */
    protected function import()
    {
        $file = $this->request->request('file');
        if (!$file) {
            $this->error(__('Parameter %s can not be empty', 'file'));
        }
        $filePath = ROOT_PATH . DS . 'public' . DS . $file;
        if (!is_file($filePath)) {
            $this->error(__('No results were found'));
        }
        //实例化reader
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!in_array($ext, ['csv', 'xls', 'xlsx'])) {
            $this->error(__('Unknown data format'));
        }
        if ($ext === 'csv') {
            $file = fopen($filePath, 'r');
            $filePath = tempnam(sys_get_temp_dir(), 'import_csv');
            $fp = fopen($filePath, "w");
            $n = 0;
            while ($line = fgets($file)) {
                $line = rtrim($line, "\n\r\0");
                $encoding = mb_detect_encoding($line, ['utf-8', 'gbk', 'latin1', 'big5']);
                if ($encoding != 'utf-8') {
                    $line = mb_convert_encoding($line, 'utf-8', $encoding);
                }
                if ($n == 0 || preg_match('/^".*"$/', $line)) {
                    fwrite($fp, $line . "\n");
                } else {
                    fwrite($fp, '"' . str_replace(['"', ','], ['""', '","'], $line) . "\"\n");
                }
                $n++;
            }
            fclose($file) || fclose($fp);

            $reader = new Csv();
        } elseif ($ext === 'xls') {
            $reader = new Xls();
        } else {
            $reader = new Xlsx();
        }

        //导入文件首行类型,默认是注释,如果需要使用字段名称请使用name
        $importHeadType = isset($this->importHeadType) ? $this->importHeadType : 'comment';

        $table = $this->model->getQuery()->getTable();
        $database = \think\Config::get('database.database');
        $fieldArr = [];
        $list = db()->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?", [$table, $database]);
        foreach ($list as $k => $v) {
            if ($importHeadType == 'comment') {
                $fieldArr[$v['COLUMN_COMMENT']] = $v['COLUMN_NAME'];
            } else {
                $fieldArr[$v['COLUMN_NAME']] = $v['COLUMN_NAME'];
            }
        }

        //加载文件
        $insert = [];
        try {
            if (!$PHPExcel = $reader->load($filePath)) {
                $this->error(__('Unknown data format'));
            }
            $currentSheet = $PHPExcel->getSheet(0);  //读取文件中的第一个工作表
            $allColumn = $currentSheet->getHighestDataColumn(); //取得最大的列号
            $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
            $maxColumnNumber = Coordinate::columnIndexFromString($allColumn);
            $fields = [];
            for ($currentRow = 1; $currentRow <= 1; $currentRow++) {
                for ($currentColumn = 1; $currentColumn <= $maxColumnNumber; $currentColumn++) {
                    $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
                    $fields[] = $val;
                }
            }

            for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
                $values = [];
                for ($currentColumn = 1; $currentColumn <= $maxColumnNumber; $currentColumn++) {
                    $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
                    $values[] = is_null($val) ? '' : $val;
                }
                $row = [];
                $temp = array_combine($fields, $values);
                foreach ($temp as $k => $v) {
                    if (isset($fieldArr[$k]) && $k !== '') {
                        $row[$fieldArr[$k]] = $v;
                    }
                }
                if ($row) {
                    $insert[] = $row;
                }
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
        if (!$insert) {
            $this->error(__('No rows were updated'));
        }

        try {
            //是否包含admin_id字段
            $has_admin_id = false;
            foreach ($fieldArr as $name => $key) {
                if ($key == 'admin_id') {
                    $has_admin_id = true;
                    break;
                }
            }
            if ($has_admin_id) {
                $auth = Auth::instance();
                foreach ($insert as &$val) {
                    if (!isset($val['admin_id']) || empty($val['admin_id'])) {
                        $val['admin_id'] = $auth->isLogin() ? $auth->id : 0;
                    }
                }
            }
            $this->model->saveAll($insert);
        } catch (PDOException $exception) {
            $msg = $exception->getMessage();
            if (preg_match("/.+Integrity constraint violation: 1062 Duplicate entry '(.+)' for key '(.+)'/is", $msg, $matches)) {
                $msg = "导入失败，包含【{$matches[1]}】的记录已存在";
            };
            $this->error($msg);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->success();
    }

    public function setTop()
    {
        if (empty($this->request->param('ids'))){
            $this->error(__('Parameter %s can not be empty', 'ids'));
        }
        $ids=$this->request->param('ids');
        parse_str($this->request->post("params"), $values);
        $values = $this->auth->isSuperAdmin() ? $values : array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
        if (empty($values)){
            $this->error(__('You have no permission'));
        }
        Db::startTrans();
        try {
            $linkTopData=LinkTop::where('link_id',$ids)->find();
            if ($linkTopData){
                if (empty($values['link_top_status'])||$values['link_top_status']=="0"){
                    LinkTop::where($this->model->getPk(), $linkTopData['id'])->delete();
                }else{
                    LinkTop::where($this->model->getPk(), $linkTopData['id'])->update(['status'=>$values['link_top_status']]);
                }
            }else{
                $linkData=$this->model->find($ids);
                if (!empty($values['link_top_status'])||$values['link_top_status']!="0"){
                    LinkTop::insert([
                        'link_id'=>$linkData['id'],
                        'uid'=>$linkData['uid'],
                        'status'=>$values['link_top_status'],
                        'stock_id'=>$linkData['stock_id'],
                    ]);
                }
            }
            Db::commit();
        } catch (PDOException $e) {
            Db::rollback();
            $this->error($e->getMessage());
        } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        $this->success();
    }
}
