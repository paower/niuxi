<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>商品订单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>

    <!-- Link Swiper's CSS -->

    <link rel="stylesheet" type="text/css" href="/Public/Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/Public/css/foot.css">

    <link rel="stylesheet" href="/Public/Public/css/head.css">
    <link rel="stylesheet" href="/Public/Public/icon/iconfont.css">
    <script type="text/javascript" src="/Public/Public/js/jquery-1.7.1.min.js"></script>

    <!--弹框JS-->
    <script type="text/javascript" src="/Public/Public/verify/layer.js"></script>

    <script type="text/javascript" src="/Public/Public/js/jquery.touchSlider.js"></script>
    <!-- Demo styles -->

</head>
<body style="background: #f4f4f4;">
<div class="header">
    <div class="header_l">
        <a href="<?php echo U('car/shopping');?>"><img src="/Public/Public/images/lpg.png" alt=""><span>确认订单</span></a>
    </div>
    <div class="header_c"><h1></h1></div>
    <div class="header_r"><a href=""></a></div>
    <!-- <span><a href=""><img src="" alt=""></a></span> -->
</div>

<div class="receipt">
    <?php if(($addinfp['name']) == ""): ?><a href="<?php echo U('member/addresslist');?>"> <p class="shr">添加收货地址</p></a>
        <?php else: ?>
    <a href="<?php echo U('member/addresslist',array('type'=>8));?>">
            <p class="shr">收货人：
                <input type="hidden" name="uname" value="<?php echo ($addinfp['name']); ?>">
                <input type="hidden" name="uphone" value="<?php echo ($addinfp['telephone']); ?>">
                <input type="hidden" name="address" value="<?php echo ($addinfp['province_id']); echo ($addinfp['city_id']); echo ($addinfp['country_id']); ?> <?php echo ($addinfp['address']); ?>">

                <i class="uname"><?php echo ($addinfp['name']); ?></i>
                <i class="uphone"><?php echo ($addinfp['telephone']); ?></i></p>
            <p class="shdz" onclick=""><i class="iconfont">&#xe619;</i><span class="address">收货地址：<?php echo ($addinfp['province_id']); echo ($addinfp['city_id']); echo ($addinfp['country_id']); ?> <?php echo ($addinfp['address']); ?></span>
            </p>
    </a><?php endif; ?>
</div>
<?php $allPrice = 0;?>
<?php $allNum = 0;?>
<?php if(is_array($selProductList)): foreach($selProductList as $key=>$selProd): if(is_array($selProd)): foreach($selProd as $key=>$product): ?><div class="receipt_nr">
            <div class="receipt_nrl">
                <img src="<?php echo ($product['pic']); ?>" alt="">
            </div>
                    <?php  $sp_id=$product['pid']; $shop=M('product_detail')->where(array('id'=>$sp_id))->find(); $uid=$shop['shangjia']; $dianpu=M('gerenshangpu')->where('userid='.$uid)->find(); ?>
            <div class="receipt_nrr">
            
                <h3 onclick="window.location.href='<?php echo U('Home/details',array('proid'=>$product['pid']));?>'">
                    <?php echo ($product['name']); ?></h3>
                <p><img style="width: 100%" src="<?php echo ($dianpu['shop_logo']); ?>">店铺：<?php echo ($dianpu['shop_name']); ?></p>
                <p>
                    <?php if(($product['color']) != ""): ?>颜色分类：<?php echo ($product['color']); endif; ?>
                    <?php if(($product['size']) != ""): ?><span>尺码：<?php echo ($product['size']); ?></span><?php endif; ?>
                </p>
                <p class="ssjg">￥<?php echo ($product['price']*$product['num']); ?> <span>x<?php echo ($product['num']); ?></span></p>
            </div>
            <div style="clear: both;"></div>
        </div>

       <p> <?php $allPrice=$allPrice+$product['num']*$product['price']; ?>
        <?php $allNum = $allNum+$product['num']; ?></p><?php endforeach; endif; endforeach; endif; ?>
<div class="order_bb">
    <ul>
        <li>购买数量
            <span>
        <div id="content">
        <div class="aab">
        <input readonly="readonly" class="num" name="num[]" type="text" value="<?php echo ($allNum); ?>">
        </div>
        </div>
        </span>
        </li>
      <!--   <li>配送方法<span class="spr">包邮</span></li> -->
        <!--<li>选择积分-->
            <!--<span class="spr">-->
            <!--<select id="jifentype">-->
              <!--<option value="0" type="0">请选择类型</option>-->
              <!--<option jifen-type="1" jifen-nums="400">鸡场积分400</option>-->
              <!--<option jifen-type="2" jifen-nums="280">果园积分280</option>-->
              <!--<option jifen-type="3" jifen-nums="186">渔场积分186</option>-->
            <!--</select>-->
        <!--</span>-->
        <!--</li>-->
    </ul>
</div>

<div style="height: 15vmin;"></div>
<div class="order_foor">
    <p>合计：<span>￥<?php echo ($allPrice); ?>.00</span></p>
    <a class="uporder" href="javascript:void(0)">提交订单</a>
    <!--<a href="<?php echo U('Car/addOrder');?>">提交订单</a>-->
</div>


<script type="text/javascript">
    /*提交订单*/
    $('.uporder').click(function () {
        var uphone = $('.uphone').text();
        var uname = $('.uname').text();
        var jifentype = $("#jifentype").find('option:selected').attr('jifen-type');
        var jifennums = $("#jifentype").find('option:selected').attr('jifen-nums');

        if (uname == '') {
            layer.msg('请先添加收货地址', {shift: -1, time: 1200}, function () {
                location.href = "<?php echo U('member/address',array('type'=>8));?>";
            });
            return;
        }
        location.href = "<?php echo U('Car/addOrder',array('address_id'=>$addinfp['address_id']));?>";
    })

</script>

</body>
</html>