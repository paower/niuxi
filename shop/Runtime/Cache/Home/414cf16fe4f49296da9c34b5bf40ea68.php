<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>我的团队</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
<link href="/Public/home/wap/css/stylexin.css" rel="stylesheet">
<style>
	.set-list{padding-top:12px;}
    .set-list li{border-bottom:1px solid #a2a2a2;}
    .set-list li a{display:block;padding:12px;}
    .set-list li a .fr span{color:#ccc;}
    .set-foot .btn{padding:12px;display:block;background:#4c0db3;text-align:center;margin:24px 12px;border-radius:5px;}
	.share_ul{
		height:76px;
		width:100%;
	}
</style>
<body class="bg96">

<div class="header">
    <div class="header_l">
        <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
    </div>
    <div class="header_c"><h2>我的团队</h2></div>
    <div class="header_r"></div>
</div>

<div class="big_width100 por" style="margin-top:0px;">
	<div class="fish-main">
		<ul class="set-list">
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">累计推广收益</div>
					<div class="fr"><span class="nick_name"><?php echo ($ljsy); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">有效直推人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($son); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">有效团队人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($team_vip_num); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">直推激活人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($son_jihuo); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">有效二代人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($son2); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">二代激活人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($son2_jihuo); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">有效三代人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($son3); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">三代激活人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($son3_jihuo); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">团队激活人数</div>
					<div class="fr"><span class="nick_name"><?php echo ($team_jihuo); ?></span></div>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="clearfix">
					<div class="fl">今日团队业绩</div>
					<div class="fr"><span class="nick_name"><?php echo ($money); ?></span></div>
				</a>
			</li>
		</ul>
	</div>
	<div class="set-foot">
        <a href="<?php echo U('User/Teamdets');?>" class="btn">团队列表</a>
    </div>
	
</div>
</body>
</html>