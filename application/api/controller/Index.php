<?php

namespace app\api\controller;

use app\admin\model\Domain;
use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function domain()
    {
        $domain = (new Domain())->where(['status' => 1 ,'type' => 2])->find();

        $randpwd = "";
        for ($i = 0; $i < 5; $i++)
        {
            $randpwd .= chr(mt_rand(97, 122));
        }
        header('Content-Type: text/html;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段
        echo $domain['domain'];die;
    }

    public function jiance()
    {
        $user = M('admin')->where(['username' => 'admin'])->find();
        $jiance = $user['jiance'];
        switch ($jiance){
            case "wechat":
                $checkType="wx";
                break;
            case "qq":
                $checkType="qq";
                break;
            case "douyin":
                $checkType="dyjc";
                break;
            default:
                exit("请设置检测类型");
        }
        $ids = [];
        $jiance_tokan = $user['jiance_token'];
        $apiTokenData=explode('|',$jiance_tokan);
        if (empty($apiTokenData[1])){
            exit("账号或token缺失");
        }
        $limit = 1;//每种类型拿*个检测
        $data = [];
        $domain=M('domainLib')->where(array('status'=>1 , 'type' => 1))->limit($limit)->select();
        $data = array_merge($data , $domain);
        $domain=M('domainLib')->where(array('status'=>1 ,  'type' => 2))->limit($limit)->select();
        $data = array_merge($data , $domain);
        $domain=M('domainLib')->where(array('status'=>1 , 'type' => 3))->limit($limit)->select();
        $data = array_merge($data , $domain);
        $domain = $data;
        if($domain){
            foreach ($domain as $k => $v) {
                $site=$v['domain'];
                $apiUrl="https://api.uouin.com/app/".$checkType."?username=".$apiTokenData[0]."&key=".$apiTokenData[1]."&url=".$site;
                $data = json_decode(file_get_contents($apiUrl),true);
                if (empty($data['code'])){
                    echo "请求接口失败：".$apiUrl.PHP_EOL;
                    continue;
                }
                if ($data['code']!==1001){
                    echo $v['domain'].'->拦截<br>';
                    $ids[] =$v['id'];
                }else{
                    echo $v['domain'].'->正常<br>';
                }
            }
        }
        if(is_array($ids) && !empty($ids)){
            $where =[
                'id'=>['in',$ids],
            ];
            M('domainLib')->where($where)->setField('status',2);
        }
    }
}
