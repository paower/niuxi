<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>关于我们</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" /> 
	
<style>
    .content{position:relative;overflow:hidden;padding:20px 16px 12px;}
    .title{font-size:22px;margin-bottom:14px;font-weight:700;}
    .info{margin-bottom:22px;line-height:20px;font-size:0;}
    .info span{display:inline-block;vertical-align:middle;margin:0 10px 10px 0;font-size:15px;color:rgba(0,0,0,0.3);}
    .box{font-size:16px;overflow:hidden;}
    .box img{width:100%;}
    .qrcode{position:relative;margin-top:14px;}
    .qrcode .qrcode-bg{width:100%;margin:0 auto;display:block;}
    .qrcode .qrcode-qr{width:32%;position:absolute;bottom:18%;left:50%;transform:translateX(-50%);}
    .box-link{margin-top:14px;text-align:center;}
</style>

</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <a href="javascript:window.history.back();" class="head-back"><span>返回</span></a>
    <h3 class="head-tit"><span>关于我们</span></h3>
</div>
<div class="fish-main">
    <div class="content">
        <!-- 文章标题 -->
        <h1 class="title" v-text="info.title">十二星座</h1>
        <!-- 文章信息 -->
        <!-- <div class="info">
            <span><a href="javascript:void(0);"></a></span>
            <span></span>
            <span></span>
        </div> -->
        <!-- 文章内容 -->
        <div class="box" v-html="info.content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;全球公布数字理财游戏十二星座，去中心化、公正透明区块链理财游戏平台在于2019年7月6日正式全球启动。十二星座是由BIockchain App Factory创建，以收藏游戏为主，提供推广区块链营销的创新的解决方案，增加理财式不断增加游戏的用户量，目前式全球启动。十二星座是由BIockchain App Factory的全球办事处，主要位于新加坡、马来西亚、澳大利亚涵盖业务和规模主要以区块技术和营销为主，我们在区块链开发方面的专业知识使我们能够为各行各业提供了定制区块链的解决方案，通过战略性设计的ICO，数字理财游戏开发和管理。实现流程的分散和自动化，并节省运营成本。对于游戏玩家来说每一个玩家都能拥有对游戏账户唯一控制权，游戏发行方与运营方都无法通过任何途径来篡改和删除用户的游戏控制权。我们的服务宗旨是为您提供成功所需的平台，共同探索各种可能性。
        新家坡营销团队祝全球十二constellation玩家们生活愉快！
                      <span style="text-align:right;width:100%;float: right;"> 2019年7月6日 </span> </div>
      
    </div>
     <!--<div class="dialog-bottom">已经加载全部！</div>-->
</div>

    </div>
    <!-- js -->
	
<script>
    var app = new Vue({
        el: '#app',
        data: {
            info: '',
        },
        computed: {

        },
        methods: {
            detail: function(){
                var self = this;

                core.load("/index/publics/play_instructions.html", { }, function(res){
                    console.log(res);
                    if(res.code==0){
                        self.info=res.info;
                    }else{
                        core.toast(res.msg);
                    }
                })
            }
        },
        mounted: function(){
            this.detail();
        }
    });
</script>

</body>
</html>