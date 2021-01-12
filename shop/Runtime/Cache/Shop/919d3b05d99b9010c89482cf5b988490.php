<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,minimal-ui">
  <title><?php echo ($config['SITE_TITLE']); ?></title>
  <link rel="stylesheet" href="/Public/Public/css/style1.css">
  <link rel="stylesheet" href="/Public/Public/icon/iconfont.css">
  <link rel="stylesheet" href="/Public/Public/icon1/iconfont.css">

  <!-- 轮播图 -->
  <script type="text/javascript" src="/Public/Public/js/swiper-3.4.2.jquery.min.js"></script>
  <script type="text/javascript" src="/Public/Public/js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="/Public/Public/js/jquery.touchSlider.js"></script>
  <script type="text/javascript" src="/Public/Public/js/js.js"></script>

<style>
.notice_right {
	width: 100%;
	width: 90%;
	height: 10vmin;
	overflow: hidden;
}

.notice_right ul li {
	display: block;
	height: 10vmin;
	line-height: 10vmin;
	overflow: hidden;
}

.notice_right ul li a {
	display: inline-block;
	height: 10vmin;
	line-height: 10vmin;
}

.search_btn {
	display: block;
	float: right;
	margin: 0;
	padding: 0;
	margin-top: -7.5%;
	z-index: 9999;
	margin-right: 3vmin;
}

.search_btn img {
	display: block;
	width: 5vmin;
	z-index: 9999;
}

#sou {
	float: left;
}

.type,.type ul {
	background: none;
}

