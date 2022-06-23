<?php

namespace app\index\controller;

use app\admin\model\Admin;
use app\admin\model\Link;
use app\admin\model\Order;
use app\admin\model\Payset;
use app\common\controller\Frontend;
use fast\WxpayService;
use think\Cache;
use think\cache\driver\Redis;
use think\Controller;
use think\Request;
use function fast\array_get;

class Trading extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {

        $this->checkFlg();
         $d = config('site.doiyin');
        $this->assign('dy',$d);
    }

    public function index()
    {
        $model = $this->request->param('model');
        if(empty($model)) {
            $user = Admin::getUser($this->id);
            if (empty($user['pay_model'])&&empty($user['pay_model1'])) {
                $user = Admin::getUser(1);
            }
            if ($this->request->param('pay',"wx")==="ali"){
                $model = $user['pay_model1'];
            }elseif ($this->request->param('pay',"wx")==="wx"){
                $model = $user['pay_model'];
            }else{
                if (!empty($user['pay_model'])){
                    $model = $user['pay_model'];
                }elseif (!empty($user['pay_model1'])){
                    $model = $user['pay_model1'];
                }else{
                    $this->error("未配置支付通道");
                }
            }
        }
        $user = Admin::getUser($this->id);
        $payInfo = Payset::getPayInfo($model);
        $model=$payInfo['model'];

        switch ($model) {
            case 'dingchengpay':
                $this->dingchengpay($payInfo , $user , $model);
                break;
            case 'fangyoufang':
                $this->fangyoufang($payInfo , $user , $model);
                break;
            case 'shenyupay':
                $this->shenyupay($payInfo , $user , $model);
                break;
            case 'shehuang168':
                $this->shehuang168($payInfo , $user , $model);
                break;
            case 'kangxinlianmeng':
                $this->kangxinlianmeng($payInfo , $user , $model);
                break;
            case 'xhh':
                $this->xhh($payInfo , $user , $model);
                break;
            case 'manager':
                $this->manager($payInfo , $user , $model);
                break;
            case 'legobang':
                $this->legobang($payInfo , $user , $model);
                break;
                
            case 'burenshi':
                $this->burenshi($payInfo , $user , $model);
                break;
             case 'xihaha':
                $this->xihaha($payInfo , $user , $model);
            case 'rongyi':
                $this->rongyi($payInfo , $user , $model);
                break;
            case 'changlian':
                $this->changlian($payInfo , $user , $model);
                break;
            case 'new_aicai':
                $this->new_aicai($payInfo , $user , $model);
                break;
            case 'dafa':
                $this->dafa($payInfo , $user , $model);
                break;
            case 'laomao':
                $this->laomao($payInfo , $user , $model);
                break;
            case 'hyf':
                 $this->hyf($payInfo , $user , $model);
                break;
            case 'qianbaotong_alipay':
                $this->qianbaotong_alipay($payInfo , $user , $model);
                break;
            case 'qianbaotong':
                $this->qianbaotong($payInfo , $user , $model);
                break;
            case 'mimiPay':
                $this->minipay($payInfo , $user , $model);
                break;
            case 'dcpay':
                $this->dcpay($payInfo , $user , $model);
                break;
            case 'sssvips':
                $this->sssvips($payInfo , $user , $model);
                break;
            case 'yft':
                $this->yft($payInfo , $user , $model);
                break;
                case 'ymf':
                $this->ymf($payInfo , $user , $model);
                break;
            case 'alipay':
                $this->alipay($payInfo , $user , $model);
                break;
            case 'xiaoxiao':
                $this->xiaoxiao($payInfo , $user , $model);
                break;
            case 'payhui':
                $this->payhui($payInfo , $user , $model);
                break;
            case 'qiqi':
                $this->qiqi($payInfo , $user , $model);
                break;
            case 'caihong':
                $this->caihong($payInfo , $user , $model);
                break;
            case 'qumipay':
                $this->qumipay($payInfo , $user , $model);
                break;
            case 'zhengbandingcheng':
                $this->zhengbandingcheng($payInfo , $user , $model);
                break;
            case 'qxiaoge':
                $this->qxiaoge($payInfo , $user , $model);
                break;
            case 'xsdwrkj001':
                $this->xsdwrkj001($payInfo , $user , $model);
                break;
            case 'xsdwrkj002':
                $this->xsdwrkj002($payInfo , $user , $model);
                break;
            case 'yeyf003':
            $this->yeyf003($payInfo , $user , $model);
            break;
            case 'csxyst':
                $this->csxyst($payInfo , $user , $model);
                break;
            case "dingcheng":
                $this->dingcheng($payInfo , $user , $model);
                break;
            case "wechat":
                $this->wechat($payInfo , $user , $model);
                break;
            case "sanliu":
                $this->aliPay($payInfo , $user , $model);
                break;
            case "codepay_wx":
                $this->codepay_wx($payInfo , $user , $model);
                break;
            case "dp1010":
                return $this->dp1010($payInfo , $user , $model);
                break;
            case "mahuayun":
                return $this->mahuayun($payInfo , $user , $model);
                break;
            case "shunda":
                return $this->shunda($payInfo , $user , $model);
                break;
            default:
                $this->error("未匹配到{$model}支付渠道,请确认");
                break;
        }
    }
    
    //鼎城内付
    protected function dingchengpay($payInfo , $user , $model){
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];//商户id
        $appKey = $payInfo['app_key'];//商户KEY
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "dingchengpay");

        // 发起订单
        try {
            $sdk = new SDK();
            $sdk->key($appKey);
            echo $sdk->pid($appId)
                ->url($payGateWayUrl)
                ->outTradeNo($transact)
                ->type($payChannel)
                ->notifyUrl($payNotifyUrl)
                ->returnUrl($payCallBackUrl)
                ->money($payMoney)
                ->submit()
                ->getHtmlForm();
        } catch (EpayException $e) {
            echo $e->getMessage();
        }
        die;
        
    }
    
    
    protected function fangyoufang($payInfo , $user , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "fangyoufang");

           $pay_url = $payGateWayUrl;
        $merchantCode = $appId;
        $key = $appKey;
         
         
         
         
         $amt = $payMoney; //金额
        $payid = $appId; //商户id
        $paykey = $key; //商户KEY
        $path ="http://".$_SERVER['HTTP_HOST']."/fan/rquery.php"; //，您根据您的文件存放位置进行修改即可
        $payurl="http://".$_SERVER['HTTP_HOST']."/fan/submit.php";//，您根据您的文件存放位置进行修改即可
        $pdata = array(
            'url' => $payurl, //
            'id' => $payid, //商户id
            'trade_no' => $transact, //订单号
            'name' => '测试', //名称
            'money' => $payMoney, //金额'
            'notify_url' => $payNotifyUrl, //这里是通知的地址，填入要给您get数据的地址
            'return_url' => $payCallBackUrl, //这里是支付成功后跳转的地址，填入您想跳转的地址即可
            'AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'json' => 1 , //输出页面
           
            
            
        );
        $parameter = $pdata;
        unset($parameter['url']);
        ksort($parameter);
        reset($parameter);
        $fieldString = http_build_query($parameter);
        $sign = md5(substr(md5($parameter['trade_no'].$paykey),10));
        $parameter['sign']=$sign;
        $parameter['sign_type']='MD5';
        $parameter['path']=$path;
        
        
         $tm=null;
         $tm='<title>正在前往支付</title>';
         foreach ($parameter as $key => $val) {
         $tm .= '<input type="hidden" name="' . $key . '" value="' . $val . '">';
          }
        $tmp = '<form class="form-inline" id="test_form" method="PSOT" action="'.$pdata['url'].'">'.$tm
        .'<button type="submit" class="btn btn-success btn-lg">正在前往支付</button></form>'
        .'<script>var form = document.getElementById("test_form").submit();</script>';
        echo $tmp;
        
        die;
    }
    
    protected function xihaha($payInfo , $user , $model)
    {
          $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);

        	//商户ID
    	$mchId = $payInfo['pay_channel'];
    	//商户秘钥
    	$mchKey = $payInfo['app_key'];
    	//商户应用ID
    	$appId =  $payInfo['app_id'];
    	//支付产品ID
    	$productId= '8004';
    	//支付网关地址
    	$payHost = $payInfo['pay_url'];
    	
    	 $payMoney = array_get($res, 'data.price' , 0)*100; 
    	 $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "xihaha");
    
        $paramArray = array(
    		"mchId" => $mchId, //商户ID
    		"appId" => $appId,  //商户应用ID
    		"productId" => $productId,  //支付产品ID
    		"mchOrderNo" => $transact,// 商户订单号
    		"currency" => 'cny',//币种
    		"amount" => $payMoney . "", //支付金额,单位分
    		//"clientIp" => '210.73.10.148',   //客户端IP
    		//"device" => 'ios10.3.1',    //客户端设备
    		"returnUrl" => $payCallBackUrl,	 //支付结果前端跳转URL
    		"notifyUrl" => $payNotifyUrl,	 //支付结果后台回调URL
    		"subject" => '网络购物',	 //商品主题
    		"body" => '网络购物',	 //商品描述信息
    		//"param1" => '',	 //扩展参数1
    		//"param2" =>  '',	 //扩展参数2
    		"extra" =>  '附加参数'	 //附加参数
        );
        file_put_contents(ROOT_PATH."fq.txt","订单处理返回结果 老陈".json_encode($paramArray,1).PHP_EOL,FILE_APPEND);
    	$sign =self::paramArraySign($paramArray, $mchKey);  //签名
    	$paramArray["sign"] = $sign;
       
    	$paramsStr = http_build_query($paramArray); //请求参数str
    	$response = self::httpPost($payHost . "/api/pay/create_order", $paramsStr);

    	$resjson = json_decode($response, true);
        echo $resjson['payParams']['payUrl'];

        
    }
    
    
	function httpPost($url, $paramStr){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $paramStr,
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  return $err;
		}
		return $response;
	}
	
	function paramArraySign($paramArray, $mchKey){
		
		ksort($paramArray);  //字典排序
		reset($paramArray);
	
		$md5str = "";
		foreach ($paramArray as $key => $val) {
			if( strlen($key)  && strlen($val) ){
				$md5str = $md5str . $key . "=" . $val . "&";
			}
		}
		$sign = strtoupper(md5($md5str . "key=" . $mchKey));  //签名
		
		return $sign;
		
	}
	
    protected function shenyupay($payInfo , $user , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "shenyupay");

           $pay_url = $payGateWayUrl;
        $merchantCode = $appId;
        $key = $appKey;
         
         
         $param = [
            'pid'=>$appId,
            'name'=>'一双小拖鞋',
            'type'=>$payChannel,
            'money'=>$payMoney,
            'out_trade_no'=>$transact,
            'notify_url'=>$payNotifyUrl,
            'return_url'=>$payCallBackUrl
            ];
            
            
            $signPars = "";
            ksort($param);
            foreach ($param as $k => $v) {
            if ("sign" != $k) {
            $signPars .= $k . "=" . $v . "&";
            }
            }
            $signPars = rtrim($signPars, '&');
            $signPars .= $key;
            $sign = md5($signPars); // 此处要md5加密小写
            
            $param['sign'] = $sign;
            
            

         
             $htmls = "<form id='aicaipay' name='aicaipay' action='" . $pay_url . "' method='get'>";
        foreach ($param as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);
    }
    
    
    protected function shehuang168($payInfo , $user , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "shehuang168");

           $pay_url = $payGateWayUrl;
        $merchantCode = $appId;
        $key = $appKey;
         
         
         $param = [
            'pid'=>$appId,
            'name'=>'一双小拖鞋',
            'type'=>$payChannel,
            'money'=>$payMoney,
            'out_trade_no'=>$transact,
            'notify_url'=>$payNotifyUrl,
            'return_url'=>$payCallBackUrl
            ];
            
            
            $signPars = "";
            ksort($param);
            foreach ($param as $k => $v) {
            if ("sign" != $k) {
            $signPars .= $k . "=" . $v . "&";
            }
            }
            $signPars = rtrim($signPars, '&');
            $signPars .= $key;
            $sign = md5($signPars); // 此处要md5加密小写
            
            $param['sign'] = $sign;
            
            

         
             $htmls = "<form id='aicaipay' name='aicaipay' action='" . $pay_url . "' method='get'>";
        foreach ($param as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);


            
         
    }
    
    protected function kangxinlianmeng($payInfo , $user , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "kangxinlianmeng");

           $pay_url = $payGateWayUrl;
        $merchantCode = $appId;
        $key = $appKey;
            
            
          $params = array(
            'pid'=>$appId,//对接ID
            'type'=>$payChannel,//支付方式
            'out_trade_no'=>$transact,//商户订单号
            'notify_url'=>$payNotifyUrl,//异步回调地址
            'return_url'=>$payCallBackUrl,//同步跳转地址
            'name'=>'商品',//商品名称
            'money'=>$payMoney,//金额，单位：元
            'sitename'=>'网站普通',//网站标题
        );
     
        
        $data = $params;
            
            $data = array_filter($data);
    if (get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }
    ksort($data);
    $str1 = '';
    foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
    }
    $str = $str1 . $key;
    $str = trim($str, '&');
    $sign = md5($str);
    
   // $params['sign'] = $sign;
    
        
        
    
    // 前往支付
    $pay_url = $pay_url . '/pay/index/submit?pid='.$params['pid'].'&type='.$params['type'].'&out_trade_no='.$params['out_trade_no'].'&notify_url='.rawurlencode($params['notify_url']).'&return_url='.rawurlencode($params['return_url']).'&name='.rawurlencode($params['name']).'&money='.$params['money'].'&sitename='.rawurlencode($params['sitename']).'&sign='.$sign.'&sign_type=MD5';

    header("Location: $pay_url");//跳转到支付地址
    exit();
    
    
		
		
	 
	
	    
    }
    
    
    protected function manager($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "manager");

           $domain = $payGateWayUrl;
        $merchantCode = $appId;
        $merchantKey = $appKey;
            
            
          $bodyJson['amount'] = $payMoney * 100;
          $bodyJson['channelType'] = '2:1';
          $bodyJson['merchantOrderCode'] = $transact;
          $bodyJson['noticeUrl'] = $payNotifyUrl;
          $bodyJson['returnUrl'] = $payCallBackUrl;
        
          $signStr = '';
          foreach ($bodyJson as $key => $value){
            $signStr .= $key . '=' . $value;
          }
          $signStr .= 'key=' . $merchantKey;
        
          $requestJson['merchantCode'] = $merchantCode;
          $requestJson['sign'] = md5($signStr);
          $requestJson['body'] = $bodyJson;
        
          $ch = curl_init($domain . '/order/payment/create');
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestJson));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          $response = curl_exec($ch);
          curl_close($ch);
        
          $d = json_decode($response,1);
          if($d['code'] == 200)
          {
              
              $jump_url = $d['body']['paymentUrl'];
               echo '<script>window.location.href="'.$jump_url.'";</script>';
               die;

          }
          
          exit($d['message']);die;
        
	
	    
    }
    
    protected function legobang($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "legobang");


        //通道名称
        $inlet = 'qqgame';
        //支付方式 1为二维码 2为网页
        $mode = 1;

        $data = [
            'appid'        => $appId,
            'pay_type'     => $payChannel,
            'out_order_no' => $transact,
            'money'       =>sprintf("%.2f",$payMoney),
        	'inlet'       => $inlet,
            'mode'       => $mode,
            'notify_url' => $payNotifyUrl,
            'success_url'  => $payCallBackUrl,
            'error_url'    => $payCallBackUrl,
        ];
        
        
         $data = array_filter($data);

        //签名步骤一：按字典序排序参数
        ksort($data);
        $string_a = http_build_query($data);
        $string_a = urldecode($string_a);

        //签名步骤二：在string后加入mch_key
        $string_sign_temp = $string_a . "&key=" . $appKey;

        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);

        // 签名步骤四：所有字符转为大写
        $sign = strtoupper($sign);
        
        $data['sign'] = $sign;
        
        
        
        $res = $this->curlPost($payGateWayUrl , $data);
        $res = json_decode($res, true);
        
        if($res['status'] == 1)
        {
                    echo '<script>window.location.href="'.$res['result']['weburl'].'";</script>';
                    
                    die;

        }
        
        
       // dump($res);die;
        
        
        

        
        
        //$this->jumpPost($payGateWayUrl , $data);
        //die;
        
	
	    
    }
    
    
    protected function burenshi($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "burenshi");


      
  
       $type = $payChannel;
       $Md5key = $appKey;
       $url  = $payGateWayUrl;
        $pay_applydate = date("Y-m-d H:i:s");  //订单时间
        $pay_bankcode = $payChannel;   //银行编码
        $native = array(
            "pay_memberid" => $appId,
            "pay_orderid" => $transact,
            "pay_amount" => $payMoney,
            "pay_applydate" => $pay_applydate,
            "pay_bankcode" => $pay_bankcode,
            "pay_notifyurl" => $payNotifyUrl,
            "pay_callbackurl" => $payCallBackUrl,
        );
        ksort($native);
        $md5str = "";
        foreach ($native as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        //echo($md5str . "key=" . $Md5key);
        $sign = strtoupper(md5($md5str . "key=" . $Md5key));
        $native["pay_md5sign"] = $sign;
        $native['pay_attach'] = "1234|456";
        $native['pay_productname'] ='VIP基础服务';
        
        
        $this->jumpPost($payGateWayUrl , $native);
        die;
        
	
	    
    }
    
    protected function rongyi($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "rongyi");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
    
        $param = [];
        $param['out_trade_no'] = $transact;
        $param['total_amount'] = $payMoney * 100;
        $param['access_id']    = $appId;
        $param['notify_url']   = $payNotifyUrl;
        $param['return_url']   = $payCallBackUrl;
        $_timestamp  = date("YmdHis");
        $param['timestamp']    = $_timestamp;
        
        $param['subject']      = "test";
        $param['create_ip']    = $this->getIP();
        
        
        
        $param['sign']         = $this->getSignss($param,$appKey);
       // $res = $this->curlPost($payGateWayUrl , $param);
    //    var_dump($res);die;
        $jump_url = $payGateWayUrl.'?'.http_build_query ($param);
        echo '<script>window.location.href="'.$jump_url.'";</script>';
        exit;
	
	    
    }
    
    
    
    function curlPost($url = '', $postData = '', $options = array())
    {
    if (is_array($postData)){
        $postData = http_build_query($postData);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if (!empty($options)){
        curl_setopt_array($ch, $options);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
    }


    function getSignss(array $data, $appSecret)
{
    ksort($data);
    $buff = "";
    foreach ($data as $k => $v) {
        if ($k != "sign" && $v !== "" && !is_array($v)) {
            $buff .= $k . "=" . $v . "&";
        }
    }
    $buff = trim($buff, "&");
    $sign_md5 = $buff. "&key=" . $appSecret;
    //写入日志
    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/demo_v3/log.txt', $sign_md5."\n", FILE_APPEND);
    return md5($sign_md5);
}
    function getIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

    protected function changlian($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "changlian");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
    

	
	    $appKey = $appKey;
	    
	    $m = $this->payTypes();
        $appSecret = $appKey;
        $data = [
               'appid' => $appId,
               'out_trade_no' => $transact,
               'amount' => sprintf("%.2f",$payMoney),
               'extend' => '{"body":"商品描述"}',
               'pay_type' => $payChannel,
               'callback_url' => $payNotifyUrl,
               'success_url' => $payCallBackUrl,
               'error_url' => $payNotifyUrl
        ];




        // 去空
        $data = array_filter($data);
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string_a = http_build_query($data);
        $string_a = urldecode($string_a);
        //签名步骤二：在string后加入KEY
        
        $string_sign_temp = $string_a . "&key=" . $appKey;
        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);
        // 签名步骤四：所有字符转为大写
        $result = strtoupper($sign);

       

        $data['sign'] = $result;
        
        
        
        $this->jumpPost($payGateWayUrl , $data);
        
        
        die;
    }
    
    protected function new_aicai($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "new_aicai");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
    

	
	    $appKey = $appKey;
	    
	    $m = $this->payTypes();
        $appSecret = $appKey;
        
        //Tenxunwx腾讯微信区  Wxqrcode微信个码 Douyin 抖音币   Ccpay  cc直播  Dhb电魂币 Jdphone京东话费  Ddkh点点开黑  Dd373 373支付宝
        $code = "Wxqrcode";
        $data = [
               'mchId' => $appId,
               'billNo' => $transact,
               'totalAmount' => $payMoney * 100,
               'billDesc' => 'test',
               'way' => $m,
               'payment' => "wechat",//支付通道 wechat  / alipay
               'code' => $payChannel,
               'notifyUrl' => $payNotifyUrl,
               'returnUrl' => $payCallBackUrl,
        ];




        ksort ( $data );
        $str = '';
        foreach ( $data as $k => $v ) {
            if ($k != "sign" && $v != "") {
                $str .= $k . "=" . $v . "&";
            }
        }
        $sign =  strtoupper ( md5 ( $str . "key=" . $appSecret ) );

        $data['sign'] = $sign;
        
        
        
        $ret = $this->curl ( $payGateWayUrl, json_encode ( $data ) );
        
        $ret = json_decode($ret , 1);
        if($ret['code'] == 0)
        {
            header("Location:".$ret['result']['linkUrl']);
             die;
        }
           
     //   dump($ret);die;
	
    die;
    }
    protected function dafa($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "dafa");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
    

	
	$appKey = $appKey;
	$data=[
        'mchid'=>$appId,
    	
    	'out_trade_no'=>$transact,
    	'notify_url'=>$payNotifyUrl,
    	'callback_url'=>$payCallBackUrl,
    	
    	'total_fee'=>$payMoney * 100,
    	
	];
	


    
    ksort($data);
    $need = [];
    foreach ($data as $key => $value) {
        if (! $value || $key == 'sign') {
            continue;
        }
        $need[] = "{$key}={$value}";
    }
    $string = implode('&', $need).$appKey;

    $sign =  strtoupper(md5($string));
    
    
    $data['sign'] = $sign;
    

    
    
    
    
         $url = "$payGateWayUrl?".http_build_query($data);
         
         
	
    header("Location:".$url);
    die;
    }
    
    protected function laomao($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "laomao");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
    

	
	$appKey = $appKey;
	$options=[
        'pid'=>$appId,
    	'type'=>$payChannel,
    	'out_trade_no'=>$transact,
    	'notify_url'=>$payNotifyUrl,
    	'return_url'=>$payCallBackUrl,
    	'name'=>'test',
    	'money'=>$payMoney,
    	'sitename'=>''
	];
	


    $signPars = "";
	ksort($options);
	foreach ($options as $k => $v) {
		if ($k!="sign"&&$v!="") {
			$signPars .= $k . "=" . $v . "&";
		}
	}
	$signPars = rtrim($signPars, '&');
	$signPars .= $appKey;
	$sign = md5($signPars);
	
    $options['sign']=$sign;
    $options['sign_type']='MD5';
    
    
    
    
    
        $url = $payGateWayUrl."?".http_build_query($options);
    
    
    
            echo "<script>location.href='$url';</script>";
            
            die;
    }
    protected function hyf($payInfo , $user , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        
           
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "hyf");


      
  
       $type = $payChannel;
       $key = "lcspb7hs8qa5l9e1q9n1rffjsw8masyn";
       $url  = $payGateWayUrl;
       $paykey = $appKey;
       $payurl = $url;
    

        $array = array(
            "merchant_no" => $appId,
             'amount' => $payMoney,
            "order_no" => $transact,
            'order_time' => time(),
            "notify_url" => $payNotifyUrl,
            'front_url' => $payCallBackUrl,
        );
        ksort($array);
        $tmp = array();
        foreach ($array as $k => $param) {
            $tmp[] = $k . '=' .  $param;
        }
        $string = implode('&', $tmp) . '&key=' . $key;
        
    	$sign = md5($string);
        
        $array['sign'] = $sign;
        
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$payGateWayUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        $data = json_decode($data , true);
        
        if($data['result'] == 1)
        {
            
          
            header("Location:{$data['data']['pay_url']}");
            die;
        }
        
        
    //    dump($data);
        die;
    }
    
    
    protected function qianbaotong_alipay($payInfo , $user , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        
           
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "qianbaotong");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
       $paykey = $appKey;
       $payurl = $url;
    

        $parameter = array(
            "MrchtID" => $appId,//1016捕鱼 
            "MrchtOrderNo" => $transact,
            'Product' => 'test',
            'Currency' => '4217',
            'TotalAmt' => $payMoney * 100,
            "NotifyURL" => $payNotifyUrl,
            'NonceStr' => rand(100,300),
        
          
        );
        
        

       
        $sign = $this->makeSignss($parameter , $paykey );
        $parameter['Signature'] = $sign;
        $data_string = json_encode($parameter);
        $ch = curl_init($payGateWayUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
         
        $result = curl_exec($ch);


        $result = json_decode($result , true);
        
        
        
        
        
        
        
        if($result['Result'] == "SUCCESS")
        {
            
            $path = "http://" . $_SERVER['HTTP_HOST'] . "/index/trading/checkOrderStatus";
         $root_path='http://'.$_SERVER['HTTP_HOST'].'/yimiao/resouce/q.php?f='.id_encode($this->id) . '&out_trade_no=' . $transact . '&code_url=' . urlencode($result['Content']) ."&transact=".id_encode($transact). '&amount=' . $payMoney . '&return_url=' . $payCallBackUrl."&path={$path}";

              
           
            
            header("Location:$root_path");
            die;
             
        }
        
        exit($result);
        
        
      
    }
    
    
    
    
    protected function qianbaotong($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        
           
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "qianbaotong");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
       $paykey = $appKey;
       $payurl = $url;
    

        $parameter = array(
            "MrchtID" => $appId,//1016捕鱼 
            "MrchtOrderNo" => $transact,
            'Product' => 'test',
            'Currency' => '4217',
            'TotalAmt' => $payMoney * 100,
            "NotifyURL" => $payNotifyUrl,
            'NonceStr' => rand(100,300),
        
          
        );

       
        $sign = $this->makeSignss($parameter , $paykey );
        $parameter['Signature'] = $sign;
        $data_string = json_encode($parameter);
        $ch = curl_init($payGateWayUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
         
        $result = curl_exec($ch);


        $result = json_decode($result , true);
        
        
        
        
        if($result['Result'] == "SUCCESS")
        {
            
                $path = "http://" . $_SERVER['HTTP_HOST'] . "/index/trading/checkOrderStatus";
            $tjdata = 'wxurl=' . $result['CodeURL'] . "&money=".$payMoney."&path={$path}&f=".id_encode($this->id)."&transact=".id_encode($transact)."&return={$payCallBackUrl}";
            $tjurl = "http://" . $_SERVER['HTTP_HOST'] . "/pay/2dcdc/q.php?" . $tjdata; //付款页面文件的路径  请注意路径
             header("Location:$tjurl");die;

        }
        
        
        
        $purl = $payGateWayUrl . "?" . http_build_query($parameter) . "&sign=" . $sign ;
        
        header("Location:{$purl}");
        die;
    }
    
    
    private function makeSignss($arr, $cert)
    {
        //sign = Md5(原字符串&key=商户密钥).toUpperCase.
        
        $arr = array_filter($arr);
        if (isset($arr['sign'])) {
            unset($arr['sign']);
        } 
        ksort($arr);
        $str = http_build_query($arr);
        
        
        $str = urldecode($str).'&key='.$cert;
        $str = md5($str);
        return  strtoupper($str);
    }
    
    
    protected function minipay($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        
           
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "minipay");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
       $paykey = $appKey;
       $payurl = $url;
    

        $parameter = array(
            "key" => $appKey,//1016捕鱼 
            "fee" => $payMoney * 100,
            'body' => 'test',
            'order' => $transact,
            'randStr' => rand(100,333),
            "notice_url" => $payNotifyUrl,
            "notify" => $payCallBackUrl,
          
        );


        
    
        
        $sign = $this->makeSign($parameter , $appId );
        
        
        
        $purl = $payGateWayUrl . "?" . http_build_query($parameter) . "&sign=" . $sign ;
        
        header("Location:{$purl}");
        die;


        
    }
    
    
    /**
     * 签名
     * $arr  参与签名的数组
     * $cert 用户密钥
     */
    private function makeSign($arr, $cert)
    {
        
        $arr = array_filter($arr);
        if (isset($arr['sign'])) {
            unset($arr['sign']);
        } 
        ksort($arr);
        $str = http_build_query($arr);
        
        $str = urldecode($str).'&cert='.$cert;
        $str = md5($str);
        return  strtoupper($str);
    }
    
    
    
     protected function dcpay($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        
           
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "dcpay");


      
  
       $type = $payChannel;
       $key = $appKey;
      $url  = $payGateWayUrl;
      $paykey = $appKey;
      $payurl = $url;
    

        $parameter = array(
    "mtype" => $type,//1016捕鱼 
    "id" => $appId,
    "notify_url" => $payNotifyUrl,
    "return_url" => $payCallBackUrl,
    "trade_no" => $transact,//订单号
    "name" => '测试', //名称
    "money" => $payMoney,//金额为整数型 字符串会导致签名失败
    "json" => '1'//保持
);



