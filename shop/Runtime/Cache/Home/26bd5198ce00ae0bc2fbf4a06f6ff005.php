<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>转让记录</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<link href="/Public/home/wap/css/stylexin.css" rel="stylesheet" />

		<style>
			.ado-list li {
				margin-top: 12px;
				color: #ccc
			}

			.ado-list li .list-top {
				padding: 12px;
			}

			.ado-list li .list-box {
				padding: 12px;
				border-bottom: 1px solid #a2a2a2;
			}

			.ado-list li .list-box h3 {
				font-size: 16px;
				color: #fff;
				margin-bottom: 5px;
			}

			.ado-list li .list-box .list-item span {
				margin-left: 5px;
			}

			.ado-list li .list-box .list-item .btn {
				display: inline-block;
				background: #681fde;
				color: #fff;
				padding: 5px 20px;
				border-radius: 5px;
				margin-top: -5px
			}

			.ado-list li .list-box .list-item .fl {
				line-height: 31px;
			}

			.green {
				color: #bb94fb;
			}

			.red {
				color: #E02737;
			}

			.tabs {
				position: fixed;
				top: 44px;
				max-width: 720px;
			}
		</style>

		<script src="/Public/home/wap/js/vue.min.js"></script>
		<script src="/Public/home/wap/js/jquery.min.js"></script>
		<script src="/Public/home/wap/js/core.js"></script>
	</head>
	<body>
		<div id="app">

			<div class="fish-head">
				<a href="javascript:;" onclick="history.go(-1)" class="head-back"><span>返回</span></a>
				<h3 class="head-tit"><span>转让记录</span></h3>
			</div>
			<div class="fish-main">
				<div style="height:44px;"></div>
				<ul class="tabs">
					<li class="tab"><a @click="typeFun(4)" href="#test1">待转让</a></li>
					<li class="tab"><a @click="typeFun(1)" href="#test2">转让中</a></li>
					<li class="tab"><a @click="typeFun(2)" href="#test3">已完成</a></li>
					<li class="tab"><a @click="typeFun(3)" href="#test4">取消/申诉</a></li>
				</ul>
				<div id="test1">
					<ul class="ado-list">
						<?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list1.length>0"  @click="toDetail(vo.record_id)">
							<div class="list-top clearfix">
								<div class="fl">编号：<span><?php echo ($vo["record_no"]); ?></span></div>
								<div class="fr"><span class="green">待转让</span></div>
							</div>
							<div class="list-box">
								<!-- <h3 class="text-ellipsis">
									<div class="fl">
										<?php echo ($vo["title"]); ?>
										&nbsp;&nbsp;&nbsp;
									</div>
								</h3> -->
								<div class="list-item">价值：<span><?php echo ($vo["record_price"]); ?></span></div>
								<div class="list-item">智能合约收益：<span>未选择</span></div>
								<div class="list-item">收藏方：<span>未选择</span></div>
								<div class="list-item">出售时间：<span class="red"><?php echo (date("Y-m-d H:i:s",$vo["generate_time"])); ?></span></div>

								<div class="list-item clearfix">
									<div class="fr">
									</div>
								</div>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div class="dialog-bottom"></div>
				</div>
				<div id="test2">
					<ul class="ado-list">
						<?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list2.length>0"  @click="toDetail(vo.fid)">
								<div class="list-top clearfix">
									<div class="fl">编号：<span><?php echo ($vo[record_no]); ?></span></div>
									<div class="fr"><span class="green">转让中</span></div>
								</div>
								<div class="list-box">
									<h3 class="text-ellipsis">
										<?php echo ($vo["title"]); ?>
										&nbsp;&nbsp;&nbsp;
									</h3>
									<div class="list-item">价值：<span><?php echo ($vo["record_price"]); ?></span></div>
									<div class="list-item">智能合约收益：<span><?php echo ($vo["profit_day"]); ?>天/<?php echo ($vo["profit_value"]); ?>%</span></div>
									<div class="list-item" v-if="vo.user_name">收藏方：<span><?php echo ($vo[in_username]); ?></span></div>
									<div class="list-item clearfix">
										<?php if($vo['record_status']==7): ?><div class="fl">确认到款到期时间：<span class="red" v-text="vo.over_time"><?php echo (date("Y-m-d H:i:s",$vo[getmoney_time])); ?></span></div>
										 <?php else: endif; ?>
										<div class="fr">
											<?php if($vo[record_status] == 6): ?><a href="javascript:;" class="btn" style="background:#999999;color:0D1414;">待对方打款</a>
											<?php elseif($vo[record_status] == 7): ?>
											<a href="<?php echo U('turntable/recharge',array('id'=>$vo['record_id']));?>" class="btn">确认收款</a><?php endif; ?>
										</div>
									</div>
								</div>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div class="dialog-bottom"></div>
				</div>
				<div id="test3">
					<ul class="ado-list">
						<?php if(is_array($list3)): $i = 0; $__LIST__ = $list3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list3.length>0" @click="toDetail(vo.fid)">
								<div class="list-top clearfix">
									<div class="fl">编号：<span><?php echo ($vo[record_no]); ?></span></div>
									<div class="fr"><span class="green">交易完成</span></div>
								</div>
								<div class="list-box">
									<h3 class="text-ellipsis">
										<?php echo ($vo["title"]); ?>
										&nbsp;&nbsp;&nbsp;
									</h3>
									<div class="list-item">价值：<span><?php echo ($vo["record_price"]); ?></span></div>

									<div class="list-item">智能合约收益：<span><?php echo ($vo["profit_day"]); ?>天/<?php echo ($vo["profit_value"]); ?>%</span></div>
									<div class="list-item" v-if="vo.user_name">收藏方：<span><?php echo ($vo[in_username]); ?></span></div>
									<div class="list-item clearfix">
										<div class="fl">完成时间：<span class="red"><?php echo (date("Y-m-d H:i:s",$vo[complete_time])); ?></span></div>
										<div class="fr">
											<a href="javascript:;" class="btn">已完成</a>
										</div>
									</div>
								</div>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div class="dialog-bottom"></div>
				</div>
				<div id="test4">
					<ul class="ado-list">
						<?php if(is_array($list4)): $i = 0; $__LIST__ = $list4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li v-if="list4.length>0" @click="toDetail(vo.fid)">
							<div class="list-top clearfix">
								<div class="fl">编号：<span><?php echo ($vo[record_no]); ?></span></div>
								<div class="fr"><span class="green">投诉订单</span></div>
							</div>
							<div class="list-box">
								<h3 class="text-ellipsis">
										<?php echo ($vo["title"]); ?>
										&nbsp;&nbsp;&nbsp;
									</h3>
								<div class="list-item">价值：<span><?php echo ($vo["record_price"]); ?></span></div>
								<div class="list-item">智能合约收益：<span><?php echo ($vo["profit_day"]); ?>天/<?php echo ($vo["profit_value"]); ?>%</span></div>
								<div class="list-item" v-if="vo.user_name">收藏方：<span><?php echo ($vo[in_username]); ?></span></div>
								<div class="list-item clearfix">
									<div class="fl">付款时间：<span class="red"><?php echo (date("Y-m-d H:i:s",$vo[getmoney_time])); ?></span></div>
									<div class="fr">
										<!-- <a href="javascript:;" class="btn" @click.stop="cancel(vo.fid)">取消</a> -->
										<!-- <a href="javascript:;" class="btn" style="background:#999999;color:0D1414;" @click.stop="cancel(vo.fid)">取消</a> -->
									</div>
								</div>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div class="dialog-bottom"></div>
				</div>
			</div>

		</div>
		<!-- js -->

		<script>
			var app = new Vue({
				el: 'app',
				data: {
					type: 4,
					list1: [],
					page1: 0,
					status1: true,
					list2: [],
					page2: 0,
					status2: true,
					list3: [],
					page3: 0,
					status3: true,
					list4: [],
					page4: 0,
					status4: true,
				},
				computed: {

				},
				methods: {
					strchange: function(time) {
						var date = new Date(time);
						return this.formatDate(date, 'yyyy-MM-dd hh:mm');
					},
			
					formatDate: function(date,fmt) {
						if (/(y+)/.test(fmt)) {
							fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length));
						}
						let o = {
							'M+': date.getMonth() + 1,
							'd+': date.getDate(),
							'h+': date.getHours(),
							'm+': date.getMinutes(),
							's+': date.getSeconds()
						};
						for (let k in o) {
							if (new RegExp(`(${k})`).test(fmt)) {
								let str = o[k] + '';
								fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? str : this.padLeftZero(str));
							}
						}
						return fmt;
					},
					
					padLeftZero: function(str) {
						return ('00' + str).substr(str.length);
					},
					
					
					cancel: function(id) {
						var self = this;
						core.confirm('确认取消申诉吗啊？', '提示', function() {
							core.load("/index/my/cancel_appeal.html", {
								fid: id
							}, function(res) {
								console.log(res);
								if (res.code == 0) {
									self.list3 = [];
									self.page3 = 0;
									self.status3 = true;
									self.list4 = [];
									self.page4 = 0;
									self.status4 = true;
									self.loadList();
									setTimeout(function() {

									}, 300);
								}
								core.toast(res.msg);
							});
						})
					},
					countDown: function(times, that) {
						var self = this;
						var timer = null;
						if (times > 0) {
							timer = setInterval(function() {
								var day = 0,
									hour = 0,
									minute = 0,
									second = 0; //时间默认值
								if (times > 0) {
									day = Math.floor(times / (60 * 60 * 24));
									hour = Math.floor(times / (60 * 60)) - (day * 24);
									minute = Math.floor(times / 60) - (day * 24 * 60) - (hour * 60);
									second = Math.floor(times) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
								}
								if (day <= 9) day = '0' + day;
								if (hour <= 9) hour = '0' + hour;
								if (minute <= 9) minute = '0' + minute;
								if (second <= 9) second = '0' + second;
								//
								that.text(day + "天" + hour + "小时" + minute + "分钟" + second + "秒");
								times--;
							}, 1000);
						} else {
							clearInterval(timer);
							that.text('已过期');
						}
					},
					toDetail: function(id) {
						id && (location.href = "/home/member/detail.html?type=2&id=" + id);
					},
					typeFun: function(id) {
						if (this.type == id) return;
						this.type = id;
						if (this.type == 4) {
							if (this.page1 != 0) return;
						} else if (this.type == 1) {
							if (this.page2 != 0) return;
						} else if (this.type == 2) {
							if (this.page3 != 0) return;
						} else if (this.type == 3) {
							if (this.page4 != 0) return;
						}

						this.loadList();
					},
					loadList: function() {
						var self = this;
						var page = '';

						if (self.type == 4) {
							if (!self.status1) return;
							page = self.page1;
							self.page1 = ++self.page1;
						} else if (self.type == 1) {
							if (!self.status2) return;
							page = self.page2;
							self.page2 = ++self.page2;
						} else if (self.type == 2) {
							if (!self.status3) return;
							page = self.page3;
							self.page3 = ++self.page3;
						} else if (self.type == 3) {
							if (!self.status4) return;
							page = self.page4;
							self.page4 = ++self.page4;
						}
						var data = {
							type: (self.type - 1),
							limit: 12,
							page: page,
						};

						core.load("<?php echo U('Index/trans');?>", data, function(res) {
							console.log(res);
							if (res.code == '0') {
								if (self.type == 4) {
									if (res.info.length > 0) self.list1 = self.list1.concat(res.info);
									if (!res.info || (res.info.length < data.limit)) {
										self.status1 = false;
										$('.dialog-bottom').eq(0).html('已经加载全部数据');
									} else {
										$('.dialog-bottom').eq(0).html('正在加载...');
									}
								} else if (self.type == 1) {
									if (res.info.length > 0) {
										self.list2 = self.list2.concat(res.info);
										setTimeout(function() {
											console.log(0);
											$('.ado-list').eq(1).children('li').each(function(index, el) {
												var that = $(this).find('.timer');
												if (!that.text()) {
													self.countDown(that.data('time'), that);
												}
											});
										});
									}
									if (!res.info || (res.info.length < data.limit)) {
										self.status2 = false;
										$('.dialog-bottom').eq(1).html('已经加载全部数据');
									} else {
										$('.dialog-bottom').eq(1).html('正在加载...');
									}
								} else if (self.type == 2) {
									if (res.info.length > 0) self.list3 = self.list3.concat(res.info);
									if (!res.info || (res.info.length < data.limit)) {
										self.status3 = false;
										$('.dialog-bottom').eq(2).html('已经加载全部数据');
									} else {
										$('.dialog-bottom').eq(2).html('正在加载...');
									}
								} else if (self.type == 3) {
									if (res.info.length > 0) self.list4 = self.list4.concat(res.info);
									if (!res.info || (res.info.length < data.limit)) {
										self.status4 = false;
										$('.dialog-bottom').eq(3).html('已经加载全部数据');
									} else {
										$('.dialog-bottom').eq(3).html('正在加载...');
									}
								}
							} else {
								core.toast(res.msg);
							}
						})
					},
				},
				mounted: function() {
					$('ul.tabs').tabs();
					var self = this;
					self.loadList()
					// 下拉加载
					$(window).off("scroll").on("scroll", function(e) {
						var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop()) + 150;
						if (($(document).height() <= totalheight)) {
							self.loadList()
						}
					});
				}
			});
		</script>

	</body>
</html>