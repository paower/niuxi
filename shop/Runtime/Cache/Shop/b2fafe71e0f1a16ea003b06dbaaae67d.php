<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?php echo ($config['SITE_TITLE']); ?></title>
    <meta name="Keywords" content=""/>
    <meta name="description" content="" />
    <!-- <script src="/Public/Public/js/mui.min.js"></script> -->
    <link href="/Public/Public/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Public/Public/css/styleshop.css" />
    <link rel="stylesheet" href="/Public/Public/icon/iconfont.css">
     <link rel="stylesheet" href="/Public/Public/css/style1.css">
     <link rel="stylesheet" href="/Public/Public/icon1/iconfont.css">
    <script type="text/javascript">
        !function(J){function H(){var d=E.getBoundingClientRect().width;var e=(d/7.5>100*B?100*B:(d/7.5<42?42:d/7.5));E.style.fontSize=e+"px",J.rem=e}var G,F=J.document,E=F.documentElement,D=F.querySelector('meta[name="viewport"]'),B=0,A=0;if(D){var y=D.getAttribute("content").match(/initial\-scale=([\d\.]+)/);y&&(A=parseFloat(y[1]),B=parseInt(1/A))}if(!B&&!A){var u=(J.navigator.appVersion.match(/android/gi),J.navigator.appVersion.match(/iphone/gi)),t=J.devicePixelRatio;B=u?t>=3&&(!B||B>=3)?3:t>=2&&(!B||B>=2)?2:1:1,A=1/B}if(E.setAttribute("data-dpr",B),!D){if(D=F.createElement("meta"),D.setAttribute("name","viewport"),D.setAttribute("content","initial-scale="+A+", maximum-scale="+A+", minimum-scale="+A+", user-scalable=no"),E.firstElementChild){E.firstElementChild.appendChild(D)}else{var s=F.createElement("div");s.appendChild(D),F.write(s.innerHTML)}}J.addEventListener("resize",function(){clearTimeout(G),G=setTimeout(H,300)},!1),J.addEventListener("pageshow",function(b){b.persisted&&(clearTimeout(G),G=setTimeout(H,300))},!1),H()}(window);
        if (typeof(M) == 'undefined' || !M){
            window.M = {};
        }
    </script>
</head>
<body>

