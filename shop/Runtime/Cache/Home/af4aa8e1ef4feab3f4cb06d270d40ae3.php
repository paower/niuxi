<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<title><?php echo (L("Setup")); ?></title>
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">
<link rel="stylesheet" href="/Public/home/wap/css/reset.css"> 
<link rel="stylesheet" href="/Public/home/wap/css/uploads.css">
<link rel="stylesheet" href="/Public/home/wap/css/normalize.css">
<link rel="stylesheet" href="/Public/home/wap/css/wen.css">
<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/Public/home/common/layer/layer.js"></script>
<script type="text/javascript" src="/Public/home/common/js/index.js" ></script>
<script type="text/javascript" src="/Public/home/wap/js/upload.js"></script>
<link rel="stylesheet" href="/Public/home/wap/layui-v2.4.5/css/layui.css" >
<style>
	body{
    background: #327585;
	}
	.sett_xiug{display:none;}
	.button,#clipBtn{width: 130px;font-size: 16px;}
</style>
<body>
    <div class="user-top">
		<div class="user-head" id="logox"><img id="bgl" src="/Public/home/wap/heads/<?php echo ($uinfo['img_head']); ?>"/></div>
		<div class="user_dt">
			<p>用户名:<?php echo ($uinfo['username']); ?></p>
			<p>手机:<?php echo ($uinfo['mobile']); ?></p>
			<p>级别:<?php if($uinfo['vip_grade'] == 1 OR $uinfo['vip_grade'] == 0): ?>普通会员
							<?php elseif($uinfo['vip_grade'] == 2): ?> 初级会员
							<?php elseif($uinfo['vip_grade'] == 3): ?>中级会员
							<?php elseif($uinfo['vip_grade'] == 4): ?>高级会员<?php endif; ?></p>
		</div>
		<div class="personal-index-top">
	  	 <a href="<?php echo U('User/setting');?>" class="personal-top-right">
	  	 	<img src="/Public/home/wap/images/setup.png" alt="">
	  	 </a>
	  </div>
    </div>
	<div class="centBalance general_information generalin01">
			<div class="Balance">
				<a href="<?php echo U('Index/Bancerecord');?>">
					<strong><span  class="total_ls"><?php echo (sprintf("%.2f",$uinfo['total_lingshi']+0)); ?></span></strong>
						<p>购物券</p>
				</a>
			</div>
			
			<div class="Balance">
				<a href="<?php echo U('Index/activeRecord');?>">
						<strong><span  class="activity"><?php echo (sprintf("%.2f",$uinfo['total_active']+$push_active)); ?></span></strong>
						<p>星座收益</p>
				</a>
			</div>
			
			<div class="Balance">
				<a href="<?php echo U('Index/extension');?>">
						<strong><span  class="userteam"><?php echo (sprintf("%.2f",$uinfo['total_tuiguang']+0)); ?></span></strong>
						<p>推广收益</p>
				</a>
			</div>
			
			<div class="Balance">
				<a href="<?php echo U('Index/geo_details');?>">
						<strong><span  class="userteam"><?php echo (sprintf("%.2f",$uinfo['geo']+0)); ?></span></strong>
						<p>GEO</p>
				</a>
			</div>
	</div>
		
    <div class="setlistbox">
		<ul class="user_categories">
			<li><a href="<?php echo U('Index/adoption');?>">
                    <img src="/Public/home/wap/images/set01.png" alt="">
                    <p>抢购记录</p>
            </a></li>
            <li><a href="<?php echo U('Index/transfer');?>">
                    <img src="/Public/home/wap/images/set02.png" alt="">
                    <p>转让记录</p>
            </a></li>
            <li><a href="<?php echo U('Index/appointment');?>">
                    <img src="/Public/home/wap/images/set03.png" alt="">
                    <p>预约记录</p>
            </a></li>
            
        </ul>
        <ul class="user_categories">
			<li><a href="<?php echo U('User/team_statistics');?>">
                    <img src="/Public/home/wap/images/cen10-iocn.png" alt="">
                    <p>我的团队</p>
            </a></li>
			<li><a href="<?php echo U('User/Sharecode');?>">
                    <img src="/Public/home/wap/images/cen11-iocn.png" alt="">
                    <p>推广中心</p>
			</a></li>
			<li class="righline"><a href="<?php echo U('User/real_name');?>">
					<img src="/Public/home/wap/images/chengg.png" alt="">
					<p>实名认证</p>
			</a></li>
		</ul>
		<ul class="user_categories">
			
			
            <li><a href="<?php echo U('User/customer_service');?>">
                    <img src="/Public/home/wap/images/jiaoy03-iocn.png" alt="">
                    <p>客服中心</p>
            </a></li>
			<li><a href="<?php echo U('User/News',array('type'=>1));?>">
                    <img src="/Public/home/wap/images/sett14-icon.png" alt="">
                    <p>公告</p>
			</a></li>
			<li class="righline"><a href="<?php echo U('User/Complaint');?>">
                <img src="/Public/home/wap/images/set003.png" alt="">
                <p>投诉建议</p>
            </a></li>
		</ul>
		
    </div>
	<div class="fish-foot clearfix">
		<a href="<?php echo U('Index/index');?>" class="col-4">
			<i class="layui-icon layui-icon-star" style="font-size: 23px;display: block; color: #f727ef;"></i>
			<span>纽西之谜</span>
		</a> 
		<a href="<?php echo U('Index/pond');?>" class="col-4 ">
			<i class="layui-icon layui-icon-chart" style="font-size: 23px;display: block; color: #f727ef;"></i>
			<span>已购产品</span>
		</a> 
		<a href="<?php echo U('User/Personal');?>" class="col-4 act">
			<i class="layui-icon layui-icon-username" style="font-size: 23px;display: block; color: #f727ef;"></i>
			<span>我的</span>
		</a>
   </div>
       
