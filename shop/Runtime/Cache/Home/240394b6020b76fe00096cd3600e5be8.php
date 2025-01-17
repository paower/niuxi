<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet">
	<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css" >
<style>
    body{
		background:#270858url('/Public/home/wap/images/appxz-bg.png');
		width:100%;height:100%;
		background-size:cover;
	}
    .fish-head{}
	.act_box{
	
	}
	.act_box a{
		color:#666 !important;
	}
	.act_box .reg_fer{
		display: flex;
		margin-top:10px;
	}
	.act_box .reg_fer .reg_fer_s{
		flex:1;
		
		height:50px;
		line-height:50px;
	}
	.act_box .reg_fer .reg_fer_s a{}
	.act_box .reg_fer .reg_fer_s.reg_fer_sl{
		text-align:left;
		padding-left:2em;
	}
	.act_box .reg_fer .reg_fer_s.reg_fer_sr{
		text-align:right;
		padding-right: 2em;
	}
	.act_box .shens{
		text-align:center;
		margin-top:20px;
		display: flex;
		padding:0 20px;
	}
	.act_box .shens .shens_s{
		flex:1;
	}
	.act_box .shens .shens_c{
	
	}
	.act_box .shens .shens_c a{
		color:#9957f2;
	}
	.act_box .shens .shens_l{
		border-bottom: 1px solid #9957f2;
		margin: 0 10px 10px 10px;
		
	}
	.act_box .shens .shens_r{
		border-bottom:1px solid #9957f2;
		margin: 0 10px 10px 10px;		
	}
	.remen{
		padding-left: 32px;
		height:20px;
		line-height:20px;
	}
	.remen .remen_icon{
		width:15px;
		height:15px;
		background:url('images/unremember_icon.png');		
		background-size:cover;
		float:left;
		margin:3px 7px 0 0;
	}
	.remen .remen_icon.remen_yes{
		background:url('images/remember_icon.png');
		background-size:cover;
	}
	.remen span{
		color:#666;
		float:left;
	}
	.userlist{
		position: absolute;
	    line-height: 25px;
	    width: 100%;
	    padding: 0px 0px 0px 52px;
	    border-radius: 7px;
	    border: none;
	    /* background: none; */
	    background: #fff;
	    overflow: hidden;
	    color: #000;
	    z-index: 999;
	}
</style>
</head>
<body>
    <div id="app">
		

<div class="logo-box">
    <div class="logo-img"><img src="/Public/home/wap/images/logo.png" alt="ICON"></div>
</div>
<form name="formlogin" id="loginForm" class="don-form formlogin" method="post" action="<?php echo U('Login/checkLogin');?>">
	<div style="height:40px;"></div>
	<div class="input_box"> 
		<div class="input-item" >
			<i class="icon layui-icon layui-icon-username" style="color:#2b4ab2; font-size:22px;"></i>
			
			<input type="text" name="account" class="username" placeholder="请输入手机号" autocomplete="off" id="addressInput" onclick="selectclick()" />
			 <span style="margin-left:100px;width:18px;margin-top: -30px;float: right;color: #000" onclick="xuanze()">
				▼
			</span>
				<div class="userlist">
					<ul id="userlistul" style="display: none;">
					</ul>
				</div>
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-password" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="password" name="password" class="password" placeholder="请输入密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div class="input-foot">
			<button  class="foot-btn"  id="submit" type="button" onclick="login()">登陆</button>
		</div>
		
		<div class="act_box">
			<div class="reg_fer">
				<div class="reg_fer_s reg_fer_sl">
					<a href="<?php echo U('Login/register');?>">立即注册</a>
				</div>
				<div class="reg_fer_s reg_fer_sr">
					<a href="<?php echo U('login/getpsw');?>">忘记密码？</a>
				</div>
			</div>
		</div>
	</div>
	
	
</form>

    </div>
<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>


<!--表单验证-->
<script src="/Public/home/wap/js/jquery.validate.min.js?var1.14.0"></script>
<!--commonjs-->
<script type="text/javascript" src="/Public/home/common/layer/layer.js" ></script>
<script type="text/javascript" src="/Public/home/common/js/jquery-1.9.1.min.js" ></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
<script src="/Public/home/wap/js/jquery.cookie.js"></script>
<script>
	// array.unshift()
	$(function(){
		var myCookie = $.cookie('userlist');
		if($.cookie('userlist')){
			var newObject = JSON.parse(myCookie);
			$('.username').val(newObject[0]);
			$.each(newObject,function(index,value){
				
			     $("#userlistul").append('<li onclick="isid('+value+')">'+value+'</li>');
				
			});
		}
	})

	function xuanze(){
		 $("#userlistul").toggle();
	}
	function getValue(value,inputId){
		document.getElementById(inputId).value=value;
	}
	function isid(phone){
		$('#addressInput').val(phone);
		$('#userlistul').css('display','none');
	}
</script>
</body>
</html>