<!--搜索分类列表-->
<div class="mui-content mui-row mui-fullscreen search-menu">
    <div class="mui-col-xs-3">
        <div id="segmentedControls" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-vertical">
            <?php if(is_array($oneCateList)): $i = 0; $__LIST__ = $oneCateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!-- mui-active -->
                <a class="mui-control-item <?php echo ($vo['id']==$id?'mui-active':''); ?>" data-index="<?php echo ($vo['id']); ?>" href="<?php echo U('home/cation',array('id'=>$vo['id']));?>"> <?php echo ($vo['name']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div id="segmentedControlContents" class="mui-col-xs-9" >
            <div id="content1" class="mui-control-content" style="margin-top:5px;">
            <ul class="mui-table-view">
                <?php if(is_array($shopping)): $i = 0; $__LIST__ = $shopping;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="/shop/dianpu/index/did/<?php echo ($vo['userid']); ?>"><li class="mui-table-view-cell"><img src="<?php echo ($vo['shop_logo']); ?>" style="width:90px;height:60px"><p style="font-size:12px"> <?php echo ($vo['shop_name']); ?></p> </li></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            </div>
    </div>
</div>
<div class="h50"></div>



<script src="/Public/Public/js/jquery-1.10.1.min.js"></script>



<!-- <script>
    //链接跳转问题
    // mui('body').on('tap', 'a', function() {
    //     document.location.href = this.href;
    // });
    mui.init({
        swipeBack: true //启用右滑关闭功能
    });
    var controls = document.getElementById("segmentedControls");
    var contents = document.getElementById("segmentedControlContents");
   

    var arr = new Array();
    var cateData = <?php echo $jsonData; ?>;
    var oneCate = cateData.one;//产品大类
    var twoCate = cateData.two;//大类下店铺

    var html = [];
    var i = 1,
        j = 1,
        m = oneCate.length, //左侧选项卡数量+1
        n = twoCate.length; //每个选项卡列表数量+1
    for (; i <=m; i++) {
        var one = oneCate[i-1];
        html.push('<a class="mui-control-item" data-index="' + (i - 1) + '" href="#content' + i + '"> ' + one.name + '' +  '</a>');
    }
    controls.innerHTML = html.join('');
    html = [];
    for (i = 1; i <= m; i++) {
        var one = oneCate[i-1];

        html.push('<div id="content' + i + '" class="mui-control-content"><ul class="mui-table-view">'+'<h2><span class="fl">' +one.name+ '</span><a href="" class="fr mui-navigate-right"></a></h2>');
        for (j = 1; j <=n; j++) {
            var two = twoCate[j-1];
            if(one.type==two.shop_type){
                html.push('<a href="/shop/dianpu/index/did/'+two.userid+'">'+'<li class="mui-table-view-cell">' + '<img src="' +two.shop_logo+ '" style="width:90px;height:60px"/>' +'<p style=font-size:12px> '+two.shop_name+'</p> ' + '</li>'+ '</a>');
            }
        }
        html.push('</ul></div>');
    }
    contents.innerHTML = html.join('');
    //默认选中第一个
    controls.querySelector('.mui-control-item').classList.add('mui-active');
    //          contents.querySelector('.mui-control-content').classList.add('mui-active');
    (   function() {
        var controlsElem = document.getElementById("segmentedControls");
        var contentsElem = document.getElementById("segmentedControlContents");
        var controlListElem = controlsElem.querySelectorAll('.mui-control-item');
        var contentListElem = contentsElem.querySelectorAll('.mui-control-content');
        var controlWrapperElem = controlsElem.parentNode;
        var controlWrapperHeight = controlWrapperElem.offsetHeight;
        var controlMaxScroll = controlWrapperElem.scrollHeight - controlWrapperHeight;//左侧类别最大可滚动高度
        var controlHeight = controlListElem[0].offsetHeight;//左侧类别每一项的高度
        contentsElem.addEventListener('scroll', function() {
            var scrollTop = contentsElem.scrollTop;
            for (var i = 0; i < contentListElem.length; i++) {
                var offsetTop = contentListElem[i].offsetTop - 80;
                var offset = Math.abs(offsetTop - scrollTop);
//                      console.log("i:"+i+",scrollTop:"+scrollTop+",offsetTop:"+offsetTop+",offset:"+offset);
                // console.log(offsetTop);
                // console.log(scrollTop-(contentListElem[i].offsetHeight / 2));

                console.log(i);
                if (scrollTop-(contentListElem[i].offsetHeight / 2) + 50 <= offsetTop) {
                    onScroll(i);
                    break;
                }
            }
        });
        var lastIndex = 0;
        //监听content滚动
        var onScroll = function(index) {
            if (lastIndex !== index) {
                lastIndex = index;
                var lastActiveElem = controlsElem.querySelector('.mui-active');
                lastActiveElem && (lastActiveElem.classList.remove('mui-active'));
                var currentElem = controlsElem.querySelector('.mui-control-item:nth-child(' + (index) + ')');
                currentElem.classList.add('mui-active');
                //简单处理左侧分类滚动，要么滚动到底，要么滚动到顶
            }
        };
        //滚动到指定content
        var scrollTo = function(index) {
            contentsElem.scrollTop = contentListElem[index].offsetTop;
        };
        mui(controlsElem).on('tap', '.mui-control-item', function(e) {
            scrollTo(this.getAttribute('data-index'));
            return false;
        });
    })();

</script> -->
<?php $name= ACTION_NAME; ?>
<!-- 底部 -->

<style type="text/css">
    .footer a p{
            box-sizing:content-box;
            color: #333333;
    }

    .footer a{
            box-sizing:content-box;

    }

    .footer{
            box-sizing:content-box;
    }
</style>
<div class="footer">
    <a href="<?php echo U('/Shop/Home/index');?>" <?php if(($name) == "index"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>首页</p>
    </a>
     <a href="<?php echo U('/Shop/Home/cation');?>" <?php if(($name) == "cation"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>店铺分类</p>
    </a>
     <a href="<?php echo U('/Shop/Car/shopping');?>" <?php if(($name) == "shopping"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>购物车</p>
    </a>
     <a href="<?php echo U('/Shop/member/mine');?>" <?php if(($name) == "mine"): ?>class="onb"<?php endif; ?>>
        <i class="iconfont"></i>
        <p>我的</p>
    </a>
</div>



</body>
</html>