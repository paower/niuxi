<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="font-size: 100px;">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5">
		<title>联系客服</title>
		<link href="/Public/home/wap/css/wen.css" rel="stylesheet">
	</head>
<body style="background:#327585;">
  <div id="app">
   <!----> 
   <div class="sec-level">
    <div data-v-c78f367e="" class="center">
	<div data-v-1c99e16c="" class="whead flex align-items">
		<a data-v-1c99e16c="" href="javascript:history.go(-1);" class="iconfont"></a> 
		<p data-v-1c99e16c="" class="head-title">联系客服</p>
	</div>		 
     <div data-v-c78f367e="" class="ptop88">
      <div data-v-c78f367e="" class="custom-list-b">
       <div data-v-c78f367e="" class="custom-list">
        <div data-v-c78f367e="" class="custom-type flex">
         <div data-v-c78f367e="" class="custom-type-right flex1">
          <h3 data-v-c78f367e="">在线客服</h3> 
          <p data-v-c78f367e="">留言后，客服会回复您</p>
         </div>
        </div> 
        <div data-v-c78f367e="" class="type-text">
         <h4 data-v-c78f367e="">添加客服QQ</h4> 
         <div data-v-c78f367e="" class="add-method flex align-items">
          <span data-v-c78f367e="">QQ：</span> 
          <span data-v-c78f367e="" id="txt1">123456</span> 
          <a data-v-c78f367e="" href="#" class="copy" onclick="copy('123456');">复制QQ号</a>
         </div>
        </div>
       </div> 
       <div data-v-c78f367e="" class="custom-list">
        <div data-v-c78f367e="" class="custom-type flex"> 
         <div data-v-c78f367e="" class="custom-type-right flex1">
          <h3 data-v-c78f367e="">在线客服</h3> 
          <p data-v-c78f367e="">欢迎咨询和建议</p>
         </div>
        </div> 
        <div data-v-c78f367e="" class="type-text">
         <h4 data-v-c78f367e="">添加微信客服</h4> 
         <div data-v-c78f367e="" class="add-method flex align-items">
          <span data-v-c78f367e="">微信号：<span id="txt2">123456</span></span> 
          <div id="biao1" style="display:none;"><?php echo ($service_wechat_name); ?></div>
          <a data-v-c78f367e="" href="javascript:;" class="copy" onclick="copy('123456');"> 复制微信号 </a>
         </div>
        </div>
       </div> 
      
      </div>
     </div>
    </div>
   </div> 
  </div>
  <script type="text/javascript" src="/Public/home/common/js/jquery-1.9.1.min.js" ></script>
  <script type="text/javascript" src="/Public/home/common/layer/layer.js" ></script>
  <script type="text/javascript" src="/Public/home/common/js/index.js"></script>
 <script type="text/javascript">
    <!-- $(document).ready(function () { -->
        <!-- $("#hide").click(function () { -->
            <!-- $("#p1").toggle(); //toggle() 方法切换元素的可见状态。 如果被选元素可见,则隐藏这些元素,如果被选元素隐藏,则显示这些元素。 -->
        <!-- }); -->

    <!-- }); -->

    <!-- function copyUrl1(){ -->
        <!-- var txt=$("#txt1").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
    <!-- function copyUrl2() -->
    <!-- { -->
        <!-- var txt=$("#txt2").text(); -->
        <!-- copy(txt); -->
    <!-- } -->

    <!-- function copy(message) { -->
        <!-- var input = document.createElement("input"); -->
        <!-- input.value = message; -->
        <!-- document.body.appendChild(input); -->
        <!-- input.select(); -->
        <!-- input.setSelectionRange(0, input.value.length), document.execCommand('Copy'); -->
        <!-- document.body.removeChild(input); -->
        <!-- msg_alert("复制成功哦"); -->
    <!-- } -->

	
	function copy(message){


    dom = document.createElement('textarea');
    // Prevent zooming on iOS
    dom.style.fontSize = '12pt';
    // Reset box model
    dom.style.border = '0';
    dom.style.padding = '0';
    dom.style.margin = '0';
    // Move element out of screen horizontally
    dom.style.position = 'absolute';
    dom.style['left'] = '-9999px';
    // Move element to the same position vertically
    var yPosition = window.pageYOffset || document.documentElement.scrollTop;
    dom.style.top = yPosition + 'px';

    dom.setAttribute('readonly', '');
    dom.value = message;

    document.body.appendChild(dom);

    dom.select();
    dom.setSelectionRange(0, dom.value.length);
    document.execCommand('copy');
    document.removeEventListener('click', copy);
    msg_alert("复制成功哦");
}
</script>
 </body>
</html>