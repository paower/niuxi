<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo ($product['name']); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />

    <!-- Link Swiper's CSS -->

    <link rel="stylesheet" type="text/css" href="/Public/Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/Public/css/foot.css">

    <link rel="stylesheet" href="/Public/Public/css/head.css">
    <link rel="stylesheet" href="/Public/Public/icon/iconfont.css">
    <script type="text/javascript" src="/Public/Public/js/jquery-1.7.1.min.js"></script>

    <script type="text/javascript" src="/Public/Public/js/jquery.touchSlider.js"></script>

    <!--弹框JS-->
    <script type="text/javascript" src="/Public/Public/verify/layer.js"></script>
    <!-- Demo styles -->
    <script type="text/javascript">
        $(document).ready(function(){

            $(".main_visual").hover(function(){
                $("#btn_prev,#btn_next").fadeIn()
            },function(){
                $("#btn_prev,#btn_next").fadeOut()
            });

            $dragBln = false;

            $(".main_image").touchSlider({
                flexible : true,
                speed : 200,
                btn_prev : $("#btn_prev"),
                btn_next : $("#btn_next"),
                paging : $(".flicking_con a"),
                counter : function (e){
                    $(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
                }
            });

            $(".main_image").bind("mousedown", function() {
                $dragBln = false;
            });
          

            $(".main_image").bind("dragstart", function() {
                $dragBln = true;
            });

            $(".main_image a").click(function(){
                if($dragBln) {
                    return false;
                }
            });

            timer = setInterval(function(){
                $("#btn_next").click();
            }, 5000);

            $(".main_visual").hover(function(){
                clearInterval(timer);
            },function(){
                timer = setInterval(function(){
                    $("#btn_next").click();
                },5000);
            });

            $(".main_image").bind("touchstart",function(){
                clearInterval(timer);
            }).bind("touchend", function(){
                timer = setInterval(function(){
                    $("#btn_next").click();
                }, 5000);
            });


            $("#color_ul li").click(function(){
                $("#color_ul").attr("data-str",$(this).html());

                $("#color_ul li").each(function(i,v){
                    $(this).removeClass('selColor');
                });

                $(this).addClass('selColor');
            });

            $("#size_ul li").click(function(){
                $("#size_ul").attr("data-str",$(this).html());
                $("#size_ul li").each(function(i,v){
                    $(this).removeClass('selSize');
                });

                $(this).addClass('selSize');
            });

            $("#type_ul li").click(function(){
                $("#type_ul").attr("data-str",$(this).html());
                $("#type_ul li").each(function(i,v){
                    $(this).removeClass('selSize');
                });

                $(this).addClass('selSize');
            });

            $(".jia").click(function(){
                var n = $("#bnum").val();
                n++;
                $("#bnum").val(n);
            });

            $(".jian").click(function(){
                var n = $("#bnum").val();
                if(n<=1) return;
                n--;
                $("#bnum").val(n);

            });

            /*加入购物车*/
            $("#join_car").click(function(){
                var nv = $("#bnum").val();
                var sv = $("#size_ul").attr("data-str");
                var cv = $("#color_ul").attr("data-str");
                var pv = $("body").attr("data-id");



                if(nv==""||nv==null){
                    layer.msg('购买数量不正确', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }

                var chima = $('.chima').val();
                var yanse = $('.yanse').val();
                var jifentype = $('.jifentype').val();

                if(chima != undefined){
                    if(chima != ''){
                        if(sv==""||sv==null){
                            layer.msg('请选择尺寸', {shift: -1, time: 1200}, function () {
                            });
                            return;
                        }
                    }
                }
                if(yanse != undefined){
                    if(yanse != ''){
                        if(cv==""||cv==null){
                            layer.msg('请选择颜色', {shift: -1, time: 1200}, function () {
                            });
                            return;
                        }
                    }
                }

                if(pv==""||pv==null){
                    layer.msg('缺少购买参数', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }
                $.post("/Shop/Home/addCar",{p:pv,n:nv,s:sv,c:cv},function(data){
                    if(data.status == 0){
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                            $("#params_show").hide();
                            $("#details_show").show();
                        });
                    }else if(data.status == 1){
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                            $("#params_show").hide();
                            $("#details_show").show();
                        });
                    }else{
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                            $("#params_show").hide();
                            $("#details_show").show();
                            window.location.href='/shop/personal/login';
                        });
                    }
                },"json");

            });

            /*立即购买*/
            $("#buy_now").click(function(){
                var nv = $("#bnum").val();
                var sv = $("#size_ul").attr("data-str");
                var cv = $("#color_ul").attr("data-str");
//                /*积分分类*/
//                var jtype = $("#type_ul").attr("data-str");

                var pv = $("body").attr("data-id");


                if(nv==""||nv==null){
                    layer.msg('购买数量不正确', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }

                var chima = $('.chima').val();
                var yanse = $('.yanse').val();
                var jifentype = $('.jifentype').val();

                if(chima != undefined){
                    if(chima != ''){
                        if(sv==""||sv==null){
                            layer.msg('请选择尺寸', {shift: -1, time: 1200}, function () {
                            });
                            return;
                        }
                    }
                }
                if(yanse != undefined){
                    if(yanse != ''){
                        if(cv==""||cv==null){
                            layer.msg('请选择颜色', {shift: -1, time: 1200}, function () {
                            });
                            return;
                        }
                    }
                }

                if(pv==""||pv==null){
                    layer.msg('缺少购买参数', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }

                $.post("/Shop/Car/buynow",{p:pv,n:nv,s:sv,c:cv},function(data){
                    if(data.status == 1){
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                            $("#params_show").hide();
                            $("#details_show").show();
                            location.href = "<?php echo U('Shop/Home/order');?>";
                        });
                    }else{
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                        });
                    }

                },"json");
            });

            $('.ffr').click(function () {
                var nv = $("#bnum").val();
                var sv = $("#size_ul").attr("data-str");
                var cv = $("#color_ul").attr("data-str");
                var pv = $("body").attr("data-id");
                /*积分分类*/
                var jtype = $("#type_ul").attr("data-str");

                if(nv==""||nv==null){
                    layer.msg('购买数量不正确', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }
                if(sv==""||sv==null){
                    layer.msg('请选择尺寸', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }
                if(cv==""||cv==null){
                    layer.msg('请选择颜色', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }
                if(pv==""||pv==null){
                    layer.msg('缺少购买参数', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }
                if(jtype==""||jtype==null){
                    layer.msg('缺少积分类型', {shift: -1, time: 1200}, function () {
                    });
                    return;
                }

                $.post("/Shop/Home/addCar",{p:pv,n:nv,s:sv,c:cv,'jtype':jtype},function(data){
                    layer.msg(data.info, {shift: -1, time: 1200}, function () {
                    });
                },"json");

            });

            /*收藏*/
            $("#like").click(function(){
                var i =  $("body").attr("data-id");
                $.post("/Shop/Home/like",{pid:i},function(data){
                    if(data.status=="1"){
                        $("#like i").html("&#xe601;");
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                        });
                    }else if(data.status=="2"){
                        $("#like i").html("&#xe61c;");
                    }else{
                        layer.msg(data.info, {shift: -1, time: 1200}, function () {
                        });
                    }
                },"json");
            });


        });


        function showParams(){
            $("#params_show").show();
            $("#details_show").hide();
        }

        function hideParams(){
            $("#params_show").hide();
            $("#details_show").show();
        }

        function showContent(){
            var ishide = $("#content_show").css('display');
            if(ishide == 'none'){
                $("#content_show").show();
                $("#details_show").hide()
            }else{
                $("#content_show").hide();
                $("#details_show").show();
            }
        }

        function hideContent(){
            var ishide = $("#content_show").css('display');
            if(ishide == 'block'){
                $("#content_show").hide();
                $("#details_show").show();
            }



        }

    </script>
