<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title><?php echo ($config['SITE_TITLE']); ?></title>
    <meta name="Keywords" content=""/>
    <meta name="description" content=""/>
    <!--线上JQ包-->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!--本地JQ包-->
    <!--<script src="/Public/Public/js/jquery-1.12.1.min.js"></script>-->
    <script type="text/javascript" src="/Public/Public/js/layer/layer.js"></script>



    <script src="/Public/Public/js/mui.min.js"></script>
    <link href="/Public/Public/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Public/Public/icon/iconfont.css">
    <link rel="stylesheet" href="/Public/Public/css/styleshop.css"/>
    <link rel="stylesheet" href="/Public/Public/css/style1.css">
    <link rel="stylesheet" href="/Public/Public/icon1/iconfont.css">
    <script type="text/javascript">        !function (J) {
        function H() {
            var d = E.getBoundingClientRect().width;
            var e = (d / 7.5 > 100 * B ? 100 * B : (d / 7.5 < 42 ? 42 : d / 7.5));
            E.style.fontSize = e + "px", J.rem = e
        }

        var G, F = J.document, E = F.documentElement, D = F.querySelector('meta[name="viewport"]'), B = 0, A = 0;
        if (D) {
            var y = D.getAttribute("content").match(/initial\-scale=([\d\.]+)/);
            y && (A = parseFloat(y[1]), B = parseInt(1 / A))
        }
        if (!B && !A) {
            var u = (J.navigator.appVersion.match(/android/gi), J.navigator.appVersion.match(/iphone/gi)),
                t = J.devicePixelRatio;
            B = u ? t >= 3 && (!B || B >= 3) ? 3 : t >= 2 && (!B || B >= 2) ? 2 : 1 : 1, A = 1 / B
        }
        if (E.setAttribute("data-dpr", B), !D) {
            if (D = F.createElement("meta"), D.setAttribute("name", "viewport"), D.setAttribute("content", "initial-scale=" + A + ", maximum-scale=" + A + ", minimum-scale=" + A + ", user-scalable=no"), E.firstElementChild) {
                E.firstElementChild.appendChild(D)
            } else {
                var s = F.createElement("div");
                s.appendChild(D), F.write(s.innerHTML)
            }
        }
        J.addEventListener("resize", function () {
            clearTimeout(G), G = setTimeout(H, 300)
        }, !1), J.addEventListener("pageshow", function (b) {
            b.persisted && (clearTimeout(G), G = setTimeout(H, 300))
        }, !1), H()
    }(window);
    if (typeof(M) == 'undefined' || !M) {
        window.M = {};
    }    </script>
    <style>    
		.fxm_left img {
        width: 4vmin;
        margin-top: 9vmin;
        height: 6vmin;
        float: left;
        margin-left: 3vmin;
    }

    .user-order-box ul li {
        width: 25%;
    }   
    .member-info .user-name .info-fan{
        <!-- display: flex; -->
        flex-direction: column;
        align-items: center;
        justify-content: center;
      
    } 
    .member-info .user-name .info-fan a{
        background: #F15353;
        padding:  0 2vmin;
        box-shadow: 1px 1px 1px rgba(0,0,0,0.15);
        font-size:3.8vmin;


    }
    </style>
</head>
<body>
<div class="member-top">
    <div class="fxm_left"><a href="<?php echo U('/Shop/Home/index');?>"><img src="/Public/Public/images/left0.png"></a></div>
    <div class="header-r"><a href=""><i class="iconfont"></i></a></div>
    <div class="member-info">
        <div class="user-avatar"><img src="/Public/home/wap/heads/<?php echo ($uinfo['img_head']); ?>"></div>
        <div class="user-name">
		<div>GEO消耗累计:<?php echo ($uinfo['pay_geo']); ?></div>
            <?php if(($member['status']) == 0 ): ?><div class="info-fan">
                <span><?php echo ($member['username']); ?></span>
                <a href="<?php echo U('Member/verify');?>">升级商家</a>
            </div>
            <?php else: ?>
                <div class="info-fan"><?php echo ($member['username']); ?></div><?php endif; ?>
        </div>
    </div>
