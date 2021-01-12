<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>选择支付宝</title>
	<link rel="stylesheet" href="/Public/home/wap/css/style.css">
	<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
	<link rel="stylesheet" href="/Public/home/wap/css/meCena.css">

	<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
	<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
	<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
	<body class="bg96">

		<div class="header">
			<div class="header_l">
				<a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
			</div>
			<div class="header_c">
				<h2>收款账号</h2>
			</div>
			<div class="header_r"></div>
		</div>

		<div class="big_width">
			<div class="pad10"></div>
			<?php if(empty($morecars3)): ?><div class="addBankCard">
					<a href="<?php echo U('Growth/Addbank',array('type'=>3));?>" class="clear_wl"><img src="/Public/home/wap/images/addyhk.png">
						<p>添加微信</p>
					</a>
				</div>
			<?php else: ?>
				<?php if(is_array($morecars3)): foreach($morecars3 as $key=>$v): ?><div class="myBankCard">
						<!-- <?php echo U('Growth/default_bank',array('id'=>$v['id']));?> -->
						<a href="javascript:void(0)" onclick="default_bank(<?php echo ($v['id']); ?>)" class="clear_wl">
							<img src="/Public/home/wap/images/wx.png">
							<div class="yhxx">
								<p><?php echo ($v['alipay_name']); ?></p>
								<p><?php echo ($v['alipay_number']); ?></p>
							</div>
						</a>
						<div class="myBankCard_snac">
							<?php if(($v['is_default']) == "1"): ?><a href="javascript:void(0);">默认</a><?php endif; ?>
							<a href="javascript:void(0)" onclick="deleteb(this)" data-id="<?php echo ($v['id']); ?>">删除</a>
						</div>
							
					</div><?php endforeach; endif; endif; ?>
			<?php if(empty($morecars)): ?><div class="addBankCard">
					<a href="<?php echo U('Growth/Addbank',array('type'=>1));?>" class="clear_wl"><img src="/Public/home/wap/images/addyhk.png">
						<p>添加支付宝</p>
					</a>
				</div>
			<?php else: ?>
				<?php if(is_array($morecars)): foreach($morecars as $key=>$v): ?><div class="myBankCard">
						<!-- <?php echo U('Growth/default_bank',array('id'=>$v['id']));?> -->
						<a href="javascript:void(0)" onclick="default_bank(<?php echo ($v['id']); ?>)" class="clear_wl">
							<img src="/Public/home/wap/images/zfb.png">
							<div class="yhxx">
								<p><?php echo ($v['alipay_name']); ?></p>
								<p><?php echo ($v['alipay_number']); ?></p>
							</div>
						</a>
						<div class="myBankCard_snac">
							<?php if(($v['is_default']) == "1"): ?><a href="javascript:void(0);">默认</a><?php endif; ?>
							<a href="javascript:void(0)" onclick="deleteb(this)" data-id="<?php echo ($v['id']); ?>">删除</a>
						</div>
				
					</div><?php endforeach; endif; endif; ?>	
			<?php if(empty($morecars2)): ?><div class="addBankCard">
					<a href="<?php echo U('Growth/Addbank',array('type'=>2));?>" class="clear_wl"><img src="/Public/home/wap/images/addyhk.png">
						<p>添加银行卡</p>
					</a>
				</div>
			<?php else: ?>
				<?php if(is_array($morecars2)): foreach($morecars2 as $key=>$v): ?><div class="myBankCard">
						<!-- <?php echo U('Growth/default_bank',array('id'=>$v['id']));?> -->
						<a href="javascript:void(0)" onclick="default_bank(<?php echo ($v['id']); ?>)" class="clear_wl">
							<img src="/Public/home/wap/images/<?php echo ($v["banq_img"]); ?>">
							<div class="yhxx">
								<p><?php echo ($v['alipay_name']); ?></p>
								<p><?php echo ($v['alipay_number']); ?></p>
							</div>
						</a>
						<div class="myBankCard_snac">
							<?php if(($v['is_default']) == "1"): ?><a href="javascript:void(0);">默认</a><?php endif; ?>
							<a href="javascript:void(0)" onclick="deleteb(this)" data-id="<?php echo ($v['id']); ?>">删除</a>
						</div>
				
					</div><?php endforeach; endif; endif; ?>
		</div>
	</body>
</html>
<script>
	function deleteb(e) {
		var bangid = $(e).attr('data-id');
		if (bangid == '') {
			msg_alert('请选择对应银行卡进行操作');
		}
		$.ajax({
			url: '/Growth/Cardinfos',
			type: 'post',
			data: {
				'bangid': bangid
			},
			datatype: 'json',
			success: function(mes) {
				if (mes.status == 1) {
					msg_alert(mes.message, mes.url);
				} else {
					msg_alert(mes.message);
				}
			}
		})
	}

	function default_bank(id) {
		if (id == '') {
			msg_alert('请刷新重试');
			return;
		}
		location.href="/Growth/edit_bank/id/" + id;
	}
</script>