<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>找回密码</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- css -->
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet">
	<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css" >
<style>
    body{
		background:#270858url('images/login_bg_2.png');
		width:100%;height:100%;
		background-size:cover;
	}
	
    .fish-head{background:none}
    .bus-list{padding:12px;overflow: hidden;}
    .bus-list li{padding:12px;background-color:#fff;border-bottom:1px solid #eee;overflow: hidden;}    
    .bus-list li input{background-color:#fff;}
    .bus-list li .set-file{position:absolute;left:0;right:0;top:0;bottom:0;opacity:0;}
	.getcode{
		position: absolute;
		top: 6px;
		right: 10px;
		background-image: linear-gradient(160deg, #49218a 20%,#910adb 80%);
		background-size: cover;
		color: #fff;
		height: 32px;
		line-height: 32px;
		text-align: center;
		border-radius: 32px;
		width: 92px;
	}
	.fortxt{
		height:40px;
		line-height:40px;
		font-size:18px;
		text-align:center;
	}
	.fortxt .fortxt_line{
		
	}
</style>

</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <a href="javascript:window.history.back();" class="head-back"><span><</span></a>
</div>
<div class="fish-main">  

	 <form name="getpwdfrom" id="forgetForm" class="formrgister formgetpsw don-form" action="<?php echo U('setpsw');?>" method="post" >
	<div class="fortxt">
		<span class="fortxt_line">－ </span>
		<span>找回密码</span>
		<span class="fortxt_line"> －</span>
	</div>
	<div class="input_box"> 		
		<div class="input-item">
			<i class="icon layui-icon layui-icon-cellphone" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="text" name="mobile" class="phone_number" placeholder="请输入手机号码" maxlength="11" autocomplete="off" id="number"/>
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-vercode" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="code" name="code" class="code" placeholder="请输入验证码" oncontextmenu="return false" onpaste="return false" />		
			<a href="#" class="getcode" id="mycode">发送验证码</a>
			
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-password" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="password" name="password" class="password" placeholder="请设置新登录密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-password" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="password" name="passwordmin" class="passwordmin" placeholder="确认新的登录密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		
		<div class="input-foot">
			<button id="submit" class="foot-btn" type="button" onclick="SetPwd()">确 定</button>			
		</div>
	</div>
    </form>
</div>

    </div>
	<!-- js -->
	<script src="https://www.jq22.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="/Public/home/wap/js/common.js"></script>
	<script src="/Public/home/wap/js/jquery.validate.min.js?var1.14.0"></script>
	<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
	<script type="text/javascript"  src="/Public/home/common/layer/layer.js" ></script>
	
<script type="text/javascript">
    $('#mycode').click(function(){
        var mobile=$("input[name='mobile']").val();
        if(mobile=='' || mobile==null){
            layer.msg('请输入手机号码');
        }
        $.post("<?php echo U('Login/sendCode');?>",{'mobile':mobile},function(data){
            if(data.status==1){
                layer.msg(data.message);
                RemainTime();
            }else{
                layer.msg(data.message);
            }
        });
    });

    var intime="<?php echo (session('set_time')); ?>";
    var timenow ="<?php echo time(); ?>";

    var bet=(parseInt(intime)+60)-parseInt(timenow);
    $(document).ready(function(){
        if(bet>0){
            RemainTime();
        }
    });
    var iTime = 59;
    var Account;
    if(bet>0){
        iTime=bet;
    }
    function RemainTime(){
        var iSecond,sSecond="",sTime="";
        if (iTime >= 0){
            iSecond = parseInt(iTime%60);
            iMinute = parseInt(iTime/60)
            if (iSecond >= 0){
                if(iMinute>0){
                    sSecond = iMinute + "分" + iSecond + "秒";
                }else{
                    sSecond = iSecond + "秒";
                }
            }
            sTime=sSecond;
            if(iTime==0){
                clearTimeout(Account);
                sTime='获取验证码';
                iTime = 59;
            }else{
                Account = setTimeout("RemainTime()",1000);
                iTime=iTime-1;
            }
        }else{
            sTime='没有倒计时';
        }
        $('#mycode').html(sTime);
        //document.getElementById('').html(123);
    }
</script>
</body>
</html>