</div>
<div class="user-order-box">
    <dl><a href="<?php echo U('Member/allorder',array('s'=>5));?>">
        <dt><strong>全部订单</strong> <span>查看全部订单</span></dt>
    </a></dl>
    <ul>
        <li><a href="<?php echo U('Member/allorder',array('s'=>0));?>">
            <div class="user_order"><i class="iconfont">&#xe631;</i></div>
            <span>待付款</span> </a></li>
        <li><a href="<?php echo U('Member/allorder',array('s'=>1));?>">
            <div class="user_order"><i class="iconfont">&#xe775;</i></div>
            <span>待发货</span> </a></li>
        <li><a href="<?php echo U('Member/allorder',array('s'=>2));?>">
            <div class="user_order"><i class="iconfont">&#xe775;</i></div>
            <span>待收货</span> </a></li>
        <li><a href="<?php echo U('Member/allorder',array('s'=>3));?>">
            <div class="user_order"><i class="iconfont">&#xe605;</i></div>
            <span>已完成</span> </a></li>
    </ul>
</div>
<div class="uset-center-content">
   <a
        href="<?php echo U('Member/moneydets');?>"> <em class="exchange-icon"></em>
    <dl>
        <dt>商城收益</dt>
        <dd></dd>
    </dl>
</a> 
 <a
        href="<?php echo U('Member/addresslist');?>"> <em class="consignee-address-icon"></em>
    <dl class="border_bottm">
        <dt>收货地址</dt>
        <dd style='color: red;'>添加/修改</dd>
    </dl>
</a> <a href="<?php echo U('Shop/Member/Mineorders');?>"> <em class="groupon-icon"></em>
    <dl>
        <dt>我的订单</dt>
		<dd></dd>
    </dl>
</a><a
        href="<?php echo U('Member/verify');?>"> <em class="user-info-icon"></em>
    <dl>
        <dt>认证中心</dt>
        <dd style='color: red;'>前往认证</dd>
    </dl>
</a>
    <?php if(($member['status']) == "1"): ?><a href="<?php echo U('Shop/Home/Business');?>"> <em class="product-upload-icon"></em>
        <dl>
            <dt>产品上传</dt>
        </dl>
    </a> <a href="<?php echo U('Shop/Home/Minepros');?>"> <em class="product-manage-icon"></em>
        <dl>
            <dt>产品管理</dt>
        </dl>
    </a> <a href="<?php echo U('Shop/Dianpu/dp_info');?>"> <em class="myshop-icon"></em>
        <dl>
            <dt>我的店铺</dt>
        </dl>
    </a><?php endif; ?>
</div>
<div class="uset-center-content"><a href="<?php echo U('Member/loginout');?>"> <em class="sign-off-icon"></em>
    <dl>
        <dt>注销登录</dt>
    </dl>
</a></div>
<div class="h50"></div>
<?php $name= ACTION_NAME; ?>
<!-- 底部 -->

<style type="text/css">
    .footer a p{
            box-sizing:content-box;
            color: #333333;
    }

    .footer a{
            box-sizing:content-box;

    }

    .footer{
            box-sizing:content-box;
    }
</style>
<div class="footer">
    <a href="<?php echo U('/Shop/Home/index');?>" <?php if(($name) == "index"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>首页</p>
    </a>
     <a href="<?php echo U('/Shop/Home/cation');?>" <?php if(($name) == "cation"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>店铺分类</p>
    </a>
     <a href="<?php echo U('/Shop/Car/shopping');?>" <?php if(($name) == "shopping"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>购物车</p>
    </a>
     <a href="<?php echo U('/Shop/member/mine');?>" <?php if(($name) == "mine"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>我的</p>
    </a>
</div>



</body>
</html>








<script>    //链接跳转问题    mui('body').on('tap', 'a', function() {        document.location.href = this.href;    });    $(function () {        var elm = $('#shortbar');        var startPos = $(elm).offset().top;        $.event.add(window, "scroll", function(){            var p = $(window).scrollTop();            if (p > startPos) {                elm.addClass('sortbar-fixed');            }            else {                elm.removeClass('sortbar-fixed');            }        });    });</script>


<script>


// 升级商家
function upshop(vip_grade){
    // console.log(vip_grade);
    if(vip_grade < 3){
        layer.msg('请升级为金钻会员');
        return ;
    }

    
    $.get('/Shop/Member/upshop?vip_grade='+vip_grade,function(res){
        if(res.status == 1){
            layer.msg(res.message,{time:1000},function(){
                window.location.href = res.url;
            });
        }else{
            layer.msg(res.message);
        }
    },'json');
}
</script>