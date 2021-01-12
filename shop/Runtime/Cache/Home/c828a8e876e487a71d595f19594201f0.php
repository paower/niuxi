<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>详情内容</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
<body class="bgff ">
	
	<div class="header">
	    <div class="header_l">
	    <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
	    </div>
	    <div class="header_c"><h2>详情内容</h2></div>
	    <div class="header_r"></div>
	</div>
    

     <div class="big_width100">

        <div class="AnnouncementDetails clear_wl">
        	 <h2 class="annDe_h2"><?php echo ($newdets['title']); ?></h2>

        	 <div class="AnnouncementDetails_de">
        	 	<p>
					<?php echo (html_entity_decode($newdets['content'] )); ?>
        	 	</p>
        	 </div>
        </div>
        
	      

	    
           
	      
	</div>

	   


</body>

</html>