</head>
<style>
    .selSize{
        border-color: #ff5000;
        color: #ff5000;
    }

    .selColor{
        border-color: #ff5000;
        color: #ff5000;
    }
	.icon_sortcar img{display:block; width:7.2vmin; vertical-align:middle; text-align:center; margin:0 auto;}
	.product_con{
		padding: 4vmin;
    clear: both;
    font-size: 3.6vmin;
    color: #444;
    line-height: 5vmin;
    margin-bottom: 6vmin;
    width: 90%;
    height: 100%;
    /* overflow: auto; */
    display: inline-block;
    word-wrap: break-word;
	line-height:7vmin;
		}
		.product_con pre{ word-wrap: break-word;
	line-height:7vmin;font-size: 3.6vmin;
    color: #444;
    line-height: 5vmin;}
	.product_con pre br{display:block; clear:both;}
	.product_con img{display:block; max-width:90vmin; max-height:90vmin; clear:both; margin:0 auto;}
</style>
<body style="background: #f6f6f6 ; background-color:#fff;" data-id="<?php echo ($product['id']); ?>" >

<div class="head_bb">
    <p><a href="javascript:window.history.go(-1);"><img src="/Public/Public/images/b1.png" alt=""></a></p>
    <!--<p style="float: right;margin-right: 3%;"><a href="<?php echo U('Car/shopping');?>"><img src="/Public/Public/images/b2.png" alt=""></a></p>-->
</div>