$path = "http://" . $_SERVER['HTTP_HOST'] . "/pay/rquery.php";//此文件路径要对 不然没有同步回调
ksort($parameter);
reset($parameter);
$fieldString = [];
foreach ($parameter as $key => $value) {
    if (!empty($value)) {
        $fieldString[] = $key . "=" . $value . "";
    }
}
$fieldString = implode('&', $fieldString);
$sign = md5($fieldString . $paykey);
$purl = $payurl . "?" . $fieldString . "&sign=" . $sign . "&sign_type=MD5";
$data = file_get_contents($purl);
$data = json_decode($data, true);
$tjurl = $data['url'];
$data = $data['data'];
$header = array('Ktype:iscurl', 'User-Agent:' . $_SERVER['HTTP_USER_AGENT']);
$data = $this->http_post($tjurl, $header, $data);
$fdata = json_decode($data, true);
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {//判断是否在微信里打开 
    if ($fdata['code'] == 1) {//微信内扫码付款

        $tjdata = 'wxurl=' . $fdata['wxurl'] . '&sign=' . $fdata['sign'] . '&serial_no=' . $fdata['serial_no'] . '&qtype=' . $fdata['qtype'] . '&url=' . $fdata['url'] . '&return=' . $parameter['return_url'] . '&path=' . $path;
        //$tjurl路径要对
        $tjurl = "http://" . $_SERVER['HTTP_HOST'] . "/pay/2dcdc/bypay.php?" . $tjdata; //付款页面文件的路径  请注意路径

        header("Location:$tjurl");
    } else {
        echo('error');
    }
} else {
    if ($fdata['code'] == 1) {//h5拉起付款


        $tjdata = 'wxurl=' . $fdata['wxurl'] . '&sign=' . $fdata['sign'] . '&serial_no=' . $fdata['serial_no'] . '&qtype=' . $fdata['qtype']  . '&return=' . $parameter['return_url'] . '&path=' . $path . '&money=' . $parameter['money'];
        //$tjurl路径要对
        $tjurl = "http://" . $_SERVER['HTTP_HOST'] . "/pay/2dcdc/byh5.php?" . $tjdata; //付款页面文件的路径    请注意路径
        header("Location:$tjurl");
    } else {
        print_r($fdata);die;
        echo('error');
    }
}

        
    }
    
    
    protected function ymf($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "ymf");


      
  
       $type = $payChannel;
       $key = $appKey;
      $url  = $payGateWayUrl;
      
     $url = 'http://'.file_get_contents($url).'/api/do_pay';

    $data = [
        'id'           => $appId,
        'out_trade_no' => $transact,
        'name'         => 'test',
        'type'         => $payChannel,
        'money'        => $payMoney,
        'mchid'        => '',
        'notify_url'   => $payNotifyUrl,
        'return_url'   => $payCallBackUrl,
    ];
    $data = array_filter($data);
    if (@get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }
    ksort($data);
    $str1 = '';
    foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
    }

    $sign = md5(trim($str1 . $key, '&'));

    $data['sign']      = $sign;
    $data['sign_type'] = 'MD5';
    
    $htmls = "<form id='aicaipay' name='aicaipay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);
        
    }
    protected function sssvips($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "sssvips");


      
  
       $type = $payChannel;
       $key = $appKey;
       $url  = $payGateWayUrl;
    

	
	$appKey = $appKey;
	$options=[
        'pid'=>$appId,
    	'type'=>$payChannel,
    	'out_trade_no'=>$transact,
    	'notify_url'=>$payNotifyUrl,
    	'return_url'=>$payCallBackUrl,
    	'name'=>'test',
    	'money'=>$payMoney,
    	'sitename'=>''
	];


    $signPars = "";
	ksort($options);
	foreach ($options as $k => $v) {
		if ($k!="sign"&&$v!="") {
			$signPars .= $k . "=" . $v . "&";
		}
	}
	$signPars = rtrim($signPars, '&');
	$signPars .= $appKey;
	$sign = md5($signPars);
	
    $options['sign']=$sign;
    $options['sign_type']='MD5';
    
    
    
    
    
    $url = $payGateWayUrl."?".http_build_query($options);
    
    
            echo "<script>location.href='$url';</script>";
            
            die;

        

    }
    
     protected function alipay($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "alipays");


        
        $data = [
            
            'money' => $payMoney,
            'out_trade_no' => $transact,
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,

        ];
        
        
        $url = http_build_query($data);

        $payDomain = getDomain(2);
        
        $payDomain = $payDomain."/alipay/wappay/pay.php?".$url;
        
        header("Location:{$payDomain}");
        die;
        
        
        

    }
    
    
    protected function yft($payInfo , $user , $model)
    {
        
        
        $transact = date("YmdHis") . rand(100000, 999999);
        
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        
           if(!isset($_GET['openid'])){
       // $url = 'http://pay.amghzqc.cn/api/pay/openid';//正常模式
         $url = 'http://pay.amghzqc.cn/api/pay/ds_openid';//代收模式
        $data = [];
        $data['seller_id'] = $appId;
        $data['redirect_url'] = urlencode('http://'.$_SERVER['HTTP_HOST'].'/index/trading/index?v=2&ds=2&'.http_build_query($this->request->param()));//此链接为接收openid和sub_mch_id链接可自行定义
        $url = $url."?".http_build_query($data);

        header("Location:".$url);//个别防封系统请使用这个跳转 这个删除
        exit;
    }
    
        $res = $this->createOrder($user , $transact , $model);

        
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "yft");


        $appSecret = $appKey;
       

        
        
        
        
     
        //$url = 'http://pay.amghzqc.cn/api/pay/pay';//正常模式
         $url = 'http://pay.amghzqc.cn/api/pay/daishou';//代收模式

        $skey = $appKey;//支付密钥后台获取
        $data = [];
        $data['pay_sn']         = $transact;
        $data['order_amount']   = $payMoney; //以元为单位
        $data['seller_id']      = $appId;//商户ID 后台可获取
        $data['sub_mch_id']     = $_GET['sub_mch_id'];//子商户ID 后台申请可获取不填 可自动轮训商户 收满额度自动关闭
        $data['notify_url']     = $payNotifyUrl;//异步回调地址
        $data['return_url']     = $payCallBackUrl;//同步回调地址
        $data['pay_type']       = $payChannel;//公众号支付:Wxgzh 扫码支付:wxsm
        $data['openid']         = $_GET['openid'];//公众号支付:Wxgzh 扫码支付:wxsm
        
        
        ksort($data);
        $sign = '';
        foreach ($data as $key => $value) {
          $sign .= $value;
        }
        $sign = md5($sign.$skey);
        $data['sign'] = $sign;
        
        $row_curl = curl_init();
        curl_setopt($row_curl, CURLOPT_URL, $url);
        curl_setopt($row_curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($row_curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($row_curl, CURLOPT_CONNECTTIMEOUT , 30);
        curl_setopt($row_curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($row_curl, CURLOPT_POST, 1);
        curl_setopt($row_curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($row_curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($row_curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($row_curl);
        $data = json_decode($data,true);
        curl_close($row_curl);
        $url = $data['datas']['url'];
        header("Location:".$url);//个别防封系统请使用这个跳转 这个删除
        exit;
        
        

        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $url . "' method='post'>";
       
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);die;
        

    }
    protected function xiaoxiao($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "xiaoxiao");


      
  
       $type = $payChannel;
       $key = $appKey;
      $url  = $payGateWayUrl;
    $data = [
        'id'           => $appId,
        'out_trade_no' => $transact,
        'name'         => 'test',
        'type'         => $payChannel,
        'money'        => $payMoney,
        'mchid'        => '',
        'notify_url'   => $payNotifyUrl,
        'return_url'   => $payCallBackUrl,
    ];
    $data = array_filter($data);
    if (@get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }
    ksort($data);
    $str1 = '';
    foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
    }

    $sign = md5(trim($str1 . $key, '&'));

    $data['sign']      = $sign;
    $data['sign_type'] = 'MD5';

	if ($type == 900) {
        $info = $this->posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            //发起支付失败，记录失败信息
            file_put_contents('alipay_error.txt', '发起支付异常：' . $info['message'].'---'.date("Y-m-d H:i:s",time()), FILE_APPEND);
            exit;
        }
        $info=$info['data'];
        $root_path='http://'.$_SERVER['HTTP_HOST'].'/yimiao/resouce/alipay.php?uid=' . $info['uid'] . '&out_trade_no=' . $info['out_trade_no'] . '&code_url=' . $info['code_url'] . '&amount=' . $info['amount'] . '&return_url=' . $info['return_url'];
        echo "<script>location.href='$root_path';</script>";
    }elseif ($type == 905) {
        $info = $this->posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            //发起支付失败，记录失败信息
            file_put_contents('wechat_native.txt', '发起支付异常：' . $info['message'] . '---' . date("Y-m-d H:i:s", time()), FILE_APPEND);
            exit;
        }
        $info      = $info['data'];
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/native.php?uid=' . $info['uid'] . '&trade_no=' . $info['trade_no'] . '&pay_url=' . $info['pay_url'] . '&amount=' . $info['amount']
            . '&return_url=' . $info['return_url'] . '&name=' . $info['name'];
        echo "<script>location.href='$root_path';</script>";
    }else if ($type == 906 || $type == 907 || $type == 912) {
        $info = $this->posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            exit;
        }
        $info      = $info['data'];//如果是YY通道需要使用支付宝或者是龙珠通道，请把下一行的yypay.php更换为yyalipay.php
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/yypay.php?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'];
        echo "<script>location.href='$root_path';</script>";
    }else if ($type == 908) {
        $info = $this->posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message'];
            exit;
        }
        $info      = $info['data'];
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/kuaipay.php?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'];
        echo "<script>location.href='$root_path';</script>";
    }elseif ($type == 910) {
        $info = $this->posturl($url, $data);
        if ($info['code'] == 400) {
            echo $info['message']; //重要信息yypay.php页面的jquery.min.js请注意相对路径是否跟您的路径一致
            exit;
        }
        $info      = $info['data'];
        $root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/yimiao/resouce/uualipay.php?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'];
        echo "<script>location.href='$root_path';</script>";
    }elseif ($type == 911) {
		$info = $this->posturl($url, $data);
		
		if ($info['code'] == 400) {
			echo $info['message'];
			exit;
		}
		
		$info      = $info['data'];
		if($info['pay_type']=="wechat"){
            $pay_page="yypay.php";
        }else{
            $pay_page="yyalipay.php";
        }
		$root_path = 'http://' . $_SERVER['HTTP_HOST'] . '/xiaopay/resouce/'.$pay_page.'?uid=' . $info['uid'] . '&pay_url=' . $info['pay_url'] . '&return_url=' . $info['return_url'] . '&user_order_num=' . $info['user_order_num'] . '&money=' . $info['money'].'&pay_code='.$info['pay_code'];
		echo "<script>location.href='$root_path';</script>";
	}else {
        $htmls = "<form id='wsypay' name='wsypay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['wsypay'].submit();</script>";
        exit($htmls);
    }
        

    }
    
    
    protected function posturl($url, $data)
    {
    $data        = json_encode($data);
    $headerArray = array("Content-type:application/json;charset='utf-8'", "Accept:application/json");
    $curl        = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return json_decode($output, true);
    }
    protected function payhui($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "payhui");


        $appSecret = $appKey;
        $data = [
            'pid' => $appId,
            'type' => $payChannel,
            'money' => $payMoney,
            'name' => 'test',
            'out_trade_no' => $transact,
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,

        ];

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }

        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';

        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $payGateWayUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);die;
        

    }
    
    protected function qiqi($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "qiqi");



        $m = $this->payTypes();
        $appSecret = $appKey;
        $data = [
            'mchId' => $appId,
            'way' => $m,
            'totalAmount' => $payMoney * 100,
            'billDesc' => 'test',
            'billNo' => $transact,
            'payment' => "$payChannel",
            'notifyUrl' => $payNotifyUrl,
            'returnUrl' => $payCallBackUrl,

        ];



        ksort ( $data );
        $str = '';
        foreach ( $data as $k => $v ) {
            if ($k != "sign" && $v != "") {
                $str .= $k . "=" . $v . "&";
            }
        }
        $sign =  strtoupper ( md5 ( $str . "key=" . $appSecret ) );

        $data['sign'] = $sign;

        $ret = $this->curl ( $payGateWayUrl, json_encode ( $data ) );


        
        
        
        
        $payDomain = getDomain(2);
        $checkUrl = "$payDomain/index/trading/checkOrderStatus?f=".id_encode($user['id'])."&transact=".id_encode($transact); //主动查单地址

    

        $datas = json_decode ( $ret, true );

        $datas['result']['totalAmount'] = $payMoney;
        $datas ['result']["returnUrl"] = $data["returnUrl"];
        $datas ['result']["checkUrl"] = $checkUrl;
        
      
        
        if ($datas ['code'] != 0)
        {
         //   dump($datas);die;
        }
        
        if($m == "qrcode")
        {
           $turl ="/qiqi/pay.php";
        }
        else
        {
            
           //$turl ="/qiqi/h5.php";
           $url = $datas['result']['linkUrl'];
            header("Location:{$url}");
            die;
        }
        
        
        
        
        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $turl . "' method='post'>";
        foreach ($datas['result'] as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);die;
        

    }


    protected function payTypes(){
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
            return "qrcode";
        } else {
            return "wap";
        }
    }
    
    
    protected function qumipay($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        
        
        $payNotifyUrl = $this->getNotifyUrl( [], "qumipay");


        $appSecret = $appKey;
        $data = [
            'pid' => $appId,
            'type' => $payChannel,
            'money' => $payMoney,
            'name' => 'test',
            'out_trade_no' => $transact,
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,

        ];
        
        

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }

        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';

        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $payGateWayUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);die;



    }

    protected function caihong($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "caihong");


        $appSecret = $appKey;
        $data = [
            'pid' => $appId,
            'type' => $payChannel,
            'money' => $payMoney,
            'name' => 'test',
            'out_trade_no' => $transact,
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,

        ];

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }

        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';

        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $payGateWayUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);die;



    }
    protected function qxiaoge($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "qxiaoge");


        $appSecret = $appKey;
        $data = [
            'mchid' => $appId,
            'out_trade_no' => $transact,
            'total_fee' => $payMoney * 100,
            'notify_url' => $payNotifyUrl,
            'callback_url' => $payCallBackUrl,
        ];
        ksort($data);
        $need = [];
        foreach ($data as $key => $value) {
            if (! $value || $key == 'sign') {
                continue;
            }
            $need[] = "{$key}={$value}";
        }
        $string = implode('&', $need).$appSecret;
        $sign = strtoupper(md5($string));

        $data['error_url']		= '';//支付失败同步回调地址，不参与签名

        $data['sign'] = $sign;
        $url = $payGateWayUrl.http_build_query($data);



        header("Location:".$url);

    }
    protected function xsdwrkj002($payInfo , $user , $model)
    {

        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "xsdwrkj002");


        $key = $appKey;
        $data = [
            'pid' => $appId,
            'out_trade_no' => $transact,
            'name' => "test",
            'type' => $payChannel,
            'money' => round($payMoney * 1.4),
            //'mchid' => '5jl5dXZ5ss7R2DGks9GS',
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,
        ];

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $url = $payGateWayUrl;
        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';



        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);

    }
    
    protected function yeyf003($payInfo , $user , $model)
    {

        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "yeyf003");


        $key = $appKey;
        $data = [
            'pid' => $appId,
            'out_trade_no' => $transact,
            'name' => "test",
            'type' => $payChannel,
            'money' => $payMoney,
            //'mchid' => '5jl5dXZ5ss7R2DGks9GS',
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,
        ];

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $url = $payGateWayUrl;
        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';



        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);

    }
    
    protected function xsdwrkj001($payInfo , $user , $model)
    {

        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "xsdwrkj001");


        $key = $appKey;
        $data = [
            'pid' => $appId,
            'out_trade_no' => $transact,
            'name' => "test",
            'type' => $payChannel,
            'money' => $payMoney,
            //'mchid' => '5jl5dXZ5ss7R2DGks9GS',
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,
        ];

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $url = $payGateWayUrl;
        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';



        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);

    }
    protected function csxyst($payInfo , $user , $model)
    {

        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "csxyst");

        $url = $payGateWayUrl;
        $data = [
            'id' => $appId,
            'out_trade_no' => $transact,
            'name' => "test",
            'type' => $payChannel,
            'money' => $payMoney,
            'mchid' => '',
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,
        ];

        $data = array_filter($data);
        if (@get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }

        $key = $appKey;
        $sign = md5(trim($str1 . $key, '&'));

        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';

        $htmls = "<form id='aicaipay' name='aicaipay' action='" . $url . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
        exit($htmls);
    }
    protected function zhengbandingcheng($payInfo , $user , $model)
    {

        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "zhengbandingcheng");

        $payurl = $payGateWayUrl; //支付网关联系客服获取