</body>
</html>

<!--头像上传新SSSSS-->
	<script src="/Public/home/wap/jsa/jquery.min.js" type="text/javascript"></script>
	<script>window.jQuery || document.write('<script src="/Public/home/wap/jsa/jquery-2.1.1.min.js"><\/script>')</script>
	<script src="/Public/home/wap/jsa/iscroll-zoom.js"></script>
	<script src="/Public/home/wap/jsa/hammer.js"></script>
	<script src="/Public/home/wap/jsa/jquery.photoClip.js"></script>
	<script type="text/javascript" src="/Public/home/wap/js/jquery.form.js"></script>

	<script>
		var obUrl = ''
		//document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
		$("#clipArea").photoClip({
			width: 320,
			height: 320,
			file: "#file",
			view: "#view",
			ok: "#clipBtn",
			loadStart: function() {
				console.log("照片读取中");
			},
			loadComplete: function() {
				console.log("照片读取完成");
			},
			clipFinish: function(dataURL) {
				// console.log(dataURL);
			}
		});


		$(function(){
			$("#logox").click(function(){
				$(".htmleaf-container").show();
			})
			$("#clipBtn").click(function(){
			    //数据流上传开始执行图片上传
				$.ajax({
					url:'/User/imgUps',
					type:'post',
					data:{'dataflow':imgsource},
					datatype:'json',
					success:function (data) {
						if(data.status == 1){
                            $("#logox").empty();
                            $('#logox').append('<img src="' + imgsource + '" align="absmiddle" style=" width:60px;height: 60px;">');
                            $(".htmleaf-container").hide();
                            msg_alert(data.message);
                        }else{
						    msg_alert(data.message);
						}
                    }
				})
			})
		});
	</script>
	<script type="text/javascript">
		$(function(){
			jQuery.divselect = function(divselectid,inputselectid) {
				var inputselect = $(inputselectid);
				$(divselectid+" small").click(function(){
					$("#divselect ul").toggle();
					$(".mask").show();
				});
				$(divselectid+" ul li a").click(function(){
					var txt = $(this).text();
					$(divselectid+" small").html(txt);
					var value = $(this).attr("selectid");
					inputselect.val(value);
					$(divselectid+" ul").hide();
					$(".mask").hide();
					$("#divselect small").css("color","#333")
				});
			};
			$.divselect("#divselect","#inputselect");
		});
	</script>
	<script type="text/javascript">
		function setImagePreview() {
			var preview, img_txt, localImag, file_head = document.getElementById("file_head"),
				picture = file_head.value;

			if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("您上传的图片格式不正确，请重新选择！"),
				!1;
			if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) preview.style.display = "block",
				preview.style.width = "63px",
				preview.style.height = "63px",
				preview.src = window.navigator.userAgent.indexOf("Chrome") >= 1 || window.navigator.userAgent.indexOf("Safari") >= 1 ? window.webkitURL.createObjectURL(file_head.files[0]) : window.URL.createObjectURL(file_head.files[0]);
			else {
				file_head.select(),
					file_head.blur(),
					img_txt = document.selection.createRange().text,
					localImag = document.getElementById("localImag"),
					localImag.style.width = "63px",
					localImag.style.height = "63px";
				try {
					localImag.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)",
						localImag.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = img_txt
				} catch(f) {
					return alert("您上传的图片格式不正确，请重新选择！"),
						!1
				}
				preview.style.display = "none",
					document.selection.empty()
			}
			return document.getElementById("DivUp").style.display = "block",
				!0
		}
	</script>
<!--头像上传新EEEEE-->
</script>