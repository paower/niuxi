<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php if($type == 1): ?>添加支付宝<?php elseif($type == 2): ?>添加银行卡<?php endif; ?></title>
	<link rel="stylesheet" href="/Public/home/wap/css/style.css">
	<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
	<link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" /> 
	<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
	<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
	<script type="text/javascript" src="/Public/home/common/js/index.js"></script>
	<script type="text/javascript" src="/Public/home/wap/js/jquery.form.js"></script>
	<style>
	    .bus-list{padding-top:12px;}
	    .bus-list li{padding:12px;background-color:#2e0571;border-bottom:1px solid #3b1080;}
	    .bus-list li input{background-color:#2e0571;color:#eee;}
	    .bus-list li select{background-color:#2e0571;color:#eee;}
	    .bus-list li .set-file{position: absolute;left:0;right: 0;top:0;bottom: 0;opacity:0;}
	    .foot-btn {padding:12px;}
	    .foot-btn .btn{display: block;text-align: center;padding:12px;border-radius: 5px;background-color:#4c0db3;font-size:16px;}
		.getcode{position:absolute;top:-3px;right:0;background-color:#4c0db3;color:#fff;padding:5px 15px;border-radius:5px;}
	</style>
	<body class="bg96">
		<div class="header">
			<div class="header_l">
				<a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
			</div>
			<div class="header_c">
				<?php if($ubank['bank_type'] == 1): ?><h2>修改支付宝</h2>
				<?php elseif($ubank['bank_type'] == 2): ?>
					<h2>修改银行卡</h2>
				<?php elseif($ubank['bank_type'] == 3): ?>
					<h2>修改微信</h2><?php endif; ?>
			</div>
			<div class="header_r"></div>
		</div>
		
		<?php if($ubank['bank_type'] == 1): ?><div class="big_width100">
				<div class="tips">*请绑定本人的支付宝!</div>
				<form id='myupload' action="<?php echo U('Growth/edit_bank');?>" method='post' enctype='multipart/form-data'>
					<div class="add_bank_add_gr">
						<input name="type" value="1" type="hidden" />
						<input name="id" value="<?php echo ($ubank['id']); ?>" type="hidden" />
						<div class="fill_sty add_gr_b10">
							<p>姓名</p>
							<input type="text" value="<?php echo ($ubank['alipay_name']); ?>" name="alipay_name" placeholder="姓名" autocomplete="off" id="crkxm">
						</div>

						<!--支付宝号-->
						<div class="fill_sty add_gr_b10">
							<p>支付宝号</p>
							<input type="text" value="<?php echo ($ubank['alipay_number']); ?>" name="alipay_number" placeholder="支付宝号" autocomplete="off" id="yhk">
						</div>
						<div class="acco_con_upa">
							<h3>二维码</h3>
							<div class="shangcjt">
								<div class="containera"></div>
								<input type="file" id="photo" name="uploadfile" class="shangcanj">
							</div>
						</div>
					</div>
					<div class="buttonGeoup">
						<a href="#" class="not_next" id="confirm"><?php echo (L("termine")); ?></a>
					</div>
				</form>
			</div>
		<?php elseif($ubank['bank_type'] == 2): ?>
			<div class="fish-main">
				<form id='myupload2' action="<?php echo U('Growth/edit_bank');?>" method='post' enctype='multipart/form-data'>
			        <ul class="bus-list">
						<input name="type" value="2" type="hidden" />
						<input name="id" value="<?php echo ($ubank['id']); ?>" type="hidden" />
			            <li class="clearfix">
			                <div class="col-3">银行名称</div>
			                <div class="inp--field col s9">
			                    <select class="initialized" name="bank_name">
									<?php if(is_array($bakinfo)): $i = 0; $__LIST__ = $bakinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option 
										<?php
 if($ubank['card_id'] == $vo['q_id']){ echo 'selected="selected"'; } ?>
										 value="<?php echo ($vo["q_id"]); ?>"><?php echo ($vo["banq_genre"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			                    </select>
			                </div>
			            </li>
			            <li class="clearfix">
			                <div class="col-3">银行卡姓名</div>
			                <div class="col-9"><input type="text"  value="<?php echo ($ubank['alipay_name']); ?>" placeholder="请输入银行卡姓名" name="alipay_name"></div>
			            </li>
			            <li class="clearfix">
			                <div class="col-3">银行卡账号</div>
			                <div class="col-9"><input type="text" value="<?php echo ($ubank['alipay_number']); ?>"  placeholder="请输入银行卡账号" name="alipay_number"></div>
			            </li>
			            <li class="clearfix">
			                <div class="col-3">开户支行</div>
			                <div class="col-9"><input type="text" value="<?php echo ($ubank['bank_name2']); ?>" placeholder="请输入开户支行" name="bank_name2"></div>
			            </li>
			        </ul>
			    </form>
			    <div class="buttonGeoup">
					<a href="#" class="not_next" id="confirm2">提交</a>
			    </div>
			</div>
		<?php elseif($ubank['bank_type'] == 3): ?>
			<div class="big_width100">
				<div class="tips">*请绑定本人的微信!</div>
				<form id='myupload3' action="<?php echo U('Growth/edit_bank');?>" method='post' enctype='multipart/form-data'>
					<div class="add_bank_add_gr">
						<input name="type" value="3" type="hidden" />
						<input name="id" value="<?php echo ($ubank['id']); ?>" type="hidden" />
						<div class="fill_sty add_gr_b10">
							<p>昵称</p>
							<input type="text" name="alipay_name" value="<?php echo ($ubank['alipay_name']); ?>" placeholder="昵称" autocomplete="off" id="crkxm">
						</div>
			
						<!--支付宝号-->
						<div class="fill_sty add_gr_b10">
							<p>微信号</p>
							<input type="text" name="alipay_number" value="<?php echo ($ubank['alipay_number']); ?>" placeholder="微信号" autocomplete="off" id="yhk">
						</div>
						<div class="acco_con_upa">
							<h3>二维码</h3>
							<div class="shangcjt">
								<div class="containera"></div>
								<input type="file" id="photo" name="uploadfile" class="shangcanj">
							</div>
						</div>
					</div>
					<div class="buttonGeoup">
						<a href="#" class="not_next" id="confirm3">提交</a>
					</div>
				</form>
			</div><?php endif; ?>
		<!-- 提示不能为空 -->
		<script type="text/javascript">
			$('#confirm').click(function() {
				var old = $(this);
				$("#myupload").ajaxSubmit({
					dataType: 'json', //数据格式为json
					success: function(data) {
						if (data.status == 1) {
							msg_alert(data.message, data.url);
						} else {
							msg_alert(data.message);
						}
					},
					error: function(xhr) { //上传失败
						msg_alert(data.message);
					}
				});
			});
			
			$('#confirm2').click(function() {
				$("#myupload2").ajaxSubmit({
					dataType: 'json', //数据格式为json
					success: function(data) {
						if (data.status == 1) {
							msg_alert(data.message, data.url);
						} else {
							msg_alert(data.message);
						}
					},
					error: function(xhr) { //上传失败
						msg_alert(data.message);
					}
				});
			});
			
			$('#confirm3').click(function() {
				var old = $(this);
				$("#myupload3").ajaxSubmit({
					dataType: 'json', //数据格式为json
					success: function(data) {
						if (data.status == 1) {
							msg_alert(data.message, data.url);
						} else {
							msg_alert(data.message);
						}
					},
					error: function(xhr) { //上传失败
						msg_alert(data.message);
					}
				});
			});


			$('.shangcanj').change(function(e) {
				var old_this = $(this);
				var files = this.files;
				var img = new Image();
				var reader = new FileReader();
				reader.readAsDataURL(files[0]);
				reader.onload = function(e) {
					var dx = (e.total / 1024) / 1024;
					if (dx >= 10) {
						alert("文件不能大于10M");
						return;
					}
					img.src = this.result;
					img.style.width = "100%";
					img.style.height = "90%";
					img.id = 'uploadImg';
					old_this.parents('form').find('.containera').html(img);
				}
			})
		</script>


		<script src="/Public/home/wap/js/ansel_select.js"></script>
		<!--input  type="checkbox"  美化 -->
		<script>
			function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){
                $(this).parent('label').addClass('c_on');
            });
        };
        if ($('.label_radio input').length) {    /////
            $('.label_radio').each(function(){
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){
                $(this).parent('label').addClass('r_on');
            });
        };
    };
    $(document).ready(function(){
        $('body').addClass('has-js');
        $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel();
    });

</script>
<script>
			//插件初始化配置
    $('.select').anselcfg({});
</script>
	</body>

</html>