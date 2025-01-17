<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,minimal-ui">
  <title>订单支付</title>
  <link rel="stylesheet" href="/Public/Public/css/3db_style.css">
  <link rel="stylesheet" href="/Public/Public/icon/3db_iconfont.css">

  <!-- 轮播图 -->
  <script type="text/javascript" src="/Public/Public/js/jquery-1.7.1.min.js"></script>

  <script type="text/javascript" src="/Public/Public/js/jquery.touchSlider.js"></script>
  <script type="text/javascript" src="/Public/Public/js/js.js"></script>
  <script type="text/javascript" src="/Public/Public/js/3db_layer.js"></script>

</head>
<body>
  <!-- 轮播图 -->
    <div class="fxm_header">
       <div class="fxm_left">
           <a href="<?php echo U('shop/home/index');?>"><img src="/Public/Public/images/b1.png" alt=""></a>
       </div>
       <div class="fxm_center"><?php echo ((isset($title) && ($title !== ""))?($title):'支付'); ?></div>
    </div>
     <body style="background: #f6f5fb;" data-id="<?php echo ($order['order_no']); ?>">


<link rel="stylesheet" href="/Public/Public/css/dizhi.css">
<div style="margin-top: 13vmin"></div>
<style type="text/css">
  label{
    width: 80%;
    display: inline-block;
  }

</style>
<?php if(is_array($order)): foreach($order as $key=>$v): ?><div class="commoditys">
  <div class="commoditys-left">
    <img src="/Public/Public/images/ept_1.jpg" alt="">
  </div>
  
  <div class="commoditys-right">


    <?php
 $dianpu=M('gerenshangpu')->where('userid',$v['order_sellerid'])->find(); ?>
  <h1>店铺名称：<?php echo ($dianpu["shop_name"]); ?></h1>
    <h3 style="color: black";>订单号：<?php echo ($v["order_no"]); ?></h3>
    <h3 style="color: inherit;" >订单总额：<span style="color:#FF2626" >￥<?php echo ($v["buy_price"]); ?></span></h3>

  </div>
 
</div><?php endforeach; endif; ?>
<div class="clear"></div>

  <div class="methods">
    <h1>请选择支付方式</h1>
    <!-- <p> -->
    <!-- <i class="iconfont" style="color: #f04f37">&#xe60e;</i> -->

    <!-- <label for="money">积分支付（余额：<?php echo ($farmlink_jifen); ?>元）</label> -->
    <!-- <input id="money" type="radio" name="payway" value="1"> -->
    <!-- </p> -->
	<p>
		<i class="iconfont" style="color: #f04f37">&#xe60e;</i>
		<label for="money">GEO支付（余额：<?php echo ($geo); ?>）</label>
		<input id="" type="radio" name="payway" value="2" checked="">
    </p>
  </div>




  <div class="lijizhifu">
    <a href="<?php echo U('Pay/pays',array('oid'=>$order[0]['order_id'],'type'=>4,'payway'=>2));?>" id="go">立即支付</a>
  </div>
  <input type="hidden" id="order_id" value="" >







<script type="text/javascript">

    /*选中消费积分支付不显示赠送积分*/
    $("input[name='payway']").change(function () {
        var pay_type = $("input[name='payway']:checked").val();
        var url = '/Shop/Pay/pays/oid/'+<?php echo ($order[0]['order_id']); ?>+'/type/4/payway/'+pay_type+'.html';
        $('#go').attr('href',url);
        if (pay_type == 4) {
            $('.paytypes').hide();
        } else {
            $('.paytypes').show();
        }
    });

    $("#pay_yes").click(function () {
        $("#shadow_div").show("200");
    });

    $("#pay_close").click(function () {
        $("#shadow_div").hide("200");
    });


    $("#pay_submit").click(function () {
        //验证数据
        var pay_type = $("input[name='paytype']:checked").val();
        var ono = $("body").attr("data-id");
        var pwd = $("input[name='pay_pwd']").val();
        var or_no = $("body").attr("data-id");
        $(".order_no").val(ono);
        /*选择积分类型*/
        var jifentypes = $("#jifentype").val();

        if (!pwd) {
            layer.msg('请输入二级密码', {icon: 5,time: 1500});
            return;
        }

        if (!ono) {
            layer.msg('该订单不存在', {icon: 5,time: 1500});
            return;
        }

        $.post("/Shop/Pay/pay", {ptype: pay_type, ono: ono, pwd: pwd, jifentypes: jifentypes}, function (data) {
            if (data.status == "1") {
                if(data.info == 2){
                    window.location.href = "<?php echo U('Shop/pay/apily',array('order_no'=>$order['order_no']));?>";
                    return;
                }
                layer.msg(data.info, {icon: 1,time: 1500}, function () {
                    $("#shadow_div").hide("200");
                    window.location.href = "<?php echo U('/shop/home/index');?>";
                });
            } else {
                layer.msg(data.info, {shift: -1, time: 1500}, function () {
                });
            }
        }, "json");
    });
</script>



<script type="text/javascript">
    $(".codeimg").click(function(){
        var img = $(this).attr("src");

        shop_qrcode(img);

    });
    function shop_qrcode(img){
        layer.open({
          type: 1,
          title: false,
          shadeClose: true,
          closeBtn: false,
          shade: 0.5,
          area: ['250', '250'],
          content: '<img   src="'+img+'" style="width:250px;height:250px;display:block;margin:0 auto;">' //iframe的url
        });

    }
</script>
</body>
</html>