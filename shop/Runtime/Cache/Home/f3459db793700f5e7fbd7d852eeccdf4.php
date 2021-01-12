<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- <link rel="shortcut icon" href=""> -->
    <!-- css -->
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet">
	
<style>
    .set-list{padding-top:12px;}
    .set-list li{border-bottom:1px solid #a2a2a2;}
    .set-list li a{display:block;padding:12px;}
    .set-list li a .fr span{color:#ccc;}
    .set-foot .btn{padding:12px;display:block;background:#4c0db3;text-align:center;margin:24px 12px;border-radius:5px;}
	.nick_name{
		display:inline-block;
		overflow: hidden;
		text-overflow:ellipsis;
		white-space: nowrap;
		max-width: 200px;
		float: left;
	}
</style>

</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <a href="javascript:window.history.back();" class="head-back"><span>返回</span></a>
    <h3 class="head-tit"><span>设置</span></h3>
</div>
<div class="fish-main">
    <ul class="set-list">
        <li>
            <a href="<?php echo U('User/Setuname');?>" class="clearfix">
                <div class="fl">用户名</div>
                <div class="fr"><span class="nick_name"><?php echo ($settuname['username']); ?></span><i class="icon-right"></i></div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="clearfix">
                <div class="fl">当前账户</div>
                <div class="fr"><span><?php echo ($settuser['mobile']); ?></span></div>
            </a>
        </li>
    </ul>
    <ul class="set-list">
        <li>
            <a href="<?php echo U('User/Setpwd',array('type'=>1));?>" class="clearfix">
                <div class="fl">登录密码</div>
                <div class="fr"><i class="icon-right"></i></div>
            </a>
        </li>
        <li>
            <a href="<?php echo U('User/Setpwd',array('type'=>2));?>" class="clearfix">
                <div class="fl">支付密码</div>
                <div class="fr"><i class="icon-right"></i></div>
            </a>
        </li>
        <li>
            <a href="<?php echo U('Growth/Cardinfos');?>" class="clearfix">
                <div class="fl">收款账户</div>
                <div class="fr"><i class="icon-right"></i></div>
            </a>
        </li>
    </ul>
    <ul class="set-list">
        <!-- <li> -->
            <!-- <a href="<?php echo U('User/customer_service');?>" class="clearfix"> -->
                <!-- <div class="fl">客服中心</div> -->
                <!-- <div class="fr"><i class="icon-right"></i></div> -->
            <!-- </a> -->
        <!-- </li> -->
		<li>
            <!-- <a href="javascript:void(0);" onclick="shop()" class="clearfix"> -->
            <a href="<?php echo U('Shop/Home/index');?>" class="clearfix">
                <div class="fl">线上商城</div>
                <div class="fr"><i class="icon-right"></i></div>
            </a>
        </li>
        <li>
            <a href="<?php echo U('User/Aboutus');?>" class="clearfix">
                <div class="fl">关于我们</div>
                <div class="fr"><i class="icon-right"></i></div>
            </a>
        </li>
    </ul>
    <div class="set-foot">
        <a href="<?php echo U('User/Loginout');?>" class="btn" @click="send()">退出账号</a>
    </div>
</div>

    </div>
    <!-- js -->
	<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
<script>
	function shop(){
				layer.msg("线上商城未开放");
			}
</script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            info: '',
        },
        computed: {
            
        },
        methods: {
            member: function(){
                var self = this;
                core.load("/index/setup/index.html", {}, function(res){
                    console.log(res);
                    if(res.code==0){
                        self.info=res.info;
                    }else{
                        core.toast(res.msg);
                    }
                })
            },
            send: function(){
                localStorage.uid='';
                //localStorage.clear();
                core.toast('成功退出登录！');
                // 跳转到首页
                setTimeout(function(){
                    window.location.href = "/home/publics/login.html";
                }, 300);
            },
        },
        mounted: function(){
            this.member();
        }
    });
</script>

</body>
</html>