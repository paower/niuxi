<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>实名认证</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">

<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
<script type="text/javascript" src="/Public/home/wap/js/jquery.form.js"></script>

<body class="bg96 ">
	
	<div class="header">
	    <div class="header_l">
	    <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
	    </div>
	    <div class="header_c"><h2>实名认证</h2></div>
	    <div class="header_r"></div>
	</div>
        <?php if($is_verify == 0): ?><span style="margin: 0 auto;display: block;width: 300px;"><img src="/Public/home/wap/images/examine-and.png"></span>
                
        <?php elseif($user['is_verify'] == 0): ?>
            
            <form class="big_width100" method="POST" action="" enctype="multipart/form-data">
                <div class="nic_xiu">
                    <!--  <?php if($is_exis != 1): ?>disabled<?php endif; ?>  -->
                    <input type="text" name="id_card" class="id_card nic_xiu" value="<?php echo ($user['id_card']); ?>" <?php echo ($is_exis == 1?'disabled':''); ?> placeholder="请输入身份证" autocomplete="off"/>
                </div>
                <div class="nic_xiu">
                    <!-- <?php if($is_exis != 1): ?>disabled<?php endif; ?> -->
                    <input type="text" name="truename" class="truename nic_xiu" <?php echo ($is_exis == 1?'disabled':''); ?>  value="<?php echo ($user['truename']); ?>" placeholder="请输入真实姓名" autocomplete="off"/>
                </div>
                <?php if($is_exis == 1): ?><span style="margin: 0 auto;display: block;width: 300px;"><img src="/Public/home/wap/images/examine-on.png"></span><?php endif; ?>
                <input type="hidden" name="token_code" value="<?php echo ($token_code); ?>">
                <?php if($is_exis == 0): ?><div class="nic_xiu">
                        <input type="text" name="phone" class="truename nic_xiu" <?php echo ($is_exis == 1?'disabled':''); ?>  value="<?php echo ($user['mobile']); ?>" placeholder="请输入手机号" autocomplete="off"/>
                    </div>
                   <!--  <div class="nic_xiu">
                        <input type="text" name="alipay_number" class="truename nic_xiu" <?php echo ($is_exis == 1?'disabled':''); ?>  value="<?php echo ($user['alipay_number']); ?>" placeholder="请输入支付宝帐号" autocomplete="off"/>
                    </div> -->
                    <div class="nic_xiu">
                        <span>身份证正面：</span><input type="file" name="pic1" class="pic" placeholder="身份证正面" autocomplete="off"/>
                    </div>
                    <div class="nic_xiu">
                        <span>身份证反面：</span>
                        <input type="file" name="pic2" class="pic" placeholder="身份证反面" autocomplete="off"/>
                    </div>
                    <!-- <div class="nic_xiu">
                        <span>支付宝收款码：</span>
                        <input type="file" name="pic3" class="pic" placeholder="支付宝收款码" autocomplete="off"/>
                    </div> -->
                    <div class="buttonGeoup">
                        <button type="button" style="border:none;" class="not_next ljzf_but">提交后台</button>
                    </div><?php endif; ?>
            </form>
        <?php elseif($user['is_verify'] == 1): ?>
            <span style="margin: 0 auto;display: block;width: 300px;"><img src="/Public/home/wap/images/examine-off.png"></span>
            <br/><a href="<?php echo U('User/user_verify',array('is_verify'=>0));?>" style="text-align: center; color:#fff;display:block;block;border: 1px solid #aa9ebd;
										padding: 10px;width: 45%; margin:0 auto;">重新提交实名</a>
        <?php elseif($user['is_verify'] == 2): ?>
            <span style="margin: 0 auto;display: block;width: 300px;"><img src="/Public/home/wap/images/examine-on.png"></span>
            <br/><a href="<?php echo U('User/user_verify',array('is_verify'=>0));?>" style="width: 45%; margin:0 auto;text-align: center;display:block;border: 1px solid #2524d2;
										padding: 10px;
										color: #2524d2;">查看信息</a><?php endif; ?>
		<div class="formnone" style="display:none"></div>
</body>
</html>
<script>
	$('.ljzf_but').click(function () {
        $('.big_width100').ajaxSubmit({
            url : '<?php echo U("user/real_name_form");?>',
            type:'POST',
            processData : false, 
            contentType : false, 
            dataType : 'JSON',
            success : function(res){
                if(res.code==1){
                    msg_alert(res.msg);
                    setTimeout(function(){window.location.href='/User/Personal.html'},2000);
                }else if(res.code ==0){
                    msg_alert(res.msg);
                }
            }
        });
    });



    function validateIdCard(idCard) {
        //15位和18位身份证号码的正则表达式
        var regIdCard = /^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;
        //如果通过该验证，说明身份证格式正确，但准确性还需计算
        if (regIdCard.test(idCard)) {
            if (idCard.length == 18) {
                var idCardWi = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); //将前17位加权因子保存在数组里
                var idCardY = new Array(1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
                var idCardWiSum = 0; //用来保存前17位各自乖以加权因子后的总和
                for (var i = 0; i < 17; i++) {
                    idCardWiSum += idCard.substring(i, i + 1) * idCardWi[i];
                }
                var idCardMod = idCardWiSum % 11;//计算出校验码所在数组的位置
                var idCardLast = idCard.substring(17);//得到最后一位身份证号码
                //如果等于2，则说明校验码是10，身份证号码最后一位应该是X
                if (idCardMod == 2) {
                    if (idCardLast == "X" || idCardLast == "x") {
                        return true;
                        //alert("恭喜通过验证啦！");
                    } else {
                        return false;
                        //alert("身份证号码错误！");
                    }
                } else {
                    //用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
                    if (idCardLast == idCardY[idCardMod]) {
                        //alert("恭喜通过验证啦！");
                        return true;
                    } else {
                        return false;
                        //alert("身份证号码错误！");
                    }
                }
            }
        } else {
            //alert("身份证格式不正确!");
            return false;
        }
    }

</script>