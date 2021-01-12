<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>我的团队</title>
<link rel="stylesheet" href="/Public/home/wap/css/style.css">
<link rel="stylesheet" href="/Public/home/wap/css/meCen.css">

<body class="bg96">

<div class="header">
    <div class="header_l">
        <a href="javascript:history.go(-1)"><img src="/Public/home/wap/images/jiant.png" alt=""></a>
    </div>
    <div class="header_c"><h2>我的团队</h2></div>
    <div class="header_r"></div>
</div>

<div class="big_width100 por" style="margin-top:0px;">
	<div class="share_ul" style="height: 120px">
		<div class="share_ul_l">
			<img style="margin-top:20px;" src="/Public/home/wap/heads/<?php echo ($info['img_head']); ?>" alt="">
			<div class="share_p">
				<p><?php echo ($info['username']); ?><span><?php if($info['is_real_name'] == 1): ?>(已实名)<?php else: ?>(未实名)<?php endif; ?></span></p>
				<p>UID:<?php echo ($info['userid']); ?>
					<?php if($info['vip_grade'] == 0 ): ?><span>暂无
						<?php elseif($info['vip_grade'] == 1 OR $info['vip_grade'] == 0): ?> <span class=" dengjxiasa">普通会员
						<?php elseif($info['vip_grade'] == 2): ?><span class=" dengjxiasa">一星会员
						<?php elseif($info['vip_grade'] == 3): ?><span class=" dengjxiasa">二星会员
						<?php elseif($info['vip_grade'] == 4): ?><span class=" dengjxiasa">三星会员
						<?php elseif($info['vip_grade'] == 5): ?><span class=" dengjxiasa">四星会员<?php endif; ?>
					</span>
				</p>
				<p>手机:<?php echo ($info['mobile']); ?></p>
				<p>直推有效人数:<?php echo ($son); ?></p>
				<p>团队人数:<?php echo ($team_num); ?></p>
				<p>团队有效人数:<?php echo ($team_vip_num); ?></p>
				<p>累计收益:<?php echo ($info['all_sy']); ?></p>
			</div>
		</div>
    </div>

    <!-- <form action="<?php echo U('User/Teamdets');?>" method="post" style="margin-top:7px"> -->
        <!-- <div class="zySearch"> -->
            <!-- <input id="searchInput" name="uinfo" class="search-input" value="<?php echo ($uinfo); ?>" type="text" placeholder="搜索UID/手机号码"> -->
            <!-- <button class="search-btn btn">搜索</button> -->
        <!-- </div> -->
    <!-- </form> -->

    <?php if(is_array($muinfo)): foreach($muinfo as $key=>$v): ?><div class="share_ul">
			<div class="share_ul_l">
				<img src="/Public/home/wap/heads/<?php echo ($v['img_head']); ?>" alt="">
				<div class="share_p">
					<p><?php echo ($v['username']); ?><span><?php if($v['is_real_name'] == 1): ?>(已实名)<?php else: ?>(未实名)<?php endif; ?></span></p>
					<p>UID:<?php echo ($v['userid']); ?>
						<?php if($v['vip_grade'] == 0 ): ?><span>暂无
							<?php elseif($v['vip_grade'] == 1 OR $v['vip_grade'] == 0): ?> <span class=" dengjxiasa">普通会员
							<?php elseif($v['vip_grade'] == 2): ?><span class=" dengjxiasa">一星会员
							<?php elseif($v['vip_grade'] == 3): ?><span class=" dengjxiasa">二星会员
							<?php elseif($v['vip_grade'] == 4): ?><span class=" dengjxiasa">三星会员
							<?php elseif($v['vip_grade'] == 5): ?><span class=" dengjxiasa">四星会员<?php endif; ?>
						</span>
					</p>
					<p>手机:<?php echo ($v['mobile']); ?></p>
				</div>
			</div>
			<div class="shijin">
				<p><span></span></p>
				<span><?php echo (date("Y-m-d H:i:s",$v['reg_date'])); ?></span>
			</div>
				
        </div><?php endforeach; endif; ?>
    </div>
</div>
</body>
</html>