//-----------------------------统一下单接口-----------------------------------------


        $paydata = array (
            'mchId' => $appId, //商户ID，后台提取
            'billNo' => $transact, //商户订单号
            'totalAmount' => $payMoney*100, //金额
            'billDesc' => "在线充值", //商品名称
            'way' => $this->payType(), //支付模式
            'payment' => $payChannel, //微信支付
            'notifyUrl' => $payNotifyUrl, //回调地址
            'returnUrl' => $payCallBackUrl, //同步跳转
            'attach' => "",
            "accKey" => "" //收款账号
        );



        $Md5key = $appKey; //签名密钥，后台提取
        $paydata ['sign'] = $this->markSign ( $paydata, $Md5key );

        file_put_contents(ROOT_PATH."pay.txt","下单".json_encode($paydata , 1).PHP_EOL,FILE_APPEND);

        //$payUrl = "http://$payurl/game/unifiedorder"; //请求订单地址
        // $checkUrl = "http://$payurl/pay/checkTradeNo"; //主动查单地址


        $ret = $this->curl ( $payGateWayUrl, json_encode ( $paydata ) );



        $data = json_decode ( $ret, true );
        $data['result']['totalAmount'] = $payMoney;
        $data['result']['returnUrl'] = $payCallBackUrl;





        if ($data ['code'] == 0)
        {

            $url = $data['result']['linkUrl'];
            header("Location:{$url}");
            die;

        } else {
            exit ( $data ['message'] );
        }

    }
    protected function dingcheng($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "dingcheng");

        $payurl = $payGateWayUrl; //支付网关联系客服获取
