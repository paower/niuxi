<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>订单详情</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js" ></script>
<script type="text/javascript" src="/Public/home/wap/js/jquery.form.js"></script>
<body class="bg96 ">

<div class="header">
    <div class="header_l">
        <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
    </div>
    <div class="header_c"><h2>订单</h2></div>
</div>
<div class="haveCard por">
	<div class="acco_con_up">
		<div class="paymentinfo">
			<p class="payinfohead"><?php echo ($res[title]); ?></b><span class="ordernumber">编号:<?php echo ($res[record_no]); ?></span></p>
            <p>价值：<?php echo ($res[record_price]); ?>
                    <span class="buyer" id="expiration_time">0时00分00秒</span>
            </p>
            <p>智能合约收益：<?php echo ($res[profit_day]); ?>天/<?php echo ($res[profit_value]); ?>%</p>
			<p>
				<span class="buyer">
					<?php if($res['record_status'] == 6): ?>确认打款
					<?php elseif($orders['status'] == 1 AND $orders['sell_id'] == $uid): ?>
						等待确认打款
					<?php elseif($res['record_status'] == 7): ?>
						等待确认收款
					<?php elseif($orders['status'] == 2 AND $orders['sell_id'] == $uid): ?>
						确认收款<?php endif; ?>
				</span>
			</p>
			<p class="order_desc">本订单有效时间为2小时，转让方将在2小时内完成，超时收藏方自动收藏成功！</p>
		</div>
		<div class="paymentinfo buserinfo">
			<p class="payinfohead">收藏方信息</p>
			<div class="information">
				<span class="infoicon"><img src="/Public/home/wap/images/sett1-icon.png" alt=""/></span>
				<div class="infocenter">姓名：<span id="txt1"><?php echo ($res['userinfo']['username']); ?></span></div>
				<div class="inforight"><span class="buyer" onclick="copy('<?php echo ($res['userinfo']['username']); ?>')">复制</span></div>
			</div>
			<div class="information">
				<span class="infoicon"><img src="/Public/home/wap/images/sett15-icon.png" alt=""/></span>
				<div class="infocenter">手机号：<span id="txt2"><?php echo ($res['userinfo']['mobile']); ?></span></div>
				<!-- <div class="inforight"><a href="tel:<?php echo ($get_user['mobile']); ?>"><img src="/Public/home/wap/images/phone.png" alt=""/></a></div> -->
			</div>
		</div>
		<div class="paymentinfo buserinfo">
			<p class="payinfohead">转让方信息</p>
			<a class="payinfohead" onClick="open01()">查看银行卡</a>
			<a class="payinfohead" onClick="open02()">查看支付宝</a>
			<a class="payinfohead" onClick="open03()">查看微信</a>
			<div class="information">
				<span class="infoicon"><img src="/Public/home/wap/images/sett1-icon.png" alt=""/></span>
				<div class="infocenter">姓名：<span id="txt1"><?php echo ($res['userinfo_out']['username']); ?></span></div>
				<div class="inforight"><span class="buyer" onclick="copy('<?php echo ($res['userinfo_out']['username']); ?>')">复制</span></div>
			</div>
			<div class="information">
				<span class="infoicon"><img src="/Public/home/wap/images/sett15-icon.png" alt=""/></span>
				<div class="infocenter">手机号：<span id="txt2"><?php echo ($res['userinfo_out']['mobile']); ?></span></div>
				<div class="inforight"><span class="buyer" onclick="copy('<?php echo ($res['userinfo_out']['mobile']); ?>')">复制</span></div>
			</div>
			
			<div id="bank1" style="display:none;">
               
    				<div class="information">
    					<span class="infoicon"><img src="/Public/home/wap/images/sett10-icon.png" alt=""/></span>
    					<div class="infocenter">开户名：<span id="txt3"><?php echo ($res[userbank][alipay_name]); ?></span></div>
    					<div class="inforight"><span class="buyer"  onclick="copy('<?php echo ($res[userbank][alipay_name]); ?>')">复制</span></div>
    				</div>
    				<div class="information">
    					<span class="infoicon"><img src="/Public/home/wap/images/sett10-icon.png" alt=""/></span>
    					<div class="infocenter">开户账号：<span id="txt4"><?php echo ($res[userbank][alipay_number]); ?></span></div>
    					<div class="inforight"><span class="buyer"  onclick="copy('<?php echo ($res[userbank][alipay_number]); ?>')">复制</span></div>
    				</div>
    				<div class="information">
    					<span class="infoicon"><img src="/Public/home/wap/images/sett10-icon.png" alt=""/></span>
    					<div class="infocenter">开户支行：<span id="txt5"><?php echo ($res[userbank][bank_name2]); ?></span></div>
    					<div class="inforight"><span class="buyer"  onclick="copy('<?php echo ($res[userbank][bank_name2]); ?>')">复制</span></div>
    				</div>	
               
			</div>
			<div id="alipay2" style="display:none;">
				<div class="information">	
					<span class="infoicon"><img src="/Public/home/wap/images/zfb.png" alt=""/></span>
					<div class="infocenter">支付宝：<span id="txt6"><?php echo ($res[useralipay][alipay_name]); ?></span></div>
					<div class="inforight"><span class="buyer"  onclick="copy('<?php echo ($res[useralipay][alipay_name]); ?>')">复制</span></div>
					<p class="infocode">收款二维码：<span><img src="<?php echo ($res[useralipay]['img']); ?>"/></span></p>
				</div>
			</div>
			<div id="wechart3" style="display:none;">
				<div class="information">	
					<span class="infoicon"><img src="/Public/home/wap/images/wx.png" alt=""/></span>
					<div class="infocenter">微信：<span id="txt7"><?php echo ($res[userwx][alipay_name]); ?></span></div>
					<div class="inforight"><span class="buyer"  onclick="copy('<?php echo ($res[userwx][alipay_name]); ?>')">复制</span></div>
					<p>收款二维码：<span id="txt3"><img style="width: 250px;height:auto;" src="<?php echo ($res[userwx]['img']); ?>"/></span></p>
				</div>
			</div>
		</div>	
    </div>
    <?php if($res['record_status'] == 6 AND $show == 0): ?><div class="acco_con_upa">
            <h3>上传打款截图</h3>
            <div class="shangcjt">
                <form id='myupload' action="<?php echo U('Turntable/Conpay');?>" method='post'
                    enctype='multipart/form-data' name="form">
                    <div class="containera"></div>
                    <input type="text" value="<?php echo ($res['record_id']); ?>" name="trid">
                    <input type="file" id="photo" name="uploadfile" class="shangcanj">
                </form>
            </div>                    
        </div>
    <?php elseif($res['record_status'] == 7 AND $show == 1): ?>
   
        <div class="acco_con_upa">
            <h3>打款截图</h3>
            <div class="shangcjt">
                <img src="<?php echo ($res['trans_img']); ?>" width="200px" height="auto">
            </div>
        </div><?php endif; ?>
 
    <input name="id" type="hidden" value="<?php echo ($orders['id']); ?>"/>
    <input name="recharge_token" type="hidden" value="<?php echo ($recharge_token); ?>"/>
    
