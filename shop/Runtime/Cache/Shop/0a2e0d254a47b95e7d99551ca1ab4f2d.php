<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo ($config['SITE_TITLE']); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />

    <!-- Link Swiper's CSS -->

    <link rel="stylesheet" type="text/css" href="/Public/Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/Public/css/foot.css">

    <link rel="stylesheet" href="/Public/Public/css/head.css">
    <link rel="stylesheet" type="text/css" href="/Public/Public//iconfont/iconfont.css">

    <link rel="stylesheet" href="/Public/Public/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/Public/Public/css/style22.css">
    <script type="text/javascript" src="/Public/Public/js/jquery-1.7.1.min.js"></script>

    <script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>

    <!-- Demo styles -->
   <!--  <script type="text/javascript" src="/Public/Public/js/jquery.touchSlider.js"></script>

    <script type="text/javascript" src="/Public/Public/js/webuploader.min.js"></script>
<script type="text/javascript" src="/Public/Public/js/upload.js"></script> -->

</head>
<style>
    .dzlist{
        margin-right: 3%;
        margin-left: 3%;
        border: 1px solid #e5e5e5;
        border-radius: 3px;
        margin-top: 5%;
        box-shadow: 0px 0px 10px #ccc;
        padding:3%;
    }
    .dzlist h3{
        font-size: 4.5vmin;
        color:#333;
        line-height: 6vmin;
    }
    .dzlist p{
        line-height: 10vmin;
        font-size: 4vmin;
        color:#767975;
    }
    .dzlist_bot{
        border-top:1px solid #ddd;

    }
    .dzlist_bot span{
        float: right;
         margin-left: 5%;
    }
    .dzlist_bot a{
        line-height: 10vmin;
        font-size:4vmin;
        color:#767975;
    }

    .order_table tr{
      width:100%;
      height: 8vmin;

    }

    .order_table tr th{
      width:20%;
    }
    .order_table tr td{
      width:66%;
    }
    .order_table tr td input{
        border: none
    }
    .allder_nr p.dain {
        float: left;
        line-height: 10vmin;
        font-size: 4vmin;
        margin-left: 3%;
        color: #ff7031;
    }
</style>
<body>
<div class="header">
    <div class="header_l" style="width: 15%;">
      <a href="<?php echo U('shop/member/mine');?>"><img src="/Public/Public/images/lpg.png" alt=""><span>商户订单</span></a>

    </div>
    <div class="header_c" style="width: 70%;"> <h1 style="color:#000"></h1></div>
    <div class="header_r" style="width: 15%;"></div>
    <!-- <span><a href=""><img src="" alt=""></a></span> -->
