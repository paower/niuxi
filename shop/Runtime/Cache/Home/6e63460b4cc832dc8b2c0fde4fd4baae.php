<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>转出</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js" ></script>

<body class="bg96">
	
	<div class="header">
	    <div class="header_l">
	    <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
	    </div>
	    <div class="header_c"><h2>转出</h2></div>
	    <div class="header_r"></div>
	</div>

       <div class="big_width100">
	       <div class="fill_sty">
	       	<p>对方账号</p>
	       	<input type="number" name="other_account" placeholder="输入对方手机号/UID" autocomplete="off" id="phone_uid">
	       </div>
	       <div class="buttonGeoup">

	       	<a href="#" class="not_next" id="ternNextStep">下一步</a>
	       </div>
	   </div>
	     <script type="text/javascript">
          $('#ternNextStep').on('click', function(){
              Checku();
		  });

	   </script>

</body>
</html>