</style>
</head>
<body>

  <!-- 轮播图 -->
    <div class="fxm_header">
       <div class="fxm_left"><a href="<?php echo U('Home/index/index');?>"><img src="/Public/Public/images/left0.png"></a></div>
       <div class="fxm_center">商城首页</div>
    </div>

		<div class="main-content ng-scope" id="main_content"> 
		   <div class="main_visual"> 
			<div class="flicking_con"> 
			 <a href="#"></a> 
			 <a href="#"></a> 
			</div> 
			<div class="main_image"> 
			 <ul> 
			  <li><span class="img_3"><img src="/Public/Public/images/ban4.jpg" /></span></li> 
			  <li><span class="img_4"><img src="/Public/Public/images/banner1.jpg" /></span></li> 
			 </ul> 
			 <a href="javascript:;" id="btn_prev"></a> 
			 <a href="javascript:;" id="btn_next"></a> 
			</div> 
		   </div> 
		  </div>
    <!-- 轮播图 -->

    <div class="type">

      <ul>

        <li>

          <a href="<?php echo U('dianpu/businesslist');?>">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e7bd36a2f.png"></span>

            <p>入驻商家</p>

          </a>

        </li><li>

          <a href="<?php echo U('shop/Home/mend',array('sta'=>1));?>">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e7d381d77.png"></span>

            <p>热门商品</p>

          </a>

        </li><li>

          <a href="<?php echo U('shop/Home/mend',array('sta'=>2));?>">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e7e305882.png"></span>

            <p>最新商品</p>

          </a>

        </li><li>

          <a href="<?php echo U('shop/Home/mend',array('sta'=>3));?>">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e7f620653.png"></span>

            <p>推荐商品</p>

          </a>

        </li><li>

          <a href="<?php echo U('shop/Home/mend',array('sta'=>4));?>">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e81283eb5.png"></span>

            <p>全部商品</p>

          </a>

        </li>
		<li>

          <a href="<?php echo U('/Shop/member/mine');?>">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e84cb975b.png"></span>

            <p>会员中心</p>

          </a>

        </li>
		<li>

          <a href="#">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e87cdc0d0.png"></span>

            <p>帮助中心</p>

          </a>

        </li><li>

          <a href="#">

            <span><img src="/Public/Public/Uploads/image/touxiang/2017-12-26/5a41e88b8dd5a.png"></span>

            <p>商城介绍</p>

          </a>

        </li>      </ul>

    </div>

    <!-- 下分类完 -->
  <form action="<?php echo U('/Shop/Home/mend');?>" method="get" name="xxx"  id="search">  
	<input type="hidden" name="sousuo" value="sousuo">
		<input type="text" name="name" placeholder="输入商品名称" value="" id="sou" onFocus="this.placeholder=&#39;&#39;" onBlur="this.placeholder=&#39;搜索商品&#39;" >
			<div class="search_btn"><a href="javascript:document:xxx.submit();" ><img src="/Public/Public/images/icon_search1.png" /></a></div> 
			  <span><i class="iconfont"></i></span>
        </form>
    <!-- 最新动态 公告 -->
    <div class="notice">
      <div class="notice_left"><img src="/Public/Public/images/gg.jpg"></div>
      <div class="notice_right">
                <ul>
					<li>这是一条最新公告</li>
                </ul> 
      </div>
      <script type="text/javascript"> 
		  function autoScroll(obj){  
				$(obj).find("ul").animate({  
					marginTop : "-39px"  
				},700,function(){  
					$(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
				})  
			}  
			$(function(){  
				setInterval('autoScroll(".maquee")',5);
				setInterval('autoScroll(".notice_right")',2000);
			})       
	</script> 
    </div>
    <!-- 美丽人生 -->
    <div class="youxuan mlrs">
      <h3>
		<span>
			<img src="/Public/Public/images/ss1.png">
		</span>
			热门商品 
			<a href="<?php echo U('shop/Home/mend',array('sta'=>1));?>">
			<i><img src="/Public/Public/images/gd1.png"></i></a>
	 </h3>
        <?php if(!empty($hot_product_list)): ?><ul id="mlsr_b" style="background: #f5f5f5;text-align: center;">
		<?php if(is_array($hot_product_list)): foreach($hot_product_list as $key=>$v): ?><li>
				<a href="###">
				  <p style="margin-top:2vmin;"><?php echo ($v["name"]); ?></p>
				  <p class="mlsr_b" style="color:#ff0000;">￥：<?php echo ($v["price"]); ?></p>
				  <a href="<?php echo U('/Shop/Home/details',array('proid'=>$v['id']));?>">
				  <p><img src="<?php echo ($v["pic"]); ?>"></p></a>
				</a>
			</li><?php endforeach; endif; ?>
        </ul>
           <?php else: ?>
            <p>暂无热门商品哦,亲</p><?php endif; ?>
    </div>
    <!-- 美丽人生 -->

    <!-- 新鲜水果 -->

    <div class="youxuan zxsp_a">
      <h3>
		<span><img src="/Public/Public/images/ss2.png"></span>
			最新商品 
			<a href="<?php echo U('shop/Home/mend',array('sta'=>2));?>">
				<i><img src="/Public/Public/images/gd2.png"></i>
			</a>
	 </h3>
        <?php if(!empty($new_product_list)): ?></div>
        <style>
        .dil li{margin-left: 2.36vmin !important;}
        </style>
            <ul id="mlsr_b" class="abcd dil" style="    width: 96% !important;">
<?php if(is_array($new_product_list)): foreach($new_product_list as $ka=>$v2): if(($ka < 7) and ($ka > 0)): ?><li>
                    <a href="<?php echo U('/Shop/Home/details',array('proid'=>$v2['id']));?>">
                      <p style="margin-top:1.6vmin;"><?php echo ($v2["name"]); ?>）</p>
                      <p class="mlsr_b" style="color:#ff0000;">￥：<?php echo ($v2["price"]); ?></p>
                      <p><img src="<?php echo ($v2["pic"]); ?>"></p>
                    </a>
                </li>
                </else><?php endif; endforeach; endif; ?>
		</ul>
                     <?php else: ?>
            <p>暂无最新商品哦,亲</p><?php endif; ?>
    </div>

    <!-- 新鲜水果 -->

    <!-- 为您推荐 -->

    <div class="youxuan footers a_width">
        <h1>
            <span class="line-left"></span>
            <em style="margin-top:-22px; color:#f00; font-weight:250;"><img src="/Public/Public/images/fire.png" alt="">为您推荐</em>
            <span class="line-right"></span>

        </h1>
        <?php if(!empty($like_product_list)): ?><ul>
		<?php if(is_array($like_product_list)): foreach($like_product_list as $key=>$v): ?><li>
                <a href="<?php echo U('/Shop/Home/details',array('proid'=>$v['id']));?>" style=" display: block;float: left;">
                    <img src="<?php echo ($v["pic"]); ?>" alt="">
                    <div class="footers-rights">
                        <h2><?php echo ($v["name"]); ?></h2>
                        <p>
                            <strong>￥：<?php echo ($v["price"]); ?></strong>
                        </p>
                        <?php  $id['userid']=$v['shangjia']; $dianpu=M('gerenshangpu')->where($id)->find(); ?>

                    </div>

                    <i class="iconfont"></i>
                </a>
            </li><?php endforeach; endif; ?>

        </ul>
                 <?php else: ?>
            <p>暂无推荐商品哦,亲</p><?php endif; ?>
    </div>
	<div style="height:20vmin;float: left;display: block;width: 100%; background-color:#f5f5f5;"></div>

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