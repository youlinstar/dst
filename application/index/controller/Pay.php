<?php

namespace app\index\controller;

use app\admin\library\Log;
use app\admin\model\Admin;
use app\admin\model\AdminLog;
use app\admin\model\Order;
use app\commom\model\Payed;
use app\common\controller\Frontend;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use app\admin\model\Payset;
use function fast\array_get;

class Pay extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize(){
        //$this->checkFlg();
    }

    public function dingchengpay()
    {
        file_put_contents(ROOT_PATH."pay.txt","dingchengpay: 订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        
        $data = $_GET;
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        $sdk = new SDK();
        $sdk->key($app_key);
        
        if(!$sdk->signVerify($data)){
            echo 'fail';die;
        }
        
        if($data['trade_status'] == 'TRADE_SUCCESS'){
            $transact = $data['out_trade_no'];
            $order = (new Order())->where(['transact' => $transact])->find();
            $money = $order['price'];
            $uid = $this->id;
            if(empty($this->id))
            {
                $this->id = $order['uid'];
            }
            $res =  $this->saveOrder($transact , $money);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        }
        
        echo 'fail';die;
    }
    
    public function fangyoufang()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果 fangyoufang ".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $trade_status = $_REQUEST['trade_status'];//TRADE_SUCCESS成功
        $out_trade_no = $_REQUEST['out_trade_no'];//提交的订单号


        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach'],$result['sign_type']);
        
        
        $data = array_filter($result);

            
        $sign = md5(substr(md5($out_trade_no.$app_key),10));//$key是你的秘钥
        
        if($sign != $signs)
        {
            echo  'FAIL';die;
        }
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    public function shenyupay()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果 shehuang168 ".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach'],$result['sign_type']);
        
        
        $data = array_filter($result);

            
            $param = $data;
        
        $signPars = "";
        ksort($param);
        foreach ($param as $k => $v) {
        if ("sign" != $k) {
        $signPars .= $k . "=" . $v . "&";
        }
        }
        $signPars = rtrim($signPars, '&');
        $signPars .= $app_key;
        $sign = md5($signPars); // 此处要md5加密小写
        
        if($sign != $signs)
        {
            echo  'FAIL';die;
        }
        
        
        
     
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    public function shehuang168()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果 shehuang168 ".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach'],$result['sign_type']);
        
        
        $data = array_filter($result);

            
            $param = $data;
        
        $signPars = "";
        ksort($param);
        foreach ($param as $k => $v) {
        if ("sign" != $k) {
        $signPars .= $k . "=" . $v . "&";
        }
        }
        $signPars = rtrim($signPars, '&');
        $signPars .= $app_key;
        $sign = md5($signPars); // 此处要md5加密小写
        
        if($sign != $signs)
        {
            echo  'FAIL';die;
        }
        
        
        
     
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    public function xihaha()
    {
	
    	if(!isset($_REQUEST["sign"]) ){
    		echo "fail(sign not exists)";
    		exit;
    	}
    	
    	$resSign = $_REQUEST["sign"] ;
    	
    	$paramArray = array();
    	
    	if(isset($_REQUEST["payOrderId"]) ){
    		$paramArray["payOrderId"] = $_REQUEST["payOrderId"];
    	}
    
    	if(isset($_REQUEST["income"]) ){
    		$paramArray["income"] = $_REQUEST["income"];
    	}
    	
    	if(isset($_REQUEST["mchId"]) ){
    		$paramArray["mchId"] = $_REQUEST["mchId"];
    	}
    	
    	if(isset($_REQUEST["appId"]) ){
    		$paramArray["appId"] = $_REQUEST["appId"];
    	}
    	
    	if(isset($_REQUEST["productId"]) ){
    		$paramArray["productId"] = $_REQUEST["productId"];
    	}
    	
    	if(isset($_REQUEST["mchOrderNo"]) ){
    		$paramArray["mchOrderNo"] = $_REQUEST["mchOrderNo"];
    	}
    	
    	if(isset($_REQUEST["amount"]) ){
    		$paramArray["amount"] = $_REQUEST["amount"];
    	}
    	
    	if(isset($_REQUEST["status"]) ){
    		$paramArray["status"] = $_REQUEST["status"];
    	}
    	
    	if(isset($_REQUEST["channelOrderNo"]) ){
    		$paramArray["channelOrderNo"] = $_REQUEST["channelOrderNo"];
    	}
    	
    	if(isset($_REQUEST["channelAttach"]) ){
    		$paramArray["channelAttach"] = $_REQUEST["channelAttach"];
    	}
    	
    	if(isset($_REQUEST["param1"]) ){
    		$paramArray["param1"] = $_REQUEST["param1"];
    	}
    	
    	if(isset($_REQUEST["param2"]) ){
    		$paramArray["param2"] = $_REQUEST["param2"];
    	}
    	
    	if(isset($_REQUEST["paySuccTime"]) ){
    		$paramArray["paySuccTime"] = $_REQUEST["paySuccTime"];
    	}
    	
    	if(isset($_REQUEST["backType"]) ){
    		$paramArray["backType"] = $_REQUEST["backType"];
    	}
     
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $mchKey = array_get($payInfo,'app_key');
        
    	
    	$sign = $this->paramArraySign($paramArray, $mchKey);  //签名
    	
   
    // 	if($resSign != $sign){  //验签失败
    // 		echo "fail(verify fail)";
    // 		exit;
    // 	}
	
        
        $transact = $_REQUEST['mchOrderNo'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay1.txt","订单处理返回结果 老陈".json_encode($_REQUEST).PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay1.txt","ok".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }else{
             file_put_contents(ROOT_PATH."pay1.txt","fail".PHP_EOL,FILE_APPEND);
                echo 'fail';die;
        }

      
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

    public function kangxinlianmeng()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果kangxinlianmeng".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach'],$result['sign_type']);
        
        
        $data = array_filter($result);

        
        
        if (get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $str = $str1 . $app_key;
        $str = trim($str, '&');
        $sign = md5($str);
        
        if($sign != $signs)
        {
            echo  'FAIL';die;
        }
        
        
        
     
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    
    public function manager()
    {
        
        //file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果manager".$_REQUEST.PHP_EOL,FILE_APPEND);
        
        
         $testxml  = file_get_contents("php://input");

 

        $results = json_decode($testxml, true);//转成数组，


        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果manager".json_encode($results,256).PHP_EOL,FILE_APPEND);
        
        
        
        
        
        $transact = $results['merchantOrderCode'];

        
        
       $result = $results;
        
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach']);
        
        
        $signStr = '';
          foreach ($result as $key => $value){
            $signStr .= $key . '=' . $value;
          }
          $signStr .= 'key=' . $app_key;
          
          $signStr = md5($signStr);
          
          if($signs != $signStr)
          {
              echo 'fail';die;
          }
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "SUCCESS";die;
        }

        echo 'fail';die;
    }
    public function legobang()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果legobang".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_order_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach']);
        
        
        $data = array_filter($result);

        //签名步骤一：按字典序排序参数
        ksort($data);
        $string_a = http_build_query($data);
        $string_a = urldecode($string_a);

        //签名步骤二：在string后加入mch_key
        $string_sign_temp = $string_a . "&key=" . $app_key;

        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);

        // 签名步骤四：所有字符转为大写
        $sign = strtoupper($sign);
        
        
        
    
    	if($sign != $signs)
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    public function burenshi()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果burenshi".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['orderid'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $signs = $result['sign'];
        
        unset($result['s'],$result['sign'],$result['attach']);
        
        
        ksort($result);
        reset($result);
        $md5str = "";
        foreach ($result as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $app_key));
        
        
    
    	if($sign != $signs)
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","ok".PHP_EOL,FILE_APPEND);
            echo "ok";die;
        }

        echo 'fail';die;
    }
    public function rongyi()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果rongyi".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        
        unset($result['s'],$result['key']);
        
        
        ksort($result);
        $buff = "";
        foreach ($result as $k => $v) {
            if ($k != "sign" && $v !== "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        $sign_md5 = $buff. "&key=" . $app_key;
        
        $sign_md5 = md5($sign_md5);
        
        
    
    	if($sign_md5 != $result['sign'])
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    public function changlian()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果changlian".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
            
            $sss = $result['sign'];
        
        unset($result['s'],$result['sign']);
        
        
         $data = array_filter($result);
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string_a = http_build_query($data);
        $string_a = urldecode($string_a);
        //签名步骤二：在string后加入KEY
        
        $string_sign_temp = $string_a . "&key=" . $app_key;
        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);
        // 签名步骤四：所有字符转为大写
        $result = strtoupper($sign);
        
    
    	if($result != $sss)
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    public function new_aicai()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果new_aicai".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['billNo'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        
        unset($result['s'],$result['key']);
        
        
        
        
          ksort ( $result );
        $str = '';
        foreach ( $result as $k => $v ) {
            if ($k != "sign" && $v != "") {
                $str .= $k . "=" . $v . "&";
            }
        }
        $sign =  strtoupper ( md5 ( $str . "key=" . $app_key ) );
        
    
    	if($sign != $result['sign'])
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    public function dafa()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果dafa".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        
        unset($result['s'],$result['key']);
        
        
        
        
         ksort($result);
    $need = [];
    foreach ($result as $key => $value) {
        if (! $value || $key == 'sign') {
            continue;
        }
        $need[] = "{$key}={$value}";
    }
    $string = implode('&', $need).$app_key;

    $sign = strtoupper(md5($string));
    
    
    
    	
    	
    	if($sign != $result['sign'])
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function laomao()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果laomao".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        $result = $_REQUEST;
        
        
        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        
        unset($result['s'],$result['sign_type']);
        
        
        
        
        $signPars = "";
    	ksort($result);
    	foreach ($result as $k => $v) {
    		if ($k!="sign"&&$v!="") {
    			$signPars .= $k . "=" . $v . "&";
    		}
    	}
    	$signPars = rtrim($signPars, '&');
    	$signPars .= $app_key;
    	$sign = md5($signPars);
    	
    	
    	if($sign != $result['sign'])
    	{
    	    exit('fail');
    	}
	

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function hyf()
    {

        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        
        $request  = $_REQUEST;
    file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果hyf".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $s = $request['sign'];
        unset($request['s'],$request['sign']);
        $transact = $request['out_order_no'];
        
        ksort($request);
        $tmp = array();
        foreach ($request as $k => $param) {
            $tmp[] = $k . '=' .  $param;
        }
        $string = implode('&', $tmp) . '&key=' . $app_key;
        
    	$sign = md5($string);
    	
    	if($sign != $s)
    	{
    	   // exit('fail');
    	}
    	
    
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true && $request['status'] == "1" )
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function qianbaotong()
    {

        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        
        $testxml  = file_get_contents("php://input");
        file_put_contents(ROOT_PATH."pay.txt","qianbaotong-xml".$testxml.PHP_EOL,FILE_APPEND);

        $testxml = json_decode($testxml,true);
        
        $transact = $testxml['MrchtOrderNo'];
        
        $arr = array_filter($testxml);
        if (isset($arr['Signature'])) {
            unset($arr['Signature']);
        } 
        ksort($arr);
        $str = http_build_query($arr);
        
        $str = urldecode($str).'&key='.$app_key;
        $str = md5($str);
        $sign = strtoupper($str);
        

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        if($sign != $testxml['Signature'])
        {
            echo 'fail';die;
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true && $testxml['PayStatus'] == "SUCCESS")
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function minipay()
    {
        file_put_contents(ROOT_PATH."pay.txt","minipay".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['order'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function dcpay()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果sssvips".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }


    public function sssvips()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果sssvips".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    public function ymf()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    public function yft()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_pay_sn'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "OK";die;
        }

        echo 'fail';die;
    }

    public function alipays()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    public function xiaoxiao()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    public function qiqi()
    {
        $request = $_REQUEST;
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['billNo'];




        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        unset($request['s']);
        
        ksort($request);
        $str='';
        foreach($request as $k=>$v)
        {
            if($k != "sign" && $v!= "")
            {
                $str.=$k."=".$v."&";
            }
        }
        
        
        $sign = strtoupper(md5($str."key=".$app_key));
        
        if($sign != $request['sign'])
        {
            echo "fail";die;
        }

        
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($_REQUEST['tradeStatus'] != '1')
        {
            echo 'fail';die;
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "SUCCESS";die;
        }

        echo 'fail';die;
    }


    public function payhui()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($_REQUEST['trade_status'] != 'TRADE_SUCCESS')
        {
            echo 'fail';die;
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    
    public function qumipay()
    {
        file_put_contents(ROOT_PATH."pay.txt","qumipay: 订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($_REQUEST['trade_status'] != 'TRADE_SUCCESS')
        {
            echo 'fail';die;
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
    
    
    public function caihong()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($_REQUEST['trade_status'] != 'TRADE_SUCCESS')
        {
            echo 'fail';die;
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function qxiaoge()
    {
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];

        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }

        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true)
        {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function xsdwrkj001()
    {


        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        if(isset($_REQUEST['s']))
        {
            unset($_REQUEST['s']);
        }


        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $sign = '';
    	ksort($_REQUEST);
        unset($_REQUEST['sign_type']);
    	foreach ($_REQUEST as $k => $v) {
    	    
    	    if($v && $k !== 'sign') $sign .= $k . '=' . $v . '&';
    	}
    	$sign = md5(rtrim($sign, '&') . $app_key);
    	if($sign != $_REQUEST['sign']) {
    	    
    	  file_put_contents(ROOT_PATH."pay.txt","xsdwrkj001-签名error".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);

    		 echo 'fail2';die;
    	}
    	
    	
        
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
       
        
        
        if($_REQUEST['trade_status'] == "TRADE_SUCCESS")
        {
            $res =  $this->saveOrder($transact , $money);

            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        }
        echo 'fail';die;
    }
    
    
    public function xsdwrkj002()
    {


        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        if(isset($_REQUEST['s']))
        {
            unset($_REQUEST['s']);
        }


        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $sign = '';
    	ksort($_REQUEST);
        unset($_REQUEST['sign_type']);
    	foreach ($_REQUEST as $k => $v) {
    	    
    	    if($v && $k !== 'sign') $sign .= $k . '=' . $v . '&';
    	}
    	$sign = md5(rtrim($sign, '&') . $app_key);
    	if($sign != $_REQUEST['sign']) {
    	    
    	  file_put_contents(ROOT_PATH."pay.txt","xsdwrkj002-签名error".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);

    		 echo 'fail2';die;
    	}
    	
    	
        
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
       
        
        
        if($_REQUEST['trade_status'] == "TRADE_SUCCESS")
        {
            $res =  $this->saveOrder($transact , $money);

            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        }
        echo 'fail';die;
    }
    
    
     public function yeyf003()
    {


        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        
        if(isset($_REQUEST['s']))
        {
            unset($_REQUEST['s']);
        }


        $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        $sign = '';
    	ksort($_REQUEST);
        unset($_REQUEST['sign_type']);
    	foreach ($_REQUEST as $k => $v) {
    	    
    	    if($v && $k !== 'sign') $sign .= $k . '=' . $v . '&';
    	}
    	$sign = md5(rtrim($sign, '&') . $app_key);
    	if($sign != $_REQUEST['sign']) {
    	    
    	  file_put_contents(ROOT_PATH."pay.txt","yeyf003-签名error".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);

    		 echo 'fail2';die;
    	}
    	
    	
        
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
       
        
        
        if($_REQUEST['trade_status'] == "TRADE_SUCCESS")
        {
            $res =  $this->saveOrder($transact , $money);

            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        }
        echo 'fail';die;
    }
    
    public function csxyst()
    {

        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);

        $transact = $_REQUEST['out_trade_no'];
        $money = $_REQUEST['money'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        
            $res =  $this->saveOrder($transact , $money);

            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        
        echo 'fail';die;
    }
    public function wechat()
    {
        $testxml  = file_get_contents("php://input");

        $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA));

        $result = json_decode($jsonxml, true);//转成数组，


        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".json_encode($result,1).PHP_EOL,FILE_APPEND);

        $out_trade_no = $result['out_trade_no'];

        if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $transact = $out_trade_no;
            $order = (new Order())->where(['transact' => $transact])->find();
            $money = $order['price'];
            $uid = $this->id;
            if(empty($this->id))
            {
                $this->id = $order['uid'];
            }
            $res =  $this->saveOrder($transact , $money);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".gettype($res).PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                $str='<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
                file_put_contents(ROOT_PATH."pay.txt",$str.PHP_EOL,FILE_APPEND);
                echo $str;die;
            }
        }
    }
    
    public function zhengbandingcheng()
    {
        $request = $this->request->param();
        \think\Log::error($this->request->param());
        file_put_contents(ROOT_PATH."pay.txt",json_encode($request,1).PHP_EOL,FILE_APPEND);
        
        
         $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        unset($request['s']);
        
        ksort($request);
        $str='';
        foreach($request as $k=>$v)
        {
            if($k != "sign" && $v!= "")
            {
                $str.=$k."=".$v."&";
            }
        }
        
        
        $sign = strtoupper(md5($str."key=".$app_key));
        
        if($sign != $request['sign'])
        {
            echo "fail";die;
        }
        
        
        
        $transact = $request['billNo'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($request['tradeStatus'] == "1" || $request['tradeStatus'] == -1 || $request['tradeStatus'] == 0)
        {
            $res =  $this->saveOrder($transact , $money);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".gettype($res).PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "SUCCESS";die;
            }
        }
        echo "fail";die;
    }
    
    
    public function dingcheng()
    {
       $request = $this->request->param();
        \think\Log::error($this->request->param());
        file_put_contents(ROOT_PATH."pay.txt",json_encode($request,1).PHP_EOL,FILE_APPEND);
        
        
         $action = $this->request->action();
        $payInfo  = (new Payset())->where(['model' => $action])->find()->toArray();
        $app_key = array_get($payInfo,'app_key');
        
        unset($request['s']);
        
        ksort($request);
        $str='';
        foreach($request as $k=>$v)
        {
            if($k != "sign" && $v!= "")
            {
                $str.=$k."=".$v."&";
            }
        }
        
        
        $sign = strtoupper(md5($str."key=".$app_key));
        
        if($sign != $request['sign'])
        {
            echo "fail";die;
        }
        
        
        
        $transact = $request['billNo'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($request['tradeStatus'] == "1" || $request['tradeStatus'] == -1 || $request['tradeStatus'] == 0)
        {
            $res =  $this->saveOrder($transact , $money);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".gettype($res).PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "SUCCESS";die;
            }
        }
        echo "fail";die;
    }
    public function dp1010()
    {
        $request = $this->request->param();
        \think\Log::error($this->request->param());
        file_put_contents(ROOT_PATH."pay.txt",json_encode($request,1).PHP_EOL,FILE_APPEND);
        $transact = $request['out_trade_no'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }

        if($request['trade_status'] == "TRADE_SUCCESS")
        {
            $res =  $this->saveOrder($transact , $money);

            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".gettype($res).PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        }
        echo "fail";die;
    }
    public function notify()
    {
        $request = $this->request->param();
        \think\Log::error($this->request->param());
        file_put_contents(ROOT_PATH."pay.txt",json_encode($request,1).PHP_EOL,FILE_APPEND);
        $transact = $request['pay_id'];
        $money = $request['money'];
        $uid = $this->id;
        $order = (new Order())->where(['transact' => $transact])->find();
        if(empty($this->id))
        {
            $this->id = $order['uid'];
        }
        if($request['status'] == 1 || $request['ok'] == 1)
        {
            $res =  $this->saveOrder($transact , $money);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
            file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".gettype($res).PHP_EOL,FILE_APPEND);
            if((boolean) $res == true)
            {
                file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
                echo "success";die;
            }
        }
        echo "fail";die;
    }

    protected function saveOrder($transact = null , $money = 0)
    {
        $orderInfo = Order::getOrderInfo($transact);
        if($orderInfo['status'] == 1) {
            return true;
        }
        $userInfo = Admin::getUser($this->id);
        $user = $userInfo;
        $uid = $userInfo['id'];

        $is_kouliang = 1;
        $orderInfo['is_kouliang'] = $is_kouliang;
        if ($user['pid'] > 0) {
            $kouliang = $user['kouliang'];
            if ($kouliang > 0) {
                $count = (new Order())->where(['uid' => $uid, 'status' => 1])->count();
                if ($count > 0 && ($count + 0) % $kouliang == 0) {
                    $is_kouliang = 2;
                }
            }
        }
        //优化逻辑扣量
        if($is_kouliang == 2) {
            //扣量逻辑
            if($userInfo['pid'] == 0) {
                $uid = $userInfo['id'];
            }
            if($userInfo['pid'] > 0) {
                $uid = $userInfo['pid_top'];
            }
            $orderInfo['is_kouliang'] = $is_kouliang;
        }
        //计算提成
        $ticheng = $userInfo['ticheng'];
        $price = $money;
        $tichengPrice = 0;
        if($ticheng>0 && $orderInfo['is_kouliang'] == 1) {
            $tichengPrice = $money * $ticheng / 100;
            if($tichengPrice) {
                $price = $money - $tichengPrice;
            }
        }
        Db::startTrans();
        try {
            $msg = "";
            if($orderInfo['is_kouliang'] == 2) {
                $msg = " 【扣量订单】单号:{$transact} 代理ID:".$this->id ." 代理名称:".get_user($this->id ,'username');
            } else {
                $msg = '【打赏收入】单号:'.$transact;
            }
            Admin::money($price , $uid ,$msg );
            if($tichengPrice && $orderInfo['is_kouliang'] == 1) {
             Admin::money(
                 $tichengPrice ,
                 $userInfo['pid'] ,
                 "【分销抽成】单号:{$transact};提成抽取比例{$ticheng}%;代理【{$userInfo['username']}】ID:{$userInfo['id']}"
             );
                //$this->jisuan($transact,$money);
            }
            $key = "success_order_{$uid}_".date('Y-m-d');
            $redis = redisInstance();
            if($is_kouliang == 2) {
                $key = "success_order_1_".date('Y-m-d');
            }
            $redis->handler()->zadd($key ,time() , $transact );
            (new Order())->save([
                // 'uid' => $uid,
                'status' => 1,
                'paytime' => time(),
                'tc_money' => $tichengPrice,
                'is_kouliang' => $is_kouliang
            ] , ['transact' => $transact]);

            $expire = time() + 86400;
            if($orderInfo['is_date'] == 2) {
                $expire = time() + 86400;
            }
            if($orderInfo['is_month'] == 2) {
                $expire = time() + (86400 * 30);
            }
            if($orderInfo['is_week'] == 2) {
                $expire = time() + (86400 * 7);
            }
            (new Payed())->save([
                'vid' => $orderInfo['vid'],
                'uid' => $this->id,
                'ip' => $orderInfo['ip'],
                'order_sn' => $orderInfo['transact'],
                'ua' => $orderInfo['ua'],
                'expire' => $expire,
                'is_month' => $orderInfo['is_month'],
                'is_date' => $orderInfo['is_date'],
                'is_week' => $orderInfo['is_week'],
            ]);
            file_put_contents(ROOT_PATH."pay.txt","订单处理完成".PHP_EOL,FILE_APPEND);
            Db::commit();
            return true;
        }
        catch (Exception $e)
        {
            Db::rollback();
            file_put_contents(ROOT_PATH."pay.txt","消息异常".$e->getMessage().PHP_EOL,FILE_APPEND);
            return false;
        }
        return false;
    }

    public function jisuan($transact = 0 , $money = '')
    {
        //echo id_encode("59");
        //die;
        //$transact = '';
        //$money = 1;
        $parentInfo = $this->getParent();
        if(empty($parentInfo))
        {
            return true;
        }
        $arr = [];
        foreach ($parentInfo as $key => $item)
        {
            if($item['id'] == $this->id)
            {
                //continue;
            }
            if($item['pid'] == 0)
            {
                continue;
            }
            $pt = 0;
            if(isset($parentInfo[$key + 1]))
            {
                $pt = $parentInfo[$key + 1]['ticheng'];
            }
            //总金额 * (提成 - 上级提成)
            $p = ($item['ticheng']) /100 - ($pt /100);

            $m = $money * ( $p );

            $price = $this->m($money , $item['ticheng']);
            $arr[$key] = $price;
            $msg = "当前代理账号{$item['id']};当前总价{$money}元;提成:{$p};分配个上级代理账号{$item['pid']}---:{$m}元".PHP_EOL;
            file_put_contents(ROOT_PATH."pay.txt",$msg,FILE_APPEND);

            $pp = $p * 100;
            Admin::money($m , $item['pid'] , "【分销抽成】单号:{$transact};提成抽取比例{$pp}%;代理【{$item['username']}】ID:{$item['id']}");
        }

    }

    protected function m($money , $ticheng)
    {
        $tichengPrice = $money * $ticheng / 100;

        $m = $money - $tichengPrice;

        return $tichengPrice;
    }
    protected function getParent()
    {
        $parentInfo = (new Admin())->query("SELECT T2.id,T2.pid,T2.username,T2.ticheng
FROM ( 
    SELECT 
        @r AS _id, 
        (SELECT @r := pid FROM ds_admin WHERE id = _id) AS pid, 
        @l := @l + 1 AS lvl 
    FROM 
        (SELECT @r := {$this->id}, @l := 0) vars, 
        ds_admin h 
    WHERE @r <> 0) T1 
JOIN ds_admin T2 
ON T1._id = T2.id 
ORDER BY T1.lvl asc;");


        return $parentInfo;
    }

    public function mahuayun()
    {
        file_put_contents(ROOT_PATH."pay.txt","qumipay: 订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id)) {
            $this->id = $order['uid'];
        }
        if($_REQUEST['trade_status'] != 'TRADE_SUCCESS') {
            echo 'fail';die;
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true) {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function dabolang(){
        file_put_contents(ROOT_PATH."pay.txt","qumipay: 订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id)) {
            $this->id = $order['uid'];
        }
        if($_REQUEST['trade_status'] != 'TRADE_SUCCESS') {
            echo 'fail';die;
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true) {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }

    public function feiji(){
        file_put_contents(ROOT_PATH."pay.txt","qumipay: 订单处理返回结果".json_encode($_REQUEST ,1).PHP_EOL,FILE_APPEND);
        $transact = $_REQUEST['out_trade_no'];
        $order = (new Order())->where(['transact' => $transact])->find();
        $money = $order['price'];
        $uid = $this->id;
        if(empty($this->id)) {
            $this->id = $order['uid'];
        }
        $res =  $this->saveOrder($transact , $money);
        file_put_contents(ROOT_PATH."pay.txt","订单处理返回结果".$res.PHP_EOL,FILE_APPEND);
        if((boolean) $res == true) {
            file_put_contents(ROOT_PATH."pay.txt","success".PHP_EOL,FILE_APPEND);
            echo "success";die;
        }

        echo 'fail';die;
    }
}