</div>
<input type="hidden" value="" name="pwd">
<input type="hidden" value="" name="sellnums">
<input type="hidden" value="<?php echo ($morecars['type']); ?>" name="type">

<div class="buttonGeoup" style="margin-top:50px;">


    <?php if($res['record_status'] == 6 AND $show == 0): ?><a href="javascript:void(0);" class="Issuing sumbit" id="cuanjdd">确认打款</a><?php endif; ?>
    <?php if($res['record_status'] == 7 AND $show == 1): ?><a href="javascript:void(0);" class="Issuing " onClick="querenshou(this,'<?php echo ($res[record_id]); ?>')">确认收款</a>
		<a href="javascript:void(0);" class="trial confirm_represen" onClick="shensu('<?php echo ($res[record_id]); ?>')">申诉</a><?php endif; ?>
</div>
<script type="text/javascript">

    $(".buyChecked").on("click", function () {
        $(this).addClass("on").siblings().removeClass("on");
    })

</script>
<script type="text/javascript">
function open01(){
 	$("#bank1").toggle();
}
function open02(){
 	$("#alipay2").toggle();
}
function open03(){
 	$("#wechart3").toggle();
}
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#hide").click(function () {
            $("#p1").toggle(); //toggle() 方法切换元素的可见状态。 如果被选元素可见,则隐藏这些元素,如果被选元素隐藏,则显示这些元素。
        });

    });

    <!-- function copyUrl1(){ -->
        <!-- var txt=$("#txt1").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
    <!-- function copyUrl2() -->
    <!-- { -->
        <!-- var txt=$("#txt2").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
    <!-- function copyUrl3() -->
    <!-- { -->
        <!-- var txt=$("#txt3").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
	<!-- function copyUrl4() -->
    <!-- { -->
        <!-- var txt=$("#txt4").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
	<!-- function copyUrl5() -->
    <!-- { -->
        <!-- var txt=$("#txt5").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
	<!-- function copyUrl6() -->
    <!-- { -->
        <!-- var txt=$("#txt6").text(); -->
        <!-- copy(txt); -->
    <!-- } -->
	<!-- function copyUrl7() -->
    <!-- { -->
        <!-- var txt=$("#txt7").text(); -->
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


<script type="text/javascript">
    window.onload=clock;
    function clock(){
        var today=new Date(),//当前时间
            h=today.getHours(),
            m=today.getMinutes(),
            s=today.getSeconds();
        var stopTime=new Date('<?php echo (date("Y-m-d H:i:s",$res[dakuantime])); ?>'),//结束时间
            stopH=stopTime.getHours(),
            stopM=stopTime.getMinutes(),
            stopS=stopTime.getSeconds();
        var shenyu=stopTime.getTime()-today.getTime(),//倒计时毫秒数
            shengyuD=parseInt(shenyu/(60*60*24*1000)),//转换为天
            D=parseInt(shenyu)-parseInt(shengyuD*60*60*24*1000),//除去天的毫秒数
            shengyuH=parseInt(D/(60*60*1000)),//除去天的毫秒数转换成小时
            H=D-shengyuH*60*60*1000,//除去天、小时的毫秒数
            shengyuM=parseInt(H/(60*1000)),//除去天的毫秒数转换成分钟
            M=H-shengyuM*60*1000;//除去天、小时、分的毫秒数
            S=parseInt((shenyu-shengyuD*60*60*24*1000-shengyuH*60*60*1000-shengyuM*60*1000)/1000)//除去天、小时、分的毫秒数转化为秒
            if(S>=0){
                document.getElementById("expiration_time").innerHTML=(shengyuH+"时"+shengyuM+"分"+S+"秒");
            }else{
                document.getElementById("expiration_time").innerHTML=(00+"时"+00+"分"+00+"秒");
            }
            // setTimeout("clock()",500);
            setTimeout(clock,500);
    }



    $('#cuanjdd').on('click', function () {
          var fm = document.getElementsByTagName('form')[0];
          var fl = new FormData(fm);
          var url = "<?php echo U('Turntable/Conpay');?>";
          $.ajax({
            url:url,
            type:"POST",
            data:fl,
            dataType:"json",
            contentType:false,
            processData: false, 
            success: function (data) {
                if (data.status == 1) {
                    msg_alert(data.message);
                    window.location.href = data.url;
                } else {
                    msg_alert(data.message);
                }
             },
            error: function (xhr) { //上传失败
                alert("上传失败");
            }
         })

    });

    $('.shangcanj').change(function (e) {
        var old_this = $(this);
        var files = this.files;
        var img = new Image();
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);
        reader.onload = function (e) {
            var dx = (e.total / 1024) / 1024;
            if (dx >= 2) {
                msg_alert("文件不能大于2M");
                return;
            }
            img.src = this.result;
            img.style.width = "100%";
            img.style.height = "90%";
            old_this.parents('#myupload').find('.containera').html(img);
        }
    })

    // 确认收款
    function querenshou(obj,id){
     $.post("<?php echo U('Turntable/confirm_receipt');?>",{'id':id},function(data){
          if(data.status==1){
              msg_alert(data.message);
              setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
                window.location.href = data.url;
              },2000);
          }else{
              msg_alert(data.message);
          }
      }); 
  }

    // 确认收款申述
    // $('.confirm_represen').click(function(){
    //     var id = $("input[name='id']").val();
    //     $.post("/Turntable/confirm_represen",{'id':id},function(res){
    //         if(res.status == 1){
    //             msg_alert(res.message,res.url);
    //         }else{
    //             msg_alert(res.message);
    //         }
    //     },'json');
    // })
    function shensu(id){
        $.post("/Turntable/confirm_represen",{'id':id},function(res){
            if(res.status == 1){
                msg_alert(res.message,res.url);
            }else{
                msg_alert(res.message);
            }
        },'json');
    }
    //确认打款
    // $('.sumbit').click(function () {
    //     var old = $(this);
    //     $("#myupload").ajaxSubmit({
    //         dataType: 'json', //数据格式为json
    //         success: function (data) {
    //             if (data.status == 1) {
    //                 msg_alert(data.message,data.url);
    //             } else {
    //                 msg_alert(data.message);
    //             }
    //         }
    //     });
    // })

    $(function () {
        //关闭浮动
        // $(".close").click(function () {
        //     $(".ftc_wzsf").hide();
        //     $(".mm_box li").removeClass("mmdd");
        //     $(".mm_box li").attr("data", "");
        //     i = 0;
        // });
        // //数字显示隐藏
        // $(".xiaq_tb").click(function () {
        //     $(".numb_box").slideUp(0);
        // });
        // $(".mm_box").click(function () {
        //     $(".numb_box").slideDown(0);
        // });
        // //----
        // var i = 0;
        // $(".nub_ggg li .zf_num").click(function () {
        //     if (i < 6) {
        //         $(".mm_box li").eq(i).addClass("mmdd");
        //         $(".mm_box li").eq(i).attr("data", $(this).text());
        //         i++
        //         if (i == 6) {
        //             setTimeout(function () {
        //                 var pwd = "";
        //                 $(".mm_box li").each(function(){
        //                     pwd += $(this).attr("data");
        //                 });
        //                 $("input[name='pwd']").val(pwd);
        //                 //AJAX提交数据
        //                 var sellnums = $.trim($('.on').text());//账号  //.trim() 去空格判断
        //                 var cardid = $('.carnumber').val();//银行卡id
        //                 var exg = /^[1-9]\d*|0$/;
        //                 if (!exg.test(sellnums)) {
        //                     msg_alert('请选择买入金额~');
        //                     return;
        //                 }
        //                 var uploadfile = $("input[name='sellnums']").val(sellnums);
        //                 $("#myupload").ajaxSubmit({
        //                     dataType: 'json', //数据格式为json
        //                     success:function (mes) {
        //                         if(mes.status == 1){
        //                             msg_alert(mes.message);
        //                             $(".ftc_wzsf").hide();
        //                             $(".mm_box li").removeClass("mmdd");
        //                             $(".mm_box li").attr("data","");
        //                             i = 0;
        //                         }else{
        //                             msg_alert(mes.message);
        //                             $(".mm_box li").removeClass("mmdd");
        //                             $(".mm_box li").attr("data","");
        //                             i = 0;
        //                         }
        //                     }
        //                 });
        //                 .ajax({
        //                     url:'/Growth/Recharge',
        //                     type:'post',
        //                     data:{'pwd':pwd,'cardid':cardid,'type':type,'uploadfile':uploadfile},
        //                     datatype:'json',
        //                     success:function (mes) {
        //                         if(mes.status == 1){
        //                             msg_alert(mes.message);
        //                             $(".ftc_wzsf").hide();
        //                             $(".mm_box li").removeClass("mmdd");
        //                             $(".mm_box li").attr("data","");
        //                             i = 0;
        //                         }else{
        //                             msg_alert(mes.message);
        //                             $(".mm_box li").removeClass("mmdd");
        //                             $(".mm_box li").attr("data","");
        //                             i = 0;
        //                         }
        //                     }
        //                 })
        //             }, 100);
        //         };
        //     }
        // });

        $(".nub_ggg li .zf_del").click(function () {
            if (i > 0) {
                i--
                $(".mm_box li").eq(i).removeClass("mmdd");
                $(".mm_box li").eq(i).attr("data", "");
            }
        });

        $(".nub_ggg li .zf_empty").click(function () {
            $(".mm_box li").removeClass("mmdd");
            $(".mm_box li").attr("data", "");
            i = 0;
        });

    });
</script>

</body>

</html>