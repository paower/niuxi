<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet">
	<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css" >
	<script type="text/javascript" src="/Public/home/common/js/jquery-1.9.1.min.js" ></script>
	<script type="text/javascript" src="/Public/home/common/layer/layer.js" ></script>
	<script type="text/javascript" src="/Public/home/common/js/index.js" ></script>
	
<style>
    body{
		background:#270858url('images/login_bg_2.png');
		width:100%;height:100%;
		background-size:cover;
	}
    .fish-head{background:none}
    .fish-head .head-back{
		/*background-image: url('images/icon-back01.png')*/
		color:#fff;
	}
    .form-link .icon{height:15px;width: 15px;margin-right: 5px;vertical-align:-3px;}
    .icon-agree{background-image: url('images/icon-agree.png');}
    .icon-agree01{background-image: url('images/icon-agree01.png');}
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
	.down{
		text-align:center;
	}
	.down a{
		font-size: 18px;
		color: #fff;
		font-weight: bold;
		cursor: pointer;
	}	
	.queren_box{
		display:none;
	}
	.queren_box.show{
		display:block;
	}
	.queren_bg{
		position: fixed;
		z-index: 99;
		top: 0px;
		left: 0;
		bottom: 0;
		right: 0;
		height: 100%;
		width: 100%;
		background: #000;		
		opacity: 0.5;
	}
	.queren_box .queren_con{		
		z-index: 100;
		position: fixed;
		top: 0;
		left: 0;
		margin-left:0px;
		margin-top:0px;
		bottom: 0;
		right: 0;
		height: 100%;
		width: 100%;
		text-align:center;		
	}
	.queren_box .queren_con .queren_conin{		
		position: fixed;
		top: 50%;
		left: 50%;
		margin-left:-160px;
		margin-top:-50px;
		background:#fff;		
		width:320px;
		height:100px;		
	}
	.queren_box .queren_con .queren_conin .title{
		padding-top:15px;
		color:#fb3838;
	}
	.queren_box .queren_con .queren_conin .sub{
		padding-top:25px;
		color:#fb3838;
	}
	.queren_box .queren_con .queren_conin .sub span{
		padding:2px 10px;
		border:1px solid #fb3838;
	}
	
	
</style>
</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <a href="javascript:window.history.back();" class="head-back"><span><</span></a>
</div>
<div class="logo-box">
   
</div>
 <form name="AddUser" action="<?php echo U('Login/register');?>" id="registerForm" class="don-form" method="get">
	<div class="fortxt">
		<span class="fortxt_line">－ </span>
		<span>用户注册</span>
		<span class="fortxt_line"> －</span>
	</div>
	<div class="input_box">
		<div class="input-item">
			<i class="icon layui-icon layui-icon-username" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="text" name="username" class="username" placeholder="请输入昵称" autocomplete="off"/>
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-username" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="number" name="mobile" class="phone_number" placeholder="请输入手机号码" autocomplete="off" id="number"/>
		</div>
		<div class="input-item" id="captcha-container">
			<i class="icon layui-icon layui-icon-vercode" style="color:#2b4ab2; font-size:22px;"></i>
			<input name="verify" class="code" placeholder="请输入图形验证码"  id="j_verify" type="text">
			<img class="getcode" style="border-radius: 0;" alt="图形验证码" src="<?php echo U('Home/Login/verify_c',array());?>" title="点击刷新">
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-vercode" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="number" id="code" name="smscode" class="code" placeholder="请输入验证码" oncontextmenu="return false" onpaste="return false" />
			<a href="#" class="getcode" id="mycode">发送验证码</a>
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-password" style="color:#2b4ab2; font-size:22px;"></i>
			 <input type="password" name="login_pwd" class="password" placeholder="请输入登录密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-password" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="password" name="relogin_pwd" class="confirm_password" placeholder="确认登录输入密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-password" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="password" name="safety_pwd" class="safety_pwd" placeholder="请输入交易密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div class="input-item">
			<i class="icon layui-icon layui-icon-friends" style="color:#2b4ab2; font-size:22px;"></i>
			<input type="text" name="pid" placeholder="请输入推荐人手机号" value="<?php echo ($mobile); ?>">
		</div>
		<div class="input-foot">
			<button class="foot-btn" id="submit"  type="button" onclick="adduser()":style="agreeType!=1 ? 'background:#999;border-radius: 50px;': ''">注 册</button>
		</div>
		<div class="form-link clearfix" >
			<div class="act text-center"><span>
			<i class="icon layui-icon layui-icon-radio" style="color:#2b4ab2; font-size:22px;"></i>
				同意</span><a href="#" style="color:#9957f2 !important;">《用户协议与法律声明》</a></div>
		</div>
	</div>
	<br>
	<!-- <div class="down" v-if="down"> -->
		<!-- <a href="#"> -->
			<!-- — 点击下载app — -->
		<!-- </a> -->
		
	<!-- </div> -->
	<br>
	<br>
</form>
</div>
 <!--表单验证-->
<script src="/Public/home/wap/js/jquery.validate.min.js?var1.14.0"></script>
<script type="text/javascript">
    // 验证码生成  
    var a=1;
    var captcha_img = $('#captcha-container').find('img')  
    var verifyimg = captcha_img.attr("src");  
    captcha_img.attr('title', '点击刷新');  
    captcha_img.click(function(){  
        if( verifyimg.indexOf('?')>0){  
            $(this).attr("src", verifyimg+'&random='+Math.random());  
        }else{  
            $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());  
        }  
    }); 
    $("#j_verify").blur(function() {
     
        $.post("<?php echo U('Login/check_verify');?>", {
            code : $("#j_verify").val()
            }, function(data) {
            if (data == true) {
                //验证码输入正确
                a=0;
                 layer.msg('图形验证码正确');
                
            } else {
                //验证码输入错误
                a=1;
                layer.msg('图形验证码错误');
                
            }
        });
    });
        $('#mycode').click(function(){
            // alert(a);
            var mobile=$("input[name='mobile']").val();
            if(mobile=='' || mobile==null){
                layer.msg('请输入手机号码');
           }
            
            if(a==1){
                layer.msg('图形验证码错误');
            }else{
               $.post("<?php echo U('Login/sendCode');?>",{'mobile':mobile},function(data){
             console.log(data);
                if(data.status==1){
                 layer.msg(data.message);
                    RemainTime();
               }else{
                    layer.msg(data.message);
                }
            });
            }
           
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
        }
    </script>

</body>
</html>