<!-- banner  s-->
<div class="main_visual" style="height: 74vmin;">
    <div class="flicking_con" style="left: 48%;top:90%;">
        <?php $n = 0;?>
        <?php if($product['pic1'] != null): ?><a href="javascript:void(0)"><?php echo ($n++); ?></a><?php endif; ?>
        <?php if($product['pic2'] != null): ?><a href="javascript:void(0)"><?php echo ($n++); ?></a><?php endif; ?>
        <?php if($product['pic3'] != null): ?><a href="javascript:void(0)"><?php echo ($n++); ?></a><?php endif; ?>
        <?php if($product['pic4'] != null): ?><a href="javascript:void(0)"><?php echo ($n++); ?></a><?php endif; ?>
        <?php if($product['pic5'] != null): ?><a href="javascript:void(0)"><?php echo ($n++); ?></a><?php endif; ?>
    </div>
    <div class="main_image" style="height: 74vmin;">
        <ul>
            <?php if($product['pic1'] != null): ?><li><span class="img_3"><img src="<?php echo ($product['pic1']); ?>" alt=""></span></li><?php endif; ?>
            <?php if($product['pic2'] != null): ?><li><span class="img_4"><img src="<?php echo ($product['pic2']); ?>" alt=""></span></li><?php endif; ?>
            <?php if($product['pic3'] != null): ?><li><span class="img_1"><img src="<?php echo ($product['pic3']); ?>" alt=""></span></li><?php endif; ?>
            <?php if($product['pic4'] != null): ?><li><span class="img_4"><img src="<?php echo ($product['pic4']); ?>" alt=""></span></li><?php endif; ?>
            <?php if($product['pic5'] != null): ?><li><span class="img_1"><img src="<?php echo ($product['pic5']); ?>" alt=""></span></li><?php endif; ?>
        </ul>
    </div>
</div>
<!-- banner  e-->
<!-- 详情 -->
<div id="details_show" style="display: block;">
    <div class="detanr">
        <div class="detanr_bt">
            <h3><?php echo ($product['name']); ?></h3>
            <!--<span onclick ="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><i class="iconfont">&#xe64f;</i><p>分享</p></span>-->
        </div>
        <p class="jg">¥ <?php echo ($product['price']); ?><!--<?php echo ($product['price']); ?>  // 赠送 <?php echo ($product['jifen_nums']); ?> 积分 --></p>
       
<?php
$dzid['userid']=$product['shangjia']; $dizhi=M('gerenshangpu')->where($dzid)->find(); ?>

        <p>快递：到付<span><?php echo ($dizhi['shop_address']); ?></span></p>
      <!--   <p><?php echo (tercept($product['s_desc'])); ?></p> -->
       <p><span>库存：<?php echo ($product['stock']); ?></span></p>
    </div>
     <!--分隔线-->
	<div class="d_line_6"></div>
    <div class="detail_dpinfo dd_height2" style="display:none;">
    	<?php
 $id['userid']=$product['shangjia']; $dianpu=M('gerenshangpu')->where($id)->find(); ?>


        	<img src="<?php echo ($dianpu["shop_logo"]); ?>" class="d_dlogo">
            <h2><?php echo ($dianpu["shop_name"]); ?></h2>
            
            <div class="d_dbtn2">
                <a href="<?php echo U('dianpu/index',array('did'=>$dianpu['userid']));?>">进店逛逛</a>
            </div>
        	
    </div>
    
    
    
	  <!-- <div class="d_line_4"></div>
    
 <div class="meter" style="margin-top:0vmin;">
        <ul>
            <li><a onclick="showParams();">选择数量 <i class="iconfont">&#xe6fb;</i></a></li>
            <li><a onclick="showContent();">产品详情 <i class="iconfont">&#xe6fb;</i></a></li>
            <!--<li><a href="<?php echo U('Home/evaluation',array('proid'=>$product['id']));?>">商品评价 <i class="iconfont">&#xe6fb;</i></a></li>-->
       <!-- </ul>
    </div>-->
    
    <!--商品详情-->
    <div class="spcs_nr">
        <h3>产品详情</h3>
        <div class="product_con">
 <?php if($product['shangjia'] == 0): echo (htmlspecialchars_decode($product['content'])); ?>  
 <?php else: ?>     
