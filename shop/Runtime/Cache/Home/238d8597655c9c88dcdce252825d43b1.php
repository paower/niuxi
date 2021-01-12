<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>抢购记录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" /> 
	
<style>
    .ado-list li{margin-top:12px;color:#ccc;border-bottom:1px solid #a2a2a2;}
    .ado-list li .list-top{padding:12px;}
    .ado-list li .list-box{padding:12px;}
    .ado-list li .list-box h3{font-size:16px;color:#fff;margin-bottom:5px;}
    .ado-list li .list-box .list-item span{margin-left:5px;}
    .ado-list li .list-box .list-item .btn{display:inline-block;background:#7f10c7;color:#fff;padding:5px 20px;border-radius:5px;margin-top:-5px}
    .ado-list li .list-box .list-item .fl{line-height:31px;}
    .green{color:#cc87f9;}
    .red{color:#E02737;}
    .tabs{position:fixed;top:44px;max-width:720px;}
    .detail-foot{position:fixed;bottom:10%;width:100%;max-width:720px;z-index:123;}
    .detail-foot .btn{background-color:#7f10c7;display:block;margin:auto;padding:12px 0;width:100%;border-radius:15px;color:#fff;-webkit-box-shadow:0px 3px 8px 0px rgba(0,0,0,.2);-moz-box-shadow:0px 3px 8px 0px rgba(0,0,0,.2);box-shadow:0px 3px 8px 0px rgba(0,0,0,.2);text-align:center;}
    .modal-title{font-size:18px;text-align:center;}
    .modal-info{color:#999;text-align:center;margin-top:24px;}
    .modal-pic{text-align:center;font-size:30px;font-weight:bold;margin-bottom:12px;}
    .input-item{margin-bottom:15px;}
    .input-box{position:relative;}
    .input-box input{padding:12px 0;display:block;width:100%;background-color:#0D1414;padding-left:12px;color:#fff;}
</style>

    <script src="/Public/home/wap/js/vue.min.js"></script>
   <script src="/Public/home/wap/js/jquery.min.js"></script> 
    <script src="/Public/home/wap/js/core.js"></script>
</head>
<body>
    <div id="app">
		
<div class="fish-head">
    <a href="javascript:window.history.back();" class="head-back"><span>返回</span></a>
    <h3 class="head-tit"><span>抢购记录</span></h3>
</div>
<div class="fish-main">
    <div style="height:44px;"></div>
    <ul class="tabs">
        <li class="tab"><a @click="typeFun(1)" href="javascript:" onClick="typeFun(1)">待完成</a></li>
        <li class="tab"><a @click="typeFun(2)" href="javascript:" onClick="typeFun(2)">已完成</a></li>
        <li class="tab"><a @click="typeFun(3)" href="javascript:" onClick="typeFun(3)">取消/申诉</a></li>
    </ul>
    <div id="test1">
        <ul class="ado-list">
            <?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list1.length>0" v-for="vo in list1" @click="toDetail(vo.fid)">
                    <div class="list-top clearfix">
                        <div class="fl">编号：<span><?php echo ($vo[record_no]); ?></span></div>
                        <div class="fr"><span class="green">待完成</span></div>
                    </div>
                    <div class="list-box">
                        <h3 class="text-ellipsis">
    						<?php echo ($vo[title]); ?>						
    						&nbsp;&nbsp;&nbsp;
    					</h3>
    					</h3>
                        <div class="list-item">价值：<span><?php echo ($vo[record_price]); ?></span></div>
                        <div class="list-item">智能合约收益：<span><?php echo ($vo[profit_day]); ?>天/<?php echo ($vo[profit_value]); ?>%</span></div>
                        <div class="list-item">转让方：<span><?php echo ($vo[out_username]); ?></span></div>
                        <div class="list-item clearfix">
                            <?php if($vo['record_status'] == 6): ?><div class="fl">付款到期时间：<span><?php echo (date("Y-m-d H:i:s",$vo['fukuantime'])); ?></span></div><?php endif; ?>
                            <div class="fr">
                                <?php if($vo['record_status'] == 6): ?><a href="<?php echo U('turntable/recharge',array('id'=>$vo['record_id']));?>" class="btn" onclick="modal1">去付款</a>
                                 <?php elseif($vo['record_status'] == 7): ?>
                                    <a href="javascript:;" class="btn" style="background:#999999;color:0D1414;">待对方确认</a>
                                <?php elseif($vo['record_status'] == 8): ?>
                                    <a href="javascript:;" class="btn" style="background:#999999;color:0D1414;">转让方已申诉</a><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="dialog-bottom">已经加载全部数据</div>
    </div>
	
    <div id="test2" style="display: none;">
        <ul class="ado-list">
            <?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list2.length>0"  @click="toDetail(vo.fid)">
                    <div class="list-top clearfix">
                        <div class="fl">编号：<span><?php echo ($vo[record_no]); ?></span></div>
                        <div class="fr"><span class="green">已完成</span></div>
                    </div>
                    <div class="list-box">
                        <h3 class="text-ellipsis">
    						<?php echo ($vo[title]); ?>
    						&nbsp;&nbsp;&nbsp;
    					</h3>
                        <div class="list-item">区块金额：<span><?php echo ($vo[record_price]); ?></span></div>
                        <div class="list-item">智能合约收益：<span><?php echo ($vo[profit_day]); ?>天/<?php echo ($vo[profit_value]); ?>%</span></div>
                        <div class="list-item">转让方：<span><?php echo ($vo[out_username]); ?></span></div>
                        <div class="list-item clearfix">
                            <div class="fl">冻结完成时间：<span><?php echo (date("Y-m-d H:i:s",$vo['dongjirtime'])); ?></span></div>
                            <div class="fr">
                                 <a href="javascript:;" class="btn" @click.stop="cancel(vo.fid)">已完成</a>
                            </div>
                        </div>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="dialog-bottom">已经加载全部数据</div>
    </div>
    <div id="test3" style="display: none;">
        <ul class="ado-list">
            <?php if(is_array($list3)): $i = 0; $__LIST__ = $list3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list3.length>0"  @click="toDetail(vo.fid)">
                <div class="list-top clearfix">
                    <div class="fl">编号：<span><?php echo ($vo[record_no]); ?></span></div>
                    <div class="fr"><span class="green">投诉订单</span></div>
                </div>
                <div class="list-box">
                    <h3 class="text-ellipsis">
						<?php echo ($vo[title]); ?>
						&nbsp;&nbsp;&nbsp;
					</h3>
                    <div class="list-item">区块金额：<span><?php echo ($vo[record_price]); ?></span></div>
                    <div class="list-item">智能合约收益：<span><?php echo ($vo[profit_day]); ?>天/<?php echo ($vo[profit_value]); ?>%</span></div>
                    <div class="list-item">转让方：<span><?php echo ($vo[out_username]); ?></span></div>
                    <div class="list-item clearfix">
                        <div class="fl">付款时间：<span><?php echo (date("Y-m-d H:i:s",$vo['getmoney_time'])); ?></span></div>
                       <div class="fr">
							<!-- <a href="javascript:;" class="btn">投诉</a>
                            <a href="javascript:;" class="btn" style="background:#999999;color:0D1414;" @click.stop="cancel(vo.fid)">取消</a> -->
                   </div>
                    </div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="dialog-bottom">已经加载全部数据</div>
    </div>
</div>
<!-- 支付 -->
<div id="modal1" class="modal bottom-sheet" style="border-radius:12px 12px 0 0;background-color:#182121;max-height:70%;">
    <div style="padding:15px">
        <div class="modal-title">确认支付</div>
        <div class="modal-content">
            <div class="modal-info">支付金额</div>
            <div class="modal-pic" v-text="worth">0.00</div>
            <div class="clearfix" style="padding:12px 0;">
                <div class="col-4">上传交易凭证</div>
                <div class="col-8" style="position:relative;">
                    <input type="file" accept="image/jpeg,image/jpg,image/png" id="upload" class="set-file" @change="upload()" style="position:absolute;opacity:0;top:0;left:0;width:100%;height:100%;max-height:120px">
                    <img :src="picture/34c893b2ca7347c6920209db89d0167a.gif" id="path" alt="" class="pic-img" style="display:blcok;width:100%;">
                    <span v-if="!path" style="color:#999;">请选择图片<i class="icon-right"></i></span>
                </div>
            </div>
            <div class="input-item clearfix">
                <div class="input-label col-4"><label for="">交易密码</label></div>
                <div class="input-box col-8">
                    <input type="password" placeholder="请输入交易密码">
                </div>
            </div>
            <div class="detail-foot" style="position:relative;max-width:100%;">
                <a href="javascript:;" class="btn" @click="send()">确认</a>
            </div>
        </div>
    </div>
</div>

    </div>
    <!-- js -->
<script src="/Public/home/wap/js/jquery1.11.1.min.js"></script>
<script>
function typeFun(id){
    if(id==1){
        $('#test1').css('display','inline');
        $('#test2').css('display','none');
        $('#test3').css('display','none');
    }else if(id==2){
        $('#test1').css('display','none');
        $('#test2').css('display','inline');
        $('#test3').css('display','none');
    }else if(id==3){
        $('#test1').css('display','none');
        $('#test3').css('display','inline');
        $('#test2').css('display','none');
    }
}
</script>


</body>
</html>