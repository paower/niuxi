<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <title><?php echo ($config['SITE_TITLE']); ?></title>
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
    <link rel="stylesheet" href="/Public/Public/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/Public/Public/css/style22.css">
    <script type="text/javascript" src="/Public/Public/js/jquery-1.7.1.min.js"></script>

    <!--弹框JS-->
    <script type="text/javascript" src="/Public/Public/verify/layer.js"></script>



    <script type="text/javascript" src="/Public/Public/js/address.js"></script>
    <!-- Demo styles -->
    <!-- <script type="text/javascript" src="/Public/Public/js/webuploader.min.js"></script>
    <script type="text/javascript" src="/Public/Public/js/upload.js"></script>
    <script type="text/javascript" src="/Public/Public/js/area.js"></script> -->

</head>
<body>
<style>
    .address {
        margin-right: 4%;
        margin-left: 4%;
    }

    .address li {
        line-height: 17vmin;
        font-size: 4.2vmin;
    }

    .address li input {
        width: 85%;
        height: 5vmin;
        border: none;
        border-bottom: 1px solid #aaaaaa;
    }

    .selectcc {
        width: 83%;
        border: none;
        border-bottom: 1px solid #aaa;
        font-family: "微软雅黑";
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        padding-right: 14px;
    }

    .dzq {
        width: 84%;
        height: 5vmin;
        border: none;
        border-bottom: 1px solid #aaaaaa;
    }
</style>
<div class="header">
    <div class="header_l" style="width: 15%;">
        <a href="Javascript:history.go(-1)"><img src="/Public/Public/images/lpg.png" alt=""><span>收货地址</span></a>

    </div>
    <div class="header_c" style="width: 70%;"><h1 style="color:#000"></h1></div>
    <div class="header_r" style="width: 15%;"></div>
    <!-- <span><a href=""><img src="" alt=""></a></span> -->
</div>

<div class="address">
    <ul>
        <li>姓名：<input type="text" value="<?php echo ($info['name']); ?>" name="uname"></li>
        <!-- <li>省份：<input type="text"></li>
        <li>城市：<input type="text"></li>
        <li>区域：<input type="text"></li> -->
        <li>
            <p>省份：
                <select id="province" name="province" class="ng-valid ng-dirty ng-valid-parse ng-touched dzq">
                    <option value="" selected="selected">--请选择省份--</option>
                </select>
            </p>

            <p>城市：
                <select id="city" name="city" class="ng-valid ng-dirty ng-valid-parse ng-touched dzq">
                    <option value="" selected="selected">--请选择市--</option>
                </select>
            </p>

            <p>区域：
                   <select id="district" name="district" class="ng-valid ng-dirty ng-valid-parse ng-touched dzq">
                    <option value="" selected="selected">--请选择区--</option>
                </select>
            </p>


        </li>
        <li>地址：<input type="text" value="<?php echo ($info['address']); ?>" name="detailadd"></li>
        <li>电话：<input type="text" value="<?php echo ($info['telephone']); ?>" name="phone"></li>
    </ul>
    <p><input type="checkbox" value="1" <?php if(($info['zt_']) == "1"): ?>checked<?php endif; ?> class="ismoren" style="vertical-align: middle;vertical-align: middle;width: 9vmin;height: 5vmin;">是否设为默认地址
    </p>
    <input type="hidden" class="province_id" value="<?php echo ($info['province_id']); ?>">
    <input type="hidden" class="city_id" value="<?php echo ($info['city_id']); ?>">
    <input type="hidden" class="country_id" value="<?php echo ($info['country_id']); ?>">
    <input type="hidden" class="address_id" value="<?php echo ($info['address_id']); ?>">
    <input type="hidden" class="type" value="<?php echo ($type); ?>">
</div>

<script type="text/javascript">
    var province_id = $('.province_id').val();
    var city_id = $('.city_id').val();
    var country_id = $('.country_id').val();
    if(province_id != '' ){
        addressInit('province', 'city', 'district', province_id, city_id, country_id);//添加
    }else{
        addressInit('province', 'city', 'district', '广东', '', '');//添加
    }
</script>

<style>
    .selectcc {
        width: 83%;
        border: none;
        border-bottom: 1px solid #aaa;
        font-family: "微软雅黑";
        /*很关键：将默认的select选择框样式清除*/
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        /*为下拉小箭头留出一点位置，避免被文字覆盖*/
        padding-right: 14px;

    }
</style>

<?php if(!empty($info['name'])): ?><div class="dosave submit"><a href="javascript:void(0)" style="background:#ff6a31;">确认修改</a></div>
<?php else: ?>
    <div class="dosubmit submit"><a href="javascript:void(0)" style="background:#ff6a31;">确认添加</a></div><?php endif; ?>
<script>
    $('.dosubmit').click(function () {
        var uname = $("input[ name='uname' ]").val();
        var province = $("#province  option:selected").text();
        var city = $("#city  option:selected").text();
        var district = $("#district  option:selected").text();
        var detailadd = $("input[ name='detailadd' ]").val();
        var phone = $("input[ name='phone']").val();
        var ismoren = $('input[type=checkbox]:checked').val();
        var type = $('.type').val();
        /*电话号码正则*/
        if(!(/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7]))\d{8}$/.test(phone))){
                layer.msg('不是完整的11位手机号或者正确的手机号前七位', {shift: -1, time: 1200}, function () {
            });
            return false;
        }

        $.ajax({
            url: "<?php echo U('Member/Addaddress');?>",
            type: "post",
            data: {
                'uname': uname,
                'province': province,
                'city': city,
                'district': district,
                'detailadd': detailadd,
                'phone': phone,
                'ismoren': ismoren
            },
            datatype: "json",
            success: function (mes) {
                if (mes.status == 1) {
                    layer.msg('收货地址添加成功', {shift: -1, time: 1200}, function () {
                        if(type == 8){
                            location.href = "<?php echo U('home/order');?>";
                        }else{
                            location.href = "<?php echo U('member/addresslist');?>";
                        }
                    });
                } else {
                    layer.msg('添加失败,请填写完整地址信息', {shift: -1, time: 1200}, function () {
                    });
                }
            }
        })
    })

    /*修改*/
    $('.dosave').click(function () {
        var uname = $("input[ name='uname' ]").val();
        var province = $("#province  option:selected").text();
        var city = $("#city  option:selected").text();
        var district = $("#district  option:selected").text();
        var detailadd = $("input[ name='detailadd' ]").val();
        var phone = $("input[ name='phone' ]").val();
        var ismoren = $('input[type=checkbox]:checked').val();
        var address_id = $(".address_id").val();
        $.ajax({
            url: "<?php echo U('Member/Addaddress');?>",
            type: "post",
            data: {
                'address_id': address_id,
                'uname': uname,
                'province': province,
                'city': city,
                'district': district,
                'detailadd': detailadd,
                'phone': phone,
                'ismoren': ismoren
            },
            datatype: "json",
            success: function (mes) {
                if (mes.status == 1) {
                    layer.msg(mes.info, {shift: -1, time: 1200}, function () {
                        location.href = "<?php echo U('member/addresslist');?>";
                    });
                } else {
                    layer.msg(mes.info, {shift: -1, time: 1200}, function () {
                    });
                }
            }
        })
    })
</script>
</body>
</html>