<?php if(($product['s_desc']) == ""): echo (htmlspecialchars_decode($product['content'])); ?>
<?php else: ?>
<?php echo (htmlspecialchars_decode($product['s_desc'])); endif; endif; ?>
<!--
        <?php if($product['shangjia'] == 0): echo (htmlspecialchars_decode($product['content'])); ?>
        <?php else: echo (htmlspecialchars_decode($product['s_desc'])); endif; ?>
 


  -->
        </div>
       
    </div>
    
    
    <div class="d_line_14"></div>

    <div class="meter_foor">
        <div class="meter_foor_l">
            <ul>
               <li><a href="<?php echo U('/Shop/Home/index');?>" > <i class="iconfont">&#xe61c;</i><p>首页</p></a></li>
                <li>
                <?php if($product['shangjia'] == 0): ?><a href="<?php echo U('/Shop/Home/jieshao',array('ids'=>3));?>" class="fl">
                <?php else: ?>
                <a href="<?php echo U('/Shop/Home/lianxi',array('id'=>$product['shangjia']));?>" class="fl"><?php endif; ?>
               
                <i class="iconfont">&#xe644;</i><p>联系商家</p></a></li>
               <!--  <li><a id="like" class="fr"><i class="iconfont"><?php if($isCollect > 0): ?>&#xe601;<?php else: ?>&#xe61c;<?php endif; ?></i><p>收藏</p></a></li> -->
                <li><a href="<?php echo U('Car/shopping');?>"><i class="icon_sortcar"><img src="/Public/Public/images/icon_sortcar.png" style="width:7.2vmin; height:7.2vmin"></i>
                <p>购物车</p></a></li>
            </ul>
        </div>
        <div class="meter_foor_r">
            <ul>
                <li><a  class="ffl" onclick="showParams();">立即购买</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- 参数 -->
<div id="params_show" style="display: none; border-top:2px solid #e8e8e8;">
    <div class="visual_bt"  >
        <div class="visual_btl"><img src="<?php echo ($product['pic']); ?>" alt=""></div>
        <div class="visual_btr">
            <p class="btrjg" onclick="hideParams()">¥ <?php echo ($product['price']); ?> <span><i class="iconfont">&#xe638;</i></span></p>
            <p>库存<?php echo ($product['stock']); ?>件 </p>
            <p>请选择</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <?php if(($product['color_cate']) != ""): ?><div class="demo-box">
            <h3>颜色分类</h3>
            <input type="hidden" value="<?php echo ($colorList[0]); ?>" class="yanse">
            <table class="demo-table">
                <tr>
                    <td>
                        <ul class="ui-choose" id="color_ul" data-str="">
                            <?php if(is_array($colorList)): foreach($colorList as $key=>$color): ?><li><?php echo ($color); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div><?php endif; ?>

    <?php if(($product['csize']) != ""): ?><div class="demo-box">
            <h3>尺码</h3>
            <input type="hidden" value="<?php echo ($sizeList[0]); ?>" class="chima">
            <table class="demo-table">
                <tr>
                    <td>
                        <ul class="ui-choose" id="size_ul" data-str="">
                            <!-- class="selected " -->
                            <?php if(is_array($sizeList)): foreach($sizeList as $key=>$size): ?><li><?php echo ($size); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div><?php endif; ?>

    <div class="demo-box">
        <h3>购买数量</h3>
        <div id="content">
            <div class="aac">
                <span class="jian" style="cursor: pointer;">-</span>
                <input readonly class="num" name="num" id="bnum" type="text" value="1">
                <span class="jia" style="cursor: pointer;">+</span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div style="height: 15vmin;"></div>
    <div class="size_foot">
        <a id="join_car" style="background: linear-gradient(to left, #ff9902, #ffc500);">加入购物车</a>
        <a id="buy_now" style="float: right;">立即购买</a>
    </div>
</div>
<style>
.spcs_nr img{width:100%; height:auto} 
table{max-width:100%;border: none;}
.spcs_nr h3{display:inline-block;  height:10vmin; line-height:10vmin; text-align:left; color:#333; padding:4vmin; font-size:3.8vmin; clear:both;}
.product_con{padding:4vmin; clear:both; font-size:3.4vmin; color:#444; line-height:5vmin; margin-bottom:6vmin;}
</style>
<div id="content_show" style="display: none;">
    <div class="spcs_nr">
        <h3 onclick="showContent();">产品详情</h3>
        <div><?php echo (htmlspecialchars_decode($product['s_desc'])); ?></div>
    </div>

    <div class="spcs_foor" onclick="hideContent();">
        完成
    </div>

</div>

<!--<div id="light" class="white_content">-->
    <!--<h3>分享</h3>-->
    <!--<ul>-->
        <!--<li><a href=""><i class="iconfont iconb1">&#xe628;</i><p>复制链接</p></a></li>-->
        <!--<li><a href=""><i class="iconfont iconb2">&#xe673;</i><p>微信</p></a></li>-->
        <!--<li><a href="<?php echo U('Home/share');?>"><i class="iconfont iconb3">&#xe541;</i><p>果友</p></a></li>-->
    <!--</ul>-->
    <!--<div style="clear: both;"></div>-->
    <!--<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" class="qx">取消</a>-->
<!--</div>-->


</body>
</html>