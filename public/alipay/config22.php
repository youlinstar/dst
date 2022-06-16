<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2019030463408900",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAgZiHVQpjt4Vzzjjpg943Zf0+tHqGHgmW7zGejAJtHpC462pTA/+nn5BOWa2vSg1iyCwRQq4m9ARG9NWQYxQ+no+ICNrYKixjub9/4nxG7QkgyinaXNpVRsr9yH5aehdCUSh5330R9hCDavXLJ+40d6n+m7sjgmT51ZziEUADj+B676cfJrsbSRSOQSayXfBjp/yUH1b4YdiltXItxTrXi0h7a/1jC9oajebVn0/Gs0DNTyXFSuQ7LDm6W2z/caA0NSkUGAY6VgdArTqftu15O11C3j6K9GR9XanlzEBB3vMGndPbkE/nmpK+oUEY7DSbVQHZH+bJK2MsAwmwC3Lq1wIDAQABAoIBAEMVNVhr3FovFlb1VssPyBVfFYpOsgXyaNLAGJXY26sqts4FZ5t2Rspt5GC/azEl5LBBP14Iz9kYLbKmqerfm9pv6bbLsYGDIMwRuJ0AP6aLRxHewE24JtRSVzPlU+hHCekAzrVFBHse6SgAu3yb7UTUFht+r07b/gb5AnxzamSazYtbZ3lhE4AeiuHV9csTFo76Hsq46q1Ut+IVW+hslGAlfu3z+eo5yrY6K0HkWPwDIn8oJPYf/gCBOmdgSRrjWl5+WwJF6mZDaxwdzxHHzEOOsF83T16wvrtUTnQweUpgWronyhoZUCmbM6RPV2ZH5RtP4lBB5AN/hm+qwO+0TsECgYEAwqzDH/Mo1iLNzFKSsomhLucjrThBTi4kgJ2gh552lBsoCuam55JZFBfERcTgLmf1oAzBeE/mdda29dBjUe/JGdhhy82dhXYVSZX98cFFLuv2K6uZSwTg2Z7kh+FgSx6Ws3zcap7oUmYKS41fvCUlzkNjJ5S4BsowAQRlBW0wI/8CgYEAqmuSr955sVqpj5xJgViLM6ar8WaWudImYuvUcPOo2Wwgzwjc1lhsXx1xyWK5htgqrb13f19ZgKECdYOP0RoHuMKOpM2lnXMk8AAy59uWA0oZF8HJJojqBE6MyVezR1q3Bc5FQaips4yl7lPCfDfdbD2uxRpCMkuubevUNBfG2SkCgYEAitGBDq5pR1FoKTQUkaWcv4JpKWM9Bk/XDbPZPfwcmH5I7oUNLYJpbO+JsSqzpcPSHkAaUf2/2/WxX9YqjMoNQBXRnu/PTNUoVuHTROpJuCzgzME/vYQMBoLMeayX6tk0I2d9Ebag+ejznG6CfvqKW+wnr5jYJVdWJdOJafYzZucCgYAjkVwGFJq1Z0SoUmgM9NvopcqREWY31iJo1ut5v4DoD+cxDpp4qe/EUjLjYxVxjUArDrYYAWB+thv7RsAHVjVyXDjFMJ52JAf7hy8YsP24JgjiqnE+96hPyc0cYI9sPwSf05MkxvzUGnCvMxAOOOKfqqgFPxu9v4niKywYyzWXMQKBgD//DoOuWs6ojTf5LD9G9+MfmXUwNWZ+5Gfj00B7qlBkxuIg1letBVfuzfIjQKRKvjxaZAR2jSAm/zLvgw+3rslno9KHFsseY4t/X8zvPkvQ63hPVYuywloHENkJ2JREgjF3KmcZJwGCiKs1kPCGxQnKytqowIrhIaWRlnPL4q39",
		
		//异步通知地址
		'notify_url' => "http://api.rovide8.cn/alipay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://api.rovide8.cn/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqsR23JHNmhLB+0/hTbPJxrcpJimYmszk1C0232fP0IccMBhR16foRT1bWw81arCC1KrdeNXodSXrjz7JnY/IBMDpxdqtDOCDZ9A/xl4mpzqvQ1Aiqs1BHSOeXreNPmyK5DSqMxBwPQDLJMSCNVkA6vM61Uuu5GDcoF5X9VseT9Hn6ChCKKChpG7e5agG1q1h2jAz18o9MUtCHEBgSJMvwUZMLPXcjInkU1cIl4wSuuXyCE8twnEuGRsOn/77MgSF58yCPPOvPxTWSH879LIx3p5wdGpdl1MKYsxuM+QWO9CVOF4MmmXq8tdS/+EJrd64lTvOHOXflsrWIeDVYrGzYwIDAQAB",
		
	
);