//-----------------------------统一下单接口-----------------------------------------


        $paydata = array (
            'mchId' => $appId, //商户ID，后台提取
            'billNo' => $transact, //商户订单号
            'totalAmount' => $payMoney*100, //金额
            'billDesc' => "在线充值", //商品名称
            'way' => $this->payType(), //支付模式
            'payment' => $payChannel, //微信支付
            'notifyUrl' => $payNotifyUrl, //回调地址
            'returnUrl' => $payCallBackUrl, //同步跳转
            'attach' => "",
            "accKey" => "" //收款账号
        );



        $Md5key = $appKey; //签名密钥，后台提取
        $paydata ['sign'] = $this->markSign ( $paydata, $Md5key );

        file_put_contents(ROOT_PATH."pay.txt","下单".json_encode($paydata , 1).PHP_EOL,FILE_APPEND);

        $payUrl = "http://$payurl/game/unifiedorder"; //请求订单地址
        $checkUrl = "http://$payurl/pay/checkTradeNo"; //主动查单地址


        $ret = $this->curl ( $payUrl, json_encode ( $paydata ) );



        $data = json_decode ( $ret, true );
        $data['result']['totalAmount'] = $payMoney;
        $data['result']['returnUrl'] = $payCallBackUrl;




        if ($data ['code'] == 0)
        {


            $url = $data['result']['linkUrl'];
            header("Location:{$url}");
            die;
            $data ['result']["returnUrl"] = $paydata["returnUrl"];
            $data ['result']["checkUrl"] = $checkUrl;
            if ($this->payType() == "qrcode"){
                $url="/dingcheng/html/qrcode.php"; //付款页面
                $this->jumpPost($url,$data ['result']);
            } else {
                $url="/dingcheng/html/qrcode.php"; //付款页面
                $this->jumpPost($url,$data ['result']);
            }
        } else {
            exit ( $data ['message'] );
        }

    }
    protected function wechat($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        $domain = getDomain(2);
        $payDomain = getDomain(3);
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl(['transact' => id_encode($transact) , 'f' => id_encode($this->id)] , '' , '', $domain);
        $payNotifyUrl = $this->getNotifyUrl([]  , "wechat");

        $mchid = $appId;          //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
        $appid = $appKey;  //微信支付申请对应的公众号的APPID
        $appKey = $payChannel;   //微信支付申请对应的公众号的APP Key
        $apiKey = $payGateWayUrl;   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
        //①、获取用户openid
        $wxPay = new WxpayService($mchid,$appid,$appKey,$apiKey);

        $openId = $wxPay->GetOpenid($domain , $payDomain);      //获取openid
        if(!$openId) exit('获取openid失败');
        $outTradeNo = $transact;     //你自己的商品订单号
        $payAmount = $payMoney;          //付款金额，单位:元
        $orderName = '支付测试';    //订单标题
        $notifyUrl = $payNotifyUrl;     //付款成功后的回调地址(不要有问号)
        $payTime = time();      //付款时间
        $jsApiParameters = $wxPay->createJsBizPackage($openId,$payAmount,$outTradeNo,$orderName,$notifyUrl,$payTime);
        $jsApiParameters = json_encode($jsApiParameters);


        $html = "<html>
    <head>
        <meta charset=\"utf-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>
        <title>微信支付样例-支付</title>
        <script type=\"text/javascript\">
            //调用微信JS api 支付
            function jsApiCall()
            {
                WeixinJSBridge.invoke(
                    'getBrandWCPayRequest',
                    $jsApiParameters,
                    function(res){
                        WeixinJSBridge.log(res.err_msg);
						if(res.err_msg=='get_brand_wcpay_request:ok'){
							alert('支付成功！');
							location.href = '{$payCallBackUrl}'
						}else{
							alert('支付失败：'+res.err_code+res.err_desc+res.err_msg);
						}
                    }
                );
            }
            function callpay()
            {
                if (typeof WeixinJSBridge == \"undefined\"){
                    if( document.addEventListener ){
                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                    }else if (document.attachEvent){
                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                    }
                }else{
                    jsApiCall();
                }
            }
            callpay();
        </script>
    </head>
    <body>    
    </body>
    </html>";

        echo $html;die;

    }
    protected function dp1010($payInfo , $user , $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl(['transact' => id_encode($transact) , 'f' => id_encode($this->id)] );
        $payNotifyUrl = $this->getNotifyUrl(['f' => id_encode($this->id)] , "dp1010");

        $money = $payMoney; //订单金额
        $trade_no = $transact;//订单号
        $uid = $appId;//UID
        $tongdao_id = $payChannel;//通道ID  网易801 ， 捕鱼802
        $token = $appKey; //令牌
        $url = $payGateWayUrl; //网关
        $notify_url = $payNotifyUrl;//异步跳转地址
        $return_url = $payCallBackUrl;//同步跳转地址
        return $this->pay($trade_no,$money,$uid,$token,$tongdao_id,$notify_url,$return_url,$url);

    }
    protected function codepay_wx($payInfo = null , $user = [] , $model)
    {
        
        $transact = date("YmdHis") . rand(100000, 999999);
        
      
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0)
        {
            return $this->error('下单失败');
        }
        
        
        $payCallBackUrl = $this->getCallbackUrl(['transact' => id_encode($transact) , 'f' => id_encode($this->id)]);
        
        
        $payNotifyUrl = $this->getNotifyUrl(['f' => id_encode($this->id)]);
        //todo 到这里为运营商下单逻辑

        $data = array(
            "id" => $appId,//你的码支付ID
            "pay_id" => $transact, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "type" => $payChannel,//1支付宝支付 3微信支付 2QQ钱包
            "price" => $payMoney,//金额100元
            "param" => "",//自定义参数
            "notify_url" => $payNotifyUrl,//通知地址
            "return_url" => $payCallBackUrl,//跳转地址
        );
        
        
        //构造需要传递的参数
        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素
        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data as $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign . $appKey); //创建订单所需的参数
        $url = "$payGateWayUrl/?{$query}"; //支付页面

        header("Location:{$url}"); //跳转到支付页面
        die;
    }
    
    protected function pay($trade_no,$money,$uid,$token,$tongdao_id,$notify_url,$return_url,$url){
        $arr_data = array(
            'uid' => $uid, //商户id
            'token' => $token, //商户密钥
            'trade_no' => $trade_no, //订单号
            'money' => $money, //金额'
            'tongdao_id'=>$tongdao_id,
            'notify_url' => $notify_url, //这里是通知的地址，填入要给您get数据的地址
            'return_url' => $return_url //这里是支付成功后跳转的地址，填入您想跳转的地址即可
        );
        $parameter = $arr_data;
        $fieldString = http_build_query($parameter);
        $sign = md5($fieldString.$parameter['token']);
        $arr_data['sign'] = $sign;//签名
        $header = array('Ktype:iscurl', 'User-Agent:' . $_SERVER['HTTP_USER_AGENT']);

        //发起请求
        $data = $this->http_post($url, $header, $arr_data);
        $data = json_decode($data,true);
        //echo "<pre>";print_r($data); exit;
        if($data['code'] == 1){
            //网易
            if($tongdao_id == 801){


                //捕鱼
            }elseif($tongdao_id == 802){
                $fdata = $data['data'];

                //参数加密
                $check_str = array(
                    "check_url" => $data['data']['check_url'],
                    "check_sign" => $data['data']['check_sign'],
                );
                $check_str = json_encode($check_str);
                $check_str = $this->encrypt($check_str,"E");//加密
                //重组参数
                $jm  = array(
                    "money"=>$money,
                    "return_url"=>$return_url,
                    "wxurl" => $data['data']['wxurl'],
                    "check_str" => $check_str
                );
                $jm_json = json_encode($jm);
                $jm_string = $this->encrypt($jm_json,"E");//加密
                //echo "<pre>";print_r($fdata); exit;
                // 微信内付
                if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {//判断是否在微信里打开
                    $tjurl="/html/802/wxpay.php?code=".$jm_string; //付款页面文件的路径  请注意路径
                    //echo $tjurl;
                    header("Location:$tjurl");
                    // 微信H5
                }else{
                    //$tjurl路径要对
                    $tjurl="/html/802/wxpayh5.php?code=".$jm_string;  //付款页面文件的路径    请注意路径
                    header("Location:$tjurl");
                }
            }else{
                echo "通道ID未指定";
            }
        }else{
            echo $data['msg'];
        }
    }
    protected function encrypt($string,$operation) {
        $src = array(
            "/",
            "+",
            "="
        );
        $dist = array(
            "_a",
            "_b",
            "_c"
        );
        if ($operation == 'D') {
            $string = str_replace($dist,$src,$string);
        }
        $key = md5("as4zaz1a4d4aad");
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key) ,0,8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result.= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result,0,8) == substr(md5(substr($result,8) . $key) ,0,8))
            {
                return substr($result,8);
            } else {
                return '';
            }
        } else {
            $rdate = str_replace('=','',base64_encode($result));
            $rdate = str_replace($src,$dist,$rdate);
            return $rdate;
        }
    }
    protected function http_post($sUrl, $aHeader, $aData) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $sUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch,CURLOPT_TIMEOUT,10);

        $sResult=curl_exec($ch);
        $sCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($sCode==200){
            return $sResult;
        }else{
            return null;
        }
    }
    protected function payType(){
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
            return "qrcode";
        } else {
            return "wap";
        }
    }
    /**
     * 签名方法
     */
    protected function markSign($paydata, $signkey) {
        ksort ( $paydata );
        $str = '';
        foreach ( $paydata as $k => $v ) {
            if ($k != "sign" && $v != "") {
                $str .= $k . "=" . $v . "&";
            }
        }
        return strtoupper ( md5 ( $str . "key=" . $signkey ) );
    }

    /**
     * 表单跳转模式
     * $url 地址
     * $data 数据,支持数组或字符串，可留空
     * $target 是否新窗口提交，默认关闭
     */
    protected function jumpPost($url,$data){
        $html = "<form id='form' name='form' action='".$url."' method='post'>";
        if (!empty($data)){
            if (is_array($data)){
                foreach ($data as $key => $val) {
                    $html.= "<input type='hidden' name='".$key."' value='".$val."'/>";
                }
            } else {
                $html.= "<input type='hidden' name='value' value='".$data."'/>";
            }
        }
        $html.= "</form>";
        $html.= "<script>document.forms['form'].submit();</script>";
        exit($html);
    }
    protected function curl($url, $post_data) {
        $ch = curl_init ();
        $header = [
            'Content-Type: application/json',
          //  'Content-Length: ' . strlen ( $post_data )
        ];
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        $output = curl_exec ( $ch );
        curl_close ( $ch );
        return $output;
    }

    //同步检测回调
    public function callBack($transact , $f)
    {
        
        $request = $this->request->param();
        
        
        $transact = id_decode(array_get($request, 'transact',''));
        
        
        $orderInfo = Order::getOrderInfo($transact['id']);
        
        


        if(empty($orderInfo))
        {
            return $this->error('订单不存在,请重试!' , '' ,'',333);
        }
        $_GET['id'] = $orderInfo['id'];
        $_GET['v'] = $orderInfo['vid'];
        $_GET['f'] = $request['f'];
        $_GET['transact'] = $request['transact'];

        if(empty($_GET['transact']))
        {
            $_GET['transact'] = $request['transact'];
        }
        if(empty($_GET['f']))
        {
            $_GET['f'] = $request['f'];
        }

        $this->assign('v' ,$_GET['v']);

        $this->assign('f' ,$_GET['f']);
        $this->assign('transact' ,$_GET['transact']);

        // echo "已支付,缺少前台轮询调用检测";
        //dump($orderInfo);
        $this->assign('order' , $orderInfo);
        return view('callback');
    }

    public function checkOrderStatus()
    {
        $request = $this->request->param();
        $transact = id_decode(array_get($request, 'transact',''));
        $orderInfo = Order::getOrderInfo($transact['id']);
        if($orderInfo['status'] == 1)
        {
            return json(['code' => 1 , 'data' => $orderInfo , 'msg' => 'success']);
        }
        return json(['code' => 0 , 'msg' => 'notPay' , 'data' => $orderInfo]);
    }
    protected function createOrder($user , $transact , $model = null )
    {
        $uid = $this->id;
        $vid = $this->request->get('vid');
        $isDate = $this->request->get('is_date',0);
        $isMonth = $this->request->get('is_month',0);
        $isWeek = $this->request->get('is_week',0);
        $ip = $this->request->ip();
        $linkInfo = (new Link())->where(['id' => $vid, 'uid' => $uid ])->find();
        $payMoney = array_get($linkInfo, 'money' , 0);
        $payDesc = '支付';
        if($isDate == 2)
        {
            $payMoney = $user['date_fee'];
        }
        if($isMonth == 2)
        {
            $payMoney = $user['month_fee'];
            $payDesc = "支付_3";
        }
        if($isWeek == 2)
        {
            $payMoney = $user['week_fee'];
            $payDesc = "支付_3";
        }

        //扣量判断
        $is_kouliang = 1;
        //统一下单
        $data = [
            'vid' => $vid,
            'uid' => $uid,
            'ip' => $ip,
            'transact' => $transact,
            'price' => $payMoney,
            'pid' => $user['pid'],
            'ua' => cookie('ua'),
            'pid_top' => $this->pid_top,
            'is_kouliang' => $is_kouliang,
            'is_date' => $isDate == 2 ? 2 : 1,
            'is_month' => $isMonth == 2 ? 2 : 1,
            'is_week' => $isWeek == 2 ? 2 : 1,
            'pay_channel' => $model,
            'des' => $payDesc
        ];
        $redis = redisInstance();
        $key = "order_{$uid}_".date('Y-m-d');
        $redis->handler()->zadd($key ,time() , $transact );
        $res = (new Order())->save($data);
        if($res)
        {
            return ['code' => 1 , 'data' => $data , 'link' => $linkInfo];
        }
        return ['code' => 0 , 'data' => []];
    }
    //异步通知地址
    protected function getNotifyUrl($param = [] , $action = "notify")
    {
        $host = $this->request->host(true);
        $scheme = $this->request->scheme();
        $port = $this->request->port();
        if($param) {
//            return $scheme ."://" . $host . ":$port" . "/index/pay/$action?a=a&".http_build_query($param);
            return "http://" . $host . "/index/pay/$action?a=a&".http_build_query($param);
        }
        if($action =="wechat") {
            // return $scheme ."://" . $host . ":$port"."/gzh.php";
        }
        //return $scheme ."://" . $host . ":$port" . "/index/pay/$action";
        return "http://" . $host . "/index/pay/$action";
    }
    //dy
    
    public function dcallback()
    {
        $params = $this->request->param('params');
        
      //  dump(id_decode('TURBd01EQXdNREF3TUo1OWRLTQ'));
      //  dump($params);die;
        
        $f = $this->request->param('f');
        
        
        $payDomain = getDomain(2);
        $domain = $payDomain . "/index/trading/callBack/?".$params."&f={$f}";
        //echo $domain;die;
        $this->assign('url' , $domain);
        
        return $this->view->fetch("third/jump");
        
        
        
    }
    //同步通知地址
    protected function getCallbackUrl($params = [] , $order = '' , $id = '' , $domain = '')
    {
        $f = isset($params['f']) ? $params['f'] : id_encode($id);
        $host = $this->request->host(true);
        $p =  ['transact' => id_encode($order) , 'f' => id_encode($id)];
        $scheme = $this->request->scheme() . "://";
        // $domain = getDomain(2);
        $payDomain = getDomain(2);
        if($payDomain) {
            $domain = $payDomain;
        }
        if(!empty($domain)) {
            $host = $domain;
            $scheme = '';
        }else{
            $host="http://". $host;
        }
        $port = $this->request->port();
        if($params) {
//            $url =  $scheme . $host . ":$port" ."/index/trading/callBack?a=a&".http_build_query($params);
            $url =  $host ."/index/trading/callBack?a=a&".http_build_query($params);
        } else {
//            $url = $scheme  . $host . ":$port" ."/index/trading/callBack/transact/".id_encode($order)."/f/".id_encode($id);
            $url = $host ."/index/trading/callBack/transact/".id_encode($order)."/f/".id_encode($id);
        }
        $d = config('site.doiyin');
        if($d == 1) {
            $host = getDomain(3);
            $url = $host."/index/trading/dcallBack/f/".$f."/params/".urlencode(http_build_query($p));
        }
        return $url;
    }

    private function mahuayun($payInfo,$user, $model)
    {
        $transact = date("YmdHis") . rand(100000, 999999);
        $res = $this->createOrder($user , $transact , $model);
        $appId = $payInfo['app_id'];
        $appKey = $payInfo['app_key'];
        $payChannel = $payInfo['pay_channel'];
        $payGateWayUrl = $payInfo['pay_url'];
        $payName = $payInfo['pay_name'];
        $payMoney = array_get($res, 'data.price' , 0);
        $payDesc = array_get($res , 'data.des');
        if($res['code'] == 0) {
            return $this->error('下单失败');
        }
        $payCallBackUrl = $this->getCallbackUrl([] , $transact , $this->id);
        $payNotifyUrl = $this->getNotifyUrl( [], "mahuayun");
        $appSecret = $appKey;
        $data = [
            'pid' => $appId,
            'type' => $payChannel,
            'money' => $payMoney,
            'name' => $payName,
            'out_trade_no' => $transact,
            'notify_url' => $payNotifyUrl,
            'return_url' => $payCallBackUrl,
        ];
        $data = array_filter($data);
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $sign = md5(trim($str1 . $appKey, '&'));
        $data['sign']      = $sign;
        $data['is_wx_browser']      = '0'; // 不参与签名

        $headers = array('Content-Type: application/x-www-form-urlencoded');
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $payGateWayUrl); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $this->error('Errno'.curl_error($curl));
        }
        curl_close($curl); // 关闭CURL会话
        $result = json_decode($result, true);
        if ($result['code'] != 200) {
            dump($data);
            die($result['msg']);
        }
        $wxUrl = $result['data']['wxUrl'];
        echo ("<script>window.location.href='".$wxUrl."'</script>");
    }

}
