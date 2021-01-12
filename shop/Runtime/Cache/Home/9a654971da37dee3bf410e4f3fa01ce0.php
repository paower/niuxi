<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>转让</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
<body class="bg96 ">

<div class="header">
    <div class="header_l">
        <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
    </div>
    <div class="header_c"><h2>转让</h2></div>
    <div class="header_r"></div>
</div>

<div class="big_width100">

    <?php if(empty($morecars)): ?><!--未添加银行卡-->
		<div class="addCard SellAddCard">
			<a href="<?php echo U('Growth/Cardinfos');?>">+请添加收款账号</a>
		</div>
		<input type="hidden" name="" class="carnumber" value=""/>
	<?php else: ?>
		<input type="hidden" name="" class="carnumber" value="已添加"/><?php endif; ?>


    <div class="pad9"></div>
    <div class="buy_aminy br-b">
		<span class="selection">选择类型：</span>
        <ul class="clear_wl">
			<!-- <li class="buyChecked"> -->
				<!-- <input class="inputradion" type="radio" name="my" value="1" ><span>星座收益</span> -->
			<!-- </li> -->
			<li class="buyChecked on" >
				<input class="inputradion" type="radio" name="my" value="2"><span>推广收益</span>
			</li>
		</ul>
        <ul class="clear_wl">
			<input class="sellredwine" id="zichang" type="number" name="zichang" value="" placeholder="输入<?php echo ($tzhuanrang_min); ?>起">
		</ul>
    </div>
    <div class="buttonGeoup">
         <a href="###"   class="not_next ljzf_but" class="not_next" id="cuanjdd">提 交</a>
    </div>

</div>
<!--浮动层-->
<div class="ftc_wzsf">
    <div class="srzfmm_box">
        <div class="qsrzfmm_bt clear_wl">
            <img src="/Public/home/wap/images/xx_03.jpg" class="tx close fl">
            <span class="fl">请输入支付密码</span></div>
        <div class="zfmmxx_shop">

        </div>
        <ul class="mm_box">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="numb_box">
        <div class="xiaq_tb">
            <img src="/Public/home/wap/images/jftc_14.jpg" height="10"></div>
        <ul class="nub_ggg">
            <li><a href="javascript:void(0);" class="zf_num">1</a></li>
            <li><a href="javascript:void(0);" class="zj_x zf_num">2</a></li>
            <li><a href="javascript:void(0);" class="zf_num">3</a></li>
            <li><a href="javascript:void(0);" class="zf_num">4</a></li>
            <li><a href="javascript:void(0);" class="zj_x zf_num">5</a></li>
            <li><a href="javascript:void(0);" class="zf_num">6</a></li>
            <li><a href="javascript:void(0);" class="zf_num">7</a></li>
            <li><a href="javascript:void(0);" class="zj_x zf_num">8</a></li>
            <li><a href="javascript:void(0);" class="zf_num">9</a></li>
            <li><a href="javascript:void(0);" class="zf_empty"><?php echo (L("emptya")); ?></a></li>
            <li><a href="javascript:void(0);" class="zj_x zf_num">0</a></li>
            <li><a href="javascript:void(0);" class="zf_del"><?php echo (L("deleteo")); ?></a></li>
        </ul>
    </div>
    <div class="hbbj"></div>
</div>
<script type="text/javascript">
    $(".buyChecked").on("click", function () {
        $(this).addClass("on").siblings().removeClass("on");
        var ondata = $(this).find('.inputradion').val(); 
        var zhuanrang_min = <?php echo ($zhuanrang_min); ?>;
        var tzhuanrang_min = <?php echo ($tzhuanrang_min); ?>;
        if(ondata==1){
            $('#zichang').attr('placeholder','输入'+zhuanrang_min+'起');
        }else if(ondata==2){
            $('#zichang').attr('placeholder','输入'+tzhuanrang_min+'起');
        }
    })
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#hide").click(function () {
            $("#p1").toggle(); //toggle() 方法切换元素的可见状态。 如果被选元素可见,则隐藏这些元素,如果被选元素隐藏,则显示这些元素。
        });
    });