</div>
<style>
    .jilu table{width: 100%;font-size:14px;margin:3% 0;}
    .jilu table tr th{text-align: center;padding-right:2%;line-height: 40px;background: #ddd}
    .jilu table tr td{border:1px solid #ddd;text-align: center;line-height: 35px;}
    .jilu table tr td input{border:none;width:100px;text-align: center}
</style>

<?php if(is_array($orderList)): foreach($orderList as $key=>$order): ?><div class="allder_nr">
        <p class="dain">订单编号：<span>1</span></p>
        <div style="clear: both;"></div>
          <?php
 $allProductNum = 0; $allProductPrice =0; ?>
          <?php if(is_array($order['detail'])): foreach($order['detail'] as $key=>$detail): $allProductNum = $allProductNum + $detail['com_num']; $allProductPrice = $allProductPrice+$detail['com_num']*$detail['com_price']; ?>

        <div class="ddcontent">
            <div class="content_l">
              <img src="<?php echo ($detail['com_img']); ?>" alt="">
            </div>
            <div class="content_r">
              <div class="content_rt">
                <h3 onClick="window.location.href='<?php echo U('Home/details',array('proid'=>$detail['com_id']));?>'"><?php echo ($detail['com_name']); ?></h3>
                <div class="jaind">
                  <p>￥<?php echo ($detail['com_price']); ?></p>
                  <p>x<?php echo ($detail['com_num']); ?></p>
                </div>
              </div>
            </div>
            <div style="clear: both;"></div>
        </div><?php endforeach; endif; ?>
        <!--<div class="total" style="margin-bottom:10vmin">
          <p>共计<?php echo ($allProductNum+0); ?>商品 <span>合计：￥<?php echo ($allProductPrice+0); ?></span></p>

          <a href="javascript:void(0)" onClick="window.location.href='/Shop/Pay/index/oid/<?php echo ($detail['order_id']); ?>'" class="btn_style2">立即支付</a>
          <a href="javascript:void(0)" class="btn_style1" id="show_odetail">查看详情</a>
        </div>-->

    <!--<?php if(is_array($order['detail'])): foreach($order['detail'] as $k=>$detail): ?><table class="order_table">
             <tr>
                <th>订单编号:</th>
                <td><?php echo ($k+1); ?></td>
            </tr>
            <tr>
                <th>商品名称:</th>
                <td><?php echo ($detail['com_name']); ?></td>
            </tr>

            <tr>
                <th>购买金额:</th>
                 <td><?php echo ($detail['com_price']+0); ?> * <?php echo ($detail['com_num']+0); ?></td>
            </tr>
            <tr>
               <th>购买数量:</th>
               <td><?php echo ($detail['com_num']+0); ?></td>
            </tr>
            <tr>
               <th>结算金额:</th>
               <td><?php echo ($order['buy_price']+0); ?></td>
             </tr>

        </table><?php endforeach; endif; ?>
    <?php if(($order['status']) == "1"): ?>-->
    <table class="order_table" style="margin-left: 3%">
        <tr>
             <th>快递名称:</th>
             <td><input type="text" value="<?php echo ($order['kd_name']); ?>" class="kd_name_<?php echo ($order['order_id']); ?>"  name="kd_name"></td>
         </tr>
         <tr>
              <th>快递单号:</th>
              <td><input type="text" value="<?php echo ($order['order_no']); ?>"  class="order_no_<?php echo ($order['order_id']); ?>"  name="order_no"></td>
         </tr>
    </table>

    <p style="text-align: center;padding-bottom: 3%;padding-top: 3%;">
        <?php if($order['status'] == 2): ?><button  style="width: 94%;height: 10vmin;border: none;background: #c5c5c5;font-size: 4vmin;border-radius: 1vmin;color: #fff;">
            已发货</button>
        <?php elseif($order['status'] == 3): ?>
            <button  style="width: 94%;height: 10vmin;border: none;background: #c5c5c5;font-size: 4vmin;border-radius: 1vmin;color: #fff;">
            已签收</button>
        <?php else: ?>
            <button class="deliver" data-id="<?php echo ($order['order_id']); ?>" style="width: 94%;height: 10vmin;border: none;background: #ff5000;font-size: 4vmin;border-radius: 1vmin;color: #fff;">
            确定发货</button><?php endif; ?>
    </p>
    <!--<?php endif; ?>-->
    <?php if(($order['status']) == "0"): if(!empty($order['order_proof'])): ?><p style="text-align: center;padding-bottom: 3%;">
            <a href="<?php echo ($order['order_proof']); ?>"  target="_blank"><img width="60" height="60" src="<?php echo ($order['order_proof']); ?>" alt=""></a>
            <button  class=" haveMoney" data-id="<?php echo ($order['order_id']); ?>" style="width: 94%;height: 10vmin;border: none;background: #ff5000;font-size: 4vmin;border-radius: 1vmin;color: #fff;">
            我已收到款</button>
            </p><?php endif; endif; ?>

    <div style="background: #f4f4f4;height: 2vmin;margin-top: 3vmin;"></div><?php endforeach; endif; ?>



<style>
    .selectcc{
        width: 83%;
        border: none;
        border-bottom: 1px solid #aaa;
        font-family: "微软雅黑";
        /*很关键：将默认的select选择框样式清除*/
        appearance:none;
        -moz-appearance:none;
        -webkit-appearance:none;
        /*为下拉小箭头留出一点位置，避免被文字覆盖*/
        padding-right: 14px;
    }
    .tixian{border-top:0;}
</style>

<script  type="text/javascript" charset="utf-8" async defer>
    $(".haveMoney").click(function(){
        var id = $(this).attr("data-id");
        $.post("<?php echo U('Member/havemoney');?>",{"id":id},function(data){
            if(data.status=='1'){
                layer.msg(data.info,{icon:1,time:1200});
            }else{
                layer.msg(data.info,{icon:2,time:1200});
            }


        },"json");



    });


    $('.deliver').click(function () {
        var id = $(this).attr('data-id');
        var kd_name = ".kd_name_"+id;
        var kd_no = ".order_no_"+id;
        var kd_name_val = $(kd_name).val();
        var kd_no_val = $(kd_no).val();
        var old = $(this);
        $.ajax({
            url:"/Shop/Member/deliver",
            type:"post",
            data:{'id':id,'express_order':kd_no_val,'express_name':kd_name_val},
            datatype:"json",
            success:function (mes) {
                if(mes.status == 1){
                    layer.msg(mes.info, {icon: 1, time: 1200}, function () {
                        old.text('已发货');
                        old.css('background','#c5c5c5');
                        old.removeClass("deliver");return;
                    });
                }else{
                    layer.msg(mes.info,{icon:2,time:1200});
                }
            }
        })
    })



</script>

</body>
</html>