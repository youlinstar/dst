<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2019030463403866",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAjQhnhXSbmkXsl3C5Xw59okRhoQ6zrNWaXsxRGmf4WUYb3syYbPh2m1podiBuu4GG7De8NzQ4TCOu+d2uEythCZ17Ph0x8QPQtUSx8/xgGRxpyuqOXvnCbaDW1CYBzA5fFrlF49vBY3Jwh610smEKsUA+ofhJavcE9pR9ilisJRRCzM51IftBGezHTd1uQY13IVRVFM/qeNZvAbNvg3FjvvCRyelunlZPbcDru8Qtap56KbabynD+MAgWForM1iN9HkTNaAQBDWIqXNCPF0I1r37MBIXzFhiMCH4xEDLFcHYd7dTrM0vw9fEmMrJLAAYiVxJnbCclLOeGNgt6dA2/IQIDAQABAoIBAAulegcHTiI7TAJliKlU5QMVaoqGUEghi5HwhXIMy/FzXLHVa3D0Q7cojB/VJc/OLnorUBuu8Ec5WyW/LLTgjC7jFl5Wwt0IV5/ggGGJodXxBrt/CyrErU2oTpVOXi+fsDKMMj1S1HGF7c0GgfCJGvzwNTvi6Q0wQPSr5oIaOH0HQvW/Vh+RxEdxccQBwQaXkKjer5Z2FMZSm6UHi7CAdQfeFAIjpxmpaLsyzF/uZVWk+dVr1NKRXTrHD38y/f6IgBMfDhd5M6tGYhS3o/6alfZ8/fHjj3doviBQ7VeV9YarBToHJpxQc3SlXosXozMhwXtKzyxac28cnkP9CLRYhMECgYEA8x60AwwsR9nVZVBVtVr5Q1DmueZAX1hBvQpm2mYb+VynH0LDgTwWEgdt0H7N+Q/79Pfjyezhvgmj0IqOL1wBc8oaLtt6GM53+MQK55UvbmB7PnGbzoPblKRD7ZbWS7XXeSmUcCLR/LOVYkwMhBoFj8q4gJ4j9q1h2SdJPUi14y0CgYEAlIEm8IdW1T5Okx236/iGnV9P4PIfwcokNj2It4xketRsFBouATBGj0xs2+nEkmObi1M8GmiGXgnOsFfWJjQB782uD/RyrM/AgOr/I+bMvo3heZIWKhtnp68y/sRSNKNSNUXXoO52jyts1RjfwXg3OZIDgW2gzYyTO+HCladoFEUCgYAgzQGob5oBz6f01VPa9f0vUdjvN9tzgarM4Hxj9ubLS+7YTt+lrf+kSxBL0u/jLH7n3BIFikoio5ZQaoEobpdbkebab44XjrOtAnYeLIiLscSu9hD5WdzkPw1THsimyk/Z7vwx7OC74VbEPlJp+EDL16Pw5mUfwOC0tZIyDH9NuQKBgQCCD9NA2ees/9LleiO5IYMUlYNqKeSyXw30C1SQHP9rrFu0B3G/TL6fhnnY6RZmd6KlFZMQNfdoqQJC48sEzovbsLH/+0HsJFAfGLG4ic1MHwsY5F9RJYtVC1aIVv0AaQH48mB17CQeJBQ/VneyBE2puD4lvxQUskfJLGK1m1bGWQKBgQCReOzBfLGxO/rtwX3vQyJnqhiJaOtC4kuCBRUDPWFTmTkO5GvscCJFajFPss3mpZGidErNFeZlHRXCUlM3cQTzUSnD0QrRaYc+4EuftvESzekAlqVeKNpaH2slOwyAJraNWCpdxBWuZAWTWbWimp6SDJbTnlbwMmtM1U6ywo6nFw==",
		
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
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjQhnhXSbmkXsl3C5Xw59okRhoQ6zrNWaXsxRGmf4WUYb3syYbPh2m1podiBuu4GG7De8NzQ4TCOu+d2uEythCZ17Ph0x8QPQtUSx8/xgGRxpyuqOXvnCbaDW1CYBzA5fFrlF49vBY3Jwh610smEKsUA+ofhJavcE9pR9ilisJRRCzM51IftBGezHTd1uQY13IVRVFM/qeNZvAbNvg3FjvvCRyelunlZPbcDru8Qtap56KbabynD+MAgWForM1iN9HkTNaAQBDWIqXNCPF0I1r37MBIXzFhiMCH4xEDLFcHYd7dTrM0vw9fEmMrJLAAYiVxJnbCclLOeGNgt6dA2/IQIDAQAB",
		
	
);