</script>

<script type="text/javascript">
    $('#cuanjdd').on('click', function () {
        $("#p1").hide(); //toggle() 方法切换元素的可见状态。 如果被选元素可见,则隐藏这些元素,如果被选元素隐藏,则显示这些元素。

        var mairjie = $('.on').find('input').val();
        if (mairjie == '') {
            msg_alert('请选择卖出类型~');
            return;
        }
        //是否存在银行卡
        var carnumber = $('.carnumber').val();
        if(carnumber == ''){
            msg_alert('请先添加收款方式~');
            return;
        }
		
		var zichang = $('#zichang').val();
        var sellnums = $('.on').find('input').val();
        if(sellnums==1){
            if(zichang <<?php echo ($zhuanrang_min); ?> || zichang % 1 != 0){
                msg_alert('转让金额不能低于'+<?php echo ($zhuanrang_min); ?>);
                return;
            }
            if(zichang><?php echo ($zhuanrang_max); ?>){
                msg_alert('转让金额不能高于'+<?php echo ($zhuanrang_max); ?>);
                return;
            }
        }else if(sellnums==2){
            if(zichang <<?php echo ($tzhuanrang_min); ?> || zichang % 1 != 0){
                msg_alert('转让金额不能低于'+<?php echo ($tzhuanrang_min); ?>);
                return;
            }
            if(zichang><?php echo ($tzhuanrang_max); ?>){
                msg_alert('转让金额不能高于'+<?php echo ($tzhuanrang_max); ?>);
                return;
            }
        }
		
		
        $(".ftc_wzsf").show();
    });

    $(function () {
        //关闭浮动
        $(".close").click(function () {
            $(".ftc_wzsf").hide();
            $(".mm_box li").removeClass("mmdd");
            $(".mm_box li").attr("data", "");
            i = 0;
        });
        //数字显示隐藏
        $(".xiaq_tb").click(function () {
            $(".numb_box").slideUp(50000);
        });
        $(".mm_box").click(function () {
            $(".numb_box").slideDown(50000);
        });
        //----
        var i = 0;
        $(".nub_ggg li .zf_num").click(function () { 

            if (i < 6) {
                $(".mm_box li").eq(i).addClass("mmdd");
                $(".mm_box li").eq(i).attr("data", $(this).text());
                i++
                if (i == 6) {
                    setTimeout(function () {
                        var pwd = "";
                        $(".mm_box li").each(function(){
                            pwd += $(this).attr("data");
                        });
                        //AJAX提交数据
                        var sellnums = $('.on').find('input').val();
                        var cardid = $('.carnumber').val();//银行卡id
                        var zichang = $('#zichang').val();
                        var exg = /^[1-9]\d*|0$/;
                        if (!exg.test(sellnums)) {
                            msg_alert('请选择买入金额~');
                            return;
                        }

                        if (cardid == '') {
                            msg_alert('请添加收款方式');
                            return;
                        }
                        $.ajax({
                            url:'/Trading/SellCentr',
                            type:'post',
                            data:{'sellnums':sellnums,'pwd':pwd,'zichang':zichang},
                            datatype:'json',
                            success:function (mes) {
                                if(mes.status == 1){
                                    msg_alert(mes.message);
                                    $(".ftc_wzsf").hide();
                                    $(".mm_box li").removeClass("mmdd");
                                    $(".mm_box li").attr("data","");
                                    i = 0;
                                }else{
                                    msg_alert(mes.message);
                                    $(".mm_box li").removeClass("mmdd");
                                    $(".mm_box li").attr("data","");
                                    i = 0;
                                }
                            }
                        })
                    }, 100);
                };
            }
        });

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