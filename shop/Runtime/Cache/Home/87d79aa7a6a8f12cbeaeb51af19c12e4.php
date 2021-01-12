<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>预约记录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" /> 
	
<style>
    .app-list{position:relative;}
    .app-list li{border-bottom:1px solid #a2a2a2;}
    .app-list li a{display:block;padding:12px;color:#ccc;}
    .app-list li a .fl h3{font-size:16px;color:#fff;}
    .app-list li a .fr{text-align:right;}
    .green{color:#cc87f9;font-size:16px;}
    .red{color:#E02737;font-size:16px;}
</style>

   <!-- <script src="/Public/home/wap/js/vue.min.js"></script>
    <script src="/Public/home/wap/js/jquery.min.js"></script>
    <script src="/Public/home/wap/js/core.js"></script> -->
</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <a href="javascript:window.history.back();" class="head-back"><span>返回</span></a>
    <h3 class="head-tit"><span>预约记录</span></h3>
</div>
<div class="fish-main">
    <ul class="app-list">
        <?php if(is_array($res)): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list.length>0">
                <a href="javascript:;" class="clearfix">
                    <div class="fl">
                        <h3><?php echo ($vo['xing_title']); ?></h3>
                        <div><?php echo (date("Y-m-d H:i:s",$vo['get_time'])); ?></div>
                    </div>
                    <div class="fr">
                        <div><span class="red" v-else>-<?php echo ($vo['get_nums']); ?></span></div>
                        <div>预约</div>
                    </div>
                </a>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="dialog-bottom"></div>
</div>

    </div>
    <!-- js -->
	
<script>
    var app = new Vue({
        el: '#app',
        data: {
            list: [],
            page: 0,
            status: true,
        },
        computed: {
            
        },
        methods: {
            loadList: function(){
                var self = this;
                var data = {
                    page: self.page,
                    limit: 12,
                };

                core.load("/index/my/make_record.html", data, function(res){
                    console.log(res);
                    if(res.code=='0'){
                        if(res.info.length>0) self.list = self.list.concat(res.info);
                        if(!res.info || (res.info.length<data.limit)){
                            self.status = false;
                            $('.dialog-bottom').eq(0).html('已经加载全部数据');
                        }else{
                            $('.dialog-bottom').eq(0).html('<i class="loading"></i> 正在加载...');
                        }
                    }else{
                        core.toast(res.message);
                    }
                })
            }
        },
        mounted: function(){
            var self = this;
            self.loadList();
            // 下拉加载
            $(window).off("scroll").on("scroll", function(e){
                var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop()) + 60;
                if (($(document).height()<=totalheight) && self.status){
                    self.page = ++self.page;
                    self.loadList()
                }
            });
        }
    });
</script>

</body>
</html>