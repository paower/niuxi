<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>收益记录</title>
	<link rel="stylesheet" href="/Public/home/wap/css/style.css">
	<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
	<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css">	
	<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
	<script src="/Public/home/wap/js/iscroll.js"></script>
	<body class="bg96">
		<div class="header">
			<div class="header_l"><a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a></div>
			<div class="header_c">
				<h2>收益记录</h2>
			</div>
			<div class="header_r"><a href="javascript:" onclick="zhuanrang()">转让</a></div>
		</div>
		<style type="text/css">
			.yugejil1 {
				width: 100%;
				height: 40px;
				line-height: 40px;
			}

			.yugejil1 p {
				float: left;
				width: 24.3%;
				font-size: 14px;
				text-align: center;
			}

			.p23 {
				line-height: 40px;
			}

			#wrapper li p {
				float: left;
				width: 24.3%;
				font-size: 14px;
				text-align: center;
				color: #fff;
			}
		</style>
		<div class=" ">
			<div class="yugejil1">
				<p>业务类型</p>
				<p>数额</p>
				<p>当前余额</p>
				<p>时间</p>
			</div>
			<div id="wrapper">
				<div class="scroller">
					<ul>
						<?php if(is_array($Chan_info)): $i = 0; $__LIST__ = $Chan_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['get_type'] == 18): ?><li>
									<p>推广收益</p>
									<p>+<?php echo ($vo['get_nums']); ?></p>
									<p class="p23">
										<?php echo ($vo['now_nums']); ?>
									</p>
									<p class="p24"><?php echo (date("Y-m-d",$vo['get_time'])); ?></br><?php echo (date("H:i:s",$vo['get_time'])); ?></p>
								</li><?php endif; ?>
							<?php if($vo['get_type'] == 17): ?><li>
									<p>团队收益</p>
									<p>+<?php echo ($vo['get_nums']); ?></p>
									<p class="p23">
										<?php echo ($vo['now_nums']); ?>
									</p>
									<p class="p24"><?php echo (date("Y-m-d",$vo['get_time'])); ?></br><?php echo (date("H:i:s",$vo['get_time'])); ?></p>
								</li><?php endif; ?>
							<?php if($vo['get_type'] == 16): ?><li>
									<p>推广收益转让</p>
									<p>-<?php echo ($vo['get_nums']); ?></p>
									<p class="p23">
										<?php echo ($vo['now_nums']); ?>
									</p>
									<p class="p24"><?php echo (date("Y-m-d",$vo['get_time'])); ?></br><?php echo (date("H:i:s",$vo['get_time'])); ?></p>
								</li><?php endif; ?>
  							<?php if($vo['get_type'] == 24): ?><li>
									<p>转让退回</p >
									<p>+<?php echo ($vo['get_nums']); ?></p >
									<p class="p23">
										<?php echo ($vo['now_nums']); ?>
									</p >
									<p class="p24"><?php echo (date("Y-m-d",$vo['get_time'])); ?></br><?php echo (date("H:i:s",$vo['get_time'])); ?></p >
								</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
		<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
		<script>
			function zhuanrang(){
				if(<?php echo ($is_real_name); ?>==0){
					msg_alert('请先进行实名验证');
				}else{
					location.href = "<?php echo U('Trading/SellCentr');?>";
				}
			}
		</script>
	</body>
</html>