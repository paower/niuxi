<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>已购产品</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
   <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" />
	<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css" >
<style>
    .head-tit{font-weight:bold;}    .pond01{margin-right:5px;height:15px;width:15px;vertical-align:-3px;}
    .pond-top{text-align:center;padding:10px 0;}
    .pond-top a{background:#182121 url('/Public/home/wap/images/pond-top-bg.png') no-repeat bottom center;background-size:100% 100%;display:inline-block;padding:5px 12px;border-radius:8px;color:#ccc;}
    .pond-top a span{color:#bc35ff}
    .pond-list{position:relative;}
	.pond-list .fish_bg{
		background: #BB9EF0;
		position: absolute;
		width: 100%;
		height: 100%;
		overflow: hidden;
		opacity: 0.2;		
	}
    .pond-list li{
		margin:0 12px 12px;
		border-radius:8px;
		overflow:hidden;
		position: relative;	
		padding:12px 0;
	}
    .pond-list li .pond-img img{width:100%;max-width:150px;display:block;margin:0 auto;}
    .pond-list li .pond-title{color:#bc35ff;font-size:16px; padding: 10px 0 0 10px;}
    .pond-list li .pond-con{color:#ccc;}
    .pond-list li .pond-con .col-4{padding:0 5px;}
    .pond-list li .pond-con .pond-item{height:5px;width:100%;background:#fff;border-radius:10px;margin-top:9px;overflow:hidden;}
    .pond-list li .pond-con .pond-item>div{height:5px;}
    .pond-list li .pond-hand{position:absolute;top:15px;right:5px;}
    .pond-list li .pond-hand .icon{height:60px;width:60px;}
</style>

    <!-- <script src="/Public/home/wap/js/vue.min.js"></script>
    <script src="/Public/home/wap/js/jquery.min.js"></script>
    <script src="/Public/home/wap/js/core.js"></script> -->
</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <h3 class="head-tit"><span>已购产品</span></h3>
</div>
<div class="fish-main">
    <div class="pond-top">
        <a href="javascript:;">
			<i class="icon pond01"></i>
			购物券：<span><?php echo ((isset($active_num) && ($active_num !== ""))?($active_num):'0'); ?></span>			
			&nbsp;
			总成本：<span><?php echo ((isset($zongjf) && ($zongjf !== ""))?($zongjf):'0'); ?></span></span>
		</a>		
    </div>
    <!-- 星座列表 -->
    <ul class="pond-list">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="clearfix" v-if="list.length>0" @click="toDetail(vo.id)">
                <div class="fish_bg"></div>
                <div class="col-4 pond-img"><img :src="picture/vo.img" alt=""></div>
                <div class="col-8">
                    <h3 class="pond-title text-ellipsis"><?php echo ($vo[title]); ?>
                            &nbsp;&nbsp;&nbsp;
                    </h3>
                    <div class="pond-con" style="padding-left:10px;">
                        <div class="clearfix">
                            <div class="fl">成本:</div>
                            <div class="col-4"><div class="pond-item"><div style="width:100%;background:#f727ef"></div></div></div>
                            <div class="fl"><?php echo ($vo[record_price]); ?></div>
                        </div>
                        <div class="clearfix">
                            <div class="fl">产品:</div>
                            <div class="col-4"><div class="pond-item"><div style="background:#9bd53a"></div></div></div>
                            <div class="fl">100%</div>
                        </div>
                        <div class="clearfix">
                            <div class="fl">收益:</div>
                            <div class="col-4"><div class="pond-item"><div style="width:<?php $startdate=strtotime(date('Y-m-d H:i:s',time()));$enddate=strtotime(date('Y-m-d H:i:s',$vo['dj_time']));$days=round(($enddate-$startdate)/3600/24);echo ($vo[profit_day]-$days)/$vo[profit_day]*100;?>%;background:#33E9F3"></div></div></div>
                            <div class="fl">
                            <?php
 $startdate=strtotime(date('Y-m-d H:i:s',time())); $enddate=strtotime(date('Y-m-d H:i:s',$vo['dj_time'])); $days=round(($enddate-$startdate)/3600/24); $baifen = (int)sprintf("%.2f",($vo[profit_day]-$days)/$vo[profit_day]*100);if($baifen>100)$baifen=100;echo $baifen?>%/<?php echo ($vo['profit_value']*100); ?>%</div>
                        </div>
                        <div class="clearfix">
                            <div class="fl">成长:</div>
                            <div class="col-4"><div class="pond-item"><div style="width:<?php $startdate=strtotime(date('Y-m-d H:i:s',time()));$enddate=strtotime(date('Y-m-d H:i:s',$vo['dj_time']));$days=round(($enddate-$startdate)/3600/24);echo ($vo[profit_day]-$days)/$vo[profit_day]*100;?>%;background:#950CA4"></div></div></div>
                            <div class="fl"><?php
 $startdate=strtotime(date('Y-m-d H:i:s',time())); $enddate=strtotime(date('Y-m-d H:i:s',$vo['dj_time'])); $days=round(($enddate-$startdate)/3600/24); $tian = $vo[profit_day]-$days;if($tian>$vo[profit_day])$tian=$vo[profit_day];echo $tian;?>天/<?php echo ($vo['profit_day']); ?>天</div>
                        </div>
                    </div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="dialog-bottom"></div>
</div>
<div style="height:50px"></div>
<div class="fish-foot clearfix">
		<a href="<?php echo U('Index/index');?>" class="col-4">
			<i class="layui-icon layui-icon-star" style="font-size: 23px;display: block; color: #f727ef;"></i>
			<span>纽西之谜</span>
		</a> 
		<a href="<?php echo U('Index/pond');?>" class="col-4 act">
			<i class="layui-icon layui-icon-chart" style="font-size: 23px;display: block; color: #f727ef;"></i>
			<span>已购产品</span>
		</a> 
		<a href="<?php echo U('User/Personal');?>" class="col-4">
			<i class="layui-icon layui-icon-username" style="font-size: 23px;display: block; color: #f727ef;"></i>
			<span>我的</span>
		</a>
   </div>


    </div>
    <!-- js -->
	
<script>
    var app = new Vue({
        el: '#app',
        data: {
            list: [],
            page: 1,
            status: true,
            mybait: '',
			cost:'',
        },
        computed: {
            
        },
        methods: {
            toDetail: function(id){
                id && (location.href="/home/member/detail.html?type=3&id="+id);
            },
            feed: function(id, index){
                var self = this;
                core.load("/index/fish/feed.html", {fid: id}, function(res){
                    if(res.code==0){
                        self.list[index].is_contract=1;
                    }
                    core.toast(res.msg);
                })
            },
            loadList: function(){
                var self = this;
                var data = {
                    page: self.page,
                    limit: 12,
                };

                core.load("/index/fish/index.html", data, function(res){
                    console.log(res);
                    if(res.code=='0'){
                        if(!self.mybait) self.mybait=res.info.mybait;
						if(!self.cost) self.cost=res.info.cost;
						
                        if(res.info.list.length>0) self.list = self.list.concat(res.info.list);
                        if(!res.info.list || (res.info.list.length<data.limit)){
                            self.status = false;
                            $('.dialog-bottom').text('已经加载全部数据');
                        }else{
                            $('.dialog-bottom').text('正在加载...');
                        }
                    }else{
                        core.toast(res.msg)
                    }
                })
            },
        },
        mounted: function(){
            var self = this;
            self.loadList();
            // 下拉加载
            $(window).off("scroll").on("scroll", function(e){
                var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop()) + 90;
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