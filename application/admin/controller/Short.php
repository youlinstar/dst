<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use function fast\array_get;

class Short extends Backend
{

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Link;

    }

  


    /**
     * 短链接生成
     */
    public function shortUrl()
    {
        
        $id = $this->request->param('id');
        $path = '';
        /*if ($id) {
            $url = $this->getPushUrls() .
            $path = "/index/index/index?hezi={$id}&f=" . id_encode($this->auth->id);
        } else {
            $url = $this->getPushUrls() . "/index/index/index?f=" . id_encode($this->auth->id);
            $path = "/index/index/index?f=" . id_encode($this->auth->id);
        }*/
        if (!empty($id)) {
            $url = $this->getPushUrls($id).
            $path='?d='.base64_encode(id_encode($this->auth->id)."|".$id."|".time());
        } else {
            $url=$this->getPushUrls().
                $path='?f='.id_encode($this->auth->id).'&cd='.time();
        }
        //$url = $this->add_querystring_var($url, 'cd', time());
        //$path = $this->add_querystring_var($path, 'cd', time());
        $user = db('admin')->where(['id' => $this->auth->id])->find();
        $short = $user['short'];
        $c = array_filter(config('SHORT'));
        if (empty($short)) {
            //exit(json_encode(['code' => 1, 'msg' => '请到【个人设置】选择短链接类型']));
            $user = db('admin')->where(['id' => 1])->find();
            $short = $user['short'];
        }
        
        
    
        switch ($short) {
            case 'self':
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $url]));
                break;
            case 'uouin':
                    
                    $s = array_column($c, 's', 'model');
                    
                    $c = array_column($c, 'app_key', 'model');
                    
                    
                    $u = urlencode($url);
                    //$url = urlencode($url);
                    $key = $c[$short];
                    $username = $s[$short];
                    
                    $api = "https://api.uouin.com/index.php/index/Userapi?username={$username}&key={$key}&url=".urlencode($url);

                    $res = json_decode(file_get_contents($api) , 1);
                    
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['short']]));

                
                    
                    break;
            case 'surl_cn':

            		$u = "https://surl.cn/generateUrl?links=".urlencode($url);
            		$res = json_decode(file_get_contents($u),1);
            		if($res['code'] == 200)
            		{
                		exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['url']]));
            		}
            		
            	exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));

            		
            	break;
            case 'zuijin_to':
                
                $c = array_column($c, 'app_key', 'model');
                
                $u = urlencode($url);
                //$url = urlencode($url);
                $key = $c[$short];

                //短链接生成类型 
                $name = "wurlcn";
                
                $host = "http://api.dwzjh.com/api/{$key}?name=wurlcn&url={$u}";
                
                
                $res = file_get_contents($host);
                
                $res = json_decode($res , true);
                
                
    
                if($res['code'] == 200)
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['data']['url']]));

                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));
                break;
            case '45dwzs':
                
                $c = array_column($c, 'app_key', 'model');
                
                $u = $url;
                //$url = urlencode($url);
                $key = $c[$short];

                $host = 'https://45dwz.cn';
                $path = '/apicreate.php?token='.$key;
                
            
                $url = $host . $path;
                
                
                // TODO：设置待转换长网址
                $data = array('url'=>$u, 'mark'=>'你的备注');
                
                // 创建连接
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // 发送请求
                $response = curl_exec($ch);
                curl_close($ch);
                
                // 读取响应
                $response = json_decode($response , 1);
                
           
                
                if($response['code'] == 1000)
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $response['shortUrl']]));

                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));
                break;
            case 'r6m_news':
            $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                
                $curl = curl_init();
                
                
                $json = [
                    "platformId" => 1,
                    "domain" => $path,
                    "secretKey" => $key,
                    "mainDomain" => '111'
                    ];

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'http://www.kxunchina.com/create',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>json_encode($json , 256),
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                $res = json_decode($response , 1);
                
                if($res['status'] == "200")
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['message']]));
                }
                
                
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['message']]));

                
                
                
                
                break;
            case 'suowor6n':
                
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                //http://api.suowo.cn/api.htm?url=http://baidu.com&key=5d9ae11b8e676d79d8d3ab66@c8a439f77e2280602306d394a1a3cbd8&format=json
                $api = "http://api.suowo.cn/api.htm?url={$url}&key={$key}&format=json";
                $res = json_decode(file_get_contents($api),1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));
                break;
            case 'suowor6ngzh':
                
                 $a = array_column($c, 'app_id', 'model');
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                
                $app_id = $a[$short];
                
                 $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$app_id&response_type=code&scope=snsapi_base&redirect_uri=$url";
                $url = urlencode($url);
            
                //http://api.suowo.cn/api.htm?url=http://baidu.com&key=5d9ae11b8e676d79d8d3ab66@c8a439f77e2280602306d394a1a3cbd8&format=json
                $api = "http://api.suowo.cn/api.htm?url={$url}&key={$key}&format=json";
                $res = json_decode(file_get_contents($api),1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));
                break;
            case '45dwz':
                $c = array_column($c, 'app_key', 'model');
                //$url = urlencode($url);
                $key = $c[$short];
                
                //echo $key;
                $host = 'https://45dwz.cn';//45短网址可复活 官网https://45dwz.cn/
                $path = '/exclusiveDomainCreate.php?token='.$key;
                $urls = $host . $path;
                // TODO：设置待转换长网址
                $data = array('domain'=>'j1i1.cn', 'url'=>$url, 'mark'=>'你的备注');
                $ch = curl_init($urls);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // 发送请求
                $response = curl_exec($ch);
                curl_close($ch);
                

                $res = json_decode($response,1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['shortUrl']]));
                break;
            case '1eh':
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $api = "https://1eh.cn/api/new/?id=27&token=$key&url={$url}";
                $res = json_decode(file_get_contents($api),1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));
                break;
            case 'r6n_gzh':
                
               $a = array_column($c, 'app_id', 'model');
            $c = array_column($c, 'app_key', 'model');
            
            $url = urlencode($url);
             
            $key = $c[$short];
            $app_id = $a[$short];
            
            
            $gzh = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$app_id&response_type=code&scope=snsapi_base&redirect_uri=$url";
            $gzh = urlencode($gzh);
            
            
            $api = "http://api.ft12.com/r6m.php?format=json&url={$gzh}&apikey=$key&format=json";
            
            $res = json_decode(file_get_contents($api),1);
            if(isset($res['url']) && $res['status'] != -1)
            {
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));
            }
            exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['err']]));
            break;
            case 'r88ns':
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $api = "http://r8n.cn/api/?key={$key}&url={$url}&format=json";
                
                
                $res = json_decode(file_get_contents($api),1);
                //print_r($res);die;
                if(isset($res['short']) && $res['error'] == 0 )
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['short']]));
                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));
                break;
            case 'r6n':
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $api = "http://api.ft12.com/r6m.php?format=json&url={$url}&apikey=$key";
                $res = json_decode(file_get_contents($api),1);
                if(isset($res['url']) && $res['status'] != -1)
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));
                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['err']]));
                break;
            case 'newz333333333':
                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $date = date('Y-m-d', time() + 86400);
                $api = "https://zz3.cn/api/new/?id=21&token={$key}&url={$url}";
                $res = json_decode(file_get_contents($api), 1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['msg']]));

                break;
            case 'newdwz44' :

                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $date = date('Y-m-d', time() + 86400);
                $api = "http://mrw.so/api.htm?format=json&url={$url}&key={$key}&expireDate={$date}";
                $res = json_decode(file_get_contents($api), 1);
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['url']]));

                break;
            case 'newdwz33':

                $c = array_column($c, 'app_key', 'model');
                $url = urlencode($url);
                $key = $c[$short];
                $api = "http://api.tianchu.cc/add.php?key={$key}&url={$url}&rid=0.1&type=hidden&gid=0&short=syamcom&title=春风吹又生";
                $code = json_decode(file_get_contents($api), true);
                if ($code['result'] == 200) {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $code['data']]));
                } else {
                    exit(json_encode(['code' => 0, 'msg' => $code['msg'], 'data' => $code['msg']]));
                }
                break;
            case 'newdwz3':
                $code = "https://dwz3.cn/apis/authorize/getCode";
                $code = json_decode(file_get_contents($code), true)['data'];

                $time = date('Y-m-d H:i:s', time());


                $s = array_column($c, 's', 'model');
                $c = array_column($c, 'app_key', 'model');

                $key = $c[$short];
                $api_key = $c[$short];
                $se = $s[$short];

                $sign = strtolower(md5("api_key={$key}code={$code}request_time={$time}{$se}"));
                $access_token_url = "https://dwz3.cn/apis/authorize/getAccessToken";
                $header = array();


                $content = [
                    'api_key' => $key,
                    'code' => $code,
                    'request_time' => $time,
                    'sign' => $sign
                ];
                $access_token = json_decode($this->tocurl($access_token_url, $header, $content), 1);


                if ($access_token['status'] == 0) {
                    exit(json_encode(['code' => 0, 'msg' => $access_token['info'], 'data' => '']));
                }
                $access_token = $access_token['data']['access_token'];
                $add = "https://dwz3.cn/apis/urls/add";
                $p_header = [];
                $params = [
                    'real_url' => $url,
                    'access_token' => $access_token
                ];

                $res = json_decode($this->tocurl($add, $p_header, $params), 1);
                if ($res['status'] != 1) {
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
            case "car":
           
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
            case "deyunshe":
                $api = "http://43.154.201.120/api/auth/deyunshe?url=".urlencode($url);
                $shortUrl = file_get_contents($api);
                if(empty($shortUrl))
                {
                    exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $url]));
                }
                exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $shortUrl]));
                break;
            /*   default:
                   $token = C('BF_TOKEN');
                   $api = "http://yy.gongju.at/?a=addon&m=$short&token=$token&long=" . urlencode($url);
                   $res = json_decode(file_get_contents($api), true);
                   exit(json_encode(['code' => 0, 'msg' => 'success', 'data' => $res['short']]));
                   break;*/
        }

        exit(json_encode(['code' => 1, 'msg' => 'error 报错']));
    }

    /**
     * 获取推广总链
     */
    protected function getPushUrls($id=null)
    {
        $url = "";
        $uid = $this->auth->id;
        $sid = $uid;
        $pinfo = get_user($uid);
        if ($pinfo['pid'] > 0) {
            $sid = $pinfo['pid_top'];
        }
        if (!empty($pinfo['wx_check_api'])) {
            $fangfeng_url = $pinfo['wx_check_api'];
        } else {
            $fangfeng_url = get_user($sid, 'wx_check_api');
        }
        if ($fangfeng_url) {
            $url = $fangfeng_url;
        } else {
            $domain = trim(getDomain(1));

            if ($domain) {
                $hezi_url = $domain;
                $url = $hezi_url.'/index/index/index';
            } else {
                $url = '需要添加主域名才能生成盒子链接';
            }
        }
        return trim($url);
    }


    public function add_querystring_var($url, $key, $value)
    {
        $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
        $url = substr($url, 0, -1);
        if (strpos($url, '?') === false) {
            return ($url . '?' . $key . '=' . $value);
        } else {
            return ($url . '&' . $key . '=' . $value);
        }
    }
}
