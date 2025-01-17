<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta charset="UTF-8" />
		<title>纽西之谜</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="format-detection" content="telephone=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" />
		<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
		<style>
			.head-tit {
				font-weight: bold;
			}

			.logo {
				background-image: url('/fish/img/logo.png');
				margin-right: 5px;
				vertical-align: -4px;
			}

			.fish-notice {
				padding: 6px 0;
				background: #0D1414;
				margin-top: -1px;
				/*opacity: 0.6;	*/
			}

			.fish-notice .notice_box {
				display: none;
			}

			.fish-notice .notice_box.notice_show {
				display: block;
			}

			.fish-notice .notice li a {
				color: #fff;
			}

			.notice-wrap {
				height: 22px;
				overflow: hidden;
			}

			.notice-wrap li {
				overflow: hidden;
				white-space: nowrap;
				text-overflow: ellipsis;
			}

			.icon-notice {
				
				height: 14px;
				width: 14px;
				margin-right: 5px;
			}

			.fish-banner {
				position: relative;
				padding: 12px;
			}

			.swipe {
				overflow: hidden;
				visibility: hidden;
				position: relative;
				max-height: 156px;
			}

			.swipe-wrap {
				overflow: hidden;
				position: relative;
			}

			.swipe-wrap>.swipe-item {
				float: left;
				width: 100%;
				position: relative;
			}

			.swipe-wrap>.swipe-item img {
				display: block;
				width: 100%;
				max-height: 156px;
				border-radius: 8px;
			}

			.swipe-dot {
				overflow: hidden;
				text-align: right;
				position: absolute;
				bottom: 0;
				left: 0;
				width: 100%;
				margin: 0;
				padding: 0;
				padding: 12px 20px;
			}

			.swipe-dot li {
				box-sizing: border-box;
				border-radius: 50%;
				height: 8px;
				width: 8px;
				margin: 0 4px;
				display: inline-block;
				background-color: #ccc;
			}

			.swipe-dot li.act {
				background-color: #7f10c7;
			}

			.fish-list {
				position: relative;
				display: none;
			}

			.fish-list.list_show {
				display: block;
			}

			.fish-list .fish-info {
				margin-top: 15px;
			}

			.fish-list .fish_bg {
				background: #BB9EF0;
				position: absolute;
				width: 100%;
				height: 92%;
				overflow: hidden;
				opacity: 0.2;
				border-radius: 8px;
			}

			.fish-list li {
				margin: 0 12px 8px;
				position: relative;
				padding: 12px 0;
			}


			.fish-list li .fish-img img {
				width: 89%;
				max-width: 124px;
				display: block;
				margin: 0 5px;
				margin-top: 10px;
				border-radius: 15px;
			}

			.fish-list li .info-title {
				color: #d091ef;
				font-size: 16px;
			}

			.fish-list li .info-item {
				color: #ccc;
				font-size: 12px;
			}

			.fish-list li .info-item span {
				color: #fff;
			}

			.fish-list li .list-btn {
				display: block;
				
				width: 38px;
				text-align: center;
				height: 115px;
				margin: auto;
				font-size: 16px;
				padding-top: 30px;
				line-height: 1.2em;
			}

			.fish-list li .list-btn.gray {
				background: #8e4ef7;
				padding-top: 30px;
				top: 0px;
				right: 10px;
				color: #d6d4d4;
			}

			.fish-list li .grow {
				background: url(/fish/img/fish-list-grow.png) no-repeat center center;
				background-size: 100% 100%;
				position: absolute;
				right: 1px;
				top: 12px;
				border-radius: 0;
				padding-top: 30px;
				width: 76px;
				height: 76px;
			}



			.success-btn {
				display: inline-block;
				background-color: #00D6E2;
				color: #FFEA59;
				border: 2px solid #FFEA59;
				font-size: 24px;
				padding: 5px 24px;
				border-radius: 25px;
			}

			.success-img {
				position: absolute;
			}


			.status_ion {
				display: none;
			}

			.status_ion.status_show {
				display: block;
			}

			.status_ion .status_bg {
				background: #1a141e;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				opacity: 0.6;
				z-index: 1000;
			}

			.status_ion .status_img {
				position: fixed;
				top: 50%;
				left: 0%;
				z-index: 1001;
				width: 100%;
				text-align: center;
				margin-top: -210px;
			}

			.status_ion .status_img img{  width: 248px;}

			.status_ion .wait {
				   position: fixed;
					top: 50%;
					left: 0%;
					z-index: 1001;
					width: 100%;
					text-align: center;
					margin-top: -145px;
			}


			.status_ion .status_img .status_sub {
				background: #9366fa;
				width: 80%;
				height: 37px;
				line-height: 37px;
				font-size: 18px;
				text-align: center;
				border-radius: 40px;
				margin: 26px auto 0;
			}

			.act_box {
				position: relative;
				margin-top: 15px;
			}



			@keyframes scroll {
				0% {
					-webkit-transform: translateY(0px);
					transform: translateY(0px);
				}

				20% {
					-webkit-transform: translateY(0px);
					transform: translateY(0px);
				}

				25% {
					-webkit-transform: translateY(-30px);
					transform: translateY(-30px);
				}

				45% {
					-webkit-transform: translateY(-30px);
					transform: translateY(-30px);
				}

				50% {
					-webkit-transform: translateY(-60px);
					transform: translateY(-60px);
				}

				70% {
					-webkit-transform: translateY(-60px);
					transform: translateY(-60px);
				}

				75% {
					-webkit-transform: translateY(-90px);
					transform: translateY(-90px);
				}

				95% {
					-webkit-transform: translateY(-90px);
					transform: translateY(-90px);
				}

				100% {
					-webkit-transform: translateY(-120px);
					transform: translateY(-120px);
				}
			}

			.sbox {
				height: 30px;
				overflow: hidden;
			}

			.sbox .sconten {
				height: 100%;
				width: 100%;
				animation: mymove 10s infinite;
				-webkit-animation: scroll 10s infinite;
			}

			.sbox .sconten .line {
				line-height: 30px;
				height: 30px;
				margin: 0;
				padding: 0;
			}


			.queren_box {
				display: none;
			}

			.queren_box.show {
				display: block;
			}

			.queren_bg {
				position: fixed;
				z-index: 99;
				top: 0px;
				left: 0;
				bottom: 0;
				right: 0;
				height: 100%;
				width: 100%;
				background: #000;
				opacity: 0.5;
			}

			.queren_box .queren_con {
				z-index: 100;
				position: fixed;
				top: 0;
				left: 0;
				margin-left: 0px;
				margin-top: 0px;
				bottom: 0;
				right: 0;
				height: 100%;
				width: 100%;
				text-align: center;
			}

			.queren_box .queren_con .queren_conin {
				position: fixed;
				top: 50%;
				left: 50%;
				margin-left: -100px;
				margin-top: -35px;
				background: #43454b;
				width: 200px;
				height: 70px;
			}

			.queren_box .queren_con .queren_conin .title {
				padding-top: 15px;
				color: #fafafa;
			}

			.queren_box .queren_con .queren_conin .sub {
				padding-top: 25px;
				color: #fb3838;
			}

			.queren_box .queren_con .queren_conin .sub span {
				padding: 2px 10px;
				border: 1px solid #fb3838;
			}
			.wait img{  width: 280px;}
		</style>

		<!-- js -->
		<script src="/Public/home/wap/js/vue.min.js"></script>
		<script src="/Public/home/wap/js/jquery.min.js"></script>
		<script src="/Public/home/wap/js/core.js"></script>
	</head>
	<body>
		<div id="app">
			<div class="fish-head">
				<h3 class="head-tit"><span>纽西之谜</span></h3>
			</div>
			<div class="fish-main">
				<div class="fish-notice clearfix">
					<div class="fl" style="text-align: center; padding-left: 12px; margin-top: 5px;">
						<i class="icon icon-notice"></i>公告：
					</div>
					<div class="notice_box notice_show">
						<div class="col-9 notice-wrap sbox">
							<ul class="notice sconten">
								<?php if(is_array($newinfo)): foreach($newinfo as $key=>$v): ?><li class="line"><a href="<?php echo U('User/Newsdetail',array('nid'=>$v['id']));?>"><?php echo ($v['title']); ?></a></li><?php endforeach; endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="fish-banner">
					
					<div class="slider">
						<ul class="slides">
							<?php if(is_array($pic_array)): foreach($pic_array as $key=>$vo): ?><li class="slide swipe-item" style="height: 160px">
									<div class="box" ><a href="<?php echo ($vo['href']); ?>"><img src="/Uploads/<?php echo ($vo['picture']); ?>" alt="<?php echo ($vo['title']); ?>" style="padding: 0;border-radius: 5px"></a></div>
								</li><?php endforeach; endif; ?>
						</ul>
					</div>
				</div>

				<ul class="fish-list list_show">
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="clearfix">
							<div class="fish_bg"></div>
							<div class="col-4 fish-img">
								<img src="/Uploads/<?php echo ($vo["scroll_image"]); ?>" alt="" />
							</div>
							<div class="col-6 fish-info">
								<h3 class="info-title text-ellipsis"><?php echo ($vo['title']); ?></h3>
								<div class="info-item">
									价值：
									<span><?php echo ($vo['value_region']); ?></span><!-- <?php echo ($vo['sell_num']); ?> -->

								</div>
								<div class="info-item">
									抢购时间：
									<span><?php echo ($vo['start_time']); ?>-<?php echo ($vo['end_time']); ?></span>
								</div>
								<div class="info-item">
									预约/抢购消耗积分：
									<span><?php echo ($vo['book_consume']); ?>/<?php echo ($vo['rush_consume']); ?></span>
								</div>
								<div class="info-item">
									智能合约收益：
									<span style="color: red; font-weight: bold;"><?php echo ($vo['profit_day']); ?>天/<?php echo ($vo['profit_value']*100); ?>%</span><!-- <?php echo ($vo['reward_num']+0); ?> -->
									<div class="info-item">
										收藏消耗积分：
										<span><?php echo ($vo['feed_consume']); ?></span>
									</div>
									<div class="info-item">
										倒计时：
                    					<span class="countdown" date-time="<?php echo ($vo["daojishi"]); ?>">0时00分00秒</span>
									</div>
								</div>
							</div>
							<div class="col-2 act_box">
								<?php if($vo["state"] == 1): ?><a href="javascript:;" class="list-btn gray" onclick="yyue(<?php echo ($vo["id"]); ?>)">预<br /><br />约</a> 
								<?php elseif($vo["state"] == 2): ?>
									<a href="javascript:;" onclick="adopt(<?php echo ($vo["id"]); ?>)" class="list-btn gray">收<br /><br />藏</a> 
								<?php elseif($vo["state"] == 3): ?> 
									<a href="javascript:;" class="list-btn gray">等<br />待<br />中</a>
								<?php elseif($vo["state"] == 4): ?> 
									<a href="javascript:;" class="list-btn gray">预<br />约<br />中</a><?php endif; ?>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="dialog-bottom">
					更多种类，敬请期待
				</div>
			</div>
			<div class="status_ion" style="display: none;">
				<div class="status_bg"></div>
				<div class="wait" style="display: none;">
					<img src="/Public/home/eps8743.gif" />
				</div>
				<div class="status_img fail" style="display: none;">
					<img src="/Public/home/fail.png" />
					<div class="status_sub" onclick="guanbi()">
						关闭
					</div>
				</div>
				<div class="status_img success" style="display: none;">
					<img src="/Public/home/success.png" />
					<div class="status_sub">
						<a href="/Index/adoption.html"> 支付 </a>
					</div>
				</div>
			</div>
		
			<div style="height: 50px;"></div>
			<div class="fish-foot clearfix">
				<a href="<?php echo U('Index/index');?>" class="col-4 act">
					<i class="layui-icon layui-icon-star" style="font-size: 23px;display: block; color: #f727ef;"></i>
					<span>纽西之谜</span>
				</a>
				<a href="<?php echo U('Index/pond');?>" class="col-4">
					<i class="layui-icon layui-icon-chart" style="font-size: 23px;display: block; color: #f727ef;"></i>
					<span>已购产品</span>
				</a>
				<a href="<?php echo U('User/Personal');?>" class="col-4">
					<i class="layui-icon layui-icon-username" style="font-size: 23px;display: block; color: #f727ef;"></i>
					<span>我的</span>
				</a>
			</div>
		</div>
		<!-- js -->
		<script type="text/javascript" src="/Public/home/wap/js/jquery.glide.min.js"></script>
		<script>
			$(function(){
				$('.countdown').each(function () {	//countdown是显示时间元素
					let setTimer = null;
					let Time = $(this).attr('date-time'); //获取每个倒计时的总秒数
					if(Time<0 || Time>120){
						$(this).parent().hide();
					}
					let obj = $(this);
					// console.log(Time);
					setTimer = setInterval(function () {
						Time--;
						if(Time>=0){
							timer(Time, setTimer, obj);
						}
					}, 1000);
				})
			})
			function timer(Time, setTimer,obj) {
				if (Time > 0) {
					let int = null;
					let $time = obj;
					Time--;
					// console.log(Time);
					let days = parseInt((Time / 3600) / 24); //计算剩余的天数 
					let hours = parseInt((Time / 3600) % 24); //计算剩余的小时 
					let minutes = parseInt((Time / 60) % 60); // 分
					let seconds = parseInt((Time % 60)); // 秒

					function checkTime(i) { //将0-9的数字前面加上0\.  1变为01
						if (i < 10) {
							return '0' + i;
						} else {
							return i;
						}
					}

					days = checkTime(days);
					hours = checkTime(hours);
					minutes = checkTime(minutes);
					seconds = checkTime(seconds);

					$time.html(`${days}:${hours}:${minutes}:${seconds}`);
				} else {
					clearInterval(setTimer);
					let $time = $('.countdown').html(`预约结束`);
					setTimeout(function(){window.location.reload();},1000);
					
				}
			}
			//收藏
			function adopt(id){
				$('.status_ion').css('display','inline');
				// <!-- $('.wait').css('display','inline'); -->
				$.ajax({
					type:'post',
					url:"<?php echo U('Index/adpot');?>",
					data:{id:id},
					success:function(msg){
						//console.log(msg);
						if(msg.Boolean){
							// <!-- setTimeout(function(){ -->
							// 	<!-- $('.wait').css('display','none'); -->
							// <!-- },5000); -->
							setTimeout(function(){
								$('.success').css('display','inline');
							},)
						}else{
							
							// <!-- setTimeout(function(){ -->
							// 	<!-- $('.wait').css('display','none'); -->
							// <!-- },5000); -->
							setTimeout(function(){
								if(msg.code==99){
									core.toast(msg.text);
								}
								$('.fail').css('display','inline');
							},)
						}
					}
				});
				
			}
			function yyue(id){
				// $('.status_ion').css('display','inline');
				// $('.wait').css('display','inline');
				$.ajax({
					type:'post',
					url:"<?php echo U('Index/yyue');?>",
					data:{id:id},
					success:function(msg){
						if(msg.Boolean){
							// <!-- setTimeout(function(){ -->
							// 	<!-- $('.wait').css('display','none'); -->
							// 	<!-- $('.status_ion').css('display','none'); -->
							// <!-- },5000); -->
							setTimeout(function(){
								core.toast(msg.text);
							},);
							
						}else{
							// <!-- setTimeout(function(){ -->
							// 	<!-- $('.wait').css('display','none'); -->
							// 	<!-- $('.status_ion').css('display','none'); -->
							// <!-- },5000); -->
							setTimeout(function(){
								core.toast(msg.text);
							},);
						}
					}
				});
			}
			function guanbi(){
				$('.status_ion').css('display','none');
				location.reload();
			}
		</script>
		<script type="text/javascript">
    var glide = $('.slider').glide({
        //autoplay:true,//是否自動播放 默認值 true如果不需要就設置此值
        animationTime:500, //動畫過度效果，只有當瀏覽器支持CSS3的時候生效
        arrows:false, //是否顯示左右導航器
        arrowsWrapperClass: "arrowsWrapper",//滑塊箭頭導航器外部DIV類名
        arrowMainClass: "slider-arrow",//滑塊箭頭公共類名
        arrowRightClass:"slider-arrow--right",//滑塊右箭頭類名
        arrowLeftClass:"slider-arrow--left",//滑塊左箭頭類名
        arrowRightText:">",//定義左右導航器文字或者符號也可以是類
        arrowLeftText:"<",

        nav:true, //主導航器也就是本例中顯示的小方塊
        navCenter:true, //主導航器位置是否居中
        navClass:"slider-nav",//主導航器外部div類名
        navItemClass:"slider-nav__item", //本例中小方塊的樣式
        navCurrentItemClass:"slider-nav__item--current" //被選中後的樣式
    });
</script>
	</body>
</html>